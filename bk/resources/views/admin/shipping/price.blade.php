@extends('admin.layouts.app')

@php
    if(!empty($data))
        extract($data->toArray());
@endphp

@section('seo')
    @include('admin.partials.seo')
@endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="m-t-0 header-title"><b>{!! $title !!}</b></h4>
                
                <div class="row">
                    <div class="col-md-4" style="width: 20%">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Thêm/Sửa {{ $title }}</h3>
                            </div> <!-- /.card-header -->
                            <div class="card-body">
                                <form method="POST" action="{{ $url_action }}" accept-charset="UTF-8" enctype="multipart/form-data">
                                    @csrf()
                                    <input type="hidden" name="id" value="{{ $id??0 }}">
                                    
                                    <div class="form-row mb-2">
                                        <label class="col-lg-4 col-form-label" >Tên</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" id="name" name="name" value="{{ $name??'' }}" required>
                                        </div>
                                    </div>

                                    <div class="form-row mb-2">
                                        <label class="col-lg-4 col-form-label">Mã</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" id="code" name="code" value="{{ $code??'' }}" required>
                                        </div>
                                    </div>
                                    <div class="form-row mb-2">
                                        <label class="col-lg-4 col-form-label">Phí</label>
                                        <div class="col-lg-8">
                                            <input type="number" class="form-control" id="price_" name="price" value="{{ $price??0 }}" required>
                                        </div>
                                    </div>

                                    <div class="form-row mb-2">
                                        <label class="col-lg-4 col-form-label">Sắp xếp (tăng dần)</label>
                                        <div class="col-lg-8">
                                            <input type="number" class="form-control" id="sort" name="sort" value="{{ $sort??0 }}" required>
                                        </div>
                                    </div>

                                    <div class="form-row mb-3">
                                        <label class="col-lg-4 col-form-label" >Note</label>
                                        <div class="col-lg-8">
                                            <textarea name="content" class="form-control" rows="2">{!! $content??'' !!}</textarea>
                                            @error('content')
                                                <div class="text-danger" style="font-size: 12px;">
                                                    {{ $errors->first('content') }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-row mb-3">
                                        <label class="col-lg-4 col-form-label">Trạng thái</label>
                                        <div>
                                            <div class="icheck-primary pt-1">
                                                <input type="checkbox" id="status" name="status" value="1" {{ isset($status) && $status == 1 ? 'checked' : '' }}>
                                                <label for="status">Hiển thị</label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group text-right m-b-0">
                                        <a class="btn btn-secondary btn-sm" href="{{ route('admin.shipping') }}">Danh sách</a>
                                        @if(!empty($id))
                                        <button class="btn btn-primary btn-sm" type="submit">Cập nhật</button>
                                        @else
                                        <button class="btn btn-primary btn-sm" type="submit">Thêm</button>
                                        @endif
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8" style="width: 80%">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Danh sách</h3>
                            </div> <!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-striped m-0">
                                    <thead>
                                    <tr>
                                        <th class="text-center">STT</th>
                                        <th>Tên</th>
                                        <th>Mã</th>
                                        <th>Phí</th>
                                        <th class="text-center" width="100">Thao tác</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($posts as $post)
                                        <tr class="{{ !empty($id) && $id == $post->id ? 'active' : '' }}">
                                            <td class="text-center">{!! $post->sort !!}</td>
                                            <td>{!! $post->name !!}</td>
                                            <td>{!! $post->code !!}</td>
                                            <td>{!! $post->price !!}</td>
                                            <td class="text-center">
                                                <div>
                                                    @if($post->status)
                                                    <span class="badge badge-primary">Hiển thị</span>
                                                    @else
                                                    <span class="badge badge-secondary">Ẩn</span>
                                                    @endif
                                                </div>
                                                <a href="{{ route('admin.shipping_edit', $post->id) }}"><i class="fas fa-pen"></i></a>
                                                <a class="text-danger ml-2" href="{{ route('admin.shipping_delete', $post->id) }}"><i class="fas fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="fr mb-3 text-center">
                                {!! $posts->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>
</section>
@endsection

@push('script')
    <script type="text/javascript">
        $('#creation_date_from').datetimepicker({
            format:"DD/MM/YYYY",
            startDate: new Date()
        });
    </script>
@endpush