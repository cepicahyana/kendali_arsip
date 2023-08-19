 <?php
 	// $this->db->where("jenis_pegawai",2);
	//  $data = $this->db->get("data_pegawai")->row();
 	// echo json_encode($data);
 ?>

					<!-- breadcrumb -->
					<div class="breadcrumb-header justify-content-between">
						<div>
							<h4 class="content-title mb-2">Sinkronisasi data pegawai</h4>
							<nav aria-label="breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="#">terakhir data diperbaharui : <?= $this->m_reff->pengaturan(32);?></a></li>
									<!-- <li class="breadcrumb-item active" aria-current="page">Project</li> -->
								</ol>
							</nav>
						</div>
						 
					</div>
					<!-- /breadcrumb -->


					<!-- main-content-body -->
					<div class="main-content-body">
												<div class="row row-sm" id="sin">
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
								<div class="card">
									<div class="card-body">
									<center>
											 <button onclick="sinbtn()" class="btn btn-primary">Sinkronkan sekarang</button>
								<br>
									Diupdate :  <span class="offsite">0</span> /<?php echo $t=$this->mdl->total()?>
						            </div>

<!-- <hr>
<div class="card-body">
<div id='progress' class=" wd-10p  bg-primary" role="progressbar"></div>
</div>
<br> -->



									</center>
					           	</div>
							</div>
						</div>

						<hr>
												<div class="row row-sm">
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
								<div class="card">
									<div class="card-body">
									<center>
										<h5>Transfer data PPNPN ke aplikasi cetak IDCARD</h5>
											 <button onclick="trfsinbtn()" class="btn btn-success">Transfer sekarang</button>
								<br>
									Diupdate :  <span class="trfoffsite">0</span> /<?php echo $trf=$this->mdl->trftotal()?>
						            </div>
									</center>
					           	</div>
							</div>
						</div>
 
					</div></div>


<script>
	
	var total = "<?php echo $t;?>";
	var offsite;
	function sin(){
		if(!offsite){
			offsite=1;
		}
										if(offsite>total){
											// unblock("sin");
											swal("success", {
												icon: "success",
												buttons : {
													confirm : {
														className: 'btn btn-success'
													}
												}
											});

											 return false;
										} 
	//  loading("sin");
	 
	  var url   = "<?php echo site_url("syncron/start");?>";
							var param = {
								total:total,
								offsite:offsite,
								<?php echo $this->m_reff->tokenName()?>:token
								};
							$.ajax({
									type: "POST",dataType: "json",data: param, url: url,
									success: function(val){
										
										$(".offsite").html(offsite);
										token=val['token'];
										var persen=val['persen'];
										 
										 
										 $("#progress").addClass("wd-"+persen+"p");
										 $("#progress").addClass("progress-bar");
										if(offsite<=total){
											offsite++;
											sin();
										}else{
											offsite=null;
										}
									}
							});	
	}
	function sinbtn(){
		offsite=0;
		sin();
	}
</script>






<script>
	
	var trftotal = "<?php echo $trf;?>";
	var trfoffsite;
	function trfsin(){
		if(!trfoffsite){
			trfoffsite=1;
		}
										if(trfoffsite>trftotal){
											// unblock("sin");
											swal("success", {
												icon: "success",
												buttons : {
													confirm : {
														className: 'btn btn-success'
													}
												}
											});

											 return false;
										} 
	//  loading("sin");
	 
	  var url   = "<?php echo site_url("syncron/trfstart");?>";
							var param = {
								total:trftotal,
								offsite:trfoffsite,
								<?php echo $this->m_reff->tokenName()?>:token
								};
							$.ajax({
									type: "POST",dataType: "json",data: param, url: url,
									success: function(val){
										
										$(".trfoffsite").html(trfoffsite);
										token=val['token'];
										var persen=val['persen'];
										 
										 
										 $("#trfprogress").addClass("wd-"+persen+"p");
										 $("#trfprogress").addClass("progress-bar");
										if(trfoffsite<=trftotal){
											trfoffsite++;
											trfsin();
										}else{
											trfoffsite=null;
										}
									}
							});	
	}
	function trfsinbtn(){
		trfoffsite=0;
		trfsin();
	}
</script>