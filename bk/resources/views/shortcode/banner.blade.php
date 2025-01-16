@php
    $banner = \App\Model\Slider::where('type', '<>', 'mobile')->where('slider_id', $data['id'])->where('link', $data['link'])->first(); 
    $banner_mobile = \App\Model\Slider::where('type', 'mobile')->where('slider_id', $data['id'])->where('link', $data['link'])->first(); 
@endphp
@if($banner)
    <div class="banner-block d-md-block d-none">
        <div class="container">
            <div class="position-relative">
                @if($banner->src)
                <div class="bg-banner">
                    <div class="img-banner" style="background-image: url('{{ asset($banner->src) }}')"></div>
                </div>
                @endif
                @if($banner->description)
                <div class="Advertising_adv">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-5">
                                {!! htmlspecialchars_decode($banner->description) !!}
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
@endif
@if($banner_mobile)
    <div class="banner-block d-md-none">
        <div class="container">
            <div class="position-relative">
                @if($banner_mobile->src)
                <div class="bg-banner">
                    <div class="img-banner" style="background-image: url('{{ asset($banner_mobile->src) }}')"></div>
                </div>
                @endif
                @if($banner_mobile->description)
                <div class="Advertising_adv">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-5">
                                {!! htmlspecialchars_decode($banner_mobile->description) !!}
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
@endif