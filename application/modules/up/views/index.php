 <?php
 if($this->session->flashdata("msg")){
	 ?>
	 <div class="card card-style bg-red2-dark">
<div class="content">
<h4 class="color-white">PENTING!</h4>
<p class="color-white font-20">
Mohon lengkapi semua data profile anda terlebih dahulu  
</p>
</div>
</div>
 <?php }
 ?>
 
<div id="divInfo">

<?php 
$this->load->view("reload_info");?>
</div>




<script>

//  setTimeout(function(){ reload_status(); }, 700);
//  var load = loading();
//  $("#divInfo").html(load);
// function reload_status(){  
// 	 var load = loading();
// 	  $("#divInfo").html(load);
// 	  $.post("<?php echo base_url()?>up/reload_info", function(data, status){
// 		  $("#divInfo").html(data);
// 	  }); 
//  }
</script>