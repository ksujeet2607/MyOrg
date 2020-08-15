<?php
class UserModel extends Base{

    function __construct() {
        parent::__construct();
    }

    public function isMemberLogin(){
        if(auth::IsLogin('member')){
            return true;
        }else{
            $this->redirect(public_URL, "Session Expired~err");
        }
    }



    public function indexPageSrc($param){
        //$imgs = parent::getSliderImg($param);
        //$services = $this->db_executeReader("news", "*", "", "","","order by newsId DESC LIMIT 12",false);
        return $response = array("list",$rs,$about,$imgs);
    }

    public function saveVisitors($param){
      $this->db_Insert("visitors","emailid,visit_date",$param['email']."~".date('Y-m-d H:i:s'));
      
    }

    public function contactPageSrc($param){

//        $rs = $this->db_executeReader("news", "*", "", "","","order by newsId DESC LIMIT 12",false);
//
//        $about = $this->db_executeSingle("pagecontant", "page_details", "pagename='About Us'");

        return $response = array("list",$rs,$about,$imgs);
    }

    public function portfolioPageSrc($param){
//        $about = $this->db_executeSingle("pagecontant", "page_details", "pagename='About Us'");

        return $response = array("list",$rs,$about,$imgs);
    }

    public function savefeedback($param){
      return $response = array("list",$rs,$about,$imgs);
    }

    public function saveEnquiry($param){

        return $response = array("list",$rs,$about,$imgs);
        //$about = $this->db_Insert("feedback", "name, email, mobile, subject, message, entrydate, readstatus", $values, $print_qry);
    }

    private function getPortfolio($param){

        //$rs = $this->db_executeReader("portfolio", "*", "", "","","order by newsId DESC LIMIT 12",false);
    }




}
