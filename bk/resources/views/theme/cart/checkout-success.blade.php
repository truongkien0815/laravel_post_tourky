@extends($templatePath .'.layouts.index')

@section('seo')
@include($templatePath .'.layouts.seo', $seo??[] )
@endsection

@section('content')
    <div class="container pb-5 mb-sm-4">
        <div class="pt-5 text-center">
            <h2 class="h4">{{ $title }}</h2>
            <p class="fs-sm mb-2">{{ sc_language_render('checkout.order_success_msg') }}</p>
        </div>
        @if(!empty($orderInfos))
        <div class="row g-3 justify-content-center">
            @foreach($orderInfos as $order)
            <div class="col-md-6">
                <div class="card py-3 mt-sm-3">
                <div class="card-body text-center">
                  <p class="fs-sm mb-2">Mã đơn hàng: <b class='fw-medium'>{{ $order['code'] }}</b></p>
                  <p class="fs-sm mb-2">Tổng tiền: <b class='fw-medium'>{!! sc_currency_render_symbol($order['total']) !!}</b></p>
                  <!-- <p class="fs-sm">You will be receiving an email shortly with confirmation of your order. <u>You can now:</u></p> -->
                  <a class="btn btn-secondary mt-3 me-3" href="/">Tiếp tục mua sắm</a>
                  <!-- <a class="btn btn-primary mt-3" href="order-tracking.html"><i class="ci-location"></i>&nbsp;Track order</a> -->
                </div>
                </div>
            </div>
            @endforeach
        </div>
            
        @endif
        {{--
        <div class="row">
            <div class="col-md-12">
                <h2 class="title-page">{{ $title }}</h2>
            </div>
            <div class="col-md-12 text-success">
                <h2>{{ sc_language_render('checkout.order_success_msg') }}</h2>
                <h3>{{ sc_language_render('checkout.order_success_order_info', ['order_id'=>session('orderID')]) }}</h3>
            </div>
        </div>
        --}}
    </div>
@endsection
