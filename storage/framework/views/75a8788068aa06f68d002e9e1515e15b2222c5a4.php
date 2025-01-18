

<?php 

$category = \App\Model\Category::where('slug', 'dich-vu')->first();
   
$posts = $category->post()->where('status', 1)->orderBy('sort', 'asc')->limit(4)->get()?>

	<section class="service-section">
		<div class="container">
			<div class="section-title">
				<div>
					<div class="sub-title"><?php echo e($category->name); ?></div>
					<h3>Tính năng sáng tạo từ ngành sản xuất</h3>
				</div>
				
			</div>
			<div class="rw-service">
				<?php if(!empty($posts)): ?>
				<?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			

				<div class="item-service">
					<a href="<?php echo e('news/'.$post->slug. '.html?'.'id='.$post->id); ?>">
					
						<img src="<?php echo e(asset($post->image)); ?>" alt="" />
					</a>

					<a href="<?php echo e('news/'.$post->slug. '.html?'.'id='.$post->id); ?>">
					
						<h6><?php echo e($post->name); ?></h6>
					</a>
				
					
					<a id="detail_seve" href="<?php echo e('news/'.$post->slug. '.html?'.'id='.$post->id); ?>">Chi tiết <img src="<?php echo e(asset('img/bi_arrow-up.png')); ?>" alt="" /></a>
				</div>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			
			
			<?php endif; ?>
	
				
			</div>
			
		</div>
	</section><?php /**PATH D:\laragon\www\congnghiepnew\resources\views/shortcode/product.blade.php ENDPATH**/ ?>