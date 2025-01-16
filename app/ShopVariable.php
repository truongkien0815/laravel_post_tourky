<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShopVariable extends Model
{
    protected $table = 'shop_variable';

    public function getNameAttribute($value){
        $lc = app()->getLocale();
        if('vi' == $lc){
            return $value;
        } else {
            return $this->{'name_' . $lc};
        }
    }

    public function listItem()
    {
        return $this->hasMany(\App\Model\ShopProductItemFeature::class, 'variable_id', 'id')->groupBy('value');
    }
}
