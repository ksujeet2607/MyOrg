<?php 
    session_start();
    require_once __DIR__.'/../config/config.php';
    function loadClass($className){
        $fileName = '';
        $namespace = '';
        $includePath = dirname(__FILE__).DIRECTORY_SEPARATOR;
        if (false !== ($lastNsPos = strripos($className, '\\'))) {
            $namespace = substr($className, 0, $lastNsPos);
            $className = substr($className, $lastNsPos + 1);
            $fileName = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
        }
        $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
        $fullFileName = $includePath . DIRECTORY_SEPARATOR . $fileName;
       
        if (file_exists($fullFileName)) {
            require $fullFileName;
        } else {
            echo 'Class "'.$className.'" does not exist.';
        }
    }
    spl_autoload_register('loadClass');
?>
