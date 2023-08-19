<?php

class Model extends CI_Model  {


	public function __construct()
    {
        parent::__construct();
    }

	function dataProfileAdminPpnpn()
	{
		$id=$this->session->userdata("id");
		$this->db->where("id_admin",$id);
		return $this->db->get("admin")->row();	 
	}

	function dataProfilePicPpnpn(){
		$id=$this->session->userdata("id");
		$this->db->where("id_admin",$id);
		return $this->db->get("admin")->row();	
	}
	function dataProfilePimpinanPpnpn(){
		$id=$this->session->userdata("id");
		$this->db->where("id_admin",$id);
		return $this->db->get("admin")->row();	
	}


    public function update()
    {
		$id		=	$this->input->post("id");
		$form	=	$this->input->post("f");
		if(!$form){
			return false;
		}

		$dok = "file_upload/dp";
		$file = $this->m_reff->upload_file("image",$dok,"foto_admin_".date('His'),"JPG,JPEG,PNG,jpg,jpeg,png",25000000,"");
		if($file["validasi"]!=false){
			$this->db->set("poto",$file["name"]);
		}


		$this->db->set($form);
      	$this->db->where("id_admin", $id);
      	return $this->db->update("admin");
	}

	public function get_by_id()
    {
		$id=$this->session->userdata("id_admin");
		$this->db->where("id_admin", $id);
		return $this->db->get("admin")->row();
    }

	function getLevel($level){
		$this->db->where("id_level", $level);
		return $this->db->get("main_level")->row();
	}

	function getBiro($kode_biro){
		$this->db->where("kode", $kode_biro);
		return $this->db->get("tr_biro")->row();
	}


}
