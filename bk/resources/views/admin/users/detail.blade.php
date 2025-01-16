@php
$provinces = \App\Model\LocationProvince::get();
@endphp

@extends('admin.layouts.app')
@section('seo')
    <title>Thành viên</title>
@endsection
@section('content')

<?php
    if(isset($user)){
        extract($user->toArray());
    }

    $id = $id??0;
    $type = $type??0;
    $province_id = $province_id??0;
?>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">{{ $title }}</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form action="{{ $url_action }}" method="post" accept-charset="utf-8"  enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $user->id ?? 0 }}">

                <div class="row">
                    <div class="col-9">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{ $title }}</h4>
                            </div> <!-- /.card-header -->
                            <div class="card-body">
                                <!-- show error form -->
                                <div class="errorTxt"></div>
                                @if(count($errors)>0)
                                    <div class="alert-tb alert alert-danger">
                                        @foreach($errors->all() as $err)
                                          <i class="fa fa-exclamation-circle"></i> {{ $err }}<br/>
                                        @endforeach
                                    </div>
                                @endif
                                <div class="row">
                                    <div class="form-group col-md-6 mb-3">
                                      <label class="mb-2">Họ và tên</label>
                                      <input type="text" class="form-control" name="fullname" value="{{ $fullname??'' }}">
                                    </div>
                                    <div class="form-group col-md-6 mb-3">
                                      <label class="mb-2">Email</label>
                                      <input type="text" class="form-control" name="email" value="{{ $email??'' }}">
                                    </div>
                                    <div class="form-group col-md-6 mb-3">
                                      <label class="mb-2">Điện thoại</label>
                                      <input type="text" class="form-control" name="phone" value="{{ $phone??'' }}">
                                    </div>
                                </div>
                                <div class="row">
                                    {{--
                                    <div class="form-group col-md-6 mb-3">
                                        <label class="mb-2">Mã giới thiệu</label>
                                        <input type="text" class="form-control" name="code" value="{{ $code??'' }}">
                                    </div>

                                    <div class="form-group col-md-6 mb-3">
                                        <label class="mb-2">Kinh Nghiệm</label>
                                        <input type="text" class="form-control" name="exp" value="{{ $exp??'' }}">
                                    </div>

                                    <div class="form-group col-md-12 mb-3">
                                        <label class="mb-2">Mạng lưới</label>
                                        <input type="text" class="form-control" name="net" value="{{ $net??'' }}">
                                    </div>

                                    <div class="form-group col-md-12 mb-3">
                                        <label class="mb-2">Phân loại</label>
                                        <select class="form-control" name="type">
                                            <option value="1" {{ $type==1?'selected':'' }}>Dẫn dắt</option>
                                            <option value="2" {{ $type==2?'selected':'' }}>Thực chiến</option>
                                        </select>
                                    </div>

                                    <hr>
                                    --}}

                                    <div class="form-group col-md-12 mb-3">
                                      <label class="mb-2">Giới thiệu</label>
                                      <textarea name="about_me" class="form-control" rows="5">{!! $about_me??'' !!}</textarea>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="form-group col-md-6 mb-3">
                                      <label class="mb-2">Địa chỉ</label>
                                      <input type="text" class="form-control" name="address" value="{{ $address??'' }}">
                                    </div>
                                    <div class="form-group col-md-6 col-lg-6 required">
                                        <label for="state_province" class="mb-2">Tỉnh/thành <span class="required-f">*</span></label>
                                        <select name="state" id="state_province" class="form-control">
                                            <option value=""> --- Please Select --- </option>
                                            @foreach($provinces as $province)
                                            <option value="{{ $province->id }}" {{ $province->id == $province_id ? 'selected' : '' }}>{{ $province->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                {{--
                                <hr>
                                @isset($user)
                                <div class="form-group">
                                    <label for="check_pass">Đổi mật khẩu?</label>
                                    <input type="checkbox" name="check_pass" id="check_pass" value="1">
                                </div>
                                @endisset
                                <div class="wrap-pass" {{ !isset($user) ? 'style=display:block' : '' }}>
                                    <div class="form-group">
                                        <label for="password">Mật khẩu</label>
                                        <input type="password" class="form-control" id="password" name="password" autocomplete="off" value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="repassword">Xác nhận mật khẩu</label>
                                        <input type="password" class="form-control" id="repassword" name="password_confirmation" autocomplete="off" value="">
                                    </div>
                                </div>
                                --}}
                            </div> <!-- /.card-body -->
                        </div><!-- /.card -->   
                    </div>

                    <div class="col-3">
                        @include('admin.partials.action_button', ['public_title'=>'Hoạt động', 'draft_title' => 'Ngưng hoạt động'])
                        @include('admin.partials.image', ['title'=>'Avatar', 'id'=>'img', 'name'=>'avatar', 'image'=> ($avatar ?? '')])

                   </div> <!-- /.col-9 -->

                </div>
                
            </form>

        </div> <!-- /.container-fluid -->
    </section>
    <script type="text/javascript">
    jQuery(document).ready(function ($){
        //check change pass
        $('input[name="check_pass"]').click(function() {
            $('.wrap-pass').toggleClass('avtive-wpap-pass');
        });
    });
    editorQuote('about_me');
</script>
@endsection


@section('style')
<style>
    .wrap-pass{
        display: none;
    }
    .avtive-wpap-pass{
        display: block;
    }
    #frm-create-useradmin .error{
        color:#dc3545;
        font-size: 13px;
    }
</style>
@endsection