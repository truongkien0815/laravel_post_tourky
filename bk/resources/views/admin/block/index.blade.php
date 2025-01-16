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
        <h1 class="m-0 text-dark">List Page</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
          <li class="breadcrumb-item active">List Page</li>
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
		            	<h3 class="card-title">List Page</h3>
		          	</div> <!-- /.card-header -->
		          	<div class="card-body">
                        <div class="clear">
                            <ul class="nav fl">
                                <li class="nav-item">
                                    <a class="btn btn-danger" onclick="delete_id('block')" href="javascript:void(0)"><i class="fas fa-trash"></i> Delete</a>
                                </li>
                                <li class="nav-item">
                                    <a class="btn btn-primary" href="{{ $create_page }}" style="margin-left: 6px;"><i class="fas fa-plus"></i> Add New</a>
                                </li>
                            </ul>
                            <div class="fr">
                                <form method="GET" action="" id="frm-filter-post" class="form-inline">
                                    <input type="text" class="form-control" name="search_title" id="search_title" placeholder="Từ khoá" value="{{ request('search_title') }}">
                                    <button type="submit" class="btn btn-primary ml-2">Tìm kiếm</button>
                                </form>
                            </div>
                        </div>
                        <br/>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="table_index">
                                <thead>
                                    <tr>
                                        <th scope="col"><input type="checkbox" id="selectall" onclick="select_all()"></th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Trang</th>
                                        <th scope="col">Vị trí</th>
                                        <th scope="col">Thứ tự</th>
                                        <th scope="col">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($page as $data)
                                    <tr>
                                        <td class="text-center"><input type="checkbox" id="{{$data->id}}" name="seq_list[]" value="{{$data->id}}"></td>
                                        <td class="">
                                            <a class="row-title" href="{{route('admin_block.edit', $data->id)}}">
                                                <b>{{ $data->name }}</b>                       
                                            </a>
                                        </td>
                                        <td>
                                            
                                            @if (strpos($data->page, '*') !== false) 
                                                Tất cả các trang
                                            @else 
                                                @php $arrPage = explode(',', $data->page); @endphp
                                                @foreach ($arrPage as $key => $value) 
                                                    <div>{{ __($value ?? '') }}</div>
                                                @endforeach
                                            
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            {{ __($data->position) }}
                                        </td>
                                        <td class="text-center">
                                            {{ $data->sort }}
                                        </td>
                                        <td class="text-center">
                                            @if($data->status == 0)
                                            <span class="badge badge-danger">Draf</span>
                                            @else
                                            <span class="badge badge-success">Public</span>
                                            @endif

                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="fr">
                            {!! $page->links() !!}
                        </div>

		        	</div> <!-- /.card-body -->
	      		</div><!-- /.card -->
	    	</div> <!-- /.col -->
	  	</div> <!-- /.row -->
  	</div> <!-- /.container-fluid -->
</section>
@endsection