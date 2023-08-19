<?php
$kode    = $this->m_reff->san($this->input->post("kode"));
$db      = $this->db->get_where("data_test",array("kode"=>$kode))->row();
if(!isset($db)){   return false; }
$hasil   = isset($db->hasil)?($db->hasil):"";
$nip     = isset($db->nip)?($db->nip):"";


$peg     = $this->m_reff->data_pegawai($nip);
if(!isset($peg)){   return false; }
$nik     = isset($peg->nik)?($peg->nik):"";

if($hasil=="+"){
    $hasil_text = "<h5 class='text-danger'>Positif (+)</h5>
    <a class='text-primary' href='".site_url("download")."?f=".$this->m_reff->encrypt("hasil/".$db->file)."'> 
		  <i class='fa fa-download' ></i> Download hasil tes</a>
    ";
}elseif($hasil=="-"){
    $hasil_text = "<h5 class='text-success'>Negatif (-)</h5>
    <a class='text-primary' href='".site_url("download")."?f=".$this->m_reff->encrypt("hasil/".$db->file)."'> 
    <i class='fa fa-download' ></i> Download hasil tes</a>
    ";
}else{
    $hasil_text = "<br>( <i>belum keluar</i> )";
}
?>


<div class="modal-content">  
                         <div class="modal-header">  <h5 class="modal-titles" id="defaultModalLabel"><b>Hasil test </b></h5>
						<button type="button" class="close" aria-label="Close" data-dismiss="modal">
                       
						</button>
                    </div>


                        <div class="modal-body" >
                            <div class="alert alert-info p-10">
					<center><b>hasil tes anda  : </b><br>
                    <?php echo $hasil_text;?></center>
                    <div>
                    <hr>
					<form  action="javascript:submitForm('modal_ket')" 
					id="modal_ket" url="<?php echo base_url()?>dpegawai/update_ket"  method="post" enctype="multipart/form-data">
 <input type="hidden" name="kode" value="<?php echo $kode?>">
 <input type="hidden" name="nik" value="<?php echo $nik?>">
 
 
<?php
if($hasil=="+"){?>
  <div class="col-md-12 col-lg-12 col-xl-12 mx-auto d-block" data-select2-id="13">
										<div class="card card-body pd-10 pd-md-40 border shadow-nones">

   <h5 class="card-titles ">  Isolasi yang dipilih:</h5>
 
 <div class="pos-relative -mt-2">
 <?php
$data = $this->db->get("tr_isolasi")->result();
foreach($data as $val){
echo '<div class="col-lg-12 p-1"> <label class="rdiobox"><input required type="radio" name="f[isolasi]" value="'.$val->kode.'"><span>'.$val->nama.'</span></label> </div>';
}?>
<!-- <div class="col-lg-12 p-1"> <span>Lainnya: <input type="text" name="perawatan[]" class='form-control'> </span> </div> -->

</div>
<hr>







											<h5 class="card-titles ">  Domisili saat ini:</h5>
											<div class="form-group">
												
                                             
                                    <label class="main-content-label tx-11 tx-medium tx-gray-600">Provinsi</label>
									 <div class="pos-relative">
 									<?php
                                     $this->db->where_in("id_prov",array("31","32"));
									 $dt = $this->db->get("provinsi")->result();
								 
									 foreach($dt as $val){
											$op[$val->id_prov] = $val->nama;
									 }
									echo form_dropdown("d[id_prov]",$op,$peg->id_prov,"onchange='get_kab()' required class='form-control ' style='color:black'"); 
									?>
								  </div>
                                  
                                  
                                  <label class="main-content-label tx-11 tx-medium tx-gray-600">Kab/Kota</label>
									 <div class="pos-relative">
 									 <div id="data_kab"></div>
								  </div>
                                  
                                  <label class="main-content-label tx-11 tx-medium tx-gray-600">Kecamatan</label>
									 <div class="pos-relative">
 									 <div id="data_kec"></div>
								  </div>
							               
                                  
                                  <label class="main-content-label tx-11 tx-medium tx-gray-600">Kelurahan</label>
									 <div class="pos-relative">
 									 <div id="data_kel"></div>
								  </div>
							               
                                        <hr>
                                        <h5 class="card-titles ">  Prediksi penularan dari :</h5>
 
									 <div class="pos-relative -mt-2">
                                     <?php
                                    $data = $this->db->get("tr_penularan")->result();
                                    foreach($data as $val){
                                    echo '<div class="col-lg-12 p-1"> <label class="ckbox"><input   type="checkbox" name="penularan[]" value="'.$val->nama.'"><span>'.$val->nama.'</span></label> </div>';
                                    }?>
                                    <div class="col-lg-12 p-1"> <span>Lainnya: <input type="text" name="penularan[]" class='form-control'> </span> </div>

								  </div>

                                            </div>
										 

<?php } ?>
  
  



 <div class="col-lg-12 p-1"><center>
<button class="btn btn-success"  aria-label="Close" data-dismiss="modal" >  close</button>
</center>
</div>

</form>

</div>

</div>

<script>
    setTimeout(function(){ get_kab(); }, 500);
    

     	function get_kab(){
             var id_prov  = $("[name='d[id_prov]']").val();
             var value    = "<?php echo $peg->id_kab?>";
		$.post("<?php echo site_url("dpegawai/get_kab"); ?>",{id_prov:id_prov,value:value},function(data){
			 $("#data_kab").html(data);
             get_kec();
		      }); 
	}

     	function get_kec(){
             var id_kab  = $("[name='d[id_kab]']").val();
             var value    = "<?php echo $peg->id_kec?>";
		$.post("<?php echo site_url("dpegawai/get_kec"); ?>",{id_kab:id_kab,value:value},function(data){
			 $("#data_kec").html(data);
             get_kel();
		      }); 
	}

     	function get_kel(){
             var id_kec  = $("[name='d[id_kec]']").val();
             var value    = "<?php echo $peg->id_kel?>";
		$.post("<?php echo site_url("dpegawai/get_kel"); ?>",{id_kec:id_kec,value:value},function(data){
			 $("#data_kel").html(data);
		      }); 
	}

    function reload_table(){
        update(`<?php echo $kode?>`);
    }
 </script>


