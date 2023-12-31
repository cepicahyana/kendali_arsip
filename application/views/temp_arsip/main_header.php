<!-- main-header -->
<div class="main-header side-header sticky nav nav-item">
				<div class="container-fluid main-container ">
					<div class="main-header-left ">
						<div class="app-sidebar__toggle mobile-toggle" data-bs-toggle="sidebar">
							<a class="open-toggle"   href="javascript:void(0);"><i class="header-icons" data-eva="menu-outline"></i></a>
							<a class="close-toggle"   href="javascript:void(0);"><i class="header-icons" data-eva="close-outline"></i></a>
						</div>
						<div class="responsive-logo">
							<a href="index.html" class="header-logo"><img src="<?=base_url();?>assets_arsip/img/brand/logo.png" class="logo-11"></a>
							<a href="index.html" class="header-logo"><img src="<?=base_url();?>assets_arsip/img/brand/logo-white.png" class="logo-1"></a>
						</div>
						<?=$this->load->view("temp_arsip/top_menu_".$this->session->userdata("level"));?>
					</div>
					<button class="navbar-toggler nav-link icon navresponsive-toggler vertical-icon ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent-4" aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">
						<i class="fe fe-more-vertical header-icons navbar-toggler-icon"></i>
					</button>
					<div class="mb-0 navbar navbar-expand-lg navbar-nav-right responsive-navbar navbar-dark p-0  mg-lg-s-auto">
						<div class="collapse navbar-collapse" id="navbarSupportedContent-4">
							<div class="main-header-right">
								 
								<li class="dropdown nav-item main-layout">
									<a class="new theme-layout nav-link-bg layout-setting" >
										<span class="dark-layout"><i class="fe fe-moon"></i></span>
										<span class="light-layout"><i class="fe fe-sun"></i></span>
									</a>
								</li>
								<div class="nav nav-item  navbar-nav-right mg-lg-s-auto">
									<div class="nav-item full-screen fullscreen-button">
										<a class="new nav-link full-screen-link"   href="javascript:void(0);"><i class="fe fe-maximize"></i></span></a>
									</div>
									<div class="dropdown  nav-item main-header-message ">
										<a class="new nav-link"   href="javascript:void(0);" ><i class="fe fe-mail"></i><span class=" pulse-danger"></span></a>
										<div class="dropdown-menu">
											<div class="menu-header-content bg-primary-gradient text-start d-flex">
												<div class="">
													<h6 class="menu-header-title text-white mb-0">5 new Messages</h6>
												</div>
												<div class="my-auto mg-s-auto">
													<a class="badge bg-pill bg-warning float-end"   href="javascript:void(0);">Mark All Read</a>
												</div>
											</div>
											<div class="main-message-list chat-scroll">
												<a href="mail.html" class="p-3 d-flex border-bottom">
													<div class="drop-img  cover-image  " data-bs-image-src="<?=base_url();?>assets_arsip/img/faces/3.jpg">
														<span class="avatar-status bg-teal"></span>
													</div>

													<div class="wd-90p">
														<div class="d-flex">
															<h5 class="mb-1 name">Paul Molive</h5>
															<p class="time mb-0 text-end ms-auto float-end">10 min ago</p>
														</div>
														<p class="mb-0 desc">I'm sorry but i'm not sure how...</p>
													</div>
												</a>
												<a href="mail.html" class="p-3 d-flex border-bottom">
													<div class="drop-img cover-image" data-bs-image-src="<?=base_url();?>assets_arsip/img/faces/2.jpg">
														<span class="avatar-status bg-teal"></span>
													</div>
													<div class="wd-90p">
														<div class="d-flex">
															<h5 class="mb-1 name">Sahar Dary</h5>
															<p class="time mb-0 text-end ms-auto float-end">13 min ago</p>
														</div>
														<p class="mb-0 desc">All set ! Now, time to get to you now......</p>
													</div>
												</a>
												<a href="mail.html" class="p-3 d-flex border-bottom">
													<div class="drop-img cover-image" data-bs-image-src="<?=base_url();?>assets_arsip/img/faces/9.jpg">
														<span class="avatar-status bg-teal"></span>
													</div>
													<div class="wd-90p">
														<div class="d-flex">
															<h5 class="mb-1 name">Khadija Mehr</h5>
															<p class="time mb-0 text-end ms-auto float-end">20 min ago</p>
														</div>
														<p class="mb-0 desc">Are you ready to pickup your Delivery...</p>
													</div>
												</a>
												<a href="mail.html" class="p-3 d-flex border-bottom">
													<div class="drop-img cover-image" data-bs-image-src="<?=base_url();?>assets_arsip/img/faces/12.jpg">
														<span class="avatar-status bg-danger"></span>
													</div>
													<div class="wd-90p">
														<div class="d-flex">
															<h5 class="mb-1 name">Barney Cull</h5>
															<p class="time mb-0 text-end ms-auto float-end">30 min ago</p>
														</div>
														<p class="mb-0 desc">Here are some products ...</p>
													</div>
												</a>
												<a href="mail.html" class="p-3 d-flex border-bottom">
													<div class="drop-img cover-image" data-bs-image-src="<?=base_url();?>assets_arsip/img/faces/5.jpg">
														<span class="avatar-status bg-teal"></span>
													</div>
													<div class="wd-90p">
														<div class="d-flex">
															<h5 class="mb-1 name">Petey Cruiser</h5>
															<p class="time mb-0 text-end ms-auto float-end">35 min ago</p>
														</div>
														<p class="mb-0 desc">I'm sorry but i'm not sure how...</p>
													</div>
												</a>
											</div>
											<div class="text-center dropdown-footer">
												<a href="mail.html">VIEW ALL</a>
											</div>
										</div>
									</div>
									<div class="dropdown nav-item main-header-notification">
										<a class="new nav-link"   href="javascript:void(0);"><i class="fe fe-bell"></i><span class=" pulse"></span></a>
										<div class="dropdown-menu">
											<div class="menu-header-content bg-primary-gradient text-start d-flex">
												<div class="">
													<h6 class="menu-header-title text-white mb-0">7 new Notifications</h6>
												</div>
												<div class="my-auto ms-auto">
													<a class="badge bg-pill bg-warning float-end"   href="javascript:void(0);">Mark All Read</a>
												</div>
											</div>
											<div class="main-notification-list Notification-scroll">
												<a class="d-flex p-3 border-bottom"   href="javascript:void(0);">
													<div class="notifyimg bg-success-transparent">
														<i class="la la-shopping-basket text-success"></i>
													</div>
													<div class="ms-3">
														<h5 class="notification-label mb-1">New Order Received</h5>
														<div class="notification-subtext">1 hour ago</div>
													</div>
													<div class="ms-auto" >
														<i class="las la-angle-right text-end text-muted"></i>
													</div>
												</a>
												<a class="d-flex p-3 border-bottom"   href="javascript:void(0);">
													<div class="notifyimg bg-danger-transparent">
														<i class="la la-user-check text-danger"></i>
													</div>
													<div class="ms-3">
														<h5 class="notification-label mb-1">22 verified registrations</h5>
														<div class="notification-subtext">2 hour ago</div>
													</div>
													<div class="ms-auto" >
														<i class="las la-angle-right text-end text-muted"></i>
													</div>
												</a>
												<a class="d-flex p-3 border-bottom"   href="javascript:void(0);">
													<div class="notifyimg bg-primary-transparent">
														<i class="la la-check-circle text-primary"></i>
													</div>
													<div class="ms-3">
														<h5 class="notification-label mb-1">Project has been approved</h5>
														<div class="notification-subtext">4 hour ago</div>
													</div>
													<div class="ms-auto" >
														<i class="las la-angle-right text-end text-muted"></i>
													</div>
												</a>
												<a class="d-flex p-3 border-bottom"   href="javascript:void(0);">
													<div class="notifyimg bg-pink-transparent">
														<i class="la la-file-alt text-pink"></i>
													</div>
													<div class="ms-3">
														<h5 class="notification-label mb-1">New files available</h5>
														<div class="notification-subtext">10 hour ago</div>
													</div>
													<div class="ms-auto" >
														<i class="las la-angle-right text-end text-muted"></i>
													</div>
												</a>
												<a class="d-flex p-3 border-bottom"   href="javascript:void(0);">
													<div class="notifyimg bg-warning-transparent">
														<i class="la la-envelope-open text-warning"></i>
													</div>
													<div class="ms-3">
														<h5 class="notification-label mb-1">New review received</h5>
														<div class="notification-subtext">1 day ago</div>
													</div>
													<div class="ms-auto" >
														<i class="las la-angle-right text-end text-muted"></i>
													</div>
												</a>
												<a class="d-flex p-3"   href="javascript:void(0);">
													<div class="notifyimg bg-purple-transparent">
														<i class="la la-gem text-purple"></i>
													</div>
													<div class="ms-3">
														<h5 class="notification-label mb-1">Updates Available</h5>
														<div class="notification-subtext">2 days ago</div>
													</div>
													<div class="ms-auto" >
														<i class="las la-angle-right text-end text-muted"></i>
													</div>
												</a>
											</div>
											<div class="dropdown-footer">
												<a   href="javascript:void(0);">VIEW ALL</a>
											</div>
										</div>
									</div>
									<div class="dropdown main-profile-menu nav nav-item nav-link">

										<a class="profile-user d-flex" href="">
											<img src="<?=base_url();?>plug/img/<?=$this->session->userdata("gender");?>.png" alt="user-img" class="rounded-circle mCS_img_loaded">
									
											<span></span></a>

										<div class="dropdown-menu">
											<div class="main-header-profile header-img">
												<div class="main-img-user">
												<img src="<?=base_url();?>plug/img/<?=$this->session->userdata("gender");?>.png" alt="user-img">
									
											</div>
												<h6><?=$this->session->userdata("username");?></h6>
												<span><?=$this->session->userdata("level_ket");?></span>
											</div>
											<a class="dropdown-item" href="profile.html"><i class="far fa-user"></i> My Profile</a> 
											<a class="dropdown-item" href="<?=base_url()?>ars_master/activity"><i class="far fa-clock"></i> Activity Logs</a> 
											<a class="dropdown-item" href="<?=base_url();?>login/logout"><i class="fas fa-sign-out-alt"></i> Sign Out</a>
										</div>
									</div>
									<!-- <div class="dropdown main-header-message right-toggle">
										<a class="nav-link pe-0" data-bs-toggle="sidebar-right" data-bs-target=".sidebar-right">
											<i class="ion ion-md-menu tx-20 bg-transparent"></i>
										</a>
									</div> -->
								</div>
							</div>
						</div>
					</div>
					<!-- <div class="d-flex header-setting-icon">
						<a class="nav-link icon demo-icon"    href="javascript:void(0);">
							<i class="fe fe-settings  fe-spin"></i>
						</a>
					</div> -->
				</div>
			</div>
			<!-- /main-header -->