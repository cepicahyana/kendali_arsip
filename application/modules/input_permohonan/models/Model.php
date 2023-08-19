<?php

class Model extends CI_Model  {
    
	 
	function __construct()
    {
        parent::__construct();
    }
	function setNIK(){
		$var["token"]=$this->m_reff->getToken();
		$nik	=	$this->m_reff->san($this->input->post("nik"));
		$id		=	$this->m_reff->san($this->input->post("id"));

					$this->db->where("id!=",$id);
		$cek	=	$this->db->get_where("data_pegawai",array("nik"=>$nik))->num_rows();
		if($cek){
			$var["sts"] = false;
			$var["info"] = "NIK sudah pernah digunakan oleh oleh lain.";
			return $var;
		}

		$this->db->set("nik",$nik);
		$this->db->where("id",$id);
		$this->db->update("data_pegawai");
		 $var["sts"] = true;
	
		 return $var;
	}
	function setTempatLahir(){
		$tmp	=	$this->m_reff->san($this->input->post("val"));
		$id		=	$this->m_reff->san($this->input->post("id"));
		$this->db->set("tempat_lahir",$tmp);
		$this->db->where("id",$id);
		return $this->db->update("data_pegawai");
	}
	function setTglLahir(){
		$tmp	=	$this->m_reff->san($this->input->post("val"));
		$id		=	$this->m_reff->san($this->input->post("id"));
		$tmp    =   $this->tanggal->eng_($tmp,"-");
		$this->db->set("tgl_lahir",$tmp);
		$this->db->where("id",$id);
		return $this->db->update("data_pegawai");
	}
	function get_data()
	{
		 $this->_get_data();
		if($this->input->post("length")!=-1) 
		$this->db->limit($this->input->post("length"),$this->input->post("start"));
	 	return $this->db->get()->result();
		 
	}
	function _get_data()
	{
	 	    // $nip = $this->session->userdata("nip");    
			$this->db->order_by("id","desc");
			// $this->db->where("sts",0);
			// $this->db->where("_cid",$this->idu());
			$this->db->where("nik",$this->m_reff->nik());
			$query=$this->db->from("data_test");
		return $query;
			 
		
		 
	}
	function nip(){
		return $this->session->userdata("nip");
	}
	function idu(){
		return $this->session->userdata("id");
	}
	public function count()
	{				
			$this->_get_data();
		return $this->db->get()->num_rows();
	}
	function setHp(){
		$tmp	=	$this->m_reff->san($this->input->post("val"));
		$id		=	$this->m_reff->san($this->input->post("id"));
		$this->db->set("no_hp",$tmp);
		$this->db->where("id",$id);
		return $this->db->update("data_pegawai");
	}
	function hapus(){
		$id    = $this->input->post("id");
		$nip   = $this->input->post("nip");

		$this->db->where("nip",$nip);
		$this->db->set("sts_test",0);
		$this->db->update("data_pegawai");


		$this->db->where("id",$id);
		return    $this->db->delete("data_test");
	}
	function insert(){
		$form 	 = $this->input->post("f");
		$nik	 = $this->m_reff->nik();
		$db		 = $this->db->get_where("data_pegawai",array("nik"=>$nik))->row();
		$nip =  isset($db->nip)?($db->nip):"";

		
		$this->db->where("hasil",null);
		// $this->db->where("tgl",date("Y-m-d"));
		$this->db->where("nip",$nip);
		$cek = $this->db->get("data_test")->num_rows();
		if($cek){
			$var["gagal"]	=	true;
			$var["info"]	=	"Anda sedang dalam mengajukan test!";
			return $var;
		}

		
		$cek		 = isset($db->hasil_test)?($db->hasil_test):"";
		$kode_utama	 = isset($db->kode_test)?($db->kode_test):null;
		$nama		 = isset($db->nama)?($db->nama):null;
		$nik		 = isset($db->nik)?($db->nik):null;
		$nip		 = isset($db->nip)?($db->nip):null;
		$sts_test		 = isset($db->sts_test)?($db->sts_test):null;
		$kode_biro		 = isset($db->kode_biro)?($db->kode_biro):null;
		 
		$kode	 = $this->generateKode();

		
		
		if($cek!="+"){
			$this->db->where("nik",$nik);
			$this->db->set("kode_test",$kode);
			$this->db->set("sts_test",1);
			$this->db->update("data_pegawai");
		}
		
		$tgl_permohonan = $this->m_reff->san($this->input->post("tgl_permohonan"));
		$tgl_permohonan = $this->tanggal->eng_($tgl_permohonan,"-");

		$this->db->set(
			array(
			"tgl"		=>	$tgl_permohonan,//date("Y-m-d"),
			"_cid"		=>	$this->idu(),
			"_ctime"	=>	date("Y-m-d H:i:s"),
			"kode"		=>	$kode,
			"nama"		=>	$nama,
			"nip"		=>	$nip,
			"nik"		=>	$nik
			)
		);
		$this->db->set("sts_acc",0);
		if($cek=="+"){
			// $this->db->set("test_lanjutan",1);
			$this->db->set("kode_test_utama",$kode_utama);
		}
		$this->db->set($form);
		$this->db->set("kode_istana",$this->session->kode_istana);
		$this->db->set("kode_biro",$kode_biro);
		$this->db->insert("data_test");

		 $this->mdl->notifPIC();
		 $var["token"] = $this->m_reff->getToken();
		 $this->m_reff->log("Pegawai: input permohonan");
		 $this->m_reff->counterNotif($this->session->kode_istana,$kode_biro,$notif_field="notif_pengajuan");
		return $var;
	}
	function notifPIC(){
		$msg = $this->m_reff->notifikasi(7,"wa");
		$msg = str_replace("{tgl}",date("d-m-Y H:i:s"),$msg);

			  $this->db->where("level",6);
			  if($this->session->userdata("kode_biro")){
				$this->db->where("kode_biro",$this->session->userdata("kode_biro"));
			  }
			  if($this->session->userdata("kode_istana")){
				$this->db->where("kode_istana",$this->session->userdata("kode_istana"));
			  }
		$db = $this->db->get("admin")->result();
		foreach($db as $val){
			$hp = $val->telp;
		 	$this->m_reff->kirimWa($hp,$msg);
		}
		return true;
	}
	function update(){
		$form 	 = $this->input->post("f");
		$id		 = $this->input->post("id");

		$this->db->set($form);
		$this->db->where("id",$id);
		 $this->db->update("data_test");

		$var["token"] = $this->m_reff->getToken();
		return $var;

	}

	function getDataPegawaiEdit(){
        $val    = $this->input->post("val");
                  $this->db->or_where("nip",$val);
        return    $this->db->get("data_pegawai")->row();
    }

	function getDataPegawai(){
        $val    = $this->input->post("val");
                  $this->db->where("nik",$val);
                  $this->db->or_where("nip",$val);
                  $this->db->where("sts_test",0);
        return    $this->db->get("data_pegawai")->row();
    }

	function generateKode(){
		$kode = $this->m_reff->acak(10);
		$cek = $this->db->get_where("data_test",array("kode"=>$kode))->num_rows();
		if($cek){
			return $this->generateKode();
		}else{
			return $kode;
		}
	}
	function get_data_family()
	{
		 $this->_get_data_family();
		if($this->input->post("length")!=-1) 
		$this->db->limit($this->input->post("length"),$this->input->post("start"));
	 	return $this->db->get()->result();
		 
	}
	function _get_data_family()
	{
	 	    $nip = $this->session->userdata("nip");    
			$this->db->order_by("id","desc");
			// $this->db->where("sts",0);
			$pic = $this->session->pic;
			if($pic){
				$this->db->where("nip_pegawai in (select nip from data_pegawai where kode_biro='".$this->m_reff->sanitize($pic)."' )");
			}else{
			    $this->db->where("_cid",$this->idu());
			}

				if (strlen(isset($_POST['search']['value'])?($_POST['search']['value']):null)>1) {
					$searchkey = $_POST['search']['value'];
					$searchkey = $this->m_reff->sanitize($searchkey);
					$query=array(
					"nama"=>$searchkey, 				 		 
					"nip_pegawai"=>$searchkey, 				 
					"nik"=>$searchkey, 				 				 
							  
					);
					$this->db->group_start()
							->or_like($query)
					->group_end();
					
				}	

			$query=$this->db->from("data_test_keluarga");
		return $query;
	}
	public function countFamily()
	{				
			$this->_get_data_family();
		return $this->db->get()->num_rows();
	}
	function getDataKeluargaEdit(){
        $nik    = $this->input->post("val");
                  $this->db->or_where("nik",$nik);
        return    $this->db->get("data_keluarga")->row();
    }


	function insert_family(){
		$form 	 = $this->input->post("f");
		$nik	 = $this->input->post("f[nik]");
		$id_hub  = $this->input->post("id_hubungan");
		$jk	     = $this->input->post("jk");
  

	 

		
		$this->db->where("tgl",date("Y-m-d"));
		$this->db->where("nik",$nik);
		$cek = $this->db->get("data_test_keluarga")->row();
		$nama = isset($cek->nama)?($cek->nama):"";
		if(isset($cek->id)){
			$var["gagal"]	=	true;
			$var["info"]	=	"Anda telah mengajukan tes untuk ".$nama."  hari ini!";
			return $var;
		}




		$kode	 = $this->generateKodeFamily();

				   $this->db->where("nip_pegawai",$this->m_reff->nip());
				   $this->db->where("nik",$nik);
		$cek 	 = $this->db->get("data_keluarga")->row();
		$cek_test     = isset($cek->sts_test)?($cek->sts_test):0;
		$ava     = isset($cek->id)?($cek->id):0;
		$hasil_tes = isset($cek->hasil_test)?($cek->hasil_test):null;
		$kode_utama = isset($cek->kode_test)?($cek->kode_test):null;

		if($cek_test){
			$var["gagal"] = true;
			$var["info"]  = "Gagal! ".$form['nama']. " sedang diajukan untuk tes.";
			$var["token"] = $this->m_reff->getToken();
			return $var;
		}

		$tgl = $this->tanggal->eng_($this->input->post("tgl_lahir"));
		
		// $this->db->set("istana",$this->m_reff->peg_id_istana());
		// $this->db->set("kode_biro",$this->m_reff->peg_kode_biro());
		if(!$ava){ // jika data keluarga tidak ada maka ditambahkan
			$this->db->set("tgl_lahir",$tgl);
			$this->db->set("nip_pegawai",$this->m_reff->nip());
			$this->db->set($form);
			$this->db->set("id_hubungan",$id_hub);
			$this->db->set("jk",$jk);
			$this->db->set("kode_test",$kode);
			$this->db->set("sts_test",1);
			$this->db->insert("data_keluarga");
		}else{
			$this->db->set("jk",$jk);
			$this->db->set("id_hubungan",$id_hub);
			$this->db->set("tgl_lahir",$tgl);
			$this->db->set("sts_test",1);
			$this->db->set($form);
			$this->db->where("id",$ava);
			$this->db->update("data_keluarga");
		}

		 
			 $sts_acc=0;
		 
		$this->db->set("kode_istana",$this->m_reff->peg_id_istana());
		$this->db->set("kode_biro",$this->m_reff->peg_kode_biro());
		$this->db->set(
			array(
			"tgl"		=>	date("Y-m-d"),
			"_cid"		=>	$this->idu(),
			"_ctime"	=>	date("Y-m-d H:i:s"),
			"kode"		=>	$kode,
			"nip_pegawai"	=> $this->m_reff->nip(),
			"kode_tempat"	=> $this->input->post("kode_tempat"),
			"kode_jenis"	=> $this->input->post("kode_jenis"),
			"nama"	=> $this->input->post("f[nama]"),
			"jk"	=> $this->input->post("jk"),
			"nik"	=> $this->input->post("f[nik]"),
			"id_hubungan"	=> $id_hub,
			"sts_acc"		=> $sts_acc
			)
		);

		if($hasil_tes=="+"){
			$this->db->set("kode_test_utama",$kode_utama);
		}
		$this->db->insert("data_test_keluarga");
		$this->notifPIC();
		$var["token"] = $this->m_reff->getToken();
		return $var;
	}
	 

	function generateKodeFamily(){
		$kode = $this->m_reff->acak(11);
		$cek = $this->db->get_where("data_test_keluarga",array("kode"=>$kode))->num_rows();
		if($cek){
			return $this->generateKodeFamily();
		}else{
			return $kode;
		}
	}

	function update_family(){
		$form 	 = $this->input->post("f");
		$id		 = $this->input->post("id");
 
		 $this->db->set("sts_acc",0);
		 
	
		 $this->db->set("kode_istana",$this->m_reff->peg_id_istana());
		 $this->db->set("kode_biro",$this->m_reff->peg_kode_biro());
		$this->db->set($form);
		$this->db->where("id",$id);
		$this->db->update("data_test_keluarga");
		$var["token"] = $this->m_reff->getToken();
		return $var;
	}
 

}




