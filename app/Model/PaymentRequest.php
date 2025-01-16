<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PaymentRequest extends Model
{
    public $timestamps = true;
    protected $table = 'payment_request';
    protected $fillable =[
        'user_id',
        'cart_id',
        'amount',
        'status',
        'payment_method',
        'payment_status',
        'payment_code',
        'bank_code',
        'payment_url',
        'conent',
        'log_merchant'
    ];
}
