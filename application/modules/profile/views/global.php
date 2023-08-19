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
 $level      =   $this->session->level;
 if($level=="pegawai"){
     $data   =   $this->db->get_where("data_pegawai",array("nip"=>$this->m_reff->nip()))->row();
 
     $profileimg=isset($data->poto)?($data->poto):'dp.png';	
     if($profileimg!=''){$img=$profileimg;}else{$img='dp.png';}	
     
     
     $nip = isset($data->nip)?($data->nip):null;
     $tempat_lahir = isset($data->tempat_lahir)?($data->tempat_lahir):null;
     $tgl_lahir = isset($data->tgl_lahir)?($data->tgl_lahir):null;
     $no_hp = isset($data->no_hp)?($data->no_hp):null;
     $agama = isset($data->agama)?($data->agama):null;
     $email = isset($data->email)?($data->email):null;
     $bagian = isset($data->bagian)?($data->bagian):null;
     $nama = isset($data->nama)?($data->nama):null;
     $foto = isset($data->poto)?($data->poto):'dp.png';
     $istana = isset($data->kode_istana)?($data->kode_istana):null;
    //  $istana = $this->m_reff->istana($istana);
     $biro = isset($data->kode_biro)?($data->kode_biro):null;
     $biro = $this->m_reff->biro($biro);
     $id = isset($data->id_admin)?($data->id_admin):null;
     
     
 }else{
    $data   =   $this->db->get_where("data_pegawai",array("nip"=>$this->session->userdata("nip")))->row();
    $profileimg=isset($data->poto)?($data->poto):'dp.png';	
    if($profileimg!=''){$img=$profileimg;}else{$img='dp.png';}	
    
    
    $nip = isset($data->nip)?($data->nip):null;
    $tempat_lahir = isset($data->tempat_lahir)?($data->tempat_lahir):null;
    $tgl_lahir = isset($data->tgl_lahir)?($data->tgl_lahir):null;
    $no_hp = isset($data->no_hp)?($data->no_hp):null;
    $agama = isset($data->agama)?($data->agama):null;
    $email = isset($data->email)?($data->email):null;
    $bagian = isset($data->bagian)?($data->bagian):null;
    $nama = isset($data->nama)?($data->nama):null;
    $foto = isset($data->poto)?($data->poto):'dp.png';
    $istana = isset($data->istana)?($data->istana):null;
    $istana = isset($data->kode_istana)?($data->kode_istana):null;
    $biro = isset($data->kode_biro)?($data->kode_biro):null;
    $biro = $this->m_reff->biro($biro);
    $id = isset($data->id_admin)?($data->id_admin):null;
    
 }



 

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
                                <!-- <tr>
                                    <td width="40%"><b>NIP/NPP</b></td>
                                    <td width="10%">:</td>
                                    <td><?=$nip?></td>
                                </tr> -->
                                <tr>
                                    <td width="40%"><b>Satuan Kerja</b></td>
                                    <td width="10%">:</td>
                                    <td><?=$this->m_reff->istana($istana)?></td>
                                </tr>
                                <tr>
                                    <td width="40%"><b>Biro</b></td>
                                    <td width="10%">:</td>
                                    <td><?=$biro?></td>
                                </tr>
                                <tr>
                                <td width="40%"><b>Akses anda saat ini sebagai</b></td>
                                    <td width="10%">:</td>
                                    <td><?=$this->m_reff->goField("main_level","ket","where nama='".$level."'")?></td>
                                </tr>
                                
                                    <?php
                                        $this->db->where("nip", $nip);
                                        $this->db->where("id_admin!=", $this->session->id);
                                        $cekLevelAdmin = $this->db->get("admin")->result();
                                        $role = "";
                                        foreach($cekLevelAdmin as $v){
                                         $levelName = $this->m_reff->goField("main_level","nama","where id_level='".$v->level."'");  
                                         $levelKet = $this->m_reff->goField("main_level","ket","where id_level='".$v->level."'");  
                                         
                                         $role.= '<a style="text-align:left;min-width:300px;margin-bottom:3px" href="'.base_url('portal/login?nip='.$this->m_reff->encrypt($nip).'&level='.$this->m_reff->encrypt($levelName)).'" 
                                                class="btn   btn-secondary" style="margin: 1px 3px 1px 3px;"> <i class="fa fa-hand-point-right"></i> '. ucwords($levelKet).'</a><br>';
                                          
                                     } 

                                     $cek = $this->db->get_where("data_pegawai",array("nip"=>$nip,"id!="=>$this->m_reff->idu()))->num_rows();
										if($cek){
											   $role.= '<a style="text-align:left;min-width:300px;margin-bottom:3px" href="'.base_url('portal/login?nip='.$this->m_reff->encrypt($nip).'&level='.$this->m_reff->encrypt("pegawai")).'" 
                                               class="btn   btn-secondary"  > <i class="fa fa-hand-point-right"></i> PEGAWAI</a>';
											 
										}

                                     if($role){
                                         echo '<tr>
                                         <td width="40%" colspan="3"><b>Role yang dapat anda akses : </b><br>
                                       ';
                                       echo $role;
                                       echo ' </td>
                                       </tr>';
                                     }
                                    ?>
                                   
                              
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