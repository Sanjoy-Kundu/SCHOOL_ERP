<?php

namespace App\Http\Controllers\Api\Academic;

use App\Http\Controllers\Controller;
use App\Models\Shift;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ShiftController extends Controller
{
/**
     * Fetch all shift master records sorted by sort_order
     */
    public function index()
    {
        Gate::authorize('shifts_groups.view');

        try {
            $allShifts = Shift::orderBy('sort_order', 'asc')->get();
            $activeShifts = Shift::where('status', true)->orderBy('sort_order', 'asc')->get();

            return response()->json([
                'status' => true,
                'data' => $activeShifts,
                'all_data' => $allShifts
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created shift
     */
    public function store(Request $request)
    {
        Gate::authorize('shifts_groups.create');

        $request->validate([
            'name' => 'required|string|max:100|unique:shifts,name',
            'sort_order' => 'required|integer|min:0',
            'status' => 'nullable|boolean'
        ]);

        try {
            $shift = Shift::create([
                'name' => trim($request->name),
                'sort_order' => $request->integer('sort_order', 0),
                'status' => $request->boolean('status', true)
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Academic Shift created successfully.',
                'data' => $shift
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get specific shift details
     */
    public function show($id)
    {
        Gate::authorize('shifts_groups.view');

        try {
            $shift = Shift::findOrFail($id);

            return response()->json([
                'status' => true,
                'data' => $shift
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Academic Shift not found.'
            ], 404);
        }
    }

    /**
     * Update specified shift details
     */
    public function update(Request $request, $id)
    {
        Gate::authorize('shifts_groups.edit');

        $request->validate([
            'name' => 'required|string|max:100|unique:shifts,name,' . $id,
            'sort_order' => 'required|integer|min:0',
            'status' => 'nullable|boolean'
        ]);

        try {
            $shift = Shift::findOrFail($id);

            $shift->update([
                'name' => trim($request->name),
                'sort_order' => $request->integer('sort_order', 0),
                'status' => $request->boolean('status', $shift->status)
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Academic Shift updated successfully.'
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete specified shift from DB
     */
    public function destroy($id)
    {
        Gate::authorize('shifts_groups.delete');

        try {
            $shift = Shift::findOrFail($id);
            $shift->delete();

            return response()->json([
                'status' => true,
                'message' => 'Academic Shift deleted successfully.'
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
