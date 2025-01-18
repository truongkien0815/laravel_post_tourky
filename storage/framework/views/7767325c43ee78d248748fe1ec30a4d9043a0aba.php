<?php
    $states = \App\Model\LocationProvince::get();
?>


<?php $__env->startSection('seo'); ?>
<?php echo $__env->make($templatePath .'.layouts.seo', $seo??[] , \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>

    <section class="py-5 my-post bg-light  position-relative">
        <div class="container">
            <div class="row justify-content-end">
                <div class="col-lg-3  col-12 mb-4">
                    <?php echo $__env->make($templatePath .'.customer.includes.sidebar-customer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                <div class="col-lg-9 col-12">
                    <div class="border bg-white p-3">
                        <div class="section-title mb-3 d-flex align-items-center justify-content-center">
                          <h4>Thông tin cá nhân</h4>
                        </div>
                        <form action="<?php echo e(route('customer.updateprofile')); ?>" method="post" accept-charset="utf-8"  enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <div class="row">
                                <div class="form-group col-md-6 mb-3">
                                  <label class="mb-2">Họ tên</label>
                                  <input type="text" class="form-control" name="fullname" value="<?php echo e($user->fullname); ?>">
                                </div>
                                <div class="form-group col-md-6 mb-3">
                                  <label class="mb-2">Email</label>
                                  <input type="text" class="form-control" readonly value="<?php echo e($user->email); ?>">
                                </div>
                                <div class="form-group col-md-6 mb-3">
                                  <label class="mb-2">Điện thoại</label>
                                  <input type="text" class="form-control" name="phone" value="<?php echo e($user->phone); ?>">
                                </div>
                            </div>

                            <div class="section-title my-3 d-flex align-items-center justify-content-center">
                              <h4>Địa chỉ nhận hàng</h4>
                            </div>
                            <fieldset>
                                <div class="mb-3 required">
                                    <label class="form-label" for="province">Tỉnh / Thành phố <span class="required-f">*</span></label>
                                    <select name="province" id="province" class="form-select">
                                        <option value=""> --- Chọn Tỉnh / Thành phố --- </option>
                                        <?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($state->name); ?>" <?php echo e($user->province == $state->id || $user->province == $state->name ? 'selected' : ''); ?>><?php echo e($state->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="mb-3 required">
                                    <label class="form-label" for="district">Quận/Huyện <span class="required-f">*</span></label>
                                    <select name="district" id="district" class="form-select" data-province="<?php echo e($user->province); ?>" data="<?php echo e($user->district); ?>">
                                        <option value=""> --- Chọn Quận/Huyện --- </option>
                                    </select>
                                </div>
                                <div class="mb-3 required">
                                    <label class="form-label" for="ward">Phường/xã <span class="required-f">*</span></label>
                                    <select name="ward" id="ward" class="form-select" data-district="<?php echo e($user->district); ?>" data="<?php echo e($user->ward); ?>">
                                        <option value=""> --- Chọn Phường/xã --- </option>
                                    </select>
                                </div>

                                <div class="mb-3 required">
                                    <label class="form-label" for="input-address-1">Địa chỉ <span class="required-f">*</span></label>
                                    <input name="address_line1" value="<?php echo e($user->address); ?>" id="input-address-1" type="text" class="form-control">
                                </div>

                            </fieldset>

                            <hr>
                            <div class="row">
                                <div class="col-12 mt-3 mb-5">
                                  <h6>Cập nhật ảnh đại diện</h6>
                                  <p>Vui lòng chọn ảnh hình vuông, kích thước khoảng 500px x 500px</p>
                                  <div class="input-group file-upload">
                                    <input type="file" name="avatar_upload" class="form-control" id="customFile">
                                    <label class="input-group-text" for="customFile">Chọn file</label>
                                  </div>
                                </div>

                                <div class="form-group col-md-12 mb-3 text-center">
                                    <button type="submit" class="btn-main">Cập nhật</button>
                                </div>
                            </div>
                        </form>
                    </div>  
                </div>
            </div>
        </div>
    </section>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('after-footer'); ?>

<?php $__env->stopPush(); ?>

<?php echo $__env->make($templatePath .'.layouts.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\congnghiepnew\resources\views/theme/customer/profile.blade.php ENDPATH**/ ?>