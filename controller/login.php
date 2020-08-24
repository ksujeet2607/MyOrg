<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of login
 *
 * @author ADMIN
 */
class login extends myfunction{
    //put your code here
    public  $params;
    
    function __construct($method,$params) {
        parent::__construct(); 
        $this->params = $params;
        
    }
    
    public function index($response){  
        if(auth::IsLogin('admin')){
           $this->redirect(BASE_URL.auth::Get_userType()."/".auth::Get_userType().'home/');
           exit();
        }
        $this->render("../view/admin/index.php", $response);
        exit();
    }
    
    public function login($param){
       if($this->is_not_empty($_POST,"userid~@~password")){ 
            if(!$this->checkadminlogininfo()){  
               $msg = "Worng Id or Password.~err";
               $page = BASE_URL."login/";
            }else{
                
               $msg = "";
               $page = BASE_URL."admin/adminhome/";
               
            }
         }else{
             $msg = "Invalid input.~err";
             $page = "index"; 
         }
//         echo $msg;
//         print_r($page);
//         die();
         $this->redirect($page,$msg); 
    }
    
    public function memberlogin($param){
       if($this->is_not_empty($_POST,"userid~@~password")){ 
            if(!$this->checkmemberlogininfo()){  
               $msg = "Worng Id or Password.~err";
               $page = PUBLIC_URL."index?lgerr";
            }else{
                
               $msg = "";
               $page = PUBLIC_URL."memberProfile";
               
            }
         }else{
             $msg = "Invalid input.~err";
             $page = "index"; 
         }
         $this->redirect($page,$msg); 
    }
    
    public function logout($param) {
        auth::DestroySess($param[0]);
        $this->redirect(PUBLIC_URL."index?lgerr", "Logged out!!~suc");
    }
    
}
