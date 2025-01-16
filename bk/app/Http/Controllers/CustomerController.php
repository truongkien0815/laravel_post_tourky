<?php

namespace App\Http\Controllers;

use App\User;
use App\Customer;
use Auth;
use Validator;
use Redirect;
use Route;
use Hash;
use Mail;
use Illuminate\Http\Request;
use App\Model\Post;
use App\Model\Category;
use App\Model\Rating_Product;
use App\Model\Wishlist;
use App\Model\Addtocard;
use App\Model\Shipping_order;
use App\Model\Customer_forget_pass_otp;
use DB, Input, File;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use App\Libraries\Helpers;
use App\Facades\WebService;
use App\ShopOrderStatus;
use App\ShopOrderPaymentStatus;
use App\Services\GHNService;
use App\Model\ShopOrder;
use App\Model\ShopShippingStatus;
use App\Model\ShopAttributeGroup;

class CustomerController extends Controller
{

    use \App\Traits\LocalizeController;
    
    public $currency, $ghn_service;
    public $data = [
        'error' => false,
        'success' => false,
        'message' => ''
    ];

    public $path = 'customer';

    public function __construct(GHNService $ghn_service)
    {
        parent::__construct();
        $this->data['statusOrder']    = ShopOrderStatus::getIdAll();
        $this->data['orderPayment']    = ShopOrderPaymentStatus::getIdAll();
        $this->ghn_service = $ghn_service;
    }

    public function index()
    {
       return view($this->path .'.home');
    }

    public function showLoginForm()
    {
        if (!Auth::check()) {
            $this->localized();
            $this->data['seo'] = [
                'seo_title' => 'Đăng nhập',
            ];
            return view('auth.login', $this->data);
        }
        return redirect(url('/'));
    }

    public function postLogin(Request $request)
    {
        $data_return = ['status'=>"success", 'message'=>'Thành công'];

        $login = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        if($request->remember_me == 1){
            $remember_me = true;
        } else{
            $remember_me = false;
        }

        $check_user = \App\User::where('email', $request->email)->first();
        if($check_user!='' && $check_user->status==0){
            if (Auth::attempt($login, $remember_me)) {
                session()->forget('shippingAddress');
                return response()->json(
                    [
                        'error' => 0,
                        'redirect_back' => $request->url_back??'/', //redirect()->back(),
                        'view' => view('auth.login_success')->render(),
                        'msg'   => __('Login success')
                    ]
                );
            } 
            else {
                return response()->json(
                    [
                        'error' => 1,
                        'msg'   => __('Email or Password is wrong')
                    ]
                );
            }
        } 
        else {
            return response()->json(
                [
                    'error' => 1,
                    'msg'   => __('Account does not exist!')
                ]
            );
        }
    }

    public function registerCustomer(){
        $this->data['seo'] = [
            'seo_title' => 'Đăng ký thành viên',
        ];

        return view('auth.register',  $this->data);
    }

    public function createCustomer(Request $request){
        $data_return = ['status'=>"success", 'message'=>'Thành công'];
        $validation_rules = array(
            'fullname' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required'
        );
        $messages = array(
            'fullname.required' => 'Vui lòng nhập họ tên',
            'email.required' => 'Hãy nhập vào địa chỉ Email',
            'email.email' => 'Địa chỉ Email không đúng định dạng',
            'email.max' => 'Địa chỉ Email tối đa 255 ký tự',
            'email.unique' => 'Địa chỉ Email đã tồn tại',
            'password.required' => 'Hãy nhập mật khẩu'
        );
        $data = $request->all();
        
        $validator = Validator::make($data, $validation_rules, $messages);
        
        if($validator->fails()) {
            $error = $validator->errors()->first();
            // dd($validator->errors());

            return response()->json([
                'error' => 1,
                'msg'   => $error
            ]);
            // $view = view('customer.includes.modal_register')->render();
        }
        $dataUpdate = [
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'fullname' => $data['fullname'],
        ];
        $new_cus = (new User)->create($dataUpdate);
        // dd($new_cus);

        if($new_cus->id){
            $email_admin = Helpers::get_option_minhnn('email');
            $name_admin_email = Helpers::get_option_minhnn('name-admin');
            $url_web = url('/');
            $url_only = request()->getHttpHost();
            //email send to user
            $data = array(
                'user' => $new_cus,
                'url_web' => $url_web,
                'fullname' => $new_cus->fullname,
                'phone' => $new_cus->phone,
                'email' => $new_cus->email,
                'subject' => "Đăng ký tài khoản thành công",
                'subject_sys' => "Thông báo có tài khoản vừa đăng ký",
                'title' => setting_option('company_name'),
                'email_admin' => $email_admin,
                'url_only' => $url_only,
            );
            
            Mail::send(
                'email.thongbao_user_register', $data,
                function ($message) use ($data) {
                        $message->from($data['email'], $data['title']);
                        $message->to($data['email'])->subject($data['subject']);
                    }
            );

            //thong bao co thanh vien dang ky
            Mail::send(
                'email.user_register_system', $data,
                function($message) use ($data) {
                    $message->from($data['email_admin'], $data['title']);
                    $message->to($data['email_admin'])
                        ->subject($data['subject_sys']." - Website: ".$data['url_only']);
                }
            );

            Auth::login($new_cus);

            return response()->json([
                'error' => 0,
                'view' => view('auth.register_success')->render(),
                'msg'   => __('Register success')
            ]);
        }
        
        
    }

    public function createCustomerSuccess()
    {
        return view($this->path .'.includes.register_success');
    }

    public function profile(){
        $this->data['user'] = Auth::user();
        $this->data['seo_title'] = 'Thông tin';
        return view($this->templatePath .'.customer.profile', $this->data);
    }
    public function updateProfile(Request $rq){
        $id = Auth::user()->id;
        $name_field = "avatar_upload";
        if($rq->avatar_upload){
            $image_folder="/images/avatar/";

            $file = $rq->file($name_field);
            $file_name = uniqid() . '-' . $file->getClientOriginalName();
            $name_avatar = $image_folder . $file_name;

            
            $file->move( public_path().$image_folder, $file_name );
            if(Auth::user()->avatar !='' && file_exists( base_path().Auth::user()->avatar )){
                if(file_exists(asset(base_path().Auth::user()->avatar)))
                    unlink( asset(base_path().Auth::user()->avatar) );
            }
        }
        else
            $name_avatar = Auth::user()->avatar;

        $data= array(
            'fullname' => $rq->fullname??'',
            'firstname' => $rq->firstname??'',
            'lastname' => $rq->lastname??'',
            'address' => $rq->address_line1 ?? '',
            'birthday' => $rq->birthday ?? null,
            'country' => $rq->country ?? '',
            'province' => $rq->province ?? '',
            'district' => $rq->district ?? '',
            'ward' => $rq->ward ?? '',
            'postal_code' => $rq->postal_code ?? 0,
            'avatar' => $name_avatar,
            'phone' => $rq->phone,
        );
        $respons =(new \App\User)->find($id)->update($data);
        $msg = "Thông tin tài khoản đã được cập nhật";
        $url=  route($this->templatePath .'.customer.profile');
        Helpers::msg_move_page($msg,$url);
    }

    public function myPost()
    {
        $this->localized();
        $this->data['products'] = \App\Product::where('user_id', auth()->user()->id)->orderbyDesc('id')->paginate(10);
        
        return view($this->templatePath .'customer.my-post', ['data'=>$this->data]);
    }

    public function deletePost($id)
    {
        $db = \App\Product::where('id', $id)->where('user_id', auth()->user()->id)->first();
        if($db->delete())
        {
            \App\Model\ThemeInfo::where('theme_id', $id)->delete();
            \App\Model\Join_Category_Theme::where('theme_id', $id)->delete();
            return redirect()->back();
        }
    }

    public function logoutCustomer(){
        Auth::logout();
        return redirect()->route('index');
    }
    public function changePassword(){
        $this->data['user'] = Auth::user();
        return view('auth.passwords.change_pass')->with(['data'=>$this->data]);
    }
    public function postChangePassword(Request $rq){
        $user = Auth::user();
        $id = $user->id;
        $current_pass = $user->password;
        if(Hash::check($rq->current_password, $user->password)){
            if($rq->new_password != '' && $rq->new_password == $rq->confirm_password){
                $data = array(
                    'password' => bcrypt($rq->new_password)
                );
            } else{
                $msg = 'Mật khẩu xác nhận không trùng khớp';
                return Redirect::back()->withErrors($msg);
            }
        } else{
            $msg = 'Mật khẩu hiện tại không chính xác';
            return Redirect::back()->withErrors($msg);
        }
        $respons =DB::table('users')->where("id","=",$id)->update($data);
        $msg = "Mật khẩu đã được thay đổi";
        $url=  route('customer.profile');
        Helpers::msg_move_page($msg,$url);
    }

    public function checkWallet(Request $request)
    {
        $this->data['status'] = 'success';
        $price_post = $request->price_post;
        $wallet = auth()->user()->wallet;
        $wallet_check = 'ok';
        if($wallet < $price_post){
            $wallet_check = 'error';
            $this->data['status'] = 'error';
        }
        $this->data['view'] = view('theme.dangtin.includes.wallet_check', compact('wallet_check'))->render();
        return response()->json($this->data);
    }

    public function wishlist()
    {
        if(auth()->check()){
            $this->data['wishlist'] = \App\Model\Wishlist::with('product')->where('user_id', auth()->user()->id)->get();
            return view('theme.customer.wishlist', ['data'=>$this->data]);
        }
        else
        {
            $wishlist = json_decode(\Cookie::get('wishlist'));

            if($wishlist != ''){
                $this->data['wishlist'] = \App\Product::whereIn('id', $wishlist)->get();
                // dd($this->data['wishlist']);
            }
            return view($this->path .'.wishlist', ['data'=>$this->data]);
        }
    }

    public function subscription(Request $request)
    {
        $email = $request->email;
        \App\Model\User_register_email::updateOrCreate(['email'=>$email]);
        $this->data['status'] = 'success';
        $this->data['email'] = $email;
        $this->data['view'] = view($this->templatePath .'.customer.includes.subscription')->render();
        return response()->json($this->data);
    }

    public function myOrder()
    {
        $customer = auth()->user();
        $statusOrder = ShopOrderStatus::getIdAll();
        sc_check_view($this->templatePath . '.customer.order_list');
        // dd((new ShopOrder)->profile()->get());
        return view($this->templatePath . '.customer.order_list', [
            'title'       => sc_language_render('customer.order_history'),
            'statusOrder' => $statusOrder,
            'orders'      => (new ShopOrder)->profile()->orderByDesc('id')->get(),
            'customer'    => $customer,
            'layout_page' => 'shop_profile',
            'breadcrumbs' => [
                ['url'    => sc_route('customer.index'), 'title' => sc_language_render('front.my_account')],
                ['url'    => '', 'title' => sc_language_render('customer.order_history')],
            ],
        ]);
    }
    
    public function myOrderDetail($id){
        $customer = auth()->user();
        $statusOrder = ShopOrderStatus::getIdAll();
        $statusShipping = ShopShippingStatus::getIdAll();
        
        $order = ShopOrder::where('id', $id) ->where('customer_id', $customer->id)->first();
        if ($order) {
            $title = sc_language_render('customer.order_detail').' #'.$order->id;
        } else {
            return $this->pageNotFound();
        }
        sc_check_view($this->templatePath . '.customer.order_detail');
        return view($this->templatePath . '.customer.order_detail', [
            'title'           => $title,
            'statusOrder'     => $statusOrder,
            'statusShipping'  => $statusShipping,
            
            'order'           => $order,
            'customer'        => $customer,
            'layout_page'     => 'shop_profile',
            'breadcrumbs'     => [
                ['url'        => sc_route('customer.index'), 'title' => sc_language_render('front.my_account')],
                ['url'        => '', 'title' => $title],
            ],
        ]);
    }

    public function myPoint()
    {
        $user = request()->user();
        $user_point = $user->getVIP();
        // dd($user_point);

        $this->data = [
            'user'  => $user,
            'user_point'  => $user_point,
            'seo'   =>[
                'seo_title' => 'Thông tin tài khoản',
            ]
        ];

        return view($this->path .'.my-point', $this->data);
    }
}



