@if(!empty($options) && count($options))
	@php
		$item_id_current = 0;
	@endphp
	<div class="cart__meta-text">
		@foreach($cart->options as $groupAttr => $variable)
		    @php
		        $attr_feature = explode('__', $groupAttr);
		        $item_id = $attr_feature[1]??0;
		        $feature_item = \App\Model\ShopProductItem::find($item_id);
		    @endphp
		    <div>{{ $attr_feature[0]??'' }}: <b>{{ $variable }}</b></div>
		    @if($item_id_current == $item_id)
		    <div>SKU: <b>{{ $feature_item->sku??'' }}</b></div>
		    @endif
		    @php
		    	if($item_id_current != $item_id)
		        	$item_id_current = $item_id;
		    @endphp
		@endforeach
	</div>
@endif