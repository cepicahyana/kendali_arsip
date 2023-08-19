<?php
$db     = $this->db->get_where("data_pegawai",array("nip"=>$this->m_reff->nip()))->row();
if(!isset($db)){ echo "data tidak tersedia"; return false;}
$sts    = $db->sts_test;
$no_hp	= isset($db->no_hp)?($db->no_hp):0;
$nik	= isset($db->nik)?($db->nik):null;
$tempat_lahir	= isset($db->tempat_lahir)?($db->tempat_lahir):null;
$jenis_pegawai	= isset($db->jenis_pegawai)?($db->jenis_pegawai):null;
$tgl_lahir		= isset($db->tgl_lahir)?($db->tgl_lahir):null;
$tgl_lahir		=$this->tanggal->ind($tgl_lahir,"/");
$id		= isset($db->id)?($db->id):null;
?>



<div class="modal-content" id="area_modal_kondisi">  
                         <div class="modal-header">  <h5 class="modal-titles" id="defaultModalLabel"><b>Ajukan permohonan tes covid untuk anda </b></h5>
						<button type="button" class="close" aria-label="Close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
						</button>
                    </div>


                        <div class="modal-body" >
                        <?php
 if($sts==1){?>   
                            <div class="alsert alsert-success">
                                Anda sedang dalam pengajuan test covid
                            </div>

<?php  }else{?>          
    <form  action="javascript:submitForm('modal_kondisi')" 
		id="modal_kondisi" url="<?php echo base_url()?>input_permohonan/insert"  method="post" enctype="multipart/form-data">
 <input type="hidden" id="formToken" name="<?php echo $this->m_reff->tokenName()?>" value="<?php echo $this->m_reff->getToken()?>">
 <input type="hidden"  name="f[jenis_pegawai]" value="<?php echo $db->jenis_pegawai;?>">
 <!-- 3175082507790012 -->

<?php
if($jenis_pegawai==2){?>

<div class="row row-xs align-items-center mg-b-20">
							   <div class="col-md-4">
								   <label class="form-label mg-b-0" style='color:black'>Nomor Hp </label>
									   </div>
							   <div class="col-md-8 mg-t-5 mg-md-t-0">
						 <input   class='form-control' required onchange="setHp(this.value)" type="number" value="<?=$no_hp?>" placeholder="Nomor hp (whatsapp)">
							   </div>
</div>

<div class="row row-xs align-items-center mg-b-20">
							   <div class="col-md-4">
								   <label class="form-label mg-b-0" style='color:black'> Input NIK </label>
									   </div>
							   <div class="col-md-8 mg-t-5 mg-md-t-0">
						 <input id="setNIKupdate" class='form-control' required onchange="setNIK(this.value)" type="number" value="<?=$nik?>" placeholder="Nomor Induk Keluarga/ (nomor KTP)">
							   </div>
</div>

		 
 
		 <div class="row row-xs align-items-center mg-b-20">
										<div class="col-md-4">
											<label class="form-label mg-b-0" style='color:black'> Tempat Lahir </label>
								                </div>
										<div class="col-md-8 mg-t-5 mg-md-t-0">
 								 <input class='form-control' required onchange="setTempatLahir(this.value)" type="text" value="<?=$tempat_lahir?>" placeholder="Tempat lahir">
										</div>
		 </div>



 
										<div class="row row-xs align-items-center mg-b-20">
										<div class="col-md-4">
											<label class="form-label mg-b-0" style='color:black'> Tanggal Lahir </label>
								                </div>
										<div class="col-md-8 mg-t-5 mg-md-t-0">
										<?php
										if($tgl_lahir=="00/00/0000" or !$tgl_lahir)
										{
											$tgl_lahir="";
										}
										 
										?>
 								 <input class='form-control' id="tgl_lahir" required onchange="setTglLahir(this.value)" type="text" value="<?=$tgl_lahir?>" placeholder="Tanggal lahir">
										</div>
										</div>
   	 




		
   
<?php } ?>



<div class="row row-xs align-items-center mg-b-20">
										<div class="col-md-4">
											<label class="form-label mg-b-0" style='color:black'> Tanggal Permohonan Tes </label>
								                </div>
										<div class="col-md-8 mg-t-5 mg-md-t-0">
 								 <input name="tgl_permohonan" class='form-control' id="tgl_permohonan" required  type="text"  >
										</div>
										</div>

                        <div class="row row-xs align-items-center mg-b-20">
										<div class="col-md-4">
											<label class="form-label mg-b-0" style='color:black'>Pilih jenis test </label>
								                </div>
										<div class="col-md-8 mg-t-5 mg-md-t-0">
 									<?php
									 $this->db->where("kode!=","04");
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
									 $this->db->where("kode_istana",$this->m_reff->dataProfilePegawai()->kode_istana);
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

   <div class="row row-xs align-items-center mg-b-20">
										<div class="col-md-4">
											<label class="black form-label mg-b-0" style='color:black'>Keperluan permohonan </label>
								                </div>
										<div class="col-md-8 mg-t-5 mg-md-t-0">
 									<?php
									 $dt = $this->db->get("tr_keperluan_tes")->result();
									 $op=array();
									 $op[""]="=== pilih ===";
									 foreach($dt as $val){
											$op[$val->kode] = $val->nama;
									 }
									echo form_dropdown("f[id_keperluan]",$op,"","onchange='alasan(this.value)' required class='form-control search-box' style='color:black'"); 
									?>
										</div>
   </div>
   <div class="row row-xs align-items-center mg-b-20" id="detail_keperluan">
										<div class="col-md-4">
											<label class="black form-label mg-b-0" style='color:black'>Keterangan dinas</label>
								                </div>
										<div class="col-md-8 mg-t-5 mg-md-t-0">
 									<input id="ketKeperluan" placeholder="contoh: dinas luar ke malang" type="text" name="f[keperluan]" class="form-control">
										</div>
   </div>


   <div class="col-lg-12 p-1"><center>
<button class="btn btn-success" onclick="submitForm('modal_kondisi')"> Ajukan sekarang</button>
</center>

<?php } ?>
                                    </div>
</div>

<script>
	$("#detail_keperluan").hide();
	function alasan(val){
		if(val==1){
			$("#detail_keperluan").show();
			$("#ketKeperluan").prop('required',true);
		}else{
			$("#detail_keperluan").hide();
			$("#ketKeperluan").prop('required',false);
		}
	}
  function  reload_table()
    {
        setTimeout(() => {
            window.location.href="<?php echo site_url('dpegawai');?>";
        }, 1000);
      
	}

	</script>
<script>
	function setHp(val){
		var id = "<?php echo $id;?>";
		loading("area_modal");
		var url   = "<?php echo site_url("input_permohonan/setHp");?>";
		var param = {id:id,val:val,<?php echo $this->m_reff->tokenName()?>:token};
							$.ajax({
									type: "POST",dataType: "json",data: param, url: url,
									success: function(val){
										 
										token=val['token'];
										unblock("area_modal");
									}
							});	
	}
</script>
<script>
	function setNIK(nik){
		var id = "<?php echo $id;?>";
		loading("area_modal");
		var url   = "<?php echo site_url("input_permohonan/setNIK");?>";
		var param = {id:id,nik:nik,<?php echo $this->m_reff->tokenName()?>:token};
							$.ajax({
									type: "POST",dataType: "json",data: param, url: url,
									success: function(val){
										if(val['sts']==false){
											notif(val['info']);
											$("#setNIKupdate").value();
										}
										token=val['token'];
										unblock("area_modal");
									}
							});	
	}
</script>
<script>
	function setTglLahir(val){
		var id = "<?php echo $id;?>";
		loading("area_modal");
		var url   = "<?php echo site_url("input_permohonan/setTglLahir");?>";
		var param = {id:id,val:val,<?php echo $this->m_reff->tokenName()?>:token};
							$.ajax({
									type: "POST",dataType: "json",data: param, url: url,
									success: function(val){
										token=val['token'];
										unblock("area_modal");
									}
							});	
	}
</script>
<script>
	function setTempatLahir(val){
		var id = "<?php echo $id;?>";
		loading("area_modal");
		var url   = "<?php echo site_url("input_permohonan/setTempatLahir");?>";
		var param = {id:id,val:val,<?php echo $this->m_reff->tokenName()?>:token};
							$.ajax({
									type: "POST",dataType: "json",data: param, url: url,
									success: function(val){
										token=val['token'];
										unblock("area_modal");
									}
							});	
	}
</script>

<script>

$('#tgl_lahir').daterangepicker({
    "singleDatePicker": true,
    "autoApply": true,
    "locale": {
        "format": "DD-MM-YYYY",
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
});

$('#tgl_permohonan').daterangepicker({
    "singleDatePicker": true,
    "autoApply": true,
    "locale": {
        "format": "DD-MM-YYYY",
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
});
</script>