<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class VNPayLog extends Model
{
    public $timestamps = true;
    protected $table = 'vnpay_logs';
    protected $guarded =[];

}
