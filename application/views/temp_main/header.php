<?php
$nama_pengguna="";
   $level = $this->session->userdata("level");
if($level=="admin_covid" or $level=="super_admin" or $level=="pimpinan_covid"){
    $dp = $this->db->get_where("admin",array("id_admin"=>$this->session->userdata("id")))->row();
    $foto = isset($dp->poto)?($dp->poto):"";
    $nama_pengguna = isset($dp->owner)?($dp->owner):"";
}elseif($level=="pegawai" or $level=="ppnpn"){
    $dp = $this->db->get_where("data_pegawai",array("id"=>$this->session->userdata("id")))->row();
    $foto = isset($dp->poto)?($dp->poto):"dp.png";
    $nama_pengguna = isset($dp->nama)?($dp->nama):"";
}elseif($level=="rs"){
    $dp = $this->db->get_where("tm_rs",array("id"=>$this->session->userdata("id")))->row();
    $foto = isset($dp->poto)?($dp->poto):"dp.png";
    $nama_pengguna = isset($dp->nama)?($dp->nama):"";
}elseif($level=="pic_covid"){
    $dp = $this->db->get_where("admin",array("id_admin"=>$this->session->userdata("id")))->row();
    $foto = isset($dp->foto)?($dp->foto):"dp.png";
    $nama_pengguna = isset($dp->nama)?($dp->nama):"";
}elseif($level=="dokter"){
    $dp = $this->db->get_where("data_dokter",array("id"=>$this->session->userdata("id")))->row();
    $foto = isset($dp->foto)?($dp->foto):"dp.png";
    $nama_pengguna = isset($dp->nama)?($dp->nama):"";
}elseif($level=="kordokter"){
    $dp = $this->db->get_where("data_kordokter",array("id"=>$this->session->userdata("id")))->row();
    $foto = isset($dp->foto)?($dp->foto):"dp.png";
    $nama_pengguna = isset($dp->nama)?($dp->nama):"";
}
$foto = "dp.png";
?>

 
<?php
if($level=="admin_covid" or $level=="super_admin"){
	?>
<div class="main-header nav nav-item hor-header top-header">
    <?php }else{  ?> 
 <div class="main-header nav nav-item hor-header ">        
        
        <?php } ?>
					<div class="container">
						<div class="main-header-left ">
							<a class="animated-arrow hor-toggle horizontal-navtoggle"><span></span></a><!-- sidebar-toggle-->
							<a class="header-brand  hor-toggle horizontal-navtoggle" >
							<div class="logo-white sadow" style="color:#FFFF00;margin-top:20px;font-size:17px;font-weight:bold">
							  <img height='15px' src="<?php echo base_url()?>plug/img/lcovid.png"> </div>
							 	<div class="icon-white" style="color:white;margin-top:20px;font-size:16px;font-weight:bold">
								  <img height='15px' src="<?php echo base_url()?>plug/img/lcovid.png">  </div>
								<img src="<?php echo base_url()?>assets/img/brand/favicon.png" class="icon-default">
							</a>
							<div class="main-header-center">

							


                          <?php 
                         if($level=="admin_covid" or $level=="super_admin"){
                          ?>      
								<ul class="header-megamenu-dropdown  nav">
									<li class="nav-item">
										<div class="btn-group dropdown">
											<button aria-expanded="false" aria-haspopup="true" class="btn btn-link dropdown-toggle" data-toggle="dropdown" id="dropdownMenuButton2" type="button"><span><i class="fe fe-settings"></i> Settings </span></button>
											<div  class="dropdown-menu" >
												<div class="dropdown-menu-header header-img p-3">
													<div class="drop-menu-inner">
														<div class="header-content text-left d-flex">
															<div class="text-white">
																<h5 class="menu-header-title">Setting</h5>
																<!-- <h6 class="menu-header-subtitle mb-0">Overview of theme</h6> -->
															</div>
															<!-- <div class="my-auto ml-auto">
																<span class="badge badge-pill badge-warning float-right">View all</span>
															</div> -->
														</div>
													</div>
												</div>
												<div class="setting-scrolsl">
													<div>
														<div class="setting-menu ">
															<a  class="dropdown-item" href="<?php echo base_url()?>notifikasi"><i class="mdi mdi-bell-outline tx-16 mr-2 mt-1"></i>Notif hasil tes</a>
															<a  class="dropdown-item" href="<?php echo base_url()?>notifikasi/aproval_tes"><i class="mdi mdi-bell-outline tx-16 mr-2 mt-1"></i>Notif permohonan tes diterima</a>

															<a  class="dropdown-item" href="<?php echo base_url()?>notifikasi/aproval_external"><i class="mdi mdi-bell-outline tx-16 mr-2 mt-1"></i>Notif melakukan tes untuk external</a>
															<a  class="dropdown-item" href="<?php echo base_url()?>notifikasi/hasil_external"><i class="mdi mdi-bell-outline tx-16 mr-2 mt-1"></i>Notif Hasil tes untuk external</a>
															<a  class="dropdown-item" href="<?php echo base_url()?>notifikasi/akun_wa"><i class="mdi mdi-bell-outline tx-16 mr-2 mt-1"></i>Akun WA</a>
															<a  class="dropdown-item" href="<?php echo base_url()?>notifikasi/akun_email"><i class="mdi mdi-bell-outline tx-16 mr-2 mt-1"></i>Akun Email</a>
													 	</div>
													</div>
												</div>
												<ul class="setting-menu-footer flex-column pl-0">
													<li class="divider mb-0 pb-0 "></li>
													<li class="setting-menu-btn">
														<button class=" btn-shadow btn btn-success btn-sm">Cancel</button>
													</li>
												</ul>
											</div>
										</div>
									</li>
									<li class="nav-item">
										<div class="dropdown-menu-rounded btn-group dropdown" >
											<button aria-expanded="false" aria-haspopup="true" class="btn btn-link dropdown-toggle" data-toggle="dropdown" id="dropdownMenuButton3" type="button">
                                            <span><i class="nav-link-icon fe fe-briefcase"></i> Data master </span></button>
											<div class="dropdown-menu-lg dropdown-menu"  x-placement="bottom-left">
												<div class="dropdown-menu-header">
													<div class="dropdown-menu-header-inner header-img p-3">
														<div class="header-content text-left d-flex">
															<div class="text-white">
																 
																<h6 class="menu-header-subtitle mb-0">Data master</h6>
															</div>
															 
														</div>
													</div>
												</div>
                                                <!-- <a class="dropdown-item menuclick" href="<?php echo base_url()?>data_master/pegawai"><i class="typcn typcn-chevron-right-outline"></i> Data Pegawai</a>
												<div class="dropdown-divider"></div> -->
												<a class="dropdown-item menuclick" href="<?php echo base_url()?>data_master/pimpinan_pusat"><i class="typcn typcn-chevron-right-outline"></i> Akun Pimpinan Pusat</a>
												<a class="dropdown-item menuclick" href="<?php echo base_url()?>data_master/admin"><i class="typcn typcn-chevron-right-outline"></i> Akun Admin</a>
                                                
                                                <a class="dropdown-item menuclick" href="<?php echo base_url()?>data_master/pic"><i class="typcn typcn-chevron-right-outline"></i> Akun PIC</a>
                                                <a class="dropdown-item menuclick" href="<?php echo base_url()?>data_master/pimpinan"><i class="typcn typcn-chevron-right-outline"></i> Akun Pimpinan</a>
                                                <a class="dropdown-item menuclick" href="<?php echo base_url()?>data_master/rs"><i class="typcn typcn-chevron-right-outline"></i> Akun Rumah Sakit</a>
                                                <a class="dropdown-item menuclick" href="<?php echo base_url()?>data_master/dr"><i class="typcn typcn-chevron-right-outline"></i> Akun Dokter</a>
                                                <a class="dropdown-item menuclick" href="<?php echo base_url()?>data_master/kdr"><i class="typcn typcn-chevron-right-outline"></i> Akun Koordinator Dokter</a>
											  
											 
												<a class="dropdown-item menuclick mb-2" href="<?php echo base_url()?>data_master/jenis_test"><i class="typcn typcn-chevron-right-outline"></i>Data jenis test</a>
											</div>
										</div>
									</li>
								</ul> <?php } ?>
							</div>
						</div>
					<?php	if($level=="admin_covid" or $level=="super_admin"){
						?>
						<a class="header-brand2" href="">
						<img style="margin-top:10px" height="25px" src="<?php echo base_url()?>plug/img/lcovid.png" class="logo-white top-header-logo1">
								<img height="25px" src="<?php echo base_url()?>plug/img/lcovid.png" class="logo-default top-header-logo2">
						</a>
                        <?php } ?>
						<!-- search -->
	 

						<div class="main-header-right">
							 
								<div class="nav nav-item  navbar-nav-right ml-auto">
									<div class="nav-item full-screen fullscreen-button">
										<a class="new nav-link full-screen-link" href="#"><i class="fe fe-maximize"></i></span></a>
									</div>
									<div class="dropdown  nav-item main-header-message ">
									<!-- <a class="new nav-link" href="#" ><i class="fe fe-mail"></i><span class=" pulse-danger"></span></a> -->
									<div class="dropdown-menu">
										<div class="menu-header-content bg-primary-gradient text-left d-flex">
											<div class="">
												<h6 class="menu-header-title text-white mb-0">5 new Messages</h6>
											</div>
											<div class="my-auto ml-auto">
												<a class="badge badge-pill badge-warning float-right" href="#">Mark All Read</a>
											</div>
										</div>
										<div class="main-message-list chat-scroll">
											<a href="#" class="p-3 d-flex border-bottom">
												<div class="  drop-img  cover-image  " data-image-src="<?php echo base_url()?>assets/img/faces/3.jpg">
													<span class="avatar-status bg-teal"></span>
												</div>

												<div class="wd-90p">
													<div class="d-flex">
														<h5 class="mb-1 name">Paul Molive</h5>
														<p class="time mb-0 text-right ml-auto float-right">10 min ago</p>
													</div>
													<p class="mb-0 desc">I'm sorry but i'm not sure how...</p>
												</div>
											</a>
											<a href="#" class="p-3 d-flex border-bottom">
												<div class="drop-img cover-image" data-image-src="<?php echo base_url()?>assets/img/faces/2.jpg">
													<span class="avatar-status bg-teal"></span>
												</div>
												<div class="wd-90p">
													<div class="d-flex">
														<h5 class="mb-1 name">Sahar Dary</h5>
														<p class="time mb-0 text-right ml-auto float-right">13 min ago</p>
													</div>
													<p class="mb-0 desc">All set ! Now, time to get to you now......</p>
												</div>
											</a>
											<a href="#" class="p-3 d-flex border-bottom">
												<div class="drop-img cover-image" data-image-src="<?php echo base_url()?>assets/img/faces/9.jpg">
													<span class="avatar-status bg-teal"></span>
												</div>
												<div class="wd-90p">
													<div class="d-flex">
														<h5 class="mb-1 name">Khadija Mehr</h5>
														<p class="time mb-0 text-right ml-auto float-right">20 min ago</p>
													</div>
													<p class="mb-0 desc">Are you ready to pickup your Delivery...</p>
												</div>
											</a>
											<a href="#" class="p-3 d-flex border-bottom">
												<div class="drop-img cover-image" data-image-src="<?php echo base_url()?>assets/img/faces/12.jpg">
													<span class="avatar-status bg-danger"></span>
												</div>
												<div class="wd-90p">
													<div class="d-flex">
														<h5 class="mb-1 name">Barney Cull</h5>
														<p class="time mb-0 text-right ml-auto float-right">30 min ago</p>
													</div>
													<p class="mb-0 desc">Here are some products ...</p>
												</div>
											</a>
											<a href="#" class="p-3 d-flex border-bottom">
												<div class="drop-img cover-image" data-image-src="<?php echo base_url()?>assets/img/faces/5.jpg">
													<span class="avatar-status bg-teal"></span>
												</div>
												<div class="wd-90p">
													<div class="d-flex">
														<h5 class="mb-1 name">Petey Cruiser</h5>
														<p class="time mb-0 text-right ml-auto float-right">35 min ago</p>
													</div>
													<p class="mb-0 desc">I'm sorry but i'm not sure how...</p>
												</div>
											</a>
										</div>
										<div class="text-center dropdown-footer">
											<a href="#">VIEW ALL</a>
										</div>
									</div>
								</div>
								<div class="dropdown nav-item main-header-notification">
									<!-- <a class="new nav-link" href="#"><i class="fe fe-bell"></i><span class=" pulse"></span></a> -->
									<div class="dropdown-menu">
										<div class="menu-header-content bg-primary-gradient text-left d-flex">
											<div class="">
												<h6 class="menu-header-title text-white mb-0">7 new Notifications</h6>
											</div>
											<div class="my-auto ml-auto">
												<a class="badge badge-pill badge-warning float-right" href="#">Mark All Read</a>
											</div>
										</div>
										<div class="main-notification-list Notification-scroll">
											<a class="d-flex p-3 border-bottom" href="#">
												<div class="notifyimg bg-success-transparent">
													<i class="la la-shopping-basket text-success"></i>
												</div>
												<div class="ml-3">
													<h5 class="notification-label mb-1">New Order Received</h5>
													<div class="notification-subtext">1 hour ago</div>
												</div>
												<div class="ml-auto" >
													<i class="las la-angle-right text-right text-muted"></i>
												</div>
											</a>
											<a class="d-flex p-3 border-bottom" href="#">
												<div class="notifyimg bg-danger-transparent">
													<i class="la la-user-check text-danger"></i>
												</div>
												<div class="ml-3">
													<h5 class="notification-label mb-1">22 verified registrations</h5>
													<div class="notification-subtext">2 hour ago</div>
												</div>
												<div class="ml-auto" >
													<i class="las la-angle-right text-right text-muted"></i>
												</div>
											</a>
											<a class="d-flex p-3 border-bottom" href="#">
												<div class="notifyimg bg-primary-transparent">
													<i class="la la-check-circle text-primary"></i>
												</div>
												<div class="ml-3">
													<h5 class="notification-label mb-1">Project has been approved</h5>
													<div class="notification-subtext">4 hour ago</div>
												</div>
												<div class="ml-auto" >
													<i class="las la-angle-right text-right text-muted"></i>
												</div>
											</a>
											<a class="d-flex p-3 border-bottom" href="#">
												<div class="notifyimg bg-pink-transparent">
													<i class="la la-file-alt text-pink"></i>
												</div>
												<div class="ml-3">
													<h5 class="notification-label mb-1">New files available</h5>
													<div class="notification-subtext">10 hour ago</div>
												</div>
												<div class="ml-auto" >
													<i class="las la-angle-right text-right text-muted"></i>
												</div>
											</a>
											<a class="d-flex p-3 border-bottom" href="#">
												<div class="notifyimg bg-warning-transparent">
													<i class="la la-envelope-open text-warning"></i>
												</div>
												<div class="ml-3">
													<h5 class="notification-label mb-1">New review received</h5>
													<div class="notification-subtext">1 day ago</div>
												</div>
												<div class="ml-auto" >
													<i class="las la-angle-right text-right text-muted"></i>
												</div>
											</a>
											<a class="d-flex p-3" href="#">
												<div class="notifyimg bg-purple-transparent">
													<i class="la la-gem text-purple"></i>
												</div>
												<div class="ml-3">
													<h5 class="notification-label mb-1">Updates Available</h5>
													<div class="notification-subtext">2 days ago</div>
												</div>
												<div class="ml-auto" >
													<i class="las la-angle-right text-right text-muted"></i>
												</div>
											</a>
										</div>
										<div class="dropdown-footer">
											<a href="#">VIEW ALL</a>
										</div>
									</div>
								</div>
								<div class="dropdown main-profile-menu nav nav-item nav-link">
									<a class="profile-user d-flex" href=""><img src="<?php echo base_url()?>plug/img/dp/<?php echo $foto?>" 
                                    alt="user-img" class="rounded-circle mCS_img_loaded"><span></span></a>
									<div class="dropdown-menu">
										<div class="main-header-profile header-img">
											<div class="main-img-user"><img alt="" src="<?php echo base_url()?>plug/img/dp/<?php echo $foto?>""></div>
											<h6><?php echo $nama_pengguna;?></h6>
											<span><?php echo $this->m_reff->area();?></span>
										</div>
										<!-- <a class="dropdown-item menuclick" href="<?php echo base_url()?>profile"><i class="far fa-user"></i> My Profile</a> -->
										<a class="dropdown-item"  href="<?php echo base_url()?>profile"><i class="far fa-user"></i> Profile</a> 
										<?php
                                        $this->db->where("nip", $nip=$this->session->nip);
                                        $this->db->where("id_admin!=", $this->session->id);
                                        $cekLevelAdmin = $this->db->get("admin")->result();
                                        $role = "";
                                        foreach($cekLevelAdmin as $v){
                                         $levelName = $this->m_reff->goField("main_level","nama","where id_level='".$v->level."'");  
                                         $levelKet = $this->m_reff->goField("main_level","ket","where id_level='".$v->level."'");  
   
                                       echo  $role= '<a  href="'.base_url('portal/login?nip='.$this->m_reff->encrypt($nip).'&level='.$this->m_reff->encrypt($levelName)).'" 
										 class="dropdown-item"  > <i class="fa fa-paper-plane"></i> '. ucwords($levelKet).'</a>';
                                          
                                     	} 
										$cek = $this->db->get_where("data_pegawai",array("nip"=>$nip,"id!="=>$this->m_reff->idu()))->num_rows();
										if($cek){
											echo  $role= '<a  href="'.base_url('portal/login?nip='.$this->m_reff->encrypt($nip).'&level='.$this->m_reff->encrypt("pegawai")).'" 
											class="dropdown-item"  > <i class="fa fa-paper-plane"></i> PEGAWAI</a>';
											 
										}

                                    
                                    ?>

										<a class="dropdown-item" href="<?php echo base_url()?>login/logout"><i class="fas fa-sign-out-alt"></i> Sign Out</a>
									</div>
								</div>
								<!-- <div class="dropdown main-header-message right-toggle">
									<a class="nav-link pr-0" data-toggle="sidebar-right" data-target=".sidebar-right">
										<i class="ion ion-md-menu tx-20 bg-transparent"></i>
									</a>
								</div> -->
							</div>
						</div>
					</div>
				</div>