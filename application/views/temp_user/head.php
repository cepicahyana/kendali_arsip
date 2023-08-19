<!DOCTYPE html>
<html lang="en">
<head>
    <title>PANDU</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="" />
    <meta name="keywords" content="">
    <meta name="author" content="Phoenixcoded" />
   
   <link rel="icon" href="<?php echo base_url()?>plug/img/logom.png" type="image/x-icon">
   
   	<script src="<?php echo base_url()?>assets/js/vendor-all.min.js"></script> 
  
	<script src="<?php echo base_url()?>plug/jquery/jquery.min.js"></script>
	<script src="<?php echo base_url()?>plug/jqueryform/jquery.form.js"></script>
	<script src="<?php echo base_url()?>plug/blokui.js"></script>
	<script src="<?php echo base_url()?>plug/js/angular.js"></script>
 	<script src="<?php echo base_url()?>plug/js/proses.js"></script>
 		
    <!-- vendor css -->
	  <link rel="stylesheet" href="<?php echo base_url()?>assets/css/plugins/select2.min.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/style.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>plug/dist/bootstrap-clockpicker.min.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/plugins/fullcalendar.min.css">
    <!-- vendor css -->
		<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>plug/css/bootstrap-select.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>plug/css/add.css"/>
     <link rel="stylesheet" href="<?php echo base_url()?>assets/css/plugins/lightbox.min.css">
 
  <!---<link href="<?php echo base_url()?>plug/alertify/css/alertify.css" rel="stylesheet"> --->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>plug/datatables/css.css"/>
<script type="text/javascript" src="<?php echo base_url()?>plug/datatables/font.js"></script> 
<script type="text/javascript" src="<?php echo base_url()?>plug/datatables/datatable.js"></script>

	<?php
	$temp=$this->uri->segment(1);
	if(strpos($temp,"template")===FALSE){?>
 	 <script src="<?php echo base_url()?>plug/ckeditor/ckeditor.js"></script> 
	<?php }else{ ?>
	<script src="<?php echo base_url()?>assets/ckeditor/ckeditor.js"></script>
	<script src="<?php echo base_url()?>assets/ckeditor/js/sample.js"></script>
	<?php } ?>
     <link href="<?php echo base_url()?>plug/date/daterangepicker.css" rel="stylesheet">
	<script type="text/javascript" src="<?php echo base_url()?>plug/date/date_moment.js"></script>
	<script type="text/javascript" src="<?php echo base_url()?>plug/date/date_range.js"></script>
	 <script src="<?php echo base_url()?>plug/js/highcart.js"></script>
	 <script src="<?php echo base_url()?>plug/js/highcart-3d.js"></script>
 <script>
        function cantik()
  {
    return '<center><div class="card-body" id="loadingKontak"> Mohon tunggu....<br><div class="spinner-grow text-primary" role="status"><span class="sr-only">Loading...</span></div><div class="spinner-grow text-secondary" role="status"><span class="sr-only">Loading...</span></div><div class="spinner-grow text-success" role="status"><span class="sr-only">Loading...</span></div><div class="spinner-grow text-danger" role="status"><span class="sr-only">Loading...</span></div><div class="spinner-grow text-warning" role="status"><span class="sr-only">Loading...</span></div><div class="spinner-grow text-info" role="status"><span class="sr-only">Loading...</span></div><div class="spinner-grow text-light" role="status"><span class="sr-only">Loading...</span></div><div class="spinner-grow text-dark" role="status"><span class="sr-only">Loading...</span></div></div></center>';
  }
 </script>
</head>