<?php
$id = $this->m_reff->san($this->input->post("id"));
$val = $this->db->get_where("ars_tr_kka",array("uuid"=>$id))->row();

$id=$val->id??null;
$uuid=$val->uuid??null;
$kode=$val->kode??'';
$parent_kode=$val->parent_kode??'';
$nama=$val->nama??'';
$deskripsi=$val->deskripsi??'';
$status=$val->status??'';
$level=$val->level??'';
$peraturan_id=$val->peraturan_id??'';
?>

 


<div class="modal-body">
<form  action="javascript:submitForm('modal')" id="modal" url="<?php echo base_url()?>ars_master/update_klasifikasi_arsip"  method="post" enctype="multipart/form-data">
			<input type="hidden" value="<?php echo $uuid?>" name="uuid">
			<input type="hidden" id="formToken" name="<?php echo $this->m_reff->tokenName()?>" value="<?php echo $this->m_reff->getToken()?>">
			<div class="row row-xs align-items-center mg-b-20">
				<div class="col-md-2">
					<label class="form-label mg-b-0 text-black">peraturan </label>
				</div>
				<div class="col-md-9 mg-t-5 mg-md-t-0">
				<?php 
				$valray=array();
				$valray[""]="=== Pilih ===";
				$this->db->where('status',1);
				$db = $this->db->get('ars_tr_peraturan')->result();
				foreach($db as $v)
				{
					$valray[$v->id]=$v->nama;
				}
				echo form_dropdown("f[peraturan_id]",$valray,$peraturan_id,'class="form-control select2 pb-2 text-black" style="width:100%" onchange="change_peraturan()" required');
				?>
				</div>
			</div>
			<div class="row row-xs align-items-center mg-b-20">
				<div class="col-md-2">
					<label class="form-label mg-b-0 text-black">Level </label>
				</div>
				<div class="col-md-9 mg-t-5 mg-md-t-0">
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
					$this->db->where("peraturan_id",$peraturan_id);
					$this->db->group_by("kode");
					$db = $this->db->get('ars_tr_kka')->result();
					foreach($db as $v)
					{
						$valray[$v->kode]=$v->kode.' - '.$v->nama;
					}
				}
				echo form_dropdown("parent_kode",$valray,$parent_kode,'id="parent_kode" class="form-control select2 pb-2" style="width:100%" onchange="get_kode_klasifikasi_arsip(this.value)"');
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

			
			 
		 


<div align="right">
<hr>
	 <button  onclick="submitForm('modal')" class="btn btn-primary pd-x-30 mg-r-5 mg-t-5"><i class='fa fa-save'></i> Simpan</button>
 </div>
 
</form>				
</div>
<script>
	$(function() {
		$('.select2').select2({
			dropdownParent: $('#mdl_modal'),
			tags: true,
			allowClear: true,
			width: '100%'
		});
	});
	function change_peraturan() {
		$("[name='f[level]']").val('');
		$("#level").val('');
		$("#area_parent_kode").show();
		$("#parent_kode").val([""]).trigger("change");
		$("[name='f[kode]']").val('');
		$("[name='f[nama]']").val('');
		$("[name='f[deskripsi]']").val('');
	}
	function change_level(kd) {
		var peraturan_id = $("[name='f[peraturan_id]']").val();
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
			var url   = "<?php echo site_url("ars_master/get_parent_kode_klasifikasi");?>";
			var param = {<?php echo $this->m_reff->tokenName()?>:token, peraturan_id:peraturan_id, level:level, action:'form'};
			$.ajax({
				type: "POST",dataType: "json",data: param, url: url,
				success: function(val){
					$("#parent_kode").html(val['data']);
					token=val['token'];
				}
			});
		}
		
		
		
	}
	function get_kode_klasifikasi_arsip(kd) {
		var peraturan_id = $("[name='f[peraturan_id]']").val();
		var level = $("[name='f[level]']").val();
		var url   = "<?php echo site_url("ars_master/get_kode_klasifikasi_arsip");?>";
        var param = {<?php echo $this->m_reff->tokenName()?>:token,kd: kd, peraturan_id:peraturan_id, level:level, action:'form'};
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
 
 
 