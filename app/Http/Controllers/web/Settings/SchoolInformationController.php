<?php

namespace App\Http\Controllers\Web\Settings;

use App\Http\Controllers\Controller;
use Exception;

class SchoolInformationController extends Controller
{
/**
     * Display the School Information Management panel.
     */
    public function schoolInformationCreate()
    {
        try{
        // Points to the future printable subject map page 
        return view('pages.dashboard.settings.school-information.schoolInformationPage');
        }catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
