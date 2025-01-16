{{-- @if(!empty($data['category_id']))
    @php
        $category = \App\ProductCategory::where('id', $data['category_id'])->first();
        $products = (new \App\Product)->setCategory($data['category_id'])->getList(['limit' => $data['limit']??10]);
    @endphp
    @if($products->count())
        <div class="product-shirt py-5">
            <div class="container">
                <div class="title-box">
                    <div class="section-heading">
                        <h5>{{ $category->name }}</h5>
                    </div>
                    <a href="{{ route('shop.detail', ['slug' => $category->slug]) }}">Xem thêm</a>
                </div>
                <div class="product-slider owl-carousel">
                    @foreach($products as $key => $product)
                        @include($templatePath .'.product.product-item', compact('product'))
                    @endforeach
                </div>
            </div>
        </div>
    @endif
@endif --}}

<?php 

$category = \App\Model\Category::where('slug', 'dich-vu')->first();
   
$posts = $category->post()->where('status', 1)->orderBy('sort', 'asc')->limit(4)->get()?>

	<section class="service-section">
		<div class="container">
			<div class="section-title">
				<div>
					<div class="sub-title">{{ $category->name}}</div>
					<h3>Tính năng sáng tạo từ ngành sản xuất</h3>
				</div>
				
			</div>
			<div class="rw-service">
				@if(!empty($posts))
				@foreach($posts as $post)
			

				<div class="item-service">
					<a href="{{'news/'.$post->slug. '.html?'.'id='.$post->id}}">
					
						<img src="{{ asset($post->image)}}" alt="" />
					</a>

					<a href="{{'news/'.$post->slug. '.html?'.'id='.$post->id}}">
					
						<h6>{{ $post->name}}</h6>
					</a>
				
					
					<a id="detail_seve" href="{{'news/'.$post->slug. '.html?'.'id='.$post->id}}">Chi tiết <img src="{{ asset('img/bi_arrow-up.png')}}" alt="" /></a>
				</div>
			@endforeach
			
			
			@endif
	
				
			</div>
			
		</div>
	</section>