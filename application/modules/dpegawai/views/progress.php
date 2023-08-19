<?php
$kode = $this->m_reff->san($this->input->post("kode"));
if(!$kode){
    return false;
}
?>

<div class="col-lg-12  col-md-12 col-sm-12">
								<div class="card card-dashboard-events">
									<div class="card-header pb-0">
										<div class="d-flex justify-content-between">
											<h5 class=" text-success mg-b-10">Laporan kondisi harian</h5>
											<i class="mdi mdi-dots-horizontal text-gray"></i>
										</div>
									 
									</div>
									<div class="card-body">
										<div class="list-group ">
										<?php
                                        $this->db->order_by("id","desc");
                                        $db = $this->db->get_where("data_kondisi",array("kode_test"=>$kode))->result();
                                        foreach($db as $val){
                                            $gejala = str_replace('"','',$val->gejala);
                                            $gejala = str_replace('[','',$gejala);
                                            $gejala = str_replace(']','',$gejala);
                                            if(strtolower($val->kondisi)=="membaik"){
                                                $bg = 'bg-success-gradient';
                                            }
                                            elseif(strtolower($val->kondisi)=="stagnan"){
                                                $bg = 'bg-info-gradient';
                                            }else{
                                                $bg = 'bg-danger-gradient';
                                            }


if(substr($val->tgl,0,10)==date("Y-m-d")){
    $btn='<button class="float-right btn btn-danger btn-sm" onclick="hapus_progress(`'.$val->id.'`)"> hapus </button>';
}else{
    $btn='';
}

echo '
<div class="list-group-item border-bottom-0">
<div class="event-indicator '.$bg.'"></div><label>'.$this->tanggal->dateTimeJam($val->tgl).' WIB</label>
<h6 class="text-info"><i class="typcn icon typcn-chart-bar-outline"></i> '.$val->kondisi.'</h6>
<p>'.$gejala.'</p>
'.$btn.'
</div>
';
                                        }
										?>

										</div>
									</div>
								</div>
							</div>