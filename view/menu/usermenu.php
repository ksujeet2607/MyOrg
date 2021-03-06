                    <nav class="main-navigation fr">
                        <ul class="clearfix">
                            <li class="parent-item <?= (mb_strtolower(User::$menu) == 'index')?"current_page_item":"" ?>">
                                <a href="<?= BASE_URL ?>" class="ln-tr">Home</a>
                            </li>
                            <li class="parent-item haschild <?= (mb_strtolower(User::$menu) == 'services')?"current_page_item":"" ?> courses-menu">
                                <a href="#" class="ln-tr">Services</a>
                                <ul class="clearfix">
                                    <li class="course-menu-item col-md-3 col-sm-4">
                                        <div class="single-item">
                                            <span class="item-icon"><img src="<?= SRC_URL ?>img/icon1.png" class="services_img" alt="" style=""></span>
                                            <a href="<?= PUBLIC_URL ?>web-development" class="ln-tr link">Web Development</a>
                                        </div>
                                    </li><!-- end course menu item -->
                                    <li class="course-menu-item col-md-3 col-sm-4">
                                        <div class="single-item">
                                            <span class="item-icon"><img src="<?= SRC_URL ?>img/icon6.png" class="services_img" alt="" style=""></span>
                                            <a href="<?= PUBLIC_URL ?>mobile-application" class="ln-tr link">Mobile Application</a>
                                        </div>
                                    </li><!-- end course menu item -->
                                    <li class="course-menu-item col-md-3 col-sm-4">
                                        <div class="single-item">
                                            <span class="item-icon"><img src="<?= SRC_URL ?>img/icon5.png" class="services_img" alt="" style=""></span>
                                            <a href="<?= PUBLIC_URL ?>e-commerse-services" class="ln-tr link">E-commerse</a>
                                        </div>
                                    </li><!-- end course menu item -->
                                    <li class="course-menu-item col-md-3 col-sm-4">
                                        <div class="single-item">
                                            <span class="item-icon"><img src="<?= SRC_URL ?>img/icon4.png" class="services_img" alt="" style=""></span>
                                            <a href="<?= PUBLIC_URL ?>domain-hosting" class="ln-tr link">Domain / Hosting</a>
                                        </div>
                                    </li>
                                    <li class="course-menu-item col-md-3 col-sm-4">
                                        <div class="single-item">
                                            <span class="item-icon"><img src="<?= SRC_URL ?>img/icon8.png" class="services_img" alt="" style=""></span>
                                            <a href="<?= PUBLIC_URL ?>ui-xi-design" class="ln-tr link">UI / XI Design</a>
                                        </div>
                                    </li><!-- end course menu item -->
                                    <li class="course-menu-item col-md-3 col-sm-4">
                                        <div class="single-item">
                                            <span class="item-icon"><img src="<?= SRC_URL ?>img/icon7.png" class="services_img" alt="" style=""></span>
                                            <a href="<?= PUBLIC_URL ?>seo-facility" class="ln-tr link">SEO</a>
                                        </div>
                                    </li><!-- end course menu item -->
                                    <li class="course-menu-item col-md-3 col-sm-4">
                                        <div class="single-item">
                                            <span class="item-icon"><img src="<?= SRC_URL ?>img/icon9.png" class="services_img" alt="" style=""></span>
                                            <a href="<?= PUBLIC_URL ?>bulk-sms" class="ln-tr link">Bulk SMS</a>
                                        </div>
                                    </li><!-- end course menu item -->
                                    <li class="course-menu-item col-md-3 col-sm-4">
                                        <div class="single-item">
                                            <span class="item-icon"><img src="<?= SRC_URL ?>img/icon10.png" class="services_img" alt="" style=""></span>
                                            <a href="<?= PUBLIC_URL ?>api-intigration" class="ln-tr link">API Intigration</a>
                                        </div>
                                    </li><!-- end course menu item -->
                                </ul><!-- end courses menu -->
                            </li>
                            <li class="parent-item <?= (mb_strtolower(User::$menu) == 'meet_our_team')?"current_page_item":"" ?> ">
                                <a href="<?= PUBLIC_URL ?>meet-our-team" class="ln-tr">Our Team</a>
                            </li>
                            <li class="parent-item <?= (mb_strtolower(User::$menu) == 'our_portfolio')?"current_page_item":"" ?>">
                                <a href="<?= PUBLIC_URL ?>our-portfolio" class="ln-tr">Portfolio</a>
                            </li>
                            <li class="parent-item <?= (mb_strtolower(User::$menu) == 'about_us')?"current_page_item":"" ?> ">
                                <a href="<?= PUBLIC_URL ?>about-us" class="ln-tr">About</a>
                            </li>
                            <!-- <li class="parent-item haschild">
                                <a href="20-blog-1-list.html" class="ln-tr">Blog</a>
                            </li> -->
                            <li class="parent-item <?= (mb_strtolower(User::$menu) == 'contact_us')?"current_page_item":"" ?> ">
                                <a href="<?= PUBLIC_URL ?>contact-us" class="ln-tr">Contact</a>
                            </li>
                            <li class="parent-item <?= (mb_strtolower(User::$menu) == 'careers')?"current_page_item":"" ?> ">
                                <a href="<?= PUBLIC_URL ?>careers" class="ln-tr">Careers</a>
                            </li>
                        </ul>
                    </nav><!-- End NAV Container -->
                    <div class="mobile-navigation fr">
                        <a href="#" class="mobile-btn"><span></span></a>
                        <div class="mobile-container"></div>
                    </div><!-- end mobile navigation -->
