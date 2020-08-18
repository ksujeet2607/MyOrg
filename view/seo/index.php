
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo SITE_NAME ?> | Admin Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo SRC_URL?>css/bootstrap.admin.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo SRC_URL?>css/font-awesome.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo SRC_URL?>css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo SRC_URL?>css/AdminLTE.min.css">
  <link href='<?php echo SRC_URL?>css/alertify.min.css' rel='stylesheet' type='text/css'>	
  <link href='<?php echo SRC_URL?>css/error.css' rel='stylesheet' type='text/css'>

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="#"><b><?php echo SITE_NAME ?></b></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>
    <div class="content-header no-padding" style="margin-bottom: 10px;"></div>
    <form action="<?php echo BASE_URL ?>login/seologin/" method="post">
      
      <div class="form-group has-feedback">
          <input type="text" name="userid" maxlength="15" minlength="3"  class="form-control" placeholder="Login Id" required>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="password" maxlength="15" minlength="4" class="form-control" placeholder="Password" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="<?php echo SRC_URL?>js/jquery.min.js"></script>
<script language="JavaScript" src="<?php echo SRC_URL?>js/alertify.min.js"></script>
<script language="JavaScript" src="<?php echo SRC_URL?>js/basic.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo SRC_URL?>js/bootstrap.min.js"></script>
<?php echo  session::GetMessage(); ?>
</body>
</html>
