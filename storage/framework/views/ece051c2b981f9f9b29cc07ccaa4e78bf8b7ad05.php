<?php $__env->startSection('seo'); ?>
<?php echo $__env->make($templatePath .'.layouts.seo', $seo??[] , \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('seo'); ?>
<title><?php echo e(!empty($news->seo_title) ? $news->seo_title : $news->title); ?></title>
<link rel="canonical" href="<?php echo e(url('/')); ?>" />
<meta name="robots" content="index, follow">
<meta name="description" content="<?php echo e(!empty($news->seo_description) ? $news->seo_description : strip_tags(htmlspecialchars_decode($news->description))); ?>">
<meta property="og:title" content="<?php echo e(!empty($news->seo_title) ? $news->seo_title : $news->title); ?>" />
<meta property="og:description" content="<?php echo e(!empty($news->seo_description) ? $news->seo_description : strip_tags(htmlspecialchars_decode($news->description))); ?>" />
<meta property="og:image" content="<?php echo e(asset( $news->image)); ?>" />
<meta property="og:url" content="<?php echo e(url()->current()); ?>" />
<meta property="og:site_name" content="<?php echo e(Helpers::get_option_minhnn('og-site-name')); ?>" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>


<!--=================================
blog-detail -->
<section class="space-ptb py-5">
  <div class="container">
    <div class="row">
        <div class="col-lg-9">
          <div class="blog-detail">
            <div class="blog-post">
              <div class="blog-post-title mb-3">
                <h2><?php echo e($news->name); ?></h2>
              </div>

              <div class="blog-post-content border-0">
                <?php echo htmlspecialchars_decode($news->content); ?>

              </div>
              <hr>
              <div class="mt-3">
                <span class="d-inline-block align-middle text-muted fs-sm me-3 mt-1 mb-2">Share post:</span>
                <a class="btn-social bs-facebook me-2 mb-2" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo e(url()->current()); ?>&amp;t=<?php echo e($news->title); ?>"><i class="fab fa-facebook"></i></a>
                <a class="btn-social bs-twitter me-2 mb-2" href="http://twitter.com/share?text=text goes here&url=<?php echo e(url()->current()); ?>"><i class="fab fa-twitter"></i></a>
                <a class="btn-social bs-pinterest me-2 mb-2" href="http://www.instagram.com/?url=<?php echo e(url()->current()); ?>"><i class="fab fa-pinterest"></i></a>
              </div>
            </div>
          </div>

          <div class="blog-featured">
            <h6 class="text-primary mb-3"><?php echo app('translator')->get('Hoạt động liên quan'); ?></h6>
            <ul class="pl-3">
              <?php if(count($news_featured)>0): ?>
                <?php $__currentLoopData = $news_featured; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li>
                  <a href="<?php echo e(route('news.single', ['id' => $item->id, 'slug' => $item->slug], true, $lc)); ?>"><?php echo e($item->name); ?></a>
                </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              <?php endif; ?>
            </ul>
          </div>  
        </div>
        <div class="col-lg-3 mt-5 mt-lg-0">
          <div class="blog-sidebar">
            <div class="widget">
              <div class="widget-title mb-3">
                <h6>Hoạt động</h6>
              </div>
                <?php if(count($news_featured)>0): ?>
                    <?php $__currentLoopData = $news_featured; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="row mb-3">
                        <div class="col-md-3">
                          <img class="img-fluid" src="<?php echo e(asset($item->image)); ?>" alt="">
                        </div>
                        <div class="col-md-9">
                          <a class="text-dark" href="<?php echo e(route('news.single', ['id' => $item->id, 'slug' => $item->slug], true, $lc)); ?>"><b><?php echo e($item->name); ?> </b></a>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
</section>
<!--=================================
blog-detail -->
 <?php $__env->startPush('after-footer'); ?>
  <script src="https://sp.zalo.me/plugins/sdk.js"></script>
    <script>
      jQuery(document).ready(function($) {
        $('.view-phone').click(function(event) {
          var phone = '<?php echo e(Helpers::get_option_minhnn('zalo')); ?>';
          $(this).find('span').text(phone);
          $(this).attr('href', 'tel:' + phone);
        });
      });

    </script>
  <?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make($templatePath .'.layouts.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\congnghiepnew\resources\views/theme/news/single.blade.php ENDPATH**/ ?>