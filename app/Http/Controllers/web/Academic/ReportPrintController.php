<?php

namespace App\Http\Controllers\Web\Academic;

use App\Http\Controllers\Controller;
use Exception;


class ReportPrintController extends Controller
{
/**
     * Render the centralized master subject list print view.
     */
    public function subjectListPrint()
    {
        try{
        // Points to the future printable subject map page 
        return view('pages.dashboard.academic.reports.subjectListPrintPage');
        }catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
