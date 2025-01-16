<div class="container cart_container pt-4 pb-3 py-sm-4">
    @if($carts->count())
    <div class="rounded-3 shadow-lg mt-4 mb-5">
        <ul class="nav nav-tabs nav-justified mb-4">
            <li class="nav-item"><a class="nav-link fs-lg fw-medium py-4 active" href="{{ route('cart') }}">1. Giỏ hàng</a></li>
            <li class="nav-item"><a class="nav-link fs-lg fw-medium py-4" href="{{ route('cart.checkout') }}">2. Thanh toán</a></li>
        </ul>
        <div class="px-3 px-sm-4 px-xl-5 pt-1 pb-4 pb-sm-5">
            <form action="#" method="post" class="cart style2">
                <div class="row">
                    <!-- Items in cart-->
                    <div class="col-lg-8 col-md-7 pt-sm-2">
                        @foreach($carts as $cart)
                        @php 
                            $product = \App\Product::find($cart->id);
                            $disabled = '';
                            if($product->stock < $cart->qty)
                                $disabled = 'disabled';

                            if($cart->options)
                            {
                                $option_key_first = array_key_first($cart->options->toArray());
                                $item_id = explode('__', $option_key_first)[1]??0;
                                $product_item = \App\Model\ShopProductItem::find($item_id);
                                // $img = $product_item->getGallery()[0]??'';
                            }
                        @endphp
                            <!-- Item-->
                            <div class="">
                                @if($disabled!='')
                                <div class="text-danger"><i>Sản phẩm hết hàng</i></div>
                                @endif
                                <div class="cart__row_item d-sm-flex mt-3 mb-4 pb-3 border-bottom {{ $disabled }}">
                                    <div class="d-block d-sm-flex text-center text-sm-start" style="flex: 1">
                                        <a class="d-inline-block flex-shrink-0 mx-auto me-sm-4" href="{{ route('shop.detail', $product->slug) }}">
                                            <img src="{{ asset($img??$product->image) }}" alt="{{ $product->name }}" onerror="if (this.src != '{{ asset('assets/images/no-image.jpg') }}') this.src = '{{ asset('assets/images/no-image.jpg') }}';" width="120">
                                        </a>
                                        <div style="flex: 1">
                                            <div class=" product-title fs-base mb-2"><a href="{{ route('shop.detail', $product->slug) }}">{{ $product->name }}</a></div>
                                            @if($product->unit)
                                            <div class="fs-sm"><span class="text-muted me-2">Đơn vị:</span>{{ $product->unit }}</div>
                                            @endif
                                            @include($templatePath .'.cart.includes.render-attr-item', ['options' => $cart->options])
                                            <div class="fs-5 text-danger pt-2">{!! render_price($cart->price) !!}</div>
                                        </div>
                                    </div>
                                    <div class="pt-2 pt-sm-0 ps-sm-3 mx-auto mx-sm-0 text-center text-sm-start" style="max-width: 9rem;">
                                        <label class="form-label" for="quantity1">Số lượng</label>
                                        <input class="form-control cart__qty-input" type="number"name="updates[]" id="quantity1" value="{{ $cart->qty }}" min="1" data-rowid="{{ $cart->rowId }}">
                                        <button class="btn btn-link px-0 text-danger cart__remove" type="button" data="{{ $cart->rowId }}"><i class="ci-close-circle me-2"></i><span class="fs-sm">Xóa</span></button>
                                    </div>
                                    <div class="px-2 text-center" style="min-width: 9rem;">
                                        <div class="mb-3">Thành tiền</div>
                                        <h5>{!! render_price($cart->price * $cart->qty) !!}</h5>
                                    </div>
                                </div>
                            </div>
                            <!-- Item-->
                        @endforeach
                    </div>
                    <!-- Sidebar-->
                    <div class="col-lg-4 col-md-5 pt-3 pt-sm-4">
                        <div class="rounded-3 bg-light px-3 px-sm-4 py-4">
                            <div class="text-center mb-4 pb-3 border-bottom">
                                <h3 class="h5 mb-3 pb-1">Thành tiền</h3>
                                <h4 class="fw-normal cart_total">{!! render_price(Cart::total(2)) !!}</h4>
                            </div>
                            {{--
                            <div class="mb-4">
                                <label class="form-label mb-3" for="order-comments"><span class="badge bg-info fs-xs me-2">Note</span>Thêm ghi chú</label>
                                <textarea class="form-control" rows="4" id="order-comments"></textarea>
                            </div>
                            
                            <h3 class="h6 mb-4">Apply promo code</h3>
                            <form class="needs-validation" method="post" novalidate="">
                                <div class="mb-3">
                                    <input class="form-control" type="text" placeholder="Promo code" required="">
                                    <div class="invalid-feedback">Please provide promo code.</div>
                                </div>
                                <button class="btn btn-outline-primary d-block w-100" type="submit">Apply promo code</button>
                            </form>
                            --}}
                            <a class="btn-main text-center d-block w-100 mt-4 mb-3" href="{{ route('cart.checkout') }}"><i class="ci-card fs-lg me-2"></i>Thanh toán</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @else
    <div class="alert alert-danger text-uppercase mt-5" role="alert">
        <i class="ci-loudspeaker"></i> &nbsp;@lang('Cart is empty!')
    </div>
    @endif

</div>