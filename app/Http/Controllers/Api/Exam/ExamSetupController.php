<?php

namespace App\Http\Controllers\Api\Exam;

use App\Http\Controllers\Controller;
use App\Models\ClassSetup;
use App\Models\ExamSetup;
use App\Models\ExamType;
use App\Models\SubjectAssignment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ExamSetupController extends Controller
{
    /**
     * Fetch all setups with preloaded dynamic relationships.
     */
    public function index()
    {
        try {
            $setups = ExamSetup::with([
                'examType',
                'classSetup.schoolClass',
                'classSetup.section',
                'classSetup.shift'
            ])->get();

            // Transform each setup record to calculate count of subject assignments
            $formatted = $setups->map(function ($setup) {
                $subjectCount = SubjectAssignment::where('class_setup_id', $setup->class_setup_id)->count();
                return [
                    'id' => $setup->id,
                    'exam_type' => $setup->examType->name ?? '—',
                    'class_setup_id' => $setup->class_setup_id,
                    'class_name' => $setup->classSetup->schoolClass->name ?? '—',
                    'section_name' => $setup->classSetup->section->name ?? 'N/A',
                    'shift_name' => $setup->classSetup->shift->name ?? 'N/A',
                    'subject_count' => $subjectCount,
                    'status' => $setup->status
                ];
            });

            return response()->json([
                'status' => true,
                'all_data' => $formatted
            ], 200);

        } catch (Exception $e) {
            Log::error('ExamSetup Index Failed: ' . $e->getMessage());
            return response()->json(['status' => false, 'message' => 'ডাটাবেজ থেকে তথ্য রিট্রিভ করা যায়নি।'], 500);
        }
    }

    /**
     * Fetch Active Exam Types and Readable Class Setups for populating the forms.
     */
    public function getFormDependencies()
    {
        try {
            $examTypes = ExamType::where('status', true)->orderBy('sort_order')->get();
            
            // FIXED: Changed 'class' to 'schoolClass' to match model relationship
            $classSetups = ClassSetup::with(['schoolClass', 'section', 'shift'])->where('status', true)->get();

            $formattedClassSetups = $classSetups->map(function ($setup) {
                $className = $setup->schoolClass->name ?? '—';
                $sectionName = $setup->section->name ?? 'N/A';
                $shiftName = $setup->shift->name ?? 'N/A';
                
                return [
                    'id' => $setup->id,
                    'label' => "{$className} - Section: {$sectionName} - {$shiftName} Shift"
                ];
            });

            return response()->json([
                'status' => true,
                'exam_types' => $examTypes,
                'class_setups' => $formattedClassSetups
            ], 200);

        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => 'ফিজিবল ডিক্লেয়ারেশন ডেটা লোড করা যায়নি।'], 500);
        }
    }

    /**
     * Store new Exam Setup.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'exam_type_id' => 'required|exists:exam_types,id',
            'class_setup_id' => 'required|exists:class_setups,id',
            'status' => 'nullable|boolean'
        ], [
            'exam_type_id.required' => 'পরীক্ষার ধরণ অবশ্যই নির্বাচন করতে হবে।',
            'class_setup_id.required' => 'শ্রেণীর বিন্যাস অবশ্যই নির্বাচন করতে হবে।'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        try {
            DB::beginTransaction();

            // Duplicate prevention strategy
            $exists = ExamSetup::where('exam_type_id', $request->exam_type_id)
                ->where('class_setup_id', $request->class_setup_id)
                ->exists();

            if ($exists) {
                return response()->json([
                    'status' => false,
                    'message' => 'এই শ্রেণীর জন্য এই পরীক্ষার ধরণটি ইতিমধ্যে বিন্যাস করা আছে।'
                ], 422);
            }

            $setup = ExamSetup::create([
                'exam_type_id' => $request->exam_type_id,
                'class_setup_id' => $request->class_setup_id,
                'status' => $request->boolean('status', true)
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'পরীক্ষা বিন্যাসকরণ সফলভাবে তৈরি হয়েছে।',
                'data' => $setup
            ], 201);

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('ExamSetup Store Failed: ' . $e->getMessage());
            return response()->json(['status' => false, 'message' => 'তথ্য সংরক্ষণ করা সম্ভব হয়নি।'], 500);
        }
    }


    /**
     * Show detailed Exam Setup along with dynamically loaded subject assignments.
     */
    public function show($id)
    {
        try {
            $examSetup = ExamSetup::with([
                'examType',
                'classSetup.schoolClass',
                'classSetup.section',
                'classSetup.shift'
            ])->findOrFail($id);

            // Fetch the exact same active subject assignments as the Details component
            $assignments = SubjectAssignment::with(['subject', 'group', 'paper'])
                ->where('class_setup_id', $examSetup->class_setup_id)
                ->get();

            return response()->json([
                'status' => true,
                'exam_setup' => $examSetup,
                'all_data' => $assignments // Matching your details view data structure!
            ], 200);

        } catch (Exception $e) {
            Log::error('ExamSetup Show Failed: ' . $e->getMessage());
            return response()->json(['status' => false, 'message' => 'রেকর্ডটি খুঁজে পাওয়া যায়নি।'], 404);
        }
    }

    /**
     * Update dynamic Exam Setup.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'exam_type_id' => 'required|exists:exam_types,id',
            'class_setup_id' => 'required|exists:class_setups,id',
            'status' => 'nullable|boolean'
        ], [
            'exam_type_id.required' => 'পরীক্ষার ধরণ অবশ্যই নির্বাচন করতে হবে।',
            'class_setup_id.required' => 'শ্রেণীর বিন্যাস অবশ্যই নির্বাচন করতে হবে।'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        try {
            DB::beginTransaction();

            $examSetup = ExamSetup::findOrFail($id);

            // Duplicate prevention strategy excluding the current ID
            $exists = ExamSetup::where('exam_type_id', $request->exam_type_id)
                ->where('class_setup_id', $request->class_setup_id)
                ->where('id', '!=', $id)
                ->exists();

            if ($exists) {
                return response()->json([
                    'status' => false,
                    'message' => 'এই শ্রেণীর জন্য এই পরীক্ষার ধরণটি ইতিমধ্যে বিন্যাস করা আছে।'
                ], 422);
            }

            $examSetup->update([
                'exam_type_id' => $request->exam_type_id,
                'class_setup_id' => $request->class_setup_id,
                'status' => $request->boolean('status', $examSetup->status)
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'পরীক্ষা বিন্যাসকরণ সফলভাবে হালনাগাদ করা হয়েছে।'
            ], 200);

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('ExamSetup Update Failed: ' . $e->getMessage());
            return response()->json(['status' => false, 'message' => 'তথ্য হালনাগাদ করা সম্ভব হয়নি।'], 500);
        }
    }

    /**
     * Delete dynamic Exam Setup.
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $examSetup = ExamSetup::findOrFail($id);
            $examSetup->delete();

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'পরীক্ষা বিন্যাসকরণ সফলভাবে মুছে ফেলা হয়েছে।'
            ], 200);

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('ExamSetup Delete Failed: ' . $e->getMessage());
            return response()->json(['status' => false, 'message' => 'রেকর্ডটি মুছে ফেলা সম্ভব হয়নি।'], 500);
        }
    }
}