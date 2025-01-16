@extends('admin.layouts.app')
@section('seo')
@include('admin.partials.seo')
@endsection
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Contact</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Dashboard              </a></li>
              <li class="breadcrumb-item active">Edit Contact</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

   

     

    
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">General</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
            <form method="post" name="frm" action="{{ url('admin/contact/'.$item->id)}}" enctype="multipart/form-data">
            @method('PUT')
                        @csrf
                        <div class="card-body">
                                    <!-- <label for="inputName">Tiêu đề</label> -->
                                  
                                    <input required name="ten_lienhe" value="{{$item->fullname}}" type="text" id="ten_lienhe" class="form-control"
                                    placeholder="Tên liên hệ...">
                                </div>


                            <div class=" card-body item_lienhe"><input required value="{{$item->address}}"  class="form-control" name="diachi_lienhe" type="text" id="diachi_lienhe"
                                    placeholder="Địa chỉ..."></div>

                            <div class="card-body item_lienhe"><input required value="{{$item->mobile}}"  name="dienthoai_lienhe" class="form-control" type="text" id="dienthoai_lienhe"
                                    placeholder="Điện thoại..."></div>
                                    
                                    <label for="inputStatus">Chọn câu hỏi</label>
                                    <select id="inputStatus" name="question_id" class="form-control custom-select">
                                        <option disabled>Select one</option>
                                      
                                        <option selected value="{{ $item->question_id}}">{{ $item->question_id}}</option>
                                        @foreach($question as $itam)
                                        <option value="{{ $itam->question_list}}">{{ $itam->question_list}}</option>
                                        @endforeach
                                    </select>
                            {{-- <div class="card-body item_lienhe"><input required value="{{$item->email}}"  name="email_lienhe" class="form-control" type="text" id="email_lienhe"
                                    placeholder="Email..."></div>

                            <div class="card-body item_lienhe"><input required value="{{$item->subject}}"  name="tieude_lienhe" class="form-control" type="text" id="tieude_lienhe"
                                    placeholder="Tiêu đề..."></div> --}}

                            <div class="card-body item_lienhe"><textarea   name="noidung_lienhe" class="form-control" id="noidung_lienhe" rows="5"
                                    placeholder="{{$item->content}}" required>
                                    {{$item->content}}
                                  </textarea></div>


                            <div class="card-body item_lienhe">
                                <p>&nbsp;</p>
                                
                                <input type="submit" id="button1" value="Gửi" onclick="js_submit();">
                                <input type="button" id="button2" value="Nhập lại" onclick="document.frm.reset();">
                            </div>
                            <style>
                            #button1 {
                                padding: 7px px 25px;
                                background: #ee0303;
                                border: none;
                                color: #fff;
                                border-radius: 3px;
                                margin: 10px 0px;
                                cursor: pointer;
                            }

                            #button2 {
                                padding: 7px px 25px;
                                background: #ee0303;
                                border: none;
                                color: #fff;
                                border-radius: 3px;
                                margin: 10px 0px;
                                cursor: pointer;
                            }
                            </style>
                        </form>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  @endsection