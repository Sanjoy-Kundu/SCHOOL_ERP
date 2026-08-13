<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Month extends Model
{
/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'months';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
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
     * Standard hooks to normalize inputs on saving.
     */
    protected static function booted(): void
    {
        // Capitalize the first letter of the month name on saving
        static::saving(function ($model) {
            if ($model->name) {
                $model->name = ucfirst(strtolower(trim($model->name)));
            }
        });
    }

    /**
     * Local Scope to retrieve only active months for dropdown listings.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
