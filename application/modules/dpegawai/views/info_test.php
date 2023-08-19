<?php
$dp 	= $this->db->get_where("data_pegawai",array("id"=>$this->session->userdata("id")))->row();
$level 	= $this->session->userdata("level");
$kode	= isset($dp->kode_test)?($dp->kode_test):null;
$hasil	= isset($dp->hasil_test)?($dp->hasil_test):null;
$mobile = $this->m_reff->mobile();

$stsDb 		= $this->mdl->sts_test_trakhir();

$sts    	 = isset($stsDb->sts)?($stsDb->sts):null; // sts selesai atau belum
$hasilDb	 = isset($stsDb->hasil)?($stsDb->hasil):null;
$stsID		 = isset($stsDb->id)?($stsDb->id):null;
$stsAcc		 = isset($stsDb->sts_acc)?($stsDb->sts_acc):0;
$kode_rs	 = isset($stsDb->kode_tempat)?($stsDb->kode_tempat):0;
$sts_acc   	 = isset($stsDb->sts_acc)?($stsDb->sts_acc):"not";
$kode_new    = isset($stsDb->kode)?($stsDb->kode):null;
$tgl_new     = isset($stsDb->tgl)?($stsDb->tgl):null;
$tahun_new   = substr($tgl_new,0,4);
$kode_utama  = isset($stsDb->kode_test_utama)?($stsDb->kode_test_utama):null;

$dtrs 		= $this->db->get_where("tm_rs",array("kode"=>$kode_rs))->row();
$rs			= isset($dtrs->nama)?($dtrs->nama):"";
$alamat_rs	= isset($dtrs->alamat)?($dtrs->alamat):"";
 

if($dp->jenis_pegawai==1){ //jika pegawai ASN foto dr link
    $img = $dp->foto;
    if($img){
      $img = $img;
    }else{
      $img =   base_url().'assets/'.$dp->jk.'.png';
    }

  }else{
        $img = $dp->foto; //foto dr upload path
      if($img){
           $img = $this->m_reff->pengaturan(1).$img;
           $img =   $this->konversi->img($img);
      }else{
          $img =  base_url().'assets/'.$dp->jk.'.png';
      }
  }



if($sts_acc==1){


if($hasilDb=="-"){
	if($stsDb->konfirm_rs){
		$tgl =  $this->tanggal->hariLengkap3($stsDb->konfirm_rs,"/");
	}else{
		$tgl =  $this->tanggal->hariLengkap3($stsDb->tgl,"/");
	}

	echo '	
    <div class="row">
	<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
    <div class="card custom-card">
        <div class="card-body text-center">
            <div class="user-lock text-center">
                 
                <img alt="avatar" class="rounded-circle" src="'.$img.'">
                    </div>
            <h5 class=" mb-1 mt-3 card-titles">
            '.$dp->nama.'
            </h5>
            <p class="text-muted text-center mt-1">
            Hasil test pada hari '.$this->tanggal->hariLengkap($stsDb->konfirm_rs,"/").'  dinyatakan 
            <b class="text-success mt-1">Negatif (-)</b>
            </p>
         

            <div class="mt-2 user-info btn-list">
                <a class="btn btn-success btn-block" href="'.site_url("download").'?f='.$this->m_reff->encrypt($stsDb->file).'"><i class="fe fe-download mr-2"></i><span> Download hasil tes</span></a>
                     </div>
                </div>
            </div>
        </div></div><br>';
}
elseif($hasilDb=="+" and $sts!=1){
 
	$tgl =  $this->tanggal->hariLengkap3($stsDb->konfirm_rs,"/");
    echo '    
    <div class="row">
	<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
						<div class="card custom-card">
							<div class="card-body text-center">
								<div class="user-lock text-center">
									 
									<img alt="avatar" class="rounded-circle" src="'.$img.'">
						                </div>
								<h5 class=" mb-1 mt-3 card-titles">
                                
                                Hasil test anda pada hari '.$tgl.' dinyatakan 
<b class="text-danger mt-1">Positif (+)</b>
                                
                                </h5>
							
								<p class="text-black text-center mt-0">
                                Anda telah dinyatakan positif, mohon untuk melaporkan perkembangan kondisi anda setiap hari
                                agar kami dapat memantau kesehatan anda
                                </p>
								<div class="mt-2 user-info btn-list">
									<a class="btn btn-info btn-block" href="javascript:void(0)" onclick="update(`'.$kode.'`,`'.$kode_utama.'`)"><i class="fa fa-paper-plane mr-2"></i><span>Laporkan kondisi terkini</span></a>
									<a class="btn btn-success btn-block" href="'.site_url("download").'?f='.$this->m_reff->encrypt($stsDb->file).'"><i class="fe fe-download mr-2"></i><span> Download hasil tes</span></a>
									<a style="display:none" class="btn btn-secondary  btn-block" href="javascript:ajukan_ulang(`'.$kode_new.'`,`'.$dp->nama.'`)"><i class="fa fa-clinic-medical mr-2"></i><span>Ajukan tes covid selanjutnya</span></a>
						                </div>
					                </div>
				                </div>
			                </div>
    </div><br>
    ';

    

}else{
    if($kode_utama){
        $tmb='  <div class="mt-2 user-info btn-list">
        <a class="btn btn-info btn-block" href="javascript:void(0)" onclick="update(`'.$kode_new.'`,`'.$kode_utama.'`)"><i class="fa fa-paper-plane mr-2"></i><span>Laporkan kondisi terkini</span></a>
             </div>';
    }else{
        $tmb='';    
    }
    $file_sr = $tahun_new."/surat_rekomendasi/".$kode_new.".pdf";
    echo '	
    <div class="row">
	<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
    <div class="card custom-card">
        <div class="card-body text-center">
            <div class="user-lock text-center">
                 
                <img alt="avatar" class="rounded-circle" src="'.$img.'">
                    </div>
            <h5 class=" mb-1 mt-3 card-titles">
            '.$dp->nama.'
            </h5>
            <p class="text-black text-center mt-1">
            Permohonan anda untuk pengajuan tes covid telah disetujui,
            silahkan datang ke <span class="text-success"><b>'.$rs.' - '.$alamat_rs.'</b></span>
            dengan membawa KTP asli dan surat tes yag dapat anda download pada tombol dibawah ini.
            </p>
            <a target="_blank" class="btn btn-info btn-block" href="'.site_url("download").'?f='.$this->m_reff->encrypt($file_sr).'"  ><i class="fa fa-download mr-2"></i><span>Download surat tes</span></a>
       

          '.$tmb.'
         
                </div>
            </div>
        </div></div><br>';
}



}elseif($sts_acc==0 and $stsID){
    echo '
    <div class="row">
	<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
						<div class="card custom-card">
							<div class="card-body text-center">
								<div class="user-lock text-center">
									 
									<img alt="avatar" class="rounded-circle" src="'.$img.'">
										</div>
								<h5 class=" mb-1 mt-3 card-titles">
								'.$dp->nama.'
								</h5>
								<p class="text-black text-center mt-1">
								Permohonan anda untuk pengajuan tes covid sedang dalam proses persetujuan admin,
								 tes dilakukan ketika permohonan sudah disetujui, mohon menunggu.
								</p>
							 
								<div class="mt-2 user-info btn-list">
									<a onclick="batalkan(`'.$kode_new.'`,`'.$dp->nama.'`)" class="btn btn-danger btn-block" href="javascript:void(0)"><i class="fa fa-paper-plane mr-2"></i><span>Batalkan permohonan tes</span></a>
									 </div>
									</div>
								</div>
							</div>
                   </div><br>         ';
}else{
    if(!$mobile){
        echo '
    <div class="row">
	<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
						<div class="card custom-card">
							<div class="card-body text-center">
								<div class="user-lock text-center">
									 
									<img alt="avatar" class="rounded-circle" src="'.$img.'">
										</div>
								<h5 class=" mb-1 mt-3 card-titles">
								'.$dp->nama.'
								</h5>
								<p class="text-black text-center mt-1">
								Saat ini anda tidak sedang dalam permohonan tes covid, untuk melakukan permohonan tes silahkan klik tombol dibawah ini:
								</p>
							 
								<div class="mt-2 user-info btn-list">
                                <a class="menuclick btn btn-secondary  btn-block" 
                                href="'.base_url().'input_permohonan"><i class="fa fa-paper-plane  mr-2"></i><span>Ajukan tes covid </span></a>
						         
									 </div>
									</div>
								</div>
							</div>
                   </div><br>         ';
    }
}
?>