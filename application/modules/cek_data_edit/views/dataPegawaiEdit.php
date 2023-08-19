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
$tmt = isset($f->tmt) ? date('d/m/Y', strtotime($f->tmt)) : '';
$istana = $f->kode_istana ?? '';
$instansi = $f->instansi ?? '';
$kode_biro = $f->kode_biro ?? '';
$jabatan = $f->jabatan ?? '';
$bagian = $f->bagian ?? '';
$eselon = $f->eselon ?? '';
$golongan = $f->golongan ?? '';
$subbagian = $f->subbagian ?? '';
$gelar_belakang = $f->gelar_belakang ?? '';
$gelar_depan = $f->gelar_depan ?? '';
$karpeg = $f->karpeg ?? '';
$masker_golongan = $f->masker_golongan ?? '';
$masker_keseluruhan = $f->masker_keseluruhan ?? '';
$tmt_setpres = $f->tmt_setpres ?? '';
$penjab_lain = $f->penjab_lain ?? '';
$sts_keaktifan = $f->sts_keaktifan ?? '';
?>
<div class="modal-content">
	<div class="modal-header">
		<h5 class="modal-titles" id="defaultModalLabel"><b>Edit Data Pegawai</b></h5>
		<button type="button" class="close" aria-label="Close" data-dismiss="modal">
			<span aria-hidden="true">×</span>
		</button>
	</div>


	<div class="modal-body">
		<form action="javascript:submitForm('modal')" id="modal" url="<?php echo site_url($get_controller . $action_url) ?>" method="post">
			<input type="hidden" id="formToken" name="<?php echo $this->m_reff->tokenName() ?>" value="<?php echo $this->m_reff->getToken() ?>">
			<input type="hidden" name="id" value="<?php echo $id_pegawai; ?>">
			<input type="hidden" name="nip" value="<?php echo $nip; ?>">
			<input type="hidden" name="fr" value="b">

			<div class="mb-4 main-content-label">Informasi Pekerjaan</div>

			<div class="row">
				<div class="col-md-6">
					<div class="form-group ">

						<label class="form-label" for="nip">NIP</label>

						<input name="f[nip]" id="nip" type="text" class="form-control" value="<?= $nip ?>">

					</div>
					<div class="form-group ">

						<label class="form-label" for="nip">NIP BARU</label>

						<input name="f[nip_baru]" id="nip_baru" type="text" class="form-control" value="<?= $nip_baru ?>">

					</div>
					<div class="form-group ">

						<label class="form-label" for="">Gelar Depan</label>

						<input name="f[gelar_depan]" id="" type="text" class="form-control" value="<?= $gelar_depan ?>">

					</div>
					<div class="form-group ">

						<label class="form-label" for="">Gelar Belakang</label>

						<input name="f[gelar_belakang]" id="" type="text" class="form-control" value="<?= $gelar_belakang ?>">

					</div>

					<div class="form-group ">

						<label class="form-label" for="">NO KARPEG</label>

						<input name="f[karpeg]" id="" type="text" class="form-control" value="<?= $karpeg ?>">

					</div>
					<div class="form-group ">

						<label class="form-label" for="tmt">Tanggal Mulai Tugas</label>

						<input name="tmt" id="tmt" class="form-control date-tmt" placeholder="DD/MM/YYYY" type="text" value="<?= set_value('tmt', $tmt); ?>">

					</div>
					<div class="form-group ">

						<label class="form-label" for="">Masa Kerja Golongan</label>

						<input name="f[masker_golongan]" id="" type="text" class="form-control" value="<?= $masker_golongan ?>">

					</div>
					<div class="form-group ">

						<label class="form-label" for="">Masa Kerja Keseluruhan</label>

						<input name="f[masker_keseluruhan]" id="" type="text" class="form-control" value="<?= $masker_keseluruhan ?>">

					</div>


				</div>
				<div class="col-md-6">
					<!-- <div class="form-group ">

						<label class="form-label" for="">Tmt ditempatkan di Sekretariat Presiden</label>

						<input name="f[tmt_setpres]" id="" type="text" class="form-control" value="<?= $tmt_setpres ?>">

					</div> -->
					<div class="form-group ">

<label class="form-label" for="">Status Keaktifan Pegawai</label>
<?php
$options = ["" => "-- Pilih Status Keaktifan --"];
$dbKeaktifan =  $this->db->get("tr_sts_keaktifan")->result();
foreach ($dbKeaktifan as $r) {
	$options[$r->nama] = $r->nama;
}
echo form_dropdown("f[sts_keaktifan]", $options, $sts_keaktifan, "id='' class='text-black form-control select2'");
unset($options); ?>
</div>
					<div class="form-group ">

						<label class="form-label" for="">Penugasan Jabatan lain</label>
						<input name="f[penjab_lain]" id="" type="text" class="form-control" value="<?= $penjab_lain ?>">
						
					</div>
				
					<div class="form-group ">

						<label class="form-label" for="istana">Istana Kepresidenan</label>

						<?php
						$options = ["" => "-- Pilih Istana Kepresidenan --"];
						$dbIstana =  $this->m_reff->list_istana()->result();
						foreach ($dbIstana as $r) {
							$options[$r->kode] = $r->istana;
						}
						echo form_dropdown("f[kode_istana]", $options, $istana, "id='istana' class='text-black form-control select2'");
						unset($options); ?>

					</div>
					<div class="form-group ">
						<label class="form-label" for="instansi">Instansi</label>
						<input name="f[instansi]" id="instansi" type="text" class="form-control" placeholder="Instansi" value="<?= set_value('f[instansi]', $instansi); ?>">
					</div>
					<div class="form-group ">
						<label class="form-label" for="biro">Biro</label>
						<?php
						$options = ["" => "-- Pilih Biro --"];
						$dbBiro =  $this->m_reff->list_biro()->result();
						foreach ($dbBiro as $r) {
							$options[$r->kode] = $r->biro;
						}
						echo form_dropdown("f[kode_biro]", $options, $kode_biro, "id='istana' class='text-black form-control select2'");
						unset($options); ?>
					</div>
					<div class="form-group ">
						<label class="form-label" for="jabatan">Jabatan</label>
						<input name="f[jabatan]" id="jabatan" type="text" class="form-control" placeholder="Jabatan" value="<?= set_value('f[jabatan]', $jabatan); ?>">
					</div>
					<div class="form-group ">
						<label class="form-label" for="bagian">Bagian</label>
						<input name="f[bagian]" id="bagian" type="text" class="form-control" placeholder="Bagian" value="<?= set_value('f[bagian]', $bagian); ?>">
					</div>
					<div class="form-group ">
						<label class="form-label" for="subbagian">Sub Bagian</label>
						<input name="f[subbagian]" id="subbagian" type="text" class="form-control" placeholder=" Sub Bagian" value="<?= $subbagian ?>">
					</div>
				</div>
			</div>
<hr>
<div class="row">
<div class="col-md-6">
	<div class="form-group ">
	<label class="form-label" for=""><i class="fa fa-upload"></i> File penetapan NIP</label>
	<input name="file_penetapan_nip" id="" type="file" class="form-control">
	</div>
</div>
<div class="col-md-6">
	<div class="form-group ">
	<label class="form-label" for=""><i class="fa fa-upload"></i> File kartu pegawai</label>
	<input name="file_karpeg" id="" type="file" class="form-control">
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
	function reload_table(){
		setTimeout(() => {
			tab(`<?=base_url()?>cek_data/tab_kepegawaian`);	
		}, 500);
    }
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
		"drops": "up"
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
		"drops": "up"
	});</script>
	
	
	 