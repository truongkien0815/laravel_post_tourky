@extends('admin.layouts.app')
@section('seo')
    @include('admin.partials.seo')
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Xử lý data</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Xử lý data</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Xử lý data</h4>
                        </div> <!-- /.card-header -->
                        <div class="card-body">
                            <div class="mt-2">
                                <form action="{{ route('admin_product.import_process') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @isset($success)
                                        <div class="mgt-10  alert alert-success alert-dismissible" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                            {!! $success !!}
                                        </div>
                                    @endif
                                    <div class="form-group">
                                        <label for="file_input">File Excel (Chọn file Excel nếu bạn đang update Đồ Điện)</label>
                                        <input type="file" name="file_input" id="file_input" class="form-control-file">
                                    </div>
                                    <div class="form-group text-center">
                                        <button type="submit" class="btn btn-success">Import</button>
                                    </div>
                                </form>
                            </div>
                            <br/>
                            
                        </div> <!-- /.card-body -->
                    </div><!-- /.card -->
                </div> <!-- /.col -->
            </div> <!-- /.row -->
        </div> <!-- /.container-fluid -->
    </section>
@endsection
