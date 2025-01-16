@extends('admin.layouts.app')
@section('seo')
    @include('admin.partials.seo')
@endsection
@section('content')

@php
    if(!empty($post))
        extract($post->toArray());
    $id = $id??0;
@endphp

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2 justify-content-end">
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
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
        <form action="{{ $url_action }}" method="POST" id="frm-create-post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{$discount->id ?? 0}}">
    	    <div class="row">
                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-header"><h4>Edit</h4></div> <!-- /.card-header -->
                        <div class="card-body">
                            <!-- show error form -->
                            <div class="errorTxt"></div>

                            <div class="fields-group">

                            <div class="form-group  row {{ $errors->has('code') ? ' invalid' : '' }}">
                                <label for="code" class="col-sm-2  control-label">{{ sc_language_render('Plugins/Total/Discount::lang.code') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-clipboard-list"></i></span>
                                        </div>
                                        <input type="text" id="code" name="code" value="{{ old('code', ($discount['code']??'')) }}" class="form-control" placeholder="" />
                                    </div>
                                        @if ($errors->has('code'))
                                            <span class="help-block">
                                                <i class="fa fa-info-circle"></i>  {{ $errors->first('code') }}
                                            </span>
                                        @else
                                            
                                                <i class="fa fa-info-circle"></i>  {{ sc_language_render('Plugins/Total/Discount::lang.admin.code_helper') }}
                                      
                                        @endif
                                </div>
                            </div>

                            <div class="form-group  row {{ $errors->has('reward') ? ' invalid' : '' }}">
                                <label for="reward" class="col-sm-2  control-label">{{ sc_language_render('Plugins/Total/Discount::lang.reward') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-file-alt"></i></span>
                                        </div>
                                        <input type="text" id="reward" name="reward" value="{{ old('reward', ($discount['reward']??'')) }}" class="form-control" placeholder="" />
                                    </div>
                                        @if ($errors->has('reward'))
                                            <span class="help-block">
                                                {{ $errors->first('reward') }}
                                            </span>
                                        @endif
                                </div>
                            </div>


                            <div class="form-group align-items-center row {{ $errors->has('type') ? ' invalid' : '' }}">
                                <label for="type" class="col-sm-2  control-label">{{ sc_language_render('Plugins/Total/Discount::lang.type') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                    <label class="radio-inline"><input type="radio" name="type" value="point" {{ (old('type',$discount['type']??'') == 'point')?'checked':'' }}> Point</label>
                                        &nbsp; 
                                    <label class="radio-inline"><input type="radio" name="type" value="percent" {{ (old('type',$discount['type']??'') == 'percent')?'checked':'' }}> Percent (%)</label>
                                    </div>
                                        @if ($errors->has('type'))
                                            <span class="help-block">
                                                {{ $errors->first('type') }}
                                            </span>
                                        @endif
                                </div>
                            </div>


                            <div class="form-group  row {{ $errors->has('data') ? ' invalid' : '' }}">
                                <label for="data" class="col-sm-2  control-label">{{ sc_language_render('Plugins/Total/Discount::lang.data') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                        <input type="text" id="data" name="data" value="{{ old('data', ($discount['data']??'')) }}" class="form-control" placeholder="" />
                                    </div>
                                        @if ($errors->has('data'))
                                            <span class="help-block">
                                                {{ $errors->first('data') }}
                                            </span>
                                        @endif
                                </div>
                            </div>


                            <div class="form-group  row {{ $errors->has('limit') ? ' invalid' : '' }}">
                                <label for="limit" class="col-sm-2  control-label">{{ sc_language_render('Plugins/Total/Discount::lang.limit') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                        <input type="number" id="limit" name="limit" value="{{ old('limit', ($discount['limit']??'1')) }}" class="form-control" placeholder="" />
                                    </div>
                                        @if ($errors->has('limit'))
                                            <span class="help-block">
                                                {{ $errors->first('limit') }}
                                            </span>
                                        @endif
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('expires_at') ? ' invalid' : '' }}">
                                <label for="expires_at" class="col-sm-2  control-label">{{ sc_language_render('Plugins/Total/Discount::lang.expires_at') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-calendar fa-fw"></i></span>
                                        </div>
                                        <input type="text" id="expires_at" name="expires_at" value="{{ old('expires_at', ($discount['expires_at']??'')) }}" class="form-control date_time"  placeholder="yyyy-mm-dd" autocomplete="off" />
                                    </div>
                                        @if ($errors->has('expires_at'))
                                            <span class="help-block">
                                                {{ $errors->first('expires_at') }}
                                            </span>
                                        @endif
                                </div>
                            </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    @include('admin.partials.action_button')
                </div>
    	  	</div> <!-- /.row -->
            
        </form>
  	</div> <!-- /.container-fluid -->
</section>
@endsection

@push('scripts')
    <script>
        $('.date_time').datetimepicker({
            format: 'Y-m-d',
            timepicker: false
        });
    </script>
@endpush