(function ($) {
  "use strict";

  /*------------------
        Background Set
    --------------------*/
  $(".set-bg").each(function () {
    var bg = $(this).data("setbg");
    $(this).css("background-image", "url(" + bg + ")");
  });

  // Header carousel
  $(".slider-banner").owlCarousel({
    autoplay: true,
    smartSpeed: 1200,
    dots: true,
    loop: true,
    nav: false,
    responsive: {
      0: {
        items: 1,
      },
      600: {
        items: 1,
      },
      1000: {
        items: 1,
      },
    },
  });

  $(".product-slider").owlCarousel({
    autoplay: true,
    loop: true,
    dots: false,
    nav: true,
    navText: [
      '<i class="bi bi-chevron-left"></i>',
      '<i class="bi bi-chevron-right"></i>',
    ],
    margin: 20,
    responsive: {
      0: {
        items: 2,
      },
      600: {
        items: 3,
      },
      1000: {
        items: 5,
      },
    },
  });

  $(".news-slider").owlCarousel({
    loop: true,
    dots: false,
    nav: true,
    navText: [
      '<i class="bi bi-chevron-left"></i>',
      '<i class="bi bi-chevron-right"></i>',
    ],
    margin: 30,
    responsive: {
      0: {
        items: 1,
      },
      600: {
        items: 3,
      },
      1000: {
        items: 3,
      },
    },
  });

  $(document).on('click', ".swatch-element", function () {
    $(this).parent().children().each(function (key, item) {
        $(item).removeClass("active");
      });
    $(this).addClass("active");

    var value = $(this).data('value'),
      product_id = $(this).data('product'),
        div_item = $(this).closest('.item'),
        img = $(this).find('span').data('img');
    if(img)
      div_item.find('.thumb').find('.item-img').attr('src', img);
    if(value)
    {
      axios({
        method: "post",
        url: '/ajax/change-attr-color',
        data: { color: value, product_id:product_id },
      })
      .then((res) => {
        if (!res.data.error) {
          if(res.data.view)
            div_item.find('.hover-content').remove();
            div_item.find('.thumb').prepend(res.data.view);
        }
      })
      .catch((e) => console.log(e));
    }
  });

  $(document).on('click', '.product-item-size', function(){
    var size = $(this).parent().find('input').val(),
      div_item = $(this).closest('.item'),
      color = div_item.find('.swatch-element.active').data('value'),
      product_item_id = $(this).data('id');

      div_item.find('form').find('input[name="product_item_id"]').val(product_item_id);
      var formData = new FormData(div_item.find('form')[0]);
      axios({
        method: 'post',
        url: div_item.find('form').prop("action"),
        data: formData
      }).then(res => {
        if(res.data.error ==0)
        {
          setTimeout(function () {
            $('#CartCount').html(res.data.count_cart);

            if(res.data.view !=''){
              $('.site-cart #header-cart').remove();
              $('.site-cart').append(res.data.view);
            }


          }, 1000);
          alertMsg('success', res.data.msg);
        }
      })
      .catch((e) => console.log(e));
  });

  // Sticky Navbar
  $(window).scroll(function () {
    if ($(this).scrollTop() > 300) {
      $(".sticky-top").addClass("shadow-sm").css("top", "0px");
    } else {
      $(".sticky-top").removeClass("shadow-sm").css("top", "-100px");
    }
  });

  //Search Switch
  $(".search-switch").on("click", function () {
    // $(".search-model").fadeIn(400);
    $('.header__nav__option').addClass('active');
    $('.search-form').addClass('active');
    $('.search-form input').focus();
  });

  $(".search-close").on("click", function () {
    $('.header__nav__option').removeClass('active');
    $('.search-form').removeClass('active');
    /*$(".search-model").fadeOut(400, function () {
      $("#search-input").val("");
    });*/
  });

  //search
  $('#search-input').click(function(){
      var val = $(this).val();
      if( val.length > 0 )
         $('.search-suggest-list').show();
   });
  $(document).click(function (e) {
        if (!$(event.target).closest('#search-input').length) {
           // Hide the menus.
           $(this).find('.search-suggest-list').hide();
        }
     })
  $('#search-input').keyup(delay(function (e) {
       var this_ = $(this),
          val = $(this).val();
       if( val.length > 0 ){
             axios({
                method: 'post',
                url: '/ajax/search',
                data: {
                   keyword:val
                }
             }).then(res => {
                if(res.data.view!=''){
                   this_.closest('.dropdown').find('.search-suggest-list').html(res.data.view).show();
                }
             }).catch(e => console.log(e));
       }
       else{
          this_.closest('.dropdown').find('.search-suggest-list').hide().html('');
       }
 }, 500));
  //end search
  
  function delay(callback, ms) {
         var timer = 0;
         return function() {
           var context = this, args = arguments;
           clearTimeout(timer);
           timer = setTimeout(function () {
             callback.apply(context, args);
           }, ms || 0);
         };
       }

  /*------------------
		Navigation
	--------------------*/
  $(".mobile-menu").slicknav({
    prependTo: "#mobile-menu-wrap",
    allowParentLinks: true,
  });

  //Canvas Menu
  $(".canvas__open").on("click", function () {
    $(".offcanvas-menu-wrapper").addClass("active");
    $(".offcanvas-menu-overlay").addClass("active");
  });

  $(".offcanvas-menu-overlay").on("click", function () {
    $(".offcanvas-menu-wrapper").removeClass("active");
    $(".offcanvas-menu-overlay").removeClass("active");
  });

  // Menu Dropdown Toggle
  if ($(".menu-trigger").length) {
    $(".menu-trigger").on("click", function () {
      $(this).toggleClass("active");
      $(".header-area .nav").slideToggle(200);
    });
  }

  $(".description-details").addClass("is-show");
  $(".description-details p").slice(0, 2).show();
  $(".product-description__loadmore").on("click", function (e) {
    e.preventDefault();
    $(".description-details p:hidden").slice(0, 8).slideDown();
    if ($(".description-details p:hidden").length == 0) {
      $(".product-description__loadmore").css("visibility", "hidden");
    } else {
      $("html,body").animate(
        {
          scrollTop: $(this).offset().top,
        },
        1500
      );
    }
    $(".loadmore-detail__product").remove();
    $(".description-details").removeClass("is-show");
  });

  // Page loading animation
  $(window).on("load", function () {
    if ($(".cover").length) {
      $(".cover").parallax({
        imageSrc: $(".cover").data("image"),
        zIndex: "1",
      });
    }

    $("#preloader").animate(
      {
        opacity: "0",
      },
      600,
      function () {
        setTimeout(function () {
          $("#preloader").css("visibility", "hidden").fadeOut();
        }, 300);
      }
    );
  });

  $(".product-single__img").slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    infinite: true,
    arrows: false,
    fade: true,
    autoplay: false,
    autoplaySpeed: 4000,
    speed: 300,
    lazyLoad: "ondemand",
    asNavFor: ".product-single__gallery",
    rows: 0,
  });

  $(".product-single__gallery").slick({
    slidesToShow: 10,
    slidesToScroll: 1,
    infinite: true,
    centerPadding: "0px",
    asNavFor: ".product-single__img",
    dots: false,
    centerMode: false,
    draggable: true,
    speed: 200,
    focusOnSelect: true,
    rows: 0,
  });

  $(".product-single__img").on(
    "afterChange",
    function (event, slick, currentSlide, nextSlide) {
      //remove all active class
      $(".product-single__gallery .slick-slide").removeClass("slick-current");
      //set active class for current slide
      $(".product-single__gallery .slick-slide:not(.slick-cloned)")
        .eq(currentSlide)
        .addClass("slick-current");
    }
  );

  $(".btn-subscription").click(function (e) {
    e.preventDefault();
    var action = $(this).closest("form").attr("action"),
      email = $(this).closest("form").find('input[name="your_email"]').val();
    console.log(email);
    if (email != "") {
      axios({
        method: "post",
        url: action,
        data: { email: email },
      })
        .then((res) => {
          if (res.data.status == "success") {
            $("footer").find("#notifyModal").remove();
            $("footer").append(res.data.view);
            $("#notifyModal").modal("show");
          }
        })
        .catch((e) => console.log(e));
    } else {
      alert("Vui lòng nhập Email");
      $('input[name="your_email"]').focus();
    }
  });

  // product attr
  $(document).on('change', '.form-attr input', function(){
    var checked = $(this).is(':checked');
    $(this).closest('.option-select').find('input').prop('checked', false);
    if(checked)
    {
      $(this).prop('checked', true);
    }

    var product = $('input[name="product"]').val();
    var checkedInputs = $('.product-attr input:checked').map(function() {
      return this.value;
    }).get();

    console.log(checkedInputs);
    axios({
      method: 'POST',
      url: '/ajax/change-attr',
      data: {
        attrs:checkedInputs,
        product:product
      },
    }).then(res => {
      if(!res.data.error)
      {
        $('.product-attr-content').html(res.data.view);
        $('.show-price').html(res.data.show_price);
        if(res.data.product_item_sku)
          $('.product-sku').html('<p>Mã SP: '+ res.data.product_item_sku +'</p>');

        $('.product-stock').html('('+ res.data.attr_stock +')');
        $('.product-form__input.qty').attr('max', res.data.attr_stock);
        if(res.data.attr_stock != 0)
          $('.product-form__cart-add').attr('disabled', false);

        if(res.data.gallery)
        {
          $('.gallery-content').html(res.data.gallery);

          $(".product-single__img").slick({
          slidesToShow: 1,
          slidesToScroll: 1,
          infinite: true,
          arrows: false,
          fade: true,
          autoplay: false,
          autoplaySpeed: 4000,
          speed: 300,
          lazyLoad: "ondemand",
          asNavFor: ".product-single__gallery",
          rows: 0,
        });

        $(".product-single__gallery").slick({
          slidesToShow: 10,
          slidesToScroll: 1,
          infinite: true,
          centerPadding: "0px",
          asNavFor: ".product-single__img",
          dots: false,
          centerMode: false,
          draggable: true,
          speed: 200,
          focusOnSelect: true,
          rows: 0,
        });

        $(".product-single__img").on(
          "afterChange",
          function (event, slick, currentSlide, nextSlide) {
            //remove all active class
            $(".product-single__gallery .slick-slide").removeClass("slick-current");
            //set active class for current slide
            $(".product-single__gallery .slick-slide:not(.slick-cloned)")
              .eq(currentSlide)
              .addClass("slick-current");
          }
        );
        }
      }
    }).catch(e => console.log(e));

  })


  /*----------------------------------
    26. Quantity Plus Minus
  ------------------------------------*/
  function qnt_incre(){
    $(document).on("click", ".qtyBtn", function() {
      if($(this).parent().hasClass('disabled'))
        return false;

      var qtyField = $(this).parent(".qtyField"),
          oldValue = $(qtyField).find(".qty").val(),
          newVal = 1;

      if ($(this).is(".plus")) {
        newVal = parseInt(oldValue) + 1;
      } else if (oldValue > 1) {
        newVal = parseInt(oldValue) - 1;
      }
      $(qtyField).find(".qty").val(newVal);
    });
  }
  qnt_incre();

  $(document).on('click', '.product-form__cart-add', function(){
    if($(this).hasClass('disabled'))
    {
      return false;
    }
    if($('input[name="product_item_id"]').length && $('input[name="product_item_id"]').val() == 0)
    {
      console.log($('input[name="product_item_id"]').val());
      alertMsg('error','Vui lòng chọn thuộc tính sản phẩm');
      return false;
    }
    // var form = document.getElementById('product_form_addCart'),
    var form = $(this).closest('form'),
        fdnew = new FormData(form[0]);
    axios({
      method: 'post',
      url: $('#product_form_addCart').prop("action"),
      data: fdnew
    }).then(res => {
      if(res.data.error ==0)
      {
        setTimeout(function () {
          $('#CartCount').html(res.data.count_cart);

          if(res.data.view !=''){
            $('.site-cart #header-cart').remove();
            $('.site-cart').append(res.data.view);
          }


        }, 1000);
        // alertMsg('success', res.data.msg);
        $('#product_add_cart_modal').remove();
        $('body').append(res.data.view_modal);
        $('#product_add_cart_modal').modal('show');

        $(".product-top-sell").owlCarousel({
          autoplay: true,
          margin: 5,
          smartSpeed: 1500,
          loop: true,
          nav: true,
          navText: ['<i class="fa-solid fa-chevron-left"></i>', '<i class="fa-solid fa-chevron-right"></i>'],
          dots: true,
          items: 4,
          responsive:{
            0:{
              items:2,
            },
            600:{
              items:3,
            },
            1000:{
              items:4,
            }
          }
        });

        setTimeout(function(){
          $('.product-top-sell').css({'opacity': 1})
        }, 1000)

      }else{
        alertMsg('error', res.data.msg);
      }
    }).catch(e => console.log(e));
  });
  $(document).on('click', '.quick-buy', function(){
    $(this).text('Loading...');
    var form = document.getElementById('product_form_addCart'),
        fdnew = new FormData(form),
        href = $(this).attr('href');
    axios({
      method: 'post',
      url: 'buy-now',
      data: fdnew
    }).then(res => {
      if(res.data.error ==0)
      {
        window.location.href = href;
      }else{
        alertJs('error', res.data.msg);
      }
    }).catch(e => console.log(e));

    return false;
  });

  $(document).on('click', '.mini-products-list .remove', function(event) {
    event.preventDefault();
    $(this).closest('.widget-cart-item').remove();
    var rowId = $(this).attr('data');
    axios({
      method: 'post',
      url: '/cart/ajax/remove',
      data: { rowId:rowId }
    }).then(res => {
      if(res.data.error ==0)
      {
        setTimeout(function () {
          $('#CartCount').html(res.data.count_cart);
          $('#header-cart .money-total').html(res.data.total);
        }, 1000);
        alertJs('success', res.data.msg);
      }else{
        alertJs('error', res.data.msg);
      }
    }).catch(e => console.log(e));
  });


  // product attr
    if($('#district').length)
    {
      var province_id = $('#district').data('province');
      getLocation(province_id, 'district');
    }
    if($('#ward').length)
    {
      var district_id = $('#ward').data('district');
      getLocation(district_id, 'ward');
    }

    $("#province").change(function () {
        var id = $(this).val();

        getLocation(id, 'district');

    });
    $("#district").change(function () {
        var id = $(this).val();

        getLocation(id, 'ward');
    });

    function getLocation(id, type="province") {
      axios({
        method: 'post',
        url: '/location/'+ type,
        data: {
              id: id
          },
      }).then(res => {
          $("#"+ type).attr('disabled', false);
          $("#"+ type).html(res.data.view);

          var val = $("#"+ type).attr('data');
          $("#"+ type).val(val).change();

          if(res.data.to_district)
          {
            $('#to_district').val(res.data.to_district);
          }
          if(res.data.to_ward)
          {
            $('#to_ward').val(res.data.to_ward);
          }
      }).catch(e => console.log(e));
    }
//----
})(window.jQuery);

function alertMsg(type = 'error', msg = '', note = '') {
  const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      confirmButton: 'btn btn-success',
      cancelButton: 'btn btn-danger'
    },
    buttonsStyling: true,
  });
  swalWithBootstrapButtons.fire(
      msg, note, type
  )
}
