<?php
class Bootstrap {
    public $url;
    public $control;

    public function init(){
        $this->getUrl();
    }

    private function getUrl(){
       $this->url = explode('/', rtrim(isset($_GET['url'])?$_GET['url']:"u",'/'));
       $this->loadExe();
    }
    private function loadExe(){
        $controller = isset($this->url[0])?$this->url[0]:"u";
        if($controller=='u')$controller='user';
        $controller = ucfirst(file_exists("controller/".$controller.".controller.php")?$controller:"Errors");
        if(file_exists("model/".$controller."Model.model.php") && $controller!="Errors"){
          require_once "model/".$controller."Model.model.php";
          require_once "controller/".$controller.".controller.php";
        }else{
          $controller1 = "Errors";
          require_once "controller/".$controller1.".controller.php";
          $this->control = new $controller1($controller);
          $this->control->index("404");
          exit();
        }

        if(isset($this->url[1])){
            $method = $this->url[1];
        }else{
           $method = "index";
        }
        $par = isset($this->url[2])?$this->url:"";
        $params = array();
        for($i=2; $i < count($par);$i++){
            array_push($params, $par[$i]);
        }

        $this->control = new $controller($method,$params);
        if(method_exists($controller, $method)){
            if($controller == "Errors")$params=404;
            $this->control->$method($params);
            exit();
        }else{
            $controller1 = "Errors";
            require_once "controller/".$controller1.".controller.php";
            $this->control = new $controller1($controller);
            $this->control->index("404");
            exit();
        }
    }
}
