<?php

namespace App\Http\Controllers\Payment;

use Illuminate\Http\Request;
use Cart, Auth;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\View;
use App\Model\PaymentRequest;
use Illuminate\Support\Facades\Log;


class VNPAYController extends Controller {
    public function index() {
        //
    }

    public function processOrder(){

        $dataOrder = session('dataOrder')?? [];
        $currency = $dataOrder['currency'] ?? '';

        //Validate order id exist
        if (session('orderID')) {
            return $this->prepareDataBeforeSend();
        } else {
            return redirect(sc_route('cart'))
                ->with(['error' => sc_language_render('cart.order_not_found')]);
        }
        
    }

    /**
     * Process data before send to vnpay
     */
    public function prepareDataBeforeSend() {
        $vnp_Url = $this->plugin->urlApi;
        $vnp_HashSecret = $this->plugin->getSecretKey();
        $dataOrder = session('dataOrder')?? [];
        $inputData = array(
            "vnp_Version" => "2.0.0",
            "vnp_TmnCode" => $this->plugin->getPartnerCode(),
            "vnp_Amount" => $dataOrder['total'] * 100, // require * 100
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $_SERVER['REMOTE_ADDR'],
            "vnp_Locale" => 'vn',
            "vnp_OrderInfo" => 'Shop SCart',
            "vnp_OrderType" => '1',
            "vnp_ReturnUrl" => sc_route('vnpay_basic.process'),
            "vnp_TxnRef" => session('orderID'),
        );
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . $key . "=" . $value;
            } else {
                $hashdata .= $key . "=" . $value;
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }
        $vnp_Url = $vnp_Url . "?" . $query;
        
        // $vnpSecureHash = hash('sha256', $vnp_HashSecret . $hashdata);
        $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);

        $vnp_Url .= 'vnp_SecureHashType=SHA256&vnp_SecureHash=' . $vnpSecureHash;
        return redirect($vnp_Url);
    }

    /**
     * Process order info response in page redirect
     */
    public function processResponse() {
        $customer = session('customer');
        $orderID = session('orderID');
        // Check order id response
        if(!$orderID) {
            $msg = sc_language_render($this->plugin->pathPlugin.'::lang.process_invalid');
            return redirect(sc_route('cart'))->with(['error' => $msg]);
        }
        $dataResponse = request()->all();

        //Cancel
        if($dataResponse['vnp_ResponseCode'] === '24') {
            return redirect(sc_route('cart'));
        }
        //Error 
        if($dataResponse['vnp_ResponseCode'] !== '00') {
            $msg = sc_language_render($this->plugin->pathPlugin.'::lang.error_number', ['code' => $dataResponse['vnp_ResponseCode']]);
            return redirect(sc_route('cart'))->with(['error' => $msg]);
        }

        //Success
        if($dataResponse['vnp_ResponseCode'] === '00') {
            $vnpBankTranNo = $dataResponse['vnp_BankTranNo'];
            $vnpSecureHash = $dataResponse['vnp_SecureHash'];
            unset($dataResponse['vnp_SecureHashType']);
            unset($dataResponse['vnp_SecureHash']);
            ksort($dataResponse);
            $i = 0;
            $hashData = "";
            foreach ($dataResponse as $key => $value) {
                if ($i == 1) {
                    $hashData = $hashData . '&' . $key . "=" . $value;
                } else {
                    $hashData = $hashData . $key . "=" . $value;
                    $i = 1;
                }
            }
            //Compare vnpSecureHash
            $secureHash = hash('sha256',$this->plugin->getSecretKey() . $hashData);
            if($secureHash !== $vnpSecureHash) {
                $msg = sc_language_render($this->plugin->pathPlugin.'::lang.process_invalid');
                return redirect(sc_route('cart'))->with(['error' => $msg]);
            }

            ShopOrder::find($orderID)->update([
                'transaction' => $dataResponse['vnp_BankTranNo'], 
                'status' => sc_config('vnpay_order_status_success', 2),
                'payment_status' => sc_config('vnpay_payment_status', 3)
                ]);

            //Add history
            $dataHistory = [
                'order_id' => $orderID,
                'content' => 'Transaction ' . $vnpBankTranNo,
                'customer_id' => $customer->id ?? 0,
                'order_status_id' => sc_config('vnpay_order_status_success', 2),
            ];
            (new ShopOrder)->addOrderHistory($dataHistory);
            //Complete order

            return (new ShopCartController)->completeOrder();

        }
    }

    /**
     * Process IPN
     */
    public function processIpn()
    {
        //
    }
}
