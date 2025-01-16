<?php 
    
    $cate_type = App\Model\ShopType::all();
    $cate_shop = App\Model\ShopCategory::where('parent','0')->get();
    $cate_shop_leve2 = App\Model\ShopCategory::all();
    $cate_shop_leve3 = App\Model\ShopCategory::where('parent','!=','0')->limit(8)->get();

    $product_new = App\Product::limit(7)->get();
    $product_item = App\Product::all();

    
?>
<section class="product-grid-section">
    <div class="container">
        <div class="row g-3">
            <div class="col-md-4 col-lg-3">


                <div class="sidebar">
                    <h3 class="title-cate">DANH MỤC SẢN PHẨM</h3>
                    @foreach($cate_shop as $item)
                    <div class="item-cate-sidebar">
                        
                       
                       
                       
                        <a href="#item" class="">
                            <i class="fa-light fa-circle-plus"></i> {{ $item->name}}
                        </a>
                      
                        <div class="item-cate-content">
                            <ul>
                                @foreach($cate_shop_leve2 as $item_nho)
                                @if($item->id == $item_nho->parent)
                                <li>
                                    <a href="{{$item_nho->slug.'.html'}}">{{$item_nho->name}} <i class="fa-regular fa-chevron-right"></i></a>
                                  
                                    <ul class="sub-menu">
                                        <li>
                                            <a href="#">Item 1</a>
                                        </li>
                                        <li>
                                            <a href="#">Item 2</a>
                                        </li>
                                        <li>
                                            <a href="#">Item 3</a>
                                        </li>
                                    </ul>
                                    
                                </li>
                                @else
                        
                                @endif
                                @endforeach
                            </ul>
                        </div>
                      
                       

                       
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-8 col-lg-9">
                <div class="list-product-right">
                    @if(!empty($category))
                    <h5>{{ $category->name}}</h5>
                  <?php   $cate_shop_leve4 = App\Model\ShopCategory::where('parent','=',$category->parent)->limit(8)->get(); ?>
                  
                    @else
                    <h5>Sản phẩm</h5>
                    @endif
                    <div class="list-tag">
                        <ul>
                            
                            <li class="active"><a href="{{ url('san-pham')}}">🔥 Tất cả</a></li>
                            
                            @if(empty($category))
                            @foreach($cate_shop_leve3 as $item) 
                                                         
                            <li class="product-photo" data-product-id="{{ $item->id }}"><a href="#sort">{{$item->name}}</a></li>
                        
                            @endforeach

                            @else

                            @foreach($cate_shop_leve4 as $item) 
                                                         
                            <li class="product-photo" data-product-id="{{ $item->id }}"><a href="#sort">{{$item->name}}</a></li>
                        
                            @endforeach
                            
                            @endif 
                           
                        </ul>
                    </div>
                    <div class="products" id="#sort">
                        @foreach($products as $product)
                     
                        <div class="item-product">
                            <a href="{{$product->slug.".html"}}">
                                <div class="product-img">
                                    <img src="{{asset($product->image)}}" alt="" />
                                </div>
                            </a>
                            <div class="item-product-body">
                                <h3><a href="{{$product->slug.".html"}}">{{$product->name}}</a></h3>
                                <div class="price-cart">
                                  <span class="price">
                                    {!! $product->showPrice() !!}
                                 </span>
                                        
                                    <a href="{{$product->slug.".html"}}">  <img src="{{ asset('img/cart.png')}}" alt="" /></a>
                                  
                                </div>
                            </div>
                        </div>
                      
                        @endforeach
                       

                    </div>
                </div>
                
                <div class="product-view-more btn-loadmore" data-url="{{ route('product.loadmore') }}">
                    <button class="btn">xem thêm</button>
                </div>
               
            </div>
        </div>
    </div>
</section>
  <!-- Product Grid Section End -->
  </main>

  
