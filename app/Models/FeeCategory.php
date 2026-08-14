<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FeeCategory extends Model
{
 /**
     * Define Type Constants directly inside Model
     */
    const TYPE_ONE_TIME = 'one_time';
    const TYPE_MONTHLY  = 'monthly';
    const TYPE_CUSTOM   = 'custom';

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
        'type', // Added securely
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
     * Static helper to get translated type labels
     */
    public static function getTypeLabels(): array
    {
        return [
            self::TYPE_MONTHLY  => 'মাসিক ফি (Monthly)',
            self::TYPE_ONE_TIME => 'এককালীন ফি (One-time)',
            self::TYPE_CUSTOM   => 'কাস্টম ফি (Custom)',
        ];
    }

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

    /**
     * Get setups mapping associated with this category.
     */
    public function feeSetups(): HasMany
    {
        return $this->hasMany(FeeSetup::class, 'fee_category_id');
    }
}
