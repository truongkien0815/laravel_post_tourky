@extends('admin.layouts.app')
@section('seo')
@include('admin.partials.seo')
@endsection
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="row">
      <div class="col-sm-6">
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
          <li class="breadcrumb-item active">Product</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<section class="content">
	<div class="card">
      	<div class="card-header">
        	<h3 class="card-title">Product</h3>
      	</div> <!-- /.card-header -->
      	<div class="card-body">
            <div class="clear">
                <ul class="nav fl">
                    <li class="nav-item">
                        <a class="btn btn-danger" onclick="delete_id('product')" href="javascript:void(0)"><i class="fas fa-trash"></i> Delete</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary" href="{{route('admin.createProduct')}}" style="margin-left: 6px;"><i class="fas fa-plus"></i> Add New</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary" href="{{ route('admin.product.export', ['category_id' => request('category_id'), 'search_title' => request('search_title'), 'page' => request('page')]) }}" style="margin-left: 6px;"><i class="fas fa-download"></i> Export</a>
                    </li>
                </ul>
                <div class="fr">
                    <form method="GET" action="" id="frm-filter-post" class="form-inline">
                        <?php 
                            $list_cate = App\Model\ShopCategory::where('parent', 0)->orderBy('id', 'ASC')
                                    ->select('id', 'name')->get();
                            $type_cate = App\Model\ShopType::where('parent', 0)->orderBy('id', 'ASC')
                                ->select('id', 'name')->get();
                        ?>
                        <select class="custom-select mr-2" name="category_id">
                            <option value="">Danh mục</option>
                            @foreach($list_cate as $cate)
                                <option value="{{$cate->id}}" {{ request('category_id') == $cate->id ? 'selected': '' }}>{{$cate->name}}</option>
                                @if(count($cate->children)>0)
                                    @foreach($cate->children as $cate_child)
                                        <option value="{{$cate_child->id}}" {{ request('category_id') == $cate_child->id ? 'selected': '' }}>   &ensp;&ensp;{{$cate_child->name}}</option>
                                    @endforeach
                                @endif
                            @endforeach
                        </select>
{{--                        <select class="custom-select mr-2" name="type_id">--}}
{{--                            <option value="">Loại sản phẩm</option>--}}
{{--                            @foreach($type_cate as $cate)--}}
{{--                                <option value="{{$cate->id}}" {{ request('type_id') == $cate->id ? 'selected': '' }}>{{$cate->name}}</option>--}}
{{--                            @endforeach--}}
{{--                        </select>--}}
                        <input type="text" class="form-control" name="search_title" id="search_title" placeholder="Nhập tên hoặc mã SP" value="{{ request('search_title') }}">
                        <button type="submit" class="btn btn-primary ml-2">Search</button>
                    </form>
                </div>
            </div>
            <br/>
            <div class="clear">
                <div class="fl" style="font-size: 16px;">
                    <b>Tổng</b>: <span class="bold" style="color: red; font-weight: bold;">{{$total_item}}</span> sản phẩm
                </div>
                <div class="fr">
                    {!! $products->withQueryString()->links() !!}
                </div>
            </div>
            <br/>
            <div class="table-responsive">
                <table class="table table-striped projects" id="table_index">
                    <thead>
                        <tr>
                            <th width="70" class="text-center"><input type="checkbox" id="selectall" onclick="select_all()"></th>
                            <th width="70" class="text-center">STT</th>
                            <th>Tên sản phẩm</th>
                            <th>Kho</th>
                            <th>Danh mục</th>
                            <th class="text-center">Hình ảnh</th>
                            <th class="text-center">Ngày và trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $data)
                        <tr class="{{ $data->hot ? 'hot' : '' }}">
                            <td class="text-center"><input type="checkbox" id="{{$data->id}}" name="seq_list[]" value="{{$data->id}}"></td>
                            <td class="text-center">
                                {{ $data->sort }}
                            </td>
                            <td>
                                <a class="row-title" href="{{route('admin.productDetail', array($data->id))}}">
                                    <b>{{$data->name}}</b>
                                    @if($data->hot)
                                    <span class="badge badge-danger">Hot</span>
                                    @endif
                                </a>
                                <div>Mã: {{ $data->sku }}</div>
                            </td>
                            <td>
                                <div class="form-inline">
                                    <span class="d-inline mr-2">Số lượng:</span>
                                    <input type="number" name="stock" data-id="{{ $data->id }}" min="1" class="form-control form-control-sm" value="{{ $data->stock??0 }}" style="width: 70px;">
                                </div>

                            </td>
                            <td>
                                @php
                                    $categories = $data->categories;
                                    //dd($category);
                                @endphp
                                @foreach($categories as $k=>$category)
                                    <div>
                                        <a class="tag" target="_blank" href="#">{{ $category->name }}</a>
                                    </div>
                                @endforeach
                            </td>
                            <td class="text-center">
                                @if($data->image != '')
                                    <img src="{{asset($data->image)}}" style="height: 50px;">
                                @endif
                            </td>
                            <td class="text-center">
                                <input type="checkbox" name="my-checkbox" data-id="{{ $data->id }}" {{ $data->status?'checked':'' }} data-bootstrap-switch value="1">
                                <div>
                                    {{ date('d/m/Y H:i', strtotime($data->created_at)) }}
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="fr">
                {!! $products->withQueryString()->links() !!}
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