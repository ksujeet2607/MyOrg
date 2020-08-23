<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Errors
 *
 * @author SUJEET KUMAR KAHAR
 */
class Errors {

    protected $control;
    use General, Session;

    public function __construct($control) {
        $this->control = $control;
    }

    public function __toString(){
        return $this->control;
    }

    public function index($param) {
        $this->error404($param);
    }

    public function error404($param){
        $this->render(__FUNCTION__, $param);
    }
}
