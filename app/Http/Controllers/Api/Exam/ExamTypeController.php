<?php

namespace App\Http\Controllers\Api\Exam;

use App\Http\Controllers\Controller;
use App\Models\ExamType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ExamTypeController extends Controller
{
 /**
     * Fetch all active & inactive exam types sorted by priority.
     */
    public function index()
    {
        try {
            $examTypes = ExamType::orderBy('sort_order', 'asc')
                ->orderBy('id', 'asc')
                ->get();

            return response()->json([
                'status' => true,
                'all_data' => $examTypes
            ], 200);

        } catch (Exception $e) {
            Log::error('ExamType Fetch Failed: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'পরীক্ষার ধরণ তালিকা লোড করা সম্ভব হয়নি।'
            ], 500);
        }
    }

    /**
     * Store a newly created Master Exam Type in database.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:exam_types,name',
            'short_name' => 'nullable|string|max:50',
            'sort_order' => 'required|integer|min:0',
            'status' => 'nullable|boolean'
        ], [
            'name.required' => 'পরীক্ষার নাম অবশ্যই প্রদান করতে হবে।',
            'name.unique' => 'এই নামের পরীক্ষার ধরণ ইতিমধ্যে ডাটাবেজে সংরক্ষিত আছে।',
            'sort_order.required' => 'সাজানোর ক্রম অবশ্যই প্রদান করতে হবে।',
            'sort_order.integer' => 'সাজানোর ক্রম অবশ্যই একটি পূর্ণসংখ্যা হতে হবে।'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $examType = ExamType::create([
                'name' => $request->name,
                'short_name' => $request->short_name,
                'sort_order' => $request->sort_order,
                'status' => $request->boolean('status', true)
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'পরীক্ষার ধরণ সফলভাবে তৈরি করা হয়েছে।',
                'data' => $examType
            ], 201);

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('ExamType Store Failed: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'সার্ভার ত্রুটি! তথ্য সংরক্ষণ করা সম্ভব হয়নি।'
            ], 500);
        }
    }

    /**
     * Retrieve specified exam type details.
     */
    public function show($id)
    {
        try {
            $examType = ExamType::findOrFail($id);

            return response()->json([
                'status' => true,
                'data' => $examType
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'পরীক্ষার ধরণ রেকর্ডটি পাওয়া যায়নি।'
            ], 404);
        }
    }

    /**
     * Update specified master exam type.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:exam_types,name,' . $id,
            'short_name' => 'nullable|string|max:50',
            'sort_order' => 'required|integer|min:0',
            'status' => 'nullable|boolean'
        ], [
            'name.required' => 'পরীক্ষার নাম অবশ্যই প্রদান করতে হবে।',
            'name.unique' => 'এই নামের পরীক্ষার ধরণ ইতিমধ্যে ডাটাবেজে সংরক্ষিত আছে।',
            'sort_order.required' => 'সাজানোর ক্রম অবশ্যই প্রদান করতে হবে।',
            'sort_order.integer' => 'সাজানোর ক্রম অবশ্যই একটি পূর্ণসংখ্যা হতে হবে।'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $examType = ExamType::findOrFail($id);
            $examType->update([
                'name' => $request->name,
                'short_name' => $request->short_name,
                'sort_order' => $request->sort_order,
                'status' => $request->boolean('status', $examType->status)
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'পরীক্ষার ধরণ সফলভাবে হালনাগাদ করা হয়েছে।'
            ], 200);

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('ExamType Update Failed: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'সার্ভার ত্রুটি! তথ্য হালনাগাদ করা সম্ভব হয়নি।'
            ], 500);
        }
    }

    /**
     * Delete specified exam type.
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $examType = ExamType::findOrFail($id);
            $examType->delete();

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'পরীক্ষার ধরণ সফলভাবে মুছে ফেলা হয়েছে।'
            ], 200);

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('ExamType Delete Failed: ' . $e->getMessage());
            
            // Handle foreign key constraint restriction cleanly
            if (str_contains($e->getMessage(), 'a foreign key constraint fails')) {
                return response()->json([
                    'status' => false,
                    'message' => 'এই পরীক্ষার ধরণের অধীনে ইতোমধ্যে সেশনের পরীক্ষা তৈরি করা হয়েছে, তাই এটি মুছে ফেলা সম্ভব নয়।'
                ], 422);
            }

            return response()->json([
                'status' => false,
                'message' => 'সার্ভার ত্রুটি! রেকর্ডটি মুছে ফেলা সম্ভব হয়নি।'
            ], 500);
        }
    }
}
