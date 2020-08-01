<?php include_once __DIR__.'/../layout/header.php'; ?>
  <!-- Left side column. contains the logo and sidebar -->
<?php include_once __DIR__.'/../layout/menu.php'; ?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Edit/Delete News
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Manage News</a></li>
        <li class="active">Edit/Delete News</li>
      </ol>
    </section>
    <style>
        .form-group label{
          color: #00000094!important;  
        }
        </style>
    <!-- Main content -->
     <?php 
         if($response[0]=="list"){$action="modifynews";$btn="Edit News";}
         else{$action="modifynews";$btn="Edit News";}
         ?>
    <section class="content container-fluid" onload="updateSize();">
        <form id="myform" method="get" action="<?php echo ADMIN_URL.$action ?>">
            <div class="row">
                <div class="col-md-12">
                    <?php 
                        $cpage = ($response[4]!="")?$response[4]:1;
                        $col = ((int)$cpage > 1)?"collapsed-box":"";
                        $fa = ((int)$cpage > 1)?"fa fa-plus":"fa fa-minus";
                        $b_body = ((int)$cpage > 1)?"style='display:none;'":"";
                        //print_r($response);
                    ?>
                    <div class="box <?php echo $col ?>">
                        <div class="box-header">
                            <h4><?php echo $btn; ?></h4>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool"  data-widget="collapse"><i class="<?php echo $fa ?>"></i></button>
                            </div>
                        </div>
                        <div class="box-body" <?php echo $b_body ?>>
                            <div class="col-md-3">
                                <div class=" form-group">
                                    <label>From Date</label>
                                    <input class=" form-control " onkeypress="return false"  name="date1" id="date1" placeholder="News From" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class=" form-group">
                                    <label>To Date</label>
                                    <input class=" form-control " onkeypress="return false"  name="date2" id="date2" placeholder="News To" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control" name="status" id="status">
                                        <option <?php echo ($response[3]=="All")?"selected='true'":"" ?> value="All">All</option>
                                        <option <?php echo ($response[3]=="0")?"selected='true'":"" ?> value="0">Un-verified</option>
                                        <option <?php echo ($response[3]=="1")?"selected='true'":"" ?> value="1">Verified</option>
                                        <option <?php echo ($response[3]=="2")?"selected='true'":"" ?> value="2">Block</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class=" form-group">
                                    <label>Added By</label>
                                    <select class=" form-control" name="addedby" id="addedby">
                                        <option <?php echo ($response[4]=="All")?"selected='true'":"" ?> value="All">All</option>
                                        <option <?php echo ($response[4]=="0")?"selected='true'":"" ?> value="0">Member</option>
                                        <option <?php echo ($response[4]=="user")?"selected='true'":"" ?> value="user">Admin User</option>
                                        <option <?php echo ($response[4]=="1")?"selected='true'":"" ?> value="1">Admin</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <input name="id" type="hidden" value="<?php echo $response[3]; ?>">
                                <input type="submit"  class="btn btn-flat btn-primary" name="submit" value="Get News List">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <h4>News List</h4>
                        </div>
                        <div class="box-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Sn.</th>
                                        <th>News Title</th>
                                        <th>News Date</th>
                                        <th>Status</th>
                                        <th width="25%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                            <?php 
                            $date1 = $response[1];
                            $date2 = $response[2];
                            $status = $response[3];
                            $addedby = $response[4];
                            if($response[5]==""){
                                $datecond = " news_date between '".$date1."' AND '".$date2."'";
                            }
                            if($status!="All"){
                               $datecond .= " AND status=$status " ;
                            }
                            if($addedby!="All"){
                               if($addedby=="user"){
                                  $datecond .= " AND added_by NOT IN (0,1) " ; 
                               }else{
                                  $datecond .= " AND status=$addedby " ; 
                               }  
                            }
                            $showdate1 = urlencode(date("d/m/Y", strtotime($date1)));
                            $showdate2 = urlencode(date("d/m/Y", strtotime($date2)));
                            ?>
                        <?php 
                        $limit = 20;
                        $cpage = (isset($_GET['page']))?$_GET['page']:1;
                        echo $this->pagination("news where $datecond",$limit,$cpage,"?date1=$showdate1&date2=$showdate2&status=$status&addedby=$addedby&"); ?>
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
    var date1 = '<?php echo $date1 ?>';
    var date2 = '<?php echo $date2 ?>';
    var status = '<?php echo $status ?>';
    var isHomeEnq = '<?php echo $response[5] ?>';
    var addedby = '<?php echo $addedby ?>';
    $('.table').DataTable({
        'paging'      : false,
        'lengthChange': true,
        'searching'   : true,
        'ordering'    : true,
        'info'        : false,
        'autoWidth'   : false,
        processing: true,
        serverSide: true,
        ajax: {
            url : "<?php echo ADMIN_URL ?>getNewsRecord/"+limit+"/"+cpage+"/"+date1+"/"+date2+"/"+status+"/"+addedby+"/"+isHomeEnq,
            type:"post"
            
        }
        
    });
    $("#date1,#date2").datepicker({format: 'dd/mm/yyyy'}).on("change",function(){
        $(".datepicker").hide();
    });
    $("#date1").val('<?php echo date("d/m/Y", strtotime($date1)); ?>');
    $("#date2").val('<?php echo date("d/m/Y", strtotime($date2)); ?>');
  })
  function deleteNews(x){
      if(confirm("Are you sure to delete?")){
        var url = "<?php echo ADMIN_URL ?>deletens/"+x;
        $.ajax({
            url: url,
            success: function(res){
                if(res=="1"){
                    $("#row_"+x).remove();
                }else{
                    alertify.sujeet("<p <?php echo MSG_ERR ?>>Required data missing.</p>");
                }
            }
        })
      }
  }
  
    $("form input[type=submit]").on("click",function(){
       return checkrequired("myform");      
  });
</script>
</body>

</html>

