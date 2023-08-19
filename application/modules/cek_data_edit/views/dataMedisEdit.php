<?php
$get_controller = $this->router->fetch_class();
$f = $this->mdl->getByNip($val)->row();


$id_pegawai = $f->id ?? '';
$nip = $f->nip ?? '';
$nip_baru = $f->nip_baru ?? '';

$id_pen = $id_a ?? '';
$i = $this->mdl->getMedisById($id_pen)->row();
$id_medis = $i->id ?? '';
$kesimpulan = $i->kesimpulan ?? '';
$saran = $i->saran ?? '';
$tgl_mcu = $i->tgl_mcu ?? '';

$tgl_mcu = $this->tanggal->ind($tgl_mcu,"/");


$action_url = (empty($id_medis)) ? '/insert' : '/update';
?>

<div class="modal-content">
	<div class="modal-header">
		<h5 class="modal-titles" id="defaultModalLabel"><b> Data Medis</b></h5>
		<button type="button" class="close" aria-label="Close" data-dismiss="modal">
			<span aria-hidden="true">×</span>
		</button>
	</div>


	<div class="modal-body">
		<form action="javascript:submitFormN('modal')" id="modal" url="<?php echo site_url($get_controller . $action_url) ?>" method="post">
			<input type="hidden" id="formToken" name="<?php echo $this->m_reff->tokenName() ?>" value="<?php echo $this->m_reff->getToken() ?>">
			<input type="hidden" name="id" value="<?php echo $id_pegawai; ?>">
			<input type="hidden" name="fr" value="k">

			<input type="hidden" name="f[nip_pegawai]" value="<?=$nip ?>">
			<input type="hidden" name="id_a" value="<?php echo $id_medis; ?>">

			<!-- <div class="mb-4 main-content-labeld">Form data Medis</div> -->

			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<div class="row">
							
							<div class="col-md-3">
								<label class="form-label" for="">Tgl MCU</label>
								<input name="tgl_mcu" id="" type="text" class="form-control" value="<?= $tgl_mcu; ?>">
							</div>
							<div class="col-md-9">
								<label class="form-label" for="">Kesimpulan</label>
								<input name="f[kesimpulan]" id="" type="text" class="form-control" value="<?= $kesimpulan; ?>">
							</div>
							<div class="row clear col-md-12"> &nbsp;</div>
							<div class="col-md-3">
								<label class="form-label" for="">Upload hasil MCU</label>
								<input name="file_hasil_mcu" id="" type="file" class="form-control">
							</div>
							<div class="col-md-9">
								<label class="form-label" for="">Saran tindak lanjut</label>
								<input name="f[saran]" id="" type="text" class="form-control" value="<?= $saran; ?>">
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
		reload_table_inmodal('k');
	});
</script>



<script>   
		  $('[name="tgl_mcu"]').daterangepicker({
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