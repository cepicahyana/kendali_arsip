 
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
				{ 	 
					token = data["token"];
					$("#formToken").val(data["token"]);
					unblock("area_"+id); 	
					if(data["gagal"]==true)
					{	  
							notif(data["info"]);
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
					//  berhasil_disimpan();
					swal("success", {
						icon: "success",
						buttons : {
							confirm : {
								className: 'btn btn-success'
							}
						}
					});
					
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
				{ 	   
					token = data["token"];
					$("#formToken").val(data["token"]);
					unblock("area_"+id); 	
					if(data["gagal"]==true)
					{	  
							notif("<font color='black'>"+data["info"]+"</font>");
					} else{
					  $("#"+id)[0].reset();
					  $("#mdl_"+id).modal("hide"); 
					  reload_table();
					  swal("success", {
						icon: "success",
						buttons : {
							confirm : {
								className: 'btn btn-success'
							}
						}
					});
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
				{ 	  
					token = data["token"];
					$("#formToken").val(data["token"]);
					 unblock("area_"+id); 	
					if(data["gagal"]==true)
					{	  
							notif(data["info"]);
					}else{
						swal("success", {
							icon: "success",
							buttons : {
								confirm : {
									className: 'btn btn-success'
								}
							}
						});
						  reload_table();
					   
					}
					 			
				}
		});     
};

 

 
