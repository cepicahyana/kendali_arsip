 
	                <div class="modal-content">  
                         <div class="modal-header">  <h5 class="modal-titles" id="defaultModalLabel"><b>Input data external / non-pegawai</b></h5>
						<button type="button" class="close" aria-label="Close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
						</button>
                    </div>


                        <div class="modal-bodys" ><br>

<form  action="javascript:submitForm('modal')" id="modal" url="<?php echo base_url()?>input/insert_external"  method="post" enctype="multipart/form-data">
<input type="hidden" id="formToken" name="<?php echo $this->m_reff->tokenName()?>" value="<?php echo $this->m_reff->getToken()?>">

				 
  <div class="col-md-12 col-lg-12 col-xl-12 mx-auto d-block" data-select2-id="13" id="loading">
										<div class="card card-body pd-10 pd-md-40 border shadow-nones">


                                         
 
<div id="response"></div>
<div class="form-group">
									  <h6 class="card-titles ">  No NIK   yang akan melaksanakan tes:</h6>
                                         <div class="pos-relative -mt-2">
                                      <input type="text" required autocomplete="off" onkeyup="getDataByNik(this.value)" name="f[nik]"  class='form-control'>
								        </div> 



                                      </div>

<div id="form_akun">
                                      
 



											
									<div class="form-group">
									  <h6 class="card-titles ">  Nama lengkap   :</h6>
                                         <div class="pos-relative -mt-2">
                                      <input type="text" required name="f[nama]"  class='form-control'>
								        </div> 
                                      </div>

											
									<div class="form-group">
									  <h6 class="card-titles ">  Jenis Kelamin  :</h6>
                                         <div class="pos-relative mt-2 row" style="margin-left:1px">
                                         <div class="col-lg-2 p-1"> 
                                        
                                         <label class="rdiobox">
                                        <input   required type="radio" 
                                        name="jk" value="l"><span>Laki-laki</span></label> 
                                        </div>
                                         <div class="col-lg-3 p-1"> 
                                        
                                         <label class="rdiobox">
                                        <input   required type="radio" 
                                        name="jk" value="p"><span>Perempuan</span></label> 
                                        </div>
                                         </div> 
                                      </div>
										 
                                      <div class="form-group">
									  <h6 class="card-titles ">  No.Hp   :</h6>
                                         <div class="pos-relative -mt-2">
                                      <input type="text" required name="f[no_hp]"  class='form-control'>
								        </div> 
                                      </div>
                                      <div class="form-group">
									  <h6 class="card-titles ">  E-mail   :</h6>
                                         <div class="pos-relative -mt-2">
                                      <input type="text"   name="f[email]"  class='form-control'>
								        </div> 
                                      </div>
                                
											
								<div class="form-group">
								   <div class="pos-relative -mt-2 row">
                                  <div class="col-md-4"> 
                                  <h6 class="card-titles "> Tempat  lahir :</h6>
                                  <input type="text" name="f[tempat_lahir]" class='form-control'></div>
                                  <div  class="col-md-8"> 
                                  <h6 class="card-titles "> Tanggal lahir   :</h6>
                                  <input id="tgl_lahir" autocomplete="off" type="text" name="tgl_lahir" class='form-control'></div>
                                     
								  </div>
                                </div>                  
										 
											
							
											
                                <div class="form-group">
									  <h6 class="card-titles "> Keterangan  :</h6>
                                         <div class="pos-relative -mt-2">
                                      <input type="text" name="f[ket]"  class='form-control'>
								        </div> 
                                      </div>
                             
 
                                <hr>

                                <div class="row row-xs align-items-center mg-b-20">
										<div class="col-md-4">
											<label class="form-label mg-b-0" style='color:black'>Tanggal test</label>
								                </div>
										<div class="col-md-8 mg-t-5 mg-md-t-0">
 									 <input type="text"  required name="tgl_test" id="tgl_test" class="form-control">
										</div>
   </div>
<div class="row row-xs align-items-center mg-b-20">
										<div class="col-md-4">
											<label class="form-label mg-b-0" style='color:black'>Pilih jenis tes </label>
								                </div>
										<div class="col-md-8 mg-t-5 mg-md-t-0">
 									<?php
									 $dt = $this->db->get("tr_jenis_test")->result();
									 $op[""]="=== pilih ===";
									 foreach($dt as $val){
											$op[$val->kode] = $val->nama;
									 }
									echo form_dropdown("kode_jenis",$op,"","required class='form-control SlectBox' style='color:black'"); 
									?>
										</div>
   </div>

<div class="row row-xs align-items-center mg-b-20">
										<div class="col-md-4">
											<label class="black form-label mg-b-0" style='color:black'>Pilih tempat tes </label>
								                </div>
										<div class="col-md-8 mg-t-5 mg-md-t-0">
 									<?php
                                     $this->db->where("kode_istana",$this->m_reff->dataProfileAdmin()->kode_istana);
									 $dt = $this->db->get("tm_rs")->result();
									 $op=array();
									 $op[""]="=== pilih ===";
									 foreach($dt as $val){
											$op[$val->kode] = $val->nama." - ".$val->alamat;
									 }
									echo form_dropdown("kode_tempat",$op,"","required class='form-control search-box' style='color:black'"); 
									?>
										</div>
   </div>

                             



 <div class="col-lg-12 p-1"><center>
<button class="btn btn-success" onclick="submitForm('modal')"><i class="fa fa-save"></i> simpan</button>
</center>
</div>

</form>








</div>


</div>
</div>


 



 

      <script>
          
      $('#tgl_lahir').daterangepicker({
    "singleDatePicker": true,
    "showDropdowns": true,
    "autoApply": true,
    "locale": {
        "format": "DD/MM/YYYY",
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
            "Januari",
            "Februari",
            "Maret",
            "April",
            "Mei",
            "Juni",
            "Juli",
            "Augustus",
            "September",
            "October",
            "November",
            "Desember"
        ],
        "firstDay": 1
    },
     
    "opens": "center",
    "drops": "up"
});</script>


 



<script>
 	$("#form_akun").hide();
function getDataByNik(val){
                            loading("modal");
                            var url   = "<?php echo site_url("input/dataExternal");?>";
                            var param = {val:val,<?php echo $this->m_reff->tokenName()?>:token};
							$.ajax({
									type: "POST",dataType: "json",data: param, url: url,
									success: function(val){
                                        unblock("modal");
										token=val['token'];
                                        $("#formToken").val(token);
                                        if(val['status']==true){
                                            $("[name='f[nama]']").val(val['data'].nama); 
                                            $("[name='f[no_hp]']").val(val['data'].no_hp); 
                                            $("[name='f[email]']").val(val['data'].email); 
                                            $("[name='f[ket]']").val(val['data'].ket); 
                                            $("[name='f[tempat_lahir]']").val(val['data'].tempat_lahir);
                                            $("[name='tgl_lahir']").val(val['tgl_lahir']); 
                                            $("input:radio[name=jk][value="+val['data'].jk+"]")[0].checked = true;
                                            $("#form_akun").show();
                                            // setTimeout(function(){ alert("Hello"); }, 3000);
                                        }else{
                                            if(val["info"]==false){
                                                // notif(val["info"]);
                                                $("#form_akun").show();
                                            }else{
                                                notif(val["info"]);
                                                $("#form_akun").hide();
                                            }

                                            $("[name='f[nama]']").val(""); 
                                            $("[name='f[tempat_lahir]']").val("");
                                            $("[name='tgl_lahir']").val("");  
                                           


                                        }
                                        
                                    
									}
							});	
	
}
</script>





<script>
          
          $('#tgl_test').daterangepicker({
        "singleDatePicker": true,
        "showDropdowns": true,
        "autoApply": true,
        "locale": {
            "format": "DD/MM/YYYY",
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
                "Januari",
                "Februari",
                "Maret",
                "April",
                "Mei",
                "Juni",
                "Juli",
                "Augustus",
                "September",
                "October",
                "November",
                "Desember"
            ],
            "firstDay": 1
        },
         
        "opens": "center",
        "drops": "up"
    });</script>