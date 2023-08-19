<?php
$get_controller = $this->router->fetch_class();
$f = $this->mdl->getByNip($val)->row();


$id_pegawai = $f->id ?? '';
$nip = $f->nip ?? '';
$nip_baru = $f->nip_baru ?? '';

$id_pen = $id_a ?? '';
$i = $this->mdl->getPenghargaanById($id_pen)->row();
$id_penghargaan = $i->id ?? '';
$jenis = $i->jenis ?? '';
$instansi_pemberi = $i->instansi_pemberi ?? '';
$pemberi_penghargaan = $i->pemberi_penghargaan ?? '';
$nomor = $i->nomor ?? '';
$tgl = isset($i->tgl) ? date('d/m/Y', strtotime($i->tgl)) : '';

$action_url = (empty($id_penghargaan)) ? '/insert' : '/update';
?>

<div class="modal-content">
	<div class="modal-header">
		<h5 class="modal-titles" id="defaultModalLabel"><b>Edit Data Penghargaan</b></h5>
		<button type="button" class="close" aria-label="Close" data-dismiss="modal">
			<span aria-hidden="true">×</span>
		</button>
	</div>


	<div class="modal-body">
		<form action="javascript:submitFormN('modal')" id="modal" url="<?php echo site_url($get_controller . $action_url) ?>" method="post">
			<input type="hidden" id="formToken" name="<?php echo $this->m_reff->tokenName() ?>" value="<?php echo $this->m_reff->getToken() ?>">
			<input type="hidden" name="id" value="<?php echo $id_pegawai; ?>">
			<input type="hidden" name="fr" value="i">

			<input type="hidden" name="f[nip_pegawai]" value="<?=$nip?>">
			<input type="hidden" name="id_a" value="<?php echo $id_penghargaan; ?>">

			<div class="mb-4 main-content-label">Form data Penghargaan</div>

			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label class="form-label" for="">Jenis</label>
						<input name="f[jenis]" class="form-control" type="text" value="<?= $jenis ?>">
					</div>
					<div class="form-group">
						<label class="form-label" for="">Tanggal</label>
						<input name="tgl" class="form-control date-mask" placeholder="DD/MM/YYYY" type="text" value="<?= $tgl ?>">
					</div>
					<div class="form-group">
						<label class="form-label" for="">Instansi Pemberi</label>
						<input name="f[instansi_pemberi]" class="form-control" type="text" value="<?= $instansi_pemberi ?>">
					</div>
					

					

				</div>
				<div class="col-md-6">
					
				<div class="form-group">
						<label class="form-label" for="">Pemberi Penghargaan</label>
						<input name="f[pemberi_penghargaan]" class="form-control" type="text" value="<?= $pemberi_penghargaan ?>">
					</div>
					<div class="form-group">
						<label class="form-label" for="">Nomor</label>
						<input name="f[nomor]" class="form-control" type="text" value="<?= $nomor ?>">
					</div>
					<div class="form-group">
						<label class="form-label" for="">File Lampiran</label>
						<input name="file" class="form-control" type="file" value="">
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
		reload_table_inmodal('i');
	});
</script>



<script>   
		  $('[name="tgl"]').daterangepicker({
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
	
	
	 