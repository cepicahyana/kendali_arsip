<?php
class Model extends CI_Model  {

	function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
	}
	function nip(){
		return $this->session->userdata("nip");
	}
	function idu(){
		return $this->session->userdata("id");
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
		$module	= $this->m_reff->sanitize($this->input->post("module"));
		if ($module) {
			$this->db->where("module", $module);
		}
		
		if (isset($_POST['search']['value'])) {
			$searchkey=$_POST['search']['value']; 
			$searchkey = $this->m_reff->sanitize($searchkey);
			if(strlen($searchkey)>1){
				$query=array(
					"nama"=>$searchkey,
				);

				$this->db->group_start()->or_like($query)->group_end();
			}
		}

				$this->db->order_by("tgl", "desc");
			$query=$this->db->from("main_log");
		return $query;
	}
	function countData()
	{
			$this->_getData();
		return $this->db->get()->num_rows();
	}


}




