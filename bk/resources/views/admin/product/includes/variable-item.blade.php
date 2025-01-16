@php
   $index = $index??0;
   $gallery_attr = '';
   if(!empty($data)){
      $items = \App\Model\ShopProductItemFeature::where('product_item_id', $data->id)->get();
      if(!empty($data->gallery))
            $gallery_attr = json_decode($data->gallery, true);
   }
@endphp
<div class="row variable-item {{ $index==0?'item-clone':'' }} border-bottom pb-3 mb-3">
      <div class="col-lg-10">
         <div class="row">
            @if(!empty($items) && $items->count())
                @foreach($items as $key => $item)
                <div class="col-lg-3 mb-2 {{ $key==0?'feature-clone':'' }}">
                   <select class="custom-select key-selector bg-info" name="feature_select[{{ $index }}][]">
                      <option value="">--Remove--</option>
                      @foreach($variables as $variable_item)
                          @php
                            $selected = '';
                            if($item->variable_id == $variable_item->id)
                                $selected = 'selected';

                          @endphp
                          <option value="{{ $variable_item->name }}" data-type="{{ $variable_item->input_type }}" {{ $selected }}>{{ $variable_item->name }}</option>
                      @endforeach
                   </select>
                   <div class="input-group mb-3 mt-2">
                     @if($item->color)
                        <div class="input-group-prepend">
                           <span class="input-group-text" id="basic-addon1" style="width: 40px; background-color: {{ $item->color  }};"></span>
                        </div>
                        <input type="text" value="{{ $item->value }}__{{ $item->color }}" name="feature[{{ $index }}][]" class="value-input form-control" >
                     @else
                        <input type="text" value="{{ $item->value }}" name="feature[{{ $index }}][]" class="value-input form-control" >
                     @endif
                  </div>
                </div>
                @endforeach
            @else
            <div class="col-lg-3 mb-2 feature-clone">
               <select class="custom-select key-selector bg-info" name="feature_select[{{ $index }}][]">
                  <option value="">--Remove--</option>
                  @foreach($variables as $item)
                  <option value="{{ $item->name }}" data-type="{{ $item->input_type }}">{{ $item->name }}</option>
                  @endforeach
               </select>
               <input type="text" value="" name="feature[{{ $index }}][]" class="value-input form-control mt-2">
            </div>
            @endif
         </div>
      </div>
      <div class="col-lg-2 text-right">
         <button type="button" class="add-feature btn w-sm btn-primary waves-effect waves-light mb-2">+ Add</button>
         <button type="button" class="remove-item btn w-sm btn-danger waves-effect waves-light mb-2">- Remove item</button>
      </div>
      <div class="col-12">
         <div class="row">
            <div class="col-md-4">
               <div class="form-group">
                  <label>Giá</label>
                  <div class="input-group">
                     <div class="input-group-prepend"><span class="input-group-text">VNĐ</span></div>
                     <input type="number" min="0" step="1" class="form-control" name="feature_price[]" placeholder="Item Price" value="{{ $data->price??0 }}">
                  </div>
               </div>
            </div>
            <div class="col-md-4">
               <div class="form-group">
                  <label>Giá khuyến mãi</label>
                  <div class="input-group">
                     <div class="input-group-prepend"><span class="input-group-text">VNĐ</span></div>
                     <input type="number" min="0" step="1" class="form-control" name="feature_promotion[]" value="{{ $data->promotion??0 }}">
                  </div>
               </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>SKU</label>
                    <input type="text" class="form-control" name="feature_sku[]" placeholder="SKU" value="{{ $data->sku??'' }}">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Số lượng</label>
                    <input type="number" min="0" step="1" class="form-control" name="feature_quantity[]" placeholder="Quantity" value="{{ $data->quantity??0 }}">
                </div>
            </div>
         </div>
      </div>

      <div class="col-12">
         @include('admin.partials.galleries_box')
      </div>

   </div>