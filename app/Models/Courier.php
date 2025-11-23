<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Courier extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'base_url',
        'status'
    ];

    public function deliveryOrders()
    {
        return $this->hasMany(DeliveryOrder::class, 'courier_id');
    }
}
