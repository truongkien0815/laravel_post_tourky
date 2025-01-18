<?php
     $segment_check = Request::segment(1);
?>




   <ul>
    <?php $__currentLoopData = $menu_main; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <li>
        <a href="<?php echo e(url($menu['link']??'#')); ?>" class="<?php echo e($menu['class']); ?> <?php echo e($segment_check == $menu['link']  || empty($segment_check) && in_array($menu['link'], ['trang-chu', '/']) ? 'active' : ''); ?>">
        
            <?php if(in_array($menu['link'], ['trang-chu', '/'])): ?>
            <img src="<?php echo e(asset('img/home.png')); ?>" alt="" />
            
        <?php else: ?>
            <?php echo e($menu['label']); ?>

        <?php endif; ?>
        
        </a></li>
                       
                    </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                       
                        
                       
                       
                    </ul><?php /**PATH D:\laragon\www\congnghiepnew-call-api\resources\views/theme/layouts/menu-main.blade.php ENDPATH**/ ?>