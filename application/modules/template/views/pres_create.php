<?php 
	$poto_template	= base_url()."plug/img/template_undangan.jpg"; 
?>

<div id="area_formSubmit">
	 <form class="form-horizontal" id="formSubmit" action="javascript:submitFormNoResset('formSubmit')"	method="post" url="<?php echo base_url()?>template/create_template_presiden">
				<input type="hidden" name="id_acara" value="<?php echo $id;?>">			
							<div class="page-header" >
		 
			<div class="row">
			<div class="col-md-4" >
			
				<img src="<?php echo $poto_template;?>" width="100px" id="blah" class="img-fluid img-thumbnail"> 
				<div class="custom-file">
                   <label class="custom-file-labeld" for="imgInp" >	    <input type="file"  class="custom-file-inputd" name="poto"  id="imgInp"  >
                </label>
				</div>
			</div>
		<div class="col-md-8">
			 <input type="text" name="nama" placeholder="Nama template ...." required class="form-control" style="background-color:white"><br>
			<div class="btn-group" style="float:right"> 
			
			<button  class="text-right btn-light  btn btn-sms feather icon-save" onclick="submitFormNoResset('formSubmit')"> SAVE</button>
		
			</div>
		 </div>
		 </div>
			 
		</div>

<main id="area_formSubmit" style="margin-top:-40px">

	
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
											<textarea id="editor" name="isi"></textarea>
										</div>
										</div>
									</div>
							</div>
							<div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
								 	<div class="adjoined-bottom">
									<div class="grid-container">
										<div class="grid-width-100">
											<div class="alert alert-danger"> VERSI BAHASA INGGRIS </div>
											<textarea id="editor2" name="isi_inggris"></textarea>
										</div>
										</div>
									</div>
							</div>
							 
						</div>
					</div>
				</div>

	 
</main>

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
	{			
		loading();
		 window.location.href="<?php echo base_url()?>template/save_direct_presiden/<?php echo $id;?>";
	}
	
	 
  </script>

 
 
					
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