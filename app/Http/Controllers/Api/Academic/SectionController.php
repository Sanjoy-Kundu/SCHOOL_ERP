<?php

namespace App\Http\Controllers\Api\Academic;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SectionController extends Controller
{
/**
     * Fetch all master sections sorted by display order priority.
     */
    public function index()
    {
        Gate::authorize('classes_sections.view');

        try {
            // Retrieve sections and sort sequentially based on sort_order column
            $allSections = Section::orderBy('sort_order', 'asc')->get();
            $activeSections = Section::where('status', true)->orderBy('sort_order', 'asc')->get();

            return response()->json([
                'status' => true,
                'data' => $activeSections,
                'all_data' => $allSections
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store new master section.
     */
    public function store(Request $request)
    {
        Gate::authorize('classes_sections.create');

        $request->validate([
            // Verified: Using unique check targeting 'sections' table correctly
            'name' => 'required|string|max:100|unique:sections,name',
            'sort_order' => 'required|integer|min:0',
            'status' => 'nullable|boolean'
        ]);

        try {
            $section = Section::create([
                'name' => trim($request->name),
                'sort_order' => $request->integer('sort_order', 0),
                'status' => $request->boolean('status', true)
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Section created successfully.',
                'data' => $section
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get specific section details.
     */
    public function show($id)
    {
        Gate::authorize('classes_sections.view');

        try {
            $section = Section::findOrFail($id);

            return response()->json([
                'status' => true,
                'data' => $section
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Section not found.'
            ], 404);
        }
    }

    /**
     * Update specified section details.
     */
    public function update(Request $request, $id)
    {
        Gate::authorize('classes_sections.edit');

        $request->validate([
            // Verified: Using unique check targeting 'sections' table correctly and ignoring current ID
            'name' => 'required|string|max:100|unique:sections,name,' . $id,
            'sort_order' => 'required|integer|min:0',
            'status' => 'nullable|boolean'
        ]);

        try {
            $section = Section::findOrFail($id);

            $section->update([
                'name' => trim($request->name),
                'sort_order' => $request->integer('sort_order', 0),
                'status' => $request->boolean('status', $section->status)
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Section updated successfully.'
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete specified section from DB workspace.
     */
    public function destroy($id)
    {
        Gate::authorize('classes_sections.delete');

        try {
            $section = Section::findOrFail($id);
            $section->delete();

            return response()->json([
                'status' => true,
                'message' => 'Section deleted successfully.'
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
