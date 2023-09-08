<?php
$id = $this->m_reff->san($this->input->post("id"));
$val = $this->db->get_where("ars_tr_up",array("id"=>$id))->row();

$id = isset($val->id)?($val->id):null;
$uuid = isset($val->uuid)?($val->uuid):"";
$uk_uuid = isset($val->uk_uuid)?($val->uk_uuid):"";
$description = isset($val->description)?($val->description):null;
$organisasi_kode = isset($val->organisasi_kode)?($val->organisasi_kode):"";
?>

 


<div class="modal-body">
<form  action="javascript:submitForm('modal')" id="modal" url="<?php echo base_url()?>ars_master/update_unit_pengelola"  method="post" enctype="multipart/form-data">
			<input type="hidden" value="<?php echo $id?>" name="id">
			<input type="hidden" id="formToken" name="<?php echo $this->m_reff->tokenName()?>" value="<?php echo $this->m_reff->getToken()?>">
			<div class="row row-xs align-items-center mg-b-20">
				<div class="col-md-4">
					<label class="form-label mg-b-0 text-black">Unit Kearsipan </label>
				</div>
				<div class="col-md-8 mg-t-5 mg-md-t-0">
				<?php 
				$valray=array();
				$valray[""]="=== Pilih ===";
				$db = $this->db->order_by('description','ASC');
				$db = $this->db->get('ars_tr_uk')->result();
				foreach($db as $v)
				{
					$valray[$v->uuid]=$v->description;
				}
				echo form_dropdown("f[uk_uuid]",$valray,$uk_uuid,'class="form-control select2 pb-2 text-black" style="width:100%" ');
				?>
				</div>
			</div>
			<div class="row row-xs align-items-center mg-b-20">
				<div class="col-md-4">
					<label class="form-label mg-b-0 text-black">Organisasi </label>
				</div>
				<div class="col-md-8 mg-t-5 mg-md-t-0">
				<?php 
				$valray=array();
				$valray[""]="=== Pilih ===";
				$db = $this->db->get('ars_tr_organisasi')->result();
				foreach($db as $v)
				{
					$valray[$v->kode]=$v->nama;
				}
				echo form_dropdown("f[organisasi_kode]",$valray,$organisasi_kode,'id="organisasi" class="form-control select2 pb-2" style="width:100%" required');
				?>
				</div>
			</div>
			<div class="row row-xs align-items-center mg-b-20">
				<div class="col-md-4">
					<label class="form-label mg-b-0 text-black">Description </label>
				</div>
				<div class="col-md-8 mg-t-5 mg-md-t-0">
				<input type="text" class="form-control" name="f[description]" value="<?php echo $description ?>" placeholder="Description">
				</div>
			</div>
			
			 
		 


<div align="right">
<hr>
	 <button  onclick="submitForm('modal')" class="btn btn-primary pd-x-30 mg-r-5 mg-t-5"><i class='fa fa-save'></i> Simpan</button>
 </div>
 
</form>				
</div>
<script>
	$(function() {
		$('.select2').select2();
	});
	// function get_parent_unit_kearsipan(kd) {
	// 	var url   = "<?php echo site_url("ars_master/get_parent_unit_kearsipan");?>";
    //     var param = {<?php echo $this->m_reff->tokenName()?>:token,kd: kd, action:'form'};
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
</script>
 
 
 