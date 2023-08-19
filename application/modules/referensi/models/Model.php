<?php

class Model extends CI_Model  {
    
	 
 
 	function __construct()
    {
        parent::__construct();
    }
	function idu()
	{
		return $this->session->userdata("id");
	}
	
	 
	function set()
	{
		$sts=$this->input->post("sts");
		$id=$this->input->post("id");
		if($sts==0){ $sts=1;}else{ $sts=0;}
		$this->db->set("sts",$sts);
		$this->db->where("id",$id);
		return $this->db->update($this->tbl);
	}
	 
	 
	  
	
	function get_data_master()
	{
		 $this->_get_data_master();
		if($this->input->post("length")!=-1) 
		$this->db->limit($this->input->post("length"),$this->input->post("start"));
	 	return $this->db->get()->result();
		 
	}
	function _get_data_master()
	{
		  
		if (strlen(isset($_POST['search']['value'])?($_POST['search']['value']):null)>1) {
			$searchkey = $_POST['search']['value'];
			$searchkey = $this->m_reff->sanitize($searchkey);
			
				$query=array(
				"title"=>$searchkey ,			 
				"val"=>$searchkey 	 
				);
				$this->db->group_start()
                        ->or_like($query)
                ->group_end();
				
			}	
			
			
			$this->db->order_by("id","asc");
			$query=$this->db->from("pengaturan");
		return $query;
			 
		
		 
	}
	
	public function count_master()
	{				
			$this->_get_data_master();
		return $this->db->get()->num_rows();
	}
	function insert_master()
	{	 
		$post=$this->input->post("f"); 
		$post=$this->security->xss_clean($post); 
	 	return $this->db->insert("pengaturan",$post);
	 
	} 
	 function update_master()
	{	  
		$post=$this->input->post("f"); 
		$post=$this->security->xss_clean($post);
		$this->db->where("id",$this->input->post("id"));
	 	return $this->db->update("pengaturan",$post);
	 
	}
	 
	 
	
	 function hapus_master($id)
	{
		 
		$this->db->where("id",$id);
		return $this->db->delete("pengaturan");
	}
	 function hapus($id,$tbl)
	{
		$this->db->where("id",$id);
		return $this->db->delete($tbl);
	}
	
	 
	 
	function get_data()
	{
		 $this->_get_data();
		if($this->input->post("length")!=-1) 
		$this->db->limit($this->input->post("length"),$this->input->post("start"));
	 	return $this->db->get()->result();
		 
	}
	function _get_data()
	{	$tbl = $this->m_reff->san($this->input->get_post("tbl"));
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
			
			
			$this->db->order_by("id","asc");
			$query=$this->db->from($tbl);
		return $query;
			 
		
		 
	}
	
	public function count()
	{				
			$this->_get_data();
		return $this->db->get()->num_rows();
	}
	function update()
	{	  
		$post=$this->input->post("f"); 
		$post=$this->security->xss_clean($post);
		$this->db->where("id",$this->input->post("id"));
	 	return $this->db->update($this->m_reff->san($this->input->post("tbl")),$post);
	 
	}
	 function insert()
	{	  
		$post=$this->input->post("f"); 
		$post=$this->security->xss_clean($post);
	 	return $this->db->insert($this->m_reff->san($this->input->post("tbl")),$post);
	 
	}
	 
}