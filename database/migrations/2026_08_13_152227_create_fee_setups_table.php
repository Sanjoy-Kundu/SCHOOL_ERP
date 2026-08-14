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
            $table->foreignId('academic_session_id')->constrained('academic_sessions')->cascadeOnDelete();
            $table->foreignId('class_setup_id')->constrained('class_setups')->cascadeOnDelete();
            $table->foreignId('fee_category_id')->constrained('fee_categories')->cascadeOnDelete();
            $table->foreignId('month_id')->nullable() ->constrained('months')->nullOnDelete();
            $table->decimal('amount', 10, 2)->default(0.00);
            $table->boolean('status')->default(true);
            $table->unsignedBigInteger('month_unique_val')->nullable()->stored()->as('IFNULL(month_id, 0)');
            $table->timestamps();
            $table->unique(
                [
                    'academic_session_id',
                    'class_setup_id',
                    'fee_category_id',
                    'month_unique_val'
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
