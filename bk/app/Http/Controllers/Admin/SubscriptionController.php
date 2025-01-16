<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\User_register_email;

class SubscriptionController extends Controller
{
    public $view_path = 'admin.subscription';
    public $view_title = 'Đăng ký nhận tin';
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
    public function index(){
        $db = new User_register_email;

        if(request()->search_title)
        {
            $keyword = request()->search_title;
            $db = $db->where('email', 'like', "%$keyword%");
        }

        $data_rows = $db->orderbyDesc('id')->paginate(20);
        // dd($data_rows->first()->teams);
        $dataResponse = [
            'title' => $this->view_title,
            'data_rows' => $data_rows,
            'view_path' => $this->view_path,
            'url_create' => route('admin_chiso.create'),
        ];
        return view($this->view_path .'.index', $dataResponse);
    }

    public function create(){
        $dataResponse = [
            'title' => 'Thêm '. $this->view_title,
            'url_action' => route('admin_chiso.post'),
            'category_select' => [],
            'view_path' => $this->view_path,
        ];

        return view($this->view_path .'.single', $dataResponse);
    }

    public function edit($id){
        $single = (new ChiSoTraCuu)->getDetail($id, $type = '');
        
        $dataResponse = [
            'title' => $this->view_title,
            'url_action' => route('admin_chiso.post'),
            'single' => $single,
            'view_path' => $this->view_path,
        ];

        if($single)
            return view($this->view_path .'.single', $dataResponse);
        else
            return view('404');
    }

    public function store(Request $rq){
        $data = request()->all();
        //id post
        $sid = $data['id'];
        $post_id = $sid;

        $name = $data['name'];

        $slug = $data['slug'] ?? '';
        if(empty($slug) || $slug == '')
           $slug = Str::slug($name);


        $save = $rq->submit ?? 'apply';
        $date_start = implode(' ', [ $data['date_start']??'', $data['time_start']??'' ]);
        $data_db = array(
            'sub_name' => $data['sub_name']??'',
            'chiso' => $data['chiso']??0,
            'name' => $name,
            'slug' => $slug,
            'description' => $data['description'] ? htmlspecialchars($data['description']) : '',
            'content' => $data['content'] ? htmlspecialchars($data['content']) : '',

            'status' => $data['status'] ?? 0,

            'image' => $data['image'] ?? '',
            'cover' => $data['cover'] ?? '',
            'icon' => $data['icon'] ?? '',

            'seo_title' => $data['seo_title'] ?? '',
            'seo_keyword' => $data['seo_keyword'] ?? '',
            'seo_description' => $data['seo_description'] ?? '',
        );


        if($sid > 0){
            $respons = ChiSoTraCuu::where('id', $sid)->update($data_db);

        } else{
            $respons = ChiSoTraCuu::create($data_db);
            $post_id = $respons->id;
        }

        
        \App\Model\ChiSoCategoryJoin::where('post_id', $post_id)->delete();
        if(isset($data['category']))
        {
            foreach ($data['category'] as $key => $category) {
                \App\Model\ChiSoCategoryJoin::create([
                    'post_id'   => $post_id,
                    'category_id'   => $category
                ]);
            }
        }
        

        if($save=='apply'){
            $msg = "Product has been Updated";
            $url = route('admin_chiso.edit', array($post_id));
            Helpers::msg_move_page($msg, $url);
        }
        else{
            return redirect(route('admin_chiso'));
        }
    }
}
