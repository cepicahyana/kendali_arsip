
<?php  $con		=	new konfig();
	   $dp		=	$con->dataProfile($this->session->userdata("id")); 
	   $dp		=	$this->m_reff->dataProfilePegawai();  
	   $dpeg	=	$this->m_reff->dbPegawai();	

 
 
    $fileimage		=	$this->m_reff->pengaturan(26).$dpeg->foto;
	 $file  =	@get_headers($fileimage);
	if($file && strpos( $file[0], '200')) {
	 	  $poto = $fileimage;
	}
	else{
		$poto = base_url()."plug/img/logom.png";
	} 
	
	 
	 
?>
	
	
<body >

	<!-- [ Pre-loader ] start -->
	<div class="loader-bg">
		<div class="loader-track">
			<div class="loader-fill"></div>
		</div>
	</div>
	<!-- [ Pre-loader ] End -->
	<!-- [ navigation menu ] start -->
	<nav class="pcoded-navbar menu-light navbar-collapsed">
		<div class="navbar-wrapper  ">
			<div class="navbar-content scroll-div " >
				
				<div class="">
					<div class="main-menu-header">
						<img class="img-radius" src="<?php echo  $poto;?>" alt="User-Profile-Image">
						<div class="user-details">
							<div id="more-details"><?php echo $dpeg->nmpeg;?> <i class="fa fa-caret-down"></i></div>
						</div>
					</div>
					<div class="collapse" id="nav-user-link">
						<ul class="list-inline">
							<li class="list-inline-item"><a href="<?php echo site_url('profile')?>" data-toggle="tooltip" title="Edit Profile"><i class="feather icon-user"></i></a></li>
						 	<li class="list-inline-item"><a href="<?php echo site_url('login/logout')?>" data-toggle="tooltip" title="Logout" class="text-danger"><i class="feather icon-power"></i></a></li>
						</ul>
					</div>
				</div>
				<?php
				 if($this->session->userdata("level")=="admin") {
					echo $this->load->view("temp_user/menu_admin");
				} else{
					echo $this->load->view("temp_user/menu_pimpinan");
				}
				?>
				 
				 
			</div>
		</div>
	</nav>
	<!-- [ navigation menu ] end -->
	<!-- [ Header ] start -->
	<header class="navbar pcoded-header navbar-expand-lg navbar-light header-blue">
		
			
				<div class="m-header">
					<a class="mobile-menu" id="mobile-collapse" href="#!"><span></span></a>
					<a href="<?php echo base_url()?>#!" class="b-brand">
						<!-- ========   change your logo hear   ============ -->
						<img src="<?php echo base_url()?>plug/img/logo5.png" alt="" class="logo" width='100%'>  
				 
					</a>
					<a href="#!" class="mob-toggler">
						<i class="feather icon-more-vertical"></i>
					</a>
				</div>
				<div class="collapse navbar-collapse">
					 
					<ul class="navbar-nav ml-auto">
						<li>
						 
						</li>
						<li>
							<div class="dropdown drp-user">
								<a href="<?php echo base_url()?>#" class="dropdown-toggle" data-toggle="dropdown">
									 
									<img width="30px" style='border:white solid 2px' src="<?php echo $poto;?>" class="img-radius" alt="User-Profile-Image">
									
								</a>
								<div class="dropdown-menu dropdown-menu-right profile-notification">
									<div class="pro-head">
										<img src="<?php echo $poto;?>" class="img-radius" alt="User-Profile-Image">
										<span><?php echo $dpeg->nmpeg;?> </span>
										<a href="<?php echo base_url()?>login/logout" class="dud-logout" title="Logout">
											<i class="feather icon-log-out"></i>
										</a>
									</div>
									<ul class="pro-body">
										<li><a href="<?php echo site_url('profile')?>" class="dropdown-item"><i class="feather icon-user"></i> Profile</a></li>
										<!--li><a href="<?php echo base_url()?>email_inbox.html" class="dropdown-item"><i class="feather icon-mail"></i> My Messages</a></li-->
										<li><a href="<?php echo site_url('login/logout')?>" class="dropdown-item"><i class="feather icon-power"></i> Logout</a></li>
									</ul>
								</div>
							</div>
						</li>
					</ul>
				</div>
				
			
	</header>
	<!-- [ Header ] end -->
	
	
