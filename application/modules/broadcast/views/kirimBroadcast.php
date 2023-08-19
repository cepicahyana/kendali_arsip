<?php
   $data =  $this->input->post("data");
   $jml  =  count($this->m_reff->clearkomaray($data));
  if(!$data){
      $jml = 0;
  }
?>
<form class="form-horizontal" id="modal" action="javascript:submitForm('modal')" 
method="post" url="<?php echo base_url()?>broadcast/sendBroadcast">
<input type="hidden" id="formToken" name="<?php echo $this->m_reff->tokenName()?>" value="<?php echo $this->m_reff->getToken()?>">
<input type="hidden" name="data" value="<?php echo $data;?>">
<div class='card-body'>
    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="cards">
                                <div class="card-bodys">
                                    <b class="text-black">Whatsapp</b>
                                    <textarea class="form-control" name="f[wa]" style="min-height:280px"><?php echo $this->m_reff->notifikasi(6,"wa");?></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- <div class="col-lg-6 col-md-12">
                            <div class="cards">
                                <div class="card-bodys">
                                <b  class="text-black">E-mail</b>
                                <div class="input-group" style="padding-bottom:5px">
											<div class="input-group-prepend">
												<span class="input-group-text" id="basic-addon1">Subject</span>
									                </div><input  name="f[subject]"  aria-describedby="basic-addon1" name="wa" aria-label="wa" class="form-control" placeholder="" type="text" value="<?php echo $this->m_reff->notifikasi(6,"subject");?>">
	                     </div>
                               <textarea   name="f[email]" class="form-control"  style="min-height:200px"><?php echo $this->m_reff->notifikasi(6,"email");?></textarea>
                               <div class="input-group" style="padding-top:5px">
											<div class="input-group-prepend">
												<span class="input-group-text" id="basic-addon1">Lampiran</span>
									                </div><input  name="lampiran" aria-describedby="basic-addon1" name="wa" aria-label="wa" class="form-control" placeholder="" type="file">
	                     </div> 
                            
                            </div>
                            </div>
                        </div> -->
    </div>
    <hr>
  
     <!-- <input placeholder="nomor whatsapp" type="text" class="form-control" id="nomor_coba" style="width:250px">         -->
     <div class="row">
<div class="col-md-6">

    
<b class="text-black">Pengkodean : </b><br>
{nama}  =  nama pegawai  <br>         
{email}  = alamat email   <br>         
{wa}  =  nomor whatsapp   <br>      
</div>

<?php
if($data){?>
<!-- <div class="col-md-6">
    <b style="margin-left:10px;color:black">Opsi pengiriman : </b><br>
                                            <div class="col-lg-12 mt-2">
									        	<label class="ckbox"><input checked name="o[]" value="wa" type="checkbox"><span>Whatsapp</span></label>
							                </div><br>
                                            <div class="col-lg-12">
									        	<label class="ckbox"><input checked name="o[]" value="email" type="checkbox"><span>E-mail</span></label>
							                </div>
                                          
</div> -->
<?php } ?>
</div>

<hr>
<div class="row">
 
 

<div class="col-md-6">
<b class="text-black"> kirimkan juga pesan ke nomor dibawah ini : </b>
<div class="input-group" style="width:350px">
											<div class="input-group-prepend">
												<span class="input-group-text" id="basic-addon1">Nomor WA</span>
									                </div><input  name="try_wa" aria-describedby="basic-addon1" name="wa" aria-label="wa" class="form-control" placeholder="" type="text">
	  </div> 
   
      <!-- <div class="input-group" style="width:350px;margin-top:10px">
											<div class="input-group-prepend">
												<span class="input-group-text" id="basic-addon1">E-mail</span>
									                </div><input   name="try_email"  aria-describedby="basic-addon1" type="email" name="email" aria-label="email" class="form-control" placeholder="" type="text">
	  </div>  -->
</div>
 

<div class="col-md-6">
    <div class="alert alert-info">
        <?php 
        if(!$data){
            echo " Tidak ada data pegawai yang dipilih";
        }else{
            echo " Jumlah data yang akan dikirim  : ".$jml." orang";
        }
       ?>
    </div>
</div>
</div>
      
<span class='btn-group'  style="float:right;">
<?php
if(!$data){
echo ' <button onclick="submitForm(`modal`)" class="pull-right btn btn-secondary" ><i class="fa fa-save"></i> Simpan</button>';
}else{
echo ' <button onclick="submitForm(`modal`)" class="pull-right btn btn-primary" ><i class="fa fa-paper-plane"></i> Kirim sekarang</button>';
}?>
</span>


 


</div>
<br>
<br></form>