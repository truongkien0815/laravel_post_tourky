<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    public function contacts()
    {
        return $this->belongsTo('App\Contact', 'question_id');
    }
}
