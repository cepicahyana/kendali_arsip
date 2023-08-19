<?php
$this->db->where("id",$id=$this->input->post("id"));
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

<form  action="javascript:submitForm('modal')" id="modal" url="<?php echo base_url()?>input/update"  method="post" enctype="multipart/form-data">
 <input type="hidden" name="id" value="<?php echo $id;?>">
								<div class=" pd-sm-20 "  >
								 
									<div class="row row-xs align-items-center mg-b-20">
										
									 
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
									echo form_dropdown("f[kode_jenis]",$op,$data->kode_jenis,"required class='form-control SlectBox' style='color:black'"); 
									?>
										</div>
   </div>

<div class="row row-xs align-items-center mg-b-20">
										<div class="col-md-4">
											<label class="black form-label mg-b-0" style='color:black'>Pilih jenis test </label>
								                </div>
										<div class="col-md-8 mg-t-5 mg-md-t-0">
 									<?php
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

 
   <button  onclick="submitForm('modal')"  
                                    class="float-right btn btn-primary pd-x-30 mg-r-5 mg-t-5"><i class='fa fa-save'></i> Simpan</button>
								 
                                     
                                    </div>   
</div>									
				<!-- /row -->
</form>

</div>
</div>

 

<script>

	setTimeout(function(){ 	getData();}, 300);

	$("#form_akun").show();
	function getData(){
		var val = "<?php echo $nip;?>";
		if(val==""){return false;}
		$("#response").html(cantik());
		$.post("<?php echo site_url('input/getDataPegawaiEdit')?>",{val:val}, function(data){
			 $("#response").html(data);
			 if(data.length<250){
				$("#form_akun").hide();
			 }else{
				$("#form_akun").show();
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