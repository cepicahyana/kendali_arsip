<?php
$id	=	$this->input->post("id");
$this->db->where("id",$id);
$db	=	$this->db->get("tr_istana")->row();
if(!isset($db)){ return false;}

?>
<div class="row" id="area_formSubmit">
	<div class="col-sm-12">

		<div class="card-block">
		<h5 class="sub-title">Edit  </h5><hr>

		<form id="formSubmit" action="javascript:submitForm('formSubmit')" method="post"
		url="<?php echo base_url()?>mistana/update">
				<input type="hidden" name="id" value="<?php echo $db->id;?>">
				 
				<div class="form-group row">
					<label class="col-sm-4 col-form-label">Nama Istana</label>
						<div class="col-sm-8">
							<input type="text" name="f[nama]" value="<?php echo $db->nama; ?>"   required class="form-controls">
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

