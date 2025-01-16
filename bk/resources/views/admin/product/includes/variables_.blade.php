@php
   $variables = \App\Model\ShopVariable::get();
@endphp
<div class="list-variation">
   @if($variables->count())
      @foreach($variables as $item)
         @php
            $product_variables = \App\Model\ShopProductVariable::where('product_id', $id)->where('variable_id', $item->id)->get();
         @endphp
      <div class="variable-box">
         <h4>{{ $item->name }}</h4>
         <div class="variable-list">
            @if($product_variables->count())
               @foreach($product_variables as $key => $value)
               <div class="form-group {{ $key == 0 ? 'clone' : '' }}">
                  <input type="text" name="variable[{{ $item->id }}][]" placeholder="Nhập dữ liệu {{ $item->name }}" class="form-control" value="{{ $value->value }}">
               </div>
               @endforeach
            @else
            <div class="form-group clone">
               <input type="text" name="variable[{{ $item->id }}][]" placeholder="Nhập dữ liệu {{ $item->name }}" class="form-control">
            </div>
            @endif
         </div>
         <div class="text-right">
            <button type="button" class="btn btn-primary v-item-add">+ Thêm</button>
         </div>
      </div>
      @endforeach
   @endif
</div>

@push('styles')
<!-- add styles here -->

@endpush

@push('scripts-footer')
<!-- add script here -->
<script>
   jQuery(document).ready(function($) {
      $(document).on('click', '.v-item-add', function(){
         var html = $(this).closest('.variable-box').find('.variable-list').find('.form-group.clone').clone();
         html = html.removeClass('clone').find('input').val('');
         $(this).closest('.variable-box').find('.variable-list').append(html);
      });
   });
</script>
@endpush