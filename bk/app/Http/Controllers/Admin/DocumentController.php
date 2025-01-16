<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Document;
use Illuminate\Support\Facades\Hash;
use App\Libraries\Helpers;
use Illuminate\Support\Str;
use DB, File, Image, Config;
use Illuminate\Pagination\Paginator;

class DocumentController extends Controller
{
    public $data = [];
    public $admin_path = 'admin.document';
    public $title_head;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->title_head = __('Document');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index(){
        $db = new Document;

        if(request()->has('search_title') && request()->search_title != ''){
            $search_title = request('search_title');
            $db->where('name', 'like', '%'. $search_title .'%');
        }

        $posts = $db->orderByDesc('created_at')->paginate(20);

        $dataReponse = [
            'posts'  => $posts,
            'title'  => $this->title_head,
            'url_create'  => route('admin.document_create'),
        ];

        return view($this->admin_path .'.index', $dataReponse);
    }

    public function create(){
        $dataReponse = [
            'title'  => $this->title_head . ' | Thêm mới',
            'url_action'  => route('admin.document_post'),
        ];
        return view($this->admin_path .'.single', $dataReponse);
    }

    public function edit($id){

        $post = Document::find($id);
        if($post){
            $dataReponse = [
                'post'  => $post,
                'title'  => $this->title_head,
                'url_action'  => route('admin.document_post'),
            ];

            return view($this->admin_path .'.single', $dataReponse);
        } else{
            return view('404');
        }
    }

    public function post(Request $rq){
        $user_admin = auth()->user();
        $data = request()->all();
        $post_id = $data['id'];

        $title_new = $data['name'];
        $title_slug = addslashes($data['slug']);

        if(empty($title_slug) || $title_slug == '')
           $title_slug = Str::slug($title_new);

        //xử lý content
        $content = htmlspecialchars($data['content']??'');

        $galleries = $data['gallery'] ?? '';
        if($galleries!=''){
            $galleries = array_filter($galleries);
            $data['gallery'] = $galleries ? serialize($galleries) : '';

        }

        $status = $data['status'] ?? 0;

        $save = $data['submit'] ?? 'apply';
        
        $data_db = array(
            'name' => $title_new,
            'slug' => $title_slug,
            'content' => $content,

            'user_id' => $data['user_id']??0,
            'download' => $data['download']??0,

            'file' => $data['document'] ?? '',
            'gallery' => $data['gallery'] ?? '',
            'image' => $data['image'] ?? '',
            'cover' => $data['cover'] ?? '',
            'icon' => $data['icon'] ?? '',
            'status' => $status,
            'sort' => $data['sort'] ?? 0,
            'created_at' => $rq->created_at??date('Y-m-d H:i'),

            'seo_title' => $data['seo_title'] ?? '',
            'seo_keyword' => $data['seo_keyword'] ?? '',
            'seo_description' => $data['seo_description'] ?? '',
        );

        if($post_id == 0){
            $respons = Document::create($data_db);
            $post_id= $respons->id;
        } else{
            $respons = Document::find($post_id)->update($data_db);
        }

        if(isset($data['category_item'])){
            \App\Model\DocumentCategoryJoin::where('post_id', $post_id)->delete();
            foreach ($data['category_item'] as $key => $category_id) {
                \App\Model\DocumentCategoryJoin::create([
                    'post_id'   => $post_id,
                    'category_id'   => $category_id
                ]);
            }
        }

        if($save=='apply'){
            $msg = "Document has been Updated";
            $url = route('admin.document_edit', array($post_id));
            Helpers::msg_move_page($msg, $url);
        }
        else{
            return redirect(route('admin.document'));
        }
    }
}
