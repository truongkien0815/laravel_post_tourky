<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Filters\Filterable;
use App\Libraries\Helpers;
use App\Model\Variable;
use App\Model\ThemeVariable;
use App\ShopProductCategory;
use App\Model\ShopProductLevel;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Input;
use DB;
// use Elasticquent\ElasticquentTrait;

//review 
use App\Plugins\Cms\ProductReview\Models\PluginModel;

class Product extends Model
{
    
    use Filterable;

    protected $table = 'shop_products';
    protected $primaryKey = 'id';

    protected  $sc_category = []; // array category id
    protected  $sc_level = []; // array level id

    public static function search(string $keyword){
        $orderby=" ORDER BY A.updated_at DESC ";

        $keyword = addslashes($keyword);
        $keyword_array = "";

        if(strpos($keyword," ") || strpos($keyword,"　"))
            $keyword_array = explode(" ",$keyword);

        $where_query = [];
        if(is_array($keyword_array) && count($keyword_array)>1)
        {
            foreach($keyword_array as $item)
            {
                $where_query[] = "name like '%". $item ."%'";
            }
            $where_query = implode(' and ', $where_query);

            $posts = Product::where(function($query) use($where_query, $keyword){
                return $query->whereRaw($where_query)->orWhere('sku', $keyword);
            })->where('status', 1)->orderByDesc('created_at')->paginate(20);
        }
        else
        {
            $posts = Product::selectRaw("*, MATCH(name) AGAINST('$keyword') as name_search")
            ->whereRaw(
                "MATCH(name) AGAINST(?) ", 
                $keyword
            )
            ->orWhere('sku', $keyword)
            ->where('status', 1)
            ->orderByDesc('name_search')
            ->paginate(20);
        }

        return $posts;
    }

    public function arrayPaginator($array, $request)
    {
        $page = Input::get('page', 1);
        $perPage = config(20);
        $offset = ($page * $perPage) - $perPage;

        return new LengthAwarePaginator(array_slice($array, $offset, $perPage, true), count($array), $perPage, $page,
            ['path' => $request->url(), 'query' => $request->query()]);
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

    /**
     * Get product to array level
     * @param   [array|int]  $arrLevel
     */
    public function getProductToLevel($arrLevel) {
        $this->setLevel($arrLevel);
        return $this;
    }
    /**
     * Set array level 
     *
     * @param   [array|int]  $level 
     *
     */
    private function setLevel($level) {
        if (is_array($level)) {
            $this->sc_level = $level;
        } else {
            $this->sc_level = array((int)$level);
        }
        return $this;
    }

    public function getList(array $dataSearch, $count = false)
    {
        $keyword = $dataSearch['keyword'] ?? '';

        $sort_order = $dataSearch['sort_order'] ?? '';

        $limit = $dataSearch['limit']??0;
        $price = $dataSearch['price']??'';

        $type = $dataSearch['type']??'';
        $brand = $dataSearch['brand']??0;
        $product_id = $dataSearch['product_id']??0;

        $hot = $dataSearch['hot']??0;
        $color = $dataSearch['color']??'';
        $size = $dataSearch['size']??'';
        $promotion = $dataSearch['promotion']??0;

        \DB::enableQueryLog(); // Enable query log
        $list = (new Product);
        if (count($this->sc_category)) {
            $tablePTC = (new ShopProductCategory)->getTable();
            $list = $list->leftJoin($tablePTC, $tablePTC . '.product_id', $this->getTable() . '.id');
            $list = $list->whereIn($tablePTC . '.category_id', $this->sc_category)->groupBy($tablePTC . '.product_id');
        }

        if ($type != '') {
            $type_array = explode(',', $type);
            $tableType = (new \App\Model\ShopProductType)->getTable();
            $list = $list->leftJoin($tableType, $tableType . '.product_id', $this->getTable() . '.id');
            $list = $list->whereIn($tableType . '.type_id', $type_array)->groupBy($tableType . '.product_id');
        }
        if ($brand) {
            $brand_array = explode(',', $brand);
            $tableBrand = (new \App\Model\ShopProductBrand)->getTable();
            $list = $list->leftJoin($tableBrand, $tableBrand . '.product_id', $this->getTable() . '.id');
            $list = $list->whereIn($tableBrand . '.brand_id', $brand_array)->groupBy($tableBrand . '.product_id');
        }

        if($color != '' || $size != '')
        {
            $variable_arr = array_filter([$color, $size]);

            $variable_items = new \App\Model\ShopProductItemFeature;
            $variable_items = $variable_items->whereIn('value', $variable_arr);
            $variable_items = $variable_items->get()->pluck('product_item_id')->toArray();

            $product_ids = \App\Model\ShopProductItem::whereIn('id', $variable_items)->groupBy('product_id')->get()->pluck('product_id');
            if($product_ids->count())
            {
                $product_ids = $product_ids->toArray();
                $list = $list->whereIn($this->getTable() . '.id', $product_ids);
            }
        }

        if ($keyword) {
            $list = $list->whereRaw("MATCH(name) AGAINST(?)", array($keyword));
        }
        if ($product_id) {
            $list = $list->where('id', '<>', $product_id);
        }
        if ($hot) {
            $list = $list->where('hot', 1);
        }
        if($promotion)
        {
            $list = $list->where('promotion', '>', 0);
        }
        if ( !empty ( $price ) ){
            if($price == 'sale')
            {
                $list = $list->where('promotion', '!=', 0);
            }
            else
            {
                $price = explode('-', $price);
                $price_first = $price[0]??0;
                $price_last = $price[1]??0;
                
                if($price_first && $price_last)
                {
                    $list = $list->whereBetween('price', [$price_first, $price_last]);
                }
                elseif($price_first && !$price_last)
                {
                    $list = $list->where('price', '>', $price_first);
                }
                elseif(!$price_first && $price_last)
                {
                    $list = $list->where('price', '<', $price_last);
                }
            }
        }
        if ($sort_order) 
        {
            $field = explode('__', $sort_order)[0];
            $sort_field = explode('__', $sort_order)[1];
            $list = $list->orderBy($field, $sort_field);
        }
        else
        {
            $list = $list->orderByDesc('id');
        }

        $list = $list->where('status', 1);

        if($count)
            $list = $list->get()->count();
        else
        {
            if($limit)
                $list = $list->limit($limit)->get();
            else
                $list = $list->paginate(20);
        }

        return $list;
    }

    public function getFinalPrice()
    {
        if($this->promotion > 0)
            return $this->promotion;
        return $this->price;
    }

    public function showPrice()
    {
        $priceFinal = $this->promotion ?? 0;
        $price = $this->price ?? 0;
        return view( env('APP_THEME', 'theme') .'.product.includes.showPrice',[
            'priceFinal' => $priceFinal,
            'price' => $price,
        ]);
    }
    public function showPriceDetail($options = null)
    {
        $priceFinal = $this->promotion ?? 0;
        $price = $this->price ?? 0;
        if($options != null)
        {
            $price = $options->price??0;
            $priceFinal = $options->promotion??0;
            /*$attr_items = \App\Model\ShopProductItem::where('product_id', $this->id)->get();
            // $item_features_selecteds = \App\Model\ShopProductItemFeature::whereIn('product_item_id', $attr_items)->whereIn('value', $options)->get()->toArray();
            foreach($attr_items as $item)
            {
                $item_features = \App\Model\ShopProductItemFeature::where('product_item_id', $item->id)->get();
                if(count($options) == $item_features->count())
                {
                    $item_features_test = \App\Model\ShopProductItemFeature::where('product_item_id', $item->id)->whereIn('value', $options)->get();
                    if(count($options) == $item_features_test->count())
                    {
                        $price = $item->price??0;
                        $priceFinal = $item->promotion??0;
                    }
                }
            }*/
        }
        else
        {
            /*$variables_item = $this->getVariables->first();
            if($variables_item){
                $price = $variables_item->price;
                $priceFinal = $variables_item->promotion;
            }*/
        }

        return view( env('APP_THEME', 'theme') .'.product.includes.showPriceDetail',[
            'priceFinal' => $priceFinal,
            'price' => $price,
            'unit' => $this->unit,
        ]);
    }

    /*
    *Format price
    */
    public function getPrice()
    {
        return $this->price;
    }

    /*
    *gallery
    */
    public function getGallery(){
        if($this->gallery!='')
            return unserialize($this->gallery);
        return [];
    }
    public function countGallery(){
        if($this->gallery!='')
            return count(unserialize($this->gallery));
        return 0;
    }

    public function attrs()
    {
        return $this->hasMany('\App\Model\ShopProductAttr', 'product_id', 'id');
    }

    public function wishlist()
    {
        if(auth()->check()){
            $db = \App\Model\Wishlist::where('product_id', $this->id)->where('user_id', auth()->user()->id)->first();
            if($db!='')
                return true;
        }
        else{
            $wishlist = json_decode(\Cookie::get('wishlist'));
            // dd($wishlist);
            $key = false;
            if($wishlist!='' && count($wishlist)>0)
                $key = array_search( $this->id, $wishlist);

            if($key !== false)
                return true;
        }
        return false;
    }

    public function getWishList()
    {
        return $this->hasMany('App\Model\Wishlist', 'product_id', 'id');
    }

    /*user detail*/
    public function getUser()
    {
        return $this->hasOne(\App\User::class, 'id', 'user_id');
    }
    /*theme info*/
    public function getInfo()
    {
        return $this->hasOne(\App\Model\ThemeInfo::class, 'theme_id', 'id');
    }

    public function getThongke()
    {
        return $this->hasOne('App\Model\Thongke', 'theme_id', 'id');
    }

    public function getPackage()
    {
        return $this->hasOne('App\Model\Package', 'id', 'package_id');
    }
    public function types(){
        return $this->belongsToMany('App\Model\ShopType', 'shop_product_type', 'product_id', 'type_id');
    }
    public function categories(){
        return $this->belongsToMany('App\ProductCategory', 'shop_product_category', 'product_id', 'category_id');
    }
    public function brands(){
        return $this->belongsToMany('App\Brand', 'shop_product_brand', 'product_id', 'brand_id');
    }
    public function element(){
        return $this->belongsToMany('App\Model\ShopElement', 'shop_product_element', 'product_id', 'element_id');
    }

     public function getAllVariable()
    {
        return $this->belongsToMany('App\Variable', 'theme_variable', 'theme_id', 'variable_id');
    }
    public function getVariable($variable_parent)
    {
        return $this->hasMany('App\Model\ThemeVariable', 'theme_id', 'id')->where('variable_parent', $variable_parent)->groupBy('variable_id')->orderBy('price')->get();
    }
    public function getVariables()
    {
        return $this->hasMany('App\Model\ThemeVariable', 'theme_id', 'id')->where('parent', 0)->orderBy('price');
    }

    public function FlashSale()
    {
        $now = date('Y-m-d H:i');
        $list = (new Product)->where('status', 1)->where('promotion', '>', 0)->where('date_start', '<', $now)->where('date_end' , '>', $now)->get();
        return $list;
    }

    public function getShopProductItems()
    {
        return $this->hasMany(\App\Model\ShopProductItem::class, 'product_id', 'id');
    }

    public function product_variables()
    {
        // $attr_items = \App\Model\ShopProductItem::where('product_id', $this->id)->get();
        // $attr_items = $this->getShopProductItems;
        return view( env('APP_THEME', 'theme') .'.product.render-attr',[
            'attr_items' => $this->getShopProductItems
        ]);
    }

    //color and render
    public function getColor()
    {
        $attrs = $this->getShopProductItems->pluck('id')->toArray();
        if($attrs)
        {
            $variable_color = \App\Model\ShopVariable::where('input_type', 'color')->first();
            $attr_items = \App\Model\ShopProductItemFeature::whereIn('product_item_id', $attrs)
                        ->where('color', '<>', '')
                        ->where('variable_id', $variable_color->id)
                        ->orderByDesc('created_at')
                        ->groupBy('color')
                        ->get();

            return $attr_items;
        }
        return [];
    }

    public function renderColor()
    {
        $attr_items = $this->getColor();
        if($attr_items)
        {
            return view( env('APP_THEME', 'theme') .'.product.render-color',[
                'attr_items' => $attr_items,
                'product_id' => $this->id,
            ]);
        }
        return;
    }
    //color

    // size and render
    public function getSize($color = '')
    {
        $attrs = $this->getShopProductItems->pluck('id')->toArray();
        if($attrs)
        {
            if($color != '')
            {
                $item_availables = \App\Model\ShopProductItemFeature::whereIn('product_item_id', $attrs)->where('value', $color)->get()->pluck('product_item_id')->toArray();
            }

            $variable_size = \App\Model\ShopVariable::where('input_type', 'size')->first();
            $attr_items = \App\Model\ShopProductItemFeature::whereIn('product_item_id', $attrs)->where('variable_id', $variable_size->id);

            if(!empty($item_availables) && count($item_availables))
                $attr_items = $attr_items->whereIn('product_item_id', $item_availables)->orderByDesc('created_at');

            $attr_items = $attr_items->get();

            // dd($attr_items);

            return $attr_items;
        }
        return [];
    }

    public function renderSize($color = '')
    {
        $attr_items = $this->getSize($color);
        if($attr_items)
        {
            return view( env('APP_THEME', 'theme') .'.product.render-sizes',[
                'attr_items' => $attr_items,
                'product_id' => $this->id,
            ]);
        }
    }
    // size

    // review
    public function review(){
        return $this->hasMany(PluginModel::class, 'product_id', 'id');
    }
    
    public function getRating()
    {
        if($this->review->count()){
            $round_star = round($this->review->sum('point') / $this->review->count()); //làm tròn số sao

            return view(env('APP_THEME', 'theme') .'.product-review.show_rating', 
                [
                    'point'         => $round_star,
                    'rating_count'  => $this->review->count()
                ]
            )->render();
        }
    }
    // review

    public function checkStock()
    {
        /*$attr_items = \App\Model\ShopProductItem::where('product_id', $this->id)->get()->pluck('id');
        $group_attrs = \App\Model\ShopProductItemFeature::whereIn('product_item_id', $attr_items)->groupBy('variable_id')->get();*/
        // dd($attr_items);
        $attr_items = \App\Model\ShopProductItem::where('product_id', $this->id)->get();
        if($attr_items->count())
        {
            return true;
        }
        elseif($this->stock)
        {
            return true;
        }
        return false;
    }
}
