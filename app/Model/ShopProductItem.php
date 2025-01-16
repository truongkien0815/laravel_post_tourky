<?php

namespace App\Model;

use App\Filters\Filterable;
use Illuminate\Database\Eloquent\Model;

class ShopProductItem extends Model
{

    public $timestamps = true;
    protected $table = 'shop_product_items';
    protected $guarded = [];

    public function productItemFeatures()
    {
        return $this->hasMany(ShopProductItemFeature::class);
    }

    public function product()
    {
        return $this->belongsTo(ShopProduct::class);
    }

    public function getGallery()
    {
        if($this->gallery != '')
        {
            $gallery = json_decode($this->gallery);
            return $gallery;
        }
        return [];
    }
}
