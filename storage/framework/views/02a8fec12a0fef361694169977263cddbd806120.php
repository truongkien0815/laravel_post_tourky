<?php if(!empty($gallery)): ?>
<div class="product-single__images">
    <div class="product-single__img">
        <?php $__currentLoopData = $gallery; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a href="<?php echo e(asset($image)); ?>" data-fancybox="gallery">
            <img src="<?php echo e(asset($image)); ?>">
        </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <div class="thumbs">
        <div class="product-single__gallery">
            <?php $__currentLoopData = $gallery; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="item-thumb">
                <img src="<?php echo e(asset($image)); ?>">
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>
<?php else: ?>
    <div class="product-single__images">
        <div class="product-single__img">
            <a href="<?php echo e(asset($product->image)); ?>" data-fancybox="gallery">
                <img src="<?php echo e(asset($product->image)); ?>">
            </a>
        </div>
    </div>
<?php endif; ?><?php /**PATH D:\laragon\www\congnghiepnew\resources\views/theme/product/product-gallery.blade.php ENDPATH**/ ?>