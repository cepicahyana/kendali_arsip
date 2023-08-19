<?php
$get_controller = $this->router->fetch_class();
$f = $this->mdl->getByNip($val)->row();


$id_pegawai = $f->id ?? '';
$nip = $f->nip ?? '';
$nip_baru = $f->nip_baru ?? '';

$id_pen = $id_a ?? '';
$i = $this->mdl->getPendidikanById($id_pen)->row();
$id_pendidikan = $i->id ?? '';
$istitusi = $i->istitusi ?? '';
$id_jenjang = $i->id_jenjang ?? '';
$no_ijazah = $i->no_ijazah ?? '';

// $dbjenjang=$this->db->get_where('tr_pendidikan',array('id'=>$id_jenjang))->row();
// $jenjang = $dbjenjang->nama ?? '';

$tahun_lulus = $i->tahun_lulus ?? '';
$jurusan = $i->jurusan ?? '';
$ipk = $i->ipk ?? '';
$no_ijazah = $i->no_ijazah ?? '';


$action_url = (empty($id_pendidikan)) ? '/insert' : '/update';
?>

<div class="modal-content">
	<div class="modal-header">
		<h5 class="modal-titles" id="defaultModalLabel"><b>Edit Data Pendidikan</b></h5>
		<button type="button" class="close" aria-label="Close" data-dismiss="modal">
			<span aria-hidden="true">×</span>
		</button>
	</div>


	<div class="modal-body">
		<form action="javascript:submitFormN('modal')" id="modal" url="<?php echo site_url($get_controller . $action_url) ?>" method="post">
			<input type="hidden" id="formToken" name="<?php echo $this->m_reff->tokenName() ?>" value="<?php echo $this->m_reff->getToken() ?>">
			<input type="hidden" name="id" value="<?php echo $id_pegawai; ?>">
			<input type="hidden" name="fr" value="h">

			<input type="hidden" name="f[nip_pegawai]" value="<?=$nip?>">
			<input type="hidden" name="id_a" value="<?php echo $id_pendidikan; ?>">

			<div class="mb-4 main-content-label">Form data Pendidikan</div>

			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label class="form-label" for="">Nama Istitusi</label>
						<input name="f[istitusi]" class="form-control" type="text" value="<?= $istitusi ?>">
					</div>
					<div class="form-group">
						<label class="form-label" for="">Jenjang</label>
						<?php
						$options = ["" => "-- Pilih --"];
						$dbJen =  $this->db->get("tr_pendidikan")->result();
						foreach ($dbJen as $r) {
							$options[$r->id] = $r->nama;
						}
						echo form_dropdown("f[id_jenjang]", $options, $id_jenjang, "id='' class='text-black form-control select2'");
						unset($options);
						?>
					</div>
					<div class="form-group">
						<label class="form-label" for="">Jurusan</label>
						<input name="f[jurusan]" class="form-control" type="text" value="<?= $jurusan ?>">
					</div>
					

				</div>
				<div class="col-md-6">
					
					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<label class="form-label" for="">Tahun Lulus</label>
								<input name="f[tahun_lulus]" class="form-control" type="text" value="<?= $tahun_lulus ?>">
							</div>
							<div class="col-md-6">
								<label class="form-label" for="">IPK/Nilai/Terakhir</label>
								<input name="f[ipk]" class="form-control" type="text" value="<?= $ipk ?>">
							</div>
							<div class="col-md-12">
							<br>	<label class="form-label" for="">Nomor ijazah</label>
								<input name="f[no_ijazah]" class="form-control" type="text" value="<?= $no_ijazah ?>">
							</div>
							<div class="col-md-12">
							<br>	<label class="form-label" for="">File ijazah</label>
								<input name="file_ijazah" class="form-control" type="file" value="<?= $no_ijazah ?>">
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
		reload_table_inmodal('h');
	});
</script>