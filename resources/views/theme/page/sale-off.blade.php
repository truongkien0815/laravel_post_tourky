@php extract($data); @endphp

@extends($templatePath.'.layouts.index')

@section('seo')

@endsection

@section('content')
@php
    $products = (new \App\Product)->getList([
        'promotion'   => 1,
    ]);
@endphp
<div class="product-list">
    <div class="container pb-lg-4">
        <h1 class="text-center my-3">{{ $page->title }}</h1>
        <div class="row list-group-product g-4">
            @foreach($products as $product)
              @include($templatePath .'.product.product-item')
            @endforeach
        </div>
    </div>
</div>
@endsection