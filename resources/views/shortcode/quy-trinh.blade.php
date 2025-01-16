

<?php 

$category = \App\Model\Category::where('slug', 'quy-trinh')->first();
   
$posts = $category->post()->where('status', 1)->orderBy('sort', 'asc')->limit(4)->get()?>

	<section class="service-section">
		<div class="container">
			<div class="section-title">
				<div>
					<div class="sub-title">{{ $category->name}}</div>
					<h3>Tính năng sáng tạo từ ngành sản xuất
					</h3>
				</div>
				
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
	</section>