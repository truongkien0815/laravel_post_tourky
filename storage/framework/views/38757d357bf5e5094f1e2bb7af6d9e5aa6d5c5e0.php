<?php $__env->startSection('content'); ?>
<div id="page-content" class="page-template page-register-content pt-5">
    
    <!--Page Title-->
    <div class="page section-header text-center">
        <div class="page-title">
            <div class="wrapper"><h1 class="page-width">Tạo tài khoản</h1></div>
          </div>
    </div>
    <!--End Page Title-->
    
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-12 col-md-6 col-lg-4 main-col">
                <div class="mb-4">
                   <form method="post" action="<?php echo e(route('postRegisterCustomer')); ?>" id="page-customer-register" accept-charset="UTF-8" class="contact-form">	
                        <?php echo csrf_field(); ?>
                        <div class="list-content-loading">
                            <div class="half-circle-spinner">
                                <div class="circle circle-1"></div>
                                <div class="circle circle-2"></div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="fullname">Họ & Tên</label>
                            <input type="text" name="fullname" placeholder="" id="fullname" autofocus="" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="phone">Điện thoại</label>
                            <input type="text" name="phone" placeholder="" id="phone" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="CustomerEmail">Email</label>
                            <input type="email" name="email" placeholder="" id="email" class="form-control" autocorrect="off" autocapitalize="none" autofocus="">
                        </div>
                        <div class="mb-3">
                            <label for="CustomerPassword">Mật khẩu</label>
                            <input type="password" value="" name="password" placeholder="" id="password" class="form-control">                        	
                        </div>
                        <div class="mb-3">
                            <div class="error-message text-danger"></div>
                        </div>

                        <div class="text-center col-12 col-sm-12 col-md-12 col-lg-12">
                            <button type="button" class="btn-main mb-3 btn-page-register">Đăng ký</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    jQuery(document).ready(function($) {
        $("#page-customer-register").validate({
          onfocusout: false,
          onkeyup: false,
          onclick: false,
          rules: {
              fullname: "required",
              phone: "required",
              email: "required",
              password: "required"
          },
          messages: {
            fullname: "Nhập họ & tên",
              phone: "Nhập số điện thoại",
              email: "Nhập địa chỉ E-mail",
              password : "Nhập mật khẩu"
          },
          errorElement : 'div',
          errorLabelContainer: '.errorTxt',
          invalidHandler: function(event, validator) {
              $('html, body').animate({
                  scrollTop: 0
              }, 500);
          }
        });

        $('.btn-page-register').click(function(event) {
            registerPage();
        });
        $('#page-customer-register input').on('keypress', function (e) {
            if(e.which === 13)
            {
                registerPage();
            }
        });

        function registerPage()
        {
            var form_id = $('#page-customer-register');
            if(form_id.valid()){
            
                form_id.find('.list-content-loading').show();
                var form = document.getElementById('page-customer-register');
            
                var fdnew = new FormData(form);
             
                axios({
                       method: 'POST',
                       url: form_id.prop("action"),
                   data: fdnew,

                }).then(res => {
                    var url_back = '';

                    if (res.data.error == 0) {
                        url_back = res.data.redirect_back;
                        $('.page-register-content').html(res.data.view);
                    }
                    else{
                        form_id.find('.error-message').html(res.data.msg);
                        form_id.find('.list-content-loading').hide();
                    }
                    
                }).catch(e => console.log(e));
            }
        }

    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make($templatePath .'.layouts.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\congnghiepnew\resources\views/auth/register.blade.php ENDPATH**/ ?>