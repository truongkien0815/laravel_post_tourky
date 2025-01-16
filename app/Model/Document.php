<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    public $timestamps = true;
    // protected $table = 'client';
    protected $guarded = [];
    protected  $sc_category = []; // array category id

    /**
     * Set array category 
     *
     * @param   [array|int]  $category 
     *
     */
    public function setCategory($category) {
        if (is_array($category)) {
            $this->sc_category = $category;
        } else {
            $this->sc_category = array((int)$category);
        }
        return $this;
    }

    public function categories(){
        return $this->belongsToMany('App\Model\DocumentCategory', 'document_category_joins', 'post_id', 'category_id');
    }

    public function getDetail($id, $type='')
    {
        $detail = new Document;
        if($type == 'slug')
            $detail = $detail->where('slug', $id);
        else
            $detail = $detail->where('id', $id);

        $detail = $detail->first();
        return $detail;
    }

    public function getList(array $dataSearch)
    {
        $keyword = $dataSearch['keyword'] ?? '';

        $sort_order = $dataSearch['sort_order'] ?? '';
        $limit = $dataSearch['limit'] ?? 0;
        $status = $dataSearch['status'] ?? 1;
        $user_id = $dataSearch['user_id'] ?? 0;
        $paginate = $dataSearch['paginate'] ?? 20;

        $list = (new Document);

        if (count($this->sc_category)) {
            $tablePCJ = (new \App\Model\DocumentCategoryJoin)->getTable();
            $dataSelect = $this->getTable().'.*';
            $list = $this->selectRaw($dataSelect)->leftJoin($tablePCJ, $tablePCJ . '.post_id', $this->getTable() . '.id');
            $list = $list->whereIn($tablePCJ . '.category_id', $this->sc_category);
        }

        if($user_id)
        {
            $list = $list->where('user_id', $user_id);
        }

        if ($keyword) {
            $list = $list->where(function ($query) use($keyword){
                $query->where('name', 'like', '%' . $keyword . '%');
            });
        }

        if ($sort_order) {
            $field = explode('__', $sort_order)[0];
            $sort_field = explode('__', $sort_order)[1];
            $list = $list->orderBy($field, $sort_field);
        } else {
            $list = $list->orderBy('created_at', 'desc');
        }

        $list = $list->where($this->getTable().'.status', $status);
        if($limit)
            $list = $list->limit($limit)->get();
        else
            $list = $list->paginate($paginate);
        return $list;
    }

    
}
