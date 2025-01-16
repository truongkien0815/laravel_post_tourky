<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ShopOrderHistory extends Model
{
    public $timestamps = false;
    protected $table = 'shop_order_history';
    protected $guarded =[];

    protected static function boot()
    {
        parent::boot();
        // before delete() method call this
        static::deleting(
            function ($obj) {
                //
            }
        );
    }
}
