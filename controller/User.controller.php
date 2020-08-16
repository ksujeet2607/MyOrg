<?php
class User extends Session{
    protected  $userid;
    protected  $usertype;
    protected  $model;
    public  $params;
    public static $menu;

    function __construct($method,$params) {
        $this->params = $params;
        $this->model = new UserModel();
        self::$menu = $method;
    }

    public function isMemberLogin(){
        if(auth::IsLogin('member')){
            return true;
        }else{
            $this->redirect(PUBLIC_URL, "Session Expired~err");
        }
    }


    public function index($param){
        define('SUBTITLE','Innovative Business Solution Provider');
        $response = $this->model->indexPageSrc($param);
        $this->render(__FUNCTION__, $response, "default", "user");
    }

    public function contact_us($param){
        define('SUBTITLE','Contact Technets');
        $response = $this->model->contactPageSrc($param);
        $this->render(__FUNCTION__, $response);
    }

     public function about_us($param){
        define('SUBTITLE','About Technets');
        $this->render(__FUNCTION__, $response);
    }

    public function meet_our_team($param){
        define('SUBTITLE','Technets Team');
        $this->render(__FUNCTION__, $response);
    }

    public function visitors($param){
      $response = $this->model->saveVisitors($_POST);
      if($response){
        echo 'Thank you very much for visiting Technets! We are delighted to have you on board!. We will notify you as soon as we launch it.';
      }else{
        echo 'Thank You! We Will Notify You on This Email.';
      }

    }

    public function send_enquiry($param){
        $response = $this->model->saveEnquiry($param);
        include('mail.controller.php');
        $mail = new mail();
        $mail->saveEnquiry($_POST);
        $this->redirect(PUBLIC_URL."contact-us", "Thank You! We Will Get Back To You Soon.~suc");
    }

    public function our_portfolio($param){
        define('SUBTITLE','Technets Portfolio');
        $response = $this->model->portfolioPageSrc($param);
        $this->render(__FUNCTION__, $response);
    }

    public function send_feedback($param){
        $response = $this->model->savefeedback($param);
        include('mail.controller.php');
        $mail = new mail();
        $mail->savefeedback($_POST);
        $this->redirect(PUBLIC_URL, "Thank You! For Your Valuable Feedback.~suc");
    }


    public function captcha($param) {
       $cap = new captcha($_POST['typ']);
       echo $cap->phpcaptcha("#".$param[0], "#".$param[1], $param[2], $param[3], $param[4], $param[5]);
    }


}
