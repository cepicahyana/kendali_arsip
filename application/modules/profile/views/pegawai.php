<style>
    .upload {
        border: #DCDCDC dashed 1px;
    }
    
	@media only screen and (min-width: 768px){
		#tabel{
			margin-left: -20%;
		}

        #tombol-akses{
			margin-left: -22%;
		}
	}
</style>

<?php 
//$jkl=$jkp=""; if($data->jk=="l"){ $jkl="checked";}else{ $jkp="checked";}
  $profileimg=isset($data->foto)?($data->foto):'dp.png';	
if($profileimg!=''){$img=$profileimg;}else{$img='dp.png';}	


$nip = isset($data->nip)?($data->nip):null;
$tempat_lahir = isset($data->tempat_lahir)?($data->tempat_lahir):null;
$tgl_lahir = isset($data->tgl_lahir)?($data->tgl_lahir):null;
$no_hp = isset($data->no_hp)?($data->no_hp):null;
$agama = isset($data->agama)?($data->agama):null;
$email = isset($data->email)?($data->email):null;
$bagian = isset($data->bagian)?($data->bagian):null;
$nama = isset($data->nama)?($data->nama):null;
$foto = isset($data->foto)?($data->foto):'dp.png';
$istana = isset($data->istana)?($data->istana):null;
$biro = isset($data->biro)?($data->biro):null;
$jp = isset($data->jenis_pegawai)?($data->jenis_pegawai):null;
$level = isset($data->level_indikasi)?($data->level_indikasi):null;

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
                            <img class="profile-user-img img-responsive img-circle mb-3" src="<?= base_url()?>/plug/img/dp/<?php echo $profileimg;?>" style="border-radius: 15px; width:40%;">
				
                            <!-- <h3 class="text-center mb-2"><?=$nama?></h3>                          -->
                        </div>
                        <div class="col-md-6">
                            <table class="table table-bordered" id="tabel">
                                <tr>
                                    <td width="40%"><b>Nama</b></td>
                                    <td width="10%">:</td>
                                    <td><?=$nama?></td>
                                </tr>
                                <tr>
                                    <td width="40%"><b><?php
                                    if($jp==1){ echo "NIP";}else{ echo "NPP"; }
                                    ?></b></td>
                                    <td width="10%">:</td>
                                    <td><?=$nip?></td>
                                </tr>
                                <tr>
                                    <td width="40%"><b>Satuan Kerja</b></td>
                                    <td width="10%">:</td>
                                    <td><?=$istana?></td>
                                </tr>
                                <tr>
                                    <td width="40%"><b>Biro</b></td>
                                    <td width="10%">:</td>
                                    <td><?=$biro?></td>
                                </tr>
                                <tr>
                                    <td width="40%" rowspan="3"><b>Akses sebagai</b></td>
                                    <td width="10%" rowspan="3">:</td>
                                    <?php
                                    
                                        $this->db->where("nip", $nip);
                                        $this->db->where("level", 13); //13 level id pimpinan_covid
                                        $cekLevelAdmin = $this->db->get("admin")->num_rows();

                                        if($cekLevelAdmin){ ?>
                                            <td>
                                                <a href="<?=base_url('welcome?nip='.$this->m_reff->encrypt($nip).'&level='.$this->m_reff->encrypt($level))?>" class="btn btn-sm btn-primary" style="margin: 1px 3px 1px 3px;">Masuk sebagai Pimpinan</a>
                                            </td>
                                    <?php } 
                                    ?>
                                </tr>
                                <!-- <tr> -->
                                    <!-- <?php
                                        // $this->db->where("nip", $nip);
                                        // $this->db->where("level_indikasi", 11); //11 level id pegawai
                                        // $cekLevelPegawai = $this->db->get("data_pegawai")->row();

                                        // if($cekLevelPegawai != ""){
                                            // <td>
                                            //     <a href="" class="btn btn-sm btn-success" style="margin: 1px 3px 1px 3px;">Masuk sebagai Pegawai</a>
                                            // </td>;
                                        // }else{
                                    
                                        // }
                                    // ?>
                                </tr> -->
                                <tr>
                                    <?php
                                        $this->db->where("nip", $nip);
                                        $this->db->where("level", 2); //2 id level super admin
                                        $cekLevelAdmin = $this->db->get("admin")->num_rows();

                                        if($cekLevelAdmin){ ?>
                                            <td>
                                                <a href="<?=base_url('welcome?nip='.$this->m_reff->encrypt($nip).'&level='.$this->m_reff->encrypt($level))?>" class="btn btn-sm btn-danger" style="margin: 1px 3px 1px 3px;">Masuk sebagai Super Admin</a>
                                            </td>
                                     <?php } 
                                    ?>
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