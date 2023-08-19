<?php
$get_controller = $this->router->fetch_class();
$id_pegawai = ''; ?>
<div class="modal-content">
    <div class="modal-header">  <h5 class="modal-titles" id="defaultModalLabel"><b>Import Data PNS</b></h5>
		<button type="button" class="close" aria-label="Close" data-dismiss="modal">
	    	<span aria-hidden="true">×</span>
		</button>
	</div>


	<div class="modal-body">
		<form  action="javascript:submitForm('modal')" id="modal" url="<?php echo site_url($get_controller.'/import_file_pns')?>"  method="post" enctype="multipart/form-data">
			<input type="hidden" id="formToken" name="<?php echo $this->m_reff->tokenName()?>" value="<?php echo $this->m_reff->getToken()?>">
			<?php 
			echo form_hidden('group', $this->input->post('group')); ?>

			<table class="table table-bordered mg-b-0 text-md-nowrap">
				<tr>
					<td align='center' colspan="2">
						<a href="<?php echo base_url()?>plug/format_pegawai.xlsx">
							Download Format File disini 
						</a>
					</td>
				</tr>
				<tr>
					<td>Istana</td>
					<td>
						<?php
                        $dataIstana=$this->db->get('tr_istana');

                        $options = array('' => '=== Pilih Istana ===',);
                        foreach ($dataIstana->result() as $di) {
                            $options[$di->kode] = $di->istana;
                        }

                        $attr = array('class' => 'custom-select', 'required' => 'required','onchange'=>'dataBiro(this.value)');
                        echo form_dropdown('kode_istana', $options, null, $attr);
                        unset($options);
                        unset($attr);
                        ?>
					</td>
				</tr>
				<tr id="dataBiro">
					<td>Biro</td>
					<td>
						<?php
                        $dataBiro=$this->db->get('tr_biro');

                        $options = array('' => '=== Pilih Biro ===',);
                        foreach ($dataBiro->result() as $db) {
                            $options[$db->kode] = $db->biro;
                        }

                        $attr = array('class' => 'custom-select');
                        echo form_dropdown('kode_biro', $options, null, $attr);
                        unset($options);
                        unset($attr);
                        ?>
					</td>
				</tr>
				<tr>
					<td>Upload file </td>
					<td>
						<div class="custom-files">
							<input   type="file" id="userfile" name="userfile" accept=".xlsx" required>  
						</div>
					</td> 
				</tr>
			</table>

			<div class="col-lg-12 p-1">
				<center>
					<button class="btn btn-success button_save" onclick="submitForm('modal')"><i class="fas fa-upload"></i> Upload File</button>
				</center>
			</div>
		</form>
	</div>
</div>

<script>
$("#dataBiro").hide();
function dataBiro(id) {
	var is = id.toLowerCase();
	if(is=="<?php echo $this->m_reff->kode_istana_jakarta()?>"){
  	    $("#dataBiro").show();
	}else {
		$("#dataBiro").hide();
	}
}
</script>