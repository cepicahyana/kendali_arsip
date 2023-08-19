<?php
$kode = $this->input->post("kode");
$nama = $this->input->post("nama");
$hasil = $this->input->post("hasil");
$kode_jenis = $this->input->post("kode_jenis");
$id_hub = $this->input->post("id_hub");
$nik = $this->input->post("nik");

$positif ="";
$negatif ="";
 
	if($hasil=="+"){
		$positif ="checked";
		$negatif ="";
	} 
	if($hasil=="-"){
		$negatif ="checked";
		$positif ="";
	} 

	 
?>
	                <div class="modal-content">  
                         <div class="modal-header">  <h5 class="modal-titles" id="defaultModalLabel"><b>Upload hasil test </b></h5>
						<button type="button" class="close" aria-label="Close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
						</button>
                    </div>


                        <div class="modal-body" >
 
 <form action="javascript:simpanfile()" id="uploadfilexl">
 <table class="entry table-bordered" width="100%">
<tr>
	<td><br><span style="padding-top:3px">Atas nama </span><br>&nbsp;</td><td><b><?php echo $nama;?></b></td>
</tr>
<tr>
<td>
 
Jenis tes </td><td> 
<div class="row col-md-12">
<?php
$data_tes = $this->db->get("tr_jenis_test")->result();
foreach($data_tes as $val){
if($val->kode==$kode_jenis){
	$cek="checked";
}else{ $cek="";}
?>

<div class="col-md-4 p-1">
 <label class="rdiobox"><input required <?php echo $cek;?>  type="radio" name="kode_jenis" value="<?php echo $val->kode;?>"><span><?php echo $val->nama; ?></span></label>
</div>
<?php } ?>
 
</div>
</td> </tr>
<tr>
<td>
 
Hasil </td><td> 

<div class="row col-md-12">
<div class="col-lg-6 p-1">
 <label class="rdiobox"><input required <?php echo $positif;?> type="radio" name="hasil" value="+"><span>Positif (+)</span></label>
</div>
<div class="col-lg-6 p-1">
 <label class="rdiobox"><input required <?php echo $negatif;?> type="radio" name="hasil" value="-"><span>Negatif (-)</span></label>
</div>
</div>

</td> </tr>
<tr>
<td>
Upload file hasil tes</td>
<td>
<input class='form-control' type="file" required  name="userfile"  id="userfile"  accept=".pdf" >
<br>
<div style="font-size:11px;color:#A52A2A">- Kapasitas upload file max.5MB <br>- type file yang diizinkan : pdf</div>
</td> 
</tr>
</table>

<br>


<center id="btn1">
<button   onclick="simpanfile()" class="btn btn-info "> <i style='font-size:15px' class='typcn typcn-upload'></i>  Upload file </button>
</center> 
</form>


<center id="btn2">
<button class="btn btn-primary has-ripple" type="button" disabled="">
									<span class="spinner-grow spinner-grow-sm" role="status"></span>
									Loading...
								</button></center>


<br>
<br>
<br>
<div class="progress-bar" id="progress" >
    <div class="bar"></div >
    <div class="percent">0%</div >
</div>

<div id="statusToGet"></div>

<center>
<div id="hasilAdd">
 </div>
 <div class="card-body" id="loadingKontak"> Mohon tunggu sistem sedang mengupload....<br>
						<div class="spinner-grow text-primary" role="status">
							<span class="sr-only">Loading...</span>
						</div>
						<div class="spinner-grow text-secondary" role="status">
							<span class="sr-only">Loading...</span>
						</div>
						<div class="spinner-grow text-success" role="status">
							<span class="sr-only">Loading...</span>
						</div>
						<div class="spinner-grow text-danger" role="status">
							<span class="sr-only">Loading...</span>
						</div>
						<div class="spinner-grow text-warning" role="status">
							<span class="sr-only">Loading...</span>
						</div>
						<div class="spinner-grow text-info" role="status">
							<span class="sr-only">Loading...</span>
						</div>
						<div class="spinner-grow text-light" role="status">
							<span class="sr-only">Loading...</span>
						</div>
						<div class="spinner-grow text-dark" role="status">
							<span class="sr-only">Loading...</span>
						</div>
					</div>
</center>
  
 <script type="text/javascript">
 $('.progress-bar').hide();
 //document.getElementById("progress").style.width = "0%";
//  setTimeout(function(){  $("[name='nama'").focus(); }, 500);
	// var csrfHash="echo $this->security->get_csrf_hash(); ?>";
	// var csrfName=" echo $this->security->get_csrf_token_name(); ?>";
function simpanfile(){
	
	var kode="<?php echo $kode;?>";
	var nik="<?php echo $nik;?>";
	var hasil=$('input[name="hasil"]:checked').val();
	var kode_jenis=$('input[name="kode_jenis"]:checked').val();
    var userfile=$('#userfile').val();
 
    if(userfile=="undefined" || userfile==null || !userfile || !hasil){ 
	$('#userfile').focus();
	//  notif("Silahkan upload file");
	return false;
	}
	$('.progress-bar').show();
	$("#btn1").hide();
	$("#btn2").show();
//	$("#loadingKontak").show();
	
	$("#hasilAdd").html(""); 
	
	
	var progress = $('.progress-bar');
	var bar = $('.bar');
    var percent = $('.percent');
    var status = $('#statusToGet');
    var id_hub = "<?php echo $id_hub;?>";
	
    $('#uploadfilexl').ajaxForm({
     url:'<?php echo base_url()?>data_test/upload_file',
     type: 'post',
	 dataType:"JSON",
     data:{"id_hub":id_hub,"userfile":userfile,"kode":kode,"hasil":hasil,"kode_jenis":kode_jenis,"nik":nik,"<?php echo $this->m_reff->tokenName()?>":token}, 
    //  data:{"userfile":userfile,"id":id,"qr":qr,"nama":nama,[csrfName]:csrfHash}, 
	 
	 
	 beforeSend: function() {
		 $('.progress-bar').show();
            status.empty();
            var percentVal = '0%';
            bar.width(percentVal);
            progress.width(percentVal);
            percent.html(percentVal);
			//document.getElementById("progress").style.width = percentVal;
        },
        uploadProgress: function(event, position, total, percentComplete) {
            var percentVal = percentComplete + '%';
            bar.width(percentVal);
			 progress.width(percentVal);
            percent.html(percentVal);
        },
	 
     
     success: function(data) {
		token = data["token"];
       if(data["gagal"]==true)
	   {	 $('.progress-bar').hide();
		     $("#hasilAdd").html("<div class='alert alert-danger text-black   b'>"+data["info"]+"</div>"); 
			 	 
	   }else{
	   
	    $("#hasilAdd").html("Berhasil diupload."); 
		
		
    setTimeout(function(){ reload_table();$("#mdl_modal").modal("hide"); }, 1100);
			 notif("<span style='color:white'>Berhasil disimpan</span>");
	   }
	    // csrfHash=data.csrf; 
	     $("#btn1").show();
			   $("#btn2").hide();
			   $("#loadingKontak").hide();
	    
     },
    });     
};
</script>   




 <script>
 $("#btn2").hide();
 $("#loadingKontak").hide();
  
 </script>


 



















</div>

		</div>
 





