<?php
class Seo extends Session{

    protected  $userid;
    protected  $usertype;
    protected  $model;
    public  $params;
    public static $menu;

    function __construct($method,$params) {
        $this->params = $params;
        $this->model = new SeoModel();
        self::$menu = $method;
    }

    public function index($response){
        if(auth::IsLogin('seo')){
            $this->seohome($response);
        }else{
            require_once 'view/seo/index.php';
            exit();
        }

    }

    public function logout($param) {
        auth::DestroySess('seo');
        $this->redirect(PUBLIC_URL."seo", "Logged out!!~suc");
    }

    public function seohome($param) {
        if(!auth::IsLogin('seo')){
          $this->redirect(PUBLIC_URL."seo", "Session Expired!!~err");
        }
        $this->render(__FUNCTION__, $param);
    }

    public function getseopageoptions($name="",$id="",$class="",$narration="",$selected="",$selectedBy="id",$action=""){
        $response = $this->model->getseopageoptions($name, $id, $class, $narration, $selected, $selectedBy, $action);
        return $response;
    }


    public function addcontent($param) {
        print_r($_POST);
        die();
    }

    ///////////////////////////////////////////////////////

}
