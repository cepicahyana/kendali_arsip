<?php
$get_controller = $this->router->fetch_class();
$f = $this->mdl->getByNip($val)->row();


$id_pegawai = $f->id ?? '';
$nip = $f->nip ?? '';
$nip_baru = $f->nip_baru ?? '';

$id_pen = $id_a ?? '';
$i = $this->mdl->getPelatihanById($id_pen)->row();
$id_pelatihan = $i->id ?? '';
$jenis_pelatihan = $i->jenis_pelatihan ?? '';
$tgl_pelaksanaan = isset($i->tgl_pelaksanaan) ? date('d/m/Y', strtotime($i->tgl_pelaksanaan)) : '';
$nama_pelatihan = $i->nama_pelatihan ?? '';
$lama_pelatihan = $i->lama_pelatihan ?? '';
$instansi_penyelenggara = $i->instansi_penyelenggara ?? '';
$no_sertifikat = $i->no_sertifikat ?? '';
$file_sertifikat = $i->file_sertifikat ?? '';

$action_url = (empty($id_pelatihan)) ? '/insert' : '/update';
?>

<div class="modal-content">
	<div class="modal-header">
		<h5 class="modal-titles" id="defaultModalLabel"><b>Edit Data Pelatihan</b></h5>
		<button type="button" class="close" aria-label="Close" data-dismiss="modal">
			<span aria-hidden="true">×</span>
		</button>
	</div>


	<div class="modal-body">
		<form action="javascript:submitFormN('modal')" id="modal" url="<?php echo site_url($get_controller . $action_url) ?>" method="post">
			<input type="hidden" id="formToken" name="<?php echo $this->m_reff->tokenName() ?>" value="<?php echo $this->m_reff->getToken() ?>">
			<input type="hidden" name="id" value="<?php echo $id_pegawai; ?>">
			<input type="hidden" name="fr" value="p">

			<input type="hidden" name="f[nip_pegawai]" value="<?=$nip?>">
			<input type="hidden" name="id_a" value="<?php echo $id_pelatihan; ?>">

			<div class="mb-4 main-content-label">Form data Pelatihan</div>

			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label class="form-label" for="">Jenis pelatihan</label>
						<input name="f[jenis_pelatihan]" class="form-control" type="text" value="<?= $jenis_pelatihan ?>">
					</div>
					<div class="form-group">
						<label class="form-label" for="">Nama Pelatihan</label>
						<input name="f[nama_pelatihan]" class="form-control" type="text" value="<?= $nama_pelatihan ?>">
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<label class="form-label" for="">Tanggal Pelaksanaan</label>
								<input name="tgl_pelaksanaan" class="form-control date-mask" placeholder="DD/MM/YYYY" type="text" value="<?= $tgl_pelaksanaan ?>">
							</div>
							<div class="col-md-6">
								<label class="form-label" for="">Lama Pelatihan</label>
								<input name="f[lama_pelatihan]" class="form-control" type="text" value="<?= $lama_pelatihan ?>">
							</div>
						</div>

					</div>


				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label class="form-label" for="">Instansi penyelenggara</label>
						<input name="f[instansi_penyelenggara]" class="form-control" type="text" value="<?= $instansi_penyelenggara ?>">
					</div>
					<div class="form-group">
						<label class="form-label" for="">Nomor sertifikat</label>
						<input name="f[no_sertifikat]" class="form-control" type="text" value="<?= $no_sertifikat ?>">
					</div>
					<div class="form-group">
						<label class="form-label" for="">File Sertifikat</label>
						<input name="file_sertifikat" class="form-control" type="file">
					</div>

				</div>

				<div class="col-lg-12 p-1">
					<center>
						<a href="#" class="btn btn-light" onclick="resetFormN()"> reset </a>
						<button class="btn btn-success button_save" onclick="submitFormN('modal')"><i class="fa fa-save"></i> simpan</button>
					</center>
				</div>
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
		reload_table_inmodal('p');
	});
</script>
<script>   
		  $('[name="tgl_pelaksanaan"]').daterangepicker({
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
		"drops": "up"
	});</script>
	
	