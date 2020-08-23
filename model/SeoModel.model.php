<?php
class SeoModel extends Base{

    use General, Session;
    function __construct() {
        parent::__construct();
    }

    public function seopageoptions(){
      $rs = $this->db_execute("SELECT * FROM seopages ORDER BY seopage");
      $pagearr = $this->db_read($rs);
      return $pagearr;
    }

    public function loadPageMetaData($data){
      $arr1 = $this->db_executeReader("seocontent", "*", "", "pagename=?", [$data]);
      $arr2 = $this->db_executeReader("seo_property", "*", "", "pagename=?", [$data]);
      return array($arr1, $arr2);
    }

    public function addseocontent($data){
      if($data['pagename']!=""){
        $this->db_Replace("seocontent","pagename, title, descrp, keyword",
          $this->strip($data['pagename'])."~".$this->strip($data['title'])."~".$this->strip($data['desc'])
        ."~".$this->strip($data['keyword']));
      }
      $sql = "Replace into seo_property (type, p_value, contect, pagename) VALUES";
      for($i = 1; $i <= count($data['tagtype']); $i++){
        if($data['tagtype'][$i]!=""){
          $sql .= "('".$this->strip($data['tagtype'][$i])."', '".$this->strip($data['metaname'][$i])."',
          '".$this->strip($data['metacontent'][$i])."', '".$this->strip($data['pagename'])."'), ";
        }
      }
      $sql = rtrim($sql, ", ");
      $this->db_execute($sql);
      if($data['removeIDs']!=""){
        $this->db_delete("seo_property","id IN (?)",[ltrim($data['removeIDs'],",")]);
      }
      //die();
    }



}
