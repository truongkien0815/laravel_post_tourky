<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class LocationDistrict extends Model
{
    public $timestamps = false;
    protected $table = 'location_district';
    protected $fillable =[
        'name',
        'slug',
        'type',
        'province_id'
    ];


    public function ward()
    {
        return $this->hasMany(\App\Model\Ward::class, 'district_id');
    }
}
