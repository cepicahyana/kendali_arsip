<?php
$kode = $this->m_reff->san($this->input->post("kode"));
$kondisi = $this->m_reff->san($this->input->post("kondisi"));
$kode_utama = $this->m_reff->san($this->input->post("kodut"));
?>
	                <div class="modal-content">  
                         <div class="modal-header">  <h5 class="modal-titles" id="defaultModalLabel"><b>Update harian </b></h5>
						<button type="button" class="close" aria-label="Close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
						</button>
                    </div>


                        <div class="modal-body" >
					<center><b>Apa yang dirasakan saat ini:</b></center><hr>
					<form  action="javascript:submitForm('modal_kondisi')" 
					id="modal_kondisi" url="<?php echo base_url()?>dpegawai/update_kondisi_keluarga"  method="post" enctype="multipart/form-data">
 <input type="hidden" name="kondisi" value="<?php echo $kondisi?>">
 <input type="hidden" name="kode" value="<?php echo $kode?>">
 <input type="hidden" name="kode_utama" value="<?php echo $kode_utama?>">
 <input type="hidden" id="formToken" name="<?php echo $this->m_reff->tokenName()?>" value="<?php echo $this->m_reff->getToken()?>">
<?php
$data = $this->db->get("tr_gejala")->result();
foreach($data as $val){
echo '<div class="col-lg-12 p-1"> <label class="ckbox"><input type="checkbox" name="gejala[]" value="'.$val->nama.'"><span>'.$val->nama.'</span></label> </div>';
}?>
<div class="col-lg-12 p-1"> <span>yang dirasakan lainnya : <input type="text" name="gejala[]" class='form-control'> </span> </div>

 <!-- <div  onclick="set(`sembuh`)" class="cursor alert alert-outline-info" role="alert"> Sembuh</div> -->
 <div class="col-lg-12 p-1"><center>
<button class="btn btn-success" onclick="submitForm('modal_kondisi')"><i class="fa fa-save"></i> simpan</button>
</center>
</div>

</form>

</div>

</div>


 <script>

function reload_table(){
	// progress();
}


					 
 </script>




