<?php 

use App\Model\ShopPaymentMethod;

if (!function_exists('sc_payment_setting') && !in_array('sc_payment_setting', config('sc_payment_setting', []))) {
    //Get all language
    function sc_payment_setting($code)
    {
        $setting = (new ShopPaymentMethod)->where('code', $code)->first();
        if($setting)
        	$setting = $setting->setting->pluck('value', 'key')->toArray();
        return $setting;
    }
}

if(!function_exists('sc_payment_getway'))
{
    function sc_payment_getway($value)
    {
        $arr = explode('__', $value);
        if(!empty($arr[0]))
        {
            $nameSpace = $arr[0];
            $code = sc_word_format_class($nameSpace);
            if($code)
                return '\App\Plugins\Payment\\'. $code . '\Controllers\FrontController';
        }
    }
}