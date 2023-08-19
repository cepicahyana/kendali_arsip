<div class="  card">
	<div class="card-body">
	
		<?php 
		// $fattr = ['id'=>'formSubmit', 'action'=>'javascript:submitForm("formSubmit")'];
		// echo form_open('pengaturan/update');
		?>
		<form id="formSubmit" action="javascript:submitForm('formSubmit')" method="post" url="<?php echo base_url()?>pengaturan/update">
			<h4 class="card-title">Radius Lokasi Presensi WFO</h4>
			<div class="form-row">
				<div class="form-group col-md-3">
					<label for="max_jarak_absen">Max. Jarak Absen</label>
					<input value="<?= set_value('f15', $this->mdl->getVal('15')); ?>" name="f15" type="number" class="form-control" id="max_jarak_absen">
				</div>
			</div>
			<h4 class="card-title">Office Hour</h4>
			<div class="form-row">
				<div class="form-group col-md-3">
					<label for="jam_masuk">Jam Masuk</label>
					<input value="<?= set_value('f4', $this->mdl->getVal('4')); ?>" name="f4" type="text" class="form-control" id="jam_masuk">
				</div>
				<div class="form-group col-md-3">
					<label for="jam_pulang">Jam Pulang</label>
					<input value="<?= set_value('f5', $this->mdl->getVal('5')); ?>" name="f5" type="text" class="form-control" id="jam_pulang">
				</div>
				<div class="form-group col-md-3">
					<label for="durasi_kerja">Lama Bekerja Per Hari</label>
					<input value="<?= set_value('f7', $this->mdl->getVal('7')); ?>" name="f7" type="text" class="form-control" id="durasi_kerja">
				</div>
				<div class="form-group col-md-3">
					<label for="uang_makan">Nominal Uang Makan/Hari</label>
					<input value="<?= set_value('f9', $this->mdl->getVal('9')); ?>" name="f9" type="number" class="form-control" id="uang_makan">
				</div>
			</div>
			<h4 class="card-title">Lembur</h4>
			<div class="form-row">
				<div class="form-group col-md-3">
					<label for="jam_mulai_lembur">Jam Mulai Lembur (Week Day)</label>
					<input value="<?= set_value('f6', $this->mdl->getVal('6')); ?>" name="f6" type="text" class="form-control" id="jam_mulai_lembur">
				</div>
				<div class="form-group col-md-3">
					<label for="min_jam_lembur">Min. Lembur</label>
					<input value="<?= set_value('f8', $this->mdl->getVal('8')); ?>" name="f8" type="text" class="form-control" id="min_jam_lembur">
				</div>
				<div class="form-group col-md-3">
					<label for="nominal_lembur_perjam">Nominal Lembur/Jam</label>
					<input value="<?= set_value('f10', $this->mdl->getVal('10')); ?>" name="f10" type="number" class="form-control" id="nominal_lembur_perjam">
				</div>
				<div class="form-group col-md-3">
					<label for="max_uang_lembur_perhari">Max. Uang Lembur/Hari (Week Day)</label>
					<input value="<?= set_value('f11', $this->mdl->getVal('11')); ?>" name="f11" type="number" class="form-control" id="max_uang_lembur_perhari">
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col-md-3">
					<label for="max_jam_lembur">Max. Jam Lembur/Hari</label>
					<input value="<?= set_value('f12', $this->mdl->getVal('12')); ?>" name="f12" type="number" class="form-control" id="max_jam_lembur">
				</div>
				<div class="form-group col-md-3">
					<label for="max_lembur_weekend">Max. Lembur/Week End</label>
					<input value="<?= set_value('f13', $this->mdl->getVal('13')); ?>" name="f13" type="number" class="form-control" id="max_lembur_weekend">
				</div>
				<div class="form-group col-md-3">
					<label for="max_uang_lembur_weekend">Max. Uang Lembur (Week End)</label>
					<input value="<?= set_value('f14', $this->mdl->getVal('14')); ?>" name="f14" type="number" class="form-control" id="max_uang_lembur_weekend">
				</div>
				<div class="form-group col-md-3">
					<label for="max_total_jam_lembur_perminggu">Max. Total Jam Lembur/Minggu</label>
					<input value="<?= set_value('f16', $this->mdl->getVal('16')); ?>" name="f16" type="number" class="form-control" id="max_total_jam_lembur_perminggu">
				</div>
			</div>

			<button class="btn btn-primary mb-3 pull-right" onclick="simpan()"><i class="fa fa-save"></i> SIMPAN</button>
			<!--button type="submit" class="btn btn-primary mb-3 pull-right"><i class="fa fa-save"></i> SIMPAN</button-->
	</form>

	</div>
</div>


<script>
	var f4 = $('[name="f4"]').val();
	var f5 = $('[name="f5"]').val();
	var f6 = $('[name="f6"]').val();
	var f7 = $('[name="f7"]').val();
	var f8 = $('[name="f8"]').val();
	var f9 = $('[name="f9"]').val();
	var f10 = $('[name="f10"]').val();
	var f11 = $('[name="f11"]').val();
	var f12 = $('[name="f12"]').val();
	var f13 = $('[name="f13"]').val();
	var f14 = $('[name="f14"]').val();
	var f15 = $('[name="f15"]').val();
	var f16 = $('[name="f16"]').val();

function simpan() {

	$("#mdlValue").html("mohon tunggu...");
	$.post("<?php echo base_url() ?>pengaturan/update", {
		f4: f4,f5: f5,f6: f6,f7: f7,f8: f8,f9: f9, f10: f10, f11:f11,f12:f12, f13:f13,f14:f14,f15:f15,f16:f16,
	}, function() {
		notif("Berhasil disimpan!", "Info", "success");
	});
}
</script>