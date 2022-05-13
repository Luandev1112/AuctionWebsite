(function ($) {

  "user strict";

    $(window).on('load', function () {
        $('.preloader').fadeOut(1000);
            var img = $('.bg_img');
            img.css('background-image', function () {
            var bg = ('url(' + $(this).data('background') + ')');
            return bg;
        });
    });
    $('footer').prev().hasClass('bg--section') ? $('footer').addClass('bg--body') :  $('footer').addClass('bg--section');
    $('.banner-slider').owlCarousel({
      loop: false,
      nav: false,
      dots: true,
      items: 1,
      margin: 30,
      autoplay: false,
      autoHeight: true,
      animateIn: 'fadeIn',
      animateOut: 'fadeOut',
      mouseDrag: false,
    })
    $('.partner-slider').owlCarousel({
        loop: true,
        nav: false,
        dots: false,
        items: 2,
        autoplay: true,
        margin: 15,
        responsive: {
          768: {
            items: 3,
            margin: 30,
          },
          992: {
            items: 4,
          },
          1200: {
            items: 6,
          }
        }
      })
    $("ul>li>.submenu").parent("li").addClass("menu-item-has-children");
    // drop down menu width overflow problem fix
    $('ul').parent('li').hover(function () {
    var menu = $(this).find("ul");
    var menupos = $(menu).offset();
    if (menupos.left + menu.width() > $(window).width()) {
        var newpos = -$(menu).width();
        menu.css({
        left: newpos
        });
    }
    }); 
    $("body").each(function () {
    $(this).find(".popup-image").magnificPopup({
        type: "image",
        gallery: {
        enabled: true
        }
    });
    });
    //Video Popup Youtube
    $('.popup').magnificPopup({
      disableOn: 700,
      type: 'iframe',
      mainClass: 'mfp-fade',
      removalDelay: 160,
      preloader: false,
      fixedContentPos: true,
      disableOn: 300
    });
    //Popup Uploaded
    $('.popup-player').magnificPopup({
        type: 'iframe',
        mainClass: 'mfp-fade',
        removalDelay: 160,
        preloader: false,
        fixedContentPos: true,
        iframe: {
            markup: '<div class="mfp-iframe-scaler">'+
                    '<div class="mfp-close"></div>'+
                    '<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>'+
                    '</div>',
    
            srcAction: 'iframe_src',
            }
    });
    $('.menu li a').on('click', function (e) {
    var element = $(this).parent('li');
    if (element.hasClass('open')) {
        element.removeClass('open');
        element.find('li').removeClass('open');
        element.find('ul').slideUp(300, "swing");
    } else {
        element.addClass('open');
        element.children('ul').slideDown(300, "swing");
        element.siblings('li').children('ul').slideUp(300, "swing");
        element.siblings('li').removeClass('open');
        element.siblings('li').find('li').removeClass('open');
        element.siblings('li').find('ul').slideUp(300, "swing");
    }
    })
    // Scroll To Top 
    var scrollTop = $(".scrollToTop");
    $(window).on('scroll', function () {
    if ($(this).scrollTop() < 500) {
        scrollTop.removeClass("active");
    } else {
        scrollTop.addClass("active");
    }
    });
    //header
    var header = $(".header-bottom");
    $(window).on('scroll', function () {
    if ($(this).scrollTop() < 1) {
        header.removeClass("active");
    } else {
        header.addClass("active");
    }
    });
    //Click event to scroll to top
    $('.scrollToTop').on('click', function () {
    $('html, body').animate({
        scrollTop: 0
    }, 500);
    return false;
    });
    //Header Bar
    $('.header-bar').on('click', function () {
      $(this).toggleClass('active');
      $('.overlay').toggleClass('active');
      $('.menu').toggleClass('active');
    })
    $('.overlay').on('click', function () {
      $('.menu, .dashboard-menu, .overlay, .header-bar').removeClass('active');
    });
    $('.sidebar__init').on('click', function() {
      $('.dashboard-menu, .overlay').addClass('active')
    })
    $('.side-sidebar-close-btn').on('click', function() {
      $('.dashboard-menu, .overlay').removeClass('active')
    })
    
    $('.faq__wrapper .faq__title').on('click', function (e) {
      var element = $(this).parent('.faq__item');
      if (element.hasClass('open')) {
          element.removeClass('open');
          element.find('.faq__content').removeClass('open');
          element.find('.faq__content').slideUp(200, "swing");
      } else {
          element.addClass('open');
          element.children('.faq__content').slideDown(200, "swing");
          element.siblings('.faq__item').children('.faq__content').slideUp(200, "swing");
          element.siblings('.faq__item').removeClass('open');
          element.siblings('.faq__item').find('.faq__title').removeClass('open');
          element.siblings('.faq__item').find('.faq__content').slideUp(200, "swing");
      }
    });
    $('.products-slider').owlCarousel({
      loop: false,
      responsiveClass: true,
      nav: true,
      dots: false,
      autoplay: true,
      autoplayTimeout: 2500,
      autoplayHoverPause: true,
      responsive: {
        0: {
          items: 1,
        },
        768: {
          items: 2,
        },
        992: {
          items: 3,
        },
        1200: {
          items: 4,
        }
      }
    });
    $('.related-slider').owlCarousel({
      loop: false,
      responsiveClass: true,
      nav: false,
      dots: false,
      autoplay: true,
      autoplayTimeout: 2500,
      autoplayHoverPause: true,
      responsive: {
        0: {
          items: 1,
        },
        768: {
          items: 2,
        },
        1400: {
          items: 3,
        }
      }
    });
    $('.client-slider').owlCarousel({
      loop: true,
      responsiveClass: true,
      nav: false,
      dots: true,
      autoplay: true,
      autoplayTimeout: 2500,
      autoplayHoverPause: true,
      items: 1
    });

    $('.tab-menu li').on('click', function (g) {
      var tab = $(this).closest('.tab'),
        index = $(this).closest('li').index();
      tab.find('li').siblings('li').removeClass('active');
      $(this).closest('li').addClass('active');
      tab.find('.tab-area').find('div.tab-item').not('div.tab-item:eq(' + index + ')').hide(500);
      tab.find('.tab-area').find('div.tab-item:eq(' + index + ')').show(500);
      g.preventDefault();
    });

    $('.owl-prev').html('<i class="las la-angle-left">');
    $('.owl-next').html('<i class="las la-angle-right">');

    $('.more--btn').on('click', function() {
      if($('.more--btn').hasClass('active')) {
        $(this).removeClass('active');
        $('.footer-hidden-links').slideUp(300);
      }else {
        $(this).addClass('active');
        $('.footer-hidden-links').slideDown(300)
      }
    })

    $('.type-change').on('click', function(e){
      if($(this).hasClass('active')) {
        $(this).removeClass('active');
        $(this).siblings('input').attr({type:"password"});
        $(this).closest('.position-relative').find('.type-change').html('<i class="las la-eye"></i>');
      }else {
        $(this).addClass('active');
        $(this).siblings('input').attr({type:"text"});
        $(this).closest('.position-relative').find('.type-change').html('<i class="las la-eye-slash"></i>');
      }
    })
    $('.recent__logins').owlCarousel({
      loop: false,
      responsiveClass: true,
      nav: false,
      dots: true,
      autoplay: true,
      autoplayTimeout: 2500,
      autoplayHoverPause: true,
      responsive: {
        0: {
          items: 2,
        },
        500: {
          items: 2,
        },
        768: {
          items: 3,
        },
        992: {
          items: 2,
        },
        1200: {
          items: 3,
        },
      }
    });

    $('.close-filter-bar').on('click', function(){
      $('.search-filter').removeClass('active');
    })
    $('.filter-btn').on('click', function(){
      $('.search-filter').addClass('active');
    })
    
      $( "#slider-range" ).slider({
          range: true,
          min: 0,
          max: 10000,
          values: [ 700, 6000 ],
          slide: function( event, ui ) {
          $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
          }
      });
      $( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) + " - $" + $( "#slider-range" ).slider( "values", 1 ) );
      
    $(".qtybutton").on("click", function() {
      var $button = $(this);
      $button.parent().find('.qtybutton').removeClass('active')
      $button.addClass('active');
        var oldValue = $button.parent().find("input").val();
        if ($button.hasClass('inc')) {
            var newVal = parseFloat(oldValue) + 1;
        } else {
            if (oldValue > 1) {
                var newVal = parseFloat(oldValue) - 1;
            } else {
                newVal = 1;
            }
        }
      $button.parent().find("input").val(newVal);
    });

})(jQuery);