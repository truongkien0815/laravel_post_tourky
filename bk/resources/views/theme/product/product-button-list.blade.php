@php
  $menus = Menu::getByName('Product-category');
  $class_active ='';
@endphp
<!-- ***** Archive Button Starts ***** -->
<div class="button-list">
  <div class="container">
      <div class="group-button-list">
          @foreach($menus as $item)
            <div class="item-button">
                <a href="{{ url($item['link']??'javascript:;') }}" class="{{ $item['class'] }}">{{ $item['label'] }}</a>
            </div>
          @endforeach
      </div>
  </div>
</div>
<!-- ***** Archive Button Ends ***** -->