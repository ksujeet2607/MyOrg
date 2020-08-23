<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of auth
 *
 * @author SUJEET KUMAR KAHAR
 */
 class Auth  {
    //put your code here



    static function Create_Session($uname="",$type='',$user_id="",$displayname="",$role="0")
    {
        $_SESSION["userName"]=$uname;
        $_SESSION["userType"]=$type;
        $_SESSION["userid"]=$user_id;
        $_SESSION["displayname"]=$displayname;
        $_SESSION["admin_area"]=$role;

        return true;
    }

    static function Create_Session_Public($user_id="",$type='')
    {
            $_SESSION["pubuserid"]=$user_id;
            $_SESSION["pubuserType"]=$type;
            return true;
    }

    static function Get_userType($typ="admin")
    {

        if($typ=="member")
        $user =  (isset($_SESSION["pubuserType"]) && $_SESSION["pubuserType"]!="")?strtolower($_SESSION["pubuserType"]):"";
        else {
        $user =  (isset($_SESSION["userType"]) && $_SESSION["userType"]!="")?strtolower($_SESSION["userType"]):"";
        }

        return strtolower($user);
    }

    static function Get_userName($typ="admin")
    {
        return (isset($_SESSION["userName"]) && $_SESSION["userName"]!="")?$_SESSION["userName"]:"";
    }
    static function Get_userID($typ="admin")
    {
        if($typ=="member")
        $res =  (isset($_SESSION["pubuserid"]) && $_SESSION["pubuserid"]!="" )?$_SESSION["pubuserid"]:"";
        else {
        $res =  (isset($_SESSION["userid"]) && $_SESSION["userid"]!="" )?$_SESSION["userid"]:"";
        }

        return $res;
    }

    static function Get_displayName()
    {
        $res =  (isset($_SESSION["displayname"]) && $_SESSION["displayname"]!="" )?$_SESSION["displayname"]:"";
        return $res;
    }
    static function isAdminAccess()
    {
        $res =  (isset($_SESSION["admin_area"]) && $_SESSION["admin_area"]!="" )?$_SESSION["admin_area"]:"0";
        return $res;
    }

    static function IsvalidLogin($typ="admin"){
        if(!self::isAdminAccess()){
            return FALSE;
        }
            return TRUE;
    }
    static function IsLogin($type=""){
        if($type!=""){
           if(self::Get_userType($type)== strtolower($type)){
            return true;
           }else{
             return false;
           }
        }else if(self::Get_userType($type)==""){
            return FALSE;
        }else{
            return TRUE;
        }

    }

    static function DestroySess($typ="admin"){
        if($typ=="member"){
            $_SESSION["pubuserType"]="";
            $_SESSION["pubuserid"]="";
            unset($_SESSION["pubuserType"]);
            unset($_SESSION["pubuserid"]);
        }else{
         $_SESSION["userName"]="";
         $_SESSION["userType"]="";
         $_SESSION["userid"]="";
         $_SESSION["branchid"]="";
         $_SESSION["branchCityId"]="";
         $_SESSION["displayname"]="";
         unset($_SESSION["userName"]);
         unset($_SESSION["userType"]);
         unset($_SESSION["userid"]);
         unset($_SESSION["branchid"]);
         unset($_SESSION["branchCityId"]);
         unset($_SESSION["displayname"]);
        }
         return TRUE;
    }
}
