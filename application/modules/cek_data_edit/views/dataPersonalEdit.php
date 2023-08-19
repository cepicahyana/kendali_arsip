<?php
$get_controller = $this->router->fetch_class();
$f = $this->mdl->getByNip($val)->row();
$action_url = (empty($id_pegawai)) ? '/update' : '/update';

$id_pegawai = $f->id ?? '';
$nip = $f->nip ?? '';
$nip_baru = $f->nip_baru ?? '';
$nik = $f->nik ?? '';
$nama = $f->nama ?? '';
$jk = $f->jk ?? '';
$tempat_lahir = $f->tempat_lahir ?? '';
$tgl_lahir = isset($f->tgl_lahir) ? date('d/m/Y', strtotime($f->tgl_lahir)) : '';
$agama = $f->agama ?? '';
$sts_menikah = $f->sts_menikah ?? '';
$id_goldar = $f->id_goldar ?? '';
$id_jp = $f->id_jp ?? '';
$email = $f->email ?? '';
$no_hp = $f->no_hp ?? '';
$ktp_alamat = $f->ktp_alamat ?? '';
$ktp_prov = $f->ktp_prov ?? '';
$ktp_kab = $f->ktp_kab ?? '';
$ktp_kec = $f->ktp_kec ?? '';
$ktp_kel = $f->ktp_kel ?? '';
$npwp = $f->npwp ?? '';
$bpjs = $f->bpjs ?? '';
$bank = $f->bank ?? '';
$norek = $f->norek ?? '';
$an_rek = $f->an_rek ?? '';
?>
<div class="modal-content">
	<div class="modal-header">
		<h5 class="modal-titles" id="defaultModalLabel"><b>Edit Data Personal</b></h5>
		<button type="button" class="close" aria-label="Close" data-dismiss="modal">
			<span aria-hidden="true">×</span>
		</button>
	</div>


	<div class="modal-body">
		<form action="javascript:submitForm('modal')" id="modal" url="<?php echo site_url($get_controller . $action_url) ?>" method="post">
			<input type="hidden" id="formToken" name="<?php echo $this->m_reff->tokenName() ?>" value="<?php echo $this->m_reff->getToken() ?>">
			<input type="hidden" name="id" value="<?php echo $id_pegawai; ?>">
			<input type="hidden" name="fr" value="a">

			<div class="mb-4 main-content-label">Informasi Personal</div>
			<?php
			if($f->jenis_pegawai!=1)
			{?>
			<div class="form-group ">
				<div class="row">
					<div class="col-md-3">
						<label class="form-label" for="foto">Foto</label>
					</div>
					<div class="col-md-9">
						<input name="foto" id="foto" type="file" class="form-control"  >
						<input name="nip"  type="hidden" <?php echo $nip;?> class="form-control"  >
					</div>
				</div>
			</div>
			<?php } ?>
			<div class="form-group ">
				<div class="row">
					<div class="col-md-3">
						<label class="form-label" for="nik">NIK</label>
					</div>
					<div class="col-md-9">
						<input name="f[nik]" id="nik" type="text" class="form-control" value="<?= set_value('f[nik]', $nik); ?>">
					</div>
				</div>
			</div>
			<div class="form-group ">
				<div class="row">
					<div class="col-md-3">
						<label class="form-label" for="nama">Nama</label>
					</div>
					<div class="col-md-9">
						<input name="f[nama]" id="nama" type="text" class="form-control" value="<?= set_value('f[nama]', $nama); ?>">
					</div>
				</div>
			</div>
			<div class="form-group ">
				<div class="row">
					<div class="col-md-3">
						<label class="form-label" for="jk">Jenis Kelamin</label>
					</div>
					<div class="col-lg-3">
						<label class="rdiobox"><input name="f[jk]" value="l" type="radio" <?= ($jk == 'l') ? 'checked' : ''; ?>> <span>Laki-Laki</span></label>
					</div>
					<div class="col-lg-3 mg-t-20 mg-lg-t-0">
						<label class="rdiobox"><input name="f[jk]" value="p" type="radio" <?= ($jk == 'p') ? 'checked' : ''; ?>> <span>Perempuan</span></label>
					</div>
				</div>
			</div>
			<div class="form-group ">
				<div class="row">
					<div class="col-md-3">
						<label class="form-label" for="pob">Tempat, Tanggal Lahir</label>
					</div>
					<div class="col-md-6">
						<input name="f[tempat_lahir]" id="pob" type="text" class="form-control" placeholder="Tempat Lahir" value="<?= set_value('f[tempat_lahir]', $tempat_lahir); ?>">
					</div>
					<div class="col-md-3">
						<input name="tgl_lahir" class="form-control date-mask" placeholder="DD/MM/YYYY" type="text" value="<?= set_value('f[tgl_lahir]', $tgl_lahir); ?>">
					</div>
				</div>
			</div>
			<hr>
			<div class="mb-4 main-content-label">ALAMAT SESUAI KTP</div>
			<div class="form-group ">
				<div class="row">
					<div class="col-md-3">
						<label class="form-label" for="ktp_alamat">Alamat</label>
					</div>
					<div class="col-md-9">
						<textarea name="f[ktp_alamat]" id="ktp_alamat" class="form-control" rows="2"><?= $ktp_alamat ?></textarea>
					</div>
				</div>
			</div>
			<div class="form-group ">
				<div class="row">
					<div class="col-md-3">
						<label class="form-label" for="">Provinsi</label>
					</div>
					<div class="col-md-9">
						<?php
						// $dtProv = $this->db->where_in("id_prov", array("31", "32"));
						$dtProv = $this->db->get("provinsi")->result();
						$opProv[] = "-- Pilih Provinsi --";
						foreach ($dtProv as $v) {
							$opProv[$v->id_prov] = $v->nama;
						}
						echo form_dropdown("f[ktp_prov]", $opProv, $ktp_prov, " onchange='get_kab()' class='text-black form-control select2'");
						?>
					</div>
				</div>
			</div>
			<div class="form-group ">
				<div class="row">
					<div class="col-md-3">
						<label class="form-label" for="">Kab/Kota</label>
					</div>
					<div class="col-md-9">
						<div id="data_kab"></div>
					</div>
				</div>
			</div>
			<div class="form-group ">
				<div class="row">
					<div class="col-md-3">
						<label class="form-label" for="">Kecamatan</label>
					</div>
					<div class="col-md-9">
						<div id="data_kec"></div>
					</div>
				</div>
			</div>
			<div class="form-group ">
				<div class="row">
					<div class="col-md-3">
						<label class="form-label" for="">Kelurahan</label>
					</div>
					<div class="col-md-9">
						<div id="data_kel"></div>
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
						$tr_agama = $this->db->get('tr_agama')->result();
						$optA[] = "-- Pilih Agama --";
						foreach ($tr_agama as $v) {
							$optA[$v->nama] = $v->nama;
						}
						echo form_dropdown("f[agama]", $optA, $agama, "id='agama' class='text-black form-control select2'");
						unset($options); ?>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-md-3">
						<label class="form-label" for="pernikahan">Status Pernikahan</label>
					</div>
					<div class="col-md-9">
						<?php
						$tr_sts_perkawinan = $this->db->get('tr_sts_perkawinan')->result();
						$optB[] = "-- Pilih Status Pernikahan --";
						foreach ($tr_sts_perkawinan as $v) {
							$optB[$v->nama] = $v->nama;
						}
						echo form_dropdown("f[sts_menikah]", $optB, $sts_menikah, "id='pernikahan' class='text-black form-control select2'");
						unset($optB); ?>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-md-3">
						<label class="form-label" for="goldar">Golongan Darah</label>
					</div>
					<div class="col-md-9">
						<?php
						$tr_goldar = $this->db->get('tr_goldar')->result();
						$optC[] = "-- Pilih Golongan Darah --";
						foreach ($tr_goldar as $v) {
							$optC[$v->nama] = $v->nama;
						}
						echo form_dropdown("f[id_goldar]", $optC, $id_goldar, "id='goldar' class='text-black form-control select2'");
						unset($optC); ?>
					</div>
				</div>
			</div>
			<div class="form-group ">
				<div class="row">
					<div class="col-md-3">
						<label class="form-label" for="pendidikan">Pendidikan Terakhir</label>
					</div>
					<div class="col-md-9">
						<?php
						$tr_jp = $this->db->get('tr_jp')->result();
						$optD[] = "-- Pilih Pendidikan Terakhir --";
						foreach ($tr_jp as $v) {
							$optD[$v->nama] = $v->nama;
						}
						echo form_dropdown("f[id_jp]", $optD, $id_jp, "id='pendidikan' class='text-black form-control select2'");
						unset($optD); ?>
					</div>
				</div>
			</div>
			<hr>
			<div class="mb-4 main-content-label">Informasi Kontak</div>
			<div class="form-group ">
				<div class="row">
					<div class="col-md-3">
						<label class="form-label" for="email">E-mail</label>
					</div>
					<div class="col-md-9">
						<input name="f[email]" id="email" type="email" class="form-control" value="<?= set_value('f[email]', $email); ?>" >
					</div>
				</div>
			</div>
			<div class="form-group ">
				<div class="row">
					<div class="col-md-3">
						<label class="form-label" for="no_hp">Nomor HP</label>
					</div>
					<div class="col-md-9">
						<input name="f[no_hp]" id="no_hp" type="text" class="form-control" value="<?= set_value('f[no_hp]', $no_hp); ?>">
					</div>
				</div>
			</div>
			<hr>
			<div class="mb-4 main-content-label">Informasi Lain</div>
			<div class="form-group ">
				<div class="row">
					<div class="col-md-3">
						<label class="form-label" for="npwp">NPWP</label>
					</div>
					<div class="col-md-9">
						<input name="f[npwp]" id="npwp" type="text" class="form-control" value="<?= $npwp ?>">
					</div>
				</div>
				<div class="row">
					<div class="col-md-3">
						<label class="form-label" for="bpjs">BPJS</label>
					</div>
					<div class="col-md-9">
						<input name="f[bpjs]" id="bpjs" type="text" class="form-control" value="<?= $bpjs ?>">
					</div>
				</div>
				<div class="row">
					<div class="col-md-3">
						<label class="form-label" for="bank">NAMA BANK</label>
					</div>
					<div class="col-md-9">
						<input name="f[bank]" id="bank" type="text" class="form-control" value="<?= $bank ?>">
					</div>
				</div>
				<div class="row">
					<div class="col-md-3">
						<label class="form-label" for="norek">No Rekening</label>
					</div>
					<div class="col-md-9">
						<input name="f[norek]" id="norek" type="text" class="form-control" value="<?= $norek ?>">
					</div>
				</div>
				<div class="row">
					<div class="col-md-3">
						<label class="form-label" for="an_rek">Atas Nama</label>
					</div>
					<div class="col-md-9">
						<input name="f[an_rek]" id="an_rek" type="text" class="form-control" value="<?= $an_rek ?>">
					</div>

				</div>
			</div>
			<hr>
			<div class="mb-4 main-content-label">File upload</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group ">
						<div class="row">
							<div class="col-md-3">
								<label class="form-label" for="akta">Akta lahir</label>
							</div>
							<div class="col-md-9">
								<input name="file_akta" id="akta" type="file" class="form-control"  >
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group ">
						<div class="row">
							<div class="col-md-3">
								<label class="form-label" for="npwp">NPWP</label>
							</div>
							<div class="col-md-9">
								<input name="file_npwp" id="npwp" type="file" class="form-control"  >
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group ">
						<div class="row">
							<div class="col-md-3">
								<label class="form-label" for="file_ktp">KTP</label>
							</div>
							<div class="col-md-9">
								<input name="file_ktp" id="file_ktp" type="file" class="form-control"  >
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group ">
						<div class="row">
							<div class="col-md-3">
								<label class="form-label" for="file_buku_rek">Buku rekening</label>
							</div>
							<div class="col-md-9">
								<input name="file_buku_rek" id="file_buku_rek" type="file" class="form-control"  >
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group ">
						<div class="row">
							<div class="col-md-3">
								<label class="form-label" for="file_goldar">File Ket.Golongan Darah</label>
							</div>
							<div class="col-md-9">
								<input name="file_goldar" id="file_goldar" type="file" class="form-control"  >
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group ">
						<div class="row">
							<div class="col-md-3">
								<label class="form-label" for="file_surat_nikah">File surat nikah</label>
							</div>
							<div class="col-md-9">
								<input name="file_surat_nikah" id="file_surat_nikah" type="file" class="form-control"  >
							</div>
						</div>
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
	$(function(){
		setTimeout(function() {
			get_kab();
		}, 500);
	});

	function reload_table(){
	
		setTimeout(function() {
			search();
		}, 500);
    }

	function get_kab() {
		var id_prov = $("[name='f[ktp_prov]']").val();
		var name = 'f[ktp_kab]';
		var value = "<?= $ktp_kab ?>";
		$.post("<?php echo site_url("cek_data_edit/get_kab"); ?>", {
			idprov: id_prov,
			name: name,
			value: value
		}, function(data) {
			$("#data_kab").html(data);
			get_kec();
		});
	}

	function get_kec() {
		var id_kab = $("[name='f[ktp_kab]']").val();
		var name = 'f[ktp_kec]';
		var value = "<?= $ktp_kec ?>";
		$.post("<?php echo site_url("cek_data_edit/get_kec"); ?>", {
			idkab: id_kab,
			name:name,
			value: value
		}, function(data) {
			$("#data_kec").html(data);
			get_kel();
		});
	}
	
	function get_kel() {
		var id_kec = $("[name='f[ktp_kec]']").val();
		var name = 'f[ktp_kel]';
		var value = "<?= $ktp_kel ?>";
		$.post("<?php echo site_url("cek_data_edit/get_kel"); ?>", {
			idkec: id_kec,
			name:name,
			value: value
		}, function(data) {
			$("#data_kel").html(data);
		});
	}


	
</script>


<script>   
		  $('[name="tgl_lahir"]').daterangepicker({
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
	
	
	 