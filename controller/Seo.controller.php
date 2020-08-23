<?php
class Seo {
    protected  $userid;
    protected  $usertype;
    protected  $model;
    public  $params;
    public static $menu;
    use General, Session;

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
        $pagearr = $this->model->seopageoptions();
        $response = "<select class='form-control required' id='pagename' name='pagename' onchange=' loadPageMetaData(this);'>";
        $response .= "<option value='0'>Select Page</option>";
        foreach ($pagearr as $key => $data) {
           $value = ($selectedBy=="id")?$data['id']:$data['seopage'];
           $sel = ($value==$selected)?" selected='true'":"";
           $response .= "<option value='".$value."' $sel>".$this->ucf($data['seopage'])."</option>";
        }
        $response .= "</select>";
        $param = array('pagename' => $response);
        $this->render(__FUNCTION__, $param);
    }

    public function addseocontent($param) {
        $response = $this->model->addseocontent($_POST);
        $this->redirect(PUBLIC_URL."seo", "Meta Tags Updated!~suc");
    }

    public function loadPageMetaData($param) {
        $arr = $this->model->loadPageMetaData($this->strip($_POST['pagename']));
        echo json_encode($arr);
    }

    ///////////////////////////////////////////////////////

}
