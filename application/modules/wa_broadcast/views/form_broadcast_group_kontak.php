<?php
$get_controller = $this->router->fetch_class();
$id_pegawai = '';

$data =  $this->input->post("data");
$jml  =  count($this->m_reff->clearkomaray($data));
if(!$data){
	$jml = 0;
}
?>
<div class="modal-content">
    <div class="modal-header"><h5 class="modal-titles" id="defaultModalLabel"><b>Broadcast Kontak Group</b></h5>
		<button type="button" class="close" aria-label="Close" data-dismiss="modal">
	    	<span aria-hidden="true">×</span>
		</button>
	</div>


	<div class="modal-body">
		<form  action="javascript:submitForm('modal')" id="modal" url="<?php echo site_url($get_controller.'/sendBroadcast_group_kontak')?>" method="post" enctype="multipart/form-data">
			<input type="hidden" id="formToken" name="<?php echo $this->m_reff->tokenName()?>" value="<?php echo $this->m_reff->getToken()?>">
			<input type="hidden" name="data" value="<?php echo $data;?>">
			

			<div class="row">
				<div class="col-lg-12 col-md-12">
					<div class="cards">
						<div class="card-bodys">
						    <b class="text-black">Whatsapp</b>
						    <textarea class="form-control" name="f[wa]" style="min-height:280px"><?php echo $this->m_reff->notifikasi(2,"wa");?></textarea>
							<div>
								<table width="100%" style="margin-top:15px">
									<tr>
										<td width="100px">
									 
										<a href="https://upload.tukepegawaiansetpres.com/index.php" target="_blank">Lampiran</a>
								 
										</td>
										<td><input style="width:100%" name="lampiran" value="<?php echo $this->m_reff->notifikasi(2,"file");?>" type="text" class="form-control"> </td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>

				<!-- <div class="col-lg-6 col-md-12">
					<div class="cards">
						<div class="card-bodys">
							<b class="text-black">E-mail</b>
							<div class="input-group" style="padding-bottom:5px">
								<div class="input-group-prepend">
									<span class="input-group-text" id="basic-addon1">Subject</span>
						                </div><input  name="f[subject]"  aria-describedby="basic-addon1" name="wa" aria-label="wa" class="form-control" placeholder="" type="text" value="<?php echo $this->m_reff->notifikasi(2,"subject");?>">
							</div>
							<textarea   name="f[email]" class="form-control"  style="min-height:200px"><?php echo $this->m_reff->notifikasi(2,"email");?></textarea>
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
			<div class="row">
				<div class="col-md-6">
					<b class="text-black">Pengkodean : </b><br>
					{nama}  =  nama pegawai  <br>         
					{email}  = alamat email   <br>         
					{wa}  =  nomor whatsapp   <br>      
				</div>

				 
			</div>

			<hr>
			<div class="row">
				 
				<div class="col-md-6">
					<b class="text-black"> Uji coba kirim :</b>
					<div class="input-group" style="width:350px">
						<div class="input-group-prepend">
							<span class="input-group-text" id="basic-addon1">Nomor WA</span>
				        </div>
				        <input  name="try_wa" aria-describedby="basic-addon1" name="wa" aria-label="wa" class="form-control" placeholder="" type="text">
					</div>
				   
				    
				</div>
			 

				<div class="col-md-6"><br>
				    <div class="alert alert-info">
				        <?php 
				        if(!$data){
				            echo " Tidak ada data yang dipilih.";
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
				echo ' <button onclick="submitForm(`modal`)" class="pull-right btn btn-secondary" ><i class="fa fa-save"></i> Kirim sekarang</button>';
				}else{
				echo ' <button onclick="submitForm(`modal`)" class="pull-right btn btn-primary" ><i class="fa fa-paper-plane"></i> Kirim sekarang</button>';
				}?>
			</span>

		</form>
	</div>
</div>