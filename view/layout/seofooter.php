<div id="myModalImg" class="modal1">

  <!-- The Close Button -->
  <span class="close1">&times;</span>

  <!-- Modal Content (The Image) -->
  <img class="modal-content1" id="imgs01">

  <!-- Modal Caption (Image Text) -->
  <div id="caption1"></div>
</div>

<div id="loader12" class="modal">
  <span class="close">&times;</span>
  <img class="modal-content" style=" text-align: center" id="">
     <div id="divLoading" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%;  z-index: 30001;">
        <p id="loderimg" style="position: absolute; color: White; top: 50%; left: 40%;">
            Sending verification mail on this mail-id, please wait...
        <img class=".loading-image" src="<?php echo BASE_URL ?>assets/img/loader.gif">
        </p>
        <p id="emailfailed" style=" position: absolute; color: red; top: 53%; left: 45%;"></p>
        <p id="emailsuc" style=" position: absolute; green: White; top: 53%; left: 45%;"></p>
    </div>

  <div id="caption"></div>
</div>

<script src="<?php echo SRC_URL ?>js/jquery.dataTables.min.js"></script>
<script src="<?php echo SRC_URL ?>js/dataTables.bootstrap.min.js"></script>
<script language="JavaScript" src="<?php echo SRC_URL ?>js/alertify.min.js"></script>
<script language="JavaScript" src="<?php echo SRC_URL ?>js/basic.js"></script>
<script language="JavaScript" src="<?php echo SRC_URL ?>js/bootstrap-datepicker.js"></script>
<script>

$(document).on("click","img",function(){

var modal = document.getElementById("myModalImg");

var modalImg = document.getElementById("imgs01");
var captionText = document.getElementById("caption1");
  modal.style.display = "block";
  modalImg.src = this.src;
  captionText.innerHTML = this.alt;

var span = document.getElementsByClassName("close1")[0];

span.onclick = function() {
  modal.style.display = "none";
}
});

function exportRecord(form){
    var trg = $(form).attr('action');
    var trgarr = trg.split('admin/');
    var target = trgarr[0]+"admin/export"+trgarr[1];
    var formdata = $(form).serialize();
    var newform = document.createElement('form');
    newform.action = target+"?"+formdata;
    newform.method = 'post';
    newform.id = 'newform';
    newform.target = '_blank';
    document.body.appendChild(newform);
    $("#newform").submit();
    return false;
}
$( ".dropdown" ).mouseover(function() {
    $( this ).addClass('show').attr('aria-expanded',"true");
    $( this ).find('.dropdown-menu').addClass('show');
  }).mouseout(function() {
    $( this ).removeClass('show').attr('aria-expanded',"false");
    $( this ).find('.dropdown-menu').removeClass('show');
 });
</script>
    <footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">

    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; <?php echo date("Y"); ?> <a href="#"><?= SITE_NAME ?></a>. All rights reserved.</strong>
  </footer>
