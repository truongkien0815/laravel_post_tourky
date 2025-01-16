@php
  $products = (new \App\Product)->getList([
    'limit' => 10
  ]);
@endphp
<!-- ***** Products Area Starts ***** -->
<div class="product-discover py-5">
  <div class="container">
      <div class="title-box">
          <div class="section-heading">
              <h5>khám phá bst mới nhất</h5>
          </div>
      </div>
      <div class="product-slider owl-carousel">
        @foreach($products as $product)
          @include($templatePath .'.product.product-item')
        @endforeach
      </div>
  </div>
</div>
<!-- ***** Products Area Ends ***** -->