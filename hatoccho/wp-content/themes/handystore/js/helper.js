/* Handy Theme js functions ver 2.0 */
jQuery(document).ready(function($){
    "use strict";

    /* List/Grid Switcher */
    var container = $('ul.products:not(.owl-carousel)');
    if ( $('.pt-view-switcher span.pt-list').hasClass('active') ) {
      container.find('.product').each(function(){
        if ($(this).not('.list-view')) {
          $(this).addClass('list-view');
        };
      });
    };

    $('.pt-view-switcher').on( 'click', 'span', function(e) {
      e.preventDefault();
      if ( (e.currentTarget.className == 'pt-grid active') || (e.currentTarget.className == 'pt-list active') ) {
        return false;
      }
      var container = $('ul.products:not(.owl-carousel)');

      if ( $(this).hasClass('pt-grid') && $(this).not('.active') ) {
        container.animate({opacity:0},function(){
          $('.pt-view-switcher .pt-list').removeClass('active');
          $('.pt-view-switcher .pt-grid').addClass('active');
          container.find('.product').each(function(){
            $(this).removeClass('list-view');
          });
          container.stop().animate({opacity:1});
        });
      }

      if ( $(this).hasClass('pt-list') && $(this).not('.active') ) {
        container.animate({opacity:0},function(){
          $('.pt-view-switcher .pt-grid').removeClass('active');
          $('.pt-view-switcher .pt-list').addClass('active');
          container.find('.product').each(function(){
            $(this).addClass('list-view');
          });
          container.stop().animate({opacity:1});
        });
      }
    });

    /* Product dropdown filters animation */
    var settings = {
      interval: 100,
      timeout: 200,
      over: mousein_triger,
      out: mouseout_triger
    };

    function mousein_triger(){
      if ($(this).hasClass('widget_price_filter')) {
        $(this).find('form').css('visibility', 'visible');
      } else {
        $(this).find('.yith-wcan').css('visibility', 'visible');
      }
      $(this).addClass('hovered');
    }
    function mouseout_triger() {
      $(this).removeClass('hovered');
  		if ($(this).hasClass('widget_price_filter')) {
  			$(this).find('form').delay(300).queue(function() {
  				$(this).css('visibility', 'hidden').dequeue();
  			});
  		} else {
  			$(this).find('.yith-wcan').delay(300).queue(function() {
  				$(this).css('visibility', 'hidden').dequeue();
  			});
  		}
    }

    $('#filters-sidebar .widget').hoverIntent(settings);

    /* Adding slider to woocommerce recently-viewed widget */
    $('.widget_recently_viewed_products').each(function(){
        var slider = $(this).find('.product_list_widget');
        slider.attr("data-owl","container").attr("data-owl-slides","1").attr("data-owl-type","simple").attr("data-owl-transition","fade").attr("data-owl-navi","true").attr("data-owl-pagi","false");
    });

    /* Primary navigation animation */
    $('.primary-nav li').has('ul').mouseover(function(){
        $(this).children('ul').css('visibility','visible');
        }).mouseout(function(){
        $(this).children('ul').css('visibility','hidden');
    });

    /* Extra product gallery images links */
    $("ul.pt-extra-gallery-thumbs li a").on( 'click', function(e) {
        e.preventDefault();
        var mainImage = $(this).attr("href");
        var imgSrcset = $(this).find('img').attr("srcset");
        var mainImageContainer = $(this).parent().parent().parent().find(".pt-extra-gallery-img img");
        mainImageContainer.attr({ src: mainImage, srcset: imgSrcset });
        return false;
    });

    /* To top button */
    // Scroll (in pixels) after which the "To Top" link is shown
    var offset = 300,
    //Scroll (in pixels) after which the "back to top" link opacity is reduced
    offset_opacity = 1200,
    //Duration of the top scrolling animation (in ms)
    scroll_top_duration = 700,
    //Get the "To Top" link
    $back_to_top = $('.to-top');

    //Visible or not "To Top" link
    $(window).scroll(function(){
        ( $(this).scrollTop() > offset ) ? $back_to_top.addClass('top-is-visible') : $back_to_top.removeClass('top-is-visible top-fade-out');
        if( $(this).scrollTop() > offset_opacity ) {
            $back_to_top.addClass('top-fade-out');
        }
    });

    //Smoothy scroll to top
    $back_to_top.on('click', function(event){
        event.preventDefault();
        $('body,html').animate({
            scrollTop: 0 ,
            }, scroll_top_duration
        );
    });

    /* Magnific pop-Up init */

    // Gallery Page init
    $('.pt-gallery').each( function() {

        $(this).magnificPopup({

            mainClass: 'mfp-zoom-in mfp-img-mobile',
            removalDelay: 300,
            delegate: '.quick-view',
            type: 'image',
            closeOnContentClick: true,
            closeBtnInside: true,

            image: {
                verticalFit: true,
                titleSrc: function(item) {
                    var img_desc = item.el.parent().parent().find('h3').html();
                    return img_desc + '<a class="image-source-link" href="'+item.el.attr('href')+'" target="_blank">source</a>';
                }
            },

            gallery: {
                enabled:true,
            },

            callbacks: {
              beforeOpen: function() {
                            // just a hack that adds mfp-anim class to markup
                            this.st.image.markup = this.st.image.markup.replace('mfp-figure', 'mfp-figure mfp-with-anim');
              },
                buildControls: function() {
                            // re-appends controls inside the main container
                            this.contentContainer.append(this.arrowLeft.add(this.arrowRight));
                },
            },

        });

    });

    // Single image pop-up init
    var magnificLink = $('[data-magnific=link]');

    magnificLink.magnificPopup({
        removalDelay: 500,
        type: 'image',
        closeOnContentClick: false,
        closeBtnInside: true,

        callbacks: {
            beforeOpen: function() {
            // just a hack that adds mfp-anim class to markup
            this.st.image.markup = this.st.image.markup.replace('mfp-figure', 'mfp-figure mfp-with-anim');
            this.st.mainClass = this.st.el.attr('data-effect');
            }
        },
    });

    // Single Product Gallery
    var magnificContainer = $('[data-magnific=container]');

    magnificContainer.each( function() {

        $(this).magnificPopup({

            mainClass: 'mfp-zoom-in mfp-img-mobile',
            removalDelay: 300,
            delegate: 'a.magnific-link',
            type: 'image',
            closeOnContentClick: true,
            closeBtnInside: true,
            midClick: true,
            image: {
                verticalFit: true,
                titleSrc: function(item) {
                    var img_desc = item.el.attr('title');
                    return img_desc + '<a class="image-source-link" href="'+item.el.attr('href')+'" target="_blank">source</a>';
                }
            },
            gallery: {
                enabled:true,
            },
            callbacks: {
                beforeOpen: function() {
                              // just a hack that adds mfp-anim class to markup
                              this.st.image.markup = this.st.image.markup.replace('mfp-figure', 'mfp-figure mfp-with-anim');
                },
                buildControls: function() {
                    if ( this.arrowLeft && this.arrowRight ) {
                        this.contentContainer.append(this.arrowLeft.add(this.arrowRight));
                    };
                },
            },

        });

    });

    /* Owl Carousel init */

    // Owl special functions
    function center(number,sync2){
        var sync2visible = sync2.data("owlCarousel").owl.visibleItems;
        var num = number;
        var found = false;
        for(var i in sync2visible){
            if(num === sync2visible[i]){
                var found = true;
            }
        }

        if(found===false){
            if(num>sync2visible[sync2visible.length-1]){
                sync2.trigger("owl.goTo", num - sync2visible.length+2)
            }else{
                if(num - 1 === -1){
                    num = 0;
                }
                sync2.trigger("owl.goTo", num);
            }
        } else if(num === sync2visible[sync2visible.length-1]){
            sync2.trigger("owl.goTo", sync2visible[1])
        } else if(num === sync2visible[0]){
            sync2.trigger("owl.goTo", num-1)
        }
    }

    function afterOWLinit() {
        // adding A to div.owl-page
        $('.owl-controls .owl-page').append('<div class="item-link"></div>');
        var paginatorsLink = $('.owl-controls .item-link');
        /**
        * this.owl.userItems - it's your HTML <div class="item"><img src="http://www.ow...t of us"></div>
        */
        $.each(this.owl.userItems, function (i) {
            $(paginatorsLink[i])
            // i - counter
            // Give some styles and set background image for pagination item
            .css({
            'background': 'url(' + $(this).find('img').attr('src') + ') center center no-repeat',
            '-webkit-background-size': 'cover',
            '-moz-background-size': 'cover',
            '-o-background-size': 'cover',
            'background-size': 'cover'
            })
            // set Custom Event for pagination item
            .click(function () {
                $(this).trigger('owl.goTo', i);
            });
        });
    }

    var owlContainer = $('[data-owl=container]');

    $(owlContainer).each(function(){
        // Variables
        var owlSlidesQty = $(this).data('owl-slides');
        var owlType = $(this).data('owl-type');
        var owlTransition = $(this).data('owl-transition');
        if ( owlSlidesQty !== 1 ) {
            owlTransition = false;
        }
        var owlNavigation = $(this).data('owl-navi');
        var owlPagination = $(this).data('owl-pagi');
        if (!owlPagination || owlPagination=='') {
            owlPagination = false
        }
        if (owlNavigation == 'custom') {
            var owlCustomNext = $(this).find(".next");
            var owlCustomPrev = $(this).find(".prev");
        };

        // Simple Carousel
        if ( owlType == 'simple' ) {
            // One Slide Gallery
            if ( owlSlidesQty == 1 ) {
                $(this).owlCarousel({
                    navigation : owlNavigation,
                    pagination : owlPagination,
                    navigationText : ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"],
                    slideSpeed : 300,
                    paginationSpeed : 400,
                    singleItem : true,
                    transitionStyle : owlTransition,
                });
            };
        };

        // Carousel for Woo shortcodes
        if ( owlType == 'woo_shortcode' ) {
            var owl = $(this).find('ul:not(.pt-extra-gallery-thumbs)');
            owl.owlCarousel({
                navigation : false,
                pagination : owlPagination,
                slideSpeed : 300,
                paginationSpeed : 400,
                items : owlSlidesQty,
                itemsDesktop : owlSlidesQty,
                itemsDesktopSmall : [900,(owlSlidesQty-1)],
                itemsTablet: [600,(owlSlidesQty-1)],
                itemsMobile : [479,2],
                rewindNav : false,
                scrollPerPage : false,
            });

            var owlCustomNext = $(this).find(".next");
            var owlCustomPrev = $(this).find(".prev");

            owlCustomNext.click(function(){
                owl.trigger("owl.next");
            })
            owlCustomPrev.click(function(){
                owl.trigger("owl.prev");
            })
        }

        // Carousel with thumbs
        if ( owlType == 'with-thumbs' ) {
            var sync1 = $(this);
            var sync2 = $(this).parent().find('[data-owl-thumbs="container"]');

            sync2.on("click", ".owl-item", function(e){
                e.preventDefault();
                var number = $(this).data("owlItem");
                sync1.trigger("owl.goTo",number);
            });

            sync1.owlCarousel({
                singleItem : true,
                slideSpeed : 300,
                paginationSpeed : 400,
                navigation : false,
                pagination : false,
                afterInit : function(el) {
      							if (el.parent().hasClass('carousel-loading')) { el.parent().removeClass('carousel-loading'); }
      				  },
                afterAction : function(el){
                    var current = this.currentItem;
                    sync2
                        .find(".owl-item")
                        .removeClass("synced")
                        .eq(current)
                        .addClass("synced")
                        if(sync2.data("owlCarousel") !== undefined){
                            center(current,sync2)
                        }
                },
                responsiveRefreshRate : 200,
                transitionStyle : owlTransition,
            });

            var owlCustomNext = sync1.parent().find(".next");
            var owlCustomPrev = sync1.parent().find(".prev");

            owlCustomNext.click(function(){
                sync1.trigger("owl.next");
            })
            owlCustomPrev.click(function(){
                sync1.trigger("owl.prev");
            })

            sync2.owlCarousel({
                items : 4,
                pagination : false,
                responsiveRefreshRate : 100,
                itemsDesktop : [1199,4],
                itemsDesktopSmall : [979,4],
                itemsTablet: [768,4],
                itemsMobile : [479,2],

                afterInit : function(el){
                    el.find(".owl-item").eq(0).addClass("synced");
                }
            });

        };

        // Simple Carousel with icon-pagination
        if ( owlType == 'with-icons' ) {
            $(this).owlCarousel({
                navigation : owlNavigation, // Show next and prev buttons
                pagination : owlPagination,
                slideSpeed : 300,
                paginationSpeed : 400,
                singleItem : true,
                transitionStyle : owlTransition,
                afterInit: afterOWLinit,
                navigationText : ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"],
            });
        };

    });

    /* Related Posts Carousel on mobile devices */
    var owl = $('#related_posts').find('ul.post-list');
    if ( window.matchMedia("(max-width: 480px)").matches ) {
      owl.owlCarousel({
          navigation: false,
          pagination: true,
          slideSpeed: 300,
          paginationSpeed: 400,
          singleItem : true,
          autoHeight: true,
          singleItem : true,
          transitionStyle : "fade",
      });
    }

    /* Related Products Carousel on mobile devices */
    var related_products_owl = $('.related.products').find('ul.products');
    if ( (window.matchMedia("(max-width: 768px)").matches) ) {
      related_products_owl.owlCarousel({
        navigation: false,
        pagination: true,
        slideSpeed: 300,
        paginationSpeed: 400,
        items : 2,
        itemsDesktop : 2,
        itemsDesktopSmall : [900,2],
        itemsTablet: [600,2],
        itemsMobile : [479,1],
      });
    }

    /* Vendor Related Products Carousel on mobile devices */
    var related_products_owl = $('.wcv-related.products').find('ul.products');
    if ( (window.matchMedia("(max-width: 768px)").matches) ) {
      related_products_owl.owlCarousel({
        navigation: false,
        pagination: true,
        slideSpeed: 300,
        paginationSpeed: 400,
        items : 2,
        itemsDesktop : 2,
        itemsDesktopSmall : [900,2],
        itemsTablet: [600,2],
        itemsMobile : [479,1],
      });
    }

    /* Adding Carousel to cross-sells */
    var owl = $(".cross-sells ul.products");
    owl.owlCarousel({
      navigation : false,
      pagination : true,
      autoPlay   : false,
      slideSpeed : 300,
      paginationSpeed : 400,
      singleItem : true,
      transitionStyle : "fade",
    });

    /* Wrap the selects for extra styling */
    $('.sidebar .widget select, .variations_form select, .orderby').each(function(){
      $(this).wrap( "<div class='select-wrapper'></div>" );
    });

    /* Add extra element to radiobuttons & checkboxes for extra styling */
    var checkboxes = $('input[type="checkbox"]');
    checkboxes.each(function(){
      if ( $(this).is('#rememberme') ) {
        $(this).parent().append('<span class="extra"></span>');
      }
    });

    /* Add Filterizr to Gallery Page Template */
    // Default options
    var options = { animationDuration: 0.3, filter: '1', layout: 'sameWidth', };
    var filterizd = $('.pt-gallery');
    $('.portfolio-filters-wrapper .filtr').click(function() {
      $('.portfolio-filters-wrapper .filtr').removeClass('filtr-active');
      $(this).addClass('filtr-active');
    });
    if ( filterizd.hasClass('filtr-container') ) {
      $('.filtr-container').filterizr(options);
    }

    /* Vendor List socials icons animation */
    var settings2 = {
      interval: 100,
      timeout: 200,
      over: mousein_triger2,
      out: mouseout_triger2
    };

    function mousein_triger2(){
      $(this).find('ul.social-icons').css('visibility', 'visible');
      $(this).addClass('hovered');
    }
    function mouseout_triger2() {
      $(this).removeClass('hovered');
      $(this).find('ul.social-icons').delay(300).queue(function() {
        $(this).css('visibility', 'hidden').dequeue();
      });
    }

    $('.wcv-pro-vendorlist .wcv-socials-container').hoverIntent(settings2);

});
