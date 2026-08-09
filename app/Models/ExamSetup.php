<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExamSetup extends Model
{
protected $table = 'exam_setups';

    protected $fillable = [
        'exam_type_id',
        'class_setup_id',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean'
    ];

    /**
     * Get the master exam type configuration.
     */
    public function examType(): BelongsTo
    {
        return $this->belongsTo(ExamType::class, 'exam_type_id');
    }

    /**
     * Get the structured class setup configuration.
     */
    public function classSetup(): BelongsTo
    {
        return $this->belongsTo(ClassSetup::class, 'class_setup_id');
    }
}
