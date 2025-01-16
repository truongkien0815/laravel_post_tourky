@extends($templatePath .'.layouts.index')

@section('seo')
@include($templatePath .'.layouts.seo', $seo??[] )
@endsection

@section('seo')
<title>{{ !empty($news->seo_title) ? $news->seo_title : $news->title  }}</title>
<link rel="canonical" href="{{ url('/') }}" />
<meta name="robots" content="index, follow">
<meta name="description" content="{{ !empty($news->seo_description) ? $news->seo_description : strip_tags(htmlspecialchars_decode($news->description)) }}">
<meta property="og:title" content="{{ !empty($news->seo_title) ? $news->seo_title : $news->title  }}" />
<meta property="og:description" content="{{ !empty($news->seo_description) ? $news->seo_description : strip_tags(htmlspecialchars_decode($news->description)) }}" />
<meta property="og:image" content="{{ asset( $news->image) }}" />
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:site_name" content="{{ Helpers::get_option_minhnn('og-site-name') }}" />
@endsection

@section('content')
{{-- @if($category->image)
<div class="page-heading text-center">
  <img src="{{ asset($category->cover) }}" class="w-100">
</div>
@endif --}}

<!--=================================
blog-detail -->
<section class="space-ptb py-5">
  <div class="container">
    <div class="row">
        <div class="col-lg-9">
          <div class="blog-detail">
            <div class="blog-post">
              <div class="blog-post-title mb-3">
                <h2>{{ $news->name }}</h2>
              </div>

              <div class="blog-post-content border-0">
                {!! htmlspecialchars_decode($news->content) !!}
              </div>
              <hr>
              <div class="mt-3">
                <span class="d-inline-block align-middle text-muted fs-sm me-3 mt-1 mb-2">Share post:</span>
                <a class="btn-social bs-facebook me-2 mb-2" href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}&amp;t={{$news->title}}"><i class="fab fa-facebook"></i></a>
                <a class="btn-social bs-twitter me-2 mb-2" href="http://twitter.com/share?text=text goes here&url={{ url()->current() }}"><i class="fab fa-twitter"></i></a>
                <a class="btn-social bs-pinterest me-2 mb-2" href="http://www.instagram.com/?url={{ url()->current() }}"><i class="fab fa-pinterest"></i></a>
              </div>
            </div>
          </div>

          <div class="blog-featured">
            <h6 class="text-primary mb-3">@lang('Hoạt động liên quan')</h6>
            <ul class="pl-3">
              @if(count($news_featured)>0)
                @foreach($news_featured as $item)
                <li>
                  <a href="{{ route('news.single', ['id' => $item->id, 'slug' => $item->slug], true, $lc) }}">{{ $item->name }}</a>
                </li>
                @endforeach
              @endif
            </ul>
          </div>  
        </div>
        <div class="col-lg-3 mt-5 mt-lg-0">
          <div class="blog-sidebar">
            <div class="widget">
              <div class="widget-title mb-3">
                <h6>Hoạt động</h6>
              </div>
                @if(count($news_featured)>0)
                    @foreach($news_featured as $item)
                    <div class="row mb-3">
                        <div class="col-md-3">
                          <img class="img-fluid" src="{{ asset($item->image) }}" alt="">
                        </div>
                        <div class="col-md-9">
                          <a class="text-dark" href="{{ route('news.single', ['id' => $item->id, 'slug' => $item->slug], true, $lc) }}"><b>{{ $item->name }} </b></a>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
          </div>
        </div>
      </div>
    </div>
</section>
<!--=================================
blog-detail -->
 @push('after-footer')
  <script src="https://sp.zalo.me/plugins/sdk.js"></script>
    <script>
      jQuery(document).ready(function($) {
        $('.view-phone').click(function(event) {
          var phone = '{{ Helpers::get_option_minhnn('zalo') }}';
          $(this).find('span').text(phone);
          $(this).attr('href', 'tel:' + phone);
        });
      });

    </script>
  @endpush

@endsection