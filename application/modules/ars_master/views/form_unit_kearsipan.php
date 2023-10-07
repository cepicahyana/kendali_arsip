<?php
$id = $this->m_reff->san($this->input->get_post("id"));
$val = $this->db->get_where("ars_tr_uk",array("uuid"=>$id))->row();

$id = isset($val->id)?($val->id):null;
$uuid = isset($val->uuid)?($val->uuid):null;
$type = isset($val->type)?($val->type):null;
$parent_uuid = isset($val->parent_uuid)?($val->parent_uuid):null;
$description = isset($val->description)?($val->description):null;
$status = isset($val->status)?($val->status):null;
$organization_kode = isset($val->organization_kode)?($val->organization_kode):null;
?>

<div id="form_isi" class="card">  
	<div class="card-header d-flex justify-content-between">
		<h4 class="text-left" id="formhead"><?= $formhead??'' ?></h4>
		<div class="pull-right">
			<a href="<?php echo site_url("ars_master/unit_kearsipan");?>" class="btn btn-secondary pd-x-30 mg-r-5 mg-t-5 menuclick">Kembali</a>
		</div>
	</div>         
	<div class="row card-body" style='padding-top:10px;padding-bottom:20px'>
		<div class="col-md-12" id="area_lod">

			<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
			<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

			<form  action="javascript:submitForm('modal')" id="modal" url="<?php echo base_url()?>ars_master/update_unit_kearsipan"  method="post" enctype="multipart/form-data">
					<input type="hidden" value="<?php echo $uuid?>" name="uuid">
					<input type="hidden" id="formToken" name="<?php echo $this->m_reff->tokenName()?>" value="<?php echo $this->m_reff->getToken()?>">
					<div class="row mg-b-20">
						<div class="col-md-12">
							<div class="row row-xs align-items-center mg-b-20">
								<div class="col-md-3">
									<label class="form-label mg-b-0 text-black">Unit Kearsipan </label>
								</div>
								<div class="col-md-9 mg-t-5 mg-md-t-0">
								<?php 
								$valray=array();
								$valray[""]="=== Pilih ===";
								$valray["1"]="Unit Kearsipan I";
								$valray["2"]="Unit Kearsipan II";
								$valray["3"]="Unit Kearsipan III";
								echo form_dropdown("f[type]",$valray,$type,'class="form-control text-black" style="width:100%" onchange="get_parent_unit_kearsipan(this.value)"');
								?>
								</div>
							</div>
							<div id="parent_uk" class="row row-xs align-items-center mg-b-20">
								<div class="col-md-3">
									<label class="form-label mg-b-0 text-black">Parent Unit Kearsipan </label>
								</div>
								<div class="col-md-9 mg-t-5 mg-md-t-0">
								<?php 
								$valray=array();
								$valray[""]="=== Pilih ===";
								if($uuid){
									$db = $this->db->order_by('description','ASC');
									$db = $this->db->where('type',$type);
									$db = $this->db->get('ars_tr_uk')->result();
									foreach($db as $v)
									{
										$stype="";
										if($v->type==1){
											$stype="Unit Kearsipan I";
										}
										if($v->type==2){
											$stype="Unit Kearsipan II";
										}
										if($v->type==3){
											$stype="Unit Kearsipan III";
										}

										if($val->organization_kode){
											$getOrg=$this->db->get_where("ars_tr_organisasi",array("kode"=>$v->organization_kode))->row();
											$nama_organisasi=$getOrg->nama??"";
										}else{
											$nama_organisasi="";
										}
										if($nama_organisasi){
											$valray[$v->uuid]=$stype.' ('.$nama_organisasi.')';
										}else{
											$valray[$v->uuid]=$stype;
										}
										
									}
								}
								echo form_dropdown("f[parent_uuid]",$valray,$uuid,'id="parent_unit_kearsipan" class="form-control select2 pb-2"  style="width:100%"');
								?>
								</div>
							</div>
							<div class="row row-xs align-items-top mg-b-20">
								<div class="col-md-3">
									<label class="form-label mg-b-0 text-black">Description </label>
								</div>
								<div class="col-md-9 mg-t-5 mg-md-t-0">
								<textarea class="form-control" name="f[description]" rows="3" placeholder="Description"><?php echo $description ?></textarea>
								<!-- <input type="text" class="form-control" name="f[description]" value="<.?php echo $description ?>" placeholder="Description"> -->
								</div>
							</div>
							<?php if($id){?>
							<div class="row row-xs align-items-center mg-b-20">
								<div class="col-md-3">
									<label class="form-label mg-b-0 text-black">Status </label>
								</div>
								<div class="col-md-9 mg-t-5 mg-md-t-0 d-flex justify-content-start">
									<label class="rdiobox pd-e-20"><input <?php if($status=='1'){echo 'checked';}?> name="f[status]" value="1" type="radio"><span>aktif</span></label>
									<label class="rdiobox"><input <?php if($status=='2'){echo 'checked';}?> name="f[status]" value="2" type="radio"><span>nonaktif</span></label>
								</div>
							</div>
							<?php }?>
							<div class="row row-xs align-items-center mg-b-20">
								<div class="col-md-3">
									<label class="form-label mg-b-0 text-black">Organisasi </label>
								</div>
								<div class="col-md-9 mg-t-5 mg-md-t-0">
								<?php 
								$valray=array();
								$valray[""]="=== Pilih ===";
								$db = $this->db->get('ars_tr_organisasi')->result();
								foreach($db as $v)
								{
									$valray[$v->kode]=$v->nama;
								}
								echo form_dropdown("f[organization_kode]",$valray,$organization_kode,'id="organisasi" class="form-control select2 pb-2" style="width:100%" onchange="get_uk_employe(this.value)" required');
								?>
								</div>
							</div>
				
							<div id="area_employe_uk"></div>
						</div>
						<!-- <div class="col-md-12">
							<div class="row row-xs align-items-center mg-b-20">
								<div class="col-md-12">
									
								</div>
							</div>
						</div> -->
					</div>

			<div align="right">
				<hr>
				<a href="<?php echo site_url("ars_master/unit_kearsipan");?>" class="btn btn-secondary pd-x-30 mg-r-5 mg-t-5 menuclick">Kembali</a>
				<button  onclick="submitForm('modal')" class="btn btn-primary pd-x-30 mg-r-5 mg-t-5"><i class='fa fa-save'></i> Simpan</button>
			</div>
			
			</form>	

		</div>
	</div>
</div>	
<script>
	$(function(){
		$('.select2').select2({
			dropdownParent: $('#form_isi'),
			tags: true,
			placeholder: "=== Pilih ===",
			allowClear: true,
			width: '100%'
		});
		<?php if($uuid && $organization_kode){?>
			get_uk_employe(`<?=$organization_kode?>`,`<?=$uuid?>`);
		<?php }?>
	}); 
	function get_parent_unit_kearsipan(kd) {
		var url   = "<?php echo site_url("ars_master/get_parent_unit_kearsipan");?>";
        var param = {<?php echo $this->m_reff->tokenName()?>:token,kd: kd, action:'form'};
		if(kd==1){
			$("#parent_uk").hide();
			$('[name="f[description]"]').val("");
		}else{
			$("#parent_uk").show();
			$.ajax({
				type: "POST",dataType: "json",data: param, url: url,
				success: function(val){
					$("#parent_unit_kearsipan").html(val['data']);
					$('[name="f[description]"]').val("");
					token=val['token'];
				}
			});
		}
        
	}
	$('#parent_unit_kearsipan').change(function(){
		var thisvaltext = $(this).find('option:selected').attr('dt');
		$('[name="f[description]"]').val(thisvaltext);
	});

	function get_uk_employe(kd,uuid){
		var url   = "<?php echo site_url("ars_master/get_uk_employe");?>";
        var param = {<?php echo $this->m_reff->tokenName()?>:token,kd: kd,uuid:uuid, action:'form'};
		$("#area_employe_uk").html("<p class='text-center'>Mohon tunggu...</p>");
		$.ajax({
			type: "POST",dataType: "json",data: param, url: url,
			success: function(val){
				$("#area_employe_uk").html(val['data']);
				token=val['token'];
			}
		});
	}
	// function get_organisasi(kd) {
	// 	var url   = "<.?php echo site_url("ars_master/get_organisasi");?>";
    //     var param = {<.?php echo $this->m_reff->tokenName()?>:token,kd: kd, action:'form'};
    //     $.ajax({
	// 		type: "POST",dataType: "json",data: param, url: url,
	// 		success: function(val){
	// 		$("#organisasi").html(val['data']);
	// 		token=val['token'];
	// 		}
	// 	});
	// }
</script>
 
 
 