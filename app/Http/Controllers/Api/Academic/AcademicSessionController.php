<?php

namespace App\Http\Controllers\Api\Academic;

use App\Http\Controllers\Controller;
use App\Models\AcademicSession;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class AcademicSessionController extends Controller
{
 /**
     * Get all sessions for data-table management
     */
    public function index()
    {
        // Enforce view authorization
        Gate::authorize('academic_sessions.view');

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
     * Create new academic session
     */
    public function store(Request $request)
    {
        // Enforce create authorization
        Gate::authorize('academic_sessions.create');

        $request->validate([
            'name' => 'required|string|max:50|unique:academic_sessions,name',
            'is_active' => 'nullable|boolean'
        ]);

        try {
            $session = DB::transaction(function () use ($request) {
                $isActive = $request->boolean('is_active', false);

                // If set as active, deactivate other older workspaces first
                if ($isActive) {
                    AcademicSession::query()->update(['is_active' => false]);
                }

                return AcademicSession::create([
                    'name' => trim($request->name),
                    'is_active' => $isActive
                ]);
            });

            return response()->json([
                'status' => true,
                'message' => 'Academic session created successfully.',
                'data' => $session
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get single academic session details
     */
    public function show($id)
    {
        // Enforce view authorization
        Gate::authorize('academic_sessions.view');

        try {
            $session = AcademicSession::findOrFail($id);

            return response()->json([
                'status' => true,
                'data' => $session
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Academic session not found.'
            ], 404);
        }
    }

    /**
     * Update dynamic academic session
     */
    public function update(Request $request, $id)
    {
        // Enforce edit authorization
        Gate::authorize('academic_sessions.edit');

        $request->validate([
            'name' => 'required|string|max:50|unique:academic_sessions,name,' . $id,
            'is_active' => 'nullable|boolean'
        ]);

        try {
            $session = AcademicSession::findOrFail($id);

            DB::transaction(function () use ($request, $session) {
                $isActive = $request->boolean('is_active', false);

                // Toggle active session states across ERP
                if ($isActive) {
                    AcademicSession::query()->update(['is_active' => false]);
                }

                $session->update([
                    'name' => trim($request->name),
                    'is_active' => $isActive
                ]);
            });

            return response()->json([
                'status' => true,
                'message' => 'Academic session updated successfully.'
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete academic session
     */
    public function destroy($id)
    {
        // Enforce delete authorization
        Gate::authorize('academic_sessions.delete');

        try {
            $session = AcademicSession::findOrFail($id);

            // Restrict deletion of active session
            if ($session->is_active) {
                return response()->json([
                    'status' => false,
                    'message' => 'Cannot delete the active academic session.'
                ], 422);
            }

            $session->delete();

            return response()->json([
                'status' => true,
                'message' => 'Academic session deleted successfully.'
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Set a specific session as active workspace
     */
    public function setActive($id)
    {
        // Enforce edit authorization
        Gate::authorize('academic_sessions.edit');

        try {
            $session = AcademicSession::findOrFail($id);

            DB::transaction(function () use ($session) {
                // Deactivate all workspaces
                AcademicSession::query()->update(['is_active' => false]);

                // Active only specified year
                $session->update(['is_active' => true]);
            });

            return response()->json([
                'status' => true,
                'message' => "Academic session '{$session->name}' has been successfully set as active."
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
