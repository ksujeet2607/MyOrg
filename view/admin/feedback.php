<?php include_once __DIR__.'/../layout/header.php'; ?>
  <!-- Left side column. contains the logo and sidebar -->
<?php include_once __DIR__.'/../layout/menu.php'; ?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Feedback / Enquiry 
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Reports</a></li>
        <li class="active">Feedback / Enquiry</li>
      </ol>
    </section>
    <style>
        .form-group label{
          color: #00000094!important;  
        }
        </style>
    <!-- Main content -->
     <?php 
         if($response[0]=="list"){$action="modifynews";$btn="Edit News";}
         else{$action="modifynews";$btn="Edit News";}
         ?>
    <section class="content container-fluid" onload="updateSize();">
        <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <h4>Feedback / Enquiry</h4>
                        </div>
                        <div class="box-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Sn.</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>Message</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if(!empty($response[1])){
                                        $cnt = ($response[3]==1)?1:(($response[3]-1)*$response[4]) + 1;
                                        while ($row = $this->db_read($response[1])) {
                                            $ids .= $row['id'].",";
                                            $action = '<button onclick=" return deleteFeedback('.$row['id'].')"><i class="fa fa-trash" style=" color:red;"></i></button>';
                                        ?>
                                    
                                        <tr id="row_<?= $row['id'] ?>">
                                          <td><?= $cnt; ?></td>
                                          <td><?= $row['name']; ?></td>
                                          <td><?= $row['email']; ?></td>
                                          <td><?= $row['mobile']; ?></td>
                                          <td><?= $row['message']; ?></td>
                                          <td><?= $this->formatdate($row['entrydate'],"d-M-Y H:i A"); ?></td>
                                          <td><?= $action ?></td>
                                        </tr>
                                       <?php $cnt++; }
                                        $ids = rtrim($ids, ",");
                                        }
                                    ?>
                                </tbody>
                            </table>
                            <?php 
                            echo $response[2];
                            ?>
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
  $(function () {

    $('.table').DataTable({
        'paging'      : false,
        'lengthChange': true,
        'searching'   : true,
        'ordering'    : true,
        'info'        : false,
        'autoWidth'   : false
    });
    $.ajax({
        url:"<?= ADMIN_URL ?>updateFeedBacSts",
        type:"post",
        data:{ids:"<?= $ids; ?>"},
        success:function(res){
            if(res=="1");
        }
        
    })
  })
  function deleteFeedback(x){
      if(confirm("Are you sure to delete?")){
        var url = "<?php echo ADMIN_URL ?>deleteFeedback/"+x;
        $.ajax({
            url: url,
            success: function(res){
                if(res=="1"){
                    $("#row_"+x).remove();
                }else{
                    alert("Required data missing.");
                }
            }
        })
      }
  }
  

</script>
</body>

</html>

