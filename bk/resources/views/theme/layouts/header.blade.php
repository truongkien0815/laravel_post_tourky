@php
    $menu_main = Menu::getByName('Menu-main');
@endphp

<div class="offcanvas-menu-overlay"></div>
<div class="offcanvas-menu-wrapper">
    <div class="offcanvas__nav__option">
        <a href="#" class="search-switch"><img src="{{ asset( 'upload/images/general/search.png') }}" alt="" /></a>
        <a href="{{ route('customer.wishlist') }}"><img src="{{ asset( 'upload/images/general/heart.png') }}" alt="" /></a>
        <a href="{{ route('cart') }}"><img src="{{ asset( 'upload/images/general/cart.png') }}" alt="" /> <span>{{ Cart::count() }}</span></a>
    </div>
    <div id="mobile-menu-wrap"></div>
</div>

<!-- <div class="search-model">
    <div class="h-100 d-flex align-items-center justify-content-center">
        <div class="search-close-switch">+</div>
        <form class="search-model-form" method="get" action="{{ route('search') }}">>
            <input type="text" id="search-input" name="keyword" placeholder="Search here.....">
        </form>
    </div>
</div> -->

<header class="header-area sticky-top">
    <div class="container">
        <div class="header-content">
            <a href="/" class="logo">
                <img src="{{ setting_option('logo') }}" />
            </a>
            <nav class="header__menu mobile-menu">
                @include($templatePath . '.layouts.menu-main')
            </nav>
            <div class="header__nav__option">
                <div class="search-switch">
                    <img class="icon-search" src="{{ url('upload/images/general/search.png') }}" alt="" />
                </div>
                <div class="search-form dropdown">
                    <form method="get" action="{{ route('search') }}">
                        <input type="hidden" name="submit">
                        <input type="text" id="search-input" name="keyword" placeholder="Search here....." autocomplete="off">
                        <!-- <button type="submit" class="btn-search"><img src="{{ url('upload/images/general/search.png') }}" alt="" /></button> -->
                        <button type="button" class="btn-search search-close"><i class="fas fa-xmark"></i></button>
                    </form>
                    <div class="dropdown-menu search-suggest-list dropdown-menu-end"></div>
                </div>
                <!-- <a href="javascript:;" class="search-switch"></a> -->
                @if(Auth::check())
                    <a href="{{ route('customer.profile') }}">
                        <img src="{{ url('upload/images/general/user-broken.png') }}" alt="{{ request()->user()->fullname }}" />
                    </a>
                @else
                <a href="{{ route('user.login') }}"><img src="{{ url('upload/images/general/user-broken.png') }}" alt="" /></a>
                @endif
                <a href="{{ route('cart') }}"><img src="{{ url('upload/images/general/shopping.png') }}" /><span id="CartCount">{{ Cart::count() }}</span></a>
            </div>
        </div>
        <div class="canvas__open"><i class="fa fa-bars"></i></div>
    </div>
</header>


@if(!Auth::check())
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
                    <form class="needs-validation tab-pane fade" action="{{route('postRegisterCustomer')}}" autocomplete="off" novalidate="" id="signup-tab">
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


    @push('after-footer')
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
    @endpush
@endif