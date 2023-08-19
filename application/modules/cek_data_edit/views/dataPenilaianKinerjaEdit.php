<?php
$get_controller = $this->router->fetch_class();
$f = $this->mdl->getByNip($val)->row();


$id_pegawai = $f->id ?? '';
$nip = $f->nip ?? '';
$nip_baru = $f->nip_baru ?? '';

$id_pen = $id_a ?? '';
$i = $this->mdl->getPenilaiankinerjaById($id_pen)->row();
$id_penilaiankinerja = $i->id ?? '';
$tahun = $i->tahun ?? '';
$nilai = $i->nilai ?? '';
$pejabat_penilai = $i->pejabat_penilai ?? '';
$atasan_pejabat_penilai = $i->atasan_pejabat_penilai ?? '';
$ket = $i->ket ?? '';

$action_url = (empty($id_penilaiankinerja)) ? '/insert' : '/update';
?>

<div class="modal-content">
	<div class="modal-header">
		<h5 class="modal-titles" id="defaultModalLabel"><b>Edit Data Penilaian Kinerja</b></h5>
		<button type="button" class="close" aria-label="Close" data-dismiss="modal">
			<span aria-hidden="true">×</span>
		</button>
	</div>


	<div class="modal-body">
		<form action="javascript:submitFormN('modal')" id="modal" url="<?php echo site_url($get_controller . $action_url) ?>" method="post">
			<input type="hidden" id="formToken" name="<?php echo $this->m_reff->tokenName() ?>" value="<?php echo $this->m_reff->getToken() ?>">
			<input type="hidden" name="id" value="<?php echo $id_pegawai; ?>">
			<input type="hidden" name="fr" value="j">

			<input type="hidden" name="f[nip_pegawai]" value="<?=$nip?>">
			<input type="hidden" name="id_a" value="<?php echo $id_penilaiankinerja; ?>">

			<div class="mb-4 main-content-label">Form data Penilaian Kinerja</div>

			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<label class="form-label" for="">Tahun</label>
								<input name="f[tahun]" id="" type="text" class="form-control" value="<?= $tahun; ?>">
							</div>
							<div class="col-md-6">
								<label class="form-label" for="">Nilai rata-rata</label>
								<input name="f[nilai]" id="" type="text" class="form-control" value="<?= $nilai; ?>">
							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="form-label" for="">Pejabat Penilai</label>
						<input name="f[pejabat_penilai]" class="form-control" type="text" value="<?= $pejabat_penilai ?>">
					</div>

					<div class="form-group">
						<label class="form-label" for="">Atasan Pejabat Penilai</label>
						<input name="f[atasan_pejabat_penilai]" class="form-control" type="text" value="<?= $atasan_pejabat_penilai ?>">
					</div>


				</div>
				<div class="col-md-6">



					<div class="form-group">
						<label class="form-label" for="">Ket</label>
						<input name="f[ket]" class="form-control" type="text" value="<?= $ket ?>">
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
		reload_table_inmodal('j');
	});
</script>