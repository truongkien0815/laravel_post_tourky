@php
    $category = \App\Model\Category::find(1);
    if($category)
       $posts = $category->post()->where('status', 1)->orderBy('sort', 'asc')->limit(3)->get();

@endphp
@if(!empty($posts))
<div class="news-block py-5">
  <div class="container">
      <div class="title-box">
          <div class="section-heading">
              <h5>TIN TỨC SỰ KIỆN</h5>
          </div>
          <a href="{{ route('news') }}">Xem thêm</a>
      </div>
      <div class="news-slider owl-carousel">
          @foreach($posts as $post)
              @include($templatePath . '.news.includes.post-item', compact('post'))
          @endforeach
      </div>
  </div>
</div>
@endif