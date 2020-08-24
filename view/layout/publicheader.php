<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title><?= SITE_NAME ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<!--[if ie]><meta content='IE=8' http-equiv='X-UA-Compatible'/><![endif]-->
		<!-- bootstrap -->
		<link href="<?php echo SRC_URL ?>css/bootstrap.min.css" rel="stylesheet">      
		<link href="<?php echo SRC_URL ?>css/bootstrap-responsive.min.css" rel="stylesheet">		
		<link href="<?php echo SRC_URL ?>css/bootstrappage.css" rel="stylesheet"/>
		<link rel="stylesheet" href="<?php echo SRC_URL ?>css/font-awesome.css">
                <!-- Ionicons -->
                <link rel="stylesheet" href="<?php echo SRC_URL ?>css/ionicons.min.css">
		<!-- global styles -->
		<link href="<?php echo SRC_URL ?>css/flexslider.css" rel="stylesheet"/>
		<link href="<?php echo SRC_URL ?>css/main.css" rel="stylesheet"/>
                <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
                <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
                <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
                <link rel="manifest" href="/site.webmanifest">
		<!-- scripts -->
		<script src="<?php echo SRC_URL ?>js/jquery-1.7.2.min.js"></script>
		<script src="<?php echo SRC_URL ?>js/bootstrap.min.js"></script>				
		<script src="<?php echo SRC_URL ?>js/superfish.js"></script>	
		<script src="<?php echo SRC_URL ?>js/basic.js"></script>	
		<script src="<?php echo SRC_URL ?>js/jquery.scrolltotop.js"></script>
                <style>
                    #top-bar{
                        position: sticky;
                        top: 0;
                        z-index: 9999;
                        padding-bottom: 0;
                            /* background: #242424; */
                        background-color: #242424;
                        background-image: linear-gradient(#199450, #333);
                    }
                    section.navbar{
                        position: sticky;
                        top: 51;
                    }
                    .navbar-inner{
                        margin-top: 7px;
                        padding-top: 7px;
                        border-top: 1px solid #ddd!important;
                    }
                    li a.current{
                        color: #62c462;
                    }
                    .user-menu a{
                        color: #fff;
                    }
                </style>

	</head>
    <body>		
		<div id="top-bar" class="container">
			<div class="row">
				<div class="span4">
                                    <form method="POST" class="search_form" action=" <?= PUBLIC_URL ?>product">
                                            <div class=" form-group" style=" display: flex">
                                                <input type="text" style="color: #000" class="input-block-level search-query" name="keyword" Placeholder="eg. hemp oil " required>
                                                <button type="submit" class=" btn" style="border-radius: 17px;"><i class="fa fa-search"></i></button>
                                            </div> 
					</form>
				</div>
				<div class="span8">
					<div class="account pull-right">
						<ul class="user-menu">				
							<li><a href="<?= BASE_URL ?>">Home</a></li>
							<li><a href="<?= PUBLIC_URL."contact" ?>">Contact Us</a></li>
							<li><a href="<?= PUBLIC_URL."about" ?>">About Us</a></li>			
						</ul>
					</div>
				</div>
                            
			</div>
                    			<section class="navbar main-menu">
				<div class="navbar-inner main-menu">				
					<a href="<?= BASE_URL ?>" class="logo pull-left">
                                            <img style="height: 41px;" src="<?php echo SRC_URL ?>images/logo.png" class="site_logo" alt="">
                                        </a>
					<nav id="menu" class="pull-right">
						<ul>
							<li><a href="#">Shop</a>					
                                                            <?php
                                                            echo $this->getCatList("","",$selected);
                                                            ?>
							</li>															
                                                        <li><a href="<?= PUBLIC_URL."product/". urlencode("Best Seller") ?>">Best Seller</a></li>
							<li><a href="<?= PUBLIC_URL."product/". urlencode("Top Seller") ?>">Top Seller</a></li>
						</ul>
					</nav>
				</div>
			</section>
		</div>
		<div id="wrapper" class="container">
	