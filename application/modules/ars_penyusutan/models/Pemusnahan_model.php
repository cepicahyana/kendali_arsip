<?php

class Pemusnahan_model extends CI_Model
{



    function __construct()
    {
        parent::__construct();
    }
    function idu()
    {
        return $this->session->userdata("id");
    }
	 
    /*======= DATATABLE PEMUSNAHAN =========*/
	function getData()
	{
		$this->_getData();
		if($this->m_reff->san($this->input->post("length")!=-1)) 
		$this->db->limit($this->m_reff->san($this->input->post("length")),$this->m_reff->san($this->input->post("start")));
	 	return $this->db->get()->result();
		 
	}

	function _getData()
	{
		  
		    if (strlen(isset($_POST['search']['value'])?($_POST['search']['value']):null)>1) {
                $searchkey = $_POST['search']['value'];
                $searchkey = $this->m_reff->sanitize($searchkey);
				$query=array(
				"nama"=>$searchkey 
				);
				$this->db->group_start()
                        ->or_like($query)
                ->group_end();
				
			}		 
		$query=$this->db->from("ars_trx_pemusnahan");
		return $query;
	}
	
	public function count()
	{				
		$this->_getData();
		return $this->db->get()->num_rows();
	}


	/*======= DATATABLE ARSIP =========*/
	function getDataArsip()
	{
		$this->_getDataArsip();
		if($this->m_reff->san($this->input->post("length")!=-1)) 
		$this->db->limit($this->m_reff->san($this->input->post("length")),$this->m_reff->san($this->input->post("start")));
	 	return $this->db->get()->result();
		 
	}

	function _getDataArsip()
	{

		if (strlen(isset($_POST['search']['value']) ? ($_POST['search']['value']) : null) > 1) {
			$searchkey = $_POST['search']['value'];
			$searchkey = $this->m_reff->sanitize($searchkey);
			$query = array(
				"nama" => $searchkey
			);
			$this->db->group_start()
				->or_like($query)
				->group_end();
		}
		$query = $this->db->from("ars_trx_arsip");
		return $query;
	}

	public function countArsip()
	{				
		$this->_getDataArsip();
		return $this->db->get()->num_rows();
	}

}