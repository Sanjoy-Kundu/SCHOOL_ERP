<?php

namespace App\Http\Controllers\Api\FeesManagement\FeeStructure;

use App\Http\Controllers\Controller;
use App\Models\AcademicSession;
use App\Models\ClassSetup;
use App\Models\FeeCategory;
use App\Models\FeeSetup;
use App\Models\Month;
use App\Models\SchoolInformation;
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
            $months = Month::where('is_active', true)->orderBy('sort_order', 'asc')->get();
            $categories = FeeCategory::where('is_active', true)->orderBy('sort_order', 'asc')->get();

            $storedSetups = FeeSetup::where('academic_session_id', $request->academic_session_id)
                ->where('class_setup_id', $request->class_setup_id)
                ->get();

            // Transform raw vertical rows into associative 2D array representation
            // We use '0' as a key placeholder for month-less (one_time) fee mappings
            $matrix = [];
            foreach ($storedSetups as $setup) {
                $mKey = $setup->month_id ?? 0;
                $matrix[$setup->fee_category_id][$mKey] = $setup->amount;
            }

            $schoolInfo = SchoolInformation::first();
            $classSetup = ClassSetup::with(['schoolClass', 'section', 'shift', 'group'])
                ->find($request->class_setup_id);

            return response()->json([
                'status' => true,
                'months' => $months,
                'categories' => $categories,
                'matrix' => $matrix,
                'school' => $schoolInfo,
                'class_setup' => $classSetup
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

            // Pre-load active categories from Database for strict validation checking
            $categories = FeeCategory::whereIn('id', array_keys($feesMatrix))->get()->keyBy('id');

            foreach ($feesMatrix as $categoryId => $monthsData) {
                if (!isset($categories[$categoryId])) {
                    throw new Exception("অবৈধ ফি ক্যাটাগরি সনাক্ত করা হয়েছে।");
                }

                $category = $categories[$categoryId];

                if ($category->type === FeeCategory::TYPE_ONE_TIME) {
                    // Yearly / One-time fee category: spans across all 12 month columns cleanly
                    // Pull amount directly from index "0"
                    $amount = $monthsData[0] ?? $monthsData[''] ?? 0.00;
                    $amountVal = ($amount !== null && $amount !== '') ? (float) $amount : 0.00;

                    $keys = [
                        'academic_session_id' => $sessionId,
                        'class_setup_id'      => $classSetupId,
                        'fee_category_id'     => $categoryId,
                        'month_id'            => null // Strictly NULL for one_time/yearly configs
                    ];

                    if ($amountVal > 0) {
                        FeeSetup::updateOrCreate($keys, [
                            'amount' => $amountVal,
                            'status' => true
                        ]);
                    } else {
                        FeeSetup::where($keys)->delete();
                    }

                } else {
                    // For monthly & custom structures
                    foreach ($monthsData as $monthId => $amount) {
                        if (empty($monthId)) {
                            continue; // Prevent storing invalid empty months
                        }

                        $amountVal = ($amount !== null && $amount !== '') ? (float) $amount : 0.00;

                        $keys = [
                            'academic_session_id' => $sessionId,
                            'class_setup_id'      => $classSetupId,
                            'fee_category_id'     => $categoryId,
                            'month_id'            => $monthId
                        ];

                        if ($amountVal > 0) {
                            FeeSetup::updateOrCreate($keys, [
                                'amount' => $amountVal,
                                'status' => true
                            ]);
                        } else {
                            FeeSetup::where($keys)->delete();
                        }
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
                'message' => $e->getMessage() ?: 'তথ্য সংরক্ষণ করা সম্ভব হয়নি।'
            ], 500);
        }
    }

    /**
     * Copy Previous Academic Session configuration structure cleanly.
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

        $sourceSessionId = $request->source_session_id;
        $targetSessionId = $request->target_session_id;
        $classSetupId = $request->class_setup_id;

        // BUG FIX: Check source existence outside the transaction to prevent uncommitted locks
        $sourceSetups = FeeSetup::where('academic_session_id', $sourceSessionId)
            ->where('class_setup_id', $classSetupId)
            ->get();

        if ($sourceSetups->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'নির্বাচিত উৎস শিক্ষাবর্ষে কোনো ফি কাঠামো পাওয়া যায়নি।'
            ], 422);
        }

        try {
            DB::beginTransaction();

            // Clear old existing target setups to avoid duplicate overlaps
            FeeSetup::where('academic_session_id', $targetSessionId)
                ->where('class_setup_id', $classSetupId)
                ->delete();

            foreach ($sourceSetups as $setup) {
                FeeSetup::create([
                    'academic_session_id' => $targetSessionId,
                    'class_setup_id'      => $classSetupId,
                    'fee_category_id'     => $setup->fee_category_id,
                    'month_id'            => $setup->month_id, // NULL copies safely
                    'amount'              => $setup->amount,
                    'status'              => $setup->status
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
