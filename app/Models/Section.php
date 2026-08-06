<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
// Explicitly define table name as sections
    protected $table = 'sections';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'sort_order',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => 'boolean',
    ];
}
