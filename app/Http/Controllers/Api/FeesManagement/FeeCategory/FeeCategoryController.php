<?php

namespace App\Http\Controllers\Api\FeesManagement\FeeCategory;

use App\Http\Controllers\Controller;
use App\Models\FeeCategory;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class FeeCategoryController extends Controller
{
 /**
     * Fetch and list all fee categories for the rendering view.
     */
    public function index(): JsonResponse
    {
        try {
            $categories = FeeCategory::orderBy('sort_order', 'asc')
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'status' => true,
                'all_data' => $categories
            ], 200);

        } catch (Exception $e) {
            Log::error('FeeCategory Fetch Failed: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Failed to load fee categories.'
            ], 500);
        }
    }

    /**
     * Store a newly created fee category.
     * Accessible at: POST /api/fees/categories/store
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:fee_categories,name',
            'code' => 'nullable|string|max:50|unique:fee_categories,code',
            'type' => [
                'required', 
                'string', 
                Rule::in([FeeCategory::TYPE_MONTHLY, FeeCategory::TYPE_ONE_TIME, FeeCategory::TYPE_CUSTOM])
            ],
            'description' => 'nullable|string|max:1000',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0'
        ], [
            'name.required' => 'ফি ক্যাটাগরির নামটি অবশ্যই দিতে হবে।',
            'name.unique' => 'এই ফি ক্যাটাগরির নামটি ইতিমধ্যে ব্যবহার করা হয়েছে।',
            'code.unique' => 'এই কোডটি ইতিমধ্যে ব্যবহার করা হয়েছে।',
            'type.required' => 'ফি এর ধরণ (Type) নির্বাচন করা আবশ্যক।',
            'type.in' => 'নির্বাচিত ফি এর ধরণটি সঠিক নয়।'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $category = FeeCategory::create([
                'name' => $request->name,
                'code' => $request->code,
                'type' => $request->type, // Saved securely
                'description' => $request->description,
                'sort_order' => $request->input('sort_order', 0) ?? 0,
                'is_active' => $request->boolean('is_active', true)
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'ফি ক্যাটাগরি সফলভাবে তৈরি করা হয়েছে।',
                'data' => $category
            ], 201);

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('FeeCategory Store Failed: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'তথ্য সংরক্ষণ করা সম্ভব হয়নি।'
            ], 500);
        }
    }

    /**
     * Show specified Fee Category details.
     * Accessible at: GET /api/fees/categories/details/{id}
     */
    public function show($id): JsonResponse
    {
        try {
            $category = FeeCategory::findOrFail($id);

            return response()->json([
                'status' => true,
                'data' => $category
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'ফি ক্যাটাগরি খুঁজে পাওয়া যায়নি।'
            ], 404);
        }
    }

    /**
     * Update specified Fee Category securely with unique validation bypass.
     * Accessible at: POST /api/fees/categories/update/{id}
     */
    public function update(Request $request, $id): JsonResponse
    {
        try {
            $category = FeeCategory::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('fee_categories', 'name')->ignore($id)
                ],
                'code' => [
                    'nullable',
                    'string',
                    'max:50',
                    Rule::unique('fee_categories', 'code')->ignore($id)
                ],
                'type' => [
                    'required', 
                    'string', 
                    Rule::in([FeeCategory::TYPE_MONTHLY, FeeCategory::TYPE_ONE_TIME, FeeCategory::TYPE_CUSTOM])
                ],
                'description' => 'nullable|string|max:1000',
                'is_active' => 'nullable|boolean',
                'sort_order' => 'nullable|integer|min:0'
            ], [
                'name.required' => 'ফি ক্যাটাগরির নামটি অবশ্যই দিতে হবে।',
                'name.unique' => 'এই ফি ক্যাটাগরির নামটি ইতিমধ্যে ব্যবহার করা হয়েছে।',
                'code.unique' => 'এই কোডটি ইতিমধ্যে ব্যবহার করা হয়েছে।',
                'type.required' => 'ফি এর ধরণ (Type) নির্বাচন করা আবশ্যক।',
                'type.in' => ' can only be: monthly, one_time, custom'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            DB::beginTransaction();

            $category->update([
                'name' => $request->name,
                'code' => $request->code,
                'type' => $request->type, // Updated securely
                'description' => $request->description,
                'sort_order' => $request->input('sort_order', 0) ?? 0,
                'is_active' => $request->boolean('is_active', $category->is_active)
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'ফি ক্যাটাগরি সফলভাবে হালনাগাদ করা হয়েছে।'
            ], 200);

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('FeeCategory Update Failed: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'তথ্য হালনাগাদ করা সম্ভব হয়নি।'
            ], 500);
        }
    }

    /**
     * Toggle Active/Inactive status.
     * Accessible at: PATCH /api/fees/categories/{id}/toggle-status
     */
    public function toggleStatus($id): JsonResponse
    {
        try {
            DB::beginTransaction();

            $category = FeeCategory::findOrFail($id);
            $category->is_active = !$category->is_active;
            $category->save();

            DB::commit();

            $statusText = $category->is_active ? 'সক্রিয়' : 'নিষ্ক্রিয়';

            return response()->json([
                'status' => true,
                'message' => "ফি ক্যাটাগরি সফলভাবে {$statusText} করা হয়েছে。",
                'is_active' => $category->is_active
            ], 200);

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'অবস্থা পরিবর্তন করা সম্ভব হয়নি।'
            ], 500);
        }
    }

    /**
     * Delete specified Fee Category securely.
     * Accessible at: DELETE /api/fees/categories/delete/{id}
     */
    public function destroy($id): JsonResponse
    {
        try {
            DB::beginTransaction();
            $category = FeeCategory::findOrFail($id);
            $category->delete();

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'ফি ক্যাটাগরি সফলভাবে মুছে ফেলা হয়েছে।'
            ], 200);

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('FeeCategory Delete Failed: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'রেকর্ডটি মুছে ফেলা সম্ভব হয়নি।'
            ], 500);
        }
    }
}
