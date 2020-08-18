 $(document).ready(function() {
     "use strict";

     /* -------------------------------------------------------------------------*
      * PRE LOADER
      * -------------------------------------------------------------------------*/
     $(window).load(function() {
             $('#status').delay(300).fadeOut();
             $('#preloader').delay(300).fadeOut('slow');
         })
         /* -------------------------------------------------------------------------*
          * ADD ANIMATION TO SPECIFIC ELEMENTS
          * -------------------------------------------------------------------------*/
     $('.tags li').hover(function() {
         $(this).find('a').toggleClass("wow flipInY animated");
     });
     //
     $('.f-social li').hover(function() {
         $(this).find('a').toggleClass("wow swing animated");
     });
     $('.social a').hover(function() {
         $(this).find('p').toggleClass("wow fadeInDown animated");
     });
     $('a.read-more').hover(function() {
         $(this).find('span').toggleClass("wow flipInY animated");
     });

     /* -------------------------------------------------------------------------*
      * GO TO TOP
      * -------------------------------------------------------------------------*/
     $.scrollUp();

     /* -------------------------------------------------------------------------*
      * MODAL BOXES & POP UP WINDOWS OR IMAGES
      * -------------------------------------------------------------------------*/
     $('.open-popup-link').magnificPopup({
         removalDelay: 500, //delay removal by X to allow out-animation
         callbacks: {
             beforeOpen: function() {
                 this.st.mainClass = this.st.el.attr('data-effect');
             }
         },
         midClick: true // allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source.
     });
     $('#image-popups').magnificPopup({
         delegate: 'a',
         type: 'image',
         removalDelay: 500, //delay removal by X to allow out-animation
         callbacks: {
             beforeOpen: function() {
                 // just a hack that adds mfp-anim class to markup 
                 this.st.image.markup = this.st.image.markup.replace(
                     'mfp-figure', 'mfp-figure mfp-with-anim');
                 this.st.mainClass = this.st.el.attr('data-effect');
             }
         },
         closeOnContentClick: true,
         midClick: true // allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source.
     });
     $('.popup-youtube, .popup-vimeo, .popup-gmaps').magnificPopup({
         disableOn: 700,
         type: 'iframe',
         mainClass: 'mfp-fade',
         removalDelay: 160,
         preloader: true,
         fixedContentPos: false
     });
     $('.popup-img').magnificPopup({
         type: 'image'
     });

     // This will create a single gallery from all elements that have class "gallery-item"
     $('.gallery-item').magnificPopup({
         type: 'image',
         gallery: {
             enabled: true
         }
     });

     /* -------------------------------------------------------------------------*
      * MASONRY
      * -------------------------------------------------------------------------*/
     var $container = $('.grid').masonry({
         itemSelector: '.masonry-item',
     });

     /* -------------------------------------------------------------------------*
      * MASONRY BLOG LINK NUDGING
      * -------------------------------------------------------------------------*/
     $('.masonry-item a.more').hover(function() { //mouse in
         $(this).animate({
             paddingLeft: '30px'
         }, 400);
     }, function() { //mouse out
         $(this).animate({
             paddingLeft: 15
         }, 400);
     });

     /* -------------------------------------------------------------------------*
      * SCROLL BAR
      * -------------------------------------------------------------------------*/
     var seq = 0;
     $("html").niceScroll({
         styler: "fb",
         cursorcolor: "#e74c3c"
     });
     $(window).load(function() {
         setTimeout(function() {
             $("#gmbox div").animate({
                 'top': 60
             }, 1500, "easeOutElastic");
         }, 1500);
     });

     /* -------------------------------------------------------------------------*
      * WOW ANIMATION
      * -------------------------------------------------------------------------*/
     new WOW().init();

     /* -------------------------------------------------------------------------*
      * CALENDAR
      * -------------------------------------------------------------------------*/
     
     
     /* -------------------------------------------------------------------------*
      * SETTING DATE AND TIME
      * -------------------------------------------------------------------------*/
     var datetime = null,
         date = null;
     var update = function() {
         date = moment(new Date())
         datetime.html(date.format('dddd, D MMMM  YYYY, h:mm:ss a'));
     };
     datetime = $('#time-date')
     update();
     setInterval(update, 1000);

     /* -------------------------------------------------------------------------*
      * STYLE SWITCHER
      * -------------------------------------------------------------------------*/
     $('#switcher').styleSwitcher({
         useCookie: true
     });

     /* -------------------------------------------------------------------------*
      * SEARCH BAR
      * -------------------------------------------------------------------------*/
     // Hide search wrap by default;
     $(".search-container").hide();
     $(".toggle-search").on("click", function(e) {
         // Prevent default link behavior
         e.preventDefault();
         // Stop propagation
         e.stopPropagation();
         // Toggle search-wrap
         $(".search-container").slideToggle(500, function() {
             // Focus on the search bar
             // When animation is complete
             $("#search-bar").focus();
         });
     });
     // Close the search bar if user clicks anywhere
     $(document).click(function(e) {
         var searchWrap = $(".search-container");
         if (!searchWrap.is(e.target) && searchWrap.has(e.target).length ===
             0) {
             searchWrap.slideUp(500);
         }
     });

     /* -------------------------------------------------------------------------*
      * ADDING SLIDE UP AND ANIMATION TO DROPDOWN
      * -------------------------------------------------------------------------*/
     enquire.register("screen and (min-width:767px)", {

         match: function() {
             $(".dropdown").hover(function() {
                 $('.dropdown-menu', this).stop().fadeIn("slow");
             }, function() {
                 $('.dropdown-menu', this).stop().fadeOut("slow");
             });
         },
     });

     /* -------------------------------------------------------------------------*
      * DROPDOWN LINK NUDGING
      * -------------------------------------------------------------------------*/
     $('.dropdown-menu a').hover(function() { //mouse in
         $(this).animate({
             paddingLeft: '30px'
         }, 400);
     }, function() { //mouse out
         $(this).animate({
             paddingLeft: 20
         }, 400);
     });

     /* -------------------------------------------------------------------------*
      * STICKY NAVIGATION
      * -------------------------------------------------------------------------*/
     $(window).scroll(function() {
         if ($(window).scrollTop() >= 99) {
             $('.nav-search-outer').addClass('navbar-fixed-top');
         }


         if ($(window).scrollTop() >= 100) {
             $('.nav-search-outer').addClass('show');
         } else {
             $('.nav-search-outer').removeClass('show navbar-fixed-top');
         }
     });


     /* -------------------------------------------------------------------------*
      * HOT NEWS
      * -------------------------------------------------------------------------*/
     $('#js-news').ticker();
     // hide the release history when the page loads
     $('#release-wrapper').css('margin-top', '-' + ($('#release-wrapper').height() +
         20) + 'px');
     // show/hide the release history on click
     $('a[href="#release-history"]').toggle(function() {
         $('#release-wrapper').animate({
             marginTop: '0px'
         }, 600, 'linear');
     }, function() {
         $('#release-wrapper').animate({
             marginTop: '-' + ($('#release-wrapper').height() + 20) +
                 'px'
         }, 600, 'linear');
     });
     $('#download a').mousedown(function() {
         _gaq.push(['_trackEvent', 'download-button', 'clicked'])
     });

     /* -------------------------------------------------------------------------*
      * OWL CAROUSEL
      * -------------------------------------------------------------------------*/
     $("#banner-thumbs").owlCarousel({
         autoPlay: true, //Set AutoPlay to 3 seconds
         navigation: false,
         stopOnHover: true,
         pagination: false,
         items: 4,
         itemsDesktop: [1199,
             4
         ],
         itemsDesktopSmall: [
             979, 3
         ],
         itemsTablet: [768, 3],
         itemsMobile: [479, 1],

     });

     $("#vid-thumbs").owlCarousel({
         navigation: false,
         pagination: true,
         slideSpeed: 300,
         paginationSpeed: 400,
         singleItem: true,
     });
     $("#owl-lifestyle").owlCarousel({
         autoPlay: false, //Set AutoPlay to 3 seconds
         navigation: true,
         pagination: false,
         items: 3,
         itemsDesktop: [1199,
             3
         ],
         itemsDesktopSmall: [
             979, 2
         ],
         itemsTablet: [768, 2],
         itemsMobile: [479, 1],
     });
     $("#owl-blog").owlCarousel({
         navigation: true,
         pagination: false,
         slideSpeed: 300,
         paginationSpeed: 400,
         singleItem: true,
     });

     var time = 4; // time in seconds
     var $progressBar,
         $bar,
         $elem,
         isPause,
         tick,
         percentTime;
     var sync1 = $("#sync1");
     var sync2 = $("#sync2");
     sync1.owlCarousel({
         singleItem: true,
         slideSpeed: 1000,
         navigation: true,
         pagination: false,
         transitionStyle: "fadeUp",
         afterAction: syncPosition,
         responsiveRefreshRate: 200,
         afterInit: progressBar,
         afterMove: moved,
         startDragging: pauseOnDragging
     });
     sync2.owlCarousel({
         items: 4,
         itemsDesktop: [1199,
             4
         ],
         itemsDesktopSmall: [
             979, 3
         ],
         itemsTablet: [768, 3],
         itemsMobile: [479, 3],
         pagination: false,
         responsiveRefreshRate: 100,
         afterInit: function(el) {
             el.find(".owl-item").eq(0).addClass("synced");
         }
     });

     function syncPosition(el) {
         var current = this.currentItem;
         $("#sync2").find(".owl-item").removeClass("synced").eq(current).addClass(
             "synced")
         if ($("#sync2").data("owlCarousel") !== undefined) {
             center(current)
         }
     }
     $("#sync2").on("click", ".owl-item", function(e) {
         e.preventDefault();
         var number = $(this).data("owlItem");
         sync1.trigger("owl.goTo", number);
     });

     function center(number) {
         var sync2visible = sync2.data("owlCarousel").owl.visibleItems;
         var num = number;
         var found = false;
         for (var i in sync2visible) {
             if (num === sync2visible[i]) {
                 var found = true;
             }
         }
         if (found === false) {
             if (num > sync2visible[sync2visible.length - 1]) {
                 sync2.trigger("owl.goTo", num - sync2visible.length + 2)
             } else {
                 if (num - 1 === -1) {
                     num = 0;
                 }
                 sync2.trigger("owl.goTo", num);
             }
         } else if (num === sync2visible[sync2visible.length - 1]) {
             sync2.trigger("owl.goTo", sync2visible[1])
         } else if (num === sync2visible[0]) {
             sync2.trigger("owl.goTo", num - 1)
         }
     }
     //Init progressBar where elem is $("#owl-demo")
     function progressBar(elem) {
         $elem = elem;
         //build progress bar elements
         buildProgressBar();
         //start counting
         start();
     }
     //create div#progressBar and div#bar then prepend to $("#owl-demo")
     function buildProgressBar() {
         $progressBar = $("<div>", {
             id: "progressBar"
         });
         $bar = $("<div>", {
             id: "bar"
         });
         $progressBar.append($bar).prependTo($elem);
     }

     function start() {
         //reset timer
         percentTime = 0;
         isPause = false;
         //run interval every 0.01 second
         tick = setInterval(interval, 10);
     };

     function interval() {
         if (isPause === false) {
             percentTime += 1 / time;
             $bar.css({
                 width: percentTime + "%"
             });
             //if percentTime is equal or greater than 100
             if (percentTime >= 100) {
                 //slide to next item
                 $elem.trigger('owl.next')
             }
         }
     }
     //pause while dragging
     function pauseOnDragging() {
         isPause = true;
     }
     //moved callback
     function moved() {
         //clear interval
         clearTimeout(tick);
         //start again
         start();
     }
     jQuery($elem).on('mouseover', function() {
         isPause = true;
     });

     jQuery($elem).on('mouseout', function() {
         isPause = false;
     });

 });

 /* -------------------------------------------------------------------------*
  * WEATHER
  * -------------------------------------------------------------------------*/
 $.simpleWeather({
     location: '',
     woeid: '1521894',
     unit: 'c',
     success: function(weather) {
         html = '<i class="icon-' + weather.code + '"></i> ' + weather.city +
             ', ' + weather.region + ' ' + weather.temp + '&deg;' +
             weather.units.temp + ' ';
         $("#weather").html(html);
     },
     error: function(error) {
         $("#weather").html('<p>' + error + '</p>');
     }
 });