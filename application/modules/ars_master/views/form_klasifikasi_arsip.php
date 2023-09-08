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
?>

 


<div class="modal-body">
<form  action="javascript:submitForm('modal')" id="modal" url="<?php echo base_url()?>ars_master/update_klasifikasi_arsip"  method="post" enctype="multipart/form-data">
			<input type="hidden" value="<?php echo $uuid?>" name="uuid">
			<input type="hidden" id="formToken" name="<?php echo $this->m_reff->tokenName()?>" value="<?php echo $this->m_reff->getToken()?>">
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
				echo form_dropdown("f[level]",$valray,$level,'class="form-control select2 pb-2 text-black" style="width:100%" onchange="change_level(this.value)"');
				?>
				</div>
			</div>
			<div id="for_level1">
				<input type="hidden" name="parent_kode1">
				<div class="row row-xs align-items-center mg-b-20">
					<div class="col-md-2">
						<label class="form-label mg-b-0 text-black">Kode </label>
					</div>
					<div class="col-md-9 mg-t-5 mg-md-t-0">
					<?php if($kode){?>
					<input type="text" class="form-control" value="<?php echo $kode ?>" placeholder="Kode" disabled>
					<input type="hidden" name="kode1" value="<?php echo $kode ?>">
					<?php }else{?>
					<input type="text" class="form-control" name="kode1" placeholder="Kode">
					<?php }?>
					</div>
				</div>
				<div class="row row-xs align-items-top mg-b-20">
					<div class="col-md-2">
						<label class="form-label mg-b-0 text-black">Nama </label>
					</div>
					<div class="col-md-9 mg-t-5 mg-md-t-0">
					<textarea class="form-control" name="nama1" placeholder="Nama" rows=5><?php echo $nama ?></textarea>
					</div>
				</div>
				<div class="row row-xs align-items-top mg-b-20">
					<div class="col-md-2">
						<label class="form-label mg-b-0 text-black">Deskripsi </label>
					</div>
					<div class="col-md-9 mg-t-5 mg-md-t-0">
					<textarea class="form-control" name="deskripsi1" placeholder="Deskripsi" rows=5><?php echo $deskripsi ?></textarea>
					</div>
				</div>
			</div>
			<div id="for_level2">
				<div class="row row-xs align-items-center mg-b-20">
					<div class="col-md-2">
						<label class="form-label mg-b-0 text-black">Parent Kode </label>
					</div>
					<div class="col-md-9 mg-t-5 mg-md-t-0">
					<?php 
					$valray=array();
					$valray[""]="=== Pilih ===";
					$this->db->where("level",1);
					$this->db->group_by("kode");
					$db = $this->db->get('ars_tr_kka')->result();
					foreach($db as $v)
					{
						$valray[$v->kode]=$v->kode.' - '.$v->nama;
					}
					echo form_dropdown("parent_kode2",$valray,$parent_kode,'class="form-control select2 pb-2" style="width:100%" onchange="get_kode_klasifikasi_arsip(this.value,2)"');
					?>
					</div>
				</div>
				<div class="row row-xs align-items-center mg-b-20">
					<div class="col-md-2">
						<label class="form-label mg-b-0 text-black">Kode </label>
					</div>
					<div class="col-md-9 mg-t-5 mg-md-t-0">
					<input type="text" id="kode2" class="form-control" value="<?php echo $kode ?>" placeholder="Kode" disabled>
					<input type="hidden" name="kode2" value="<?php echo $kode ?>">
					</div>
				</div>
				<div class="row row-xs align-items-top mg-b-20">
					<div class="col-md-2">
						<label class="form-label mg-b-0 text-black">Nama </label>
					</div>
					<div class="col-md-9 mg-t-5 mg-md-t-0">
					<textarea class="form-control" name="nama2" placeholder="Nama" rows=5><?php echo $nama ?></textarea>
					</div>
				</div>
				<div class="row row-xs align-items-top mg-b-20">
					<div class="col-md-2">
						<label class="form-label mg-b-0 text-black">Deskripsi </label>
					</div>
					<div class="col-md-9 mg-t-5 mg-md-t-0">
					<textarea class="form-control" name="deskripsi2" placeholder="Deskripsi" rows=5><?php echo $deskripsi ?></textarea>
					</div>
				</div>
			</div>
			<div id="for_level3">
				<div class="row row-xs align-items-center mg-b-20">
					<div class="col-md-2">
						<label class="form-label mg-b-0 text-black">Parent Kode </label>
					</div>
					<div class="col-md-9 mg-t-5 mg-md-t-0">
					<?php 
					$valray=array();
					$valray[""]="=== Pilih ===";
					$this->db->where("level",2);
					$this->db->group_by("kode");
					$db = $this->db->get('ars_tr_kka')->result();
					foreach($db as $v)
					{
						$valray[$v->kode]=$v->kode.' - '.$v->nama;
					}
					echo form_dropdown("parent_kode3",$valray,$parent_kode,'class="form-control select2 pb-2" style="width:100%" onchange="get_kode_klasifikasi_arsip(this.value,3)"');
					?>
					</div>
				</div>
				<div class="row row-xs align-items-center mg-b-20">
					<div class="col-md-2">
						<label class="form-label mg-b-0 text-black">Kode </label>
					</div>
					<div class="col-md-9 mg-t-5 mg-md-t-0">
					<input type="text" id="kode3" class="form-control" value="<?php echo $kode ?>" placeholder="Kode" disabled>
					<input type="hidden" name="kode3" value="<?php echo $kode ?>">
					</div>
				</div>
				<div class="row row-xs align-items-top mg-b-20">
					<div class="col-md-2">
						<label class="form-label mg-b-0 text-black">Nama </label>
					</div>
					<div class="col-md-9 mg-t-5 mg-md-t-0">
					<textarea class="form-control" name="nama3" placeholder="Nama" rows=5><?php echo $nama ?></textarea>
					</div>
				</div>
				<div class="row row-xs align-items-top mg-b-20">
					<div class="col-md-2">
						<label class="form-label mg-b-0 text-black">Deskripsi </label>
					</div>
					<div class="col-md-9 mg-t-5 mg-md-t-0">
					<textarea class="form-control" name="deskripsi3" placeholder="Deskripsi" rows=5><?php echo $deskripsi ?></textarea>
					</div>
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
		var id = $("[name='id']").val();
		var level = $("[name='f[level]']").val();
		if(level==1){
			$("#for_level1").show();
			$("#for_level2").hide();
			$("#for_level3").hide();
		}
		if(level==2){
			$("#for_level1").hide();
			$("#for_level2").show();
			$("#for_level3").hide();
		}
		if(level==3){
			$("#for_level1").hide();
			$("#for_level2").hide();
			$("#for_level3").show();
		}
		if(level==''){
			$("#for_level1").hide();
			$("#for_level2").hide();
			$("#for_level3").hide();
		}
	});
	function change_level(kd) {
		if(kd==1){
			$("#for_level1").show();
			$("#for_level2").hide();
			$("#for_level3").hide();
		}
		if(kd==2){
			$("#for_level1").hide();
			$("#for_level2").show();
			$("#for_level3").hide();
		}
		if(kd==3){
			$("#for_level1").hide();
			$("#for_level2").hide();
			$("#for_level3").show();
		}
	}
	function get_kode_klasifikasi_arsip(kd,lvl) {
		var url   = "<?php echo site_url("ars_master/get_kode_klasifikasi_arsip");?>";
        var param = {<?php echo $this->m_reff->tokenName()?>:token,kd: kd, level:lvl, action:'form'};
		if(kd){
			$.ajax({
				type: "POST",dataType: "json",data: param, url: url,
				success: function(val){
					if(lvl==2){
						$("#kode2").val(val['data']);
						$("[name='kode2']").val(val['data']);
					}
					if(lvl==3){
						$("#kode3").val(val['data']);
						$("[name='kode3']").val(val['data']);
					}
				token=val['token'];
				}
			});
		}
	}
</script>
 
 
 