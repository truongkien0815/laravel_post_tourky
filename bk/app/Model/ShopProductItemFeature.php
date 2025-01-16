<?php

namespace App\Model;

use App\Filters\Filterable;
use Illuminate\Database\Eloquent\Model;

class ShopProductItemFeature extends Model
{
	public $timestamps = true;
   protected $table = 'shop_product_item_features';
   protected $guarded = [];

   public function getItem()
   {
       return $this->hasOne(ShopProductItem::class, 'id', 'product_item_id');
   }
}
