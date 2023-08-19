<?php

class Model extends CI_Model  {
    
		
	function __construct()
    {
        parent::__construct();
    }
	 
	 
	 
	  function notifikasi($id)
	 {
		$this->db->where("id",$id);
		return $this->db->get("notifikasi")->row();
		 
	 }

	 function update()
	{
		$form = $this->input->post("f");
		$this->db->set($form);
		$this->db->where("id",$this->input->post("id"));
		return $this->db->update("notifikasi");
	}
	 function updateText()
	{
		$form = $this->input->post("val");
		$this->db->set("val",$this->m_reff->san($form));
		$this->db->where("id",$this->input->post("id"));
		return $this->db->update("pengaturan");
	}
	 
	
	 
}