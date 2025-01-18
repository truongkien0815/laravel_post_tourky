<?php
   $index = $index??0;
   $gallery_attr = '';
   if(!empty($data)){
      $items = \App\Model\ShopProductItemFeature::where('product_item_id', $data->id)->get();
      if(!empty($data->gallery))
            $gallery_attr = json_decode($data->gallery, true);
   }
?>
<div class="row variable-item <?php echo e($index==0?'item-clone':''); ?> border-bottom pb-3 mb-3">
      <div class="col-lg-10">
         <div class="row">
            <?php if(!empty($items) && $items->count()): ?>
                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-lg-3 mb-2 <?php echo e($key==0?'feature-clone':''); ?>">
                   <select class="custom-select key-selector bg-info" name="feature_select[<?php echo e($index); ?>][]">
                      <option value="">--Remove--</option>
                      <?php $__currentLoopData = $variables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variable_item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <?php
                            $selected = '';
                            if($item->variable_id == $variable_item->id)
                                $selected = 'selected';

                          ?>
                          <option value="<?php echo e($variable_item->name); ?>" data-type="<?php echo e($variable_item->input_type); ?>" <?php echo e($selected); ?>><?php echo e($variable_item->name); ?></option>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                   </select>
                   <div class="input-group mb-3 mt-2">
                     <?php if($item->color): ?>
                        <div class="input-group-prepend">
                           <span class="input-group-text" id="basic-addon1" style="width: 40px; background-color: <?php echo e($item->color); ?>;"></span>
                        </div>
                        <input type="text" value="<?php echo e($item->value); ?>__<?php echo e($item->color); ?>" name="feature[<?php echo e($index); ?>][]" class="value-input form-control" >
                     <?php else: ?>
                        <input type="text" value="<?php echo e($item->value); ?>" name="feature[<?php echo e($index); ?>][]" class="value-input form-control" >
                     <?php endif; ?>
                  </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
            <div class="col-lg-3 mb-2 feature-clone">
               <select class="custom-select key-selector bg-info" name="feature_select[<?php echo e($index); ?>][]">
                  <option value="">--Remove--</option>
                  <?php $__currentLoopData = $variables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($item->name); ?>" data-type="<?php echo e($item->input_type); ?>"><?php echo e($item->name); ?></option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               </select>
               <input type="text" value="" name="feature[<?php echo e($index); ?>][]" class="value-input form-control mt-2">
            </div>
            <?php endif; ?>
         </div>
      </div>
      <div class="col-lg-2 text-right">
         <button type="button" class="add-feature btn w-sm btn-primary waves-effect waves-light mb-2">+ Add</button>
         <button type="button" class="remove-item btn w-sm btn-danger waves-effect waves-light mb-2">- Remove item</button>
      </div>
      <div class="col-12">
         <div class="row">
            <div class="col-md-4">
               <div class="form-group">
                  <label>Giá</label>
                  <div class="input-group">
                     <div class="input-group-prepend"><span class="input-group-text">VNĐ</span></div>
                     <input type="number" min="0" step="1" class="form-control" name="feature_price[]" placeholder="Item Price" value="<?php echo e($data->price??0); ?>">
                  </div>
               </div>
            </div>
            <div class="col-md-4">
               <div class="form-group">
                  <label>Giá khuyến mãi</label>
                  <div class="input-group">
                     <div class="input-group-prepend"><span class="input-group-text">VNĐ</span></div>
                     <input type="number" min="0" step="1" class="form-control" name="feature_promotion[]" value="<?php echo e($data->promotion??0); ?>">
                  </div>
               </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>SKU</label>
                    <input type="text" class="form-control" name="feature_sku[]" placeholder="SKU" value="<?php echo e($data->sku??''); ?>">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Số lượng</label>
                    <input type="number" min="0" step="1" class="form-control" name="feature_quantity[]" placeholder="Quantity" value="<?php echo e($data->quantity??0); ?>">
                </div>
            </div>
         </div>
      </div>

      <div class="col-12">
         <?php echo $__env->make('admin.partials.galleries_box', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      </div>

   </div><?php /**PATH D:\laragon\www\congnghiepnew\resources\views/admin/product/includes/variable-item.blade.php ENDPATH**/ ?>