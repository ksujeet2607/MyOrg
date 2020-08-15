

            <div class="inner-head">
                <div class="container">
                    <h1 class="entry-title">We Wanna Hear From You!</h1>
                    <p class="description">
                      
                    </p>
                    <div class="breadcrumb">
                        <ul class="clearfix">
                            <li class="ib"><a href="<?= PUBLIC_URL ?>">Home</a></li>
                            <li class="ib current-page"><a href="">Contact Us</a></li>
                        </ul>
                    </div>
                </div><!-- End container -->
            </div><!-- End Inner Page Head -->

            <div class="clearfix"></div>

            <article class="contact fadeInDown-animation">

                <div class="contact-container container">
                    <div class="row">
                      <div class="content-header col-md-12"></div>
                        <div class="col-md-8">
                            <div class="contact-left">
                                <span class="contact-form-icon"><i class="fa fa-envelope"></i></span>
                                <h5 class="contact-title ib">Contact Form</h5>
                                <div class="contact-text">
                                    <p>
                                      We are ready to help you. Let us know what are your requirements. There is no challenge that we can't overcome!
                                    </p>
                                </div><!-- End text -->
                                <div class="contact-form">
                                    <form method="post" action="<?= PUBLIC_URL ?>send-enquiry" id="contact-form">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="input">
                                                    <input type="text" id="name" name="fname" class="name-input" placeholder="Your Name" required>
                                                </div>
                                            </div><!-- end name -->
                                            <div class="col-md-6">
                                                <div class="input">
                                                    <input type="email" id="email" name="email" maxlength="100" class="email-input" placeholder="Email">
                                                </div>
                                            </div><!-- end email -->
                                            <div class="col-md-6">
                                                <div class="input">
                                                    <input type="text" id="tel" name="mobile" maxlength="12" minlength="10"  class="tel-input" placeholder="Phone" required>
                                                </div>
                                            </div><!-- end phone -->
                                            <div class="col-md-6">
                                                <div class="input">
                                                    <input type="text" id="subject" name="subject" class="subject-input" placeholder="Subject" required>
                                                </div>
                                            </div><!-- end phone -->
                                            <div class="col-md-12">
                                                <div class="input">
                                                    <textarea name="msg"  id="comment-area" placeholder="Comment" required></textarea>
                                                    <input type="submit" id="comment-submit" class="submit-input grad-btn ln-tr" value="Send">
                                                </div>
                                            </div>
                                        </div><!-- end row -->
                                    </form><!-- end form tag -->
                                </div><!-- end contact form -->
                            </div><!-- End contact left -->
                        </div><!-- end col-md-8 -->
                        <div class="col-md-4">
                            <div class="contact-right sidebar">
                                <div class="sidebar-widget contact-info">
                                    <span class="widget-icon"><i class="fa fa-book"></i></span>
                                    <h5 class="sidebar-widget-title ib">Contact Information</h5>
                                    <div class="info-text">
                                        <p>
                                          You can call or email us on below  given details  :
                                        </p>
                                    </div><!-- end text info -->
                                    <div class="call">
                                        <p>Mobile : <?= CONTACT ?></p>
                                        <p>Mobile : <?= CONTACT_NO ?></p>
                                        <p>Email : <?= EMAIL_FROM ?></p>
                                    </div><!-- end call info -->
                                </div><!-- end 1st block -->
                                <div class="sidebar-widget follow-us">
                                    <span class="widget-icon"><i class="fa fa-share-alt"></i></span>
                                    <h5 class="sidebar-widget-title ib">Follow US</h5>
                                    <div class="follow-icons clearfix">
                                        <div class="icons">
                                            <ul class="clearfix">
                                                <li><a href="https://www.facebook.com/TechNets-101201801686846" target="_blank" class="fb-icon ln-tr"><i class="fa fa-facebook"></i></a></li>
                                                <li><a href="https://twitter.com/technets8" target="_blank" class="tw-icon ln-tr"><i class="fa fa-twitter"></i></a></li>
                                                <li><a href="https://www.linkedin.com/in/technets-in-46a5a11b3/" target="_blank" class="in-icon ln-tr"><i class="fa fa-linkedin"></i></a></li>
                                            </ul>
                                        </div>
                                    </div><!-- end social icons -->
                                </div><!-- end 2nd block -->
                            </div><!-- End contact right -->
                        </div><!-- end col-md-4 -->
                    </div><!-- end row -->
                </div><!-- end contact container -->
            </article><!-- End Single Article -->

            <div class="clearfix"></div>
