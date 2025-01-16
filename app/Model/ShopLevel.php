<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ShopLevel extends Model
{
    public $timestamps = false;
    protected $table = 'shop_level';
    protected $guarded =[];

    public function getChild()
    {
        return $this->hasMany(ShopLevel::class, 'parent', 'id');
    }
}
