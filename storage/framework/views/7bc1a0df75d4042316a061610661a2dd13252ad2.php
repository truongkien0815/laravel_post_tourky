<?php if(!empty($options) && count($options)): ?>
	<?php
		$item_id_current = 0;
	?>
	<div class="cart__meta-text">
		<?php $__currentLoopData = $cart->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $groupAttr => $variable): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		    <?php
		        $attr_feature = explode('__', $groupAttr);
		        $item_id = $attr_feature[1]??0;
		        $feature_item = \App\Model\ShopProductItem::find($item_id);
		    ?>
		    <div><?php echo e($attr_feature[0]??''); ?>: <b><?php echo e($variable); ?></b></div>
		    <?php if($item_id_current == $item_id): ?>
		    <div>SKU: <b><?php echo e($feature_item->sku??''); ?></b></div>
		    <?php endif; ?>
		    <?php
		    	if($item_id_current != $item_id)
		        	$item_id_current = $item_id;
		    ?>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</div>
<?php endif; ?><?php /**PATH D:\laragon\www\congnghiepnew\resources\views/theme/cart/includes/render-attr-item.blade.php ENDPATH**/ ?>