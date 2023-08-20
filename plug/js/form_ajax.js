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
						 

							swal(data["info"], {
								icon: "warning",
								buttons : {
									confirm : {
										className: 'btn btn-primary'
									}
								}
							});
					
					}else if(data["data"]?.gagal==true)
					{	   
							swal(data["data"]?.info, {
								icon: "warning",
								buttons : {
									confirm : {
										className: 'btn btn-primary'
									}
								}
							});
							 reload_table();
							 return true;
					} else{
					  $("#"+id)[0].reset();
					  $("#mdl_"+id).modal("hide"); 
					  reload_table();

					  
					  swal({
						title: 'Success!',
						text: ' ',
						icon: 'success',
						timer: 1000,
						buttons: false,
					})


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
					  

					 if(typeof data["data"]!=="undefined" && data["data"].gagal){
						swal({
							title: 'Success!',
							text: ' ',
							icon: 'success',
							timer: 1000,
							buttons: false,
						})
					return	  reload_table();

					 }


					if(data["data"].gagal==true)
					{	  
						swal(data["data"].info, {
							icon: "warning",
							buttons : {
								confirm : {
									className: 'btn btn-primary'
								}
							}
						});
					}else{
						  
						swal({
							title: 'Success!',
							text: ' ',
							icon: 'success',
							timer: 1000,
							buttons: false,
						})
						  reload_table();
					   
					}
					 			
				}
		});     
};

 

 