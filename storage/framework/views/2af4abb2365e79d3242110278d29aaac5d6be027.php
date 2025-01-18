<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
  <link rel="shortcut icon" href="<?php echo e(asset(setting_option('favicon'))); ?>" />
  <?php echo $__env->yieldContent('seo'); ?>
  <!-- Google Font: Source Sans Pro -->
  
  <!-- Ionicons -->
  
  <!-- Font Awesome -->
  <link rel="stylesheet" id="fontawesome-css" href="https://use.fontawesome.com/releases/v5.0.1/css/all.css?ver=4.9.1" type="text/css" media="all">
  <!-- Admin Css -->
  <link rel="stylesheet" href="<?php echo e(url('assets/plugin/sweetalert2/sweetalert2.min.css')); ?>">
  <link rel="stylesheet" href="<?php echo e(url('assets/css/admin-expro.min.css')); ?>">
  <!-- Admin Custom Css -->
  <link rel="stylesheet" href="<?php echo e(url('assets/css/style_admin.css?ver=1.11')); ?>">
  <!-- Admin js -->
  <script src="<?php echo e(asset('assets/plugin/sweetalert2/sweetalert2.all.min.js')); ?>"></script>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script src="<?php echo e(asset('assets/js/admin.expro.js')); ?>"></script>

  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

  <script src="<?php echo e(asset('assets/plugin/select2/js/select2.min.js')); ?>"></script>
  <script src="<?php echo e(asset('assets/plugin/bootstrap-switch/js/bootstrap-switch.min.js')); ?>"></script>
  <!-- <script src="<?php echo e(asset('assets/plugin/inputmask/jquery.inputmask.min.js')); ?>"></script> -->

  <link rel="stylesheet" href="<?php echo e(asset('assets/js/datetimepicker/jquery.datetimepicker.min.css')); ?>">
  <script src="<?php echo e(asset('assets/js/datetimepicker/jquery.datetimepicker.full.min.js')); ?>"></script>
  
  <script src="<?php echo e(asset('assets/js/js_admin.js?ver=1.23')); ?>"></script>
  <script src="<?php echo e(asset('js/ckeditor/ckeditor.js')); ?>"></script>
  <script src="<?php echo e(asset('js/ckfinder/ckfinder.js')); ?>"></script>
  <script>CKFinder.config( { connectorPath: '/ckfinder/connector' } );</script>

  <?php echo $__env->yieldContent('style'); ?>
  <?php echo $__env->yieldPushContent('styles'); ?>
</head>

<?php echo $__env->make('admin.layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
          </li>
          <li class="nav-item d-none d-sm-inline-block">
            <a href="<?php echo e(route('index')); ?>" class="nav-link">Home</a>
          </li>
        </ul>

    </nav>
    <!-- /.navbar -->
    <?php echo $__env->make('admin.layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <?php echo $__env->yieldContent('content'); ?>
        <?php echo $__env->yieldContent('contents'); ?>
    </div> <!-- /.content-wrapper -->
<?php echo $__env->make('admin.layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<script type="text/javascript">
  jQuery(document).ready(function ($){
    //Date range picker
    $('#created_at').datetimepicker({
      format: 'Y-m-d H:i'
    });
    $('#cus_from').datetimepicker({
      format: 'YYYY-MM-DD'
    });

    $('#cus_to').datetimepicker({
      format: 'YYYY-MM-DD'
    });

    $('#order_from').datetimepicker({
      format: 'YYYY-MM-DD'
    });

    $('#order_to').datetimepicker({
      format: 'YYYY-MM-DD'
    });
    
  });
</script>
<?php echo $__env->yieldContent('scripts'); ?>
<?php echo $__env->yieldPushContent('scripts'); ?>
<?php echo $__env->yieldPushContent('scripts-footer'); ?>
</body>
</html><?php /**PATH D:\laragon\www\congnghiepnew-call-api\resources\views/admin/layouts/app.blade.php ENDPATH**/ ?>