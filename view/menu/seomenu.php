 <?php $submenu = Seo::$menu;
            switch ($submenu) {
                case "mngDistrict":
                    $Master = " active menu-open";$Masterul = "display:block";
                    break;
                case "mngState":
                    $Master = " active menu-open";$Masterul = "display:block";
                    break;
                case "mngCity":
                    $Master = " active menu-open";$Masterul = "display:block";
                    break;
               default:
                break;
              }

            ?>
<nav class="navbar navbar-static-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <a href="<?php echo BASE_URL ?>seo/seohome" class="navbar-brand"><b>Tech</b>nets<small>.in</small></a>
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
            <i class="fa fa-bars"></i>
          </button>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="<?php echo BASE_URL ?>seo/seohome">Home <span class="sr-only">Home</span></a></li>
          </ul>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account Menu -->
          <li class="dropdown user user-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!-- The user image in the navbar-->
              <img src="<?php echo SRC_URL ?>img/avatar.png" class="user-image" alt="User Image">
              <!-- hidden-xs hides the username on small devices so only the image appears. -->
              <span class="hidden-xs"><?php echo ucwords(str_replace("_"," ",auth::Get_displayName())); ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- The user image in the menu -->
              <li class="user-header">
                <img src="<?php echo SRC_URL ?>img/avatar.png" class="img-circle" alt="User Image">

                <p>
                  <?php echo ucwords(str_replace("_"," ",auth::Get_displayName())); ?>
                  <small><?php echo date("l,d-M-Y"); ?></small>
                </p>
              </li>
              <!-- Menu Body -->
              <li class="user-body">
                <div class="row">
                  <div class="col-xs-8 text-center">
                      <?php if(auth::IsLogin('Admin')){ ?><a class="btn btn-default btn-flat" target="_blank" href="<?php echo ADMIN_URL."changePassword" ?>">Change Password</a><?php } ?>
                  </div>

                  <div class="col-xs-4 text-center">
                    <a class="btn btn-default btn-flat" href="<?php echo BASE_URL.'login/logout/seo' ?>">Logout</a>
                  </div>
                </div>
                <!-- /.row -->
              </li>
            </ul>
          </li>
        </ul>
      </div>
        </div>

        <!-- /.navbar-collapse -->
      </div>
      <!-- /.container-fluid -->
    </nav>
