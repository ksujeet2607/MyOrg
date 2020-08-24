<?php
class admin extends myfunction{ 
    public static $menu;
    protected  $userid;
    protected  $usertype;
    public  $params;
    function __construct($method,$params){
        self::$menu = $method;
        $this->params = $params;
        $this->userid = auth::Get_userID();
        $this->usertype = strtolower(auth::Get_userType());
        parent::__construct();  
        
//        echo $this->usertype;
//        die();
        if(!auth::IsLogin('Admin')){
           $this->redirect(BASE_URL.'login');
           exit();
        }
        
    }
    public function index($response){       
        if(auth::IsLogin('Admin')){
            $this->adminhome("adminhome");
        }else{
            $this->render("../view/admin/index.php", $response);
            exit();
        }

    }
    
    public function logout($param) {
        auth::DestroySess('admin');
        $this->redirect(BASE_URL."login", "Logged out!!~suc");
    }
    
    public function adminhome($param) {
        $this->render("../view/admin/adminhome.php", $param);
    }
    

    
  ////////**************** Add / Update Product ***************//////
    
    public function product($param) {
        $this->render("../view/admin/product.php", $param);
    }
    
    public function addproduct($param){
      $this->isAuthAdmin("product", "Add");
      for($j=0;$j<count($_FILES['productImg']['name']);$j++){
          if($_FILES['productImg']['name'][$j]!="" && in_array($_FILES['productImg']['name'][$j], $_POST['newImgs'])){
              $uploadfile=$_FILES["productImg"]["tmp_name"][$j];
              $img_name = $_FILES['productImg']['name'][$j];
              $extension = end(explode(".", $img_name));
              $new_name = explode(".", $img_name)[0]."_".rand()."_".date('Ymdi').".".$extension;                
              move_uploaded_file($uploadfile, __DIR__."/../assets/products/".$new_name);  
              $resized = $this->resize_image(__DIR__."/../assets/products/".$new_name, 512, 600,FALSE,'products');
              header('Content-Type: text/html');
              $photo .= $resized."||";
          }

      }
      $imgurls = rtrim($photo,"||");
      //die();
      $productcat = $this->strip($_POST['productcat']);
      $prefix = substr(strtoupper($productcat),0,3);
      foreach ($_POST['saveas'] as $value) {
         $productas .= $value.","; 
      }
      $productas = rtrim($productas, ",");
      while (true) {
          $productid = $this->getUniqueId($prefix,true);
          if($this->db_Insert("product", "cat,productid,productname,brand,strikeprice,offer,"
                  . "price,unit,productkey,productas,productDesc,photos,entrytime,user_id", 
              $productcat."~".$productid."~".$this->strip($_POST['productname'])."~".
              $this->strip($_POST['brand'])."~".$this->strip($_POST['strikeprice'])."~".
              $this->strip($_POST['offer'])."~".$this->strip($_POST['price'])."~".
              $this->strip($_POST['unit'])."~". $this->strip($_POST['productkey'])."~".
              $productas."~".$this->strip($_POST['newsdetails'])."~".$imgurls."~".
              date("Y-m-d h:i:s")."~".$this->userid,false)){
              //break;
          }
      }
      
      $this->redirect(ADMIN_URL."product", "Product Added Successfully!~suc");

  }  
    public function modifyproduct($param) {
          $this->isAuthAdmin("product", "Edit");
          $cond = " 1=1 ";
          if(isset($_POST['submit'])){
              $_SESSION['search'] = $_POST;
              $data = $_POST;
          }elseif(isset ($_SESSION['search'])){
              $data = $_SESSION['search'];
          }

          if($data['productcat']!="" && $data['productcat']!="All"){
              $cond .= " AND cat='".$this->strip($data['productcat'])."'";
          }
          if($data['type']!="" && $data['type']!="All"){
              $cond .= " AND productas like '%".$this->strip($data['type'])."%'";
          }
          if($_POST['keyword']!=""){
              $key = $this->strip($data['keyword']);
              $cond .= " AND (cat like '%$key%' OR productname like '%$key%' OR brand like '%$key%' "
                      . "OR productas like '%$key%' OR productDesc like '%$key%' OR productid like '%$key%'"
                      . " OR productkey like '%$key%' unit like '%$key%' )";
          }
          $limit = 50;
          $cpage = (isset($_GET['page']))?$_GET['page']:1;
          $pagi =  $this->pagination("product",$limit,$cpage);
          if($cpage==1){
              $start = 0; 
             }else{
                 $start = ($cpage * $limit) - $limit;
             }
          $lim = " limit $start ,$limit";
          $rs = $this->db_executeReader("product p", "p.*,l.DisplayName","LEFT JOIN login l ON p.user_id=l.id", $cond," order by id desc $lim",false);
          $this->render("../view/admin/modifyproduct.php", array('list',$rs,$data,$pagi,$limit,$cpage));  

      }
    public function editproduct($param) {
          $this->isAuthAdmin("product", "Edit");
          if(isset($param[0]) || count($param[0])!=0){
              $rs = $this->db_executeReader("product", "*", $join, "id='".$this->strip($param[0])."'");
              $data = $this->db_read($rs);
              $response = array("edit",$data,$param[0]);
              $this->product($response);
          }else{
            $this->redirect (ADMIN_URL."product","Required data missing.~err");  
          }
      }

    public function updateproduct(){
        $this->isAuthAdmin("product", "Edit");
        $id = $this->strip($_POST['productid']);
        $photo = $this->db_executeSingle("product", "photos", "id=$id");
        $photo = $photo."||";
        for($j=0;$j<count($_FILES['productImg']['name']);$j++){
            if($_FILES['productImg']['name'][$j]!="" && in_array($_FILES['productImg']['name'][$j], $_POST['newImgs'])){
                $uploadfile=$_FILES["productImg"]["tmp_name"][$j];
                $img_name = $_FILES['productImg']['name'][$j];
                $extension = end(explode(".", $img_name));
                $new_name = explode(".", $img_name)[0]."_".rand()."_".date('Ymdi').".".$extension;                
                move_uploaded_file($uploadfile, __DIR__."/../assets/products/".$new_name);  
                $resized = $this->resize_image(__DIR__."/../assets/products/".$new_name, 512, 600,FALSE,'products');
                header('Content-Type: text/html');
                $photo .= $resized."||";
            }

        }
        $imgurls = rtrim($photo,"||");
        //die();
        $productcat = $this->strip($_POST['productcat']);
        $prefix = substr(strtoupper($productcat),0,3);
        foreach ($_POST['saveas'] as $value) {
           $productas .= $value.","; 
        }
        $productas = rtrim($productas, ",");
        $this->db_Update("product", "cat,productname,brand,strikeprice,offer,"
                    . "price,unit,productkey,productas,productDesc,photos", 
                $productcat."~".$this->strip($_POST['productname'])."~".
                $this->strip($_POST['brand'])."~".$this->strip($_POST['strikeprice'])."~".
                $this->strip($_POST['offer'])."~".$this->strip($_POST['price'])."~".
                $this->strip($_POST['unit'])."~".$this->strip($_POST['productkey'])."~".
                $productas."~".$this->strip($_POST['newsdetails'])."~".$imgurls,"id=$id",false);
        $this->redirect(ADMIN_URL."editproduct/$id", "Product Updated Successfully!~suc");
    }
    
        public function deleteProductImg(){        
        $imgpath = $this->db_executeSingle("product", "photos","id='".$this->strip($_POST['id'])."'","",false);
        $url = $_POST['src'];
        $len = strlen(BASE_URL);
        $new_path = substr($url, $len, strlen($url)-$len);
        $new_path = __DIR__."/../".$new_path;
        $filename = "thumb_".basename($new_path);
        $thumb = __DIR__."/../assets/products/".$filename;
        if(file_exists($new_path)){
            unlink($new_path);
            unlink($thumb);
         }
        $imgpath = str_replace($url, "", $imgpath);
        $this->db_Update("product", "photos", $imgpath, "id='".$this->strip($_POST['id'])."'", false);
        
        echo '1';
    
    }
    
    public function deleteproduct(){
        $imgpath = $this->db_executeSingle("product", "photos","id='".$this->strip($_POST['id'])."'","",false);
        $urls = explode("||", $imgpath);
        foreach ($urls as $url) {
            $len = strlen(BASE_URL);
            $new_path = substr($url, $len, strlen($url)-$len);
            $new_path = __DIR__."/../".$new_path;
            if(file_exists($new_path)){
                unlink($new_path);
             } 
        }
        if($this->db_delete("product", "id='".$this->strip($_POST['id'])."'", false)){
           echo '1'; 
        }else{
           echo '2'; 
        }
    }

    
  //////////////////////////////////////////////////////////////////
    
  //********************Add/Update Profile*************************//   
    
    
    public function manageProfile($param){  
        $this->isAuthAdmin("manageProfile", "Show");
            
            if(isset($_POST['search']) || ($param[0]!="")){
                $SearchProfile = $_POST['SearchProfile'];
                $SearchCriteria = $_POST['SearchCriteria'];
                $SearchValue = $_POST['SearchValue'];
                $show = false;
                 $action1 = explode("_", base64_decode($param[1]));
                 
                    if($action1[0]=="editbrid"){
                        $this->isAuthAdmin("manageProfile", "Edit");
                        $rs_edit = $this->db_executeReader("Profile", "*", "", "id = ".$action1[1],"",false);
                        $profileid = $this->db_executeSingle("profile", "Loginid", "id = ".$action1[1]);
                        $rrs = $this->db_executeReader("profile_child", "*", "", "profileid = '".$profileid."' AND child='son'","",false);
                        while ($dd = $this->db_read($rrs)) {
                            $data['son'][] = $dd;
                        }
                        $childs = json_encode($data);
                        $rrd = $this->db_executeReader("profile_child", "*", "", "profileid = '".$profileid."' AND child='daughter'","",false);
                        while ($dd = $this->db_read($rrd)) {
                            $data1['daughter'][] = $dd;
                        }
                       $childd = json_encode($data1);
                    }
                    if($action1[0]=="viewbrid"){
                        $this->isAuthAdmin("manageProfile", "Show");
                        $rs_edit = $this->db_executeReader("Profile", "*", "", "id = ".$action1[1],"",false);
                        $profileid = $this->db_executeSingle("profile", "Loginid", "id = ".$action1[1]);
                        $rrs = $this->db_executeReader("profile_child", "*", "", "profileid = '".$profileid."' AND child='son'","",false);
                        while ($dd = $this->db_read($rrs)) {
                            $data['son'][] = $dd;
                        }
                        $childs = json_encode($data);
                        $rrd = $this->db_executeReader("profile_child", "*", "", "profileid = '".$profileid."' AND child='daughter'","",false);
                        while ($dd = $this->db_read($rrd)) {
                            $data1['daughter'][] = $dd;
                        }
                       $childd = json_encode($data1);
                       $show = true;
                    }
                    if($action1[0]=="deletebrid"){  
                        $this->isAuthAdmin("manageProfile", "Delete");
                        $this->db_delete("Profile", "id = ".$action1[1],FALSE);  
                    }
                    $response = array("edit",$rs_search,$rs_edit,$childs,$childd,$show);
            }
            $this->render("../view/admin/manageProfile.php", $response);
        }
        
    public function searchprofile($param){
        
        $this->isAuthAdmin("manageProfile", "Show");
            if(isset($_POST['search']) || isset($_POST['editprofile']) || isset($_POST['deleteprofile'])){
                $SearchProfile = $_POST['SearchProfile'];
                $SearchCriteria = $_POST['SearchCriteria'];
                $SearchValue = $_POST['SearchValue'];
                
                if($this->is_not_empty($_POST,"SearchProfile~@~SearchCriteria~@~SearchValue")){
                    if($action1[0]=="editbrid"){
                        $this->isAuthAdmin("manageProfile", "Edit");
                        $rs_edit = $this->db_executeReader("Profile", "*", "", "id = ".$action1[1],"",false); 
                    }
                    if($action2[0]=="deletebrid"){  
                        $this->isAuthAdmin("manageProfile", "Delete");
                        $pht = $this->db_executeReader("Profile", "photo,phot1,photo2", "", "id = ".$action1[1],"",false);
                        $photo = $this->db_read($pht);
                        foreach ($photo as $value) {
                            $url = $value;
                            $len = strlen(PUBLIC_URL);
                            $new_path = substr($url, $len, strlen($url)-$len);
                            $new_path = __DIR__."/../".$new_path;
                            if(file_exists($new_path)){
                               unlink($new_path);
                            }
                        }
                        $this->db_delete("Profile", "id = ".$action2[1],FALSE);  
                    }
                    if($SearchValue!=""){
                        $cond = " profile.LoginID like '$SearchValue%' OR name like "
                                . "'%$SearchValue%' OR fname like'%$SearchValue%' OR mobile like '%$SearchValue%' OR"
                                . " email like '%$SearchValue%' OR gender like '$SearchValue%' OR "
                                . "occu like '%$SearchValue%' OR city like '$SearchValue%' OR "
                                . " location like '%$SearchValue%'";
                    }else{
                        $cond = " 1=1 ";
                        if($SearchProfile!="All" && $SearchProfile!=""){
                           $cond .= " AND status=".$SearchProfile." "; 
                        }
                        if($SearchCriteria!="All" && $SearchCriteria!=""){
                           if($SearchCriteria=="User"){
                              $cond .= " AND reg_by NOT IN(0,1) "; 
                           }else{
                              $cond .= " AND reg_by=".$SearchCriteria." ";  
                           }

                        }
                    }
                    $rs_search = $this->db_executeReader("profile", "profile.*, (CASE WHEN (reg_by = 0) THEN 'Self' ELSE l. displayname END) as addedby", " LEFT JOIN Login l on l.id = reg_by", $cond,"",false);
                    $response = array("edit",$rs_search,$rs_edit);
                }else{
                    $this->redirect(ADMIN_URL."manageProfile", "Please fill all mandatory field.~err");
                }
            }
            $this->render("../view/admin/searchprofile.php", $response);
    }   
    
    public function exportsearchprofile($param){
        
        $this->isAuthAdmin("manageProfile", "Show");
                $SearchProfile = $_GET['SearchProfile'];
                $SearchCriteria = $_GET['SearchCriteria'];
                $SearchValue = $_GET['SearchValue'];
                    if($SearchValue!=""){
                        $cond = " profile.LoginID like '$SearchValue%' OR name like "
                                . "'%$SearchValue%' OR fname like'%$SearchValue%' OR mobile like '%$SearchValue%' OR"
                                . " email like '%$SearchValue%' OR gender like '$SearchValue%' OR "
                                . "occu like '%$SearchValue%' OR city like '$SearchValue%' OR "
                                . " location like '%$SearchValue%'";
                    }else{
                        $cond = " 1=1 ";
                        if($SearchProfile!="All" && $SearchProfile!=""){
                           $cond .= " AND status=".$SearchProfile." "; 
                        }
                        if($SearchCriteria!="All" && $SearchCriteria!=""){
                           if($SearchCriteria=="User"){
                              $cond .= " AND reg_by NOT IN(0,1) "; 
                              $addedby = "Admin User";
                           }else{
                              $cond .= " AND reg_by=".$SearchCriteria." ";  
                              $addedby = ($SearchCriteria==0)?"Member Self":"Admin";
                           }

                        }
                    }
             $rs = $this->db_executeReader("profile", "profile.*, (CASE WHEN (reg_by = 0) THEN 'Self' ELSE l. displayname END) as addedby", " LEFT JOIN Login l on l.id = reg_by", $cond,"",false);
             $objPHPExcel = $this->excelHeader();
             $file = "Registered_Member_".date("d-M-Y").".xls";
             $objPHPExcel->getProperties()->setCreator(SITE_NAME." - ".auth::Get_displayName())
             ->setLastModifiedBy(SITE_NAME."_".auth::Get_userName())
             ->setTitle("Registered_Member_".date("d-M-Y"))
             ->setSubject("Registered_Member_".date("d-M-Y"))
             ->setKeywords("Registered Member Excel")
             ->setCategory("Registered Member Excel");
             $styleArray = array(
                 'alignment' => array(
                     'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                 ),
                 'alignment' => array(
                     'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP,
                 ),
                 'borders' => array(
                     'allborders' => array(
                         'style' => PHPExcel_Style_Border::BORDER_HAIR,
                     )
                 )
             );
             $headerArray = array(
                 'font' => array(
                     'bold' => true,
                 ),
                 'alignment' => array(
                     'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                 ),
                 'alignment' => array(
                     'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP,
                 ),
                 'borders' => array(
                     'allborders' => array(
                         'style' => PHPExcel_Style_Border::BORDER_THIN,
                     )
                 )
             );
             $c = 'A';
             while($c <= 'G'){
             $objPHPExcel->getActiveSheet()->getColumnDimension($c)->setAutoSize(true);
             $c++;
             }
             $objPHPExcel->getActiveSheet()->mergeCells('A1:G1');
             $objPHPExcel->getActiveSheet()->mergeCells('A2:G2');
             $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', SITE_NAME." - ".auth::Get_displayName());
             $objPHPExcel->getActiveSheet()->getStyle('A1:G1')->applyFromArray($styleArray);
             $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', ($SearchValue!="")?"Search Keyword: ".$SearchValue:"");
             $objPHPExcel->getActiveSheet()->getStyle('A2:G2')->applyFromArray($styleArray);
             $objPHPExcel->getActiveSheet()->mergeCells('A3:C3');
             $objPHPExcel->getActiveSheet()->mergeCells('D3:G3');
             $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', 'Status:  '.$SearchProfile);
             $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3', 'Added By: '.$SearchCriteria);
             $objPHPExcel->setActiveSheetIndex(0)
                         ->setCellValue('A4', 'Sn.')
                         ->setCellValue('B4', 'Profile ID')
                         ->setCellValue('C4', 'Personal Detail')
                         ->setCellValue('D4', 'Contact Detail')
                         ->setCellValue('E4', 'Occupation Detail')
                         ->setCellValue('F4', 'Family Detail')
                         ->setCellValue('G4', 'Other Detail');
             $objPHPExcel->getActiveSheet()->getStyle('A4:G4')->applyFromArray($headerArray);
         $count = 4;
         while($row = $this->db_read($rs)){       
             $count++;  
             $logininfo = "Id: ".$row['LoginID']."\n"."Pwd: ".$row['password'];
             $personal = "Name: ".$row['name']."\n"."DOB: ".$this->formatdate($row['dob'],"d-m-Y")
                            ."\n"."Gender: ".$row['gender']
                            ."\n"."Marital Status: ".$row['mstatus']
                            ."\n"."Caste: ".$row['caste']
                            ."\n"."Subcaste: ".$row['subcaste'];
             $contact = "Mobile: ".$row['mobile']
                            ."\n"."Email: ".$row['email']
                            ."\n"."Landline: ".$row['stdcode']."-".$row['phone']
                            ."\n"."City: ".$row['city']
                            ."\n"."Location: ".$row['location'];
             $Occupation = "Education: ".$row['edu']
                            ."\n"."Occupation: ".$row['occu']
                            ."\n"."Office Contact: ".$row['o_contact'];
             $family = "Father Name: ". stripslashes($row['fanme'])
                            ."\n"."Father DoB: ".$this->formatdate($row['fdob'],"d-m-Y")
                            ."\n"."Mother Name: ".stripslashes($row['mname'])
                            ."\n"."Mother DoB: ".$this->formatdate($row['mdob'],"d-m-Y")
                            ."\n"."Brothers: ".$row['brother']
                            ."\n"."Sister: ".$row['sister'];
                            if($row['mstatus']!="Unmarried"){
                            echo "\n"."Unmarried Son: ".$row['sonunmarried']
                            ."\n"."Unmarried Daughter: ".$row['daughterunmarried'];
                            }
              $other = "Reg Date: ".$this->formatdate($row['reg_date'],"d-m-Y")
                                        ."\n"."Reg By: ".$row['addedby'];
             $objPHPExcel->setActiveSheetIndex(0)
                         ->setCellValue('A'.$count, ($count - 4))                    
                         ->setCellValue('B'.$count, $logininfo)
                         ->setCellValue('C'.$count, $personal)
                         ->setCellValue('D'.$count, $contact)                    
                         ->setCellValue('E'.$count, $Occupation)
                         ->setCellValue('F'.$count, $family)
                         ->setCellValue('G'.$count, $other);
             $objPHPExcel->getActiveSheet()->getStyle("A$count:G$count")->applyFromArray($styleArray);
         }

         $this->excelFooter($objPHPExcel,$file);
            
            
    }   
    

    
    public function addprofile($param){
        $this->isAuthAdmin("manageProfile", "Add");
        
        $son = $this->strip($_POST['son']);
        $sonunmarried = $this->strip($_POST['sonunmarried']);
        $daughter = $this->strip($_POST['daughter']);
        $daughterunmarried = $this->strip($_POST['daughterunmarried']);
           $gender=$this->strip($_POST['gender']);
           $mstatus=$this->strip($_POST['mstatus']);
           $password=$this->strip($_POST['password']);
           $email= strtolower($this->strip($_POST['email']));
           $caste=$this->ucf($this->strip($_POST['caste']));
           $subcaste=$this->ucf($this->strip($_POST['subcaste']));
           $dob=$this->formatdate($_POST['dob']);
           $ProfileName= $this->ucf($this->strip($_POST['ProfileName']));
           $city= $this->ucf($this->strip($_POST['city']));
           $Mobileno=$this->strip($_POST['Mobileno']);
           $STDcode=$this->strip($_POST['STDcode']);
           $Landline=$this->strip($_POST['Landline']);
           $PINcode=$this->strip($_POST['PINcode']);
           $occu= trim($this->strip($_POST['occu']));
           
           
           $orgni= $this->ucf($this->strip($_POST['orgni']));
           $desig= $this->ucf($this->strip($_POST['desig']));
           $off_addr= $this->ucf($this->strip($_POST['off_addr']));
           $off_cont= $this->strip($_POST['off_cont']);
           
          
           $orgni_b= $this->ucf($this->strip($_POST['orgni_b']));
           $area_b= $this->ucf($this->strip($_POST['area_b']));
           $off_addr_b= $this->ucf($this->strip($_POST['off_addr_b']));
           $off_cont_b= $this->ucf($this->strip($_POST['off_cont_b']));
           $off_web_b= $this->ucf($this->strip($_POST['off_web_b']));
           $email_b= $this->ucf($this->strip($_POST['email_b']));
           $estab_b= $this->ucf($this->strip($_POST['estab_b']));
           
           if($occu=="Business"){
             $orgni = $orgni_b;   $off_addr = $off_addr_b;   $off_cont = $off_cont_b;
             $web = $off_web_b;   $off_email = $email_b;    $off_area = $area_b;
           }
           
           $sec_p= $this->ucf($this->strip($_POST['sec_p']));
           $profname= $this->ucf($this->strip($_POST['profname']));
           $area_p= $this->ucf($this->strip($_POST['area_p']));
           $off_web_p= $this->ucf($this->strip($_POST['off_web_p']));
           $email_p= $this->ucf($this->strip($_POST['email_p']));
           
           if($occu=="Professional"){
             $web = $off_web_p;   $off_email = $email_p; $off_area = $area_p;
           }
           
           $fname= $this->ucf($this->strip($_POST['fname']));
           $fage= $this->formatdate($_POST['fage']);
           $mname= $this->ucf($this->strip($_POST['mname']));
           $mage= $this->formatdate($_POST['mage']);
           $brother=$this->strip($_POST['brother']);
           $sister=$this->strip($_POST['sister']);
           
           $LoginID = parent::getUniqueId(true);
           $location = $this->db_executeSingle("area", "AreaName","id='".$this->strip($_POST['area'])."'");
           $educ = $this->db_executeSingle("education", "Education","Eduid='".$this->strip($_POST['educ'])."'");
            foreach ($_FILES as $key=>$value) {
                $uploadfile=$_FILES[$key]["tmp_name"];
                $img_name = $_FILES[$key]['name'];
                $extension = end(explode(".", $img_name));
                $new_name = explode(".", $img_name)[0]."_".rand()."_".date('Ymdi').".".$extension;                
                move_uploaded_file($uploadfile, __DIR__."/../assets/member/".$new_name);  
                $$key = $this->resize_image(__DIR__."/../assets/member/".$new_name, 517, 600,FALSE,'member');    
            }
            header('Content-Type: text/html'); 
            $this->db_Insert("profile","name,dob,caste,subcaste,mstatus,"
                    . "gender,email,mobile,phone,stdcode,pincode,"
                    . "city,location,edu,occu,o_organi,o_design,"
                    . "o_address,o_contact,o_area,o_web,o_email,o_estab,o_sector,"
                    . "o_prof,fname,fdob,mname,mdob,brother,sister,photo,photo1,photo2,reg_by,"
                    . "reg_date,status,LoginID,password,son,sonunmarried,daughter,daughterunmarried", 
                    $ProfileName."~".$dob."~".$caste."~".$subcaste."~".$mstatus.
                    "~".$gender."~".$email."~".$Mobileno."~".$Landline."~".$STDcode."~".$PINcode.
                    "~".$city."~".$location."~".$educ."~".$occu."~".$orgni."~".$desig.
                    "~".$off_addr."~".$off_cont."~".$off_area."~".$web."~".$off_email."~".
                    $estab_b."~".$sec_p."~".$profname."~".$fname."~".$fage."~".$mname."~".$mage.
                    "~".$brother."~".$sister."~".$photo."~".$photo1."~".$photo2.
                    "~".auth::Get_userID()."~".date("Y-m-d H:i:s")."~1~".
                    $LoginID."~".$password."~".$son."~".$sonunmarried."~".$daughter.
                    "~".$daughterunmarried, false); 

            $sql = "INSERT INTO profile_child(profileid,name,dob,job,child) values";   
            if($sonunmarried > 0){
               for($i=0;$i<count($_POST['unson']);$i++){ 
                    $Name= $this->ucf($this->strip($_POST['unson'][$i]['name']));
                    $job= $this->ucf($this->strip($_POST['unson'][$i]['job']));
                    $cdob=$this->formatdate($_POST['unson'][$i]['age']);
                    $sql .= "('$LoginID','".$Name."','$cdob','$job','son'),";
               }

            }
            if($daughterunmarried > 0){
               for($i=0;$i<count($_POST['undaughter']);$i++){ 
                    $Name= $this->ucf($this->strip($_POST['undaughter'][$i]['name']));
                    $job= $this->ucf($this->strip($_POST['undaughter'][$i]['job']));
                    $cdob=$this->formatdate($_POST['undaughter'][$i]['age']);
                    $sql .= "('$LoginID','".$Name."','$cdob','$job','daughter'),";
               }

            }
            
            $sql = rtrim($sql, ",");
            $this->db_execute($sql,FALSE);
            $msg = "Profile Added.~suc";
//            die();
           
        $this->redirect (ADMIN_URL."manageProfile",$msg);
    }    
    public function updateprofile($param){
        $son = $this->strip($_POST['son']);
        $sonunmarried = $this->strip($_POST['sonunmarried']);
        $daughter = $this->strip($_POST['daughter']);
        $daughterunmarried = $this->strip($_POST['daughterunmarried']);
           $gender=$this->strip($_POST['gender']);
           $mstatus=$this->strip($_POST['mstatus']);
           $password=$this->strip($_POST['password']);
           $email= strtolower($this->strip($_POST['email']));
           $caste=$this->ucf($this->strip($_POST['caste']));
           $subcaste=$this->ucf($this->strip($_POST['subcaste']));
           $dob=$this->formatdate($_POST['dob']);
           $ProfileName= $this->ucf($this->strip($_POST['ProfileName']));
           $city= $this->ucf($this->strip($_POST['city']));
           $Mobileno=$this->strip($_POST['Mobileno']);
           $STDcode=$this->strip($_POST['STDcode']);
           $Landline=$this->strip($_POST['Landline']);
           $PINcode=$this->strip($_POST['PINcode']);
           $occu= trim($this->strip($_POST['occu']));
           
           
           $orgni= $this->ucf($this->strip($_POST['orgni']));
           $desig= $this->ucf($this->strip($_POST['desig']));
           $off_addr= $this->ucf($this->strip($_POST['off_addr']));
           $off_cont= $this->strip($_POST['off_cont']);
           
          
           $orgni_b= $this->ucf($this->strip($_POST['orgni_b']));
           $area_b= $this->ucf($this->strip($_POST['area_b']));
           $off_addr_b= $this->ucf($this->strip($_POST['off_addr_b']));
           $off_cont_b= $this->ucf($this->strip($_POST['off_cont_b']));
           $off_web_b= $this->ucf($this->strip($_POST['off_web_b']));
           $email_b= $this->ucf($this->strip($_POST['email_b']));
           $estab_b= $this->ucf($this->strip($_POST['estab_b']));
           
           if($occu=="Business"){
             $orgni = $orgni_b;   $off_addr = $off_addr_b;   $off_cont = $off_cont_b;
             $web = $off_web_b;   $off_email = $email_b;    $off_area = $area_b;
           }
           
           $sec_p= $this->ucf($this->strip($_POST['sec_p']));
           $profname= $this->ucf($this->strip($_POST['profname']));
           $area_p= $this->ucf($this->strip($_POST['area_p']));
           $off_web_p= $this->ucf($this->strip($_POST['off_web_p']));
           $email_p= $this->ucf($this->strip($_POST['email_p']));
           
           if($occu=="Professional"){
             $web = $off_web_p;   $off_email = $email_p; $off_area = $area_p;
           }
           
           $fname= $this->ucf($this->strip($_POST['fname']));
           $fage= $this->formatdate($_POST['fage']);
           $mname= $this->ucf($this->strip($_POST['mname']));
           $mage= $this->formatdate($_POST['mage']);
           $brother=$this->strip($_POST['brother']);
           $sister=$this->strip($_POST['sister']);
           
           $LoginID = $this->strip($_POST['loginid']);
           $location = $this->db_executeSingle("area", "AreaName","id='".$this->strip($_POST['area'])."'");
           $educ = $this->db_executeSingle("education", "Education","Eduid='".$this->strip($_POST['educ'])."'");
            foreach ($_FILES as $key=>$value) {
                $uploadfile=$_FILES[$key]["tmp_name"];
                $img_name = $_FILES[$key]['name'];
                $url = $this->db_executeSingle("profile", "$key","LoginID='$LoginID'");
                if($uploadfile!=""){
                    $len = strlen(PUBLIC_URL);
                    $new_path = substr($url, $len, strlen($url)-$len);
                    $new_path = __DIR__."/../".$new_path;
                    if(file_exists($new_path)){
                       unlink($new_path);
                    } 
                    $extension = end(explode(".", $img_name));
                    $new_name = explode(".", $img_name)[0]."_".rand()."_".date('Ymdi').".".$extension;                
                    move_uploaded_file($uploadfile, __DIR__."/../assets/member/".$new_name);  
                    $$key = $this->resize_image(__DIR__."/../assets/member/".$new_name, 517, 600,FALSE,'member'); 
                }else{
                   $$key = $url;
                }               
            }
            header('Content-Type: text/html'); 
            $this->db_Update("profile","name,dob,caste,subcaste,mstatus,"
                    . "gender,email,mobile,phone,stdcode,pincode,"
                    . "city,location,edu,occu,o_organi,o_design,"
                    . "o_address,o_contact,o_area,o_web,o_email,o_estab,o_sector,"
                    . "o_prof,fname,fdob,mname,mdob,brother,sister,photo,photo1,photo2,reg_by,"
                    . "reg_date,status,password,son,sonunmarried,daughter,daughterunmarried", 
                    $ProfileName."~".$dob."~".$caste."~".$subcaste."~".$mstatus.
                    "~".$gender."~".$email."~".$Mobileno."~".$Landline."~".$STDcode."~".$PINcode.
                    "~".$city."~".$location."~".$educ."~".$occu."~".$orgni."~".$desig.
                    "~".$off_addr."~".$off_cont."~".$off_area."~".$web."~".$off_email."~".
                    $estab_b."~".$sec_p."~".$profname."~".$fname."~".$fage."~".$mname."~".$mage.
                    "~".$brother."~".$sister."~".$photo."~".$photo1."~".$photo2.
                    "~".auth::Get_userID()."~".date("Y-m-d H:i:s")."~1~".
                    $password."~".$son."~".$sonunmarried."~".$daughter.
                    "~".$daughterunmarried,"LoginID='$LoginID'",false); 
            $this->db_execute("DELETE FROM profile_child where profileid='$LoginID'",FALSE);
            $sql = "INSERT INTO profile_child(profileid,name,dob,job,child) values";   
            if($sonunmarried > 0){
               for($i=0;$i<count($_POST['unson']);$i++){ 
                    $Name= $this->ucf($this->strip($_POST['unson'][$i]['name']));
                    $job= $this->ucf($this->strip($_POST['unson'][$i]['job']));
                    $cdob=$this->formatdate($_POST['unson'][$i]['age']);
                    $sql .= "('$LoginID','".$Name."','$cdob','$job','son'),";
               }

            }
            if($daughterunmarried > 0){
               for($i=0;$i<count($_POST['undaughter']);$i++){ 
                    $Name= $this->ucf($this->strip($_POST['undaughter'][$i]['name']));
                    $job= $this->ucf($this->strip($_POST['undaughter'][$i]['job']));
                    $cdob=$this->formatdate($_POST['undaughter'][$i]['age']);
                    $sql .= "('$LoginID','".$Name."','$cdob','$job','daughter'),";
               }

            }
            
            $sql = rtrim($sql, ",");
            $this->db_execute($sql,FALSE);
            $msg = "Profile Updated.~suc";
           
            $this->redirect(ADMIN_URL."manageProfile",$msg);
    }
    
    // DIRECT CHANGE NEWS STATUS//
    public function changeMemSts($param){
            $id = ($param[0]!="")?$param[0]:"";
            $sts = ($param[1]!="")?$param[1]:"";
            if($id!="" && $sts!=""){ 
                $this->db_update("profile","status",$sts,"id='".$this->strip($id)."'",false);            
              echo "1";  
            }else{
                  echo "2";  
            }
    }
 //*************************************************************//

//**************** Area Master ****************//
    
    
    public function managearea($param) {
        $this->isAuthAdmin(__FUNCTION__, "Show", "manageArea");
        $this->render("../view/admin/manageArea.php", $param);
    }
            // //
    
    
    // LIST AREA FROM AJAX INTO DATATABLES //
    public function getAreaRecord($param){
        $search = $_POST['search']['value'];
        $cond = ($search!="")?" (AreaName like '".$search."%')":"1=1";
        $limit = $param[0];
        $cpage = $param[1];
        if($cpage==1){
            $start = 0; 
           }else{
               $start = ($cpage * $limit) - $limit;
           }
        $lim = " limit $start ,$limit";
        $lim = ($cond!="1=1")?"":$lim;
        $draw = $_POST['draw'];$result = array();
        $rs = $this->db_execute("select * from Area where $cond order by AreaName $lim", false);
        $count = ($cpage==0)?0:($cpage-1)*$limit;
        while ($row = $this->db_read($rs)){
            $action = '<button class="btn btn-flat btn-warning" onclick="window.location.href=\''.ADMIN_URL.'editarea/'.$row['Id'].'\'">
                        Edit
                       </button> | 
                       <button class="btn btn-flat btn-danger" onclick="deleteArea('.$row['Id'].')">
                           Delete
                        </button>';
            $data = array("DT_RowId" => "row_".$row['Id'],++$count,"".$row['AreaName']."",$action);
            array_push($result, $data);
        }
        $response = array( "draw" => $draw );
        $response['data'] = $result;
        echo json_encode($response);
    }
    // //

    
    // ADD AREA  //
    public function addarea($param) {
        $this->isAuthAdmin("managearea", "Add");
        extract($_POST);
        $cnt = $this->db_executeSingle("Area", "COUNT(*)","AreaName='".$this->strip($areaname)."'","",FALSE);
        if($cnt > 0){
            $msg = "Duplicate area name.~err";
        }else{
            $this->db_Insert("Area","AreaName,user_id,entrytime", $this->ucf($this->strip($areaname))."~".auth::Get_userID().
                    "~". date("Y-m-d H:i:s"), false); 
            $msg = "Area Added.~suc";
        }
        
        $this->redirect (ADMIN_URL."managearea",$msg);
    }
    // //
    
    // SHOW AREA DETAILS FOR EDIT //
    public function editarea($param) {
        $this->isAuthAdmin("managearea", "Edit");
        if(isset($param[0]) || count($param[0])!=0){
            $AreaName = $this->db_executeSingle("area", "AreaName","Id='".$this->strip($param[0])."'");
            $response = array("edit",$AreaName,$param[0]);
            $this->managearea($response);
        }else{
          $this->redirect (ADMIN_URL."managearea","Required data missing.~err");  
        }
    }
    // //
    
    // UPDATE NEW AREA DETAILS //
    public function updatearea(){
        $this->isAuthAdmin("managearea", "Edit");
        extract($_POST);
        $cnt = $this->db_executeSingle("area", "COUNT(*)","AreaName='".$this->ucf($this->strip($areaname))."' AND Id!=".$this->strip($_POST['id']));
        if($cnt > 0){
            $msg = "Duplicate area name.~err";
        }else{
            $this->db_Update("area","AreaName", $this->ucf($this->strip($areaname)),"Id=".$this->strip($_POST['id'])."",false); 
            $msg = "Area Updated.~suc";
        }
        $this->redirect (ADMIN_URL."managearea",$msg);
    }
    // //
    
    // DELETE AREA //
    public function deleteArea($param) {
        $this->isAuthAdmin("managearea", "Delete");
        if(isset($param[0]) || count($param[0])!=0){
            $this->db_delete("area", "Id='".$this->strip($param[0])."'",false);
                echo "1";
            }
        else{
            echo "2";  
        }
        
    }
    // //
    
//*********************************************//

    

  
//**************** cat Master ****************//
    
    
    public function managecat($param) {
        $this->isAuthAdmin(__FUNCTION__, "Show", "managecat");
        $this->render("../view/admin/managecat.php", $param);
    }
            // //
    
    
    // LIST News Cat FROM AJAX INTO DATATABLES //
    public function getcatRecord($param){
        $search = $_POST['search']['value'];
        $cond = ($search!="")?" (catName like '".$search."%')":"1=1";
        $limit = $param[0];
        $cpage = $param[1];
        if($cpage==1){
            $start = 0; 
           }else{
               $start = ($cpage * $limit) - $limit;
           }
        $lim = " limit $start ,$limit";
        $lim = ($cond!="1=1")?"":$lim;
        $draw = $_POST['draw'];$result = array();
        $rs = $this->db_execute("select * from cat where $cond order by catName $lim", false);
        $count = ($cpage==0)?0:($cpage-1)*$limit;
        while ($row = $this->db_read($rs)){
            $action = '<button class="btn btn-flat btn-warning" onclick="window.location.href=\''.ADMIN_URL.'editcat/'.$row['Id'].'\'">
                        Edit
                       </button> | 
                       <button class="btn btn-flat btn-danger" onclick="deletecat('.$row['Id'].')">
                           Delete
                        </button>';
            $data = array("DT_RowId" => "row_".$row['Id'],++$count,"".$row['catName']."",$action);
            array_push($result, $data);
        }
        $response = array( "draw" => $draw );
        $response['data'] = $result;
        echo json_encode($response);
    }
    // //

    
    // ADD News Cat  //
    public function addcat($param) {
        $this->isAuthAdmin("managecat", "Add");
        extract($_POST);
        $cnt = $this->db_executeSingle("cat", "COUNT(*)","catName='".$this->strip($catname)."'","",FALSE);
        if($cnt > 0){
            $msg = "Duplicate News Category name.~err";
        }else{
            $this->db_Insert("cat","catName,user_id,entrytime", $this->ucf($this->strip($catname))."~".auth::Get_userID().
                    "~". date("Y-m-d H:i:s"), false); 
            $msg = "News Category Added.~suc";
        }
        $this->redirect (ADMIN_URL."managecat",$msg);
    }
    // //
    
    // SHOW News Cat DETAILS FOR EDIT //
    public function editcat($param) {
        $this->isAuthAdmin("managecat", "Edit");
        if(isset($param[0]) || count($param[0])!=0){
            $catName = $this->db_executeSingle("cat", "catName","Id='".$this->strip($param[0])."'");
            $response = array("edit",$catName,$param[0]);
            $this->managecat($response);
        }else{
          $this->redirect (ADMIN_URL."managecat","Required data missing.~err");  
        }
    }
    // //
    
    // UPDATE NEW News Cat DETAILS //
    public function updatecat(){
        $this->isAuthAdmin("managecat", "Edit");
        extract($_POST);
        $cnt = $this->db_executeSingle("cat", "COUNT(*)","catName='".$this->ucf($this->strip($catname))."' AND Id!=".$this->strip($_POST['id']));
        if($cnt > 0){
            $msg = "Duplicate cat name.~err";
        }else{
            $this->db_Update("cat","catName", $this->ucf($this->strip($catname)),"Id=".$this->strip($_POST['id'])."",false); 
            $msg = "News Category Updated.~suc";
        }
        $this->redirect (ADMIN_URL."managecat",$msg);
    }
    // //
    
    // DELETE News Cat //
    public function deletecat($param) {
        $this->isAuthAdmin("managecat", "Delete");
        if(isset($param[0]) || count($param[0])!=0){
            $this->db_delete("cat", "Id='".$this->strip($param[0])."'",false);
                echo "1";
            }
        else{
            echo "2";  
        }
        
    }
    // //
    
//*********************************************//    
    
    
    
//**************** City Master ****************//
    
    
    public function manageCity($param) {
            $this->isAuthAdmin("manageCity", "Show");
            $this->render("../view/admin/manageCity.php", $param);
        }
            // //
    
    
    // LIST CITY FROM AJAX INTO DATATABLES //
    public function getCityRecord($param){
        $search = $this->ucf($_POST['search']['value']);
        $cond = ($search!="")?" (CityName like '".$search."%') OR StateId IN(select Id from State where StateName like '".$search."%') OR DistrictID IN(select Id from District where Districtname like '".$search."%')":"1=1";
        $limit = $param[0];
        $cpage = $param[1];
        if($cpage==1){
            $start = 0; 
           }else{
               $start = ($cpage * $limit) - $limit;
           }
        $lim = " limit $start ,$limit";
        $lim = ($cond!="1=1")?"":$lim;
        $draw = $_POST['draw'];$result = array();
        $rs = $this->db_execute("select Id,cityname,StateId,DistrictID from City where $cond order by StateId,DistrictID,cityname $lim", false);
        $count = ($cpage==0)?0:($cpage-1)*$limit;
        while ($row = $this->db_read($rs)){
            $statename = $this->db_executeSingle("State", "StateName", "Id={$row['StateId']}");
            $districtname = $this->db_executeSingle("District", "Districtname", "Id={$row['DistrictID']}");
            $action = '<button class="btn btn-flat btn-warning" onclick="window.location.href=\''.ADMIN_URL.'editCity/'.$row['Id'].'\'">
                        Edit
                       </button> | 
                       <button class="btn btn-flat btn-danger" onclick="deleteCity('.$row['Id'].')">
                           Delete
                        </button>';
            $data = array("DT_RowId" => "row_".$row['Id'],++$count,
                $this->ucf($statename),
                $this->ucf($districtname),
                $row['cityname'],$action);
            array_push($result, $data);
        }
        $response = array( "draw" => $draw );
        $response['data'] = $result;
        echo json_encode($response);
    }
    // //

    
    // ADD CITY  //
    public function addCity($param) {
        //print_r($_POST);
        $this->isAuthAdmin("manageCity", "Add");
        $districtId = $this->strip($_POST['districtId']);
        $districtId_input = $this->strip($_POST['districtId_input']);
        $Cityname = $this->strip($_POST['Cityname']);
        $StateName = $this->strip($_POST['StateName']);
        $districtId = $this->db_executeSingle("District", "Id", "Districtname='".$this->ucf($districtId_input)."' and StateId='$StateName'");
        
        $cnt = $this->db_executeSingle("City", "COUNT(*)","cityname='".strtoupper($this->strip($Cityname))."' AND StateId= ".$this->strip($StateName)."  AND DistrictID= ".$this->strip($districtId)."","",FALSE);
        if($cnt > 0){
            $msg = "Duplicate City name in selected criteria.~err";
        }else{
            $this->db_Insert("City","cityname,user_id,StateId,DistrictID,entrytime", $this->ucf($this->strip($Cityname))."~".auth::Get_userID()."~".
                    $this->strip($StateName)."~".$this->strip($districtId).
                    "~". date("Y-m-d H:i:s"), true);
            $msg = "City Added.~suc";
        }

        $this->redirect (ADMIN_URL."manageCity",$msg);
    }
    // //
    
    // SHOW CITY DETAILS FOR EDIT //
    public function editCity($param) {
        $this->isAuthAdmin("manageCity", "Edit");
        if(isset($param[0]) || count($param[0])!=0){
            $cityname = $this->db_executeSingle("City", "cityname","Id='".$this->strip($param[0])."'");
            $stateid = $this->db_executeSingle("City", "StateId","Id='".$this->strip($param[0])."'");
            $districtid = $this->db_executeSingle("City", "DistrictId","Id='".$this->strip($param[0])."'");
            $response = array("edit",$stateid,$districtid,$this->ucf($cityname),$param[0]);
            $this->manageCity($response);
        }else{
          $this->redirect (ADMIN_URL."manageCity","<p".MSG_ERR.">Required data missing.</p>");  
        }
    }
    // //
    
    // UPDATE NEW CITY DETAILS //
    public function updateCity(){
        $this->isAuthAdmin("manageCity", "Edit");
        extract($_POST);
        $cnt = $this->db_executeSingle("City", "COUNT(*)","cityname='".$this->ucf($this->strip($Cityname))."'  AND StateId= ".$this->strip($StateName)."  AND DistrictID= ".$this->strip($districtId)." AND Id!=".$this->strip($_POST['id']));
        if($cnt > 0){
            $msg = "<p".MSG_ERR.">Duplicate City name in Selected Criteria.</p>";
        }else{
            $this->db_Update("City","cityname,user_id,StateId,DistrictID", $this->ucf($this->strip($Cityname))."~".auth::Get_userID()."~".
                    $this->strip($StateName)."~".$this->strip($districtId),"Id=".$this->strip($_POST['id'])."",false); 
            $msg = "City Updated.~suc";
        }
        $this->redirect (ADMIN_URL."manageCity",$msg);
    }
    // //
    
    // DELETE CITY //
    public function deleteCity($param) {
        $this->isAuthAdmin("manageCity", "Delete");
        if(isset($param[0]) || count($param[0])!=0){
            $this->db_delete("City", "Id='".$this->strip($param[0])."'",false);
                echo "1";
            }
        else{
            echo "2";  
        }
        
    }
    // //
    
//*********************************************//    
    
    
 //****************  Manage News ****************//
    
    
    
    public function createnews($param) {
        // DELETING OLD UNUSED IMAGES //

        if(isset($_SESSION["delete_img"])){
            $string = $_SESSION["delete_img"];
            $images = explode("||", $string);
            foreach ($images as $value) {   
                $len = strlen(PUBLIC_URL);
                $new_path = substr($value, $len, strlen($value)-$len);
                $new_path = __DIR__."/../".$new_path;
                if(file_exists($new_path)){
                   unlink($new_path);
                } 
            }
        }
        // //
        $_SESSION["delete_img"]="";// DELETING OLD IMAGES RECORD
        unset($_SESSION["delete_img"]);
        $response = array('list',"Add");
        $this->render("../view/admin/createnews.php", $response);
    }

   // Add NEWS//
    
        public function editnews($param) {
        $rs = $this->db_execute("select * from news where newsId=".$param[0]."", FALSE);
        $data = $this->db_read($rs);
        $response = array('list',"Edit",$data);
        $this->render("../view/admin/createnews.php", $response);
    }
    
    // SHOW NEWS LIST REQUEST BY AJAX //
    public function getNewsRecord($param){
        $search = $_POST['search']['value'];
        $cond = ($search!="")?"( (title like '%".$search."%') OR (news_date like '%".$search."%'))":"1=1";
        $limit = $param[0];
        $cpage = $param[1];
        $date1 = $param[2];
        $date2 = $param[3];
        $status = $param[4];
        $addedby = $param[5];
        if($cpage==1){
            $start = 0; 
           }else{
               $start = ($cpage * $limit) - $limit;
           }
        $datecond = " news_date between '".$date1."' AND '".$date2."'";
        if($status!="All"){
            $datecond .= " AND status=$status " ;
         }
         if($addedby!="All"){
            if($addedby=="user"){
               $datecond .= " AND added_by NOT IN (0,1) " ; 
            }else{
               $datecond .= " AND status=$addedby " ; 
            }  
         }
        $lim = " LIMIT $start,$limit";
        $lim = ($cond!="1=1")?"":$lim;
        $draw = $_POST['draw'];$result = array();
        $rs = $this->db_execute("select news.*,( CASE WHEN status=0 THEN 'Un-verified' WHEN status=1 THEN 'Verified' ELSE 'Blocked' END) as sts from news where $cond AND $datecond order by newsId DESC $lim", FALSE);
        $count = ($cpage==0)?0:($cpage-1)*$limit;
        while ($row = $this->db_read($rs)){
            $action = '<a class="btn btn-flat btn-primary"  target="_blank" href="'.ADMIN_URL.'editnews/'.$row['newsId'].'">
                        Edit
                       </a> | 
                       <button class="btn btn-flat btn-danger" onclick="deleteNews('.$row['newsId'].')">
                           Delete
                        </button> | ';
                          if($row['status']==0){ 
                            $action .='<button type="button" class="btn btn-flat btn-success" onclick="return changeNewsSts('.$row['newsId'].',1)">
                                    Verify
                                </button> | 
                                <button type="button" class="btn btn-flat btn-warning" onclick="return changeNewsSts('.$row['newsId'].',2)">
                                    Block
                                </button>';
                                 }elseif($row['status']==1){ 
                                   $action .='<button type="button" class="btn btn-flat btn-info" onclick="return changeNewsSts('.$row['newsId'].',0)">
                                     Un-verify
                                   </button> |
                                   <button type="button" class="btn btn-flat btn-warning" onclick="return changeNewsSts('.$row['newsId'].',2)">
                                     Block
                                   </button>';
                                }elseif($row['status']==2){
                                $action .='<button type="button" class="btn btn-flat btn-success" onclick="return changeNewsSts('.$row['newsId'].',1)">
                                     Un-Block & Verify
                                   </button>';
                               } 
            $data = array("DT_RowId" => "row_".$row['newsId'],++$count,$row['title'],date("d M Y", strtotime($row['news_date'])),$row['sts'],$action);
            array_push($result, $data);
        }
        $response = array( "draw" => $draw );
        $response['data'] = $result;
        echo json_encode($response);
    }
    // // 
    
    public function addnews($param,$update=false,$img_old=array()) {
        foreach ($_POST['news_show_as'] as $key => $value) {
            $show_as .=$value.",";
        }
        if($_FILES['news_head_img']['name']!=""){
            $this->deleteImages($img_old);
            $head_img_name = $_FILES['news_head_img']['name'];
            $fl  = explode(".", $head_img_name);
            $extension = end($fl);
            $head_img = $_FILES['news_head_img']['tmp_name'];
            $new_name = $head_img_name."_".rand()."_".date('Ymd').".".$extension;
            move_uploaded_file($head_img, __DIR__."/../assets/newsimages/".$new_name);      
            $head_img_new = $this->resize_image(__DIR__."/../assets/newsimages/".$new_name, 780, 600);
            header("Content-Type: text/html header.");
        }else{
            $head_img_new = $img_old[0];  
            $string = $this->db_executeSingle("news", "used_images","newsId=$param[0]","",false);
        }
        $show_as = rtrim($show_as, ",");
        $string .= $_SESSION["delete_img"];
        $_SESSION["delete_img"]="";// DELETING OLD IMAGES RECORD
        unset($_SESSION["delete_img"]);
        if($head_img_new==""){
            $head_img_new = "../assets/newsimages/defaultnews.png";
        }
//        echo $string;
//        print_r($img_old);
//        die();
        $this->db_Insert("news", "title,content_title,header_image,used_images,video_link,news_date,"
                . "show_as,news_content,entrydate,image_caption,added_by",
        $this->strip($_POST['news_head'])."~".$this->strip($_POST['content_title'])."~".
                $this->strip($head_img_new)."~".$this->strip($string)."~".$this->strip($_POST['video_link'])."~".
                $this->formatdate($_POST['news_date'])."~".
                $this->strip($show_as)."~".$this->strip($_POST['newsdetails'])."~".
                date("Y-m-d h:i:s")."~".$this->strip($_POST['image_caption'])
                ."~".$this->userid, FALSE);
        $last_id = $this->db_InsertedId();
        if($update){
            $this->db_Update("news", "newsId",$param[0], "newsId=$last_id", FALSE);
            return TRUE;
            exit();
        }else{
            $msg = "News Added Successfully~suc";
            
            $this->redirect("createnews", $msg);
            exit();
        }
        
        
    }
    // //
   
    // DELETE IMAGES OF A NEWS //
    protected function deleteImages($img_old) {
        if(count($img_old)>0){
        
                foreach ($img_old as $value) {
                    $len = strlen(PUBLIC_URL);
                    $new_path = substr($value, $len, strlen($value)-$len);
                    $new_path = __DIR__."/../".$new_path;
                   if(file_exists($new_path)){
                       unlink($new_path);
                    } 
                }
                
            }
         return true;   
    }
    // //
    // // UPDATE NEWS //
    public function updatenews($param){
        $param = array($_POST['id']);
        $img_old = $this->fetchnewsimages($param);
//                print_r($img_old);
//        die();
        if($this->deletenews($param)){
            if($this->addnews($param,$update=TRUE,$img_old)){
                $msg = "News Update Successfully~suc";
                $this->redirect(ADMIN_URL."editnews/$param[0]", $msg);
            }
        }
        echo $msg;
    }
    // //
    
    
    // FETCH ALL USED IMAGES IN NEWS //
    protected function fetchnewsimages($param){
        $head_img_old = $this->db_ExecuteScalar("news", "header_image","","newsId=$param[0]","",false);
        $used_img = $this->db_ExecuteScalar("news", "used_images","","newsId=$param[0]","",false);
        $used_image = explode("||", rtrim($used_img['used_images'],"||"));
        $img_old = array($head_img_old['header_image']);
        foreach ($used_image as $value) {
            array_push($img_old, $value);
        }
        return $img_old;
    }
    // // 
    

    
    // DIRECT DELETE NEWS //
    public function deletens($param) {
        if(isset($param[0]) || count($param[0])!=0){
            $img_old = $this->fetchnewsimages($param);
            if($this->deleteImages($img_old)){
                
                $this->db_delete("news", "newsId='".$this->strip($param[0])."'",false);
            }
              echo "1";  
        }else{
              echo "2";  
        }
    }
    
    // DIRECT CHANGE NEWS STATUS//
    public function changeNewsSts($param){
            $newsid = ($param[0]!="")?$param[0]:"";
            $sts = ($param[1]!="")?$param[1]:"";
            if($newsid!="" && $sts!=""){ 
                $this->db_update("news","status",$sts,"newsId='".$this->strip($newsid)."'",false);            
              echo "1";  
            }else{
                  echo "2";  
            }
    }
    
    // DELETE NEWS FROM CLASS //
    protected function deletenews($param) {
        if(isset($param[0]) || count($param[0])!=0){
            $this->db_delete("news", "newsId='".$this->strip($param[0])."'",false);
                return TRUE;
        }else{
                return FALSE;
        }
    }
    // //
    
    // SHOW NEWS LIST ON MODYFYNEWS.PHP //
    public function modifynews($param) {
        $date1 = (isset($_GET['date1']))? $this->formatdate($_GET['date1']):date("Y-m-d",strtotime("-15days"));
        $date2 = (isset($_GET['date2']))?$this->formatdate($_GET['date2']):date("Y-m-d");
        $status = (isset($_GET['status']))?$this->strip($_GET['status']):"All";
        $addedby = (isset($_GET['addedby']))?$this->strip($_GET['addedby']):"All";
        $response = array("list",$date1,$date2,$status,$addedby);        
        $this->render("../view/admin/modifynews.php", $response);
    }
    // //
    
    // UPLOADING IMAGES ON SERVER TO USE IN EDITOR //
    public function uploadimage($param) {
        if(isset($_FILES['upload']['name'])){
            $file = $_FILES['upload']['tmp_name'];
            $file_name = $_FILES['upload']['name'];
            $file_name_array = explode(".", $file_name);
            $extension = end($file_name_array);
            $new_image_name = $this->generateRandomString(10).rand().".".$extension;
            chmod(__DIR__.'/../assets/'.$param[0], 0777);
            $allowed_extension  = array("jpg","png","jpeg");
            if(in_array($extension, $allowed_extension)){
                move_uploaded_file($file, __DIR__.'/../assets/'.$param[0].'/'.$new_image_name);
//                $handle = fopen("delete_img".$param[1].".txt", "a+");
//                fwrite($handle,SRC_URL."$param[0]/".$new_image_name."||");
//                fclose($handle);
                $_SESSION["delete_img".$param[1]] = (isset($_SESSION["delete_img".$param[1]]))?$_SESSION["delete_img".$param[1]].SRC_URL."$param[0]/".$new_image_name."||":SRC_URL."$param[0]/".$new_image_name."||";
                $function_number = $_GET['CKEditorFuncNum'];
                $url = SRC_URL."$param[0]/".$new_image_name;
                $message = '';
                echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($function_number,"
                        . "'$url','$message');</script>";
            }
        }
    }
    //*********************************************//

    //************ Page content Management***************//
    
    public function managecontent($param) {
        // DELETING OLD UNUSED IMAGES //
        if(isset($_SESSION["delete_img_page"])){
            //$string = file_get_contents("delete_img_page.txt");
            $string = $_SESSION["delete_img_page"];
            $images = explode("||", $string);
            foreach ($images as $value) {   
                $len = strlen(PUBLIC_URL);
                $new_path = substr($value, $len, strlen($value)-$len);
                $new_path = __DIR__."/../".$new_path;
                if(file_exists($new_path)){
                   unlink($new_path);
                } 
            }
        }
        // //
        $_SESSION["delete_img_page"]="";// DELETING OLD IMAGES RECORD
        unset($_SESSION["delete_img_page"]);
        $response = array('list',"Add");
        $this->render("../view/admin/managecontent.php", $response);
    }
    
    public function addcontent($param,$update=false,$img_old=array()) {
        
        $string = $this->db_executeSingle("pagecontant", "used_images","pagename='".$this->strip($_POST['pagename'])."'","",false);
        $string = $_SESSION["delete_img_page"];
        $_SESSION["delete_img_page"]="";// DELETING OLD IMAGES RECORD
        unset($_SESSION["delete_img_page"]);
//        echo $string;
//        print_r($img_old);
//        die();
        $this->db_Replace("pagecontant", "pagename,page_title,used_images,page_details,added_by,entrydate",
        $this->strip($_POST['pagename'])."~". $this->ucf($this->strip($_POST['pagetitle']))."~".
                $this->strip($string)."~".$this->strip($_POST['newsdetails'])
                ."~".$this->userid."~".date("Y-m-d h:i:s"),false);
        $msg = "Page Content Added Successfully~suc";
//              die();
        $this->redirect("managecontent", $msg);
        exit();
    }
    
    public function loadPageContent($param) {
        $pagename = $this->strip($_POST['pagename']);
        $returntyp = ($_POST['resptyp']=="")?"json":$_POST['resptyp'];
        $valid = $this->db_executeSingle("pagecontant", "count(id)", "pagename='$pagename'","",false);
        if($valid){
            $stmt = $this->db_executeReader("pagecontant", "*", "", "pagename='$pagename'") ;
            while ($row = $this->db_read($stmt)) {
               $resposnse['res']['info']['id'] = $row['id']; 
               $resposnse['res']['info']['page_title'] = $row['page_title']; 
               $resposnse['res']['info']['page_details'] = html_entity_decode(stripslashes($row['page_details']));
            }
            $resposnse['res']['error'] = 0;
        }else{
            $resposnse['res']['error'] = 1;
        }
        if($returntyp=="json"){
            echo json_encode($resposnse);
        }else{
           return $stmt; 
        }
    }
    
    //*********************** ENd *****************//
    
    
    //***************** Gallery *************************//
    
    public function creategallery($param) {
        $this->render("../view/admin/creategallery.php", $param);
        exit();
    }
        // ADD GALLERY //
    public function addGallery($param) {    
        $cnt = $this->db_ExecuteScalar("gallery", "COUNT(*)","","title='".$this->strip($_POST['title'])."'","",FALSE);
        if($cnt[0] > 0){
            $msg = "This Gallery Name Allready Used.~err";
        }else{
            $sql = "INSERT INTO gallery_images(images_path,galid,images_title) values";
            $images_up = $_POST['images_up'];
            for($i=0;$i<count($_FILES["upload_file"]["name"]);$i++)
             {
              $uploadfile=$_FILES["upload_file"]["tmp_name"][$i];
              $img_name = $_FILES['upload_file']['name'][$i];
              $phottitle = $_POST['phtname'][$i];
              $extension = end(explode(".", $img_name));
              $new_name = explode(".", $img_name)[0]."_".rand()."_".date('Ymdi').".".$extension;                
              move_uploaded_file($uploadfile, __DIR__."/../assets/gallery/".$new_name);  
              $resized = $this->resize_image(__DIR__."/../assets/gallery/".$new_name, 780, 600,FALSE,'gallery');
              if($_POST['default_img']==$img_name){
                    $head_img =   $resized;
                }
              if(in_array($img_name, $images_up)){
                  $sql .= "('$resized',GAL,'$phottitle'),";
              }
              header('Content-Type: text/html');          
             }
            $this->db_Insert("gallery","title,header_img,enatrydate",
                    $this->strip($_POST['title'])."~".$head_img."~".
                    date("Y-m-d h:i:s"), false); 
            $galid = $this->db_InsertedId();
            $sql = rtrim($sql, ",");
            $sql = str_replace('GAL', $galid, $sql);
            $this->db_execute($sql,FALSE);
         
            $msg = "Gallery Added.~suc";
        }
        $this->redirect (ADMIN_URL."creategallery",$msg);
    }
    
        // LIST GALLERY FROM AJAX INTO DATATABLES //
    public function getGalleryRecord($param){
        $search = $_POST['search']['value'];
        $cond = ($search!="")?" (title like '".$search."%')":"1=1";
        $limit = $param[0];
        $cpage = $param[1];
        if($cpage==1){
            $start = 0; 
           }else{
               $start = ($cpage * $limit) - $limit;
           }
        $lim = " LIMIT $start,$limit";
        $lim = ($cond!="1=1")?"":$lim;
        $draw = $_POST['draw'];$result = array();
        $rs = $this->db_execute("select * from gallery where $cond order by galid DESC $lim", false);
        $count = ($cpage==0)?0:($cpage-1)*$limit;
        while ($row = $this->db_read($rs)){
            $action = '<button class="btn btn-flat btn-warning" onclick="window.location.href=\''.ADMIN_URL.'editgallery/'.$row['galid'].'\'">
                        Edit
                       </button> | 
                       <button class="btn btn-flat btn-danger" onclick="deleteGallery('.$row['galid'].')">
                           Delete
                        </button>';
            $img ='<img class="img-thumbnail" style=" height: 80px;"  src="'.$row['header_img'].'" alt="'.$row['images_title'].'">';
            //$img = "<a class='btn btn-flat btn-info' href='".$row['header_img']."' target='_blank'>View</a>";
            $data = array("DT_RowId" => "row_".$row['galid'],++$count,"".$row['title']."",
                $img,
                $action);
            array_push($result, $data);
        }
        $response = array( "draw" => $draw );
        $response['data'] = $result;
        echo json_encode($response);
    }
    
    // SHOW GALLERY DETAILS FOR EDIT //
    public function editgallery($param) {
        if(isset($param[0]) || count($param[0])!=0){
            $title = $this->db_ExecuteScalar("gallery", "title","","galid='".$this->strip($param[0])."'");
            $head_img = $this->db_ExecuteScalar("gallery", "header_img","","galid='".$this->strip($param[0])."'");
            $imgs = $this->db_execute("select * from  gallery_images where galid='".$this->strip($param[0])."' order by id");
            $response = array("edit",$title,$head_img,$imgs,$param[0]);
            $this->creategallery($response);
        }else{
          $this->redirect (ADMIN_URL."creategallery","Required data missing.~err");  
        }
    }
    // //
    
        // UPDATE GALLERY
    
    public function updateGallery($param) {
        $cnt = $this->db_ExecuteScalar("gallery", "COUNT(*)","","title='".$this->strip($_POST['title'])."' and `galid`!='".$this->strip($_POST['id'])."'","",false);
        
        if($cnt[0] > 0){
            $msg = "This Gallery Name Allready Used.~err";
        }else{ 
            $head_img = $_POST['default_img'];
            
            $images_up = $_POST['images_up'];
            if(count($images_up)>0){
              $sql = "INSERT INTO gallery_images (images_path,galid,images_title) values";  
            } else {
               $sql='' ;
            }
            
            for($i=0;$i<count($_FILES["upload_file"]["name"]);$i++)
             {
              $uploadfile=$_FILES["upload_file"]["tmp_name"][$i];
              $img_name = $_FILES['upload_file']['name'][$i];
              $phottitle = $_POST['phtname'][$i];
              $extension = end(explode(".", $img_name));
              $new_name = explode(".", $img_name)[0]."_".rand()."_".date('Ymdi').".".$extension;
                move_uploaded_file($uploadfile, __DIR__."/../assets/gallery/".$new_name); 
                $resized = $this->resize_image(__DIR__."/../assets/gallery/".$new_name, 780, 600,FALSE,'gallery');
                if($_POST['default_img']==$img_name){
                    $head_img =   $resized;
                }
              if(in_array($img_name, $images_up)){
                  $sql .= "('$resized',GAL,'$phottitle'),";
              }
              
             }
             
             $oldids = explode(",", $_POST['oldids']);
             foreach ($oldids as $value) {
                 $this->db_Update("gallery_images", "images_title", $_POST['oldphtname'][$value], "id=$value");
             }
             header('Content-Type: text/html'); 
            $this->db_Update("gallery","title,header_img,enatrydate",
                    $this->strip($_POST['title'])."~".$head_img."~".
                    date("Y-m-d h:i:s"),"galid='".$this->strip($_POST['id'])."'", false); 
            $galid = $_POST['id'];
            $sql = rtrim($sql, ",");
            $sql = str_replace('GAL', $galid, $sql);
            if($sql!='')
            $this->db_execute($sql,false);
            $msg = "Gallery Updated.~suc";
        }
//        die();
        $this->redirect (ADMIN_URL."editgallery/{$_POST['id']}",$msg);
    }
    
    //
    
    // delete gallery //
    
    
    public function deleteGallery($param){
        $head_img = $this->db_ExecuteScalar("gallery", "header_img","galid='".$this->strip($param[0])."'");
        $imgs = $this->db_ExecuteScalar("gallery", "images","galid='".$this->strip($param[0])."'");
        $imgs = rtrim($imgs, "||");
        $images = explode("||", $imgs);
        foreach ($images as $value) {
            if(file_exists(__DIR__."/../assets/gallery/".$value)){
                unlink(__DIR__."/../assets/gallery/".$value);
             } 
         }
        unlink(__DIR__."/../assets/gallery/".$head_img);
        $this->db_delete("gallery", "galid='".$this->strip($param[0])."'");
        echo "1";
    }
    
    public function deletegalimage($param) {
        $imgpath = $this->db_ExecuteScalar("gallery_images", "images_path","","id='".$this->strip($param[0])."'","",false);
        $this->db_delete('gallery_images',"id='".$this->strip($param[0])."'" );
        $len = strlen(PUBLIC_URL);
        $new_path = substr($imgpath[0], $len, strlen($imgpath[0])-$len);
        $new_path = __DIR__."/../".$new_path;
        if(file_exists($new_path)){
            unlink($new_path);
         }
        echo '1';
    }
    
    //****************** End Gallery **********************//
    
    
    
    
    //////////////////////// Change password ///////////////////////
        public function changePassword() {
            $this->render("../view/admin/changePassword.php", $response);
    }
    public function updatepassword($response=""){
            
        if($this->is_not_empty($_POST,"txtoldpass~@~txtpass")){
            $isvalid = $this->db_executeSingle("Login","COUNT(loginid)","LoginPS='".$this->strip($_POST["txtoldpass"])."' and LoginID='admin'");
            if($isvalid > 0){
                 $this->db_Update("Login" ,"LoginPS",$this->strip($_POST["txtpass"]),"LoginPS='".$this->strip($_POST["txtoldpass"])."' and LoginID='admin'");
                 $msg = "Password Changed Successfully.~suc";
                }
            else{
               $msg = "Invalid old password~err";
            }
               
            }else{
                $msg = "Invalid Data.~err";
            }
            
            $this->redirect(ADMIN_URL."changepassword",$msg);
    }
    
    /////////////////////End////////////////////////////////////////
//******* User Accessability **************//    

    
  public function page_accessibility($param){
      $this->isAuthAdmin("page_accessibility", "Show");
            $role2 = isset($_POST["users"]) ? $this->strip($_POST["users"]) : "";
            $role1 = isset($param[0]) ? base64_decode($param[0]) : "";
            if($role2==""){
                $role=$role1;
            }else{
                $role=$role2;
            }
            if(strtolower($this->usertype)=="admin")
            {
                $this->render("../view/admin/page_accessibility.php", $role); 
            }
            else
            {
                $this->redirect(ADMIN_URL."adminhome", "Unauthorized Access!~err"); 
            }    

        }
        
        
  public function Save_page_accessibility(){ 
    $this->isAuthAdmin("page_accessibility", "Add");      
        $role = $this->strip($_POST["users"]);
        if($role!=""){
        $this->db_delete("user_accessibility_admin","userid=" .$_POST["users"]."",false);
        $post_keys = array_keys($_POST); 
        $added_by = auth::Get_userID();
        for ($i = 0; $i < sizeof($_POST); $i++) {
            $tmp = explode("-", $post_keys[$i]);         
            $name = $tmp[1];         
            $type = $tmp[0];
            if ($type != 'users' && $type != 'submit') {
                for($j=0; $j < count($_POST[$post_keys[$i]]); $j++){
                    $action = $_POST[$post_keys[$i]][$j];
                    $this->db_Insert("user_accessibility_admin", "userid,type,name,action,user_id", $role.'~'.$type.'~'.$name.'~'.$action."~".$added_by, FALSE);               
                }
           }
        }
      $return_url = "page_accessibility/".base64_encode($role);
     }else{
       $return_url = "page_accessibility";  
     }  

     $this->redirect(ADMIN_URL.$return_url, "Accessibility Saved!~suc");   
  }
  


    public function getUserRecord($param){
        $search = $_POST['search']['value'];
        $cond = ($search!="")?" ((l.DisplayName like '".$search."%') OR (l.mobileno like '$search%') OR (l.LoginID like '".$search."%')) AND l.type='adminuser'":"1=1";
        $limit = $param[0];
        $cpage = $param[1];
        if($cpage==1){
            $start = 0; 
           }else{
               $start = ($cpage * $limit) - $limit;
           }
        $lim = " limit $start ,$limit";
        $lim = ($cond!="1=1")?"":$lim;
        $cond .= " AND l.type='adminuser' "; 
        $draw = $_POST['draw'];$result = array();
        $rs = $this->db_execute("select l.*,"
                . " CASE WHEN l1.type='Admin' THEN l1.DisplayName ELSE l1.DisplayName +' ('+l1.LoginID+')' END as addedby "
                . "from Login l INNER JOIN Login l1 ON l.user_id=l1.Id where $cond order by l.DisplayName $lim", false);
        $count = ($cpage==0)?0:($cpage-1)*$limit;
        while ($row = $this->db_read($rs)){
            $action = '<button class="btn btn-flat btn-warning" onclick="window.location.href=\''.ADMIN_URL.'edituser/'.$row['ID'].'\'">
                        Edit
                       </button> | 
                       <button class="btn btn-flat btn-danger" onclick="deleteUser('.$row['ID'].')">
                           Delete
                        </button>';
            $data = array("DT_RowId" => "row_".$row['ID'],++$count,
                $row['DisplayName'],
                "<b>Login ID: </b>".$row['LoginID']."<br>"."<b>Password: </b>".$row['LoginPS'],
                $row['mobileno'],
                "<b>Added By: </b>".$row['addedby']."<br>"."<b>Entry Date: </b>".$this->formatdate($row['entrytime'], "d-M-Y H:i A"),
                $action);
            array_push($result, $data);
        }
        $response = array( "draw" => $draw );
        $response['data'] = $result;
        echo json_encode($response);
    }
    
   
    
    public function manageuser($param){
        $this->isAuthAdmin("manageuser", "Show");
      $this->render("../view/admin/manageuser.php", $param);
  }  
  public function adduser($param){
      $this->isAuthAdmin("manageuser", "Add");
      $valid = $this->db_executeSingle("Login", "COUNT(LoginID)", "LoginID='".$this->strip($_POST['userid'])."'");
      if($valid){ 
          $this->redirect("","Userid is already in use.~err",false);
           echo '<script>
              window.history.go(-1);
             </script>';
       exit(); }
       $this->db_Insert("Login", "LoginID,LoginPS,mobileno,DisplayName,role,entrytime,user_id,type", 
               $this->strip($_POST['userid'])."~".$this->strip($_POST['password'])."~".
              $this->strip($_POST['mobile'])."~". ucwords($this->strip($_POST['displayn']))."~".
              "1"."~".date("Y-m-d h:i:s")."~".$this->userid."~"."User",false);
//       die();
       $this->redirect(ADMIN_URL."manageuser", "User Added Successfully!~suc");

  }  
  public function edituser($param) {
        $this->isAuthAdmin("manageuser", "Edit");
        if(isset($param[0]) || count($param[0])!=0){
            $rs = $this->db_executeReader("Login", "ID,DisplayName,LoginID,LoginPS,mobileno", $join, "Id='".$this->strip($param[0])."'");
            $data = $this->db_read($rs);
            $response = array("edit",$data,$param[0]);
            $this->manageuser($response);
        }else{
          $this->redirect (ADMIN_URL."manageuser","Required data missing.~err");  
        }
    }

  public function updateuser(){
        $this->isAuthAdmin("manageuser", "Edit");
        $cnt = $this->db_executeSingle("Login", "COUNT(*)","LoginID='".$this->strip($_POST['userid'])."' AND ID!=".$this->strip($_POST['uid']));
        if($cnt > 0){
             $msg = "User id is already used.~err";
        }else{
            $this->db_Update("Login", "LoginID,LoginPS,mobileno,DisplayName,user_id", 
               $this->strip($_POST['userid'])."~".$this->strip($_POST['password'])."~".
              $this->strip($_POST['mobile'])."~". ucwords($this->strip($_POST['displayn']))."~".
              $this->userid,"ID=".$this->strip($_POST['uid']),false);
            $msg = "User Updated.~suc";
        }
      
        $this->redirect (ADMIN_URL."edituser/".$this->strip($_POST['uid']),$msg);
    }
  public function deleteUser($param) {
       $this->isAuthAdmin("manageuser", "Delete");
        if(isset($param[0]) || count($param[0])!=0){
            $this->db_delete("Login", "Id='".$this->strip($param[0])."'",false);
                echo "1";
            }
        else{
            echo "2";  
        }
        
    }
    
    
    
    public function isauthaction($linkname,$action,$area="subsection"){
        $isvalid = $this->db_executeSingle("user_accessibility_admin", "COUNT(*)", 
                "userid=".$this->userid." AND type='$area' AND name='$linkname' AND action='$action'","",false);
        $res =  ($isvalid)?true:false;
        return ($this->usertype=="admin")?true:$res;
    }
    
    private function isAuthAdmin($fname,$action){
      $count_role = $this->db_executeSingle("user_accessibility_admin","count(id)","userid =".$this->userid." AND name='".strtolower($fname)."' AND action='".strtolower($action)."'","",false);

      if($count_role > 0 || $this->usertype=="admin"){
         return true;
     }else{
         $this->redirect("adminhome","Unauthorized Access!~err");
         exit(0);
         echo "<script>"
         . "window.history.go(-1)</script>";
         
     }
    }
    
    public function links($param){
        $this->isAuthAdmin("links", "show");
        if(isset($_POST['psearch'])){
            $type = $_POST['link_type1'];
            $sectionid = $_POST['sectionid1'];
            if($type!='' && $type!='All'){
                $cond = " acl.type = '$type' and ";
            }
            if($sectionid!=""){
                    $cond = " acl.sectionid = $sectionid and ";
            }
            $cond .= " 1=1 ";
            $rs = $this->db_executeReader("accessibility_links_admin acl","acl.*"
                    . ",acl1.title as psec ", 
                    " LEFT JOIN accessibility_links_admin acl1 on acl1.id = acl.sectionid", 
                    $cond, "ORDER BY acl.type, acl.sectionid ", false);
            if($param[0]=='edit'){
                $id = base64_decode($param[1]);
                $rs1 = $this->db_executeReader("accessibility_links_admin acl","acl.*"
                    . ",acl1.title as psec ", 
                    " LEFT JOIN accessibility_links_admin acl1 on acl1.id = acl.sectionid", 
                    "acl.id = $id", "", false); 
            }
            $response = array("search",$rs,$rs1);
        } 
      $this->render("../view/admin/links.php", $response);
    } 
    public function addlinks($param){
        $this->isAuthAdmin("links", "add");
        $type = strtolower($this->strip($_POST['link_type']));
        $sectionid = $this->strip($_POST['sectionid']);
        $sectionid = ($sectionid=="")?0:$sectionid;
        $link_title = strtolower($this->strip($_POST['link_title']));
        $link = strtolower($this->strip($_POST['link']));
        $cnt= $this->db_executeSingle("accessibility_links_admin", "COUNT(*)", 
                      "linkname = '$link'");
        if($cnt > 0){
            $valid = false;
            $this->redirect("",$this->ucf($link)." ".$this->ucf($type)." already exists !~err",false);
            echo "<script>"
            . "window.history.go(-1)</script>";
            exit(0);
        }
        foreach($_POST['option'] as $key => $value){
            $$value = "1";
        }
        $this->db_Insert("accessibility_links_admin", "linkname,title,type,sectionid,`show`,ad,`edit`,del", 
               $link."~".$link_title."~".$type."~".$sectionid ."~".$Show."~".
                $Add."~".$Edit."~".$Delete, FALSE);
        
     
        $this->redirect (ADMIN_URL."links","Link Added!.~suc"); 
        
    } 
    
    public function updatelinks($param){
        $this->isAuthAdmin("links", "edit");
        $id = $_POST['id'];
        $type = strtolower($this->strip($_POST['link_type']));
        $sectionid = $this->strip($_POST['sectionid']);
        $sectionid = ($sectionid=="")?0:$sectionid;
        $link_title = strtolower($this->strip($_POST['link_title']));
        $link = strtolower($this->strip($_POST['link']));
        $cnt= $this->db_executeSingle("accessibility_links_admin", "COUNT(*)", 
                      "linkname = '$link' and id!=$id");
        if($cnt > 0){
            $valid = false;
            $this->redirect("",$this->ucf($link)." ".$this->ucf($type)."already exists !~err",false);
            echo "<script>"
            . "window.history.go(-1)</script>";
            exit(0);
        }
        foreach($_POST['option'] as $key => $value){
            $$value = "1";
        }
        $this->db_Update("accessibility_links_admin", "linkname,title,type,sectionid,`show`,ad,edit,del", 
               $link."~".$link_title."~".$type."~".$sectionid ."~".$Show."~".
                $Add."~".$Edit."~".$Delete," id = $id ",false);
        $this->redirect (ADMIN_URL."links","Link Updated!.~suc"); 
        
    } 
    
    public function getlink_type($param){
        $type = $param[0];
        if($type=="subsection"){
        $rs = $this->db_executeReader("accessibility_links_admin", "*", "",
                "type= 'section'", "");
        while($row = $this->db_read($rs)){
            $data['section'][] = $row;
        }
        echo json_encode($data);
        }else{
            echo "false";
        }
    } 
     public function deleteLink($param){
        $this->isAuthAdmin("link", "Delete");
        $id = $this->strip($param[0]);
        if($id){
            $this->db_delete("accessibility_links_admin", "id=$id ",false);
            $msg = "deleted";
        }else{
            $msg = "Invalid id ";
        }
        echo $msg;
    }
  //******* User Accessability End **************//    
  
  //////************* Slider Image ************///////////
   
    public function manageslider($param) {
        $rs = $this->db_executeReader("sliderimg", "*", "", "", "",false);
        
        $this->render("../view/admin/manageslider.php", array('list',$rs));
    }
    
    public function addSlider($param){
        $sql = "REPLACE INTO sliderimg(img_url,heading,name,line1,line2,added_by,updated_on) VALUES";
        for($i=1;$i<=5;$i++){
            $heading = $this->ucf($this->strip($_POST['img'.$i.'intro']));
            $line1 = $this->ucf($this->strip($_POST['img'.$i.'line1']));
            $line2 = $this->ucf($this->strip($_POST['img'.$i.'line2']));
            $updated_on = date("Y-m-d H:i:s");
            $photo = $this->db_executeSingle("sliderimg", "img_url", "name='photo$i'");
            $url = "";
            $uploadfile=$_FILES["upload_file".$i]["tmp_name"];
            if($uploadfile!=""){
                $img_name = $_FILES['upload_file'.$i]['name'];
                $extension = end(explode(".", $img_name));
                $new_name = explode(".", $img_name)[0]."_".rand()."_".date('Ymdi').".".$extension;                
                move_uploaded_file($uploadfile, __DIR__."/../assets/slider/".$new_name);  
                $url = $this->resize_image(__DIR__."/../assets/slider/".$new_name, 960, 330,FALSE,'slider');
                unlink(__DIR__."/../assets/slider/".$new_name);
                header('Content-Type: text/html');
                $len = strlen(BASE_URL);
                $new_path = substr($photo, $len, strlen($photo)-$len);
                $new_path = __DIR__."/../".$new_path;
                $filename = "thumb_".basename($new_path);
                $thumb = __DIR__."/../assets/slider/".$filename;
                if(file_exists($new_path)){
                   unlink($new_path);
                   unlink($thumb);
                }
            }
            if($url==""){
               $url = $photo;
            }
            $sql .= "('$url','$heading','photo$i','$line1','$line2',".$this->userid.",'$updated_on'),";
        }
        $sql = rtrim($sql, ",");
        $this->db_execute($sql, false);
        $msg = "Slider Images Updated~suc";
      
        $this->redirect(ADMIN_URL."manageslider", $msg);
    }
    
    public function removeSlider($param) {
        if($param[0]!=""){
            $value = $this->db_executeSingle("sliderimg", "img_url", "name='photo".$this->strip($param[0])."'");
            $len = strlen(BASE_URL);
            $new_path = substr($value, $len, strlen($value)-$len);
            $new_path = __DIR__."/../".$new_path;
            $filename = "thumb_".basename($new_path);
            $thumb = __DIR__."/../assets/slider/".$filename;
            if(file_exists($new_path)){
               unlink($new_path);
               unlink($thumb);
            } 
            $this->db_Update("sliderimg", "img_url,heading,line1,line2","~~~","name='photo".$this->strip($param[0])."'");
            echo '1';
        }else{
            echo '2';
        }
    }
    
    /////////////////////////////////////////////////
    
    
    //************* Site Contact Detail********/////////
    
    public function contactInfo($param) {
        $this->isAuthAdmin("contactInfo", "Show");  
        $rs = $this->db_executeReader("contactinfo", "type,number");
        $this->render("../view/admin/contactInfo.php", array("list",$rs));
    }
    
    public function loadContactInfo($param) {
        $pagename = $this->strip($_POST['pagename']);
        $returntyp = ($_POST['resptyp']=="")?"json":$_POST['resptyp'];
        $valid = $this->db_executeSingle("contactinfo", "count(id)", "type='$pagename'","",false);
        if($valid){
            $stmt = $this->db_executeReader("contactinfo", "*", "", "type='$pagename'") ;
            while ($row = $this->db_read($stmt)) {
               $resposnse['res']['info']['id'] = $row['id']; 
               $resposnse['res']['info']['number'] = $row['number']; 
            }
            $resposnse['res']['error'] = 0;
        }else{
            $resposnse['res']['error'] = 1;
        }
        if($returntyp=="json"){
            echo json_encode($resposnse);
        }else{
           return $stmt; 
        }
    }
    
    public function addcontentinfo($param) {
        $this->isAuthAdmin("contactInfo", "Add"); 
        $type = $this->strip($_POST['type']);
        $value = $this->strip($_POST['pagetitle']);
        $this->db_Replace("contactinfo", "number,type,entrydate", $value."~".$type."~".date("Y-m-d H:i:s"));
        $this->redirect(ADMIN_URL."contactInfo", "Contact Detail Updatd~suc");
    }
    
    ///////////////////////////////////////////////////
    
}