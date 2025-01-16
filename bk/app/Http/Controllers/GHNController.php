<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Validator;
use Carbon\Carbon;
use Cart, Auth;

use App\Services\GHNService;
use App\Model\ShippingOrder;

class GHNController extends Controller
{
    use \App\Traits\LocalizeController;
    
    public $data = [], $ghn_service;
    protected $shop_id, $service_url, $province, $district, $ward, $token, $url;

    public function __construct(GHNService $ghn_service)
    {
        parent::__construct();
        $this->ghn_service = $ghn_service;
    }
    
    public function index() {
        $provinces = Http::withHeaders([
            "Access-Control-Allow-Origin" => " *",
            'Token' => $this->token,

        ])->get($this->province);
        $data = collect($provinces->object()->data);
        dd($data->where('ProvinceID', 269)->first());
    }

    public function ShippingFee($data)
    {
        try
        {
            $validator = Validator::make($data, [
                'from_district_id'  => 'required',
                'to_district_id'    => 'required',
                'weight'            => 'required',
                'height'            => 'required',
                'length'            => 'required',
                'width'             => 'required'
            ]);

            if ($validator->fails()){
                throw new \Exception($validator->errors()->first());
            }

            $records_ghn = Http::withHeaders([
                "Access-Control-Allow-Origin" => " *",
                'Token' => $this->token,

            ])->get($this->url .'/v2/shipping-order/fee', [
                "service_id" => $service_id,
                "insurance_value" => $data['product_price'],
                "coupon" => null,
                "from_district_id" => $data['from_district_id'],
                "to_district_id" => $data['to_district_id'],
                "to_ward_code" => $data['to_ward_code'],
                "height" => $data['height']??0,
                "length" => $data['length']??0,
                "weight" => $data['weight']??0,
                "width" => $data['width']??0
            ]);
            $records_ghn = $records_ghn->json();

            if(empty($records_ghn) || $records_ghn['message'] != 'Success') throw new \Exception('GHN Error');

            $view = view($this->templatePath .'.cart.includes.cart-shipping-select', $response['data'])->render();
            return response()->json([
                'error' => 0,
                'message'   => 'Success',
                'view'   => $view
            ]);
        } catch (\Exception $e) {
            return ['result'=> 'NG', 'message' => $e->getMessage()];
        }
    }
    public function shippingFeeReview()
    {
        $data = request()->all();

        $shippingAddress = session()->get('shippingAddress');
        
        if(empty($data['to_name']))
            $data['to_name'] = $shippingAddress['fullname'];
        if(empty($data['to_phone']))
            $data['to_phone'] = $shippingAddress['phone'];
        if(empty($data['to_address']))
            $data['to_address'] = $shippingAddress['address_full'];

        if(!empty($shippingAddress['delivery']) && $shippingAddress['delivery'] == 'shipping')
        {
            $customer_ward = \App\Model\LocationWard::where('name', $shippingAddress['ward']??'')->first();

            $ghn_data = $this->ghn_service->getGHNData([
                'customer_province' => $shippingAddress['province']??'',
                'customer_district' => $shippingAddress['district']??'',
                'customer_ward' => $customer_ward->type_name,
            ]);
            $data['to_district_id'] = $ghn_data['to_district_id']??'';
            $data['to_ward_code'] = $ghn_data['to_ward_code']??'';
            // dd($ghn_data);
        }
        // dd($data);
        try
        {
            $validator = Validator::make($data, [
                'to_name'               => 'required',
                'to_phone'              => 'required',
                'to_address'            => 'required',
                'to_district_id'        => 'required',
                'to_ward_code'          => 'required',
                'weight'                => 'required',
            ]);

            if ($validator->fails()){
                throw new \Exception($validator->errors()->first());
            }

            $records_ghn = $this->ghn_service->getShippingReview($data);


            if(empty($records_ghn) || $records_ghn['message'] != 'Success') throw new \Exception($records_ghn['message']);
            // dd($records_ghn['data']);
            $records_data = $records_ghn['data'];
            $expected_delivery_time = Carbon::parse($records_data['expected_delivery_time']);
            $records_data['delivery_time'] = $expected_delivery_time;

            session()->put('shipping_data', [
                'total_fee' => $records_data['total_fee'],
                'delivery_time' => $records_data['delivery_time']->format('Y-m-d'),
                'title' => 'Nhanh',
                'shipping_type' => 'ghn',
            ]);

            $view = view($this->templatePath .'.cart.includes.ghn-shipping-fee', $records_data)->render();
            $cart_total = Cart::total(2) + $records_data['total_fee'];

            return response()->json([
                'error' => 0,
                'message'   => 'Success',
                'cart_total'   => render_price($cart_total),
                'shipping_fee'   => $records_data['total_fee'],
                'view'   => $view
            ]);
        } catch (\Exception $e) {
            return ['result'=> 'fee review.', 'message' => $e->getMessage()];
        }
    }

    public function shippingFeeReviewOrder($cart_id)
    {
        try
        {
            $dataSend = $this->shippingCartInfo($cart_id);
            $records_ghn = $this->ghn_service->getShippingReview($dataSend);
            if(empty($records_ghn) || $records_ghn['message'] != 'Success') throw new \Exception($records_ghn['message']);

            $records_data = $records_ghn['data'];
            $expected_delivery_time = Carbon::parse($records_data['expected_delivery_time']);
            $records_data['delivery_time'] = $expected_delivery_time;
            session()->put('shipping_data', [
                'total_fee' => $records_data['total_fee'],
                'delivery_time' => $records_data['delivery_time']->format('Y-m-d'),
                'title' => 'Nhanh',
                'shipping_type' => 'ghn',
            ]);
            return $records_data;

        } catch (\Exception $e) {
            return ['result'=> 'Order', 'message' => $e->getMessage()];
        }
    }

    /*
        get info in Addtocard
        $cart_id: ma don hang
    */
    public function shippingCartInfo($cart_id)
    {
        try
        {
            $cart = \App\Model\Addtocard::find($cart_id);
            if($cart)
            {
                $order_products = \App\Model\Addtocard_Detail::where('cart_id', $cart_id)->get();
                $items = [];
                foreach($order_products as $key => $value)
                {
                    $value = $value->toArray();

                    $product = \App\Product::find($value['product_id']);
                    $product_length = $product->attrs()->where('name', 'length')->first();
                    $product_width = $product->attrs()->where('name', 'width')->first();
                    $product_height = $product->attrs()->where('name', 'height')->first();

                    if($product_length->content !='')
                        $length = ($product_length->content * $value['quanlity'] ) ;
                    if($product_width->content !='')
                        $width = ($product_width->content * $value['quanlity'] ) ;
                    if($product_height->content !='')
                        $height = ($product_height->content * $value['quanlity'] ) ;

                    $items[] = [
                        "name" => $product->name,
                        "code" => $product->sku,
                        "quantity" =>  (int)$value['quanlity'],
                        "price" =>  (int)$value['subtotal'],
                        "length" =>  $length??0,
                        "width" =>  $width??0,
                        "height" =>  $height??0
                    ];
                }

                $ghn_data = $this->ghn_service->getGHNData([
                    'customer_province' => $cart->province??'',
                    'customer_district' => $cart->district??'',
                    'customer_ward' => $cart->ward??'',
                ]);
                $address_full = implode(', ', array_filter([$cart->cart_address??'', $cart->ward??'', $cart->district??'', $cart->province??'']));
                $dataSend = [
                    'to_name'   => $cart->name,
                    'to_address'   => $address_full,
                    'to_district_id'   => $ghn_data['to_district_id'],
                    'to_ward_code'   => $ghn_data['to_ward_code'],
                    'cart_total'   => (int)$cart->cart_total,
                    'height'   => 0,
                    'length'   => 0,
                    'width'   => 0,
                    'weight'   => 1000,
                    'items'   => $items,
                ];
                if($cart->payment_method == 'cod')
                    $dataSend['cod_amount'] = (int)$cart->cart_total;
                return $dataSend;
            }
        } catch (\Exception $e) {
            return ['result'=> 'NG', 'message' => $e->getMessage()];
        }
    }

    public function createOrder()
    {
        $data = request()->all();
        $cart_id = $data['cart_id']??0;
        try
        {
            $dataSend = $this->shippingCartInfo($cart_id);
            if($dataSend)
            {
                $check_create_order = ShippingOrder::where('cart_id', $cart_id)->where('shipping_code', '<>','')->where('shipping_status', '<>', 'cancel')->first();
                if(!$check_create_order)
                {
                    $records_ghn = $this->ghn_service->createGHNOrder($dataSend);

                    if(empty($records_ghn) || $records_ghn['message'] != 'Success') throw new \Exception($records_ghn['message']);
                    
                    $records_data = $records_ghn['data'];
                    $expected_delivery_time = Carbon::parse($records_data['expected_delivery_time']);
                    $delivery_time = $expected_delivery_time->format('Y-m-d H:i');

                    ShippingOrder::updateorCreate(
                        [
                            'cart_id'   => $cart_id,
                        ],
                        [
                            'shipping_code'   => $records_data['order_code'],
                            'shipping_type'   => 'ghn',
                            'shipping_status'   => 'created',
                            'shipping_date'   => $delivery_time,
                        ]
                    );

                    return response()->json([
                        'error' => 0,
                        'message'   => 'Success',
                    ]);
                }
                else
                    $message = 'Đơn hàng đã được tạo';
            }
            else
                $message = 'Đơn hàng không tồn tại';

            return response()->json([
                'error' => 1,
                'message'   => $message,
            ]);
                
        } catch (\Exception $e) {
            return ['result'=> 'Create Order', 'message' => $e->getMessage()];
        }
    }

    public function getService()
    {
        $service = Http::withHeaders([
            "Access-Control-Allow-Origin" => " *",
            'Token' => $this->token,

        ])->get($this->service_url,[
            "shop_id" => $this->shop_id,
            "from_district" => 3695,
            "to_district" => 1461
        ]);
        $service = $service->json();
        if($service['code'] == 200)
        {
            return [
                'error' => 0,
                'data'  => current($service['data'])
            ];
        }
        else
            return [
                'error' => 1,
                'message'  => $service['message']
            ];
    }


    public function webhook()
    {
        $data = request()->all();
        Log::debug($data);
        try
        {
            if(!empty($data['OrderCode']))
            {
                $shipping_order = ShippingOrder::where('shipping_code', $data['OrderCode'])->first();
                if($shipping_order)
                {
                    $shipping_order->shipping_status = $data['Status'];
                    $shipping_order->save();
                }
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
        }
    }

}
