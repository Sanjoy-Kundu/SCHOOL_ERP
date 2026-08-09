<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassSetup extends Model
{
protected $table = 'class_setups';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'class_id',
        'section_id',
        'shift_id',
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

 /**
     * Relationship: Setup belongs to a master class.
     */
    public function class()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    /**
     * Relationship: Setup belongs to a master section (optional).
     */
    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    /**
     * Relationship: Setup belongs to a master shift (optional).
     */
    public function shift()
    {
        return $this->belongsTo(Shift::class, 'shift_id');
    }

    /**
     * Relationship: Setup belongs to a master academic group (optional).
     */
    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }
}