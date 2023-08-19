<?php
$id	=	$this->input->post("id");
$this->db->where("id",$id);
$db	=	$this->db->get("tr_istana")->row();
if(!isset($db)){
	echo "data istana tidak ditemukan";
	return false;
}
$istana = $db->istana ?? '';
$lat = $db->lat ?? '';
$lng = $db->lng ?? '';
$kode = $db->kode ?? '';
$max_jarak = $db->max_jarak ?? '';
$imgdata=isset($db->header)?($db->header):'';	
$dok=$this->m_reff->pengaturan(1)."dok/".$imgdata;
$dok = $this->konversi->img($dok);
if(!$dok){
	$kop_surat=base_url().'plug/img/kop-surat.jpg';
}else{
	$kop_surat=$dok;
}
  

?>
<div class="row" id="area_formSubmit">
	<div class="col-sm-12">

		<div class="card-block">
		<h5 class="sub-title">Edit  </h5><hr>

		<form id="formSubmit" action="javascript:submitForm('formSubmit')" method="post" url="<?php echo site_url()?>mistana/update" enctype="multipart/form-data">
				<input type="hidden" name="id" value="<?php echo $db->id;?>">
				<input name="kop_surat_b" type="hidden" value="<?php echo $imgdata; ?>">
				 
				<div class="form-group row">
					<label class="col-sm-4 col-form-label">Kode </label>
						<div class="col-sm-8">
							<input type="text" name="f[kode]" value="<?php echo set_value('f[kode]', $kode); ?>" required class="form-control">
						</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-4 col-form-label">Nama Istana</label>
						<div class="col-sm-8">
							<input type="text" name="f[istana]" value="<?php echo set_value('f[istana]', $istana); ?>" required class="form-control">
						</div>
				</div>

				<div class="form-group row">
					<label class="col-sm-4 col-form-label">Latitude</label>
					<div class="col-sm-8">
						<input type="text" name="f[lat]" value="<?php echo set_value('f[lat]', $lat); ?>" required class="form-control">
					</div>
				</div>

				<div class="form-group row">
					<label class="col-sm-4 col-form-label">Longitude</label>
					<div class="col-sm-8">
						<input type="text" name="f[lng]" value="<?php echo set_value('f[lng]', $lng); ?>" required class="form-control">
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-4 col-form-label">Mak Jarak Absen (Meter)</label>
					<div class="col-sm-8">
						<input type="text" name="f[max_jarak]" value="<?php echo set_value('f[max_jarak]', $max_jarak); ?>" required class="form-control">
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
				<div class="form-group row">
					<div class="col-sm-12">
						<img width="100%" height="120px" id="preview-kop-surat" src="<?php echo $kop_surat;?>">
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
function editpreviewFile(el) {
	var extension = $('#kop-surat').val().split('.').pop().toLowerCase();
	if(extension != ''){
		if(jQuery.inArray(extension, ['png','jpg','jpeg']) == -1)
		{
			alert("Image File must be .png / .jpg");
			$('#kop-surat').val('');
			return false;
		}
	}

	var a=(el.files[0].size);
	if(a > 3000000) {
			alert("Not allowed!, file size max 3 MB");
			$('#kop-surat').val('');
		return false;
	}

	if (el.files && el.files[0]) {
		var FR= new FileReader();
		FR.onload = function(e) {
			$("#preview-kop-surat").attr("src", e.target.result);
			socket.emit('image', e.target.result);
			console.log(e.target.result);
		};
		FR.readAsDataURL( el.files[0] );
	}
}
</script>