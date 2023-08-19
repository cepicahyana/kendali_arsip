<?php
$get_controller = $this->router->fetch_class();
$f = $this->mdl->getByNip($val)->row();


$id_pegawai = $f->id ?? '';
$nip = $f->nip ?? '';
$nip_baru = $f->nip_baru ?? '';

$id_gol = $id_a ?? '';
$i = $this->mdl->getGolonganById($id_gol)->row();
$id_golongan = $i->id ?? '';
$golongan = $i->golongan ?? '';
$masa_kerja = isset($i->masa_kerja) ? date('d/m/Y', strtotime($i->masa_kerja)) : '';
$jenis_kenaikan_pangkat = $i->jenis_kenaikan_pangkat ?? '';
$tmt = isset($i->tmt) ? date('d/m/Y', strtotime($i->tmt)) : '';
$tgl_sk = isset($i->tgl_sk) ? date('d/m/Y', strtotime($i->tgl_sk)) : '';
$no_sk = $i->no_sk ?? '';
$action_url = (empty($id_golongan)) ? '/insert' : '/update';
?>

<div class="modal-content">
	<div class="modal-header">
		<h5 class="modal-titles" id="defaultModalLabel"><b>Edit Data Golongan</b></h5>
		<button type="button" class="close" aria-label="Close" data-dismiss="modal">
			<span aria-hidden="true">×</span>
		</button>
	</div>


	<div class="modal-body">
		<form action="javascript:submitFormN('modal')" id="modal" url="<?php echo site_url($get_controller . $action_url) ?>" method="post">
			<input type="hidden" id="formToken" name="<?php echo $this->m_reff->tokenName() ?>" value="<?php echo $this->m_reff->getToken() ?>">
			<input type="hidden" name="id" value="<?php echo $id_pegawai; ?>">
			<input type="hidden" name="fr" value="e">

			<input type="hidden" name="f[nip_pegawai]" value="<?php echo $nip;?>">
			<input type="hidden" name="id_a" value="<?php echo $id_golongan; ?>">

			<div class="mb-4 main-content-label">Form data Golongan</div>

			<div class="row">
				<div class="col-md-6">
					<div class="form-group">

						<label class="form-label" for="">Golongan</label>
						<?php
						$options = ["" => "-- Pilih --"];
						$dbGol =  $this->db->get("tr_golongan")->result();
						foreach ($dbGol as $r) {
							$options[$r->golongan] = $r->golongan . " - " . $r->pangkat;
						}
						echo form_dropdown("f[golongan]", $options, $golongan, "id='' class='text-black form-control select2'");
						unset($options); ?>

					</div>

					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<label class="form-label" for="">Tmt</label>
								<input name="tmt" class="form-control date-mask" placeholder="DD/MM/YYYY" type="text" value="<?= $tmt ?>">
							</div>
							<div class="col-md-6">
								<label class="form-label" for="">Masa Kerja</label>
								<input name="masa_kerja" class="form-control date-mask" placeholder="DD/MM/YYYY" type="text" value="<?= $masa_kerja ?>">
							</div>
						</div>

					</div>
					<div class="form-group">
						<label class="form-label" for="">Jenis Kenaikan Pangkat</label>
						<input name="f[jenis_kenaikan_pangkat]" id="" type="text" class="form-control" value="<?= $jenis_kenaikan_pangkat; ?>">
					</div>



				</div>
				<div class="col-md-6">


					<div class="form-group">
						<label class="form-label" for="">Tanggal SK</label>
						<input name="tgl_sk" class="form-control date-mask" placeholder="DD/MM/YYYY" type="text" value="<?= $tgl_sk ?>">
					</div>
					<div class="form-group">
						<label class="form-label" for="">No SK</label>
						<input name="f[no_sk]" id="" type="text" class="form-control" value="<?= $no_sk; ?>">
					</div>
					<div class="form-group">
						<label class="form-label" for="">Lampiran</label>
						<input name="file" id="" type="file" class="form-control">
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
		reload_table_inmodal('e');
	});
</script>


<script>   
		  $('[name="masa_kerja"]').daterangepicker({
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
	
	