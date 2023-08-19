 
function submitFormAkun(id)
{		
		var form = $("#"+id);
		var link = $(form).attr("url");
	 
		$(form).ajaxForm({
		 url:link,
		 data: $(form).serialize(),
		 method:"POST",
		 dataType:"JSON",
		 beforeSend: function() {
               loading("area_"+id);
            },
		 success: function(data)
				{ 	   unblock("area_"+id); 	
					if(data["gagal"]==true)
					{	  
							notif(data["info"]);
					} else if(data["size"]==false)
					{	  
							notif("<b>Gagal  !!</b><br>- Upload File Maksimal "+data["maxsize"]+"MB.");
					}else if(data["file"]==false)
					{	  
							notif("<b>Gagal  !!</b><br>- File yang diizinkan adalah "+data["type_file"]+".");
					}else if(data["token"]==false)
					{
						notif_error("<span class='col-white'><b>Gagal!</b>  Silahkan coba lagi.</span>");
						$("#mdl_"+id).modal("hide");
					}else if(data["import_data"]==true)
					{
						$("#"+id)[0].reset();
						  $("#mdl_"+id).modal("hide"); 
						  reload_table();
						notif_success("<span class='sadow white'><div class='demo-google-material-icon'> <i class='material-icons'>done_all</i> <span class='icon-name'>Berhasil disimpan</span><br> - Ditambahkan "+data['data_insert']+" data<br> - Diperbaharui "+data['data_edit']+" data</div></span>");
					 		
						$("#mdl_"+id).modal("hide");
					}else{
					  $("#"+id)[0].reset();
					  $("#mdl_"+id).modal("hide"); 
					  reload_table();
					  berhasil_disimpan();
					 		
					  $("#mdl_"+id).modal("hide");
					}
					 			
				}
		});     
};



function submitForm(id)
{		
		var form = $("#"+id);
		var link = $(form).attr("url");
	 
		$(form).ajaxForm({
		 url:link,
		 data: $(form).serialize(),
		 method:"POST",
		 dataType:"JSON",
		 beforeSend: function() {
               loading("area_"+id);
            },
		 success: function(data)
				{ 	   unblock("area_"+id); 	
					if(data["gagal"]==true)
					{	  
							notif(data["info"]);
					} else if(data["size"]==false)
					{	  
							notif("<b>Gagal  !!</b><br>- Upload File Maksimal "+data["maxsize"]+"MB.");
					}else if(data["file"]==false)
					{	  
							notif("<b>Gagal  !!</b><br>- File yang diizinkan adalah "+data["type_file"]+".");
					}else if(data["token"]==false)
					{
						notif_error("<span class='col-white'><b>Gagal!</b>  Silahkan coba lagi.</span>");
						$("#mdl_"+id).modal("hide");
					}else if(data["import_data"]==true)
					{
						$("#"+id)[0].reset();
						  $("#mdl_"+id).modal("hide"); 
						  reload_table();
						notif_success("<span class='sadow white'><div class='demo-google-material-icon'> <i class='material-icons'>done_all</i> <span class='icon-name'>Berhasil disimpan</span><br> - Ditambahkan "+data['data_insert']+" data<br> - Diperbaharui "+data['data_edit']+" data</div></span>");
					 		
						$("#mdl_"+id).modal("hide");
					}else{
					  $("#"+id)[0].reset();
					  $("#mdl_"+id).modal("hide"); 
					  reload_table();
					  berhasil_disimpan();
					 		
					  $("#mdl_"+id).modal("hide");
					}
					 			
				}
		});     
};



function submitFormNoResset(id)
{		
		var form = $("#"+id);
		var link = $(form).attr("url");
	 
		$(form).ajaxForm({
		 url:link,
		 data: $(form).serialize(),
		 method:"POST",
		 dataType:"JSON",
		 beforeSend: function() {
               loading("area_"+id);
            },
		 success: function(data)
				{ 	   unblock("area_"+id); 	
					if(data["gagal"]==true)
					{	  
							notif(data["info"]);
					} else if(data["size"]==false)
					{	  
							notif("<b>Gagal  !!</b><br>- Upload File Maksimal "+data["maxsize"]+"MB.");
					}else if(data["file"]==false)
					{	  
							notif("<b>Gagal  !!</b><br>- File yang diizinkan adalah "+data["type_file"]+".");
					}else if(data["token"]==false)
					{
						notif_error("<span class='col-white'><b>Gagal!</b>  Silahkan coba lagi.</span>");
						$("#mdl_"+id).modal("hide");
					}else if(data["import_data"]==true)
					{
						 
						  
						
						notif_success("<span class='sadow white'><div class='demo-google-material-icon'> <i class='material-icons'>done_all</i> <span class='icon-name'>Berhasil disimpan</span><br> - Ditambahkan "+data['data_insert']+" data<br> - Diperbaharui "+data['data_edit']+" data</div></span>");
					   reload_table();
					 
						 
					}else{
						 berhasil_disimpan();
						  reload_table();
					   
					}
					 			
				}
		});     
};

 
function saveModal(id)
{
 
		 blok("f_"+id);
		 var link = $("#f_"+id).attr("url");
		 $('#f_'+id).ajaxForm({
		 url:link,
		 data: $('#f_'+id).serialize(),
		 method:"POST",
		 dataType:"JSON",
		 success: function(data)
				{ 	 
				 
				$('#f_'+id).unblock(); 
					if(data["validasi"]==false)
					{	  
							notif("<b>Gagal memposting!</b><br>- Upload File Maksimal 3MB. <br> - File yang diizinkan adalah JPG/PNG.");
					}else if(data["token"]==false)
					{
						notif_error("<span class='col-white'><b>Gagal!</b>  Silahkan coba lagi.</span>");
							$("#f_"+id).modal("hide");
							$("#ff_"+id).modal("hide");
					}else{
					  $('#f_'+id)[0].reset();
					  $('#'+id).modal("hide"); 
					  reload_table();
					 berhasil_disimpan();
					 	$("#f_"+id).modal("hide");
					$("#ff_"+id).modal("hide");
					}
				
				}
		});     
 

}

 

function save_profile(id){
	 blok("area_"+id);
	var link = $("#"+id).attr("url");
    $('#'+id).ajaxForm({
	 url:link,
     data: $('#'+id).serialize(),
	 method:"POST",
	 dataType: "JSON",
	 beforeSend: function() {
               loading("area_"+id);
            },
     success: function(data)
            {
					
			
				if(data["validasi"]==true){
				berhasil_disimpan();
				}else if(data["password"]==false){
				 alertify.error("<span class='sadow white'><b>Gagal!</b><br>Silahkan cari user /password lain.</span>");
				 }else if(data["file"]==false){
				 alertify.error("<span class='sadow white'><b>Gagal!</b><br>Silahkan gunakan file gambar (jpg).</span>");
				 }else if(data["size"]==false){
				 alertify.error("<span class='sadow white'><b>Gagal!</b><br>Maksimum upload gambar 3 Mb.</span>");
				 }
				  unblock("area_"+id); 	
            }
           
    });  
    	 
}

 
