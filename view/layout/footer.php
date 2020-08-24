<?php 
$user = (auth::Get_userType()=="User")?"Admin":auth::Get_userType();
include_once __DIR__.'/../layout/'.strtolower($user).'footer.php'; 
?>