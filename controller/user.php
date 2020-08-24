<?php
class user extends myfunction{   
    protected  $userid;
    protected  $usertype;
    public  $params;
    function __construct($method,$params) {
        parent::__construct();
        $this->params = $params;
        $this->userid = auth::Get_userID('member');
        $this->usertype = strtolower(auth::Get_userType('member'));
        
    }
    
    public function isMemberLogin(){
        if(auth::IsLogin('member')){
            return true;
        }else{
            $this->redirect(PUBLIC_URL, "Session Expired~err");
        }
    }


    public function index($param){
        if(auth::IsLogin('member')){
            $this->redirect(PUBLIC_URL."memberProfile", "");
            exit(0);
        }
        $rs = parent::getSliderImg($param);
        $about = $this->db_executeSingle("pagecontant", "page_details", "pagename='About Us'");
        $f1 = $this->db_executeReader("product", "*", "", "productas like '%Featured Product%'"," order by entrytime desc limit 0,4");
        $f2 = $this->db_executeReader("product", "*", "", "productas like '%Featured Product%'"," order by entrytime desc limit 5,4");
        $l1 = $this->db_executeReader("product", "*", "", "productas like '%Latest Product%'"," order by entrytime desc limit 0,4");
        $l2 = $this->db_executeReader("product", "*", "", "productas like '%Latest Product%'"," order by entrytime desc limit 5,4");
        $response = array("list",$rs,$about,$f1,$f2,$l1,$l2); 
        $this->render("../view/user/index.php", $response);
    } 
    
    
    
    public function getfooter($param) {
        return $footer = $this->db_executeSingle("pagecontant", "page_details", "pagename='Footer Content'");
    }
    
    public function about($param){ 
        $rs = $this->db_executeReader("pagecontant", "page_title,page_details", "", "pagename='About Us'");
        $this->render("../view/user/about.php", array('list',$rs));
    }    
   
    public function search($param){ 
        $rs = $this->db_executeReader("pagecontant", "page_title,page_details", "", "pagename='Search'");
        $this->render("../view/user/search.php", array('list',$rs));
    } 
    
    public function Searchresult($param){ 
        $type = $this->strip($_POST['type']);
        $keyword = $this->strip($_POST['keyword']);
        $action = ($type!="")?$type:"Business";
        $page= "businessresult";
        $limit = 2;
        $cpage = (isset($_POST['page']))?$_POST['page']:1;
        if($cpage==1){
            $start = 0; 
           }else{
               $start = ($cpage * $limit) - $limit;
           }
        $lim = " limit $start ,$limit";
        if($action=="Business"){
            $cond = " p.occu ='Business' ";
            if($keyword!=""){
                $cond .= " AND ( o_organi like '%$keyword%' OR o_address like '%$keyword%' "
                        . "OR o_area like '%$keyword%' OR o_address like '%$keyword%' OR o_web like '%$keyword%' "
                        . "OR o_email like '%$keyword%' OR ps.name like '%$keyword%' OR ps.descrp like '%$keyword%'"
                        . " OR ps.type like '%$keyword%')";
            }
            $rs = $this->db_executeReader("profile p", "p.id,p.LoginID,p.o_organi,p.o_address,"
                    . "p.o_contact,p.o_area,p.o_web,p.o_email,p.o_estab", 
                    "LEFT JOIN proser ps ON p.LoginID = ps.profileid", $cond,
                    "GROUP BY (p.LoginID) order by p.id DESC $lim",false);
            $page= "businessresult";
        }else{
            $cond = ""; // Status Check Here
            if($keyword!=""){
                
                $cond .= " ( name like '%$keyword%' OR city like '%$keyword%' "
                        . "OR location like '%$keyword%' OR edu like '%$keyword%' OR occu like '%$keyword%' "
                        . " OR mobile like '%$keyword%' OR LoginID like '%$keyword%'"
                        . " OR email like '%$keyword%' OR fname like '%$keyword%' OR mname like '%$keyword%')";
            }
            $rs = $this->db_executeReader("profile", "id,LoginID,DATE_FORMAT(dob, '%d/%m/%Y') as dob,mstatus,caste,subcaste,city,location,edu,occu,"
                    . "photo,photo1,photo2,name", 
                    "", $cond,"order by id DESC $lim",false); 
            $page= "searchresult";
        }
        if(isset($_POST['json'])){
            $i = 0;
            while ($data = $this->db_read($rs)) {
                $row['result'][] = $data;
                $key = base64_encode(openssl_random_pseudo_bytes(32));
                //$encrypted = general::encrypt($data['LoginID'], $key);
                $encrypted = base64_encode($data['LoginID']);
                $row['result'][$i]['profilePath'] = PUBLIC_URL."profiledetail/".$encrypted;
                $row['result'][$i]['businessPath'] = PUBLIC_URL."businessdetail/".$encrypted;
                $i++;
            }
            $row['result']['page'] = $cpage;
            echo json_encode($row);
        }else{
            $this->render("../view/user/$page.php", array($type,$rs,$type,$keyword,$cpage));
        }
    }  
    
    public function profiledetail($param){ 
        //$profileid = ($param[0]!="")?general::decrypt($param[0]):0;
        $profileid = ($param[0]!="")? base64_decode($param[0]):0;
        if($profileid!='0'){
            $rs = $this->db_executeReader("profile", "profile.*,DATE_FORMAT(dob, '%d/%m/%Y') as dob1,DATE_FORMAT(fdob, '%d/%m/%Y') as fdob,DATE_FORMAT(mdob, '%d/%m/%Y') as mdob ", "", "LoginId='$profileid'","",false);
        
            $rs1 = $this->db_executeReader("profile_child", "name,job,child,DATE_FORMAT(dob, '%d/%m/%Y') as dob", "", "profileid='$profileid' AND child='son'","",false);
            $rs2 = $this->db_executeReader("profile_child", "name,job,child,DATE_FORMAT(dob, '%d/%m/%Y') as dob", "", "profileid='$profileid' AND child='daugather'","",false);
        }
        $this->render("../view/user/profiledetail.php", array('list',$rs,$rs1,$rs2));
    }
    
    public function contact($param){
        $rs = $this->db_executeReader("pagecontant", "page_title,page_details", "", "pagename='Contact Us'");
        $this->render("../view/user/contact.php", array('list',$rs));
    }  
    
    public function product($param){
        $cat = ($param[0]!="")?$param[0]:0;
        $limit = 12;
        $cpage = (isset($_GET['page']))?$_GET['page']:1;
        if($cpage==1){
            $start = 0; 
           }else{
               $start = ($cpage * $limit) - $limit;
           }
        $lim = " limit $start ,$limit";
        $cond = " 1=1 ";
        if($cat!='0'){
            $cat = $this->strip(urldecode($cat));
            $keyword = $cat;
            $cond .= " AND (cat='$cat' OR productas like '%$cat%')";
        }elseif(isset($_POST['keyword'])){
            $keyword = $this->strip($_POST['keyword']);
            $_SESSION['keyword_input'] = $keyword;
        }elseif(isset($_SESSION['keyword_input'])) {
             $keyword = $_SESSION['keyword_input'];
        }
        if($keyword!="" && $cat=='0'){
           $cond = "  (cat like '%$keyword%' OR productas like '%$keyword%' OR productid like '%$keyword%' OR "
                   . "productname like '%$keyword%' OR brand like '%$keyword%' OR productDesc like '%$keyword%' OR "
                   . "productkey like '%$keyword%')"; 
        }
        $pagi =  $this->pagination("product where $cond ",$limit,$cpage);
        $rs = $this->db_executeReader("product", "*", "", $cond," ORDER BY id DESC $lim ",false);
        $f2 = $this->db_executeReader("product", "*", "", "productas like '%Best Seller%'"," order by entrytime desc limit 10");
        $f1 = $this->db_executeReader("product", "*", "", "productas like '%Top Seller%'"," order by entrytime desc limit 10");
        $this->render("../view/user/product.php", array('list',$rs,$pagi,$f1,$f2,$keyword));
    }   

    
    public function forgotpass($param){  
        $this->render("../view/user/forgotpass.php", $param);
    }       
     
    
    public function sendenquiry($param){ 
        $isvalid = $this->is_not_empty($_POST, "fname~email~mobile~msg");
        if($isvalid){
            $this->redirect("", "Please Fill All Required Fields.~err", false);
            echo '<script>'
            . 'window.history.go(-1);</script>';
            exit(0);
        }
        $this->render("../controller/mail.php",$param);
        $mail = new mail();
        $mail->sendenquiry($_POST);
        $this->redirect(PUBLIC_URL."contact", "Thank You, We will get back to you soon.~suc");
    }       

    
    ///////////////////////////////////////
    
    //////***********Product Detail***********/////////////
    
    
    public function productDetail($param) {
        if(isset($param[0])){
            $product = base64_decode($this->strip($param[0]));
            $rs = $this->db_executeReader("product", "*", "", "id=$product","",false);
            $f2 = $this->db_executeReader("product", "*", "", "productas like '%Best Seller%'"," order by entrytime desc limit 10");
            $f1 = $this->db_executeReader("product", "*", "", "productas like '%Top Seller%'"," order by entrytime desc limit 10");
            $cat = $this->db_executeSingle("product", "cat", "id=$product");
            $brand = $this->db_executeSingle("product", "brand", "id=$product");
            $sim1 = $this->db_executeReader("product", "*", "","brand like '$brand' AND cat like '$cat'"," ORDER BY id DESC limit 0,3 ",false);
            $sim2 = $this->db_executeReader("product", "*", "","brand like '$brand' AND cat like '$cat'"," ORDER BY rand() DESC limit 3 ",false);
            $this->render("../view/user/productDetail.php", array('list',$rs,$pagi,$f1,$f2,$sim1,$sim2));
        }else{
            $this->redirect(PUBLIC_URL."index", "Product Id Missing~err");
        }
    }
    
    ///////////////////////////////////////////////////////

}