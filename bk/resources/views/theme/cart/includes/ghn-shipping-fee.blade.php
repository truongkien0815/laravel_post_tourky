@php
    $delivery_end = $delivery_time; 
@endphp
<div class="d-flex shipping-select">
    <div class="ps-lg-5 ps-4">
        <div>Nhanh</div>
        <div class="shipping-time"><span>Nhận hàng vào {!! $delivery_time->day !!} Th{{ $delivery_time->month }} - {{ $delivery_end->addDays(2)->day }} Th{{ $delivery_end->month }}</span></div>
    </div>
    <div class="shipping-price ps-lg-5 ps-4">
        <span>{!! render_price($total_fee??0) !!}</span>
    </div>
</div>