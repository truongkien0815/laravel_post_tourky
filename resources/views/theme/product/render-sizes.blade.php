
@if(!empty($attr_items) && $attr_items->count())
<div class="hover-content">
    <p>*Thêm nhanh vào giỏ hàng</p>
    <div class="option-select" data-option-id="size">
        @foreach($attr_items as $item)
        <label class="option-select__item">
            <input type="checkbox" name="size" value="{{ $item->value }}" tabindex="0">
            <span class="checkmark product-item-size" data-id="{{ $item->product_item_id??0 }}">{{ $item->value }}</span>
        </label>
        @endforeach
    </div>
</div>
@endif