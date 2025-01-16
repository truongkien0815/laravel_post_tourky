@php extract($data); @endphp

@extends($templatePath .'.layout')

@section('seo')

@section('content')
    <!-- Products Start -->
    <div class="product-list py-5">
        <div class="container">
            <h4 class="mb-4">{{ __('Search') }} <span>- {{ $products->count()??0 }} {{ __('SearchItem') }}</span></h4>
            <div class="row g-4 wow fadeInUp" data-wow-delay="0.3s">
                @forelse($products as $product)
                    <div class="col-6 col-md-4 col-lg-3">
                        @include($templatePath.'.product.product-item', compact('product'))
                    </div>
                @empty
                    <p>{{ __('No Results.') }}</p>
                @endforelse
            </div>
            
            <div class="mt-3">
                {!! $products->withQueryString()->links() !!}
            </div>
        </div>
    </div>
    <!-- Products End -->

@endsection