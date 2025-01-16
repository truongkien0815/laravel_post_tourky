@php extract($data); @endphp

@extends($templatePath .'.layout')

@section('seo')

@section('content')
 
<div class="banner-head-img d-md-block d-none">
    @if(!empty($page) && $page->cover)
        <img src="{{ asset($page->cover) }}">
    @elseif(!empty($category) && $category->cover)
        <img src="{{ asset($category->cover) }}">
    @endif
</div> 
<div class="banner-head-img d-md-none">
    @if(!empty($page) && $page->cover)
        <img src="{{ asset($page->cover) }}">
    @elseif(!empty($category) && $category->cover_mobile)
        <img src="{{ asset($category->cover_mobile) }}">
    @endif
</div>

@include($templatePath .'.product.product-discover')

@include($templatePath .'.product.product-button-list')

<!-- ***** List Product Starts ***** -->
<div class="product-list py-5">
    <div class="container">
        @include($templatePath .'.product.product-filter-form')
        <div class="product-list-content position-relative">
            <div class="orderInfo-loading text-center">
                <div class="lds-ellipsis">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                </div>
            </div>
            @include($templatePath .'.product.includes.product-list', ['products' => $products])
        </div>

        {{--
        <div class="product-view-more">
            <button class="btn" data-type="all" data-total="">Xem thêm</button>
            <p>Hiển thị 1 - 16 trên tổng số {{ $products->total() }} sản phẩm</p>
        </div>
        --}}
    </div>
</div>
<!-- ***** List Product Ends ***** -->

<!-- ***** Archive Starts ***** -->
@include($templateFile .'.blocks.archive')
<!-- ***** Archive Ends ***** -->

@endsection

@push('scripts')
    <script>
        jQuery(document).ready(function($) {
            $('.productFilterForm select').on('change', function(){
                $('.product-list-content .lds-ellipsis').show();
                getProductList();
            });

            $('.filter-reset').click(function(){
                // window.location.href = '{{ url()->current() }}'
                $('#productFilterForm select').val('');

                window.history.pushState('', '', '{{ url()->current() }}');
                getProductList();
            })

            function getProductList() {
                var form = document.getElementById('productFilterForm'),
                    fdnew = new FormData(form);
                axios({
                    method: "post",
                    url: $('#productFilterForm').prop("action"),
                    data: fdnew,
                })
                .then((res) => {
                    if (!res.data.error && res.data.view !='') {
                        $('.list-group-product').remove();
                        $('.product-list-content').append(res.data.view);
                    }
                    if(res.data.url)
                    {
                        window.history.pushState('', '', res.data.url);
                    }
                    $('.product-list-content .lds-ellipsis').hide();
                })
                .catch((e) => console.log(e));
            }

        });
    </script>   
@endpush