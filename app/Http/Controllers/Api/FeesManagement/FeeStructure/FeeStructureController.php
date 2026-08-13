<?php

namespace App\Http\Controllers\Api\FeesManagement\FeeStructure;

use App\Http\Controllers\Controller;
use App\Models\AcademicSession;
use App\Models\ClassSetup;
use App\Models\FeeCategory;
use App\Models\FeeSetup;
use App\Models\Month;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class FeeStructureController extends Controller
{
/**
     * Display the dynamic Fee Structure Management dropdown list configurations.
     * Accessible at: GET /api/fees/structure/initial-data
     */
    public function index(): JsonResponse
    {
        try {
            $sessions = AcademicSession::orderBy('name', 'desc')->get();
            $classSetups = ClassSetup::with(['schoolClass', 'section', 'shift'])
                ->where('status', true)
                ->get();

            return response()->json([
                'status' => true,
                'sessions' => $sessions,
                'classSetups' => $classSetups
            ], 200);
        } catch (Exception $e) {
            Log::error('API FeeStructure Initial Data Load Failed: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'ড্রপডাউন তথ্য লোড করতে সমস্যা হয়েছে।'
            ], 500);
        }
    }

    /**
     * Fetch existing fee structure configurations as an associative pivot array.
     * Accessible at: GET /api/fees/structure/load
     */
    public function loadStructure(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'academic_session_id' => 'required|exists:academic_sessions,id',
            'class_setup_id' => 'required|exists:class_setups,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'অনুগ্রহ করে শিক্ষাবর্ষ এবং শ্রেণী বিন্যাস সঠিকভাবে নির্বাচন করুন।'
            ], 422);
        }

        try {
            // Load active months and active fee categories sorted by prioritization
            $months = Month::where('is_active', true)->orderBy('sort_order', 'asc')->get();
            $categories = FeeCategory::where('is_active', true)->orderBy('sort_order', 'asc')->get();

            // Fetch stored values from normalized table structure
            $storedSetups = FeeSetup::where('academic_session_id', $request->academic_session_id)
                ->where('class_setup_id', $request->class_setup_id)
                ->get();

            // Transform raw vertical rows into associative 2D array representation
            $matrix = [];
            foreach ($storedSetups as $setup) {
                $matrix[$setup->fee_category_id][$setup->month_id] = $setup->amount;
            }

            return response()->json([
                'status' => true,
                'months' => $months,
                'categories' => $categories,
                'matrix' => $matrix
            ], 200);

        } catch (Exception $e) {
            Log::error('API FeeStructure Fetch Failed: ' . $e->getMessage());
            return response()->json([
                'status' => false, 
                'message' => 'ম্যাট্রিক্স লোড করতে সমস্যা হয়েছে।'
            ], 500);
        }
    }

    /**
     * Store or Update Yearly Fee Matrix configurations securely inside Transaction.
     * Accessible at: POST /api/fees/structure/store
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'academic_session_id' => 'required|exists:academic_sessions,id',
            'class_setup_id' => 'required|exists:class_setups,id',
            'fees' => 'required|array', // Structure: fees[fee_category_id][month_id] = amount
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false, 
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $sessionId = $request->academic_session_id;
            $classSetupId = $request->class_setup_id;
            $feesMatrix = $request->fees;

            foreach ($feesMatrix as $categoryId => $monthsData) {
                foreach ($monthsData as $monthId => $amount) {
                    
                    // Sanitize input values cleanly
                    $amountVal = $amount !== null && $amount !== '' ? (float) $amount : 0.00;
                    
                    // Map unique key parameters
                    $keys = [
                        'academic_session_id' => $sessionId,
                        'class_setup_id' => $classSetupId,
                        'fee_category_id' => $categoryId,
                        'month_id' => $monthId ?: null
                    ];

                    if ($amountVal > 0) {
                        // Create or update stored values securely inside the database
                        FeeSetup::updateOrCreate($keys, [
                            'amount' => $amountVal,
                            'status' => true
                        ]);
                    } else {
                        // Clean up the database: delete row if the amount is set to 0 or blank
                        FeeSetup::where($keys)->delete();
                    }
                }
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'ফি কাঠামো সফলভাবে সংরক্ষণ করা হয়েছে।'
            ], 200);

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('API FeeStructure Save Failed: ' . $e->getMessage());
            return response()->json([
                'status' => false, 
                'message' => 'তথ্য সংরক্ষণ করা সম্ভব হয়নি।'
            ], 500);
        }
    }

    /**
     * Copy Previous Academic Session configuration structure cleanly.
     * Accessible at: POST /api/fees/structure/copy
     */
    public function copyStructure(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'source_session_id' => 'required|exists:academic_sessions,id',
            'target_session_id' => 'required|exists:academic_sessions,id|different:source_session_id',
            'class_setup_id' => 'required|exists:class_setups,id'
        ], [
            'target_session_id.different' => 'উৎস সেশন এবং লক্ষ্য সেশন আলাদা হতে হবে।'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false, 
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $sourceSessionId = $request->source_session_id;
            $targetSessionId = $request->target_session_id;
            $classSetupId = $request->class_setup_id;

            // Retrieve all matching configurations from the source session
            $sourceSetups = FeeSetup::where('academic_session_id', $sourceSessionId)
                ->where('class_setup_id', $classSetupId)
                ->get();

            if ($sourceSetups->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'নির্বাচিত উৎস শিক্ষাবর্ষে কোনো ফি কাঠামো পাওয়া যায়নি।'
                ], 422);
            }

            foreach ($sourceSetups as $setup) {
                // Duplicate values cleanly into the target session using updateOrCreate to prevent unique duplicate crashes
                FeeSetup::updateOrCreate([
                    'academic_session_id' => $targetSessionId,
                    'class_setup_id' => $classSetupId,
                    'fee_category_id' => $setup->fee_category_id,
                    'month_id' => $setup->month_id
                ], [
                    'amount' => $setup->amount,
                    'status' => $setup->status
                ]);
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'শিক্ষাবর্ষের ফি কাঠামো সফলভাবে কপি করা হয়েছে।'
            ], 200);

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('API FeeStructure Copy Failed: ' . $e->getMessage());
            return response()->json([
                'status' => false, 
                'message' => 'রুটিন কপি করতে সমস্যা হয়েছে।'
            ], 500);
        }
    }

}
