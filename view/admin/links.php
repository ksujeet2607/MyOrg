<?php include_once __DIR__.'/../layout/header.php'; ?>
  <!-- Left side column. contains the logo and sidebar -->
<?php include_once __DIR__.'/../layout/menu.php'; ?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Add/Manage Links
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Add/Manage Links</a></li>
        <li class="active">Add/Manage Links</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content container-fluid" onload="updateSize();">
      
        <div class="row">
                <div class="col-md-12">
                                        <div class="box ">
                        <div class="box-header">
                            <h4>Add Links </h4>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            </div>
                        </div>
                        
                        <div class="box-body">
                            <?php
                            $action = "addlinks"; 
                                 if(!empty($response[2])){
                                     $action = "updatelinks";
                                     $edit = $this->db_read($response[2]);    
                                      
                                 }
                                 
                             ?>
                         <form id="myform" method="post" action="<?php echo ADMIN_URL.$action ?>" autocomplete="off">
                            <div class="col-md-6">
                                <div class=" form-group">
                                    <label>Link Type</label>
                                    <select class="form-control required " name="link_type" id="link_type" onchange=" getlink_type(this,'<?php echo trim($edit["type"]) ?>');" required="" style="border: 1px solid rgb(207, 198, 198);">
                                        <option value="">Select Link Type</option>
                                        <option <?php echo (trim($edit["type"])=="section")?"selected":"" ?> value="section">Section</option>
                                        <option <?php echo (trim($edit["type"])=="subsection")?"selected":"" ?> value="subsection">Subsection</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6" id="sec" style="display: none;">
                                <div class=" form-group">
                                    <label>Select Section</label>
                                    <select class="form-control required " name="sectionid" id="sectionid"  style="border: 1px solid rgb(207, 198, 198);">
                                        <option value="">Select Section</option>
                                     </select>
                                 </div>
                            </div>
                            <div class="col-md-6">
                                <div class=" form-group">
                                    <label>Enter Link Title</label>
                                    <input class="form-control required" maxlength="70" value="<?php echo $edit['title'] ?>"  name="link_title" id="link_title" placeholder="Enter Link Title" required="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class=" form-group">
                                    <label>Enter Link</label>
                                    <input class="form-control required" maxlength="70" value="<?php echo $edit['linkname'] ?>"  name="link" id="link" placeholder="Enter Link" required="">
                                </div>
                            </div>
                             <div class="col-md-12 no-padding">
                                <div class="col-md-1">
                                    <div class=" form-group">
                                        <label>Option: </label>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class=" form-group">
                                        <label></label>
                                        <input type="checkbox" name="option[]" <?php echo ($edit['show']==1)?"checked":"" ?> id="Show" value="Show"><label for="Show">Show &nbsp;&nbsp;&nbsp;</label>
                                        <input type="checkbox" name="option[]" <?php echo ($edit['ad']==1)?"checked":"" ?> id="Add" value="Add"><label for="Add">Add&nbsp;&nbsp;&nbsp;</label>
                                        <input type="checkbox" name="option[]" <?php echo ($edit['edit']==1)?"checked":"" ?> id="Edit" value="Edit"><label for="Edit">Edit&nbsp;&nbsp;&nbsp;</label>
                                        <input type="checkbox" name="option[]" <?php echo ($edit['del']==1)?"checked":"" ?> id="Delete" value="Delete"><label for="Delete">Delete&nbsp;&nbsp;&nbsp;</label>
                                    </div>
                                </div>
                             </div>
                             
                            <div class="col-md-12">
                                <label>&nbsp;</label><br>
                                <input name="id" type="hidden" value="<?php echo $edit['id'] ?>">
                                <input type="submit" class="btn btn-flat btn-primary" name="submit" value="<?php echo ($response[2]!="")?"Update":"Add" ?> Link">
                            </div>
                        </form>
                        </div>
                        </div>
                    </div>
                </div>
        <div class="row">
                <div class="col-md-12">
                   <?php 
//                            if(!empty($response[1])){
//                            $edit = $this->db_read($response[1]); 
//
//                            }
                            ?>
                    <div class="box <?php echo $col ?>">
                        <div class="box-header" style="background: #FFE4E1;padding: 1px 0px 0px 23px;">
                            <div class="row">
                             <div class="col-md-12">
                             <div class="col-md-6">
                                <h4 style="font-weight: 600;"><?php echo "Search Links"; ?></h4>
                             </div>
                             
                            <div class="col-md-2">
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool"  data-widget="collapse"><i style="font-size: 26px; color: red;" class="<?php echo $fa ?>"></i></button>
                                </div>
                             </div>
                            </div>
                            </div>
                        </div>
                        <div class="box-body" <?php echo $b_body ?>>
                            
                           <form id="myform2" method="post" action="<?php echo ADMIN_URL."links" ?>" autocomplete="off">
                              <div class="row">
                                  <div class="col-md-4">
                                        <div class=" form-group">
                                            <label>Link Type</label>
                                            <select class="form-control  " name="link_type1" id="link_type1" onchange=" getlink_type1(this,'<?php echo trim($_POST["link_type1"]) ?>');" required="" style="border: 1px solid rgb(207, 198, 198);">
                                                <option value="All">All</option>
                                                <option <?php echo (trim($_POST["link_type1"])=="section")?"selected":"" ?> value="section">Section</option>
                                                <option <?php echo (trim($_POST["link_type1"])=="subsection")?"selected":"" ?> value="subsection">Subsection</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class=" form-group">
                                            <label>Select Section</label>
                                            <select class="form-control  " name="sectionid1" id="sectionid1"  style="border: 1px solid rgb(207, 198, 198);">
                                                <option></option>
                                            </select>
                                         </div>
                                    </div>

                                <div class="col-md-3" >
                                    <input type="submit"  class="btn btn-flat btn-primary"  style="margin-top: 24px; float: left" onclick="return checkrequired(this.form);" name="psearch" value="Search Links">
                                </div>

                              </div> 
                            </form>
                            <?php if($response[0]=="search"){ ?>
                            <div class=" col-md-12 table-responsive no-padding">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Sn.</th>
                                            <th>Title</th>
                                            <th>Link</th>
                                            <th>Type</th>
                                            <th>Parent Section</th>
                                            <th>Option</th>
                                            <th>action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if(!empty($response[1])){
                                            $cnt = 0;
                                            while($row = $this->db_read($response[1])){
                                                if($row['show']==1){
                                                    $option = "Show, ";
                                                }
                                                if($row['ad']==1){
                                                    $option .= "Add, ";
                                                }
                                                if($row['edit']==1){
                                                    $option .= "Edit, ";
                                                }
                                                if($row['del']==1){
                                                    $option .= "Delete, ";
                                                }
                                                $option = rtrim($option, ", ");
       
                                                ?>
                                        <tr id="row_<?php echo $row['id']?>">
                                            <td><?php echo ++$cnt ?></td>
                                            <td><?php echo $this->ucf($row['title']); ?></td>
                                            <td><?php echo $row['linkname'] ?></td>
                                            <td><?php echo $this->ucf($row['type']) ?></td>
                                            <td><?php echo $row['psec'] ?></td>
                                            <td><?php echo $option ?></td>
                                            <td>
                                                <input type="hidden" form="myform2" name="page" value="<?php echo $response[9] ?>">
                                                <button type="submit" form="myform2" name="psearch" onclick="$('#myform2').removeAttr('action');
                                                    $('#myform2').attr('action','<?php echo ADMIN_URL.'links/edit/'.base64_encode($row['id'])?>');$('#myform2').submit();" class=" btn btn-flat btn-warning">
                                                    Edit
                                                </button> | 
                                                <button onclick="return deleteLink(<?php echo $row['id'] ?>)" class=" btn btn-flat btn-danger">
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>
                                           <?php }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php
                                            } ?>
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

  function deleteLink(x,y){
      if(confirm("Are you sure to delete?")){
        var url = "<?php echo ADMIN_URL ?>deleteLink/"+x;
        $.ajax({
            url: url,
            success: function(res){
                if(res=="deleted"){
                    $("#row_"+x).remove();
                }else{
                    alert("Required data missing.");
                }
            }
        })
      }
  }
  function getlink_type(xx,selected){// prv, vno  are commimg from php echo to make vo dont change on same selected
         var url = "<?php echo ADMIN_URL ?>getlink_type/"+xx.value;
         $("#sectionid").empty();
         var html = "<option value=''> Select Section </option>"
         $("#sectionid").empty().append(html);
         if(xx.value=="subsection"){
             $("#sec").show();
             $("#sectionid").addClass("required");
         }else{
             $("#sec").hide();
             $("#sectionid").removeClass("required");
         }
         $.ajax({
          url:url,
          success: function(res){
            if(res!="false"){
                var jsonObj = JSON.parse(res);
                for(var i = 0;i < Object.keys(jsonObj.section).length; i++){
                    if(jsonObj.section[i].id == selected){
                        var sel = "selected";
                    }else{
                        var sel = "";
                    }
                    html += "<option "+sel+" value='"+jsonObj.section[i].id+"'>"+jsonObj.section[i].title+"</option>";
                }
                $("#sectionid").empty().append(html)
            }
        }
      }); 
  }
  function getlink_type1(xx,selected){// prv, vno  are commimg from php echo to make vo dont change on same selected
         var url = "<?php echo ADMIN_URL ?>getlink_type/"+xx.value;
         $("#sectionid1").empty();
         var html = "<option value=''> Select Section </option>"
         $("#sectionid1").empty().append(html);
         $.ajax({
          url:url,
          success: function(res){
            if(res!="false"){
                var jsonObj = JSON.parse(res);
                for(var i = 0;i < Object.keys(jsonObj.section).length; i++){
                    if(jsonObj.section[i].id == selected){
                        var sel = "selected";
                    }else{
                        var sel = "";
                    }
                    html += "<option "+sel+" value='"+jsonObj.section[i].id+"'>"+jsonObj.section[i].title+"</option>";
                }
                $("#sectionid1").empty().append(html)
            }
        }
      }); 
  }
$(document).ready(function(){
    var xx = document.getElementById('link_type1');
    <?php if($_POST['sectionid1']!=""){ ?>
    getlink_type1(xx,<?php echo $_POST['sectionid1'] ?>);
    <?php } ?>
    <?php if($edit["sectionid"]!=""){ ?>
    var xx1 = document.getElementById('link_type');
    getlink_type(xx1,<?php echo $edit['sectionid'] ?>);
    <?php } ?>
});
</script>
</body>

</html>

