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
        Schema::create('exam_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_type_id')->constrained('exam_types')->cascadeOnDelete();
            $table->foreignId('class_setup_id')->constrained('class_setups')->cascadeOnDelete();
            $table->foreignId('subject_assignment_id')->constrained('subject_assignments')->cascadeOnDelete();

            $table->date('exam_date');
            $table->time('start_time');
            $table->time('end_time');

            $table->string('room_name')->nullable();
            $table->string('examiner_name')->nullable();
            $table->integer('seat_capacity')->nullable();
            $table->text('instructions')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();

            // Strict unique composite index to prevent duplicating subject assignments inside the same exam type
            $table->unique(
                ['exam_type_id', 'class_setup_id', 'subject_assignment_id'],
                'exam_schedule_exam_type_setup_assignment_unique'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_schedules');
    }
};
