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
                        
                       
                       
                       
                        {{-- <a href="#item" class="">
                            <i class="fa-light fa-circle-plus"></i> {{ $item->name}}
                        </a> --}}
                      
                        <div class="item-cate-content">
                            <ul>
                                {{-- @foreach($cate_shop_leve2 as $item_nho)
                                @if($item->id == $item_nho->parent) --}}
                                <li>
                                    <a href="{{$item->slug.'.html'}}">  {{$item->name}} <i class="fa-regular fa-chevron-right"></i></a>
                                  
                                    <ul class="sub-menu">
                                          @foreach($cate_shop_leve2 as $item_nho)
                                @if($item->id == $item_nho->parent)
                                        <li>
                                            <a href="{{$item_nho->slug.'.html'}}">{{$item_nho->name}}</a>
                                        </li>
                                          @else
                        
                                @endif
                                @endforeach
                                      
                                    </ul>
                                    
                                </li>
                                {{-- @else
                        
                                @endif
                                @endforeach --}}
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
                  <?php   $cate_shop_leve4 = App\Model\ShopCategory::where('parent','=',$category->parent)->get();
                  
                  $cate_shop_leve44 = App\Model\ShopCategory::where('parent','=',$category->id)->get();
                  ?>
                  
                    @else
                    <h5>Sản phẩm</h5>
                    @endif
                    <div class="list-tag">
                        <ul>
                            
                          
                            
                            @if(empty($category))
                            @foreach($cate_shop_leve3 as $item) 
                                                         
                            <li class="product-photo" data-product-id="{{ $item->id }}"><a href="#sort">{{$item->name}}</a></li>
                        
                            @endforeach

                            @else
                @if($category->parent == 0)
                @foreach($cate_shop_leve44 as $item) 
                                                         
                <li class="product-photo" data-product-id="{{ $item->id }}"><a href="#sort">{{$item->name}}</a></li>

                @endforeach
            @else
                @foreach($cate_shop_leve4 as $item) 
                                                         
            <li class="product-photo" data-product-id="{{ $item->id }}"><a href="#sort">{{$item->name}}</a></li>

            @endforeach
                @endif
                          
                            
                            @endif 
                           
                        </ul>
                        <div class="spinner-border d-none loader" role="status">
							<span class="sr-only">Loading...</span>
						  </div>
                    </div>
                    <div class="products" id="#sort">
                        @foreach($products as $product)
                     
                        <div class="item-product">
                            <a href="{{$product->slug.'.html'}}">
                                <div class="product-img">
                                    <img src="{{asset($product->image)}}" alt="" />
                                </div>
                            </a>
                            <div class="item-product-body">
                                <h3><a href="{{$product->slug.'.html'}}">{{$product->name}}</a></h3>
                                <div class="price-cart">
                                  <span class="price">
                                    {!! $product->showPrice() !!}
                                 </span>
                                        
                                    <a href="{{$product->slug.'.html'}}">  <img src="{{ asset('img/cart.png')}}" alt="" /></a>
                                  
                                </div>
                            </div>
                        </div>
                      
                        @endforeach
                       

                    </div>
                </div>
                @if(empty($category))
                <div class="product-view-more btn-loadmore" data-url="{{ route('product.loadmore') }}">
                    <button class="btn">xem thêm</button>
                </div>
                @else
                <div class="product-view-more btn-loadmo">
                {!! $products->links()  !!}
            </div>
                @endif
               
            </div>
        </div>
    </div>
</section>
  <!-- Product Grid Section End -->
  </main>

  
