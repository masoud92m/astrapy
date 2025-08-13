<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'special_price',
        'prompt1',
        'prompt2',
        'meta_title',
        'meta_description',
        'published_at',
    ];

    public function questions()
    {
        return $this->hasMany(PackageQuestion::class);
    }
}
