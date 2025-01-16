@php
   $products = (new \App\Product)->where('hot', 1)->where('status', 1)->orderBy('created_at', 'desc')->orderBy('sort', 'asc')->limit(10)->get();
@endphp
<!-- Modal -->
<div class="modal fade" id="product_add_cart_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title me-3" id="exampleModalLabel">Đã thêm vào giỏ hàng</h5>

            <div>
               <a href="{{ route('shop') }}" title="">Tiếp tục mua hàng</a> |
               <a href="{{ route('cart') }}" title="">Giỏ hàng</a>
            </div>

            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <div class="row">
               <div class="col-lg-7">
                  <div class="d-flex product-item">
                     <div class="img">
                        <img src="{{ asset($product->image) }}" width="130">
                     </div>
                     <div class="product-title px-3">
                        <h3 class="h5">{{ $product->name }}</h3>
                        <p>Giá: {!! render_price($data_add_cart['price']) !!}</p>
                        <p>SL: {!! $data_add_cart['qty'] !!} {{ $product->unit??'' }}</p>
                     </div>
                  </div>
               </div>
               <div class="col-lg-5">
                  <p class="mb-3">Thành tiền: <b>{!! render_price($data_add_cart['price'] * $data_add_cart['qty']) !!}</b></p>
                  <p>
                     <a href="{{ route('cart.checkout') }}" class="btn-main" title="">Thanh toán</a>
                  </p>
               </div>
            </div>

            <div class="mt-4">
               <div class="title-detail mb-3">
                  <h3>Sản phẩm nổi bật</h3>
               </div>
               <div class="product-top-sell owl-carousel" style="opacity: 0;">
                  @foreach($products as $product) 
                       @include($templatePath .'.product.product-item', compact('product'))
                  @endforeach
               </div>
            </div>

         </div>
      </div>
   </div>
</div>