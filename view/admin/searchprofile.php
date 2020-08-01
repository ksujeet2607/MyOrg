<?php include_once __DIR__.'/../layout/header.php'; ?>
  <!-- Left side column. contains the logo and sidebar -->
<?php include_once __DIR__.'/../layout/menu.php'; ?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Update/Manage Profile
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Master</a></li>
        <li class="active">Manage Profile</li>
      </ol>
    </section>
    <style>
        .form-group label{
          color: #00000094!important;  
        }
        </style>
    <!-- Main content -->
    <section class="content container-fluid" onload="updateSize();">
        <?php 
         if($response[0]=="edit"){$btn="Search Profile";}else{$btn="Search Profile";}
        ?>
        <form id="myform2" method="post" action="<?php echo ADMIN_URL."searchprofile" ?>" autocomplete="off">
            <div class="row">
                <div class="col-md-12">

                    <div class="box <?php echo $col ?>">
                        <div class="box-header" style="background: #FFE4E1;padding: 1px 0px 0px 23px;">
                            <h4 style="font-weight: 600;"><?php echo $btn; ?></h4>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool"  data-widget="collapse"><i style="font-size: 26px; color: red;" class="<?php echo $fa ?>"></i></button>
                            </div>
                        </div>
                        <div class="box-body" <?php echo $b_body ?>>
                            <div class="col-md-3">
                                <div class=" form-group">
                                    <label>Search Status</label>
                                    <select class="form-control required" name="SearchProfile" id="SearchProfile">
                                        
                                        <option <?php echo ($_POST['SearchProfile']=="All" || $_POST['SearchProfile']=="")?"selected": ""; ?> value="All">All</option>
                                        <option <?php echo ($_POST['SearchProfile']=="1")?"selected": ""; ?> value="1">Verified</option>
                                        <option <?php echo ($_POST['SearchProfile']=="0")?"selected": ""; ?> value="0">Unverified</option>
                                        <option <?php echo ($_POST['SearchProfile']=="2")?"selected": ""; ?> value="2">Blocked</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class=" form-group">
                                    <label>Search Criteria</label>
                                  
                                    <select name="SearchCriteria" id="SearchCriteria" class="form-control" >
                                            <option <?php echo ($_POST['SearchCriteria']=="All")?"selected": ""; ?> value="All">All</option>
                                            <option <?php echo ($_POST['SearchCriteria']=="0")?"selected": ""; ?> value="0">Self Registered</option>
                                            <option <?php echo ($_POST['SearchCriteria']=="User")?"selected": ""; ?> value="User">Added By Admin User</option>
                                            <option <?php echo ($_POST['SearchCriteria']=="1")?"selected": ""; ?> value="1">Added By Admin</option>
                                            

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1" style=" text-align: center">
                                <label>OR</label><br>
                            </div>
                            <div class="col-md-3">
                                <div class=" form-group">
                                    <label>Search Keyword / Profile Id </label>
                                    <input class="form-control" type="text" value="<?php echo $_POST['SearchValue']; ?>" name="SearchValue" id="SearchValue" placeholder="Search Keyword / Profile Id">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <input name="id" type="hidden" value="<?php echo $response[4]; ?>">
                                <input type="submit"  class="btn btn-flat btn-primary" style="margin-top: 24px;" name="search" value="<?php echo $btn ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <?php if($response[0]=="search" || $response[0]=="edit"){ ?>
        <div class="box <?php echo $col ?>">
            <div class="box-header" style="background: #FFE4E1;padding: 1px 0px 0px 23px;">
                <h4 style="font-weight: 600;">Profile List <button class="btn export btn-success btn-flat" form="myform2" onclick="return exportRecord(this.form);" style="float: right;"><i class="fa fa-file-excel-o"></i> Export</button></h4>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool"  data-widget="collapse"><i style="font-size: 26px; color: red;" class="<?php echo $fa ?>"></i></button>
                </div>
            </div>
            <div class="box-body" <?php echo $b_body ?>>
                <div class=" table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Sr.</th>
                                <th>Profile ID</th>
                                <th>Personal Detail</th>
                                <th>Contact Detail</th>
                                <th>Occupation Detail</th>
                                <th>Family Detail</th>
                                <th>Other Info</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            if(!empty($response[1])){
                                $cnt = 0;
                            while($data = $this->db_read($response[1])){
                                
                                $id1 = base64_encode("editbrid_".$data['id']);
                                $id2 = base64_encode("deletebrid_".$data['id']);
                                $id3 = base64_encode("viewbrid_".$data['id']);
                                $action = "<a class='btn btn-flat btn-default' target='_blank' type='button' href='".ADMIN_URL."manageProfile/veiwprofile/$id3' name='veiwprofile'  value='$id3' id='$id3' style=' color:green'>"
                                        . "<i class='fa fa-eye'></i></a>&nbsp;<a target='_blank' class='btn btn-flat btn-default' type='button' href='".ADMIN_URL."manageProfile/editprofile/$id1' value='$id1' id='$id1' style='margin-right: 5px;color: blue'>"
                                        . "<i class='fa fa-edit'></i></a><button class='btn btn-flat btn-default' form='myform2' type='submit' name='deletebranch' onclick=' return deleteProfile(this)' value='$id2' id='$id2' style=' color:red'>"
                                        . "<i class='fa fa-trash'></i></button><br><br>";
//                                $action = "<button form='myform2' type='submit' name='editprofile' value='$id1' id='$id1' style='margin-right: 5px;color: blue'>"
//                                        . "<i class='fa fa-edit'></i></button><button form='myform2' type='submit' name='deleteprofile' onclick=' deleteProfile(this)' value='$id2' id='$id2' style=' color:red'>"
//                                        . "<i class='fa fa-trash'></i></button>";
                                
                          if($data['status']==0){ 
                            $action .='<button type="button" class="btn btn-flat btn-success" onclick="return changeMemSts('.$data['id'].',1)">
                                    Verify
                                </button> | 
                                <button type="button" class="btn btn-flat btn-warning" onclick="return changeMemSts('.$data['id'].',2)">
                                    Block
                                </button>';
                                 }elseif($data['status']==1){ 
                                   $action .='<button type="button" class="btn btn-flat btn-info" onclick="return changeMemSts('.$data['id'].',0)">
                                     Un-verify
                                   </button> |
                                   <button type="button" class="btn btn-flat btn-warning" onclick="return changeMemSts('.$data['id'].',2)">
                                     Block
                                   </button>';
                                }elseif($data['status']==2){
                                $action .='<button type="button" class="btn btn-flat btn-success" onclick="return changeMemSts('.$data['id'].',1)">
                                     Un-Block & Verify
                                   </button>';
                               }
                                
                               $action .= '<br><br><a target="_blank" class="btn btn-primary btn-flat" href="'.ADMIN_URL.'addbusiness/'.$data['LoginID'].'" >Business Details</a>';
                            ?>
                            <tr>
                                <td><?php echo ++$cnt; ?></td>
                                <td><?php echo "<b>Id: </b>".$data['LoginID']."<br>"."<b>Pwd: </b>".$data['password'] ?></td>
                                <td><?php echo"<b>Name: </b>".$data['name']."<br>"."<b>DOB: </b>".$this->formatdate($data['dob'],"d-m-Y")
                                        ."<br>"."<b>Gender: </b>".$data['gender']
                                        ."<br>"."<b>Marital Status: </b>".$data['mstatus']
                                        ."<br>"."<b>Caste: </b>".$data['caste']
                                        ."<br>"."<b>Subcaste: </b>".$data['subcaste']
                                        ?></td>
                                <td><?php echo "<b>Mobile: </b>".$data['mobile']
                                        ."<br>"."<b>Email: </b>".$data['email']
                                        ."<br>"."<b>Landline: </b>".$data['stdcode']."-".$data['phone']
                                        ."<br>"."<b>City: </b>".$data['city']
                                        ."<br>"."<b>Location: </b>".$data['location']
                                        ?></td>
                                <td><?php echo "<b>Education: </b>".$data['edu']
                                        ."<br>"."<b>Occupation: </b>".$data['occu']
                                        ."<br>"."<b>Office Contact: </b>".$data['o_contact']
                                        ?></td>
                                <td><?php echo "<b>Father Name: </b>". stripslashes($data['fanme'])
                                        ."<br>"."<b>Father DoB: </b>".$this->formatdate($data['fdob'],"d-m-Y")
                                        ."<br>"."<b>Mother Name: </b>".stripslashes($data['mname'])
                                        ."<br>"."<b>Mother DoB: </b>".$this->formatdate($data['mdob'],"d-m-Y")
                                        ."<br>"."<b>Brothers: </b>".$data['brother']
                                        ."<br>"."<b>Sister: </b>".$data['sister'];
                                        if($data['mstatus']!="Unmarried"){
                                        echo "<br>"."<b>Unmarried Son: </b>".$data['sonunmarried']
                                        ."<br>"."<b>Unmarried Daughter: </b>".$data['daughterunmarried'];
                                        }
                                        ?></td>
                                <td><?php echo "<b>Reg Date: </b>".$this->formatdate($data['reg_date'],"d-m-Y")
                                        ."<br>"."<b>Reg By: </b>".$data['addedby']
                                        ?></td>
                                <td><?php echo $action ?></td>
                            </tr>
                            <?php } } ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php } ?>

        
        
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
        'searching'   : true,
        'ordering'    : true,
        'info'        : false,
        'autoWidth'   : false
    });
  })
  function deleteCity(x){
      if(confirm("Are you sure to delete?")){
        var url = "<?php echo ADMIN_URL ?>deleteCity/"+x;
        $.ajax({
            url: url,
            success: function(res){
                if(res=="1"){
                    $("#row_"+x).remove();
                }else if(res=="2"){
                    alertify.sujeet("<p <?php echo MSG_ERR ?>>Required data missing.</p>");
                }else{
                    alertify.sujeet("<p <?php echo MSG_ERR ?>>Can't Delete This City. Related Data found!.</p>");
                }
            }
        })
      }
  }
  function loadAreaByCity(xx,yy){ //yy is used to show seleted when editing
    var url = "<?php echo ADMIN_URL ?>loadAreaByCity/"+xx.value;
//    alert(url);
    var $elem = $("#area");
    $elem.empty();
    var html = "<option value='0'>Select Location</option>";
    $.ajax({
        url: url,
        success: function(res){
            var obj = jQuery.parseJSON(res);
            console.log(obj);
            for(var j=0; j < Object.keys(obj.response).length;j++){  
                var selected = (yy==obj.response[j].Id)?"selected":"";
                html += "<option value='"+obj.response[j].Id+"' "+selected+">"+obj.response[j].AreaName+"</option>";
            }
            $elem.append(html);
        }
    });
  }
    function deleteProfile(xx){
    if(confirm("Are You Sure To Delete This Profile?")){
        return false;
    }else{
        return true;
    }
  }
  $(document).ready(function(){
     var $elem = document.getElementById('city'); 
     loadAreaByCity($elem,<?php echo ($edit['CityId']=="")?0:$edit['CityId'] ?>);
     <?php if($edit['ProfileType']=="Main Profile"){ ?>
        $("#MainProfile").removeClass("required"); 
        $("#MainProfile").attr("disabled","disabled"); 
     <?php } ?>
     <?php if($edit['StateId']!=""){ ?>
         $("#StateName").attr("disabled","disabled");
         $("#cityId").attr("disabled","disabled");
     <?php } ?>    
  });
  
    $("#myform input[type=submit]").on("click",function(){
       //return checkrequired("myform");      
  });
 function getOccuDetails(xx){
     var occu = xx.value;
     $(".occuDetail").hide();
     var $oc = $(".occuDetail").find(".ocu");
     $.each($oc,function(){
         $(this).removeClass("required");
     });
     if(occu=="Govt Job" || occu=="Private Job"){
         $(".job").show();
         var $oc = $(".job").find(".ocu");
     }
     if(occu=="Business"){
         $(".Business").show();
         var $oc = $(".Business").find(".ocu");
     }
     if(occu=="Professional"){
         $(".Professional").show();
         var $oc = $(".job").find(".ocu");       
     }
     $.each($oc,function(){
            $(this).addClass("required");
     });
 }
  
 function createUnMRDaughter(daughter){
     var $elem = $(".unmarrieddaughterdiv");
     //var daughter = Number(xx.value);
     
     for(var i =0; i < daughter; i++){
         if(i==0)var html = '<h5 style="margin-left: 14px;">Unmarried Daughter Detail</h5>';
         html += '<div class="col-md-4">'+
                    '<div class=" form-group">'+
                        '<label>Name</label>'+
                        '<input class="form-control  required" type="text" name="undaughter['+i+'][name]"  onKeyPress="return isAlphaOnly(event);" value="" placeholder="Name">'+
                    '</div>'+
                '</div>';
         html += '<div class="col-md-4">'+
                    '<div class=" form-group">'+
                        '<label>DOB</label>'+
                        '<input class="form-control date  required" type="text" name="undaughter['+i+'][age]" onKeyPress="return false;" value="" placeholder="DOB">'+
                    '</div>'+
                '</div>';
         html += '<div class="col-md-4">'+
                    '<div class=" form-group">'+
                        '<label>Job</label>'+
                        '<input class="form-control" type="text" name="undaughter['+i+'][job]"  value="" placeholder="Job">'+
                    '</div>'+
                '</div>';
     }
     
     $elem.empty();
     $elem.append(html);
     $(".date").datepicker({format: 'dd/mm/yyyy'});
      $("#daughterunmarried").val(daughter);
 } 
 function createUnMRSon(son){
     var $elem = $(".unmarriedsondiv");
     //var son = Number(xx.value);
     for(var i =0; i < son; i++){
         if(i==0)var html = '<h5 style="margin-left: 14px;">Unmarried Son Detail</h5>';
         html += '<div class="col-md-4">'+
                    '<div class=" form-group">'+
                        '<label>Name</label>'+
                        '<input class="form-control  required" type="text" name="unson['+i+'][name]"  onKeyPress="return isAlphaOnly(event);" value="" placeholder="Name">'+
                    '</div>'+
                '</div>';
         html += '<div class="col-md-4">'+
                    '<div class=" form-group">'+
                        '<label>DOB</label>'+
                        '<input class="form-control date  required" type="text" name="unson['+i+'][age]" onKeyPress="return false;" value="" placeholder="DOB">'+
                    '</div>'+
                '</div>';
         html += '<div class="col-md-4">'+
                    '<div class=" form-group">'+
                        '<label>Job</label>'+
                        '<input class="form-control" type="text" name="unson['+i+'][job]"  value="" placeholder="Job">'+
                    '</div>'+
                '</div>';
     }
     
     $elem.empty();
     $elem.append(html);
     $(".date").datepicker({format: 'dd/mm/yyyy'});
     $("#sonunmarried").val(son);
 } 
  
  $(document).on("ready",function(e){
    var $parentElem = document.getElementById('loginid');
      $.ajax({
         url:"<?php echo ADMIN_URL ?>getUniqueId",
         type:"post",
         success:function(res){
             $parentElem.value = res;
         }
      });
  });
  function deleteProfile(xx){
    if(confirm("Are You Sure To Delete This Profile?")){
        return false;
    }else{
        return true;
    }
  }
  
 function mstatusActions(xx){
     var mstatus = xx.value;
     if(mstatus!="Unmarried"){
         $(".married").show();
     }else{
         $(".married").hide();
     }
 } 
 
 function unMarriedDaughterAct(xx){
     var daughter = Number(xx.value);
     if(daughter!=NaN){
         var trgt = $("#daughterunmarried option");
         $.each(trgt,function(){
             var nn = Number($(this).text());
             if(nn!=NaN && nn > daughter){
                 $(this).hide();
             }else{
                 $(this).show();
             }
         })
     }
     createUnMRDaughter(daughter);
 }
 function unMarriedSonAct(xx){
     var son = Number(xx.value);
     if(son!=NaN){
         var trgt = $("#sonunmarried option");
         $.each(trgt,function(){
             var nn = Number($(this).text());
             if(nn!=NaN && nn > son){
                 $(this).hide();
             }else{
                 $(this).show();
             }
         })
     }
     createUnMRSon(son);
 }
 
 function preview_image(xx,id) 
{
 $('#'+id).empty();
 var total_file=xx.files.length;
 for(var i=0;i<total_file;i++)
 {
  $('#'+id).append("<img  class='img-thumbnail' src='"+URL.createObjectURL(event.target.files[i])+"'>");
 }

}

  function changeMemSts(x,sts){
      if(confirm("Are you sure to change status?")){
        var url = "<?php echo ADMIN_URL ?>changeMemSts/"+x+"/"+sts;
        $.ajax({
            url: url,
            success: function(res){
                if(res=="1"){
                    //window.location.href='<?php echo ADMIN_URL ?>modifynews'
                    window.location.reload();
                }else{
                    alertify.sujeet("<p <?php echo MSG_ERR ?>>Required data missing.</p>");
                }
            }
        })
      }
      return false;
  }
</script>
</body>

</html>

