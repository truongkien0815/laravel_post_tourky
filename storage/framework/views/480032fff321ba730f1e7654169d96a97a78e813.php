<?php 
    $pages = \App\Model\Page::where('status', 1)->orderByDesc('id')->get();
?>
<?php if(count($pages)>0): ?>
    <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <label for="category_<?php echo e($page->id); ?>" class="form-group">
            <input type="checkbox" class="category_item_input" value="<?php echo e($page->id); ?>" id="category_<?php echo e($page->id); ?>" >
            <?php echo e($page->title); ?>


            <input type="hidden" class="item-name-<?php echo e($page->id); ?>" value="<?php echo e($page->title); ?>">
            <input type="hidden" class="item-url-<?php echo e($page->id); ?>" value="<?php echo e($page->slug); ?>">
        </label>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?><?php /**PATH D:\laragon\www\congnghiepnew-call-api\resources\views/vendor/wmenu/includes/page_items.blade.php ENDPATH**/ ?>