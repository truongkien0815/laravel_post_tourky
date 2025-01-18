<?php $__env->startSection('main'); ?>
  <?php echo $content??''; ?>



<?php $__env->stopSection(); ?>




<?php echo $__env->make('email.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\congnghiepnew\resources\views/email/content.blade.php ENDPATH**/ ?>