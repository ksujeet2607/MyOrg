(function($) {
    "use strict";

    $(window).on("load", function() {

        /***************** Loading Screen ******************/

        $('.loader').fadeOut('slow'); // End Loader
        $('body').css('overflow', 'auto');

        /***************** Isotope Filter ******************/

        var $container = $(".portfolio-items");
        if ($container.length) {
            $container.isotope({
                filter: "*",
                animationOptions: {
                    duration: 750,
                    itemSelector: '.isotope-item',
                    easing: "linear",
                    queue: false,
                }
            });
        } // intialize
        $(".filter li a").on("click", function() {
            var selector = $(this).attr("data-filter");
            $container.isotope({
                filter: selector,
                animationOptions: {
                    duration: 750,
                    itemSelector: '.isotope-item',
                    easing: "linear",
                    queue: false,
                }
            });
            return false;            
        }); // data-filter
        var $optionSets = $('.filter'), $optionLinks = $optionSets.find('a'); 
        $optionLinks.on("click", function() {
            var $this = $(this); 
            // don't proceed if already active
            if ( $this.hasClass('active') ) { 
                return false; 
            } 
            var $optionSet = $this.parents('.filter'); 
            $optionSet.find('.active').removeClass('active'); 
            $this.addClass('active');  
        });

        /***************** Waypoints ******************/

        $('.home-skills').waypoint(function() {
            $('.home-skills .skillbar').each(function(){
                $(this).find('.skillbar-bar').animate({
                    width:$(this).attr('data-percent')
                },1500);
            });
        }, { offset: '75%' }); // Skills

    });
    
    /***************** Slider Revolution ******************/

    $('.tp-banner').revolution({
        delay:9000,
        startheight:616,
        navigationVAlign: "center",
        soloArrowLeftHOffset: 100,
        soloArrowLeftVOffset: 10,
        soloArrowRightHOffset: 100,
        soloArrowRightVOffset: 10,
        hideTimerBar: "on",
        hideArrowsOnMobile:"off",
        hideThumbs:0
    }); // Main Slider

    $('.fullscreen').revolution({
        delay:9000,
        startheight:616,
        navigationVAlign: "center",
        hideTimerBar: "on",
        fullScreen: "on",
        hideThumbs:0
    }); // Fullscreen Slider

    var tb_container = $('.tp-banner-container');

    $('.main-navigation').find('.courses-menu').hover(function(){
        tb_container.addClass('slider-overlay');
    }, function() {
        tb_container.removeClass('slider-overlay');
    });

    /***************** Flex Slider ******************/

    $('#courses-slider').flexslider({
        animation: "slide",
        prevText: "",
        nextText: "",
        itemWidth: 292,
        itemMargin: 0,
        move: 1
    }); // Courses Slider

    $('.basic-slider, #single-slider, #sidebar-tweets, .portfolio-slider').flexslider({
        animation: "slide",
        controlNav: false,
        prevText: "",
        nextText: "",
        slideshow: false
    }); // Basic Slider

    $('#clients-slider').flexslider({
        animation: "slide",
        controlNav: false,
        prevText: "",
        nextText: "",
        slideshow: false
    }); // Clients Slider

    $('#testimonials-slider').flexslider({
        animation: "slide",
        controlNav: false,
        smoothHeight: true,
        prevText: "",
        nextText: "",
        slideshow: false
    }); // Testimonials Slider
	
	 $('#achievement-slider').flexslider({
        animation: "slide",
        controlNav: false,
        smoothHeight: true,
        prevText: "",
        nextText: "",
        slideshow: false
    }); // achievement Slider

    $('#footer-courses-slider').flexslider({
        animation: "slide",
        directionNav: false,
        prevText: "",
        nextText: ""
    }); // Footer Slider
	
	 $('#mission-slider').flexslider({
        animation: "slide",
        directionNav: false,
        prevText: "",
        nextText: ""
    }); // Mission Slider
	
	 $('#event-slider').flexslider({
        animation: "slide",
        directionNav: false,
        prevText: "",
        nextText: ""
    }); // Event Slider

    $('#tweets-slider').flexslider({
        animation: "slide",
        directionNav: false,
        prevText: "",
        nextText: "",
        slideshow: false
    }); // Tweets Slider

    function initFlexModal() {
        $('.modal-slider').flexslider({
            animation: "slide",
            controlNav: false,
            prevText: "",
            nextText: "",
            slideshow: false
        });
    };
    $('#portfolio-modal').one('shown.bs.modal', function () {
        initFlexModal();
    }); // Modal Slider

    /***************** Animation ******************/

//    $('.fadeInDown-animation').addClass('hide').viewportChecker({
//        classToAdd: 'show animated fadeInDown',
//        offset: 100
//   });

    /***************** Tabs ******************/

    $('ul.tabs li').on("click", function() {        
        var tab_id = $(this).attr('data-tab');
        $('ul.tabs li').removeClass('active');
        $('.tab-content').removeClass('active');
        $(this).addClass('active');
        $("#"+tab_id).addClass('active');
    });

    /***************** Accordion ******************/

    $('.accordion-header').toggleClass('inactive-header');
    $('.accordion-header').first().toggleClass('active-header').toggleClass('inactive-header');
    $('.accordion-content').first().slideDown().toggleClass('open-content');
    $('.accordion-header').on("click", function() {
        if($(this).is('.inactive-header')) {
            $('.active-header').toggleClass('active-header').toggleClass('inactive-header').next().slideToggle().toggleClass('open-content');
            $(this).toggleClass('active-header').toggleClass('inactive-header');
            $(this).next().slideToggle().toggleClass('open-content');
        }
        else {
            $(this).toggleClass('active-header').toggleClass('inactive-header');
            $(this).next().slideToggle().toggleClass('open-content');
        }
    });

    /***************** Mobile Navigation ******************/

    $('.main-navigation').find('ul:first').clone().appendTo('.mobile-container');

    $('.mobile-navigation').find('.mobile-btn').on("click", function(event) {
        $('body').addClass('mobile_nav-open');
        $('.mobile-navigation').find('.mobile-container').slideToggle();
        $(this).toggleClass('show-menu');
        event.preventDefault();
    });

    $('.mobile-navigation').find('.haschild').each(function() {
        var mobile_submenu = $(this).find('ul:first');
        $(this).hover(function() { 
            mobile_submenu.stop().css({overflow:'hidden', height:'auto', display:'none', paddingTop:0}).slideDown(500, function() {
                $(this).css({overflow:'visible', height:'auto'});
            }); 
        },function() {
            mobile_submenu.stop().slideUp(500, function() {   
                $(this).css({overflow:'hidden', display:'none'});
            });
        }); 
    });

    $('.mobile-navigation').find('.haschild').children('a').one('click',function() {
        return false;
    }).on("click", function() {
        return true;
    });

    /***************** Smooth Scrolling ******************/

    $('a[href*=#]:not([href=#])').on("click", function() {
        if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
            if (target.length) {
                $('html,body').animate({scrollTop: target.offset().top}, 750);
                return false;
            }
        }
    });

})(jQuery);