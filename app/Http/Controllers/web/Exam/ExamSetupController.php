<?php

namespace App\Http\Controllers\Web\Exam;

use App\Http\Controllers\Controller;
use Exception;

class ExamSetupController extends Controller
{
 /**
     * Render the centralized master Exam Setup view.
     */
    public function examSetupPage()
    {
        try{
        // Points to the future printable subject map page 
        return view('pages.dashboard.exam.examSetupPage');
        }catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
