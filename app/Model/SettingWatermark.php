<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SettingWatermark extends Model
{
    public $timestamps = false;
    protected $table = 'settings_watermark';
    protected $guarded =[];
}
