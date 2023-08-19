
<div class="row" id="area_formSubmit">
<div class="col-sm-12">


<div class="card-block">
<h5 class="sub-title">Tambah    </h5><hr>
<form id="formSubmit" action="javascript:submitForm('formSubmit')"
	 method="post" url="<?php echo site_url()?>mbidang/insert">

 

<div class="form-group row">
<label class="col-sm-4 col-form-label">Bidang Pekerjaan</label>
<div class="col-sm-8">
<input type="text" name="f[bidang]"   required class="form-controls">
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

