<?php include_once __DIR__.'/../layout/header.php'; ?>
  <!-- Left side column. contains the logo and sidebar -->
<?php include_once __DIR__.'/../layout/menu.php'; ?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add/Manage News
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Manage News</a></li>
        <li class="active">Add News</li>
      </ol>
    </section>
    <style>
        .form-group label{
          color: #00000094!important;  
        }
        </style>
    <!-- Main content -->
     <?php 
         if($response[0]=="edit"){$btn="Search News";}else{$btn="Search News";}
        ?>
    <?php $action = ($response[1]=="Edit")?"updatenews":"addnews" ?>
    <section class="content container-fluid" onload="updateSize();">
        <form id="myform" method="post" enctype="multipart/form-data" action="<?php echo ADMIN_URL.$action ?>">
            <div class="row">
                <div class="col-md-12">
                    <div class="box <?php echo $col ?>">
                        <div class="box-header">
                            <h4><?php echo $response[1] ?> News </h4>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool"  data-widget="collapse"><i class="<?php echo $fa ?>"></i></button>
                            </div>
                        </div>
                        <div class="box-body" <?php echo $b_body ?>>
                            <div class="col-md-12">
                                <div class=" form-group">
                                    <label>News Heading</label>
                                    <input type="text" id="news_head" class="form-control required" value="<?php echo $response[2]['title'] ?>" name="news_head">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class=" form-group">
                                    <label>News Highlight</label>
                                    <input type="text" id="content_title" class="form-control required" value="<?php echo $response[2]['content_title'] ?>" name="content_title">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class=" form-group">
                                    <label>Select Header/Main Image</label>
                                    <input type="file" id="news_head_img" onchange="updateSize(this);" class="form-control <?php echo ($response[1]!="Edit")?"required":"" ?>" name="news_head_img">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class=" form-group">
                                    <label>Preview</label>
                                    <div id='img_preview' style=" max-width: 780px; overflow-x: scroll;border: 1px dashed #605ca8;">
                                        <?php if($response[1]=="Edit"){ ?>
                                        <img src="<?php echo $response[2]['header_image'] ?>">
                                        <?php } ?>
                                        <?php list($width, $height, $type, $attr) = getimagesize($response[2]['header_image']);
                                        $size = get_headers($response[2]['header_image'], 1);
                                        ?>
                                    </div>
                                    size: <span class="imgd" id="fileSize"><?php echo ($size['Content-Length']/1024)."KiB (".$size['Content-Length']."bytes)" ; ?></span>width: <span class="imgd" id="filewidth"><?php echo $width ?></span>height: <span class="imgd" id="fileheight"><?php echo $height ?></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class=" form-group">
                                    <label>Images Caption</label>
                                    <input type="text" id="image_caption" class="form-control" value="<?php echo $response[2]['image_caption'] ?>" name="image_caption">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class=" form-group">
                                    <label>Video Link(If Any)</label>
                                <input type="text" id="video_link" class="form-control" value="" name="video_link">
                                </div>
                                <?php
                                if($response[2]['video_link'] !=""){
                                    echo html_entity_decode($this->showCunckInfo($response[2]['video_link'],$map));
                                }
                                ?>
                            </div>
                            <div class="col-md-12">&nbsp;</div>
                            <div class="col-md-4">
                                <div class=" form-group">
                                    <label>Select News Date</label>
                                    <input type="text" id="news_date" class="form-control required" value="<?php echo ($response[2]['news_date']!="")? date("d/m/Y",strtotime($response[2]['news_date'])):date("d/m/Y"); ?>" name="news_date">
                                </div>
                                
                            </div>
                            <div class="col-md-8">
                                <div class=" form-group">
                                    <label>News Category</label><br/>
                                    <?php
                                    $show = explode(",", $response[2]['show_as']);
                                    $rs = $this->getNewsCateChecks();
                                    while($data = $this->db_read($rs)){ ?>
                                    <input type="checkbox" name="news_show_as[]" <?php echo in_array($data['newscatName'],$show)?"checked":"" ?> id="<?php echo str_replace(" ", "", $data['newscatName']) ?>" value="<?php echo $data['newscatName'] ?>"><label for="<?php echo str_replace(" ", "", $data['newscatName']) ?>" class="lw-label"><?php echo $data['newscatName'] ?></label>&nbsp;&nbsp;
                                    <?php } ?>
                                </div>
                                
                            </div>
                            <div class="col-md-12">
                                
                            </div>
                            <div class="col-md-12">
                                <?php 
                                header("Content-Type: text/html; charset=UTF-8");
        
                                $rs = stripcslashes($response[2]['news_content']);
                                ?>
                                <textarea id="newsdetails" name="newsdetails" rows="10" cols="80"><?php echo $rs ?></textarea>
                            </div>
                            <div class="col-md-12">
                                <input type="hidden" name="id" value="<?php echo $response[2]['newsId'] ?>">
                                <input type="submit" onclick=" return checkrequired('myform') "  class="btn btn-flat btn-primary" name="submit" value="<?php echo $response[1] ?> News">
                                <?php if($response[1]=="Edit"){ ?>
                                <button type="button" class="btn btn-flat btn-danger" onclick="return deleteNews(<?php echo $response[2]['newsId'] ?>)">
                                    Delete
                                </button>
                                <?php if($response[2]['status']==0){ ?>
                                <button type="button" class="btn btn-flat btn-success" onclick="return changeNewsSts(<?php echo $response[2]['newsId'] ?>,1)">
                                    Verify
                                </button>
                                <button type="button" class="btn btn-flat btn-warning" onclick="return changeNewsSts(<?php echo $response[2]['newsId'] ?>,2)">
                                    Block
                                </button>
                                <?php }elseif($response[2]['status']==1){ ?>
                                   <button type="button" class="btn btn-flat btn-info" onclick="return changeNewsSts(<?php echo $response[2]['newsId'] ?>,0)">
                                     Un-verify
                                   </button>
                                   <button type="button" class="btn btn-flat btn-warning" onclick="return changeNewsSts(<?php echo $response[2]['newsId'] ?>,2)">
                                     Block
                                   </button> 
                                <?php }elseif($response[2]['status']==2){ ?>
                                <button type="button" class="btn btn-flat btn-success" onclick="return changeNewsSts(<?php echo $response[2]['newsId'] ?>,1)">
                                     Un-Block & Verify
                                   </button>
                                <?php } ?>
                                <?php } ?>
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
<script src="https://cdn.ckeditor.com/4.13.0/full-all/ckeditor.js"></script>
<!--<script src="https://cdn.ckeditor.com/4.13.0/standard-all/ckeditor.js"></script>-->
<script>
  $(function () {
    CKEDITOR.replace('newsdetails',{
        height: 600,
        filebrowserUploadUrl:"<?php echo ADMIN_URL ?>uploadimage/newsimages",
        filebrowserUploadMethod:"form"
    });
 
    $("#news_date").datepicker({format: 'dd/mm/yyyy'}).on("change",function(){
        $(".datepicker").hide();
    });
    var xx = document.getElementById('cont_id');
    getCountry(xx,'<?php echo $response[2]['countryId'] ?>');
  });

</script>
<script>
function updateSize(xx,e) {
  let nBytes = 0,
      oFiles = document.getElementById("news_head_img").files,
      nFiles = oFiles.length;
  for (let nFileId = 0; nFileId < nFiles; nFileId++) {
       nBytes += oFiles[nFileId].size;
        var reader = new FileReader();
        
        reader.onload = function (e) {
            $('#img_preview').empty();
            //$('#preview').remove();
            var img = document.createElement("img");
            img.src = e.target.result;
            img.id = "preview";
            
            $('#img_preview').append(img);
            
        };
        reader.onloadend = function(e){
            var imge = document.getElementById('preview');
            var img = new Image();
            img.src = imge.src;
            var width = img.width;
            var height = img.height;
            var MAX_WIDTH = 780;
            var MAX_HEIGHT = 600;
            var width = img.naturalWidth;
            var height = img.naturalHeight;
            if (width > height) {
              if (width > MAX_WIDTH) {
                height *= MAX_WIDTH / width;
                width = MAX_WIDTH;
              }
            } else {
              if (height > MAX_HEIGHT) {
                width *= MAX_HEIGHT / height;
                height = MAX_HEIGHT;
              }
            }
            img.width = width;
            img.height = height;            
            document.getElementById("filewidth").innerHTML = width;
            document.getElementById("fileheight").innerHTML = height;  
            $('#img_preview').empty();
            $('#img_preview').append(img);
        };
        reader.readAsDataURL(xx.files[0]);
    
  }
  let sOutput = nBytes + " bytes";
  for (let aMultiples = ["KiB", "MiB", "GiB", "TiB", "PiB", "EiB", "ZiB", "YiB"], nMultiple = 0, nApprox = nBytes / 1024; nApprox > 1; nApprox /= 1024, nMultiple++) {
    sOutput = nApprox.toFixed(3) + " " + aMultiples[nMultiple] + " (" + nBytes + " bytes)";
  }

}
  function deleteNews(x){
      if(confirm("Are you sure to delete?")){
        var url = "<?php echo ADMIN_URL ?>deletens/"+x;
        $.ajax({
            url: url,
            success: function(res){
                if(res=="1"){
                    window.location.href='<?php echo ADMIN_URL ?>modifynews'
                }else{
                    alertify.sujeet("<p <?php echo MSG_ERR ?>>Required data missing.</p>");
                }
            }
        })
      }
      return false;
  }
  function changeNewsSts(x,sts){
      if(confirm("Are you sure to change status?")){
        var url = "<?php echo ADMIN_URL ?>changeNewsSts/"+x+"/"+sts;
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

