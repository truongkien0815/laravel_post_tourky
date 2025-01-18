<?php extract($data); ?>



<?php $__env->startSection('seo'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php if(Request::is('trang-chu')): ?>
<?php echo $__env->make( $templatePath .'.partials.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php else: ?>
    
  <div id='page-content'>
 
   <div class="page-wrapper container">
    <?php echo htmlspecialchars_decode($page->content); ?>

   </div>
  </div>
 <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make($templatePath.'.layouts.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\congnghiepnew-call-api\resources\views/theme/page/index.blade.php ENDPATH**/ ?>