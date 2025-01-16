@php
     $productsHot = (new \App\Product)->where('hot', 1)->where('status', 1)->orderBy('created_at', 'desc')
            ->orderBy('sort', 'asc')->limit(10)->get();
     $productsTrend = (new \App\Product)->where('trend', 1)->where('status', 1)->orderBy('created_at', 'desc')
            ->orderBy('sort', 'asc')->limit(10)->get();
     $productsNew = (new \App\Product)->getList([
         'limit'    => 10,
         'sort_order'    => "created_at__desc",
     ]);
@endphp
<div class="product-block">
  <div class="container">
      <div class="row g-3 align-items-center mb-4">
          <div class="col-md-6">
              <div class="section-heading">
                 {!! setting_option('home-product') !!}
              </div>
          </div>
          <div class="col-md-6">
              <div class="nav-scroll">
                  <ul class="nav nav-pills nav-product-tabs wow fadeInUp" data-wow-delay="0.3s" id="pills-tab" role="tablist">
                      @if($productsHot->count())
                        <li class="nav-item">
                          <a class="nav-link active" data-bs-toggle="tab" href="#tab-1" role="tab">BÁN CHẠY NHẤT</a>
                        </li>
                      @endif
                      @if($productsTrend->count())
                    <li class="nav-item">
                      <a class="nav-link" data-bs-toggle="tab" href="#tab-2" role="tab">XU HƯỚNG</a>
                    </li>
                      @endif
                      @if($productsNew->count())
                    <li class="nav-item">
                      <a class="nav-link" data-bs-toggle="tab" href="#tab-3" role="tab">HÀNG MỚI VỀ</a>
                    </li>
                      @endif
                  </ul>
              </div>
          </div>
      </div>
      <div class="tab-content wow fadeIn" data-wow-delay="0.1s">
          @if($productsHot->count())
          <div class="tab-pane fade show active" id="tab-1" role="tabpanel" aria-bs-labelledby="pills-new-tab">
              <div class="product-slider owl-carousel">
                  @foreach($productsHot as $key => $product)
                      @include($templatePath .'.product.product-item', compact('product'))
                  @endforeach
              </div>
          </div>
          @endif
          @if($productsTrend->count())
          <div class="tab-pane fade" id="tab-2" role="tabpanel" aria-bs-labelledby="pills-apartment-tab">
              <div class="product-slider owl-carousel">
                  @foreach($productsTrend as $key => $product)
                    @include($templatePath .'.product.product-item', compact('product'))
                  @endforeach
              </div>
          </div>
          @endif
          @if($productsNew->count())
          <div class="tab-pane fade" id="tab-3" role="tabpanel" aria-bs-labelledby="pills-ground-tab">
              <div class="product-slider owl-carousel">
                  @foreach($productsNew as $key => $product)
                      @include($templatePath .'.product.product-item', compact('product'))
                  @endforeach
              </div>
          </div>
          @endif
      </div>
      <div class="view-more">
          <a href="{{ route('shop') }}" class="btn">Xem tất cả</a>
      </div>
  </div>
</div>