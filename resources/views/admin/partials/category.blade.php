@if(!empty($categories) && $categories->count())
<div class="card widget-category">
  	<div class="card-header">
      <h3 class="card-title">{{ $title??'Category' }}</h3>
  	</div> <!-- /.card-header -->
  	<div class="card-body">
      <div class="inside clear">
         <div class="clear">
            @php
            	$array_checked = [];
              	if($category_joins)
              	{
                  foreach($category_joins as $data_check)
                  {
                      array_push($array_checked, $data_check->category_id);
                  }
              	}
            @endphp
            
            @include('admin.partials.category-item', compact('categories'))

         </div>
         <div class="clearfix"></div>
      </div>
  	</div> <!-- /.card-body -->
</div><!-- /.card -->
@endif