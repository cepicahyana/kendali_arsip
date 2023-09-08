<?php
$id = $this->m_reff->san($this->input->post("id"));
$val = $this->db->get_where("ars_trx_box",array("uuid"=>$id))->row();

$id = isset($val->id)?($val->id):null;
$uuid = isset($val->uuid)?($val->uuid):null;
$box_uuid=$val->box_uuid??'';
$code=$val->code??'';
$nomor=$val->nomor??'';
$deskripsi=$val->deskripsi??'';
$status=$val->status??'';
$tahun=substr($code,1,4);
?>

 


<div class="modal-body">
<form  action="javascript:submitForm('modal')" id="modal" url="<?php echo base_url()?>ars_master/update_box"  method="post" enctype="multipart/form-data">
			<input type="hidden" value="<?php echo $uuid?>" name="uuid">
			<input type="hidden" id="formToken" name="<?php echo $this->m_reff->tokenName()?>" value="<?php echo $this->m_reff->getToken()?>">
			<!-- <div class="row row-xs align-items-center mg-b-20">
				<div class="col-md-4">
					<label class="form-label mg-b-0 text-black">Unit Kearsipan </label>
				</div>
				<div class="col-md-8 mg-t-5 mg-md-t-0">
				<.?php 
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
			</div> -->
			<?php if($uuid){?>
			<div class="row row-xs align-items-center mg-b-20">
				<div class="col-md-4">
					<label class="form-label mg-b-0 text-black">Tahun </label>
				</div>
				<div class="col-md-8 mg-t-5 mg-md-t-0">
					<input class="form-control" name="tahun" value="<?php echo $tahun ?>" placeholder="Tahun" type="text">
				</div>
			</div>
			<div class="row row-xs align-items-center mg-b-20">
				<div class="col-md-4">
					<label class="form-label mg-b-0 text-black">Kode </label>
				</div>
				<div class="col-md-8 mg-t-5 mg-md-t-0">
					<input class="form-control" name="f[code]" value="<?php echo $code ?>" placeholder="Kode" type="text">
				</div>
			</div>
			<div class="row row-xs align-items-center mg-b-20">
				<div class="col-md-4">
					<label class="form-label mg-b-0 text-black">Nomor </label>
				</div>
				<div class="col-md-8 mg-t-5 mg-md-t-0">
					<input class="form-control" name="f[nomor]" value="<?php echo $nomor ?>" placeholder="Nomor" type="text">
				</div>
			</div>
			<div class="row row-xs align-items-center mg-b-20">
				<div class="col-md-4">
					<label class="form-label mg-b-0 text-black">Deskripsi </label>
				</div>
				<div class="col-md-8 mg-t-5 mg-md-t-0">
				<input type="text" class="form-control" name="f[deskripsi]" value="<?php echo $deskripsi ?>" placeholder="Deskripsi">
				</div>
			</div>
			<?php }else{ ?>
			<div class="row row-xs align-items-center mg-b-20">
				<div class="col-md-4">
					<label class="form-label mg-b-0 text-black">Tahun </label>
				</div>
				<div class="col-md-8 mg-t-5 mg-md-t-0">
					<input class="form-control" name="tahun" value="<?php echo date('Y') ?>" placeholder="Tahun" type="text">
				</div>
			</div>
			<div class="row row-xs align-items-center mg-b-20">
				<div class="col-md-4">
					<label class="form-label mg-b-0 text-black">Jumlah Box</label>
				</div>
				<div class="col-md-8 mg-t-5 mg-md-t-0">
				<input type="number" class="form-control" name="jumlah" placeholder="Jumlah Box">
				</div>
			</div>
			<?php }?>
			
			
			 
		 


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
</script>
 
 
 