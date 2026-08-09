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
        Schema::create('exam_setups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_type_id')->constrained('exam_types')->cascadeOnDelete();
            $table->foreignId('class_setup_id')->constrained('class_setups')->cascadeOnDelete();
            
            $table->boolean('status')->default(true);
            $table->timestamps();

            // Strict composite unique index constraint
            $table->unique(
                ['exam_type_id', 'class_setup_id'],
                'exam_setup_exam_type_class_setup_unique'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_setups');
    }
};
