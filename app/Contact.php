<?php

namespace App;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'fullname' , 
        'mobile' ,
        'address'  ,
        'content' ,
        'status' ,
'question_id',
       
    ];
    //
    public function questions()
    {
        return $this->hasMany('App\Question', 'id');
    }
   
}
