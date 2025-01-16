<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ShopType extends Model
{
    public $timestamps = false;
    protected $table = 'shop_type';
    protected $guarded =[];

    public function getChild()
    {
        return $this->hasMany(ShopType::class, 'parent', 'id');
    }
}
