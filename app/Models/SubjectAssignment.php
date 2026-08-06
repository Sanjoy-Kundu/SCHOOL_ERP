<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubjectAssignment extends Model
{
    protected $table = 'subject_assignments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'class_setup_id',
        'subject_id',
        'group_id',
        'paper_id',
        'code',
        'is_fourth_subject',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_fourth_subject' => 'boolean',
        'status' => 'boolean',
    ];

    /**
     * Relationship: Assignment belongs to a specific Class Setup configuration.
     */
    public function classSetup()
    {
        return $this->belongsTo(ClassSetup::class, 'class_setup_id');
    }

    /**
     * Relationship: Assignment belongs to a master Subject.
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    /**
     * Relationship: Assignment belongs to an optional master Group (nullable).
     */
    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

    /**
     * Relationship: Assignment belongs to an optional master Paper (nullable) 
     */
    public function paper()
    {
        return $this->belongsTo(Paper::class, 'paper_id');
    }


 

}
