<?php

class Base extends Dbfunction {
  
    function __construct() {
        parent::__construct();
    }


    protected function getSiteInfo($param) {
        return $this->db_executeSingle("contactinfo", "number", "type='$param'");
    }

    public function base64_encode_image ($filename=string,$filetype=string) {
        if ($filename) {
            $imgbinary = fread(fopen($filename, "r"), filesize($filename));
            return 'data:image/' . $filetype . ';base64,' . base64_encode($imgbinary);
        }
    }

    /////////// SLider Images ///////////////
    public function getSliderImg ($param) {
        $rs = $this->db_executeReader("sliderimg", "*", "", "img_url!=''");
        return $rs;
    }

    //// Create Unique Id
    public function getUniqueId($rtype=false){
            $val=10001;
            $maxid = $this->db_executeSingle("profile", "MAX(id) + 1");
            if(!$rtype)
            echo PROFILEPRE.(10001+$maxid);
            else return PROFILEPRE.(10001+$maxid);
    }

    public function send_sms($mbile_list = "", $message = "") {
            $sms = urlencode($message);
            $urltouse = "http://www.bit7sms.com/new/sendsmsapi.php?uid=".SMS_ID."&pass=".SMS_PASSWORD."&mobno=" .$mbile_list. "&msg=" .$sms;
            $res = file_get_contents($urltouse);
            return $res;
    }

    // FETCH NEWS LIMIT
    public function getNews($type,$lim=10000) {
        $rs = $this->db_execute("select * from news where show_as LIKE '%$type%' ORDER BY newsId DESC limit $lim", false);
        return $rs;
    }
    //

    public function getStateOptions($name="",$id="",$class="",$narration="",$selected="",$selectedBy="id",$action=""){
        $rs = $this->db_execute(" SELECT * FROM State ORDER BY StateName");
        $response = "<select class='".$class."' id='".$id."' name='".$name."' $action>";
        $response .= "<option value='0'>".$narration."</option>";
        while($data = $this->db_read($rs)){
            $value = ($selectedBy=="id")?$data['Id']:$data['StateName'];
            $sel = ($value==$selected)?" selected='true'":"";
            $response .= "<option value='".$value."' $sel>".$this->ucf($data['StateName'])."</option>";
        }
        $response .= "</select>";
        return $response;
    }

    public function getCityOptions($name="",$id="",$class="",$narration="",$selected="",$selectedBy="id",$action=""){
       $rs = $this->db_execute(" SELECT * FROM city ORDER BY cityname");
       $response = "<select class='".$class."' id='".$id."' name='".$name."' $action>";
       $response .= "<option value='0'>".$narration."</option>";
       while($data = $this->db_read($rs)){
           $value = ($selectedBy=="id")?$data['id']:$data['cityname'];
           $sel = ($value==$selected)?" selected='true'":"";
           $response .= "<option value='".$value."' $sel>".$this->ucf($data['cityname'])."</option>";
       }
       $response .= "</select>";
       return $response;
   }
    public function getNewsCateChecks($cond=""){
       $rs = $this->db_execute(" SELECT * FROM newscat $cond ORDER BY newscatName");

       return $rs;
   }

    public function getCasteOptions($name="",$id="",$class="",$narration="",$selected="",$selectedBy="id",$action=""){
       $rs = $this->db_execute(" SELECT * FROM caste ORDER BY Caste");
       $response = "<select class='".$class."' id='".$id."' name='".$name."' $action>";
       $response .= "<option value='0'>".$narration."</option>";
       while($data = $this->db_read($rs)){
           $value = ($selectedBy=="id")?$data['CasteId']:$data['Caste'];
           $sel = ($value==$selected)?" selected='true'":"";
           $response .= "<option value='".$value."' $sel>".$this->ucf($data['Caste'])."</option>";
       }
       $response .= "</select>";
       return $response;
    }

    public function getPageOptions($name="",$id="",$class="",$narration="",$selected="",$selectedBy="id",$action=""){
       $rs = $this->db_execute(" SELECT * FROM manageablepages ORDER BY page_title");
       $response = "<select class='".$class."' id='".$id."' name='".$name."' $action>";
       $response .= "<option value='0'>".$narration."</option>";
       while($data = $this->db_read($rs)){
           $value = ($selectedBy=="id")?$data['id']:$data['page_title'];
           $sel = ($value==$selected)?" selected='true'":"";
           $response .= "<option value='".$value."' $sel>".$this->ucf($data['page_title'])."</option>";
       }
       $response .= "</select>";
       return $response;
    }
    public function getContTypeOptions($name="",$id="",$class="",$narration="",$selected="",$selectedBy="id",$action=""){
       $rs = $this->db_execute(" SELECT * FROM conttype ORDER BY id");
       $response = "<select class='".$class."' id='".$id."' name='".$name."' $action>";
       $response .= "<option value='0'>".$narration."</option>";
       while($data = $this->db_read($rs)){
           $value = ($selectedBy=="id")?$data['id']:$data['name'];
           $sel = ($value==$selected)?" selected='true'":"";
           $response .= "<option value='".$value."' $sel>".$this->ucf($data['name'])."</option>";
       }
       $response .= "</select>";
       return $response;
    }

    public function getEduOptions($name="",$id="",$class="",$narration="",$selected="",$selectedBy="id",$action=""){
       $rs = $this->db_execute(" SELECT * FROM education ORDER BY Education");
       $response = "<select class='".$class."' id='".$id."' name='".$name."' $action>";
       $response .= "<option value='0'>".$narration."</option>";
       while($data = $this->db_read($rs)){
           $value = ($selectedBy=="id")?$data['Eduid']:$data['Education'];
           $sel = ($value==$selected)?" selected='true'":"";
           $response .= "<option value='".$value."' $sel>".$this->ucf($data['Education'])."</option>";
       }
       $response .= "</select>";
       return $response;
    }

    public function getDistrictOptions($name="",$id="",$class="",$narration="",$selected="",$selectedBy="id",$action=""){
        $rs = $this->db_execute(" SELECT * FROM State ORDER BY StateName");
        $response = "<select class='".$class."' id='".$id."' name='".$name."' $action>";

        $response .= "<option value='0'>".$narration."</option>";
        while($data = $this->db_read($rs)){
            $value = ($selectedBy=="id")?$data['Id']:$data['StateName'];
            $sel = ($value==$selected)?" selected='true'":"";
            $response .= "<option value='".$value."' $sel>".$this->ucf($data['StateName'])."</option>";
        }
        $response .= "</select>";
        return $response;
    }

    public function getDeliveryBoyOption($branch,$selected=""){
        $rs = $this->db_execute(" SELECT id,DeliveryBoyName,mobno FROM DeliveryBoy where branchid=$branch ORDER BY DeliveryBoyName");
        while($data = $this->db_read($rs)){
            $value = $data['id'];
            $sel = ($value==$selected)?" selected='true'":"";
            $response .= "<option value='".$value."' $sel>".$data['DeliveryBoyName']."-[".$data['mobno']."]</option>";
        }
        return $response;
    }
    public function getStatusOption($value){
        $rs = $this->db_execute(" SELECT * FROM statusText ORDER BY statusText");
        $response .= "<option value='DELIVERED'>DELIVERED</option>";
        while($data = $this->db_read($rs)){
            $text = trim($data['statusText']);
            $sel = ($value=='Out for delivery' && $text=='Delivered')?" selected='true'":"";
            $sel = ($value == $text)?"selected='true'":$sel;
            $response .= "<option $sel>".$text."</option>";
        }
        return $response;
    }
    public function getAreaOption($branch,$selected=""){
        $rs = $this->db_execute("SELECT ID,Area,Pincode FROM Area where Branchid=$branch ORDER BY Area,Pincode",false);
        while($data = $this->db_read($rs)){
            $value = $data['ID'];
            $sel = ($value==$selected)?" selected='true'":"";
            $response .= "<option value='".$value."' $sel>".$data['Area']."-[".$data['Pincode']."]</option>";
        }
        return $response;
    }




    public function loadDistrictByState($param){
        $StateId = (isset($param[0]))?$param[0]:"";
        if($StateId!=""){
            if($StateId=="0"){
                $cond = " 1=1 ";
            }else{
                $cond = "StateId=$StateId";
            }
            $rs = $this->db_execute("SELECT * FROM District where $cond ORDER BY Districtname",false);
            while($row = $this->db_read($rs)){
                $data['response'][]=$row;
            }
            echo json_encode($data);
        }
    }
    public function loadCityByDistrict($param){
        $DistrictID = (isset($param[0]))?$param[0]:"";
        if($DistrictID!=""){
            if($DistrictID=="0"){
                $cond=" 1=1";
            }else{
                $cond = "DistrictID=$DistrictID";
            }
            $rs = $this->db_execute("SELECT * FROM City where $cond ORDER BY cityname",false);
            while($row = $this->db_read($rs)){
                $data['response'][]=$row;
            }
            echo json_encode($data);
        }
    }
    public function check_main_branch(){
        $Stateid=$_POST['statename'];
        $cityid=$_POST['cityid'];
        $branch=$_POST['branch'];

        $count=$this->db_executeSingle("Branch", "COUNT(Branchid)", "StateId='".$Stateid."' and CityId='".$cityid."' and BranchType='Main Branch'", "",false);
        if($count>0){
            echo "Already";
        }


    }
    public function loadCityByState($param){
        $StateId = (isset($param[0]))?$param[0]:"";
        if($StateId!=""){
            $rs = $this->db_execute("SELECT * FROM city where sid=$StateId ORDER BY cityname");
            while($row = $this->db_read($rs)){

                $data['response'][]=$row;


            }
            echo json_encode($data);
        } else {
            echo json_encode('');
        }
    }
    public function loadAreaByCity($param){
        $StateId = (isset($param[0]))?$param[0]:"";
        if($StateId!=""){
            //$rs = $this->db_execute("SELECT * FROM city where sid=$StateId ORDER BY cityname"); //  When load by City Id
            $rs = $this->db_execute("SELECT * FROM area order by AreaName");
            while($row = $this->db_read($rs)){

                $data['response'][]=$row;
            }
            echo json_encode($data);
        } else {
            echo json_encode('');
        }
    }

    public function getBranchOption($branch_type="All",$select="",$exclude=""){
        if($branch_type=="All"){
            $cond = "";
        }else{
            $cond = " WHERE BranchType='".$branch_type."'";
        }
        $rs = $this->db_execute("SELECT * FROM Branch $cond ORDER BY BranchName");
            while($row = $this->db_read($rs)){
                $selected = ($select==$row['Branchid'])?"selected":"";
                if($exclude!=$row['Branchid']){
                  $response .= "<option value='".$row['Branchid']."' $selected>".$row['BranchName']."</option>";
                }
        }
        return $response;
    }

    public function isValidCity(){
        $valid = $this->db_executeSingle("City", "COUNT(Id)", "Id='".$this->strip($_POST['cityname'])."'","",FALSE) ;
        echo ($valid > 0)?"yes":"no";
    }


    public function checkadminlogininfo($bypage="login"){
        extract($_POST);

        $valid = $this->db_executeSingle("Login", "COUNT(ID)", "LoginID='".$this->strip($userid)."' AND LoginPS = '".$this->strip($password)."' ","",FALSE) ;
        if($valid > 0){
            $rs = $this->db_execute("select * from Login where LoginID='".$this->strip($userid)."' AND LoginPS = '".$this->strip($password)."' ",FALSE);
            $result = $this->db_read($rs);
            $user =  ucfirst(strtolower(str_replace(" ","",$result['type'])));
            auth::Create_Session($result['LoginID'],$user,$result['ID'],$result['DisplayName'],$result['role']);
            $res = true;
        }else{
            $res = FALSE;
        }

        return $res;
    }

    public function checkmemberlogininfo($bypage="login"){
        extract($_POST);

        $valid = $this->db_executeSingle("profile", "COUNT(ID)", "LoginID='".$this->strip($userid)."' AND password = '".$this->strip($password)."' ","",FALSE) ;
        if($valid > 0){
            $rs = $this->db_execute("select LoginID,id from profile where LoginID='".$this->strip($userid)."' AND password = '".$this->strip($password)."' ",FALSE);
            $result = $this->db_read($rs);
            $user =  ucfirst(strtolower(str_replace(" ","",$result['type'])));
            auth::Create_Session_Public($result['LoginID'],'member');
            $res = true;
        }else{
            $res = FALSE;
        }

        return $res;
    }

    public function isloginvalid($user="admin"){
        if(!$this->IsSessionValid($user)){
           $msg = "<p".MSG_ERR.">Session Expired.</p>";
           $page = "index.php";
           $this->redirect(PUBLIC_URL.$page,$msg);
        }else{
            return TRUE;
        }
    }


     public function getMenu() {
      $type = auth::Get_userType();
      $type = ($type=="adminuser")?"admin":$type;
      $home = $type."home.php";
      $d = '../view/menu/'.strtolower($type).'menu.php';
      $this->render($d,$home);
    }

    public function getGroupId(){
        $group_head = $this->db_ExecuteScalar("admlogin", "added_by","adminID=".$this->GetuserId(),"","str",false);
        $row = array();
        return $group_head;
    }
    public function getContinent(){
        $continent = $this->db_execute("select * FROM continent order by continent_name",false);
        return $continent;
    }
    public function getCountry(){
        $cont_id = $_POST['id'];
        $rs = $this->db_execute("select * FROM country where contId=$cont_id order by country_name",FALSE);
        $data = array();
        while ($row = $this->db_read($rs)){
            $data[] = $row;
        }
        $country['country'] = $data;
        echo json_encode($country);
    }

    public function getCountryListByContinent($cont_id){
        $f = $cont_id;
        $cont_id = (int)$cont_id;
        if($cont_id==0){
            $cont_id = $this->db_ExecuteScalar("continent", "contId", "continent_name like '%".$f."%'","","",false);
        }
        $rs1 = $this->db_execute("select * FROM country where contId=$cont_id order by country_name",FALSE);
        while ($row1 = $this->db_read($rs1)){
            $data1 .= "<li><a href='".PUBLIC_URL."news/cntnews/".$row1['cid']."'>".$row1['country_name']."</a></li>";
        }
        return $data1;
    }
    public function continentNames($param) {
        $rs = $this->db_execute("SELECT * FROM continent ORDER BY `contId`",FALSE);
        return $rs;
    }

    public static function makeThumb($src, $dest, $desired_width, $format = 'image/jpeg')
    {
        /* read the source image */
        $source_image = null;
        if($format == 'image/jpeg')
        {
            $source_image = imagecreatefromjpeg($src);
        }
        else if($format == 'image/png')
        {
            $source_image = imagecreatefrompng($src);
        }

        $width = imagesx($source_image);
        $height = imagesy($source_image);

        /* find the "desired height" of this thumbnail, relative to the desired width  */
        $desired_height = floor($height * ($desired_width / $width));

        /* create a new, "virtual" image */
        $virtual_image = imagecreatetruecolor($desired_width, $desired_height);

        imageAlphaBlending($virtual_image, false);
        imageSaveAlpha($virtual_image, true);

        /* copy source image at a resized size */
        imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);

        /* create the physical thumbnail image to its destination */
        if($format == 'image/jpeg')
        {
            imagejpeg($virtual_image, $dest);
        }
        else if($format == 'image/png')
        {
            imagepng($virtual_image, $dest);
        }
    }

    // RESIZE IMAGE ON SAVING TIME //
    public function resize_image1($file, $w, $h, $crop=FALSE,$dir='newsimages') {
        list($width, $height) = getimagesize($file);
        $r = $width / $height;
        if ($crop) {
            if ($width > $height) {
                $width = ceil($width-($width*abs($r-$w/$h)));
            } else {
                $height = ceil($height-($height*abs($r-$w/$h)));
            }
            $newwidth = $w;
            $newheight = $h;
        } else {
            if ($w/$h > $r) {
                $newwidth = $h*$r;
                $newheight = $h;
            } else {
                $newheight = $w/$r;
                $newwidth = $w;
            }
        }
        $src = imagecreatefromjpeg($file);
        $dst = imagecreatetruecolor($newwidth, $newheight);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
        header('Content-Type: image/jpeg');
        $new_name = $this->generateRandomString(10).date("Ymd")."_".rand().".jpg";
        imagejpeg($dst, __DIR__."/../assets/$dir/".$new_name);
        imagedestroy($dst);
        ////////// Thumbnail ////////////
        self::makeThumb($file, __DIR__."/../assets/$dir/thumb_".$new_name, 120);
        ////////////////////////////////
        unlink($file);
        $new_name = SRC_URL."$dir/".$new_name;
        return $new_name;
    }
    // //
    // RESIZE IMAGE ON SAVING TIME //
    public function resize_image($file, $w, $h, $crop=FALSE,$dir='newsimages') {
        //require './SimpleImage.php';
        $new_name = $this->generateRandomString(10).date("Ymd")."_".rand().".jpg";

        try {
        // Create a new SimpleImage object
        $image = new SimpleImage();
        // Manipulate it
        $image
          ->fromFile($file)
          ->autoOrient()                        // adjust orientation based on exif data
          ->resize($w, $h)                   // proportinoally resize to fit inside a 250x400 box
          ->border('#fff', 2)
          ->toFile(__DIR__."/../assets/$dir/".$new_name,'image/jpeg');
        self::makeThumb($file, __DIR__."/../assets/$dir/thumb_".$new_name, 270);

      } catch(Exception $err) {
        // Handle errors
        echo $err->getMessage();
      }
      //unset($image);
      $name = SRC_URL."$dir/".$new_name;
      return $name;
    }
    // //


    // FORMAT DATE IN MYSQL STYLE //
    public static function formatdate($date,$format="Y-m-d"){
        if($date!="" && $date!="0000-00-00 00:00:0000" && $date!="0000-00-00 00:00:00" && $date!="0000-00-00"){
        return date($format, strtotime(str_replace("/", "-", $date)));}
        else {return "";}

    }
    // //

    public function getBranchName($param) {
        $id = (is_array($param))?$param[0]:$param;
        $bname = $this->db_executeSingle("Branch","BranchName","Branchid=$id","",false);
        return $bname;
    }

    public function getCityName($param) {
        $id = (is_array($param))?$param[0]:$param;
        $cname = $this->db_executeSingle("City","cityname","Id=$id","",false);
        return $cname;
    }

    public function getBranchCityName($branch="") {
        $id = ($branch=="")?auth::Get_branchID():$branch;
        $cname = $this->db_executeSingle("Branch","CityName","Branchid=".$id);
        return $cname;
    }
    public function getBranchCityId() {
        $cid = $this->db_executeSingle("Branch","CityId","Branchid=".auth::Get_branchID(),"",false);
        return $cid;
    }

    public static function showdate($mem_date,$exp = "-",$new="/"){
        $mem_date = explode($exp,$mem_date);
        $mem_date = $mem_date[2].$new.$mem_date[1].$new.$mem_date[0];
        return ($mem_date=="$new$new")?"":$mem_date;
    }

    // GET COUNTRY NAME BY ITS ID //
    public function getCountryById($cid){
        if($cid!=""){
            $c_name = $this->db_ExecuteScalar("country", "country_name", "cid=$cid","","",FALSE);
            return $c_name;
        }else{
            return FALSE;
        }

    }
    public function getCityBybranch(){
         $cityid=$this->db_executeSingle("Branch", "CityId","Branchid='".auth::Get_branchID()."'");
        return $cityid;
    }
    // //

    // RETRIVE FIRST PARAGRAPH OF NEWS CONTENT //
    public function showChunckInfo($content,$map) {
        return htmlspecialchars_decode(html_entity_decode(mb_convert_encoding(strtr($content, $map), 'UTF-8', 'ISO-8859-2'), ENT_QUOTES, 'UTF-8'));;
    }
    // //

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


   // RETRIVE FIRST PARAGRAPH OF NEWS CONTENT //
    public function showCunckInfo($content,$map) {
        return htmlspecialchars_decode(html_entity_decode(mb_convert_encoding(strtr($content, $map), 'UTF-8', 'ISO-8859-2'), ENT_QUOTES, 'UTF-8'));;
    }
    // //

    //////////////////// Checks for select ///////////

    public function checkBranch($param){
        if($param[0]!=""){
            $bid = $this->db_executeSingle("Branch", "COUNT(Branchid)", "BranchName='".$param[0]."'");
            if($bid > 0){
              $res =  "valid";
            }else{
              $res = "error";
            }
        }else{
            $res = "error";
        }
        echo $res;
    }


    //////////////////// Checks for City ///////////

    public function checkCity($param){
        if($param[0]!=""){
            $bid = $this->db_executeSingle("City", "COUNT(Id)", "cityname='".$param[0]."'");
            if($bid > 0){
              $res =  "valid";
            }else{
              $res = "error";
            }
        }else{
            $res = "error";
        }
        echo $res;
    }
    /// UC First //

    public function ucf($string){
        return ucwords(strtolower($string));
    }

    public function uc($string){
        return strtoupper(strtolower($string));
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

    public function getProfileInfo() {
        $id = $this->strip($_POST['profileId']);
        $returntyp = ($_POST['resptyp']=="")?"json":$_POST['resptyp'];
        $valid = $this->db_executeSingle("profile", "count(LoginID)", "LoginID='$id'","",false);
        if($valid){
            $stmt = $this->db_executeReader("profile", "LoginID,name,mobile,photo,photo1,photo2", "", "LoginID='$id'") ;
            while ($row = $this->db_read($stmt)) {
               $resposnse['res']['info'][] = $row;
            }
            $stmt1 = $this->db_executeReader("proSer", "*", "", "profileid='$id'") ;
            while ($row1 = $this->db_read($stmt1)) {
               $resposnse['res']['bus'][] = $row1;
            }
            $resposnse['res']['error'] = 0;
        }else{
            $resposnse['res']['error'] = "Profile Id Not Found!";
        }
        if($returntyp=="json"){
            echo json_encode($resposnse);
        }else{
           return $stmt;
        }


    }
}
