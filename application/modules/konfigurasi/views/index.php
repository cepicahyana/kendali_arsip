    <style>
    textarea{
        min-height:100px;
    }
    </style>
 <div class="page-header">
		<div class="page-block">
			<div class="row align-items-center">
				<div class="col-md-12">
					<div class="page-header-title">
						<h5 class="m-b-10">Konfigurasi</h5>
					</div>
					<ul class="breadcrumb">
						<li class="breadcrumb-item"><a   href="#"><i class="fa fa-cogs"></i></a></li>
						<li class="breadcrumb-item"><a href="#">Konfigurasi</a></li>
					</ul>
				</div>
				
			</div> 
		</div>
	</div>
                <!-- Task Info -->
                <div class="col-lg-12 col-md-12 card">
                    <div >
                       
                        <div class="row card-body">
                            <div class="table-responsive col-md-12">
						
                               <table id='table' class="tabel black table-bordered  table-hover dataTable" style=" width:100%">
								<thead  class='  bg-blue'>			
									<th class='thead' axis="string" width='15px'>&nbsp;NO</th>
								
									<th class='thead' >Pengaturan </th>
									<th class='thead' >Value </th>
									 
								</thead>
								
								<tr>
								<td><?php $no=1;	echo $no++?></td>
								<td>Nama Presiden RI saat ini</td>
								<td> 
								<input class='form-control' type="text" id="val_22" name="val_22" onchange='save_(`22`,`val_22`)' value="<?php echo $this->m_reff->goField("pengaturan","val","where id='22' ");?>">
								</td>
								</tr>
								<tr>
								<td><?php echo $no++;?></td>
								<td>Nama Ibu Negara RI saat ini (versi Indonesia)</td>
								<td> 
								<input class='form-control' type="text" id="val_24" name="val_24" onchange='save_(`24`,`val_24`)' value="<?php echo $this->m_reff->goField("pengaturan","val","where id='24' ");?>">
								</td>
								</tr>
									<tr>
								<td><?php echo $no++;?></td>
								<td>Nama Ibu Negara RI saat ini (versi English)</td>
								<td> 
								<input class='form-control' type="text" id="val_23" name="val_23" onchange='save_(`23`,`val_23`)' value="<?php echo $this->m_reff->goField("pengaturan","val","where id='23' ");?>">
								</td>
								</tr>
								
								
						 
								 
							</table>
							</div>						
					 					
					 
                           <!----->
                        </div>




						<div class="row card-body">
                            <div class="table-responsive col-md-12">
                               <table id='table' class="tabel black table-bordered  table-hover dataTable" style=" width:100%">
								<thead  class='bg-blue'>			
									<th class='thead' axis="string" width='15px'>&nbsp;NO</th>
								
									<th class='thead' >Pengaturan </th>
									<th class='thead' >Value </th>
									 
								</thead>
								 <?php
								 $no=1;
								 ?>
								
								
								<tr>
								<td><?php	echo $no++?></td>
								<td>Alamat URL publik</td>
								<td>
								 
								<input class='form-control' type="text" id="val_1" name="val_1" onchange='save_(`1`,`val_1`)' value="<?php echo $this->m_reff->goField("pengaturan","val","where id='1' ");?>">
							 
								</td>
								</tr>
								 
								 
								<tr>
								<td><?php	echo $no++?></td>
								<td>Alamat API Whatsapp Pesan Biasa</td>
								<td>
								 
								<input class='form-control' type="text" id="val_3" name="val_3" onchange='save_(`3`,`val_3`)' value="<?php echo $this->m_reff->goField("pengaturan","val","where id='3' ");?>">
							 
								</td>
								</tr>
								
								<tr>
								<td><?php	echo $no++?></td>
								<td>Alamat API Whatsapp Pesan Dokumen</td>
								<td>
								 
								<input class='form-control' type="text" id="val_10" name="val_10" onchange='save_(`10`,`val_10`)' value="<?php echo $this->m_reff->goField("pengaturan","val","where id='10' ");?>">
							 
								</td>
								</tr>
								
								<tr>
								<td><?php	echo $no++?></td>
								<td>Token API Whatsapp </td>
								<td>
								 
								<input class='form-control' type="text" id="val_4" name="val_4" onchange='save_(`4`,`val_4`)' value="<?php echo $this->m_reff->goField("pengaturan","val","where id='4' ");?>">
							 
								</td>
								</tr>

								<tr>
								<td><?php	echo $no++?></td>
								<td>Direktory Upload </td>
								<td>
								 
								<input class='form-control' type="text" id="val_25" name="val_25" onchange='save_(`25`,`val_25`)' value="<?php echo $this->m_reff->goField("pengaturan","val","where id='25' ");?>">
							 
								</td>
								</tr>

								<tr>
								<td><?php	echo $no++?></td>
								<td>Link profile kepegawaian </td>
								<td>
								 
								<input class='form-control' type="text" id="val_26" name="val_26" onchange='save_(`26`,`val_26`)' value="<?php echo $this->m_reff->goField("pengaturan","val","where id='26' ");?>">
							 
								</td>
								</tr>
								
								<tr>
								<td><?php	echo $no++?></td>
								<td width="300px">Text footer </td>
								<td>
								 
								<textarea style='max-height:50px' class='form-control' type="text" id="val_7" name="val_7" onchange='save_(`7`,`val_7`)'><?php echo $this->m_reff->goField("pengaturan","val","where id='7' ");?></textarea>
								<br><center><button class="btn btn-primary btn-sm fa fa-save" onclick='save_(`7`,`val_7`)'> simpan</button></center>
								</td>
								</tr>
								
								<tr>
								<td><?php	echo $no++?></td>
								<td width="300px">Notifikasi Whatapp ketika peserta menambahkan anggota atau konfirmasi kehadiran (versi bahasa indonesia) </td>
								<td>
								 
								<textarea style='height:200px'  class='form-control' type="text" id="val_13" name="val_13" onchange='save_(`13`,`val_13`)'><?php echo $this->m_reff->goField("pengaturan","val","where id='13' ");?></textarea>
								<br><center><button class="btn btn-primary btn-sm fa fa-save" onclick='save_(`13`,`val_13`)'> simpan</button></center>
								</td>
								</tr>
								
								<tr>
								<td><?php	echo $no++?></td>
								<td width="300px">Notifikasi Whatapp ketika peserta menambahkan anggota atau konfirmasi kehadiran (versi bahasa inggris) </td>
								<td>
								 
								<textarea style='height:200px'  class='form-control' type="text" id="val_14" name="val_14" onchange='save_(`14`,`val_14`)'><?php echo $this->m_reff->goField("pengaturan","val","where id='14' ");?></textarea>
								<br><center><button class="btn btn-primary btn-sm fa fa-save" onclick='save_(`14`,`val_14`)'> simpan</button></center>
								</td>
								</tr>
								 
								 
							</table>
							</div>						
					 					
					 
                           <!----->
                        </div>
						
						
						<div class="row card-body">
                            <div class="table-responsive col-md-12">
                               <table id='table' class="tabel black table-bordered  table-hover dataTable" style=" width:100%">
								<thead  class='  bg-blue'>			
									<th class='thead' axis="string" width='15px'>&nbsp;NO</th>
								
									<th class='thead' >Pengaturan </th>
									<th class='thead' >Value </th>
									 
								</thead>
								 <?php
								 $no=1;
								 ?>
								
								
								 
								
								<tr>
								<td><?php	echo $no++?></td>
								<td>SMTP User mail</td>
								<td>
								 
								<input class='form-control' type="text" id="val_20" name="val_20" onchange='save_(`20`,`val_20`)' value="<?php echo $this->m_reff->goField("pengaturan","val","where id='20' ");?>">
							 
								</td>
								</tr>
								
								<tr>
								<td><?php	echo $no++?></td>
								<td>Password SMTP User mail</td>
								<td>
								 
								<input class='form-control' type="password" id="val_21" name="val_21" onchange='save_(`21`,`val_21`)' value="<?php echo $this->m_reff->goField("pengaturan","val","where id='21' ");?>">
							 
								</td>
								</tr>
								
								<tr>
								<td><?php	echo $no++?></td>
								<td>Mail subject </td>
								<td>
								 
								<input class='form-control' type="text" id="val_19" name="val_19" onchange='save_(`19`,`val_19`)' value="<?php echo $this->m_reff->goField("pengaturan","val","where id='19' ");?>">
							 
								</td>
								</tr>
								
								<tr>
								<td><?php	echo $no++?></td>
								<td>Mail Host </td>
								<td>
								 
								<input class='form-control' type="text" id="val_5" name="val_5" onchange='save_(`5`,`val_5`)' value="<?php echo $this->m_reff->goField("pengaturan","val","where id='5' ");?>">
							 
								</td>
								</tr>
								
									<tr>
								<td><?php	echo $no++?></td>
								<td>Mail Port </td>
								<td>
								 
								<input class='form-control' type="text" id="val_8" name="val_8" onchange='save_(`8`,`val_8`)' value="<?php echo $this->m_reff->goField("pengaturan","val","where id='8' ");?>">
							 
								</td>
								</tr>
								
									<tr>
								<td><?php	echo $no++?></td>
								<td>Mail SMTPScure </td>
								<td>
								 
								<input class='form-control' type="text" id="val_9" name="val_9" onchange='save_(`9`,`val_9`)' value="<?php echo $this->m_reff->goField("pengaturan","val","where id='9' ");?>">
							 
								</td>
								</tr>
								
							 
								 
							</table>
							</div>						
					 			


	
							<div class="col-md-12 row" style="margin-left:0px;margin-top:20px"><h5>Pengaturan e-sertifikat</h5></div>
 
                            <div class="table-responsive col-md-12">
                               <table id='table' class="tabel black table-bordered  table-hover dataTable" style=" width:100%">
								<thead  class='  bg-blue'>			
									<th class='thead' axis="string" width='15px'>&nbsp;NO</th>
								
									<th class='thead' >Pengaturan </th>
									<th class='thead' >Value </th>
									 
								</thead>
								 <?php
								 $no=1;
								 ?>
								
								
								 
								
								<tr>
								<td><?php	echo $no++?></td>
								<td>esign id_subscriber: </td>
								<td>
								 
								<input class='form-control' type="text" id="val_27" name="val_27" onchange='save_(`27`,`val_27`)' value="<?php echo $this->m_reff->goField("pengaturan","val","where id='27' ");?>">
							 
								</td>
								</tr>
								
								<tr>
								<td><?php	echo $no++?></td>
								<td>esign passphrase :</td>
								<td>
								 
								<input class='form-control' type="password" id="val_28" name="val_28" onchange='save_(`28`,`val_28`)' value="<?php echo $this->m_reff->goField("pengaturan","val","where id='28' ");?>">
							 
								</td>
								</tr>
								
								<tr>
								<td><?php	echo $no++?></td>
								<td>esign link curl:</td>
								<td>
								 
								<input class='form-control' type="text" id="val_29" name="val_29" onchange='save_(`29`,`val_29`)' value="<?php echo $this->m_reff->goField("pengaturan","val","where id='29' ");?>">
							 
								</td>
								</tr>
								
								<tr>
								<td><?php	echo $no++?></td>
								<td>esign text :</td>
								<td>
								 
								<input class='form-control' type="text" id="val_30" name="val_30" onchange='save_(`30`,`val_30`)' value="<?php echo $this->m_reff->goField("pengaturan","val","where id='30' ");?>">
							 
								</td>
								</tr>
								
									  
								 
							</table>
							</div>						
							</div>						
					 					
						











								
						
                           <!----->
                        </div>	<a href="<?php echo base_url()?>konfigurasi/database" style='float:right'><i>kelola : database</i></a>
                    </div>
                </div>
                <!-- #END# Task Info -->
				
 
  
	
 

	
 
   
<script>
 
  
  //$('#val_6').jqte();
 
 function save_(idpengaturan,idkonten)
	 {	 
	 loading();
	 var idkonten=$("[name='"+idkonten+"']").val();
		 $.ajax({
		 url:"<?php echo base_url()?>konfigurasi/save_",
		 data: "idpengaturan="+idpengaturan+"&idkonten="+idkonten,
		 method:"POST",
		 success: function(data)
            {	 
				 notif("   Tersimpan! ");
				 unblock();
            }
		});
	 }
	 
    
	
</script>


 