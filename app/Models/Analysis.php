<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Analysis extends Model
{
    protected $table = 'analyses';
    protected $fillable = [
        'package_id',
        'user_id',
        'causer_id',
        'name',
        'gender',
        'relationship',
        'dob',
        'prompt',
        'analysis',
    ];
    public function answers()
    {
        return $this->hasMany(AnalysisAnswers::class);
    }
}
