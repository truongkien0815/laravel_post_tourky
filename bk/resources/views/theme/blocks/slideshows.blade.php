@php
    $sliders = \App\Model\Slider::where('status', 0)->where('slider_id', 1)->orderBy('order','asc')->get();
@endphp
@if($sliders->count())
<div class="slider-banner owl-carousel">
    @foreach($sliders as $slider)
    <div class="item-banner">
        <div class="hs-item set-bg" data-setbg="{{ $slider->src }}"></div>
        <div class="content-banner container text-center">
            <div class="row justify-content-center">
                <div class="col-md-12 col-lg-6">
                    {!! htmlspecialchars_decode($slider->description) !!}
                    <a href="{{ $slider->link !='' ? asset($slider->link) : 'javascript:;' }}" class="btn">Khám phá ngay</a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif