<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\ShopProduct, App\Model\Category_Theme, App\Model\Join_Category_Theme, App\Model\Theme_variable_sku, App\Model\Theme_variable_sku_value, App\Model\ThemeVariable;
use Illuminate\Support\Facades\Hash;
use App\Libraries\Helpers;
use Illuminate\Support\Str;
use Auth, DB, File, Image, Config;
use Illuminate\Pagination\Paginator;

use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Jobs\ProcessImportData;
use App\Exports\ProductExport;

class ProductController extends Controller
{
    public $title_head = 'Sản phẩm';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function listProduct(){
            $db = ShopProduct::select('*');

           
            if(request('category_id')){
                $db = $db->join('shop_product_category as pc', 'pc.product_id', 'shop_products.id')->where('category_id', request('category_id'));
            }

            if(request('type_id')){
                $db = $db->join('shop_product_type as pt', 'pt.product_id', 'shop_products.id')->where('type_id', request('type_id'));
            }

            if(request('search_title') != ''){
                $search_title = request('search_title');
                $db = $db->where(function($query) use($search_title){
                    return $query->where('name', 'like', '%' . $search_title . '%')
                        ->orWhere('sku', 'like', '%' . $search_title . '%');
                });
            }
            

            $products = $db->orderByDesc('created_at')->paginate(20);

            $count_item = ShopProduct::get()->count();

            $data = [
                'title_head'    => $this->title_head,
                'products'  => $products,
                'total_item'  => $count_item
            ];
        return view('admin.product.index', $data);
    }

    
    public function createProduct(){
        $data['variables_selected'] = [];
        $data['listUnit'] = $this->listUnit();
        return view('admin.product.single', $data);
    }

    public function productDetail($id){
        $product = ShopProduct::find($id);
        $data['listUnit'] = $this->listUnit();

        $data['product_detail'] = $product;

        $data['attrs'] = $product->getAttr->keyBy('name')->toArray();
        // dd($attrs);

        /*$newStudents = $attrs->map(function($attr, $key){
            $data[$attr->name] = [
                'name' => $attr->name,
                'content' => $attr->content
            ];
            return $data;
        });*/

        // dd($newStudents);
        if($data['product_detail'])
        {
            return view('admin.product.single', $data);
        } 
        else
        {
            return view('404');
        }
    }


    public function postProductDetail(Request $rq){
        $datetime_now = date('Y-m-d H:i:s');
        $datetime_convert = strtotime($datetime_now);

        $data = request()->all();

        //id post
        $sid = $rq->id ?? 0;


        $data['slug'] = addslashes($rq->slug);
        if($data['slug'] == '')
           $data['slug'] = Str::slug($data['name']);

        $data['price'] = $rq->price ? str_replace(',', '', $rq->price) : 0;
        $data['promotion'] = $rq->promotion ? str_replace(',', '', $rq->promotion) : 0;

        $data['description'] = $rq->description ? htmlspecialchars($rq->description) : '' ;
        $data['content'] = $rq->content ? htmlspecialchars($rq->content) : '' ;
        $data['body'] = $rq->body ? htmlspecialchars($rq->body) : '' ;

        //lang
        $tab_langs = $rq->tab_lang ?? '';
        if(is_array($tab_langs)){
            foreach ($tab_langs as $key => $lang) {
                $title_lang = 'name_'. $lang;
                $description = 'description_'. $lang;
                $content = 'content_'. $lang;

                $data['description_'. $lang] = $rq->$title_lang ? $rq->$title_lang : '' ;
                $data['description_'. $lang] = $rq->$description ? htmlspecialchars($rq->$description) : '' ;
                $data['content_'. $lang] = $rq->$content ? htmlspecialchars($rq->$content) : '' ;
            }
        }
        
        //xử lý gallery
        $galleries = $rq->gallery ?? '';
        if($galleries!=''){
            $galleries = array_filter($galleries);
            $data['gallery'] = $galleries ? serialize($galleries) : '';

        }
        //end xử lý gallery

        $data['sort'] = $rq->stt ? addslashes($rq->stt) : 0;
        $data['hot'] = $rq->hot ?? 0;
        $data['trend'] = $rq->trend ?? 0;
        $data['admin_id'] = Auth::guard('admin')->user()->id;


        $save = $rq->submit ?? 'apply';

        if($sid > 0){
            $post_id = $sid;
            \App\Model\ShopProductCategory::where('product_id', $sid)->delete();
            $respons = ShopProduct::find($sid)->update($data);
        } else{
            $respons = ShopProduct::create($data);
            $id_insert = $respons->id;
            $post_id = $id_insert;
        }

        $category_items = $rq->category_item ?? '' ;
        if($category_items!=''){
            \App\Model\ShopProductCategory::where('product_id', $post_id)->delete();
            foreach ($category_items as $key => $item) {
                if($item>0){
                    $datas_item = array(
                        "category_id" => $item,
                        "product_id" => $post_id
                    );
                    \App\Model\ShopProductCategory::create($datas_item);
                }
            }
        }

        $brand_items = $rq->brand_item ?? '' ;
        \App\Model\ShopProductBrand::where('product_id', $post_id)->delete();
        if($brand_items!=''){
            foreach ($brand_items as $key => $item) {
                if($item>0){
                    $datas_item = array(
                        "brand_id" => $item,
                        "product_id" => $post_id
                    );
                    \App\Model\ShopProductBrand::create($datas_item);
                }
            }
        }
        //element
        $element_items = $rq->element_item ?? '' ;
        \App\Model\ShopProductElement::where('product_id', $post_id)->delete();
        if($element_items!=''){

            foreach ($element_items as $key => $item) {
                if($item>0){
                    $datas_item = array(
                        "element_id" => $item,
                        "product_id" => $post_id
                    );
                    \App\Model\ShopProductElement::create($datas_item);
                }
            }
        }
        //level
        $level_items = $rq->level_item ?? '' ;
        \App\Model\ShopProductLevel::where('product_id', $post_id)->delete();
        if($level_items!=''){

            foreach ($level_items as $key => $item) {
                if($item>0){
                    $datas_item = array(
                        "level_id" => $item,
                        "product_id" => $post_id
                    );
                    \App\Model\ShopProductLevel::create($datas_item);
                }
            }
        }
        //type
        $level_items = $rq->type_item ?? '' ;
        \App\Model\ShopProductType::where('product_id', $post_id)->delete();
        if($level_items!='')
        {
            foreach ($level_items as $key => $item) 
            {
                if($item>0){
                    $datas_item = array(
                        "type_id" => $item,
                        "product_id" => $post_id
                    );
                    \App\Model\ShopProductType::create($datas_item);
                }
            }
        }

        //variable
        
        $features_old = \App\Model\ShopProductItem::where('product_id', $post_id)->select()->pluck('id');
        \App\Model\ShopProductItemFeature::whereIn('product_item_id', $features_old)->delete();
        \App\Model\ShopProductItem::where('product_id', $post_id)->delete();
        if(!empty($data['feature']))
        {
            $features = array_filter($data['feature']);
            foreach($features as $key => $feature)
            {
                // dd($data['gallery_attr']);
                $gallery_attr = '';
                if(!empty($data['gallery_attr'][$key]))
                {
                    $gallery_attr = json_encode($data['gallery_attr'][$key]);
                }

                $product_item = \App\Model\ShopProductItem::create([
                    'product_id'    => $post_id,
                    'price'    => $data['feature_price'][$key]??0,
                    'promotion'    => $data['feature_promotion'][$key]??0,
                    'sku'    => $data['feature_sku'][$key]??0,
                    'quantity'    => $data['feature_quantity'][$key]??0,
                    'gallery'    => $gallery_attr??''
                ]);
                if($product_item)
                {
                    $feature = array_filter($feature);
                    // dd($feature);

                    foreach($feature as $index => $value)
                    {
                        if(!empty($data['feature_select'][$key][$index]))
                        {
                            $feature_select = $data['feature_select'][$key][$index];
                            $feature_select_data = \App\Model\ShopVariable::where('name', $feature_select)->first();

                            $value_arr = explode('__', $value);

                            $feature = \App\Model\ShopProductItemFeature::create([
                                'feature'    => $feature_select??'',
                                'value'    => $value_arr[0],
                                'color'    => $value_arr[1]??'',
                                'product_item_id'    => $product_item->id,
                                'variable_id'    => $feature_select_data->id??0
                            ]);
                        }
                    }
                }
            }
        }

        // shop product attr
        $attrs = $data['attrs'];
        // dd($attrs);
        if(!empty($attrs))
        {
            $i = 0;
            foreach($attrs['name'] as $index => $item)
            {
                $attr_content = $attrs['content'][$index]??'';
                $attr_title = $attrs['title'][$index]??'';
                if($attr_content != '')
                {
                    $option_db = \App\Model\ShopProductAttr::updateOrCreate(
                        [
                            'name'  => $item,
                            'product_id'  => $post_id
                        ],
                        [
                            'content'   => $attr_content,
                            'title'   => $attr_title,
                            'sort'   => $i,
                        ]
                    );
                    $list_option[] = $option_db->id;
                    $i++;
                }
            }
        }

        // shop product attr

        if($save=='apply'){
            $msg = "Product has been Updated";
            $url = route('admin.productDetail', array($post_id));
            Helpers::msg_move_page($msg, $url);
        }
        else{
            return redirect(route('admin.listProduct'));
        }
        
    }

    public function updateStock()
    {
        $data = request()->all();
        if(!empty($data['id']))
        {
            ShopProduct::find($data['id'])->update(['stock' => $data['stock']]);
            return response()->json([
                'error' => 0,
                'message'   => 'Cập nhật kho thành công'
            ]);
        }
        return response()->json([
            'error' => 1,
            'message'   => 'Không tìm thấy sản phẩm'
        ]);
    }

    public function updateStatus()
    {
        $data = request()->all();
        if(!empty($data['id']))
        {
            $status = $data['status']??0;
            ShopProduct::find($data['id'])->update(['status' => $status]);
            return response()->json([
                'error' => 0,
                'message'   => 'Cập nhật trạng thái thành công'
            ]);
        }
        return response()->json([
            'error' => 1,
            'message'   => 'Không tìm thấy sản phẩm'
        ]);
    }

    public function listUnit()
    {
        return [
            'hộp',
            'vỉ',
        ];
    }

    public function import()
    {
        return view('admin.product.import');
    }
    public function importProcess()
    {
        if (request()->hasFile('file_input')) {
            $file = request()->file('file_input');
            $name = "excel-" . time() . '-' . $file->getClientOriginalName();
            $name = str_replace(' ', '-', $name);
            $url_folder_upload = "/excel-file/";
            $url_full_path = $url_folder_upload . $name;
            $file->move(public_path() . $url_folder_upload, $name);

            $importJob = new ProcessImportData( '/public/'.$url_folder_upload .$name );
            $importJob->delay(\Carbon\Carbon::now()->addSeconds(3));
            dispatch($importJob);
            return view('admin.product.import', ['success'=> 'File Excel của bạn sẽ được hoàn tất sau 2 phút!']);
        }
    }

    public function export(){
        $db = ShopProduct::select('*');

        if(request('category_id')){
            $db = $db->join('shop_product_category as pc', 'pc.product_id', 'shop_products.id')->where('category_id', request('category_id'));
        }

        if(request('search_title') != ''){
            $db->where('name', 'like', '%' . request('search_title') . '%');
        }

        $data_product = $db->orderByDesc('id')->get();
        // dd($data_product);

        foreach($data_product as $key => $product)
        {
            $categories = $product->categories()->pluck('name')->toArray();
            // dd($categories);
            $categories = implode(', ', $categories);

            $arr[] = [
                'ID' => $product->id,
                'Title' => $product->name,
                'Category' => $categories,
                'Price_Origin' => $product->price,
                'Price_Promotion' => $product->promotion,
                'SKU' => $product->sku,
                'Stock' => $product->stock,
                'Created_at' => $product->created_at
            ];
        }

        return (new ProductExport($arr))->download('product.xlsx');
    }
}









