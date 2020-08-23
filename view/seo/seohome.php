
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
        <div class="box">
            <div class="box-body">
                <form id="seoform" action="<?= BASE_URL."seo/addseocontent" ?>" method="post">
                    <div class="row">
                        <div class=" col-md-6">
                            <div class=" form-group">
                                <label>Select Page</label>
                                <?php
                                $sel = ($edit['pagename']!="")?$edit['pagename']:"0";
                                echo $response['pagename'];
                                ?>
                            </div>
                        </div>
                        <div class=" col-md-6">
                            <div class=" form-group">
                                <label>Page Title</label>
                                <input class=" form-control title"  onblur="setOutput(this)" oninput=" setOutput(this)" name=" title" >
                            </div>
                        </div>
                        <div class=" col-md-6">
                            <div class=" form-group">
                                <label>Description</label>
                                <textarea class=" form-control description" onblur="setOutput(this)" oninput=" setOutput(this)" name=" desc" ></textarea>
                            </div>
                        </div>
                        <div class=" col-md-6">
                            <div class=" form-group">
                                <label>Keywords</label>
                                <textarea class=" form-control keywords" onblur="setOutput(this)" oninput=" setOutput(this)" name=" keyword" ></textarea>
                            </div>
                        </div>
                    </div>
                    <div class=" row">
                        <div class=" col-md-12">
                            <textarea class=" form-control" id="title" readonly="true"></textarea>
                            <textarea class=" form-control" id="description" readonly="true"></textarea>
                            <textarea class=" form-control" id="keywords" readonly="true"></textarea>
                        </div>
                    </div>
                    <div class=" row">
                        <div class=" col-md-12">
                            <h4>Meta Tags name and content</h4>
                        </div>
                        <div class="properties">

                        </div>
                        <div class=" col-md-2">
                            <button type="submit" name="submit" class=" btn btn-primary" >Submit</button>
                        </div>
                        <div class="col-md-2" style=" float: right;">
                            <button class=" btn btn-default" onclick=" return addrow()">Add More+</button>
                        </div>
                    </div>
                    <input type="hidden" name="removeIDs" id="removeIDs">
                </form>
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
<script>

$(document).ready(function(){
    addrow();
});

function loadPageMetaData(ele){
  var modal1 = document.getElementById("loader12");
  $.ajax({
    url: "<?= BASE_URL ?>seo/loadPageMetaData",
    type: "post",
    data:{pagename: ele.value},
    beforeSend:function(res){
      modal1.style.display = "block";
    },
    success: function(res){
      var jsonObj = JSON.parse(res);
      $(".properties").find(".col-md-12").remove();
      var title = document.querySelector('.title');
      if(Object.keys(jsonObj[0]).length > 0){
        title.value = jsonObj[0][0].title;
        setOutput(title);
        var description = document.querySelector('.description');
        description.value = jsonObj[0][0].descrp;
        setOutput(description);
        var keywords = document.querySelector('.keywords');
        keywords.value = jsonObj[0][0].keyword;
        setOutput(keywords);
      }
      if(jsonObj[1]!=null){
        if(Object.keys(jsonObj[1]).length > 0){
          for(var i = 0; i < Object.keys(jsonObj[1]).length; i++){
            addrow(jsonObj[1][i].type, jsonObj[1][i].p_value, jsonObj[1][i].contect, jsonObj[1][i].id);
          }

        }
      }

    }
  }).done(function() {
    modal1.style.display = "none";
  });
}

function addrow(tagname, tagvalue, tagcontent, tagid){
  tagname = (tagname==undefined)?'':tagname;
  tagvalue = (tagvalue==undefined)?'':tagvalue;
  tagcontent = (tagcontent==undefined)?'':tagcontent;
    var $elecount = Number($(".properties").find(".col-md-12").length)+1;
      var  html='<div class=" col-md-12" id="ele'+$elecount+'">'+
                    '<div class=" row"> '+
                        '<div class=" col-md-3">'+
                            '<div class=" form-group">'+
                                '<label>Select Meta Tag Name/Property</label>'+
                                '<select class=" form-control" name="tagtype['+$elecount+']">'+
                                    '<option '+((tagname=="" || tagname=="name")?"selected":"")+'>name</option>'+
                                    '<option '+((tagname=="property")?"selected":"")+'>property</option>'+
                                    '<option '+((tagname=="http-equiv")?"selected":"")+'>http-equiv</option>'+
                                    '<option '+((tagname=="charset")?"selected":"")+'>charset</option>'+
                                '</select>'+
                            '</div>'+
                        '</div>'+
                        '<div class=" col-md-3">'+
                            '<div class=" form-group">'+
                                '<label>Tag Name/Property (E.g googlebot, robots)</label>'+
                                '<input class=" form-control" name="metaname['+$elecount+']"  value="'+tagvalue+'">'+
                            '</div>'+
                        '</div>'+
                        '<div class=" col-md-5">'+
                            '<div class=" form-group">'+
                                '<label>Meta Content</label>'+
                                '<input class=" form-control" name="metacontent['+$elecount+']" value="'+tagcontent+'">'+
                            '</div>'+
                        '</div>'+
                        '<div class=" col-md-1">'+
                            '<div class=" form-group">'+
                                '<label>&nbsp;</label><br>'+
                                '<button class=" btn" onclick="return removeids('+$elecount+','+tagid+')" ><i class="fa fa-times" style=" color: red;"></i></button>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+

                '</div>';
    $(".properties").append(html);
    return false;
}

function removeids(elecount,tagid){
  if(confirm('Are you sure?')){
    $('#ele'+elecount).remove();
    if(tagid!=undefined){
      var ids = $("#removeIDs").val();
      $("#removeIDs").val(ids+","+tagid);
    }
  }
  return false;
}

function setOutput($ele){

    if($ele.classList.contains("title")){
       document.querySelector('#title').innerHTML  = '&lt;title&gt;'+$ele.value+'&lt;/title&gt;';
    }else{
       var index = $ele.classList.length - 1;
       document.querySelector('#'+$ele.classList[index]).innerHTML = '&lt;meta name="'+$ele.classList[index]+'" content="'+$ele.value+'" /&gt;';
    }

}
</script>
