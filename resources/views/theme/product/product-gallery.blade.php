@if (!empty($gallery))
<div class="product-single__images">
    <div class="product-single__img">
        @foreach ($gallery as $key => $image)
        <a href="{{ asset($image) }}" data-fancybox="gallery">
            <img src="{{ asset($image) }}">
        </a>
        @endforeach
    </div>
    <div class="thumbs">
        <div class="product-single__gallery">
            @foreach ($gallery as $key => $image)
            <div class="item-thumb">
                <img src="{{ asset($image) }}">
            </div>
            @endforeach
        </div>
    </div>
</div>
@else
    <div class="product-single__images">
        <div class="product-single__img">
            <a href="{{ asset($product->image) }}" data-fancybox="gallery">
                <img src="{{ asset($product->image) }}">
            </a>
        </div>
    </div>
@endif