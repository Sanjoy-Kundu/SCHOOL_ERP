<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeeCategory extends Model
{
/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'fee_categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'code',
        'description',
        'is_active',
        'sort_order'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * The booted method of the model.
     * Automatically registers lifecycle hook events.
     */
    protected static function booted(): void
    {
        // Creating Event: Auto-format short codes to clean uppercase string
        static::creating(function ($model) {
            if ($model->code) {
                $model->code = strtoupper(trim($model->code));
            }
        });

        // Updating Event: Maintain clean uppercase format during update cycles
        static::updating(function ($model) {
            if ($model->code) {
                $model->code = strtoupper(trim($model->code));
            }
        });
    }
}
