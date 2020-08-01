<?php

class Dbfunction extends Session {
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASSWORD;
    private $db = DB_NAME;
    public $conn;

    function __construct() {

        $this->conn = $this->getConnection();
    }

    Private function getConnection($param=NULL) {
       try{
            $options = [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_CASE => PDO::CASE_NATURAL,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                      ];
            $conn = new PDO("mysql:host=".$this->host.";dbname=".$this->db.";", $this->user, $this->pass,$options);

        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
        return $conn;
    }

    public function db_InsertedId(){
        return $this->conn->lastInsertId();
    }

    //********************// Select Multiple rows Values //**********************//

    public function db_executeReader($table = "", $colomns = "", $join = "", $condition = "", $conditionArr="", $extra = "", $print_qry = false){

        $qry = "select ".$colomns." from ".$table." ";

        if(trim($join) != ""){$qry .= " ".$join." ";}

        if(trim($condition) != ""){$qry .= " where (".$condition.") ";}

        if(trim($extra) != ""){$qry .= " ".$extra." ";}

        if($print_qry){echo $qry;} // print query
        //echo $qry;
        //die();
        $stmt = $this->conn->prepare($qry);

        $stmt->execute([$conditionArr]);

        return $stmt->fetchAll();
    }






    //********************// Select Query //**********************//

    public function db_execute($qryTxt, $print_qry = false){

        $qry = $qryTxt;

        if($print_qry){echo $qry;} // print query

        $stmt = $this->conn->prepare($qry);

        $stmt->execute();

        //$this->conn = null;

        return $stmt;
    }

    /////******************/////
    public function db_executeSingleQuery($QryString = "", $PrepareArr=[],$print_qry = false){

        $qry = $QryString;


        if($print_qry){echo $qry;} // print query

        $stmt = $this->conn->prepare($qry);

        $stmt->execute($PrepareArr);

        $row = $stmt->fetch();

        //$this->conn = null;

        return $row[0];
    }



    /////****** Fetch Rows from execute() object ******/////
    public function db_read($stmt) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }



/////****** Fetch Single Row ******/////
    public function db_executeSingle($table = "", $colomn = "", $condition = "", $conditionArr = "", $extra = "", $print_qry = false){

        $qry = "select ".$colomn." from ".$table." ";

        if(trim($condition) != ""){$qry .= " where (".$condition.") ";}

        if(trim($extra) != ""){$qry .= " ".$extra." ";}

        if($print_qry){echo $qry;} // print query

        $stmt = $this->conn->prepare($qry);

        $stmt->execute([$conditionArr]);

        $row = $stmt->fetch();

        //$this->conn = null;

        return $row[0];
    }


////**************////




//********************// Update Values //**********************//
    public function db_Update($table = "", $colomns = "", $values = "", $condition = "",  $conditionArr = "", $print_qry = false){

        $colomn_array = explode(",", $colomns);

        $values_array = explode("~", $values);

        $qry = "update ".$table." set ";

        $read_qry = "update ".$table." set ";

        foreach($colomn_array as $key => $field){

            if ($key == 0) {

            $qry .= $field.' = ?';

            $read_qry .= $field.' = '.$values_array[$key];

          } else {

            $qry .= ', '.$field.' = ?';

            $read_qry .= ', '.$field.' = '.$values_array[$key];

          }
        }

        if($condition != ""){

            $qry .= " where (".$condition.") ";

            $read_qry .= " where (".$condition.") ";
            if(!empty($conditionArr)){
              $conditionArr = array($conditionArr);
              foreach ($conditionArr as $value) {
                array_push($values_array,$value);
              }
            }

        }

        try {

        $stmt = $this->conn->prepare($qry);

        $stmt->execute($values_array);

        if($print_qry){
            //$stmt->debugDumpParams();
            echo $read_qry;
        }

        if($stmt->rowCount()>0){return true;}else{return false;}

        }
        catch (PDOException $e){

            $e->getMessage();

            return false;
        }
    }




    //********************// Insert Values //**********************//

    public function db_Insert($table = "", $colomns = "", $values = "", $print_qry = false){

        $col_count = substr_count($colomns, ',');

        $values_array = explode("~", $values);

        $qry = "insert into ".$table." (".$colomns.") values (";

        for($i = 0; $i <= $col_count; $i++){

            if($i == 0){ $qry .= "?";}else{ $qry .= ",?";}
        }

        $qry .= ")";

        try {

        $stmt = $this->conn->prepare($qry);

        // foreach ($values_array as $key => $value) {
        //
        //     $stmt->bindParam(($key+1), $values_array[$key]);
        // }

        $stmt->execute($values_array);

        if($print_qry){
            $qry1 = "insert into ".$table." (".$colomns.") values (";

            for($i = 0; $i <= $col_count; $i++){

                if($i == 0){ $qry1 .= "'".$values_array[$i]."'";}else{ $qry1 .= ",'".$values_array[$i]."'";}
            }

            $qry1 .= ")";
            //$stmt->debugDumpParams();
            var_dump($qry1);

        } // print query

        if($stmt->rowCount()>0){return true;}else{return false;}

        }
        catch (PDOException $e){

            $e->getMessage();

            return false;
        }

    }

    ///**********************//////



    //********************// Replace Values //**********************//

    public function db_Replace($table = "", $colomns = "", $values = "", $print_qry = false){

        $col_count = substr_count($colomns, ',');

        $values_array = explode("~", $values);

        $qry = "replace into ".$table." (".$colomns.") values (";

        for($i = 0; $i <= $col_count; $i++){

            if($i == 0){ $qry .= "?";}else{ $qry .= ",?";}
        }

        $qry .= ")";

        try {

        $stmt = $this->conn->prepare($qry);

        // foreach ($values_array as $key => $value) {
        //
        //     $stmt->bindParam(($key+1), $values_array[$key]);
        // }

        $stmt->execute($values_array);

        if($print_qry){$stmt->debugDumpParams();} // print query

        if($stmt->rowCount()>0){return true;}else{return false;}

        }
        catch (PDOException $e){

            $e->getMessage();

            return false;
        }

    }

    ///**********************//////




   //********************// Delete Record //**********************//
public function db_delete($table = "", $condition = "", $print_qry = false){

        $qry = "delete from ".$table." ";

        if($condition != ""){

            $qry .= "where (".$condition.") ";
        }

        try {

        $stmt = $this->conn->prepare($qry);

        $stmt->execute();

        if($print_qry){$stmt->debugDumpParams();}

        if($stmt->rowCount()>0){return true;}else{return false;}

        }
        catch (PDOException $e){

            $e->getMessage();

            return false;
        }
    }


  function pagination($query, $per_page = 10,$page = 1, $url = '?'){
    	$query = "SELECT COUNT(*) as num FROM {$query}";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    	$total = $row['num'];
        $adjacents = "2";

    	$page = ($page == 0 ? 1 : $page);
    	$start = ($page - 1) * $per_page;

    	$prev = $page - 1;
    	$next = $page + 1;
        $lastpage = ceil($total/$per_page);
    	$lpm1 = $lastpage - 1;
    	$pagination = "";
    	if($lastpage > 1)
    	{
    		$pagination .= "<ul class='pagination'>";
                    $pagination .= "<li class='details'><a  href='javascript:void(0)'>Page $page of $lastpage</a></li>";

    		if ($lastpage < 7 + ($adjacents * 2))
    		{
    			for ($counter = 1; $counter <= $lastpage; $counter++)
    			{
    				if ($counter == $page)
    					$pagination.= "<li><a class='current'>$counter</a></li>";
    				else
    					$pagination.= "<li><a href='{$url}page=$counter'>$counter</a></li>";
    			}
    		}
    		elseif($lastpage > 5 + ($adjacents * 2))
    		{
    			if($page < 1 + ($adjacents * 2))
    			{
    				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<li><a class='current'>$counter</a></li>";
    					else
    						$pagination.= "<li><a href='{$url}page=$counter'>$counter</a></li>";
    				}
    				$pagination.= "<li class='dot'>...</li>";
    				$pagination.= "<li><a href='{$url}page=$lpm1'>$lpm1</a></li>";
    				$pagination.= "<li><a href='{$url}page=$lastpage'>$lastpage</a></li>";
    			}
    			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
    			{
    				$pagination.= "<li><a href='{$url}page=1'>1</a></li>";
    				$pagination.= "<li><a href='{$url}page=2'>2</a></li>";
    				$pagination.= "<li class='dot'>...</li>";
    				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<li><a class='current'>$counter</a></li>";
    					else
    						$pagination.= "<li><a href='{$url}page=$counter'>$counter</a></li>";
    				}
    				$pagination.= "<li class='dot'>..</li>";
    				$pagination.= "<li><a href='{$url}page=$lpm1'>$lpm1</a></li>";
    				$pagination.= "<li><a href='{$url}page=$lastpage'>$lastpage</a></li>";
    			}
    			else
    			{
    				$pagination.= "<li><a href='{$url}page=1'>1</a></li>";
    				$pagination.= "<li><a href='{$url}page=2'>2</a></li>";
    				$pagination.= "<li class='dot'>..</li>";
    				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<li><a class='current'>$counter</a></li>";
    					else
    						$pagination.= "<li><a href='{$url}page=$counter'>$counter</a></li>";
    				}
    			}
    		}

    		if ($page < $counter - 1){
    			$pagination.= "<li><a href='{$url}page=$next'>Next</a></li>";
                $pagination.= "<li><a href='{$url}page=$lastpage'>Last</a></li>";
    		}else{
    			$pagination.= "<li><a class='current'>Next</a></li>";
                $pagination.= "<li><a class='current'>Last</a></li>";
            }
    		$pagination.= "</ul>\n";
    	}


        return $pagination;
    }

}
