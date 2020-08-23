<?php
class LoginModel extends Base{

    use General, Session;
    function __construct() {
        parent::__construct();
    }

    public function checkadminlogininfo($bypage="login"){
        extract($_POST);
        $valid = $this->db_executeSingle("Login", "COUNT(ID)", "LoginID='".$this->strip($userid)."' AND LoginPS = '".$this->strip($password)."' ","",FALSE) ;
        if($valid > 0){
            $rs = $this->db_execute("select * from Login where LoginID='".$this->strip($userid)."' AND LoginPS = '".$this->strip($password)."' ",FALSE);
            $result = $this->db_read($rs);
            $result = $result[0];
            $user =  ucfirst(strtolower(str_replace(" ","",$result['type'])));
            auth::Create_Session($result['LoginID'],$user,$result['ID'],$result['DisplayName'],$result['role']);
            $res = true;
        }else{
            $res = FALSE;
        }

        return $res;
    }

    public function checkmemberlogininfo($bypage="login"){
        extract($_POST);

        $valid = $this->db_executeSingle("profile", "COUNT(ID)", "LoginID='".$this->strip($userid)."' AND password = '".$this->strip($password)."' ","",FALSE) ;
        if($valid > 0){
            $rs = $this->db_execute("select LoginID,id from profile where LoginID='".$this->strip($userid)."' AND password = '".$this->strip($password)."' ",FALSE);
            $result = $this->db_read($rs);
            $result = $result[0];
            $user =  ucfirst(strtolower(str_replace(" ","",$result['type'])));
            auth::Create_Session_Public($result['LoginID'],'member');
            $res = true;
        }else{
            $res = FALSE;
        }

        return $res;
    }

    public function checkseologininfo($bypage="login"){
        extract($_POST);
        $valid = $this->db_executeSingle("login", "COUNT(ID)", "LoginID=? AND LoginPS = ? and type= ? ",[$this->strip($userid),$this->strip($password),'seo'],"",FALSE) ;
        if($valid > 0){
            $rs = $this->db_execute("select * from login where LoginID=? AND LoginPS = ? and type=? ", [$this->strip($userid),$this->strip($password),'seo'],FALSE);
            $result = $this->db_read($rs);
            $result = $result[0];
            $user =  ucfirst(strtolower(str_replace(" ","",$result['type'])));
            auth::Create_Session($result['LoginID'],$user,$result['ID'],$result['DisplayName'],$result['role']);
            $res = true;
        }else{
            $res = FALSE;
        }
        return $res;
    }


}
