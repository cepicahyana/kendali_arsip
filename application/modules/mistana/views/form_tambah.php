
<div class="row" id="area_formSubmit">
<div class="col-sm-12">


<div class="card-block">
<h5 class="sub-title">Tambah    </h5><hr>
<form id="formSubmit" action="javascript:submitForm('formSubmit')"
	 method="post" url="<?php echo site_url()?>mistana/insert">

 
	 <div class="form-group row">
					<label class="col-sm-4 col-form-label">Kode </label>
						<div class="col-sm-8">
							<input type="text" name="f[kode]"   required class="form-control">
						</div>
				</div>
<div class="form-group row">
<label class="col-sm-4 col-form-label">Nama Istana</label>
<div class="col-sm-8">
<input type="text" name="f[istana]" required class="form-control">
</div>
</div>

<div class="form-group row">
<label class="col-sm-4 col-form-label">Latitude</label>
<div class="col-sm-8">
<input type="text" name="f[lat]" required class="form-control">
</div>
</div>

<div class="form-group row">
<label class="col-sm-4 col-form-label">Longitude</label>
<div class="col-sm-8">
<input type="text" name="f[lng]" required class="form-control">
</div>
</div>

<div class="form-group row">
					<label class="col-sm-4 col-form-label" for="kop-surat">Kop Surat</label>
					<div class="col-sm-8">
						<div>
							<input type="file" class="form-control-file" name="kop_surat" id="kop-surat" onchange="editpreviewFile(this)">
							<small><i class="text-muted">*Image max size 3MB</i></small>
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

