<?php
class Model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	// getJenjangPendidikan
	function getJp()
	{
		return  $this->db->get('tr_jp')->result();
	}

	function getJpByid($id)
	{
		$this->db->select('nama');
		$this->db->from('tr_jp');
		$this->db->where('id', $id);
		return $this->db->get()->row();
	}

    function add(){
        // $tahun=$this->m_reff->tahun();
        // $sms=$this->m_reff->semester();
		$ket=$this->m_reff->san($this->input->post("ket"));
		$start=$this->m_reff->san($this->input->post("start"));
		$end=$this->m_reff->san($this->input->post("end"));
		$end=$this->tanggal->minTglEng(2,$end);

		// $this->db->set("id_tahun",$tahun);
		// $this->db->set("id_semester",$sms);
		$this->db->set("nama",$ket);
		$this->db->set("start",$start);
		$this->db->set("end",$end);
		return $this->db->insert("tm_jadwal_libur");
	}

    function update(){
		$title=$this->m_reff->san($this->input->post("title"));
		$id=$this->m_reff->san($this->input->post("id"));
		$this->db->where("id",$id);
		$this->db->set("nama",$title);
		return $this->db->update("tm_jadwal_libur");
	}
    
    function moveEvent(){
		$id=$this->m_reff->san($this->input->post("id"));
		$start=$this->m_reff->san($this->input->post("start"));
		$end=$this->m_reff->san($this->input->post("end"));
		$this->db->where("id",$id);
		$this->db->set("start",$start);
		$this->db->set("end",$end);
		return $this->db->update("tm_jadwal_libur");
	}

	function hapus(){
		$id=$this->m_reff->san($this->input->post("id"));
		$this->db->where("id",$id);
		$this->db->delete("tm_jadwal_libur");
	}


}