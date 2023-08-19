<?php
$kode					=	isset($db->kode)?($db->kode):"";
$id_acara				=	isset($db->id_acara)?($db->id_acara):"";
$id_jenis_kegiatan		=	isset($db->id_jenis_kegiatan)?($db->id_jenis_kegiatan):"";
$template_1				=	isset($db->template_1)?($db->template_1):"";
$template_2				=	isset($db->template_2)?($db->template_2):"";
$module					=	$this->m_reff->goField("tr_jenis_undangan","module","where id='".$id_acara."' ");

?>
 
 
	 <form class="form-horizontal" id="formSubmit" action="javascript:submitForm('formSubmit')"	method="post" url="<?php echo base_url()?>template/update_presiden">
				<input type="hidden" name="id" value="<?php echo $kode;?>">			
							<div class="page-header">
			<div class="page-block">
				<div class="row align-items-center">
					<div class="col-md-12">
						<div class="page-header-title">
							<h5 class="m-b-10">Acara Pelantikan || kode acara  : <?php echo $kode;?></h5>
						</div>
						 
					</div>
					
				
					
				</div>
			</div>	
			<button  type="button" class="text-right btn-light btn btn-sms feather icon-grid" onclick="show_template()"> Pilih Template</button>
			<div class="btn-groups" style="float:right">
				
			<a  class="text-right btn-light  btn btn-sms feather icon-user menuclick " href="<?php echo base_url()?><?php echo $module;?>/tamu/<?php echo $kode;?>"> Kembali ke data tamu </a>
			<button  class="text-right btn-light  btn btn-sms feather icon-save " onclick="submitForm('formSubmit')"> save & preview</button>
		
			</div>
			<br>
		</div>



<div class="card" id="area_formSubmit">
					<div class="card-body">
						<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
							<li class="nav-item">
								<a class="nav-link has-ripple active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Bahasa Indonesia </a>
							</li>
							<li class="nav-item">
								<a class="nav-link has-ripple" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Bahasa Inggris</a>
							</li>
							 
						</ul>
						<div class="tab-content" id="pills-tabContent">
							<div class="tab-pane fade active show" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
								 	<div class="adjoined-bottom">
									<div class="grid-container">
										<div class="grid-width-100">
											<div class="alert alert-warning"> VERSI BAHASA INDONSIA </div>
											<textarea id="editor" name="template_1"><?php echo $template_1;?></textarea>
										</div>
										</div>
									</div>
							</div>
							<div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
								 	<div class="adjoined-bottom">
									<div class="grid-container">
										<div class="grid-width-100">
											<div class="alert alert-danger"> VERSI BAHASA INGGRIS </div>
											<textarea id="editor2" name="template_2"><?php echo $template_2;?></textarea>
										</div>
										</div>
									</div>
							</div>
							 
						</div>
					</div>
				</div>

 

 

 </form>
 
<script>
   
    // These styles are used to provide the "page view" display style like in the demo and matching styles for export to PDF.
    CKEDITOR.addCss(
      'body.document-editor { margin: 0.5cm auto; border: 1px #D3D3D3 solid; border-radius: 5px; background: white; box-shadow: 0 0 5px rgba(0, 0, 0, 0.1); }' +
      'body.document-editor, div.cke_editable { width: 19cm;height: 20cm; padding: 0.5cm 0.5cm 0.5cm; } ' +
      'body.document-editor table td > p, div.cke_editable table td > p { margin-top: 0; margin-bottom: 0; padding: 4px 0 3px 5px;} ' +
      'blockquote { font-family: sans-serif, Arial, Verdana, "Trebuchet MS", "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol"; } ');

     CKEDITOR.replace('editor', {
      height: 550, 
      bodyClass: 'document-editor'
    });
	 CKEDITOR.replace('editor2', {
      height: 550, 
      bodyClass: 'document-editor'
    });
	
	function reload_table()
	{			var kode	=	"<?php echo $kode;?>";
				 $("#mdl_formSubmit").modal();
		 		  $("#editan").html(cantik());
			 $.post("<?php echo site_url("template/preview_presiden"); ?>",{kode:kode},function(data){
		 	   $("#editan").html(data); 
			   
			});
	}
	
	function show_template()
	{		 
	
				var id_acara	=	"<?php echo $id_jenis_kegiatan;?>";
				$("#mdl_template").modal(); 
		 		  $("#ghaelery_template").html(cantik());
					$.post("<?php echo site_url("template/ghaelery_template_presiden"); ?>",{id_acara:id_acara},function(data){
					$("#ghaelery_template").html(data);  
				});
				 
			 
	}
	
	
 
	function hapus(id,nama)
	{	 
		 swal({
                title: "Hapus template ?",
               text:nama,
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
				 
			    $.post("<?php echo base_url()?>template/deleteTemplate",{id:id},function(data){
					swal("Perubahan disimpan!", {
                        icon: "success",
                    });
					show_template();
			});  
			
			
                    
                } else {
                    return false;
                }
            });
		 
	}
 
	function terapkan(id,nama)
	{	var kode ="<?php echo $kode;?>";
		 swal({
                title: "Terapkan template ?",
               text:nama,
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
				 
			    $.post("<?php echo base_url()?>template/setTemplatePresiden",{id_template:id,kode:kode},function(data){
					swal("Perubahan disimpan!", {
                        icon: "success",
                    });
					 window.location.href="";
			});  
			
			
                    
                } else {
                    return false;
                }
            });
		 
	}
	function edit(id)
	{
		  window.open("<?php echo base_url()?>template/edit_template_presiden?id="+id,"_blank");
	}
  </script>

 <?php
	if(strlen($template_1)<50){
		echo "<script> 
			$( document ).ready(function() {
				show_template();
			}); 
	 </script>";
	}
	?>
					
<!-- Modal -->
<div class="modal fade " id="mdl_template" tabindex="-9991" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
 
   <div class="modal-dialog   modal-lg" role="document" >
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> 
					 <div class="row col-md-12" id="ghaelery_template"> 
					 </div>
					 <center>
					<a class="btn btn-primary fas fa-plus-circle" href="<?php echo base_url()?>template/pres_create?id=<?php echo $id_jenis_kegiatan?>" target="_blank"> Buat template baru</a>
					</center>
                </div>
                
                
            </div>
        </div>
    </div>
</div>



					
<!-- Modal -->
<div class="modal fade " id="mdl_formSubmit" tabindex="-9991" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
 
   <div class="modal-dialog   modal-lg" role="document" >
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
					<div id="editan"></div> 
                </div>
                
                
            </div>
        </div>
    </div>
</div>