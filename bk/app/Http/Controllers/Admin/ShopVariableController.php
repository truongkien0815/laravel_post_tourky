<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\ShopVariable;
use Illuminate\Support\Facades\Hash;
use App\Libraries\Helpers;
use Illuminate\Support\Str;
use DB, File, Image, Config;
use Illuminate\Pagination\Paginator;

class ShopVariableController extends Controller
{
    public $data = [];
    public $admin_path = 'admin.shop-variable';
    public $title_head;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->title_head = __('Thuộc tính sản phẩm');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index(){
        $db = new ShopVariable;

        if(request()->has('search_title') && request()->search_title != ''){
            $search_title = request('search_title');
            $db->where('name', 'like', '%'. $search_title .'%');
        }

        $posts = $db->orderByDesc('id')->paginate(20);

        $dataReponse = [
            'posts'  => $posts,
            'title_head'  => $this->title_head,
            'url_action'  => route('admin_variable.create'),
            // 'url_create'  => route('admin_variable.create'),
        ];

        return view($this->admin_path .'.index', $dataReponse);
    }

    public function create(){
        $db = new ShopVariable;
        $posts = $db->orderByDesc('id')->paginate(20);

        $dataReponse = [
            'posts' => $posts,
            'title_head'  => $this->title_head . ' | Thêm mới',
            'url_action'  => route('admin_variable.post'),
        ];
        return view($this->admin_path .'.index', $dataReponse);
    }

    public function edit($id){
        $db = new ShopVariable;
        $posts = $db->orderByDesc('id')->paginate(20);

        $post = ShopVariable::find($id);
        if($post){
            $dataReponse = [
                'posts'  => $posts,
                'post'  => $post,
                'title_head'  => $this->title_head,
                'url_action'  => route('admin_variable.post'),
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

        if(empty($title_slug) || $title_slug == ''):
           $title_slug = Str::slug($title_new);
        endif;

        $save = $data['submit'] ?? 'apply';
        
        $data_db = array(
            'name' => $title_new,
            'slug' => $title_slug,

            'input_type' => $data['input_type']??'',

            'status' => $data['status'] ?? 0,
            'sort' => $data['sort'] ?? 0,
            'created_at' => $data['created_at'] ?? data('Y-m-d H:i'),
        );

        if($post_id == 0){
            $respons = ShopVariable::create($data_db);
            $post_id= $respons->id;
        } else{
            $respons = ShopVariable::find($post_id)->update($data_db);
        }

        if($save=='apply'){
            $msg = "Shop Level has been Updated";
            $url = route('admin_variable.edit', array($post_id));
            Helpers::msg_move_page($msg, $url);
        }
        else{
            return redirect(route('admin_variable'));
        }
    }
}
