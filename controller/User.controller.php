<?php
class User extends Session{
    protected  $userid;
    protected  $usertype;
    protected  $model;
    public  $params;

    function __construct($method,$params) {
        $this->params = $params;
        $this->model = new UserModel();
    }

    public function isMemberLogin(){
        if(auth::IsLogin('member')){
            return true;
        }else{
            $this->redirect(PUBLIC_URL, "Session Expired~err");
        }
    }


    public function index($param){
        $response = $this->model->indexPageSrc($param);
        $this->render(__FUNCTION__, $response, "default", "user");
    }
    
    public function contact($param){
        $response = $this->model->contactPageSrc($param);
        $this->render(__FUNCTION__, $response);
    }
    
     public function about($param){
        $this->render(__FUNCTION__, $response);
    }
    
    public function enquiry($param){
        $response = $this->model->saveEnquiry($param);
        $this->render(__FUNCTION__, $response);
    }
    
    public function portfolio($param){
        $response = $this->model->portfolioPageSrc($param);
        $this->render(__FUNCTION__, $response);
    }


    public function captcha($param) {
       $cap = new captcha($_POST['typ']);
       echo $cap->phpcaptcha("#".$param[0], "#".$param[1], $param[2], $param[3], $param[4], $param[5]);
    }


}
