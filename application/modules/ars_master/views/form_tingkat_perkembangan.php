<?php
$id = $this->m_reff->san($this->input->post("id"));
$data = $this->db->get_where("ars_tr_tingkat_perkembangan",array("id"=>$id))->row();
$nama = isset($data->nama)?($data->nama):null;
$id = isset($data->id)?($data->id):null;
 
?>

 


<div class="modal-body">
<form  action="javascript:submitForm('modal')" id="modal" url="<?php echo base_url()?>ars_master/update_tingkat_perkembangan"  method="post" enctype="multipart/form-data">
			<input type="hidden" value="<?php echo $id?>" name="id">
			<input type="hidden" id="formToken" name="<?php echo $this->m_reff->tokenName()?>" value="<?php echo $this->m_reff->getToken()?>">
			 
		 <?php
		 $form=array(
			"name"  => "f[nama]",
			"title" => "Nama",
			"value" => $nama
		 );
		 echo $this->form->input($form);
		 ?>


<div align="right">
<hr>
	 <button  onclick="submitForm('modal')" class="btn btn-primary pd-x-30 mg-r-5 mg-t-5"><i class='fa fa-save'></i> Simpan</button>
 </div>
 
</form>				
</div>
 
 
 
 