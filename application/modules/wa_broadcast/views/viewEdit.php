<?php
$get_controller = $this->router->fetch_class();
$id = (null !== $this->input->post('id')) ? $this->input->post('id') : '';
$q = $this->mdl->getById($id);
$nama = ($q->num_rows()) ? $q->row()->nama : '' ;
?>
<div class="modal-content">
    <div class="modal-header">  <h5 class="modal-titles" id="defaultModalLabel"><b>Group Broadcast</b></h5>
		<button type="button" class="close" aria-label="Close" data-dismiss="modal">
	    	<span aria-hidden="true">×</span>
		</button>
	</div>


	<div class="modal-body">
		<form  action="javascript:submitForm('modal')" id="modal" url="<?php echo site_url($get_controller.'/update_data')?>"  method="post">
			<input type="hidden" name="id" value="<?php echo $id;?>">
			<input type="hidden" id="formToken" name="<?php echo $this->m_reff->tokenName()?>" value="<?php echo $this->m_reff->getToken()?>">

			<div class="form-group">
				<h6 class="card-titles ">Nama Group</h6>
				<div class="pos-relative -mt-2">
					<input type="text" name="f[nama]" value="<?= $nama;?>" class='form-control'>
				</div> 
			</div>

			<div class="col-lg-12 p-1">
				<center>
					<button class="btn btn-success button_save" onclick="submitForm('modal')"><i class="fa fa-save"></i> simpan</button>
				</center>
			</div>
		</form>
	</div>
</div>
