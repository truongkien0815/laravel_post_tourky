@extends($templatePath .'.layouts.index')

@section('seo')
@include($templatePath .'.layouts.seo', $seo??[] )
@endsection

@section('content')
   


   <div class="news-block py-lg-5 py-4">
     <div class="container">
         <div class="title-box">
             <div class="section-heading">
                 <h5>{{ $category_current->name }}</h5>
             </div>
         </div>
         <div class="row g-3">
             @foreach($news as $post)
               <div class="col-lg-3 col-6">
                 @include($templatePath . '.news.includes.post-item', compact('post'))
               </div>
             @endforeach
         </div>
     </div>
   </div>

   @include($templatePath . '.product.product-related')

@endsection