<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <!-- Meta Tags -->
        <meta charset="utf-8">
        <title><?= SITE_NAME ?> | <?= SUBTITLE ?></title>
        <meta name="description" content="">
        <meta name="author" content="iSeada.com">
        <!-- Mobile Meta -->
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
        <!-- Main Stylesheet -->
        <link rel="stylesheet" href="<?= SRC_URL ?>css/style.css">
        <!-- Responsiveness -->
        <link rel="stylesheet" href="<?= SRC_URL ?>css/responsive.css">
        <!-- FAV & Touch Icons -->
        <link rel="shortcut icon" href="<?= SRC_URL ?>img/icons/favicon.ico">
        <link rel="apple-touch-icon" href="<?= SRC_URL ?>img/icons/apple-touch-icon.png">
        <link rel="apple-touch-icon" sizes="72x72" href="<?= SRC_URL ?>img/icons/apple-touch-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="114x114" href="<?= SRC_URL ?>img/icons/apple-touch-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="144x144" href="<?= SRC_URL ?>img/icons/apple-touch-icon-144x144.png">
        <!--[if lt IE 9]>
            <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
            <script>window.html5 || document.write('<script src="<?= SRC_URL ?>js/vendor/html5shiv.js"><\/script>')</script>
        <![endif]-->
    </head>
    <body>
        <div id="entire">
            <div class="loader"></div>
            <div class="top-bar clearfix">
                <div class="container">
                    <div class="fl top-social-icons">
                        <ul class="clearfix">
                            <li><a href="#" class="fb-icon ln-tr"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#" class="tw-icon ln-tr"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#" class="in-icon ln-tr"><i class="fa fa-linkedin"></i></a></li>
                        </ul>
                    </div><!-- End Social Container -->
                    <div class="fr top-contact">
                        <ul class="clearfix">
                            <li class="fl"><i class="fa fa-phone"></i><span class="text">Call Us: +2 01065370701</span></li>
                            <li class="fl divider"><span>&#124;</span></li>
                            <li class="fl"><i class="fa fa-envelope"></i><span class="text">Email Us: <a href="mailto:johnsmith@gmail.com">johnsmith@gmail.com</a></span></li>
                        </ul>
                    </div><!-- End Top Contact -->
                </div>
            </div><!-- End Tob Bar -->
            <header class="alt static-header">
                <div class="container">
                    <div class="logo-container fl clearfix">
                        <a href="#" class="ib">

                           <span class="site-name"><img src="<?= SRC_URL ?>img/logo@2x.jpg" class="fl" alt="Logo"><span>.in</span></span>
                        </a>
                    </div><!-- End Logo Container -->
                    <?php include __DIR__.'/../menu/usermenu.php'; ?>
                </div>
            </header><!-- End Main Header Container -->
