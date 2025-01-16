<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Slider;
use Illuminate\Support\Facades\Hash;
use App\Libraries\Helpers;
use Illuminate\Support\Str;
use DB, File, Image, Cache;

class SliderController extends Controller
{
    public $view_path = 'admin.slider';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function listSlider(){
        $data_slider = Slider::where('slider_id', 0)->get();
        return view($this->view_path .'.index')->with(['data_slider' => $data_slider]);
    }

    public function createSlider(){
        return view($this->view_path .'.single');
    }

    public function sliderDetail($id){
        $data_slider = Slider::findorfail($id);
        if($data_slider){
            $dataResponse = [
                'data_slider'   => $data_slider,
                'sliders' => \App\Model\Slider::where('slider_id', $data_slider->id)->orderBy('order', 'asc')->get()
            ];
            
            return view($this->view_path .'.single', $dataResponse);
        } else{
            return view('404');
        }
    }

    public function postSliderDetail(Request $rq){
        Cache::forget('slider_home');
        //id page
        $sid = $rq->sid;
        $datetime_now=date('Y-m-d H:i:s');
        $datetime_convert=strtotime($datetime_now);

        $title_new = $rq->post_title;

        /*PC up load*/
        $name_thumb_pc="";
        $name_field_pc="csv_slishow";
        $name_text_pc="slishow_upload";
        if($rq->hasFile($name_field_pc)):
            $file = $rq->file($name_field_pc);
            $timestamp = $datetime_convert;
            $name = "slider-".$timestamp. '-' .$file->getClientOriginalName();
            $name_thumb_pc='/public/img/uploads/slider/'.$name;
            $file->move(base_path().'/public/img/uploads/slider/',$name);
        else:
            if($rq->input($name_text_pc) !=""):
                $name_thumb_pc = $rq->input($name_text_pc);
            else:
                $name_thumb_pc = "";
            endif;
        endif;
        /*End pc upload*/

        /*Mobile up load*/
        $name_thumb_mobile = "";
        $name_field_mobile = "csv_slishow_mobile";
        $name_text_mobile = "slishow_upload_mobile";
        if($rq->hasFile($name_field_mobile)):
            $file = $rq->file($name_field_mobile);
            $timestamp = $datetime_convert;
            $name = "slider-mobile-".$timestamp. '-' .$file->getClientOriginalName();
            $name_thumb_mobile = '/public/img/uploads/slider/'.$name;
            $file->move(base_path().'/public/img/uploads/slider/',$name);
        else:
            if($rq->input($name_text_mobile) !=""):
                $name_thumb_mobile = $rq->input($name_text_mobile);
            else:
                $name_thumb_mobile = "";
            endif;
        endif;
        /*End Mobile upload*/
        
        if($sid == 0){
            $data = array(
                'name' => $title_new,
                'src' => $name_thumb_pc,
                'src_mobile' => $name_thumb_mobile,
                'order' => $rq->order,
                'link' => $rq->link,
                'description' => '',
                'target' => $rq->target,
                'status' => $rq->status,
                'updated' => $rq->created,
                'created' => $rq->created,
            );
            $respons = Slider::create($data);
            $id_insert= $respons->id;
            Cache::forget('slider_home');
            if($id_insert>0):
                $msg = "Slider has been registered";
                $url= route('admin.slider');
                Helpers::msg_move_page($msg,$url);
            endif;
        } else{
            $data = array(
                'name' => $title_new,
                'src' => $name_thumb_pc,
                'src_mobile' => $name_thumb_mobile,
                'order' => $rq->order,
                'link' => $rq->link,
                'description' => '',
                'target' => $rq->target,
                'status' => $rq->status,
                'updated' => date('Y-m-d h:i:s')
            );
            $respons = Slider::where ("id","=", $sid)->update($data);
            Cache::forget('slider_home');
            $msg = "Silder has been Updated";
            $url= route('admin.sliderDetail', array($sid));
            Helpers::msg_move_page($msg,$url);
        }
        
    }

    public function editSlider(Request $request)
    {
        $id = $request->id ?? 0;
        $parent = $request->parent ?? 0;
        if($id)
        {
            $slider = Slider::findorfail($id);
            $dataResponse = [
                'title_head' => 'Sửa slider',
                'slider'    => $slider,
                'parent'    => $parent,
            ];
        }
        else
        {
            $dataResponse = [
                'title_head' => 'Thêm slider',
                'parent'    => $parent,
            ];
        }

        return response()->json([
            'view'  => view($this->view_path .'.includes.form', $dataResponse)->render()
        ]);
    }

    public function insertSlider(Request $request)
    {
        $id = $request->id ?? 0;
        $parent = $request->slider_id ?? 0;
        $data = $request->all();
        $data['description'] = htmlspecialchars($data['description']);

        if($id == 0){
            $slider_end = Slider::where('slider_id', $parent)->orderby('order', 'desc')->first();
            if($slider_end)
                $data['order'] = (int)$slider_end->order + 1;
            else
                $data['order'] = 0;
        }
        
        $slider = Slider::updateOrCreate(
            ['id'=> $id],
            $data
        );
        $sliders = Slider::where('slider_id', $parent)->orderby('order', 'asc')->get();

        Cache::forget('slider_home');
        $view = view($this->view_path .'.includes.slider-items', ['sliders'=>$sliders])->render();
        return response()->json([
            'view'  => $view
        ]);
        
    }
    public function deleteSlider(Request $request)
    {
        Cache::forget('slider_home');
        $id = $request->id ? $request->id : 0;
        if($id){
            $slider = Slider::findorfail($id);
            $slider_id = $slider->slider_id;
            $slider->delete();
            $sliders = Slider::where('slider_id', $slider_id)->orderby('order', 'asc')->get();
            $view = view($this->view_path .'.includes.slider-items', ['sliders'=>$sliders])->render();
            return response()->json([
                'view'  => $view
            ]);
        }
    }
    public function updateSort()
    {
        $sliders = request()->slider;
        
        foreach ($sliders as $key => $item) {
            Slider::find($item)->update(['order'=> $key]);
        }
        return;
    }
}
