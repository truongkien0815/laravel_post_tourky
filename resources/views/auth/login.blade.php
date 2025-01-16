@extends($templatePath .'.layouts.index')

@section('content')
    <div id="page-content" class="page-template mt-5">
        <!--Page Title-->
        <div class="page section-header text-center">
            <div class="page-title">
                <div class="wrapper">
                    <h1 class="page-width">Đăng Nhập</h1>
                </div>
            </div>
        </div>
        <!--End Page Title-->

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-sm-12 col-md-6 col-lg-4 main-col">
                    <div class="mb-4">
                        <form method="post" action="{{route('loginCustomerAction')}}" id="form-login-page" accept-charset="UTF-8">
                            <input type="hidden" name="url_back" value="{{ url()->previous() }}">
                            <div class="list-content-loading">
                                <div class="half-circle-spinner">
                                    <div class="circle circle-1"></div>
                                    <div class="circle circle-2"></div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="CustomerEmail">Email</label>
                                <input type="email" name="email" id="email" placeholder="" id="CustomerEmail" class="form-control" autocorrect="off" autocapitalize="none" autofocus="">
                            </div>
                            <div class="mb-3">
                                <label for="CustomerPassword">Mật khẩu</label>
                                <input type="password" value="" name="password" id="password" placeholder="" id="CustomerPassword" class="form-control">
                            </div>

                            <div class="error-message"></div>
                        
                            <div class="text-center col-12 col-sm-12 col-md-12 col-lg-12">
                                <button type="button" class="btn-main mb-3 btn-login-page">@lang('Đăng nhập')</button>
                                <p class="mb-4">
                                    <a href="{{route('forgetPassword')}}" id="RecoverPassword">Quên mật khẩu?</a> &nbsp; | &nbsp;
                                    <a href="{{ route('user.register') }}" id="customer_register_link">Tạo tài khoản</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

<!--=================================
 Modal login -->
<div class="modal login fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="list-content-loading">
                <div class="half-circle-spinner">
                    <div class="circle circle-1"></div>
                    <div class="circle circle-2"></div>
                </div>
            </div>

            <div class="modal-header border-0">
            <h5 class="modal-title" id="loginModalLabel">Đăng nhập</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body"></div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('after-footer')
<script>
    jQuery(document).ready(function($) {
        var login_page = $('#form-login-page');
      login_page.validate({
          onfocusout: false,
          onkeyup: false,
          onclick: false,
          rules: {
              email: "required",
              password: "required",
          },
          messages: {
              email: "Nhập địa chỉ E-mail",
              password : "Nhập mật khẩu",
          },
          errorElement : 'div',
          errorLabelContainer: '.errorTxt',
          invalidHandler: function(event, validator) {
              $('html, body').animate({
                  scrollTop: 0
              }, 500);
          }
      });

        $('.btn-login-page').click(function(event) {
            loginPage();
        });
        $('#form-login-page input').on('keypress', function (e) {
            if(e.which === 13)
            {
                loginPage();
            }
        });

        function loginPage() 
        {
            console.log('fdafas');
            if(login_page.valid()){
                var form = document.getElementById('form-login-page');
                var fdnew = new FormData(form);
                login_page.find('.list-content-loading').show();
                axios({
                    method: 'POST',
                    url: '/customer/login',
                    data: fdnew,

                }).then(res => {
                   console.log(res.data);
                    if (res.data.error == 0) {
                        $('#loginModal').find('.modal-body').html(res.data.view);
                        $('#loginModal').find('.modal-footer').remove();
                        $('#loginModal').modal('show');

                        $('#loginModal').on('hidden.bs.modal', function (e) {
                            // window.location.href="/";
                            window.location.href= res.data.redirect_back;
                        })
                    } 
                    else{
                        login_page.find('.list-content-loading').hide();
                        login_page.find('.error-message').html(res.data.msg);
                    }
                    // login_page.find('.list-content-loading').hide();
                }).catch(e => console.log(e));
            }    
        }
    });
</script>
@endpush