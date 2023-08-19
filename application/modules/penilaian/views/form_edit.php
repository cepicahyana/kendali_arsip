<?php
$id		= $this->input->post("id") ?? '';
$nip	= $this->input->post("nip") ?? '';
$tahun	= $this->input->post("tahun") ?? '';
$sms	= $this->input->post("sms") ?? '';

$nama = $this->m_reff->goField("data_pegawai","nama","where nip='".$nip."'");
$furl = ($id>0) ? 'penilaian/update' : 'penilaian/insert' ;


$hasil_evaluasi = $predikat = $catatan =  $komentar = '';
$db	= $this->db->get_where("penilaian_kinerja_ppnpn", ["tahun"=>$tahun,"semester"=>$sms,"nip"=>$nip]);
if ($db->num_rows()) {
	$dbp = $db->row();
	$hasil_evaluasi = $dbp->hasil_evaluasi ?? '';
	$predikat = $dbp->predikat ?? '';
	$komentar = $dbp->komentar ?? '';
	$catatan = $dbp->catatan ?? '';
}

?>
<div class="row" id="area_formSubmit">
	<div class="col-sm-12">

		<div class="card-block">
		<h5 class="sub-title"><?= ($id>0) ? 'Edit' : 'Form' ;?> Penilaian  </h5><hr>

		<form id="formSubmit" action="javascript:submitForm('formSubmit')" method="post"
		url="<?php echo site_url($furl);?>">
		<input type="hidden" id="formToken" name="<?php echo $this->m_reff->tokenName()?>" value="<?php echo $this->m_reff->getToken()?>">
				<input type="hidden" name="id" id="penilaian_id" value="<?= $id;?>">
				<input type="hidden" name="f[nama]" value="<?= $nama;?>">
				<input type="hidden" name="f[nip]" value="<?= $nip;?>">
				<input type="hidden" name="f[tahun]" id="tahun" value="<?= $tahun;?>">
				<input type="hidden" name="f[semester]" id="semester" value="<?= $sms;?>">
				 
				<table width="100%" class="entry2">
					<tr>
						<td width="200px">Nama</td>
						<td><?= ucwords($nama); ?></td>
					</tr>
					<tr>
						<td>Tahun / Semester</td>
						<td><?=$tahun." - Semester ".  $sms;?></td>
					</tr>
				</table><br/>
 

<div class="table-responsive">
<table class="table">
	<thead class="bg-teal">
		<tr>
			<th class="col-md-6">Indikator</th>
			<th class="col-md-2">Bobot (%)</th>
			<th class="col-md-2">Skor</th>
			<th class="col-md-2">Nilai</th>
		</tr>
	</thead>
	<tbody id="indikator"></tbody>
	<?php
	$cekIndikator = $this->db->get_where('tm_indikator_penilaian',['tahun'=>$tahun,'semester'=>$sms])->num_rows();
	if ($cekIndikator>0):
	?>
	<tfoot>
		<tr>
			<th colspan="3" class="col-md-10 text-right">Hasil Penilaian</th>
			<th class="col-md-2 text-center">
				<span id="hasil_penilaian_txt"><?= $hasil_evaluasi;?></span>
				<input type="hidden" id="hasil_penilaian" name="f[hasil_evaluasi]" value="<?= set_value('f[hasil_evaluasi]', $hasil_evaluasi);?>">
			</th>
		</tr>
		<tr>
			<th colspan="3" class="col-md-10 text-right">Predikat</th>
			<th class="col-md-2 text-center">
				<span id="predikat_txt"><?= $this->m_reff->predikat($predikat);?></span>
				<input type="hidden" id="predikat" name="f[predikat]" value="<?= set_value('f[predikat]', $predikat);?>">
			</th>
		</tr>
	</tfoot>
	<?php endif;?>
</table>
</div>

<?php if ($cekIndikator>0): ?>
		<div class="form-group row">
			<label class="col-sm-12 col-form-label" for="komentar">Komentar dan Saran Pengembangan Kompetensi dan Peningkatan Kinerja</label>
			<div class="col-sm-12">
				<textarea name="f[komentar]" id="komentar" class="form-controls" style="height: 100px;"><?= set_value('f[komentar]', $komentar);?></textarea>
			</div>
		</div>
		<div class="form-group row">
			<label class="col-sm-12 col-form-label" for="komentar">Catatan (untuk informasi internal)</label>
			<div class="col-sm-12">
				<textarea name="f[catatan]" id="catatan" class="form-controls" style="height: 100px;"><?= set_value('f[catatan]', $catatan);?></textarea>
			</div>
		</div>
		<center>
			<button class="btn btn-primary mb-3 pull-right" onclick="javascript:submitForm('formSubmit')"><i class="fa fa-save"></i> SIMPAN</button>
		</center>
<?php endif ?>

		</form>

		</div>
	</div>
</div>


<script>
	var id = $('#penilaian_id').val();
	var tahun = $('#tahun').val();
    var semester = $('#semester').val();
    //alert(tglhis);
   


	var url   = "<?php echo site_url("penilaian/get_indikator"); ?>";
		var param = {
			id: id,
        tahun: tahun,
        semester: semester
 		};
 		$.ajax({
			type: "POST",dataType: "json",data: param, url: url,
			success: function(data) {
				$("#indikator").html(data['indikator']);
				inputPenilaian();
	   			inputPenilaian2()
			}
		});


</script>