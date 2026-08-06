<?php

namespace App\Http\Controllers\Api\Academic;

use App\Http\Controllers\Controller;
use App\Models\Paper;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PaperController extends Controller
{
/**
     * Fetch all master papers ordered alphabetically.
     */
    public function index()
    {
        Gate::authorize('subjects_papers.view');

        try {
            $papers = Paper::orderBy('name', 'asc')->get();

            return response()->json([
                'status' => true,
                'all_data' => $papers
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created master paper.
     */
    public function store(Request $request)
    {
        Gate::authorize('subjects_papers.create');

        $request->validate([
            'name' => 'required|string|max:150|unique:papers,name'
        ]);

        try {
            $paper = Paper::create([
                'name' => trim($request->name)
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Paper created successfully.',
                'data' => $paper
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get specific paper details.
     */
    public function show($id)
    {
        Gate::authorize('subjects_papers.view');

        try {
            $paper = Paper::findOrFail($id);

            return response()->json([
                'status' => true,
                'data' => $paper
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Paper not found.'
            ], 404);
        }
    }

    /**
     * Update specified master paper.
     */
    public function update(Request $request, $id)
    {
        Gate::authorize('subjects_papers.edit');

        $request->validate([
            'name' => 'required|string|max:150|unique:papers,name,' . $id
        ]);

        try {
            $paper = Paper::findOrFail($id);

            $paper->update([
                'name' => trim($request->name)
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Paper updated successfully.'
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete specified master paper.
     */
    public function destroy($id)
    {
        Gate::authorize('subjects_papers.delete');

        try {
            $paper = Paper::findOrFail($id);
            $paper->delete();

            return response()->json([
                'status' => true,
                'message' => 'Paper deleted successfully.'
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
