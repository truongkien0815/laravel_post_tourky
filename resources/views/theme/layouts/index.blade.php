<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
   
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
  

    <link rel="shortcut icon" href="{{ asset(setting_option('favicon')) }}" />

    @include($templatePath .'.layouts.seo')

    <link rel="preconnect" href="{{asset('https://fonts.googleapis.com')}}">
    <link rel="preconnect" href="{{asset('https://fonts.gstatic.com')}}" crossorigin>
    <link href="{{asset('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap')}}" rel="stylesheet">


    <link href="{{asset('https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css')}}" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <link rel="stylesheet" href="{{asset('https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css')}}">
    <link rel="stylesheet" href="{{asset('https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css')}}" integrity="sha512-H9jrZiiopUdsLpg94A333EfumgUBpO9MdbxStdeITo+KEIMaNfHNvwyjjDJb+ERPaRS6DpyRlKbvPUasNItRyw==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="{{asset('https://icodefy.com/Tools/iZoom/js/Vendor/fancybox/helpers/jquery.fancybox-thumbs.css')}}">
    <link rel="stylesheet" href="{{asset('https://cdn.jsdelivr.net/npm/xzoom@1.0.14/src/xzoom.css')}}">

    <link rel="stylesheet" href="{{asset('css/fontawesome6.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('fonts/icomoon/style.css')}}">
    <link rel="stylesheet" href="{{asset('css/elegant-icons.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('css/owl.carousel.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('https://cdn.jsdelivr.net/npm/swiper@8.4.7/swiper-bundle.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/barfiller.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('css/magnific-popup.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('css/slicknav.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('css/style.css?ver=0.03')}}" type="text/css">

    {{--  --}}

   
    
    <link rel="stylesheet" href="{{ url($templateFile. '/css/style.css?ver=0.16')  }}"> 
</head>

<body>
 
        {!! htmlspecialchars_decode(setting_option('body-script')) !!}
        @php
            $socials = [
                ['link' => setting_option('facebook'), 'name' => 'facebook'],
                ['link' => setting_option('instagram'), 'name' => 'instagram'],
                ['link' => setting_option('twitter'), 'name' => 'twitter'],
                ['link' => setting_option('linkedin'), 'name' => 'linkedin'],
            ];
        @endphp
        {{--
        <!-- ***** Preloader Start ***** -->
        <div id="preloader">
            <div class="jumper">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>  
        <!-- ***** Preloader End ***** -->
        --}}

        @include($templateFile .'.layouts.header')

        <main class="main">
            @yield('content')
        </main>
        
        @include($templateFile .'.layouts.footer')
        
        <script src="{{ asset('https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js')}}" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <script src="{{ asset('https://code.jquery.com/jquery-3.6.0.min.js')}}"></script>
        <script src="{{ asset('https://icodefy.com/Tools/iZoom/js/Vendor/jquery/jquery-ui.min.js')}}"></script>
        <script src="{{ asset('https://icodefy.com/Tools/iZoom/js/Vendor/ui-carousel/ui-carousel.js')}}"></script>
        <script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js')}}"></script>
        <script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/elevatezoom/2.2.3/jquery.elevatezoom.min.js')}}" integrity="sha512-UH428GPLVbCa8xDVooDWXytY8WASfzVv3kxCvTAFkxD2vPjouf1I3+RJ2QcSckESsb7sI+gv3yhsgw9ZhM7sDw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="{{ asset('https://www.elevateweb.co.uk/wp-content/themes/radial/jquery.elevatezoom.min.js')}}"></script>
    
        <script src="{{ asset('js/jquery.magnific-popup.min.js')}}"></script>
        <script src="{{ asset('js/jquery.slicknav.js')}}"></script>
        <script src="{{ asset('js/owl.carousel.min.js')}}"></script>
        <script src="{{ asset('https://cdn.jsdelivr.net/npm/swiper@8.4.7/swiper-bundle.min.js')}}"></script>
        <script src="{{ asset('js/waypoints.min.js')}}"></script>
        <script src="{{ asset('js/counterup.min.js')}}"></script>
        <script src="{{ asset('js/main.js?ver=0.03')}}"></script>


       



    
   

    <script>window.gtranslateSettings = {"default_language":"vi","native_language_names":true,
    "languages":["vi","en","zh-CN"]
    ,"wrapper_selector":".gtranslate_wrapper","flag_size":24}
    </script>
    <script src="https://cdn.gtranslate.net/widgets/latest/fn.js" defer></script>


    <!-- Plugins -->
    <script src="{{ asset($templateFile. '/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset($templateFile. '/js/slick.js') }}"></script>
    <script src="{{ asset($templateFile. '/js/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset($templateFile. '/js/isotope.js') }}"></script>
    <script src="{{ asset($templateFile. '/js/jquery.slicknav.js') }}"></script>
    <script src="{{ asset('js/axios.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('js/ajax.js') }}"></script>
    @stack('after-footer')

    <!-- Global Init -->
    <script src="{{ asset($templateFile. '/js/custom.js?ver=0.11') }}"></script>

    {!! htmlspecialchars_decode(setting_option('footer-script')) !!}

    @stack('scripts')
</body>
</html>