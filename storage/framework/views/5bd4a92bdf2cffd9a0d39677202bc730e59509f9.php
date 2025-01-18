<div class="form-group">
    <label for="<?php echo e($name??'content'); ?>"><?php echo e($label??'Nội dung'); ?></label>
    <textarea id="<?php echo e($name??'content'); ?>" name="<?php echo e($name??'content'); ?>" rows="10" class="form-control"><?php echo $content??''; ?></textarea>
</div>
<?php $__env->startPush('scripts-footer'); ?>
<script type="text/javascript">
    editor('<?php echo e($name??'content'); ?>');
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH D:\laragon\www\congnghiepnew\resources\views/admin/partials/content.blade.php ENDPATH**/ ?>