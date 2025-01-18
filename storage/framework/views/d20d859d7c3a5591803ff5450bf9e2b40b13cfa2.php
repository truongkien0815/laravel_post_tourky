




    <?php
      
            $category = \App\Model\Category::where('slug', 'tin-tuc')->first();
   
   $posts = $category->post()->where('status', 1)->orderBy('sort', 'asc')->limit(4)->get();


    ?>
<section class="news-section">
    <div class="container">
        <div class="section-title">
            <div>
                <div class="sub-title">Cổng thông tin</div>
                <h3>tin tức nổi bật</h3>
            </div>
            <a href="<?php echo e(url('tin-tuc')); ?>">XEM TẤT CẢ <img src="<?php echo e(asset('img/bi_arrow-up.png')); ?>" alt="" /></a>
        </div>
       
        <div class="news-slider owl-carousel">
            <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="new-item lp-item">
                <div class="post-thumb lp-thumb">
                    <a href="<?php echo e('news/'.$post->slug. '.html?'.'id='.$post->id); ?>">
                     
                        <img src="   <?php echo e(asset($post->image)); ?>" />

                       
                    </a>
                </div>
                <div class="post-wrapper">
                    <div class="date-time">
                        <span class="time"><i class="fa-light fa-clock"></i> 10:10</span>
                        <span class="date">24/01/2023</span>
                    </div>
                    <a href="<?php echo e('news/'.$post->slug. '.html?'.'id='.$post->id); ?>">
                        <h5><?php echo e($post->name); ?></h5>
                    </a>
                </div>
            </div>
           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          
        
        </div>
        <div class="text-center d-block d-md-none mt-4 mt-md-0">
            <a href="#" class="btn-viewmore">xem tất cả <img src="<?php echo e(asset('img/bi_arrow-up.png')); ?>" alt="" /></a>
        </div>
    </div>
</section>
<?php /**PATH D:\laragon\www\congnghiepnew\resources\views/shortcode/news.blade.php ENDPATH**/ ?>