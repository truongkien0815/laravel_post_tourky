<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ShopOrderDetail extends Model
{
    public $timestamps = false;
    protected $table = 'shop_order_detail';
    protected $guarded =[];
}
