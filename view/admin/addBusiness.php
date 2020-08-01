<?php include_once __DIR__.'/../layout/header.php'; ?>
  <!-- Left side column. contains the logo and sidebar -->
<?php include_once __DIR__.'/../layout/menu.php'; ?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add/Update Business Details
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Manage Business Details</a></li>
        <li class="active">Add/Update Business Details</li>
      </ol>
    </section>
    <style>
        .form-group label{
          color: #00000094!important;  
        }
        .products{
            padding: 8px 0px;
            border-bottom: 1px solid #0b537d;
            border-top: 1px solid #0b537d;
        }
        </style>
    <!-- Main content -->
    <section class="content container-fluid" onload="updateSize();">
        <?php 
        
         if($response[0]=="edit"){$btn="Save Business";$action="updateProduct";}else{$btn="Save Business";$action="addProduct";}
        ?>
        <form id="myform2" method="post" action="<?php echo ADMIN_URL."addProduct" ?>" enctype="multipart/form-data" autocomplete="off">
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
                             <div class="row">
                                 <div class=" col-md-3">
                                     <input type="text" class=" form-control required" name="profileId" id="profileId" value="<?php echo $response[0] ?>" placeholder="Enter Profile Id">
                                 </div>
                                 <div class=" col-md-2">
                                     <input type="button" class=" btn btn-primary btn-flat" name="search" id="search" onclick=" return getProfileInfo();" value="Search Id">
                                 </div>
                                 <input type="hidden" name="selProfileID" id="selProfileID" class="required">
                                 <div class=" col-md-6">
                                     <p style=" color: red" id="profResError"></p>
                                 </div>
                             </div>
                             <br>
                             <div class="row">
                                <div class="col-md-1">
                                    <div class=" form-group">
                                        <label>Rows</label>
                                        <input type="number" class=" form-control" onkeypress=" return isNumberKey(event)" id="quantity" name="quantity" value="1" min="1" max="100">
<!--                                        <input type="hidden" class=" form-control required" name="quantity" id="quantity" value="<?php echo ($response[0]=="")?0:$response[0]; ?>" >
                               -->
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <input name="id" type="hidden" value="<?php echo $response[4]; ?>">
                                    <input type="button"  class="btn btn-flat btn-primary" style="margin-top: 24px;" name="addproser"  id="addproser" value="Add More Product / Service">
                                </div>
                                 <div class=" col-md-2">
                                     <label>Selected Profile Id</label><br>
                                     <span id="profResId" class=" form-control"></span>
                                 </div>
                                 <div class=" col-md-2">
                                     <label>Name</label><br>
                                     <span id="profResName" class=" form-control"></span>
                                 </div>
                                 <div class=" col-md-2">
                                     <label>Mobile</label><br>
                                     <span id="profResMob" class=" form-control"></span>
                                 </div>
                                 <div class=" col-md-2">
                                     <img id="profResImg" style="height: 82px;display: none;" class=" img-thumbnail" src="">
                                 </div>
                             </div>
                             <div class="row" id="rows">
                                 
                             </div>
                             <div class="row">
                                 <div class=" col-md-2">
                                     <input type="submit" class=" btn btn-success btn-flat" name="addproduct" value="Save Details" onclick=" return checkrequired(this.form)">
                                 </div>
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
     var quant = document.getElementById("quantity");
     var rows = Number(quant.value);
     createRows(rows);
     getProfileInfo();
     $(document).on("focus","#profileId",function(){
        $(this).css("border-bottom","1px solid #ccc") 
     });
  });
 
 $("#addproser").on("click",function(){
     var quant = document.getElementById("quantity");
     var rows = Number(quant.value);
     createRows(rows);
 })
 
 function createRows(rows,jobj){
     var $elem = $("#rows");
     if(!isNaN(rows)){
        var html = '';
        var init = ($elem.find(".products").length) || 0;
        var selp = "";var sels = "";var olddata = '';
        var rmv='<div class=" col-md-12"><button type="button"  onclick=" return removebusiness(this)" class="  btn-danger">Remove</button></div>';
        for(var i=init; i < rows; i++ ){ 
            var type="";var name="";var descrp="";var imgs = '';
            if(jobj!=null && i < Object.keys(jobj.res.bus).length){
                type = (jobj.res.bus[i].type!="")?jobj.res.bus[i].type:"";
                rmv = '<div class=" col-md-12"><button type="button"  onclick=" return removebusiness(this,'+jobj.res.bus[i].id+')" class="  btn-danger">Remove</button></div>';
                imgs = '<div class=" col-md-12">'
                selp = (type=='Product')?"selected":"";
                sels = (type=='Service')?"selected":"";
                olddata += '<input id="immg'+jobj.res.bus[i].id+'" type="hidden" name="olddata['+i+']" value="'+jobj.res.bus[i].id+'" >';
                name = (jobj.res.bus[i].name!="")?jobj.res.bus[i].name:"";
                descrp = (jobj.res.bus[i].descrp!="")?jobj.res.bus[i].descrp:"";
                var im = (jobj.res.bus[i].imgurls).split("||");
                for(var j=0 in im){
                    if(im[j]!=""){
                        imgs += '<div class="col-md-1 immg'+jobj.res.bus[i].id+'"><img class="img-thumbnail" alt="'+jobj.res.bus[i].id+'" src="'+im[j]+'" style=" height: 50px;" ><br><span style="cursor: pointer;" onclick=" return removeImg(this);"><i style="color:red;" class="fa fa-trash"></i></span></div>'; 
                    }
                    j++;
                  
                }
                imgs += '</div>'; 
            }
            
            html +='<div class="col-md-12 products">'+rmv+'<div class="col-md-3">'+
                    '<label>Select Type</label>'+
                    '<select name="businessType[]" class=" form-control required">'+
                        '<option value="">Select Type</option>'+
                        '<option '+selp+'>Product</option>'+
                        '<option '+sels+'>Service</option>'+
                    '</select>'+
                '</div>'+
                '<div class=" col-md-3">'+
                    '<label>Product / Service Name</label>'+
                    '<input type="text" name="product['+i+']" value="'+name+'" class=" form-control required" placeholder=" Product / Service Name">'+
                '</div> '+ 
                '<div class=" col-md-3">'+
                    '<label>Product / Service Description</label>'+
                    '<textarea  class=" form-control" name="productDesc['+i+']" rows="3" placeholder=" Product / Service Description">'+descrp+'</textarea>'+
                '</div>'+
                '<div class=" col-md-3">'+
                    '<label>Images (If Any)</label>'+
                    '<input type="file" name="productImg['+i+'][]" onchange="preview_image(this,\'previewImg'+i+'\','+i+')" class=" form-control " multiple>\n\
                <p style="color: green">Please select jpg / jpeg images only</p>'+
                '</div>'+imgs+' '+olddata+'<div class="col-md-12" id="previewImg'+i+'"></div></div>'  
        }
        if(init > rows){
            var row = $elem.find(".products");
            var del = rows;
            for(var del; del < init; del++){
                row[del].remove();
            }
        }
        $elem.append(html);
        
     }else{
         alert("Please enter valid number.");
     }
   return false;  
 }
 
 function preview_image(xx,id,rownum) 
 {
 $('#'+id).empty();
 var total_file=xx.files.length;var msg ="";
 for(var i=0;i<total_file;i++)
 {

   if(event.target.files[i].type=="image/jpeg" || event.target.files[i].type=="image/jpg")
   $('#'+id).append("<div class='col-md-1 immg'><input type='hidden' name='newImgs["+rownum+"][]' value='"+event.target.files[i].name+"'><img style='height: 50px'  class='img-thumbnail' src='"+URL.createObjectURL(event.target.files[i])+"'><br><span style='cursor: pointer;' onclick=' return removeImg(this);'><i style='color:red;' class='fa fa-trash'></i></span></div>");
   else{
        msg = "Only jpg / jpeg images can be uploaed."
   }
   
 }
 if(msg!=""){
     alert(msg);
 }
 }
 
 function getProfileInfo(){
      var id = $("#profileId").val();
      if(id!=""){
        $.ajax({
         url:"<?php echo ADMIN_URL ?>getProfileInfo",
         type:"post",
         data:{profileId:id,resptyp:'json'},
         success:function(res){
             var jobj = JSON.parse(res);
             //console.log(jobj);
             if(jobj.res.bus!=undefined && jobj.res.bus!=null){
             var rows = (Number(Object.keys(jobj.res.bus).length) < 1 )?0:Number(Object.keys(jobj.res.bus).length);
             if(rows > 0){
                $("#quantity").val(rows);
                $("#rows").empty();
                createRows(rows,jobj)
             }
             }
             if(!jobj.res.error){
                 $("#profResId").text(jobj.res.info[0].LoginID);
                 $("#profResName").text(jobj.res.info[0].name);
                 $("#profResMob").text(jobj.res.info[0].mobile);
                 var phtsrc = jobj.res.info[0].photo || jobj.res.info[0].photo1 || jobj.res.info[0].photo2;
                 $("#profResImg").attr("src",phtsrc);
                 $("#profResImg").show();
                 $("#selProfileID").val(jobj.res.info[0].LoginID);
                 $("#profResError").text("");
             }else{
                 $("#profResError").text(jobj.res.error);
                 $("#profResId").text("");
                 $("#profResName").text("");
                 $("#profResMob").text("");
                 $("#profResImg").attr("src","");
                 $("#profResImg").hide();
                 $("#selProfileID").val("");
             }
         }
      });
      }else{
        $("#profileId").css("border-bottom","1px solid red")
      }
      return false;
 }
 
 function removeImg(ele){
  if(confirm("Are you sure to remove?")){
    var el = ele.parentElement;
    var str = $(el).find("img").attr("src");
    var id = $(el).find("img").attr("alt");
    $.ajax({
         url:"<?php echo ADMIN_URL ?>deleteBusinessImg",
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
 function removebusiness(ele,id){
  if(confirm("Are you sure to remove?")){
    var el = (ele.parentElement).parentElement;
    if(id!=undefined)
    $.ajax({
         url:"<?php echo ADMIN_URL ?>removebusiness",
         type:"post",
         data:{id:id},
         success:function(res){
             if(res)el.remove();   
         }
      });
      
    el.remove();
    
  }
   return false; 
 }
</script>
</body>

</html>

