<?php
$id	=	$this->input->post("id");
$this->db->where("id",$id);
$db	=	$this->db->get("data_informasi")->row();
if(!isset($db)){
	echo "data tidak ditemukan";
	return false;
}
$imgdata=isset($db->file_name)?($db->file_name):'';	
if ($db->sts==1){
	$checked1 = "checked";
	$checked2 = "";
}else {
	$checked1 = "";
	$checked2 = "checked";
}

$cek1=$cek2=$cek3="";
if($db->type_file==1){
    $cek1="checked";
  }elseif($db->type_file==2){
    $cek2="checked";
  }elseif($db->type_file==3){
    $cek3="checked";
  }

?>
<div class="row" id="area_formSubmit">
	<div class="col-sm-12">

		<div class="card-block">
		<h5 class="sub-title">Edit  </h5><hr>

		<form id="formSubmit" action="javascript:submitForm('formSubmit')" method="post"
		url="<?php echo site_url('kirim_info/update')?>" enctype="multipart/form-data">
				<input type="hidden" name="id" value="<?php echo $db->id;?>">
				<input type="hidden" id="formToken" name="<?php echo $this->m_reff->tokenName();?>" value="<?php echo $this->m_reff->getToken();?>">
				<input name="gambar_b" type="hidden" value="<?php echo $imgdata; ?>">
				 
				<div class="form-group row">
					<label class="col-sm-4 col-form-label">Judul  </label>
						<div class="col-sm-8">
							<input type="text" name="f[judul]" value="<?php echo $db->judul ?>"   required class="form-controls">
						</div>
				</div>

				<div class="form-group row">
					<label class="col-sm-4 col-form-label">Status  </label>
					<div class="col-sm-8">
						<div class="radio d-inline-block mr-3">
						<label>	<input type="radio" name="f[sts]" value="1" <?php echo $checked1 ?>>
							 Publish</label>
						</div>

							<div class="radio d-inline-block mr-3">
								<label><input type="radio" name="f[sts]" value="2" <?php echo $checked2 ?>>
								 Draft</label>
							</div>
					</div>

				</div>
				<div class="form-group row">
					<label class="col-sm-12 col-form-label">Isi pesan </label>
						<div class="col-sm-12">
							<textarea id="edit" name="f[isi]" rows="100" class="form-controls"><?php echo $db->isi ?></textarea>
						</div>
				</div>




<div class="form-group row">
<label class="col-sm-4 col-form-label">type file</label>
<div class="col-sm-8">
    
	<div class="radio d-inline-block mr-3">
	<label> 	<input <?php echo $cek1?> type="radio" name="f[type_file]" value="1"  >
		Gambar</label>
	</div>
	<!-- <div class="radio d-inline-block mr-3">
	<label> 	<input <?php echo $cek2?> type="radio" name="f[type_file]" value="2"  >
		Video</label>
	</div> -->

		<div class="radio d-inline-block mr-3">
			<label><input <?php echo $cek3?> type="radio" name="f[type_file]" value="3" >
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
			<button class="btn btn-primary mb-3 pull-right" onclick="javascript:submitForm('formSubmit')"><i class="fa fa-save"></i> SIMPAN</button>
		 </center>
		</form>

		</div>
	</div>
</div>


<script>
  CKEDITOR.replace('edit',{
 height  : '130px', 
      
 }); 
 </script>

