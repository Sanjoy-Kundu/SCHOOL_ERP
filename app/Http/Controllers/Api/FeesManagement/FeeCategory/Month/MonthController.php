<?php

namespace App\Http\Controllers\Api\FeesManagement\FeeCategory\Month;

use App\Http\Controllers\Controller;
use App\Models\Month;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MonthController extends Controller
{
   /**
     * Fetch and list all academic months ordered by sort priority.
     * Accessible at: GET /api/fees/months/lists
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $months = Month::orderBy('sort_order', 'asc')
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'status' => true,
                'all_data' => $months
            ], 200);

        } catch (Exception $e) {
            Log::error('Month Fetch Failed: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Failed to load months.'
            ], 500);
        }
    }

    /**
     * Store a newly created academic month.
     * Accessible at: POST /api/fees/months/store
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:months,name',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'required|integer|min:1'
        ], [
            'name.required' => 'মাসের নামটি অবশ্যই দিতে হবে।',
            'name.unique' => 'এই মাসের নামটি ইতিমধ্যে ব্যবহার করা হয়েছে।',
            'sort_order.required' => 'সর্ট অর্ডারটি প্রদান করা আবশ্যক।',
            'sort_order.integer' => 'সর্ট অর্ডারটি অবশ্যই একটি সংখ্যা হতে হবে।',
            'sort_order.min' => 'সর্ট অর্ডার অবশ্যই ১ বা তার বড় সংখ্যা হতে হবে।'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $month = Month::create([
                'name' => $request->name,
                'sort_order' => $request->input('sort_order', 0) ?? 0,
                'is_active' => $request->boolean('is_active', true)
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'মাসটি সফলভাবে যুক্ত করা হয়েছে।',
                'data' => $month
            ], 201);

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Month Store Failed: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'তথ্য সংরক্ষণ করা সম্ভব হয়নি।'
            ], 500);
        }
    }

    /**
     * Show specified Academic Month details.
     * Accessible at: GET /api/fees/months/details/{id}
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        try {
            $month = Month::findOrFail($id);

            return response()->json([
                'status' => true,
                'data' => $month
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'মাসের বিবরণী খুঁজে পাওয়া যায়নি।'
            ], 404);
        }
    }

    /**
     * Update specified Academic Month details with unique ignore validation.
     * Accessible at: POST /api/fees/months/update/{id}
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        try {
            $month = Month::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('months', 'name')->ignore($id)
                ],
                'is_active' => 'nullable|boolean',
                'sort_order' => 'required|integer|min:1'
            ], [
                'name.required' => 'মাসের নামটি অবশ্যই দিতে হবে।',
                'name.unique' => 'এই মাসের নামটি ইতিমধ্যে ব্যবহার করা হয়েছে।',
                'sort_order.required' => 'সর্ট অর্ডারটি প্রদান করা আবশ্যক।',
                'sort_order.integer' => 'সর্ট অর্ডারটি অবশ্যই একটি সংখ্যা হতে হবে।',
                'sort_order.min' => 'সর্ট অর্ডার অবশ্যই ১ বা তার বড় সংখ্যা হতে হবে।'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            DB::beginTransaction();

            $month->update([
                'name' => $request->name,
                'sort_order' => $request->input('sort_order', 0) ?? 0,
                'is_active' => $request->boolean('is_active', $month->is_active)
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'মাসের বিবরণী সফলভাবে হালনাগাদ করা হয়েছে।'
            ], 200);

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Month Update Failed: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'তথ্য হালনাগাদ করা সম্ভব হয়নি।'
            ], 500);
        }
    }

    /**
     * Toggle Active/Inactive status.
     * Accessible at: PATCH /api/fees/months/{id}/toggle-status
     *
     * @param int $id
     * @return JsonResponse
     */
    public function toggleStatus($id): JsonResponse
    {
        try {
            DB::beginTransaction();

            $month = Month::findOrFail($id);
            $month->is_active = !$month->is_active;
            $month->save();

            DB::commit();

            $statusText = $month->is_active ? 'সক্রিয়' : 'নিষ্ক্রিয়';

            return response()->json([
                'status' => true,
                'message' => "মাসটি সফলভাবে {$statusText} করা হয়েছে。",
                'is_active' => $month->is_active
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
     * Delete specified Academic Month securely.
     * Accessible at: DELETE /api/fees/months/delete/{id}
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        try {
            DB::beginTransaction();
            $month = Month::findOrFail($id);

            $month->delete();

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'মাসটি সফলভাবে মুছে ফেলা হয়েছে।'
            ], 200);

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Month Delete Failed: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'রেকর্ডটি মুছে ফেলা সম্ভব হয়নি।'
            ], 500);
        }
    }
}
