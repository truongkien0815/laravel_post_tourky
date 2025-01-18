<?php extract($data); ?>



<?php $__env->startSection('seo'); ?>

<?php $__env->startSection('content'); ?>
    <!-- Products Start -->
    <div class="product-list py-5">
        <div class="container">
            <h4 class="mb-4"><?php echo e(__('Search')); ?> <span>- <?php echo e($products->count()??0); ?> <?php echo e(__('SearchItem')); ?></span></h4>
            <div class="row g-4 wow fadeInUp" data-wow-delay="0.3s">
                <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="col-6 col-md-4 col-lg-3 list-search">
                        <?php echo $__env->make($templatePath.'.product.product-item', compact('product'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p><?php echo e(__('No Results.')); ?></p>
                <?php endif; ?>
            </div>
            
            <div class="mt-3">
                <?php echo $products->withQueryString()->links(); ?>

            </div>
        </div>
    </div>
    <!-- Products End -->

<?php $__env->stopSection(); ?>
<?php echo $__env->make($templatePath .'.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\congnghiepnew\resources\views/theme/product/search.blade.php ENDPATH**/ ?>