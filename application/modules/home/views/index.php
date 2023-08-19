<?php
 
$subbagian = $this->m_reff->goField("data_pegawai","subbagian","where id='".$this->session->userdata("id")."'");
 
 
$jam = date("H");
if($jam<12){
    $absen = "MASUK";
    $href  = 'href="javascript:absen()"';
}else{
    $absen = "PULANG";   
    $href  = 'href="javascript:absen_pulang()"';
}
?>

<div class="card card-style rounded-m shadow-xl bg-27" data-card-height="100" >
<div class="content">
<div class="d-flex" style="z-index:2;position:absolute">
<div class="pr-2">
<img style="border:#28a745 solid 1px" src="<?php echo $this->m_reff->fotoProfile()?>" width="50" height="50" class="me-3 bg-highlight rounded-xl">
</div>
<div>
<h2 class="mb-0 pt-1 text-white"><?php echo $this->m_reff->nama()?></h2>
<p class="color-white font-11 mt-n2 mb-3">Pegawai Pemerintah Non Pegawai Negeri </p>
</div>
</div>
<div class="card-overlay bg-black opacity-70"></div>
</div>
</div>

  

<div class="card card-style round-medium shadow-huge top-30">
<div class="content">
<div class="d-flexs">
<p style="line-height:14px;text-align:left">
Silahkan untuk melakukan absen dan melaporkan pekerjaan setiap hari sebagai pertimbangan dalam penilaian kinerja PPNPN.
</p>
<div class="row mb-0">


<?php
$cek = $this->mdl->dataAbsen();
if(!isset($cek->id)){?>

<div class="col-12 pe-1 absenawal">
<a data-vibrate="100" <?php echo $href; ?> class="sadow btn btn-3d btn-m btn-full mb-3 rounded-xs 
text-uppercase font-900 shadow-s border-mint-dark bg-mint-light sadow bg1"> 
<i class="fa fa-fingerprint  text-white"></i><font size="1px" color="white"> Absen  <?=$absen; ?></font></a>
</div>
<?php } ?>
<!-- 
<div class="col-6 ps-1 pe-1">
<a href="javascript:inputJob()" class="sadow btn btn-3d btn-m btn-full mb-3 rounded-xs 
text-uppercase font-900 shadow-s border-mint-dark bg-mint-light bg1"><i class="fa fa-edit text-white"></i> <font size="1px" color="white"> Input pekerjaan</font></a>
</div> -->
</div>


<div id="dataAbsen"></div>



</div>
</div>
</div>






<div id="infoact"></div>
</div>

 

 
<script>
setTimeout(() => {
    infoact();
    reloadAbsen();
}, 300);
    
      
function absen(){
	// $('#status_mdl').showMenu();
	// $('#statusReplayContent').html("msg");
    notifAbsen();
}

function absen_pulang(){
	loading_block("catatLembur");
	var url = "<?php echo base_url()?>home/absen_pulang";
			var param = {
				<?php echo $this->m_reff->tokenName()?>: token
			};
			$("#menu-welcome-modal-pulang").showMenu();
			$.ajax({
				type: "POST",
				dataType: "json",
				data: param,
				url: url,
				beforeSend: function() {
					loading_block("infoact");
				},
				success: function(val) {
					token = val['token'];
                    $("#catatLembur").html(val['data']);
                    unblock("infoact");
				}
			});
}

function infoact(){
    var url = "<?php echo base_url()?>home/infoact";
			var param = {
				<?php echo $this->m_reff->tokenName()?>: token
			};
			$.ajax({
				type: "POST",
				dataType: "json",
				data: param,
				url: url,
				beforeSend: function() {
					loading_block("infoact");
				},
				success: function(val) {
					token = val['token'];
                    $("#infoact").html(val['data']);
                    unblock("infoact");
				}
			});
}
function reloadAbsen(){
    var url = "<?php echo base_url()?>home/reloadAbsen";
			var param = {
				<?php echo $this->m_reff->tokenName()?>: token
			};
			$.ajax({
				type: "POST",
				dataType: "json",
				data: param,
				url: url,
				beforeSend: function() {
					loading_block("dataAbsen");
				},
				success: function(val) {
					token = val['token'];
                    $("#dataAbsen").html(val['data']);
                    unblock("dataAbsen");
				}
			});
}

function notifAbsen(){
    $("#menu-welcome-modal").showMenu();
}

// function notifAbsenPulang(){
//     $("#menu-welcome-modal-pulang").showMenu();
// }
 


function setAbsen(id){

<?php if(strtolower($subbagian)!="pengemudi"){ ?>

if(id==1){
		return showScan();
	}
	
<?php } ?>
	

    var url = "<?php echo base_url()?>home/setAbsen";
			var param = {
				<?php echo $this->m_reff->tokenName()?>: token,
				id: id
			};
			$.ajax({
				type: "POST",
				dataType: "json",
				data: param,
				url: url,
				beforeSend: function() {
					loading_block("menu-welcome-modal");
				},
				success: function(val) {
					unblock("menu-welcome-modal");
                    $("#menu-welcome-modal").hideMenu();
                    $("#menu-welcome-modal-pulang").hideMenu();
					token = val['token'];
                    notif_absen();
                    reloadAbsen();
                    infoact();
					$(".absenawal").hide();
				}
			});
}


function showScan(){
	$("#menu-welcome-modal-scan").showMenu();
	var url = "<?php echo base_url()?>home/showScan";
			var param = {
				<?php echo $this->m_reff->tokenName()?>: token
			};
			$.ajax({
				type: "POST",
				dataType: "json",
				data: param,
				url: url,
				beforeSend: function() {
					loading_block("menu-welcome-modal-scan");
				},
				success: function(val) {
					unblock("menu-welcome-modal-scan");
                    $("#menu-welcome-modal").hideMenu();
                    $("#isi-scan").html(val['data']);
                    // $("#jarakInfo").html(val['jarak']);
					// alert(val['jarak']);
					token = val['token'];
				}
			});
}


function notif_absen(){
    $("#notification-1").toast({ delay: 5000 });
    $('#notification-1').toast("show");
}

<?php
if($this->session->flashdata("absen")){
echo "setTimeout(() => {
	notif_absen(); 	
   }, 300);";
}?>
 
function inputJob(id){
    $("#modal-job").showMenu();
    $("#isiModal").html(loading());
    var url = "<?php echo base_url()?>home/inputJob";
			var param = {
				<?php echo $this->m_reff->tokenName()?>: token
			};
			$.ajax({
				type: "POST",
				dataType: "json",
				data: param,
				url: url,
				beforeSend: function() {
					loading_block("area_modal-job");
				},
				success: function(val) {
					unblock("area_modal-job");
					token = val['token'];
                    $("#isiModal").html(val['data']);
                   
				}
			});
}

function finish(){
    $("#modal-job").hideMenu();
    success();
    infoact();
}


function showScanPulang(){
	$("#menu-welcome-modal-scan").showMenu();
	var lembur = $("[name='txtLembur']").val();
	var url = "<?php echo base_url()?>home/showScanPulang";
			var param = {
				<?php echo $this->m_reff->tokenName()?>: token,ket:lembur,id: 6
			};
			$.ajax({
				type: "POST",
				dataType: "json",
				data: param,
				url: url,
				beforeSend: function() {
					loading_block("menu-welcome-modal-scan");
				},
				success: function(val) {
					unblock("menu-welcome-modal-scan");
                    $("#menu-welcome-modal").hideMenu();
                    $("#isi-scan").html(val['data']);
                    // $("#jarakInfo").html(val['jarak']);
					// alert(val['jarak']);

					$("#menu-welcome-modal").hideMenu();
                    $("#menu-welcome-modal-pulang").hideMenu();
					
					token = val['token'];
				}
			});
}

function konfirmasiPulang(jenis=null){
	
			var lembur = $("[name='txtLembur']").val();
			if(!lembur){
				alert("mohon isi catatan lembur!");
				$("[name='txtLembur']").focus();
				return false;
			}

			if(jenis==1){
				return showScanPulang();
			}

	
			var url = "<?php echo base_url()?>home/setAbsen";
			var param = {
				<?php echo $this->m_reff->tokenName()?>: token,
				id: 6,ket:lembur
			};
			$.ajax({
				type: "POST",
				dataType: "json",
				data: param,
				url: url,
				beforeSend: function() {
					loading_block("menu-welcome-modal");
				},
				success: function(val) {
					unblock("menu-welcome-modal");
                    $("#menu-welcome-modal").hideMenu();
                    $("#menu-welcome-modal-pulang").hideMenu();
					token = val['token'];
                    notif_absen();
                    reloadAbsen();
                    infoact();
				}
			});
}


</script>

 
<div id="menu-welcome-modal" class="menu menu-box-modal menu-box-round-medium menu-box-detached rounded-s" data-menu-width="310" data-menu-height="380" data-menu-effect="menu-over" data-menu-select="page-components">
<div class="boxed-text-xl mt-4">
<!-- <h1 class="mb-3"><i class="fa fa-check-circle color-green-dark fa-3x"></i></h1> -->
<h2 class="font-700 mb-n1">ABSEN MASUK</h2>
<span class="color-highlight">Silahkan pilih salah satu sesuai kondisi</span>

<button  onclick="setAbsen(1)" class="btn btn-3d btn-m btn-full mb-3 btn-block rounded-xs text-uppercase 
font-900 shadow-s  border-blue-dark bg-blue-light sadow">  ABSEN MASUK </button>

<!-- <button onclick="setAbsen(2)" class="btn btn-3d btn-m btn-full mb-3 btn-block rounded-xs text-uppercase 
font-900 shadow-s  border-green-dark bg-green-light sadow"> WFH (BEKERJA DIRUMAH)</button> -->

<!-- <button onclick="setAbsen(3)" class="btn btn-3d btn-m btn-full mb-3 btn-block rounded-xs text-uppercase 
font-900 shadow-s  border-mint-dark bg-mint-light sadow"> DINAS (Luar)</button>

<button onclick="setAbsen(4)"  class="btn btn-3d btn-m btn-full mb-3 btn-block rounded-xs text-uppercase 
font-900 shadow-s  border-orange-dark bg-orange-light sadow"> IZIN</button>

<button onclick="setAbsen(5)" class="btn btn-3d btn-m btn-full mb-3 btn-block rounded-xs text-uppercase 
font-900 shadow-s  border-brown-dark bg-brown-light sadow">SAKIT  </button> -->


 </div>
</div>




<div id="menu-welcome-modal-pulang" class="menu menu-box-modal menu-box-round-medium menu-box-detached rounded-s" data-menu-width="310" data-menu-height="500" data-menu-effect="menu-over" data-menu-select="page-components">
<div class="boxed-text-xl mt-4" id="catatLembur">
<br>
<br>
<br>
<br>
 </div>
</div>

 



<div id="modal-job" class="menu menu-box-modal menu-box-round-medium menu-box-detached rounded-s" data-menu-width="380" data-menu-height="530" data-menu-effect="menu-over" data-menu-select="page-components">
<div id="area_modal-job">
<div class="boxed-text-xl mt-4" id="isiModal">
 
 </div>
</div>
</div>


<div id="menu-welcome-modal-scan" class="menu menu-box-modal menu-box-round-medium menu-box-detached rounded-s" data-menu-width="380" data-menu-height="530" data-menu-effect="menu-over" data-menu-select="page-components">
	<div id="area_modal-scan">
		<div class="boxed-text-xl mt-4" id="isi-scan">
		</div>
	</div>
</div>






<div id="notification-1" data-dismiss="notification-1"  class="notification notification-ios 
bg-magenta-dark ms-2 me-2   ">
        <span class="notification-icon color-white ">
            <i class="fa fa-bell"></i>
            <em>Notifikasi</em>
            <i data-dismiss="notification-1" class="fa fa-times-circle"></i>
        </span>
        <h1 class="font-18 color-white mb-n3 sadow">success</h1>
        <p class="pt-1 sadow">
          Absen behasil disimpan!
        </p>
    </div>  



	



  
 
 
<div id="del-confirm" class="menu menu-box-bottom menu-box-detached rounded-m" data-menu-height="200" data-menu-effect="menu-over">
<h2 class="text-center font-700 mt-3 pt-1">Hapus ?</h2>
<p class="boxed-text-l" id="del_desc">
</p>
<div class="row mr-3 ml-3">
<div class="col-6">
<a href="#" class="close-menu btn btn-sm btn-full button-s shadow-l rounded-s text-uppercase font-900 bg-green1-dark">Cancel</a>
</div>
<div class="col-6">
<a href="javascript:deletes()" class=" btn btn-sm btn-full button-s shadow-l rounded-s text-uppercase font-900 bg-red1-dark">Hapus</a>
</div>
</div>
</div>
 
   
<div id="modal_detail" class="menu menu-box-modal menu-box-round-medium menu-box-detached rounded-s" data-menu-width="370" data-menu-height="450" data-menu-effect="menu-over" data-menu-select="page-components">
<div class="boxed-text-xl mt-4">
<div id="infodet"></div>
 </div>
</div>


<div id="menu-warning-1" class="menu menu-box-bottom menu-box-detached rounded-m" data-menu-height="305" data-menu-effect="menu-over" style="height: 305px; display: block;">
<h1 class="text-center mt-4"><i class="fa fa-3x fa-times color-red2-dark"></i></h1>
<h1 class="text-center mt-3 text-uppercase font-700">Gagal!</h1>
<p class="boxed-text-l">
Jarak anda <span id="jarakInfo"></span> meter dari kantor<br>
Jarak maksimal <?php echo $this->mdl->max_jarak()?> meter.
</p>
<a href="#" class="close-menu btn btn-m btn-center-m button-s shadow-l rounded-s text-uppercase font-900 bg-red1-light">Go Back</a>
</div>