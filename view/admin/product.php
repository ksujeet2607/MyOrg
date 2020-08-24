<?php include_once __DIR__.'/../layout/header.php'; ?>
  <!-- Left side column. contains the logo and sidebar -->
<?php include_once __DIR__.'/../layout/menu.php'; ?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   <section class="content-header">
    <h1>
        Manage Product
    </h1>
    <ol class="breadcrumb">
        <li><i class="fa fa-dashboard"></i> Manage Product</li>
        <li class="active">Manage Product</li>
    </ol>
</section>

<style type="text/css">
    #cke_25, #cke_45 {
        display: none;
    }
    .box-header{
        padding: 10px;
    }
</style>
<section class="content">  
<?php 
         if($response[0]=="edit"){$action="updateproduct";$btn="Update Product";}else{$action="addproduct";$btn="Add Product";}
        ?>    
    <form name="form1" id="page-form" method="post" action="<?php echo ADMIN_URL.$action ?>" autocomplete="off" onsubmit="return checkForm(this);" enctype="multipart/form-data">
  <div class="box">
            <div class="box-header">
              <h4 class="box-title">Add/Manage Product </h4>
            </div>
            <div class="box-body">  
                <?php
                    //print_r($response);
                ?>
              <div class="col-md-6">   
                <div class="form-group">
                <label for="title">Product Category</label>
                <?php
                echo $this->getCatOptions("productcat","productcat","form-control","--Select Category--",$response[1]['cat'],'str');
                ?>
                </div>
              </div>
              <div class="col-md-6">   
                <div class="form-group">
                <label for="title">Product Name</label>
                 <input type="text" name="productname" class="form-control required" id="productname" placeholder="Enter Product Name" value="<?php echo $response[1]['productname'] ?>" required/>
                </div>
              </div>
             <div class="col-md-6">    
                <div class="form-group">
                   <label for="title">Brand Name</label>
                   <input type="text" name="brand" class="form-control required" placeholder="Enter Brand Name" id="brand" value="<?php echo $response[1]['brand'] ?>" required/>
                </div>
             </div>
             <div class="col-md-3">    
                <div class="form-group">
                    <label for="title">Strike Price (Optional) E.g: <del>500</del></label>
                    <input type="text" maxlength="10" oninput=" calPrice(this) " onkeypress=" return isNumberKey(event);" placeholder="Enter Strike Price" name="strikeprice" class="form-control required" id="strikeprice" value="<?php echo $response[1]['strikeprice'] ?>" />
                </div>
             </div>
             
             <div class="col-md-3">    
                <div class="form-group">
                   <label for="title">Offer (Optional)</label>
                   <input type="text" maxlength="10" oninput=" calPrice(this) " onkeypress=" return isNumberKey(event);" placeholder="Enter Offer" name="offer" class="form-control required" id="offer" value="<?php echo $response[1]['offer'] ?>" />
                </div>
             </div>   
             <div class="col-md-3">    
                <div class="form-group">
                   <label for="title">Price</label>
                   <input type="text" maxlength="10" onkeypress=" return isNumberKey(event);" placeholder="Enter Price" name="price" class="form-control required" id="price" value="<?php echo $response[1]['price'] ?>" />
                </div>
             </div>
             <div class="col-md-3">    
                <div class="form-group">
                   <label for="title">Unit (E.g per kg , per 10 ml. / liter, / 10 ml)</label>
                   <input type="text" maxlength="50" placeholder="Enter Unit" name="unit" class="form-control required" id="unit" value="<?php echo $response[1]['unit'] ?>" />
                </div>
             </div>
             <div class="col-md-6">    
                <div class="form-group">
                   <label for="title">Search Keywords (If multiple separate by , E.g Hemp oil, Hamp oil, Hmp oil)</label>
                   <textarea type="text" maxlength="200" placeholder="Search Keywords" name="productkey" class="form-control required" id="productkey"><?php echo $response[1]['productkey'] ?></textarea>
                </div>
             </div>
             <div class="col-md-12">    
                <div class="form-group">
                    <?php
                    $arr = explode(",", $response[1]['productas']);
                    ?>
                    <label for="title">Product Save As (Optional)</label><br/>
                    <input type="checkbox" name="saveas[]" <?= in_array("Best Seller",$arr)?"checked":"" ?> id="BestSeller" value="Best Seller"><label for="BestSeller">Best Seller</label>&nbsp;&nbsp;
                    <input type="checkbox" name="saveas[]" <?= in_array("Top Seller",$arr)?"checked":"" ?> id="TopSeller" value="Top Seller"><label for="TopSeller">Top Seller</label>&nbsp;&nbsp;
                    <input type="checkbox" name="saveas[]" <?= in_array("Featured Product",$arr)?"checked":"" ?> id="FeaturedProduct" value="Featured Product"><label for="FeaturedProduct">Featured Product</label>&nbsp;&nbsp;
                    <input type="checkbox" name="saveas[]" <?= in_array("Latest Product",$arr)?"checked":"" ?> id="LatestProduct" value="Latest Product"><label for="LatestProduct">Latest Product</label>&nbsp;&nbsp;
                </div>
             </div>
            <div class="col-md-12 no-padding">
                <div class="col-md-12" style="">
                    
                    <label id="lphoto">Select Photos</label>
                    <input type="file" name="productImg[]" style=" max-width: 300px;" id="photo" onchange="preview_image(this,'image_preview');" class=" form-control <?php echo $class; ?>" multiple>
                    <div id="image_preview1" style='max-height: 400px; overflow:hidden;margin-top: 30px;'>
                        <?php
                        if(!empty($response[1]['photos'])){
                            $pht = explode("||", $response[1]['photos']);
                            foreach ($pht as $value) {
                                if($value!=""){
                        ?>
                        <div class='col-md-1 immg'>
                           <img style='height: 50px'  class='img-thumbnail' src='<?= $value ?>' alt="<?= $response[1]['id'] ?>">
                            <br><span style='cursor: pointer;' onclick=' return removeImg(this);'>
                                <i style='color:red;' class='fa fa-trash'></i></span>
                        </div>
                        <?php } } } ?>
                        
                    </div>
                    <div id="image_preview" style='max-height: 400px; overflow:hidden;margin-top: 30px;'>
                    </div>
                </div>

            </div>
            <div class="col-md-12">
                <?php 
                header("Content-Type: text/html; charset=UTF-8");

                $rs = stripcslashes($response[2]['news_content']);
                ?>
                <label>Product Description / Details</label>
                <textarea id="newsdetails" name="newsdetails" rows="3" cols="80"><?php echo $response[1]['productDesc'] ?></textarea>
            </div>
            <div class="col-md-3"> 
             <div class="form-group">
                <input type="hidden" name="productid" value="<?php echo $response[1]['id'] ?>">
                <input type="submit" id="submit" name="submit"  class="btn btn-primary btn-flat" value="<?php echo $btn ?>">
                
               </div> 
            </div> 
                <?php
                if(($response[0]=="edit")){ ?>
                <div class="col-md-3">
                <a href="<?php echo ADMIN_URL ?>product" class="btn btn-default btn-flat" >Add New</a>
                </div>
                <?php } ?>
    </div>
  </div>
</form>
     </section>

 
   </div> 
  
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
        height: 400,
        filebrowserUploadUrl:"<?php echo ADMIN_URL ?>uploadimage/products/_product",
        filebrowserUploadMethod:"form",
        allowedContent: true
        //filebrowserBrowseUrl: '<?php echo BASE_URL ?>plugins/ckfinder/ckfinder.html',
	//filebrowserUploadUrl: '<?php echo BASE_URL ?>plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files'
    });
    
  });
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
});

function deleteProduct(x){
      if(confirm("Are you sure to delete?")){
        var url = "<?php echo ADMIN_URL ?>deleteProduct/"+x;
        $.ajax({
            url: url,
            success: function(res){
                if(res=="1"){
                    $("#row_"+x).remove();
                }else if(res=="2"){
                    alertify.sujeet("Required data missing.</p>");
                }else{
                    alertify.sujeet("<p <?php echo MSG_ERR ?>>Can't Delete This Product. Related Data found!.</p>");
                }
            }
        })
      }
  }
  
   function preview_image(xx,id) 
 {
 //$('#'+id).empty();
 var total_file=xx.files.length;var msg ="";
 for(var i=0;i<total_file;i++)
 {

   if(event.target.files[i].type=="image/jpeg" || event.target.files[i].type=="image/jpg")
   $('#'+id).append("<div class='col-md-1 immg'><input type='hidden' name='newImgs["+i+"]' value='"+event.target.files[i].name+"'><img style='height: 50px'  class='img-thumbnail' src='"+URL.createObjectURL(event.target.files[i])+"'><br><span style='cursor: pointer;' onclick=' return removeImg(this);'><i style='color:red;' class='fa fa-trash'></i></span></div>");
   else{
        msg = "Only jpg / jpeg images can be uploaed."
   }
   
 }
 if(msg!=""){
     alert(msg);
 }
 }
  
   function removeImg(ele){
  if(confirm("Are you sure to remove?")){
    var el = ele.parentElement;
    var str = $(el).find("img").attr("src");
    var id = $(el).find("img").attr("alt");
    $.ajax({
         url:"<?php echo ADMIN_URL ?>deleteProductImg",
         type:"post",
         data:{id:id,src:str},
         success:function(res){
             if(res)el.remove();
             else
             alert("Request record is missing");
             
         }
      });
    el.remove();
    
  }
   return false; 
 }
  
  function calPrice(ele){
    var vl1 = Number($("#strikeprice").val()) || 1;
    var vl2 = Number($("#offer").val()) || 0;
    var per = 100 - vl2;
    vl1 = (vl1*per)/100;
    $("#price").val(vl1)
  }
  
</script>
</body>

</html>

