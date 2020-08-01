<?php include_once __DIR__.'/../layout/header.php'; ?>
  <!-- Left side column. contains the logo and sidebar -->
<?php include_once __DIR__.'/../layout/menu.php'; ?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add/Update Gallery
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Manage Gallery</a></li>
        <li class="active">Edit/Delete Gallery</li>
      </ol>
    </section>
    <style>
        .form-group label{
          color: #00000094!important;  
        }
        </style>
    <!-- Main content -->
       <?php 
         if($response[0]=="edit"){$action="updateGallery";$btn="Update Gallery";}else{$action="addGallery";$btn="Add Gallery";}

         ?>
    <section class="content container-fluid" onload="updateSize();">
        <form id="myform" method="post" enctype="multipart/form-data" action="<?php echo ADMIN_URL.$action ?>">
            <div class="row">
                <div class="col-md-12">
                    <?php 
                        $cpage = ($response[5]!="")?$response[5]:1;
                        //print_r($response);
                    ?>
                    <div class="box <?php echo $col ?>">
                        <div class="box-header">
                            <h4><?php echo $btn; ?></h4>
                           
                        </div>
                        <div class="box-body" <?php echo $b_body ?>>
                            <div class="col-md-12">
                                <div class=" form-group">
                                    <label>Gallery Title</label>
                                    <input class=" form-control"  maxlength="50"  value="<?php echo $response[1]['title']; ?>" name="title" id="title" placeholder="Enter Gallery name" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="file" id="upload_file" name="upload_file[]" onchange=" preview_image();" multiple/>
                                </div>
                              </div>
                            <div class="col-sm-12">
                                <div id="image_preview">
                                   <?php 
                                   if(!empty($response[3])){
                                       $stmt  = $response[3]; 
                                   if($stmt->rowCount() > 0){
                                       $i = 100;
                                       while ($row = $this->db_read($response[3])){
                                           
                                       ?>
                                       <div class='col-md-4' style='max-height: 400px; overflow:hidden;margin-top: 30px;' id="img<?php echo $i; ?>">
                                           <div clas='img-cp' style=''>    
                                                <label>
                                                    <input type='radio' <?php echo (pathinfo($row['images_path'])['filename']== pathinfo($response[2]['header_img'])['filename'])?"checked='true'":""  ?>  value='<?php echo $row['images_path']; ?>' name='default_img'>Set As Main Image
                                                </label>
                                                <a href='#' style='    margin-left: 40px;' onclick="delete_image(<?php echo $row['id'] ?>,'img<?php echo $i; ?>');"><i class='fa fa-times' style='color:red;'></i></a>
                                               <input type='text' name='oldphtname[<?php echo $row['id'] ?>]' value='<?php echo $row['images_title']; ?>' class='form-control' placeholder='Photo Caption/Title'>
                                               </div>    
                                           <img class='img-thumbnail'  src='<?php echo $row['images_path']  ?>' alt="<?php echo $row['images_title']; ?>">
                                               <br>
                                               
                                       </div>
                                    
                                       <?php  $i++;
                                       $ids .=$row['id'].","; 
                                       
                                       } 
                                       
                                       }
                                    } ?>
                                    <input type="hidden" name="oldids" value="<?php echo rtrim($ids,",") ?>">
                                </div>

                            </div> 
                            <div class="col-md-12">
                                <br/>
                                <input name="id" type="hidden" value="<?php echo $response[4]; ?>">
                                <input type="submit"  class="btn btn-flat btn-primary" name="submit" value="<?php echo $btn ?>">
                                <?php if($action=="updateGallery"){ ?>
                                <a type="button" href="<?php echo ADMIN_URL."creategallery"; ?>" class="btn btn-flat btn-default" >Add New Gallery</a>
                                <?php } ?>
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
                            <h4>Gallery List</h4>
                        </div>
                        <div class="box-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Sn.</th>
                                        <th>Gallery Name</th>
                                        <th>Main Image</th>
                                        <th width="20%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        <?php 
                        $limit = 30;
                        $cpage = (isset($_GET['page']))?$_GET['page']:1;
                        echo $this->pagination("Gallery",$limit,$cpage); ?>
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
            url : "<?php echo ADMIN_URL ?>getGalleryRecord/"+limit+"/"+cpage,
            type:"post"
            
        }
    });
  })
  function deleteGallery(x){
      if(confirm("Are you sure to delete?")){
        var url = "<?php echo ADMIN_URL ?>deleteGallery/"+x;
        $.ajax({
            url: url,
            success: function(res){
                if(res=="1"){
                    $("#row_"+x).remove();
                }else if(res=="2"){
                    alertify.sujeet("<p <?php echo MSG_ERR ?>>Required data missing.</p>");
                }else{
                    alertify.sujeet("<p <?php echo MSG_ERR ?>>Can't Delete This Gallery. Related Data found!.</p>");
                }
            }
        })
      }
  }
  
    $("form input[type=submit]").on("click",function(){
       return checkrequired("myform");      
  });
</script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script>
<script>
//$(document).ready(function() 
//{ 
// $('form').ajaxForm(function() 
// {
//  alert("Uploaded SuccessFully");
// }); 
//});

function preview_image() 
{
 var total_file=document.getElementById("upload_file").files.length;
 for(var i=0;i<total_file;i++)
 {
  $('#image_preview').append("<div class='col-md-4' style='max-height: 400px; overflow:hidden;margin-top: 30px;' id='img"+i+"'><div clas='img-cp' style=' '><label><input type='radio' value='"+event.target.files[i].name+"' name='default_img'>Set As Main Image</label><input type='hidden' value='"+event.target.files[i].name+"' name='images_up[]'><a href='#' style='    margin-left: 40px;' onclick=\"$('#img"+i+"').remove();\"><i class='fa fa-times' style='color:red;'></i></a><br><input type='text' name='phtname[]' class='form-control' placeholder='Photo Caption/Title'></div><img  class='img-thumbnail' src='"+URL.createObjectURL(event.target.files[i])+"'></div>");
 }

}

function checkselected(){
if($("input[name='default_img']:checked").val()){
    return true;
}else{
    alertify.sujeet("<p>Please select header images</p>");
    return false;
}

}
function delete_image(xx,y){
if(confirm('Are you sure to delete this image?')){
    var url = "<?php echo ADMIN_URL ?>deletegalimage/"+xx;
        $.ajax({
            url: url,
            success: function(res){
                if(res=="1"){
                    $('#'+y).remove();
                }else if(res=="2"){
                    alertify.sujeet("<p <?php echo MSG_ERR ?>>Required data missing.</p>");
                }else{
                    alertify.sujeet("<p <?php echo MSG_ERR ?>>Can't Delete This Image. Related Data found!.</p>");
                }
            }
        })
    }
}
</script>
</body>

</html>

