<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Page;
use App\News;
use App\Product;
use Carbon\Carbon;

class SearchController extends Controller
{
     use \App\Traits\LocalizeController;
    public $data = [];

    public function index(Request $rq){
        $this->localized();
        $keyword = $rq->input('keyword', '');

        $this->data['categories_list'] = \App\ProductCategory::where('status', 1)->where('parent', 0)->orderby('priority')->limit(10)->get();

        $this->data['result'] = true;
        $this->data['keyword'] = $keyword;
        $category = request()->category??'';
        $price = request()->price??'';
        $dataSearch = [
            'sort_order'  => request('sort')??'',
            'keyword'   => $keyword,
            'price'   => $price??0
        ];
        if($category !='' || $keyword == '')
        {
            $products = (new Product)
                ->setCategory($category)
                ->getList($dataSearch);
        }
        else
        {
            $products = (new Product)->search($keyword);
        }

        $this->data['products'] = $products;
        $this->data['page'] = [];

        $this->data['seo'] = [
            'seo_title' => __('Search'),
            'seo_image' => '',
            'seo_description'   => '',
            'seo_keyword'   => '',

        ];

        return view($this->templatePath .'.product.search', ['data' => $this->data]);
    }

    public function ajaxSearch()
    {
        $keyword = trim(request('keyword')??'');
        if($keyword != '')
        {
            $products = (new Product)->search($keyword);
            // dd($products);

            $view = view($this->templatePath.'.product.search-ajax', compact('products', 'keyword'))->render();

            return response()->json([
                'error' => 0,
                'view'  => $view,
                'message'   => 'Success'
            ]);
        }
        return;
    }
}
