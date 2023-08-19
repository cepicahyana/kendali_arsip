<?php
$notif_pengajuan	 = isset($notif->notif_pengajuan)?($notif->notif_pengajuan):0;
$notif_hasil		 = isset($notif->notif_hasil)?($notif->notif_hasil):0;
?>
	                <div class="modal-content">
                         <div class="modal-header">  <h5 class="modal-titles" id="defaultModalLabel"><b>
                            Informasi !!
                            </b></h5>
						<button type="button" class="close" aria-label="Close" data-dismiss="modal">
                        <!-- <span aria-hidden="true">×</span> -->
						</button>
                    </div>


                        <div class="modal-bodys" ><br>

<form  action="javascript:submitForm('modal')" id="modal" url="<?php echo base_url()?>kendali_data_ppnpn/insert_data"  method="post" enctype="multipart/form-data">
<input type="hidden" id="formToken" name="<?php echo $this->m_reff->tokenName()?>" value="<?php echo $this->m_reff->getToken()?>">

				 
   <div class="col-md-12 col-lg-12 col-xl-12 mx-auto d-block" data-select2-id="13" id="loading">
										<div >

  
 
<div id="form_akun">
 
<div class="pos-relative  ml-2">
<div class="row card-body ">
 

<table width="100%" class="entry">
    <tr>
        <td>Permohonan baru</td><td> <?=$notif_pengajuan?></td> 
</tr>
    <tr>
        <td>Hasil tes baru</td><td> <?=$notif_hasil?></td>
</tr>
</table>
 

 <div class="col-lg-12 p-1"><center>
<a href="<?php echo base_url()?>input" class="btn btn-warning cursor" onclick="submitForm('modal')"> Lihat pembaharuan </a>
</center>
</div>

</form>








</div>


</div>
</div>

   