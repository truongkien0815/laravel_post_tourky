<div class="list-content-loading">
    <div class="half-circle-spinner">
        <div class="circle circle-1"></div>
        <div class="circle circle-2"></div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 mb-3">
        <label for="name" class="form-label"><?php echo e(__('Your name')); ?></label>
        <input required name="contact[name]" type="text" class="form-control" id="name">
    </div>
    <div class="col-lg-6 mb-3">
        <label for="email" class="form-label"><?php echo e(__('Email')); ?></label>
        <input name="contact[email]" type="email" class="form-control" id="email">
    </div>
    <div class="col-lg-12 mb-3">
        <label for="phone" class="form-label"><?php echo e(__('Phone')); ?></label>
        <input name="contact[phone]" type="tel" class="form-control" id="phone">
    </div>
    <div class="col-lg-12 mb-3">
        <label for="subject" class="form-label"><?php echo e(__('Subject')); ?></label>
        <input required name="contact[subject]" type="text" class="form-control" id="subject">
    </div>
</div>


<div class="mb-3">
    <label for="messase" class="form-label"><?php echo e(__('Message')); ?> (không bắt buộc)</label>
    <textarea name="contact[message]" class="form-control" id="message" rows="3"></textarea>
</div>
<?php if(\Session::get('error')): ?>
    <div class="box-message mb-3">
        <p class="text-danger"><?php echo e(__(Session::get('message'))); ?></p>
    </div>
<?php endif; ?>
<?php if(\Session::get('success')): ?>
    <div class="box-message mb-3">
        <p class="text-success"><?php echo e(__(Session::get('message'))); ?></p>
    </div>
<?php endif; ?><?php /**PATH D:\laragon\www\congnghiepnew\resources\views/theme/contact/contact_content.blade.php ENDPATH**/ ?>