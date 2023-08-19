<?php
$kode	=	$db->kode;

?>


	 <form class="form-horizontal" id="formSubmit" action="javascript:submitForm('formSubmit')"	method="post" url="<?php echo base_url()?>template/update">
				<input type="hidden" name="id" value="<?php echo $kode;?>">			
							<div class="page-header">
			<div class="page-block">
				<div class="row align-items-center">
					<div class="col-md-12">
						<div class="page-header-title">
							<h5 class="m-b-10">Acara Mensesneg</h5>
						</div>
						<ul class="breadcrumb">
							<li class="breadcrumb-item"><a href="http://localhost/panduistana//und_mensesneg"><i class="feather icon-home"></i></a></li>
							<li class="breadcrumb-item"><a href="#">Mensesneg</a></li>
							<li class="breadcrumb-item"><a href="#">Tambah acara baru</a></li>
						</ul>
					</div>
					
				
					
				</div>
			</div>	<button style="float:right" class="text-right btn-success btn btn-sm feather icon-save"> SAVE & PREVIEW</button>
		</div>

<main>
 
	<div class="adjoined-bottom">
		<div class="grid-container">
			<div class="grid-width-100">
				<textarea id="editor" name="f[]">
				<div style="text-align:center;line-height:18px"><span style="font-size:22px"><strong>MENTERI SEKRETARIS NEGARA<br />
REPUBLIK INDONESIA</strong></span></div> 
<p style="text-align:center;margin-top:-10px">mengharapkan dengan hormat Bapak/Ibu/Saudara<br>
pada acara</p>

				</textarea>
			</div>
			</div>
		</div>
	</div>

	 
</main>

 </form>
 
<script>
   
    // These styles are used to provide the "page view" display style like in the demo and matching styles for export to PDF.
    CKEDITOR.addCss(
      'body.document-editor { margin: 0.5cm auto; border: 1px #D3D3D3 solid; border-radius: 5px; background: white; box-shadow: 0 0 5px rgba(0, 0, 0, 0.1); }' +
      'body.document-editor, div.cke_editable { width: 19cm;height: 13cm; padding: 0.5cm 0.5cm 0.5cm; } ' +
      'body.document-editor table td > p, div.cke_editable table td > p { margin-top: 0; margin-bottom: 0; padding: 4px 0 3px 5px;} ' +
      'blockquote { font-family: sans-serif, Arial, Verdana, "Trebuchet MS", "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol"; } ');

     CKEDITOR.replace('editor', {
      height: 550, 
      bodyClass: 'document-editor'
    });
  </script>

 
