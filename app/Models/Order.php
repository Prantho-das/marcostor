<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'name',
        'mobile',
        'area',
        'address',
        'subtotal',
        'delivery_charge',
        'shipping_cost',
        'total',
        'payment_method',
        'payment_gateway',
        'transaction_id',
        'payment_status',
        'payment_date',
        'is_paid',
        'status',
        'gateway_response',
        
         'courier_name',
    'courier_tracking_id',
    'courier_status',
    'courier_payload',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
