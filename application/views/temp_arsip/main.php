<?=$this->load->view("temp_arsip/head");?>
	<body class="main-body app sidebar-mini ltr">

    <!-- Switcher -->
 
	<!-- End Switcher -->

		<!-- Loader -->
		<div id="global-loader">
			<img src="<?=base_url();?>assets_arsip/img/loaders/loader-4.svg" class="loader-img" alt="Loader">
		</div>
		<!-- /Loader -->

		<!-- page -->
	   <div class="page custom-index">
 
			<?=$this->load->view("temp_arsip/main_header");?>
			<?=$this->load->view("temp_arsip/main_sidebar");?>

		<!-- main-content -->
		<div class="main-content app-contentz">

			<!-- container -->
			<div class="main-container container-fluid"  >
			<input type="hidden" name="token_footer" id="token_footer" value="">
			 	<!-- row -->
				<div class="row">
                <?=$this->load->view("temp_arsip/konten");?>
				</div>
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->

		
        <?=$this->load->view("temp_arsip/sidebar_right");?>
        <?=$this->load->view("temp_arsip/footer");?>