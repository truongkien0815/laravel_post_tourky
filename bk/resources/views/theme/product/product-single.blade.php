@php
    extract($data);
    $gallery = $product->getGallery() ?? '';

    $spec_short = $product->spec_short ?? '';
    if($spec_short != '')
        $spec_short = json_decode($spec_short, true);

    $product_stock = $product->checkStock();
     $disabled = 'disabled';
     if($product_stock)
        $disabled = '';
@endphp

@extends($templatePath .'.layout')

@section('seo')

@section('content')

    <!-- ***** Product Area Starts ***** -->
    <div class="product-single">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 gallery-content">
                    @include($templatePath .'.product.product-gallery')
                </div>
                <div class="col-lg-8">
                    <div class="product-info">
                        <div class="breadcrumbs-single">
                            <nav aria-label="breadcrumb animated slideInDown">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('shop.detail', $category->slug) }}">{{ $category->name??'' }}</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
                                </ol>
                            </nav> 
                        </div>
                        <h6>{{ $product->name }} {{ $product->sku }}</h6>
                        @include($templatePath .'.product.product-summary', compact('product'))
                        <div class="product-detail__description">
                            {!! htmlspecialchars_decode($product->description) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="product-tabs">
                <div class="scroll-mb">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                      <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" role="tab" aria-controls="home" aria-selected="true">Mô tả sản phẩm</a>
                      </li>
                      <li class="nav-item" role="presentation">
                        <a class="nav-link" id="comment-tab" data-bs-toggle="tab" data-bs-target="#comment" role="tab" aria-controls="comment" aria-selected="false">Đánh giá</a>
                      </li>
                      <li class="nav-item" role="presentation">
                        <a class="nav-link" id="policy-tab" data-bs-toggle="tab" data-bs-target="#policy" role="tab" aria-controls="policy" aria-selected="false">Chính sách mua hàng</a>
                      </li>
                      <li class="nav-item" role="presentation">
                        <a class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" role="tab" aria-controls="profile" aria-selected="false">Hướng dẫn sử dụng</a>
                      </li>
                    </ul>
                </div>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="product-detail_description description-details">
                            {!! htmlspecialchars_decode($product->content) !!}
                        </div>
                        <div class="loadmore-detail__product">
                            <a href="#" class="product-description__loadmore">Xem thêm</a>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="comment" role="tabpanel" aria-labelledby="comment-tab">
                        <div class="product-detail_description">
                            <div class="fb-comments" data-href="{{ url()->current() }}" data-width="100%" data-numposts="1"></div>
                            @include($templatePath .'.product.product_review', compact('product'))
                        </div>
                    </div>
                    <div class="tab-pane fade" id="policy" role="tabpanel" aria-labelledby="policy-tab">
                        <div class="product-detail_description">
                            @php
                                $page_buy = \App\Page::find(13);
                            @endphp
                            @if($page_buy)
                                {!! htmlspecialchars_decode($page_buy->content) !!}
                            @endif
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="product-detail_description">
                            {!! htmlspecialchars_decode($product->body) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ***** Product Area Ends ***** -->


    <!-- ***** Products Area Starts ***** -->
    <div class="product-related py-5">
        <div class="container">
            <div class="title-box">
                <div class="section-heading">
                    <h5>sản phẩm liên quan</h5>
                </div>
            </div>
            <div class="product-slider owl-carousel">
                @foreach($related as $key => $items)
                    @foreach($items as $product)
                        @include($templatePath .'.product.product-item', compact('product'))
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>
    <!-- ***** Products Area Ends ***** -->

@endsection


@push('head-style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" integrity="sha512-H9jrZiiopUdsLpg94A333EfumgUBpO9MdbxStdeITo+KEIMaNfHNvwyjjDJb+ERPaRS6DpyRlKbvPUasNItRyw==" crossorigin="anonymous" referrerpolicy="no-referrer">
@endpush

@push('after-footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js" integrity="sha512-uURl+ZXMBrF4AwGaWmEetzrd+J5/8NRkWAvJx5sbPSSuOb0bZLqf+tOzniObO00BjHa/dD7gub9oCGMLPQHtQA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(function() {
            $(document).on('change', '.product-form__item_color input', function(event) {
                event.preventDefault();
                /* Act on the event */
                var attr_id = $(this).data('id'),
                    product = {{ $product->id }};
                axios({
                    method: 'post',
                    url: '{{ route('ajax.attr.change') }}',
                    data: {attr_id:attr_id, product:product, type:$(this).data('type')}
                }).then(res => {
                    if(res.data.error == 0){
                        if(res.data.attr_stock==0)
                            $('.product-form__cart-add').addClass('disabled');
                        $('.product-single-variations').html(res.data.view);
                    }
                }).catch(e => console.log(e));
            });

            $(document).on('change', '.available-item input', function(event) {
                event.preventDefault();

                var attr_id_change = $(this).data('id'),
                    attr_id_change_parent = $(this).data('parent');
                console.log(attr_id_change);
                $('#product_form_addCart').find('input[name="attr_id"]').attr('name', 'attr_id['+ attr_id_change_parent +']').val(attr_id_change);

                var form = document.getElementById('product_form_addCart');
                var formData = new FormData(form);

                axios({
                    method: 'post',
                    url: '{{ route('ajax.attr.change') }}',
                    data: formData
                }).then(res => {
                    if(res.data.error == 0){
                        $('.product-single-variations').html(res.data.view);
                        if(res.data.show_price != '')
                            $('.product-single__price').html(res.data.show_price);
                    }
                }).catch(e => console.log(e));
            });
            $(".write_comment").click(function() {
                $('html,body').animate({
                        scrollTop: $(".rate_thongke").offset().top},
                    'slow');
            });
        });
    </script>

@endpush