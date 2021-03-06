<?php
class UserModel extends Base{


    use General, Session;
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

    public function metatags($seopage){
      $rs = $this->db_executeReader("seocontent","title, descrp, keyword","","pagename = ?",[$seopage],"",false);
      $rs1 = $this->db_executeReader("seo_property","type, p_value, contect","","pagename = ?",[$seopage],"",false);
      return [$rs[0], $rs1];
    }


    public function indexPageSrc($param){
        //$imgs = parent::getSliderImg($param);
        //$services = $this->db_executeReader("news", "*", "", "","","order by newsId DESC LIMIT 12",false);
        return $response = array("list",$rs,$about,$imgs);
    }

    public function readOpennings($param){
        //$imgs = parent::getSliderImg($param);
        //$services = $this->db_executeReader("news", "*", "", "","","order by newsId DESC LIMIT 12",false);
        return $response = array("list",$rs,$about,$imgs);
    }

    public function saveVisitors($param){
      $rs = $this->db_Insert("visitors","emailid,visit_date",$param['email']."~".date('Y-m-d H:i:s'));
      if($rs){
        return true;
      }else{
        return false;
      }
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
