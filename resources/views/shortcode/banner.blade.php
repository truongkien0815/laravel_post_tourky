

@php extract($data) @endphp
@php
    
    $banner = \App\Model\Slider::get(); 
    if(!empty($data['id_mobile']))
        $banner_mobile = \App\Model\Slider::find($data['id_mobile']); 

    	$sliders = \App\Model\Slider::where('slider_id', $id)->where('type', '=', 'desktop')->get(); 
    	$slidersdt = \App\Model\Slider::where('slider_id', $id_dt)->where('type', '=', 'desktop')->get(); 

@endphp




 <section class="achievement-section">
            <div class="container">
                <div class="section-title text-center d-block">
                    <div class="sub-title">chứng nhận</div>
                    <h3>Đại lý uỷ quyền từ hãng</h3>
                </div>
                <div class="achievement-slider owl-carousel">
                    @foreach($sliders as $item)
                  
                  
                    <div class="item-achievement">
                        <div class="thumb">
                            <img src="{{ asset($item->src) }}" alt="" />
                        </div>
                    </div>
                   
                   
                    @endforeach
                  
                </div>
            </div>
 </section>


 <section class="partner-section">
    <div class="container">
        <div class="section-title text-center d-block">
            <div class="sub-title">ĐỐI TÁC &</div>
            <h3> KHÁCH HÀNG TIÊU BIỂU</h3>
        </div>
        <div class="achievement-slider owl-carousel">
            @foreach($slidersdt as $item)
            {{-- @if($item->type == 'desktop' && $item->name == 'khachhang') --}}
            <div class="item-achievement">
                <div class="thumb">
                    <img src="{{ asset($item->src) }}" alt="" />
                    
                </div>
            </div>
            {{-- @endif --}}
            @endforeach
          
        </div>
    </div>
</section>