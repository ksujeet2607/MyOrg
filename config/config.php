<?php
// database credentials

define('DB_NAME', 'technetsdb');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_HOST', 'localhost');

// error_reporting(0);
// ini_set("display_errors", "off");

error_reporting(E_ALL);
ini_set("display_errors", "on");


define('BASE_URL', 'http://localhost/TechNets/');
define('PUBLIC_URL', 'http://localhost/TechNets/');
define('ADMIN_URL', 'http://localhost/TechNets/admin/');
define('ADMUR_URL', 'http://localhost/TechNets/adminuser/');

define('SRC_URL', 'http://localhost/TechNets/assets/'); // Load Js/Css

define('IMG_URL', 'http://localhost/TechNets/images/');// load Images
define('GAL_URL', 'http://localhost/TechNets/gallery/'); // load Gallery images
define("SCANFILE", "scan");

define("PROFILEPRE", "JMS");// Profile Prefix

define('MSG_ERR', 'red');
define('MSG_SUC', 'green');
define('SITE_NAME', "TechNets");

define('SMS_ID', "");
define('SMS_PASSWORD', "");

define('CONTACT', "+91 93430 86888");
define('CONTACT_NO', "9343086888");
define('EMAIL_FROM', "jainCommunity@gmail.com");

define('EMAIL_FROM1', "noreply.matrimony.com@gmail.com");
define('EMAIL_PASS1', "Admin@123");
define('SMTP_HOST', "smtp.gmail.com");
define('SMTP_SECURE', 'TLS');
define('SMTP_PORT', '587');
define('SMTP_DEBUG', '0');

date_default_timezone_set('Asia/Kolkata');
