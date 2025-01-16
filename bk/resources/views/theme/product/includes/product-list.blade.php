<div class="row list-group-product g-4">
    <div class="item">
        <div class="thumb">
            <a href="javascript:;" title="">
                @if(!empty($page) && $page->image)
                    <img src="{{ asset($page->image) }}">
                @elseif(!empty($category) && $category->image)
                    <img src="{{ asset($category->image) }}">
                @endif
            </a>
        </div>
    </div>
    @foreach($products as $product)
      @include($templatePath .'.product.product-item')
    @endforeach

<div>
    {!! $products->links() !!}
</div>
</div>