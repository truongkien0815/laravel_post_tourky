<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DocumentCategory extends Model
{
    public $timestamps = true;
    // protected $table = 'client_category';
    protected $guarded =[];

    function nameConvert()
    {
        $name = str_replace('<br />', '', $this->name);
        $name = str_replace('<br/>', '', $name);
        $name = str_replace('__', ' ', $name);
        return $name;
    }

    public function post()
    {
        return $this->belongsToMany('App\Model\Document', 'document_category_join', 'category_id', 'post_id');
    }

    public function children() {
        return $this->hasMany(DocumentCategory::class, 'category_id', 'id')->orderBy('sort', 'asc')->orderByDesc('id');
    }
}
