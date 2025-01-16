@php
     $segment_check = Request::segment(1);
@endphp
<ul>
    @foreach($menu_main as $menu)
    <li>
        <a href="{{ url($menu['link']??'#') }}" class="{{ $menu['class'] }} {{ $segment_check == $menu['link']  || empty($segment_check) && in_array($menu['link'], ['trang-chu', '/']) ? 'active' : '' }}">
            @if(in_array($menu['link'], ['trang-chu', '/']))
                <img src="{{ asset($menu['icon']) }}" />
            @else
                {{ $menu['label'] }}
            @endif
        </a>
    </li>
    @endforeach
</ul> 