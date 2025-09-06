<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gateway extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'driver',
        'merchant_id',
        'callback_url',
        'sandbox',
        'active',
    ];

    /**
     * A gateway can have many transactions.
     */
    public function transactions()
    {
        return $this->hasMany(GatewayTransaction::class);
    }
}
