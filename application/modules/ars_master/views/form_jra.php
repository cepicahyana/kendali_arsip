<?php
$id = $this->m_reff->san($this->input->post("id"));
$val = $this->db->get_where("ars_tr_jra",array("uuid"=>$id))->row();

$id=$val->id??'';
$uuid=$val->uuid??'';
$nama=$val->nama??'';
$deskripsi=$val->deskripsi??'';
$retensi_aktif=$val->retensi_aktif??'';
$retensi_aktif_deskripsi=$val->retensi_aktif_deskripsi??'';
$retensi_inaktif=$val->retensi_inaktif??'';
$retensi_inaktif_deskripsi=$val->retensi_inaktif_deskripsi??'';
$tindak_lanjut_uuid=$val->tindak_lanjut_uuid??'';
$status=$val->status??'';
$kode=$val->kode??'';
$parent_kode=$val->parent_kode??'';
$level=$val->level??'';
?>



<div class="modal-body">
<form  action="javascript:submitForm('modal')" id="modal" url="<?php echo base_url()?>ars_master/update_jra"  method="post" enctype="multipart/form-data">
			<input type="hidden" value="<?php echo $uuid?>" name="uuid">
			<input type="hidden" id="formToken" name="<?php echo $this->m_reff->tokenName()?>" value="<?php echo $this->m_reff->getToken()?>">
			<div class="row row-xs align-items-center mg-b-20">
				<div class="col-md-2">
					<label class="form-label mg-b-0 text-black">Level </label>
				</div>
				<div class="col-md-6 mg-t-5 mg-md-t-0">
				<?php 
				$valray=array();
				$valray[""]="=== Pilih ===";
				$valray["1"]="1";
				$valray["2"]="2";
				$valray["3"]="3";
				echo form_dropdown("f[level]",$valray,$level,'id="level" class="form-control pb-2 text-black" style="width:100%" onchange="change_level(this.value)"');
				?>
				</div>
			</div>
			<?php if($level!=1){?>
			<div id="area_parent_kode" class="row row-xs align-items-center mg-b-20">
				<div class="col-md-2">
					<label class="form-label mg-b-0 text-black">Parent Kode </label>
				</div>
				<div class="col-md-9 mg-t-5 mg-md-t-0">
				<?php 
				$valray=array();
				$valray[""]="=== Pilih ===";
				if($parent_kode){
					$this->db->group_by("kode");
					$db = $this->db->get('ars_tr_jra')->result();
					foreach($db as $v)
					{
						$valray[$v->kode]=$v->kode.' - '.$v->nama;
					}
				}
				echo form_dropdown("parent_kode",$valray,$parent_kode,'id="parent_kode" class="form-control select2 pb-2" style="width:100%" onchange="get_kode_jra(this.value)"');
				?>
				</div>
			</div>
			<?php } ?>
			<div class="row row-xs align-items-center mg-b-20">
				<div class="col-md-2">
					<label class="form-label mg-b-0 text-black">Kode </label>
				</div>
				<div class="col-md-9 mg-t-5 mg-md-t-0">
				<input type="text" id="kode" name="f[kode]" class="form-control" value="<?php echo $kode ?>" placeholder="Kode" <?php if($level>1){echo'readonly';}?>>
				</div>
			</div>
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

	function change_level(kd) {
		var level = $("[name='f[level]']").val();
		$("#area_parent_kode").show();
		$("#parent_kode").val([""]).trigger("change");
		$("[name='f[kode]']").val('');
		$("[name='f[nama]']").val('');
		$("[name='f[deskripsi]']").val('');
		if(level==1){
			$("#area_parent_kode").hide();
			$("[name='parent_kode']").val('');
			$("#kode").removeAttr('readonly');
		}
		if(level==2 || level==3){
			$("#area_parent_kode").show();
			$("#kode").attr('readonly',true);
			var url   = "<?php echo site_url("ars_master/get_parent_kode_jra");?>";
			var param = {<?php echo $this->m_reff->tokenName()?>:token, level:level, action:'form'};
			$.ajax({
				type: "POST",dataType: "json",data: param, url: url,
				success: function(val){
					$("#parent_kode").html(val['data']);
					token=val['token'];
				}
			});
		}
		
		
		
	}
	function get_kode_jra(kd) {
		var level = $("[name='f[level]']").val();
		var url   = "<?php echo site_url("ars_master/get_kode_jra");?>";
        var param = {<?php echo $this->m_reff->tokenName()?>:token,kd: kd, level:level, action:'form'};
		if(kd){
			$.ajax({
				type: "POST",dataType: "json",data: param, url: url,
				success: function(val){
					$("[name='f[kode]']").val(val['data']);
					token=val['token'];
				}
			});
		}else{
			$("[name='f[kode]']").val('');
		}
	}
</script>
 
 
 