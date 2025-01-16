@extends('admin.layouts.app')
@section('seo')
@include('admin.partials.seo')
@endsection
@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="row">
      <div class="col-sm-6">
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
          <li class="breadcrumb-item active">List Contact</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<style>
    table.dataTable tbody td {
    padding: 14px;
}
</style>
<section class="content">
	<div class="card">
      	<div class="card-header">
        	<h3 class="card-title">List Contact</h3>
      	</div> <!-- /.card-header -->
      	<div class="card-body">
            <div class="clear">
                <ul class="nav fl">
                    {{-- <li class="nav-item">
                        <a class="btn btn-danger" onclick="delete_id('product')" href="javascript:void(0)"><i class="fas fa-trash"></i> Delete</a>
                    </li> --}}
                    <li class="nav-item">
                        <a class="btn btn-primary" href="{{url('admin/contact/create')}}" style="margin-left: 6px;"><i class="fas fa-plus"></i> Add New</a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="btn btn-primary" href="{{ route('admin.product.export', ['category_id' => request('category_id'), 'search_title' => request('search_title'), 'page' => request('page')]) }}" style="margin-left: 6px;"><i class="fas fa-download"></i> Export</a>
                    </li> --}}
                </ul>
                <div class="fr">
                 
                </div>
            </div>
            <br/>
           
            <br/>
            <div class="table-responsive">
              <table class="table table-striped projects" id="example">
                  <thead>
                      <tr>
                        <th style="width: 1%">
                          Id
                      </th>
                      <th style="width: 10%">
                          Tên liên hệ
                      </th>
                      {{-- <th style="width: 10%">
                          Nội dung
                      </th> --}}
                      <th style="width: 10%">
                          Sdt
                      </th>
                      <th style="width: 10%">
                          Email
                      </th>

                      <th style="width: 20%">
                          Thao tác
                      </th>
                      </tr>
                  </thead>
                  <tbody>
                    @foreach($contact as $item)

                    <tr>
                        <td>
                            {{$item->id}}

                        </td>


                        <td>
                            {{$item->fullname}}
                            <br />
                            <small>
                                Created {{$item->created_at}}
                            </small>
                        </td>
                        {{-- <td>
                            {{$item->content}}

                        </td> --}}
                        <td>
                            {{$item->mobile}}


                        </td>
                        <td>
                            {{$item->address}}
                            {{-- @foreach($question as $itam)
                            {{$itam->question_list}}
                            @endforeach --}}

                        </td>

                        <td class="project-actions text-center">
                          
                            <a class="btn btn-info btn-sm" href="{{url('admin/contact/'.$item->id.'/edit')}}">
                                <i class="fas fa-pencil-alt">
                                </i>
                                <a href="{{url('admin/contact/'.$item->id.'/edit')}}"></a>

                            </a>
                            <a class="btn btn-danger btn-sm" href="#">
                                <form action="{{ url('admin/contact/'.$item->id)}}" method="post">
                                    @method('DELETE')
                                    @csrf
                                    <input class="fas fa-trash bg-danger" style="border:none" type="submit"
                                        value="Delete">
                                </form>

                            </a>
                        </td>
                    </tr>

                    @endforeach



















                  </tbody>
              </table>
             
          </div>
           
    	</div> <!-- /.card-body -->
		</div><!-- /.card -->
</section>
@endsection

@push('scripts')
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $('input[name="stock"]').on('change', function(){
                var id = $(this).data('id'),
                    stock = $(this).val();
                axios({
                    method: 'post',
                    url: '{{ route("admin_product.updateStock") }}',
                    data: {id:id, stock:stock}
                }).then(res => {
                  alertMsg('success', res.data.message);
                }).catch(e => console.log(e));
            });
            $('input[name="my-checkbox"]').on('switchChange.bootstrapSwitch', function(e){
                var id = $(this).data('id'),
                    status = e.target.checked;
                axios({
                    method: 'post',
                    url: '{{ route("admin_product.updateStatus") }}',
                    data: {id:id, status:status}
                }).then(res => {
                  alertMsg('success', res.data.message);
                }).catch(e => console.log(e));
            });
        });
    </script>
@endpush

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('js/js.js')}}"></script>