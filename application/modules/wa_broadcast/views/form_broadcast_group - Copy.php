<?php
$get_controller = $this->router->fetch_class();
$id_pegawai = ''; ?>
<div class="modal-content">
    <div class="modal-header">  <h5 class="modal-titles" id="defaultModalLabel"><b>Broadcast Group</b></h5>
		<button type="button" class="close" aria-label="Close" data-dismiss="modal">
	    	<span aria-hidden="true">×</span>
		</button>
	</div>


	<div class="modal-body">
		<form  action="javascript:submitForm('modal')" id="modal" url="<?php echo site_url($get_controller.'/insert_group_kontak')?>"  method="post">
			<input type="hidden" id="formToken" name="<?php echo $this->m_reff->tokenName()?>" value="<?php echo $this->m_reff->getToken()?>">

			<div class="form-group">
				<h6 class="card-titles ">Pesan</h6>
				<div class="pos-relative -mt-2">
					<textarea class="form-control" placeholder="Textarea" rows="12"></textarea>
				</div> 
			</div>

			<div class="col-lg-12 p-1">
				<center>
					<button class="btn btn-success button_save" onclick="submitForm('modal')"><i class="icon ion-md-paper-plane"></i> Kirim Pesan</button>
				</center>
			</div>
		</form>
	</div>
</div>