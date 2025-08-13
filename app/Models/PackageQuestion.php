<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageQuestion extends Model
{
    protected $fillable = [
        'package_id',
        'content',
    ];
}
