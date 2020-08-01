<?php include_once __DIR__.'/../layout/header.php'; ?>
  <!-- Left side column. contains the logo and sidebar -->
<?php include_once __DIR__.'/../layout/menu.php'; ?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         Manage Contact Detail
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Master</a></li>
        <li class="active">Manage Contact Detail</li>
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
        <form id="myform" method="post" enctype="multipart/form-data" action="<?php echo ADMIN_URL."addcontentinfo" ?>">
            <div class="row">
                <div class="col-md-12">
                    <div class="box <?php echo $col ?>">
                        <div class="box-header">
                            <h4>Update Contact Detail </h4>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool"  data-widget="collapse"><i class="<?php echo $fa ?>"></i></button>
                            </div>
                        </div>
                        <div class="box-body" <?php echo $b_body ?>>
                            <div class=" input-group">
                                <div class="col-md-5">
                                    <div class=" form-group">
                                        <label>Select Type</label><br/>
                                        <?php
                                            $sel = ($edit['type']!="")?$edit['type']:"0";
                                            echo $this->getContTypeOptions("type","type","form-control required","Select Type","$sel","str"," onchange='return loadPageContent(this);' ");
                                            ?> 
                                    </div>

                                </div>
                                <div class="col-md-5">
                                    <div class=" form-group">
                                        <label>Enter Value</label>
                                        <input type="text" id="pagetitle" maxlength="100" class="form-control required" value="" name="pagetitle">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <label>&nbsp;</label><br/>
                                    <input type="submit" onclick=" return checkrequired(this.form) "  class="btn btn-flat btn-primary" name="submit" value="Update Contact Info">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <h4>News Category List</h4>
                        </div>
                        <div class="box-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th>Number / Email / Pass</th>
                                        <th>Entry Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if(!empty($response[1])){
                                        while ($row = $this->db_read($response[1])) { ?>
                                    <tr>
                                        <td><?= $row['type'] ?></td>
                                        <td><?= $row['number'] ?></td>
                                        <td><?= $this->formatdate($row['entrydate'], "d/m/Y") ?></td>
                                        <td><button class="btn" alt="<?= $row['type'] ?>" onclick='return loadPageContent(this);'><i class="fa fa-edit" style=" color: blue;"></i></button></td>
                                    </tr>
                                    
                                  <?php }
                                    }
                                    ?>
                                </tbody>
                            </table>
                       </div>
                    </div>

                </div>
        </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php include_once __DIR__.'/../layout/footer.php'; ?>
<?php echo session::GetMessage(); ?>
</div>

<script>

function loadPageContent(ele){
    if(ele.nodeName=="BUTTON"){
       var vl = $(ele).attr('alt'); 
       $("#type").val(vl);
    }else{
       var vl = ele.value; 
    }
    $.ajax({
       url:"<?php echo ADMIN_URL ?>loadContactInfo",
       type:"post",
       data:{pagename:vl,resptyp:'json'},
       success: function(res){
         var jobj = JSON.parse(res);
         if(!jobj.res.error){
             $("#pagetitle").val(jobj.res.info.number)
         }
       }
    });
}

</script>

</body>

</html>

