<!DOCTYPE HTML>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /> 
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
<title>Login - KENDALI ISTANA</title>
<link rel="shortcut icon" href="<?= base_url('landingpage/logokendali.png');?>">
<link rel="stylesheet" type="text/css" href="<?= base_url();?>mobile/styles/bootstrap.css">
<link href="<?= base_url();?>mobile/https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900|Roboto:300,300i,400,400i,500,500i,700,700i,900,900i&amp;display=swap" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?= base_url();?>mobile/fonts/css/fontawesome-all.min.css">
<link rel="manifest" href="<?= base_url();?>mobile/_manifest.json" data-pwa-version="set_in_manifest_and_pwa_js">
<link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('landingpage/logokendali.png');?>">
  <script type="text/javascript" src="<?= base_url();?>mobile/scripts/jquery.js"></script> 
	<script src="<?= base_url();?>plug/jqueryform/jquery.form.js"></script>
	<script src="<?= base_url();?>plug/blokui.js"></script>
	<script src="<?= base_url();?>plug/js/angular_mobile.js"></script>
	<script type="text/javascript" src="<?= base_url();?>plug/js/mask.js"></script>
	<script src='https://www.google.com/recaptcha/api.js'></script>
	
</head>
<body class="theme-blue" data-highlight="blue2">
<div id="preloader"><div class="spinner-border color-highlight" role="status"></div></div>
<div id="page">
<!--
<div class="header header-fixed header-auto-show header-logo-app">
<a href="<?= base_url();?>mobile/index.html" class="header-title">AZURES</a>
<a href="<?= base_url();?>mobile/#" data-menu="menu-main" class="header-icon header-icon-1"><i class="fas fa-bars"></i></a>
<a href="<?= base_url();?>mobile/#" data-toggle-theme class="header-icon header-icon-2 show-on-theme-dark"><i class="fas fa-sun"></i></a>
<a href="<?= base_url();?>mobile/#" data-toggle-theme class="header-icon header-icon-2 show-on-theme-light"><i class="fas fa-moon"></i></a>
<a href="<?= base_url();?>mobile/#" data-menu="menu-highlights" class="header-icon header-icon-3"><i class="fas fa-brush"></i></a>
</div>-->
 
<div class="page-content">

<div class="page-title page-title-large">
	<h2 data-username="" class="text-white text-center"> KENDALI ISTANA</h2>
</div>
 
<center><h1><img width='200px' style="border-radius:25px" src="<?= base_url('landingpage/logokendali.png');?>"></h1>
<br>
</center>
<div class="card header-card shape-rounded" data-card-height="210">
<div class="card-overlay bg-highlight opacity-95"></div>
<div class="card-overlay dark-mode-tint"></div>
<div class="card-bg preload-img" data-src="<?= base_url();?>upload/dp/ "></div>

</div>

<form action="javascript:login()" method="POST" id="formlogin">

	<div class="card card-style">
		<div class="content mt-2 mb-0">
			<div class="input-style has-icon input-style-1 input-required pb-1">
				<i class="input-icon fa fa-user color-theme"></i>
				<span class="input-style-1-inactive">Username</span>
				<em>(required)</em>
				<input class="font-20 form-control" autocomplete="off" style="font-size:20px" type="text" name="username" required placeholder="Username">
			</div>
			<div class="input-style has-icon input-style-1 input-required pb-1">
				<i class="input-icon fa fa-lock color-theme"></i>
				<span>Password</span>
				<em>(required)</em>
				<input type="password" name="password" required placeholder="Password">
			</div>
			<!-- <div class="input-style has-icon input-style-1 input-required pb-1">
			 
			$site_key = $this->m_reff->pengaturan(37);
			 
			<center>
				<div class="g-recaptcha"   data-sitekey="?php echo $site_key?>"></div>
				</center>
			</div> -->
			<button class="btn btn-m mt-2 mb-4 btn-block bg-blue2-dark rounded-sm text-uppercase font-900">Masuk</button>

			<div id="msg" class="alert alert-warning"></div>
		<!--
		<hr>
		belum pernah daftar ? silahkan daftar!
		<a href="<?= base_url();?>reg" class="btn btn-m mt-2 mb-4 btn-full bg-blue2-dark rounded-sm text-uppercase font-900">DAFTAR </a> 
		  Lupa password ? silahkan klik tombol dibawah!
		 <a href="<?= base_url();?>forgot" class="btn btn-m mt-2 mb-4 btn-full bg-brown2-dark rounded-sm text-uppercase font-900">LUPA PASSWORD </a><br> -->
		</div>
	</div>

</form>

<script>
$("#msg").hide();
function login()
{
    $("#msg").show();
    $('#msg').html("<img style='width:50px;height:80px' src='<?php echo base_url()?>plug/img/progres.gif'> Please wait...");
	$.ajax({
		url:"<?php echo site_url()?>login/cekLogin",
		type: "POST",
		data: $('#formlogin').serialize(),
		dataType: "JSON",
		success: function(data)
			{
				var token = data["token"];
				$("#token").val(token);
				//if success close modal and reload ajax table
				// if(data["upass"]==false){
				//    $('#msg').html("<i class='col-red'></i> Username/Password Salah!"); return false;
				// }
				
				// if(data["captca"]==false){
				//   $('#msg').html("<i class='fa fa-warning'></i> Nomor yang anda masukan tidak sama");  return false;
				// }
				
				
				if(data["sts"]==true){
				 $('#msg').html('  Berhasil !! Mohon tunggu....'); 
				  
					 window.location.href="<?php echo base_url()?>"+data["direct"]; 
				}else{
                    $('#msg').html(data["response"]);
					//  window.location.href="https://konekwa.com/login/logout"; 
				}
				
				  
				
				
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				alert('Try Again!');
			}
	});
  
}
</script>




<!--
<div class="footer">
</div>
-->
 
</div>
 
<script type="text/javascript" src="<?= base_url();?>mobile/scripts/bootstrap.min.js"></script>
<script type="text/javascript" src="<?= base_url();?>mobile/scripts/custom.js"></script>

	
	
</body>
