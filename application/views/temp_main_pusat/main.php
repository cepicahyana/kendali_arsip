<?php
$level = $this->session->userdata('level');
$tempMain = 'temp_main_pusat';
?>
<!DOCTYPE html>
<html lang="en">
	<?php echo $this->load->view($tempMain."/head");?>
	<body class="main-body  app">

		<!-- Loader -->
		<div id="global-loader">
			<img src="<?php echo base_url()?>assets/img/loaders/loader-4.svg" class="loader-img" alt="Loader">
		</div>
		<!-- /Loader -->

		
		<!-- Page -->
		<div class="page">

		   <!-- main-header opened -->
		<?php echo $this->load->view($tempMain."/header");?>
		  <!-- main-header closed -->

			<!--Horizontal-main -->
            
            <?php echo $this->load->view($tempMain."/menu");?>
			<!--Horizontal-main -->
	

			<!-- main-content opened -->
			<?php echo $this->load->view($tempMain."/content");?>
				<!-- /container -->
			</div>
			<!-- /main-content -->

			<!--Sidebar-right-->
			<div class="sidebar sidebar-right sidebar-animate">
				<div class="panel panel-primary card mb-0">
					<div class="panel-body tabs-menu-body p-0 border-0">
						<ul class="Date-time">
							<li class="time">
								<h1 class="animated ">21:00</h1>
								<p class="animated ">Sat,October 1st 2029</p>
							</li>
						</ul>
						<div class="card-body latest-tasks">
							<h3 class="events-title"><span>Events For Week </span></h3>
							<div class="event">
								<div class="Day">Monday 20 Jan</div>
								<a href="#">No Events Today</a>
							</div>
							<div class="event">
								<div class="Day">Tuesday 21 Jan</div>
								<a href="#">No Events Today</a>
							</div>
							<div class="event">
								<div class="Day">Wednessday 22 Jan</div>
								<div class="tasks">
									<div class=" task-line primary">
										<a href="#" class="label">
											XML Import &amp; Export
										</a>
										<div class="time">
											12:00 PM
										</div>
									</div>
									<div class="checkbox">
										<label class="check-box">
											<label class="ckbox"><input checked="" type="checkbox"><span></span></label>
										</label>
									</div>
								</div>
								<div class="tasks">
									<div class="task-line danger">
										<a href="#" class="label">
											Connect API to pages
										</a>
										<div class="time">
											08:00 AM
										</div>
									</div>
									<div class="checkbox">
										<label class="check-box">
											<label class="ckbox"><input type="checkbox"><span></span></label>
										</label>
									</div>
								</div>
							</div>
							<div class="event">
								<div class="Day">Thursday 23 Jan</div>
								<div class="tasks">
									<div class="task-line success">
										<a href="#" class="label">
											Create Wireframes
										</a>
										<div class="time">
											06:20 PM
										</div>
									</div>
									<div class="checkbox">
										<label class="check-box">
											<label class="ckbox"><input type="checkbox"><span></span></label>
										</label>
									</div>
								</div>
							</div>
							<div class="event">
								<div class="Day">Friday 24 Jan</div>
								<div class="tasks">
									<div class="task-line warning">
										<a href="#" class="label">
											Test new features in tablets
										</a>
										<div class="time">
											02: 00 PM
										</div>
									</div>
									<div class="checkbox">
										<label class="check-box">
											<label class="ckbox"><input type="checkbox"><span></span></label>
										</label>
									</div>
								</div>
								<div class="tasks">
									<div class="task-line teal">
										<a href="#" class="label">
											Design Evommerce
										</a>
										<div class="time">
											10: 00 PM
										</div>
									</div>
									<div class="checkbox">
										<label class="check-box">
											<label class="ckbox"><input type="checkbox"><span></span></label>
										</label>
									</div>
								</div>
								<div class="tasks mb-0">
									<div class="task-line purple">
										<a href="#" class="label">
											Fix Validation Issues
										</a>
										<div class="time">
											12: 00 AM
										</div>
									</div>
									<div class="checkbox">
										<label class="check-box">
											<label class="ckbox"><input type="checkbox"><span></span></label>
										</label>
									</div>
								</div>
							</div>
							<div class="d-flex pagination wd-100p">
								<a href="#">Previous</a>
								<a href="#" class="ml-auto">Next</a>
							</div>
						</div>
						<div class="card-body border-top border-bottom">
							<div class="row">
								<div class="col-4 text-center">
									<a class="" href=""><i class="dropdown-icon mdi  mdi-message-outline fs-20 m-0 leading-tight"></i></a>
									<div>Inbox</div>
								</div>
								<div class="col-4 text-center">
									<a class="" href=""><i class="dropdown-icon mdi mdi-tune fs-20 m-0 leading-tight"></i></a>
									<div>Settings</div>
								</div>
								<div class="col-4 text-center">
									<a class="" href=""><i class="dropdown-icon mdi mdi-logout-variant fs-20 m-0 leading-tight"></i></a>
									<div>Sign out</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
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
        $this->load->view($tempMain."/footer");
        ?>
	

	</body>
</html>