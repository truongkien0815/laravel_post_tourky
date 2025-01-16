<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ContactPayment extends Model
{
    public $timestamps = true;
    protected $table = 'contact_payment';
    protected $fillable =[
        'name',
        'phone',
        'email',
        'content',
        'file',
    ];
}
