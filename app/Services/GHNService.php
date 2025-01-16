<?php 
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Request;
use Cart, Auth, Cache;
use Carbon\Carbon;

class GHNService
{
	protected $shop_id, $service_url, $province, $district, $ward, $token, $url;

	public function __construct()
   {
        $this->url = 'https://online-gateway.ghn.vn/shiip/public-api';
        // $this->url = 'https://dev-online-gateway.ghn.vn/shiip/public-api';
        $this->shop_id = env('GHN_SHOP_ID', '');
        $this->service_url = $this->url .'/v2/shipping-order/available-services';
        $this->province = $this->url .'/master-data/province';
        $this->district = $this->url .'/master-data/district?Token=aa0f951c-dfe9-11ed-a2d2-eac62dba9bd9';
        $this->ward = $this->url .'/master-data/ward';
        $this->token = env('GHN_TOKEN', '');
   }

   public function getAPI($url_api, $data=[])
   {
   	$response = Http::withHeaders([
         "Access-Control-Allow-Origin" => " *",
         'Token' => $this->token,

     	])->get($url_api, $data);

     	$response = $response->object();
     	// dd($response);
     	if(empty($response) || $response->message != 'Success') throw new \Exception($response->message);
     	$response = collect($response->data);
     	return $response;
   }

   public function getGHNData($data = [])
   {
   	$province_name = $data['customer_province']??'';
   	$district_name = $data['customer_district']??'';
   	$ward_name = $data['customer_ward']??'';

   	if($province_name)
   	{
   		if (Cache::has('ghn_provinces')) 
   		{
	        $provinces = Cache::get('ghn_provinces');
	      }
	      else
	      {
		   	$provinces = $this->getAPI($this->province);
		   	Cache::forever('ghn_provinces', $provinces);
	      }
	   	// dd($provinces);
	   	if(!empty($provinces))
	   	{
	   		$province = $provinces->filter(function ($item) use ($province_name) {
	   			$province_name = str_replace('-', '–', $province_name);
	   			return false !== stristr($item->ProvinceName, $province_name);
				});
	   		// dd($province_name);
	   		$province = $province->first();
	   	}
	   }

   	if($district_name)
   	{
   		// dd($provinces);
   		if (Cache::has('ghn_districts__'. $province->ProvinceID)) 
   		{
	         $districts = Cache::get('ghn_districts__'. $province->ProvinceID);
	      }
	      else
	      {
		   		$districts = $this->getAPI($this->district, ['province_id' => $province->ProvinceID??0]);
		   		Cache::forever('ghn_districts__'. $province->ProvinceID, $districts);
	      }
	   	
	   	if(!empty($districts))
	   	{
	   		$district_name = str_replace('-', '–', $district_name);
	   		$district = $districts->filter(function ($item) use ($district_name) {
				    return false !== stristr($item->DistrictName, $district_name);
				});
	   		$district = $district->first();
	   	}
	   }
   	if($ward_name)
   	{
   		if (Cache::has('ghn_wards__'. $district->DistrictID)) 
   		{
          	$wards = Cache::get('ghn_wards__'. $district->DistrictID);
      	}
	      else
	      {
		   		$wards = $this->getAPI($this->ward, ['district_id' => $district->DistrictID??0]);
		   		Cache::forever('ghn_wards__'. $district->DistrictID, $wards);
	      }
   		
   		if(!empty($wards))
   		{
		   	$ward = $wards->filter(function ($item) use ($ward_name) {
		   		$ward_name = str_replace('-', '–', $ward_name);
				  return false !== in_array($ward_name, $item->NameExtension);
				});
				
	   		$ward = $ward->first();
		   }
	   }
	   
   	return [
   		'to_province_id'	=> $province->ProvinceID??'',
   		'to_district_id'	=> $district->DistrictID??'',
   		'to_ward_code'	=> $ward->WardCode??'',
   	];
   }

   public function getShippingReview($data)
   {
      $cart_content = Cart::content();

      $items = [];
		foreach($cart_content as $key => $value)
		{
			$value = $value->toArray();

			$product = \App\Product::find($value['id']);
			$product_length = $product->attrs()->where('name', 'length')->first();
			$product_width = $product->attrs()->where('name', 'width')->first();
			$product_height = $product->attrs()->where('name', 'height')->first();

        	if($product_length && $product_length->content !='')
            $length = ($product_length->content * $value['qty'] ) ;
        	if($product_width && $product_width->content !='')
            $width = ($product_width->content * $value['qty'] ) ;
        	if($product_height && $product_height->content !='')
            $height = ($product_height->content * $value['qty'] ) ;

			$items[] = [
				"name" => $product->name,
            "code" => $product->sku,
            "quantity" =>  (int)$value['qty'],
            "price" =>  (int)($value['subtotal'] ?? ($value['price'] * $value['qty'])),
            "length" =>  $length??0,
            "width" =>  $width??0,
            "height" =>  $height??0
			];
		}


		$data_request = [
			"service_type_id" => 2,
			"payment_type_id" => 1,
			"shop_id" => $this->shop_id,
			"content" => "Thanh toan don hang",
			"required_note" => "KHONGCHOXEMHANG",
			"to_name" => $data['to_name'],
			"to_phone" => '0900000001' ,//$data['to_phone'],
			"to_address" => $data['to_address'],
			"to_district_id" => (int)$data['to_district_id'],
			"to_ward_code" => $data['to_ward_code'],
			"insurance_value" => (int)$data['cart_total'],
			"service_type_id" => 2,
			"height" => (int)($data['height']??0),
			"length" => (int)($data['length']??0),
			"weight" => (int)($data['weight']??0),
			"width" => (int)($data['width']??0),
			"items"	=> $items
      ];
      if(!empty($data['payment_method']) && $data['payment_method']=='cod')
      {
      	$data_request['cod_amount'] = (int)$data['cart_total'];
      }
      // dd($data_request);
      // dd(json_encode($data_request, JSON_UNESCAPED_UNICODE));

   	$records_ghn = Http::withHeaders([
          "Access-Control-Allow-Origin" => " *",
          'Token' => $this->token,
      ])
      ->withBody(json_encode($data_request), 'application/json')
      ->post($this->url .'/v2/shipping-order/preview');
      $records_ghn = $records_ghn->json();

      return $records_ghn;
   }
   public function createGHNOrder($data)
   {
		$data_request = [
			"service_type_id" => 2,
			"payment_type_id" => 1,
			"shop_id" => $this->shop_id,
			"note" => "Thanh toan don hang",
			"required_note" => "KHONGCHOXEMHANG",
			"to_name" => $data['to_name'],
			"to_phone" => $data['to_phone'],
			"to_address" => $data['to_address'],
			"to_district_id" => (int)$data['to_district_id'],
			"to_ward_code" => $data['to_ward_code'],
			"insurance_value" => (int)$data['cart_total'],
			"service_type_id" => 2,
			"height" => (int)($data['height']??0),
			"length" => (int)($data['length']??0),
			"weight" => (int)($data['weight']??0),
			"width" => (int)($data['width']??0),
			"items"	=> $data['items']
      ];
      // dd(json_encode($data_request, JSON_UNESCAPED_UNICODE));

   	$records_ghn = Http::withHeaders([
          "Access-Control-Allow-Origin" => " *",
          'Token' => $this->token,
      ])
      ->withBody(json_encode($data_request), 'application/json')
      ->post($this->url .'/v2/shipping-order/create');
      $records_ghn = $records_ghn->json();

      return $records_ghn;
   }

   public function checkShippingOrder($shipping_code)
   {
   	$data_request = [
			"order_code" => $shipping_code
      ];

   	$records_ghn = Http::withHeaders([
          "Access-Control-Allow-Origin" => " *",
          'Token' => $this->token,
      ])
      ->withBody(json_encode($data_request), 'application/json')
      ->post($this->url .'/v2/shipping-order/detail');
      $records_ghn = $records_ghn->json();
      if(empty($records_ghn) || $records_ghn['message'] != 'Success') throw new \Exception($records_ghn['message']);
      return $records_ghn['data']??'';
  }

  	public function statusGHN()
  	{
	  	return [
			'ready_to_pick'	=> 'Mới tạo đơn hàng',
			'picking'	 => 'Nhân viên đang lấy hàng',
			'cancel'	=> 'Hủy đơn hàng',
			'money_collect_picking'	=> 'Đang thu tiền người gửi',
			'picked'	=> 'Nhân viên đã lấy hàng',
			'storing'	=> 'Hàng đang nằm ở kho',
			'transporting'	=> 'Đang luân chuyển hàng',
			'sorting'	=> 'Đang phân loại hàng hóa',
			'delivering'	=> 'Nhân viên đang giao cho người nhận',
			'money_collect_delivering'	=> 'Nhân viên đang thu tiền người nhận',
			'delivered'	=> 'Nhân viên đã giao hàng thành công',
			'delivery_fail'	=> 'Nhân viên giao hàng thất bại',
			'waiting_to_return'	=> 'Đang đợi trả hàng về cho người gửi',
			'return'	=> 'Trả hàng',
			'return_transporting'	=> 'Đang luân chuyển hàng trả',
			'return_sorting'	=> 'Đang phân loại hàng trả',
			'returning'	=> 'Nhân viên đang đi trả hàng',
			'return_fail'	=> 'Nhân viên trả hàng thất bại',
			'returned'	=> 'Nhân viên trả hàng thành công',
			'exception'	=> 'Đơn hàng ngoại lệ không nằm trong quy trình',
			'damage'	=> 'Hàng bị hư hỏng',
			'lost'	=> 'Hàng bị mất',
	  	];
  	}
}

?>