<?php

namespace App\Http\Controllers\Web\Admission;

use App\Http\Controllers\Controller;
use Exception;


class AdmissionController extends Controller
{
/**
     * Display the Online Admission panel.
     */
    public function onlineApplicationsForm()
    {
        try{
        return view('pages.admission.onlineAdmissionPage');
        }catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
/**
     * Display the Online Admission panel.
     */
    public function newAdmissionForm()
    {
        try{
        return view('pages.dashboard.admission.admissionPage');
        }catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
