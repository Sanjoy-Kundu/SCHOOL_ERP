<?php

namespace App\Http\Controllers\Api\Exam;

use App\Http\Controllers\Controller;
use App\Models\ClassSetup;
use App\Models\ExamSchedule;
use App\Models\ExamType;
use App\Models\SchoolClass;
use App\Models\SchoolInformation;
use App\Models\SubjectAssignment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ExamScheduleController extends Controller
{
    /**
     * Fetch filtered schedules with formatted relationships and school information metadata.
     */
    public function index(Request $request)
    {
        Gate::authorize('exam_schedules.view');

        try {
            // Eager load related configurations to prevent N+1 query issue [cite: 19]
            $query = ExamSchedule::with([
                'examType',
                'classSetup.schoolClass', 
                'classSetup.section',
                'classSetup.shift',
                'subjectAssignment.subject',
                'subjectAssignment.paper',
                'subjectAssignment.group'
            ]);

            // 1. Dynamic Server-side Filters [cite: 19]
            if ($request->filled('exam_type_id')) {
                $query->where('exam_type_id', $request->exam_type_id);
            }

            if ($request->filled('class_id')) {
                $query->whereHas('classSetup', function ($q) use ($request) {
                    $q->where('class_id', $request->class_id);
                });
            }

            if ($request->filled('class_setup_id')) {
                $query->where('class_setup_id', $request->class_setup_id);
            }

            // Always sort chronologically by Date and Start Time [cite: 19]
            $schedules = $query->orderBy('exam_date', 'asc')
                ->orderBy('start_time', 'asc')
                ->get();

            $formatted = $schedules->map(function ($schedule) {
                return [
                    'id' => $schedule->id,
                    'class_setup_id' => $schedule->class_setup_id,
                    'exam_type' => $schedule->examType->name ?? '—',
                    'class_name' => $schedule->classSetup?->schoolClass?->name ?? '—',
                    'section_name' => $schedule->classSetup?->section?->name ?? 'N/A',
                    'shift_name' => $schedule->classSetup?->shift?->name ?? 'N/A',
                    'group_name' => $schedule->subjectAssignment?->group?->name ?? 'Compulsory',
                    'subject_name' => $schedule->subjectAssignment?->subject?->name ?? '—',
                    'code' => $schedule->subjectAssignment?->code ?? '—',
                    'paper_name' => $schedule->subjectAssignment?->paper?->name ?? '—',
                    'exam_date' => $schedule->exam_date->format('Y-m-d'),
                    'start_time' => date('H:i', strtotime($schedule->start_time)),
                    'end_time' => date('H:i', strtotime($schedule->end_time)),
                    'room_name' => $schedule->room_name ?? '—',
                    'examiner_name' => $schedule->examiner_name ?? '—',
                    'seat_capacity' => $schedule->seat_capacity ?? '—',
                    'status' => $schedule->status
                ];
            });

            // Fetch dynamic school information master profile [cite: 19]
            $schoolInfo = SchoolInformation::first();

            return response()->json([
                'status' => true,
                'all_data' => $formatted,
                'school_information' => $schoolInfo
            ], 200);

        } catch (Exception $e) {
            Log::error('ExamSchedule Index Failed: ' . $e->getMessage());
            return response()->json(['status' => false, 'message' => 'ডাটাবেজ থেকে তথ্য রিট্রিভ করা যায়নি।'], 500);
        }
    }

    /**
     * Fetch Initial Form Dropdowns and Master Datasets.
     */
    public function getFormDependencies()
    {
        try {
            $examTypes = ExamType::where('status', true)->orderBy('sort_order')->get();
            $classes = SchoolClass::where('status', true)->orderBy('sort_order')->get();

            return response()->json([
                'status' => true,
                'exam_types' => $examTypes,
                'classes' => $classes
            ], 200);

        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => 'নির্ভরতা ডেটা লোড করা যায়নি।'], 500);
        }
    }

    /**
     * Fetch Class Setups mapped under a selected School Class.
     */
    public function getClassSetups($classId)
    {
        try {
            $classSetups = ClassSetup::with(['section', 'shift'])
                ->where('class_id', $classId)
                ->where('status', true)
                ->get();

            $formatted = $classSetups->map(function ($setup) {
                $sectionName = $setup->section?->name ?? 'N/A';
                $shiftName = $setup->shift?->name ?? 'N/A';
                return [
                    'id' => $setup->id,
                    'label' => "Section: {$sectionName} - Shift: {$shiftName}"
                ];
            });

            return response()->json([
                'status' => true,
                'class_setups' => $formatted
            ], 200);

        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => 'শ্রেণী বিন্যাস লোড করা সম্ভব হয়নি।'], 500);
        }
    }

    /**
     * Fetch Subject Assignments mapped under selected Class Setup.
     */
    public function getSubjectAssignments($classSetupId)
    {
        try {
            $assignments = SubjectAssignment::with(['subject', 'paper', 'group'])
                ->where('class_setup_id', $classSetupId)
                ->where('status', true)
                ->get();

            $formatted = $assignments->map(function ($assign) {
                $paperText = $assign->paper ? " ({$assign->paper->name})" : '';
                $groupText = $assign->group ? " [{$assign->group->name} Group]" : '';
                $fourthText = $assign->is_fourth_subject ? " [Fourth Subject]" : '';
                
                return [
                    'id' => $assign->id,
                    'label' => "{$assign->subject?->name}{$paperText}{$groupText}{$fourthText}"
                ];
            });

            return response()->json([
                'status' => true,
                'subject_assignments' => $formatted
            ], 200);

        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => 'বিষয় বিন্যাস লোড করা সম্ভব হয়নি।'], 500);
        }
    }


    /**
     * Store new Exam Schedule with Group & 4th Subject Overlap Preventions.
     */
    public function store(Request $request)
    {
        Gate::authorize('exam_schedules.create');

        $validator = Validator::make($request->all(), [
            'exam_type_id' => 'required|exists:exam_types,id',
            'class_setup_id' => 'required|exists:class_setups,id',
            'subject_assignment_id' => 'required|exists:subject_assignments,id',
            'exam_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'room_name' => 'nullable|string|max:100',
            'examiner_name' => 'nullable|string|max:150',
            'seat_capacity' => 'nullable|integer|min:1',
            'instructions' => 'nullable|string',
            'status' => 'nullable|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        try {
            DB::beginTransaction();

            // 1. Verify that the subject assignment belongs to the selected class setup
            $newAssignment = SubjectAssignment::with(['subject', 'group'])
                ->where('id', $request->subject_assignment_id)
                ->where('class_setup_id', $request->class_setup_id)
                ->first();

            if (!$newAssignment) {
                return response()->json(['status' => false, 'message' => 'নির্বাচিত বিষয়টি এই শ্রেণী বিন্যাসের অন্তর্ভুক্ত নয়।'], 422);
            }

            // 2. Check for exact duplicate exam schedule entry
            $exists = ExamSchedule::where('exam_type_id', $request->exam_type_id)
                ->where('class_setup_id', $request->class_setup_id)
                ->where('subject_assignment_id', $request->subject_assignment_id)
                ->exists();

            if ($exists) {
                return response()->json(['status' => false, 'message' => 'এই বিষয়ের জন্য এই পরীক্ষা বিন্যাসটি ইতিমধ্যে তৈরি করা আছে।'], 422);
            }

            // 3. Fetch overlapping schedules for the same class setup, date, and time range
            $overlappingSchedules = ExamSchedule::where('class_setup_id', $request->class_setup_id)
                ->where('exam_date', $request->exam_date)
                ->where(function ($q) use ($request) {
                    $q->where('start_time', '<', $request->end_time)
                      ->where('end_time', '>', $request->start_time);
                })
                ->with('subjectAssignment.subject')
                ->get();

            // 4. Perform group-based and 4th subject-based smart overlap filtering
            foreach ($overlappingSchedules as $existing) {
                $existingAssignment = $existing->subjectAssignment;
                if (!$existingAssignment) continue;

                // Check 1: Check if either subject is compulsory (no group_id and not a 4th subject)
                $isNewCompulsory = is_null($newAssignment->group_id) && !$newAssignment->is_fourth_subject;
                $isExistingCompulsory = is_null($existingAssignment->group_id) && !$existingAssignment->is_fourth_subject;

                if ($isNewCompulsory || $isExistingCompulsory) {
                    return response()->json([
                        'status' => false, 
                        'message' => 'এই সময়ে একটি আবশ্যিক পরীক্ষা (' . ($isExistingCompulsory ? $existingAssignment->subject?->name : $newAssignment->subject?->name) . ') নির্ধারিত আছে। আবশ্যিক পরীক্ষার সাথে অন্য পরীক্ষা নেওয়া সম্ভব নয়।'
                    ], 422);
                }

                // Check 2: Check if both exams belong to the same group and are not 4th subjects
                if (!$newAssignment->is_fourth_subject && !$existingAssignment->is_fourth_subject) {
                    if ($newAssignment->group_id === $existingAssignment->group_id) {
                        return response()->json([
                            'status' => false, 
                            'message' => 'এই গ্রুপের জন্য একই সময়ে আরেকটি সাধারণ পরীক্ষা (' . $existingAssignment->subject?->name . ') ইতিমধ্যে নির্ধারিত আছে।'
                        ], 422);
                    }
                }

                // Check 3: Check for general elective vs 4th subject conflict within the same group
                if ($newAssignment->group_id === $existingAssignment->group_id) {
                    // Parallel scheduling is allowed if both are 4th subjects (e.g., Agri Studies 4th vs Higher Math 4th)
                    if ($newAssignment->is_fourth_subject && $existingAssignment->is_fourth_subject) {
                        continue;
                    }
                    return response()->json([
                        'status' => false, 
                        'message' => 'একই গ্রুপের শিক্ষার্থীদের জন্য সাধারণ বিষয় ও ৪র্থ বিষয়ের পরীক্ষা একই সময়ে নেওয়া সম্ভব নয়।'
                    ], 422);
                }
            }

            // 5. Room overlap check (prevents other classes from booking the same room at the same time)
            if ($request->filled('room_name')) {
                $roomOverlap = ExamSchedule::where('room_name', $request->room_name)
                    ->where('exam_date', $request->exam_date)
                    ->where('class_setup_id', '!=', $request->class_setup_id) // Exclude same class cohort as they can share rooms
                    ->where(function ($q) use ($request) {
                        $q->where('start_time', '<', $request->end_time)
                          ->where('end_time', '>', $request->start_time);
                    })
                    ->exists();

                if ($roomOverlap) {
                    return response()->json(['status' => false, 'message' => 'এই তারিখে ও সময়ে এই রুমটি অন্য একটি ক্লাসের পরীক্ষার জন্য বুক করা আছে।'], 422);
                }
            }

            // Create the new exam schedule record
            $schedule = ExamSchedule::create([
                'exam_type_id' => $request->exam_type_id,
                'class_setup_id' => $request->class_setup_id,
                'subject_assignment_id' => $request->subject_assignment_id,
                'exam_date' => $request->exam_date,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'room_name' => $request->room_name,
                'examiner_name' => $request->examiner_name,
                'seat_capacity' => $request->seat_capacity,
                'instructions' => $request->instructions,
                'status' => $request->boolean('status', true)
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'পরীক্ষার সময়সূচী সফলভাবে তৈরি হয়েছে।',
                'data' => $schedule
            ], 201);

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('ExamSchedule Store Failed: ' . $e->getMessage());
            return response()->json(['status' => false, 'message' => 'তথ্য সংরক্ষণ করা সম্ভব হয়নি।'], 500);
        }
    }

    /**
     * Show specified Exam Schedule details.
     */
    public function show($id)
    {
        Gate::authorize('exam_schedules.view');

        try {
            $schedule = ExamSchedule::with([
                'examType',
                'classSetup.schoolClass', 
                'classSetup.section',
                'classSetup.shift',
                'subjectAssignment.subject',
                'subjectAssignment.paper',
                'subjectAssignment.group'
            ])->findOrFail($id);

            $schedule->formatted_start = date('H:i', strtotime($schedule->start_time));
            $schedule->formatted_end = date('H:i', strtotime($schedule->end_time));

            return response()->json([
                'status' => true,
                'data' => $schedule
            ], 200);

        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => 'সময়সূচী খুঁজে পাওয়া যায়নি।'], 404);
        }
    }

    /**
     * Update specified Exam Schedule with Overlap Preventions.
     */
    // public function update(Request $request, $id)
    // {
    //     Gate::authorize('exam_schedules.edit');

    //     $validator = Validator::make($request->all(), [
    //         'exam_type_id' => 'required|exists:exam_types,id',
    //         'class_setup_id' => 'required|exists:class_setups,id',
    //         'subject_assignment_id' => 'required|exists:subject_assignments,id',
    //         'exam_date' => 'required|date',
    //         'start_time' => 'required|date_format:H:i',
    //         'end_time' => 'required|date_format:H:i|after:start_time',
    //         'room_name' => 'nullable|string|max:100',
    //         'examiner_name' => 'nullable|string|max:150',
    //         'seat_capacity' => 'nullable|integer|min:1',
    //         'instructions' => 'nullable|string',
    //         'status' => 'nullable|boolean'
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
    //     }

    //     try {
    //         DB::beginTransaction();

    //         $schedule = ExamSchedule::findOrFail($id);

    //         $validAssignment = SubjectAssignment::where('id', $request->subject_assignment_id)
    //             ->where('class_setup_id', $request->class_setup_id)
    //             ->exists();

    //         if (!$validAssignment) {
    //             return response()->json(['status' => false, 'message' => 'নির্বাচিত বিষয়টি এই শ্রেণী বিন্যাসের অন্তর্ভুক্ত নয়।'], 422);
    //         }

    //         $exists = ExamSchedule::where('exam_type_id', $request->exam_type_id)
    //             ->where('class_setup_id', $request->class_setup_id)
    //             ->where('subject_assignment_id', $request->subject_assignment_id)
    //             ->where('id', '!=', $id)
    //             ->exists();

    //         if ($exists) {
    //             return response()->json(['status' => false, 'message' => 'এই বিষয়ের জন্য এই পরীক্ষা বিন্যাসটি ইতিমধ্যে তৈরি করা আছে।'], 422);
    //         }

    //         $classOverlap = ExamSchedule::where('class_setup_id', $request->class_setup_id)
    //             ->where('exam_date', $request->exam_date)
    //             ->where('id', '!=', $id)
    //             ->where(function ($q) use ($request) {
    //                 $q->where('start_time', '<', $request->end_time)
    //                   ->where('end_time', '>', $request->start_time);
    //             })
    //             ->exists();

    //         if ($classOverlap) {
    //             return response()->json(['status' => false, 'message' => 'এই শ্রেণীর জন্য একই সময়ে আরেকটি পরীক্ষা ইতিমধ্যে নির্ধারিত আছে।'], 422);
    //         }

    //         if ($request->filled('room_name')) {
    //             $roomOverlap = ExamSchedule::where('room_name', $request->room_name)
    //                 ->where('exam_date', $request->exam_date)
    //                 ->where('id', '!=', $id)
    //                 ->where(function ($q) use ($request) {
    //                     $q->where('start_time', '<', $request->end_time)
    //                       ->where('end_time', '>', $request->start_time);
    //                 })
    //                 ->exists();

    //             if ($roomOverlap) {
    //                 return response()->json(['status' => false, 'message' => 'এই তারিখে ও সময়ে এই রুমটি ইতিমধ্যে অন্য একটি পরীক্ষার জন্য বুক করা আছে।'], 422);
    //             }
    //         }

    //         $schedule->update([
    //             'exam_type_id' => $request->exam_type_id,
    //             'class_setup_id' => $request->class_setup_id,
    //             'subject_assignment_id' => $request->subject_assignment_id,
    //             'exam_date' => $request->exam_date,
    //             'start_time' => $request->start_time,
    //             'end_time' => $request->end_time,
    //             'room_name' => $request->room_name,
    //             'examiner_name' => $request->examiner_name,
    //             'seat_capacity' => $request->seat_capacity,
    //             'instructions' => $request->instructions,
    //             'status' => $request->boolean('status', $schedule->status)
    //         ]);

    //         DB::commit();

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'পরীক্ষার সময়সূচী সফলভাবে হালনাগাদ করা হয়েছে।'
    //         ], 200);

    //     } catch (Exception $e) {
    //         DB::rollBack();
    //         Log::error('ExamSchedule Update Failed: ' . $e->getMessage());
    //         return response()->json(['status' => false, 'message' => 'তথ্য হালনাগাদ করা সম্ভব হয়নি।'], 500);
    //     }
    // }
    /**
     * Update specified Exam Schedule with Group & 4th Subject Overlap Preventions.
     */
    public function update(Request $request, $id)
    {
        Gate::authorize('exam_schedules.edit');

        $validator = Validator::make($request->all(), [
            'exam_type_id' => 'required|exists:exam_types,id',
            'class_setup_id' => 'required|exists:class_setups,id',
            'subject_assignment_id' => 'required|exists:subject_assignments,id',
            'exam_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'room_name' => 'nullable|string|max:100',
            'examiner_name' => 'nullable|string|max:150',
            'seat_capacity' => 'nullable|integer|min:1',
            'instructions' => 'nullable|string',
            'status' => 'nullable|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        try {
            DB::beginTransaction();

            $schedule = ExamSchedule::findOrFail($id);

            // 1. Verify that the subject assignment belongs to the selected class setup
            $newAssignment = SubjectAssignment::with(['subject', 'group'])
                ->where('id', $request->subject_assignment_id)
                ->where('class_setup_id', $request->class_setup_id)
                ->first();

            if (!$newAssignment) {
                return response()->json(['status' => false, 'message' => 'নির্বাচিত বিষয়টি এই শ্রেণী বিন্যাসের অন্তর্ভুক্ত নয়।'], 422);
            }

            // 2. Check for duplicate exam schedule entry (excluding current record)
            $exists = ExamSchedule::where('exam_type_id', $request->exam_type_id)
                ->where('class_setup_id', $request->class_setup_id)
                ->where('subject_assignment_id', $request->subject_assignment_id)
                ->where('id', '!=', $id)
                ->exists();

            if ($exists) {
                return response()->json(['status' => false, 'message' => 'এই বিষয়ের জন্য এই পরীক্ষা বিন্যাসটি ইতিমধ্যে তৈরি করা আছে।'], 422);
            }

            // 3. Fetch overlapping schedules for the same class setup, date, and time range (excluding current record)
            $overlappingSchedules = ExamSchedule::where('class_setup_id', $request->class_setup_id)
                ->where('exam_date', $request->exam_date)
                ->where('id', '!=', $id)
                ->where(function ($q) use ($request) {
                    $q->where('start_time', '<', $request->end_time)
                      ->where('end_time', '>', $request->start_time);
                })
                ->with('subjectAssignment.subject')
                ->get();

            // 4. Perform group-based and 4th subject-based smart overlap filtering
            foreach ($overlappingSchedules as $existing) {
                $existingAssignment = $existing->subjectAssignment;
                if (!$existingAssignment) continue;

                // Check 1: Check if either subject is compulsory (no group_id and not a 4th subject)
                $isNewCompulsory = is_null($newAssignment->group_id) && !$newAssignment->is_fourth_subject;
                $isExistingCompulsory = is_null($existingAssignment->group_id) && !$existingAssignment->is_fourth_subject;

                if ($isNewCompulsory || $isExistingCompulsory) {
                    return response()->json([
                        'status' => false, 
                        'message' => 'এই সময়ে একটি আবশ্যিক পরীক্ষা (' . ($isExistingCompulsory ? $existingAssignment->subject?->name : $newAssignment->subject?->name) . ') নির্ধারিত আছে।'
                    ], 422);
                }

                // Check 2: Check if both exams belong to the same group and are not 4th subjects
                if (!$newAssignment->is_fourth_subject && !$existingAssignment->is_fourth_subject) {
                    if ($newAssignment->group_id === $existingAssignment->group_id) {
                        return response()->json([
                            'status' => false, 
                            'message' => 'এই গ্রুপের জন্য একই সময়ে আরেকটি সাধারণ পরীক্ষা (' . $existingAssignment->subject?->name . ') ইতিমধ্যে নির্ধারিত আছে।'
                        ], 422);
                    }
                }

                // Check 3: Check for general elective vs 4th subject conflict within the same group
                if ($newAssignment->group_id === $existingAssignment->group_id) {
                    // Parallel scheduling is allowed if both are 4th subjects (e.g., Agri Studies 4th vs Higher Math 4th)
                    if ($newAssignment->is_fourth_subject && $existingAssignment->is_fourth_subject) {
                        continue;
                    }
                    return response()->json([
                        'status' => false, 
                        'message' => 'একই গ্রুপের শিক্ষার্থীদের জন্য সাধারণ বিষয় ও ৪র্থ বিষয়ের পরীক্ষা একই সময়ে নেওয়া সম্ভব নয়।'
                    ], 422);
                }
            }

            // 5. Room overlap check (prevents other classes from booking the same room at the same time, excluding current record)
            if ($request->filled('room_name')) {
                $roomOverlap = ExamSchedule::where('room_name', $request->room_name)
                    ->where('exam_date', $request->exam_date)
                    ->where('class_setup_id', '!=', $request->class_setup_id) // Exclude same class cohort as they can share rooms
                    ->where('id', '!=', $id)
                    ->where(function ($q) use ($request) {
                        $q->where('start_time', '<', $request->end_time)
                          ->where('end_time', '>', $request->start_time);
                    })
                    ->exists();

                if ($roomOverlap) {
                    return response()->json(['status' => false, 'message' => 'এই তারিখে ও সময়ে এই রুমটি অন্য একটি ক্লাসের পরীক্ষার জন্য বুক করা আছে।'], 422);
                }
            }

            // Update the existing exam schedule record
            $schedule->update([
                'exam_type_id' => $request->exam_type_id,
                'class_setup_id' => $request->class_setup_id,
                'subject_assignment_id' => $request->subject_assignment_id,
                'exam_date' => $request->exam_date,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'room_name' => $request->room_name,
                'examiner_name' => $request->examiner_name,
                'seat_capacity' => $request->seat_capacity,
                'instructions' => $request->instructions,
                'status' => $request->boolean('status', $schedule->status)
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'পরীক্ষার সময়সূচী সফলভাবে হালনাগাদ করা হয়েছে।'
            ], 200);

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('ExamSchedule Update Failed: ' . $e->getMessage());
            return response()->json(['status' => false, 'message' => 'তথ্য হালনাগাদ করা সম্ভব হয়নি।'], 500);
        }
    }

    /**
     * Delete specified Exam Schedule.
     */
    public function destroy($id)
    {
        Gate::authorize('exam_schedules.delete');

        try {
            DB::beginTransaction();

            $schedule = ExamSchedule::findOrFail($id);
            $schedule->delete();

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'পরীক্ষার সময়সূচী সফলভাবে মুছে ফেলা হয়েছে।'
            ], 200);

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('ExamSchedule Delete Failed: ' . $e->getMessage());
            return response()->json(['status' => false, 'message' => 'রেকর্ডটি মুছে ফেলা সম্ভব হয়নি।'], 500);
        }
    }
}
