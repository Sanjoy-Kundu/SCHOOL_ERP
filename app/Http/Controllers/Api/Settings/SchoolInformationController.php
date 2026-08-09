<?php

namespace App\Http\Controllers\Api\Settings;

use App\Http\Controllers\Controller;
use App\Models\SchoolInformation;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class SchoolInformationController extends Controller
{
/**
     * Fetch Single Institution Master Record.
     */
    public function show()
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
     * Create or Update Single Master Record safely using Database Transactions.
     */
    public function update(Request $request)
    {
        // 1. Spatie Permission Check (Seamless protection)
        if (!auth()->user()->can('school_information.edit')) {
            return response()->json([
                'status'  => false,
                'message' => 'প্রতিষ্ঠানের তথ্য পরিবর্তন করার অনুমতি আপনার নেই।'
            ], 403);
        }

        // 2. Validate Inputs
        $validator = Validator::make($request->all(), [
            'name_bn'              => 'required|string|max:255',
            'name_en'              => 'required|string|max:255',
            'school_code'          => 'nullable|string|max:100',
            'eiin'                 => 'nullable|string|max:100',
            'school_type'          => 'nullable|string|max:100',
            'management_type'      => 'nullable|string|max:100',
            'established_year'     => 'nullable|integer|min:1000|max:' . date('Y'),
            'recognition_no'       => 'nullable|string|max:255',
            'recognition_date'     => 'nullable|date',
            
            'division'             => 'nullable|string|max:255',
            'district'             => 'nullable|string|max:255',
            'upazila'              => 'nullable|string|max:255',
            'union_ward'           => 'nullable|string|max:255',
            'village_area'         => 'nullable|string|max:255',
            'post_office'          => 'nullable|string|max:255',
            'post_code'            => 'nullable|string|max:100',
            'address'              => 'nullable|string',
            
            'phone'                => 'required|string|max:100',
            'alternate_phone'      => 'nullable|string|max:100',
            'email'                => 'nullable|email|max:255',
            'website'              => 'nullable|url|max:255',
            'emergency_phone'      => 'nullable|string|max:100',
            
            'head_name_bn'         => 'nullable|string|max:255',
            'head_name_en'         => 'nullable|string|max:255',
            'head_designation_bn'  => 'nullable|string|max:255',
            'head_designation_en'  => 'nullable|string|max:255',
            
            'motto'                => 'nullable|string|max:255',
            'description'          => 'nullable|string',
            'mission'              => 'nullable|string',
            'vision'               => 'nullable|string',
            
            'logo_square'          => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
            'logo_circle'          => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
            'favicon'              => 'nullable|mimes:jpeg,jpg,png,webp,ico|max:1024',
            
            'social_links'         => 'nullable|array',
            'social_links.*.platform' => 'required_with:social_links|string|max:255',
            'social_links.*.icon'     => 'required_with:social_links|string|max:255',
            'social_links.*.url'      => 'required_with:social_links|url|max:500'
        ], [
            'name_bn.required' => 'প্রতিষ্ঠানের নাম (বাংলা) অবশ্যই প্রদান করতে হবে।',
            'name_en.required' => 'প্রতিষ্ঠানের নাম (ইংরেজি) অবশ্যই প্রদান করতে হবে।',
            'phone.required'   => 'অফিসিয়াল মোবাইল নম্বর অবশ্যই প্রদান করতে হবে।',
            'email.email'      => 'সঠিক ই-মেইল ঠিকানা প্রদান করুন।',
            'website.url'      => 'সঠিক ওয়েবসাইট ইউআরএল (URL) প্রদান করুন।',
            'logo_square.max'  => 'স্কয়ার লোগোর সাইজ ২ মেগাবাইটের বেশি হতে পারবে না।',
            'logo_circle.max'  => 'সার্কেল লোগোর সাইজ ২ মেগাবাইটের বেশি হতে পারবে না।',
            'favicon.max'      => 'ফেভিকনের সাইজ ১ মেগাবাইটের বেশি হতে পারবে না।',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $tempFilesUploaded = [];

        try {
            DB::beginTransaction();

            $school = SchoolInformation::first() ?? new SchoolInformation();

            // Fill text fields
            $school->fill($request->except(['logo_square', 'logo_circle', 'favicon', 'social_links']));
            
            // Format and assign dynamic social links safely
            $school->social_links = $request->social_links ?? [];

            // 3. Handle File Uploads with Public Path Storage and Professional Naming
            $brandingFiles = [
                'logo_square' => 'logo_square_path',
                'logo_circle' => 'logo_circle_path',
                'favicon'     => 'favicon_path'
            ];

            $namingDictionary = [
                'logo_square' => 'school_logo_square',
                'logo_circle' => 'school_logo_circle',
                'favicon'     => 'school_favicon'
            ];


            foreach ($brandingFiles as $inputName => $dbField) {
                if ($request->hasFile($inputName)) {
                    $oldFilePath = $school->$dbField;
                    $uploadedFile = $request->file($inputName);
                    
                    // Professional custom filename generation
                    $prefix = $namingDictionary[$inputName] ?? 'school_asset';
                    $fileName = $prefix . '_' . time() . '.' . $uploadedFile->getClientOriginalExtension();
                    
                    // Target destination path inside public directory
                    $destinationPath = public_path('uploads/settings/logo');
                    
                    // Move the file physically
                    $uploadedFile->move($destinationPath, $fileName);
                    $relativeDbPath = 'uploads/settings/logo/' . $fileName;

                    $tempFilesUploaded[] = $relativeDbPath; // Tracker for rollback
                    $school->$dbField = $relativeDbPath;

                    // Safely purge outdated physical asset from public directory
                    if ($oldFilePath) {
                        $oldPhysicalPath = public_path($oldFilePath);
                        if (file_exists($oldPhysicalPath)) {
                            @unlink($oldPhysicalPath);
                        }
                    }
                }
            }

            $school->save();

            DB::commit();

            return response()->json([
                'status'  => true,
                'message' => 'প্রতিষ্ঠানের তথ্য সফলভাবে আপডেট করা হয়েছে।',
                'data'    => $school
            ], 200);

        } catch (Exception $e) {
            DB::rollBack();

            // Safe rollback: Clean up newly uploaded files immediately
            // Safe rollback: Clean up newly uploaded files from public directory immediately
            foreach ($tempFilesUploaded as $relativePath) {
                $physicalPath = public_path($relativePath);
                if (file_exists($physicalPath)) {
                    @unlink($physicalPath);
                }
            }


            Log::error('SchoolInformation Update Failed: ' . $e->getMessage());

            return response()->json([
                'status'  => false,
                'message' => 'সার্ভার ত্রুটি! তথ্য আপডেট করা সম্ভব হয়নি।'
            ], 500);
        }
    }
}
