<?php
    $attrs_selected = $attrs_selected??[];
    $attr_items_id = $attr_items->pluck('id');

    //
    $item_features_selecteds = \App\Model\ShopProductItemFeature::whereIn('product_item_id', $attr_items_id)->whereIn('value', $attrs_selected)->get();
    $item_features = \App\Model\ShopProductItemFeature::whereIn('product_item_id', $attr_items_id)->get();


    $group_attrs = \App\Model\ShopProductItemFeature::whereIn('product_item_id', $attr_items_id)->orderByDesc('created_at')->groupBy('variable_id')->get();
    $item_features_group = \App\Model\ShopProductItemFeature::whereIn('product_item_id', $attr_items_id)->groupBy('value')->get();


?>
<?php if($group_attrs->count()): ?>
    <div class="product-attr" data="<?php echo e($group_attrs->count()); ?>">
        <input type="hidden" name="product_item_id" value="<?php echo e($product_item_id??0); ?>">

        <?php $__currentLoopData = $group_attrs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index_g => $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

        <div class="product-single__option">
            <div class="option-heading">
                <div class="option-heading__title">
                    <?php echo e($group->feature); ?>:
                </div>
            </div>
            <div class="option-select">
                <?php $__currentLoopData = $attr_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item_feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $item = $item_features_group->where('variable_id', $group->variable_id)->where('product_item_id', $item_feature->id)->first();
                        $selected = '';
                    ?>
                    <?php if($item): ?>
                        <?php
                            $disabled = '';
                            if(count($attrs_selected))
                            {
                               $check_feature = [];
                               $item_features_selecteds_another = $item_features_selecteds->where('variable_id', '<>', $group->variable_id);

                               if($item_features_selecteds_another)
                               {
                                  foreach($item_features_selecteds_another as $item_selected)
                                  {
                                     $check_feature = $item_features->where('value', '<>', $item_selected->value)
                                                                      ->where('value', $item->value)
                                                                      ->where('product_item_id', $item_selected->product_item_id)->first();
                                     $disabled = 'disabled';
                                     if($check_feature)
                                     {
                                        $disabled = '';
                                        break;
                                     }
                                  }
                               }
                            }
                            if(in_array( $item->value, $attrs_selected ))
                            {
                               $selected = 'checked';
                               $disabled = '';
                            }
                        ?>
                        <?php if( $group->feature == 'Màu sắc'): ?>
                            <label class="option-select__item option-select__item--color den">
                                <div class="option-select__inner form-attr">
                                    <input type="checkbox" name="feature[<?php echo e($group->variable_id); ?>]" id="item_<?php echo e($item->id); ?>" value="<?php echo e($item->value); ?>" <?php echo e($selected); ?> <?php echo e($disabled); ?>>
                                    <?php if($item->color != ''): ?>
                                    <span class="checkmark checkmark-color <?php echo e($disabled); ?>" style="--data-color: <?php echo e($item->color); ?>" title="<?php echo e($item->value); ?>"><?php echo e($item->value); ?></span>
                                    <?php else: ?>
                                    <span class="checkmark <?php echo e($disabled); ?>"><?php echo e($item->value); ?></span>
                                    <?php endif; ?>
                                </div>
                            </label>
                        <?php else: ?>
                            <label class="option-select__item option-size">
                                <div class="option-select__inner form-attr">
                                    <input type="checkbox" name="feature[<?php echo e($group->variable_id); ?>]" id="item_<?php echo e($item->id); ?>" value="<?php echo e($item->value); ?>" <?php echo e($selected); ?> <?php echo e($disabled); ?>>
                                    <span class="checkmark"><?php echo e($item->value); ?></span>
                                </div>






                            </label>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </div>
        </div>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </div>

<?php endif; ?><?php /**PATH D:\laragon\www\congnghiepnew\resources\views/theme/product/render-attr.blade.php ENDPATH**/ ?>