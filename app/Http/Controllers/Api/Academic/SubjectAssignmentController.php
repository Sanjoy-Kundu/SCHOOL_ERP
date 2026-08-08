<?php

namespace App\Http\Controllers\Api\Academic;

use App\Http\Controllers\Controller;
use App\Models\ClassSetup;
use App\Models\SubjectAssignment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SubjectAssignmentController extends Controller
{
/**
     * Fetch all subject assignments with active relationship trees.
     */
    public function index()
    {
        Gate::authorize('subject_assignments.view');

        try {
            // Load setups, master subjects, and checked papers with custom collection sorting
            $assignments = SubjectAssignment::with([
                'classSetup.class',
                'classSetup.section',
                'classSetup.shift',
                'subject',
                'group',
                'paper'
            ])->get()->sortBy(function ($assignment) {
                return [
                    $assignment->classSetup?->class?->sort_order ?? 0,
                    $assignment->classSetup?->section?->sort_order ?? 0,
                    $assignment->classSetup?->shift?->sort_order ?? 0,
                    $assignment->subject?->name ?? ''
                ];
            })->values();

            return response()->json([
                'status' => true,
                'all_data' => $assignments
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store new subject assignment record.
     */
    public function store(Request $request)
    {
        Gate::authorize('subject_assignments.create');

        $request->validate([
            'class_setup_id' => 'required|exists:class_setups,id',
            'subject_id' => 'required|exists:subjects,id',
            'group_id' => 'nullable|exists:groups,id',
            'paper_id' => 'nullable|exists:papers,id',
            'code' => 'nullable|string|max:100',
            'is_fourth_subject' => 'required|boolean',
            'status' => 'nullable|boolean'
        ]);

        try {
            // Null-safe duplication check on Class Setup, Subject, Group and Paper combination 
            $exists = SubjectAssignment::where('class_setup_id', $request->class_setup_id)
                ->where('subject_id', $request->subject_id)
                ->where(function ($q) use ($request) {
                    $request->group_id ? $q->where('group_id', $request->group_id) : $q->whereNull('group_id');
                })
                ->where(function ($q) use ($request) {
                    $request->paper_id ? $q->where('paper_id', $request->paper_id) : $q->whereNull('paper_id');
                })
                ->exists();

            if ($exists) {
                return response()->json([
                    'status' => false,
                    'message' => 'এই শ্রেণী বিন্যাসের অধীনে এই বিষয় ও পত্রের কম্বিনেশনটি ইতিমধ্যে বিদ্যমান।'
                ], 422);
            }

            $assignment = SubjectAssignment::create([
                'class_setup_id' => $request->class_setup_id,
                'subject_id' => $request->subject_id,
                'group_id' => $request->group_id ?? null,
                'paper_id' => $request->paper_id ?? null,
                'code' => !empty($request->code) ? trim(strtoupper($request->code)) : null,
                'is_fourth_subject' => $request->boolean('is_fourth_subject', false),
                'status' => $request->boolean('status', true)
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Subject assigned successfully.',
                'data' => $assignment->load(['classSetup', 'subject', 'group', 'paper'])
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get specific subject assignment detail.
     */
    public function show($id)
    {
        Gate::authorize('subject_assignments.view');

        try {
            $assignment = SubjectAssignment::findOrFail($id);

            return response()->json([
                'status' => true,
                'data' => $assignment
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Assignment not found.'
            ], 404);
        }
    }

    /**
     * Update specified subject assignment details.
     */
    public function update(Request $request, $id)
    {
        Gate::authorize('subject_assignments.edit');

        $request->validate([
            'class_setup_id' => 'required|exists:class_setups,id',
            'subject_id' => 'required|exists:subjects,id',
            'group_id' => 'nullable|exists:groups,id',
            'paper_id' => 'nullable|exists:papers,id',
            'code' => 'nullable|string|max:100',
            'is_fourth_subject' => 'required|boolean',
            'status' => 'nullable|boolean'
        ]);

        try {
            $assignment = SubjectAssignment::findOrFail($id);

            // Prevent duplication on update ignoring current record ID 
            $exists = SubjectAssignment::where('class_setup_id', $request->class_setup_id)
                ->where('subject_id', $request->subject_id)
                ->where(function ($q) use ($request) {
                    $request->group_id ? $q->where('group_id', $request->group_id) : $q->whereNull('group_id');
                })
                ->where(function ($q) use ($request) {
                    $request->paper_id ? $q->where('paper_id', $request->paper_id) : $q->whereNull('paper_id');
                })
                ->where('id', '!=', $id)
                ->exists();

            if ($exists) {
                return response()->json([
                    'status' => false,
                    'message' => 'এই শ্রেণী বিন্যাসের অধীনে এই বিষয় ও পত্রের কম্বিনেশনটি ইতিমধ্যে বিদ্যমান।'
                ], 422);
            }

            $assignment->update([
                'class_setup_id' => $request->class_setup_id,
                'subject_id' => $request->subject_id,
                'group_id' => $request->group_id ?? null,
                'paper_id' => $request->paper_id ?? null,
                'code' => !empty($request->code) ? trim(strtoupper($request->code)) : null,
                'is_fourth_subject' => $request->boolean('is_fourth_subject', false),
                'status' => $request->boolean('status', $assignment->status)
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Subject assignment updated successfully.'
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete specified subject assignment.
     */
    public function destroy($id)
    {
        Gate::authorize('subject_assignments.delete');

        try {
            $assignment = SubjectAssignment::findOrFail($id);
            $assignment->delete();

            return response()->json([
                'status' => true,
                'message' => 'Subject assignment deleted successfully.'
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }



    /**
     * Fetch unique Class Setups that have active subject assignments (Grouped Overview).
     */
    public function getOverviews()
    {
        Gate::authorize('subject_assignments.view');

        try {
            // Retrieve only Class Setups that have mapped subjects with strict eager loading
            $setups = ClassSetup::with(['class', 'section', 'shift', 'group'])
                ->whereHas('subjectAssignments')
                ->get()
                ->sortBy(function ($setup) {
                    return [
                        $setup->class?->sort_order ?? 0,
                        $setup->section?->sort_order ?? 0,
                        $setup->shift?->sort_order ?? 0,
                        $setup->group?->sort_order ?? 0
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
     * Fetch all mapped subjects for a specific Class Setup in detail view.
     */
    public function getDetails($classSetupId)
    {
        Gate::authorize('subject_assignments.view');

        try {
            // Fetch the Class Setup details
            $classSetup = ClassSetup::with(['class', 'section', 'shift', 'group'])->findOrFail($classSetupId);

            // Fetch subject assignments associated with this specific Class Setup
            $assignments = SubjectAssignment::where('class_setup_id', $classSetupId)
                ->with(['subject', 'paper', 'group'])
                ->get()
                ->sortBy(function ($assignment) {
                    return [
                        $assignment->group?->sort_order ?? 0,
                        $assignment->is_fourth_subject ? 1 : 0,
                        $assignment->subject?->name ?? ''
                    ];
                })->values();

            return response()->json([
                'status' => true,
                'class_setup' => $classSetup,
                'all_data' => $assignments
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
