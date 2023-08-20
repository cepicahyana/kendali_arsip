<!doctype html>
<html lang="en" dir="ltr">
	<head>

		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="Description" content="Aplikasi kendali arsip">
		<meta name="Author" content="DMT">
		 
		<!-- Title -->
		<title> Kendali Arsip </title>
		<script src="<?=base_url();?>assets_arsip/plugins/jquery/jquery.min.js"></script>
		<!--- Favicon --->
		<link rel="icon" href="<?=base_url();?>assets_arsip/img/brand/favicon.png" type="image/x-icon"/>

		<!-- Bootstrap css -->
		<link href="<?=base_url();?>assets_arsip/plugins/bootstrap/css/bootstrap.css" rel="stylesheet" id="style"/>

		<!--- Icons css --->
		<link href="<?=base_url();?>assets_arsip/css/icons.css" rel="stylesheet">

		<!--- Style css --->
		<link href="<?=base_url();?>assets_arsip/css/style.css" rel="stylesheet">
		<link href="<?=base_url();?>assets_arsip/css/plugins.css" rel="stylesheet">

		<!--- Animations css --->
		<link href="<?=base_url();?>assets_arsip/css/animate.css" rel="stylesheet">

		<!-- Switcher css -->
		<link href="<?=base_url();?>assets_arsip/switcher/css/switcher.css" rel="stylesheet"/>
		<link rel="stylesheet" href="<?=base_url();?>assets_arsip/switcher/demo.css"/>
       

        <script src="<?php echo base_url()?>plug/jqueryform/jquery.form.js"></script>
        <script src="<?php echo base_url()?>plug/blokui.js"></script>
        <script src="<?php echo base_url()?>plug/js/angular.js"></script>
        <script src="<?php echo base_url()?>plug/js/form_action.js"></script>

		<!--- Select2 css-->
		<link href="<?php echo base_url()?>assets_arsip/plugins/select2/css/select2.min.css" rel="stylesheet">
        	<!--- Internal Sumoselect css --->
		<link rel="stylesheet" href="<?php echo base_url()?>assets_arsip/plugins/sumoselect/sumoselect.css">

        <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>plug/datatables/css.css"/>
        <script type="text/javascript" src="<?php echo base_url()?>plug/datatables/font.js"></script> 
        <script type="text/javascript" src="<?php echo base_url()?>plug/datatables/datatable.js"></script>

        <link href="<?php echo base_url()?>plug/date/daterangepicker.css" rel="stylesheet">
        <script type="text/javascript" src="<?php echo base_url()?>plug/date/date_moment.js"></script>
        <script type="text/javascript" src="<?php echo base_url()?>plug/date/date_range.js"></script>
        <script src="<?php echo base_url()?>plug/js/highcart.js"></script>
        <script src="<?php echo base_url()?>plug/js/highcart-3d.js"></script> 
		<script>
            function cantik(){
                return '<div><div class="spinner-grow text-primary" role="status"> <span class="sr-only">Loading...</span> </div> <div class="spinner-grow text-secondary" role="status"> <span class="sr-only">Loading...</span> </div> <div class="spinner-grow text-success" role="status"> <span class="sr-only">Loading...</span> </div> <div class="spinner-grow text-danger" role="status"> <span class="sr-only">Loading...</span> </div> <div class="spinner-grow text-warning" role="status"> <span class="sr-only">Loading...</span> </div> <div class="spinner-grow text-info" role="status"> <span class="sr-only">Loading...</span> </div><div class="spinner-grow text-dark" role="status"> <span class="sr-only">Loading...</span> </div>  <div class="spinner-grow text-light" role="status"> <span class="sr-only">Loading...</span> </div> </div>';
            }
            var token="";
        </script>
	</head>