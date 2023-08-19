 <div class="card card-style" id="loading_ks">
<div class="content mb-0">
<h3>Kirim : Kritik & saran</h3>
  
<div class="  input-required mb-">
 
 
<textarea name="ks" placeholder="ketik disini..." class="form-control" style="min-hight:200px"></textarea>
</div>

 
 
 <br>
 <a href="javascript:kirim_ks()" class="btn btn-m btn-full mb-3 rounded-xl text-uppercase font-900 shadow-s bg-mint-dark">kirim</a>
 
 
</div>
</div>
 
<div id="divks"></div>




<script>

 setTimeout(function(){ reload_status(); }, 700);
 var load = loading();
 $("#divks").html(load);
function reload_status(){  
	 var load = loading();
	  $("#divks").html(load);
	  $.post("<?php echo base_url()?>up/reload_ks", function(data, status){
		  $("#divks").html(data);
	  }); 
 }
 
 function kirim_ks(){  
 var msg = $("[name='ks']").val();
 if(!msg){ return false;}
	  loading("loading_ks");
	  $("#divks").html(load);
	  $.post("<?php echo base_url()?>up/kirim_ks",{msg:msg}, function(data, status){
		$("[name='ks']").val("");
		  reload_status();
		  unblock("loading_ks");
	  }); 
 }
 var idhapus;
 function hapus_ks(id){
	 idhapus=id;
	$('#menu-confirm').showMenu();
 }
 function close_confirm(){
	 $('#menu-confirm').hideMenu();
 }
 function yes_hapus(){
	 var id=idhapus;
	  loading("divks");
	  $.post("<?php echo base_url()?>up/hapus_ks",{id:id}, function(data, status){
		$("[name='ks']").val("");
		 $('#menu-confirm').hideMenu();
		  reload_status();
		  unblock("divks");
	  }); 
 }
</script>




</div>


<div id="menu-confirm" class="menu menu-box-bottom menu-box-detached rounded-m" data-menu-height="200" data-menu-effect="menu-over">
<h2 class="text-center font-700 mt-3 pt-1">Hapus ?</h2>
 <br>
 <br>
<div class="row mr-3 ml-3">

<div class="col-6">
<a href="javascript:close_confirm()" class="close-menu btn btn-sm btn-full button-s shadow-l rounded-s text-uppercase font-900 bg-red1-dark">Batal</a>
</div>
<div class="col-6">
<a  href="javascript:yes_hapus()" onclick="yes_hapus()" class="close-menu btn btn-sm btn-full button-s shadow-l rounded-s text-uppercase font-900 bg-green1-dark">YA! Hapus</a>
</div>
</div>
</div>
