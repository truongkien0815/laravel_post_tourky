<?php
    $child = $child??0;
?>
<tr class="tr-item <?php echo e($child?'item-level-1':''); ?>">
    <td class="text-center"><input type="checkbox" id="<?php echo e($data->id); ?>" name="seq_list[]" value="<?php echo e($data->id); ?>"></td>
    <td class="title">
        <a class="row-title" href="<?php echo e(route('admin_type.edit', $data->id)); ?>">
            <b><?php echo e($data->name); ?></b>
            <br>
            <b style="color:#c76805;"><?php echo e($data->slug); ?></b>                                
        </a>
    </td>
    <td class="text-center">
        <?php echo e($data->status == 0 ? 'Draft' : 'Public'); ?>

    </td>
</tr><?php /**PATH D:\laragon\www\congnghiepnew\resources\views/admin/shop-type/item.blade.php ENDPATH**/ ?>