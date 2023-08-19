<?php
$id	=	$this->input->post("id");
$this->db->where("id",$id);
$db	=	$this->db->get("tm_bidang")->row();

if ($db->sts==1){
	$checked1 = "checked";
	$checked2 = "";
}else {
	$checked1 = "";
	$checked2 = "checked";
}

?>
<div class="row" id="area_formSubmit">
	<div class="col-sm-12">

		<div class="card-block">
		<h5 class="sub-title">Edit  </h5><hr>

		<form id="formSubmit" action="javascript:submitForm('formSubmit')" method="post"
		url="<?php echo base_url()?>mbidang/update">
				<input type="hidden" name="id" value="<?php echo $db->id;?>">
				 
				<div class="form-group row">
					<label class="col-sm-4 col-form-label">Bidang Pekerjaan</label>
						<div class="col-sm-8">
							<input type="text" name="f[bidang]" value="<?php echo $db->bidang ?>"   required class="form-controls">
						</div>
				</div>

				<div class="form-group row">
					<label class="col-sm-4 col-form-label">Status</label>
					<div class="col-sm-8">
						<div class="radio d-inline-block mr-3">
						<label>	<input type="radio" name="f[sts]" value="1" <?php echo $checked1 ?>>
							 Aktif</label>
						</div>

						<div class="radio d-inline-block mr-3">
							<label><input type="radio" name="f[sts]" value="2" <?php echo $checked2 ?>>
							 Non Aktif</label>
						</div>
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

