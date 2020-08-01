 <?php $submenu = admin::$menu;
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
                case "editCity":
                    $Master = " active menu-open";$Masterul = "display:block";
                    break;
                case "mngBranch":
                    $Master = " active menu-open";$Masterul = "display:block";
                    break;
                case "cNote":
                    $Master = " active menu-open";$Masterul = "display:block";
                    break;
                case "CNoteAllot":
                    $Master = " active menu-open";$Masterul = "display:block";
                    break;
                case "regChildren":
                    $report = " active menu-open";$reportul = "display:block";
                    break;
                case "bookings":
                    $report = " active menu-open";$reportul = "display:block";
                    break;

               default:
                break;
              }
            
            ?>
<nav class="navbar navbar-static-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <a href="<?php echo ADMIN_URL ?>adminhome" class="navbar-brand"><b>Jain</b>Community</a>
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
            <i class="fa fa-bars"></i>
          </button>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="<?php echo ADMIN_URL ?>adminhome">Home <span class="sr-only">Home</span></a></li>
            <?php 
            $rs = $this->db_executeReader("accessibility_links_admin","linkname,title,id,"
                    . "`show`,ad,`edit`,del","", "sectionid=0"," order by id",false);
            while($row = $this->db_read($rs)){
            ?>
                <?php if($this->isauthaction($row['linkname'],"show","section")){ ?>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $this->ucf($row['title']) ?> <span class="caret"></span></a>
                  <ul class="dropdown-menu" role="menu">
                   <?php    $rs1 = $this->db_executeReader("accessibility_links_admin","linkname,title,`show`,ad,`edit`,del","", "sectionid=".$row['id']," order by id",false);
                      while($subm = $this->db_read($rs1)){ ?>
                        <?php if($this->isauthaction($subm['linkname'],"show","subsection")){ ?>
                        <li><a href="<?php echo ADMIN_URL.$subm['linkname'] ?>"><?php echo $this->ucf($subm['title']) ?></a></li>
                        <?php } ?>
                      <?php } ?>
                  </ul>
                </li>
              <?php  } ?>
          <?php  } ?>
<!--                <li><a target="_blank" href="<?php echo ADMIN_URL."Network" ?>" >Network</a></li>-->
          </ul>
<!--          <form class="navbar-form navbar-left" action="<?php echo  ADMIN_URL ?>trackCnote" target="_blank" method="post" role="search">
            <div class="input-group" style="margin-left: 5px;">
                <input type="text" name="awbno" onkeypress="return isNumberKey(event);" class="form-control" placeholder="Consignment Tracking..." required="true">
              <span class="input-group-btn">
                    <button type="submit" name="search"  style="background: #ccc;" id="search-btn" class="btn btn-flat">
                      <i class="fa fa-search"></i>
                    </button>
                  </span>
            </div>
          </form>-->
            <?php // if(strtolower(admin::$menu) == "adminhome"){ ?>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account Menu -->
          <li class="dropdown user user-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!-- The user image in the navbar-->
              <img src="<?php echo SRC_URL ?>img/avatar.png" class="user-image" alt="User Image">
              <!-- hidden-xs hides the username on small devices so only the image appears. -->
              <span class="hidden-xs"><?php echo ucwords(str_replace("_"," ",auth::Get_userType())); ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- The user image in the menu -->
              <li class="user-header">
                <img src="<?php echo SRC_URL ?>img/avatar.png" class="img-circle" alt="User Image">

                <p>
                  <?php echo ucwords(str_replace("_"," ",auth::Get_userType())); ?>
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
                    <a class="btn btn-default btn-flat" href="<?php echo ADMIN_URL.'logout' ?>">Logout</a>
                  </div>
                </div>
                <!-- /.row -->
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
<!--          <li>
            <a href="<?php echo ADMIN_URL.'logout' ?>" ><i class="fa fa-sign-out"></i></a>
          </li>-->
        </ul>
      </div>
      <?php // } ?>
        </div>
        
        <!-- /.navbar-collapse -->
      </div>
      <!-- /.container-fluid -->
    </nav>