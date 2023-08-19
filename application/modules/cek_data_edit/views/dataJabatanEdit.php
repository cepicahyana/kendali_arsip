<?php
$get_controller = $this->router->fetch_class();
$f = $this->mdl->getByNip($val)->row();


$id_pegawai = $f->id ?? '';
$nip = $f->nip ?? '';
$nip_baru = $f->nip_baru ?? '';

$id_jab = $id_a ?? '';
$i = $this->mdl->getJabatanById($id_jab)->row();
$id_jabatan = $i->id ?? '';
$jenis = $i->jenis ?? '';
$grade = $i->grade ?? '';
$nama = $i->nama ?? '';
$tmt = isset($i->tmt) ? date('d/m/Y', strtotime($i->tmt)) : '';

$no_sk_jabatan = $i->no_sk_jabatan ?? '';
$tgl_sk_jabatan = isset($i->tgl_sk_jabatan) ? date('d/m/Y', strtotime($i->tgl_sk_jabatan)) : '';

$tgl_sk_eselon = isset($i->tgl_sk_eselon) ? date('d/m/Y', strtotime($i->tgl_sk_eselon)) : '';
$no_sk_eselon = $i->no_sk_eselon ?? '';

$action_url = (empty($id_jabatan)) ? '/insert' : '/update';
?>

<div class="modal-content">
	<div class="modal-header">
		<h5 class="modal-titles" id="defaultModalLabel"><b>Edit Data Jabatan</b></h5>
		<button type="button" class="close" aria-label="Close" data-dismiss="modal">
			<span aria-hidden="true">×</span>
		</button>
	</div>


	<div class="modal-body">
		<form action="javascript:submitFormN('modal')" id="modal" url="<?php echo site_url($get_controller . $action_url) ?>" method="post">
			<input type="hidden" id="formToken" name="<?php echo $this->m_reff->tokenName() ?>" value="<?php echo $this->m_reff->getToken() ?>">
			<input type="hidden" name="id" value="<?php echo $id_pegawai; ?>">
			<input type="hidden" name="fr" value="f">

			<input type="hidden" name="f[nip_pegawai]" value="<?=$nip?>">
			<input type="hidden" name="id_a" value="<?php echo $id_jabatan; ?>">

			<div class="mb-4 main-content-label">Form data Jabatan</div>

			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label class="form-label" for="">Jenis Jabatan</label>
						<input name="f[jenis]" class="form-control" type="text" value="<?= $jenis ?>">
					</div>

					<div class="form-group">
						<label class="form-label" for="">Nama Jabatan</label>
						<input name="f[nama]" class="form-control" type="text" value="<?= $nama ?>">
					</div>

					<div class="form-group">
						<label class="form-label" for="">Grade</label>
						<input name="f[grade]" class="form-control" type="text" value="<?= $grade ?>">
					</div>


				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label class="form-label" for="">TMT</label>
						<input name="tmt" class="form-control date-mask" placeholder="DD/MM/YYYY" type="text" value="<?= $tmt ?>">
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<label class="form-label" for="">Tanggal SK Jabatan</label>
								<input name="tgl_sk_jabatan" class="form-control date-mask" placeholder="DD/MM/YYYY" type="text" value="<?= $tgl_sk_jabatan ?>">
							</div>
							<div class="col-md-6">
								<label class="form-label" for="">No SK Jabatan</label>
								<input name="f[no_sk_jabatan]" id="" type="text" class="form-control" value="<?= $no_sk_jabatan; ?>">
							</div>
						</div>
					</div>


					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<label class="form-label" for="">Tanggal SK Eselon</label>
								<input name="tgl_sk_eselon" class="form-control date-mask" placeholder="DD/MM/YYYY" type="text" value="<?= $tgl_sk_eselon ?>">
							</div>
							<div class="col-md-6">
								<label class="form-label" for="">No SK Eselon</label>
								<input name="f[no_sk_eselon]" id="" type="text" class="form-control" value="<?= $no_sk_eselon; ?>">
							</div>
						</div>
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
		reload_table_inmodal('f');
	});
</script>



<script>   
		  $('[name="tgl_sk_jabatan"]').daterangepicker({
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
	
	
<script>   
		  $('[name="tgl_sk_eselon"]').daterangepicker({
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
	
	
<script>   
		  $('[name="tmt"]').daterangepicker({
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
	
	