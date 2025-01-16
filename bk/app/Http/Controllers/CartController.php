<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailNotify;
use Cart, Auth;

use ShipEngine\ShipEngine;

use App\Model\ShopEmailTemplate;
use App\Mail\SendMail;
use App\Jobs\Job_SendMail;
use App\ShopOrderStatus;
use App\ShopOrderPaymentStatus;
use Illuminate\Support\Str;
use App\Services\GHNService;

use App\Model\ShopProduct;
use App\Model\ShopOrder;
use App\Model\ShopOrderDetail;
use App\Model\ShopOrderTotal;

class CartController extends Controller
{
    use \App\Traits\LocalizeController;
    public $currency,
    $statusOrder,
    $orderPayment,
    $ghn_service;
    public $data = [
        'error' => false,
        'success' => false,
        'message' => ''
    ];

    const ORDER_STATUS_NEW = 1;
    const PAYMENT_UNPAID   = 1;
    const SHIPPING_NOTSEND = 1;

    public function __construct()
    {
        parent::__construct();
        $this->data['statusOrder']    = ShopOrderStatus::getIdAll();
        $this->data['orderPayment']    = ShopOrderPaymentStatus::getIdAll();
    }

    public function cart(){
        $this->localized();
        $carts = Cart::content();
        $this->data['carts'] = $carts;
        $this->data['seo'] = [
            'seo_title' => 'Giỏ hàng',
        ];

        session(['dataCheckout' => $this->data['carts']]);

        return view($this->templatePath .'.cart.cart', $this->data);
    }

    public function addCart()
    {
        $data = request()->all();
        $optionPrice = 0;

        $data['qty'] = $data['qty']??1;

        $product = \App\Product::find($data['product']);
        if (!$product) {
            return response()->json(
                [
                    'error' => 1,
                    'msg' => 'Product not found',
                ]
            );
        }
        if ($product->stock < $data['qty']) 
        {
            return response()->json(
                [
                    'error' => 1,
                    'msg' => 'Số lượng sản phẩm không đủ trong kho',
                ]
            );
        }
        if (isset($data['product_item_id']) && $data['product_item_id'] == 0) {
            return response()->json(
                [
                    'error' => 1,
                    'msg' => 'Vui lòng chọn thuộc tính sản phẩm',
                ]
            );
        }
        if(!empty($data['product_item_id']))
        {
            $product_item = \App\Model\ShopProductItem::find($data['product_item_id']);
            if($product_item)
            {
                if($product_item->quantity==0)
                {
                    return response()->json(
                        [
                            'error' => 1,
                            'msg' => 'Thuộc tính sản phẩm này đã hết hàng',
                        ]
                    );
                }
                $item_features = \App\Model\ShopProductItemFeature::where('product_item_id', $data['product_item_id'])->get();
                foreach($item_features as $item)
                {
                    $form_attr[$item->feature.'__'. $product_item->id] = $item->value;
                }
                $optionPrice = $product_item->promotion ? $product_item->promotion : ($product_item->price??0);
            }
        
        }
        $price = $optionPrice > 0 ? $optionPrice : $product->getFinalPrice();
        $data_add_cart = array(
            'id'      => $product->id,
            'name'    => $product->name,
            'qty'     => $data['qty'],
            'price'   => $price,
            'options' => $form_attr ?? []
        );
        //Check product allow for sale
        Cart::add($data_add_cart);
        
        return response()->json(
            [
                'error' => 0,
                'count_cart' => Cart::count(),
                'view' => view($this->templatePath .'.cart.cart-mini')->render(),
                'view_modal' => view($this->templatePath .'.product.product_add_cart_modal', compact('product', 'data_add_cart'))->render(),
                'msg' => 'Sảm phẩn đã thêm vào giỏ hàng',
            ]
        );
    }

    public function updateCarts()
    {
        $data = request()->all();

        $cart = Cart::content()->where('rowId',$data['rowId'])->first();
        // dd($cart);
        if(!empty($cart->id))
        {
            $product = \App\Product::find($cart->id);

            if ($product->stock < $data['qty']) 
            {
                return response()->json([
                    'error' => 1,
                    'msg'   => 'Số lượng trong kho không đủ'
                ]);
            }
        }
        
        Cart::update($data['rowId'], ['qty' => $data['qty']]);
        $carts = Cart::content();
        return response()->json([
            'error' => 0,
            'count_cart' => Cart::count(),
            'view_cart_mini' => view($this->templatePath .'.cart.cart-mini')->render(),
            'view' => view($this->templatePath .'.cart.cart-list', compact('carts'))->render(),
            'msg'   => 'Update cart success'
        ]);
        
    }

    public function removeCarts()
    {
        Cart::destroy();
        return redirect(route('cart'));
    }

    public function removeCart()
    {
        $rowId = request('rowId');
        if (array_key_exists($rowId, Cart::content()->toArray())) {
            Cart::remove($rowId);
            $carts = Cart::content();

            return response()->json(
                [
                    'error' => 0,
                    'count_cart' => Cart::content()->count(),
                    'total' => number_format(Cart::total()),
                    'msg' => 'Delete success',
                    'view' => view($this->templatePath .'.cart.cart-list', compact('carts'))->render(),
                ]
            );
        }
        return response()->json(
            [
                'error' => 1,
                'msg' => 'Delete error',
            ]
        );
    }

    public function checkout()
    {
        $this->localized();
        $cart_content = Cart::content();
        if(!Cart::count())
            return redirect(route('shop'));

        foreach($cart_content as $key => $value)
        {
            $value = $value->toArray();

            $product_ = \App\Product::find($value['id']);

            if ($product_->stock < $value['qty']) 
            {
                return redirect(route('cart'));
            }
        }
        if($cart_content){
            session()->forget('option');
            $this->data['seo_title'] = 'Đặt hàng';

            // Shipping address
            $customer = auth()->user();
            if ($customer) 
            {
                $customer_ward = \App\Model\LocationWard::where('name', $customer->ward)->first();

                $address_full = array_filter([ $customer->address, $customer_ward->type_name??'', $customer->district,$customer->province ]);
                $address_full = implode(', ', $address_full);

                $addressDefaul = [
                    'fullname'      => $customer->fullname,
                    'email'           => $customer->email,
                    'address_line1'         => $customer->address,
                    'ward'            => $customer->ward,
                    'district'        => $customer->district,
                    'province'        => $customer->province,
                    'postcode'        => $customer->postal_code,
                    'company'         => $customer->company,
                    'country'         => $customer->country,
                    'phone'           => $customer->phone,
                    'address_full'    => $address_full,
                    'comment'         => '',
                    'delivery'         => 'shipping',
                ];
            }
            else
            {
                $addressDefaul = [
                    'fullname'        => '',
                    'email'           => '',
                    'address_line1'         => '',
                    'ward'            => '',
                    'district'        => '',
                    'province'        => '',
                    'postcode'        => '',
                    'company'         => '',
                    'country'         => '',
                    'phone'           => '',
                    'comment'         => '',
                    'address_full'         => '',
                    'delivery'         => 'shipping',
                ];
            }

            $shippingAddress = session('shippingAddress')??'';

            if($shippingAddress == '' || $shippingAddress['phone'] == '')
            {
                $shippingAddress = $addressDefaul;
                session([ 'shippingAddress' => $shippingAddress ] );
            }
            else
            {
                $shippingAddress['delivery'] = 'shipping';
                session()->forget('shippingAddress');
                session(['shippingAddress' => $shippingAddress]);
            }
            // dd($shippingAddress);
            $this->data['shippingAddress'] = $shippingAddress;

            if(session()->has('cart-info')){
                $data = session()->get('cart-info');
                $this->data["cart_info"] = $data;
            }

            //Total
            $moduleTotal = sc_get_plugin_installed('total');
            $sourcesTotal = sc_get_all_plugin('total');
            $totalMethod = array();
            foreach ($moduleTotal as $module) {
                if (array_key_exists($module['key'], $sourcesTotal)) {
                    $moduleClass = $sourcesTotal[$module['key']] . '\AppConfig';
                    $totalMethod[$module['key']] = (new $moduleClass)->getData();
                }
            }
            $this->data['totalMethod'] = $totalMethod;

            $shipping_methods = (new \App\Model\ShippingPrice)->getListActive();
            session()->put('shippingMethod', $shipping_methods->first()->code);
            $this->data['shipping_methods'] = $shipping_methods;

            $objects = ShopOrderTotal::getObjectOrderTotal();
            $dataTotal = ShopOrderTotal::processDataTotal($objects);
            $total    = (new ShopOrderTotal)->sumValueTotal('total', $dataTotal);
            $subtotal = (new ShopOrderTotal)->sumValueTotal('subtotal', $dataTotal); //sum total
            $this->data['dataTotal'] = $dataTotal;
            // dd($dataTotal);

            // dd($this->data['shipping_methods']);

            
            return view($this->templatePath .'.cart.checkout', $this->data);
        }
        else
            return $this->cart();
    }

    public function checkoutConfirm()
    {
        $this->localized();
        $data = request()->all();

        if ($data) {
            session()->forget('cart-info');
            if (auth()->check())
            {
                $user = auth()->user();
                $data['fullname']       = $user->fullname;
                $data['phone']          = $user->phone;
                $data['email']          = $user->email;
                $data['address_line1']  = $user->address;
                $data['country_code']   = $user->country;
            }
            else
            {
                $data['fullname']   = $data['ship_name'] ?? $data['ship_phone'] ?? 'N/A';
                $data['email']      = $data['ship_email'] ?? '';
                $data['phone']      = $data['ship_phone'] ?? '';
            }

            if(!empty($data['delivery']))
            {
                $shipping_method = (new \App\Model\ShippingPrice)->where('code', $data['delivery'])->first();
                if($shipping_method)
                {
                    session()->put('shippingMethod', $shipping_method->code);
                }
            }

            session()->put('cart-info', $data);

            // dd($data);
            return redirect()->route('cart.checkout.get.confirm');
        }
        else
        {
            if (session()->has('order-waiting'))
            {
                $cart_id = session('order-waiting')[0];
                session()->forget('order-waiting');
                return redirect()->route('cart.check_payment', $cart_id);
            }
            elseif (!session()->has('cart-info'))
                return redirect()->route('cart');

            $data = session()->get('cart-info');

            if(auth()->check())
            {
                $user = auth()->user();
                if($data['email'] != $user->email || $data['phone'] != $user->phone)
                    return redirect()->route('cart');
            }
        }

        //Total
        $moduleTotal = sc_get_plugin_installed('total');
        $sourcesTotal = sc_get_all_plugin('total');
        $totalMethod = array();
        foreach ($moduleTotal as $module) {
            if (array_key_exists($module['key'], $sourcesTotal)) {
                $moduleClass = $sourcesTotal[$module['key']] . '\AppConfig';
                $totalMethod[$module['key']] = (new $moduleClass)->getData();
            }
        }

        $objects = ShopOrderTotal::getObjectOrderTotal();
        $dataTotal = ShopOrderTotal::processDataTotal($objects);
        $total    = (new ShopOrderTotal)->sumValueTotal('total', $dataTotal);
        $subtotal = (new ShopOrderTotal)->sumValueTotal('subtotal', $dataTotal); //sum total
        // dd($dataTotal);
        //Set session dataTotal
        session(['dataTotal' => $dataTotal]);

        $shippingAddress = session('shippingAddress')??'';
        if($shippingAddress == '')
        {
            $shippingAddress = $addressDefaul;
            session([ 'shippingAddress' => $shippingAddress ] );
        }
        else
        {
            $delivery = $data['delivery']??'shipping';
            $shippingAddress['delivery'] = $delivery;
            session()->forget('shippingAddress');
            session(['shippingAddress' => $shippingAddress]);
        }

        $dataReponse = [
            'cart_info' => $data,
            'totalMethod' => $totalMethod,
            'dataTotal' => $dataTotal,
            'total' => $total,
            'subtotal' => $subtotal,
            'shippingAddress' => $shippingAddress,
            'delivery' => $delivery??'',
            'seo_title' => 'Checkout',
        ];


        // return view($this->templatePath . '.checkout.checkout', $dataReponse);

        return view($this->templatePath .'.cart.checkout-confirm', $dataReponse);
    }

    public function processCheckout(Request $request)
    {
        $agent = new \Jenssegers\Agent\Agent();
        $customer = auth()->user();
        $uID = $customer->id ?? 0;

        //if cart empty
        if (count(session('dataCheckout', [])) == 0) {
            return redirect(url('/'));
        }
        //Not allow for guest
        if (!sc_config('shop_allow_guest') && !$customer) {
            return redirect(sc_route('login'));
        } //

        $data = request()->all();

        if (!$data) {
            return redirect(route('cart'));
        } else {
            $dataTotal       = session('dataTotal') ?? [];
            $dataTotals       = session('dataTotals') ?? [];
            $shippingAddress = session('shippingAddress') ?? [];
            $paymentMethod   = session('paymentMethod') ?? '';
            $shippingMethod  = session('shippingMethod') ?? '';
            $address_process = session('address_process') ?? '';
            $storeCheckout   = session('storeCheckout') ?? '';
            $dataCheckout    = session('dataCheckout') ?? '';
            $cartGroup    = session('cartGroup') ?? '';
        }
        //save vendor order
        $orderIDs = [];
        // dd($shippingAddress);
        if(empty($shippingAddress['first_name']))
            $shippingAddress['first_name'] = $shippingAddress['fullname'];
        
        //Process total
        $subtotal = (new ShopOrderTotal)->sumValueTotal('subtotal', $dataTotal); //sum total
        $tax      = (new ShopOrderTotal)->sumValueTotal('tax', $dataTotal); //sum tax
        $shipping = (new ShopOrderTotal)->sumValueTotal('shipping', $dataTotal); //sum shipping
        $discount = (new ShopOrderTotal)->sumValueTotal('discount', $dataTotal); //sum discount
        $otherFee = (new ShopOrderTotal)->sumValueTotal('other_fee', $dataTotal); //sum other_fee
        $received = (new ShopOrderTotal)->sumValueTotal('received', $dataTotal); //sum received
        $total    = (new ShopOrderTotal)->sumValueTotal('total', $dataTotal);
        //end total

        $dataOrder['store_id']        = $storeCheckout;
        $dataOrder['customer_id']     = $uID;
        $dataOrder['subtotal']        = $subtotal;
        $dataOrder['shipping']        = $shipping;
        $dataOrder['discount']        = $discount;
        $dataOrder['other_fee']        = $otherFee;
        $dataOrder['received']        = $received;
        $dataOrder['tax']             = $tax;
        $dataOrder['payment_status']  = self::PAYMENT_UNPAID;
        $dataOrder['shipping_status'] = self::SHIPPING_NOTSEND;
        $dataOrder['status']          = self::ORDER_STATUS_NEW;
        $dataOrder['currency']        = sc_currency_code();
        $dataOrder['exchange_rate']   = sc_currency_rate();
        $dataOrder['total']           = $total;
        $dataOrder['balance']         = $total + $received;
        $dataOrder['email']           = $shippingAddress['email'];
        $dataOrder['first_name']      = $shippingAddress['first_name'];
        $dataOrder['payment_method']  = $paymentMethod;
        $dataOrder['shipping_method'] = $shippingMethod;
        $dataOrder['user_agent']      = $request->header('User-Agent');
        $dataOrder['device_type']      = $agent->deviceType();
        $dataOrder['ip']              = $request->ip();
        $dataOrder['created_at']      = sc_time_now();

        if (!empty($shippingAddress['last_name'])) {
            $dataOrder['last_name']       = $shippingAddress['last_name'];
        }
        if (!empty($shippingAddress['first_name_kana'])) {
            $dataOrder['first_name_kana']       = $shippingAddress['first_name_kana'];
        }
        if (!empty($shippingAddress['last_name_kana'])) {
            $dataOrder['last_name_kana']       = $shippingAddress['last_name_kana'];
        }
        if (!empty($shippingAddress['province'])) {
            $dataOrder['address1']       = $shippingAddress['province'];
        }
        if (!empty($shippingAddress['district'])) {
            $dataOrder['address2']       = $shippingAddress['district'];
        }
        if (!empty($shippingAddress['address_line1'])) {
            $dataOrder['address3']       = $shippingAddress['address_line1'];
        }
        if (!empty($shippingAddress['country'])) {
            $dataOrder['country']       = $shippingAddress['country'];
        }
        if (!empty($shippingAddress['phone'])) {
            $dataOrder['phone']       = $shippingAddress['phone'];
        }
        if (!empty($shippingAddress['postcode'])) {
            $dataOrder['postcode']       = $shippingAddress['postcode'];
        }
        if (!empty($shippingAddress['company'])) {
            $dataOrder['company']       = $shippingAddress['company'];
        }
        if (!empty($shippingAddress['comment'])) {
            $dataOrder['comment']       = $shippingAddress['comment'];
        }
    
        $dataOrder['store_id']        = $store_id??0;

        $arrCartDetail = [];
        foreach ($dataCheckout as $cartItem) {
            $arrDetail['product_id']  = $cartItem->id;
            $arrDetail['name']        = $cartItem->name;
            $arrDetail['price']       = sc_currency_value($cartItem->price);
            $arrDetail['qty']         = $cartItem->qty;
            $arrDetail['store_id']    = $store_id??0;
            $arrDetail['attribute']   = ($cartItem->options) ? $cartItem->options->toArray() : null;
            $arrDetail['total_price'] = sc_currency_value($cartItem->price) * $cartItem->qty;
            $arrCartDetail[]          = $arrDetail;
        }

        //Create new order
        $newOrder = (new ShopOrder)->createOrder($dataOrder, $dataTotal, $arrCartDetail);

        if ($newOrder['error'] == 1) {
            sc_report($newOrder['msg']);
            return redirect(route('cart'))->with(['error' => $newOrder['msg']]);
        }
        //Set session orderID
        $orderIDs[] = $newOrder['orderID'];
       
        if(count($orderIDs))
            session(['orderIDs' => $orderIDs]);
        
        //Create new address
        if ($address_process == 'new') {
            $addressNew = [
                'first_name'      => $shippingAddress['first_name'] ?? '',
                'last_name'       => $shippingAddress['last_name'] ?? '',
                'first_name_kana' => $shippingAddress['first_name_kana'] ?? '',
                'last_name_kana'  => $shippingAddress['last_name_kana'] ?? '',
                'postcode'        => $shippingAddress['postcode'] ?? '',
                'address1'        => $shippingAddress['province'] ?? '',
                'address2'        => $shippingAddress['district'] ?? '',
                'address3'        => $shippingAddress['address_line1'] ?? '',
                'country'         => $shippingAddress['country'] ?? '',
                'phone'           => $shippingAddress['phone'] ?? '',
            ];
            //Process escape
            $addressNew = sc_clean($addressNew);

            ShopCustomer::find($uID)->addresses()->save(new ShopCustomerAddress($addressNew));
            session()->forget('address_process'); //destroy address_process
        }

        // dd(session('paymentMethod'));
        $paymentMethod = sc_get_class_plugin_controller('Payment', session('paymentMethod'));

        return (new CartController)->completeOrder();
    }

    /**
     * Complete order
     *
     * Step 07
     *
     * @return [redirect]
     */
    public function completeOrder()
    {
        //Clear cart store
        $this->clearCartStore();

        // $orderID = session('orderID') ?? 0;
        $orderIDs = session('orderIDs') ?? [];
        // dd($orderIDs);
        $paymentMethod  = session('paymentMethod');
        $shippingMethod = session('shippingMethod');
        $totalMethod    = session('totalMethod', []);

        if (!count($orderIDs)) {
            return redirect()->route('home', ['error' => 'Error Order ID!']);
        }

        foreach($orderIDs as $orderID)
        {
            // Process event success
            sc_event_order_success($order = ShopOrder::find($orderID));

            $classPaymentConfig = sc_get_class_plugin_config('Payment', $paymentMethod);
            if (method_exists($classPaymentConfig, 'endApp')) {
                (new $classPaymentConfig)->endApp();
            }

            $classShippingConfig = sc_get_class_plugin_config('Shipping', $shippingMethod);
            if (method_exists($classShippingConfig, 'endApp')) {
                (new $classShippingConfig)->endApp();
            }

            if ($totalMethod && is_array($totalMethod)) {
                foreach ($totalMethod as $keyMethod => $valueMethod) {
                    $classTotalConfig = sc_get_class_plugin_config('Total', $keyMethod);
                    if (method_exists($classTotalConfig, 'endApp')) {
                        (new $classTotalConfig)->endApp(['orderID' => $orderID, 'code' => $valueMethod]);
                    }
                }
            }

            
            $data = ShopOrder::with('details')->find($orderID)->toArray();
            $checkContent = (new ShopEmailTemplate)->where('group', 'order_to_admin')->where('status', 1)->first();
            $checkContentCustomer = (new ShopEmailTemplate)->where('group', 'order_to_user')->where('status', 1)->first();

            if ($checkContent || $checkContentCustomer) {
                $orderDetail = '';
                $orderDetail .= '<tr>
                                    <td>' . sc_language_render('email.order.sort') . '</td>
                                    <td>' . sc_language_render('email.order.sku') . '</td>
                                    <td>' . sc_language_render('email.order.name') . '</td>
                                    <td>' . sc_language_render('email.order.price') . '</td>
                                    <td>' . sc_language_render('email.order.qty') . '</td>
                                    <td>' . sc_language_render('email.order.total') . '</td>
                                </tr>';
                foreach ($data['details'] as $key => $detail) {
                    $product = ShopProduct::find($detail['product_id']);
                    $pathDownload = $product->downloadPath->path ?? '';
                    $nameProduct = $detail['name'];
                    if ($product && $pathDownload && $product->property == SC_PROPERTY_DOWNLOAD) {
                        $nameProduct .="<br><a href='".sc_path_download_render($pathDownload)."'>Download</a>";
                    }

                    $orderDetail .= '<tr>
                                    <td>' . ($key + 1) . '</td>
                                    <td>' . $detail['sku'] . '</td>
                                    <td>' . $nameProduct . '</td>
                                    <td>' . sc_currency_render($detail['price'], '', '', '', false) . '</td>
                                    <td>' . number_format($detail['qty']) . '</td>
                                    <td align="right">' . sc_currency_render($detail['total_price'], '', '', '', false) . '</td>
                                </tr>';
                }
                $dataFind = [
                    '/\{\{\$title\}\}/',
                    '/\{\{\$orderID\}\}/',
                    '/\{\{\$firstName\}\}/',
                    '/\{\{\$lastName\}\}/',
                    '/\{\{\$toname\}\}/',
                    '/\{\{\$address\}\}/',
                    '/\{\{\$address1\}\}/',
                    '/\{\{\$address2\}\}/',
                    '/\{\{\$address3\}\}/',
                    '/\{\{\$email\}\}/',
                    '/\{\{\$phone\}\}/',
                    '/\{\{\$comment\}\}/',
                    '/\{\{\$orderDetail\}\}/',
                    '/\{\{\$subtotal\}\}/',
                    '/\{\{\$shipping\}\}/',
                    '/\{\{\$discount\}\}/',
                    '/\{\{\$otherFee\}\}/',
                    '/\{\{\$total\}\}/',
                ];
                $dataReplace = [
                    sc_language_render('email.order.email_subject_customer') . '#' . $orderID,
                    $orderID,
                    $data['first_name'],
                    $data['last_name'],
                    $data['first_name'].' '.$data['last_name'],
                    $data['address1'] . ' ' . $data['address2'].' '.$data['address3'],
                    $data['address1'],
                    $data['address2'],
                    $data['address3'],
                    $data['email'],
                    $data['phone'],
                    $data['comment'],
                    $orderDetail,
                    sc_currency_render($data['subtotal'], '', '', '', false),
                    sc_currency_render($data['shipping'], '', '', '', false),
                    sc_currency_render($data['discount'], '', '', '', false),
                    sc_currency_render($data['other_fee'], '', '', '', false),
                    sc_currency_render($data['total'], '', '', '', false),
                ];

                // Send mail order success to admin
                if (sc_config('order_success_to_admin') && $checkContent) {
                    $content = $checkContent->text;
                    $content = preg_replace($dataFind, $dataReplace, $content);
                    $dataView = [
                        'content' => $content,
                    ];
                    $config = [
                        'to' => sc_store('email'),
                        'subject' => sc_language_render('email.order.email_subject_to_admin', ['order_id' => $orderID]),
                    ];
                    sc_send_mail($this->templatePath . '.mail.order_success_to_admin', $dataView, $config, []);
                }

                // Send mail order success to customer
                if (sc_config('order_success_to_customer') && $checkContentCustomer) {
                    $contentCustomer = $checkContentCustomer->text;
                    $contentCustomer = preg_replace($dataFind, $dataReplace, $contentCustomer);
                    $dataView = [
                        'content' => $contentCustomer,
                    ];
                    $config = [
                        'to' => $data['email'],
                        'replyTo' => sc_store('email'),
                        'subject' => sc_language_render('email.order.email_subject_customer', ['order_id' => $orderID]),
                    ];

                    $attach = [];
                    if (sc_config('order_success_to_customer_pdf')) {
                        // Invoice pdf
                        \PDF::loadView($this->templatePath . '.mail.order_success_to_customer_pdf', $dataView)
                            ->save(\Storage::disk('invoice')->path('order-'.$orderID.'.pdf'));
                        $attach['attachFromStorage'] = [
                            [
                                'file_storage' => 'invoice',
                                'file_path' => 'order-'.$orderID.'.pdf',
                            ]
                        ];
                    }

                    sc_send_mail($this->templatePath . '.mail.order_success_to_customer', $dataView, $config, $attach);
                }
            }
        }
        //Clear session
            $this->clearSession();

        $dataResponse = [
            'orderIDs'        => $orderIDs,
        ];
        return redirect(route('order.success'))->with($dataResponse);
    }


    /**
     * Process front page order success
     *
     * Step 08.1
     *
     * @param [type] ...$params
     * @return void
     */
    public function orderSuccessProcessFront(...$params)
    {
        if (config('app.seoLang')) {
            $lang = $params[0] ?? '';
            sc_lang_switch($lang);
        }
        return $this->_orderSuccess();
    }

    /**
     * Page order success
     *
     * Step 08.2
     *
     * @return  [view]
     */
    private function _orderSuccess()
    {
        if (!session('orderIDs')) {
            return redirect()->route('home');
        }
        sc_check_view($this->templatePath . '.screen.shop_order_success');
        $orderInfos = ShopOrder::with('details')->whereIn('id', session('orderIDs'))->get()->toArray();
        // dd($orderInfos);
        return view(
            $this->templatePath . '.screen.shop_order_success',
            [
                'title'       => sc_language_render('checkout.success_title'),
                'orderInfos'   => $orderInfos??'',
                'layout_page' => 'shop_order_success',
                'breadcrumbs' => [
                    ['url'    => '', 'title' => sc_language_render('checkout.success_title')],
                ],
            ]
        );
    }

    public function processCheckout_(Request $request)
    {
        $this->forgetCartSession();
        $data_request = request()->all();
        $data = session()->get('cart-info');
        if (!$data)
        {
            if (auth()->check())
            {
                $user = auth()->user();
                $data['firstname']  = $user->firstname;
                $data['lastname']  = $user->lastname;
                $data['fullname']  = $user->fullname;
                $data['phone']  = $user->phone;
                $data['email']  = $user->email;
                $data['address_line1']  = $user->address;
                $data['country_code']  = $user->country;
                session()->put('cart-info', $data);
            }
            else
                return redirect(route('cart'));
        }

        $data['delivery'] = $data['delivery'] ?? 'pick_up';

        $payment_method = [];
        if (!empty($data_request['payment_method']))
            $payment_method = explode('__', $data_request['payment_method']);

        $shipping_cost = $data_request['shipping_cost'] ?? 0;

        $option_session = session()->get('option');

        if ($option_session) {
            $option = json_decode($option_session[0], true);

            $cart_content[] = $option;
        } else {
            $cart_content = Cart::content()->toArray();
        }

        $objects = ShopOrderTotal::getObjectOrderTotal();
        $dataTotal = ShopOrderTotal::processDataTotal($objects);

        //Process total
        $subtotal = (new ShopOrderTotal)->sumValueTotal('subtotal', $dataTotal); //sum total
        $tax      = (new ShopOrderTotal)->sumValueTotal('tax', $dataTotal); //sum tax
        $shipping = (new ShopOrderTotal)->sumValueTotal('shipping', $dataTotal); //sum shipping
        $discount = (new ShopOrderTotal)->sumValueTotal('discount', $dataTotal); //sum discount
        $auth_discount = (new ShopOrderTotal)->sumValueTotal('auth_discount', $dataTotal); //sum discount
        $otherFee = (new ShopOrderTotal)->sumValueTotal('other_fee', $dataTotal); //sum other_fee
        $received = (new ShopOrderTotal)->sumValueTotal('received', $dataTotal); //sum received
        $payment_fee = (new ShopOrderTotal)->sumValueTotal('payment_fee', $dataTotal); //sum received
        $total    = (new ShopOrderTotal)->sumValueTotal('total', $dataTotal);
        //end total

        // dd($payment_fee);

        // dd($data_request, $data);
        $payment_method_code = $data_request['payment_method'] ?? '';
        $database = array(
            'firstname' => $data['firstname'] ?? '',
            'lastname' => $data['lastname'] ?? '',
            'name' => $data['fullname'] ?? '',
            'cart_phone' => $data['phone'],
            'cart_email' => $data['email'],
            'cart_address' => $data['address_line1'] ?? '',
            'cart_address2' => $data['address_line2'] ?? '',
            'city' => $data['city_locality'] ?? '',
            'province' => $data['state_province'] ?? '',
            'country_code' => $data['country_code'] ?? '',
            'postal_code' => $data['postal_code'] ?? '',
            'company' => $data['company'] ?? '',
            'shipping_type' => $data['delivery'] ?? '',
            'shipping_cost' => $shipping,
            'payment_fee' => $payment_fee,
            'discount' => $discount,
            'auth_discount' => $auth_discount,
            'cart_note' => $data['cart_note'] ?? '',
            'payment_method' => $payment_method_code,
            'cart_total' => $total,
            'user_id' => Auth::check() ? Auth::user()->id : 0,
            'cart_code' => auto_code(),
            'cart_payment' => 2, //chua thanh toan
            'cart_status' => 1, // cho xac nhan
            'currency' => sc_currency_code(),
            'exchange_rate' => sc_currency_rate()
        );
        // dd($database);

        $respons = \App\Model\Addtocard::create($database);

        $order_id = auto_code('Order', $respons->cart_id);
        $cart = \App\Model\Addtocard::where('cart_id', $respons->cart_id)->first();
        $cart->cart_code = $order_id;
        $cart->save();

        //Create new shop order total
        //Insert order total
        foreach ($dataTotal as $key => $row) {
            $row = sc_clean($row);
            $row['order_id'] = $order_id;
            $row['created_at'] = sc_time_now();
            $dataTotal[$key] = $row;
        }
        ShopOrderTotal::insert($dataTotal);

        //insert in Addtocard_Detail
        foreach ($cart_content as $key => $value) {
            $product_item = \App\Product::find($value['id']);

            \App\Model\Addtocard_Detail::create([
                'product_id' => $value['id'],
                'cart_id'   => $respons->cart_id,
                'admin_id'      => $product_item->admin_id ?? 0,
                'name'          => $value['name'] ?? $product_item->name,
                'quanlity'      => $value['qty'],
                'subtotal'      => $value['subtotal'] ?? ($value['price'] * $value['qty'])
            ]);
        }

        session()->push('cart_code', $cart->cart_code);
        $data_request['cart'] = $respons;
        $data_request['cart_code'] = $cart->cart_code;
        $data_request['cart_content'] = $cart_content;
        $data_request['payment_method'] = $payment_method[1] ?? 'card';
        
        if (!empty($payment_method[0]) && $payment_method[0] == 'stripe')
        {
            return (new \App\Http\Controllers\StripeController)->checkout($data_request); // request to stripe
        }
        elseif (!empty($payment_method[0]) && $payment_method[0] == 'tazapay')
        {
            $data_request['payment_method'] = $payment_method[1] ?? $payment_method[0];
            return (new \App\Http\Controllers\Payment\TazapayController)->checkout($data_request); // request to stripe
        }

        $id_post = $respons->cart_id;
        $title = 'Order payment ' . $order_id;

        if( in_array($data_request['payment_method'], ['vnpay', 'qrcode', 'banks', 'visa'])){
            $data['payment_method'] = $request->payment_method??'';
            $data['bank_code'] = $request->bank_code??'';
            $data['cart_id'] = $cart_id;
            return (new \App\Http\Controllers\PaymentController)->checkout($data);
        }
        
        if(Cart::count() || $option_session){
            if($price){
                try {
                    sc_mail_cart_success($cart_id);

                    Cart::destroy();
                    session()->forget('shipping_data');
                    session()->forget('option');
                    session()->forget('cart-info');
                    if($option_session){
                        session()->forget('option_session');
                    }
                    session()->forget('cart_code');
                    session()->push('cart_code', $cart->cart_code);
                    return redirect()->route('cart.checkout.success');
                } catch(Exception $e) {
                    return $e->getMessage();
                }
            }
        }
    }

    public function success()
    {
        if (!session('orderIDs')) {
            return redirect(url('/'));
        }
        // $cart = \App\Model\ShopOrder::where('cart_code', $cart_code)->first();
        $orderInfos = ShopOrder::with('details')->whereIn('id', session('orderIDs'))->get()->toArray();

        return view(
            $this->templatePath . '.cart.checkout-success',
            [
                'title'       => sc_language_render('checkout.success_title'),
                'orderInfos'   => $orderInfos??'',
                'breadcrumbs' => [
                    ['url'    => '', 'title' => sc_language_render('checkout.success_title')],
                ],
            ]
        );
    }

    public function view($id)
    {
        if($id)
        {
            $order_detail = \App\Model\ShopOrder::where('cart_code', $id)->first();
            $this->data['order'] = $order_detail;
            $this->data['order_detail'] = \App\Model\ShopOrderDetail::where('cart_id', $this->data['order']->cart_id)->get();

            //shipping data
            $this->data['shipping_data'] = $order_detail->shipping_data ? json_decode($order_detail->shipping_data, true): [];
            $shipping_order = $order_detail->getShippingOrder;
            $this->data['shipping_order'] = $shipping_order;
            $this->data['shipping_code'] = $shipping_order->shipping_code??'';
            if($this->data['shipping_code'])
            {
                $this->data['shipping_log'] = $this->ghn_service->checkShippingOrder($this->data['shipping_code']);
            }
            //shipping data

            $total_price = isset($order_detail->total) ? $order_detail->total : 0;

            // $data = ShopOrder::where('user_id', Auth::user()->id)->where('cart_id', $id_cart)->first();
            if($this->data['order']){
                $this->data['seo'] = [
                    'seo_title' => 'Đơn hàng - '. $this->data['order']->cart_code,

                ];
                return view($this->templatePath .'.cart.view', $this->data);
            }
            else
                return view('errors.404');
        }

    }

    public function checkPayment($cart_id)
    {
        $this->localized();
        $this->data['cart'] = \App\Model\ShopOrder::where('cart_id', $cart_id)->first();
        // dd($cart);
        if($this->data['cart'] && $this->data['cart']['cart_status'] =='waiting-payment')
            return view($this->templatePath .'.cart.check-payment', $this->data);
        else
            return redirect(url('/'));
    }

    public function requestPaymentSuccess($cart_code)
    {
        $cart = \App\Model\ShopOrder::where('cart_code', $cart_code)->first();
        // dd($cart);
        if($cart)
        {
            $this->data['cart'] = $cart;
            $this->data['seo'] = [
                'seo_title' => 'Yêu cầu đã thanh toán cho đơn hàng '. $cart_code,
            ];
            return view($this->templatePath .'.cart.request_payment', $this->data);
        }
        else
            return view('errors.404');
    }

    public function post_requestPaymentSuccess()
    {
        $data_email = request()->all();

        $checkContent = ShopEmailTemplate::where('group', 'request_payment_success')->where('status', 1)->first();
        if($checkContent){
            $email_admin       = setting_option('email_admin');
            $company_name      = setting_option('company_name');
            
            $content = htmlspecialchars_decode($checkContent->text);
            $orderID_link = '<a href="'. route('cart.view', $data_email['cart_code']) .'">'. $data_email['cart_code'] .'</a>';
            $dataFind = [
                '/\{\{\$orderID_link\}\}/',
                '/\{\{\$orderID\}\}/',
                '/\{\{\$toname\}\}/',
                '/\{\{\$email\}\}/',
                '/\{\{\$phone\}\}/',
                '/\{\{\$comment\}\}/',
            ];
            $dataReplace = [
                $orderID_link ?? '',
                $data_email['cart_code'] ?? '',
                $data_email['request_name'] ?? '',
                $data_email['request_email'] ?? '',
                $data_email['request_phone']??'',
                $data_email['request_message']??'',
            ];
            $content = preg_replace($dataFind, $dataReplace, $content);

            $dataView = [
                'content' => $content,
            ];
            $config = [
                'to' => $email_admin,
                'subject' => 'Thông báo đơn hàng '.$data_email['cart_code'] . ' đã được thanh toán.',
            ];

            $file_path = '';
            $attach = [];
            $folderPath = '/images/paid-file';
            if(isset($data_email['request_file'])){
                $file = request()->file("request_file");

                $filename_original = $file->getClientOriginalName();
                $filename_ = pathinfo($filename_original, PATHINFO_FILENAME);
                $extension_ = pathinfo($filename_original, PATHINFO_EXTENSION);

                $file_slug = Str::slug($filename_);
                $file_name = uniqid() . '-' . $file_slug . '.' . $extension_;
                $img_name = $folderPath . '/' . $file_name;
                $file_path = $img_name;

                $attach['fileAttach'][] = [
                        'file_path' => asset($img_name),
                        'file_name' => $filename_
                ];
                
                $file->move(base_path().$folderPath, $file_name);
            }

            \App\Model\ContactPayment::create([
                'name' => $data_email['request_name'] ?? '',
                'email' => $data_email['request_email'] ?? '',
                'phone' => $data_email['request_phone']??'',
                'content' => $data_email['request_message']??'',
                'file' => $file_path,
            ]);

            $send_mail = new SendMail( 'email.content', $dataView, $config , $attach);
            $sendEmailJob = new Job_SendMail($send_mail);
            dispatch($sendEmailJob)->delay(now()->addSeconds(5));

            return response()->json(
                [
                    'error' => 0,
                    'view' => view($this->templatePath .'.cart.includes.send_request_payment_success')->render(),
                    'msg'   => __('Login success')
                ]
            );
        }
    }

    public function orderStatus()
    {
        $data = [
            '0' => 'Chờ xác nhận',
            '1' => 'Đã hủy',
            '2' => 'Đã nhận',
            '3' => 'Đang giao hàng',
            '4' => 'Hoàn thành',
        ];

        return $data;
    }

    public function orderPayment()
    {
        $data = [
            '0' => 'Chưa thanh toán',
            '1' => 'Đã thanh toán',
        ];

        return $data;
    }

    public function forgetCartSession()
    {
        session()->forget('cart_code');
    }

    /**
     * Remove cart store ordered
     */
    private function clearCartStore()
    {
        $dataCheckout = session('dataCheckout') ?? '';
        if ($dataCheckout) {
            foreach ($dataCheckout as $key => $row) {
                Cart::remove($row->rowId);
            }
        }
    }

    /**
     * Clear session
     */
    private function clearSession()
    {
        session()->forget('option');
        session()->forget('cart-info');
        session()->forget('payment_code');

        session()->forget('paymentMethod'); //destroy paymentMethod
        session()->forget('shippingMethod'); //destroy shippingMethod
        session()->forget('totalMethod'); //destroy totalMethod
        session()->forget('otherMethod'); //destroy otherMethod
        session()->forget('dataTotal'); //destroy dataTotal
        session()->forget('dataCheckout'); //destroy dataCheckout
        session()->forget('storeCheckout'); //destroy storeCheckout
        session()->forget('dataOrder'); //destroy dataOrder
        session()->forget('arrCartDetail'); //destroy arrCartDetail
        session()->forget('orderID'); //destroy orderID
    }
}
