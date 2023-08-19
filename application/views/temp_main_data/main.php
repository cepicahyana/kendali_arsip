
<!DOCTYPE html>
<html lang="en">
	<?php echo $this->load->view("temp_main_data/head");?>
	<body class="main-body  app">

		<!-- Loader -->
		<div id="global-loader">
			<img src="<?php echo base_url()?>assets/img/loaders/loader-4.svg" class="loader-img" alt="Loader">
		</div>
		<!-- /Loader -->

		
		<!-- Page -->
		<div class="page">

		   <!-- main-header opened -->
		<?php echo $this->load->view("temp_main_data/header");?>
		  <!-- main-header closed -->

			<!--Horizontal-main -->
            
            <?php echo $this->load->view("temp_main_data/menu");?>
			<!--Horizontal-main -->
	

			<!-- main-content opened -->
			<?php echo $this->load->view("temp_main_data/content");?>
				<!-- /container -->
			</div>
			<!-- /main-content -->

			<!--Sidebar-right-->
		 
			<!--/Sidebar-right-->

			<!-- Footer opened -->
			<!-- <div class="main-footer ht-40">
				<div class="container-fluid pd-t-0-f ht-100p">
					<span>Copyright © 2020 <a href="#">Azira</a>. Designed by <a href="https://www.spruko.com/">Spruko</a> All rights reserved.</span>
				</div>
			</div> -->
			<!-- Footer closed -->
		</div>
		<!-- end page -->

		<!--- Back-to-top --->
		<a href="#top" id="back-to-top"><i class="las la-angle-double-up"></i></a>

        <?php
        $this->load->view("temp_main_data/footer");
        ?>
	

	</body>
</html>