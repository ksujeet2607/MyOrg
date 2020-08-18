<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo SITE_NAME ?> </title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="<?php echo SRC_URL ?>css/bootstrap.admin.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo SRC_URL ?>css/font-awesome.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo SRC_URL ?>css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo SRC_URL ?>css/AdminLTE.min.css">

  <link rel="stylesheet" href="<?php echo SRC_URL ?>css/skin-purple-light.min.css">

  <link rel="stylesheet" href="<?php echo SRC_URL ?>css/alertify.min.css">

  <link rel="stylesheet" href="<?php echo SRC_URL ?>css/bootstrap-datepicker.css">

  <link rel="stylesheet" href="<?php echo SRC_URL ?>css/combobox/kendo.common-material.min.css" />
    <link rel="stylesheet" href="<?php echo SRC_URL ?>css/combobox/kendo.material.min.css" />
    <link rel="stylesheet" href="<?php echo SRC_URL ?>css/combobox/kendo.material.mobile.min.css" />
  <script src="<?php echo SRC_URL ?>js/jquery.min.js"></script>
  <script src="<?php echo SRC_URL ?>js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo SRC_URL ?>js/adminlte.min.js"></script>
<script src="<?php echo SRC_URL ?>css/combobox/js/kendo.all.min.js"></script>
  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
<script>
$(document).ready(function(){
    $(".date").datepicker({format: 'dd/mm/yyyy'}).on("change",function(){
        $(".datepicker").hide();
    });
    var $ele = $('.date');
    $.each($ele,function(){
        if(this.value===""){
         $(this).datepicker('setDate', '<?php echo date("d/m/Y");  ?>');
        }
    })


});
// $(document).ready(function(){
//     $(".combobox").kendoComboBox({clearButton: false});
//     $(".combobox").data("kendoComboBox");
// });

$(document).on("click","input",function(){
    this.select();
});


</script>
</head>
<body class="hold-transition skin-purple-light layout-top-nav">
<div class="wrapper" style="background: #367fa9!important;">
<style>

    img:hover{
        cursor: pointer;
    }

 /* The Modal (background) */
.modal1 {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 99999; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
}

/* Modal Content (Image) */
.modal-content1 {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
}
 /* caption1 of Modal Image (Image Text) - Same Width as the Image */
#caption1 {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
  text-align: center;
  color: #ccc;
  padding: 10px 0;
  height: 150px;
}

/* Add Animation - Zoom in the Modal */
.modal-content1, #caption1 {
  animation-name: zoom;
  animation-duration: 0.6s;
}

@keyframes zoom {
  from {transform:scale(0)}
  to {transform:scale(1)}
}

/* The close1 Button */
.close1 {
  position: absolute;
  top: 15px;
  right: 35px;
  color: #f1f1f1;
  font-size: 40px;
  font-weight: bold;
  transition: 0.3s;
  z-index: 99999;
}

.close1:hover,
.close1:focus {
  color: #bbb;
  text-decoration: none;
  cursor: pointer;
}

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px){
  .modal-content1 {
    width: 100%;
  }
}

.dropdown-menu>li>a {
    color: #f3eded;
}
.dropdown-menu{
        background-color: #605ca8;
}
    .rupee {
    background-position:left;
    width: 10px;
    height: 14px;
    background-image: url('http://i.stack.imgur.com/vJZ9m.png');
    display:block;
    background-repeat: no-repeat;
}

.headName{
    text-transform: uppercase;
    font-weight: 600;
    color: #FFFFFF;
    text-align: center;
}
    #exportingmsg{
        margin-left: 100px;
    }
    .export{
        margin-bottom: 6px;
        float: right;
        margin-right: 10px;
        margin-top: -7px;
    }
.dataTables_filter label{
    float: right;
}
.datepicker {
    background: #605ca8!important;
    color: #000;
}
.datepicker .focused {
    background-color: #3c8dbc!important;
    background-image: linear-gradient(to bottom, #08c, #0044cc);
    background-repeat: repeat-x;
}
.datepicker .datepicker-switch:hover, .datepicker .prev:hover, .datepicker .next:hover, .datepicker tfoot tr th:hover{
    background-color: #0044cc!important;
    background-image: linear-gradient(to bottom, #08c, #0044cc);
    background-repeat: repeat-x;
}
          .skin-purple-light .sidebar-menu>li.active{
	margin-left: 6px;
	border-left: 2px solid;
}
.skin-purple-light .sidebar-menu .treeview-menu>li.active>a{
    margin-left: 6px;
	border-left: 2px solid;
}
.form-control.k-widget {
   width: -webkit-fill-available;
       width: 100%;
}
td.day {
    color: aliceblue;
}
.datepicker table tr td.day:hover, .datepicker table tr td.day.focused {
    color: #000!important;
}
.datepicker th{
   color: aliceblue;
}
.box-header{
    background: #FFE4E1;
    padding: 1px 0px 0px 23px;
}
.box-header h4{
    font-weight: 600;
}

.k-input{
    border: none!important;
}
.table-bordered>thead>tr>th, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>tbody>tr>td, .table-bordered>tfoot>tr>td {
    border: 1px solid #b9b6b6;
}
.table-bordered {
    border: 1px solid #8a8686;
}
.red{
    color: red;
}
      </style>
 <header class="main-header">
  <?php $this->getMenu('seo'); ?>
</header>
