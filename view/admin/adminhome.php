<?php include_once __DIR__.'/../layout/header.php'; ?>
  <!-- Left side column. contains the logo and sidebar -->
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

        <style>
            .stst{
                background: #337ab7;
                color: #fff;
                margin: 13px 5px;
            }
        </style> 
            
        <div class=" col-md-5 stst" >
           
            <div class=" col-md-8" style=" color: #fff;">
                <h4>Un-verified News :
                </h4>
            </div>
            <div class=" col-md-4" >
                <a href="<?= ADMIN_URL ?>modifynews/0" class=" btn btn-flat btn-default" style=" color: #000;"><?php echo $response[1]; ?></a>
            </div>
                
        </div>
        <div class=" col-md-5 stst" >
           
            <div class=" col-md-8" style=" color: #fff;">
                <h4>New Enquiry/Feedback :
                </h4>
            </div>
            <div class=" col-md-4" style=" color: #fff;">
                <a href="<?= ADMIN_URL ?>feedback/0" class=" btn btn-flat btn-default" style=" color: #000;"><?php echo $response[2]; ?></a>
            </div>
                
        </div>
        <div class=" col-md-5 stst" >
           
            <div class=" col-md-8" style=" color: #fff;">
                <h4>Un-verified Members :
                </h4>
            </div>
            <div class=" col-md-4" style=" color: #fff;">
                <a href="<?= ADMIN_URL ?>searchprofile/0" class=" btn btn-flat btn-default" style=" color: #000;"><?php echo $response[3]; ?></a>
            </div>
                
        </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php include_once __DIR__.'/../layout/footer.php'; ?>
</div>

<script language="JavaScript" src="<?php echo SRC_URL ?>js/alertify.min.js"></script>
<script language="JavaScript" src="<?php echo SRC_URL ?>js/basic.js"></script>
<?php echo  session::GetMessage(); ?>
</body>
</html>