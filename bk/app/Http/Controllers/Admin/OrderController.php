<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Libraries\Helpers;
use App\WebService\WebService;
use Illuminate\Support\Str;
use DB, File, Image, Config;
use Illuminate\Pagination\Paginator;
use App\ShopOrderStatus;
use App\ShopOrderPaymentStatus;
use App\Model\ShopOrder;
use App\Model\ShippingOrder;
use App\Model\ShopShipping;
use App\Model\ShopPaymentStatus;
use App\Model\ShopShippingStatus;

class OrderController extends Controller
{
    public $currency,
    $statusOrder,
    $orderPayment,
    $ghn_service,
    $provinces,
    $shop_shipping,
    $statusShipping;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->shop_shipping    = ShopShipping::get();
        $this->statusOrder    = ShopOrderStatus::getIdAll();
        $this->statusPayment    = ShopPaymentStatus::getIdAll();
        $this->statusShipping = ShopShippingStatus::getIdAll();
        $this->provinces        = \App\Model\LocationProvince::get();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function listOrder()
    {
        $sort_order   = sc_clean(request('sort_order') ?? 'id_desc');
        $keyword      = sc_clean(request('keyword') ?? '');
        $email        = sc_clean(request('email') ?? '');
        $from_to      = sc_clean(request('from_to') ?? '');
        $end_to       = sc_clean(request('end_to') ?? '');
        $order_status = sc_clean(request('order_status') ?? '');
        $shop = sc_clean(request('shop') ?? '');

        $arrSort = [
            'id__desc'         => sc_language_render('filter_sort.id_desc'),
            'id__asc'          => sc_language_render('filter_sort.id_asc'),
            'email__desc'      => sc_language_render('filter_sort.alpha_desc', ['alpha' => 'Email']),
            'email__asc'       => sc_language_render('filter_sort.alpha_asc', ['alpha' => 'Email']),
            'created_at__desc' => sc_language_render('filter_sort.value_desc', ['value' => 'Date']),
            'created_at__asc'  => sc_language_render('filter_sort.value_asc', ['value' => 'Date']),
        ];
        $dataSearch = [
            'keyword'      => $keyword,
            'email'        => $email,
            'from_to'      => $from_to,
            'end_to'       => $end_to,
            'sort_order'   => $sort_order,
            'arrSort'      => $arrSort,
            'order_status' => $order_status,
        ];

        $orders = (new ShopOrder)->getOrderListAdmin($dataSearch);
        // dd($orders);

        $dataResponse = [
            'orderPayment'  => $this->orderPayment,
            'statusOrder'  => $this->statusOrder,
            'orders'  => $orders,
        ];

        return view('admin.orders.index', $dataResponse);
    }

    public function createOrder(){
        return view('admin.orders.single');
    }

    public function orderDetail($id)
    {
        $statusOrder = ShopOrderStatus::getIdAll();
        $statusShipping = \App\Model\ShopShippingStatus::getIdAll();

        $shippingMethod = [];
        $paymentMethod = [];

        $shippingMethodTmp = \App\Model\ShippingPrice::getListActive();
        foreach ($shippingMethodTmp as $key => $value) {
            $shippingMethod[$value->code] = sc_language_render($value->name);
        }

        $paymentMethodTmp = \App\Model\ShopPaymentMethod::getListActive();
        foreach ($paymentMethodTmp as $key => $value) {
            $paymentMethod[$value->code] = sc_language_render($value->name);
        }
        // dd($shippingMethod);
        $order = ShopOrder::where('id', $id)->first();
        if ($order) {
            $title = sc_language_render('customer.order_detail').' #'.$order->id;
        } else {
            return $this->pageNotFound();
        }

        $order_location = $order->getLocation();
        // dd($order_location);

        sc_check_view('admin.orders.single');
        return view('admin.orders.single', [
            'title'           => $title,
            'statusOrder'     => $statusOrder,
            'statusPayment'     => $this->statusPayment,
            'shippingMethod'     => $shippingMethod,
            'paymentMethod'     => $paymentMethod,
            'statusShipping'  => $statusShipping,
            'provinces'  => $order_location['provinces'],
            'districts'  => $order_location['districts'],
            'wards'  => $order_location['wards'],
            
            'order'           => $order,
            'layout_page'     => 'shop_profile',
            'breadcrumbs'     => [
                ['url'        => sc_route('customer.index'), 'title' => sc_language_render('front.my_account')],
                ['url'        => '', 'title' => $title],
            ],
        ]);
    }

    public function postOrderDetail(){
        $data = request()->all();
        $cart_id = $data['cart_id'];
        // dd($data);
        //xử lý content
        $content = htmlspecialchars($data['admin_note']);
        $status_order = (int)$data['cart_status'];
        if($cart_id > 0){
            $cart = Addtocard::where ("cart_id", $cart_id)->first();
            $cart_shipping = json_decode($cart->shipping_data, true);
            // dd($cart_shipping);

            $shop_shipping = $this->shop_shipping->pluck('name','code');
            $shipping_company = $data['shipping_company'] ?? $cart_shipping['shipping_type'];
            $shipping_title = $shop_shipping[$shipping_company]??$cart_shipping['shipping_company'];
            $shipping_type = $data['shipping_type']??$cart_shipping['shipping_type'];
            
            $shipping_data = [
                'total_fee' => $data['shipping_cost']??$cart_shipping['total_fee'],
                'delivery_time' => date('Y-m-d'),
                'title' => $shipping_title,
                'shipping_type' => $shipping_type,
            ];
            $shipping_cost = $data['shipping_cost'] ?? $cart->shipping_cost;

            //update
            $dataUpdate = array(
                "cart_note" => $content,
                "cart_status" => $status_order,
                "cart_payment" => $data['cart_payment']??0,
                "shipping_cost" => $shipping_cost,
                'shipping_data' => json_encode($shipping_data, JSON_UNESCAPED_UNICODE),
            );
            $respons = Addtocard::where ("cart_id", $cart_id)->update($dataUpdate);

            session()->forget('shipping_data');

            $msg = "Order has been Updated";
            $url= route('admin.orderDetail', array($cart_id));
            Helpers::msg_move_page($msg,$url);
        }
    }

    public function update()
    {
        $cart_id = request('pk')??'';
        $code = request('name');
        $value = request('value');
        $data = null;
        if($cart_id)
        {
            $order = ShopOrder::find($cart_id);
            if(!$order)
            {
                return response()->json(['error' => 1, 'msg' => 'Không tìm thấy đơn hàng', 'detail' => '']);
            }

            $respons = ShopOrder::where("id", $cart_id)->update([
                $code   => $value
            ]);

            if($code=='address1')
            {
                $province = \App\Model\LocationProvince::where('name', $value)->first();
                $data['districts'] = \App\Model\LocationDistrict::where('province_id', $province->id??0)->get()->pluck('name');
            }
            if($code=='address2')
            {
                $district = \App\Model\LocationDistrict::where('name', $value)->first();
                $data['wards'] = \App\Model\LocationWard::where('district_id', $district->id??0)->get()->pluck('type_name');
            }

            if(in_array($code, ['address1','address2', 'address3', 'address']))
            {
                $data['address'] = implode(', ', array_filter([$order->address3, $order->address2, $order->address1, $order->country]));
            }

            return response()->json(['error' => 0, 'msg' => 'Cập nhật thành công', 'data' => $data]);
        }
        return response()->json(['error' => 1, 'msg' => 'Không tìm thấy đơn hàng', 'detail' => '']);
    }
}
