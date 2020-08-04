<div class="clearfix"></div>

            <footer id="footer">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="widget about-widget">
                                <h6 class="widget-title">About <?= SITE_NAME ?></h6>
                                <p class="about-text">
                                  We are dedicated to give optimized and cost effective product within a scheduled time, We have a very skilled, enthusiastic and experienced team to develop high quality product.
                                </p>
                                <div class="footer-links">
                                    <ul>
                                        <li><a href="<?= PUBLIC_URL ?>about" class="ln-tr">About Us</a></li>
                                        <li><a href="#" class="ln-tr">Meet Our Team</a></li>
                                        <li><a href="<?= PUBLIC_URL ?>contact" class="ln-tr">Contact Us</a></li>
                                    </ul>
                                </div><!-- End Footer Links -->
                            </div><!-- End About Widget -->
                        </div><!-- End col-md3 -->
                        <div class="col-md-2">
                            <div class="widget links-widget">
                                <h6 class="widget-title">Quick Links</h6>
                                <div class="footer-links">
                                    <ul>
                                        <li><a href="#" class="ln-tr">Help</a></li>
                                        <li><a href="#" class="ln-tr">Sitemap</a></li>
                                        <li><a href="#" class="ln-tr">Mobile</a></li>
                                        <li><a href="#" class="ln-tr">Privacy Policy</a></li>
                                        <li><a href="#" class="ln-tr">Support</a></li>
                                        <li><a href="#" class="ln-tr">Careers</a></li>
                                        <li><a href="#" class="ln-tr">Instructors</a></li>
                                    </ul>
                                </div><!-- End Footer Links -->
                            </div><!-- End Links Widget -->
                        </div><!-- End col-md2 -->
                        <div class="col-md-6">
                            <div class="widget about-widget">
                                <h6 class="widget-title">Give Us A Feedback</h6>
                                <p class="about-text" style=" margin-bottom: 0;">
                                  Give us your valueable feedback. Let us know your thoughts about us and help us to improve our services.
                                </p>
                                <div class="contact-left">
                                    <div class="contact-form">
                                        <form method="post" action="" id="contact-form">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="input">
                                                        <input type="text" id="name" class="name-input" placeholder="Your Name">
                                                    </div>
                                                </div><!-- end name -->

                                                <div class="col-md-6">
                                                    <div class="input">
                                                        <input type="text" id="tel" class="tel-input" placeholder="Phone">
                                                    </div>
                                                </div><!-- end phone -->
                                                <div class="col-md-12">
                                                    <div class="input">
                                                        <input type="email" id="email" class="email-input" placeholder="Email">
                                                    </div>
                                                </div><!-- end email -->
                                                <div class="col-md-12">
                                                    <div class="input">
                                                        <textarea name="comment-area" id="comment-area" placeholder="Comment"></textarea>
                                                        <input type="submit" id="comment-submit" class="submit-input grad-btn ln-tr" value="Send">
                                                    </div>
                                                </div>
                                            </div><!-- end row -->
                                        </form><!-- end form tag -->
                                    </div><!-- end contact form -->
                                </div><!-- End contact left -->
                            </div><!-- End About Widget -->
                        </div><!-- End col-md3 -->
                    </div>
                </div>
                <div id="bottom">
                    <div class="container">
                        <div class="fl copyright">
                            <p>All Rights Reserved &copy; <?= SITE_NAME ?> <?= date("Y") ?></p>
                        </div><!-- End Copyright -->
                        <div class="fr footer-social-icons">
                            <ul class="clearfix">
                                <li><a href="#" class="fb-icon ln-tr"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="#" class="tw-icon ln-tr"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="#" class="in-icon ln-tr"><i class="fa fa-linkedin"></i></a></li>
                            </ul>
                        </div><!-- End Social Media Icons -->
                    </div><!-- End container -->
                </div><!-- End Bottom Footer -->
            </footer><!-- End Footer -->
        </div><!-- End Entire Wrap -->

        <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog container">
                <div class="popup-content">
                    <div class="login-page">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="login-form">
                                    <div class="login-title">
                                        <span class="icon"><i class="fa fa-group"></i></span>
                                        <span class="text">Login Area</span>
                                        <a href="#" class="close-modal fr" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true"><i class="fa fa-close"></i></span>
                                        </a>
                                    </div><!-- End Title -->
                                    <form method="post" action="/" id="login-form">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6">
                                                <div class="input">
                                                    <input type="text" id="login_username" class="username-input" placeholder="User Name">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="input">
                                                    <input type="password" id="login_password" class="password-input" placeholder="Password">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="input clearfix">
                                                    <input type="submit" id="login_submit" class="submit-input grad-btn ln-tr" value="Login">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6 clearfix">
                                                <div class="custom-checkbox fl">
                                                    <input type="checkbox" id="login_remember" class="checkbox-input" checked>
                                                    <label for="login_remember">Remember Password</label>
                                                </div>
                                            </div><!-- end remember -->
                                            <div class="col-md-6 col-sm-6 clearfix">
                                                <div class="forgot fr">
                                                    <a href="#" class="new-user">Create New Account</a> / <a href="#" class="reset">Forget Password ?</a>
                                                </div>
                                            </div><!-- end forgot password -->
                                        </div><!-- end row -->
                                    </form><!-- End form -->
                                </div><!-- end login form -->
                                <div class="login-options">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                            <a href="#" class="login-op-btn grad-btn ln-tr fb">Login with Facebook Account</a>
                                        </div><!-- end FB login -->
                                        <div class="col-md-6 col-sm-6">
                                            <a href="#" class="login-op-btn grad-btn ln-tr gp">Login with Google Account</a>
                                        </div><!-- end GP login -->
                                        <div class="col-md-6 col-sm-6">
                                            <a href="#" class="login-op-btn grad-btn ln-tr tw">Login with Twitter Account</a>
                                        </div><!-- end TW login -->
                                        <div class="col-md-6 col-sm-6">
                                            <a href="#" class="login-op-btn grad-btn ln-tr ya">Login with Yahoo Account</a>
                                        </div><!-- end YA login -->
                                    </div>
                                </div><!-- end login optionss -->
                            </div><!-- end col-md-12 -->
                        </div><!-- end row -->
                    </div><!-- End Login Page -->
                </div><!-- End Modal Content -->
            </div><!-- End Dialog -->
        </div><!-- End Login Modal -->

        <div class="modal fade" id="register-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog container">
                <div class="popup-content">
                    <div class="login-page">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="login-form register">
                                    <div class="login-title">
                                        <span class="icon"><i class="fa fa-group"></i></span>
                                        <span class="text">Register</span>
                                        <a href="#" class="close-modal fr" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true"><i class="fa fa-close"></i></span>
                                        </a>
                                    </div><!-- End Title -->
                                    <form method="post" action="/" id="register-form">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6">
                                                <div class="input">
                                                    <input type="text" id="reg_username" class="username-input" placeholder="User Name">
                                                </div>
                                            </div><!-- end username -->
                                            <div class="col-md-6 col-sm-6">
                                                <div class="input">
                                                    <input type="email" id="reg_email" class="email-input" placeholder="Email">
                                                </div>
                                            </div><!-- end email -->
                                            <div class="col-md-6 col-sm-6">
                                                <div class="input">
                                                    <input type="password" id="reg_password" class="password-input" placeholder="Password">
                                                </div>
                                            </div><!-- end password -->
                                            <div class="col-md-6 col-sm-6">
                                                <div class="input">
                                                    <input type="password" id="reg_confirm-password" class="confirm-password-input" placeholder="Confirm Password">
                                                </div>
                                            </div><!-- end confirm password -->
                                            <div class="col-md-12">
                                                <div class="input clearfix">
                                                    <input type="submit" id="reg_submit" class="submit-input grad-btn ln-tr" value="Login">
                                                </div>
                                            </div><!-- end submit -->
                                        </div><!-- end row -->
                                    </form><!-- End form -->
                                </div><!-- end login form -->
                                <div class="login-options">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                            <a href="#" class="login-op-btn grad-btn ln-tr fb">Login with Facebook Account</a>
                                        </div><!-- end FB login -->
                                        <div class="col-md-6 col-sm-6">
                                            <a href="#" class="login-op-btn grad-btn ln-tr gp">Login with Google Account</a>
                                        </div><!-- end GP login -->
                                        <div class="col-md-6 col-sm-6">
                                            <a href="#" class="login-op-btn grad-btn ln-tr tw">Login with Twitter Account</a>
                                        </div><!-- end TW login -->
                                        <div class="col-md-6 col-sm-6">
                                            <a href="#" class="login-op-btn grad-btn ln-tr ya">Login with Yahoo Account</a>
                                        </div><!-- end YA login -->
                                    </div>
                                </div><!-- end login optionss -->
                            </div><!-- end col-md-8/offset -->
                        </div><!-- end row -->
                    </div><!-- End Register Page -->
                </div><!-- End Modal Content -->
            </div><!-- End Dialog -->
        </div><!-- End Register Modal -->
        <!-- jQuery -->
        <script src="<?= SRC_URL ?>js/vendor/jquery-1.11.2.min.js"></script>
        <!-- Plugins -->
        <script src="<?= SRC_URL ?>js/bsmodal.min.js"></script>
        <script src="<?= SRC_URL ?>js/jquery.countdown.min.js"></script>
        <script src="<?= SRC_URL ?>js/jquery.easydropdown.min.js"></script>
        <script src="<?= SRC_URL ?>js/jquery.flexslider-min.js"></script>
        <script src="<?= SRC_URL ?>js/jquery.isotope.min.js"></script>
        <script src="<?= SRC_URL ?>js/jquery.themepunch.tools.min.js"></script>
        <script src="<?= SRC_URL ?>js/jquery.themepunch.revolution.min.js"></script>
        <script src="<?= SRC_URL ?>js/jquery.viewportchecker.min.js"></script>
        <script src="<?= SRC_URL ?>js/jquery.waypoints.min.js"></script>
        <script src="<?= SRC_URL ?>js/scripts.js"></script>
        <script>
            $(document).ready(function(){
              $(document).on('ready', function(event) {
                var ele = document.querySelector(".scroll-down a");
                if (ele.hash !== "") {
                  event.preventDefault();
                  var hash = ele.hash;
                  $('html, body').animate({
                    scrollTop: $(hash).offset().top
                  }, 2200, function(){
                    window.location.hash = hash;
                  });
                }
              });
            });
        </script>
    </body>
</html>
