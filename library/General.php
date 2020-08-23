<?php
trait General  {

  public function strpos_all($haystack, $needle) {
    $offset = 0;
    $allpos = array();
    while (($pos = mb_strpos($haystack, $needle, $offset)) !== FALSE) {
        $offset   = $pos + 1;
        $allpos[] = $pos;
    }
    return $allpos;
  }


  /// UC First //

  public function ucf($string){
      return ucwords(strtolower($string));
  }

  public function uc($string){
      return strtoupper(strtolower($string));
  }

  /////// Generates random string /////////////
 function generateRandomString($length = 15) {
   $characters = '0123456789-abcdefghijklmnopqrstuvwxyz_ABCDEFGHIJKLMNOPQRSTUVWXYZ';
   $charactersLength = strlen($characters);
   $randomString = '';
   for ($i = 0; $i < $length; $i++) {
       $randomString .= $characters[rand(0, $charactersLength - 1)];
   }
   return $randomString;
 }


////////////////// Upload files //////////////////////
  public function uploadfile($file = "",$filename_custem = "", $folder = "", $allowed_exts = "", $allowed_type = "", $minsize = 0, $maxsize = 0){

      $filename = "N";

      if ($_FILES[$file]["name"] != "") {

        $ext = explode(".", $_FILES[$file]["name"]);

        $extn = strtolower(end($ext));

        if($filename_custem != ""){
          $filename = $filename_custem.".".$extn;
        }
        else {
            $filename = substr(str_replace(" ", "-", $ext[0]), 0, 10) . "_" . time() .".". $extn;
        }

        if (file_exists($folder . $filename)) {
            unlink($folder . $filename);
        }

        $error = 0;

        if (round(($_FILES[$file]["size"]) / 1024) < $minsize) {
            $error++;
        }

        if (round(($_FILES[$file]["size"]) / 1024) > $maxsize) {
            $error++;
        }

        if(is_array($allowed_type)){
            $result = new finfo();
            $mimefiletype=$result->file($_FILES[$file]["tmp_name"], FILEINFO_MIME_TYPE);
            if (!in_array($mimefiletype, $allowed_type)) {
                $error++;
            }
        }

        if(is_array($allowed_exts)){
            if (!in_array($extn, $allowed_exts)) {
                $error++;
            }
        }

        if($error == 0 ){
            print_r($_FILES[$file]);
            if(move_uploaded_file($_FILES[$file]["tmp_name"],$folder . $filename)){
                $filename = $filename;
            } else {
                $filename = "N";
            }
        }else{
           $filename = "N";
        }

      } else {
        $filename = "N";
      }
      return $filename;
  }

  public function excelHeader() {
      require('plugins/PHP-Excel/Classes/PHPExcel.php');
      ini_set('memory_limit', '512M');
//        if (PHP_SAPI == 'cli')
      return $objPHPExcel = new PHPExcel();
  }
  public function excelFooter($objPHPExcel,$filename="Report.xls") {
      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename='.$filename);
      header('Cache-Control: max-age=0');
      // If you're serving to IE 9, then the following may be needed
      header('Cache-Control: max-age=1');

      // If you're serving to IE over SSL, then the following may be needed
      //header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
      //header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
      header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
      header ('Pragma: public'); // HTTP/1.0

      $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
      ob_end_clean();
      $objWriter->save('php://output');
      exit;
  }

    public static function encrypt($data, $key)
    {
        $encryption_key = base64_decode($key);
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $encrypted_data = openssl_encrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);
        return base64_encode($encrypted_data . '::' . $iv. ' ::'.$key);


    }

    public static function decrypt($data)
    {
        list($encrypted_data, $iv, $key) = explode('::', base64_decode($data), 3);
        $encryption_key = base64_decode($key);
        return openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);
    }

    /////////////////// Get Menu ////////////////////
    public function getMenu($type) {
       include_once 'view/menu/'.strtolower($type).'menu.php';
    }

    ////////////////// Render Views //////////////////////
    public function render($d, $response=array(), $layoutH="", $layoutF=""){
         $dir = strtolower(get_called_class());
         //echo  __DIR__."/../view/".$dir."/".$d.".php";
         if(file_exists( __DIR__."/../view/".$dir."/".$d.".php")){
           if($layoutH!=""){
               include_once __DIR__."/../view/layout/".strtolower($layoutH)."header.php";
           }else{
              include_once __DIR__."/../view/layout/".$dir."header.php";
           }
           require_once __DIR__."/../view/".$dir."/".$d.".php";
           if($layoutF!=""){
               include_once __DIR__."/../view/layout/".strtolower($layoutF)."footer.php";
           }else{
               include_once __DIR__."/../view/layout/".$dir."footer.php";
           }
         }else{
             require_once __DIR__."/../view/errors/error404.php";
         }
    }
    public function loadModel($d){
         if(file_exists(__DIR__."/".$d."Model")){
           require_once __DIR__."/".$d."Model";
           return new $d."Model()";
         }else{
             $this->render("../view/errors/error404.php", "user");
         }
    }


function strip($val=""){
$val=addslashes($val);
$val=str_replace("`","",$val);
$val=str_replace("~","",$val);
$val=str_replace("\r\n"," ",$val);
$val=trim($val);
$val=htmlspecialchars($val);
return $val;
}
function strip_min($val=""){
//$val=str_replace("'","",$val);
$val=addslashes($val);
$val=str_replace("`","",$val);
$val=str_replace("~","",$val);
//$val=htmlspecialchars($val);
$val=trim($val);
return $val;
}
function unstrip($val=""){
$val=stripslashes($val);
if(!$this->is_html($val))
$val=htmlentities($val);
//$val=html_entity_decode($val);


return $val;
}
function un($val=""){
$val=htmlentities($val);
return $val;
}
function is_html($string)
{
  return preg_match("/<[^<]+>/",$string,$m) != 0;
}
function unstrip_array($val){
    if(is_array($val)){
        $a=array();
        foreach ($val as $key => $value) {
            $a[$key]=$this->unstrip($value);
        }
return $a;
    }else{
return $val;
    }
}

function un_all($val){
    if(is_array($val)){
        $a=array();
        foreach ($val as $key => $value) {
            $a[$key]=un($value);
        }
return $a;
    }else{
return $val;
    }
}

function getcdate($dif=0){

    if($dif!="0"){
        return date("d-m-Y",  strtotime("$dif days"));
    }
return date("d-m-Y");

}

function goback($step = 1){
    echo "<script>window.location.go(-$step)</script>";
}

function redirect($url,$msg="",$type=true){
if (!headers_sent($filename, $linenum)) {
    $message = "";
    if($msg!=''){
    $msg = explode("~", $msg);
    $div = ($msg[1]=="suc")?"success":"danger";
    $fcolr = ($msg[1]=="suc")?MSG_SUC:MSG_ERR;
    $message = '<script>$(document).ready(function(){'
            .'$(".content-header").append(\'<div id="erralert" class="alert alert-'.$div.'" style="margin-bottom: 0px;">'
                .'<span style="color: '.$fcolr.';">'.$msg[0].'</span>'
            .'</div>\');
            setTimeout(function(){if($("#erralert").length > 0){$("#erralert").remove();}},5000);});
        </script>';
    }
    $_SESSION["msg"]= $message;
    if($type){
        header('Location:'.$url);
    exit();
    }else{
        return true;
    }

    exit;
} else {
    echo "Headers already sent in $filename on line $linenum\n" .
          "Cannot redirect.";
    exit;
}

	}
function roundoff($no=0){
    if($no==""){
        $no="0.00";
    }
$temp_dx=explode(".",$no);
$dec=(sizeof($temp_dx)>1)?$temp_dx[1]:"00";
while(strlen($dec)!=2){
   $dec.="0";
}
return $temp_dx[0].".".$dec;
}
function appendzero($no=0,$length=0){
 while(strlen($no)!=$length){
     $no="0".$no;
 }
return $no;
}
function cutstring($str="",$length=0,$adddot=true){
$txteng=explode(" ",$str);
if(sizeof($txteng)>$length)
{
    $neweng=implode(" ",array_slice($txteng,0,$length));
    if($adddot)
        $neweng.="...";
    return $neweng;
}else{
    if($adddot)
        $str.="...";
    return $str;
}
}
function converttocurrency($no=0){
    $str="";
    if(strlen($no)>3){
        $str1=substr($no, (strlen($no)-3),3);
        $str2=substr($no, 0,(strlen($no)-3));
            $x=0;
  while(strlen($str2)>1){
        $str.=substr($str2, (strlen($str2)-1),1);
        $str2=substr($str2, 0,(strlen($str2)-1));
      //  echo "<br/>".$str."-".$str2."-".$x;

        $x++;
             if($x==2)   {
                 $str.=",";
                 $x=0;
             }

   }
   $str.=$str2;
   //echo $str;
   $str2="";
        while(strlen($str)>0){
        $str2.=substr($str, (strlen($str)-1),1);
        $str=substr($str, 0,(strlen($str)-1));
        //echo "<br/>".$str2."-".$str;
   }
   $str=$str2;
   $str.=",".$str1;
    }else{
        $str=$no;
    }


  return $str;
}

function getreceiptno($no){
    if(strlen($no)<6){
        $no=appendzero($no,5);
        $no="1".$no;
    }
    return $no;
}
function convert_number($number) {
    if (($number < 0) || ($number > 999999999))
    {
    return $number;
    }
    $Gn = floor($number / 100000);  /* Millions (giga) */
    $number -= $Gn * 100000;
    $kn = floor($number / 1000);     /* Thousands (kilo) */
    $number -= $kn * 1000;
    $Hn = floor($number / 100);      /* Hundreds (hecto) */
    $number -= $Hn * 100;
    $Dn = floor($number / 10);       /* Tens (deca) */
    $n = $number % 10;               /* Ones */

    $res = "";

    if ($Gn)
    {
        $res .= convert_number($Gn) . " Lac";
    }

    if ($kn)
    {
        $res .= (empty($res) ? "" : " ") .
            convert_number($kn) . " Thousand";
    }

    if ($Hn)
    {
        $res .= (empty($res) ? "" : " ") .
            convert_number($Hn) . " Hundred";
    }

    $ones = array("", "One", "Two", "Three", "Four", "Five", "Six",
        "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen",
        "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen",
        "Nineteen");
    $tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty",
        "Seventy", "Eigthy", "Ninety");

    if ($Dn || $n)
    {
        if (!empty($res))
        {
            $res .= " and ";
        }

        if ($Dn < 2)
        {
            $res .= $ones[$Dn * 10 + $n];
        }
        else
        {
            $res .= $tens[$Dn];

            if ($n)
            {
                $res .= "-" . $ones[$n];
            }
        }
    }

    if (empty($res))
    {
        $res = "zero";
    }
return $res;
}
function get_subtitle($array=array()){
 $subtitle="";
 foreach ($array as $key => $value) {
     if(strpos(FILE_NAME, $key)){
         $subtitle=$value;

     }
 }
 return $subtitle;
}

    /////////////////////////////////////////////////////////////////////////////////
    // check varible existance and value not null ///////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////

    public function is_not_null($variable_type = "", $variable_list = ""){

        $variables = explode("~", $variable_list);

        $error = 0;

        if($variable_type == "POST"){

            foreach ($variables as $variable){

            if(isset($_POST[$variable])){

                if(trim($_POST[$variable]) == "" && $_POST[$variable] == NULL){
                    $error++;
                }
            }
            else {
                $error++;
            }
           }
        }
        else if($variable_type == "GET"){

            foreach ($variables as $variable){

            if(isset($_GET[$variable])){

                if(trim($_GET[$variable]) == "" && $_GET[$variable] == NULL){
                    $error++;
                }
            }
            else {
                $error++;
            }
           }
        }
        else if($variable_type == "FILES"){

            foreach ($variables as $variable){

            if(!isset($_FILES[$variable])){
                 $error++;
            }
           }
        }
        else if($variable_type == "SESSION"){

            foreach ($variables as $variable){

            if(isset($_SESSION[$variable])){

                if(trim($_SESSION[$variable]) == "" && $_SESSION[$variable] == NULL){
                    $error++;
                }
            }
            else {
                $error++;
            }
           }
        }
        else if($variable_type == "REQUEST"){

            foreach ($variables as $variable){

            if(isset($_REQUEST[$variable])){

                if(trim($_REQUEST[$variable]) == "" && $_REQUEST[$variable] == NULL){
                    $error++;
                }
            }
            else {
                $error++;
            }
           }
        }
        else if($variable_type == "COOKIE"){

            foreach ($variables as $variable){

            if(isset($_COOKIE[$variable])){

                if(trim($_COOKIE[$variable]) == "" && $_COOKIE[$variable] == NULL){
                    $error++;
                }
            }
            else {
                $error++;
            }
           }
        }
        else if($variable_type == "SERVER"){

            foreach ($variables as $variable){

            if(isset($_SERVER[$variable])){

                if(trim($_SERVER[$variable]) == "" && $_SERVER[$variable] == NULL){
                    $error++;
                }
            }
            else {
                $error++;
            }
           }
        }

        if($error == 0){return true;}else{return false;}
    }


function is_not_empty($array,$value){
   if($this->is_not_null($array)){
    $tmp_array=explode("~@~",$value);
      if (is_array($tmp_array)) {
      if (sizeof($tmp_array) > 0) {
          foreach ($tmp_array as $value) {
          if(array_key_exists($value,$array)){
              if(!$this->is_not_null($array[$value])){
                  return false;
              }
          }else{
              return false;

          }
          }
          return true;
      } else {
       return false;
      }
    } }else{
        return false;
    }
  }
function load_js($title="",$mini=true,$type="ui"){
    $title=explode(",",$title);
    $min=($mini)?".min":"";
    $minf=($mini)?"/minified":"";
    foreach ($title as $value){
    echo "<script type='text/javascript' src='".RE_HOME_PATH."extra/jquery/ui".$minf."/jquery.".$type.".".$value.$min.".js'></script>";
    }

}
function get_pagename($filename=""){
 $tmp=explode("/",$filename);
 if(sizeof($tmp)<2){
     $tmp=explode("\\",$filename);
 }
 $tmp1=$tmp[sizeof($tmp)-1];
 $tmp2=explode(".", $tmp1);
 $filename=$tmp2[0];
 return $filename;
}
function  add_script($default=true,$script=""){
    if($default){
    $filename=get_pagename(PAGE_NAME);
    }else{
        $filename=$script;

    }
    echo "<script type='text/javascript' src='".RE_ADMIN_PATH."js/".$filename.".js'></script>";
}
function showpaging($pagesize=0,$row_count=0,$cpage=0,$add=""){
    $paging="";
    $totp=$row_count/$pagesize;
    $totp=(($totp-round($totp))>0)?round($totp)+1:round($totp);
    if($row_count>$pagesize){
    $paging.='<tr><td colspan="100"><table border="0" cellpadding="0" cellspacing="0" id="paging-table"><tbody><tr><td>
        <span style="float:left;padding: 3px 12px 0 12px;display:none;" id="paging_loader" ><img src="'.$add.'images/loader.gif"/>Please Wait While Loading....</span>';
    if($cpage!=1){
    $paging.='<a href="" onclick="$(\'#paging_loader\').show();start(\'1\');return false;" class="page-far-left"></a>';
    }
    if($cpage!=1){
    $paging.='<a href="" onclick="$(\'#paging_loader\').show();start(\''.($cpage-1).'\');return false;" class="page-left"></a>';
    }

    $paging.='<div id="page-info">Page <strong>'.$cpage.'</strong> / '.$totp.'</div>';
    if($cpage!=$totp){
    $paging.='<a href="" onclick="$(\'#paging_loader\').show();start(\''.($cpage+1).'\');return false;" class="page-right"></a>';
    }
    if($cpage!=$totp){
    $paging.='<a href="" onclick="$(\'#paging_loader\').show();start(\''.$totp.'\');return false;" class="page-far-right"></a>';
    }
    $paging.='</td><td>';
    $paging.='<select class="form-control" onchange="$(\'#paging_loader\').show();start(\'1\',this.value);">';
    $paging.='<option disabled="disabled">Number of rows</option>';
    $x=1;
    while($x<=$totp){
	if($x==1){$paging.='<option selected=selected>'.($pagesize*$x).'</option>';}else {
    $paging.='<option>'.($pagesize*$x).'</option>';
	}
    $x++;
    }
    $paging.='</select></td></tr></tbody></table></td></tr>';
    }
    return $paging;
}
function add_cookies($array="",$pagename="int"){
    foreach ($array as $key => $value) {
    if(!is_not_empty($_COOKIE,"nethomes")){
        setcookie("nethomes[$pagename][$key]","$value", (time()+(60*60*24*30)), "/");
    }else{
            setcookie("nethomes[$pagename][$key]","$value", (time()+(60*60*24*30)), "/");
    }

    }
}
function set_cookies($name=""){
    $array=explode("~@~",$name);
    $page=get_pagename(FILE_NAME);
    $j=0;
    $str="<script type='text/javascript'>$(document).ready(function(){";
    $str1="";
    if(is_not_empty($_COOKIE["nethomes"],$page)){
    foreach ($_COOKIE["nethomes"][$page] as $key => $value) {
        if(is_not_null($array))
        foreach ($array as $value1) {
            if($value1==$key){
             if(is_not_null($value)){
                $str.="$('#$key').val('$value');";
                $str1.="<input type='hidden' value='".$value."' id='hdd_".$key."'/>";
                 $j++;
             }
            }
        }
    }}
    $str.="});</script>";
    if($j>0){
        echo $str;
        echo $str1;
    }
}
function to_currency($number) {
    if (($number < 0) || ($number > 99999999999))
    {
    return $number;
    }
    $no = round($number / 10000000,2); //crore
    $ty="Crore(s)";
    if($no<1){
    $no = round($number / 100000,2); //lac
    $ty="Lac(s)";
    }
    if($no<1){
        $no=converttocurrency($number);
        $ty="";
    }


return $no." ".$ty;
}
function to_sqrft($area="",$unit=""){
      $retVal=$area;
      $selectValue=$unit;
      $inpElem=(double)$area;
    if($selectValue!="")
        {
            if($selectValue=='Sq-yrd'  &&  $inpElem !=null  &&  $inpElem!=''){
               $retVal=round(($inpElem*9.0));}
            else if($selectValue=='Sq-m' && $inpElem!=null && $inpElem!='')
                $retVal=round(($inpElem)*10.76);
            else if($selectValue=='Acre' && $inpElem!=null && $inpElem!='')
                $retVal=round(($inpElem)*43559.35);
            else if($selectValue=='Bigha' && $inpElem!=null && $inpElem!='')
                $retVal=round(($inpElem)*26909.75);
            else if($selectValue=='Hectare' && $inpElem!=null && $inpElem!='')
                $retVal=round(($inpElem)*107639);
            else if($selectValue=='Marla' && $inpElem!=null && $inpElem!='')
                $retVal=round(($inpElem)*272.25);
            else if($selectValue=='Kanal' && $inpElem!=null && $inpElem!='')
                $retVal=round(($inpElem)*5445.02);
            else if($selectValue=='Biswa1' && $inpElem!=null && $inpElem!='')
            $retVal=round(($inpElem)*3751003.87);
            else if($selectValue=='Biswa2' && $inpElem!=null && $inpElem!='')
            $retVal=round(($inpElem)*5860932.78);
            else if($selectValue=='Ground' && $inpElem!=null && $inpElem!='')
            $retVal=round(($inpElem)*25832.28);
            else if($selectValue=='Aankadam' && $inpElem!=null && $inpElem!='')
            $retVal=round(($inpElem)*774.88);
            else if($selectValue=='Rood' && $inpElem!=null && $inpElem!='')
            $retVal=round(($inpElem)*117240.39);
            else if($selectValue=='Chatak' && $inpElem!=null && $inpElem!='')
            $retVal=round(($inpElem)*4843.64);
            else if($selectValue=='Kottah' && $inpElem!=null && $inpElem!='')
            $retVal=round((($inpElem)*66.88/0.0929));
            else if($selectValue=='Cent' && $inpElem!=null && $inpElem!='')
            $retVal=round(($inpElem)*4688.10);
            else if($selectValue=='Perch' && $inpElem!=null && $inpElem!='')
            $retVal=round(($inpElem)*2931.00);
            else if($selectValue=='Guntha' && $inpElem!=null && $inpElem!='')
            $retVal=round(($inpElem)*11720.81);
            else if($selectValue=='Are' && $inpElem!=null && $inpElem!='')
            $retVal=round(($inpElem)*11581.95);
            else
                $retVal=$area;


       }

       return $retVal;
}

function Count_Sort(&$arr=array()){    /// this function sort data according to no of element with acsc sorting
      if(is_array($arr) && is_not_null($arr)){
          $au=array_unique($arr);
          $arr_tot=array();
          foreach ($au as $value) {foreach ($arr as $val) {if($value==$val){if(array_key_exists($value, $arr_tot)){
                   $arr_tot[$value]++;   }else{$arr_tot[$value]=1;}}}}
                   $a=asort($arr_tot);
                   $aa=array_reverse($arr_tot,true);
         $arr=array();
         foreach ($aa as $key => $value) {
             for($i=0;$i<$value;$i++){
                 array_push($arr,$key);
          }
         }
        }
}
function getlocation(&$city=0,&$region=0){
$ip =$_SERVER['REMOTE_ADDR'];//"122.168.53.224";
$file = "cache/".$ip;
if(!file_exists($file)) {
    $json = file_get_contents("http://traceipaddress.co.in/utility/example.php?ip=".$ip);
    $json=explode("<b>City</b>:</td><td> ",$json);
    $city=explode("</td></tr><tr><td width='100'><b>Country</b>",$json[1]);
    $json=explode("<b>Region Name</b>:</td><td> ",$city[1]);
    $state=explode("</td></tr></table>",$json[1]);
    $json='{"IP":"'.$ip.'","regionName":"'.$state[0].'","cityName":"'.$city[0].'"}';
    $f = fopen($file,"w+");
    fwrite($f,$json);
    fclose($f);
} else {
    $json = file_get_contents($file);
}
$json = json_decode($json,true);
$region=$json["regionName"];
$city=$json["cityName"];
}


function sendsms($msg="",$no=0){
    error_reporting(0);
$postdata = http_build_query(array(
        'msg' => $msg,
        'uid' =>"nethometrans",
        'mobno'=>$no,
        'pass'=>"nethometrans1213testtt"));
$opts = array('http' =>array(
        'method'  => 'POST',
        'header'  => 'Content-type: application/x-www-form-urlencoded',
        'content' => $postdata
    ));
$context  = stream_context_create($opts);

$out=file_get_contents("http://www.bit7sms.com/new/sendsmsapi.php",false,$context);

}
function sendemail($to="",$sub="",$msg){
  ini_set('SMTP','115.124.123.73');
  $headers =  "From: ".EMAIL_FROM."\r\n";
  $headers .= 'MIME-Version: 1.0' . "\r\n";
  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
  //$headers .= "\r\nX-Mailer: PHP/" . phpversion();
  $subject = $sub;
  $message = $msg;
  return mail($to, $subject , $message ,$headers);
}

function mkstr($input){
   return ucwords(strtolower(strip($input)));
}

function set_valid_date($date,$format="Y-m-d"){
    return date($format, strtotime($date));
}

function get_valid_date($date,$format="d-m-Y",$datepicker=false){
    if($date=="" || $date=="0000-00-00" || $date=="0000-00-00 00:00:00" || $date=="1970-01-01" || $date=="1970-01-01 00:00:00"){
        if($datepicker){
           $response = date($format);
        }else{
           $response = "";
        }
    }else{
       $response = date($format, strtotime($date));
    }

    return $response;
}



}
