<?php

namespace App\Http\Controllers\Api\Academic;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SchoolClassController extends Controller
{
/**
     * Fetch all school classes sorted by manual display order priority.
     */
    public function index()
    {
        Gate::authorize('classes_sections.view');

        try {
            // Retrieve classes and sort sequentially based on sort_order
            $allClasses = SchoolClass::orderBy('sort_order', 'asc')->get();
            $activeClasses = SchoolClass::where('status', true)->orderBy('sort_order', 'asc')->get();

            return response()->json([
                'status' => true,
                'data' => $activeClasses,
                'all_data' => $allClasses
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created school class.
     */
    public function store(Request $request)
    {
        Gate::authorize('classes_sections.create');

        $request->validate([
            'name' => 'required|string|max:100|unique:school_classes,name',
            'sort_order' => 'required|integer|min:0',
            'status' => 'nullable|boolean'
        ]);

        try {
            $class = SchoolClass::create([
                'name' => trim($request->name),
                'sort_order' => $request->integer('sort_order', 0),
                'status' => $request->boolean('status', true)
            ]);

            return response()->json([
                'status' => true,
                'message' => 'School Class created successfully.',
                'data' => $class
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get specific class details.
     */
    public function show($id)
    {
        Gate::authorize('classes_sections.view');

        try {
            $class = SchoolClass::findOrFail($id);

            return response()->json([
                'status' => true,
                'data' => $class
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'School Class not found.'
            ], 404);
        }
    }

    /**
     * Update specified school class details.
     */
    public function update(Request $request, $id)
    {
        Gate::authorize('classes_sections.edit');

        $request->validate([
            'name' => 'required|string|max:100|unique:school_classes,name,' . $id,
            'sort_order' => 'required|integer|min:0',
            'status' => 'nullable|boolean'
        ]);

        try {
            $class = SchoolClass::findOrFail($id);

            $class->update([
                'name' => trim($request->name),
                'sort_order' => $request->integer('sort_order', 0),
                'status' => $request->boolean('status', $class->status)
            ]);

            return response()->json([
                'status' => true,
                'message' => 'School Class updated successfully.'
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete specified class from DB workspace.
     */
    public function destroy($id)
    {
        Gate::authorize('classes_sections.delete');

        try {
            $class = SchoolClass::findOrFail($id);
            $class->delete();

            return response()->json([
                'status' => true,
                'message' => 'School Class deleted successfully.'
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
