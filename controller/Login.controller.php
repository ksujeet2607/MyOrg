<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of login
 *
 * @author SUJEET KUMAR KAHAR
 */
class Login {
    //put your code here
    public  $params;
    protected  $userid;
    protected  $usertype;
    protected  $model;
    public static $menu;
    use General, Session;

    function __construct($method,$params) {
        $this->params = $params;
        $this->model = new LoginModel();
        self::$menu = $method;
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
            if(!$this->model->checkadminlogininfo()){
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
//         print_r($page);
//         die();
         $this->redirect($page,$msg);
    }

    public function memberlogin($param){
       if($this->is_not_empty($_POST,"userid~@~password")){
            if(!$this->model->checkmemberlogininfo()){
               $msg = "Worng Id or Password.~err";
               $page = PUBLIC_URL."index?lgerr";
            }else{

               $msg = "";
               $page = PUBLIC_URL."Dashboard";

            }
         }else{
             $msg = "Invalid input.~err";
             $page = "index";
         }
         $this->redirect($page,$msg);
    }

    public function seologin($param){
       if($this->is_not_empty($_POST,"userid~@~password")){
            if(!$this->model->checkseologininfo()){
               $msg = "Worng Id or Password.~err";
               $page = BASE_URL."seo/index?lgerr";
            }else{
               $msg = "";
               $page = BASE_URL."seo/seohome";
            }
         }else{
             $msg = "Invalid input.~err";
             $page = "index";
         }

         $this->redirect($page,$msg);
    }

    public function logout($param) {
        auth::DestroySess($param[0]);
        $this->redirect(PUBLIC_URL."seo", "Logged out!!~suc");
    }

}
