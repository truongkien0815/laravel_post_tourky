
<!-- ***** Main Banner Area Start ***** -->
@include($templateFile .'.blocks.slideshows')
<!-- ***** Main Banner Area End ***** -->

<!-- ***** Product Starts ***** -->
@include($templateFile .'.blocks.products')
<!-- ***** Product Ends ***** -->

<!-- ***** Banner Starts ***** -->
@include($templateFile .'.partials.banner-link', [
    'banner' => \App\Model\Slider::where('status', 0)->where('slider_id', 11)->orderBy('order','asc')->get()
    ])
<!-- ***** Banner Ends ***** -->

<!-- ***** Shirt Starts ***** -->
@include($templateFile .'.partials.product-by-category', [ 'id' => 1 ])
<!-- ***** Shirt Ends ***** -->

<!-- ***** Banner Polo Starts ***** -->
@include($templateFile .'.partials.banner-link', [
    'banner' => \App\Model\Slider::where('status', 0)->where('slider_id', 13)->orderBy('order','asc')->get()
    ])
<!-- ***** Banner Polo Ends ***** -->

<!-- ***** Product Polo Starts ***** -->
@include($templateFile .'.partials.product-by-category', [ 'id' => 2 ])
<!-- ***** Product Polo Ends ***** -->

<!-- ***** Banner Short Starts ***** -->
@include($templateFile .'.partials.banner-link', [
    'banner' => \App\Model\Slider::where('status', 0)->where('slider_id', 15)->orderBy('order','asc')->get()
    ])
<!-- ***** Banner Short Ends ***** -->

<!-- ***** Product Short Starts ***** -->
@include($templateFile .'.partials.product-by-category', [ 'id' => 3 ])
<!-- ***** Product Short Ends ***** -->

<!-- ***** Banner Under Starts ***** -->
@include($templateFile .'.partials.banner-link', [
    'banner' => \App\Model\Slider::where('status', 0)->where('slider_id', 17)->orderBy('order','asc')->get()
    ])
<!-- ***** Banner Under Ends ***** -->

<!-- ***** Product Under Starts ***** -->
@include($templateFile .'.partials.product-by-category', [ 'id' => 4 ])
<!-- ***** Product Under Ends ***** -->

<!-- ***** News Starts ***** -->
@include($templateFile .'.blocks.news')
<!-- ***** News Ends ***** -->

<!-- ***** Archive Starts ***** -->
@include($templateFile .'.blocks.archive')
<!-- ***** Archive Ends ***** -->