<!DOCTYPE html>
<html>
<body>

<p>Jika ini berlangsung lama mohon aktifkan GPS di HP anda dan kemudian reload ulang halaman.</p>

 
<p id="demoGeo"></p>

<script>
 
setTimeout(() => {
    getLocation();  
}, 1000);

var x = document.getElementById("demoGeo");
x.innerHTML="<img src='<?php echo base_url()?>assets/images/gps.gif'> <i>Sedang mendeteksi lokasi ....</i>";

function getLocation() {
if (navigator.geolocation) {
navigator.geolocation.getCurrentPosition(showPosition);
} else {
x.innerHTML = "Gunakan browser google chorme / safari.";
}
}

function showPosition(position) {
cekLokasi(position.coords.latitude,position.coords.longitude);
}

function cekLokasi(lat,lng){
    x.innerHTML="processing....";
	var url = "<?php echo base_url()?>home/cekLokasiPulang";
	var ket = "<?=$ket;?>";
			var param = {
				id:6,lat:lat,lng:lng,<?php echo $this->m_reff->tokenName()?>: token,ket:ket
			};
			$.ajax({
				type: "POST",
				dataType: "json",
				data: param,
				url: url,
				beforeSend: function() {
					loading_block("demoGeo");
				},
				success: function(val) {
                    if(val["data"].sts==false){
                        $("#menu-warning-1").showMenu();
                        $("#menu-welcome-modal-scan").hideMenu();
				    	unblock("demoGeo");
                        $("#jarak").html(val["data"].jarak);
						   $("#jarakInfo").html(val['jarak']);
			
                        return false;
                    }
                   
                    notif_absen();
                    reloadAbsen();
                    infoact();
                    $("#menu-welcome-modal-scan").hideMenu();
					unblock("demoGeo");
					token = val['token'];
				}
			});
}



</script>

</body>
</html>