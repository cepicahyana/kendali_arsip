<?php
$get_controller = $this->router->fetch_class();
$f = $this->mdl->getByNip($val)->row();


$id_pegawai = $f->id ?? '';
$nip = $f->nip ?? '';
$nip_baru = $f->nip_baru ?? '';

$id_pen = $id_a ?? '';
$i = $this->mdl->getGajiById($id_pen)->row();
$id_gaji = $i->id ?? '';
$golongan = $i->golongan ?? '';
$tmt = isset($i->tmt) ? date('d/m/Y', strtotime($i->tmt)) : '';
$no_sk = $i->no_sk ?? '';
$mk_gol_tahun = $i->mk_gol_tahun ?? '';
$mk_gol_bulan = $i->mk_gol_bulan ?? '';
$gapok_lama = $i->gapok_lama ?? '';
$gapok_baru = $i->gapok_baru ?? '';
$ket = $i->ket ?? '';
$action_url = (empty($id_gaji)) ? '/insert' : '/update';
?>

<div class="modal-content">
	<div class="modal-header">
		<h5 class="modal-titles" id="defaultModalLabel"><b>Edit Data Gaji</b></h5>
		<button type="button" class="close" aria-label="Close" data-dismiss="modal">
			<span aria-hidden="true">×</span>
		</button>
	</div>


	<div class="modal-body">
		<form action="javascript:submitFormN('modal')" id="modal" url="<?php echo site_url($get_controller . $action_url) ?>" method="post">
			<input type="hidden" id="formToken" name="<?php echo $this->m_reff->tokenName() ?>" value="<?php echo $this->m_reff->getToken() ?>">
			<input type="hidden" name="id" value="<?php echo $id_pegawai; ?>">
			<input type="hidden" name="fr" value="l">

			<input type="hidden" name="f[nip_pegawai]" value="<?=$nip?>">
			<input type="hidden" name="id_a" value="<?php echo $id_gaji; ?>">

			<div class="mb-4 main-content-label">Form data Gaji</div>

			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label class="form-label" for="">Golongan</label>
						<?php
						$options = ["" => "-- Pilih --"];
						$dbGol =  $this->db->get("tr_golongan")->result();
						foreach ($dbGol as $r) {
							$options[$r->golongan] = $r->golongan;
						}
						echo form_dropdown("f[golongan]", $options, $golongan, "id='' class='text-black form-control select2'");
						unset($options); ?>
					</div>
					<div class="form-group">
						<label class="form-label" for="">TMT</label>
						<input name="tmt" class="form-control date-mask" placeholder="DD/MM/YYYY" type="text" value="<?= $tmt ?>">
					</div>
					<div class="form-group">
						<label class="form-label" for="">Nomor SK</label>
						<input name="f[no_sk]" class="form-control" type="text" value="<?= $no_sk ?>">
					</div>
					<div class="form-group">
						<label class="form-label" for="">Ket</label>
						<input name="f[ket]" class="form-control" type="text" value="<?= $ket ?>">
					</div>




				</div>
				<div class="col-md-6">

					<div class="form-group">
						<label class="form-label" for="">MK Golongan Tahun</label>
						<input name="f[mk_gol_tahun]" class="form-control" type="text" value="<?= $mk_gol_tahun ?>">
					</div>
					<div class="form-group">
						<label class="form-label" for="">MK Golongan Bulan</label>
						<input name="f[mk_gol_bulan]" class="form-control" type="text" value="<?= $mk_gol_bulan ?>">
					</div>
					<div class="form-group">
						<label class="form-label" for="">Gaji Pokok Lama</label>
						<input name="f[gapok_lama]" class="form-control" type="text" value="<?= $gapok_lama ?>">
					</div>
					<div class="form-group">
						<label class="form-label" for="">Gaji Pokok Baru</label>
						<input name="f[gapok_baru]" class="form-control" type="text" value="<?= $gapok_baru ?>">
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
		reload_table_inmodal('l');
	});
</script>



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
	
	