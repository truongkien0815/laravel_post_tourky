/*  ---------------------------------------------------
    Template Name: Amin
    Description:  Amin magazine HTML Template
    Author: Colorlib
    Author URI: https://colorlib.com
    Version: 1.0
    Created: Colorlib
---------------------------------------------------------  */

'use strict';

(function ($) {

    /*------------------
        Background Set
    --------------------*/
    $('.set-bg').each(function () {
        var bg = $(this).data('setbg');
        $(this).css('background-image', 'url(' + bg + ')');
    });

    // Humberger Menu
    $(".humberger-open").on('click', function () {
        $(".humberger-menu-wrapper").addClass("show-humberger-menu");
        $(".humberger-menu-overlay").addClass("active");
        $(".nav-options").addClass("humberger-change");
    });

    $(".humberger-menu-overlay").on('click', function () {
        $(".humberger-menu-wrapper").removeClass("show-humberger-menu");
        $(".humberger-menu-overlay").removeClass("active");
        $(".nav-options").removeClass("humberger-change");
    });

    // Sign Up Form
    $('.signup-switch').on('click', function () {
        $('.signup-section').fadeIn(400);
    });

    $('.signup-close').on('click', function () {
        $('.signup-section').fadeOut(400);
    });

    /*------------------
		Navigation
	--------------------*/
    $(".mobile-menu").slicknav({
        prependTo: '#mobile-menu-wrap',
        allowParentLinks: true
    });

    // Facts counter
    if ($('.counter-count').length) {
        $('.counter-count').counterUp({
          delay: 10,
          time: 2000
      });
    }

    /*------------------
        Hero Slider
    --------------------*/
    var hero_s = $(".hero-slider");
    hero_s.owlCarousel({
        loop: true,
        margin: 0,
        items: 1,
        nav: true,
        navText: ['<span class="arrow_carrot-left"></span>', '<span class="arrow_carrot-right"></span>'],
        dots: false,
        // animateOut: 'fadeOut',
        // animateIn: 'fadeIn',
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true
    });

    /*------------------
        News Slider
    --------------------*/
    $(".news-slider").owlCarousel({
        loop: true,
        margin: 24,
        dots: false,
        nav: true,
        navText: ['<span class="arrow_carrot-left"></span>', '<span class="arrow_carrot-right"></span>'],
        dotsEach: 2,
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 3
            },
            1000: {
                items: 3
            }
        }
    });

    if($('.categories-slider').length)
    var swiper = new Swiper(".categories-slider", {
      slidesPerView: 3,
      grid: {
        rows: 2,
        fill: "row",
      },
      spaceBetween: 24,
      navigation: {
            nextEl: ".category-next",
            prevEl: ".category-prev",
        },
        breakpoints: {
            320: {
                slidesPerView: 1,
                spaceBetween: 10,
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 16,
            },
            1024: {
                slidesPerView: 3,
                spaceBetween: 24,
            },
        },
    });

    /*------------------------
        Latest Review Slider
    --------------------------*/
    $(".lp-slider").owlCarousel({
        loop: true,
        margin: 24,
        dots: false,
        nav: true,
        navText: ['<span class="arrow_carrot-left"></span>', '<span class="arrow_carrot-right"></span>'],
        smartSpeed: 1200,
        autoHeight: false,
        dotsEach: 2,
        autoplay: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 3
            },
            1000: {
                items: 4
            }
        }
    });

    /*------------------------
        Featured Product Slider
    --------------------------*/
    $(".achievement-slider").owlCarousel({
        loop: true,
        margin: 24,
        dots: true,
        nav: true,
        navText: ['<span class="arrow_carrot-left"></span>', '<span class="arrow_carrot-right"></span>'],
        smartSpeed: 1200,
        autoHeight: false,
        dotsEach: 2,
        autoplay: true,
        responsive: {
            0: {
                items: 2
            },
            480: {
                items: 2
            },
            600: {
                items: 4
            },
            1000: {
                items: 5
            }
        }
    });

    /*------------------------
        Related Product Slider
    --------------------------*/
    $(".news-products-slider").owlCarousel({
        loop: true,
        margin: 16,
        dots: false,
        nav: false,
        // navText: ['<span class="arrow_carrot-left"></span>', '<span class="arrow_carrot-right"></span>'],
        smartSpeed: 1200,
        autoHeight: false,
        dotsEach: 2,
        autoplay: true,
        responsive: {
            0: {
                items: 2
            },
            480: {
                items: 2
            },
            600: {
                items: 3
            },
            1000: {
                items: 4
            }
        }
    });

    /*------------------
        Video Popup
    --------------------*/
    $('.video-popup').magnificPopup({
        type: 'iframe'
    });

    /*------------------
        Sidebar Categories
    --------------------*/
    $(".item-cate-sidebar > a").on("click", function() {
        if ($(this).hasClass("active")) {
          $(this).removeClass("active");
          $(this)
            .siblings(".item-cate-content")
            .slideUp(200);
          $(".item-cate-sidebar > a i")
            .removeClass("fa-circle-minus")
            .addClass("fa-circle-plus");
        } else {
          $(".item-cate-sidebar > a i")
            .removeClass("fa-circle-minus")
            .addClass("fa-circle-plus");
          $(this)
            .find("i")
            .removeClass("fa-circle-plus")
            .addClass("fa-circle-minus");
          $(".item-cate-sidebar > a").removeClass("active");
          $(this).addClass("active");
          $(".item-cate-content").slideUp(200);
          $(this)
            .siblings(".item-cate-content")
            .slideDown(200);
        }
    });

    if (window.matchMedia('(max-width: 768px)').matches) {
        // do functionality on screens smaller than 768px
        $('.item-cate-content .fa-chevron-right').on("click", function() {
            // if ($(this).hasClass("active")) {
            //     $(this).removeClass("active");
            //     $(this).siblings('.sub-menu').slideUp(200);
            // } else {
            //     $('.item-cate-content .fa-chevron-right').removeClass('active');
            //     $(this).addClass('active');
            //     $('.sub-menu').slideUp(200);
            //     $(this).siblings(".sub-menu").slideDown(200);
            // }
        });
    }


    // JavaScript Document
function isDevice() {
    return ((/android|webos|iphone|ipad|ipod|blackberry|iemobile|opera mini/i.test(navigator.userAgent.toLowerCase())))
}

function initZoom(width, height) {
    $.removeData('#zoom_10', 'elevateZoom');
    $('.zoomContainer').remove();
    $('.zoomWindowContainer').remove();
    $("#zoom_10").elevateZoom({
        responsive: true,
        tint: true,
        tintColour: '#E84C3C',
        tintOpacity: 0.5,
        easing: true,
        borderSize: 0,
        lensSize: 100,
        constrainType: "height",
        loadingIcon: "https://icodefy.com/Tools/iZoom/images/loading.GIF",
        containLensZoom: false,
        zoomWindowPosition: 1,
        zoomWindowOffetx: 20,
        zoomWindowWidth: width,
        zoomWindowHeight: height,
        gallery: 'gallery_pdp',
        galleryActiveClass: "active",
        zoomWindowFadeIn: 450,
        zoomWindowFadeOut: 450,
        lensFadeIn: 450,
        lensFadeOut: 450,
        zoomType: 'inner',
        cursor: 'crosshair',
    });
}

$(document).ready(function() {
    /* init vertical carousel if thumb image length greater that 4 */
    if ($("#gallery_pdp a").length > 4) {
        $("#gallery_pdp a").css("margin", "0");
        $("#gallery_pdp").rcarousel({
            orientation: "vertical",
            visible: 4,
            width: 105,
            height: 70,
            margin: 5,
            step: 1,
            speed: 500,
        });
        $("#ui-carousel-prev").show();
        $("#ui-carousel-next").show();
    }
    /* Init Product zoom */
    initZoom(500, 475);

    $("#ui-carousel-prev").click(function() {
        initZoom(500, 475);
    });

    $("#ui-carousel-next").click(function() {
        initZoom(500, 475);
    });

    // $(".zoomContainer").width($("#zoom_10").width());

    // $("body").delegate(".fancybox-inner .mega_enl", "click", function() {
    //     $(this).html("");
    //     $(this).hide();
    // });
            // $('#gallery_pdp img').click((e) => {
            //  console.log(e)
            // })

});

$(window).resize(function() {
    var docWidth = $(document).width();
    if (docWidth > 769) {
        initZoom(500, 475);
    } else {
        $.removeData('#zoom_10', 'elevateZoom');
        $('.zoomContainer').remove();
        $('.zoomWindowContainer').remove();
        $("#zoom_10").elevateZoom({
            responsive: true,
            tint: false,
            tintColour: '#3c3c3c',
            tintOpacity: 0.5,
            easing: true,
            borderSize: 0,
            loadingIcon: "https://icodefy.com/Tools/iZoom/images/loading.GIF",
            zoomWindowPosition: "productInfoContainer",
            zoomWindowWidth: 330,
            gallery: 'gallery_pdp',
            galleryActiveClass: "active",
            zoomWindowFadeIn: 450,
            zoomWindowFadeOut: 450,
            lensFadeIn: 400,
            lensFadeOut: 400,
            zoomType: 'inner',
            cursor: 'crosshair',
        });
                
    }
})

$("#zoom_10").fancybox();

    $('.attribute-values label').click(function() {

        $(this).parent().children().each(function(key, item) {
            $(item).removeClass('active');
        });
        $(this).addClass('active');
    });

    $('.list-tag li').click(function() {

        $(this).parent().children().each(function(key, item) {
            $(item).removeClass('active');
        });
        $(this).addClass('active');
    });
})(jQuery);