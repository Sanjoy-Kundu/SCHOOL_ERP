<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExamSchedule extends Model
{
protected $table = 'exam_schedules';

    protected $fillable = [
        'exam_type_id',
        'class_setup_id',
        'subject_assignment_id',
        'exam_date',
        'start_time',
        'end_time',
        'room_name',
        'examiner_name',
        'seat_capacity',
        'instructions',
        'status'
    ];

    protected $casts = [
        'exam_date' => 'date:Y-m-d',
        'status' => 'boolean'
    ];

    /**
     * Get the master exam type.
     */
    public function examType(): BelongsTo
    {
        return $this->belongsTo(ExamType::class, 'exam_type_id');
    }

    /**
     * Get the class setup.
     */
    public function classSetup(): BelongsTo
    {
        return $this->belongsTo(ClassSetup::class, 'class_setup_id');
    }

    /**
     * Get the subject assignment mapping.
     */
    public function subjectAssignment(): BelongsTo
    {
        return $this->belongsTo(SubjectAssignment::class, 'subject_assignment_id');
    }
}
