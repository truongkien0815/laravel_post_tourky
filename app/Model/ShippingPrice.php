<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ShippingPrice extends Model
{
    public $timestamps = false;
    protected $table = 'shop_shipping_price';
    protected $guarded =[];
    private static $getListActive      = null;

    public static function getListActive()
    {
        if (self::$getListActive === null) {
            self::$getListActive = self::where('status', 1)
                ->orderBy('sort', 'asc')
                ->get();
        }
        return self::$getListActive;
    }
}
