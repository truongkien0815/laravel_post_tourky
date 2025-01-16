@php
  $variables = \App\ShopVariable::where('status', 1)->orderByDesc('created_at')->limit(20)->get();
  $types = (new \App\Model\ShopType)->where('status', 1)->limit(20)->get();
@endphp
<form id="productFilterForm" class="productFilterForm mb-4" method="GET" action="{{ route('ajax.product_filter') }}">
  <input type="hidden" name="category" value="{{ $category->id??0 }}">
  <label>Bộ lọc:</label>
  @if($variables->count())
  @foreach($variables as $item)
  
  <select name="{{ $item->slug }}">
      <option value="">{{ $item->name }}</option>
      @foreach($item->listItem as $child)
      <option value="{{ $child->value }}" {{ request($item->slug) == $child->value ? 'selected': '' }}>{{ $child->value }}</option>
      @endforeach
  </select>
  @endforeach
  @endif

  @if($types->count())
  <select name="type">
      <option value="">Chất liệu</option>
      @foreach($types as $item)
      <option value="{{ $item->id }}" {{ request('type') == $item->id ? 'selected': '' }}>{{ $item->name }}</option>
      @endforeach
  </select>
  @endif
    {{--
  <select name="size">
      <option value="size">Kích cỡ</option>
      <option value="m">M</option>
      <option value="l">L</option>
  </select>
  --}}
  {{--
  <select name="feature">
      <option value="feature">Tính năng</option>
      <option value="1">One</option>
      <option value="2">Two</option>
  </select>
  --}}
  <select name="sort">
      <option value="">Mặc định</option>
      <option value="created_at__desc">Mới nhất</option>
      <option value="name__asc" {{ request('sort') == 'name__asc' ? 'selected' : '' }}>Từ A-Z</option>
      <option value="name__desc" {{ request('sort') == 'name__desc' ? 'selected' : '' }}>Từ Z-A</option>
      <option value="price__asc" {{ request('sort') == 'price__asc' ? 'selected' : '' }}>Rẻ nhất</option>
      <option value="price__desc" {{ request('sort') == 'price__desc' ? 'selected' : '' }}>Giá giảm dần</option>
  </select>
  <button type="button" class="filter-reset">Xoá bộ lọc</button>
</form>