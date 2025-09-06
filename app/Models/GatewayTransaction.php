<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GatewayTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'gateway_id',
        'user_id',
        'order_id',
        'amount',
        'currency',
        'status',
        'transaction_id',
        'tracking_code',
        'card_number',
        'ip',
        'payment_method',
    ];

    /**
     * A transaction belongs to a gateway.
     */
    public function gateway()
    {
        return $this->belongsTo(Gateway::class);
    }

    /**
     * A transaction may belong to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
