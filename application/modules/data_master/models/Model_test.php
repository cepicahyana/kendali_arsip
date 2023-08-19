<?php

class Model_test extends CI_Model  {
    
 
 	function __construct()
    {
        parent::__construct();
    }
	function idu()
	{
		return $this->session->userdata("id");
	}
	 


	function get_data()
	{
		$this->_get_data();
		if($this->m_reff->san($this->input->post("length")!=-1)) 
		$this->db->limit($this->m_reff->san($this->input->post("length")),$this->m_reff->san($this->input->post("start")));
	 	return $this->db->get()->result();
		 
	}
	function _get_data()
	{
		  
        if (strlen(isset($_POST['search']['value'])?($_POST['search']['value']):null)>1) {
                $searchkey = $_POST['search']['value'];
                $searchkey = $this->m_reff->sanitize($searchkey);

				$query=array(
				"nama"=>$searchkey, 				 
				"kode"=>$searchkey, 				 
				 		 
				);
				$this->db->group_start()
                        ->or_like($query)
                ->group_end();
				
			}	
			
			
			$this->db->order_by("kode","asc");
			$query=$this->db->from("tr_jenis_test");
		return $query;
			 
		
		 
	}
	
	public function count()
	{				
			$this->_get_data();
		return $this->db->get()->num_rows();
	}
    function insert(){
        $form   = $this->input->post("f");
        if(!$form){return false;}
        $cek    = $this->cek();
        if($cek){
            $var["gagal"]=true;
            $var["info"]="Kode sudah pernah diinput.";
            $var["token"]=$this->m_reff->getToken();
            return $var;
        }
        $this->db->set($form);
      $this->db->insert("tr_jenis_test");
      $var["token"]=$this->m_reff->getToken();
      return $var;
    }
    function update(){
        $form   = $this->input->post("f");
        if(!$form){return false;}
        $cek    = $this->cek();
        if($cek){
            $var["gagal"]=true;
            $var["info"]="Kode sudah pernah diinput.";
            $var["token"]=$this->m_reff->getToken();
            return $var;
        }
        $id     = $this->m_reff->san($this->input->post("id")); 
        $this->db->where("id",$id);
        $this->db->set($form);
        $this->db->update("tr_jenis_test");
        $var["token"]=$this->m_reff->getToken();
        return $var;
    }
    function cek(){
        $this->db->where("kode",$this->m_reff->san($this->input->post("f[kode]")));
        $this->db->where("id!=",$this->m_reff->san($this->input->post("id")));
        return $this->db->get("tr_jenis_test")->num_rows();
    }
    function hapus(){
        $this->db->where("id",$this->m_reff->san($this->input->post("id")));
        $this->db->delete("tr_jenis_test");
        $var["token"]=$this->m_reff->getToken();
        return $var;
    }
	
}