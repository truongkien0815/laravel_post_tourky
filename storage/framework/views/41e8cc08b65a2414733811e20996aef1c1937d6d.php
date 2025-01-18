<?php
    $menu_product_hot = Menu::getByName('Product-hot');

    $category_product = \App\Model\ShopCategory::all();
	$category_dichvu = \App\Model\post::get();
	use App\Page as Page;
    $category_gioithieu = \App\Model\Category::where('slug', 'gioi-thieu')->first();
   
   $posts_gt = $category_gioithieu->post()->where('slug','gioi-thieu')->first();
?>




<section class="latest-preview-section">
    <div class="container">
        <div class="row">
            <div class="col-12 position-relative">
                <div class="swiper categories-slider">
                    <div class="swiper-wrapper">
                        <?php $__currentLoopData = $category_product; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="swiper-slide">
                            <div class="lp-item">
                                <div class="lp-thumb">
                                    <a href="<?php echo e($item->slug.'.html'); ?>">
                                        
                                        <img src="<?php echo e(asset($item->image)); ?>" alt="">
                                      
                                    </a>
                                </div>
                                <div class="lp-text">
                                    <div class="box-text">
                                        <h6><a href="<?php echo e($item->slug.'.html'); ?>"><?php echo e($item->name); ?></a></h6>
                                        <img src="<?php echo e(asset('img/arrow-up.png')); ?>" alt="" />
                                    </div>
                                    <a href="<?php echo e($item->slug.'.html'); ?>">Khám phá <img src="<?php echo e(asset('img/arrow-up.png')); ?>" alt="" /></a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                       
                    </div>
                </div>
                <div class="swiper-button-next category-next"></div>
                <div class="swiper-button-prev category-prev"></div>
            </div>
        </div>
    </div>
</section>

<section class="title-name-section">
    <div class="container">
        <div class="title_home">Shunyuan Industrial co.,ltd. </div>
    </div>
</section>



<section class="about-section">
    <div class="container">
        <div class="row g-3">
            <div class="col-md-5">
                <div class="img-about">
                    
                    <img src="	<?php echo e(asset($posts_gt->image)); ?>" alt="">
                </div>
            </div>
            <div class="col-md-7">
                <div class="box-text-about offset-lg-1">
                    <div class="sub-title">Về chúng tôi</div>
                    <div class="content-about">
                        <?php echo htmlspecialchars_decode($posts_gt->content); ?>

                    </div>
                    
                
                   <p> <a href="<?php echo e(url('gioi-thieu')); ?>">tìm hiểu thêm <img src="<?php echo e(asset('img/bi_arrow-up.png')); ?>" alt="" /></a></p>
                </div>
                
            </div>
        </div>
    </div>
</section><?php /**PATH D:\laragon\www\congnghiepnew\resources\views/shortcode/product_hot.blade.php ENDPATH**/ ?>