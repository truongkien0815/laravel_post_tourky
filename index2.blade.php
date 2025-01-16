<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="description">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Favicon --}}
    <link rel="shortcut icon" href="{{ setting_option('favicon') }}" />

    {{-- SEO meta --}}
    @yield('seo')

    {{-- GOOGLE FONT --}}
    <link href="https://fonts.googleapis.com/css2?family=Antonio&family=Montserrat:ital,wght@0,400;0,500;0,600;0,700;0,900;1,400&display=swap" rel="stylesheet">

    {{-- Customized Bootstrap Stylesheet --}}
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    {{-- Icon Font Stylesheet | fontawesome --}}
    <link rel="stylesheet" href="{{ asset('fontawesome_pro/css/all.min.css') }}">

    {{-- Plugins CSS --}}

    {{-- Main Style CSS --}}
    {{-- <link rel="stylesheet" href="{{ asset('plugin/animate/animate-3.5.2.min.css') }}"> --}}
    {{-- <link rel="stylesheet" href="{{ asset('plugin/owlcarousel/assets/owl.carousel.min.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('plugin/swiper@8/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugin/animate/animate.min.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('plugin/splide/css/splide.min.css') }}"> --}}

    {{-- Custom CSS --}}
    <link rel="stylesheet" href="{{ asset('/css/style.css?ver=' . time()) }}">

    @stack('style')

    @stack('script-head')
</head>

<body>



    @yield('content')

    {{-- Including Jquery --}}
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('plugin/axios.min.js') }}"></script>
    <script src="{{ asset('plugin/aos/aos.js') }}"></script>
    <script src="{{ asset('plugin/jquery-validation/jquery.validate.min.js') }}"></script>

    <script src="{{ asset('plugin/wow/wow.min.js') }}"></script>
    <script src="{{ asset('plugin/swiper@8/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('plugin/jquery.arctext.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/@dearhive/dearflip-jquery-flipbook@1.7.3/dflip/js/dflip.min.js"></script>
    <script src="{{ asset('js/main.js?ver=' . time()) }}"></script>

    {{-- Post ajax cart --}}
    <script>
        var cart_url = '{{ route('cart') }}';
        var cart_ajax_add = '{{ route('cart.ajax.add') }}';
        var theme_url = "{{ asset($templateFile) }}";
        var upload = "{{ asset('upload') }}";
    </script>

    <script src="{{ asset('js/custom.js?ver=' . time()) }}"></script>

    @stack('scripts')

    @stack('scripts-footer')
</body>

</html>
