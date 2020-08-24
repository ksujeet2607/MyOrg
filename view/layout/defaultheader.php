<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <!-- Meta Tags -->
        <meta charset="utf-8">
        <title><?= (self::$metatags->title!="")?self::$metatags->title:SITE_NAME." | ".SUBTITLE ?></title>
        <meta name="description" content="<?= self::$metatags->descrp ?>">
        <meta name="keywords" content="<?= self::$metatags->keyword ?>">
        <?php
        if(count(self::$metaprop)>0){
          foreach (self::$metaprop as $key => $value) {
            echo '<meta '.$value['type'].'="'.$value['p_value'].'" content="'.$value['contect'].'">';
          }
        }
         ?>
        <!-- Mobile Meta -->
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
        <!-- Main Stylesheet -->
        <link rel="stylesheet" href="<?= SRC_URL ?>css/style.css">
        <!-- Responsiveness -->
        <link rel="stylesheet" href="<?= SRC_URL ?>css/responsive.css">
        <!-- FAV & Touch Icons -->
        <link rel="apple-touch-icon" sizes="180x180" href="<?= SRC_URL ?>img/icons/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="<?= SRC_URL ?>img/icons/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="<?= SRC_URL ?>img/icons/favicon-16x16.png">
        <link rel="manifest" href="/site.webmanifest">
        <!--[if lt IE 9]>
            <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
            <script>window.html5 || document.write('<script src="<?= SRC_URL ?>js/vendor/html5shiv.js"><\/script>')</script>
        <![endif]-->
    </head>
    <body id="home-8" class="onepage">
        <div id="entire">
            <div class="loader"></div>
            <div class="tp-banner-container">
                <div class="fullscreen">
                    <ul>
                        <li data-transition="random" data-slotamount="7" data-masterspeed="1500">
                            <!-- MAIN IMAGE -->
                            <img src="<?= SRC_URL ?>img/slider1.jpg" alt="slidebg1" data-bgfit="cover" data-bgposition="left top"  data-bgrepeat="no-repeat">
                            <!-- LAYERS -->
                            <!-- LAYER NR. 1 -->
                            <div class="tp-caption lft skewtoleft tp-resizeme start white"
                                data-y="210"
                                data-x="center"
                                data-hoffset="0"
                                data-start="300"
                                data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
                                data-speed="500"
                                data-easing="Power3.easeInOut"
                                data-endspeed="300"
                                style="z-index: 2">
<!--                                <h2 class="slide-title">A new company with new ideas and approach!</h2>-->
                            </div>
                            <!-- LAYER NR. 2 -->
                            <div class="tp-caption black randomrotate skewtoleft tp-resizeme start"
                                data-x="center"
                                data-hoffset="0"
                                data-y="240"
                                data-speed="500"
                                data-start="1300"
                                data-easing="Power3.easeInOut"
                                data-splitin="none"
                                data-splitout="none"
                                data-elementdelay="0.1"
                                data-endelementdelay="0.1"
                                data-endspeed="500" style="z-index: 99; white-space: pre-line;">
<!--                                <p class="slide-description">We belive in Affordable Affective Approach to deviler best product to our client.</p>-->
                            </div>
                        </li><!-- end 1st slide -->
                        <li data-transition="random" data-slotamount="7" data-masterspeed="1000">
<!--                             MAIN IMAGE -->
                            <img src="<?= SRC_URL ?>img/slider2.jpg" alt="slidebg1" data-bgfit="cover" data-bgposition="left top" data-bgrepeat="no-repeat">
<!--                             LAYERS
                             LAYER NR. 1 -->
                            <div class="tp-caption lft skewtoleft tp-resizeme start white"
                                data-y="210"
                                data-x="center"
                                data-hoffset="0"
                                data-start="300"
                                data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
                                data-speed="500"
                                data-easing="Power3.easeInOut"
                                data-endspeed="300"
                                style="z-index: 2">
<!--                                <h2 class="slide-title">We Help You To Get What You Want!</h2>-->
                            </div>
<!--                             LAYER NR. 2 -->
                            <div class="tp-caption black randomrotate skewtoleft tp-resizeme start"
                                data-x="center"
                                data-hoffset="0"
                                data-y="240"
                                data-speed="500"
                                data-start="1300"
                                data-easing="Power3.easeInOut"
                                data-splitin="none"
                                data-splitout="none"
                                data-elementdelay="0.1"
                                data-endelementdelay="0.1"
                                data-endspeed="500" style="z-index: 99; white-space: pre-line;">
<!--                                <p class="slide-description">Every professional wants his/her own identity into the virtual world. The best way is to have our own virtual world. Let the world visit to you. </p>-->
                            </div>
                        </li>
                        <li data-transition="random" data-slotamount="7" data-masterspeed="1500">

                            <img src="<?= SRC_URL ?>img/slider3.jpg" alt="slidebg1" data-bgfit="cover" data-bgposition="left top" data-bgrepeat="no-repeat">

                            <div class="tp-caption lft skewtoleft tp-resizeme start white"
                                data-y="210"
                                data-x="center"
                                data-hoffset="0"
                                data-start="300"
                                data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
                                data-speed="500"
                                data-easing="Power3.easeInOut"
                                data-endspeed="300"
                                style="z-index: 2">
<!--                                <h2 class="slide-title">Let us to build your profession in virtual world!</h2>-->
                            </div>

                            <div class="tp-caption black randomrotate skewtoleft tp-resizeme start"
                                data-x="center"
                                data-hoffset="0"
                                data-y="240"
                                data-speed="500"
                                data-start="1300"
                                data-easing="Power3.easeInOut"
                                data-splitin="none"
                                data-splitout="none"
                                data-elementdelay="0.1"
                                data-endelementdelay="0.1"
                                data-endspeed="500" style="z-index: 99; white-space: pre-line;">
<!--                                <p class="slide-description">We will provide you the best product, within a time schedule.</p>-->
                            </div>
                        </li>
                    </ul><!-- end ul elements -->
                    <div class="scroll-down">
                        <a href="#header">
                            <span>Scroll Down</span>
                            <i class="fa fa-angle-double-down"></i>
                        </a>
                    </div><!-- End Scroll Down -->
                </div><!-- end tp-banner -->
            </div><!-- End Home Slider Container -->

            <header id="header" class="alt static-header">
                <div class="container">
                    <div class="logo-container fl clearfix">
                        <a href="<?= PUBLIC_URL ?>" class="ib">
                            <span class="site-name"><img src="<?= SRC_URL ?>img/logo@2x.jpg" class="fl" alt="Logo"><span>.in</span></span>
                        </a>
                    </div><!-- End Logo Container -->
                    <?php include __DIR__.'/../menu/usermenu.php'; ?>
                </div>
            </header><!-- End Main Header Container -->

            <div class="clearfix"></div>
