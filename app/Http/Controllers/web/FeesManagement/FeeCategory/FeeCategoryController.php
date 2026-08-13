<?php

namespace App\Http\Controllers\Web\FeesManagement\FeeCategory;

use App\Http\Controllers\Controller;
use Exception;

class FeeCategoryController extends Controller
{
/**
     * Display the Fees Category Management panel.
     */
    public function createFeesCategroy()
    {
        try{
        return view('pages.dashboard.fees.feeCategoryPage');
        }catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
