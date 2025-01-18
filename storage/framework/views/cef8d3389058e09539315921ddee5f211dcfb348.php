<?php
   $variables = \App\Model\ShopVariable::orderBy('sort', 'asc')->get();
   $variables_feature = \App\Model\ShopProductItem::where('product_id', $product_id)->orderBy('id', 'asc')->get();
   //dd($variables_feature);
?>

<div class="variable-list">
   <?php if($variables_feature->count()): ?>
      <?php $__currentLoopData = $variables_feature; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
         <?php echo $__env->make('admin.product.includes.variable-item', ['index' => $index, 'data' => $data], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
   <?php else: ?>
      <?php echo $__env->make('admin.product.includes.variable-item', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
   <?php endif; ?>
</div>

<div class="text-right">
   <button type="button" class="btn btn-primary v-item-add">+ Add item</button>
</div>

<?php $__env->startPush('scripts'); ?>
<!-- add script here -->
<script>
   jQuery(document).ready(function($) {
      $(document).on('change', '.key-selector', function(){
         var input_type = $(this).val();
         $(this).parent().find('input').attr('type', input_type);
      });

      $(document).on('click', '.add-feature', function(){
         var html = $(this).closest('.variable-item').find('.feature-clone').clone();
         html.removeClass('feature-clone');
         $(this).closest('.variable-item').find('.feature-clone').parent().append(html);
      });
      $(document).on('click', '.remove-item', function(){
         $(this).closest('.variable-item').remove();
      });

      $(document).on('click', '.v-item-add', function(){
         var html = $('.item-clone').clone(),
            item = $('.variable-item').length;

         html.removeClass('item-clone');
         html.find('.value-input').attr('name', 'feature['+item+'][]');
         html.find('.key-selector').attr('name', 'feature_select['+item+'][]');
         html.find('.gallery_body').attr('data', item);
         html.find('.gallery_box').html('');
         $('.variable-list').append(html);

         /*var html = $(this).closest('.variable-box').find('.variable-list').find('.form-group.clone').clone();
         html = html.removeClass('clone').find('input').val('');
         $(this).closest('.variable-box').find('.variable-list').append(html);*/
      });
   });
</script>
<?php $__env->stopPush(); ?><?php /**PATH D:\laragon\www\congnghiepnew\resources\views/admin/product/includes/variables.blade.php ENDPATH**/ ?>