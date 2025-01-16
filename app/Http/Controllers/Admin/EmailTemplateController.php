<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Hash;
use App\Libraries\Helpers;
use Illuminate\Support\Str;
use DB, File, Image, Config;
use Illuminate\Pagination\Paginator;

use App\Model\ShopEmailTemplate;

class EmailTemplateController extends Controller
{
    public $path_folder;
    public $data;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->path_folder = 'admin.email_template';
        $this->data['title_head'] = 'Email template';
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index(){
        $this->data['datas'] = ShopEmailTemplate::orderByDesc('created_at')->paginate(20);
        return view($this->path_folder .'.index', $this->data);
    }

    public function create(){
        $variables_selected = [];
        $category_selected = [];
        $this->data['arrayGroup'] = $this->arrayGroup();
        return view($this->path_folder.'.single', $this->data);
    }

    public function edit($id){
        $this->data['data'] = ShopEmailTemplate::findorfail($id);
        $this->data['arrayGroup'] = $this->arrayGroup();
        return view($this->path_folder . '.single', $this->data);
    }

    public function post(Request $rq){
        $data = request()->all();

        $arrayGroup = $this->arrayGroup();
        if($data['group'])
        {
            $data_db = array(
                'name'  => $arrayGroup[$data['group']],
                'subject'  => $data['subject']??'',
                'group'  => $data['group'],
                'text'  => htmlspecialchars($data['content']),
                'status'  => $data['status'] ?? 0,
                'created_at'  => $data['created_at'] ?? date('Y-m-d H:i'),
            );

            if($data['id'])
                $response = ShopEmailTemplate::find($data['id'])->update($data_db);
            else{
                $response = ShopEmailTemplate::create($data_db);
                $data['id'] = $response->id;
            }

            if($data['submit'] == 'apply'){
                $msg = "Success";
                $url = route('admin.email_template.edit', array($data['id']));
                Helpers::msg_move_page($msg, $url);
            }
            else{
                return redirect(route('admin.email_template'));
            }
        }
        return redirect()->back()->with(['error' => 'Vui lòng chọn Group']);
    }

    public function arrayGroup()
    {
        return  [
            'register_at_checkout' => 'Gửi email đăng ký ở trang Checkout',
            'order_payment_success' => 'Gửi email thanh toán thành công cho admin',
            'order_payment_success_user' => 'Gửi email thanh toán thành công cho khách',
            'order_to_admin' => 'Gửi email đơn hàng cho Admin',
            'order_to_user' => 'Gửi email đơn hàng cho khách',
            'order_processing' => 'Gửi email đơn hàng Processing',
            'order_cancel' => 'Gửi email đơn hàng Cancel',
            'order_completed' => 'Gửi email đơn hàng Completed',
            'forgot_password' => "Gủi thông báo quên mật khẩu",
            'welcome_customer_sys' =>  'Gửi đăng ký thành công cho admin',
            'welcome_customer' =>  'Gửi đăng ký thành công cho khách',
            'contact_to_admin' =>  "Gửi thông báo liên hệ cho admin",

            'request_payment_success' =>  'Gửi email thanh toán đơn hàng thành công',
            // 'other' =>  trans('email.email_action.other'),
        ];
    }
}
