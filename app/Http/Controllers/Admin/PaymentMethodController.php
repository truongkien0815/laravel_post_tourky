<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Libraries\Helpers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

use App\Model\ShopPaymentMethod;

class PaymentMethodController extends Controller
{
    public $admin_path = 'admin.shop-payment-method';
    public $title_head;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ShopPaymentMethod $tableModel){
        $this->title_head = 'Payment Method';
        $this->tableModel = $tableModel;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index(){
        $db = $this->tableModel->where('parent', 0);

        if(request()->has('keyword') && request()->keyword != ''){
            $keyword = request('keyword');
            $db = $db->where('name', 'like', '%'. $keyword .'%');
        }

        $posts = $db->orderByDesc('created_at')->paginate(20);

        $categories = (new ShopPaymentMethod)->getTreeCategoriesAdmin();

        $dataReponse = [
            'posts'  => $posts,
            'categories'  => $categories,
            'title'  => $this->title_head,
            'url_action'  => route('admin_payment_method.post'),
        ];

        return view($this->admin_path .'.index', $dataReponse);
    }

    public function create(){
        $dataReponse = [
            'title'  => $this->title_head . ' | Thêm mới',
            'url_action'  => route('admin_category_faq.post'),
        ];
        return view($this->admin_path .'.single', $dataReponse);
    }

    public function edit($id){
        $post = $this->tableModel->findOrFail($id);


        if($post){

            $db = $this->tableModel->where('parent', 0);

            if(request()->has('keyword') && request()->keyword != ''){
                $keyword = request('keyword');
                $db = $db->where('name', 'like', '%'. $keyword .'%');
            }

            $posts = $db->orderByDesc('created_at')->paginate(20);

            $dataReponse = [
                'post'  => $post,
                'posts'  => $posts,
                'categories' => (new ShopPaymentMethod)->getTreeCategoriesAdmin(),
                'title'  => $this->title_head,
                'url_action'  => route('admin_payment_method.post'),
            ];

            return view($this->admin_path .'.index', $dataReponse);
        }
    }

    protected function validator(array $data)
    {
        $validation_rules = array(
            'name' => 'required|max:255',
            'code' => 'required|max:255',
        );
        $messages = array(
            'name.required' => 'Enter Title',
            'name.max' => 'Title limit at 255 characters',
            'code.required' => 'Enter Code payment',
            'code.max' => 'Code payment limit at 255 characters',
        );

        return Validator::make($data, $validation_rules, $messages);
    }

    public function store(Request $rq){
        $user_admin = auth()->user();
        $data = request()->all();
        $post_id = $data['id'];

        $validator = $this->validator($data);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $respons = $this->tableModel->updateOrCreate(
            [
                'id' => $data['id']??0,
            ],
            [
                'name' => $data['name'],
                'parent' => $data['category']??0,
                'code' => $data['code']??0,
                'content' => $data['content']??'',
                'image' => $data['image']??'',
                'status' => $data['status']??0,
            ]
        );
        $respons->setting()->delete();

        $post_id = $respons->id;

        if(!empty($data['spec_short']))
        {
            // dd($data);
            foreach ($data['spec_short'] as $key => $row) 
            {
                $dataSetting = [
                    'method_id' => (int)$post_id,
                    'key' => $row['key']??$key,
                    'name' => $row['name'],
                    'value' => $row['value'],
                ];
                \App\Model\ShopPaymentMethodSetting::create($dataSetting);
            }
        }

        $save = $data['submit'] ?? 'apply';

        return redirect(route('admin_payment_method.edit', array($post_id)));
    }

    public function delete($id)
    {
        $post = $this->tableModel->find($id);
        if($post)
        {
            $post->delete();
        }

        return redirect(route('admin_payment_method'));
    }

    public function settingDelete()
    {
        $key = request('key');
        \App\Model\ShopPaymentMethodSetting::where('key', $key)->delete();
        return response()->json(['error' => 0, 'msg' => sc_language_render('action.update_success')]);
    }

    // ajax
    public function collectionPaymentMethod()
    {
        $data = request()->all();
        
        if(!empty($data['country']) && $data['country'] != '')
        {
            $country = end($data['country']);
            $dataRequest = [
                'amount'    => $data['amount']??0.5,
                'invoice_currency'    => $data['invoice_currency'],
                'customer_country'    => $country,
            ];
            $paymentMethods = (new \App\Services\TazapayService)->getPaymentMethods($dataRequest);
            // dd($paymentMethods);
            $view = view($this->admin_path .'.includes.payment-method', ['paymentMethods' => $paymentMethods])->render();
            return response()->json([
                'error' => 0,
                'messages'  => 'Success',
                'view'  => $view
            ]);
        }
        return response()->json([
            'error' => 1,
            'message'   => 'Please select country'
        ]);
    }
}
