<?php

namespace App\Http\Controllers\Api\Academic;

use App\Http\Controllers\Controller;
use App\Models\Group;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class GroupController extends Controller
{
 /**
     * Fetch all group master records sorted by sort_order
     */
    public function index()
    {
        Gate::authorize('shifts_groups.view');

        try {
            $allGroups = Group::orderBy('sort_order', 'asc')->get();
            $activeGroups = Group::where('status', true)->orderBy('sort_order', 'asc')->get();

            return response()->json([
                'status' => true,
                'data' => $activeGroups,
                'all_data' => $allGroups
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created group
     */
    public function store(Request $request)
    {
        Gate::authorize('shifts_groups.create');

        $request->validate([
            'name' => 'required|string|max:100|unique:groups,name',
            'sort_order' => 'required|integer|min:0',
            'status' => 'nullable|boolean'
        ]);

        try {
            $group = Group::create([
                'name' => trim($request->name),
                'sort_order' => $request->integer('sort_order', 0),
                'status' => $request->boolean('status', true)
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Academic Group created successfully.',
                'data' => $group
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get specific group details
     */
    public function show($id)
    {
        Gate::authorize('shifts_groups.view');

        try {
            $group = Group::findOrFail($id);

            return response()->json([
                'status' => true,
                'data' => $group
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Academic Group not found.'
            ], 404);
        }
    }

    /**
     * Update specified group details
     */
    public function update(Request $request, $id)
    {
        Gate::authorize('shifts_groups.edit');

        $request->validate([
            'name' => 'required|string|max:100|unique:groups,name,' . $id,
            'sort_order' => 'required|integer|min:0',
            'status' => 'nullable|boolean'
        ]);

        try {
            $group = Group::findOrFail($id);

            $group->update([
                'name' => trim($request->name),
                'sort_order' => $request->integer('sort_order', 0),
                'status' => $request->boolean('status', $group->status)
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Academic Group updated successfully.'
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete specified group from DB
     */
    public function destroy($id)
    {
        Gate::authorize('shifts_groups.delete');

        try {
            $group = Group::findOrFail($id);
            $group->delete();

            return response()->json([
                'status' => true,
                'message' => 'Academic Group deleted successfully.'
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
