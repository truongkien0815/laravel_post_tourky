<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset(setting_option('favicon')) }}" />

    @include($templatePath .'.layouts.seo')


    <!-- Additional CSS Files -->
    <link rel="stylesheet" type="text/css" href="{{ url($templateFile. '/css/bootstrap.min.css')  }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ url($templateFile. '/css//owl.carousel.min.css')  }}">
    <link rel="stylesheet" href="{{ url($templateFile. '/css/slick-theme.css')  }}">
    <link rel="stylesheet" href="{{ url($templateFile. '/css/slick.css')  }}">
    <link rel="stylesheet" href="{{ url($templateFile. '/css/slicknav.min.css')  }}">


    @stack('head-style')

    <link rel="stylesheet" href="{{ url($templateFile. '/css/style.css?ver=0.07')  }}">

    {!! htmlspecialchars_decode(setting_option('header-script')) !!}


    @stack('styles')

    @stack('head-script')

    </head>
    
    <body>
        @php
            $socials = [
                ['link' => setting_option('facebook'), 'name' => 'facebook'],
                ['link' => setting_option('instagram'), 'name' => 'instagram'],
                ['link' => setting_option('twitter'), 'name' => 'twitter'],
                ['link' => setting_option('linkedin'), 'name' => 'linkedin'],
            ];
        @endphp
        <!-- ***** Preloader Start ***** -->
        <div id="preloader">
            <div class="jumper">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>  
        <!-- ***** Preloader End ***** -->

        @include($templateFile .'.layouts.header')

        <main class="main">
            @yield('content')
        </main>
        
        @include($templateFile .'.layouts.footer')
        
        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

        <!-- Plugins -->
        <script src="{{ url($templateFile. '/js/owl.carousel.min.js') }}"></script>
        <script src="{{ url($templateFile. '/js/slick.js') }}"></script>
        <script src="{{ url($templateFile. '/js/jquery.counterup.min.js') }}"></script>
        <script src="{{ url($templateFile. '/js/isotope.js') }}"></script>
        <script src="{{ url($templateFile. '/js/jquery.slicknav.js') }}"></script>
        <script src="/js/axios.min.js"></script>
        <script src="/js/sweetalert2.all.min.js"></script>
        <script src="/js/jquery.validate.min.js"></script>

        @stack('after-footer')

        <!-- Global Init -->
        <script src="{{ url($templateFile. '/js/custom.js?ver=0.08') }}"></script>

        {!! htmlspecialchars_decode(setting_option('footer-script')) !!}

        @stack('scripts')
    </body>
</html>