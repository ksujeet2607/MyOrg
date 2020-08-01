<?php include_once __DIR__.'/../layout/header.php'; ?>
  <!-- Left side column. contains the logo and sidebar -->
<?php include_once __DIR__.'/../layout/menu.php'; ?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <style>
/*        .form-control{
            background: #805d2f0f!important;
             border-radius: 4px!important;
        }
        .form-group label{
          color: #00000094!important;  
        }*/
        .red{
            color: red;
        }
        </style>
    <!-- Main content -->
        <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Manage Password
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
        <li class="active">Manage Password</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

             <style>
            .input-group-f{
                width: 100%;
            }
        </style>       
                    <div class="box">
                        <div class="box-header">
                            <h4>Change Password</h4>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="<?php echo $fa ?>"></i></button>
                            </div>
                        </div>
                        <div class="box-body">
                            <form id="form-changepassword" method="post" action="<?php echo ADMIN_URL ?>updatepassword"> 
                                <div class="col-lg-8 col-md-6 col-sm-6">
                    <!--                    <h3 class="box-title">Add Country</h3>-->
                    <p class="red">In special chars only @ and _ is allowed</p>
                    <label>Old Password:</label>
                        <div class="input-group input-group-f">  
                            <input type="password" name="txtoldpass" id="txtoldpass" onkeypress="return validemail(event)" maxlength="15" minlength="4" class="required form-control pass"/>
                            <span id="errtxtoldpass"></span>  
                        </div>
                    <label>New Password:</label>
                        <div class="input-group input-group-f">  
                            <input type="password" name="txtpass" id="txtpass" onkeypress="return validemail(event)" maxlength="15"  minlength="4" class="form-control required password pass space"/>   
                            <span id="errtxtpass"></span>  
                        </div>
                    <label>Confirm New Password:</label>
                        <div class="input-group input-group-f">  
                            <input type="password" name="txtcpass" onkeypress="return validemail(event)" id="txtcpass" maxlength="15" minlength="4"  class="form-control required password pass space"/>
                            <span id="errtxtcpass"></span>    
                        </div>
                    <span class="input-group-btn" >
                        <button type="submit" style="margin-top: 10px;" onclick="checkall(event);"  name="btnsubmit" id="btnsubmit"  class=" btn btn-flat btn-primary">
                            Save
                          </button>
                          <button type="reset" style="margin-left: 20px;margin-top: 10px;"   class=" btn btn-flat btn-default">
                            Reset
                          </button>
                    </span>
                    <p class="red" id="commonerr"></p>       
                      
                </div>
                            </form>
                        </div>
                    </div>
<!--Strart Coding Form Here-->


    </section>
    <!-- /.content -->
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php include_once __DIR__.'/../layout/footer.php'; ?>
<?php echo session::GetMessage(); ?>
</div>
  <script>
     function checkall(e){
          var count = 0;
          var fnd = $("#form-changepassword .required");
             $.each(fnd,function(){
                 var fnv = $(this).val();
                 if(fnv == ""){
                     $(this).css("border-bottom","1px solid red");
                     count++;
                     $("#commonerr").text("Please full all fields");
                 }
                     
             });
              if(count == 0){
                  if($("#txtpass").val() !== $("#txtcpass").val()){
                      $("#commonerr").text("Password Miss match. Please confirm password.");
                      count++;
                      $("#txtpass,#txtcpass").val("");
                      $("#txtpass").focusin();
                  }
              }
              //alert(count);
              if(count == 0){
               $("#form-changepassword").submit();
              }
              e.preventDefault();

      }
      $(document).ready(function(){
         $(".required").on("focus, click",function(){
             $("#commonerr").text("");
         });
      });
  </script>
</body>

</html>