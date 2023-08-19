 
	                <div class="modal-content">  
                         <div class="modal-header">  <h5 class="modal-titles" id="defaultModalLabel"><b>Tambah </b></h5>
						<button type="button" class="close" aria-label="Close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
						</button>
                    </div>


                        <div class="modal-body" >

<form  action="javascript:submitForm('modal')" id="modal" url="<?php echo base_url()?>input/insert_ppnpn"  method="post" enctype="multipart/form-data">
<input type="hidden" id="formToken" name="<?php echo $this->m_reff->tokenName()?>" value="<?php echo $this->m_reff->getToken()?>">

								<div class=" pd-sm-20 "  >
								 
									<div class="row row-xs align-items-center mg-b-20">
										
										<div class="col-md-10 mg-t-5 mg-md-t-0">
										Input NIK 
											<input onchange="getData()" autocomplete="off"  class="form-control" name="input"  placeholder="ketik..." type="text">
											   
										</div>
										<div class="col-md-1"><br>
										<center><button onclick="getData()" type='button' class='btn btn-success'>Cari</button></center>   
										</div>
										<div style='width:100%' id="response"></div>
							     </div>
						
<div id="form_akun">
<hr>

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

 
   <button  onclick="submitForm('modal')"  
                                    class="float-right btn btn-primary pd-x-30 mg-r-5 mg-t-5"><i class='fa fa-save'></i> Simpan</button>
								 
                                     
                                    </div>   
</div>									
				<!-- /row -->
</form>

</div>
</div>

 

<script>
	$("#form_akun").hide();
	function getData(){
		var val = $("[name='input']").val();
		if(val==""){return false;}
		$("#response").html(cantik());
	  	  
		var url   = "<?php echo site_url("input/dataPpnpn");?>";
							var param = {val:val,<?php echo $this->m_reff->tokenName()?>:token};
							$.ajax({
									type: "POST",dataType: "json",data: param, url: url,
									success: function(val){
										token=val['token'];
										$("#formToken").val(token);
										$("#response").html(val['data']);
										if(val['data'].length<350){
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
	
 
	  </script>