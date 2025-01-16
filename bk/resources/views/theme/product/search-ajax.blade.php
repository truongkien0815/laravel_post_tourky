@if(!empty($products))
	@foreach($products as $index => $product)
		@if($index < 5)
		<div class="dropdown-item">
			<a href="{{ route('shop.detail', $product->slug) }}" title="{{ $product->name }}">
				<img src="{{ asset($product->image) }}" alt="{{ $product->name }}">
			</a>
			<div class="info_right">
				<a href="{{ route('shop.detail', $product->slug) }}" title="{{ $product->name }}">{{ $product->name }}</a>
				<div class="price">
		            {!! $product->showPrice() !!}
		        </div>
			</div>
		</div>
		@endif
	@endforeach
	@if($product->count()>5)
		<div class="text-center">
            <a href="{{ route('search', ['keyword' => $keyword]) }}" class="viewmore" >Xem thêm
                <svg aria-hidden="true" focusable="false" data-prefix="fal" data-icon="angle-down" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" class="svg-inline--fa fa-angle-down fa-w-8 fa-2x">
                    <path fill="currentColor" d="M119.5 326.9L3.5 209.1c-4.7-4.7-4.7-12.3 0-17l7.1-7.1c4.7-4.7 12.3-4.7 17 0L128 287.3l100.4-102.2c4.7-4.7 12.3-4.7 17 0l7.1 7.1c4.7 4.7 4.7 12.3 0 17L136.5 327c-4.7 4.6-12.3 4.6-17-.1z" class=""></path>
                </svg>
            </a>
        </div>
	@endif
@endif