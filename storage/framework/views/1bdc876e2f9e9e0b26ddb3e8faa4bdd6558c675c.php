
    <div class="gallery_body" data="<?php echo e($index); ?>" data-name="gallery_attr">
        <div class="gallery_box grabbable-parent" id="gallery_sort">
            <?php if(!empty($gallery_attr)): ?>
                <?php $__currentLoopData = $gallery_attr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="gallery_item">
                    <div class="gallery_content">
                        <span class="remove"><i class="fa fa-times-circle" aria-hidden="true"></i></span>
                        <input type="hidden" name="gallery_attr[<?php echo e($index); ?>][]" value="<?php echo e($image); ?>">
                        <img class="gallery-view<?php echo e($key); ?>" src="<?php echo e(asset($image)); ?>">
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div>
        <div class="text-center">
            <button class="btn btn-outline-secondary btn-sm ckfinder-gallery" type="button">Chọn ảnh từ thư viện</button>
        </div>
    </div>
<!--End Post Gallery-->
<?php $__env->startPush('scripts-footer'); ?>
    <script src="<?php echo e(asset('assets/plugin/Sortable.js')); ?>"></script>
    <script type="text/javascript">
        
        jQuery(document).ready(function($){
            /*new Sortable(gallery_sort, {
                swapClass: 'highlight', // The class applied to the hovered swap item
                ghostClass: 'blue-background-class',
                animation: 150
            });*/
            $(document).on('click', '.gallery_item .remove', function(){
                $(this).closest('.gallery_item').remove();
            })

        });
    </script>
<?php $__env->stopPush(); ?><?php /**PATH D:\laragon\www\congnghiepnew\resources\views/admin/partials/galleries_box.blade.php ENDPATH**/ ?>