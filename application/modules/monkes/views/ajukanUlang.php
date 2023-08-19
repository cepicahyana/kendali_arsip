<?php
 
$kode   = $this->input->post("kode");
$db     = $this->db->get_where("data_test",array("kode"=>$kode))->row();
if(!isset($db)){ echo  "test tidak ditemukan"; return false; }
$nip    = $db->nip;
$kode_test_utama  =   $db->kode_test_utama;
if(!$kode_test_utama){
    $kode_test_utama    =   $kode;
}
$tgl    = $db->konfirm_rs;
$selisih    =   $this->tanggal->selisih($tgl,date('Y-m-d'))+1;
?>



<div class="modal-content">  
                         <div class="modal-header">  <h5 class="modal-titles" id="defaultModalLabel"><b> Tes lanjutan untuk : <?php echo $db->nama;?></b></h5>
						<button type="button" class="close" aria-label="Close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
						</button>
                    </div>


                        <div class="modal-body" >
                        <?php
 if(1!=1){?>   
                            <div class="alsert alsert-success">
                                Permohonan tes covid diajukan selama 14 hari setelah 
                                masa tes sebelumnya. <hr>
                                masa isolasi anda sampai dengan saat ini masih : <?php echo $selisih ?> hari.
                                <hr>
                                Silahkan ajukan kembali setelah 14 hari
                            </div>

<?php  }else{?>          
    <form  action="javascript:submitForm('modal')" 
					id="modal" url="<?php echo base_url()?>monkes/ajukan_tes"  method="post" enctype="multipart/form-data">
 <input type="hidden" name="kode" value="<?php echo $kode?>">
 <input type="hidden" name="nip" value="<?php echo $nip?>">
 <input type="hidden" name="kode_test_utama" value="<?php echo $kode_test_utama?>">
 <input type="hidden" name="f[nama]" value="<?php echo $db->nama?>">
 <input type="hidden" name="f[nik]" value="<?php echo $db->nik?>">
 <input type="hidden" id="formToken" name="<?php echo $this->m_reff->tokenName()?>" value="<?php echo $this->m_reff->getToken()?>">
 <div class="row row-xs align-items-center mg-b-20">
										<div class="col-md-4">
											<label class="form-label mg-b-0" style='color:black'>Tanggal test</label>
								                </div>
										<div class="col-md-8 mg-t-5 mg-md-t-0">
 									 <input type="text" required  name="f[tgl]" id="tgl" class="form-control">
										</div>
                             </div>

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
									 $this->db->where("kode_istana",$this->session->kode_istana);
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

<input type="hidden" name='f[id_keperluan]' value='3'>


   <div class="col-lg-12 p-1"><center>
<button class="btn btn-success" onclick="submitForm('modal')"> Ajukan</button>
</center>

<?php } ?>
                                    </div>
</div>

 

<script>
	$('#tgl').daterangepicker({
    "singleDatePicker": true,
    "autoApply": true,
    "locale": {
        "format": "YYYY-MM-DD",
        "separator": " - ",
        "applyLabel": "Apply",
        "cancelLabel": "Cancel",
        "fromLabel": "From",
        "toLabel": "To",
        "customRangeLabel": "Custom",
        "weekLabel": "W",
        "daysOfWeek": [
            "Min",
            "Sen",
            "Sel",
            "Rab",
            "Kam",
            "Jum",
            "Sab"
        ],
        "monthNames": [
            "January",
            "February",
            "March",
            "April",
            "May",
            "June",
            "July",
            "August",
            "September",
            "October",
            "November",
            "December"
        ],
        "firstDay": 1
    },
    
}, function(start, end, label) {
  console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
});</script>