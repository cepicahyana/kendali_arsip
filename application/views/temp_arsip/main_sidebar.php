<style>
	.gold-text {
  color:#4682B4;; /* Warna teks emas */
  font-size: 24px; /* Ukuran teks */
  font-family: 'Arial', sans-serif; /* Jenis font (ganti sesuai keinginan) */
  text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3); /* Efek bayangan teks */
}
 
</style>
 

<div class="app-sidebar__overlay" data-bs-toggle="sidebar"></div>
			<div class="sticky">
				<aside class="app-sidebar sidebar-scroll">
					<div class="main-sidebar-header active curve">
						<b class="sadow gold-text text-white text-primary pd-6" >KENDALI ARSIP</b>
						<!-- <a class="desktop-logo logo-light active" href="index.html"><img src="<?=base_url();?>assets_arsip/img/brand/logo.png" class="main-logo" alt="logo"></a>
						<a class="desktop-logo logo-dark active" href="index.html"><img src="<?=base_url();?>assets_arsip/img/brand/logo-white.png" class="main-logo" alt="logo"></a>
						<a class="logo-icon mobile-logo icon-light active" href="index.html"><img src="<?=base_url();?>assets_arsip/img/brand/favicon.png" alt="logo"></a>
						<a class="logo-icon mobile-logo icon-dark active" href="index.html"><img src="<?=base_url();?>assets_arsip/img/brand/favicon-white.png" alt="logo"></a> -->
					</div>
					 
					<div class="main-sidemenu">
						<div class="main-sidebar-loggedin">
							<div class="app-sidebar__user">
								<div class="dropdown user-pro-body text-center">
									<div class="user-pic"> 
										<img src="<?=base_url();?>plug/img/<?=$this->session->userdata("gender");?>.png" alt="user-img" class="rounded-circle mCS_img_loaded">
									</div>
									<div class="user-info">
										<h6 class=" mb-0 text-dark"><?=$this->session->userdata("username");?> </h6>
										<!-- <span class="text-muted app-sidebar__user-name text-sm"></span> -->
								 <div onclick="change_role()" class="main-contact-stars  cursor mt-1 btn-success-light" style="border:green solid 10x;color:black;border-radius:10px" 
								 data-bs-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> 
									 <?=$this->session->userdata("level_ket");?> <i class="angle fe fe-chevron-down" style="margin-left:10px;margin-top:5px;position:absolute"></i>
									  </div>
									</div>
								</div>
							</div>
						</div>
						<hr>
						<!-- <div class="sidebar-navs">
							<ul class="nav  nav-pills-circle">
								<li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Settings" aria-describedby="tooltip365540">
									<a class="nav-link text-center m-2">
										<i class="fe fe-settings"></i>
									</a>
								</li>
								<li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Chat" aria-describedby="tooltip143427">
									<a class="nav-link text-center m-2">
										<i class="fe fe-mail"></i>
									</a>
								</li>
								<li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Followers">
									<a class="nav-link text-center m-2">
										<i class="fe fe-user"></i>
									</a>
								</li>
								<li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Logout">
									<a class="nav-link text-center m-2">
										<i class="fe fe-power"></i>
									</a>
								</li>
							</ul>
						</div> -->
						<div class="slide-left disabled" id="slide-left"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"><path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"/></svg></div>
					<?=$this->load->view("temp_arsip/main_menu");?>

						<div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"><path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"/></svg></div>
					</div>
				</aside>
			</div>
			<!-- main-sidebar -->

			<script>
				function change_role(){
						$("#myModalRole").modal("show");
				}
			</script>

<div class="modal fade effect-flip-horizontal" id="myModalRole" >
			<div class="modal-dialog modal-xs modal-dialog-centered" role="document">
				<div class="modal-content modal-content-demo" id="area_modal">
					<div class="modal-header">Pilih Role Akses
						<h6 class="modal-title"> </h6><button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
					
					</div>
					<div class=" card-body">

					
				<table class="table datatables table-bordered table-hover cursor">
					
						<?php
$nip = $this->session->userdata("nip");
  $id_level = $this->session->userdata("id_level");
$this->db->where("level!=",$id_level);
$data_user = $this->db->get_where("admin",array("nip"=>$nip))->result();
foreach($data_user as $val){
  $level = $this->m_reff->goField("main_level","ket","where id_level='".$val->level."' ");
  $role = $nip."::".$val->level;
echo '<tr> <td class="pointer"><a href="'.base_url().'login/change_access?id='.$this->m_reff->encrypt($role).'"><i class="far fa-paper-plane"></i> '.strtoupper($level).'</a></td></tr>';
}

$data_user = $this->db->get_where("ars_tr_uk_employee",array("employee_nip"=>$nip))->result();
foreach($data_user as $val){
  $role = $nip."::16";
  $posisi = $val->posisi_type;
 	 if($posisi=="01"){
		$posisi = "I";
	}elseif($posisi=="02"){
		$posisi = "II";
	}elseif($posisi=="03"){
		$posisi = "III";
	}
echo '<tr> <td class="pointer"><a href="'.base_url().'login/change_access?id='.$this->m_reff->encrypt($role).'"><i class="far fa-paper-plane"></i> UNIT KEARSIPAN - '.$posisi.' </a></td></tr>';
}

$data_user = $this->db->get_where("ars_tr_up_employee",array("employee_nip"=>$nip))->result();
foreach($data_user as $val){
  $role = $nip."::17";
echo '<tr> <td class="pointer"><a href="'.base_url().'login/change_access?id='.$this->m_reff->encrypt($role).'"><i class="far fa-paper-plane"></i> UNIT PENGOLAH</a></td></tr>';
}
?>
				</table>
				</div>
				</div>
			</div>
 </div> 