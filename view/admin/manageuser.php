<?php include_once __DIR__.'/../layout/header.php'; ?>
  <!-- Left side column. contains the logo and sidebar -->
<?php include_once __DIR__.'/../layout/menu.php'; ?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   <section class="content-header">
    <h1>
        Manage Users
    </h1>
    <ol class="breadcrumb">
        <li><i class="fa fa-dashboard"></i> Manage Admin Users</a></li>
        <li class="active">Manage Users</li>
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
         if($response[0]=="edit"){$action="updateuser";$btn="Update User";}else{$action="adduser";$btn="Add User";}
        ?>    
 <form name="form1" id="page-form" method="post" action="<?php echo ADMIN_URL.$action ?>" autocomplete="off" onsubmit="return checkForm(this);">
  <div class="box">
            <div class="box-header">
              <h4 class="box-title">Add/Manage User </h4>
            </div>
            <div class="box-body">  
                <?php
                    //print_r($response);
                ?>
              <div class="col-md-6">   
                <div class="form-group">
                <label for="title">Display Name</label>
                <input type="text" name="displayn" class="form-control required" placeholder="Enter the name of user" id="displayn" value="<?php echo $response[1]['DisplayName'] ?>" required/>
                </div>
              </div>
              <div class="col-md-6">   
                <div class="form-group">
                <label for="title">Login Id/ User Id</label>
                 <input type="text" name="userid" class="form-control required" id="userid" placeholder="Enter the user id (This id will be used as login id)" value="<?php echo $response[1]['LoginID'] ?>" required/>
                </div>
              </div>
             <div class="col-md-6">    
                <div class="form-group">
                   <label for="title">Password</label>
                   <input type="text" name="password" class="form-control required" placeholder="Enter login password" id="password" value="<?php echo $response[1]['LoginPS'] ?>" required/>
                </div>
             </div>
             <div class="col-md-6">    
                <div class="form-group">
                   <label for="title">Mobile No (Optional)</label>
                   <input type="text" maxlength="10" onkeypress=" return isNumberKey(event);" placeholder="Enter mobile number" name="mobile" class="form-control required" id="mobile" value="<?php echo $response[1]['mobileno'] ?>" />
                </div>
             </div>
            <div class="col-md-6"> 
             <div class="form-group">
                <input type="hidden" name="uid" value="<?php echo $response[1]['ID'] ?>">
                <input type="submit" id="submit" name="submit"  class="btn btn-primary btn-flat" value="<?php echo $btn ?>">
                
               </div> 
            </div> 
                <?php
                if(($response[0]=="edit")){ ?>
                <div class="col-md-3">
                <a href="<?php echo ADMIN_URL ?>manageuser" class="btn btn-default btn-flat" >Add New</a>
                </div>
                <?php } ?>
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
              <h4 class="box-title">All Users List</h4>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th width="10%">Sno</th>
                  <th>Display Name</th>
                  <th>Login Detail</th>
                  <th>Mobile</th>
                  <th>Entry Detail</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>

           
                </tbody>

              </table>
                <?php 
                    $limit = 30;
                    $cpage = (isset($_GET['page']))?$_GET['page']:1;
                    echo $this->pagination("Login WHERE role=1 and type='User '",$limit,$cpage); ?>
                 </div>
            </div>
            <!-- /.box-body -->
          </div>
             </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    
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
            url : "<?php echo ADMIN_URL ?>getUserRecord/"+limit+"/"+cpage,
            type:"post"
            
        }        
    });
});

function deleteUser(x){
      if(confirm("Are you sure to delete?")){
        var url = "<?php echo ADMIN_URL ?>deleteUser/"+x;
        $.ajax({
            url: url,
            success: function(res){
                if(res=="1"){
                    $("#row_"+x).remove();
                }else if(res=="2"){
                    alertify.sujeet("Required data missing.</p>");
                }else{
                    alertify.sujeet("<p <?php echo MSG_ERR ?>>Can't Delete This User. Related Data found!.</p>");
                }
            }
        })
      }
  }
</script>
</body>

</html>

