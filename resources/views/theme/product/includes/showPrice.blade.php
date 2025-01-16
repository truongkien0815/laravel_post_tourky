
@if($priceFinal > 0 && $price)
    @php
    $price_sale = $price - $priceFinal;
    $price_percent = round($price_sale * 100 / $price);
    @endphp
    
   <div class="product-price d-flex flex-wrap align-items-center">
      <span class="price px-2">
         <ins>
            <span>{!! render_price($priceFinal) !!}</span>
         </ins>
         @if(!empty($unit))
            <span>/ {!! $unit !!}</span>
         @endif
      </span>
      <del class="fs-sm text-muted px-2">{!! render_price($price) !!}</del>
   </div>
@else
   @if($price>0)
      <div class="product-price d-flex align-items-center">
         <span class="price">
            <ins>
               <span>{!! render_price($price) !!}</span>
            </ins>
         </span>
         @if(!empty($unit))
            <span>/ {{ $unit }}</span>
         @endif
      </div>
   @else
      <div class="product-price d-flex align-items-center">
         <span class="price">Liên hệ</span>
      </div>
   @endif
@endif