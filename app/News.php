<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = 'post';
    protected $primaryKey = 'id';

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
    
    public function category(){
        return $this->belongsToMany('App\NewsCategory', 'post_category_join', 'post_id', 'category_id');
    }

    public static function search(string $keyword){
        $keyword = '%' . addslashes($keyword) . '%';
        $result = self::select('id', 'title', 'slug', 'description')
            ->where('title', 'like', $keyword)->paginate(12);
        return $result;
    }
    
    public function getTitleAttribute($value){
        $lc = app()->getLocale();
        if('vi' == $lc){
            return $value;
        } else {
            return $this->{'title_' . $lc};
        }
    }
    
    public function getDescriptionAttribute($value){
        $lc = app()->getLocale();
        if('vi' == $lc){
            return $value;
        } else {
            return $this->{'description_' . $lc};
        }
    }
    
    public function getContentAttribute($value){
        $lc = app()->getLocale();
        if('vi' == $lc){
            return $value;
        } else {
            return $this->{'content_' . $lc};
        }
    }

    public function getList(array $dataSearch, $count = false)
    {
        $keyword = $dataSearch['keyword'] ?? '';

        $sort_order = $dataSearch['sort_order'] ?? '';

        $limit = $dataSearch['limit']??0;

        $news_id = $dataSearch['news_id']??0;

        $hot = $dataSearch['hot']??0;

        \DB::enableQueryLog(); // Enable query log
        $list = (new News);
        if (count($this->sc_category)) {
            $tablePTC = (new \App\Model\PostCategoryJoin)->getTable();
            $list = $list->leftJoin($tablePTC, $tablePTC . '.post_id', $this->getTable() . '.id');
            $list = $list->whereIn($tablePTC . '.category_id', $this->sc_category)->groupBy($tablePTC . '.post_id');
        }

        if ($keyword) {

            $list = $list
                ->whereRaw(
                "MATCH(name) AGAINST(?)",
                array($keyword)
            );
            
        }
        if ($news_id) {
            $list = $list->where('id', '<>', $news_id);
        }
        if ($hot) {
            $list = $list->where('hot', 1);
        }

        if ($sort_order) 
        {
            $field = explode('__', $sort_order)[0];
            $sort_field = explode('__', $sort_order)[1];
            $list = $list->orderBy($field, $sort_field);
        }
        else
        {
            $list = $list->orderByDesc('created_at');
        }

        $list = $list->where('status', 1);

        
        if($limit)
            $list = $list->limit($limit)->get();
        else
            $list = $list->paginate(20);

        return $list;
    }

    public function getDetail($id, $type='')
    {
        $detail = new News;
        if($type == 'slug')
            $detail = $detail->where('slug', $id);
        else
            $detail = $detail->where('id', $id);

        $detail = $detail->first();
        return $detail;
    }
}
