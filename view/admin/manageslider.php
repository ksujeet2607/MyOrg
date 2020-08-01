<?php include_once __DIR__.'/../layout/header.php'; ?>
  <!-- Left side column. contains the logo and sidebar -->
<?php include_once __DIR__.'/../layout/menu.php'; ?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Manage Slider Images
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Master</a></li>
        <li class="active">Manage Slider Images</li>
      </ol>
    </section>
    <style>
        .form-group label{
          color: #00000094!important;  
        }
        </style>
    <!-- Main content -->
       <?php 
         if($response[0]=="edit"){$action="updateSlider";$btn="Update Slider";}else{$action="addSlider";$btn="Add Slider";}

         ?>
    <section class="content container-fluid" onload="updateSize();">
        <form id="myform" method="post" enctype="multipart/form-data" action="<?php echo ADMIN_URL.$action ?>">
            <div class="row">
                <div class="col-md-12">
                    <?php 
                      $j=1;$data = array();
                      while ($row = $this->db_read($response[1])) {
                          $data[$j] = $row;
                          $j++;
                      }
                     
                    ?>
                    <div class="box ">
                        <div class="box-header">
                            <h4><?php echo $btn; ?></h4>
                           
                        </div>
                        <div class="box-body" <?php echo $b_body ?>>
                            <?php
                            $NumberOfSliders = 6;
                            for($i=1;$i<=$NumberOfSliders;$i++){
                            ?>
<!--                            <div class="row" >-->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Select Image <?= $i ?></label>
                                        <input class=" form-control" type="file" id="upload_file<?= $i ?>" name="upload_file<?= $i ?>" onchange=" preview_image(this,'#image_preview<?= $i ?>');" multiple/>
                                    </div>
                                <div class=" col-md-12 no-padding" style=" margin-bottom: 40px;">
                                
                                <?php
                                    if($data[$i]['img_url']!=""){ ?>
                                        <div class=" col-md-6">
                                            <img src="<?= $data[$i]['img_url'] ?>" class=" img-thumbnail"> 
                                            <button class=" btn-danger" onclick="return removeSlider(<?= $i ?>)"> Remove This Slider</button>
                                        </div>
                                   <?php }
                                    ?>
                                
                                 <div class=" col-md-6">
                                        <div id="image_preview<?= $i ?>">
                                    
                                    </div>
                                </div>
                                    
                                </div>    
                                </div>
<!--                                <div class="col-md-3">
                                    <div class=" form-group">
                                        <label>Image <?= $i ?> Intro Heading</label>
                                        <input class=" form-control"  maxlength="50"  value="<?php echo $data[$i]['heading']; ?>" name="img<?= $i ?>intro" id="img<?= $i ?>intro" placeholder="Image <?= $i ?> Intro Heading">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class=" form-group">
                                        <label>Image <?= $i ?> Intro line1</label>
                                        <input class=" form-control"  maxlength="50"  value="<?php echo $data[$i]['line1']; ?>" name="img<?= $i ?>line1" id="img<?= $i ?>line1" placeholder="Image <?= $i ?> Intro line1">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class=" form-group">
                                        <label>Image <?= $i ?> Intro line2</label>
                                        <input class=" form-control"  maxlength="50"  value="<?php echo $data[$i]['line2']; ?>" name="img<?= $i ?>line2" id="img<?= $i ?>line2" placeholder="Image <?= $i ?> Intro line2" >
                                    </div>
                                </div>-->
<!--                            </div>-->
                            <?php } ?>
                            
                            <div class="col-md-12">
                                <br/>
                                <input name="id" type="hidden" value="<?php echo $response[4]; ?>">
                                <input name="numssld" type="hidden" value="<?php echo $NumberOfSliders; ?>">
                                <input type="submit"  class="btn btn-flat btn-primary" name="submit" value="Update Slider Image">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php include_once __DIR__.'/../layout/footer.php'; ?>
<?php echo session::GetMessage(); ?>
</div>
<script>
  function deleteSlider(x){
      if(confirm("Are you sure to delete?")){
        var url = "<?php echo ADMIN_URL ?>deleteSlider/"+x;
        $.ajax({
            url: url,
            success: function(res){
                if(res=="1"){
                    $("#row_"+x).remove();
                }else if(res=="2"){
                    alertify.sujeet("<p <?php echo MSG_ERR ?>>Required data missing.</p>");
                }else{
                    alertify.sujeet("<p <?php echo MSG_ERR ?>>Can't Delete This Slider. Related Data found!.</p>");
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

function preview_image(ele,id) 
{
 $(id).empty();
 var total_file=ele.files.length;
 for(var i=0;i<total_file;i++)
 {
  $(id).append("<div class='col-md-12' style='max-height: 400px; overflow:hidden;' id='img"+i+"'><img  class='img-thumbnail' src='"+URL.createObjectURL(event.target.files[i])+"'></div><br>");
 }

}

function removeSlider(id){
if(confirm('Are you sure to delete this slider?')){
    var url = "<?php echo ADMIN_URL ?>removeSlider/"+id;
        $.ajax({
            url: url,
            success: function(res){
                if(res=="1"){
                    window.location.reload();
                }else{
                    alert("Required Data Missing");
                }
            }
        })
    }
    return false;
}
</script>
</body>

</html>

