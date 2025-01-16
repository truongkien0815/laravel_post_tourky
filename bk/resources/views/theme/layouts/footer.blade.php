@php
    $menu_footer = Menu::getByName('Menu-footer');
    $phone_sales = setting_option('phone-sales');
    $phone_support = setting_option('phone-support');
    $email = setting_option('company_email');
@endphp
<footer class="footer">
  <div class="top-footer">
      <div class="container-fluid">
          {!! setting_option('footer-service') !!}
      </div>
  </div>
  <div class="main-footer pt-5 pb-4">
      <div class="container">
          <div class="row g-3">
                <div class="col-md-4 footer-info">
                {!! setting_option('footer-company') !!}
                  
                </div>
                <div class="col-md-8">
                    <div class="row g-3 rw-right">
                        @foreach($menu_footer as $index => $item)
                          <div class="{{ $item['class']??'col-lg-3' }}">
                              <h5>{{ $item['label'] }}</h5>
                              @if($item['child'])
                              <ul>
                                @foreach($item['child'] as $menu)  
                                  <li>
                                      <a href="{{ url($menu['link']??'#') }}">{{ $menu['label'] }}</a>
                                  </li>
                                  @endforeach
                              </ul>
                              @endif
                          </div>
                        @endforeach
                        <div class="col-md-5">
                            <h5>Đăng ký nhận ưu đãi từ HAAN</h5>
                            <p>Ut enim ad minim veniam, nostrud exercitation ullamco laboris nisi ut aliquip ex</p>
                            <form method="post" action="{{ route('subscription') }}" id="form-subscription">
                                <div class="form-letter">
                                    <div class="email">
                                        <input type="email" name="your_email" class="form-control" placeholder="Nhập email của bạn">
                                    </div>
                                    <div class="btn-submit">
                                        <button type="button" class="btn btn-subscription">GỬI</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
              </div>
          </div>
      </div>
  </div>
  <div class="bottom-footer">
      <div class="container">
          <div class="row g-3">
              <div class="col-md-8">
                  <p>© Copyright 2024 Expro Việt Nam. Công ty TNHH Giải Pháp Số EXPRO Việt Nam</p>
                  <p>Mã số thuế: 0108658002 cấp tại Phòng đăng ký kinh doanh Sở Kế hoạch và Đầu tư Thành phố Hồ Chí Minh</p>
              </div>
              <div class="col-md-4">
                @if(!empty($socials))
                  <ul>
                    @foreach ($socials as $item)
                    <li>
                      <a href="{{ $item['link'] }}">
                          <img src="{{ url('/upload/images/general/'. $item['name'].'.png' )}}">
                      </a>
                    </li>
                    @endforeach
                  </ul>
                @endif
              </div>
          </div>
      </div>
  </div>
</footer>

@php
  $phone = setting_option('hotline');
  $support_groups = [
    ['link' => route('cart') , 'image' => 'shopping', 'label' => 'Giỏ hàng'],
    ['link' => "tel:{$phone}", 'image' => 'call', 'label' => 'Liên hệ'],
    ['link' => setting_option('zalo'), 'image' => 'zalo', 'label' => 'zalo', 'target' => "_blank"],
    ['link' => setting_option('messenger'), 'image' => 'messenger', 'label' => 'mess', 'target' => "_blank"],
  ];    
@endphp
<div class="group-right">
  @foreach ($support_groups as $item)
  <div class="item">
    <a href="{{ $item['link'] }}" target="{{ $item['target']??'' }}">
        <img src="{{ url('/upload/images/general/'.$item['image'].'.png') }}">
        <p>{{ $item['label'] }}</p>
    </a>
  </div>
  @endforeach
</div>