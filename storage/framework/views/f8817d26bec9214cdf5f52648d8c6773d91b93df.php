<?php 
    if(!isset($parent_id))
        $parent_id = 0;
    $dategories = \App\Model\ShopCategory::where('parent', $parent_id)
            ->orderByDesc('priority')->get();
?>
<?php if(count($dategories)>0): ?>
    <?php $__currentLoopData = $dategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <label for="page_<?php echo e($category->id); ?>" class="form-group <?php echo e($parent_id != 0 ? 'pl-4' : ''); ?>">
            <input type="checkbox" class="category_item_input" value="<?php echo e($category->id); ?>" id="page_<?php echo e($category->id); ?>" >
            <?php echo e($category->name); ?>


            <input type="hidden" class="item-name-<?php echo e($category->id); ?>" value="<?php echo e($category->name); ?>">
            <input type="hidden" class="item-url-<?php echo e($category->id); ?>" value="<?php echo e($category->slug.'.html'); ?>">
        </label>
        <?php if(count($category->children)>0): ?>
            <?php echo $__env->make('vendor.wmenu.includes.category_items', ['parent_id'=> $category->id], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?><?php /**PATH D:\laragon\www\congnghiepnew-call-api\resources\views/vendor/wmenu/includes/category_items.blade.php ENDPATH**/ ?>