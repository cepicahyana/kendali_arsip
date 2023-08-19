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

	function updateText(){
		$data = $this->m_reff->san($this->input->post("text"));
		$this->db->where("id", 17); //id link_text = 17
		$this->db->set("val", $data);
		return $this->db->update("pengaturan");
	}

	function updateImage(){
		$data = $this->m_reff->san($this->input->post("image"));
		$this->db->where("id", 18); //id link_image = 18
		$this->db->set("val", $data);
		return $this->db->update("pengaturan");
	}

	function updateKey(){
		$data = $this->m_reff->san($this->input->post("key"));
		$this->db->where("id", 19); //id key = 19
		$this->db->set("val", $data);
		return $this->db->update("pengaturan");
	}
}