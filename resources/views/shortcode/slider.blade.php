@php extract($data) @endphp
@php
	$agent = new Jenssegers\Agent\Agent;
	
	$sliders = \App\Model\Slider::where('slider_id', $id)->where('type', '=', 'desktop')->orderby('order','asc')->get(); 

	
	$slider_mobiles = \App\Model\Slider::where('slider_id', $id)->where('type', 'mobile')->get(); 
@endphp



	<main class="main">
<section class="hero-section">
    
    <div class="hero-slider owl-carousel">
		@foreach($sliders as $slider)
		
        <div class="div img_banner"><img src="{{ asset($slider->src) }}" alt=""></div>
        
		@endforeach
    </div>
</section>