<?php
class Bootstrap {
    public $url;
    public $control;

    public function init(){
        $this->getUrl();
    }

    private function getUrl(){
       $this->url = explode('/', rtrim(isset($_GET['url'])?$_GET['url']:"index",'/'));
       $this->loadExe();
    }
    private function loadExe(){
        $controller = isset($this->url[0])?ucfirst($this->url[0]):"u";
        if($controller=='u')$controller='User';
        $noIndex = array();
        foreach (new DirectoryIterator(__DIR__.'/../controller') as $file) {
          if ($file->isFile()) {
             $name = explode(".",$file->getFilename())[0];
             if($name!="User"){
               array_push($noIndex,$name);
             }
          }
        }
        if(!in_array($controller,$noIndex)){
          $controller='User';
        }// If no controller other than those it will take user controller
        $controller = ucfirst(file_exists("controller/".$controller.".controller.php")?$controller:"Errors");
        // echo $controller." - ".$method;
        // die();
        if(file_exists("model/".$controller."Model.model.php") && $controller!="Errors"){
          include_once "model/".$controller."Model.model.php";
          require_once "controller/".$controller.".controller.php";
        }else{// if selected controller not found
          $controller1 = "Errors";
          require_once "controller/".$controller1.".controller.php";
          $this->control = new $controller1($controller);
          $this->control->index("404");
          exit();
        }



        if(!in_array($controller, $noIndex)){// if controller is user then assiging right parameters and method
           if(isset($this->url[1])){// method
               $method = $this->url[1];
           }else{
             if($this->url[0]!="u"){//if u is not in url index 0 must be the method
               $method = $this->url[0];
             }else{
               $method = "index";
             }

           }
           $par = isset($this->url[1])?$this->url:"";// parameters
           $params = array();
           for($i=1; $i < count($par);$i++){
               array_push($params, $par[$i]);
           }
        }else{// if controlleris not user
          if(isset($this->url[1])){// method
              $method = $this->url[1];
          }else{
             $method = "index";
          }

          $par = isset($this->url[2])?$this->url:"";// parameters
          $params = array();
          for($i=2; $i < count($par);$i++){
              array_push($params, $par[$i]);
          }
        }
        $method = preg_replace('/[-]/', '_', $method);

        $this->control = new $controller($method,$params);
        if(method_exists($controller, $method)){// If method does not exits in selected controller run error controller
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
