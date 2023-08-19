<?php
$get_controller = $this->router->fetch_class();
$id_pegawai = $this->input->post('id') ?? '';
$f = $this->mdl->getById($id_pegawai)->row();
$nip = $f->nip ?? '';
$nik = $f->nik ?? '';
$nama = $f->nama ?? '';
$jk = $f->jk ?? '';
$tempat_lahir = $f->tempat_lahir ?? '';
$tgl_lahir = isset($f->tgl_lahir) ? date('d/m/Y', strtotime($f->tgl_lahir)):'';
$agama = $f->agama ?? '';
$istana = $f->istana ?? '';
$instansi = $f->instansi ?? '';
$biro = $f->biro ?? '';
$jabatan = $f->jabatan ?? '';
$bagian = $f->bagian ?? '';
$eselon = $f->eselon ?? '';
$golongan = $f->golongan ?? '';
?>
<div class="modal-content">
	<div class="modal-header">  <h5 class="modal-titles" id="defaultModalLabel"><b>Tambah Data PPNPN</b></h5>
		<button type="button" class="close" aria-label="Close" data-dismiss="modal">
			<span aria-hidden="true">×</span>
		</button>
	</div>


	<div class="modal-body">
		<form  action="javascript:submitForm('modal')" id="modal" url="<?php echo site_url($get_controller.'/ppnpn_insert')?>"  method="post">
			<input type="hidden" id="formToken" name="<?php echo $this->m_reff->tokenName()?>" value="<?php echo $this->m_reff->getToken()?>">

			<div class="mb-4 main-content-label">Personal Information</div>
			<div class="form-group ">
				<div class="row">
					<div class="col-md-3">
						<label class="form-label" for="nip">NIP</label>
					</div>
					<div class="col-md-9">
						<input name="f[nip]" id="nip" type="text" class="form-control" value="<?= set_value('f[nip]', $nip);?>">
					</div>
				</div>
			</div>
			<div class="form-group ">
				<div class="row">
					<div class="col-md-3">
						<label class="form-label" for="nik">NIK</label>
					</div>
					<div class="col-md-9">
						<input name="f[nik]" id="nik" type="text" class="form-control" value="<?= set_value('f[nik]', $nik);?>">
					</div>
				</div>
			</div>
			<div class="form-group ">
				<div class="row">
					<div class="col-md-3">
						<label class="form-label" for="nama">Nama</label>
					</div>
					<div class="col-md-9">
						<input name="f[nama]" id="nama" type="text" class="form-control" value="<?= set_value('f[nama]', $nama);?>">
					</div>
				</div>
			</div>

			<div class="form-group ">
				<div class="row">
					<div class="col-md-3">
						<label class="form-label" for="jk">Jenis Kelamin</label>
					</div>
					<div class="col-lg-3">
						<label class="rdiobox"><input name="f[jk]" value="l" type="radio"> <span>Laki-Laki</span></label>
					</div>
					<div class="col-lg-3 mg-t-20 mg-lg-t-0">
						<label class="rdiobox"><input name="f[jk]" value="p" type="radio"> <span>Perempuan</span></label>
					</div>
				</div>
			</div>

			<div class="form-group ">
				<div class="row">
					<div class="col-md-3">
						<label class="form-label" for="pob">Tempat, Tanggal Lahir</label>
					</div>
					<div class="col-md-6">
						<input name="f[tempat_lahir]" id="pob" type="text" class="form-control" placeholder="Tempat Lahir" value="<?= set_value('f[tempat_lahir]', $tempat_lahir);?>">
					</div>
					<div class="col-md-3">
						<input name="tgl_lahir" class="form-control" id="dateMask" placeholder="DD/MM/YYYY" type="text" value="<?= set_value('f[tgl_lahir]', $tgl_lahir);?>">
					</div>
				</div>
			</div>

			<div class="form-group ">
				<div class="row">
					<div class="col-md-3">
						<label class="form-label" for="agama">Agama</label>
					</div>
					<div class="col-md-9">
						<?php
						$options = [
							"" => "-- Pilih Agama --",
							"Islam"=>"Islam",
							"Protestan"=>"Protestan",
							"Katolik"=>"Katolik",
							"Hindu"=>"Hindu",
							"Buddha"=>"Buddha",
							"Khonghucu"=>"Khonghucu",
						];
						echo form_dropdown("f[agama]", $options, "", "id='agama' class='text-black form-control select2'");
						unset($options); ?>
					</div>
				</div>
			</div>

			<div class="form-group d-none">
				<div class="row">
					<div class="col-md-3">
						<label class="form-label" for="pernikahan">Status Pernikahan</label>
					</div>
					<div class="col-md-9">
						<?php
						$options = [
							"" => "-- Pilih Status Pernikahan --",
							"Kawin"=>"Kawin",
							"Belum Kawin"=>"Belum Kawin",
							"Cerai Hidup"=>"Cerai Hidup",
							"Cerai Mati"=>"Cerai Mati",
						];
						echo form_dropdown("f[sts_menikah]", $options, "", "id='pernikahan' class='text-black form-control select2'");
						unset($options); ?>
					</div>
				</div>
			</div>

			<div class="form-group d-none">
				<div class="row">
					<div class="col-md-3">
						<label class="form-label" for="goldar">Golongan Darah</label>
					</div>
					<div class="col-md-9">
						<select name="f[agama]" id="goldar" class="form-control select2">
							<option value="">Pilih Golongan Darah</option>
							<option value="A">A</option>
							<option value="B">B</option>
							<option value="AB">AB</option>
							<option value="O">O</option>
						</select>
						<?php
						$options = [
							"" => "-- Pilih Golongan Darah --",
							"A"=>"A",
							"B"=>"B",
							"AB"=>"AB",
							"O"=>"O",
						];
						echo form_dropdown("f[goldar]", $options, "", "id='pernikahan' class='text-black form-control select2'");
						unset($options); ?>
					</div>
				</div>
			</div>

			<div class="mb-4 main-content-label">Informasi Pekerjaan</div>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group ">
						<label class="form-label" for="istana">Istana</label>
						<input name="f[istana]" id="istana" type="text" class="form-control" placeholder="Istana" value="">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group ">
						<label class="form-label" for="instansi">Instansi</label>
						<input name="f[instansi]" id="instansi" type="text" class="form-control" placeholder="Instansi" value="<?= set_value('f[instansi]', $instansi);?>">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group ">
						<label class="form-label" for="biro">Biro</label>
						<input name="f[biro]" id="biro" type="text" class="form-control" placeholder="Biro" value="<?= set_value('f[biro]', $biro);?>">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group ">
						<label class="form-label" for="jabatan">Jabatan</label>
						<input name="f[jabatan]" id="jabatan" type="text" class="form-control" placeholder="Jabatan" value="<?= set_value('f[jabatan]', $jabatan);?>">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group ">
						<label class="form-label" for="bagian">Bagian</label>
						<input name="f[bagian]" id="bagian" type="text" class="form-control" placeholder="Bagian" value="<?= set_value('f[bagian]', $bagian);?>">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group ">
						<label class="form-label" for="eselon">Eselon</label>
						<input name="f[eselon]" id="eselon" type="text" class="form-control" placeholder="Eselon" value="<?= set_value('f[eselon]', $eselon);?>">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group ">
						<label class="form-label" for="golongan">Golongan</label>
						<input name="f[golongan]" id="golongan" type="text" class="form-control" placeholder="Golongan" value="<?= set_value('f[golongan]', $golongan);?>">
					</div>
				</div>
				
			</div>

			<div class="col-lg-12 p-1">
				<center>
					<button class="btn btn-success button_save" onclick="submitForm('modal')"><i class="fa fa-save"></i> simpan</button>
				</center>
			</div>
		</form>
	</div>
</div>

<script>
	$(function() {
		'use strict'

		$('#dateMask').mask('99/99/9999');
	});
	var id_pegawai = '<?= ($id_pegawai ?? ''); ?>';
	function get_kontak() {
		var biro = $('#biro').val();
		// AJAX request
		$.ajax({
			url: '<?= site_url($get_controller.'/option_biro'); ?>',
			method: 'post',
			data: {
				biro: biro
			},
			dataType: 'json',
			success: function(response) {
				// Remove options
				$('#kontak').find('option').not(':first').remove();

				$.each(response, function(key, val) {
					var kontak_selected = '';
					/*if (key == id_pegawai) {
						kontak_selected =  'selected="selected"';
					}*/
					$('#kontak').append('<option value="' + key +'" ' + kontak_selected + '>' + val + '</option>');
				});
			}
		});
	}
</script>

