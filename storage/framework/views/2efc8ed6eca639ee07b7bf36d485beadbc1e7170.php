<?php
    $menu_main = Menu::getByName('Menu-main');
    $time_work = setting_option('time_work');
    $header_lienhe = setting_option('header_lienhe');
?>

<div class="humberger-menu-overlay"></div>
<div class="humberger-menu-wrapper">
    <div class="hw-logo">
        <a href="/"><img src="<?php echo e(asset('img/logo.png')); ?>" alt=""></a>
    </div>
    <div class="hw-menu mobile-menu">
        <ul>
           


            <li><a href="<?php echo e(url('/')); ?>">Trang chủ</a></li>
            <li><a href="<?php echo e(url('gioi-thieu')); ?>">Về chúng tôi</a></li>
            <li><a href="<?php echo e(url('san-pham')); ?>">sản phẩm</a></li>
            <li><a href="<?php echo e(url('service')); ?>">dịch vụ</a></li>
            <li><a href="<?php echo e(url('quy-trinh')); ?>">quy trình</a></li>
            <li><a href="<?php echo e(url('contact')); ?>">Liên hệ</a></li>
           
        </ul>
    </div>
    <div id="mobile-menu-wrap"></div>
    <div class="hw-copyright">
        Copyright © 2023 Shunyan Ltd. All rights reserved
    </div>
    <div class="hw-social">
        <a href="<?php echo e(setting_option('facebook')); ?>"><i class="fa-brands fa-facebook-f"></i></a>
        <a href="<?php echo e(setting_option('instagram')); ?>"><i class="fa-brands fa-instagram"></i></a>
        <a href="<?php echo e(setting_option('twitter')); ?>"><i class="fa-brands fa-twitter"></i></a>
        <a href="<?php echo e(setting_option('pinterest')); ?>"><i class="fa-brands fa-pinterest-p"></i></a>
        <a href="<?php echo e(setting_option('youtube')); ?>"><i class="fa-brands fa-youtube"></i></a>
    </div>
    
</div>
<header class="header-section">
    <div class="logo">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-3 logo-main mb-3 mb-md-0">
                   <a href="/"><img src="<?php echo e(asset('img/logo.png')); ?>" alt=""></a>
                </div>
                <div class="col-md-9 neo_add">
                    <div class="row">
                        <div class="col-md-4 topper d-flex align-items-center mb-3 mb-md-0">
                            <div class="icon">
                                <img src="<?php echo e(asset('img/time.png')); ?>" />
                            </div>
                            <div class="text">
                                <?php echo htmlspecialchars_decode($time_work); ?>

                               
                            
                            </div>
                        </div>
                        <div class="col-md-4 topper d-flex align-items-center mb-3 mb-md-0">
                            <div class="icon">
                                <img src="<?php echo e(asset('img/phone-call.png')); ?>" />
                            </div>
                            <div class="text">
                            
                                <?php echo htmlspecialchars_decode($header_lienhe); ?>

                              
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="btn-tuvan">
                                <a href="<?php echo e(url('contact')); ?>">liên hệ báo giá</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="nav-options">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="menu-bottom-left">
                <div class="nav-menu">
                    <?php echo $__env->make($templatePath . '.layouts.menu-main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                <div class="humberger-menu humberger-open">
                    <i class="fa-regular fa-bars"></i>
                </div>
            </div>
            <div class="menu-bottom-right">

            


                <div class="searchBox">
                    <form class="searchform" method="get" action="<?php echo e(route('search')); ?>" role="search">
                        <button type="submit" class="icon"><i class="fa-regular fa-magnifying-glass"></i></button>
                        <input type="text" name="keyword" placeholder="Tìm kiếm..." class="form-control ps-5">
                    </form>
                </div>
              
                <div class="language-menu">
                    
                    <a href="#">
                        <img src="<?php echo e(asset('img/vn-lang.png')); ?>" /> <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown">
                        <li class="gtranslate_wrapper">
                           
                          
                        </li>
                     
                    </ul>
                </div>


                <div class="language-menu-2">
                    
                    <a href="<?php echo e(route('cart')); ?>">
                       
                          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-cart4" viewBox="0 0 16 16">
                            <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5M3.14 5l.5 2H5V5zM6 5v2h2V5zm3 0v2h2V5zm3 0v2h1.36l.5-2zm1.11 3H12v2h.61zM11 8H9v2h2zM8 8H6v2h2zM5 8H3.89l.5 2H5zm0 5a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0m9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0"/>
                          </svg>
                        
                        <span id="CartCount"><?php echo e(Cart::count()); ?></span></a>
                </div>
                
              
            </div>
        </div>
    </div>
</header>
<?php if(!Auth::check()): ?>
    <div class="modal fade" id="signin-modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-secondary">
                    <ul class="nav nav-tabs card-header-tabs" role="tablist">
                        <li class="nav-item"><a class="nav-link fw-medium active" href="#signin-tab" data-bs-toggle="tab" role="tab" aria-selected="true"><i class="ci-unlocked me-2 mt-n1"></i>Đăng nhập</a></li>
                        <li class="nav-item"><a class="nav-link fw-medium" href="#signup-tab" data-bs-toggle="tab" role="tab" aria-selected="false"><i class="ci-user me-2 mt-n1"></i>Đăng ký</a></li>
                    </ul>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body tab-content py-4">
                    <form action="" class="needs-validation tab-pane fade active show" autocomplete="off" novalidate="" id="signin-tab">
                        <div class="list-content-loading">
                            <div class="half-circle-spinner">
                                <div class="circle circle-1"></div>
                                <div class="circle circle-2"></div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="si-email">Email</label>
                            <input class="form-control" type="email" id="si-email" name="email" placeholder="text@example.com" required="">
                            <div class="invalid-feedback">Nhập địa chỉ Email của bạn.</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="si-password">Mật khẩu</label>
                            <div class="password-toggle">
                                <input class="form-control" type="password" id="si-password" name="password" required="">
                                <label class="password-toggle-btn" aria-label="Show/hide password">
                                    <input class="password-toggle-check" type="checkbox"><span class="password-toggle-indicator"></span>
                                </label>
                            </div>
                        </div>
                        <div class="mb-3 d-flex flex-wrap justify-content-between">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="si-remember">
                                <label class="form-check-label" for="si-remember">Ghi nhớ đăng nhập</label>
                            </div>
                            <a class="fs-sm" href="#">Quên mật khẩu?</a>
                        </div>
                        <div class="error-message" style="display: none;"></div>
                        <button class="btn btn-primary d-block w-100 btn-login" type="button">Đăng nhập</button>
                    </form>
                    <form class="needs-validation tab-pane fade" action="<?php echo e(route('postRegisterCustomer')); ?>" autocomplete="off" novalidate="" id="signup-tab">
                        <div class="list-content-loading">
                            <div class="half-circle-spinner">
                                <div class="circle circle-1"></div>
                                <div class="circle circle-2"></div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="su-name">Họ tên</label>
                            <input class="form-control" type="text" id="su-name" name="fullname" placeholder="Họ tên" required="">
                            <div class="invalid-feedback">Vui lòng nhập họ tên.</div>
                        </div>
                        <div class="mb-3">
                            <label for="su-email">Email</label>
                            <input class="form-control" type="email" id="su-email" name="email" required="">
                            <div class="invalid-feedback">Nhập địa chỉ Email của bạn.</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="su-password">Mật khẩu</label>
                            <div class="password-toggle">
                                <input class="form-control" type="password" id="password" name="password" required="">
                                <label class="password-toggle-btn" aria-label="Show/hide password">
                                    <input class="password-toggle-check" type="checkbox"><span class="password-toggle-indicator"></span>
                                </label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="su-password-confirm">Xác nhận mật khẩu</label>
                            <div class="password-toggle">
                                <input class="form-control" type="password" id="su-password-confirm" name="password_confirmation" required="">
                                <label class="password-toggle-btn" aria-label="Show/hide password">
                                    <input class="password-toggle-check" type="checkbox"><span class="password-toggle-indicator"></span>
                                </label>
                            </div>
                        </div>
                        <div class="mb-3 col-12">
                            <div class="error-message text-center " style="color: #f00;"></div>
                        </div>
                        <button class="btn btn-primary d-block w-100 btn-register" type="button">Đăng ký</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <?php $__env->startPush('after-footer'); ?>
        <script>
            jQuery(document).ready(function($) {
                $("#signup-tab").validate({
                    onfocusout: false,
                    onkeyup: false,
                    onclick: false,
                    rules: {
                        'su-name': "required",
                        'su-phone': "required",
                        'su-email': "required",
                        'su-password': "required",
                        'su-password-confirm': "required",
                    },
                    messages: {
                        'su-name': "Nhập họ tên",
                        'su-phone': "Nhập số điện thoại",
                        'su-email': "Nhập địa chỉ E-mail",
                        'su-password' : "Nhập mật khẩu",
                        'su-password-confirm' : "Nhập lại mật khẩu"
                    },
                    errorElement : 'div',
                    errorLabelContainer: '.errorTxt',
                    invalidHandler: function(event, validator) {
                        $('html, body').animate({
                            scrollTop: 0
                        }, 500);
                    }
                });
                $('.btn-register').click(function(event) {
                    form_id = $('#signup-tab');
                    if(form_id.valid()){

                        form_id.find('.list-content-loading').show();
                        var form = document.getElementById('signup-tab');

                        var fdnew = new FormData(form);

                        axios({
                            method: 'POST',
                            url: form_id.prop("action"),
                            data: fdnew,

                        }).then(res => {
                            var url_back = '';

                            if (res.data.error == 0) {
                                url_back = res.data.redirect_back;
                                form_id.html(res.data.view);
                                $('#signin-modal').on('hidden.bs.modal', function (e) {
                                    window.location.href= '/';
                                })
                            }
                            else{
                                form_id.find('.error-message').html(res.data.msg);
                                form_id.find('.list-content-loading').hide();
                            }

                        }).catch(e => console.log(e));
                    }
                });

            });
        </script>
    <?php $__env->stopPush(); ?>
<?php endif; ?><?php /**PATH D:\laragon\www\congnghiepnew\resources\views/theme/layouts/header.blade.php ENDPATH**/ ?>