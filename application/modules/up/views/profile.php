 
 
<div id="divInfo"></div>




<script>

 setTimeout(function(){ reload_status(); }, 700);
 var load = loading();
 $("#divInfo").html(load);
function reload_status(){  
var id ="<?php echo $this->uri->segment(3)?>";
	 var load = loading();
	  $("#divInfo").html(load);
	  $.post("<?php echo base_url()?>up/reload_profile/?id="+id, function(data, status){
		  $("#divInfo").html(data);
	  }); 
 }
</script>