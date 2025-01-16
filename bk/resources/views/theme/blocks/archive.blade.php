@php
$banners = \App\Model\Slider::where('status', 0)->where('slider_id', 19)->orderBy('order','asc')->get()
@endphp
<div class="archive-block py-5">
  <div class="container">
      <div class="row g-4">
          @foreach($banners as $slider)
          <div class="col-6 col-lg-3 ads-item">
              <a href="{{ $slider->link !='' ? asset($slider->link) : 'javascript:;' }}">
                  <div class="thumb">
                      <img src="{{ $slider->src }}">
                  </div>
                  <div class="content-ads">
                      <h6>{{ $slider->name }}</h6>
                  </div>
              </a>
          </div>
          @endforeach
      </div>
  </div>
</div>