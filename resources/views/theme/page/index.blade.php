@php extract($data); @endphp

@extends($templatePath.'.layouts.index')

@section('seo')

@endsection

@section('content')
@if(Request::is('trang-chu'))
@include( $templatePath .'.partials.home')
@else
    {{-- @if(!empty($page) && $page->cover)
    <div class="banner-head-img">
        <img src="{{ asset($page->cover) }}">
    </div>
    @elseif(!empty($category) && $category->first()->cover)
    <div class="banner-head-img">
        <img src="{{ asset($category->first()->cover) }}">
    </div>
    @endif --}}
  <div id='page-content'>
 {{-- <h1 class="text-center mt-3">{{ $page->title }}</h1> --}}
   <div class="page-wrapper container">
    {!! htmlspecialchars_decode($page->content) !!}
   </div>
  </div>
 @endif
@endsection