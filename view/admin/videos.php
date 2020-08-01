<?php include_once __DIR__.'/../layout/header.php'; ?>
  <!-- Left side column. contains the logo and sidebar -->
<?php include_once __DIR__.'/../layout/menu.php'; ?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add/Manage Videos
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Add/Manage Videos</a></li>
        <li class="active">Manage Videos</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid" onload="updateSize();">
        <?php 
         if($response[0]=="edit"){$action="updateVideos";$btn="Update Videos";}else{$action="addVideos";$btn="Add Videos";}

         ?>
        <form id="myform" method="post" enctype="multipart/form-data" action="<?php echo ADMIN_URL.$action ?>">
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
                                    <label>Video Title</label>
                                    <input class=" form-control required" onkeypress="return isAlphanumaricOnly(event)" maxlength="150"  value="<?php echo $response[1]; ?>" name="txttitle" id="txttitle" placeholder="Enter Videos name" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class=" form-group">
                                    <label>Video Link</label>
                                    <input class=" form-control required"   value='<?php echo $this->showChunckInfo($response[2],$map); ?>' name="url" id="url" placeholder="Enter Embaded Code from Youtube " required>
                                <?php
                                if($response[2] !=""){
                                    echo html_entity_decode($this->showChunckInfo($response[2],$map));
                                }
                                ?>
                                   
                                </div>
                            </div>
                            <div class="col-md-12">
                                <br/>
                                <input name="id" type="hidden" value="<?php echo $response[3]; ?>">
                                <input type="submit"  class="btn btn-flat btn-primary" onclick=" return checkselected()" name="submit" value="<?php echo $btn ?>">
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
                            <h4>Videos List</h4>
                        </div>
                        <div class="box-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Sn.</th>
                                        <th>Videos Name</th>
                                        <th width="20%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        <?php 
                        $limit = 30;
                        $cpage = (isset($_GET['page']))?$_GET['page']:1;
                        echo $this->pagination("Videos",$limit,$cpage); ?>
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
            url : "<?php echo ADMIN_URL ?>getVideosRecord/"+limit+"/"+cpage,
            type:"post"
            
        }
    });
  })
  function deleteVideos(x){
      if(confirm("Are you sure to delete?")){
        var url = "<?php echo ADMIN_URL ?>deleteVideos/"+x;
        $.ajax({
            url: url,
            success: function(res){
                if(res=="1"){
                    $("#row_"+x).remove();
                }else if(res=="2"){
                    alertify.sujeet("<p <?php echo MSG_ERR ?>>Required data missing.</p>");
                }else{
                    alertify.sujeet("<p <?php echo MSG_ERR ?>>Can't Delete This Videos. Related Data found!.</p>");
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

