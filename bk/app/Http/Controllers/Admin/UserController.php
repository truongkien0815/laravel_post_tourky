<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Libraries\Helpers;
use Illuminate\Support\Str;
use App\User;
use Auth, DB, File, Image, Redirect, Cache;
use App\Exports\CustomerExport;
use App\Exports\OrderExport;
use App\Exports\ProductExport;
use Maatwebsite\Excel\Facades\Excel;
use App\WebService\WebService;
use App\Model\ShopProduct;
use App\ShoppingCart;

class UserController extends Controller
{

    public $data = [];
    public $admin_path = 'admin.users';
    public $title_head;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->title_head = __('Thành viên');
    }

	public function index(){
        $data_user = User::orderBy('created_at', 'desc')->get();
        $dataReponse = [
            'users'  => $data_user,
            'title'  => $this->title_head,
            'url_create'  => route('admin_user.create'),
        ];

        return view($this->admin_path .'.index', $dataReponse);
    }

    public function exportCustomer(Request $rq){
        return (new CustomerExport())->download('customer.xlsx');
    }

    public function create(){
        $dataReponse = [
            'title'  => $this->title_head . ' | Thêm mới',
            'url_action'  => route('admin_user.post'),
        ];
        return view($this->admin_path .'.detail', $dataReponse);
    }

    public function userDetail($id){
    	$user = User::find($id);
        
        if($user){
            $dataReponse = [
                'user'  => $user,
                'title'  => $this->title_head,
                'url_action'  => route('admin_user.post'),
            ];

            return view($this->admin_path .'.detail', $dataReponse);
        } else{
            return view('404');
        }
    }

    public function post(Request $request){
    	$id = $request->id;
        $user = User::find($id);
        $change_pass = $request->check_pass ?? 0;

        if($change_pass){
            $this->validate($request,[
                'email' => 'required|unique:"'.User::class.'",email,' . $id . '',
                'password'      => 'required|confirmed',
                'fullname'          => 'required',
            ],[
                'email.required' => 'Địa chỉ Email không được trống',
                'email.email' => 'Địa chỉ Email không đúng định dạng',
                'email.unique' => 'Địa chỉ Email đã tồn tại',
                'password.required' => 'Hãy nhập mật khẩu',
                'password.confirmed' => 'Xác nhận mật khẩu không đúng',
                'fullname.required' => 'Tên không được trống',
            ]);
        }
        else{
            $this->validate($request,[
                'email' => 'required|string|max:50|unique:"'.User::class.'",email,' . $id . '',
                'fullname'          => 'required',
            ],[
                'email.required' => 'Hãy nhập vào địa chỉ Email',
                'email.email' => 'Địa chỉ Email không đúng định dạng',
                'email.unique' => 'Địa chỉ Email đã tồn tại',
                'fullname.required' => 'Tên không được trống',
            ]);
        }

        $data = request()->all();

        $dataUpdate = array(
            'expert' => $request->expert??0,
            'wallet' => $data['wallet']??0,
            'slogan' => $data['slogan']??'',
            'about_me' => htmlspecialchars($data['about_me']??''),
            'fullname' => $data['fullname'],
            'email' => $data['email'],
            'address' => $data['address'] ?? '',
            'province' => $data['state'] ?? '',
            'district' => $data['slt_district'] ?? '',
            'ward' => $data['slt_ward'] ?? '',
            'avatar' => $data['avatar'],
            'phone' => $data['phone']??'',
            'status' => $data['status']??0,
            'exp' => $data['exp']??'',
            'code' => $data['code']??'',
            'net' => $data['net']??'',
            'role' => $data['role']??0,
            'type' => $data['type']??''
            
        );

        if(!empty( $data['password'] )){
            $dataUpdate['password']  = bcrypt($data['password']);
        }
        if($id)
        {
            $respons = User::where("id", $id)->update($dataUpdate);
        }
        else
        {
            $data['password'] = $data['password'] ?? '123456';
            $dataUpdate['password']  = bcrypt($data['password']);
            $user_screate = User::create($dataUpdate);
            $id = $user_screate->id;
        }

        $save = $request->submit;
        if($save=='apply'){
            $msg = "User has been Updated";
            $url = route('admin_user.edit', array($id));
            Helpers::msg_move_page($msg, $url);
        }
        else{
            return redirect(route('admin_user'));
        }
    }

    public function deleteUser($id)
    {
        $loadDelete = User::find($id)->delete();
        if($loadDelete){
            $productDelete = ShopProduct::all();
            foreach($productDelete as $value){
                if($value->admin_id==$id){
                    $value->delete();
                }
            }
            /*$userCart = ShoppingCart::find($id);
            if($userCart){
                $userCart->delete();
            }*/
        }
        
        $msg = "Customer account has been Delete";
        $url = route('admin_user');
        Helpers::msg_move_page($msg,$url);
    }
}