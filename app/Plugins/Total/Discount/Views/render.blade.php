<div class="row">
    <div class="form-group col-md-12">
      {{--
      <label class="control-label" for="inputGroupSuccess3"><i class="fa fa-exchange" aria-hidden="true"></i> {{ sc_language_render('cart.coupon') }}
          <span style="display:inline; cursor: pointer; display: {{ (!empty(session('totalMethod')[$plugin['key']]))?'inline':'none' }}" class="text-danger" id="removeCoupon">({{ sc_language_render('cart.remove_coupon') }} <i class="fa fa fa-times"></i>)</span>
      </label>
      <div id="coupon-group" class="d-flex {{ Session::has('error_discount')?'has-error':'' }}">
          <input class="form-control form-control-sm bg-image-none me-3" id="coupon-value" type="text" placeholder="Coupon code" {{ ($plugin['permission'])?'':'disabled' }}>
          <button class="btn-main {{ ($plugin['permission'])?'':'disabled' }} text-nowrap" type="button" {!! ($plugin['permission'])?'id="coupon-button"':'' !!}>{{ sc_language_render('cart.apply') }}</button>
      </div>

      --}}
      <div id="coupon-group" class="input-group {{ Session::has('error_discount')?'has-error':'' }}">
        <input type="text" {{ ($plugin['permission'])?'':'disabled' }} placeholder="Your coupon" class="form-control" id="coupon-value" aria-describedby="inputGroupSuccess3Status">
        <div class="input-group-prepend">
        <span class="input-group-text {{ ($plugin['permission'])?'':'disabled' }}"  {!! ($plugin['permission'])?'id="coupon-button"':'' !!} style="cursor: pointer;" data-loading-text="<i class='fa fa-spinner fa-spin'></i> checking">{{ sc_language_render('cart.apply') }}</span>
        </div>
      </div>
      <span class="status-coupon" style="display: none;" class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
      <div class="coupon-msg  {{ Session::has('error_discount')?'text-danger':'' }}" style="text-align: left; font-size: 13px; margin-top: 5px; {{ Session::has('error_discount')? 'color:red':'' }}">{{ Session::has('error_discount')?Session::get('error_discount'):'' }}</div>
    </div>
</div>
