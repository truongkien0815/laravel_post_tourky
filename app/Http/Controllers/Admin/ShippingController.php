<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Libraries\Helpers;
use App\Model\ShippingPrice;

class ShippingController extends Controller
{
    public $data = [];
    public $admin_path = 'admin.shipping';
    public $title;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->title = __('Vận chuyển');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index(){
        $db = (new ShippingPrice);

        if(request()->has('search_title') && request()->search_title != ''){
            $search_title = request('search_title');
            $db->where('name', 'like', '%'. $search_title .'%');
        }

        $posts = $db->orderBy('sort')->paginate(20);

        $dataReponse = [
            'posts'  => $posts,
            'title'  => $this->title,
            'url_action'  => route('admin.shipping_post'),
        ];

        return view($this->admin_path .'.price', $dataReponse);
    }

    public function create(){
        $dataReponse = [
            'title'  => $this->title . ' | Thêm mới',
            'url_action'  => route('admin.shipping_post'),
        ];
        return view($this->admin_path .'.price', $dataReponse);
    }

    public function edit($id){

        $data = ShippingPrice::find($id);
        $posts = (new ShippingPrice)->orderByDesc('created_at')->paginate(20);
        if($data){
            $dataReponse = [
                'data'  => $data,
                'posts'  => $posts,
                'title'  => $this->title,
                'url_action'  => route('admin.shipping_post'),
            ];

            return view($this->admin_path .'.price', $dataReponse);
        } else{
            return view('404');
        }
    }

    public function post(Request $rq){
        $data               = request()->all();

        $tour_price = ShippingPrice::updateOrCreate(
            [
                'id' => $data['id']??0
            ],
            [
                'name' => $data['name'],
                'price' => $data['price'],
                'code' => $data['code']??'',
                'status' => $data['status']??0,
                'content' => $data['content']??0,
                'sort' => $data['sort']??0
            ]
        );

        $msg = "Tour has been registered";
        $url = route('admin.shipping', array($tour_price->id));
        Helpers::msg_move_page($msg, $url);
    }
    public function delete($id)
    {
        ShippingPrice::where('id', $id)->delete();
        return redirect()->back();
    }
}
