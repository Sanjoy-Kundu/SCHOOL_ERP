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
        Schema::create('fee_setups', function (Blueprint $table) {
            $table->id();
            // Foreign relationship mapping
            $table->foreignId('academic_session_id')
                  ->constrained('academic_sessions')
                  ->cascadeOnDelete();

            $table->foreignId('class_setup_id')
                  ->constrained('class_setups')
                  ->cascadeOnDelete();

            $table->foreignId('fee_category_id')
                  ->constrained('fee_categories')
                  ->cascadeOnDelete();

            $table->foreignId('month_id')
                  ->nullable()
                  ->constrained('months')
                  ->nullOnDelete();

            // Financial amounts configuration
            $table->decimal('amount', 10, 2)->default(0.00);
            $table->boolean('status')->default(true);
            $table->timestamps();

            // Strict unique composite index key definition
            $table->unique(
                [
                    'academic_session_id',
                    'class_setup_id',
                    'fee_category_id',
                    'month_id'
                ],
                'fee_setup_session_class_cat_month_unique'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fee_setups');
    }
};
