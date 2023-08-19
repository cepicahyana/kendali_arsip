<style>
div.scroll {
  height: 510px;
  overflow: scroll;
}
</style>

<?php

if(!$kode){
    return false;
}

 

       $this->db->where("kode",$kode);
$tes        = $this->db->get("data_test_keluarga")->row();
if(!isset($tes)){
    echo "<center><br><br>Data tes telah terhapus!<br><br>
    <button onclick='setSembuh(`".$kode."`)' class='btn btn-success'>Sembuh</button>
    <button onclick='setMeninggal(`".$kode."`)' class='btn btn-warning'>Meninggal</button>
    <br><br>
    </center>";
    return false;
}


$isolasi    = $this->m_reff->goField("tr_isolasi","nama","where kode='".$tes->isolasi."' ");
$ket        = $tes->ket;
$nik        = $tes->nik;
$dataKel    = $this->db->get_where("data_keluarga",array("nik"=>$nik))->row();
?>

<div class="col-lg-12  col-md-12 col-sm-12">
								<div class="card card-dashboard-events">
									<div class="card-header pb-0">
										<div class="d-flex justify-content-between">
											<h5 class=" text-black mg-b-10">Detail kondisi</h5>
											<i class="mdi mdi-dots-horizontal text-gray"></i>
                                            <button type="button" class="close" aria-label="Close" data-dismiss="modal">
                                            <span aria-hidden="true">×</span>
                                            </button>
										</div>
									 
									</div>
									<div class="card-body">


                                    

                                    <div class="border list-group">
												<div class="bg-gray-300 nav-bg">
													<nav class="nav nav-tabs">
														<a class="nav-link  active show" data-toggle="tab" href="#tabCont1">Riwayat kondisi</a>
														<a class="nav-link" data-toggle="tab" href="#tabCont2">Status Kondisi</a>
														<a class="nav-link" data-toggle="tab" href="#tabTes">Riwayat Test</a>
														<a class="nav-link" data-toggle="tab" href="#tabCont3">Profile </a>
                                                        <a class="nav-link" data-toggle="tab" href="#tabCont4">Ubah kondisi</a>
													</nav>
										                </div>
												<div class="card-body tab-content ">
													<div class="tab-pane active show p-2 scroll" id="tabCont1">
														
										<div class="list-group ">
										<?php
                                        $this->db->order_by("tgl","desc");
                                        $this->db->where("(kode_test='".$kode."' or kode_test_utama='".$kode."' )");
                                        $db = $this->db->get("data_kondisi_keluarga")->result();
                                        $i=1;
                                        $kondisi_akhir="";
                                        foreach($db as $val){
                                      
                                           
                                            $iso    = $this->m_reff->goField("tr_isolasi","nama","where kode='".$val->isolasi."' ");
                                            $gejala = str_replace('"','',$val->gejala);
                                            $gejala = str_replace('[','',$gejala);
                                            $gejala = str_replace(']','',$gejala);
                                            if(strtolower($val->kondisi)==1){
                                                $bg = 'bg-danger-gradient';
                                                $kondisi = "Memburuk";
                                                $text = "text-danger";
                                            }
                                            elseif(strtolower($val->kondisi)==2){
                                                $bg = 'bg-info-gradient';
                                                $kondisi = "Stagnan";
                                                $text = "text-info";
                                            }else{
                                                $bg = 'bg-success-gradient';
                                                $kondisi = "Membaik";
                                                $text = "text-success";
                                            }

                                            if($i==1){
                                                 $kondisi_akhir = $kondisi;
                                              }$i++;

$level = $this->m_reff->goField("tr_indikasi","level","where id='".$val->level_indikasi."'");

 
echo '
<div class="list-group-item border-bottom-0">
<div class="event-indicator '.$bg.'"></div><label>'.$this->tanggal->dateTimeJam($val->tgl).' WIB</label>
<h6 class="'.$text.'"><i class="typcn icon typcn-chart-bar-outline"></i> '.$kondisi.' |&nbsp; <span class="text-black">'.$level.' </span>&nbsp;   >> &nbsp;  <span class="text-black" style="font-size:13px">Isolasi '.$iso.'</span></h6>
<p>'.$val->ket.'</p>
 
</div>
';
                                        }
										?>

										</div>    </div>
													
                                        
                                        <div class="tab-pane p-2" id="tabCont2">
													
                                                <table class='entry' width="100%">
                                                <tr>
                                                    <td>Terpapar</td>
                                                     <td><?php echo   $this->tanggal->selisih($tes->konfirm_rs,date('Y-m-d'))+1;?> Hari, sejak hari <?php echo $this->tanggal->hariLengkap($tes->konfirm_rs,"/")?></td>
                                                </tr>
                                                <tr>
                                                    <td>Indikasi</td>
                                                     <td><?php echo $this->m_reff->goField("tr_indikasi","level","where id='".$tes->level_indikasi."'");?></td>
                                                </tr>
                                                <tr>
                                                    <td>Perkembangan </td>
                                                     <td><?php echo $kondisi_akhir; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Isolasi saat ini</td>
                                                     <td><?php echo $isolasi?></td>
                                                </tr>
                                                
                                                <tr>
                                                    <td>Keluhan</td>
                                                     <td><?php echo $ket;?></td>
                                                </tr>
                                                </table>
                                                
                                        </div>



										<div class="tab-pane p-2" id="tabCont3">
                                            <?php
                                            $dp = $this->m_reff->data_pegawai($tes->nip_pegawai);
                                          
                                                if(isset($dp->kode_biro)){
                                                    $biro = $this->m_reff->biro($dp->kode_biro);
                                                }else{
                                                    $biro = isset($dp->kode_istana)?($dp->kode_istana):"";
                                                }
                                          if(isset($dp)){
                                            $kab = $this->m_reff->goField("kabupaten","nama","where id_kab='".$dp->id_kab."' ");
                                            $kec = $this->m_reff->goField("kecamatan","nama","where id_kec='".$dp->id_kec."' ");
                                            $kel = $this->m_reff->goField("kelurahan","nama","where id_kel='".$dp->id_kel."' ");
                                            $domisili="Kab : ".ucwords(strtolower($kab)).br()."Kec : ".$kec.br()."Kel &nbsp;: ".$kel;
                                          }else{
                                            $domisili="";
                                            return true;
                                          }
                                            ?>
                                            <b>Data Profile </b>
                                            <table class='entry' width="100%">
                                                <tr>
                                                    <td>Nama</td>
                                                    <td><?php echo $dataKel->nama;?></td>
                                                </tr>
                                                <tr>
                                                    <td>Usia</td>
                                                    <td><?php echo $this->tanggal->hitungUsia($dataKel->tgl_lahir)?></td>
                                                </tr>
                                                <tr>
                                                    <td>Hubungan keluarga</td>
                                                    <td><?php echo $this->m_reff->hubungan($dataKel->id_hubungan,$dataKel->jk);?></td>
                                                </tr>
                                        </table>
                                        <hr>
                                            <b>Data keluarga pegawai</b>
                                                <table class='entry' width="100%">
                                                <tr>
                                                    <td>Nama</td>
                                                    <td><?php echo $dp->nama;?></td>
                                                </tr>
                                                <tr>
                                                    <td>Usia</td>
                                                    <td><?php echo $this->tanggal->hitungUsia($dp->tgl_lahir)?></td>
                                                </tr>
                                                <tr>
                                                    <td>Email</td>
                                                    <td><?=$dp->email; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Telp</td>
                                                    <td><?=$dp->no_hp; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Instansi / Biro</td>
                                                    <td><?=$biro;?></td>
                                                </tr>
                                                <tr>
                                                    <td>Jabatan</td>
                                                    <td><?php echo $dp->jabatan?></td>
                                                </tr>
                                                
                                                <tr>
                                                    <td>Domisili</td>
                                                    <td><?php echo $domisili;?></td>
                                                </tr>
                                                
                                                </table>
                                                
										 </div>

                                         <div class="tab-pane p-2" id="tabCont4">
                                            <center>

                                                <button onclick='setSembuh(`<?=$kode;?>`)' class='btn btn-success'>Sembuh</button>
                                             <button onclick='setMeninggal(`<?=$kode;?>`)' class='btn btn-warning'>Meninggal</button>    
                                            </center>
										 </div>



                                         <div class="tab-pane p-2" id="tabTes">
                                           <?php
                                           $tbl   = ""; $no=1;
                                                    $this->db->where("nik",$nik);
                                           $dbpeg = $this->db->get("data_test_keluarga")->result();
                                           foreach($dbpeg as $val){
                                               if($val->hasil=="+"){
                                                   $hasil="Positif(+)";
                                               }elseif($val->hasil=="-"){
                                                   $hasil="Negatif(-)";
                                               }else{
                                                   $hasil ="Belum keluar";
                                               }
                                                $tbl.="
                                                <tr>
                                                <td>".$no++."</td>
                                                <td>".$this->tanggal->hariLengkap3($val->tgl,"/")."</td>
                                                <td>".$this->m_reff->goField("tm_rs","nama","where id='".$val->kode_tempat."'")."</td>
                                                <td>".$hasil."</td>
                                                </tr>
                                                ";
                                           }
                                           ?>
                                           <table class='entry' width="100%">
                                            <tr class="bg-info text-white">
                                                <td>No</td>
                                                <td>Tanggal</td>
                                                <td>Tempat tes</td>
                                                <td>Hasil</td>
                                            </tr>
                                            <?php echo $tbl;?>
                                            </table>
                                        </div>




										                </div>
									  </div>



									</div>
								</div>
							</div>