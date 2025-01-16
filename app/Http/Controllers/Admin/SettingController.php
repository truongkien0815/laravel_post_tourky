<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Libraries\Helpers;
use Illuminate\Support\Str;

use App\Model\SettingWatermark;

class SettingController extends Controller
{
    public function watermark()
    {
        $data['settings'] = \App\Model\SettingWatermark::orderBy('sort')->get();
        $data['url_action'] = route('admin_setting.watermark');

        return view('admin.setting-watermark.index', $data);
    }

    public function store_watermark(){
        $data = request()->all();
        // dd($data);
        $data_option = $data['header_option'];
        $i = 0;
        $list_option = [];
        // dd($data_option);
        if($data_option){
            foreach ($data_option as $key => $option) {
                $type = $key;
                foreach($option['name'] as $index => $item){
                    $content = htmlspecialchars($option['value'][$index]);
                    if($type == 'editor')
                        $content = htmlspecialchars($content);
                    $option_db = SettingWatermark::updateOrCreate(
                        [
                            'name'  => $item
                        ],
                        [
                            'content'   => $content,
                            'type'   => $type,
                            'sort'   => $i,
                        ]
                    );
                    $list_option[] = $option_db->id;
                    $i++;
                }
            }
        }
        //delete;
        SettingWatermark::whereNotIn('id', $list_option)->delete();
        $msg = "Option has been registered";
        $url= route('admin_setting.watermark');
        Helpers::msg_move_page($msg,$url);
    }
}
