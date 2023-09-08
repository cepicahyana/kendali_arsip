<?php
$id = $this->m_reff->san($this->input->post("id"));
$val = $this->db->get_where("ars_tr_jra",array("uuid"=>$id))->row();

$id=$val->id??null;
$uuid=$val->uuid??null;
$nama=$val->nama??'';
$deskripsi=$val->deskripsi??'';
$retensi_aktif=$val->retensi_aktif??null;
$retensi_aktif_deskripsi=$val->retensi_aktif_deskripsi??null;
$retensi_inaktif=$val->retensi_inaktif??null;
$retensi_inaktif_deskripsi=$val->retensi_inaktif_deskripsi??null;
$tindak_lanjut_uuid=$val->tindak_lanjut_uuid??null;
$status=$val->status??'';
?>

 


<div class="modal-body">
<form  action="javascript:submitForm('modal')" id="modal" url="<?php echo base_url()?>ars_master/update_jra"  method="post" enctype="multipart/form-data">
			<input type="hidden" value="<?php echo $uuid?>" name="uuid">
			<input type="hidden" id="formToken" name="<?php echo $this->m_reff->tokenName()?>" value="<?php echo $this->m_reff->getToken()?>">
			<div class="row row-xs align-items-top mg-b-20">
				<div class="col-md-2">
					<label class="form-label mg-b-0 text-black">Nama </label>
				</div>
				<div class="col-md-9 mg-t-5 mg-md-t-0">
				<textarea class="form-control" name="f[nama]" placeholder="Nama" rows=5><?php echo $nama ?></textarea>
				</div>
			</div>
			<div class="row row-xs align-items-top mg-b-20">
				<div class="col-md-2">
					<label class="form-label mg-b-0 text-black">Deskripsi </label>
				</div>
				<div class="col-md-9 mg-t-5 mg-md-t-0">
				<textarea class="form-control" name="f[deskripsi]" placeholder="Deskripsi" rows=5><?php echo $deskripsi ?></textarea>
				</div>
			</div>
			<div class="row row-xs align-items-center mg-b-20">
				<div class="col-md-2">
					<label class="form-label mg-b-0 text-black">Retensi Aktif </label>
				</div>
				<div class="col-md-6 mg-t-5 mg-md-t-0">
					<div class="input-group mb-3">
						<input class="form-control" name="f[retensi_aktif]" value="<?php echo $retensi_aktif ?>" placeholder="Retensi Aktif" type="number">
						<div class="input-group-append">
							<span class="input-group-text">Tahun</span>
						</div>
						<input class="form-control" name="f[retensi_aktif_deskripsi]" value="<?php echo $retensi_aktif_deskripsi ?>" placeholder="Deskripsi Retensi Aktif" type="text">
					</div>
				</div>
			</div>
			<div class="row row-xs align-items-center mg-b-20">
				<div class="col-md-2">
					<label class="form-label mg-b-0 text-black">Retensi In Aktif </label>
				</div>
				<div class="col-md-6 mg-t-5 mg-md-t-0">
					<div class="input-group mb-3">
						<input class="form-control" name="f[retensi_inaktif]" value="<?php echo $retensi_inaktif ?>" placeholder="Retensi In Aktif" type="number">
						<div class="input-group-append">
							<span class="input-group-text">Tahun</span>
						</div>
						<input class="form-control" name="f[retensi_inaktif_deskripsi]" value="<?php echo $retensi_inaktif_deskripsi ?>" placeholder="Deskripsi Retensi In Aktif" type="text">
					</div>
				</div>
			</div>
			<div class="row row-xs align-items-center mg-b-20">
				<div class="col-md-2">
					<label class="form-label mg-b-0 text-black">Tindak Lanjut </label>
				</div>
				<div class="col-md-6 mg-t-5 mg-md-t-0">
				<?php 
				$valray=array();
				$valray[""]="=== Pilih ===";
				$db = $this->db->order_by('id','ASC');
				$db = $this->db->get('ars_tr_tindak_lanjut')->result();
				foreach($db as $v)
				{
					$valray[$v->uuid]=$v->nama;
				}
				echo form_dropdown("f[tindak_lanjut_uuid]",$valray,$tindak_lanjut_uuid,'class="form-control select2 pb-2 text-black" style="width:100%" ');
				?>
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
 
 
 