<?php include_once __DIR__.'/../layout/header.php'; ?>
  <!-- Left side column. contains the logo and sidebar -->
<?php include_once __DIR__.'/../layout/menu.php'; ?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add/Manage Category <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Master</a></li>
        <li class="active">Manage Category</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid" onload="updateSize();">
        <?php 
         if($response[0]=="edit"){$action="updatecat";$btn="Update Category";}else{$action="addcat";$btn="Add Category";}
        ?>
        <form id="myform" method="post" action="<?php echo ADMIN_URL.$action ?>">
            <div class="row">
                <div class="col-md-12">
                    <?php 
                        $cpage = ($response[4]!="")?$response[4]:1;
                        $col = ((int)$cpage > 1)?"collapsed-box":"";
                        $fa = ((int)$cpage > 1)?"fa fa-plus":"fa fa-minus";
                        $b_body = ((int)$cpage > 1)?"style='display:none;'":"";
                    ?>
                    <div class="box <?php echo $col ?>">
                        <div class="box-header">
                            <h4><?php echo $btn; ?></h4>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool"  data-widget="collapse"><i class="<?php echo $fa ?>"></i></button>
                            </div>
                        </div>
                        <div class="box-body" <?php echo $b_body ?>>
                            <div class="col-md-12">
                                <div class=" form-group">
                                    <label>News Category Name</label>
                                    <input class=" form-control" onkeypress="return isAlphaOnly(event)" maxlength="50"  value="<?php echo $response[1]; ?>" name="catname" id="catname" placeholder="Enter News Category" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <input name="id" type="hidden" value="<?php echo $response[2]; ?>">
                                <input type="submit"  class="btn btn-flat btn-primary" name="submit" value="<?php echo $btn ?>">
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
                            <h4>Category List</h4>
                        </div>
                        <div class="box-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Sn.</th>
                                        <th>Category</th>
                                        <th width="20%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        <?php 
                        $limit = 30;
                        $cpage = (isset($_GET['page']))?$_GET['page']:1;
                        echo $this->pagination("cat",$limit,$cpage); ?>
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
        'searching'   : true,
        'ordering'    : true,
        'info'        : false,
        'autoWidth'   : false,
        processing: true,
        serverSide: true,
        ajax: {
            url : "<?php echo ADMIN_URL ?>getcatRecord/"+limit+"/"+cpage,
            type:"post"
            
        }
    });
  })
  function deletecat(x){
      if(confirm("Are you sure to delete?")){
        var url = "<?php echo ADMIN_URL ?>deletecat/"+x;
        $.ajax({
            url: url,
            success: function(res){
                if(res=="1"){
                    $("#row_"+x).remove();
                }else if(res=="2"){
                    alertify.sujeet("<p <?php echo MSG_ERR ?>>Required data missing.</p>");
                }else{
                    alertify.sujeet("<p <?php echo MSG_ERR ?>>Can't Delete This cat. Related Data found!.</p>");
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

