<?php include_once __DIR__.'/../layout/header.php'; ?>
  <!-- Left side column. contains the logo and sidebar -->
<?php include_once __DIR__.'/../layout/menu.php'; ?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add/Manage Page Content
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Manage Page Content</a></li>
        <li class="active">Add Page Content</li>
      </ol>
    </section>
    <style>
        .form-group label{
          color: #00000094!important;  
        }
        </style>
    <!-- Main content -->
     <?php 
         if($response[0]=="edit"){$btn="Search Page Content";}else{$btn="Search Page Content";}
        ?>
    <?php $action = ($response[1]=="Edit")?"updatecontent":"addcontent" ?>
    <section class="content container-fluid" onload="updateSize();">
        <form id="myform" method="post" enctype="multipart/form-data" action="<?php echo ADMIN_URL.$action ?>">
            <div class="row">
                <div class="col-md-12">
                    <div class="box <?php echo $col ?>">
                        <div class="box-header">
                            <h4><?php echo $response[1] ?> Page Content </h4>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool"  data-widget="collapse"><i class="<?php echo $fa ?>"></i></button>
                            </div>
                        </div>
                        <div class="box-body" <?php echo $b_body ?>>
                            
                            <div class="col-md-6">
                                <div class=" form-group">
                                    <label>Select Page</label><br/>
                                    <?php
                                        $sel = ($edit['pagename']!="")?$edit['pagename']:"0";
                                        echo $this->getPageOptions("pagename","pagename","form-control required","Select Page","$sel","str"," onchange='return loadPageContent(this);' ");
                                        ?> 
                                </div>
                                
                            </div>
                            <div class="col-md-6">
                                <div class=" form-group">
                                    <label>Page Heading</label>
                                    <input type="text" id="pagetitle" class="form-control required" value="<?php echo $response[2]['title'] ?>" name="pagetitle">
                                </div>
                            </div>
                            <div class="col-md-12">
                                
                            </div>
                            <div class="col-md-12">
                                <?php 
                                header("Content-Type: text/html; charset=UTF-8");
        
                                $rs = stripcslashes($response[2]['news_content']);
                                ?>
                                <label>Page Description / Details</label>
                                <textarea id="newsdetails" name="newsdetails" rows="10" cols="80"></textarea>
                            </div>
                            <div class="col-md-12">
                                <input type="hidden" name="id" value="<?php echo $response[2]['newsId'] ?>">
                                <input type="submit" onclick=" return checkrequired(this.form) "  class="btn btn-flat btn-primary" name="submit" value="<?php echo $response[1] ?> Page Content">
                            
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
        filebrowserUploadUrl:"<?php echo ADMIN_URL ?>uploadimage/pagecontent/_page",
        filebrowserUploadMethod:"form",
        allowedContent: true,
        filebrowserBrowseUrl: '<?php echo BASE_URL ?>plugins/ckfinder/ckfinder.html',
	filebrowserUploadUrl: '<?php echo BASE_URL ?>plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files'
    });
    
  });
//a[!href]; ul; li{*}(*);div{*}(*)
function loadPageContent(ele){
    $.ajax({
       url:"<?php echo ADMIN_URL ?>loadPageContent",
       type:"post",
       data:{pagename:ele.value,resptyp:'json'},
       success: function(res){
         var jobj = JSON.parse(res);
         if(!jobj.res.error){
             $("#pagetitle").val(jobj.res.info.page_title)
             console.log(CKEDITOR.instances.newsdetails.element);
             CKEDITOR.instances['newsdetails'].setData(jobj.res.info.page_details);
             //$("#pagetitle").val(jobj.res.info.page_title)
         }
       }
    });
}

</script>
</script>
</body>

</html>

