



<?php extract($data) ?>

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
						<h3 ><?php echo e($category->name); ?></h3>
						
					</div>
				</div>
			</div>
			<div class="row d-none d-lg-flex">
				<div class="col-md-3 d-none d-lg-block col-item-prod">
					<a href="#">
						<img src="<?php echo e(asset($category->image)); ?>" alt="" />
					</a>
				</div>
				<div class="col-md-9">
					<div class="row">
						<?php $__currentLoopData = $cate_shop_leve44; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<div class="col-md-3 col-item-cate">
							<div class="line1 pagehigh">
								<div class="innermall square text-center">
									<div class="mall_word">
										<a class="category-home5" data-product-id="<?php echo e($item->id); ?>" href="#sort"><?php echo e($item->name); ?></a>
									</div>
								</div>
							</div>
						</div>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						<div class="spinner-border d-none loader5" role="status">
							<span class="sr-only">Loading...</span>
						  </div>
					</div>
					<div class="row products5">
						<?php $__currentLoopData = $products_; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<div class="col-md-3 col-item-prod item-product-new">
							
							<div class="line2 pageshow1">
								<div class="innermall square">
									<a href="<?php echo e(url($item->slug.'.html')); ?>">
										<div class="mall_word">
											<h3><?php echo e($item->name); ?></h3>
										</div>
										<div class="mall_pic big_picture">
											<img src="<?php echo e(asset($item->image)); ?>" alt="" />
										</div>
									</a>
								</div>
							</div>
						
							
						</div>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						
					
					</div>
				</div>
			</div>
			<div class="d-lg-none">
				<div class="product-area">
					<?php $__currentLoopData = $products_; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<div class="items">
						<a href="<?php echo e(url($item->slug.'.html')); ?>">
							<div class="pic">
								<img src="<?php echo e(asset($item->image)); ?>" alt="" />
							</div>
							<div class="items-body">
								
								<h5><?php echo e($item->name); ?></h5>
							</div>
						</a>
					</div>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				
				</div>
			</div>
			
		</div>
	</section>

	<?php /**PATH D:\laragon\www\congnghiepnew-call-api\resources\views/shortcode/service_home5.blade.php ENDPATH**/ ?>