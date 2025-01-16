<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cart, Auth;
use App\Page as Page;
use Illuminate\Support\Facades\View;
use Gornymedia\Shortcodes\Facades\Shortcode;
use App\Model\PaymentRequest;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller {
    use \App\Traits\LocalizeController;
    
    public $data = [];

    public function checkout($data) {
        // dd($data);
    	$this->localized();
        $startTime = date("YmdHis");
        $expire = date('YmdHis',strtotime('+15 minutes',strtotime($startTime)));

        $cart_id = $data['cart_id']??0;
        $cart_detail = \App\Model\Addtocard::where('cart_id', $cart_id)->first();

        if($cart_detail)
        {
            $amount = ($cart_detail->cart_total + $cart_detail->shipping_cost) * 100;
        }
        else
            $amount = $data['cart_total'] ? str_replace(',', '', $data['cart_total']) * 100 : 0;
    	
        $dataPayment = [
            'user_id' => auth()->check() ? auth()->user()->id : 0,
            'cart_id' => $cart_id,
            'amount' => $amount / 100,
            'content' => $data['cart_note'] ?? "Thanh toán đơn hàng $cart_id",
            'status' => 0,
            'payment_status' => 'Thanh toán kinh phí',
            'payment_method' => 'VNPay '. ($data['banks']??''),
            'send_mail' => 0,
        ];

        try {
            $vnp_TmnCode = env('VNPAY_TmnCode');
            $dataPayment['payment_method'] = $data['payment_method'];
            $payment_create = \App\Model\PaymentRequest::create($dataPayment);

            $purchase = array(
                "vnp_Version" => "2.1.0",
                "vnp_TmnCode" => $vnp_TmnCode,
                "vnp_Amount" => $amount,
                "vnp_Command" => "pay",
                "vnp_CreateDate" => date('YmdHis'),
                "vnp_CurrCode" => "VND",
                'vnp_IpAddr' => '127.0.0.1',
                "vnp_Locale" => 'vn',
                "vnp_OrderInfo" => $data['cart_note'] ?? "Thanh toán đơn hàng $cart_id",
                "vnp_OrderType" => "other",
                "vnp_ReturnUrl" => route('payment.return'),
                "vnp_TxnRef" => $payment_create->id,
                "vnp_ExpireDate"=>$expire,
            );
            if(!empty($data['bank_code']))
            {
                $purchase['vnp_BankCode'] = $data['bank_code'];
                // dd($purchase);
            }

            $vnp_Url = $this->getPurchaseVNPay($purchase);
            // dd($vnp_Url);

            $payment_create->payment_url = $vnp_Url;
            $payment_create->save();

            if ($vnp_Url) {
                session()->forget('cart_code');
                session()->push('cart_code', $cart_detail->cart_code);
                Cart::destroy();
                session()->forget('shipping_data');
                return redirect($vnp_Url);
            } else {
                // not successful
                return $response->getMessage();
            }

        } catch(Exception $e) {

            return $e->getMessage();
        }
        
        // return view('theme.home', ['data' => $this->data]);
    }

    public function getPurchaseVNPay($purchase)
    {
        // $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Url = "https://pay.vnpay.vn/vpcpay.html";
        $vnp_HashSecret = env('VNPAY_HashSecret');

        $getSecureHash = $this->getSecureHash($purchase);

        $vnp_Url = $vnp_Url . "?" . $getSecureHash['query'];
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   $getSecureHash['vnpSecureHash'];
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        return $vnp_Url;
    }
    public function getSecureHash($purchase)
    {
        $vnp_HashSecret = env('VNPAY_HashSecret');
        unset($purchase['vnp_SecureHash']);
        ksort($purchase);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($purchase as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);

        return [
            'hashdata' => $hashdata,
            'query' => $query,
            'vnpSecureHash' => $vnpSecureHash,
        ];
    }

    public function payment_return()
    {
        $this->localized();
        $this->data['title'] = 'Thanh toán đơn hàng';
        $this->data['seo'] = [
            'seo_title' => $this->data['title']
        ];
        $inputData = array();
        $response = request()->all();
        foreach ($response as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }
        $vnp_SecureHash = $inputData['vnp_SecureHash'];

    	$getSecureHash = $this->getSecureHash($inputData);
        $secureHash = $getSecureHash['vnpSecureHash'];

        $payment_id = $response['vnp_TxnRef'];
        $payment = PaymentRequest::where('id', $payment_id)->first();
        
        $cart = \App\Model\Addtocard::find($payment->cart_id);
        $this->data['cart'] = $cart;
        $this->data['payment'] = $payment;

        if($payment && $secureHash == $vnp_SecureHash)
        {
        	$payment_status = $response['vnp_TransactionStatus'] == '00' ? 'GD Thành công' : 'GD không thành công';
        	
    		if ($response['vnp_TransactionStatus'] == '00') {
                if(!empty($payment->cart_id) && $payment->send_mail == 0)
                {
                    if($cart->cart_email !='')
                        sc_mail_cart_success($payment->cart_id); //send mail 
                    PaymentRequest::where('id', $payment_id)->update([
                        'send_mail' => 1
                    ]);
                }

    			// TODO: xử lý kết quả và hiển thị.
                return view($this->templatePath .'.payment.success', $this->data);
    		    
    		} else {
                return view($this->templatePath .'.payment.reject', $this->data);
    		}
        }
        else {
            $this->data['payment'] = PaymentRequest::find($payment_id);
            $this->data['message'] = 'Invalid signature';
            return view($this->templatePath .'.payment.reject', $this->data);
        }
    }

    public function payment_ipn()
    {
        $this->localized();
        try {
            $inputData = array();
            $returnData = array();
            $vnp_HashSecret = env('VNPAY_HashSecret');

            $data = request()->all();

            if(count($data))
            {
                foreach ($data as $key => $value) {
                    if (substr($key, 0, 4) == "vnp_") {
                        $inputData[$key] = $value;
                    }
                }

                $getSecureHash = $this->getSecureHash($inputData);
                $secureHash = $getSecureHash['vnpSecureHash'];

                $this->data['payment'] = $data;
                $payment_status = $data['vnp_ResponseCode'] == '00' ? 'GD Thành công' : 'GD không thành công';
                $amount = $data['vnp_Amount'] ? $data['vnp_Amount'] / 100 : 0;

                $payment_data = \App\Model\PaymentRequest::find($data['vnp_TxnRef']);
                
                if($payment_data){
                    $vnp_SecureHash = $inputData['vnp_SecureHash'];
                    unset($inputData['vnp_SecureHashType']);
                    unset($inputData['vnp_SecureHash']);
                    ksort($inputData);

                    $i = 0;
                    $hashData = "";
                    foreach ($inputData as $key => $value) {
                        if ($i == 1) {
                            $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
                        } else {
                            $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                            $i = 1;
                        }
                    }

                    if ($secureHash == $vnp_SecureHash)
                    {
                        if($payment_data->amount == $inputData['vnp_Amount']/100)
                        {
                            if ($payment_data->status != '' && $payment_data->status == 0) 
                            {
                                if ($inputData['vnp_ResponseCode'] == '00') 
                                {
                                    // Log::info('Payment vnp_ResponseCode: '.$inputData['vnp_ResponseCode']);
                                    $Status = 1; // Trạng thái thanh toán thành công
                                    
                                    \App\Model\Addtocard::find($payment_data->cart_id)->update([
                                        'cart_payment' => 1 // cho xac nhan
                                    ]);
                                } else {
                                    // Log::info('Payment vnp_ResponseCode 1: '.$inputData['vnp_ResponseCode']);
                                    $Status = 2; // Trạng thái thanh toán thất bại / lỗi
                                }

                                //Cài đặt Code cập nhật kết quả thanh toán, tình trạng đơn hàng vào DB
                                $data_db = array(
                                    'payment_code' => $data['vnp_TransactionNo'] ?? '',
                                    'content' => $data['vnp_OrderInfo'] ?? '',
                                    'status' => $Status,
                                    'payment_status' => $payment_status,
                                    'bank_code' => $data['vnp_BankCode'] ?? ''
                                );
                                
                                $db_update = \App\Model\PaymentRequest::find($payment_data->id)->update($data_db);
                                /*if($Status == 1){
                                    if($payment_data->user_id && $payment_data->user_id > 0){
                                        // Log::info('user id vua nap tien: '.$payment_data->user_id);
                                        $xu_setting = setting_option('vnd-to-xu');
                                        $xu = $amount / $xu_setting;
                                        $user = \App\User::find($payment_data->user_id);
                                        $wallet = $user->wallet;
                                        $wallet = $wallet + $xu ;
                                        $user->update(['wallet' => $wallet]);
                                    }
                                }*/
                                //
                                //
                                //
                                //Trả kết quả về cho VNPAY: Website/APP TMĐT ghi nhận yêu cầu thành công   
                                $returnData['RspCode'] = '00';
                                $returnData['Message'] = 'Confirm Success';
                            }
                            else {
                                $returnData['RspCode'] = '02';
                                $returnData['Message'] = 'Order already confirmed';
                            }
                        }
                        else {
                            $returnData['RspCode'] = '04';
                            $returnData['Message'] = 'invalid amount';
                        }

                    }
                    else {
                        $returnData['RspCode'] = '97';
                        $returnData['Message'] = 'Invalid signature';
                    }
                }
                else {
                    $returnData['RspCode'] = '01';
                    $returnData['Message'] = 'Order not found';
                }
            }

        } catch (Exception $e) {
            $returnData['RspCode'] = '99';
            $returnData['Message'] = 'Unknow error';
        }
        //log merchant
        $data_log = [
            'response_code'    => $returnData['RspCode']??'',
            'message'    => $returnData['Message']??'',
            'ip'    => request()->ip(),
            'data'  => json_encode($data, JSON_UNESCAPED_UNICODE)
        ];
        Log::info('Payment error: '.$returnData['RspCode']);
        // Log::debug('log merchant: '. json_encode($data_log, JSON_UNESCAPED_UNICODE));
        \App\Model\VNPayLog::create($data_log);
        
        // echo json_encode($returnData); die;

        return response()->json($returnData);

    }

    public function paymentSuccess()
    {
        $this->localized();
        $this->data['payment'] = \App\Model\PaymentRequest::where('status', '<>', 1)->where('user_id', auth()->user()->id)->orderbyDesc('id')->first();

    	return view('theme.payment.success', ['data'=>$this->data]);
    }

    //nap tien
    public function paymentPoint()
    {
        $this->localized();
        return view('theme.payment.payment-point', ['data'=>$this->data]);
    }

    public function paymentType(Request $request)
    {
    	$type = $request->type;
    	$this->data['payment_type'] = $type;

        $templateName = $this->templatePath .'.payment.includes.' . $type;
        if (View::exists($templateName)) 
        {
            $this->data['view'] = view($templateName,  $this->data)->render();
            return response()->json($this->data);
        }

    	/*if($type == 'qrcode'){
    		$view = view('theme.payment.includes.qrcode')->render();
    	}
    	elseif($type == 'atm'){
    		$view = view('theme.payment.includes.banks')->render();
    	}
    	elseif($type == 'visa'){
    		$view = view('theme.payment.includes.visa')->render();
    	}
    	$this->data['view'] = $view;
    	return response()->json($this->data);*/
    }
}
