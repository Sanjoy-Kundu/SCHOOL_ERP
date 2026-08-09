<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('school_information', function (Blueprint $table) {
            $table->id();
           // Institution Identity 
            $table->string('name_bn');
            $table->string('name_en');
            $table->string('school_code')->nullable();
            $table->string('eiin')->nullable();
            $table->string('school_type')->nullable(); // Secondary, School & College etc.
            $table->string('management_type')->nullable(); // Government, MPO, Private etc.
            $table->integer('established_year')->nullable();
            $table->string('recognition_no')->nullable();
            $table->date('recognition_date')->nullable();

            // Address & Location
            $table->string('division')->nullable();
            $table->string('district')->nullable();
            $table->string('upazila')->nullable();
            $table->string('union_ward')->nullable();
            $table->string('village_area')->nullable();
            $table->string('post_office')->nullable();
            $table->string('post_code')->nullable();
            $table->text('address')->nullable();

            // Contact Information
            $table->string('phone');
            $table->string('alternate_phone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('emergency_phone')->nullable();

            // Branding Assets 
            $table->string('logo_square_path')->nullable();
            $table->string('logo_circle_path')->nullable();
            $table->string('favicon_path')->nullable();

            // Head of Institution 
            $table->string('head_name_bn')->nullable();
            $table->string('head_name_en')->nullable();
            $table->string('head_designation_bn')->nullable();
            $table->string('head_designation_en')->nullable();

            // Additional Details 
            $table->string('motto')->nullable();
            $table->text('description')->nullable();
            $table->text('mission')->nullable();
            $table->text('vision')->nullable();

            // Dynamic Social Links (JSON format)
            $table->json('social_links')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_information');
    }
};
