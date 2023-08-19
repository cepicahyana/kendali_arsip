<?php
$this->db->where("id",$id=$this->m_reff->san($this->input->post("id")));
$data	= $this->db->get("data_test")->row();
$nip	= isset($data->nip)?($data->nip):"";
?> 
	                <div class="modal-content">  
                         <div class="modal-header">  <h5 class="modal-titles" id="defaultModalLabel"><b>Update </b></h5>
						<button type="button" class="close" aria-label="Close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
						</button>
                    </div>


                        <div class="modal-body" >
<?php
$acc = $this->m_reff->san($this->input->post("acc"));
?>
<form  action="javascript:submitForm('modal')" id="modal" url="<?php echo base_url()?>input/update"  method="post" enctype="multipart/form-data">
 <input type="hidden" name="id" value="<?php echo $id;?>">
 <input type="hidden" name="acc" value="<?php echo $acc;?>">
 <input type="hidden" id="formToken" name="<?php echo $this->m_reff->tokenName()?>" value="<?php echo $this->m_reff->getToken()?>">
								<div class=" pd-sm-20 "  >
								 
									<div class="row row-xs align-items-center mg-b-20">
										
									 
										<div style='width:100%' id="response"></div>
							     </div>
						
<div id="form_akun">
<hr>
<div class="row row-xs align-items-center mg-b-20">
										<div class="col-md-4">
											<label class="form-label mg-b-0" style='color:black'>Tanggal test</label>
								                </div>
										<div class="col-md-8 mg-t-5 mg-md-t-0">
 									 <input type="text"  value="<?php echo $data->tgl;?>" name="f[tgl]" id="tgl" class="form-control">
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
									echo form_dropdown("f[kode_jenis]",$op,$data->kode_jenis,"required class='form-control SlectBox' style='color:black'"); 
									?>
										</div>
   </div>

<div class="row row-xs align-items-center mg-b-20">
										<div class="col-md-4">
											<label class="black form-label mg-b-0" style='color:black'>Pilih tempat test </label>
								                </div>
										<div class="col-md-8 mg-t-5 mg-md-t-0">
 									 
									 <?php
									 if($this->session->userdata("level")=="pic_covid"){
										 $this->db->where("kode_istana",$this->session->kode_istana);
									 }
									 $dt = $this->db->get("tm_rs")->result();
									 $op=array();
									 $op[""]="=== pilih ===";
									 foreach($dt as $val){
											$op[$val->kode] = $val->nama." - ".$val->alamat;
									 }
									echo form_dropdown("f[kode_tempat]",$op,$data->kode_tempat,"required class='form-control search-box' style='color:black'"); 
							 	?>
										</div>
   </div>
<div class="row row-xs align-items-center mg-b-20">
										<div class="col-md-4">
											<label class="black form-label mg-b-0" style='color:black'>Keperluan Tes </label>
								                </div>
										<div class="col-md-8 mg-t-5 mg-md-t-0">
 									 
									 <?php 
									 $dt = $this->db->get("tr_keperluan_tes")->result();
									 $op=array();
									 $op[""]="=== pilih ===";
									 foreach($dt as $val){
											$op[$val->kode] = $val->nama;
									 }
									echo form_dropdown("f[id_keperluan]",$op,$data->id_keperluan,"required onchange='keperluan(this.value)' class='form-control search-box' style='color:black'"); 
							 	?>
										</div>
   </div>
   <?php
  if(strlen(isset($data->keperluan)?($data->keperluan):null)<1){
	$keper = "dinas";
	}else{
		$keper = $data->keperluan;
	}
   ?>
   <div class="row row-xs align-items-center mg-b-20" id="detail_keperluan">
										<div class="col-md-4">
											<label class="black form-label mg-b-0" style='color:black'>Keterangan dinas</label>
								                </div>
										<div class="col-md-8 mg-t-5 mg-md-t-0">
 									<input id="ketKeperluan"   value="<?=$keper?>" type="text" name="f[keperluan]" class="form-control">
										</div>
   </div>
 <?php
 if($acc=="acc"){
		$text = "Simpan & setujui";
 }else{
		$text = "Simpan"; 
 }
 ?>
   <button  onclick="submitForm('modal')"  
                                    class="float-right btn btn-primary pd-x-30 mg-r-5 mg-t-5"><i class='fa fa-save'></i> <?=$text;?></button>
								 
                                     
                                    </div>   
</div>									
				<!-- /row -->
</form>

</div>
</div>

 <?php
 if($data->id_keperluan==1){
	echo "<script>$('#detail_keperluan').show()</script>";
 }else{
	echo "<script>$('#detail_keperluan').hide()</script>";
 }?>

<script>

function keperluan(val){
		if(val==1){
			$("#detail_keperluan").show();
		 
		}else{
			$("#detail_keperluan").hide();
		 
		}
	}


	setTimeout(function(){ 	getData();}, 300);

	$("#form_akun").show();
	function getData(){
		var val = "<?php echo $nip;?>";
		if(val==""){return false;}
		$("#response").html(cantik());

		var url   = "<?php echo site_url("input/getDataPegawaiEdit");?>";
		var param = {val:val,<?php echo $this->m_reff->tokenName()?>:token};
							$.ajax({
									type: "POST",dataType: "json",data: param, url: url,
									success: function(val){
										 token=val['token'];
										 $("#formToken").val(token);
										 $("#response").html(val['data']);
										 if(val['data'].length<250){
												$("#form_akun").hide();
											}else{
												$("#form_akun").show();
											}
									}
							});	
	}
</script>



    
<script>
	 
    
	window.asd = $('.SlectBox').SumoSelect({ csvDispCount: 3, selectAll:true, captionFormatAllSelected: "Yeah, OK, so everything." });
	window.Search = $('.search-box').SumoSelect({ csvDispCount: 3, search: true, searchText:'Enter here.' });
	window.sb = $('.SlectBox-grp-src').SumoSelect({ csvDispCount: 3, search: true, searchText:'Enter here.', selectAll:true });
	$('.testselect1').SumoSelect();
	$('.testselect2').SumoSelect();
	$('.selectsum1').SumoSelect({ okCancelInMulti: true, selectAll: true });
	$('.selectsum2').SumoSelect({ selectAll: true });
	
 
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
});
	  </script>