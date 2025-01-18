<div class="form-group">
    <label for="description">Trích dẫn</label>
    <textarea id="<?php echo e($name ?? 'description'); ?>" name="<?php echo e($name ?? 'description'); ?>" class="form-control"><?php echo $description; ?></textarea>
</div>
<?php $__env->startPush('scripts-footer'); ?>
    <script type="text/javascript">
        editorQuote('<?php echo e($name??'content'); ?>');
    </script>
<?php $__env->stopPush(); ?><?php /**PATH D:\laragon\www\congnghiepnew\resources\views/admin/partials/quote.blade.php ENDPATH**/ ?>