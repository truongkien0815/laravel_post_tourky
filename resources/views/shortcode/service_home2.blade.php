



@php extract($data) @endphp

<?php 
use App\ProductCategory as Category;
use App\Product;
$category = App\Model\ShopCategory::where('id', $category_id)->first();
 $cate_shop_leve44 = App\Model\ShopCategory::where('parent','=',$category->id)->limit(4)->get();
$category = Category::findOrFail($category->id);
$products_ = $category->products()->limit(8)->get();

?>



	<section class="prod-home">
		<div class="container">
			<div class="row">
				<div class="section-title title_catenew">
					<div>
						<h3 >{{ $category->name}}</h3>
						
					</div>
				</div>
			</div>
			<div class="row d-none d-lg-flex">
				<div class="col-md-3 d-none d-lg-block col-item-prod">
					<a href="#">
						<img src="{{ asset($category->image) }}" alt="" />
					</a>
				</div>
				<div class="col-md-9">
					<div class="row">
						@foreach($cate_shop_leve44 as $item)
						<div class="col-md-3 col-item-cate">
							<div class="line1 pagehigh">
								<div class="innermall square text-center">
									<div class="mall_word">
										<a class="category-home2" data-product-id="{{ $item->id }}" href="#sort">{{ $item->name}}</a>
									</div>
								</div>
							</div>
						</div>
						@endforeach
						<div class="spinner-border d-none loader2" role="status">
							<span class="sr-only">Loading...</span>
						  </div>
					</div>
					<div class="row products2">
						@foreach( $products_ as $item)
						<div class="col-md-3 col-item-prod item-product-new">
							
							<div class="line2 pageshow1">
								<div class="innermall square">
									<a href="{{ url($item->slug.'.html')}}">
										<div class="mall_word">
											<h3>{{ $item->name}}</h3>
										</div>
										<div class="mall_pic big_picture">
											<img src="{{ asset($item->image) }}" alt="" />
										</div>
									</a>
								</div>
							</div>
						
							
						</div>
						@endforeach
						
					
					</div>
				</div>
			</div>
			<div class="d-lg-none">
				<div class="product-area">
					@foreach( $products_ as $item)
					<div class="items">
						<a href="{{ url($item->slug.'.html')}}">
							<div class="pic">
								<img src="{{ asset($item->image) }}" alt="" />
							</div>
							<div class="items-body">
								{{-- <p>Lò xo</p> --}}
								<h5>{{ $item->name}}</h5>
							</div>
						</a>
					</div>
					@endforeach
				
				</div>
			</div>
			
		</div>
	</section>

	