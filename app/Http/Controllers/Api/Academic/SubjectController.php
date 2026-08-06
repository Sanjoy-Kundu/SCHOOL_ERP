<?php

namespace App\Http\Controllers\Api\Academic;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SubjectController extends Controller
{
/**
     * Fetch all master subjects ordered alphabetically.
     */
    public function index()
    {
        Gate::authorize('subjects_papers.view');

        try {
            $subjects = Subject::orderBy('name', 'asc')->get();

            return response()->json([
                'status' => true,
                'all_data' => $subjects
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created master subject.
     */
    public function store(Request $request)
    {
        Gate::authorize('subjects_papers.create');

        $request->validate([
            'name' => 'required|string|max:150|unique:subjects,name'
        ]);

        try {
            $subject = Subject::create([
                'name' => trim($request->name)
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Subject created successfully.',
                'data' => $subject
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get specific subject details.
     */
    public function show($id)
    {
        Gate::authorize('subjects_papers.view');

        try {
            $subject = Subject::findOrFail($id);

            return response()->json([
                'status' => true,
                'data' => $subject
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Subject not found.'
            ], 404);
        }
    }

    /**
     * Update specified master subject.
     */
    public function update(Request $request, $id)
    {
        Gate::authorize('subjects_papers.edit');

        $request->validate([
            'name' => 'required|string|max:150|unique:subjects,name,' . $id
        ]);

        try {
            $subject = Subject::findOrFail($id);

            $subject->update([
                'name' => trim($request->name)
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Subject updated successfully.'
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete specified subject.
     */
    public function destroy($id)
    {
        Gate::authorize('subjects_papers.delete');

        try {
            $subject = Subject::findOrFail($id);
            $subject->delete();

            return response()->json([
                'status' => true,
                'message' => 'Subject deleted successfully.'
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
