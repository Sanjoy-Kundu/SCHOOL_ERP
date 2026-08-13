<?php

namespace App\Http\Controllers\Web\FeesManagement\FeeStructure;

use App\Http\Controllers\Controller;
use Exception;


class FeeStructureController extends Controller
{
/**
     * Display the Fees Structure Management panel.
     */
    public function createFeeStructure()
    {
        try{
        return view('pages.dashboard.fees.feeStructurePage');
        }catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
