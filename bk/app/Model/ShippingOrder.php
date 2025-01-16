<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ShippingOrder extends Model
{
    public $timestamps = true;
    protected $table = 'shipping_order';
    protected $fillable =[
        'id',
        'shipping_code',
        'cart_id',
        'shipping_type',
        'shipping_status',
        'shipping_date',
    ];
}
