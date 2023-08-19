<?php

class Model extends CI_Model  {
    
	var $tbl="admin";
 
 	function __construct()
    {
        parent::__construct();
    }
	function idu()
	{
		return $this->session->userdata("id");
	}
	function simpanBroadcast_wa(){
		$real		=	$this->m_reff->san($this->input->post("konten"));
		$real	    =   str_replace("&nbsp;"," ",$real);
		$real	    =   str_replace("&nbsp;"," ",$real);
		$real	    =   str_replace("&nbsp;"," ",$real);
		
		$konten		=	$this->m_reff->convert_wa($real);
		 
		$this->db->set("real",$real); 
		$konten		=	str_replace("&nbsp;"," ",$konten);
		$konten		=	str_replace("&NBSP;"," ",$konten); 
		$this->db->set("konten",$konten);
		$this->db->set("subject","whatsapp");
		 $this->db->set("type",2);
		return $this->db->insert("data_broadcast");
	}
	
	function simpanBroadcast_email(){
		$real		=	$this->m_reff->san($this->input->post("konten"));
		$real	    =   str_replace("&nbsp;"," ",$real); 
		$real	    =   str_replace("&NBSP;"," ",$real); 
		
		$konten		=	$real;
		$konten		=	str_replace("&nbsp;"," ",$konten);
		$konten		=	str_replace("&NBSP;"," ",$konten);
		
		$set=$this->input->post("f");
		$this->db->set("real",$real);
		$this->db->set("konten",$konten);
		$this->db->set($set);
		return $this->db->insert("data_broadcast");
	}function update(){
		$id			=	$this->input->post("id");
		$real		=	$this->m_reff->san($this->input->post("konten"));
		$real	    =   str_replace("&nbsp;"," ",$real); 
		$real	    =   str_replace("&NBSP;"," ",$real); 
		
		$konten		=	$real;
		$konten		=	str_replace("&nbsp;"," ",$konten);
		$konten		=	str_replace("&NBSP;"," ",$konten);
		
		$set=$this->input->post("f");
		$this->db->set("real",$real);
		$this->db->set("konten",$konten);
	 	$this->db->set($set);
		$this->db->where("id",$id);
		return $this->db->update("data_broadcast");
	}
	 
	 function get_data()
	{
		 $this->_get_data();
		if($this->input->post("length")!=-1) 
		$this->db->limit($this->input->post("length"),$this->input->post("start"));
	 	return $this->db->get()->result();
		 
	}
	function _get_data()
	{
	  
		if (strlen(isset($_POST['search']['value'])?($_POST['search']['value']):null)>1) {
			$searchkey = $_POST['search']['value'];
			$searchkey = $this->m_reff->sanitize($searchkey);
				$query=array(
				 	 
				"konten"=>$searchkey ,			 
				"subject"=>$searchkey 			 
				);
				$this->db->group_start()
                        ->or_like($query)
                ->group_end();
				
			}	
			
			
			$this->db->order_by("id","desc");
			$query=$this->db->from("data_broadcast");
		return $query;
			 
		
		 
	}
	
	public function count()
	{				
			$this->_get_data();
		return $this->db->get()->num_rows();
	}
	
	function hapus(){
		$id	=	$this->input->post("id");
		$this->db->where("id",$id);
		return $this->db->delete("data_broadcast");
	}
 
}