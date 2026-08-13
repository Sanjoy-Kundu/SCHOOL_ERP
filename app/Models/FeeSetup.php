<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FeeSetup extends Model
{
/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'fee_setups';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'academic_session_id',
        'class_setup_id',
        'fee_category_id',
        'month_id',
        'amount',
        'status'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'amount' => 'decimal:2',
        'status' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the academic session associated with the fee setup.
     */
    public function academicSession(): BelongsTo
    {
        return $this->belongsTo(AcademicSession::class, 'academic_session_id');
    }

    /**
     * Get the class setup associated with the fee setup.
     */
    public function classSetup(): BelongsTo
    {
        return $this->belongsTo(ClassSetup::class, 'class_setup_id');
    }

    /**
     * Get the fee category associated with the fee setup.
     */
    public function feeCategory(): BelongsTo
    {
        return $this->belongsTo(FeeCategory::class, 'fee_category_id');
    }

    /**
     * Get the month associated with the fee setup.
     */
    public function month(): BelongsTo
    {
        return $this->belongsTo(Month::class, 'month_id');
    }
}
