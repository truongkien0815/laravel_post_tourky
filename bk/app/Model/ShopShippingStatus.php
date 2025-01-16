<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ShopShippingStatus extends Model
{
    public $timestamps = false;
    protected $table = 'shop_shipping_status';
    protected $guarded =[];

    protected static $listStatus = null;
    protected $connection = SC_CONNECTION;
    public static function getIdAll()
    {
        if (!self::$listStatus) {
            self::$listStatus = self::pluck('name', 'id')->all();
        }
        return self::$listStatus;
    }
}
