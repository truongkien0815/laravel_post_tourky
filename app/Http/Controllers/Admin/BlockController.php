<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\BlockContent as Block;
use App\Model\LayoutPosition;
use Illuminate\Support\Facades\Hash;
use App\Libraries\Helpers;
use Illuminate\Support\Str;
use DB, File, Image;


class BlockController extends Controller
{

    public $view = 'admin.block';
    public $layoutPosition;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->layoutPosition = LayoutPosition::getPositions();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index(){
        $db = new Block;


        if(request()->has('search_title') && request()->search_title != ''){
            $search_title = request('search_title');
            $db->where('name', 'like', '%'. $search_title .'%');
        }

        $dataReponse = [
            'title' => 'Danh sách Block',
            'create_page'   => route('admin_block.create'),
            'page' => $db->orderBy('sort')->paginate(20)
        ];
        // dd($dataReponse);

        return view($this->view .'.index', $dataReponse);
    }

    public function create(){
        $listViewBlock = $this->getListViewBlock();
        $dataReponse = [
            'title' => 'Thêm Trang',
            'title' => 'Thêm Trang',
            'listViewBlock' => $listViewBlock,
            'layoutPosition' => $this->layoutPosition,
            'url_action' => route('admin_block.post'),
        ];
        return view($this->view .'.single', $dataReponse);
    }

    public function edit($id){
        $page = Block::find($id);
        $listViewBlock = $this->getListViewBlock();
        if($page){
            $dataReponse = [
                'title' => $page->name,
                'url_action' => route('admin_block.post'),
                'page_data'  => $page,
                'listViewBlock' => $listViewBlock,
                'layoutPosition' => $this->layoutPosition,
            ];
            return view($this->view .'.single', $dataReponse);
        } else{
            return view('404');
        }
    }

    public function store(Request $request){
        //id page
        $data = $request->all();
        $id = $data['id'];

        //xử lý description
        $data['description'] = htmlspecialchars($data['description']);

        $data['page'] = in_array('*', $data['page'] ?? []) ? '*' : implode(',', $data['page'] ?? []);

        $save = $data['submit'] ?? 'apply';
        if($id == 0){
            
            $respons = Block::create($data);
            $id = $respons->id;
        } else{
            $respons = Block::find($id)->update($data);
        }

        if($save=='apply'){
            $msg = "Product has been Updated";
            $url = route('admin_block.edit', $id);
            Helpers::msg_move_page($msg, $url);
        }
        else{
            return redirect( route('admin_block') );
        }
    }

    /**
     * Get view block
     *
     * @return  [type]  [return description]
     */
    public function getListViewBlock()
    {
        $arrView = [];
        foreach (glob(base_path() ."/resources/views/theme/block/*.blade.php") as $file) {
            if (file_exists($file)) {
                $arr = explode('/', $file);
                $arrView[substr(end($arr), 0, -10)] = substr(end($arr), 0, -10);
            }
        }
        return $arrView;
    }
}
