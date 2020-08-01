<div id="myModalImg" class="modal1">

  <!-- The Close Button -->
  <span class="close1">&times;</span>

  <!-- Modal Content (The Image) -->
  <img class="modal-content1" id="imgs01">

  <!-- Modal Caption (Image Text) -->
  <div id="caption1"></div>
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
function checkBranch(xx){
    var boxText = $(xx)[0].selectedOptions[0].text;
    if(boxText != ""){
    $.ajax({
       url : "<?php echo ADMIN_URL ?>checkBranch/"+boxText,
       success: function(res){
           if(res!=="valid" && boxText!="All"){
               $("#"+$(xx).attr("id")+"err").text("please select valid branch");
               $(xx)[0].selectedIndex = 0;
               $(xx)[0].value = "";
               $(xx)[0].options[0].selected = true;
           }else{
               $("#"+$(xx).attr("id")+"err").text("");
           }
       }
    });
    }
}
function checkfield(form){
   var branch = $(form).find('.branch');
   var directsearch = $(form).find('.directsearch');
   if(directsearch.length > 0){
       if($(directsearch).val()!=""){
           return true;
       }
   }
    var bid = branch[2].selectedOptions[0].value;
    if(bid=="" && Number.isInteger(Number(bid))){
        $("#"+branch[2].name+"err").text('please select branch');
    }else{
        $("#"+branch[2].name+"err").text('');
        return true;
    }
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
    <strong>Copyright &copy; <?php echo date("Y"); ?> <a href="#">bit7informatics</a>.</strong> All rights reserved.
  </footer>