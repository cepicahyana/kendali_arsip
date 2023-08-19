<?php
class Model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	function idu()
	{
		return $this->session->userdata("id");
	}
	/*===================================*/
	public function getData()
	{
		$this->_getData();
		if ($this->input->post("length") != -1)
			$this->db->limit($this->input->post("length"), $this->input->post("start"));
		return $this->db->get()->result();
	}

	private function _getData()
	{
		if (strlen(isset($_POST['search']['value'])?($_POST['search']['value']):null)>1) {
			$searchkey = $_POST['search']['value'];
			$searchkey = $this->m_reff->sanitize($searchkey);
			
			$query = array(
				"istana" => $searchkey,
			);
			$this->db->group_start()
				->or_like($query)
				->group_end();
		}

		$this->db->order_by("kode", "asc");
		$query = $this->db->from("tr_istana");
		return $query;
	}

	public function count()
	{
		$this->_getData();
		return $this->db->get()->num_rows();
	}

	function insert()
	{
		$form	=	$this->input->post("f");
		$this->db->set($form);
		$this->db->insert("tr_istana");
		return $this->m_reff->log("insert data istana","data");
	}
	function update()
	{
	 
		$id		=	$this->input->post("id");
		$form	=	$this->input->post("f");
		if(!$form){return false;}
		// $kop_surat_b=$this->input->post("kop_surat_b"); ////
		$dok=$this->m_reff->pengaturan(1)."dok/";
		$img=$this->m_reff->upload_file("kop_surat",$dok,"kopsurat","JPG,JPEG,PNG","3000000",null);
		if($img['validasi']==true) {
			$this->db->set("header",$img['name']); 
		} 
		// else {
		// 	$this->db->set("header","kop-surat.jpg");
		// }

		$this->db->set($form);
		$this->db->where("id", $id);
		$this->db->update("tr_istana");
		return $this->m_reff->log("update data istana","data");
	}

	function hapus()
	{
		$id	=	$this->input->post("id");
		$this->db->where("id", $id);
		$this->db->delete("tr_istana");
		return $this->m_reff->log("hapus data istana","data");
	}
	 
}
