<?php
    $data_search = [
        'limit'	=> 5,
        'sort_order'	=> "id__desc"
    ];
    $products = (new \App\Product)->getList($data_search);
?>
<?php if($products->count()): ?>
    <div class="product-relate py-5">
        <div class="container">
            <div class="title-device">
                <h1>Có thể bạn sẽ Quan Tâm</h1>
                <a href="<?php echo e(route('shop')); ?>">Xem tất cả <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="product-slider owl-carousel">
                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo $__env->make($templatePath .'.product.product-item', compact('product'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
<?php endif; ?><?php /**PATH D:\laragon\www\congnghiepnew\resources\views/theme/product/product-related.blade.php ENDPATH**/ ?>