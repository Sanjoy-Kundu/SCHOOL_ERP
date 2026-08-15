<?php

namespace App\Http\Controllers\Api\Public;

use App\Http\Controllers\Controller;
use App\Models\AcademicSession;
use App\Models\ClassSetup;
use App\Models\Group;
use App\Models\Month;
use App\Models\SchoolInformation;
use Exception;
use Illuminate\Support\Facades\Log;


class PublicPortalController extends Controller
{
/**
     * Fetch Single Institution Master Record.
     */
    public function instituteInformation()
    {
        try {
            // Retrieve only first master row (Single-Installation Architecture)
            $school = SchoolInformation::first();

            return response()->json([
                'status' => true,
                'data'   => $school
            ], 200);

        } catch (Exception $e) {
            Log::error('SchoolInformation Fetch Failed: ' . $e->getMessage());
            return response()->json([
                'status'  => false,
                'message' => 'প্রতিষ্ঠানের তথ্য লোড করা সম্ভব হয়নি।'
            ], 500);
        }
    }



    /**
     * Fetch all class setups with related master data sorted sequentially.
     */
    public function classSetupLists()
    {
        try {
            // Retrieve with eager load and sort sequentially based on sort_order priorities (Group relation removed)
            $setups = ClassSetup::with(['class', 'section', 'shift'])->get()
                ->sortBy(function ($setup) {
                    return [
                        $setup->class?->sort_order ?? 0,
                        $setup->section?->sort_order ?? 0,
                        $setup->shift?->sort_order ?? 0
                    ];
                })->values();

            return response()->json([
                'status' => true,
                'all_data' => $setups
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Fetch all academic session lists .
     */
        public function academicSessionLists()
    {

        try {
            // Get sessions ordered by year dynamically
            $activeSessions = AcademicSession::where('is_active', true)->orderBy('name', 'desc')->get();
            $allSessions = AcademicSession::orderBy('name', 'desc')->get();
            return response()->json([
                'status' => true,
                'data' => $activeSessions,
                'all_data' => $allSessions
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Fetch all academic session lists .
     */
        public function monthLists()
    {
       try {
            $months = Month::orderBy('sort_order', 'asc')
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'status' => true,
                'all_data' => $months
            ], 200);

        } catch (Exception $e) {
            Log::error('Month Fetch Failed: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Failed to load months.'
            ], 500);
        }
    }


    /***
     * Group Lists
     */
     /**
     * Fetch all group master records sorted by sort_order
     */
    public function groupLists()
    {
        try {
            $allGroups = Group::orderBy('sort_order', 'asc')->get();
            $activeGroups = Group::where('status', true)->orderBy('sort_order', 'asc')->get();

            return response()->json([
                'status' => true,
                'data' => $activeGroups,
                'all_data' => $allGroups
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
