<!DOCTYPE HTML>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
<title>KENDALI PPNPN</title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>mobile/styles/bootstrap.css">
<!-- <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900|Roboto:300,300i,400,400i,500,500i,700,700i,900,900i&amp;display=swap" rel="stylesheet"> -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>mobile/fonts/css/fontawesome-all.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>plug/fullcalendar/mobile.css"> 
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>plug/css/addclass.css"> 
<!-- <link rel="manifest" href="<?php echo base_url()?>mobile/_manifest.json" data-pwa-version="set_in_manifest_and_pwa_js"> -->
<link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url()?>landingpage/logokendali.png">
<link rel="icon" href="<?php echo base_url()?>landingpage/logokendali.png" type="image/gif" sizes="16x16">
  <script type="text/javascript" src="<?php echo base_url()?>mobile/scripts/jquery.js"></script> 
	<script src="<?php echo base_url()?>plug/jqueryform/jquery.form.js"></script>
	<script src="<?php echo base_url()?>plug/blokui.js"></script>
	<script src="<?php echo base_url()?>plug/js/angular_mobile.js"></script>
	<script type="text/javascript" src="<?php echo base_url()?>plug/js/mask.js"></script>
	<!-- <script src="<?php echo base_url()?>plug/qrscanner/jsQR.js"></script> -->
  <!-- <link href="<?php echo base_url()?>plug/qrscanner/css.css" rel="stylesheet"> -->
<script>
function loading(){
	return '<br/><div class="d-flex justify-content-center"><div class="spinner-border color-blue2-dark" style="border-width: 7px;" role="status"><span class="sr-only">.</span></div> &nbsp;&nbsp;Mohon tunggu ...</div>';
	}
	
	
	var	token  = "<?php echo $this->m_reff->getToken()?>";
function submit(id)
{		
		var form = $("#"+id);
		var link = $(form).attr("url");
	 
		$.ajax({
		 url:link,
		 data: $(form).serialize(),
		 method:"POST",
		 dataType:"JSON",
		 beforeSend: function() {
               loading_block("area_"+id);
            },
		 success: function(data)
				{ 	   unblock("area_"+id); 	
					if(data["gagal"]==true)
					{	  
							notif(data["info"]);
					}else{
						finish();
					}  		
				}
		});     
};	
function submitUpload(id)
{		
		var form = $("#"+id);
		var link = $(form).attr("url");
	 
		$(form).ajaxForm({
		 url:link,
		 data: $(form).serialize(),
		 method:"POST",
		 dataType:"JSON",
		 beforeSend: function() {
               loading_block("area_"+id);
            },
		 success: function(data)
				{ 	   unblock("area_"+id); 	
					if(data["gagal"]==true)
					{	  
							notif(data["info"]);
					}else{
						finish();
					}  		
				}
		});     
};

</script>

</head>
<body class="theme-light" data-highlight="mint">
<div id="preloader"><div class="spinner-border color-highlight" role="status"></div></div>
<div id="page">
<!--
<div class="header header-fixed header-auto-show header-logo-app">
<a href="<?php echo base_url()?>mobile/index.html" class="header-title">AZURES</a>
<a href="<?php echo base_url()?>mobile/#" data-menu="menu-main" class="header-icon header-icon-1"><i class="fas fa-bars"></i></a>
<a href="<?php echo base_url()?>mobile/#" data-toggle-theme class="header-icon header-icon-2 show-on-theme-dark"><i class="fas fa-sun"></i></a>
<a href="<?php echo base_url()?>mobile/#" data-toggle-theme class="header-icon header-icon-2 show-on-theme-light"><i class="fas fa-moon"></i></a>
<a href="<?php echo base_url()?>mobile/#" data-menu="menu-highlights" class="header-icon header-icon-3"><i class="fas fa-brush"></i></a>
</div>-->
<?php echo $this->load->view("temp_ppnpn/menu");?>
<div class="page-content">

<div class="page-title page-title-large">
<h2 data-username="<?php echo $this->m_reff->nama_depan()?>" class="sadow text-white"><i class='fa fa-rss'></i> KENDALI PPNPN</h2>
<a style="margin-top:-41px" href="<?php echo base_url()?>up" data-menu="menu-main" class="bg-fade-gray1-dark shadow-xl preload-img" data-src="<?php echo $this->m_reff->dp_ppnpn()?>"></a>
</div>
<div class="card header-card shape-rounded" data-card-height="210">
<div class="card-overlay bg-highlight opacity-95"></div>
<div class="card-overlay dark-mode-tint"></div>
<div class="card-bg preload-img" data-src="<?php echo $this->m_reff->dp()?> "></div>
</div>

<?php 
$this->load->view($konten);
?>

<!--
<div class="footer">
<?php // echo $this->load->view("temp_ppnpn/menu_footer.php");?>
</div>
-->
 
</div>

<div id="menu-share" class="menu menu-box-bottom menu-box-detached rounded-m"   data-menu-height="420" data-menu-effect="menu-over">
<?php echo $this->load->view("temp_ppnpn/menu_share.php");?>
</div>

<?php echo $this->load->view("temp_ppnpn/menu_color.php");?>
 
<div id="menu-main" class="menu menu-box-right menu-box-detached rounded-m" data-menu-width="260"   data-menu-active="nav-welcome" data-menu-effect="menu-over">
<?php echo $this->load->view("temp_ppnpn/menu_main.php");?>
</div>

<script>
function success(msg){
$("#menu-success-1").showMenu();
$("#success_message").html(msg);
}
</script>

<div id="menu-success-1" class="menu menu-box-modal rounded-m " data-menu-height="270" data-menu-width="310" style="display: block; width: 310px; height: 300px;">
        <h1 class="text-center mt-3 pt-1"><i class="fa fa-3x fa-check-circle color-green-dark shadow-xl rounded-circle"></i></h1>
        <h1 class="text-center mt-3 font-700">success</h1>
        <p class="boxed-text-l" id="success_message">
        
        </p>
        <a href="#" class="close-menu btn btn-m btn-center-m button-s shadow-l rounded-s text-uppercase font-900 bg-green-light">OK</a>
    </div>
 
<script type="text/javascript" src="<?php echo base_url()?>mobile/scripts/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>mobile/scripts/custom.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>mobile/worker.js"></script>
<script src="<?php echo base_url()?>plug/fullcalendar/mobile.js"></script> 

</body>
</html>

 


