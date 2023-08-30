<?php
$id = $this->m_reff->san($this->input->post("id"));
$data = $this->db->get_where("ars_tr_uk",array("id"=>$id))->row();

$id = isset($data->id)?($data->id):null;
$type = isset($data->type)?($data->type):"";
$uuid = isset($data->uuid)?($data->uuid):"";
$parent_uuid = isset($data->parent_uuid)?($data->parent_uuid):"";
$description = isset($data->description)?($data->description):null;
$organization_kode = isset($data->organization_kode)?($data->organization_kode):"";
?>

 


<div class="modal-body">
<form  action="javascript:submitForm('modal')" id="modal" url="<?php echo base_url()?>ars_master/update_unit_kearsipan"  method="post" enctype="multipart/form-data">
			<input type="hidden" value="<?php echo $id?>" name="id">
			<input type="hidden" id="formToken" name="<?php echo $this->m_reff->tokenName()?>" value="<?php echo $this->m_reff->getToken()?>">
			<div class="row row-xs align-items-center mg-b-20">
				<div class="col-md-4">
					<label class="form-label mg-b-0 text-black">Unit Kearsipan </label>
				</div>
				<div class="col-md-8 mg-t-5 mg-md-t-0">
				<?php 
				$dataray=array();
				$dataray[""]="=== Pilih ===";
				$dataray["1"]="Unit Kearsipan I";
				$dataray["2"]="Unit Kearsipan II";
				$dataray["3"]="Unit Kearsipan III";
				echo form_dropdown("f[type]",$dataray,$type,'class="form-control text-black" style="width:100%" onchange="get_parent_unit_kearsipan(this.value)"');
				?>
				</div>
			</div>
			<div class="row row-xs align-items-center mg-b-20">
				<div class="col-md-4">
					<label class="form-label mg-b-0 text-black">Parent Unit Kearsipan </label>
				</div>
				<div class="col-md-8 mg-t-5 mg-md-t-0">
				<?php 
				$dataray=array();
				$dataray[""]="=== Pilih ===";
				if($id){
					$db = $this->db->order_by('description','ASC');
					$db = $this->db->where('type',$type);
					$db = $this->db->get('ars_tr_uk')->result();
					foreach($db as $v)
					{
						$dataray[$v->uuid]=$v->description;
					}
				}
				echo form_dropdown("f[parent_uuid]",$dataray,$uuid,'id="parent_unit_kearsipan" class="form-control select2 pb-2"  style="width:100%"');
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
			<div class="row row-xs align-items-center mg-b-20">
				<div class="col-md-4">
					<label class="form-label mg-b-0 text-black">Organisasi </label>
				</div>
				<div class="col-md-8 mg-t-5 mg-md-t-0">
				<?php 
				$dataray=array();
				$dataray[""]="=== Pilih ===";
				$db = $this->db->get('ars_tr_organisasi')->result();
				foreach($db as $v)
				{
					$dataray[$v->kode]=$v->nama;
				}
				echo form_dropdown("f[organization_kode]",$dataray,$organization_kode,'id="organisasi" class="form-control select2 pb-2" style="width:100%" required');
				?>
				</div>
			</div>
			<?php
			// $form=array(
			// 	"name"  => "f[description]",
			// 	"title" => "Description",
			// 	"value" => $description
			// );
			// echo $this->form->input($form);
			?>
			
			 
		 


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
	function get_parent_unit_kearsipan(kd) {
		var url   = "<?php echo site_url("ars_master/get_parent_unit_kearsipan");?>";
        var param = {<?php echo $this->m_reff->tokenName()?>:token,kd: kd, action:'form'};
        $.ajax({
			type: "POST",dataType: "json",data: param, url: url,
			success: function(val){
			$("#parent_unit_kearsipan").html(val['data']);
			token=val['token'];
			}
		});
	}
	$('#parent_unit_kearsipan').change(function(){
		var thisvaltext = $(this).find('option:selected').text();
		$('[name="f[description]"]').val(thisvaltext);
	});
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
 
 
 