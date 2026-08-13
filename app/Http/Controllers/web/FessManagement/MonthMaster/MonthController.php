<?php

namespace App\Http\Controllers\Web\FessManagement\MonthMaster;

use App\Http\Controllers\Controller;
use Exception;

class MonthController extends Controller
{
/**
     * Display the Fees Category Management panel.
     */
    public function createMonth()
    {
        try{
        return view('pages.dashboard.fees.createMonthPage');
        }catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
