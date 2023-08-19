<?php
$get_controller = $this->router->fetch_class();
$f = $this->mdl->getByNip($val)->row();


$id_pegawai = $f->id ?? '';
$nip = $f->nip ?? '';
$nip_baru = $f->nip_baru ?? '';
$jenisk = $f->jk ?? '';

 $file_kk = $f->file_kk ?? '';
 $file_bpjs = $f->file_bpjs ?? '';

$id_kelu = $id_a ?? '';
$i = $this->mdl->getKeluargaById($id_kelu)->row();
$id_keluarga = $i->id ?? '';
$sts_hubungan = $i->sts_hubungan ?? '';
$id_hubungan = $i->id_hubungan ?? '';
$sts_hidup = $i->sts_hidup ?? '';
$pekerjaan = $i->pekerjaan ?? '';
$bpjs = $i->bpjs ?? '';
$nama = $i->nama ?? '';
$nik = $i->nik ?? '';
$jk = $i->jk ?? '';
$tempat_lahir = $i->tempat_lahir ?? '';
$tgl_lahir = isset($i->tgl_lahir) ? date('d/m/Y', strtotime($i->tgl_lahir)) : '';

$action_url = (empty($id_keluarga)) ? '/insert' : '/update';
?>

<div class="modal-content">
	<div class="modal-header">
		<h5 class="modal-titles" id="defaultModalLabel"><b>Edit Data Keluarga</b></h5>
		<button type="button" class="close" aria-label="Close" data-dismiss="modal">
			<span aria-hidden="true">×</span>
		</button>
	</div>


	<div class="modal-body">
		<form action="javascript:submitFormKel('modal')" id="modal" url="<?php echo site_url($get_controller . $action_url) ?>" method="post">
			<input type="hidden" id="formToken" name="<?php echo $this->m_reff->tokenName() ?>" value="<?php echo $this->m_reff->getToken() ?>">
			<input type="hidden" name="id" value="<?php echo $id_pegawai; ?>">
			<input type="hidden" name="fr" value="c">

			<input type="hidden" name="f[nip_pegawai]" value="<?=$nip?>">
			<input type="hidden" name="id_a" value="<?php echo $id_keluarga; ?>">

			<div class="mb-4 main-content-label">Form data keluarga</div>

			<div class="row alert alert-info">
				<div class="col-md-6">
					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<label class="form-label" for="">Hubungan Keluarga</label>
								<?php
							 
							 	if($f->jk=="l"){
									$jeka = "nama_p";
								 }else{
									$jeka = "nama_l"; 
								 }
							
								if($jenisk=='p'){
									$options = ["" => "-- Pilih --"];
									$dbHub =  $this->db->get("tr_hubungan")->result();
									foreach ($dbHub as $r) {
										$options[$r->id] = $r->$jeka;
									}
									echo form_dropdown("f[id_hubungan]", $options, $id_hubungan, "id='' class='text-black form-control select2'");
									unset($options);
								}
								if($jenisk=='l'){
									$options = ["" => "-- Pilih --"];
									$dbHub =  $this->db->get("tr_hubungan")->result();
									foreach ($dbHub as $r) {
										$options[$r->id] = $r->nama_l;
									}
									echo form_dropdown("f[id_hubungan]", $options, $id_hubungan, "id='' class='text-black form-control select2'");
									unset($options);
								}
								 
								?>
							</div>
							<div class="col-md-6">
								<label class="form-label" for="">Status Hubungan</label>
								<?php
								$options = ["" => "-- Pilih --"];
								$dbsHub =  $this->db->get("tr_sts_hubungan")->result();
								foreach ($dbsHub as $r) {
									$options[$r->nama] = $r->nama;
								}
								echo form_dropdown("f[sts_hubungan]", $options, $sts_hubungan, "id='' class='text-black form-control select2'");
								unset($options); ?>
							</div>
						</div>
					</div>
					<input name="f[nip_pegawai]" id="" type="hidden" class="form-control" value="<?=$val;?>" required>
					<div class="form-group">
						<label class="form-label" for="">Nama</label>
						<input name="f[nama]" id="" type="text" class="form-control" value="<?= $nama; ?>" required>
					</div>
					<div class="form-group">
						<label class="form-label" for="">NIK</label>
						<input name="f[nik]" id="" type="text" class="form-control" value="<?= $nik; ?>" required>
					</div>
					<div class="form-group">
						<label class="form-label" for="jk">Jenis Kelamin</label>
						<div class="row">
							<div class="col-md-6">
								<label class="rdiobox"><input name="f[jk]" value="l" type="radio" <?= ($jk == 'l') ? 'checked' : ''; ?>> <span>Laki-Laki</span></label>
							</div>
							<div class="col-md-6">
								<label class="rdiobox"><input name="f[jk]" value="p" type="radio" <?= ($jk == 'p') ? 'checked' : ''; ?>> <span>Perempuan</span></label>
							</div>
						</div>
					</div>

				</div>
				<div class="col-md-6">

					<div class="form-group">
						<label class="form-label" for="pob">Tempat, Tanggal Lahir</label>
						<div class="row">
							<div class="col-md-6">
								<input name="f[tempat_lahir]" id="pob" type="text" class="form-control" placeholder="Tempat Lahir" value="<?= set_value('f[tempat_lahir]', $tempat_lahir); ?>">
							</div>
							<div class="col-md-6">
								<input name="tgl_lahir" class="form-control date-mask" placeholder="DD/MM/YYYY" type="text" value="<?= set_value('f[tgl_lahir]', $tgl_lahir); ?>">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="form-label" for="">Pekerjaan</label>
						<?php
						$options = ["" => "-- Pilih Pekerjaan --"];
						$dbPek =  $this->db->get("tr_pekerjaan")->result();
						foreach ($dbPek as $r) {
							$options[$r->nama] = $r->nama;
						}
						echo form_dropdown("f[pekerjaan]", $options, $pekerjaan, "id='' class='text-black form-control select2'");
						unset($options); ?>
					</div>
					<div class="form-group">
						<label class="form-label" for="">No BPJS</label>
						<input name="f[bpjs]" id="" type="text" class="form-control" value="<?= $bpjs; ?>">
					</div>
					<div class="form-group">
						<label class="form-label" for="sts_hidup">Status</label>
						<div class="row">
							<div class="col-md-6">
								<label class="rdiobox"><input name="f[sts_hidup]" value="1" type="radio" <?= ($sts_hidup == '1') ? 'checked' : ''; ?>> <span>Hidup</span></label>
							</div>
							<div class="col-md-6">
								<label class="rdiobox"><input name="f[sts_hidup]" value="0" type="radio" <?= ($sts_hidup == '0') ? 'checked' : ''; ?>> <span>Meninggal</span></label>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-12 p-1">
					<center>
						<a href="#" class="btn btn-light" onclick="resetFormN()"> reset </a>
						<button class="btn btn-success button_save" onclick="submitFormKel('modal')"><i class="fa fa-save"></i> simpan</button>
					</center>
				</div>
			</div>

		</form>
		<hr>


		<form class="alert alert-success" action="javascript:submitFormUpload('modalkel')" id="modalkel" url="<?php echo site_url("cek_data_edit/upload_keluarga") ?>" method="post">
			<input type="hidden" id="formToken" name="<?php echo $this->m_reff->tokenName() ?>" value="<?php echo $this->m_reff->getToken() ?>">
			<input type="hidden" name="id" value="<?php echo $id_pegawai; ?>">
			<input type="hidden" name="fr" value="c">

			<input type="hidden" name="nip" value="<?=$nip?>">
		
 <?php
 if($file_kk){
	$file  =  $this->m_reff->encrypt($file_kk);
	$down =  ' <a  href="'.base_url().'download?f='.$file.'" class="text-info  "><i class="fa fa-file"></i> Download</a>';
	
	$text_kk = "<span class='text-primary'>Upload ulang file kartu keluarga (KK)</span> | ".$down;
 }else{
	$text_kk = "Upload file kartu keluarga (KK)";
 }

 if($file_bpjs){
	$file  =  $this->m_reff->encrypt($file_bpjs);
	$down = ' <a  href="'.base_url().'download?f='.$file.'" class="text-info  "><i class="fa fa-file"></i> Download</a>';
	 
	$text_bpjs = "<span class='text-primary'>Upload ulang file kartu keluarga (KK)</span> | ".$down;
 }else{
	$text_bpjs = "Upload file kartu keluarga (KK)";
 }


 ?>

 

 
					<div class="form-group">
						<label class="form-label" for=""><?=$text_kk;?></label>
						<input name="file_kk" id="" type="file" class="form-control"  >
					</div>
					<div class="form-group">
						<label class="form-label" for=""><?=$text_bpjs;?></label>
						<input name="file_bpjs" id="" type="file" class="form-control"  >
					</div>
		 
				<div class="col-lg-12 p-1">
					<center>
						<button class="btn btn-success button_save" onclick="submitFormUpload('modalkel')"><i class="fa fa-save"></i> simpan</button>
					</center>
				</div>
		 

		</form>






		<div class="row">
			<div class="col-md-12">
				<hr>
				<div id="area_table"></div>
			</div>
		</div>
	</div>
</div>

<script>
	$(function() {
		reload_table_inmodal('c');
	});
	function reload_table(){
		setTimeout(() => {
			// tab(`<?=base_url()?>cek_data/tab_keluarga`);	
			search();
		}, 500);
	}
function submitFormUpload(id){
		var form = $("#"+id);
		var link = $(form).attr("url");
        var fr = $('[name="fr"]').val();
        var id_a = $('[name="id_a"]').val();
        $(form).ajaxForm({
             type: "POST",
             dataType: "json",
             data: $(form).serialize(),
             url: link,
             beforeSend: function() {
			    loading("area_"+id);
		    },
             success: function(data) {
                token = data["token"];
                $("#formToken").val(data["token"]);
                unblock("area_"+id); 	
                // search();
                if(data["gagal"]==true)
                {	  
                    notif("<font color='black'>"+data["info"]+"</font>");
                } else{
                   
                    swal("success", {
                        icon: "success",
                        buttons : {
                            confirm : {
                                className: 'btn btn-success'
                            }
                        }
                    });
                    if(id_a==""){
                        resetFormN()
                    }
                    reload_table_inmodal(fr);
                   
                }
             }
         });
	}

	
function submitFormKel(id){
		var form = $("#"+id);
		var link = $(form).attr("url");
        var fr = $('[name="fr"]').val();
        var id_a = $('[name="id_a"]').val();
        $(form).ajaxForm({
             type: "POST",
             dataType: "json",
             data: $(form).serialize(),
             url: link,
             beforeSend: function() {
			    loading("area_"+id);
		    },
             success: function(data) {
                token = data["token"];
                $("#formToken").val(data["token"]);
                unblock("area_"+id); 	
                // search();
                if(data["gagal"]==true)
                {	  
                    notif("<font color='black'>"+data["info"]+"</font>");
                } else{
                   
                    swal("success", {
                        icon: "success",
                        buttons : {
                            confirm : {
                                className: 'btn btn-success'
                            }
                        }
                    });
                    // if(id_a==""){
                        resetFormN()
                    // }
                    reload_table_inmodal(fr);
                   
                }
				
             }
         });
	}
</script>



<script>   
		  $('[name="tgl_lahir"]').daterangepicker({
		"singleDatePicker": true,
		"showDropdowns": true,
		"autoApply": true,
		"locale": {
			"format": "DD/MM/YYYY",
			"separator": " - ",
			"applyLabel": "Apply",
			"cancelLabel": "Cancel",
			"fromLabel": "From",
			"toLabel": "To",
			"customRangeLabel": "Custom",
			"weekLabel": "W",
			"daysOfWeek": [
				"Min",
				"Sen",
				"Sel",
				"Rab",
				"Kam",
				"Jum",
				"Sab"
			],
			"monthNames": [
				"Januari",
				"Februari",
				"Maret",
				"April",
				"Mei",
				"Juni",
				"Juli",
				"Augustus",
				"September",
				"October",
				"November",
				"Desember"
			],
			"firstDay": 1
		},
		 
		"opens": "center",
		"drops": "down"
	});</script>
	
	