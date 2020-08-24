<?php
// database credentials

define('DB_NAME', 'technetdb');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_HOST', 'localhost');

error_reporting(0);
ini_set("display_errors", "off");

// error_reporting(E_ALL);
// ini_set("display_errors", "on");


define('BASE_URL', 'http://localhost/TechNets/');
define('PUBLIC_URL', 'http://localhost/TechNets/');
define('ADMIN_URL', 'http://localhost/TechNets/admin/');
define('ADMUR_URL', 'http://localhost/TechNets/adminuser/');

define('SRC_URL', 'http://localhost/TechNets/assets/'); // Load Js/Css

define('IMG_URL', 'http://localhost/TechNets/images/');// load Images
define('GAL_URL', 'http://localhost/TechNets/gallery/'); // load Gallery images


define("SCANFILE", "scan");

define("PROFILEPRE", "JMS");// Profile Prefix

define('MSG_ERR', '#383c4b');
define('MSG_SUC', '#383c4b');
define('SITE_NAME', "TechNets");

define('SMS_ID', "");
define('SMS_PASSWORD', "");

define('CONTACT', "+91 90989 62964");
define('CONTACT_NO', "+91 95842 89656");
define('EMAIL_FROM', "contact@technets.in");

define('EMAIL_FROM1', "technetsinfo@gmail.com");
define('EMAIL_PASS1', "technets@1231_#");
ini_set('SMTP','202.66.175.41');

define('SMTP_HOST', "smtp.gmail.com");
define('SMTP_SECURE', 'TLS');
define('SMTP_PORT', '587');
define('SMTP_DEBUG', '0');

date_default_timezone_set('Asia/Kolkata');
