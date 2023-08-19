<?php
$get_controller = $this->router->fetch_class();
$f = $this->mdl->getByNip($val)->row();


$id_pegawai = $f->id ?? '';
$nip = $f->nip ?? '';
$nip_baru = $f->nip_baru ?? '';

$id_pen = $id_a ?? '';
$i = $this->mdl->getPenugasanById($id_pen)->row();
$id_penugasan = $i->id ?? '';
$nama_penjab = $i->nama_penjab ?? '';
$penjab_lainnya = $i->penjab_lainnya ?? '';

$tmt = isset($i->tmt) ? date('d/m/Y', strtotime($i->tmt)) : '';
$tgl_sk = isset($i->tgl_sk) ? date('d/m/Y', strtotime($i->tgl_sk)) : '';
$no_sk = $i->no_sk ?? '';
$masa_berlaku = isset($i->masa_berlaku) ? date('d/m/Y', strtotime($i->masa_berlaku)) : '';


$action_url = (empty($id_penugasan)) ? '/insert' : '/update';
?>

<div class="modal-content">
	<div class="modal-header">
		<h5 class="modal-titles" id="defaultModalLabel"><b>Edit Data Penugasan</b></h5>
		<button type="button" class="close" aria-label="Close" data-dismiss="modal">
			<span aria-hidden="true">×</span>
		</button>
	</div>


	<div class="modal-body">
		<form action="javascript:submitFormN('modal')" id="modal" url="<?php echo site_url($get_controller . $action_url) ?>" method="post">
			<input type="hidden" id="formToken" name="<?php echo $this->m_reff->tokenName() ?>" value="<?php echo $this->m_reff->getToken() ?>">
			<input type="hidden" name="id" value="<?php echo $id_pegawai; ?>">
			<input type="hidden" name="fr" value="g">

			<input type="hidden" name="f[nip_pegawai]" value="<?=$nip?>">
			<input type="hidden" name="id_a" value="<?php echo $id_penugasan; ?>">

			<div class="mb-4 main-content-label">Form data Penugasan</div>

			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label class="form-label" for="">Nama Jabatan</label>
						<input name="f[nama_penjab]" class="form-control" type="text" value="<?= $nama_penjab ?>">
					</div>
					<div class="form-group">
						<label class="form-label" for="">Penugasan Jabatan Lainnya</label>
						<input name="f[penjab_lainnya]" class="form-control" type="text" value="<?= $penjab_lainnya ?>">
					</div>

					<div class="form-group">
						<label class="form-label" for="">TMT</label>
						<input name="tmt" class="form-control date-mask" placeholder="DD/MM/YYYY" type="text" value="<?= $tmt ?>">
					</div>

				</div>
				<div class="col-md-6">
					
					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<label class="form-label" for="">Tanggal SK</label>
								<input name="tgl_sk" class="form-control date-mask" placeholder="DD/MM/YYYY" type="text" value="<?= $tgl_sk ?>">
							</div>
							<div class="col-md-6">
								<label class="form-label" for="">No SK</label>
								<input name="f[no_sk]" id="" type="text" class="form-control" value="<?= $no_sk; ?>">
							</div>
						</div>
					</div>


					<div class="form-group">
						<label class="form-label" for="">Masa Berlaku</label>
						<input name="masa_berlaku" class="form-control date-mask" placeholder="DD/MM/YYYY" type="text" value="<?= $masa_berlaku ?>">
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
		reload_table_inmodal('g');
	});
</script>


<script>   
		  $('[name="tgl_sk"]').daterangepicker({
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
		  $('[name="masa_berlaku"]').daterangepicker({
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
	
	