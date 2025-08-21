<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageQuestion extends Model
{
    protected $fillable = [
        'package_id',
        'content',
        'type',
        'is_required',
    ];

    public function options()
    {
        return $this->hasMany(PackageQuestionOption::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
