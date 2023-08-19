 

					<!-- breadcrumb -->
					<div class="breadcrumb-header justify-content-between">
						<div>
						 
					
						<span class="text-white tx-bold">Cari data pegawai 
							<table>
								<tr>
									<td>
									<?php
									$dt["nip"]		=	"NIP";
									$dt["nik"]		=	"NIK";
									$dt["nama"]		=	"Nama";
									echo form_dropdown("key",$dt,"",'class="form-control" ');
									?>
									</td>
									<td><input type="text" name="val"  value="<?=$this->input->get("nip");?>" class="form-control "> </td>
									<td><button onclick="search()" class="btn btn-warning  "><i class="fa fa-search"></i> cari</button></td>
								</tr>
							</table>
						
 						
						</span>
					</div>
					</div>
					<!-- /breadcrumb -->


					<!-- main-content-body -->
					<div class="main-content-body">
						<div class="row row-sm">
 							<div class="card col-md-12" id="dataResponse">
 							 
							</div>
						</div>
					</div>


<script>
function search(){
	loading("dataResponse");
	var url   = "<?php echo site_url("cek_data/search");?>";
	var key		=	$("[name='key']").val();
	var val		=	$("[name='val']").val();
      var param = {<?php echo $this->m_reff->tokenName()?>:token,key:key,val:val};
      $.ajax({
       type: "POST",dataType: "json",data: param, url: url,
       success: function(val){
        $("#dataResponse").html(val['data']);
        token=val['token'];
		unblock("dataResponse");
      }
    });	
}
<?php
if($this->input->get("nip")){
	echo '
	setTimeout(function () {
		search();
	}, 500);
	';
}
?>
</script>