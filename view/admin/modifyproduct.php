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
<section class="content" style=" height: auto; min-height: 190px">     
    <form name="form1" id="page-form" method="post" action="<?php echo ADMIN_URL."modifyproduct" ?>" autocomplete="off" onsubmit="return checkForm(this);" enctype="multipart/form-data">
  <div class="box">
            <div class="box-header">
              <h4 class="box-title">Edit/Delete Product </h4>
            </div>
            <div class="box-body">  
                <?php $post = $response[2]; ?>
              <div class="col-md-3">   
                <div class="form-group">
                <label for="title">Product Category</label>
                <?php
                echo $this->getCatOptions("productcat","productcat","form-control required","--Select Category--",$post['productcat'],'str',"",true);
                ?>
                </div>
              </div>
              <div class="col-md-3">   
                <div class="form-group">
                <label for="title">Type</label>
                <select class=" form-control" name="type">
                    <option <?= ($post['type']=='All')?"selected":"" ?>>All</option>
                    <option <?= ($post['type']=='Best Seller')?"selected":"" ?>>Best Seller</option>
                    <option <?= ($post['type']=='Featured Product')?"selected":"" ?>>Featured Product</option>
                    <option <?= ($post['type']=='Latest Product')?"selected":"" ?>>Latest Product</option>
                    <option <?= ($post['type']=='Top Seller')?"selected":"" ?>>Top Seller</option>
                </select>
                </div>
              </div>
              <div class="col-md-4">   
                <div class="form-group">
                <label for="title">Search Keyword</label>
                 <input type="text" name="keyword" class="form-control " id="keyword" placeholder="Enter Keyword E.g: Brand Name, Product Name" value="<?php echo $post['keyword'] ?>"/>
                </div>
              </div>
            <div class="col-md-1"> 
             <div class="form-group">
                 <label>&nbsp;</label><br/>
                <input type="hidden" name="uid" value="<?php  ?>">
                <button type="submit" id="submit" name="submit"  class="btn btn-primary btn-flat" ><i class="fa fa-search"></i> Search</button>
                
               </div> 
            </div>
    </div>
  </div>
</form>
     </section>
  

  <section class="content">
      <!-- Small boxes (Stat box) -->
       
      <div class="row">
        <div class="col-xs-12">
              <div class="box">
            <div class="box-header">
              <h4 class="box-title">All Products List</h4>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th width="10%">Sno</th>
                  <th>Product Name</th>
                  <th>Category</th>
                  <th>Brand</th>
                  <th>Price / Offer</th>
                  <th>Unit</th>
                  <th>Keywords</th>
                  <th>Product As</th>
                  <th>Added</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                  <?php
                  if(!empty($response[1])){
                      $limit = $response[4];
                      $cpage = $response[5];
                      $cnt = (($cpage * $limit) - $limit)+1;
                      while ($data = $this->db_read($response[1])) {
                      
                      $price = "<b>Strike Price: </b>".$data['strikeprice']."<br>";    
                      $price .= "<b>Offer: </b>".$data['offer']."<br>";    
                      $price .= "<b>Price: </b>".$data['price']."<br>";    
                      $added = "<b>By: </b>".$data['DisplayName']."<br>";  
                      $added .= "<b>On: </b>".$this->formatdate($data['entrytime'],"d-M-Y H:i A")."<br>";  
                      $action = '<a target="_blank" class="btn" href="'.ADMIN_URL.'editproduct/'.$data['id'].'"><i class="fa fa-edit"></i></a>';
                      $action .= '<a class="btn" href="#" onclick=" return deleteproduct('.$data['id'].',\'#row'.$data['id'].'\')"><i style=" color: red" class="fa fa-trash"></i></a>';
                   ?>
                 <tr id="row<?= $data['id'] ?>">
                     <td><?= $cnt ?></td>
                     <td><?= $data['productname'] ?></td>
                     <td><?= $data['cat'] ?></td>
                     <td><?= $data['brand'] ?></td>
                     <td><?= $price ?></td>
                     <td><?= $data['price']." ".$data['unit'] ?></td>
                     <td><?= $data['productkey'] ?></td>
                     <td><?= $data['productas'] ?></td>
                     <td><?= $added ?></td>
                     <td><?= $action ?></td>
                </tr>      
                    <?php $cnt++; }
                  }
                  ?> 
           
                </tbody>

              </table>
                <?php 
                    echo $response[3] ?>
                 </div>
            </div>
            <!-- /.box-body -->
          </div>
             </div>
        <!-- /.col -->
      
      <!-- /.row -->
    
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
    $('.table').DataTable({
        'paging'      : false,
        'lengthChange': true,
        'searching'   : false,
        'ordering'    : true,
        'info'        : false,
        'autoWidth'   : true      
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
  
   function preview_image(xx,id,rownum) 
 {
 $('#'+id).empty();
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
 
function deleteproduct(ele,rowid){
  if(confirm("Are you sure to remove?")){
    $.ajax({
         url:"<?php echo ADMIN_URL ?>deleteproduct",
         type:"post",
         data:{id:ele},
         success:function(res){
             if(res)$(rowid).remove();
             else
             alert("Request record is missing");
             
         }
      });
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

