@php
     $segment_check = Request::segment(1);
@endphp




   <ul>
    @foreach($menu_main as $menu)
    <li>
        <a href="{{ url($menu['link']??'#') }}" class="{{ $menu['class'] }} {{ $segment_check == $menu['link']  || empty($segment_check) && in_array($menu['link'], ['trang-chu', '/']) ? 'active' : '' }}">
        
            @if(in_array($menu['link'], ['trang-chu', '/']))
            <img src="{{ asset('img/home.png')}}" alt="" />
            {{-- <img src="{{ asset($menu['icon']) }}" /> --}}
        @else
            {{ $menu['label'] }}
        @endif
        
        </a></li>
                       
                    </li>
                        @endforeach
                       
                        {{-- <li>
                          <a href="{{url('quy-trinh')}}">  {{ __('messages.welcome') }}</a>
                        </li> --}}
                       
                       
                    </ul>