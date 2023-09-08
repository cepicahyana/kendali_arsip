<?php
$id = $this->m_reff->san($this->input->post("id"));
$data = $this->db->get_where("ars_trx_arsip",array("id"=>$id))->row();
$nama = isset($data->nama)?($data->nama):null;
$id = isset($data->id)?($data->id):null;
 
?>




<div class="modal-body">
    <form action="javascript:submitForm('modal')" id="modal" url="<?php echo base_url()?>ars_pemberkasan/update_arsip"
        method="post" enctype="multipart/form-data">
        <input type="hidden" value="<?php echo $id?>" name="id">
        <input type="hidden" id="formToken" name="<?php echo $this->m_reff->tokenName()?>"
            value="<?php echo $this->m_reff->getToken()?>">
        <div class="col-md-6">
            <div class="row row-xs align-items-center mg-b-20">
                <div class="col-md-4">
                    <label class="form-label mg-b-0 text-black">Jenis Arsip </label>
                </div>
                <div class="col-md-8 mg-t-5 mg-md-t-0">
                    <?php 
						$dataray=array();
						$dataray[""]="=== Pilih ===";
						$dataray["1"]="Konvensional";
						$dataray["2"]="Elektronik";
						echo form_dropdown("f[type]",$dataray,"",'class="select2 form-control text-black " style="width:100%" onchange="change_form_by_type(this.value)"');
					?>
                </div>
            </div>
		</div>

		<div class="col-md-6" id="submit_form">
            
		</div>

        <div align="right">
            <hr>
            <button onclick="submitForm('modal')" class="btn btn-primary pd-x-30 mg-r-5 mg-t-5"><i
                    class='fa fa-save'></i> Simpan</button>
        </div>

    </form>
</div>

<script type="text/javascript">
	$(".select2").select2();
	function change_form_by_type(type)
      {
        var url   = "<?php echo site_url("ars_pemberkasan/get_page");?>";
        var param = {<?php echo $this->m_reff->tokenName()?>:token,type:type};
        $.ajax({
			type: "POST",dataType: "json",data: param, url: url,
			success: function(val){
				$("#submit_form").html(val['data']);
				token=val['token'];
				$(".select2").select2();
				
				$('#periode').datepicker({
					format: 'mm-dd-yyyy'
				});
			}
		}); 
      }
</script>