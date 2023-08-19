<?php

class Model extends CI_Model  {
    
	 
	function __construct()
    {
        parent::__construct();
    }
    function updateText()
	{
		$form = $this->m_reff->san($this->input->post("val"));
		$this->db->set("val",$form);
		$this->db->where("id",$this->m_reff->san($this->input->post("id")));
		return $this->db->update("pengaturan");
	}


	function usiaMin(){ // <20
		$tgl = $this->tanggal->minTahun(20);
		$this->db->where("tgl_lahir>=",$tgl);
		return $this->db->get("data_pegawai")->num_rows();
	}
	
	function usiaMax(){ // <20
		$tgl = $this->tanggal->minTahun(50);
		$this->db->where("tgl_lahir<=",$tgl);
		return $this->db->get("data_pegawai")->num_rows();
	}
	
	function usia($min,$max){ 
		$tgl1 = $this->tanggal->minTahun($min);
		$tgl2 = $this->tanggal->minTahun($max);
		$this->db->where("tgl_lahir>",$tgl2);
		$this->db->where("tgl_lahir<=",$tgl1);
		return $this->db->get("data_pegawai")->num_rows();
	}

	function goldar($goldar)
	{
		$this->db->where("id_goldar",$goldar);
		return $this->db->get("data_pegawai")->num_rows();
	}
	function jenjangPendidikan()
	{
		$this->db->select('COUNT(id) as jml, id_jp');
		$this->db->group_by('id_jp');
		return $this->db->get('data_pegawai')->result();
	}
}




