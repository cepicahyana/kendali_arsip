<style>
    .upload {
        border: #DCDCDC dashed 1px;
    }
    
	@media only screen and (min-width: 768px){
		#tabel{
			margin-left: -20%;
		}
	}
</style>

<?php 
//$jkl=$jkp=""; if($data->jk=="l"){ $jkl="checked";}else{ $jkp="checked";}
  $profileimg=isset($data->foto)?($data->foto):'dp.png';	
if($profileimg!=''){$img=$profileimg;}else{$img='dp.png';}	


$nip = isset($data->nip)?($data->nip):null;
$kode_akses = isset($data->kode_akses)?($data->kode_akses):null;
$nama = isset($data->owner)?($data->owner):null;
$foto = isset($data->foto)?($data->foto):'dp.png';

// jenis kelamin
$jenis_kelamin = isset($db->jk)?($db->jk):null;
if($jenis_kelamin == "l"){
	$jk = "Laki-laki";
}else{
	$jk = "Perempuan";
}
?>

					<!-- breadcrumb -->
					<div class="breadcrumb-header justify-content-between">
						<div>
							<nav aria-label="breadcrumb">
								<ol class="breadcrumb">
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
                    <h3 class="font-600 text-center">Profile</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 text-center">
                            <!-- <img class="img-responsive" style="border-radius: 15px; width:50%;" id="blah" src="<?php echo base_url()?>plug/img/dp/<?php echo $profileimg;?>"/> -->
                            <img class="profile-user-img img-responsive img-circle mb-3" src="<?= base_url()?>/plug/img/dp/<?php echo $profileimg;?>" style="border-radius: 15px; width:50%;">
				                       
                        </div>
                        <div class="col-md-6">
                        <table class="table table-bordered" id="tabel">
                        <tr>
                            <td width="40%"><b>Nama</b></td>
                            <td width="10%">:</td>
                            <td><?=$nama?></td>
                        </tr>
                        <tr>
                            <td width="40%"><b>Kode Akses</b></td>
                            <td width="10%">:</td>
                            <td><?=$nip?></td>
                        </tr>
                        </table>
                        </div>
                    </div>
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
		}
    </script>