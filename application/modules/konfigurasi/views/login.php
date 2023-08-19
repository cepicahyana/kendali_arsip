  	<script>							 
									 
 function readURL(input) {

  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
      $('#blah').attr('src', e.target.result);
      $('.image img').attr('src', e.target.result);
    }

    reader.readAsDataURL(input.files[0]);
  }
}

$("#imgInp").change(function() {
  readURL(this);
});
</script>


<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
<div class="breadcrumb-header justify-content-between">
	<div>
		<h4 class="content-title mb-2">Pengaturan Login</h4>
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<!-- <li class="breadcrumb-item"><a href="#">database</a></li> -->
				<!-- <li class="breadcrumb-item active" aria-current="page"></li> -->
			</ol>
		</nav>
	</div>
</div>
                <!-- Task Info -->
                    <div class="card">
                         
                        <div class="body">
                           <!----->
				 <div  >
                        <div >
                            <div class="card-body row ">
                               <table id='table' class="entry black table-bordered" style=" width:100%">
							 

								<tr>
								<td>1</td>
								<td>Status password alternatif</td>
								<td>
								
								<?php
								$data["0"] = "Hanya gunakan LDAP untuk masuk";
								$data["1"] = "Izinkan password alternatif";
								$data["2"] = "Tetap izinkan masuk";
								echo form_dropdown("val_36",$data,$this->m_reff->pengaturan(36),"onchange='save_(`36`,`val_36`)' id='val_36' class='form-control' ");
								?>

								 
								</td>
								</tr>

								<tr>
								<td>2</td>
								<td>Password alternatif</td>
								<td>
								
								 <input type="text" id="val_35" name="val_35" onchange='save_(`35`,`val_35`)' 
								 class="form-control" value="<?php echo $this->m_reff->pengaturan(35);?>"/>
								
								</td>
								</tr>
								
								 
								 
							</table>
							<br>
							</div>						
						</div>						
					</div>	
                           <!----->
                        </div>
                    </div>
                </div>
 
                <!-- #END# Task Info -->
				
 
  
	
 

 <?php
   $notif=$this->session->flashdata("msg");
 if($notif){
	 echo "<script>alert('".$notif."')</script>";
 }
 ?>
 
 
<script>
  

 function resset()
	{	
	var token  = "<?php echo $this->m_reff->encrypt(date('Hi'))?>";		
	 var tahun = null;//$("[name='tahun']").val();
		  swal({
                title: "Resset ?",
                text:"pastikan data sudah di backup terlebih dahulu",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
				 
			    $.post("<?php echo base_url()?>konfigurasi/resset",{tahun:tahun,token:token},function(data){
		 	    window.location.href="";
			});  
			
			
                   
                } else {
                    return false;
                }
            });
		 
		  
		 
	}
 



 function save_(idpengaturan,idkonten)
	 {	 
	 var idkonten=$("[name='"+idkonten+"']").val();
		 $.ajax({
		 url:"<?php echo base_url()?>konfigurasi/save_",
		 data: "idpengaturan="+idpengaturan+"&idkonten="+idkonten,
		 method:"POST",
		 success: function(data)
            {	 
				 notif(" Tersimpan! ");
            }
		});
	 }
	function download_acara(id)
	{
		window.location.href="<?php echo base_url()?>konfigurasi/download_acara?id="+id;
	}
	
	
</script>

 