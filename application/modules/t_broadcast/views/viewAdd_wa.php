 <form  id="formSubmit" action="javascript:simpanBro('formSubmit')" method="post" url="<?php echo base_url() ?>t_broadcast/simpanBroadcast_wa">
 <b class="text-info">  Whatsapp Notifikasi</b> 
 <textarea  id="wa" name='konten'> </textarea>
 <input type="hidden" name='f[type]' value="2"> 
   
   
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