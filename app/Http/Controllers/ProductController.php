<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Model\ShopType;
use App\Page;
use Illuminate\Http\Request;
use App\ProductCategory as Category;
use App\Product;
use App\ShopProductCategory as ProductCategory;
use App\Http\Filters\ProductFilter;
use Illuminate\Support\Facades\Cookie;
use Carbon\Carbon;
use Session;
class ProductController extends Controller
{   
    use \App\Traits\LocalizeController;
    public $data = [];
    public $sort_default = 'created_at__desc';


    public function allProducts()
    {
        $this->localized();
        // $this->data['categories'] = Category::where('status', 0)->where('parent', 0)->get();
        $page = Page::where('slug', 'san-pham')->first();
        $this->data['page'] = $page;

        $data_search = [
            'element'    => request('element')??'',
            'sort_order'  => request('sort_order')??$this->sort_default,
            'keyword'   => request('keyword')??'',
            'price'   => request('price')??'',
            'level'   => request('level')??'',
            'type'   => request('type')??'',
            'brand'   => request('brand')??'',
            'color'   => request('color')??'',
            'size'   => request('size')??'',
        ];
        
        $cate = request('cate')? explode(',', request('cate')) : [];
        // old chạy dc
        // $this->data['products'] = (new Product)->setCategory($cate)->getList($data_search);
        // new
        $this->data['products'] = (new Product)->setCategory($cate)->limit(16)->get();
        $this->data = array_merge($this->data, [
            'seo_title' => $page->seo_title!=''? $page->seo_title : $page->title,
            'seo_image' => $page->image,
            'seo_description'   => $page->seo_description ?? '',
            'seo_keyword'   => $page->seo_keyword ?? '',
        ]);
        
        return view($this->templatePath .'.product.product-category', ['data' => $this->data]);
    }

    public function categoryDetail($slug, $province='', $district='', ProductFilter $filter){
        $this->localized();
        $category = Category::where('slug', $slug)->first();
        // dd($category);
        if($category){
            $dataSearch = [
                'sort_order'  => request('sort')??$this->sort_default,
                'keyword'   => request('keyword')??'',
                'price'   => request('price')??0,
                'level'   => request('level')??0,
                'type'   => request('type')??'',
                'brand'   => request('brand')??'',
                // 'limit' => 60,
                // 
            ];

            $products_ = (new Product)->setCategory($category->id);

            $products_ = $products_->getList($dataSearch);

            $this->data['category'] = $category;
            $this->data['products'] = $products_;
            $this->data['slug'] = $slug;
            if($category->parent!=0){
                $this->data['categories'] = Category::where('parent', $category->parent)->get();
                $this->data['category_parent'] = Category::find($category->parent);
            }
            else{
                $this->data['category_parent'] = $category;
                $this->data['categories'] = Category::where('parent', $category->id)->get();
            }

            $this->data = array_merge($this->data, [
                'seo_title' => $category->seo_title!=''? $category->seo_title : $category->name,
                'seo_image' => $category->image,
                'seo_description'   => $category->seo_description ?? '',
                'seo_keyword'   => $category->seo_keyword ?? '',
            ]);

            return view($this->templatePath .'.product.product-category', ['data' => $this->data])->compileShortcodes();
        }
        else
            return $this->productDetail($slug);
    }

    public function level($slug){
        $this->localized();
        $level = \App\Model\ShopLevel::where('slug', $slug)->first();

        if($level){
            $dataSearch = [
                'sort_order'  => request('sort')??$this->sort_default,
                'keyword'   => request('keyword')??'',
                'price'   => request('price')??'',
            ];
            $products_ = (new Product)
                    ->getProductToLevel($level->id)
                    ->getList($dataSearch);

            $this->data['level'] = $level;
            $this->data['products'] = $products_;
            $this->data['slug'] = $slug;
            if($level->parent!=0)
                $this->data['levels'] = \App\Model\ShopLevel::where('parent', $level->parent)->get();
            else
                $this->data['levels'] = \App\Model\ShopLevel::where('parent', $level->id)->get();

            $this->data = array_merge($this->data, [
                'seo_title' => $level->seo_title!=''? $level->seo_title : $level->name,
                'seo_image' => $level->image,
                'seo_description'   => $level->seo_description ?? '',
                'seo_keyword'   => $level->seo_keyword ?? '',
            ]);

            return view($this->templatePath .'.product.product-level', $this->data)->compileShortcodes();
        }
        else
            return $this->productDetail($slug);
    }

    public function productDetail($slug){

        $this->localized();

        $product = Product::where('slug', $slug)->first();
        if($product){
            $session_products = session()->get('products.recently_viewed');
            if( !is_array($session_products) ||  array_search($product->id, $session_products) === false){
                session()->push('products.recently_viewed', $product->id);
                $session_products = session()->get('products.recently_viewed');
            }

            // dd($session_products);
            $this->data['product_viewed'] = [];
            if($session_products)
                $this->data['product_viewed'] = Product::whereIn('id', $session_products)->take(10)->get();
            // dd($product_viewed);
            /*$thongke = \App\Model\Thongke::where('theme_id', $product->id)->first();
            if($thongke){
                $thongke->view = ($thongke->view ?? 0) + 1;
                $thongke->click = ($thongke->click ?? 0) + 1;
                $thongke->save();
            }
            else{
                $thongke = \App\Model\Thongke::create([
                    'theme_id' => $product->id,
                    'view' => 1,
                    'click' => 1
                ]);
            }*/
            $category = $product->categories->last();
            $type = $product->types->last();
            $this->data['type'] = $type;

            $this->data['category'] = $category;
            $this->data['product'] = $product;
            
            $brands = $product->brands()->pluck('name');
            if($brands->count())
                $brand = implode(', ', $brands->toArray());
            $this->data['brand'] = $brand ?? null;

            $elements = $product->element()->pluck('slug');

            if($elements->count()){
                $element = implode(', ', $elements->toArray());
                // dd($element);
            }
            $this->data['element'] = $element ?? null;

            /*$related = $category->products()->where('id', '<>', $product->id)->limit(9)->get()->chunk(3);
            $this->data['related'] = $related;*/
/*
            $this->data['related'] = Product::with('getInfo')->whereHas('getInfo', function($query) use($product){
                return $query->where('theme_id', '<>', $product->id);
            })->where('status', 1)->limit(9)->get()->chunk(3);*/

            $this->data['related'] = (new Product)->setCategory($category->id)->getList([
                'limit' => 9,
                'product_id'    => $product->id
            ])->chunk(3);

            $this->data['brc'] = [];
            if($this->data['category']){
                $brc = $this->getCategoryParent($this->data['category']);
                if(count($brc)){
                    $this->data['brc'] = array_reverse($brc);
                }
                array_push($this->data['brc'], ['url' => '' , 'name' => $this->data['product']->name]);
            }

            $this->data = array_merge($this->data, [
                'seo_title' => $product->seo_title!=''? $product->seo_title : $product->name,
                'seo_image' => $product->image,
                'seo_description'   => $product->seo_description ?? '',
                'seo_keyword'   => $product->seo_keyword ?? '',
            ]);
            
            return view($this->templatePath .'.product.product-single', ['data' => $this->data])->compileShortcodes();
        }
        else{
            return view('errors.404');
        }
    }

    public function getCategoryParent($category, $brc=[])
    {   
        $item = ['url' => route('shop.detail', [$category->slug]) , 'name' => $category->name];
        array_push($brc, $item);
        
        if($category->parent){
            $category = Category::find($category->parent);
            $brc = $this->getCategoryParent($category, $brc);
        }
        return $brc;
    }

    public function getBuyNow()
    {
        $data = request()->all();
        $optionPrice = 0;
        $id = $data['product'];
        $product = \App\Product::find($id);
        if (!$product) {
            return response()->json(
                [
                    'error' => 1,
                    'msg' => 'Không tìm thấy sản phẩm',
                ]
            );
        }
        $variables = \App\Variable::where('status', 0)->where('parent', 0)->orderBy('stt','asc')->get();
        // dd($variables);
        $attr = $data['option'] ?? '';
        foreach($variables as $variable){
            if(isset($attr[$variable->id])){
                $form_attr[$variable->id] = $attr[$variable->id];

                $variable_data = explode('__', $attr[$variable->id]);
                if(isset($variable_data[2]))
                    $optionPrice = $variable_data[2];
                elseif(isset($variable_data[1]))
                    $optionPrice = $variable_data[1];
            }
        }
        $price = $optionPrice > 0 ? $optionPrice : $product->getFinalPrice();

        //Check product allow for sale
        
        $option = array(
                'id'      => $id,
                'title'    => $product->title,
                'qty'     => $data['qty'],
                'price'   => $price,
                'options' => $form_attr ?? []
            );
        session()->forget('option');
        session()->push('option', json_encode($option, JSON_UNESCAPED_SLASHES));
        
        return response()->json(
            [
                'error' => 0,
                'msg' => 'Success',
            ]
        );
    }
    public function buyNow($id)
    {
        $product = Product::find($id);
        $option = session()->get('option');
        // dd($option);
        if($option){
            $option = json_decode($option[0], true);
            // dd($option);
            if($option['id'] != $product->id)
                return redirect()->route('shop.detail', $product->slug);
        }
        else
            return redirect()->route('shop.detail', $product->slug);
        if($product){
            $this->data['product'] = $product;
        
            $this->data['seo'] = [
                'seo_title' => 'Mua ngay - '. $product->name,

            ];
            if(session()->has('cart-info')){
                $data = session()->get('cart-info')[0];
                // dd($data);
                $this->data["cart_info"] = $data;
            }
            return view($this->templatePath .'.cart.quick-buy', $this->data);
        }
    }

    public function quickView()
    {
        $id = request()->id;
        if($id){
            $this->localized();

            $product = Product::find($id);
            if($product){
                $session_products = session()->get('products.recently_viewed');

                if( !is_array($session_products) ||  array_search($product->id, $session_products) === false)
                    session()->push('products.recently_viewed', $product->id);

                $this->data['product'] = $product;
                // $this->data['related'] = Product::with('getInfo')->whereHas('getInfo', function($query) use($product){
                //     return $query->where('province_id', $product->getInfo->province_id)->where('theme_id', '<>', $product->id);
                // })->limit(10)->get();
                
                return response()->json([
                    'error' => 0,
                    'msg'   => 'Success',
                    'view'   => view($this->templatePath .'.product.quick-view', ['data'=>$this->data])->compileShortcodes()->render(),
                ]);
                // return view($this->templatePath .'.product.product-single', ['data'=>$this->data])->compileShortcodes();
            }
        }
    }

    public function ajax_categoryDetail($slug)
    {
        $this->localized();
        $category = Category::where('categorySlug', $slug)->first();
        // dd($this->data['category']);
        $lc = $this->data['lc'];
        // dd($category->products);
        $view = view('theme.partials.product-banner-home', compact('category', 'lc'))->render();
        return response()->json($view);
    }

    public function wishlist(Request $request)
    {
        $this->localized();

        $id = $request->id;
        $type = 'save';
        if(auth()->check()){
            $data_db = array(
                'product_id' => $id,
                'user_id' => auth()->user()->id,
            );

            $db = \App\Model\Wishlist::where('product_id', $id)->where('user_id', auth()->user()->id)->first();
            if($db != ''){
                $db->delete();
                $type = 'remove';
            }
            else
                \App\Model\Wishlist::create($data_db)->save();

            $count_wishlist = \App\Model\Wishlist::where('user_id', auth()->user()->id)->count();
            $this->data['count_wishlist'] = $count_wishlist;
            $this->data['status'] = 'success';
        }
        else{
            $wishlist = json_decode(\Cookie::get('wishlist'));
            $key = false;
            

            if($wishlist != '')
                $key = array_search( $id, $wishlist);
            if($key !== false){
                unset($wishlist[$key]);
                $type = 'remove';
            }
            else{
                $wishlist[] = $id;
            }
            $this->data['count_wishlist'] = count($wishlist);
            $this->data['status'] = 'success';
            $cookie = Cookie::queue('wishlist', json_encode($wishlist), 1000000000);
        }
        $this->data['type'] = $type;
        // $this->data['view'] = view('theme.product.includes.wishlist-icon', ['type'=>$type, 'id'=>$id])->render();
        
        return response()->json($this->data);
    }

    public function ajax_get_categories($slug)
    {
        $this->localized();
        if($slug == 'du-an')
        {
            $this->data['type'] = 'project';
            $projects = \App\Model\Project::where('status', 0)->limit(20)->get();
            $this->data['view'] = view('theme.product.includes.category-dropdown', compact('projects'))->render();
        }
        else
        {
            $this->data['type'] = 'category';
            $category_parent = Category::where('categorySlug', $slug)->first();
            $categories = Category::where('categoryParent', $category_parent->categoryID)->get();
            $this->data['view'] = view('theme.product.includes.category-dropdown', compact('categories'))->render();
        }
        
        return response()->json($this->data);
    }

    public function ajaxFilter()
    {
        $data = request()->all();
        $data = array_filter($data);

        $dataSearch['sort_order'] = $data['sort']??'';
        $dataSearch['type'] = $data['type']??'';
        $variable_item = [];
        foreach($data as $key => $item)
        {
            $variable = \App\ShopVariable::where('slug', $key)->first();
            if($variable)
            {
                $dataSearch[$key] = $item;
            }
        }
        // $dataSearch['variable'] = $variable_item??[];
        // dd($dataSearch);

        $products = (new Product);

        $category = (new Category)->getDetail($data['category']??0);
        $page = Page::where('slug', 'san-pham')->first();
        if($category)
        {
            $url = route('shop.detail', array_merge(['slug' => $category->slug], $data));
            $products = $products->setCategory($category->id);
        }
        else
        {
            $url = route('shop', $data);
        }
        $products = $products->getList($dataSearch);

        // dd($dataSearch);
        
        $view = view($this->templatePath .'.product.includes.product-list', [
            'products'  => $products,
            'category'  => $category,
            'page'  => $page,
        ])->render();
        $data_map = collect($data)->map(function($index, $key){
            // return "$key=$index";
            return $index;
        });

        return response()->json([
            'error' => 0,
            'view'  => $view,
            'url'  => $url??'',
            'message'   => "Success"
        ]);
    }


    /*==================attr select=====================*/
    public function changeAttr()
    {
        $data = request()->all();
        
        $product = Product::find($data['product']);
        if($product)
        {
            $attr_items = \App\Model\ShopProductItem::where('product_id', $product->id)->get();

            $options = null;
            foreach($attr_items as $item)
            {
                $item_features = \App\Model\ShopProductItemFeature::where('product_item_id', $item->id)->get();
                $item_features_test = \App\Model\ShopProductItemFeature::where('product_item_id', $item->id)->whereIn('value', $data['attrs'])->get();
                if(count($data['attrs']) == $item_features->count())
                {
                    if(count($data['attrs']) == $item_features_test->count())
                    {
                        $options = $item;
                        $product_item_id = $item->id;
                        $product_item_sku = $item->sku;
                        $attr_stock = $item->quantity;
                        /*if($item->gallery != '')
                        {
                            $gallery = json_decode($item->gallery, true);
                            $gallery_view = view($this->templatePath .'.product.product-gallery', ['gallery' => $gallery??''])->render();
                        }*/
                    }
                }

                
                if(count($data['attrs']) == $item_features_test->count())
                {
                    if($item->gallery != '')
                    {
                        $gallery = json_decode($item->gallery, true);
                        $gallery_view = view($this->templatePath .'.product.product-gallery', ['gallery' => $gallery??''])->render();
                    }
                }
            }

            // dd($data, $attr_items->toArray(), $options);

            return response()->json(
                [
                    'error' => 0,
                    'product_item_sku' => $product_item_sku??'',
                    'product_item_id' => $product_item_id??0,
                    'attr_stock' => $attr_stock??0,
                    'gallery' => $gallery_view??'',
                    'show_price' => $product->showPriceDetail($options)->render(),
                    'view'  => view($this->templatePath .'.product.render-attr', [ 
                        'product_item_id' => $product_item_id??0,
                        'product' => $product, 
                        'attr_items' => $attr_items, 
                        'attrs_selected' => $data['attrs'] ])
                    ->render(),
                    'msg'   => 'Success'
                ]
            );
        }
    }

    public function changeAttrColor() // change in list product
    {
        $data = request()->all();
        $product_id = $data['product_id']??0;
        $color = $data['color']??'';
        if($color != '')
        {
            $product = Product::find($product_id);
            if($product)
            {
                $view_render_size = $product->renderSize($color)->render();

                return response()->json([
                    'error' => 0,
                    'view'  => $view_render_size,
                    'message'   => "Success"
                ]);
            }
        }

        return response()->json([
            'error' => 1,
            'view'  => '',
            'message'   => "Error"
        ]);
    }
    /*==================end attr select=====================*/
    public function loadMore()
    {
        $products = Product::with('categories')->paginate(16);
        return $products;
    }
    public function show(Request $request)
    {
        $id = $request->productId;

     

        $category_id = 1; // ID của danh mục cụ thể bạn muốn lấy sản phẩm

        $category = Category::findOrFail($id);
        
        $products = $category->products;
        
        


 
        return $products;
    }


    public function showcategoryhome(Request $request)
    {
        $id = $request->productId;

     

        $category_id = 1; // ID của danh mục cụ thể bạn muốn lấy sản phẩm

        $category = Category::findOrFail($id);
        
        $products = $category->products->take(8);
        
        


 
        return $products;
    }
}
