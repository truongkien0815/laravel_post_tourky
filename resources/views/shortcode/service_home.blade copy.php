

<?php 

$category = \App\Model\Category::where('slug', 'dich-vu')->first();
   
$posts = $category->post()->where('status', 1)->orderBy('sort', 'asc')->limit(4)->get();?>
<!-- 
	<section class="service-section">
		<div class="container">
			<div class="section-title">
				<div>
					<div class="sub-title">{{ $category->name}}</div>
					<h3>Tính năng sáng tạo từ ngành sản xuất</h3>
				</div>
				<a href="/service">XEM TẤT CẢ <img src="{{ asset('img/bi_arrow-up.png')}}" alt="" /></a>
			</div>
			<div class="rw-service">
				@if(!empty($posts))
				@foreach($posts as $post)
				<div class="item-service">
					<a href="{{'news/'.$post->slug. '.html?'.'id='.$post->id}}">
					
						<h6>{{ $post->name}}</h6>
					</a>
					<div class="text_service_content">  	{!! htmlspecialchars_decode($post->content) !!}</div>
					
					<a href="{{'news/'.$post->slug. '.html?'.'id='.$post->id}}">
					
						<img src="{{ asset($post->image)}}" alt="" />
					</a>
				
				</div>
			@endforeach
			
			
			@endif
	
				
			</div>
			
		</div>
	</section> -->


	

<?php 
use App\Product;
 $category = App\Model\ShopCategory::where('parent','0')->first();
 $cate_shop_leve44 = App\Model\ShopCategory::where('parent','=',$category->id)->limit(8)->get();
//  dd($category);
 $products_ = App\Product::limit(8)->get();

//  $products = $products_->get();
// $category = \App\Model\Category::where('slug', 'dich-vu')->first();
   
// $posts = $category->post()->where('status', 1)->orderBy('sort', 'asc')->limit(4)->get();?>

	{{--<section class="service-section">
		<div class="container">
			<div class="section-title">
				<div>
					<div class="sub-title">{{ $category->name}}</div>
					<h3>Tính năng sáng tạo từ ngành sản xuất</h3>
				</div>
				<a href="/service">XEM TẤT CẢ <img src="{{ asset('img/bi_arrow-up.png')}}" alt="" /></a>
			</div>
			<div class="rw-service">
				@if(!empty($posts))
				@foreach($posts as $post)
				<div class="item-service">
					<a href="{{'news/'.$post->slug. '.html?'.'id='.$post->id}}">
					
						<h6>{{ $post->name}}</h6>
					</a>
					<div class="text_service_content">  	{!! htmlspecialchars_decode($post->content) !!}</div>
					
					<a href="{{'news/'.$post->slug. '.html?'.'id='.$post->id}}">
					
						<img src="{{ asset($post->image)}}" alt="" />
					</a>
				
				</div>
			@endforeach
			
			
			@endif
	
				
			</div>
			
		</div>
	</section>--}}

	<section class="prod-home">
		<div class="container">
			<div class="section-title">
				<div>
					<h3>{{ $category->name}} 4</h3>
					<!-- <h3>Bộ phận khuôn kim loại/nhựa</h3> -->
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
										<a href="#">Lò xo</a>
									</div>
								</div>
							</div>
						</div>
						@endforeach
						<!-- <div class="col-md-3 col-item-cate">
							<div class="line1 pagehigh">
								<div class="innermall square text-center">
									<div class="mall_word">
										<a href="#">Lò xo</a>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-3 col-item-cate">
							<div class="line1 pagehigh">
								<div class="innermall square text-center">
									<div class="mall_word">
										<a href="#">Lò xo</a>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-3 col-item-cate">
							<div class="line1 pagehigh">
								<div class="innermall square text-center">
									<div class="mall_word">
										<a href="#">Lò xo</a>
									</div>
								</div>
							</div>
						</div> -->
					</div>
					<div class="row h-100">
						@foreach( $products_ as $item)
						<div class="col-md-3 col-item-prod">
							
							<div class="line2 pageshow1">
								<div class="innermall square">
									<a href="#">
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
						
						<!-- <div class="col-md-3 col-item-prod fatstyle">
							
							<div class="line2 pageshow1">
								<div class="innermall square">
									<a href="#">
										<div class="mall_word">
											<h3>loxo tai rất nhẹ màu</h3>
										</div>
										<div class="mall_pic big_picture">
											<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
										</div>
									</a>
								</div>
							</div>
							<div class="line2 pageshow1">
								<div class="innermall square">
									<a href="#">
										<div class="mall_word">
											<h3>loxo tai rất nhẹ màu</h3>
										</div>
										<div class="mall_pic big_picture">
											<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
										</div>
									</a>
								</div>
							</div>
						</div>
						<div class="col-md-3 col-item-prod fatstyle">
							
							<div class="line2 pageshow1">
								<div class="innermall square">
									<a href="#">
										<div class="mall_word">
											<h3>loxo tai rất nhẹ màu</h3>
										</div>
										<div class="mall_pic big_picture">
											<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
										</div>
									</a>
								</div>
							</div>
							<div class="line2 pageshow1">
								<div class="innermall square">
									<a href="#">
										<div class="mall_word">
											<h3>loxo tai rất nhẹ màu</h3>
										</div>
										<div class="mall_pic big_picture">
											<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
										</div>
									</a>
								</div>
							</div>
						</div>
						<div class="col-md-3 col-item-prod fatstyle">
							
							<div class="line2 pageshow1">
								<div class="innermall square">
									<a href="#">
										<div class="mall_word">
											<h3>loxo tai rất nhẹ màu</h3>
										</div>
										<div class="mall_pic big_picture">
											<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
										</div>
									</a>
								</div>
							</div>
							<div class="line2 pageshow1">
								<div class="innermall square">
									<a href="#">
										<div class="mall_word">
											<h3>loxo tai rất nhẹ màu</h3>
										</div>
										<div class="mall_pic big_picture">
											<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
										</div>
									</a>
								</div>
							</div>
						</div> -->
					</div>
				</div>
			</div>
			<div class="d-lg-none">
				<div class="product-area">
					<div class="items">
						<a href="#">
							<div class="pic">
								<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
							</div>
							<div class="items-body">
								<p>Lò xo</p>
								<h5>loxo tai rất nhẹ màu</h5>
							</div>
						</a>
					</div>
					<div class="items">
						<a href="#">
							<div class="pic">
								<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
							</div>
							<div class="items-body">
								<p>Lò xo</p>
								<h5>loxo tai rất nhẹ màu</h5>
							</div>
						</a>
					</div>
					<div class="items">
						<a href="#">
							<div class="pic">
								<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
							</div>
							<div class="items-body">
								<p>Lò xo</p>
								<h5>loxo tai rất nhẹ màu</h5>
							</div>
						</a>
					</div>
					<div class="items">
						<a href="#">
							<div class="pic">
								<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
							</div>
							<div class="items-body">
								<p>Lò xo</p>
								<h5>loxo tai rất nhẹ màu</h5>
							</div>
						</a>
					</div>
					<div class="items">
						<a href="#">
							<div class="pic">
								<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
							</div>
							<div class="items-body">
								<p>Lò xo</p>
								<h5>loxo tai rất nhẹ màu</h5>
							</div>
						</a>
					</div>
					<div class="items">
						<a href="#">
							<div class="pic">
								<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
							</div>
							<div class="items-body">
								<p>Lò xo</p>
								<h5>loxo tai rất nhẹ màu</h5>
							</div>
						</a>
					</div>
					<div class="items">
						<a href="#">
							<div class="pic">
								<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
							</div>
							<div class="items-body">
								<p>Lò xo</p>
								<h5>loxo tai rất nhẹ màu</h5>
							</div>
						</a>
					</div>
					<div class="items">
						<a href="#">
							<div class="pic">
								<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
							</div>
							<div class="items-body">
								<p>Lò xo</p>
								<h5>loxo tai rất nhẹ màu</h5>
							</div>
						</a>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="prod-home">
		<div class="container">
			<div class="section-title">
				<div>
					<h3>Phụ kiện phần cứng chung</h3>
				</div>
			</div>
			<div class="row d-none d-lg-flex">
				<div class="col-md-3 d-none d-lg-block col-item-prod">
					<a href="#">
						<img src="{{ asset('img/Home_1712363250.png') }}" alt="" />
					</a>
				</div>
				<div class="col-md-9">
					<div class="row">
						<div class="col-md-3 col-item-cate">
							<div class="line1 pagehigh">
								<div class="innermall square text-center">
									<div class="mall_word">
										<a href="#">Lò xo</a>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-3 col-item-cate">
							<div class="line1 pagehigh">
								<div class="innermall square text-center">
									<div class="mall_word">
										<a href="#">Lò xo</a>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-3 col-item-cate">
							<div class="line1 pagehigh">
								<div class="innermall square text-center">
									<div class="mall_word">
										<a href="#">Lò xo</a>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-3 col-item-cate">
							<div class="line1 pagehigh">
								<div class="innermall square text-center">
									<div class="mall_word">
										<a href="#">Lò xo</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row h-100">
						<div class="col-md-3 col-item-prod">
							<!-- <div class="line1 pagehigh">
								<div class="innermall square text-center">
									<div class="mall_word">
										<a href="#">Lò xo</a>
									</div>
								</div>
							</div> -->
							<div class="line2 pageshow1">
								<div class="innermall square">
									<a href="#">
										<div class="mall_word">
											<h3>loxo tai rất nhẹ màu</h3>
										</div>
										<div class="mall_pic big_picture">
											<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
										</div>
									</a>
								</div>
							</div>
							<div class="line2 pageshow1">
								<div class="innermall square">
									<a href="#">
										<div class="mall_word">
											<h3>loxo tai rất nhẹ màu</h3>
										</div>
										<div class="mall_pic big_picture">
											<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
										</div>
									</a>
								</div>
							</div>
						</div>
						<div class="col-md-3 col-item-prod fatstyle">
							<!-- <div class="line1 pagehigh">
								<div class="innermall square text-center">
									<div class="mall_word">
										<a href="#">Lò xo</a>
									</div>
								</div>
							</div> -->
							<div class="line2 pageshow1">
								<div class="innermall square">
									<a href="#">
										<div class="mall_word">
											<h3>loxo tai rất nhẹ màu</h3>
										</div>
										<div class="mall_pic big_picture">
											<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
										</div>
									</a>
								</div>
							</div>
							<div class="line2 pageshow1">
								<div class="innermall square">
									<a href="#">
										<div class="mall_word">
											<h3>loxo tai rất nhẹ màu</h3>
										</div>
										<div class="mall_pic big_picture">
											<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
										</div>
									</a>
								</div>
							</div>
						</div>
						<div class="col-md-3 col-item-prod fatstyle">
							<!-- <div class="line1 pagehigh">
								<div class="innermall square text-center">
									<div class="mall_word">
										<a href="#">Lò xo</a>
									</div>
								</div>
							</div> -->
							<div class="line2 pageshow1">
								<div class="innermall square">
									<a href="#">
										<div class="mall_word">
											<h3>loxo tai rất nhẹ màu</h3>
										</div>
										<div class="mall_pic big_picture">
											<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
										</div>
									</a>
								</div>
							</div>
							<div class="line2 pageshow1">
								<div class="innermall square">
									<a href="#">
										<div class="mall_word">
											<h3>loxo tai rất nhẹ màu</h3>
										</div>
										<div class="mall_pic big_picture">
											<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
										</div>
									</a>
								</div>
							</div>
						</div>
						<div class="col-md-3 col-item-prod fatstyle">
							<!-- <div class="line1 pagehigh">
								<div class="innermall square text-center">
									<div class="mall_word">
										<a href="#">Lò xo</a>
									</div>
								</div>
							</div> -->
							<div class="line2 pageshow1">
								<div class="innermall square">
									<a href="#">
										<div class="mall_word">
											<h3>loxo tai rất nhẹ màu</h3>
										</div>
										<div class="mall_pic big_picture">
											<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
										</div>
									</a>
								</div>
							</div>
							<div class="line2 pageshow1">
								<div class="innermall square">
									<a href="#">
										<div class="mall_word">
											<h3>loxo tai rất nhẹ màu</h3>
										</div>
										<div class="mall_pic big_picture">
											<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
										</div>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="d-lg-none">
				<div class="product-area">
					<div class="items">
						<a href="#">
							<div class="pic">
								<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
							</div>
							<div class="items-body">
								<p>Lò xo</p>
								<h5>loxo tai rất nhẹ màu</h5>
							</div>
						</a>
					</div>
					<div class="items">
						<a href="#">
							<div class="pic">
								<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
							</div>
							<div class="items-body">
								<p>Lò xo</p>
								<h5>loxo tai rất nhẹ màu</h5>
							</div>
						</a>
					</div>
					<div class="items">
						<a href="#">
							<div class="pic">
								<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
							</div>
							<div class="items-body">
								<p>Lò xo</p>
								<h5>loxo tai rất nhẹ màu</h5>
							</div>
						</a>
					</div>
					<div class="items">
						<a href="#">
							<div class="pic">
								<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
							</div>
							<div class="items-body">
								<p>Lò xo</p>
								<h5>loxo tai rất nhẹ màu</h5>
							</div>
						</a>
					</div>
					<div class="items">
						<a href="#">
							<div class="pic">
								<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
							</div>
							<div class="items-body">
								<p>Lò xo</p>
								<h5>loxo tai rất nhẹ màu</h5>
							</div>
						</a>
					</div>
					<div class="items">
						<a href="#">
							<div class="pic">
								<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
							</div>
							<div class="items-body">
								<p>Lò xo</p>
								<h5>loxo tai rất nhẹ màu</h5>
							</div>
						</a>
					</div>
					<div class="items">
						<a href="#">
							<div class="pic">
								<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
							</div>
							<div class="items-body">
								<p>Lò xo</p>
								<h5>loxo tai rất nhẹ màu</h5>
							</div>
						</a>
					</div>
					<div class="items">
						<a href="#">
							<div class="pic">
								<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
							</div>
							<div class="items-body">
								<p>Lò xo</p>
								<h5>loxo tai rất nhẹ màu</h5>
							</div>
						</a>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="prod-home">
		<div class="container">
			<div class="section-title">
				<div>
					<h3>Dụng cụ cắt</h3>
				</div>
			</div>
			<div class="row d-none d-lg-flex">
				<div class="col-md-3 d-none d-lg-block col-item-prod">
					<a href="#">
						<img src="{{ asset('img/Home_1712363250.png') }}" alt="" />
					</a>
				</div>
				<div class="col-md-9">
					<div class="row">
						<div class="col-md-3 col-item-cate">
							<div class="line1 pagehigh">
								<div class="innermall square text-center">
									<div class="mall_word">
										<a href="#">Lò xo</a>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-3 col-item-cate">
							<div class="line1 pagehigh">
								<div class="innermall square text-center">
									<div class="mall_word">
										<a href="#">Lò xo</a>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-3 col-item-cate">
							<div class="line1 pagehigh">
								<div class="innermall square text-center">
									<div class="mall_word">
										<a href="#">Lò xo</a>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-3 col-item-cate">
							<div class="line1 pagehigh">
								<div class="innermall square text-center">
									<div class="mall_word">
										<a href="#">Lò xo</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row h-100">
						<div class="col-md-3 col-item-prod">
							<!-- <div class="line1 pagehigh">
								<div class="innermall square text-center">
									<div class="mall_word">
										<a href="#">Lò xo</a>
									</div>
								</div>
							</div> -->
							<div class="line2 pageshow1">
								<div class="innermall square">
									<a href="#">
										<div class="mall_word">
											<h3>loxo tai rất nhẹ màu</h3>
										</div>
										<div class="mall_pic big_picture">
											<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
										</div>
									</a>
								</div>
							</div>
							<div class="line2 pageshow1">
								<div class="innermall square">
									<a href="#">
										<div class="mall_word">
											<h3>loxo tai rất nhẹ màu</h3>
										</div>
										<div class="mall_pic big_picture">
											<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
										</div>
									</a>
								</div>
							</div>
						</div>
						<div class="col-md-3 col-item-prod fatstyle">
							<!-- <div class="line1 pagehigh">
								<div class="innermall square text-center">
									<div class="mall_word">
										<a href="#">Lò xo</a>
									</div>
								</div>
							</div> -->
							<div class="line2 pageshow1">
								<div class="innermall square">
									<a href="#">
										<div class="mall_word">
											<h3>loxo tai rất nhẹ màu</h3>
										</div>
										<div class="mall_pic big_picture">
											<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
										</div>
									</a>
								</div>
							</div>
							<div class="line2 pageshow1">
								<div class="innermall square">
									<a href="#">
										<div class="mall_word">
											<h3>loxo tai rất nhẹ màu</h3>
										</div>
										<div class="mall_pic big_picture">
											<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
										</div>
									</a>
								</div>
							</div>
						</div>
						<div class="col-md-3 col-item-prod fatstyle">
							<!-- <div class="line1 pagehigh">
								<div class="innermall square text-center">
									<div class="mall_word">
										<a href="#">Lò xo</a>
									</div>
								</div>
							</div> -->
							<div class="line2 pageshow1">
								<div class="innermall square">
									<a href="#">
										<div class="mall_word">
											<h3>loxo tai rất nhẹ màu</h3>
										</div>
										<div class="mall_pic big_picture">
											<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
										</div>
									</a>
								</div>
							</div>
							<div class="line2 pageshow1">
								<div class="innermall square">
									<a href="#">
										<div class="mall_word">
											<h3>loxo tai rất nhẹ màu</h3>
										</div>
										<div class="mall_pic big_picture">
											<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
										</div>
									</a>
								</div>
							</div>
						</div>
						<div class="col-md-3 col-item-prod fatstyle">
							<!-- <div class="line1 pagehigh">
								<div class="innermall square text-center">
									<div class="mall_word">
										<a href="#">Lò xo</a>
									</div>
								</div>
							</div> -->
							<div class="line2 pageshow1">
								<div class="innermall square">
									<a href="#">
										<div class="mall_word">
											<h3>loxo tai rất nhẹ màu</h3>
										</div>
										<div class="mall_pic big_picture">
											<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
										</div>
									</a>
								</div>
							</div>
							<div class="line2 pageshow1">
								<div class="innermall square">
									<a href="#">
										<div class="mall_word">
											<h3>loxo tai rất nhẹ màu</h3>
										</div>
										<div class="mall_pic big_picture">
											<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
										</div>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="d-lg-none">
				<div class="product-area">
					<div class="items">
						<a href="#">
							<div class="pic">
								<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
							</div>
							<div class="items-body">
								<p>Lò xo</p>
								<h5>loxo tai rất nhẹ màu</h5>
							</div>
						</a>
					</div>
					<div class="items">
						<a href="#">
							<div class="pic">
								<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
							</div>
							<div class="items-body">
								<p>Lò xo</p>
								<h5>loxo tai rất nhẹ màu</h5>
							</div>
						</a>
					</div>
					<div class="items">
						<a href="#">
							<div class="pic">
								<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
							</div>
							<div class="items-body">
								<p>Lò xo</p>
								<h5>loxo tai rất nhẹ màu</h5>
							</div>
						</a>
					</div>
					<div class="items">
						<a href="#">
							<div class="pic">
								<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
							</div>
							<div class="items-body">
								<p>Lò xo</p>
								<h5>loxo tai rất nhẹ màu</h5>
							</div>
						</a>
					</div>
					<div class="items">
						<a href="#">
							<div class="pic">
								<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
							</div>
							<div class="items-body">
								<p>Lò xo</p>
								<h5>loxo tai rất nhẹ màu</h5>
							</div>
						</a>
					</div>
					<div class="items">
						<a href="#">
							<div class="pic">
								<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
							</div>
							<div class="items-body">
								<p>Lò xo</p>
								<h5>loxo tai rất nhẹ màu</h5>
							</div>
						</a>
					</div>
					<div class="items">
						<a href="#">
							<div class="pic">
								<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
							</div>
							<div class="items-body">
								<p>Lò xo</p>
								<h5>loxo tai rất nhẹ màu</h5>
							</div>
						</a>
					</div>
					<div class="items">
						<a href="#">
							<div class="pic">
								<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
							</div>
							<div class="items-body">
								<p>Lò xo</p>
								<h5>loxo tai rất nhẹ màu</h5>
							</div>
						</a>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="prod-home">
		<div class="container">
			<div class="section-title">
				<div>
					<h3>Dụng cụ và thiết bị đo lường</h3>
				</div>
			</div>
			<div class="row d-none d-lg-flex">
				<div class="col-md-3 d-none d-lg-block col-item-prod">
					<a href="#">
						<img src="{{ asset('img/Home_1712363250.png') }}" alt="" />
					</a>
				</div>
				<div class="col-md-9">
					<div class="row">
						<div class="col-md-3 col-item-cate">
							<div class="line1 pagehigh">
								<div class="innermall square text-center">
									<div class="mall_word">
										<a href="#">Lò xo</a>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-3 col-item-cate">
							<div class="line1 pagehigh">
								<div class="innermall square text-center">
									<div class="mall_word">
										<a href="#">Lò xo</a>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-3 col-item-cate">
							<div class="line1 pagehigh">
								<div class="innermall square text-center">
									<div class="mall_word">
										<a href="#">Lò xo</a>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-3 col-item-cate">
							<div class="line1 pagehigh">
								<div class="innermall square text-center">
									<div class="mall_word">
										<a href="#">Lò xo</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row h-100">
						<div class="col-md-3 col-item-prod">
							<!-- <div class="line1 pagehigh">
								<div class="innermall square text-center">
									<div class="mall_word">
										<a href="#">Lò xo</a>
									</div>
								</div>
							</div> -->
							<div class="line2 pageshow1">
								<div class="innermall square">
									<a href="#">
										<div class="mall_word">
											<h3>loxo tai rất nhẹ màu</h3>
										</div>
										<div class="mall_pic big_picture">
											<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
										</div>
									</a>
								</div>
							</div>
							<div class="line2 pageshow1">
								<div class="innermall square">
									<a href="#">
										<div class="mall_word">
											<h3>loxo tai rất nhẹ màu</h3>
										</div>
										<div class="mall_pic big_picture">
											<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
										</div>
									</a>
								</div>
							</div>
						</div>
						<div class="col-md-3 col-item-prod fatstyle">
							<!-- <div class="line1 pagehigh">
								<div class="innermall square text-center">
									<div class="mall_word">
										<a href="#">Lò xo</a>
									</div>
								</div>
							</div> -->
							<div class="line2 pageshow1">
								<div class="innermall square">
									<a href="#">
										<div class="mall_word">
											<h3>loxo tai rất nhẹ màu</h3>
										</div>
										<div class="mall_pic big_picture">
											<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
										</div>
									</a>
								</div>
							</div>
							<div class="line2 pageshow1">
								<div class="innermall square">
									<a href="#">
										<div class="mall_word">
											<h3>loxo tai rất nhẹ màu</h3>
										</div>
										<div class="mall_pic big_picture">
											<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
										</div>
									</a>
								</div>
							</div>
						</div>
						<div class="col-md-3 col-item-prod fatstyle">
							<!-- <div class="line1 pagehigh">
								<div class="innermall square text-center">
									<div class="mall_word">
										<a href="#">Lò xo</a>
									</div>
								</div>
							</div> -->
							<div class="line2 pageshow1">
								<div class="innermall square">
									<a href="#">
										<div class="mall_word">
											<h3>loxo tai rất nhẹ màu</h3>
										</div>
										<div class="mall_pic big_picture">
											<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
										</div>
									</a>
								</div>
							</div>
							<div class="line2 pageshow1">
								<div class="innermall square">
									<a href="#">
										<div class="mall_word">
											<h3>loxo tai rất nhẹ màu</h3>
										</div>
										<div class="mall_pic big_picture">
											<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
										</div>
									</a>
								</div>
							</div>
						</div>
						<div class="col-md-3 col-item-prod fatstyle">
							<!-- <div class="line1 pagehigh">
								<div class="innermall square text-center">
									<div class="mall_word">
										<a href="#">Lò xo</a>
									</div>
								</div>
							</div> -->
							<div class="line2 pageshow1">
								<div class="innermall square">
									<a href="#">
										<div class="mall_word">
											<h3>loxo tai rất nhẹ màu</h3>
										</div>
										<div class="mall_pic big_picture">
											<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
										</div>
									</a>
								</div>
							</div>
							<div class="line2 pageshow1">
								<div class="innermall square">
									<a href="#">
										<div class="mall_word">
											<h3>loxo tai rất nhẹ màu</h3>
										</div>
										<div class="mall_pic big_picture">
											<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
										</div>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="d-lg-none">
				<div class="product-area">
					<div class="items">
						<a href="#">
							<div class="pic">
								<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
							</div>
							<div class="items-body">
								<p>Lò xo</p>
								<h5>loxo tai rất nhẹ màu</h5>
							</div>
						</a>
					</div>
					<div class="items">
						<a href="#">
							<div class="pic">
								<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
							</div>
							<div class="items-body">
								<p>Lò xo</p>
								<h5>loxo tai rất nhẹ màu</h5>
							</div>
						</a>
					</div>
					<div class="items">
						<a href="#">
							<div class="pic">
								<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
							</div>
							<div class="items-body">
								<p>Lò xo</p>
								<h5>loxo tai rất nhẹ màu</h5>
							</div>
						</a>
					</div>
					<div class="items">
						<a href="#">
							<div class="pic">
								<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
							</div>
							<div class="items-body">
								<p>Lò xo</p>
								<h5>loxo tai rất nhẹ màu</h5>
							</div>
						</a>
					</div>
					<div class="items">
						<a href="#">
							<div class="pic">
								<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
							</div>
							<div class="items-body">
								<p>Lò xo</p>
								<h5>loxo tai rất nhẹ màu</h5>
							</div>
						</a>
					</div>
					<div class="items">
						<a href="#">
							<div class="pic">
								<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
							</div>
							<div class="items-body">
								<p>Lò xo</p>
								<h5>loxo tai rất nhẹ màu</h5>
							</div>
						</a>
					</div>
					<div class="items">
						<a href="#">
							<div class="pic">
								<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
							</div>
							<div class="items-body">
								<p>Lò xo</p>
								<h5>loxo tai rất nhẹ màu</h5>
							</div>
						</a>
					</div>
					<div class="items">
						<a href="#">
							<div class="pic">
								<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
							</div>
							<div class="items-body">
								<p>Lò xo</p>
								<h5>loxo tai rất nhẹ màu</h5>
							</div>
						</a>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="prod-home">
		<div class="container">
			<div class="section-title">
				<div>
					<h3>Vật tư sản xuất, gia công</h3>
				</div>
			</div>
			<div class="row d-none d-lg-flex">
				<div class="col-md-3 d-none d-lg-block col-item-prod">
					<a href="#">
						<img src="{{ asset('img/Home_1712363250.png') }}" alt="" />
					</a>
				</div>
				<div class="col-md-9">
					<div class="row">
						<div class="col-md-3 col-item-cate">
							<div class="line1 pagehigh">
								<div class="innermall square text-center">
									<div class="mall_word">
										<a href="#">Lò xo</a>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-3 col-item-cate">
							<div class="line1 pagehigh">
								<div class="innermall square text-center">
									<div class="mall_word">
										<a href="#">Lò xo</a>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-3 col-item-cate">
							<div class="line1 pagehigh">
								<div class="innermall square text-center">
									<div class="mall_word">
										<a href="#">Lò xo</a>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-3 col-item-cate">
							<div class="line1 pagehigh">
								<div class="innermall square text-center">
									<div class="mall_word">
										<a href="#">Lò xo</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row h-100">
						<div class="col-md-3 col-item-prod">
							<!-- <div class="line1 pagehigh">
								<div class="innermall square text-center">
									<div class="mall_word">
										<a href="#">Lò xo</a>
									</div>
								</div>
							</div> -->
							<div class="line2 pageshow1">
								<div class="innermall square">
									<a href="#">
										<div class="mall_word">
											<h3>loxo tai rất nhẹ màu</h3>
										</div>
										<div class="mall_pic big_picture">
											<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
										</div>
									</a>
								</div>
							</div>
							<div class="line2 pageshow1">
								<div class="innermall square">
									<a href="#">
										<div class="mall_word">
											<h3>loxo tai rất nhẹ màu</h3>
										</div>
										<div class="mall_pic big_picture">
											<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
										</div>
									</a>
								</div>
							</div>
						</div>
						<div class="col-md-3 col-item-prod fatstyle">
							<!-- <div class="line1 pagehigh">
								<div class="innermall square text-center">
									<div class="mall_word">
										<a href="#">Lò xo</a>
									</div>
								</div>
							</div> -->
							<div class="line2 pageshow1">
								<div class="innermall square">
									<a href="#">
										<div class="mall_word">
											<h3>loxo tai rất nhẹ màu</h3>
										</div>
										<div class="mall_pic big_picture">
											<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
										</div>
									</a>
								</div>
							</div>
							<div class="line2 pageshow1">
								<div class="innermall square">
									<a href="#">
										<div class="mall_word">
											<h3>loxo tai rất nhẹ màu</h3>
										</div>
										<div class="mall_pic big_picture">
											<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
										</div>
									</a>
								</div>
							</div>
						</div>
						<div class="col-md-3 col-item-prod fatstyle">
							<!-- <div class="line1 pagehigh">
								<div class="innermall square text-center">
									<div class="mall_word">
										<a href="#">Lò xo</a>
									</div>
								</div>
							</div> -->
							<div class="line2 pageshow1">
								<div class="innermall square">
									<a href="#">
										<div class="mall_word">
											<h3>loxo tai rất nhẹ màu</h3>
										</div>
										<div class="mall_pic big_picture">
											<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
										</div>
									</a>
								</div>
							</div>
							<div class="line2 pageshow1">
								<div class="innermall square">
									<a href="#">
										<div class="mall_word">
											<h3>loxo tai rất nhẹ màu</h3>
										</div>
										<div class="mall_pic big_picture">
											<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
										</div>
									</a>
								</div>
							</div>
						</div>
						<div class="col-md-3 col-item-prod fatstyle">
							<!-- <div class="line1 pagehigh">
								<div class="innermall square text-center">
									<div class="mall_word">
										<a href="#">Lò xo</a>
									</div>
								</div>
							</div> -->
							<div class="line2 pageshow1">
								<div class="innermall square">
									<a href="#">
										<div class="mall_word">
											<h3>loxo tai rất nhẹ màu</h3>
										</div>
										<div class="mall_pic big_picture">
											<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
										</div>
									</a>
								</div>
							</div>
							<div class="line2 pageshow1">
								<div class="innermall square">
									<a href="#">
										<div class="mall_word">
											<h3>loxo tai rất nhẹ màu</h3>
										</div>
										<div class="mall_pic big_picture">
											<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
										</div>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="d-lg-none">
				<div class="product-area">
					<div class="items">
						<a href="#">
							<div class="pic">
								<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
							</div>
							<div class="items-body">
								<p>Lò xo</p>
								<h5>loxo tai rất nhẹ màu</h5>
							</div>
						</a>
					</div>
					<div class="items">
						<a href="#">
							<div class="pic">
								<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
							</div>
							<div class="items-body">
								<p>Lò xo</p>
								<h5>loxo tai rất nhẹ màu</h5>
							</div>
						</a>
					</div>
					<div class="items">
						<a href="#">
							<div class="pic">
								<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
							</div>
							<div class="items-body">
								<p>Lò xo</p>
								<h5>loxo tai rất nhẹ màu</h5>
							</div>
						</a>
					</div>
					<div class="items">
						<a href="#">
							<div class="pic">
								<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
							</div>
							<div class="items-body">
								<p>Lò xo</p>
								<h5>loxo tai rất nhẹ màu</h5>
							</div>
						</a>
					</div>
					<div class="items">
						<a href="#">
							<div class="pic">
								<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
							</div>
							<div class="items-body">
								<p>Lò xo</p>
								<h5>loxo tai rất nhẹ màu</h5>
							</div>
						</a>
					</div>
					<div class="items">
						<a href="#">
							<div class="pic">
								<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
							</div>
							<div class="items-body">
								<p>Lò xo</p>
								<h5>loxo tai rất nhẹ màu</h5>
							</div>
						</a>
					</div>
					<div class="items">
						<a href="#">
							<div class="pic">
								<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
							</div>
							<div class="items-body">
								<p>Lò xo</p>
								<h5>loxo tai rất nhẹ màu</h5>
							</div>
						</a>
					</div>
					<div class="items">
						<a href="#">
							<div class="pic">
								<img src="{{ asset('upload/files/image_dung/s20.png') }}" alt="" />
							</div>
							<div class="items-body">
								<p>Lò xo</p>
								<h5>loxo tai rất nhẹ màu</h5>
							</div>
						</a>
					</div>
				</div>
			</div>
		</div>
	</section>