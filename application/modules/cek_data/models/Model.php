<?php

class Model extends CI_Model  {
    
	 
	function __construct()
    {
        parent::__construct();
    }
	function getPegawai(){
		return $this->db->get("penilaian_kinerja_ppnpn");
	  }
	  function bagian($nip){
		$this->db->where("nip",$nip);
		$dta=$this->db->get("data_pegawai")->row();
		return isset($dta->bagian)?($dta->bagian):null;
	  }
	  function getPenilaian($t, $tB){
		$this->db->where("nip", $this->input->post("nip"));
		$this->db->where("tahun <=", $t);
		$this->db->where("tahun >=", $tB);
		$this->db->order_by("tahun", 'desc');
		$this->db->order_by("semester", 'asc');
		return $this->db->get("penilaian_kinerja_ppnpn")->result();
	  }
	  function getPenilaianDetail($id){
		$this->db->where("id", $id);
		return $this->db->get("penilaian_kinerja_ppnpn")->result();
	  }
    function cekSearch(){
		$key	=	$this->input->post("key");
		$key	=	$this->m_reff->san($key);
		$val	=	$this->input->post("val");
		$val	=	$this->m_reff->san($val);
					$this->db->where($key,$val);
		return		$this->db->get("v_pegawai")->row();
	}
	function jmlKeluarga($nip,$hub){
		$this->db->where_in("id_hubungan",$hub);
		$this->db->where("nip_pegawai",$nip);
		return $this->db->get("data_keluarga")->num_rows();
	}
	function jmlPenghargaan($nip){
		$this->db->where("nip_pegawai",$nip);
		return $this->db->get("tm_penghargaan")->num_rows();
	}
	function dataForPDF($nip){
		$this->db->where("nip", $nip);
		return $this->db->get("data_pegawai")->row();
	}
	
}




