 <?php $database=$this->db->get_where("data_broadcast",array("id"=>$this->input->post("id")))->row();  
 if(!isset($database)){
	 echo "data tidak tersedia";
	 return false;
 }
  ?>		

 <form  id="formSubmit" action="javascript:simpanBro('formSubmit')" method="post" url="<?php echo base_url() ?>t_broadcast/update">
 <input type="hidden" name="id" value="<?php echo $database->id;?>"> 
 <?php
 if($database->type==1){?>
 
	 <b class="text-primary">  Email Notifikasi</b><br>
	 
	 <div class="input-group mb-12">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="inputGroupSelect01">Subject email</label>
                                    </div>
                                   <input value="<?php echo $database->subject?>" style="width:83%;border:black solid 1px" type="text" class='form-control' name='f[subject]'>
                                </div>
	 
	 
 
<textarea  id="konten" name='konten'><?php echo $database->real?></textarea>
<br>
<center>
 	<button   class="btn  fa fa-save btn-secondary has-ripple" onclick="simpanBro(`formSubmit`)"> SIMPAN  </button>
 <?php } ?> 




 <?php
 if($database->type==2){?>
     <input value="<?php echo $database->subject?>" type="hidden" class='form-control' name='f[subject]'>
                               
  <b class="text-info">  Whatsapp Notifikasi</b> 
 <textarea  id="konten" name='konten'> <?php echo $database->konten?></textarea>
  
<br>
<center>
 	<button   class="btn  fa fa-save btn-secondary has-ripple" onclick="simpanBro(`formSubmit`)"> SIMPAN  </button>
 
 <?php } ?>









 </form> 
 	
<script>
  
   CKEDITOR.replace('konten',{
  height  : '320px',});
  
  
    function simpanBro(id)
{		var kode=" ";
        var type=" ";
		var form = $("#"+id);
		var link = $(form).attr("url"); 
		$(form).ajaxForm({
		 url:link,
		 data: $(form).serialize(),
		 method:"POST",
		 dataType:"JSON",
		 beforeSend: function() {
               $("#kontenEmail").html(cantik());
            },
		 success: function(data)
				{ 	    
					  	 reload_table();
					$("#mdl_modal_artikel").modal("hide");  	 
				}
		});     
};
</script>