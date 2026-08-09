<?php

namespace App\Http\Controllers\web\Exam;

use App\Http\Controllers\Controller;
use Exception;

class ExamTypeController extends Controller
{
    /**
     * Render the centralized master Exam Type list print view.
     */
    public function examTypePage()
    {
        try{
        // Points to the future printable subject map page 
        return view('pages.dashboard.exam.createExamTypePage');
        }catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
