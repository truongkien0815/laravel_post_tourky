<?php
use Illuminate\Support\Str;
use App\Model\Setting;
use App\Model\SettingWatermark;
use App\Model\ShopCurrency;
use App\Libraries\Helpers;
use App\Model\BlockContent;
use App\Mail\SendMail;
use App\Jobs\Job_SendMail;
use Illuminate\Support\Facades\Mail;

//Product kind
define('SC_PRODUCT_SINGLE', 0);
define('SC_PRODUCT_BUILD', 1);
define('SC_PRODUCT_GROUP', 2);
//Product property
define('SC_PROPERTY_PHYSICAL', 'physical');
define('SC_PROPERTY_DOWNLOAD', 'download');
// list ID admin guard
define('SC_GUARD_ADMIN', ['1']); // admin
// list ID language guard
define('SC_GUARD_LANGUAGE', ['1', '2']); // vi, en
// list ID currency guard
define('SC_GUARD_CURRENCY', ['1', '2']); // vndong , usd
// list ID ROLES guard
define('SC_GUARD_ROLES', ['1', '2']); // admin, only view

define('SC_PRICE_FILTER', [1 => 'Từ 0 - 1.000.000 đ', 2=>'Từ 1.000.000 đ - 3.000.000 đ',3=>'Từ 3.000.000 đ - 5.000.000 đ', 4=>'Từ 5.000.000 đ - 10.000.000 đ',5=>'Từ 10.000.000 đ - Trở lên']); // price filter

/**
 * Admin define
 */
define('SC_ADMIN_MIDDLEWARE', ['web', 'admin']);
define('SC_FRONT_MIDDLEWARE', ['web', 'front']);
define('SC_API_MIDDLEWARE', ['api', 'api.extent']);
define('SC_CONNECTION', 'mysql');
define('SC_CONNECTION_LOG', 'mysql');
//Prefix url admin
define('SC_ADMIN_PREFIX', env('ADMIN_PREFIX', 'admin'));

// Root ID store
define('SC_ID_ROOT', 1);


if (!function_exists('convert_to_slug')) {
    function convert_to_slug($value)
    {
        return Str::slug($value);
    }
}

if (!function_exists('setting_option')) {
    function setting_option($variable = '')
    {
        if (Cache::has('theme_option')) {
            $data = Cache::get('theme_option');
        // dd($data);
        }
        else{
            $data = Setting::get();
            Cache::forever('theme_option', $data);
        }
        if($data){
            $option = $data->where('name', $variable)->first();
            // dd($option);
            if($option){
                $content = $option->content;
                if($option->type == 'editor' || $option->type == 'text')
                    $content = htmlspecialchars_decode(htmlspecialchars_decode($content));
                return $content;
            }
        }
    }
}
if (!function_exists('setting_watermark')) {
    function setting_watermark($variable = '')
    {
        $data = SettingWatermark::get();
    
        if($data){
            $option = $data->where('name', $variable)->first();
            // dd($option);
            if($option){
                $content = $option->content;
                if($option->type == 'editor' || $option->type == 'text')
                    $content = htmlspecialchars_decode(htmlspecialchars_decode($content));
                return $content;
            }
        }
    }
}

if (!function_exists('get_template')) {
    function get_template()
    {
        return Helpers::getTemplatePath();
    }
}

if (!function_exists('render_price')) {
    function render_price(float $money, $currency = null, $rate = null, $space_between_symbol = false, $useSymbol = true)
    {
        return ShopCurrency::render($money, $currency, $rate, $space_between_symbol, $useSymbol);
    }
}
if (!function_exists('render_option_name')) {
    function render_option_name($att)
    {
        if($att){
            $att_array = explode('__', $att);
            if(isset($att_array[0]))
                return $att_array[0];
        }
    }
}
if (!function_exists('render_option_price')) {
    function render_option_price($att)
    {
        if($att){
            $att_array = explode('__', $att);
            if(isset($att_array[2]))
                return render_price($att_array[2]);
            elseif(isset($att_array[1]))
                return render_price($att_array[1]);
        }
    }
}
if (!function_exists('auto_code')) {
    function auto_code($code = 'Order', $cart_id = 0){
        $number_start = 5000;
        // $strtime_conver=strtotime(date('d-m-Y H:i:s'));
        // $strtime=substr($strtime_conver,-4);
        // $rand=substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 4);
        $string_rand = $code . ($number_start + $cart_id);
        return $string_rand;
    }
}

/*
Get all layouts
 */
if (!function_exists('sc_store_block')) {
    function sc_store_block()
    {
        return BlockContent::getLayout();
    }
}

if(!function_exists('queryParam')) {
    function queryParam($routeName, $params=[]){
        if(count($params))
        {
            $params_ = [];
            foreach($params as $key => $item)
            {
                if($item != '')
                {
                    $params_[$key]  = $item;
                }
                
            }
            return route($routeName, $params_);
        }
    }
}


/**
 * Function render point data
 */
if (!function_exists('sc_product_get_rating')) {
    function sc_product_get_rating($pId = 0) {
        if (sc_config_global('ProductReview')) {
            $pointData = \App\Plugins\Cms\ProductReview\Models\PluginModel::getPointData($pId);
        } else {
            $pointData =  [];
        }
        return $pointData;
    }
}


if (!function_exists('sc_push_include_view')) {
    /**
     * Push view
     *
     * @param   [string]  $position
     * @param   [string]  $pathView
     *
     */
    function sc_push_include_view($position, $pathView)
    {
        $includePathView = config('sc_include_view.'.$position, []);
        $includePathView[] = $pathView;
        config(['sc_include_view.'.$position => $includePathView]);
    }
}


if (!function_exists('sc_push_include_script')) {
    /**
     * Push script
     *
     * @param   [string]  $position
     * @param   [string]  $pathScript
     *
     */
    function sc_push_include_script($position, $pathScript)
    {
        $includePathScript = config('sc_include_script.'.$position, []);
        $includePathScript[] = $pathScript;
        config(['sc_include_script.'.$position => $includePathScript]);
    }
}


if (!function_exists('sc_html_render')) {
    /*
    Html render
     */
    function sc_html_render($string)
    {
        $string = htmlspecialchars_decode($string);
        return $string;
    }
}

if (!function_exists('sc_mail_cart_success'))
{
    function sc_mail_cart_success($cart_id, $queue=false)
    {
        $cart = \App\Model\ShopOrder::where('cart_id', $cart_id)->first();
        $shop_payment_method = \App\Model\ShopPaymentMethod::where('status', 1)->get()->pluck('name', 'code')->toArray();
        if($cart)
        {
            $order_id = $cart->cart_code;
            $data_email = $cart->toArray();
            $data_email['email_admin'] = setting_option('email_admin');
            $data_email['subject_default'] = 'Payment success';

            $checkContent = \App\Model\ShopEmailTemplate::where('group', 'order_to_user')->where('status', 1)->first();
            $checkContent_admin = \App\Model\ShopEmailTemplate::where('group', 'order_to_admin')->where('status', 1)->first();
            if($checkContent || $checkContent_admin)
            {
                $email_admin       = setting_option('email_admin');
                $company_name      = setting_option('company_name');
                
                $content = htmlspecialchars_decode($checkContent->text);
                $content_admin = htmlspecialchars_decode($checkContent_admin->text);

                $order_detail = \App\Model\ShopOrderDetail::where('cart_id', $cart_id)->get();
                $orderDetail = '';
                foreach ($order_detail as $key => $detail) 
                {
                    $product = $detail->getProduct;
                    $nameProduct = $detail->name;
                    $product_attr = '';
                    
                    if ($detail->option)
                    {
                        $attribute = json_decode($detail->option, true);
                        foreach ($attribute as $groupAtt => $attrs){
                            foreach ($attrs as $item){
                                $product_attr .= '<tr><td>' . $item['name'] .'</td><td><strong>'. $item['value'] .'</strong></td></tr>';
                            }
                        }
                    }
                    $orderDetail .= '<tr><td colspan="2"><b>' . ($key + 1) .'.'. $detail->name .'</b></td></tr>';
                    $orderDetail .= $product_attr;
                    $orderDetail .= '<tr><td width="150">Price:</td><td><strong>' .render_price($detail->subtotal/$detail->quanlity) . '</strong></td></tr>';
                    $orderDetail .= '<tr><td>Qty:</td><td><strong>' . number_format($detail->quanlity) . '</strong></td></tr>';
                    $orderDetail .= '<tr><td>Total:</td><td><strong>' . render_price($detail->subtotal) . '</strong></td></tr>';
                    $orderDetail .= '<tr><td colspan="2"><hr></td></tr>';
                }

                //Phương thức nhận hàng
                $receive = $cart->shipping_type??'pick_up';
                $receive_html = '';
                if($receive == 'pick_up')
                {
                    $address_full = '';
                    $receive_html .= '<div>- Nhận tại cửa hàng: </div>'. htmlspecialchars_decode(setting_option('pickup_address'));
                }
                else
                {
                    $address_full = $cart->getAddressFull();
                    $receive_html .= '<p>- Vận chuyển đến: '. $address_full .'<p>';
                }

                //phuong thuc thanh toan
                $payment_method = $cart->payment_method ?? 'cash';
                $payment_method_html = '';
                if($payment_method == 'cash')
                {
                    $payment_method_html = '<div>- Thanh toán bằng tiền mặt khi nhận hàng</div>';
                }
                elseif(!empty($shop_payment_method[$payment_method]))
                {
                    $payment_method_html = '<div class="mb-3">- '. $shop_payment_method[$payment_method] .'</div>';
                    // $payment_method_html .= htmlspecialchars_decode(setting_option('banks'));
                }

                $shipping_cost = $cart->shipping_cost??0;

                $dataFind = [
                    '/\{\{\$orderID\}\}/',
                    '/\{\{\$toname\}\}/',
                    '/\{\{\$email\}\}/',
                    '/\{\{\$address\}\}/',
                    '/\{\{\$phone\}\}/',
                    '/\{\{\$comment\}\}/',
                    '/\{\{\$shipping_cost\}\}/',
                    '/\{\{\$subtotal\}\}/',
                    '/\{\{\$total\}\}/',
                    '/\{\{\$receive\}\}/',
                    '/\{\{\$orderDetail\}\}/',
                    '/\{\{\$payment_method\}\}/',
                ];
                $dataReplace = [
                    $order_id ?? '',
                    $data_email['name'] ?? '',
                    $data_email['cart_email'] ?? '',
                    $data_email['cart_address']??'',
                    $data_email['cart_phone']??'',
                    $data_email['cart_note']??'',
                    render_price($shipping_cost),
                    render_price($cart->cart_total),
                    render_price($cart->cart_total + $shipping_cost),
                    $receive_html,
                    $orderDetail,
                    $payment_method_html,
                ];
                $content = preg_replace($dataFind, $dataReplace, $content);
                $content_admin = preg_replace($dataFind, $dataReplace, $content_admin);
                // dd($content);
                $dataView = [
                    'content' => $content,
                ];
                $config = [
                    'to' => $data_email['cart_email'],
                    'subject' => 'Đơn hàng mới - Mã đơn hàng: '.$order_id,
                ];

                $dataView_sys = [
                    'content' => $content_admin,
                ];
                $config_sys = [
                    'to' => $email_admin,
                    'cc' => array_filter([setting_option('email_admin_cc'),setting_option('email_admin_cc_1'),setting_option('email_admin_cc_2')]),
                    'subject' => 'Đơn hàng mới - Mã đơn hàng: '.$order_id,
                ];

                if($data_email['cart_email'])
                {
                    $send_mail = new SendMail( 'email.content', $dataView, $config );
                    if(!$queue)
                        Mail::send($send_mail);
                    else
                    {
                        $sendEmailJob = new Job_SendMail($send_mail);
                        dispatch($sendEmailJob)->delay(now()->addSeconds(5));
                    }
                }

                $send_mail_admin = new SendMail( 'email.content', $dataView_sys, $config_sys );
                if(!$queue)
                    Mail::send($send_mail_admin);
                else
                {
                    $sendEmailJob_admin = new Job_SendMail($send_mail_admin);
                    dispatch($sendEmailJob_admin)->delay(now()->addSeconds(3));
                }
            }
        }
    }
}

if (!function_exists('sc_get_full_address')) {
    /*
    Html render
     */
    function sc_get_address($data)
    {
        if(!empty($data['customer_ward']))
        {
            $ward = \App\Model\LocationWard::where('name', $data['customer_ward'])->orWhere('type_name', $data['customer_ward'])->first();
        }
        if(!empty($data['customer_district']))
        {
            $district = \App\Model\LocationDistrict::where('name', $data['customer_district'])->orWhere('type_name', $data['customer_district'])->first();
        }
        if(!empty($data['customer_province']))
        {
            $province = \App\Model\LocationProvince::where('name', $data['customer_province'])->first();
            // dd($province);
        }

        // $address_arr = array_filter([$data['address_line1']??'', $ward['type_name']??'', $district['type_name']??'', $province['type_name']??'']);
        return [
            'address_line1' => $data['address_line1']??'',
            'address_line2' => $data['address_line2']??'',
            'ward' => $ward['type_name']??'',
            'district' => $district['type_name']??'',
            'province' => $province['name']??'',
        ];
    }
}
if (!function_exists('sc_get_full_address')) {
    /*
    Html render
     */
    function sc_render_address($data)
    {
        $address_array = array_filter(sc_get_address($data));
        return implode(', ', $address_array);
    }
}