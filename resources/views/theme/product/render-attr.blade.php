@php
    $attrs_selected = $attrs_selected??[];
    $attr_items_id = $attr_items->pluck('id');

    //
    $item_features_selecteds = \App\Model\ShopProductItemFeature::whereIn('product_item_id', $attr_items_id)->whereIn('value', $attrs_selected)->get();
    $item_features = \App\Model\ShopProductItemFeature::whereIn('product_item_id', $attr_items_id)->get();


    $group_attrs = \App\Model\ShopProductItemFeature::whereIn('product_item_id', $attr_items_id)->orderByDesc('created_at')->groupBy('variable_id')->get();
    $item_features_group = \App\Model\ShopProductItemFeature::whereIn('product_item_id', $attr_items_id)->groupBy('value')->get();


@endphp
@if($group_attrs->count())
    <div class="product-attr" data="{{ $group_attrs->count() }}">
        <input type="hidden" name="product_item_id" value="{{ $product_item_id??0 }}">

        @foreach($group_attrs as $index_g => $group)

        <div class="product-single__option">
            <div class="option-heading">
                <div class="option-heading__title">
                    {{ $group->feature }}:
                </div>
            </div>
            <div class="option-select">
                @foreach($attr_items as $index => $item_feature)
                    @php
                        $item = $item_features_group->where('variable_id', $group->variable_id)->where('product_item_id', $item_feature->id)->first();
                        $selected = '';
                    @endphp
                    @if($item)
                        @php
                            $disabled = '';
                            if(count($attrs_selected))
                            {
                               $check_feature = [];
                               $item_features_selecteds_another = $item_features_selecteds->where('variable_id', '<>', $group->variable_id);

                               if($item_features_selecteds_another)
                               {
                                  foreach($item_features_selecteds_another as $item_selected)
                                  {
                                     $check_feature = $item_features->where('value', '<>', $item_selected->value)
                                                                      ->where('value', $item->value)
                                                                      ->where('product_item_id', $item_selected->product_item_id)->first();
                                     $disabled = 'disabled';
                                     if($check_feature)
                                     {
                                        $disabled = '';
                                        break;
                                     }
                                  }
                               }
                            }
                            if(in_array( $item->value, $attrs_selected ))
                            {
                               $selected = 'checked';
                               $disabled = '';
                            }
                        @endphp
                        @if ( $group->feature == 'Màu sắc')
                            <label class="option-select__item option-select__item--color den">
                                <div class="option-select__inner form-attr">
                                    <input type="checkbox" name="feature[{{ $group->variable_id }}]" id="item_{{ $item->id }}" value="{{ $item->value }}" {{ $selected }} {{ $disabled }}>
                                    @if($item->color != '')
                                    <span class="checkmark checkmark-color {{ $disabled }}" style="--data-color: {{ $item->color  }}" title="{{ $item->value }}">{{ $item->value }}</span>
                                    @else
                                    <span class="checkmark {{ $disabled }}">{{ $item->value }}</span>
                                    @endif
                                </div>
                            </label>
                        @else
                            <label class="option-select__item option-size">
                                <div class="option-select__inner form-attr">
                                    <input type="checkbox" name="feature[{{ $group->variable_id }}]" id="item_{{ $item->id }}" value="{{ $item->value }}" {{ $selected }} {{ $disabled }}>
                                    <span class="checkmark">{{ $item->value }}</span>
                                </div>
{{--                                <div class="option-size-tooltip">--}}
{{--                                    <div class="option-size-tooltip__arrow"></div>--}}
{{--                                    <div data-size-height="1m50 - 1m59" data-size-weight="48kg - 54kg" data-size-type="" class="option-size-tooltip__inner">--}}
{{--                                        <span> 1m50 - 1m59</span> <br> <span> 48kg - 54kg</span>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                            </label>
                        @endif
                    @endif
                @endforeach

            </div>
        </div>

        @endforeach

    </div>

@endif