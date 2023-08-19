<?php
$nip = $this->session->userdata("nip");
$dok=$this->m_reff->pengaturan(1)."dok/".$nip."/ttd.jpg";
$img = $this->konversi->img($dok);
?>


<!-- main-content opened -->
<div class="main-content horizontal-content">
 <div class="container content">
  <style>
    .upload {
        border: #DCDCDC dashed 1px;
    }
</style>


 <br>
   
    <div>
        <div  id="area_formSubmit">
            <div class="card">
                
                <div class="card-body">
                    <form id="formSubmit" action="javascript:submitForm('formSubmit')" method="post" url="<?=base_url();?>penilaian/update_ttd" enctype="multipart/form-data">
                    <input type="hidden" id="formToken" name="token_validation_access" value="debdce6c9cba57b1d3ac93b37c0c7200">
                     
                        <div class="row">
                            <div class="col-md-4">
                                <center class="hide">
                                    <label>
                                        <div style="max-width:300px">
                                            <b>	Tanda tangan</b>
                                            <br>
                                            <img class="img-responsive" 
                                            style=" height:200px;border-radius:20px;border:#F5F5DC solid 2px;padding:5px;margin-top:20px;margin-bottom:20px;" 
                                            id="blah" alt="upload" src="<?=$img;?>">
                                             <input type='file' accept=".JPG,.jpg,.png" name="file" id="imgInp" class="form-control upload" />
                                            <br>
                                        </div>
                                    </label>
                                    <button onclick="submitForm('formSubmit')" class="btn btn-primary">
                                    <i class="fa fa-upload"></i> Upload</button>
                                  
                                    
                                </center>
                           
                            </div>
                             
                        </div>
                        <br/>
                        <br/>
                        <br/>
                        <p>
                                Catt :<br>
                                1. Gunakan photo ttd berlatar putih dengan format gambar (.jpg) <br>
                                2. Jika ingin menghapus ttd silahkan upload file ini  <a href="../plug/img/white.jpg" download>download</a>
                            </p>

      
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
        function readURL(input) {

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#blah').attr('src', e.target.result);
                    $('.image img').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#imgInp").change(function() {
            readURL(this);
        });
		function reload_table()
		{
		    window.location.href="";
		}
    </script>
</div>
</div>				<!-- /container -->
			</div>
			<!-- /main-content -->