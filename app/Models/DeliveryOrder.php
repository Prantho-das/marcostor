<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryOrder extends Model
{
    protected $fillable = [
        'courier_id',
        'merchant_order_id',
        'consignment_id',
        'recipient_name',
        'recipient_phone',
        'recipient_address',
        'city_id',
        'zone_id',
        'area_id',
        'delivery_type',
        'item_type',
        'item_quantity',
        'item_weight',
        'amount_to_collect',
        'item_description',
        'status',
        'provider_status',
        'raw_request',
        'raw_response',
        'extra'
    ];

    protected $casts = [
        'raw_request' => 'array',
        'raw_response' => 'array',
        'extra' => 'array',
    ];

    public function courier()
    {
        return $this->belongsTo(Courier::class, 'courier_id');
    }
}
