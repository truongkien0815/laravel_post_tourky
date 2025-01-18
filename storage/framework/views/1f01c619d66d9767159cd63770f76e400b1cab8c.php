
<div class="border bg-white px-3">
    <div class="agent-contact mb-3 border-bottom">
        <div class="text-center pt-3">
            <div class="avatar">
                <?php if(auth()->user()->avatar): ?>
                    <img src="<?php echo e(auth()->user()->avatar); ?>" alt="">
                <?php else: ?>
                    <i class="fa fa-user-circle-o" aria-hidden="true"></i>
                <?php endif; ?>
            </div>
            <div class="agent-contact-name mt-2">
              <h6><?php echo e(auth()->user()->fullname); ?></h6>
            </div>
        </div>
    </div>

    <div class="widget mb-3">
        <div class="widget-title fs-sm mb-2">
            <b>Quản lý thông tin tài khoản</b>
        </div>
        <a class="dropdown-item" href="<?php echo e(route('customer.my-orders')); ?>">
            <img src="/upload/images/general/list.svg" class="icon_menu"> Đơn hàng của bạn
        </a>
        <a class="dropdown-item" href="<?php echo e(route('customer.profile')); ?>">
            <img src="/upload/images/general/user.svg" class="icon_menu"> Thông tin cá nhân
        </a>
        <a class="dropdown-item" href="<?php echo e(route('customer.changePassword')); ?>">
            <img src="/upload/images/general/lock.svg" class="icon_menu"> Thay đổi mật khẩu
        </a>
        <hr class="my-2">
        <a class="dropdown-item" href="<?php echo e(route('customer.logout')); ?>"><img src="/upload/images/general/logout.svg" class="icon_menu"> Logout</a>
    </div>
</div><?php /**PATH D:\laragon\www\congnghiepnew\resources\views/theme/customer/includes/sidebar-customer.blade.php ENDPATH**/ ?>