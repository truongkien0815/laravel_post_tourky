@php
use App\Page as Page;
	
	
    $category = \App\Model\Category::where('slug', 'gioi-thieu')->first();
   
   $posts = $category->post()->where('slug','gioi-thieu')->first();
   $post_tam_nhin = $category->post()->where('slug','tam-nhin')->first();
   $post_su_menh = $category->post()->where('slug','su-menh')->first();
    @endphp
 <section class="breadcrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text">
                    <div class="bt-option">
                        <a href="/">Trang chủ</a>
                        <span>{{$category->name}}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="about-section py-3">
    <div class="container">
        <div class="row g-3">
            <div class="col-md-5">
                <div class="img-about">
                    <img src="	{{ asset($posts->image)}}" alt="">
                </div>
            </div>
            <div class="col-md-7">
                <div class="box-text-about offset-lg-1">
                    <div class="sub-title">Về chúng tôi</div>
                    {!! htmlspecialchars_decode($posts->content) !!}
                </div>
            </div>
        </div>
    </div>
</section>


<section class="philosophy-mission-section py-5">
    <div class="container">
        <div class="row rw-philosophy-mission g-3">
            <div class="col-md-6 items-pm">
                <div class="img-philosophy">
                    <img src="{{asset($post_tam_nhin->image)}}" alt="" />
                </div>
            </div>
            <div class="col-md-6 items-pm">
                <div class="box-text-about">
                    <h3>{{$post_tam_nhin->name}}</h3>
                    {!! htmlspecialchars_decode($post_tam_nhin->content) !!}
                   
                </div>
            </div>
            <div class="col-md-6 items-pm">
                <div class="box-text-about">
                    <h3>{{$post_su_menh->name}}</h3>
                    {!! htmlspecialchars_decode($post_su_menh->content) !!}
                
                </div>
            </div>
            <div class="col-md-6 items-pm">
                <div class="img-philosophy">
                    <img src=" {{asset($post_su_menh->image)}}" alt="" />
                </div>
            </div>
        </div>
    </div>
</section>
