@extends($templatePath .'.layouts.index')

@section('seo')
@include($templatePath .'.layouts.seo', $seo??[] )
@endsection

@php
    $variable_group = App\Model\Variable::where('status', 0)->pluck('name', 'id');
@endphp
@section('content')
    <!-- Page Header Start -->
    @if(\Session::get('error'))
    <div class="container">
        <div class="box-message mb-3">
            <p class="text-danger">{{ __(Session::get('error')) }}</p>
        </div>
    </div>
    @endif
    <div class="single-breadcrumbs wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-3">
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Giỏ hàng</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->
    <div class="shop-block carts-content py-5">
        @include($templatePath . '.cart.cart-list', compact('carts'))
    </div>

@endsection


@push('after-footer')
<script>
    $(document).on('click', '.cart__remove', function(event) {
    event.preventDefault();
    $(this).closest('.cart__row_item').remove();
    var rowId = $(this).attr('data');
    axios({
      method: 'post',
      url: '/cart/ajax/remove',
      data: { rowId:rowId }
    }).then(res => {
        if(res.data.error == 0)
        {
          setTimeout(function () {
            $('#CartCount').html(res.data.count_cart);
            $('#header-cart .total .money').html(res.data.total);
          }, 1000);
            $('.carts-content').html(res.data.view);
          alertJs('success', res.data.msg);
        }else{
          alertJs('error', res.data.msg);
        }
    }).catch(e => console.log(e));
  });

    $(document).on('change', '#quantity1', function(){
        var qty = $(this).val(),
            rowId = $(this).data('rowid');

        if(qty > 0){
            axios({
              method: 'post',
              url: '{{ route('carts.update') }}',
              data: { rowId:rowId, qty: qty }
            }).then(res => {
                if(res.data.error ==0)
                {
                    $('.carts-content').html(res.data.view);
                    setTimeout(function () {
                        $('#CartCount').html(res.data.count_cart);
                        $('.site-cart #header-cart').remove();
                        $('.site-cart').append(res.data.view_cart_mini);
                    }, 1000);
                  alertJs('success', res.data.msg);
                }else{
                  alertJs('error', res.data.msg);
                }
            }).catch(e => console.log(e));
        }
    })
</script>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ asset($templateFile .'/css/cart.css') }}">
@endpush