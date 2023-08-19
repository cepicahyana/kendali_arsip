 
	                <div class="modal-content">  
                         <div class="modal-header">  <h5 class="modal-titles" id="defaultModalLabel"><b>Input data keluarga anda yang akan ditest</b></h5>
						<button type="button" class="close" aria-label="Close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
						</button>
                    </div>


                        <div class="modal-bodys" ><br>

<form  action="javascript:submitForm('modal')" id="modal" url="<?php echo base_url()?>input/insert_family"  method="post" enctype="multipart/form-data">
<input type="hidden" id="formToken" name="<?php echo $this->m_reff->tokenName()?>" value="<?php echo $this->m_reff->getToken()?>">

				 
  <div class="col-md-12 col-lg-12 col-xl-12 mx-auto d-block" data-select2-id="13" id="loading">
										<div class="card card-body pd-10 pd-md-40 border shadow-nones">


                                        <div class="form-group">
									  <h6 class="card-titles ">  NIP Pegawai:</h6>
                                         <div class="pos-relative -mt-2 row">
                                    <div class="col-md-9">  <input onchange="cekNikPeg()" type="text" autocomplete="off"  name="f[nip_pegawai]"  class='form-control'></div>
                                    <div class="col-md-3"><button onclick="cekNikPeg()" type="button" class="btn btn-info">Cari</button></div>
								       
                                </div> 
 
<div id="response"></div>
 
<div id="form_akun">
                                        <div class="form-group">
									  <h6 class="card-titles ">  No NIK keluarga yang akan menjalani tes:</h6>
                                         <div class="pos-relative -mt-2">
                                      <input type="text" required autocomplete="off" onkeyup="getDataByNik(this.value)" name="f[nik]"  class='form-control'>
								        </div> 



                                      </div>



   <h6 class="card-titles">  Pilih anggota keluarga</h6>
 <div class="pos-relative ml-2" id="pilihan_hubungan">

<!-- <div class="col-lg-12 p-1"> <span>Lainnya: <input type="text" name="perawatan[]" class='form-control'> </span> </div> -->

</div>
<br>

 			
									<div class="form-group">
									  <h6 class="card-titles ">  Nama lengkap <span id='nama_lengkap'></span> :</h6>
                                         <div class="pos-relative -mt-2">
                                      <input type="text" name="f[nama]" required class='form-control'>
								        </div> 
                                      </div>
										 

											
                                      <div class="form-group" id="form_jk">
									  <h6 class="card-titles ">  Jenis kelamin <span id='nama_lengkap'></span> :</h6>
                                         <div class="pos-relative -mt-2">
                                    
                                         <div class="row mg-t-10">
									<div class="col-lg-3">
										<label class="rdiobox"><input onclick="setJK('l')"  name="opsi_jk" value="l" id="jkl" type="radio"> <span>Laki-laki</span></label>
							                </div>
									<div class="col-lg-3 mg-t-20 mg-lg-t-0">
										<label class="rdiobox"><input onclick="setJK('p')"  name="opsi_jk" value="p" id="jkp" type="radio"> <span>Perempuan</span></label>
							                </div>
								
						                </div>

								        </div> 
                                      </div>

                                  
                                      <input type="hidden" id="jeka" name="jk" value="">
                                   
										 

											
								<div class="form-group">
									    
 
								  <div class="pos-relative -mt-2 row">
                                  <div class="col-md-4"> 
                                  <h6 class="card-titles "> Tempat  lahir :</h6>
                                  <input type="text" name="f[tempat_lahir]" required class='form-control'></div>
                                  <div  class="col-md-8"> 
                                  <h6 class="card-titles "> Tanggal lahir   :</h6>
                                  <input id="tgl_lahir" autocomplete="off" required type="text" name="tgl_lahir" class='form-control'></div>
                                     
								  </div>
                                </div>                  
										 
                             
 
                                <hr>
                                <div class="row row-xs align-items-center mg-b-20">
										<div class="col-md-4">
											<label class="form-label mg-b-0" style='color:black'>Tanggal test</label>
								                </div>
										<div class="col-md-8 mg-t-5 mg-md-t-0">
 									 <input type="text" required  name="tgl_test" id="tgl_tes" class="form-control">
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
                                      if($this->session->userdata("level")=="pic_covid"){
                                        $this->db->where("kode_istana",$this->session->kode_istana);
                                    }
                                    //  $this->db->where("kode_istana",$this->session->userdata("kode_istana"));
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
 
	$("#form_akun").hide();
    var nik_peg;
	function cekNikPeg(){
		var nik_pegawai = $("[name='f[nip_pegawai]']").val();
		if(nik_pegawai==""){return false;}
		$("#response").html(cantik());
	  	  loading("loading");
		var url   = "<?php echo site_url("input/getDataPegawaiUntukKeluarga");?>";
							var param = {val:nik_pegawai,<?php echo $this->m_reff->tokenName()?>:token};
							$.ajax({
									type: "POST",dataType: "json",data: param, url: url,
									success: function(val){
                                        nik_peg=nik_pegawai;
										token=val['token'];
										$("#formToken").val(token);
										$("#response").html(val['data']);
										if(val['data'].length<350){
											$("#form_akun").hide();
                                            notif("<font color='black'>Data tidak ditemukan!</font>");
										}else{
											$("#form_akun").show();
                                            $("#pilihan_hubungan").html(val['pilihan_hubungan']);
										}
                                       unblock("loading");
									}
							});	
	}
</script>



 

      <script>
      $('#tgl_tes').daterangepicker({
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
	 
    
	window.asd = $('.SlectBox').SumoSelect({ csvDispCount: 3, selectAll:true, captionFormatAllSelected: "Yeah, OK, so everything." });
	window.Search = $('.search-box').SumoSelect({ csvDispCount: 3, search: true, searchText:'Enter here.' });
	window.sb = $('.SlectBox-grp-src').SumoSelect({ csvDispCount: 3, search: true, searchText:'Enter here.', selectAll:true });
	$('.testselect1').SumoSelect();
	$('.testselect2').SumoSelect();
	$('.selectsum1').SumoSelect({ okCancelInMulti: true, selectAll: true });
	$('.selectsum2').SumoSelect({ selectAll: true });
	
 
	  </script>




<script>
function setJK(jk){
$("[name='jk']").val(jk);
}
$("#form_jk").hide();
function klikhub(val,jk){

$("#nama_lengkap").html(val);
    if(!jk){
        $("#form_jk").show();
        $("input:radio[name=opsi_jk][value="+jk+"]")[0].checked = true;                 
    }else{ 
        $("#form_jk").hide();
        $("#jeka").val(jk);
    }
}
function getDataByNik(val){
    var url   = "<?php echo site_url("input/getDataKeluarga");?>";
    var nik_pegawai = $("[name='f[nip_pegawai]']").val();
							var param = {nik_pegawai:nik_pegawai,val:val,<?php echo $this->m_reff->tokenName()?>:token};
							$.ajax({
									type: "POST",dataType: "json",data: param, url: url,
									success: function(val){
										token=val['token'];
                                        $("#formToken").val(token);
                                        if(val['status']==true){
                                            $("[name='f[nama]']").val(val['data'].nama); 
                                            $("[name='f[tempat_lahir]']").val(val['data'].tempat_lahir);
                                            $("[name='tgl_lahir']").val(val['tgl_lahir']); 
                                            $("input:radio[name=id_hubungan][value="+val['data'].id_hubungan+"]")[0].checked = true;
                                            klikhub(val["data"].nama,val["data"].jk);
                                            // setTimeout(function(){ alert("Hello"); }, 3000);
                                        }else{
                                            if(val["info"]!=false){
                                                notif(val["info"]);
                                                $("[name='f[nik]']").val("");
                                            }

                                            $("[name='f[nama]']").val(""); 
                                            $("[name='f[tempat_lahir]']").val("");
                                            $("[name='tgl_lahir']").val("");  
                                           


                                        }
                                        
                                    
									}
							});	
	
}
</script>