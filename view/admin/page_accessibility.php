<?php include_once __DIR__.'/../layout/header.php'; ?>
  <!-- Left side column. contains the logo and sidebar -->
<?php include_once __DIR__.'/../layout/menu.php'; ?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       User Accessibility
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>User Accessibility</a></li>
        <li class="active">User Accessibility</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content container-fluid" onload="updateSize();">
      
        <div class="row">
                <div class="col-md-12">
                <div class="box ">
                        <div class="box-header">
                            <h4>Manage User Accessibility</h4>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            </div>
                        </div>
                        
                        <div class="box-body">
                          <form method="post" action="<?php echo ADMIN_URL; ?>page_accessibility">           
                                <div class="row" style="padding: 10px;">
                                 <div class="col-md-6">
                                     <?php
                                      //print_r($response);
                                     ?>
                                    <label>Select User</label>
                                    <select name="users" id="users" class="form-control">
                                        <option value="">Select User</option>
                                     <?php
                                     $role = $response;
                                    
                                     $fetch = $this->db_executeReader("Login", "ID,DisplayName,LoginID", "","LoginID!= 'admin' and role=1" , "", false); 
                                      while($row = $fetch->fetch(PDO::FETCH_ASSOC)){ 
                                        $count++; ?>
                                        <option <?php if($role==$row['ID']){echo "selected";} ?> value="<?php echo $row['ID']; ?>"><?php echo $row['DisplayName']."(".$row['LoginID'].")"; ?></option>
                                        <?php } ?>
                                    </select>
                                 </div>


                                <div class="col-md-4">
                                    <button type="submit" style="margin-top: 25px;" class="btn btn-primary">Search</button>

                                </div>
                               </div>
                            </form>
                        </div>
                        </div>
                    </div>
                </div>
        <div class="row">
                <div class="col-md-12">
                    <div class="box <?php echo $col ?>">
                        <div class="box-header" style="background: #FFE4E1;padding: 1px 0px 0px 23px;">
                            <?php $rs = $this->db_executeReader("user_accessibility_admin", "*", "","userid='" . $role . "'" , "", false); 
               ?>
    <script>
        function start() {
    <?php
     while($row = $rs->fetch(PDO::FETCH_ASSOC)){ 
                   $count++; 

        if ($row['type'] == "section") {
            echo "$('.tabs-section-" . $row['name'] . "').attr('checked','checked');\n";
            echo "$('#tabs-section-" . $row['name'] . "').show();\n";
        } else if ($row['type'] == "subsection" && $row['action'] == "Show") {
            echo "$('.Show-" . $row['name'] . "').attr('checked','checked');\n";
            echo "$('.Show-" . $row['name'] . "action').removeAttr('disabled');\n";
        } else if ($row['type'] == "subsection" && $row['action'] == "Add") {
            echo "$('.Add-" . $row['name'] . "').attr('checked','checked');\n";
            echo "$('.Add-" . $row['name'] . "action').removeAttr('disabled');\n";
        } else if ($row['type'] == "subsection" && $row['action'] == "Edit") {
            echo "$('.Edit-" . $row['name'] . "').attr('checked','checked');\n";
            echo "$('.Edit-" . $row['name'] . "action').removeAttr('disabled');\n";
        } else if ($row['type'] == "subsection" && $row['action'] == "Delete") {
            echo "$('.Delete-" . $row['name'] . "').attr('checked','checked');\n";
            echo "$('.Delete-" . $row['name'] . "action').removeAttr('disabled');\n";
        } else {

            echo "$('." . $row['name'] . "action[value=" . $row['action'] . "]').attr('checked','checked');\n";
        }
    }
    ?>
        }
    </script>
    <!-- /.col -->
    <style>
        .sec{padding: 0px;
    background-color: white;
    margin-right: 12px;
    width: 45%;}
    </style>
                        </div>
                        <div class="box-body" <?php echo $b_body ?>>
                            <form action="<?php echo ADMIN_URL; ?>Save_page_accessibility" method="post" name="form-roleaccessibility" class="style27" id="form-roleaccessibility" >

                        <input type="hidden" name="users" value="<?php echo $role; ?>" />
                            <?php
                            $rs = $this->db_executeReader("accessibility_links_admin", "*", "","type='section'" , "", false); 
                            while($row1 = $rs->fetch(PDO::FETCH_ASSOC)){ 
                             $count++;
                                ?>
                                <div class="col-md-12">

                                    <div id="tabs" class="ui-tabs ui-widget ui-widget-content ui-corner-all" >
                                        <div class="panel box box-primary" style="margin-bottom: 2px;">
                                            <div class="box-header" style="background-color:#ecf0f5;padding: 0px;"> 
                                                <div class="col-md-11" >   <h4><?php echo $row1['title']; ?></h4></div>
                                                <div class="col-md-1" >  
                                                <input type="checkbox"  name="section-<?php echo $row1['linkname']; ?>[]" value="Show" class="tabs-section-<?php echo $row1['linkname']; ?> " onclick="showallpermission(this)"   style="float:right;margin-top:14px;"/>
                                               </div>
                                               </div>


                                        <div id="tabs-section-<?php echo $row1['linkname']; ?>" class="ui-tabs-panel ui-widget-content ui-corner-bottom" style="display: none;border:1px solid #ccc;overflow: hidden; " >
                                              <?php
                                                    $rs1 = $this->db_executeReader("accessibility_links_admin", "*", "","type='subsection' and sectionid='" . $row1['id'] . "'" , "order by id", FALSE); 
                                                    while($row2 = $rs1->fetch(PDO::FETCH_ASSOC)){ 
                                                    $count++;
                                                ?>
                                                  <div class="col-md-4" style="font-size:16px;"><?php echo $row2['title']; ?> :</div>
                                                  <?php if($row2['show']){ ?>
                                                     <div class="col-md-2" style="width:auto">
                                                         <input type="checkbox"  name="subsection-<?php echo $row2['linkname']; ?>[]" id="<?php echo $row2['linkname']; ?>Show" value="Show" class="<?php echo "Show-".$row2['linkname'] ?>  <?php echo "subsection-" . $row2['linkname']; ?>" onclick="accesspermission(this);" /><label for="<?php echo $row2['linkname']; ?>Show"> <?php echo "Show"; ?> </label> &nbsp; 
                                                     </div>
                                                  <?php } ?>
                                                  <?php if($row2['ad']){ ?>
                                                     <div class="col-md-2" style="width:auto">
                                                         <input type="checkbox" name="subsection-<?php echo $row2['linkname']; ?>[]" id="<?php echo $row2['linkname']; ?>Add" value="Add" class="<?php echo "Add-".$row2['linkname'] ?> <?php echo "subsection-" . $row2['linkname']; ?>" onclick="accesspermission(this);" /><label for="<?php echo $row2['linkname']; ?>Add"> <?php echo "Add"; ?> </label>   &nbsp; 
                                                     </div>
                                                  <?php } ?>
                                                  <?php if($row2['edit']){ ?>
                                                     <div class="col-md-2" style="width:auto">
                                                         <input type="checkbox" name="subsection-<?php echo $row2['linkname']; ?>[]" id="<?php echo $row2['linkname']; ?>Edit" value="Edit" class="<?php echo "Edit-".$row2['linkname'] ?> <?php echo "subsection-" . $row2['linkname']; ?>" onclick="accesspermission(this);" /><label for="<?php echo $row2['linkname']; ?>Edit"> <?php echo "Edit"; ?>  </label>  &nbsp; 
                                                     </div>
                                                  <?php } ?>
                                                  <?php if($row2['del']){ ?>
                                                     <div class="col-md-2" style="width:auto">
                                                         <input type="checkbox" name="subsection-<?php echo $row2['linkname']; ?>[]" id="<?php echo $row2['linkname']; ?>Delete" value="Delete" class="<?php echo "Delete-".$row2['linkname'] ?> <?php echo "subsection-" . $row2['linkname']; ?>" onclick="accesspermission(this);" /><label for="<?php echo $row2['linkname']; ?>Delete"> <?php echo "Delete"; ?>  </label>  &nbsp; 
                                                     </div>
                                                  <?php } ?>
                                                    <div class="col-md-12"></div>
                                                <?php } ?> 

                                        </div>
                                             </div>
                                    </div>

                                      </div>
                                <?php
                            }
                            ?> 
                   <div class="col-md-3"><input type="submit" name="submit" value=" Save " class="btn btn-block btn-primary btn-flat" onclick="return checkrole()"  /></div>


                    </form>
                        </div>
                    </div>
                </div>
            </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php include_once __DIR__.'/../layout/footer.php'; ?>
<?php echo session::GetMessage(); ?>
</div>
<script>
  $(function () {
    var limit = '<?php echo $limit ?>';
    var cpage = '<?php echo $cpage ?>';
    $('.table').DataTable({
        'paging'      : false,
        'lengthChange': true,
        'searching'   : false,
        'ordering'    : true,
        'info'        : false,
        'autoWidth'   : false
    });
});
</script>
    <script>
        function showallpermission(y) {
           
            var classname = $(y).attr("class");
            if (y.checked){
                $('#' + classname).slideDown();
            } else {
                $("#" + classname + " input").removeAttr("checked");
                $('#' + classname).slideUp();
            }
        }
    </script>     
    
<script>
$(document).ready(function () {
//            $("#ddlemp").change(function () {
//                if ($("#ddlemp").val() != 0) {
//                    window.location = "roleaccessibility.php?role=" + $("#ddlemp").val();
//                }
//            });
    start();
});
function newddchange(x) {

}
function ddchange(x) {

}
function accesspermission(x) {
    //alert($(x).attr("class")) ;
    var classname = $(x).attr("class");

    if ($(x).attr("checked")) {

        //alert('checked');

        $('.' + classname + 'action').removeAttr("disabled");

        //$("#ddlchild").removeAttr("disabled");
    } else {
        //alert('unchecked');
        $('.' + classname + 'action').removeAttr("checked");
        $('.' + classname + 'action').attr("disabled", "true");
        //$(x+'action').attr("disabled","true");
    }




}


function checkrole() {
    if ($('#ddlemp').val() == '0') {
        alert(' Please Select Role ');
        $('#ddlemp').focus();
        return false;
    }
}
</script>
</body>

</html>

