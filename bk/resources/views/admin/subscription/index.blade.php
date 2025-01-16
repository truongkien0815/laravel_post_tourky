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
        
      </div><!-- /.col -->
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
	    <div class="row">
	      	<div class="col-12">
	        	<div class="card">
		          	<div class="card-header">
		            	<h5>{{ $title }}</h5>
		          	</div> <!-- /.card-header -->
		          	<div class="card-body">
                        <div class="clear">
                            <div class="fr">
                                <form method="GET" action="" id="frm-filter-post" class="form-inline">
                                    <input type="text" class="form-control" name="search_title" id="search_title" placeholder="Từ khoá" value="{{ request('search_title') }}">
                                    <button type="submit" class="btn btn-primary ml-2">Tìm kiếm</button>
                                </form>
                            </div>
                        </div>  
                        <br/>
                        <div class="clear">
                            <div class="fr">
                                {!! $data_rows->links() !!}
                            </div>
                        </div>
                        <br/>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="table_index">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center"><input type="checkbox" id="selectall" onclick="select_all()"></th>
                                        <th scope="col" class="text-center">Email</th>
                                        <th scope="col" class="text-center">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($data_rows->count())
                                        @foreach($data_rows as $data)
                                            <tr class="tr-item item-level-{{ isset($level) ? $level : 0 }}">
                                                <td class="text-center"><input type="checkbox" id="{{$data->id}}" name="seq_list[]" value="{{$data->id}}"></td>
                                                <td class="title">
                                                        <b style='color: #dd0000;'>{{ $data->email }}</b>
                                                </td>
                                                <td class="text-center">
                                                    {{ $data->updated_at }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="fr">
                            {!! $data_rows->links() !!}
                        </div>
                    </div> <!-- /.card-body -->
	      		</div><!-- /.card -->
	    	</div> <!-- /.col -->
	  	</div> <!-- /.row -->
  	</div> <!-- /.container-fluid -->
</section>
@endsection