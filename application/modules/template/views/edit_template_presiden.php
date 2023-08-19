<?php
$id			=	isset($db->id)?($db->id):"";
$nama		=	isset($db->nama)?($db->nama):"";
$poto		=	isset($db->poto)?($db->poto):"xxx.jpg";
$template_1				=	isset($db->isi)?($db->isi):"";
$template_2				=	isset($db->isi_inggris)?($db->isi_inggris):"";
$path		=	"plug/img/temp/".$poto;

if(!file_exists(($path)))
{
	$poto_template	= base_url()."plug/img/template_undangan.jpg";
}else{
	$poto_template	= base_url()."plug/img/temp/".$poto;
}

?>

<div id="area_formSubmit">
	 <form class="form-horizontal" id="formSubmit" action="javascript:submitFormNoResset('formSubmit')"	method="post" url="<?php echo base_url()?>template/update_template_presiden">
				<input type="hidden" name="id" value="<?php echo $id;?>">			
							<div class="page-header" >
		 
			<div class="row">
			<div class="col-md-4" >
			
				<img src="<?php echo $poto_template;?>" width="100px" id="blah" class="img-fluid img-thumbnail"> 
				<div class="custom-file">
                   <label class="custom-file-labeld" for="imgInp" >	    <input type="file" class="custom-file-inputd" name="poto"  id="imgInp"  >
                </label>
				</div>
			</div>
		<div class="col-md-8">
			 <input type="text" name="nama" value="<?php echo $nama;?>" class="form-control" ><br>
			<div class="btn-group" style="float:right"> 
			<button  class="text-right btn-light  btn btn-sms feather icon-save" onclick="submitFormNoResset('formSubmit')"> SAVE & PREVIEW</button>
		
			</div>
		 </div>
		 </div>
			 
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
 </div>
 <script>
    function readURL_1(input) {
        	if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
              $('#blah').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
          }
        }
 
  $( document ).ready(function() { 
        $("#imgInp").change(function() { 
          readURL_1(this);
        });
});		
</script>
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
	{			var kode	=	"<?php echo $id;?>";
				 $("#mdl_formSubmit").modal();
		 		  $("#editan").html(cantik());
			 $.post("<?php echo site_url("template/preview_edit_presiden"); ?>",{kode:kode},function(data){
		 	   $("#editan").html(data); 
			   
			});
	}
	
	function show_template()
	{		 
				 $("#mdl_template").modal(); 
			 
	}
	function edit(id)
	{
		  window.open("<?php echo base_url()?>template/edit_template?id="+id,"_blank");
	}
  </script>

 
 <?php
    $msg	=	$this->session->flashdata("msg");
 if($msg=="ok")
 {
	 echo "<script> 
			$( document ).ready(function() {
				reload_table();
			}); 
	 </script>";
 }
 ?>
					
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