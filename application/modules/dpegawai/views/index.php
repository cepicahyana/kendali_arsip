<!-- linear-gradient(45deg, #3858f9, #0ba360); -->
<style>
.task-box.success {
	background-color: white;
	color:grey;
}
.imgspan{
	line-height: 15px;
	font-size:12px;
	/* //background-color: coral;
	opacity: 0.1; */
	color:black
}
#cardmode{
   -moz-box-shadow:    inset 0 0px 10px #000000;
   -webkit-box-shadow: inset 0 0px 10px #000000;
   box-shadow:         inset 0 0px 10px cornflowerblue;
}
</style>

<?php
$dp 	= $this->db->get_where("data_pegawai",array("id"=>$this->session->userdata("id")))->row();

$jp		= isset($dp->jenis_pegawai)?($dp->jenis_pegawai):1;
$kode	= isset($dp->kode_test)?($dp->kode_test):null;
// $kep    = $this->db->get_where("data_test",array("kode"=>$kode))->row();
//  $id_keperluan = isset($kep->id_keperluan)?($kep->id_keperluan):null;
$hasil	= isset($dp->hasil_test)?($dp->hasil_test):null;
$mobile = $this->m_reff->mobile();

$stsDb 		= $this->mdl->sts_test_trakhir();
$hasilDb	= isset($stsDb->hasil)?($stsDb->hasil):null;
$stsID		= isset($stsDb->id)?($stsDb->id):null;
$kode_utama	= isset($stsDb->kode_test_utama)?($stsDb->kode_test_utama):null;


if($kode and $hasilDb=="+"){

	$cek_kondisi_all = $this->mdl->cek_keterangan($kode);
	if($cek_kondisi_all){
		$cek_update = $this->mdl->cek_kondisi($kode);
		if(!$cek_update){
			echo "<script>setTimeout(function(){ update('".$kode."','".$kode_utama."') }, 2000); </script>";
		}
	}else{
		if($hasil=="+"){
			echo "<script>setTimeout(function(){ update_keterangan('".$kode."','".$kode_utama."') }, 1000); </script>";
		}elseif($hasil=="-" and $kode){
			echo "<script>setTimeout(function(){ update_keterangan_negatif('".$kode."','".$kode_utama."') }, 1000); </script>";
		}
	}

	}



?>


					<!-- breadcrumb -->
					<div class="breadcrumb-header justify-content-between">
						<div>
							<h4 class="content-title mb-2">Hai, <?php echo isset($dp->nama)?($dp->nama):null?></h4>
							<nav aria-label="breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="#">Selamat datang diaplikasi monitoring covid, update terus kondisimu</a></li>
									<!-- <li class="breadcrumb-item active" aria-current="page">Project</li> -->
								</ol>
							</nav>
						</div>
					 
					</div>
					<!-- /breadcrumb --><br>

					<?php


echo $this->load->view("info_test");
if($jp==1){
	echo $this->load->view("info_test_keluarga");
}







?>
					<!-- main-content-body -->
					<div class="main-content-body">

<!-- <?php

if($info=$this->m_reff->pengaturan(2) and !$stsID){?>
						<div class="row row-sm">
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
								<div class="card overflow-hidden project-card">
									<div class="card-body">
										<div class="d-flex">
											 
											<div class="project-content">
												<h5 class='text-success'>Informasi</h5>
												 
											 <p style='color:black;font-size:20px'><?php echo $info?></p>
													 
												 
											</div>
										</div>
									</div>
								</div>
								</div> 
						</div>
<?php } ?> -->







<?php
if($mobile){

if($this->session->pic){
	$link  = site_url('input');
	$link2 = site_url('input');
}else{
	$link  = site_url('input_permohonan');
	$link2 = site_url('input_permohonan/keluarga');
}



if($jp==1){ //Jika PNS


	echo '<div > 	<table width="100%">
	<tr>
	<td style="width:50%">
	<a href="'.$link.'" class="menuclick">
	<div  id="cardmode" data-effect="effect-scale" data-toggle="modal"  class="task-box success mb-0 " style="border-top-left-radius:20px;height:100%">
												<p style="font-size:13px" class="text-center p-2 mb-0 text-success"><b>Laporkan kondisi anda</b></p>
										<center>	<img width="100px" src="'.base_url().'assets/img/5.png"/>
										<div class="imgspan">Pengajuan tes covid untuk anda</div>
										</center>
											</div>
		</a>
	</td>
	<td>
	<a href="'.$link2.'" class="menuclick">
	<div id="cardmode"  class="task-box success mb-0 " style="border-top-right-radius:20px;height:100%">
			 <p style="font-size:13px" class="text-center p-2 mb-0 tx-12 text-success" ><b style="font-size:12px">Laporkan kondisi keluarga</b></p>
			 <center>	<img width="100px" src="'.base_url().'assets/img/4.png"/>
			 <div class="imgspan">	 Pengajuan tes  covid untuk keluarga</div>
			 </center>
	</div>
	</a>
	</td>
	</tr>
	
	<tr>
	<td>
	<a href="'.base_url().'tanya_dokter" class="menuclick">
	<div id="cardmode" class="task-box success mb-0" style="height:100%">
	<p style="font-size:13px" class="text-center p-2 mb-0 tx-13 text-success"><b>Tanya dokter</b></p>
	<center>	<img width="100px" src="'.base_url().'assets/img/3.png"/>
	<div class="imgspan">konsultasikan kesehatan anda dengan dokter terbaik <div>
	</center>
	 </div>
	 </a>
	</td>
	<td>
	<a href="'.base_url().'tanya_admin" class="menuclick">
		<div id="cardmode" class="task-box success mb-0 " style="height:100%">
		<p style="font-size:13px" class="text-center p-2 mb-0 tx-13 text-success"><b>Tanya admin</b></p>
											
		<center>		<img width="100px" src="'.base_url().'assets/img/con.png"/>
		<div class="imgspan">Hubungi admin untuk kebutuhan anda<div>
		</center>
		</div>
	</a>
	</td>
	</tr>
	
	
	
	<tr>
	<td>
		<a href="'.base_url().'dpegawai/riwayat_tes" class="menuclick">
			<div id="cardmode" class="task-box success mb-0 " style="border-bottom-left-radius:20px;height:100%">
			<p style="font-size:13px" class="text-center p-2 mb-0 tx-12 text-success"><b>Riwayat tes anda</b></p>
												
			<center>	<img width="100px" src="'.base_url().'assets/img/2.png"/><br>
			Riwayat tes yang telah dilaksankan oleh anda
			</center>
			</div>
		</a>
	</td>
	<td>
	<div id="cardmode" class="task-box success mb-0 " style="border-bottom-right-radius:20px;height:100%">
	<p style="font-size:13px" class="text-center p-2 mb-0 tx-12 text-success"><b>Riwayat tes keluarga</b></p>
										
	<center>	<img width="100px" src="'.base_url().'assets/img/1.png"/><br>
	Riwayat tes yang telah dilaksankan oleh keluarga
	</center>
											</div>
	</td>
	</tr>
	
	</table></div><br><br>';
	
		// echo "<button data-effect='effect-scale' data-toggle='modal' href='#modalprog
		// ' class='btn btn-lg btn-success btn-block'><i class='typcn typcn-arrow-right-outline'></i> Update kondisi anda</button><br>";
	
		// echo "<button data-effect='effect-scale' data-toggle='modal' href='#modalprog
		// ' class='btn btn-lg btn-success btn-block'><i class='typcn typcn-arrow-right-outline'></i> Update kondisi keluarga</button><br>";
	
	 
		echo '	<!-- Modal effects -->
		<div class="modal" id="modalprog">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content modal-content-demo">
					<div class="modal-header">
						<h6 class="modal-title">Modal Header</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
							</div>
					<div class="modal-body">
					<div class="row row-sm "  id="progress"></div>
					</div>
						</div>
					</div>
				</div>
		<!-- End Modal effects-->';
 
	
	




}else{ // jika PPNPN



	echo '<div > 	<table width="100%">
	<tr>
	<td style="width:50%">
	<a href="'.$link.'" class="menuclick">
	<div  id="cardmode" data-effect="effect-scale" data-toggle="modal"  class="task-box success mb-0 " style="border-top-left-radius:20px;height:100%">
												<p style="font-size:13px" class="text-center p-2 mb-0 text-success"><b>Laporkan kondisi anda</b></p>
										<center>	<img width="100px" src="'.base_url().'assets/img/5.png"/>
										<div class="imgspan">Pengajuan tes covid untuk anda</div>
										</center>
											</div>
		</a>
	</td>
	<td>
	<a href="'.$link2.'" class="menuclick">
	<div id="cardmode"  class="task-box success mb-0 " style="border-top-right-radius:20px;height:100%">
			 <p   class="text-center p-2 mb-0 tx-12 text-success" ><b style="font-size:13px">Riwayat test</b></p>
			 <center>	<img width="100px" src="'.base_url().'assets/img/2.png"/>
			 <div class="imgspan">	Data riwayat test yang telah dilaksanakan.</div>
			 </center>
	</div>
	</a>
	</td>
	</tr>
	
	<tr>
	<td>
		<a href="'.base_url().'tanya_dokter" class="menuclick">
			<div id="cardmode" class="task-box success mb-0" style="border-bottom-left-radius:20px;height:100%">
			<p style="font-size:13px" class="text-center p-2 mb-0 tx-13 text-success"><b>Tanya dokter</b></p>
			<center>	<img width="100px" src="'.base_url().'assets/img/dok.png"/>
			<div class="imgspan">konsultasikan kesehatan anda dengan dokter terbaik <div>
			</center>
			</div>
		</a>
	</td>
	<td>
		<a href="'.base_url().'tanya_admin" class="menuclick">
			<div id="cardmode" class="task-box success mb-0 " style="border-bottom-right-radius:20px;height:100%">
			<p style="font-size:13px" class="text-center p-2 mb-0 tx-13 text-success"><b>Tanya admin</b></p>
												
			<center>		<img width="100px" src="'.base_url().'assets/img/con.png"/>
			<div class="imgspan">Hubungi admin untuk kebutuhan anda<div>
			</center>
			</div>
		</a>
	</td>
	</tr>
	
	
	
	
	</table></div><br><br>';
	
		// echo "<button data-effect='effect-scale' data-toggle='modal' href='#modalprog
		// ' class='btn btn-lg btn-success btn-block'><i class='typcn typcn-arrow-right-outline'></i> Update kondisi anda</button><br>";
	
		// echo "<button data-effect='effect-scale' data-toggle='modal' href='#modalprog
		// ' class='btn btn-lg btn-success btn-block'><i class='typcn typcn-arrow-right-outline'></i> Update kondisi keluarga</button><br>";
	
	 
		echo '	<!-- Modal effects -->
		<div class="modal" id="modalprog">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content modal-content-demo">
					<div class="modal-header">
						<h6 class="modal-title">Modal Header</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
							</div>
					<div class="modal-body">
					<div class="row row-sm "  id="progress"></div>
					</div>
						</div>
					</div>
				</div>
		<!-- End Modal effects-->';
 



}


}?>





		


<?php
if(!$mobile){
$data = $this->db->get_where("data_test",array("nip"=>$this->mdl->nip()))->row();  
 if(isset($data->id)){?>
						<!-- row -->
						<div class="row row-sm " id="riwayat">
							<div class="col-md-12 col-xl-12">
								<div class="card overflow-hidden review-project">
									<div class="card-body">
										<div class="d-flex justify-content-between">
											<h4 class="card-title mg-b-10">RIWAYAT TEST  ANDA</h4>
											<i class="mdi mdi-dots-horizontal text-gray"></i>
										</div> 
										<div class="table-responsive mb-0">
											<table id="table" class="table table-hover table-bordered mb-0 text-md-nowrap text-lg-nowrap text-xl-nowrap table-striped ">
												<thead>
													<tr>
													 
														<th>Tanggal </th>
														<th>Hasil</th>
														<th>Jenis Test</th>
														<th>Tempat Test</th>
														
														
													</tr>
												</thead>
												 
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- /row -->


<?php
if($jp==1){?>
	<!-- row -->
	<div class="row row-sm " id="riwayat2">
							<div class="col-md-12 col-xl-12 area_lod2">
								<div class="card overflow-hidden review-project">
									<div class="card-body">
										<div class="d-flex justify-content-between">
											<h4 class="card-title mg-b-10">RIWAYAT TEST  KELUARGA ANDA</h4>
											<i class="mdi mdi-dots-horizontal text-gray"></i>
										</div> 
										<div class="table-responsive mb-0">
											<table id="table2" class="table table-hover table-bordered mb-0 text-md-nowrap text-lg-nowrap text-xl-nowrap table-striped ">
												<thead>
													<tr>
													 
														<th>Tanggal </th>
														<th>Nama </th>
														<th>Hasil</th>
														<th>Jenis Test</th>
														<th>Tempat Test</th>
														
														
													</tr>
												</thead>
												 
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- /row -->
<?php } ?>





	<?php }  }?>					
				<script>
 

	//  setTimeout(function(){ progress(); }, 1500);
	function progress(){ return false;
				var kode = "<?php echo $kode;?>";
			    var url   = "<?php echo site_url("dpegawai/progress");?>";
				var param = {kode:kode,<?php echo $this->m_reff->tokenName()?>:token};
				$.ajax({
						type: "POST",dataType: "json",data: param, url: url,
						success: function(val){
							$("#progress").html(val['data']);
							token=val['token'];
						}
				});		

	}
	
	 

	function update(kode,kodut){
			    var url   = "<?php echo site_url("dpegawai/viewAdd");?>";
				var param = {kodut:kodut,kode:kode,<?php echo $this->m_reff->tokenName()?>:token};
				$.ajax({
						type: "POST",dataType: "json",data: param, url: url,
						success: function(val){
							$("#mdl_modal").modal();
							 $("#isi").html(val['data']);
							token=val['token'];
						}
				});		
	}
	 

	function update_keluarga(kode,kodut,nik){
			    var url   = "<?php echo site_url("dpegawai/viewAddKeluarga");?>";
				var param = {kodut:kodut,kode:kode,nik:nik,<?php echo $this->m_reff->tokenName()?>:token};
				$.ajax({
						type: "POST",dataType: "json",data: param, url: url,
						success: function(val){
							$("#mdl_modal").modal();
							 $("#isi").html(val['data']);
							token=val['token'];
						}
				});		
	}

	function update_keterangan(kode){
		var url   = "<?php echo site_url("dpegawai/viewKeterangan");?>";
				var param = {kode:kode,<?php echo $this->m_reff->tokenName()?>:token};
				$.ajax({
						type: "POST",dataType: "json",data: param, url: url,
						success: function(val){
							$("#mdl_modal_ket").modal({backdrop: 'static', keyboard: false});
							 $("#isi_ket").html(val['data']);
							token=val['token'];
						}
				});		
 
	}
	function update_keterangan_negatif(kode){
		$.post("<?php echo site_url("dpegawai/viewKeteranganNegatif"); ?>",{kode:kode},function(data){
			 $("#mdl_modal_ket").modal({backdrop: 'static', keyboard: false});
			 $("#isi_ket").html(data);
		      }); 
	}
	function ajukan_ulang(kode,nama){
		var url   = "<?php echo site_url("dpegawai/ajukan_ulang");?>";
				var param = {nama:nama,kode:kode,<?php echo $this->m_reff->tokenName()?>:token};
				$.ajax({
						type: "POST",dataType: "json",data: param, url: url,
						success: function(val){
							$("#mdl_modal").modal();
							 $("#isi").html(val['data']);
							token=val['token'];
						 
						}
				});		
	}
	
	function ajukan_ulang_keluarga(kode,nama){
		var url   = "<?php echo site_url("dpegawai/ajukan_ulang_keluarga");?>";
				var param = {nama:nama,kode:kode,<?php echo $this->m_reff->tokenName()?>:token};
				$.ajax({
						type: "POST",dataType: "json",data: param, url: url,
						success: function(val){
							$("#mdl_modal").modal();
							 $("#isi").html(val['data']);
							token=val['token'];
						 
						}
				});		
	}
	

	function pilih_kondisi(kode,kondisi,token,kodut){
			  $("#mdl_modal").modal("hide");
			  var url   = "<?php echo site_url("dpegawai/viewPilihKondisi");?>";
				var param = {kodut:kodut,kondisi:kondisi,kode:kode,<?php echo $this->m_reff->tokenName()?>:token};
				$.ajax({
						type: "POST",dataType: "json",data: param, url: url,
						success: function(val){
							// token=val['token'];
							$("#mdl_modal_kondisi").modal();
							 $("#isi_kondisi").html(val['data']);
							
						}
				});	
}

	function pilih_kondisi_keluarga(kode,kondisi,token,kodut){
			  $("#mdl_modal").modal("hide");
			  var url   = "<?php echo site_url("dpegawai/viewPilihKondisiKeluarga");?>";
				var param = {kodut:kodut,kondisi:kondisi,kode:kode,<?php echo $this->m_reff->tokenName()?>:token};
				$.ajax({
						type: "POST",dataType: "json",data: param, url: url,
						success: function(val){
							// token=val['token'];
							$("#mdl_modal_kondisi").modal();
							 $("#isi_kondisi").html(val['data']);
							
						}
				});	
}

 
  	  function hapus_progress(id){
		  
swal({
						title: 'Hapus ?',
						text: "",
						type: 'warning',
						buttons:{
							cancel: {
								visible: true,
								text : 'batal',
								className: 'btn btn-danger'
							},        			
							confirm: {
								text : 'Ya',
								className : 'btn btn-success'
							}
						}
					}).then((willDelete) => {
						if (willDelete) {
							swal("data telah dihapus", {
								icon: "success",
								buttons : {
									confirm : {
										className: 'btn btn-success'
									}
								}
							});
							
							  
							var url   = "<?php echo site_url("dpegawai/hapus_progress");?>";
							var param = {id:id,<?php echo $this->m_reff->tokenName()?>:token};
							$.ajax({
									type: "POST",dataType: "json",data: param, url: url,
									success: function(val){
										token=val['token'];
										window.location.href="";
									}
							});	

							
						}  
					});
		    
	  };

 
  	  function batal_keluarga(kode,akun){
swal({
						title: 'Batalkan permohonan ?',
						text: akun,
						type: 'warning',
						buttons:{
							cancel: {
								visible: true,
								text : 'batal',
								className: 'btn btn-danger'
							},        			
							confirm: {
								text : 'Ya',
								className : 'btn btn-success'
							}
						}
					}).then((willDelete) => {
						if (willDelete) {
							swal("data telah batalkan", {
								icon: "success",
								buttons : {
									confirm : {
										className: 'btn btn-success'
									}
								}
							});
							
							  
							var url   = "<?php echo site_url("dpegawai/hapus_permohonan_keluarga");?>";
							var param = {kode:kode,<?php echo $this->m_reff->tokenName()?>:token};
							$.ajax({
									type: "POST",dataType: "json",data: param, url: url,
									success: function(val){
										token=val['token'];
										window.location.href="";
									}
							});	

							
						}  
					});
		    
	  };
 
  	  function batalkan(kode,akun){
swal({
						title: 'Batalkan permohonan ?',
						text: 'anda akan membatalkan permohonan tes',
						type: 'warning',
						buttons:{
							cancel: {
								visible: true,
								text : 'batal',
								className: 'btn btn-danger'
							},        			
							confirm: {
								text : 'Ya',
								className : 'btn btn-success'
							}
						}
					}).then((willDelete) => {
						if (willDelete) {
							swal("data telah batalkan", {
								icon: "success",
								buttons : {
									confirm : {
										className: 'btn btn-success'
									}
								}
							});
							
							  
							var url   = "<?php echo site_url("dpegawai/hapus_permohonan");?>";
							var param = {kode:kode,<?php echo $this->m_reff->tokenName()?>:token};
							$.ajax({
									type: "POST",dataType: "json",data: param, url: url,
									success: function(val){
										token=val['token'];
										window.location.href="";
									}
							});	

							
						}  
					});
		    
	  };

	</script>
	
	<div class="modal effect-flip-vertical" id="mdl_modal" style="z-index:1500" role="dialog">
                <div class="modal-dialog" id="area_modal" role="document">
				 <div id="isi"></div>
				</div>
				</form>
   </div><!-- /.modal-dialog --> 


   	
<div class="modal effect-flip-vertical" id="mdl_modal_kondisi" style="z-index:1500" role="dialog">
                <div class="modal-dialog" id="area_modal_kondisi" role="document">
				 <div id="isi_kondisi"></div>
				</div>
				</form>
   </div><!-- /.modal-dialog --> 


   	
<div class="modal effect-flip-vertical" id="mdl_modal_ket" style="z-index:1500" role="dialog">
                <div class="modal-dialog modal-lg" id="area_modal_ket" role="document">
				 <div id="isi_ket"></div>
				</div>
				</form>
   </div><!-- /.modal-dialog --> 


 







<?php
if(!$mobile){
?>


<script type="text/javascript">
  	 
	   var hasil = "<?php echo $hasil;?>";
	   var save_method; //for save method string
	 var table;
   var  dataTable = $('#table').DataTable({ 
		 "paging": true,
		 "processing": false, //Feature control the processing indicator.
		 "language": {
					  "sSearch": "Pencarian",
					  "processing": ' <span class="sr-only dataTables_processing">Loading...</span> <br><b style="color:black;background:white">Proses menampilkan data<br> Mohon Menunggu..</b>',
						   "oPaginate": {
							 "sFirst": "Hal Pertama",
							 "sLast": "Hal Terakhir",
							  "sNext": "Selanjutnya",
							  "sPrevious": "Sebelumnya"
							  },
						 "sInfo": "Total :  _TOTAL_ , Halaman (_START_ - _END_)",
						  "sInfoEmpty": "Tidak ada data yang di tampilkan",
							"sZeroRecords": "Data tidak tersedia",
						   "lengthMenu": "Tampil _MENU_ Baris",  
					 },
					  
					  
		 "serverSide": true, //Feature control DataTables' server-side processing mode.
		  "responsive": false,
		  "searching": false,
		  "lengthMenu":
		  [[5,10 ,20,30], 
		  [5,10 ,20,30], ], 
	   dom: 'Blfrtip',
		 buttons: [
			// 'copy', 'csv', 'excel', 'pdf', 'print'
	  
		 // {
		 // 	  text: 'Input ',
		 //         action: function ( e, dt, node, config ) {
		 //            download();
		 //         },className: 'btn   btn-outline-success  '
		 //         }, 
	  
					  
					  
		 ],
		 
		 // Load data for the table's content from an Ajax source
		 "ajax": {
			 "url": "<?php echo site_url('dpegawai/getData');?>",
			 "type": "POST",
			 "data": function ( data ) {
				//  data.<?php echo $this->m_reff->tokenName()?>=token;
		  },
			beforeSend: function() {
				loading("area_lod");
			 },
			 complete: function(data) {
			//    token=data.responseJSON.token;
			   unblock('area_lod');
			  if(hasil=="+"){
				 progress(); 
			  }
			 },
			 
		 },
 
		 //Set column definition initialisation properties.
		 "columnDefs": [
		 { 
		   "targets": [ 0,-1,-2,-3], //last column
		   "orderable": false, //set not orderable
		 },
		 ],
	 
	   });
	 function reload_table()
	 {
		  dataTable.ajax.reload(null,false);	
	 };






	 var hasil = "<?php echo $hasil;?>";
	 
<?php
if($jp==1){?>
setTimeout(function(){ 
   var  dataTable2 = $('#table2').DataTable({ 
		 "paging": true,
		 "processing": false, //Feature control the processing indicator.
		 "language": {
					  "sSearch": "Pencarian",
					  "processing": ' <span class="sr-only dataTables_processing">Loading...</span> <br><b style="color:black;background:white">Proses menampilkan data<br> Mohon Menunggu..</b>',
						   "oPaginate": {
							 "sFirst": "Hal Pertama",
							 "sLast": "Hal Terakhir",
							  "sNext": "Selanjutnya",
							  "sPrevious": "Sebelumnya"
							  },
						 "sInfo": "Total :  _TOTAL_ , Halaman (_START_ - _END_)",
						  "sInfoEmpty": "Tidak ada data yang di tampilkan",
							"sZeroRecords": "Data tidak tersedia",
						   "lengthMenu": "Tampil _MENU_ Baris",  
					 },
					  
					  
		 "serverSide": true, //Feature control DataTables' server-side processing mode.
		  "responsive": false,
		  "searching": false,
		  "lengthMenu":
		  [[5,10 ,20,30], 
		  [5,10 ,20,30], ], 
	   dom: 'Blfrtip',
		 buttons: [
			// 'copy', 'csv', 'excel', 'pdf', 'print'
	  
		 // {
		 // 	  text: 'Input ',
		 //         action: function ( e, dt, node, config ) {
		 //            download();
		 //         },className: 'btn   btn-outline-success  '
		 //         }, 
	  
					  
					  
		 ],
		 
		 // Load data for the table's content from an Ajax source
		 "ajax": {
			 "url": "<?php echo site_url('dpegawai/getDataKeluarga');?>",
			 "type": "POST",
			 "data": function ( data ) {
				//  data.<?php echo $this->m_reff->tokenName()?>=token;
		  },
			beforeSend: function() {
				loading("area_lod2");
			 },
			 complete: function(data) {
			//    token=data.responseJSON.token;
			   unblock('area_lod2');
			  if(hasil=="+"){
				 progress(); 
			  }
			 },
			 
		 },
 
		 //Set column definition initialisation properties.
		 "columnDefs": [
		 { 
		   "targets": [ 0,-1,-2,-3], //last column
		   "orderable": false, //set not orderable
		 },
		 ],
	 
	   });

	}, 1000);

	 function reload_table2()
	 {
		  dataTable2.ajax.reload(null,false);	
	 };




<?php  }?>
</script> 

<?php  }?>