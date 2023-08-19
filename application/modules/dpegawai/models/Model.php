<?php

class Model extends CI_Model  {
    
	 
	function __construct()
    {
        parent::__construct();
    }
	function get_data()
	{
		 $this->_get_data();
		if($this->m_reff->san($this->input->post("length"))!=-1) 
		$this->db->limit($this->m_reff->san($this->input->post("length")),$this->input->post("start"));
	 	return $this->db->get()->result();
		 
	}
	function _get_data()
	{
		$nip = $this->session->userdata("nip");  
	  
			$this->db->order_by("id","desc");
			$this->db->where("nip",$nip);
			$query=$this->db->from("data_test");
		return $query;
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

	function get_data_keluarga()
	{
		$this->_get_data_keluarga();
		if($this->m_reff->san($this->input->post("length"))!=-1) 
		$this->db->limit($this->m_reff->san($this->input->post("length")),$this->m_reff->san($this->input->post("start")));
	 	return $this->db->get()->result();
		 
	}
	function _get_data_keluarga()
	{
		$nip = $this->session->userdata("nip");  
	  
			$this->db->order_by("id","desc");
			$this->db->where("nip_pegawai",$nip);
			$query=$this->db->from("data_test_keluarga");
		return $query;
	}	
	public function count_keluarga()
	{				
			$this->_get_data_keluarga();
		return $this->db->get()->num_rows();
	}


	function hapus_progress(){
		$this->db->where("id",$this->m_reff->san($this->input->post("id")));
		return $this->db->delete("data_kondisi");
	}

	function hapus_permohonan_keluarga(){
		$kode = $this->m_reff->san($this->input->post("kode"));

		$this->db->set("sts_test",0);
		$this->db->where("kode_test",$kode);
		$this->db->update("data_keluarga");

		$this->db->where("kode",$this->m_reff->san($this->input->post("kode")));
		return $this->db->delete("data_test_keluarga");
	}

	function hapus_permohonan(){
		$kode = $this->m_reff->san($this->input->post("kode"));

		$this->db->set("sts_test",0);
		$this->db->where("kode_test",$kode);
		$this->db->update("data_pegawai");

		$this->db->where("kode",$kode);
		return $this->db->delete("data_test");
	}
	function nip(){
		$id = $this->session->userdata("id");
		$this->db->where("id",$id);
		$d=$this->db->get("data_pegawai")->row();
		return isset($d->nip)?($d->nip):"";
	}
	public function count()
	{				
			$this->_get_data();
		return $this->db->get()->num_rows();
	}
	function __getKodeTest(){
		$nip = $this->nip();
		$this->db->where("nip",$nip);
		$this->db->where("sts",0);
		$this->db->where("test_lanjutan",0);
		$this->db->where("hasil","+");
		$res =  $this->db->get("data_test")->row();
		return isset($res->kode)?($res->kode):null;
	}
	function cek_kondisi($kode){
		$this->db->where("kode_test",$kode);
		$this->db->where("date(tgl)",date('Y-m-d'));
		return $this->db->get("data_kondisi")->num_rows();
	}
	function cek_keterangan($kode){
		$this->db->where("kode",$kode);
		$this->db->where("isolasi IS NOT NULL");
		$this->db->where("penularan IS NOT NULL");
		return $this->db->get("data_test")->num_rows();
	}
	function update_kondisi(){
		$form 				 = $this->input->post("f");
		if(!$form){ return false; }
		$kode 				 = $this->m_reff->san($this->input->post("kode"));
		$kode_utama 		 = $this->m_reff->san($this->input->post("kode_utama"));
		$kondisi = $this->m_reff->san($this->input->post("kondisi"));
		$gejala  = $this->input->post("gejala");
		$gejala  = json_encode($gejala);
		$gejala	=	str_replace(',""',"",$gejala);
		
		if(strpos($gejala,"4")!==FALSE){
			$level_indikasi = 4;
		}elseif(strpos($gejala,"3")!==FALSE){
			$level_indikasi = 3;
		}elseif(strpos($gejala,"2")!==FALSE){
			$level_indikasi = 2;
		}else{
			$level_indikasi = 1;
		}

		$this->db->set(
			array(
			"tgl"		=>	date("Y-m-d H:i:s"),
			"kode_test"			=>	$kode,
			"kode_test_utama"	=>	$kode_utama,
			"kondisi"	=>	$kondisi,
			"indikasi"	=>	$gejala,
			"level_indikasi"	=>	$level_indikasi
			)
		);
		 $this->db->set($form);
		 $this->db->insert("data_kondisi");
		if($kode_utama){
			$this->db->where("kode",$kode_utama);
		}else{
			$this->db->where("kode",$kode);
		}
		
		 $this->db->set("level_indikasi",$level_indikasi);
		 $this->db->set($form);
		 $this->db->update("data_test");

			
		$this->db->set("level_indikasi",$level_indikasi);
		$this->db->where("id",$this->session->userdata("id"));
		$this->db->update("data_pegawai");

		 $var["token"]=$this->m_reff->getToken();
		 return $var;
	}
	function update_kondisi_keluarga(){
		$form 				 = $this->input->post("f");
		if(!$form){ return false; }
		$nik 				 = $this->m_reff->san($this->input->post("nik"));
		$kode 				 = $this->m_reff->san($this->input->post("kode"));
		$kode_utama 		 = $this->m_reff->san($this->input->post("kode_utama"));
		$kondisi = $this->m_reff->san($this->input->post("kondisi"));
		$gejala  =  $this->input->post("gejala");
		$gejala  = json_encode($gejala);
		$gejala	=	str_replace(',""',"",$gejala);
		
		if(strpos($gejala,"4")!==FALSE){
			$level_indikasi = 4;
		}elseif(strpos($gejala,"3")!==FALSE){
			$level_indikasi = 3;
		}elseif(strpos($gejala,"2")!==FALSE){
			$level_indikasi = 2;
		}else{
			$level_indikasi = 1;
		}

		$this->db->set(
			array(
			"tgl"				=>	date("Y-m-d H:i:s"),
			"kode_test"			=>	$kode,
			"kode_test_utama"	=>	$kode_utama,
			"kondisi"			=>	$kondisi,
			"indikasi"			=>	$gejala,
			"level_indikasi"	=>	$level_indikasi
			)
		);
		 $this->db->set($form);
		 $this->db->insert("data_kondisi_keluarga");
		if($kode_utama){
			$this->db->where("kode",$kode_utama);
		}else{
			$this->db->where("kode",$kode);
		}
		
		 $this->db->set("level_indikasi",$level_indikasi);
		 $this->db->set($form);
		 $this->db->update("data_test_keluarga");

		 	
		$this->db->set("level_indikasi",$level_indikasi);
		$this->db->where("nik",$nik);
		$this->db->update("data_keluarga");


		 $var["token"]=$this->m_reff->getToken();
		 return $var;
	}
	function update_kondisi_keluarga__(){
		$kode 				 = $this->m_reff->san($this->input->post("kode"));
		$kode_utama 		 = $this->m_reff->san($this->input->post("kode_utama"));
		$kondisi = $this->m_reff->san($this->input->post("kondisi"));
		$gejala  = $this->m_reff->san($this->input->post("gejala"));
		$gejala  = json_encode($gejala);
		$gejala  = str_replace(',""',"",$gejala);

		$this->db->set(
			array(
			"tgl"		=>	date("Y-m-d H:i:s"),
			"kode_test"			=>	$kode,
			"kode_test_utama"	=>	$kode_utama,
			"kondisi"	=>	$kondisi,
			"gejala"	=>	$gejala,
			)
		);
		 $this->db->insert("data_kondisi_keluarga");
		 $var["token"]=$this->m_reff->getToken();
		 return $var;
	}

	function getDataKab($idprov){
		$this->db->where("id_prov",$idprov);
		return $this->db->get("kabupaten")->result();
	}
	function getDataKec($idkab){
		$this->db->where("id_kab",$idkab);
		return $this->db->get("kecamatan")->result();
	}
	function getDataKel($idkec){
		$this->db->where("id_kec",$idkec);
		return $this->db->get("kelurahan")->result();
	}
	
	function update_ket(){

		$kode		=	$this->m_reff->san($this->input->post("kode"));
		$form		=	$this->input->post("f");
		if(!$form){ return false; }
		$d			=	$this->input->post("d"); //domisili
		$nik		=	$this->m_reff->san($this->input->post("nik"));

		$penularan	=	$this->input->post("penularan");
		 
		$penularan	=	json_encode($penularan);
		$penularan	=	str_replace(',""',"",$penularan);

		$this->db->where("kode",$kode);
		$this->db->set($form);
		$this->db->set("penularan",$penularan);
		$this->db->update("data_test");

		$this->db->where("nik",$nik);
		$this->db->set($d);
		$this->db->update("data_pegawai");

		// UPDATE KONDISI

		$ket = $this->m_reff->san($this->input->post("ket"));
		$indikasi  = $this->input->post("indikasi");
		$indikasi  = json_encode($indikasi);
		$indikasi  = str_replace(',""',"",$indikasi);
		
		if(strpos($indikasi,"4")!==FALSE){
			$level_indikasi = 4;
		}elseif(strpos($indikasi,"3")!==FALSE){
			$level_indikasi = 3;
		}elseif(strpos($indikasi,"2")!==FALSE){
			$level_indikasi = 2;
		}else{
			$level_indikasi = 1;
		}

		$this->db->set(
			array(
			"tgl"				=>	date("Y-m-d H:i:s"),
			"kode_test"			=>	$kode,
			"kode_test_utama"	=>	null,
			"kondisi"			=>	2,
			"indikasi"			=>	$indikasi,
			"level_indikasi"	=>	$level_indikasi,
			"ket"				=>	$ket
			)
		);
		$this->db->set($form);
		 $this->db->insert("data_kondisi");

		$this->db->where("kode",$kode);
		$this->db->set("level_indikasi",$level_indikasi);
		$this->db->update("data_test");


		 $var["token"]=$this->m_reff->getToken();
		 return $var;


	}

	function ajukan_tes(){
		$form 		 = $this->input->post("f");
		if(!$form){ return false; }
		$nip		 = $this->m_reff->san($this->input->post("nip"));
		// $cek		 = "+";
		$kode_utama	 = $this->m_reff->san($this->input->post("kode_test_utama"));

		$this->db->set("sts_test",1);
		$this->db->where("nip",$nip);
		$this->db->update("data_pegawai");

		$kode	 = $this->m_reff->generateKode();

		 
		$this->db->set(
			array(
			"tgl"		=>	date("Y-m-d"),
			"_cid"		=>	$this->m_reff->idu(),
			"_ctime"	=>	date("Y-m-d H:i:s"),
			"nip"		=>	$nip,
			"kode"		=>	$kode
			)
		);
		$this->db->set("sts_acc",0);
		$this->db->set($form);
		// if($cek=="+"){
			// $this->db->set("test_lanjutan",1);
			$this->db->set("kode_test_utama",$kode_utama);
		// }
		$this->db->insert("data_test");
		 $var["token"] = $this->m_reff->getToken();
		return $var;
	}
	function ajukan_tes_keluarga(){
		$form 		 = $this->input->post("f");
		if(!$form){ return false; }
		// $nip		 = $this->input->post("nip");
		// $cek		 = "+";
		$kode_utama	 = $this->m_reff->san($this->input->post("kode_test_utama"));


		$this->db->set("sts_test",1);
		$this->db->where("nik",$form["nik"]);
		$this->db->update("data_keluarga");

		 
		$kode	 = $this->m_reff->generateKodeFamily();

		 
		$this->db->set(
			array(
			"tgl"		=>	date("Y-m-d"),
			"_cid"		=>	$this->m_reff->idu(),
			"_ctime"	=>	date("Y-m-d H:i:s"),
			"kode"		=>	$kode
			)
		);
		$this->db->set("sts_acc",0);
		$this->db->set($form);
		// if($cek=="+"){
			// $this->db->set("test_lanjutan",1);
			$this->db->set("kode_test_utama",$kode_utama);
		// }
		$this->db->insert("data_test_keluarga");
		 $var["token"] = $this->m_reff->getToken();
		return $var;
	}
	// function set_update(){
	// 	$kode 	 = $this->input->post("kode");
	// 	$kondisi = $this->input->post("kondisi");

	// 	if($kondisi=="sembuh"){
	// 		$this->db->set("sts",1);
	// 		$this->db->where("kode",$kode);
	// 		$this->db->update("data_test");
	// 	}


	// 	$this->db->set(
	// 		array(
	// 		"tgl"		=>	date("Y-m-d"),
	// 		"kode_test"	=>	$kode,
	// 		"kondisi"	=>	$kondisi,
	// 		)
	// 	);
	// 	return $this->db->insert("data_kondisi");
	// }
	function sts_test_trakhir(){
		
			
		$tglex = $this->tanggal->minTglEng(4,date('Y-m-d'));
		
		$this->db->where("nik",$this->m_reff->nik());
		$this->db->where("(sts=0 or (konfirm_rs<='".date('Y-m-d')."' and konfirm_rs>='".$tglex."') )");	
		
		$this->db->order_by("_ctime","desc");
		$this->db->limit(1);
		return $this->db->get("data_test")->row();
	}


	function cek_pengajuan_keluarga($nik){

	
		$tglex = $this->tanggal->minTglEng(4,date('Y-m-d'));
		$this->db->where("(sts=0 or (konfirm_rs<='".date('Y-m-d')."' and konfirm_rs>='".$tglex."') )");	
		$this->db->where("nik",$nik);
		// $this->db->where("kode_test_utama IS NOT NULL");
		$this->db->order_by("_ctime","desc");
		$this->db->limit(1);
		return $this->db->get("data_test_keluarga")->row();
	}
}




