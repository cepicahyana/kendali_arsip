<?php
$db     = $this->db->get_where("data_test",array("id"=>$this->input->post("id")))->row();
if(isset($b)){
	echo "data tidak tersedia";
	return false;
}
?>



<div class="modal-content">  
                         <div class="modal-header">  <h5 class="modal-titles" id="defaultModalLabel"><b>Ajukan permohonan tes covid untuk anda. </b></h5>
						<button type="button" class="close" aria-label="Close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
						</button>
                    </div>


                        <div class="modal-body" >
          
    <form  action="javascript:submitForm('modal_kondisi')" 
		id="modal_kondisi" url="<?php echo base_url()?>input_permohonan/update"  method="post" enctype="multipart/form-data">
 <input type="hidden" id="formToken" name="<?php echo $this->m_reff->tokenName()?>" value="<?php echo $this->m_reff->getToken()?>">
 <input type="hidden" id="id" name="id" value="<?php echo $db->id?>">

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
									echo form_dropdown("f[kode_jenis]",$op,$db->kode_jenis,"required class='form-control SlectBox' style='color:black'"); 
									?>
										</div>
   </div>

<div class="row row-xs align-items-center mg-b-20">
										<div class="col-md-4">
											<label class="black form-label mg-b-0" style='color:black'>Pilih tempat test </label>
								                </div>
										<div class="col-md-8 mg-t-5 mg-md-t-0">
 									<?php
									 $this->db->where("kode_istana",$this->m_reff->dataProfilePegawai()->kode_istana);
									 $dt = $this->db->get("tm_rs")->result();
									 $op=array();
									 $op[""]="=== pilih ===";
									 foreach($dt as $val){
											$op[$val->kode] = $val->nama." - ".$val->alamat;
									 }
									echo form_dropdown("f[kode_tempat]",$op,$db->kode_tempat,"required class='form-control search-box' style='color:black'"); 
									?>
										</div>
   </div>
   <div class="col-lg-12 p-1"><center>
<button class="btn btn-success" onclick="submitForm('modal_kondisi')"> Ajukan sekarang</button>
</center>

 
                                    </div>
</div>

<script>
  function  reload_table()
    {
        setTimeout(() => {
            window.location.href="";
        }, 1000);
      
    }
</script>