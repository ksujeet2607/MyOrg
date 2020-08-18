<?php
class SeoModel extends Base{

    function __construct() {
        parent::__construct();
    }

    public function getseopageoptions($name, $id, $class, $narration, $selected, $selectedBy, $action){
      $rs = $this->db_execute("SELECT * FROM seopages ORDER BY seopage");
      $response = "<select class='".$class."' id='".$id."' name='".$name."' $action>";
      $response .= "<option value='0'>".$narration."</option>";
      while($data = $this->db_read($rs)){
          $value = ($selectedBy=="id")?$data['id']:$data['seopage'];
          $sel = ($value==$selected)?" selected='true'":"";
          $response .= "<option value='".$value."' $sel>".$this->ucf($data['seopage'])."</option>";
      }
      $response .= "</select>";
      return $response;
    }




}
