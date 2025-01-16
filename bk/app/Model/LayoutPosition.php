<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class LayoutPosition extends Model
{
    public $timestamps = false;
    protected $table = 'shop_layout_position';
    protected $guarded = [];

    public static function getPositions()
    {
        return self::pluck('name', 'key')->all();
    } 
}
