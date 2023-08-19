
<div class="card card-style">
<div class="content mb-0">
<h3 class="bolder"> Bagikan informasi</h3>
<p>
Pesan yang anda bagikan   akan terlihat diberanda orang lain
</p>
 
 
<div class="input-style input-style-1 input-required">
<span class="input-style-1-inactive">Mak.250 karakter</span>
<em>(required)</em>
<textarea  style="max-height:80px;border:#DCDCDC solid 1px;padding:15px" maxlength="250" name="update_status" class="font-22" placeholder="ketik disini..."></textarea>
</div>
 <a href="javascript:kirim_status()" class="btn btn-m btn-full mb-3 rounded-xl text-uppercase font-900 shadow-s bg-highlight">Kirim</a>
</div>
</div>

<div id="shareInfo"></div>

<script>
 
	 
 setInterval(function(){ getNewStatus(); }, 13000);

 setTimeout(function(){ reload_status(); }, 1000);
 
  var load = loading();
	  $("#shareInfo").html(load);
function getNewStatus(){ 
	  $.post("<?php echo base_url()?>hallo/getNewStatus", function(data, status){
		
		   if(data.length>=100){
			    $("#newStatus").prepend($(data).fadeIn('slow'));  
			    setTimeout(function(){ $("#newStatus").hide().show(1000); }, 300);
		   }
		   
	  }); 
 }
 
 
function reload_status(){ 

	 var load = loading();
	  $("#shareInfo").html(load);
	  $.post("<?php echo base_url()?>hallo/reload_status", function(data, status){
		  $("#shareInfo").html(data);
	  }); 
 }
 function kirim_status(){
	 var msg = $("[name='update_status']").val();
	   $.post("<?php echo base_url()?>hallo/kirim_status",{msg:msg}, function(data, status){
		 // $("#newStatus").append(data);
		     $("#newStatus").prepend($(data).fadeIn('slow'));     
		   $("[name='update_status']").val("");
		   $("#newStatus").hide().show(1000);
	  }); 
 }
 function kirim_ucapan(){
      var idm  = 	$("[name='ucapanID']").val();  
	 var msg = $("[name='msg_ucapan']").val();
	  
	   $.post("<?php echo base_url()?>hallo/kirim_ucapan",{msg:msg,idm:idm}, function(data, status){ 
		 // $("#newStatus").append(data);
		   $("#msgultah"+idm).append($(data).fadeIn('slow'));     
		   $("[name='msg_ucapan']").val("");
		   //$("#msg"+idm).html(data);
		   $("#ucapan_mdl").hideMenu();
		   $("#msgultah"+idm).hide().show(1000);
	  }); 
 }
 function kirim_balasan(){
	 var idm  = 	$("[name='replayID']").val();  
	 var msg = $("[name='msg_balasan']").val();
	  
	   $.post("<?php echo base_url()?>hallo/kirim_balasan",{msg:msg,idm:idm}, function(data, status){ 
		 // $("#newStatus").append(data);
		   $("#msg"+idm).append($(data).fadeIn('slow'));     
		   $("[name='msg_balasan']").val("");
		   //$("#msg"+idm).html(data);
		   $("#status_mdl").hideMenu();
		   $("#msg"+idm).hide().show(1000);
	  }); 
 }
</script>

<script>
function replay(id,msg){
	$('#status_mdl').showMenu();
	$('#statusReplayContent').html(msg);
	$('#replayID').val(id);
}
function ucapkan(id){
    $('#ucapan_mdl').showMenu(); 
	$('#ucapanID').val(id);
}
</script>


</div>
<div id="ucapan_mdl" class="menu menu-box-bottom menu-box-detached rounded-m" style="height:200px;width:96%" >
 <input type="hidden" id="ucapanID" name="ucapanID">
<div class="content mb-0">
 
  
 <b>Ucapan :</b><br>
<div class="input-style input-style-1 input-required">
  
<textarea  style="max-height:80px;border:#DCDCDC solid 1px;padding:15px" 
maxlength="250" name="msg_ucapan" class="font-16" placeholder="ketik disini..."></textarea>
 
</div>
 <a href="javascript:kirim_ucapan()" class="btn btn-m btn-full mb-3 rounded-xl text-uppercase font-900 shadow-s bg-highlight">Kirim</a>
</div>
  
</div>




<div id="status_mdl" class="menu menu-box-bottom menu-box-detached rounded-m" style="height:350px;width:96%" >
 <input type="hidden" id="replayID" name="replayID">
<div class="content mb-0">
<div class="bolder font-16 text-black content"  id="statusReplayContent"> </div>
 
 <div class="divider   divider-margins"></div>
 komentar :<br>
<div class="input-style input-style-1 input-required">
  
<textarea  style="max-height:80px;border:#DCDCDC solid 1px;padding:15px" 
maxlength="250" name="msg_balasan" class="font-16" placeholder="ketik disini..."></textarea>

</div>
 <a href="javascript:kirim_balasan()" class="btn btn-m btn-full mb-3 rounded-xl text-uppercase font-900 shadow-s bg-highlight">Kirim</a>
</div>
 
  
 
</div>




<script>
var compus;
var ucapan;
function hapus_com(id){
     compus=id;
//	 setTimeout(function(){ $('#menu-hapus-com').hideMenu(); }, 200); 
	$('#menu-hapus-com').showMenu();
}
function hapus_ucapan(id){
     ucapan=id;
	$('#menu-hapus-ucapan').showMenu();
}

function yes_hapus_com(){
    var id=compus;
	  loading("com"+id);
	  $('#menu-hapus-com').hideMenu();
	  $.post("<?php echo base_url()?>hallo/hapus_com",{id:id}, function(data, status){   
		  $("#com"+id).fadeOut(600);
		  setTimeout(function(){  $("#com"+id).html(""); }, 600);
	  }); 
}

function yes_hapus_ucapan(){
    var id=ucapan;
	  loading("ucapan"+id);
	  $('#menu-hapus-ucapan').hideMenu();
	  $.post("<?php echo base_url()?>hallo/hapus_ucapan",{id:id}, function(data, status){   
		  $("#ucapan"+id).fadeOut(600);
		  setTimeout(function(){  $("#ucapan"+id).html(""); }, 600);
	  }); 
}

 var idhapus;
 function hapus_sts(id){
	 idhapus=id;
	 setTimeout(function(){ $('#status_mdl').hideMenu(); }, 200);
	
	$('#menu-hapus').showMenu();
 }
 function close_confirm(){
	 $('#menu-hapus').hideMenu();
	 $('#menu-hapus-com').hideMenu();
 }
 function yes_hapus(){
	 var id=idhapus;
	  loading("card"+id);
	  $('#menu-hapus').hideMenu();
	  $.post("<?php echo base_url()?>hallo/hapus_status",{id:id}, function(data, status){   
		  $("#card"+id).fadeOut(1000);
		 
		  	 setTimeout(function(){  $("#card"+id).html(""); }, 1000);
	  }); 
 }
</script>



<div id="menu-hapus" class="  menu menu-box-bottom menu-box-detached rounded-m" data-menu-height="200" data-menu-effect="menu-over">
<h2 class="text-center font-700 mt-3 pt-1 ">Hapus ?</h2>
 <br>
 <br>
<div class="row mr-3 ml-3">

<div class="col-6">
<a href="javascript:close_confirm()" class="close-menu btn btn-sm btn-full button-s shadow-l rounded-s text-uppercase font-900 bg-yellow1-dark">Batal</a>
</div>
<div class="col-6">
<a  href="javascript:yes_hapus()" onclick="yes_hapus()" class="close-menu btn btn-sm btn-full button-s shadow-l rounded-s text-uppercase font-900 bg-green1-dark">YA! Hapus</a>
</div>
</div>
</div>





<div id="menu-hapus-com" class="  menu menu-box-bottom menu-box-detached rounded-m" data-menu-height="200" data-menu-effect="menu-over">
<h2 class="text-center font-700 mt-3 pt-1 ">Hapus ?</h2>
 <br>
 <br>
<div class="row mr-3 ml-3">

<div class="col-6">
<a href="javascript:close_confirm()" class="close-menu btn btn-sm btn-full button-s shadow-l rounded-s text-uppercase font-900 bg-yellow1-dark">Batal</a>
</div>
<div class="col-6">
<a  href="javascript:yes_hapus_com()" onclick="yes_hapus_com()" class="close-menu btn btn-sm btn-full button-s shadow-l rounded-s text-uppercase font-900 bg-green1-dark">YA! Hapus</a>
</div>
</div>
</div>






<div id="menu-hapus-ucapan" class="  menu menu-box-bottom menu-box-detached rounded-m" data-menu-height="200" data-menu-effect="menu-over">
<h2 class="text-center font-700 mt-3 pt-1 ">Hapus ?</h2>
 <br>
 <br>
<div class="row mr-3 ml-3">

<div class="col-6">
<a href="javascript:close_confirm()" class="close-menu btn btn-sm btn-full button-s shadow-l rounded-s text-uppercase font-900 bg-yellow1-dark">Batal</a>
</div>
<div class="col-6">
<a  href="javascript:yes_hapus_ucapan()" onclick="yes_hapus_ucapan()" class="close-menu btn btn-sm btn-full button-s shadow-l rounded-s text-uppercase font-900 bg-green1-dark">YA! Hapus</a>
</div>
</div>
</div>
