<?php
#App\Plugins\Payment\VnpayBasic\Controllers\FrontController.php
namespace App\Plugins\Payment\Vnpay\Controllers;

use App\Plugins\Payment\Vnpay\AppConfig;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

use App\Model\ShopOrder;
use App\Model\PaymentRequest;
use App\Model\VNPayLog;

class FrontController extends Controller
{
    public $plugin;

    public function __construct()
    {
        parent::__construct();
        $this->plugin = new AppConfig;
    }

    public function index() {
        //
    }

    public function processOrder(){
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

        $create_date = Carbon::now()->format('YmdHis');
        $expire = Carbon::now()->addHours(2)->format('YmdHis');

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $this->plugin->getVnpTmnCode(),
            "vnp_Amount" => $dataOrder['total'] * 100, // require * 100
            "vnp_Command" => "pay",
            "vnp_CreateDate" => $create_date,
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $_SERVER['REMOTE_ADDR'],
            "vnp_Locale" => 'vn',
            "vnp_OrderInfo" => 'HAAN Fashion',
            "vnp_OrderType" => 'other',
            "vnp_ReturnUrl" => route('vnpay.process'),
            "vnp_TxnRef" => session('orderID'),
            'vnp_ExpireDate'    => $expire,
        );

        $payment_method = explode('__', $dataOrder['payment_method']);
        if(isset($payment_method[1]))
        {
            $bank_code = $payment_method[1];
            if($bank_code == 'banks')
                $bank_code = session()->get('bank_code')??'';
        }

        $inputData['vnp_BankCode'] = $bank_code;
        // dd($inputData);

        $getHashMac = $this->plugin->getHashMac($inputData);

        $vnp_Url = $vnp_Url . "?" . $getHashMac['query'];
        $vnp_Url .= 'vnp_SecureHash=' . $getHashMac['vnpSecureHash'];

        ShopOrder::find(session('orderID'))->update([
            'payment_url'   => $vnp_Url
        ]);
        Log::debug($vnp_Url);
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
            // dd(route('cart'));
            return redirect(route('cart'));
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

            foreach ($dataResponse as $key => $value) 
            {
                if ($i == 1) {
                    $hashData .= '&' . urlencode($key) . "=" . urlencode($value);
                } else {
                    $hashData .= urlencode($key) . "=" . urlencode($value);
                    $i = 1;
                }
            }
            //Compare vnpSecureHash
            // $secureHash = hash('sha256',$this->plugin->getSecretKey() . $hashData);

            $secureHash =   hash_hmac('sha512', $hashData, $this->plugin->getSecretKey());

            if($secureHash !== $vnpSecureHash) {
                dd($dataResponse);
                $msg = sc_language_render($this->plugin->pathPlugin.'::lang.process_invalid');
                return redirect(route('cart'))->with(['error' => $msg]);
            }

            ShopOrder::find($orderID)->update([
                'transaction' => $dataResponse['vnp_BankTranNo'], 
                'status' => 2
            ]);

            //Add history
            $dataHistory = [
                'order_id' => $orderID,
                'content' => 'Transaction ' . $vnpBankTranNo,
                'customer_id' => $customer->id ?? 0,
                'order_status_id' => 2,
            ];
            (new ShopOrder)->addOrderHistory($dataHistory);
            //Complete order

            return (new CartController)->completeOrder();

        }
    }

    /**
     * Process IPN
     */
    public function processIpn()
    {

        $inputData = array();
        $returnData = array();
        $data = request()->all();
        
        foreach ($_GET as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }

        $vnp_SecureHash = $inputData['vnp_SecureHash'];

        // $getSecureHash = $this->plugin->getSecureHash($inputData);
        
        $getHashMac = $this->plugin->getHashMac($inputData);

        $secureHash = $getHashMac['vnpSecureHash'];

        $vnpTranId = $inputData['vnp_TransactionNo']; //Mã giao dịch tại VNPAY
        $vnp_BankCode = $inputData['vnp_BankCode']; //Ngân hàng thanh toán
        $vnp_Amount = $inputData['vnp_Amount']/100; // Số tiền thanh toán VNPAY phản hồi
        
        $Status = 0; // Là trạng thái thanh toán của giao dịch chưa có IPN lưu tại hệ thống của merchant chiều khởi tạo URL thanh toán.
        $orderId = $inputData['vnp_TxnRef'];
        
        try {
            //Check Orderid    
            //Kiểm tra checksum của dữ liệu
            if ($secureHash == $vnp_SecureHash) {
                //Lấy thông tin đơn hàng lưu trong Database và kiểm tra trạng thái của đơn hàng, mã đơn hàng là: $orderId            
                //Việc kiểm tra trạng thái của đơn hàng giúp hệ thống không xử lý trùng lặp, xử lý nhiều lần một giao dịch
                //Giả sử: $order = mysqli_fetch_assoc($result);

                $order = ShopOrder::find($orderId);
        
                // $order = NULL;
                if ($order) {
                    //Kiểm tra số tiền thanh toán của giao dịch: giả sử số tiền kiểm tra là đúng. //$order["Amount"] == $vnp_Amount
                    if($order->total == $vnp_Amount) 
                    {
                        if ($order->payment_status != '' && $order->payment_status == 1)
                        {
                            if ($inputData['vnp_ResponseCode'] == '00' || $inputData['vnp_TransactionStatus'] == '00')
                            {
                                $Status = 3; // Trạng thái thanh toán thành công
                                $payment_status = 'Giao dịch thành công';
                            }
                            else
                            {
                                $Status = 2; // Trạng thái thanh toán thất bại / lỗi
                                $payment_status = 'Giao dịch thất bại';
                            }
                            
                            //Cài đặt Code cập nhật kết quả thanh toán, tình trạng đơn hàng vào DB
                            $order->update([
                                'payment_status'   => $Status
                            ]);
                            //
                            //
                            //
                            //Trả kết quả về cho VNPAY: Website/APP TMĐT ghi nhận yêu cầu thành công                
                            $returnData['RspCode'] = '00';
                            $returnData['Message'] = 'Confirm Success';
                        } else {
                            $returnData['RspCode'] = '02';
                            $returnData['Message'] = 'Order already confirmed';
                        }
                    }
                    else {
                        $returnData['RspCode'] = '04';
                        $returnData['Message'] = 'invalid amount';
                    }
                } else {
                    $returnData['RspCode'] = '01';
                    $returnData['Message'] = 'Order not found';
                }
            } else {
                $returnData['RspCode'] = '97';
                $returnData['Message'] = 'Invalid signature';
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
        Log::debug($returnData);
        // Log::debug('log merchant: '. json_encode($data_log, JSON_UNESCAPED_UNICODE));
        VNPayLog::create($data_log);

        //Trả lại VNPAY theo định dạng JSON
        // echo json_encode($returnData);
        return response()->json([
            'RspCode'   => $returnData['RspCode']??'',
            'Message'   => $returnData['Message']??''
        ]);
    }

}
