<?php
$id = $this->m_reff->san($this->input->post("id"));
?>
<div class="modal-content">  
	<div class="modal-header">  <h5 class="modal-titles" id="defaultModalLabel"><b>Tambah </b></h5>
		<button type="button" class="close" aria-label="Close" data-dismiss="modal">
			<span aria-hidden="true">×</span>
		</button>
	</div>


	<div class="modal-body" >

		<form  action="javascript:submitForm('modal_edit')" id="modal_edit" url="<?php echo base_url()?>data_master/insert_pimpinan_pusat"  method="post" enctype="multipart/form-data">
			<input type="hidden" id="formToken" name="<?php echo $this->m_reff->tokenName()?>" value="<?php echo $this->m_reff->getToken()?>">
			
			<div class=" pd-sm-20 "  >
			<div class="row row-xs align-items-center mg-b-20">
					<div class="col-md-12">
						<label class="form-label mg-b-0">NIP LAMA / NIP BARU / NIP SSO</label>
					</div>
					<div class="col-md-9 mg-t-5 mg-md-t-0">
						<input class="form-control" onchange="getDataPns()" required name='nip'  type="text">
					</div>
					<div class="col-md-1 mg-t-5 mg-md-t-0">
					<button type="button"   class="btn btn-light btn-sm"><i class='fa fa-search'></i> Cari</button>
					</div>
				</div>

				<div id="isi"></div>
 
  
				<button id="tombol" onclick="submitForm('modal_edit')"  
				class="float-right btn btn-primary pd-x-30 mg-r-5 mg-t-5"><i class='fa fa-save'></i> Simpan</button>

			</div>   
			<!-- /row -->
		</form>

	</div>
</div>

<script>
function dataBiro(id) {
var is = id.toLowerCase();
	if(is=="istana kepresidenan jakarta"){
  	    $("#dataBiro").show();
	}else {
		$("#dataBiro").hide();
	}
}
$("#tombol").hide();
function getDataPns(){
	$("#isi").html("<br><br><br>");
	loading("isi");
	var val =$("[name='nip']").val();
	var url   = "<?php echo site_url("portal/getDataPns");?>";
	var param = {nip:val,<?php echo $this->m_reff->tokenName()?>:token};
	$.ajax({
		type: "POST",dataType: "json",data: param, url: url,
		success: function(val) {
			unblock("isi");
			token=val['token'];
			$("#isi").html(val['data']);
			if(val['tombol']==true){
				$("#tombol").show();
			}else{
				$("#tombol").hide();
			}
		}
	});

}
</script>