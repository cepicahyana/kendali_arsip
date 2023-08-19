<?php
$nip	= $this->m_reff->nip();
// $dp 	= $this->db->get_where("data_keluarga",array("nip_pegawai"=>$nip))->row();
 
		  $tglex = $this->tanggal->minTglEng(4,date('Y-m-d'));
		  $this->db->where("(sts=0 or (konfirm_rs<='".date('Y-m-d')."' and konfirm_rs>='".$tglex."') )");	
		  $this->db->where("nip_pegawai",$nip) ;	
		//   $this->db->where("nik","333");	
		  $this->db->group_by("nik");
		  $this->db->select("nik");
$db 	= $this->db->get("data_test_keluarga")->result();
$tbl	= "";

 

foreach($db as $val_){

			$this->db->where("nik",$val_->nik);
			$this->db->order_by("tgl","desc");
			$this->db->limit(1);
	$val = $this->db->get("data_test_keluarga")->row();


	$dt = $this->m_reff->dataRs($val->kode_tempat);
	$dbpeg = $this->db->get_where("data_keluarga",array("nik"=>$val->nik))->row(); 
	$jk			=	isset($dbpeg->jk)?($dbpeg->jk):"";
	$kode		=	isset($dbpeg->kode_test)?($dbpeg->kode_test):"";
	
	$acc		=	$val->sts_acc;
 
	$dtrs 		= $this->db->get_where("tm_rs",array("kode"=>$val->kode_tempat))->row();
	$rs			= isset($dtrs->nama)?($dtrs->nama):"";
	$alamat_rs	= isset($dtrs->alamat)?($dtrs->alamat):"";
	$tahun		= substr($val->tgl,0,4);
	$link_sr	= $tahun."/surat_rekomendasi/".$val->kode.".pdf";
	$link_sr	= $this->m_reff->encrypt($link_sr);
	
 if($acc==1)
 {	
	if($val->hasil)
	{
		
		$aj					= $this->mdl->cek_pengajuan_keluarga($val->nik); //cek  mengambil data test lanjutan
		$aj_kode_test		= isset($aj->kode)?($aj->kode):"";
		$aj_kode_test_utama	= isset($aj->kode_test_utama)?($aj->kode_test_utama):null;

		$aj_sts_acc		= isset($aj->sts_acc)?($aj->sts_acc):"";
		$aj_hasil		= isset($aj->hasil)?($aj->hasil):null;
		$aj_kode_tempat = isset($aj->kode_tempat)?($aj->kode_tempat):"";

		$aj_dtrs 		= $this->db->get_where("tm_rs",array("kode"=>$aj_kode_tempat))->row();

		$aj_rs			= isset($aj_dtrs->nama)?($aj_dtrs->nama):"";
		$aj_alamat_rs	= isset($aj_dtrs->alamat)?($aj_dtrs->alamat):"";
		

		if($aj_sts_acc==0){
			$tmbl_ajukan = '<a onclick="batal_keluarga(`'.$aj->kode.'`,`'.$val->nama.'`)" class="btn btn-danger btn-block" href="javascript:void(0)"><i class="fa fa-paper-plane mr-2"></i><span>Batalkan permohonan tes</span></a>';
			$info = '	Permohonan '.$aj->nama.' untuk pengajuan tes covid sedang dalam proses <b class="text-black">persetujuan admin</b>,
			tes dilakukan ketika permohonan sudah disetujui, mohon menunggu.';
			$info_hasil='<b> permohonan sedang diproses</b>';
			$tmbl_down ="";
			$tmbl_lapor = '	<a onclick="update_keluarga(`'.$aj_kode_test.'`,`'.$aj_kode_test_utama.'`)" class="btn btn-info btn-block" href="javascript:void(0)"><i class="fa fa-paper-plane mr-2"></i><span>Laporkan kondisi terkini</span></a>';
		}elseif($aj_hasil=="+"){
		 
			$tmbl_ajukan ='';//<a class="btn btn-secondary  btn-block" href="javascript:ajukan_ulang_keluarga(`'.$aj->kode.'`,`'.$aj->nama.'`)"><i class="fa fa-clinic-medical mr-2"></i><span>Ajukan tes covid selanjutnya</span></a>';
			$info =ucwords($aj->nama).' telah dinyatakan positif, mohon untuk melaporkan perkembangan kondisinya setiap hari
			agar kami dapat memantau kesehatan keluarga anda.';
			$info_hasil='Hasil test pada hari '.$this->tanggal->hariLengkap($aj->konfirm_rs,"/").'  dinyatakan 
			<b class="text-danger mt-1">Positif (+)</b>';
			$tmbl_down  ='	<a class="btn btn-success btn-block" href="'.site_url("download").'?f='.$this->m_reff->encrypt($aj->file).'"><i class="fe fe-download mr-2"></i><span> Download hasil tes</span></a>';
			$tmbl_lapor = '	<a onclick="update_keluarga(`'.$aj_kode_test.'`,`'.$aj_kode_test_utama.'`)" class="btn btn-info btn-block" href="javascript:void(0)"><i class="fa fa-paper-plane mr-2"></i><span>Laporkan kondisi terkini</span></a>';
		
		}elseif($aj_hasil=="-"){
			$tmbl_ajukan ='';
			$info_hasil ='Hasil test pada hari '.$this->tanggal->hariLengkap($aj->konfirm_rs,"/").'  dinyatakan  <b class="text-success mt-1">Negatif (+)</b>';
			$info ='';
			$tmbl_down ='	<a class="btn btn-success btn-block" href="'.site_url("download").'?f='.$this->m_reff->encrypt($aj->file).'"><i class="fe fe-download mr-2"></i><span> Download hasil tes</span></a>';
			$tmbl_lapor='';
		}elseif($aj_hasil==null){
			$tmbl_ajukan ='';
			$info_hasil ='Telah disetujui';
			$info ='	Permohonan '.$aj->nama.' untuk pengajuan tes covid telah disetujui,
			silahkan datang ke <span class="text-success"><b>'.$aj_rs.' - '.$aj_alamat_rs.'</b></span>
			dengan membawa KTP asli dan menunjukan Surat rekomendasi yang dapat didownload pada link dibawah ini.';
			$tmbl_down ='';
			if($aj->kode_test_utama){
				$tmbl_lapor = '	<a onclick="update_keluarga(`'.$aj_kode_test.'`,`'.$aj_kode_test_utama.'`)" class="btn btn-info btn-block" href="javascript:void(0)"><i class="fa fa-paper-plane mr-2"></i><span>Laporkan kondisi terkini</span></a>';
	 		}else{
				$tmbl_lapor = "";
			}
		} 

		$tbl.='
		<div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
							<div class="card custom-card">
								<div class="card-body text-center">
									<div class="user-lock text-center">
										 
										<img alt="avatar" class="rounded-circle" src="'.base_url().'assets/'.$jk.'.png">
											</div>
									<h5 class=" mb-1 mt-3 card-titles">
									'.$val->nama.'
									</h5>
									<p class="text-muted text-center mt-1">
									'.$info_hasil.'
									</p>
								
									
									
								
									<p class="text-black text-center mt-0">
									'.$info.'
									</p>
									<div class="mt-2 user-info btn-list">
								 
									'.$tmbl_lapor.'
									'.$tmbl_down.'
									'.$tmbl_ajukan.'
											</div>
										</div>
									</div>
								</div>
		
		';

	}else{
		

	
		$tbl.='
		<div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
							<div class="card custom-card">
								<div class="card-body text-center">
									<div class="user-lock text-center">
										 
										<img alt="avatar" class="rounded-circle" src="'.base_url().'assets/'.$jk.'.png">
											</div>
									<h5 class=" mb-1 mt-3 card-titles">
									'.$val->nama.'
									</h5>
									<p class="text-black text-center mt-1">
									Permohonan '.$val->nama.' untuk pengajuan tes covid telah disetujui,
									silahkan datang ke <span class="text-success"><b>'.$rs.' - '.$alamat_rs.'</b></span>
									dengan membawa KTP asli dan
									Surat rekomendasi yang dapat didownload pada link dibawah ini.<br>
									<a href="'.base_url().'download?f='.$link_sr.'" class="btn-block btn btn-info btn-mini">Download Surat Rekomendasi</a>
									</p>
								 
								 
										</div>
									</div>
								</div>';

						 
	}


}else{
	if($dbpeg->sts_test==1){
	$tbl.='
	<div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
						<div class="card custom-card">
							<div class="card-body text-center">
								<div class="user-lock text-center">
									 
									<img alt="avatar" class="rounded-circle" src="'.base_url().'assets/'.$jk.'.png">
										</div>
								<h5 class=" mb-1 mt-3 card-titles">
								'.$val->nama.'
								</h5>
								<p class="text-black text-center mt-1">
								Permohonan '.$val->nama.' untuk pengajuan tes covid sedang dalam proses persetujuan admin,
								tes dilakukan ketika permohonan sudah disetujui, mohon menunggu.
								</p>
							 
								<div class="mt-2 user-info btn-list">
									<a onclick="batal_keluarga(`'.$kode.'`,`'.$val->nama.'`)" class="btn btn-danger btn-block" href="javascript:void(0)"><i class="fa fa-paper-plane mr-2"></i><span>Batalkan permohonan tes</span></a>
									 </div>
									</div>
								</div>
							</div>';
	}
}


}


?>

 


<?php
if($tbl){?>
<div style='margin-top:-20px' >
<div class="row">
	<?php echo $tbl;?>
</div>
</div>

<?php } ?>