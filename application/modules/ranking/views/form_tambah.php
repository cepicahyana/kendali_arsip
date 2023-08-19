
<div class="row" id="area_formSubmit">
<div class="col-sm-12">


<div class="card-block">
<h5 class="sub-title">Tambah    </h5><hr>
<form id="formSubmit" action="javascript:submitForm('formSubmit')"
	 method="post" url="<?php echo site_url()?>mipenilaian/insert">


<div class="form-group row">
<label class="col-sm-4 col-form-label" for="tahun">Tahun / Semester</label>
<div class="col-sm-4">
<?php
$options = [''=>'--  Pilih Tahun --'];

$YNow = date('Y');
for ($thn=$YNow; $thn < ($YNow+5); $thn++) { 
    $options[$thn] = $thn;
}

$attr = array('id' => 'tahun', 'class' => 'form-controls', 'required' => 'required', 'style' => 'width:100%;');
echo form_dropdown('f[tahun]', $options, set_value('f[tahun]'), $attr);
unset($options);
unset($attr);
?>
</div>
<div class="col-sm-4">
<?php
$options = [
	''=>'-- Pilih Semester--',
	'1'=>'Semester 1',
	'2'=>'Semester 2',
];

$attr = array('id' => 'semester', 'class' => 'form-controls', 'required' => 'required', 'style' => 'width:100%;');
echo form_dropdown('f[semester]', $options, set_value('f[semester]'), $attr);
unset($options);
unset($attr);
?>
</div>
</div> 


<div class="form-group row">
	<label class="col-sm-4 col-form-label">Indikator Penilaian</label>
	<div class="col-sm-8">
		<input type="text" name="f[indikator]" value="" required class="form-controls">
	</div>
</div>

<div class="form-group row">
	<label class="col-sm-4 col-form-label">Bobot (%)</label>
	<div class="col-sm-8">
		<input type="text" name="f[bobot]" value="" required class="form-controls">
	</div>
</div>

<div class="form-group row">
<label class="col-sm-4 col-form-label">Status</label>
<div class="col-sm-8">
	<div class="radio d-inline-block mr-3">
	<label> 	<input type="radio" name="f[sts]" value="1" checked>
		Aktif</label>
	</div>

	<div class="radio d-inline-block mr-3">
		<label><input type="radio" name="f[sts]" value="2" >
		 Non Aktif</label>
	</div>
</div>

</div>



 <center>
 <button class="btn btn-primary mb-5 pull-right" onclick="javascript:submitForm('formSubmit')"><i class="fa fa-save"></i> SIMPAN</button>
 </center>
</form>


</div>
</div>

</div>

