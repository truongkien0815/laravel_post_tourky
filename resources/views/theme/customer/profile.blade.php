@php
    $states = \App\Model\LocationProvince::get();
@endphp

@extends($templatePath .'.layouts.index')
@section('seo')
@include($templatePath .'.layouts.seo', $seo??[] )
@endsection


@section('content')

    <section class="py-5 my-post bg-light  position-relative">
        <div class="container">
            <div class="row justify-content-end">
                <div class="col-lg-3  col-12 mb-4">
                    @include($templatePath .'.customer.includes.sidebar-customer')
                </div>
                <div class="col-lg-9 col-12">
                    <div class="border bg-white p-3">
                        <div class="section-title mb-3 d-flex align-items-center justify-content-center">
                          <h4>Thông tin cá nhân</h4>
                        </div>
                        <form action="{{ route('customer.updateprofile') }}" method="post" accept-charset="utf-8"  enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-6 mb-3">
                                  <label class="mb-2">Họ tên</label>
                                  <input type="text" class="form-control" name="fullname" value="{{ $user->fullname }}">
                                </div>
                                <div class="form-group col-md-6 mb-3">
                                  <label class="mb-2">Email</label>
                                  <input type="text" class="form-control" readonly value="{{ $user->email }}">
                                </div>
                                <div class="form-group col-md-6 mb-3">
                                  <label class="mb-2">Điện thoại</label>
                                  <input type="text" class="form-control" name="phone" value="{{ $user->phone }}">
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
                                        @foreach($states as $state)
                                        <option value="{{ $state->name }}" {{ $user->province == $state->id || $user->province == $state->name ? 'selected' : '' }}>{{ $state->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3 required">
                                    <label class="form-label" for="district">Quận/Huyện <span class="required-f">*</span></label>
                                    <select name="district" id="district" class="form-select" data-province="{{ $user->province }}" data="{{ $user->district }}">
                                        <option value=""> --- Chọn Quận/Huyện --- </option>
                                    </select>
                                </div>
                                <div class="mb-3 required">
                                    <label class="form-label" for="ward">Phường/xã <span class="required-f">*</span></label>
                                    <select name="ward" id="ward" class="form-select" data-district="{{ $user->district }}" data="{{ $user->ward }}">
                                        <option value=""> --- Chọn Phường/xã --- </option>
                                    </select>
                                </div>

                                <div class="mb-3 required">
                                    <label class="form-label" for="input-address-1">Địa chỉ <span class="required-f">*</span></label>
                                    <input name="address_line1" value="{{ $user->address }}" id="input-address-1" type="text" class="form-control">
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

@endsection

@push('after-footer')

@endpush
