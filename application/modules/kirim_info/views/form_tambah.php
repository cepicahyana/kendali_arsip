
<div class="row" id="area_formSubmit">
<div class="col-sm-12">


<div class="card-block">
<h5 class="sub-title">Tambah    </h5><hr>
<form id="formSubmit" action="javascript:submitForm('formSubmit')"
	 method="post" url="<?php echo base_url()?>kirim_info/insert">
	 <input type="hidden" id="formToken" name="<?php echo $this->m_reff->tokenName();?>" value="<?php echo $this->m_reff->getToken();?>">
 

<div class="form-group row">
<label class="col-sm-4 col-form-label">Judul </label>
<div class="col-sm-8">
<input type="text" name="f[judul]"   required class="form-controls">
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

<div class="form-group row">
<label class="col-sm-12 col-form-label">Isi pesan</label>
<div class="col-sm-12">
	<textarea id="tambah" name="f[isi]" rows="25" class="form-controls"></textarea>
</div>
</div>





<div class="form-group row">
<label class="col-sm-4 col-form-label">type file</label>
<div class="col-sm-8">
    
	<div class="radio d-inline-block mr-3">
	<label> 	<input type="radio" name="f[type_file]" value="1"  >
		Gambar</label>
	</div>
	<!-- <div class="radio d-inline-block mr-3">
	<label> 	<input type="radio" name="f[type_file]" value="2"  >
		Video</label>
	</div> -->

		<div class="radio d-inline-block mr-3">
			<label><input type="radio" name="f[type_file]" value="3" >
			 File</label>
		</div>
</div>

</div>


<div class="form-group row">
<label class="col-sm-4 col-form-label">Upload file </label>
<div class="col-sm-8">
<input type="file" name="gambar"     class="form-controls">
</div>
</div>


 <center>
 <button class="btn btn-primary mb-5 pull-right" onclick="javascript:submitForm('formSubmit')"><i class="fa fa-save"></i> SIMPAN</button>
 </center>
</form>


</div>
</div>

</div>

<script>
  CKEDITOR.replace('tambah',{
 height  : '130px', 
      
 }); 
 </script>
