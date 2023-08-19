<style>
    .upload {
        border: #DCDCDC dashed 1px;
    }
</style>

<?php 
$data = $this->mdl->notifikasi(4);
if(!isset($data)){ echo "data tidak ditemukan"; return false; }
$id = $data->id;
$wa = $data->wa;
$email = $data->email;
$subject = $data->subject;
?>

					<!-- breadcrumb -->
					<div class="breadcrumb-header justify-content-between">
						<div>
							<h4 class="content-title mb-2">Notifikasi Hasil Tes External</h4>
							<nav aria-label="breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="#"> Notifikasi hasil tes</a></li>
									<!-- <li class="breadcrumb-item active" aria-current="page">Project</li> -->
								</ol>
							</nav>
						</div>
						 
					</div>
					<!-- /breadcrumb -->
   
    <div>
        <div  id="area_formSubmit">
            <div class="card">
                <div class="card-header">
                    <h5>  Notifikasi</h5>
                </div>
                <div class="card-body" id="refresh">
                    <form id="formSubmit" action="javascript:submitFormNoResset('formSubmit')" method="post" url="<?php echo site_url('notifikasi/update');?>" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?= $id; ?>">
                        <input type="hidden" id="formToken" name="<?php echo $this->m_reff->tokenName()?>" value="<?php echo $this->m_reff->getToken()?>">
                        <div class="row">
                          <div class="col-md-6">
                                <label class="form-label mg-b-0">Pesan Whatsapp</label>
                                <textarea class="form-control" required name='f[wa]' style="height: 100%;"><?= $wa; ?></textarea>
                          </div>
                      
                          <div class="col-md-6" style="height: 400px;">
                        
                          <label class="text-black form-label mg-b-0">Subject Email</label>
                          <input type="text" name='f[subject]' class='form-control' value='<?=$subject;?>'>
                          <br>
                          <label class="text-black form-label mg-b-0">Email</label>
                                <textarea class="form-control" required name='f[email]' id="text-ckeditor2"><?= $email; ?></textarea>
                          </div> 
                          <div class="col-md-6" style="padding:20px">
                            <b>Pengkodean</b> : <br>
                            {nama}  =   Nama pegawai<br>
                            {email}  =   Email pegawai<br>
                            {nik}   =   Nomor Induk Penduduk<br>
                            {tempat_tes}   =   Rumah sakit tempat tes<br>
                            {tgl}   =   Tanggal tes keluar<br>
                          </div> 
                        </div>
                        <div class="row justify-content-between btn-page mt-3">
                            <div class="col-sm-6">
                                <span class="pull-right" id="msg"></span>
                            </div>
                            <div class="col-sm-12 text-md-right">
                                <button onclick="submitFormNoResset('formSubmit')" id="button1" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<!--- ckeditor --->
<script src="<?php echo base_url()?>assets/ckeditor/ckeditor.js"></script>
<script>
    function reload_table(){
        return false;
    }
CKEDITOR.replace('text-ckeditor2',{
    uiColor: '#f4f4f4',
    toolbar: [
        ['Bold','Italic','Underline','StrikeThrough','-'],
        ['NumberedList','BulletedList','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock']
    ],
    height: 250,
});
</script>




    <!-- <script>
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
		}
    </script> -->
    


    <!--
$data = $this->mdl->notifikasi(4);
$id = $data->id;
$wa = $data->wa;
$email = $data->email;
?>
    <div>
        <div  id="area_formSubmit">
            <div class="card">
                <div class="card-header">
                    <h5>Edit Notifikasi</h5>
                </div>
                <div class="card-body" id="refresh">
                    <form id="formSubmit" action="javascript:submitFormNoResset('formSubmit')" method="post" url="<?php echo site_url('notifikasi/update');?>" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?= $id; ?>">
                        <input type="hidden" id="formToken" name="<?php echo $this->m_reff->tokenName()?>" value="<?php echo $this->m_reff->getToken()?>">
                        <div class="row">
                          <div class="col-md-12">
                                <label class="form-label mg-b-0">Pesan Whatsapp</label>
                                <textarea class="form-control" required name='f[wa]' style="height: 372px;"><?= $wa; ?></textarea>
                          </div>
                          <div class="col-md-6" style="height: 400px;">
                                <label class="form-label mg-b-0">Pesan Email</label>
                                <textarea class="form-control" required name='f[email]' id="text-ckeditor2"><?= $email; ?></textarea>
                          </div>  
                        </div>
                        <div class="row justify-content-between btn-page mt-3">
                            <div class="col-sm-6">
                                <span class="pull-right" id="msg"></span>
                            </div>
                            <div class="col-sm-12 text-md-right">
                                <button onclick="submitFormNoResset('formSubmit')" id="button1" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    -->
