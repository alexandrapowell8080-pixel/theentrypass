<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Questions extends Model
{
    protected $fillable = [
        'question', 'exam_id', 'extract', 'optionA', 'optionB', 'optionC', 'optionD', 'optionE', 'optionF', 'optionG', 'correct_answer', 'rationale', 'study_tip', 'slug',
    ];

    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }
}
