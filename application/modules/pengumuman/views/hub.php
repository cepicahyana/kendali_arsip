 
 
<div class="accordion mb-2" id="accordion-3">
<div data-card-height="90" class="card card-style bg-27 mb-0 rounded-m" style="height: 90px;">
<div class="card-center" >
<button class="btn accordion-btn border-0" data-toggle="collapse" data-target="#collapse7">
<h4 class="text-center color-white text-uppercase"><i class="fa fa-headset"></i> CALL CENTER</h4>
<p class="text-center color-white opacity-70 mb-0 mt-n2">  </p>
</button>
</div>
<div class="card-overlay bg-black opacity-70"></div>
</div>
 
 
</div>
 
<div id="divInfo"></div>




<script>

 setTimeout(function(){ reload_status(); }, 700);
 var load = loading();
 $("#divInfo").html(load);
function reload_status(){  
	 var load = loading();
	  $("#divInfo").html(load);
	  $.post("<?php echo base_url()?>hallo/reload_cs", function(data, status){
		  $("#divInfo").html(data);
	  }); 
 }
</script>