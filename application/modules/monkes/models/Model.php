<?php

class Model extends CI_Model  {
    

 
 	function __construct()
    {
        parent::__construct();
    }
	function idu()
	{
		return $this->session->userdata("id");
	}
	 

	function getTanggalTest($kode){
		$this->db->where("(kode='".$kode."' or kode_test_utama='".$kode."')");
		$tgl = $this->db->order_by("konfirm_rs","DESC");
		$tgl = $this->db->get("data_test")->row();
		return isset($tgl->konfirm_rs)?($tgl->konfirm_rs):"";
	}

	function getTanggalTestKeluarga($kode){
		$this->db->where("(kode='".$kode."' or kode_test_utama='".$kode."')");
		$tgl = $this->db->order_by("konfirm_rs","DESC");
		$tgl = $this->db->get("data_test_keluarga")->row();
		return isset($tgl->konfirm_rs)?($tgl->konfirm_rs):"";
	}

	function getData()
	{
		 $this->_getData();
		if($this->input->post("length")!=-1) 
		$this->db->limit($this->input->post("length"),$this->input->post("start"));
	 	return $this->db->get()->result();
		 
	}
	function _getData()
	{
		$jenis_pegawai = $this->m_reff->san($this->input->post("jenis_pegawai"));
		// $isolasi	   = $this->input->post("isolasi");
		$kode_istana	   = $this->m_reff->san($this->input->post("kode_istana"));
		$j				   = strlen(isset($_POST['search']['value'])?($_POST['search']['value']):0);
		if($j>1){
				$searchkey = $_POST['search']['value']; 
				$searchkey = $this->m_reff->sanitize($searchkey);

				$query=array(
				"nama"=>$this->m_reff->sanitize($searchkey)
				);
				$this->db->group_start()
                        ->or_like($query)
                ->group_end();
			}	

		if($this->session->level=="pic_covid")
		{	
			if($this->session->userdata("kode_biro")){
				$this->db->where("kode_biro",$this->session->userdata("kode_biro"));
			}else{
				$this->db->where("kode_istana",$this->session->userdata("kode_istana"));
			} 
		}	
			// if($isolasi){
			// 	$this->db->where("isolasi",$isolasi);
			// }
			
			if($jenis_pegawai){
				$this->db->where("jenis_pegawai",$jenis_pegawai);
			}
			if($kode_istana){
				$this->db->where("kode_istana",$kode_istana);
			}
			$this->db->where("(kode_test IS NOT NULL or kode_test !='')");
			$this->db->where("hasil_test","+");
			$this->db->where("sts_keaktifan","aktif");
			$this->db->order_by("level_indikasi","desc");
			$this->db->order_by("jml_buruk","desc");
			$this->db->order_by("jml_kondisi","desc");
			$query=$this->db->from("v_pegawai");
			//SELECT *,count(*) as jml_kondisi FROM `data_kondisi` where sts=0 group by kode_test order by kondisi asc,jml_kondisi desc
		return $query;
			 
		
		 
	}
	
	public function count()
	{				
			$this->_getData();
		return $this->db->get()->num_rows();
	}
   
	function setSembuhByKode($kode){


		$this->m_reff->log("set sembuh","covid");

		$this->db->set("ket","sembuh");
		// $this->db->set("hasil","-");
		$this->db->set("sts","1");
		$this->db->where("kode",$kode);
	    $this->db->update("data_test");

		$this->db->set("hasil_test","-");
		$this->db->set("sts_test","0");
		$this->db->set("sts_akhir_covid","1");
		$this->db->set("tgl_test",null);
		$this->db->set("kode_test",null);
		$this->db->where("kode_test",$kode);
		return $this->db->update("data_pegawai");
	}
	function setMeninggalByKode($kode){
		$this->m_reff->log("set meninggal karena covid","covid");
		$this->db->set("ket","meninggal");
		// $this->db->set("hasil","-");
		$this->db->set("sts","1");
		$this->db->where("kode",$kode);
	    $this->db->update("data_test");

		$this->db->set("hasil_test","-");
		$this->db->set("sts_keaktifan",'meninggal');
		$this->db->set("sts_test","0");
		$this->db->set("sts_akhir_covid","2");
		$this->db->set("tgl_test",null);
		$this->db->set("kode_test",null);
		$this->db->where("kode_test",$kode);
		return $this->db->update("data_pegawai");
	}
	function setSembuhByKodeKel($kode){
		$this->m_reff->log("set sembuh","covid");
		$this->db->set("ket","sembuh");
		// $this->db->set("hasil","-");
		$this->db->set("sts","1");
		$this->db->where("kode",$kode);
	    $this->db->update("data_test_keluarga");


		$this->db->set("hasil_test","-");
		$this->db->set("sts_test","0");
		// $this->db->set("sts_akhir_covid","1");
		$this->db->set("tgl_test",null);
		$this->db->set("kode_test",null);
		$this->db->where("kode_test",$kode);
		return $this->db->update("data_keluarga");
	}
	function setMeninggalByKodeKel($kode){
		$this->m_reff->log("set keluarga meninggal karena covid","covid");
		$this->db->set("ket","meninggal");
		// $this->db->set("hasil","-");
		$this->db->set("sts","1");
		$this->db->where("kode",$kode);
	    $this->db->update("data_test_keluarga");

		$this->db->set("hasil_test","-");
		$this->db->set("sts_hidup",0);
		$this->db->set("sts_test","0");
		// $this->db->set("sts_akhir_covid","2");
		$this->db->set("tgl_test",null);
		$this->db->set("kode_test",null);
		$this->db->where("kode_test",$kode);
		return $this->db->update("data_keluarga");
	}
	function getDataKeluarga()
	{
		 $this->_getDataKeluarga();
		if($this->input->post("length")!=-1) 
		$this->db->limit($this->input->post("length"),$this->input->post("start"));
	 	return $this->db->get()->result();
		 
	}
	function _getDataKeluarga()
	{
		  
		if(strlen(isset($_POST['search']['value']))>2){
				$searchkey = $_POST['search']['value']; 
				$searchkey = $this->m_reff->sanitize($searchkey);

				$query=array(
				"nama"=>$this->m_reff->sanitize($searchkey)
				);
				$this->db->group_start()
                        ->or_like($query)
                ->group_end();
			}	
		if($this->session->level=="pic_covid"){
			if($this->session->userdata("kode_biro")){
				//$this->db->where("kode_biro",$this->session->userdata("kode_biro"));
				$this->db->where("nip_pegawai in (select nip from data_pegawai where kode_biro='".$this->session->userdata("kode_biro")."' ) ");
			}else{
				// $this->db->where("kode_istana",$this->session->userdata("istana"));
				$this->db->where("nip_pegawai in (select nip from data_pegawai where kode_istana='".$this->session->userdata("kode_istana")."' ) ");
			} 
		}
		

			$this->db->where("(kode_test IS NOT NULL or kode_test !='')");
			$this->db->where("hasil_test","+");
			$this->db->order_by("level_indikasi","desc");
			$this->db->order_by("jml_buruk","desc");
			$this->db->order_by("jml_kondisi","desc");
			$query=$this->db->from("v_keluarga");
			//SELECT *,count(*) as jml_kondisi FROM `data_kondisi` where sts=0 group by kode_test order by kondisi asc,jml_kondisi desc
		return $query;
			 
		
		 
	}
	
	public function countKeluarga()
	{				
			$this->_getDataKeluarga();
		return $this->db->get()->num_rows();
	}
   
	function alurKondisi($kode){
		$kode = $this->m_reff->san($kode);
					//$this->db->where("(kode_test='".$kode."' or kode_test_utama='".$kode."')");
		$db		=	$this->db->query("SELECT *
					FROM data_kondisi
					WHERE id IN (
						SELECT MAX(id)
						FROM data_kondisi
						WHERE (kode_test='".$kode."' or kode_test_utama='".$kode."')
						GROUP BY substr(tgl,1,10)
					)")->result();

		$isi	=	"";
		foreach($db as $val){

			if($val->kondisi==1){
				$isi.='<button class="btn btn-sm bg-danger"><i style="font-size:20px;color:white" class="fa fa-frown"></i></button> ';
			}elseif($val->kondisi==2){
				$isi.='<button class="btn btn-sm bg-dark"><i style="font-size:20px;color:white" class="fa fa-meh"></i></button> ';
			}else{
				$isi.='<button class="btn btn-sm bg-success"><i style="font-size:20px;color:yellow" class="fa fa-smile"></i></button> ';
			}
		}
		$data='<div class="">
				'.$isi.'
 				</div>';
		return $data;
	}
	function alurKondisiKeluarga($kode){
		$kode = $this->m_reff->san($kode);
					//$this->db->where("(kode_test='".$kode."' or kode_test_utama='".$kode."')");
		$db		=	$this->db->query("SELECT *
					FROM data_kondisi_keluarga
					WHERE id IN (
						SELECT MAX(id)
						FROM data_kondisi_keluarga
						WHERE (kode_test='".$kode."' or kode_test_utama='".$kode."')
						GROUP BY substr(tgl,1,10)
					)")->result();

		$isi	=	"";
		foreach($db as $val){

			if($val->kondisi==1){
				$isi.='<button class="btn btn-sm bg-danger"><i style="font-size:20px;color:white" class="fa fa-frown"></i></button> ';
			}elseif($val->kondisi==2){
				$isi.='<button class="btn btn-sm bg-dark"><i style="font-size:20px;color:white" class="fa fa-meh"></i></button> ';
			}else{
				$isi.='<button class="btn btn-sm bg-success"><i style="font-size:20px;color:yellow" class="fa fa-smile"></i></button> ';
			}
		}
		$data='<div class="">
				'.$isi.'
 				</div>';
		return $data;
	}
	function level_kondisi_keluarga($kode){
		$kode = $this->m_reff->san($kode);
				 		$this->db->where(" (kode_test='".$kode."' or kode_test_utama='".$kode."')");
						$this->db->order_by("tgl","desc");
						$this->db->limit(1);
						$val = $this->db->get("data_kondisi_keluarga")->row();
						$tingkat = isset($val->level_indikasi)?($val->level_indikasi):"";
		$isi	=	"";
 

			if($tingkat==1){
				$isi='<span>Ringan</span> ';
			}elseif($tingkat==2){
				$isi='<span class="text-info">Sedang</span> ';
			}elseif($tingkat==3){
				$isi='<span class="text-danger">Berat</span> ';
			}elseif($tingkat==4){
				$isi='<span class="text-danger">Kritis</span> ';
			}else{
				$isi='<span></span> ';
			}
	 
		$data='<div class="">
				'.$isi.'
 				</div>';
		return $data;
	}
	function level_kondisi($kode){
		$kode = $this->m_reff->san($kode);
				 		$this->db->where(" (kode_test='".$kode."' or kode_test_utama='".$kode."')");
						$this->db->order_by("tgl","desc");
						$this->db->limit(1);
						$val = $this->db->get("data_kondisi")->row();
						$tingkat = isset($val->level_indikasi)?($val->level_indikasi):"";
		$isi	=	"";
 

			if($tingkat==1){
				$isi='<span>Ringan</span> ';
			}elseif($tingkat==2){
				$isi='<span class="text-info">Sedang</span> ';
			}elseif($tingkat==3){
				$isi='<span class="text-danger">Berat</span> ';
			}elseif($tingkat==4){
				$isi='<span class="text-danger">Kritis</span> ';
			}else{
				$isi='<span></span> ';
			}
	 
		$data='<div class="">
				'.$isi.'
 				</div>';
		return $data;
	}

	function isoman($kode){
		$kode = $this->m_reff->san($kode);
		$this->db->where("kode",$kode);
		$db		 =	$this->db->get("data_test")->row();
		$isolasi =  isset($db->isolasi)?($db->isolasi):"";
		return $this->m_reff->goField("tr_isolasi","nama","where kode='".$isolasi."'");
	}
	function isoman_keluarga($kode){
		$kode = $this->m_reff->san($kode);
		$this->db->where("kode",$kode);
		$db		 =	$this->db->get("data_test_keluarga")->row();
		$isolasi =  isset($db->isolasi)?($db->isolasi):"";
		return $this->m_reff->goField("tr_isolasi","nama","where kode='".$isolasi."'");
	}
	function hubungan($id,$jk){
		$nama="nama_".$jk;
		$this->db->where("id",$id);
		$db=$this->db->get("tr_hubungan")->row();
		return isset($db->$nama)?($db->$nama):"";
	}
	function ajukan_tes(){
		$form 		 = $this->m_reff->san($this->input->post("f"));
		$nip		 = $this->m_reff->san($this->input->post("nip"));
		// $cek		 = "+";
		$kode_utama	 = $this->m_reff->san($this->input->post("kode_test_utama"));

		$this->db->set("sts_test",1);
		$this->db->where("nip",$nip);
		$this->db->update("data_pegawai");

		$kode	 = $this->m_reff->generateKode();
		$this->m_reff->qr($kode);
		 
		$this->db->set(
			array(
			"tgl"		=>	date("Y-m-d"),
			"_cid"		=>	$this->m_reff->idu(),
			"_ctime"	=>	date("Y-m-d H:i:s"),
			"nip"		=>	$nip,
			"kode"		=>	$kode
			)
		);
		$this->db->set("sts_acc",1);
		$this->db->set($form);
		// if($cek=="+"){
			// $this->db->set("test_lanjutan",1);
			$this->db->set("kode_test_utama",$kode_utama);
		// }
		$this->db->insert("data_test");
		$tgl_test = $this->input->post("f[tgl]");
		$jenis_test =  $this->input->post("f[kode_jenis]");
		$this->kirimNotifSR($nip,$this->input->post("f[kode_tempat]"),$kode,$tgl_test,$jenis_test);

		 $var["token"] = $this->m_reff->getToken();
		return $var;
	}
	function kirimNotifSR($nip,$kode_tempat,$kode,$tgl_test,$jenis_test){
		$db = $this->db->get_where("data_pegawai",array("nip"=>$nip))->row();
		$sts = $this->m_reff->jenis_pegawai($db->jenis_pegawai);
		$msg = $this->m_reff->notifikasi(3,"wa");
		if(strtolower($db->jk)=="laki-laki"){
			$awalan = "Bpk";
		}elseif(strtolower($db->jk)=="perempuan"){
			$awalan = "Ibu";
		}else{
			$awalan = "";
		}

		$getRS = $this->db->get_where("tm_rs",array("kode"=>$kode_tempat))->row();
		$rs = isset($getRS->nama)?($getRS->nama):"";
		$rs_alamat = isset($getRS->alamat)?($getRS->alamat):"";
		$rs = $rs." - ".$rs_alamat;


		$msg = str_replace("{nik}",$db->nik,$msg);
		$msg = str_replace("{nama}",$db->nama,$msg);
		$msg = str_replace("{awalan}",$awalan,$msg);
		$msg = str_replace("{tempat_tes}",$rs,$msg);
		$msg = str_replace("{status}",$sts,$msg);
		$msg = str_replace("{tgl_tes}",$this->tanggal->hariLengkap($tgl_test,"/"),$msg);

		$tahun = date("Y");
		$file = $this->m_reff->pengaturan(1).$tahun."/surat_rekomendasi/".$kode.".pdf";
		$this->genSR($kode,$getRS,$db,$file,$tgl_test,$jenis_test);
		return $this->m_reff->kirimWa($db->no_hp,$msg,null);
	}

	function genSR($kode,$getRS,$db,$file,$tgl_test,$jenis_test){
		ob_start();
		//include('file.html');
		$data["tgl_test"] = $tgl_test; 
		$data["kode_test"] = $kode; // kode test
		$data["getRS"] = $getRS; 
		$data["data"] = $db; // data pegawai
		$data["jenis_test"] = $jenis_test; // data pegawai
	 	$html=$this->load->view('genSR',$data,TRUE); 
		// $css=$kode;

 
			$mpdf = new \Mpdf\Mpdf([
				'mode' => 'utf-8', 
				'format' => 'A4-P',
				// 'margin_left' => 32,
				// 'margin_right' => 25,
				// 'margin_top' => 27,
				// 'margin_bottom' => 25,
				// 'margin_header' => 16,
				// 'margin_footer' => 13 
			]);
	
			// $stylesheet = file_get_contents($css);
			$mpdf->SetDisplayMode('fullpage');
			// $mpdf->WriteHTML($stylesheet, 1); // The parameter 1 tells that this is css/style only and no body/html/text
			$mpdf->WriteHTML($html, 2);
			// $mpdf->Output(); // opens in browser
			$mpdf->Output($file, 'F'); // it downloads the file into the user system, with give name
	}

















	function ajukan_tes_keluarga(){
		$form 		 = $this->input->post("f");
		// $nip		 = $this->input->post("nip");
		// $cek		 = "+";
		$kode_utama	 = $this->input->post("kode_test_utama");
		$nik		 = $form["nik"];

		$this->db->set("sts_test",1);
		$this->db->where("nik",$form["nik"]);
		$this->db->update("data_keluarga");
		 
		$kode	 = $this->m_reff->generateKodeFamily();
		$this->m_reff->qr($kode);
		 
		$this->db->set(
			array(
			"tgl"		=>	date("Y-m-d"),
			"_cid"		=>	$this->m_reff->idu(),
			"_ctime"	=>	date("Y-m-d H:i:s"),
			"kode"		=>	$kode
			)
		);
		$this->db->set("sts_acc",1);
		$this->db->set($form);
		// if($cek=="+"){
			// $this->db->set("test_lanjutan",1);
			$this->db->set("kode_test_utama",$kode_utama);
		// }
		$this->db->insert("data_test_keluarga");
		 $var["token"] = $this->m_reff->getToken();


		 $param=array(
			"nip"=>$this->input->post("nip"),
			"nik"=>$nik,
			"kode_tempat" => $this->input->post("f[kode_tempat]"),
			"kode" => $kode,
			"tgl_test" => $this->input->post("f[tgl]"),
			"jenis_test" => $this->input->post("f[kode_jenis]")
		 );
		$this->kirimNotifSRKeluarga($param);

		return $var;
	}


	function kirimNotifSRKeluarga($param){
		$nik			=	$param["nik"];
		$nip			=	$param["nip"];
		$kode_tempat	=	$param["kode_tempat"];
		$kode			=	$param["kode"];
		$tgl_test		=	$param["tgl_test"];
		$jenis_test		=	$param["jenis_test"];

		$db  = $this->db->get_where("data_pegawai",array("nip"=>$nip))->row();
		$fam = $this->db->get_where("data_keluarga",array("nik"=>$nik))->row();
		
	  
		$msg = $this->m_reff->notifikasi(3,"wa");
		if(strtolower($db->jk)=="laki-laki"){
			$awalan = "Bpk";
		}elseif(strtolower($db->jk)=="perempuan"){
			$awalan = "Ibu";
		}else{
			$awalan = "";
		}
		if(strtolower($fam->jk)=="laki-laki"){
			$awalan_keluarga = "Bpk";
		}elseif(strtolower($fam->jk)=="perempuan"){
			$awalan_keluarga = "Ibu";
		}else{
			$awalan_keluarga = "";
		}

		
		if(strtolower($db->jk)=="laki-laki"){
			$awalan = "Bpk";
		}elseif(strtolower($db->jk)=="perempuan"){
			$awalan = "Ibu";
		}else{
			$awalan = "";
		}
		 
		$getRS = $this->db->get_where("tm_rs",array("kode"=>$kode_tempat))->row();
		$rs = isset($getRS->nama)?($getRS->nama):"";
		$rs_alamat = isset($getRS->alamat)?($getRS->alamat):"";
		$rs = $rs." - ".$rs_alamat;
		$msg = str_replace("{status}","Keluarga pegawai",$msg);
		$msg = str_replace("{nik}",$fam->nik,$msg);
		$msg = str_replace("{nama}",$fam->nama,$msg);
		$msg = str_replace("{nama_pegawai}",$db->nama,$msg);
		$msg = str_replace("{awalan_pegawai}",$awalan,$msg);
		$msg = str_replace("{awalan_keluarga}",$awalan_keluarga,$msg);
		$msg = str_replace("{tempat_tes}",$rs,$msg);
		$msg = str_replace("{tgl_tes}",$this->tanggal->hariLengkap($tgl_test,"/"),$msg);

		$tahun = date("Y");
		$file = $this->m_reff->pengaturan(1).$tahun."/surat_rekomendasi/".$kode.".pdf";

		$param=array(
			"kode" =>$kode,
			"getRS" =>$getRS,
			"db" =>$db,
			"file" =>$file,
			"fam" =>$fam,
			"tgl_test" =>$tgl_test,
			"jenis_test" =>$jenis_test,
		);
		$this->genSRKeluarga($param);
		return $this->m_reff->kirimWa($db->no_hp,$msg,null);
	}

	function genSRKeluarga($param){
		ob_start();
		//include('file.html');
		$data["kode_test"] = $param["kode"]; // kode test
		$data["getRS"] = $param["getRS"]; 
		$data["data"] = $param["db"]; // data pegawai
		$data["fam"] = $param["fam"]; // data family
		$data["tgl_test"] = $param["tgl_test"]; 
		$data["jenis_test"] = $param["jenis_test"]; 
		$file = $param["file"]; 
	 	$html=$this->load->view('genSRKeluarga',$data,TRUE); 
		// $css=$kode;

 
			$mpdf = new \Mpdf\Mpdf([
				'mode' => 'utf-8', 
				'format' => 'A4-P',
				// 'margin_left' => 32,
				// 'margin_right' => 25,
				// 'margin_top' => 27,
				// 'margin_bottom' => 25,
				// 'margin_header' => 16,
				// 'margin_footer' => 13 
			]);
	 
			$mpdf->SetDisplayMode('fullpage');
		 	$mpdf->WriteHTML($html, 2);
			// $mpdf->Output(); // opens in browser
			$mpdf->Output($file, 'F'); // it downloads the file into the user system, with give name
	}

}