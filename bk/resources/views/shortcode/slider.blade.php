@php extract($data) @endphp
@php
	$agent = new Jenssegers\Agent\Agent;
	$sliders = \App\Model\Slider::where('slider_id', $id)->where('type', '<>', 'mobile')->get(); 
	$slider_mobiles = \App\Model\Slider::where('slider_id', $id)->where('type', 'mobile')->get(); 
@endphp

	@if($sliders->count())
		<div class="d-md-block d-none">
			<div class="slider-banner owl-carousel">
			    @foreach($sliders as $slider)
				    <div class="item-banner">
				        <div class="hs-item set-bg" data-setbg="{{ $slider->src }}">
				        	<img src="{{ asset($slider->src) }}">
				        </div>
				        <div class="content-banner container text-center">
				            <div class="row justify-content-center">
				                <div class="col-md-12 col-lg-6">
				                    {!! htmlspecialchars_decode($slider->description) !!}
				                    @if($slider->link)
				                    	<a href="{{ $slider->link !='' ? asset($slider->link) : 'javascript:;' }}" class="btn">Khám phá ngay</a>
				                    @endif
				                </div>
				            </div>
				        </div>
				    </div>
			    @endforeach
			</div>
		</div>
	@endif
	@if($slider_mobiles->count())
		<div class="d-md-none">
			<div class="slider-banner owl-carousel">
			    @foreach($slider_mobiles as $slider)
				    <div class="item-banner">
				        <div class="hs-item set-bg" data-setbg="{{ $slider->src }}">
				        	<img src="{{ asset($slider->src) }}">
				        </div>
				        <div class="content-banner container text-center">
				            <div class="row justify-content-center">
				                <div class="col-md-12 col-lg-6">
				                    {!! htmlspecialchars_decode($slider->description) !!}
				                    @if($slider->link)
				                    	<a href="{{ $slider->link !='' ? asset($slider->link) : 'javascript:;' }}" class="btn">Khám phá ngay</a>
				                    @endif
				                </div>
				            </div>
				        </div>
				    </div>
			    @endforeach
			</div>
		</div>
	@endif