<?php
$opr = $this->session->pic;
?>
<div class="sticky">
				<div class="horizontal-main hor-menu clearfix side-header">
					<div class="horizontal-mainwrapper container clearfix">
						<!--Nav-->
						<nav class="horizontalMenu clearfix">
							<ul class="horizontalMenu-list">
								<li aria-haspopup="true"><a href="<?php echo base_url()?>pic" class="menuclick"><i class="fe fe-airplay  menu-icon"></i> Dashboard</a></li>
								<li aria-haspopup="true"><a href="#"><i class="fe fe-bar-chart-2"></i> Monitoring kesehatan <i class="fe fe-chevron-down horizontal-icon"></i></a>
								<ul class="sub-menu">

								<li aria-haspopup="true"><a href="<?php echo base_url()?>monkes" class="menuclick"> Pegawai</a></li>
								<li aria-haspopup="true"><a href="<?php echo base_url()?>monkes/keluarga" class="menuclick"> Keluarga pegawai</a></li>
								<!-- <li aria-haspopup="true"><a class="menuclick" href="<?php echo base_url();?>monkes/ppnpn" class="slide-item">PPNPN</a></li>
                                <li aria-haspopup="true"><a class="menuclick" href="<?php echo base_url();?>monkes/cs" class="slide-item">Cleaning service</a></li>
                                <li aria-haspopup="true"><a class="menuclick" href="<?php echo base_url();?>monkes/pt" class="slide-item">Petugas taman</a></li> -->
                                <!-- <li aria-haspopup="true"><a class="menuclick" href="<?php echo base_url();?>monkes/external" class="slide-item">External</a></li> -->
                              	</ul>
								
								  <li aria-haspopup="true"><a href="#" class="sub-icon"><i class="icon ion-ios-stats "></i> Report &nbsp;<i class="fe fe-chevron-down horizontal-icon"></i></a>
									<ul class="sub-menu">
                                      
									<li aria-haspopup="true"><a class="menuclick" href="<?php echo site_url('pic/test')?>">  Grafik tes  </a>
									<li aria-haspopup="true"><a class="menuclick" href="<?php echo site_url('pic/rekap')?>">  Rekapitulasi data tes </a>
							
										 
									</ul>
								</li>



                                <li aria-haspopup="true"><a href="#" class="sub-icon"><i class="fe fe-edit"></i> Input daftar test&nbsp;<i class="fe fe-chevron-down horizontal-icon"></i></a> 
                                <ul class="sub-menu">
                                <li aria-haspopup="true"><a class="menuclick" href="<?php echo base_url();?>input" class="slide-item">Pegawai</a></li>
                              <li aria-haspopup="true"><a class="menuclick" href="<?php echo base_url();?>input/family" class="slide-item">Keluarga pegawai</a></li>
                                <!--   <li aria-haspopup="true"><a class="menuclick" href="<?php echo base_url();?>input/ppnpn" class="slide-item">PPNPN</a></li>
                                <li aria-haspopup="true"><a class="menuclick" href="<?php echo base_url();?>input/cs" class="slide-item">Cleaning service</a></li>
                                <li aria-haspopup="true"><a class="menuclick" href="<?php echo base_url();?>input/pt" class="slide-item">Petugas taman</a></li> -->
                                <li aria-haspopup="true"><a class="menuclick" href="<?php echo base_url();?>input/external" class="slide-item">External</a></li>
                                </ul>
                            </li>
								 
							<li aria-haspopup="true"><a href="<?php echo site_url('pesan_masuk')?>" class="slide-item"><i class="  icon ion-md-chatboxes"></i> Pesan masuk </a></li>
							<li aria-haspopup="true"><a href="<?php echo site_url('riwayat_obrolan')?>"  class="slide-item"><i class="  icon ion-md-chatboxes"></i> Pegawai <> dokter</a></li>
							
                             
                               </ul>
                            </li>
						<!--	<li aria-haspopup="true"><a href="#" class="sub-icon"><i class="fe fe-compass"></i> Pages <i class="fe fe-chevron-down horizontal-icon"></i></a>
									<ul class="sub-menu">
										<li aria-haspopup="true"><a href="profile.html" class="slide-item">Profile</a></li>
										<li aria-haspopup="true"><a href="editprofile.html" class="slide-item">Edit-profile</a></li>
										<li aria-haspopup="true" class="sub-menu-sub"><a href="#">Mail <span class="badge badge-pink side-badge">5</span></a>
											<ul class="sub-menu">
												<li aria-haspopup="true"><a href="mail.html" class="slide-item">Mail-inbox</a></li>
												<li aria-haspopup="true"><a href="mail-compose.html" class="slide-item">Mail-compose</a></li>
												<li aria-haspopup="true"><a href="mail-read.html" class="slide-item">Mail-read</a></li>
												<li aria-haspopup="true"><a href="mail-settings.html" class="slide-item">Mail-settings</a></li>
												<li aria-haspopup="true"><a href="chat.html" class="slide-item">Chat</a></li>

											</ul>
										</li>
										<li aria-haspopup="true" class="sub-menu-sub"><a href="#">Forms <span class="badge badge-info side-badge">6</span></a>
											<ul class="sub-menu">
												<li aria-haspopup="true"><a href="form-elements.html" class="slide-item">Form Elements</a></li>
												<li aria-haspopup="true"><a href="form-advanced.html" class="slide-item">Advanced Forms</a></li>
												<li aria-haspopup="true"><a href="form-layouts.html" class="slide-item">Form Layouts</a></li>
												<li aria-haspopup="true"><a href="form-validation.html" class="slide-item">Form Validation</a></li>
												<li aria-haspopup="true"><a href="form-wizards.html" class="slide-item">Form Wizards</a></li>
												<li aria-haspopup="true"><a href="form-editor.html" class="slide-item">WYSIWYG Editor</a></li>
											</ul>
										</li>
										<li aria-haspopup="true"><a href="invoice.html" class="slide-item">Invoice</a></li>
										<li aria-haspopup="true"><a href="todotask.html" class="slide-item">Todotask</a></li>
										<li aria-haspopup="true"><a href="pricing.html" class="slide-item">Pricing</a></li>
										<li aria-haspopup="true"><a href="gallery.html" class="slide-item">Gallery</a></li>
										<li aria-haspopup="true"><a href="faq.html" class="slide-item">Faqs</a></li>
										<li aria-haspopup="true"><a href="empty.html" class="slide-item">Empty Page</a></li>
									</ul>
								</li>-->
								</li>
							 
							</ul>
						</nav>
						<!--Nav-->
					</div>
				</div>
			</div>
			<!--Horizontal-main -->