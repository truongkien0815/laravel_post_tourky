<?php $__env->startSection('content'); ?>
    
    <?php echo htmlspecialchars_decode($page->content); ?>


<?php $__env->stopSection(); ?>
<?php echo $__env->make($templatePath .'.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\congnghiepnew\resources\views/theme/home.blade.php ENDPATH**/ ?>