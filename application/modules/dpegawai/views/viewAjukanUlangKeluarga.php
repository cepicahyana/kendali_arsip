<?php
$kode   = $this->m_reff->san($this->input->post("kode"));
$nama   = $this->m_reff->san($this->input->post("nama"));
$db     = $this->db->get_where("data_test_keluarga",array("kode"=>$kode))->row();
if(!isset($db)){   return false; }
$nip    = $db->nip_pegawai;
$nik    = $db->nik;
if($db->kode_test_utama){
	$kode_test_utama  =   $db->kode_test_utama;
}else{
	$kode_test_utama  =   $db->kode;
}

$tgl    = $db->konfirm_rs;
$selisih    =   $this->tanggal->selisih($tgl,date('Y-m-d'))+1;
?>



<div class="modal-content">  
                         <div class="modal-header">  <h5 class="modal-titles" id="defaultModalLabel"><b>Ajukan permohonan tes covid untuk <?php echo $nama;?>. </b></h5>
						<button type="button" class="close" aria-label="Close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
						</button>
                    </div>


                        <div class="modal-body" >
                        <?php
 if($selisih>14){?>   
                            <div class="alsert alsert-success">
                                Permohonan tes covid diajukan selama 14 hari setelah 
                                masa tes sebelumnya. <hr>
                                masa isolasi <?= $nama?> sampai dengan saat ini masih : <?php echo $selisih ?> hari.
                                <hr>
                                Silahkan ajukan kembali setelah 14 hari
                            </div>

<?php  }else{?>          
    <form  action="javascript:submitForm('modal_kondisi')" 
					id="modal_kondisi" url="<?php echo base_url()?>dpegawai/ajukan_tes_keluarga"  method="post" enctype="multipart/form-data">
 <input type="hidden" name="kode" value="<?php echo $kode?>">
 <input type="hidden" name="nip" value="<?php echo $nip?>">
 <input type="hidden" name="kode_test_utama" value="<?php echo $kode_test_utama?>">
 <input type="hidden" name="f[nip_pegawai]" value="<?php echo $nip?>">
 <input type="hidden" name="f[nama]" value="<?php echo $db->nama?>">
 <input type="hidden" name="f[nik]" value="<?php echo $nik?>">
 <input type="hidden" name="f[jk]" value="<?php echo  $db->jk?>">
 <input type="hidden" name="f[id_hubungan]" value="<?php echo  $db->id_hubungan?>">
 <input type="hidden" id="formToken" name="<?php echo $this->m_reff->tokenName()?>" value="<?php echo $this->m_reff->getToken()?>">

                        <div class="row row-xs align-items-center mg-b-20">
										<div class="col-md-4">
											<label class="form-label mg-b-0" style='color:black'>Pilih jenis test </label>
								                </div>
										<div class="col-md-8 mg-t-5 mg-md-t-0">
 									<?php
									 $dt = $this->db->get("tr_jenis_test")->result();
									 $op[""]="=== pilih ===";
									 foreach($dt as $val){
											$op[$val->kode] = $val->nama;
									 }
									echo form_dropdown("f[kode_jenis]",$op,"","required class='form-control SlectBox' style='color:black'"); 
									?>
										</div>
   </div>

<div class="row row-xs align-items-center mg-b-20">
										<div class="col-md-4">
											<label class="black form-label mg-b-0" style='color:black'>Pilih tempat test </label>
								                </div>
										<div class="col-md-8 mg-t-5 mg-md-t-0">
 									<?php
									 $this->db->where("id_istana",$this->m_reff->dataProfilePegawai()->id_istana);
									 $dt = $this->db->get("tm_rs")->result();
									 $op=array();
									 $op[""]="=== pilih ===";
									 foreach($dt as $val){
											$op[$val->kode] = $val->nama." - ".$val->alamat;
									 }
									echo form_dropdown("f[kode_tempat]",$op,"","required class='form-control search-box' style='color:black'"); 
									?>
										</div>
   </div>
   <div class="col-lg-12 p-1"><center>
<button class="btn btn-success" onclick="submitForm('modal_kondisi')"> Ajukan sekarang</button>
</center>

<?php } ?>
                                    </div>
</div>

<script>
  function  reload_table()
    {
        window.location.href="";
    }
</script>