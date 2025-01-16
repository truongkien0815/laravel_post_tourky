@isset($variables)
   @foreach($variables as $key => $item)
      @php
         $variable = \App\Model\ShopVariable::find($key);
      @endphp
      @if($variable && !empty($item) && $item->count())
         <div class="filter-product">
            <label>{{ $variable->name }}:</label>
            <select class="form-select" name="variable[{{ $variable->id }}]" aria-label="{{ $variable->name }}">
               @foreach($item as $value)
                  @if($value->value!='')
                  <option value="{{ $value->id }}">{{ $value->value }}</option>
                  @endif
               @endforeach
            </select>
         </div>
      @endif
   @endforeach
@endisset