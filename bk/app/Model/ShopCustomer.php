<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ShopCustomer extends Model
{
    public $timestamps = false;
    protected $table = 'shop_customer';
    protected $guarded =[];
}
