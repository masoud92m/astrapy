<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnalysisAnswers extends Model
{
    protected $fillable = [
        'analysis_id',
        'package_question_id',
        'content',
    ];
}
