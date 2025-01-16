@php
   $variables = \App\Model\ShopVariable::orderBy('sort', 'asc')->get();
   $variables_feature = \App\Model\ShopProductItem::where('product_id', $product_id)->orderBy('id', 'asc')->get();
   //dd($variables_feature);
@endphp

<div class="variable-list">
   @if($variables_feature->count())
      @foreach($variables_feature as $index => $data)
         @include('admin.product.includes.variable-item', ['index' => $index, 'data' => $data])
      @endforeach
   @else
      @include('admin.product.includes.variable-item')
   @endif
</div>

<div class="text-right">
   <button type="button" class="btn btn-primary v-item-add">+ Add item</button>
</div>

@push('scripts')
<!-- add script here -->
<script>
   jQuery(document).ready(function($) {
      $(document).on('change', '.key-selector', function(){
         var input_type = $(this).val();
         $(this).parent().find('input').attr('type', input_type);
      });

      $(document).on('click', '.add-feature', function(){
         var html = $(this).closest('.variable-item').find('.feature-clone').clone();
         html.removeClass('feature-clone');
         $(this).closest('.variable-item').find('.feature-clone').parent().append(html);
      });
      $(document).on('click', '.remove-item', function(){
         $(this).closest('.variable-item').remove();
      });

      $(document).on('click', '.v-item-add', function(){
         var html = $('.item-clone').clone(),
            item = $('.variable-item').length;

         html.removeClass('item-clone');
         html.find('.value-input').attr('name', 'feature['+item+'][]');
         html.find('.key-selector').attr('name', 'feature_select['+item+'][]');
         html.find('.gallery_body').attr('data', item);
         html.find('.gallery_box').html('');
         $('.variable-list').append(html);

         /*var html = $(this).closest('.variable-box').find('.variable-list').find('.form-group.clone').clone();
         html = html.removeClass('clone').find('input').val('');
         $(this).closest('.variable-box').find('.variable-list').append(html);*/
      });
   });
</script>
@endpush