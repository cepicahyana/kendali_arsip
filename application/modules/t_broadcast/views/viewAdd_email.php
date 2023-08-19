 <form  id="formSubmit" action="javascript:simpanBro('formSubmit')" method="post" url="<?php echo base_url() ?>t_broadcast/simpanBroadcast_email">
 
 
	 <b class="text-primary">  Email Notifikasi</b><br>
	 
	 <div class="input-group mb-12">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="inputGroupSelect01">Subject email</label>
                                    </div>
                                   <input value=" " style="width:83%;border:black solid 1px" type="text" class='form-control' name='f[subject]'>
                                </div>
	 
	 
 
<textarea  id="mail" name='konten'> </textarea>
<br>
<center>
 	<button   class="btn  fa fa-save btn-secondary has-ripple" onclick="simpanBro(`formSubmit`)"> SIMPAN  </button>
 	</form> 
 	
<script>
    
  CKEDITOR.replace('wa',{
  height  : '150px',});
   CKEDITOR.replace('mail',{
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