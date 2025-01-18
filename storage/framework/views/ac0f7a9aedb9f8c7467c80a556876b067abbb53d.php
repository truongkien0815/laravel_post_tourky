<?php if(!empty($dataTotal) && count($dataTotal)): ?>
<div id="showTotal">
   <?php $__currentLoopData = $dataTotal; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($element['code']=='total'): ?>
        <div class="showTotal mb-3 pb-3 into-money">
            <div class="title"><?php echo $element['title']; ?>:</div>
            <div class="price <?php echo e($element['code']); ?>" id="<?php echo e($element['code']); ?>">
                <?php echo $element['text']; ?>

            </div>
        </div>
        <?php elseif($element['value'] !=0): ?>
            <div class="showTotal mb-1">
                <div class="title"><?php echo $element['title']; ?>

                    <?php if($element['code']=='discount'): ?>
                    <span style="cursor: pointer;" class="text-danger" id="removeCoupon" title="Remove coupon"><i class="fa fa fa-times"></i></span>
                    <?php endif; ?>
                </div>
                <div class="price" id="<?php echo e($element['code']); ?>">
                    <?php echo $element['text']; ?>

                </div>
            </div>
        <?php endif; ?>
   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php endif; ?><?php /**PATH D:\laragon\www\congnghiepnew\resources\views/theme/cart/render_total.blade.php ENDPATH**/ ?>