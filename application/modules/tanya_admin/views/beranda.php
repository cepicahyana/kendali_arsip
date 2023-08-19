<script>
$("a").removeClass("menuclick");
</script>
		<!-- breadcrumb -->
        <div class="breadcrumb-header justify-content-between">
						<div>
							<h4 class="content-title mb-2">Hubungi admin</h4>
							<nav aria-label="breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="#">
										Silahan sampaikan pertanyaan seputar kebutuhan terkait kesehatan ataupun lainnya
										</a></li>
									<!-- <li class="breadcrumb-item active" aria-current="page">Project</li> -->
								</ol>
							</nav>
						</div>
					 
					</div>

<div class="cards">
    <div class="row">
        <div class="col-md-4 cards">
            <div class="card">
        
							<div class="card-body">
								<form>
									<!-- <div class="form-group">
										<div class="row align-items-center">
											<label class="col-sm-2">To</label>
											<div class="col-sm-10">
												<input type="text" class="form-control">
									                </div>
								                </div>
							                </div> -->
								 
									<div class="form-group">
										<div class="row ">
											<label class="col-sm-12">Tulis pesan ?</label>
											<div class="col-sm-12">
												<textarea placeholder="Tulis pesan..." style="color:black;font-size:15px;border:black solid 1px" name="update_status" rows="3" class="form-control"></textarea>
									                </div>
								                </div>
							                </div>
								</form>
                                <div class="btn-lists ml-auto">
									<!-- <button type="button" class="btn btn-danger btn-space">Cancel</button> -->
									<button onclick="kirim_status()" type="submit" class="btn btn-light pull-right float-right btn-space">Kirim</button>
						                </div>
					                </div>
            </div>			 
		  </div>

                                
       
        <div class="col-md-8">
        <div id="shareInfo"></div>
        </div>
    </div>
							


<!-- <div class="card card-style">
<div class="content mb-0">
<h3 class="bolder"> Bagikan informasi</h3>
<p>
Pesan yang anda bagikan   akan terlihat diberanda orang lain
</p>
 
 
<div class="input-style input-style-1 input-required">
<span class="input-style-1-inactive">Mak.250 karakter</span>
<em>(required)</em>
<textarea  style="max-height:80px;border:#DCDCDC solid 1px;padding:15px" 
maxlength="250" name="update_status" class="font-22" placeholder="ketik disini..."></textarea>
</div>
 <a href="javascript:kirim_status()" class="btn btn-m btn-full mb-3 rounded-xl text-uppercase font-900 shadow-s bg-highlight">Kirim</a>
</div>
</div> -->







<script>
  var replayID;
	 
 setInterval(function(){ getNewReplay(); }, 5000);

 setTimeout(function(){ reload_status(); }, 100);
 
  var load = loading("shareInfo");
	  $("#shareInfo").html(load);

      
function getNewReplay(){
                            var url   = "<?php echo site_url("tanya_admin/getNewReplay");?>";
							var param = {<?php echo $this->m_reff->tokenName()?>:token};
							$.ajax({
									type: "POST",dataType: "json",data: param, url: url,
									success: function(val){
										// token   =  val['token'];
                                        $("#msgReplay").append($(val['data']).fadeIn('slow'));     
                                        
                                        //$("#msg"+idm).html(data);
                                        // $("#status_mdl").hideMenu();
                                        // $("#msg"+idm).hide().show(1000);
                                         

									}
							});	
 }

 
 
function reload_status(){ 

    var load = loading("shareInfo");
	  $("#shareInfo").html(load);
	  var url   = "<?php echo site_url("tanya_admin/reload_status");?>";
							var param = {<?php echo $this->m_reff->tokenName()?>:token};
							$.ajax({
									type: "POST",dataType: "json",data: param, url: url,
									success: function(val){
										token=val['token'];
										$("#shareInfo").html(val['data']); 
									}
							});	

 }
 function kirim_status(){
                            var msg = $("[name='update_status']").val();
                            if(!msg){
                                notif("<span class='text-black'>mohon tulis pesan yang akan dikirim</span>");
                                return false;
                            }
                            var url   = "<?php echo site_url("tanya_admin/kirim_status");?>";
							var param = {msg:msg,<?php echo $this->m_reff->tokenName()?>:token};
							$.ajax({
									type: "POST",dataType: "json",data: param, url: url,
									success: function(val){   
										token=val['token'];
                                        if(val["data"].error==true){
                                            var msg = val["data"].info;
                                            swal(msg, {
                                                icon: "warning",
                                                buttons : {
                                                    confirm : {
                                                        className: 'btn btn-success'
                                                    }
                                                }
                                            });

                                            return false;
                                        }
                                        reload_status();
                                        // $("#newStatus").append(val["data"]);
									
                                        // $("#newStatus").prepend($(val["data"]).fadeIn('slow'));     
                                        $("[name='update_status']").val("");
                                        // $("#newStatus").hide().show(1000);


                                        swal("Terkirim", {
                                                icon: "success",
                                                buttons : {
                                                    confirm : {
                                                        className: 'btn btn-success'
                                                    }
                                                }
                                            });

									}
							});	

 }

 function kirim_balasan(){
	 var idm  = replayID;
	 var msg = $("[name='msg_balasan']").val();


                            var url   = "<?php echo site_url("tanya_admin/kirim_balasan");?>";
							var param = {msg:msg,idm:idm,<?php echo $this->m_reff->tokenName()?>:token};
							$.ajax({
									type: "POST",dataType: "json",data: param, url: url,
									success: function(val){
										token=val['token'];
                                        $("#msgReplay").append($(val['data']).fadeIn('slow'));     
                                        $("[name='msg_balasan']").val("");
                                        //$("#msg"+idm).html(data);
                                        // $("#status_mdl").hideMenu();
                                        // $("#msg"+idm).hide().show(1000);
                                         $("#mdl_modal").modal("hide");

									}
							});	
 }


 function lihat_obrolan(id){
                            var url   = "<?php echo site_url("tanya_admin/lihat_obrolan");?>";
							var param = {id:id,<?php echo $this->m_reff->tokenName()?>:token};
                            // $("#isi").html(cantik());
                            $("#mdl_utama").modal();
							$.ajax({
									type: "POST",dataType: "json",data: param, url: url,
									success: function(val){
										token=val['token'];
                                        $("#isi_modal").html(val["data"]); 
									}
							});	
 }




</script>

<script>
function replay(id,msg){
	// $('#status_mdl').showMenu();
	// $('#statusReplayContent').html(msg);
	// $('#replayID').val(id);
	$('#mdl_modal').modal();
	$('#statusReplayContent').html(msg);
	// $('#replayID').val(id);
    replayID=id;
}
 
</script>




 

<script>
var compus;
var ucapan;

 var idhapus;
//  function hapus_sts(id){
// 	 idhapus=id;
// 	 setTimeout(function(){ $('#status_mdl').hideMenu(); }, 200);
	
// 	$('#menu-hapus').showMenu();
//  }
 
  
 function hapus_sts(id){
		  
		  swal({
								  title: 'Obrolan akan dihapus !',
								  text: 'Anda tidak dapat melihat riwayat obrolan ini setelah dihapus',
								  type: 'warning',
								  buttons:{
									  cancel: {
										  visible: true,
										  text : 'batal',
										  className: 'btn btn-danger'
									  },        			
									  confirm: {
										  text : 'Ya',
										  className : 'btn btn-success'
									  }
								  }
							  }).then((willDelete) => {
								  if (willDelete) {
									 
											  
							var url   = "<?php echo site_url("tanya_admin/hapus_status");?>";
							var param = {id:id,<?php echo $this->m_reff->tokenName()?>:token};
							$.ajax({
									type: "POST",dataType: "json",data: param, url: url,
									success: function(val){
										token=val['token'];
                                        $("#card"+id).fadeOut(1000);
		                                setTimeout(function(){  $("#card"+id).html(""); }, 1000);
									}
							});	

									  
								  }  
							  });
							  
			   
				   
					  
				};
 function akhiri(id){
		  
		  swal({
								  title: 'Akhiri obrolan ?',
								  text: 'Percakapan akan diakhiri namun anda masih dapat melihat percakapan ini, dan anda dapat memulai percakapan baru',
								  type: 'warning',
								  buttons:{
									  cancel: {
										  visible: true,
										  text : 'batal',
										  className: 'btn btn-danger'
									  },        			
									  confirm: {
										  text : 'Ya',
										  className : 'btn btn-success'
									  }
								  }
							  }).then((willDelete) => {
								  if (willDelete) {
									 
											  
							var url   = "<?php echo site_url("tanya_admin/akhiri_obrolan");?>";
							var param = {id:id,<?php echo $this->m_reff->tokenName()?>:token};
                            loading("shareInfo");
							$.ajax({
									type: "POST",dataType: "json",data: param, url: url,
									success: function(val){
										token=val['token'];
                                        reload_status();
                                        unblock("shareInfo");
                                     
									}
							});	

									  
								  }  
							  });
							  
			   
				   
					  
				};

 function hapus_com(id){
     compus=id;

     swal({
								  title: 'Hapus ?',
								  text: '',
								  type: 'warning',
								  buttons:{
									  cancel: {
										  visible: true,
										  text : 'batal',
										  className: 'btn btn-danger'
									  },        			
									  confirm: {
										  text : 'Ya',
										  className : 'btn btn-success'
									  }
								  }
							  }).then((willDelete) => {
								  if (willDelete) {
									 
											  
							var url   = "<?php echo site_url("tanya_admin/hapus_com");?>";
							var param = {id:id,<?php echo $this->m_reff->tokenName()?>:token};
							$.ajax({
									type: "POST",dataType: "json",data: param, url: url,
									success: function(val){
										token=val['token'];
                                        $("#com"+id).fadeOut(600);
		                                setTimeout(function(){  $("#com"+id).html(""); }, 600);
									}
							});	

									  
								  }  
							  });
        }
							     
</script>





<div class="modal effect-flip-vertical" id="mdl_modal" style="z-index:1500" role="dialog">
                <div class="modal-dialog modal-md" id="area_modal" role="document">
				 
                <div class="modal-content">  
                         <div class="modal-header">  <h5 class="modal-titles" id="defaultModalLabel"><b>Komentar </b></h5>
						<button type="button" class="close" aria-label="Close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
						</button>
                    </div>


	 <div class="card-body">
                    <div class="row row-xs align-items-center mg-b-20">
                    <!-- <div class="alert alert-info col-md-12 mg-t-5 mg-md-t-0" id="statusReplayContent"></div> -->
                 			
										<div class="col-md-12 mg-t-5 mg-md-t-0">
										   Tulis pesan balasan
											<textarea style="font-size:16px;color:black;min-height:100px" 
                                             class="form-control" 
                                            name="msg_balasan"  placeholder="ketik..."  ></textarea>
											   
										</div>
										<div class="col-md-12"><br>
										<center><button onclick="kirim_balasan()" type='button' class='btn btn-success'>Kirim</button></center>   
										</div>
										<div style='width:100%' id="response"></div>
				  </div>
                  </div>

				</div>
                </div>
   </div><!-- /.modal-dialog --> 



	
   <div class="modal effect-flip-vertical" id="mdl_utama"  role="dialog">
                <div class="modal-dialog modal-lg" id="area_modal" role="document">
				 <div id="isi_modal">s</div>
				</div>
			
   </div><!-- /.modal-dialog --> 
 
