<?php 

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailNotify;
use Cart, Auth;

use App\Model\LocationProvince;
use App\Model\LocationDistrict;
use App\Model\LocationWard;
use App\Services\GHNService;

class LocationController extends Controller
{
	public $ghn_districts=[];
	protected $service;

	public function __construct(GHNService $service)
    	{
        parent::__construct();
        $this->ghn_districts = [];
        $this->service = $service;
   	}
	public function getDistrict()
	{
		$province_name = request()->id??'';
		$name = request()->name??'';
		if($province_name)
		{
			$html = '';
			$province = LocationProvince::where('name', $province_name)->first();
			$districts = LocationDistrict::where('province_id', $province->id)->get();

			$html .= '<option value=""> --- Chọn Quận/Huyện --- </option>';
	        	foreach ($districts as $item) {
	            $select = '';
	            if(in_array($name, [$item->type_name, $item->name]))
	                 $select = 'selected';
	            $html .= '<option value="'.$item->name.'" ' .$select. '>'.$item->type_name.'</option>';
	        	}
	        	return [
	        		'view' => $html
	        	];
		}
		return;
	}
	public function getWard()
	{
		$district_name = request()->id??'';
		$name = request()->name??'';
		if($district_name)
		{
			$district = LocationDistrict::where('name', $district_name)->first();
			$wards = LocationWard::where('district_id', $district->id)->get();
			$html = '<option value=""> --- Chọn Phường/xã --- </option>';
	        	foreach ($wards as $item) {
	            $select = '';
	            if(in_array($name, [$item->type_name, $item->name]))
	                 $select = 'selected';
	            $html .= '<option value="'.$item->name.'" ' .$select. '>'.$item->type_name.'</option>';
	        	}
	        	return [
	        		'view' => $html
	        	];
		}
		return;
	}
}
?>