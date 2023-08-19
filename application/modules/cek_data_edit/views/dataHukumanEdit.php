<?php
$get_controller = $this->router->fetch_class();
$f = $this->mdl->getByNip($val)->row();


$id_pegawai = $f->id ?? '';
$nip = $f->nip ?? '';
$nip_baru = $f->nip_baru ?? '';

$id_pen = $id_a ?? '';
$i = $this->mdl->getHukumanById($id_pen)->row();
$id_hukuman = $i->id ?? '';
$jenis_hukuman = $i->jenis_hukuman ?? '';
$no_sk = $i->no_sk ?? '';
$tmt_akhir = isset($i->tmt_akhir) ? date('d/m/Y', strtotime($i->tmt_akhir)) : '';
$masa_berlaku = isset($i->masa_berlaku) ? date('d/m/Y', strtotime($i->masa_berlaku)) : '';
$no_pp = $i->no_pp ?? '';
$potongan = $i->potongan ?? '';
$pelanggaran = $i->pelanggaran ?? '';
$file = $i->file ?? '';

$action_url = (empty($id_hukuman)) ? '/insert' : '/update';
?>

<div class="modal-content">
	<div class="modal-header">
		<h5 class="modal-titles" id="defaultModalLabel"><b>Edit Data Hukuman</b></h5>
		<button type="button" class="close" aria-label="Close" data-dismiss="modal">
			<span aria-hidden="true">×</span>
		</button>
	</div>


	<div class="modal-body">
		<form action="javascript:submitFormN('modal')" id="modal" url="<?php echo site_url($get_controller . $action_url) ?>" method="post">
			<input type="hidden" id="formToken" name="<?php echo $this->m_reff->tokenName() ?>" value="<?php echo $this->m_reff->getToken() ?>">
			<input type="hidden" name="id" value="<?php echo $id_pegawai; ?>">
			<input type="hidden" name="fr" value="m">

			<input type="hidden" name="f[nip_pegawai]" value="<?=$nip ?>">
			<input type="hidden" name="id_a" value="<?php echo $id_hukuman; ?>">

			<div class="mb-4 main-content-label">Form data Hukuman</div>

			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label class="form-label" for="">Jenis hukuman</label>
						<input name="f[jenis_hukuman]" class="form-control" type="text" value="<?= $jenis_hukuman ?>">
					</div>
					<div class="form-group">
						<label class="form-label" for="">Nomor SK</label>
						<input name="f[no_sk]" class="form-control" type="text" value="<?= $no_sk ?>">
					</div>


					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<label class="form-label" for="">TMT akhir</label>
								<input name="tmt_akhir" class="form-control date-mask" placeholder="DD/MM/YYYY" type="text" value="<?= $tmt_akhir ?>">
							</div>
							<div class="col-md-6">
								<label class="form-label" for="">Masa Berlaku</label>
								<input name="masa_berlaku" class="form-control date-mask" placeholder="DD/MM/YYYY" type="text" value="<?= $masa_berlaku ?>">
							</div>
						</div>
					</div>

				</div>
				<div class="col-md-6">

					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<label class="form-label" for="">No PP</label>
								<input name="f[no_pp]" class="form-control" type="text" value="<?= $no_pp ?>">
							</div>
							<div class="col-md-6">
								<label class="form-label" for="">Potongan</label>
								<input name="f[potongan]" class="form-control" type="text" value="<?= $potongan ?>">
							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="form-label" for="">Pelanggaran</label>
						<input name="f[pelanggaran]" class="form-control" type="text" value="<?= $pelanggaran ?>">
					</div>

					<div class="form-group">
						<label class="form-label" for="">Lampiran</label>
						<input name="file" class="form-control" type="file">
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
		reload_table_inmodal('m');
	});
</script>



<script>   
		  $('[name="tmt_akhir"]').daterangepicker({
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
	
	