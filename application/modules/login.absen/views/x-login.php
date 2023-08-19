<!DOCTYPE html>
 <html lang="eng"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
 
    
    <title>login - KENDALI ISTANA</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- External CSS libraries -->
    <link type="text/css" rel="stylesheet" href="<?php echo base_url()?>assets/login-assets/bootstrap.min.css">
 
    <link href="<?php echo base_url()?>assets/css/icons.css" rel="stylesheet">
 
  
    <!-- Custom Stylesheet -->
    <link type="text/css" rel="stylesheet" href="<?php echo base_url()?>assets/login-assets/style.css">
    <link rel="stylesheet" type="text/css" id="style_sheet" href="<?php echo base_url()?>assets/login-assets/default.css">

</head>
<body id="top">
 
 

<!-- Login 1 start -->
<div class="login-1">
    <div class="container-fluid">
        <div class="row login-box">
            <div class="col-lg-6 bg-color-15 pad-0 none-992 bg-img">
                <div class="info clearfix">
                    <h1>KENDALI <span>  ISTANA</span></h1>
                    <!-- <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type</p> -->
                </div>
            </div>
            <div class="col-lg-6 align-self-center pad-0 form-section">
                <div class="form-inner">
               
                    <h3>Sign Into Your Account</h3>
                    <form action="javascript:login()" method="POST" id="formlogin">
                        <div class="form-group form-box">
                            <input type="text" name="username" class="form-control" placeholder="Username" aria-label="Username">
                            <i class="fa fa-user"></i>
                        </div>
                        <div class="form-group form-box">
                            <input type="password" name="password" class="form-control" autocomplete="off" placeholder="Password" aria-label="Password">
                            <i class="fa fa-key"></i>
                        </div>
                      
                        <div class="form-group">
                            <button type="submit"   class="btn-md btn-theme w-100">Login</button>
                        </div>
                         
                        <div id="msg" class="  alert-warning"></div>
                    </form>
                    <div class="clearfix"></div>
                 </div>
                 
            </div>
        </div>
    </div>
</div>
<!-- Login 1 end -->

<!-- External JS libraries -->
<script src="<?php echo base_url()?>assets/login-assets/jquery.min.js"></script>
 
<script src="<?php echo base_url()?>assets/login-assets/bootstrap.bundle.min.js"></script>
<!-- Custom JS Script -->
<script>
    $("#msg").hide();
function login()
 {
    $("#msg").show();
 $('#msg').html("<img style='width:50px;height:80px' src='<?php echo base_url()?>plug/img/progres.gif'> Please wait...");
	 $.ajax({
	 url:"<?php echo base_url()?>login/cekLogin",
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
  
 }</script>


</body></html>