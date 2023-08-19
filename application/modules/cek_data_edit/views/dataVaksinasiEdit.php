<?php
$get_controller = $this->router->fetch_class();
$f = $this->mdl->getByNip($val)->row();


$id_pegawai = $f->id ?? '';
$nip = $f->nip ?? '';
$nip_baru = $f->nip_baru ?? '';

$id_pen = $id_a ?? '';
$i = $this->mdl->getVaksinasiById($id_pen)->row();
$id_vaksinasi = $i->id ?? '';
$jenis_vaksin = $i->jenis_vaksin ?? '';
$tgl_vaksin = isset($i->tgl_vaksin) ? date('d/m/Y', strtotime($i->tgl_vaksin)) : '';
$ket = $i->ket ?? '';

$action_url = (empty($id_vaksinasi)) ? '/insert' : '/update';
?>

<div class="modal-content">
	<div class="modal-header">
		<h5 class="modal-titles" id="defaultModalLabel"><b>Edit Data Vaksinasi</b></h5>
		<button type="button" class="close" aria-label="Close" data-dismiss="modal">
			<span aria-hidden="true">×</span>
		</button>
	</div>


	<div class="modal-body">
		<form action="javascript:submitFormN('modal')" id="modal" url="<?php echo site_url($get_controller . $action_url) ?>" method="post">
			<input type="hidden" id="formToken" name="<?php echo $this->m_reff->tokenName() ?>" value="<?php echo $this->m_reff->getToken() ?>">
			<input type="hidden" name="id" value="<?php echo $id_pegawai; ?>">
			<input type="hidden" name="fr" value="n">

			<input type="hidden" name="f[nip_pegawai]" value="<?=$nip?>">
			<input type="hidden" name="id_a" value="<?php echo $id_vaksinasi; ?>">

			<div class="mb-4 main-content-label">Form data Vaksinasi</div>

			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="form-label" for="">Jenis vaksin</label>
						<input name="f[jenis_vaksin]" class="form-control" type="text" value="<?= $jenis_vaksin ?>">
					</div>
					<div class="form-group">
						<label class="form-label" for="">Tanggal vaksin</label>
						<input name="tgl_vaksin" class="form-control date-mask" placeholder="DD/MM/YYYY" type="text" value="<?= $tgl_vaksin ?>">
					</div>

					<div class="form-group">
						<label class="form-label" for="">Ket</label>
						<input name="f[ket]" class="form-control" type="text" value="<?= $ket ?>">
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
		reload_table_inmodal('n');
	});
</script>



<script>   
		  $('[name="tgl_vaksin"]').daterangepicker({
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
	