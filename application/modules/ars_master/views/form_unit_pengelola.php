<?php
$id = $this->m_reff->san($this->input->get_post("id"));
$val = $this->db->get_where("ars_tr_up",array("uuid"=>$id))->row();

$id = isset($val->id)?($val->id):null;
$uuid = isset($val->uuid)?($val->uuid):null;
$uk_uuid = isset($val->uk_uuid)?($val->uk_uuid):null;
$description = isset($val->description)?($val->description):null;
$organisasi_kode = isset($val->organisasi_kode)?($val->organisasi_kode):null;
$status = isset($val->status)?($val->status):null;
?>

 
<div id="form_isi" class="card">  
	<div class="card-header d-flex justify-content-between">
		<h4 class="text-left" id="formhead"><?= $formhead??'' ?></h4>
		<div class="pull-right">
			<a href="<?php echo site_url("ars_master/unit_pengelola");?>" class="btn btn-secondary pd-x-30 mg-r-5 mg-t-5 menuclick">Kembali</a>
		</div>
	</div>         
	<div class="row card-body" style='padding-top:10px;padding-bottom:20px'>
		<div class="col-md-12" id="area_lod">

			<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
			<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

			<form  action="javascript:submitForm('modal')" id="modal" url="<?php echo base_url()?>ars_master/update_unit_pengelola"  method="post" enctype="multipart/form-data">
						<input type="hidden" value="<?php echo $uuid?>" name="uuid">
						<input type="hidden" id="formToken" name="<?php echo $this->m_reff->tokenName()?>" value="<?php echo $this->m_reff->getToken()?>">
						<div class="row row-xs align-items-center mg-b-20">
							<div class="col-md-3">
								<label class="form-label mg-b-0 text-black">Unit Kearsipan </label>
							</div>
							<div class="col-md-9 mg-t-5 mg-md-t-0">
							<?php 
							$valray=array();
							$valray[""]="=== Pilih ===";
							$db = $this->db->order_by('description','ASC');
							$db = $this->db->get('ars_tr_uk')->result();
							foreach($db as $v)
							{
								if($v->type==1){
									$type="Unit Kearsipan I";
								}
								if($v->type==2){
									$type="Unit Kearsipan II";
								}
								if($v->type==3){
									$type="Unit Kearsipan III";
								}
								$valray[$v->uuid]=$type;
							}
							echo form_dropdown("f[uk_uuid]",$valray,$uk_uuid,'class="form-control select2 pb-2 text-black" style="width:100%" ');
							?>
							</div>
						</div>
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
							echo form_dropdown("f[organisasi_kode]",$valray,$organisasi_kode,'id="organisasi" class="form-control select2 pb-2" style="width:100%" onchange="get_up_employe(this.value)" required');
							?>
							</div>
						</div>
						<div class="row row-xs align-items-center mg-b-20">
							<div class="col-md-3">
								<label class="form-label mg-b-0 text-black">Description </label>
							</div>
							<div class="col-md-9 mg-t-5 mg-md-t-0">
							<input type="text" class="form-control" name="f[description]" value="<?php echo $description ?>" placeholder="Description">
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

						<div id="area_employe_up"></div>
						
						
					


			<div align="right">
				<hr>
				<a href="<?php echo site_url("ars_master/unit_pengelola");?>" class="btn btn-secondary pd-x-30 mg-r-5 mg-t-5 menuclick">Kembali</a>
				<button  onclick="submitForm('modal')" class="btn btn-primary pd-x-30 mg-r-5 mg-t-5"><i class='fa fa-save'></i> Simpan</button>
			</div>
			
			</form>		

		</div>
	</div>
</div>	
<script>
	$(function() {
		$('.select2').select2({
			dropdownParent: $('#form_isi'),
			tags: true,
			placeholder: "=== Pilih ===",
			allowClear: true,
			width: '100%'
		});
		<?php if($uuid && $organisasi_kode){?>
			get_up_employe(`<?=$organisasi_kode?>`,`<?=$uuid?>`);
		<?php }?>
	});
	// function get_parent_unit_kearsipan(kd) {
	// 	var url   = "<.?php echo site_url("ars_master/get_parent_unit_kearsipan");?>";
    //     var param = {<.?php echo $this->m_reff->tokenName()?>:token,kd: kd, action:'form'};
    //     $.ajax({
	// 		type: "POST",dataType: "json",data: param, url: url,
	// 		success: function(val){
	// 		$("#parent_unit_kearsipan").html(val['data']);
	// 		token=val['token'];
	// 		}
	// 	});
	// }
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
	function get_up_employe(kd,uuid){
		var url   = "<?php echo site_url("ars_master/get_up_employe");?>";
        var param = {<?php echo $this->m_reff->tokenName()?>:token,kd: kd,uuid:uuid, action:'form'};
		$("#area_employe_up").html("<p class='text-center'>Mohon tunggu...</p>");
		$.ajax({
			type: "POST",dataType: "json",data: param, url: url,
			success: function(val){
				$("#area_employe_up").html(val['data']);
				token=val['token'];
			}
		});
	}
</script>
 
 
 