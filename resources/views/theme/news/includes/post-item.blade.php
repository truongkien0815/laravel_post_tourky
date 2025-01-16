@php
   $url = route('news.single', ['id' => $post->id, 'slug' => $post->slug]);
   $date = \Carbon\Carbon::parse($post->created_at);
@endphp

<div class="item">
   <div class="thumb">
      <a href="{{ $url }}">
         <img src="{{ asset($post->image) }}" onerror="this.src='{{ asset('assets/images/placeholder.png') }}';" alt="">
      </a>
   </div>
   <div class="content-wrapper">
      <p><i class="fa-regular fa-clock"></i> Ngày {{ $date->day }}/{{ $date->month }}/{{ $date->year }}</p>
      <h4><a href="{{ $url }}">{{ $post->name }}</a></h4>
   </div>
</div>