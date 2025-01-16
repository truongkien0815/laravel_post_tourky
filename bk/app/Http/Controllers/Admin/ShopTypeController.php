<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\ShopType;
use Illuminate\Support\Facades\Hash;
use App\Libraries\Helpers;
use Illuminate\Support\Str;
use DB, File, Image, Config;
use Illuminate\Pagination\Paginator;

class ShopTypeController extends Controller
{
    public $data = [];
    public $admin_path = 'admin.shop-type';
    public $title_head;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->title_head = __('Loại sản phẩm');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index(){
        $db = (new ShopType)->where('parent', 0);

        if(request()->has('search_title') && request()->search_title != ''){
            $search_title = request('search_title');
            $db->where('name', 'like', '%'. $search_title .'%');
        }

        $posts = $db->orderByDesc('id')->paginate(20);

        $dataReponse = [
            'posts'  => $posts,
            'title_head'  => $this->title_head,
            'url_action'  => route('admin_type.create'),
        ];

        return view($this->admin_path .'.index', $dataReponse);
    }

    public function create(){
        $dataReponse = [
            'title_head'  => $this->title_head . ' | Thêm mới',
            'url_action'  => route('admin_type.post'),
        ];
        return view($this->admin_path .'.index', $dataReponse);
    }

    public function edit($id){
        $db = (new ShopType)->where('parent', 0);
        $posts = $db->orderByDesc('id')->paginate(20);

        $post = ShopType::find($id);
        if($post){
            $dataReponse = [
                'posts'  => $posts,
                'post'  => $post,
                'title_head'  => $this->title_head,
                'url_action'  => route('admin_type.post'),
            ];

            return view($this->admin_path .'.index', $dataReponse);
        } else{
            return view('404');
        }
    }

    public function post(Request $rq){

        $data = request()->all();
        $post_id = $data['id'];

        $title_new = $data['name'];
        $title_slug = addslashes($data['slug']);

        if(empty($title_slug) || $title_slug == '')
           $title_slug = Str::slug($title_new);

        $galleries = $data['gallery'] ?? '';
        if($galleries!=''){
            $galleries = array_filter($galleries);
            $data['gallery'] = $galleries ? serialize($galleries) : '';

        }

        $save = $data['submit'] ?? 'apply';
        
        $data_db = array(
            'parent' => request()->parent??0,
            'name' => $title_new,
            'slug' => $title_slug,

            'gallery' => $data['gallery'] ?? '',
            'image' => $data['image'] ?? '',
            'cover' => $data['cover'] ?? '',
            'icon' => $data['icon'] ?? '',
            'status' => $data['status'] ?? 0,
            'sort' => $data['sort'] ?? 0,

            'seo_title' => $data['seo_title'] ?? '',
            'seo_keyword' => $data['seo_keyword'] ?? '',
            'seo_description' => $data['seo_description'] ?? '',
        );

        if($post_id == 0){
            $respons = ShopType::create($data_db);
            $post_id= $respons->id;
        } else{
            $respons = ShopType::find($post_id)->update($data_db);
        }

        if($save=='apply'){
            $msg = "Shop Level has been Updated";
            $url = route('admin_type.edit', array($post_id));
            Helpers::msg_move_page($msg, $url);
        }
        else{
            return redirect(route('admin_type'));
        }
    }
}
