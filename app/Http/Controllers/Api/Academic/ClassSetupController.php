<?php

namespace App\Http\Controllers\Api\Academic;

use App\Http\Controllers\Controller;
use App\Models\ClassSetup;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ClassSetupController extends Controller
{
/**
     * Fetch all class setups with related master data sorted sequentially.
     */
    public function index()
    {
        Gate::authorize('class_setups.view');

        try {
            // Retrieve with eager load and sort sequentially based on sort_order priorities (Group relation removed)
            $setups = ClassSetup::with(['class', 'section', 'shift'])->get()
                ->sortBy(function ($setup) {
                    return [
                        $setup->class?->sort_order ?? 0,
                        $setup->section?->sort_order ?? 0,
                        $setup->shift?->sort_order ?? 0
                    ];
                })->values();

            return response()->json([
                'status' => true,
                'all_data' => $setups
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created dynamic class setup.
     */
    public function store(Request $request)
    {
        Gate::authorize('class_setups.create');

        $request->validate([
            'class_id' => 'required|exists:school_classes,id',
            'section_id' => 'nullable|exists:sections,id',
            'shift_id' => 'nullable|exists:shifts,id',
            'status' => 'nullable|boolean'
        ]);

        try {
            // Duplicate prevention strategy: Explicit check handling database NULL values (Group constraint removed)
            $exists = ClassSetup::where('class_id', $request->class_id)
                ->where(function ($q) use ($request) {
                    $request->section_id ? $q->where('section_id', $request->section_id) : $q->whereNull('section_id');
                })
                ->where(function ($q) use ($request) {
                    $request->shift_id ? $q->where('shift_id', $request->shift_id) : $q->whereNull('shift_id');
                })
                ->exists();

            if ($exists) {
                return response()->json([
                    'status' => false,
                    'message' => 'শ্রেণী বিন্যাসের এই কম্বিনেশনটি ডাটাবেজে ইতিমধ্যে বিদ্যমান।'
                ], 422);
            }

            $setup = ClassSetup::create([
                'class_id' => $request->class_id,
                'section_id' => $request->section_id ?? null,
                'shift_id' => $request->shift_id ?? null,
                'status' => $request->boolean('status', true)
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Class Setup created successfully.',
                'data' => $setup
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get specific class setup details.
     */
    public function show($id)
    {
        Gate::authorize('class_setups.view');

        try {
            $setup = ClassSetup::findOrFail($id);

            return response()->json([
                'status' => true,
                'data' => $setup
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Class Setup not found.'
            ], 404);
        }
    }

    /**
     * Update specified class setup details.
     */
    public function update(Request $request, $id)
    {
        Gate::authorize('class_setups.edit');

        $request->validate([
            'class_id' => 'required|exists:school_classes,id',
            'section_id' => 'nullable|exists:sections,id',
            'shift_id' => 'nullable|exists:shifts,id',
            'status' => 'nullable|boolean'
        ]);

        try {
            $setup = ClassSetup::findOrFail($id);

            // Duplicate prevention strategy: Explicit check excluding current ID (Group constraint removed)
            $exists = ClassSetup::where('class_id', $request->class_id)
                ->where(function ($q) use ($request) {
                    $request->section_id ? $q->where('section_id', $request->section_id) : $q->whereNull('section_id');
                })
                ->where(function ($q) use ($request) {
                    $request->shift_id ? $q->where('shift_id', $request->shift_id) : $q->whereNull('shift_id');
                })
                ->where('id', '!=', $id)
                ->exists();

            if ($exists) {
                return response()->json([
                    'status' => false,
                    'message' => 'শ্রেণী বিন্যাসের এই কম্বিনেশনটি ডাটাবেজে ইতিমধ্যে বিদ্যমান।'
                ], 422);
            }

            $setup->update([
                'class_id' => $request->class_id,
                'section_id' => $request->section_id ?? null,
                'shift_id' => $request->shift_id ?? null,
                'status' => $request->boolean('status', $setup->status)
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Class Setup updated successfully.'
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete specified class setup.
     */
    public function destroy($id)
    {
        Gate::authorize('class_setups.delete');

        try {
            $setup = ClassSetup::findOrFail($id);
            $setup->delete();

            return response()->json([
                'status' => true,
                'message' => 'Class Setup deleted successfully.'
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
