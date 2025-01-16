@php
    $menu_product_hot = Menu::getByName('Product-hot');
@endphp
@if($menu_product_hot)
@foreach($menu_product_hot as $menu)
    <div class="product-block">
      <div class="container">
          <div class="row g-3 align-items-center mb-4">
              <div class="col-md-6">
                  <div class="section-heading">
                     <p>{{ $menu['content'] }}</p>
                     <h5>{{ $menu['label'] }}</h5>
                  </div>
              </div>
                <div class="col-md-6">
                    @if($menu['child'])
                    <div class="nav-scroll">
                        <ul class="nav nav-pills nav-product-tabs wow fadeInUp" data-wow-delay="0.3s" id="pills-tab" role="tablist">
                            @foreach($menu['child'] as $index => $item)
                                <li class="nav-item">
                                    <a class="nav-link {{ $index == 0 ? 'active' : '' }}" data-bs-toggle="tab" href="#tab-{{ $index }}" role="tab">{{ $item['label'] }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
            </div>
            <div class="tab-content wow fadeIn" data-wow-delay="0.1s">
                @if($menu['child'])
                    @foreach($menu['child'] as $index => $item)
                        @php
                            $dataSearch = [
                                'sort_order'    => 'created_at__desc',
                                'limit' => 10
                            ];
                            if($item['link'] == 'hot')
                                $dataSearch['hot']  = 1;
                            elseif($item['link'] == 'trend')
                                $dataSearch['trend']  = 1;

                            $products = (new \App\Product)->getList($dataSearch);
                        @endphp
                        <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}" id="tab-{{ $index }}" role="tabpanel" aria-bs-labelledby="pills-new-tab">
                            <div class="product-slider owl-carousel">
                                @foreach($products as $product)
                                    @include($templatePath .'.product.product-item', compact('product'))
                                @endforeach
                            </div>

                            <div class="view-more">
                                <a href="{{ route('shop', ['type' => $item['link']]) }}" class="btn">Xem tất cả</a>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    @endforeach
@endif