<?php

trait Session {

static function GetMessage() {
    $msg = $_SESSION["msg"];
    self::ClearMessage();
    return $msg;
}

static function ClearMessage() {
    $_SESSION["msg"] = "";
    $_SESSION["msg_style"] = "";
}

function DestroySession() {
    $_SESSION["userType"] = "";
    $_SESSION["userName"] = "";
    $_SESSION["id"] = "";
    session_destroy();
    $_SESSION['msg']="";
}


function Get_Message()
{
    if($_SESSION["msg"]!=""){
        $msg = $_SESSION["msg"];
        self::ClearMessage();
        return $msg;
    }else return "";
}

function Clear_Message()
{

$_SESSION["msg"]="";
}

}
