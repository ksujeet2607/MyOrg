<?php include_once __DIR__.'/../layout/publicheader.php'; ?>
<style type="text/css">
    h1, h2, h3, h4, h5, h6 {
    color: #2c3145;
}
a, a:hover, a:focus, a:active {
    text-decoration: none;
    outline: none;
}
ul {
    margin: 0;
    padding: 0;
    list-style: none;
}

.section_all {
    position: relative;
    padding-top: 80px;
    padding-bottom: 80px;
    min-height: 100vh;
}
.section-title {
    font-weight: 700;
    text-transform: capitalize;
    letter-spacing: 1px;
}

.section-subtitle {
    letter-spacing: 0.4px;
    line-height: 28px;
    max-width: 550px;
}

.section-title-border {
    background-color: #000;
    height: 1 3px;
    width: 44px;
}

.section-title-border-white {
    background-color: #fff;
    height: 2px;
    width: 100px;
}
.text_custom {
    color: #00bd2a;
}

.about_icon i {
    font-size: 22px;
    height: 65px;
    width: 65px;
    line-height: 65px;
    display: inline-block;
    background: #ff3414;
    border-radius: 35px;
    color: white;
    box-shadow: 0 8px 20px -2px rgba(158, 152, 153, 0.5);
}

.about_header_main .about_heading {
    max-width: 450px;
    font-size: 24px;
}

.about_icon span {
    position: relative;
    top: -10px;
}

.about_content_box_all {
    padding: 28px;
}


</style>
        <?php

            if(!empty($response[1])){
                $data = $this->db_read($response[1]);
               
            }
            ?>

<section class="section_all bg-light" id="about" style="min-height: auto;padding-top: 40px;">
    <div class="container">
        <div class="bradcam_area bradcam_bg_1">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="bradcam_text text-center">
                            <h3 style=" margin-bottom: 30px;"><?php echo $data['page_title'] ?></h3>
                        </div>
                        <?php echo html_entity_decode(stripcslashes($data['page_details'])); ?>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</section>
<?php include_once __DIR__.'/../layout/publicfooter.php'; ?>