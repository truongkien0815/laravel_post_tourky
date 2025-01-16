@if(!empty($attr_items) && $attr_items->count())
<div class="product-variantcolor">
    <div class="swatch_item">
        @foreach($attr_items as $index => $item)
        @php
            $item_parent = $item->getItem;
            if($item_parent)
                $img = $item_parent->getGallery()[0]??'';
        @endphp
        <div class="swatch-element {{ $index == 0 ? 'active' : '' }}" data-value="{{ $item->value }}" data-product="{{ $product_id??0 }}">
            <span style="background-color: {{ $item->color  }};" title="{{ $item->value }}" data-img="{{ $img??'' }}"></span>
        </div>
        @endforeach
    </div>
</div>
@endif