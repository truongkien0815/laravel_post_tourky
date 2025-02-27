
@php
 $products = \App\Product::limit(5)->orderBy('created_at','desc')->get();
$pr_text= setting_option('product_new');
@endphp
<section class="news-products">
    <div class="container">
        <div class="row g-3 align-items-center">
            <div class="col-md-4">
                <div class="section-title mb-0">
                    <div>
                        <h3 class="mb-3">Sản phẩm mới <span class="block">phát hành</span></h3>
                      <p>  {{ $pr_text}}</p>
                    
                       
                    </div>
                   
                </div>
               
            </div>
            <div class="col-md-8">
                <div class="news-products-slider owl-carousel">
                    @foreach($products as $item)
                    <div class="item-product">
                        <a href="{{ url($item->slug.'.html')}}">
                            <div class="product-img">
                                <img src="{{ asset($item->image)}}" alt="" />
                            </div>
                        </a>
                        <div class="item-product-body">
                            <h3><a href="{{ url($item->slug.'.html')}}">{{ $item->name}}</a></h3>
                            <div class="price-cart">

                               
                                <span class="price"> <?php echo number_format($item->price, 0, '', ',') . " đ"; ?> </span>
                                <img src="{{ asset('img/cart.png')}}" alt="" />
                            </div>
                        </div>
                    </div>
                @endforeach
                  
                </div>
            </div>
        </div>
    </div>
</section>