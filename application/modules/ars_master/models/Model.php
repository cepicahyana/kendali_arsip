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
	 


	function get_data_biro()
	{
		 $this->_get_data_biro();
		if($this->m_reff->san($this->input->post("length")!=-1)) 
		$this->db->limit($this->m_reff->san($this->input->post("length")),$this->m_reff->san($this->input->post("start")));
	 	return $this->db->get()->result();
		 
	}
	function _get_data_biro()
	{
		  
		    if (strlen(isset($_POST['search']['value'])?($_POST['search']['value']):null)>1) {
                $searchkey = $_POST['search']['value'];
                $searchkey = $this->m_reff->sanitize($searchkey);
				$query=array(
				"biro"=>$searchkey, 				 
				"kode"=>$searchkey, 				 
				 		 
				);
				$this->db->group_start()
                        ->or_like($query)
                ->group_end();
				
			}	
			
			
			$this->db->order_by("kode","asc");
			$query=$this->db->from("tr_biro");
		return $query;
			 
		
		 
	}
	
	public function count_biro()
	{				
			$this->_get_data_biro();
		return $this->db->get()->num_rows();
	}
    function insert_biro(){
        $form   = $this->input->post("f");
        if(!$form){return false;}
        $cek    = $this->cek_biro();
        if($cek){
            $var["gagal"]=true;
            $var["info"]="Kode sudah pernah diinput.";
            $var["token"]=$this->m_reff->getToken();
            return $var;
        }
        $this->db->set($form);
        $this->db->insert("tr_biro");
        $var["token"]=$this->m_reff->getToken();
        return $var;
    }
    function update_biro(){
        $form   = $this->input->post("f");
        if(!$form){return false;}
        $cek    = $this->cek_biro();
        if($cek){
            $var["gagal"]=true;
            $var["info"]="Kode sudah pernah diinput.";
            $var["token"]=$this->m_reff->getToken();
            return $var;
        }
        $id     = $this->m_reff->san($this->input->post("id")); 
        $this->db->where("id",$id);
        $this->db->set($form);
        $this->db->update("tr_biro");
        $var["token"]=$this->m_reff->getToken();
        return $var;
    }
    function cek_biro(){
        $this->db->where("kode",$this->m_reff->san($this->input->post("f[kode]")));
        $this->db->where("id!=",$this->m_reff->san($this->input->post("id")));
        return $this->db->get("tr_biro")->num_rows();
    }
    function hapus_biro(){
        $this->db->where("id",$this->m_reff->san($this->input->post("id")));
        $this->db->delete("tr_biro");
        $var["token"]=$this->m_reff->getToken();
        return $var;
    }
	

    function getDataPegawai(){
        $val    = $this->m_reff->san($this->input->post("val"));
                  $this->db->where("nik",$val);
                  $this->db->or_where("nip",$val);
                  $this->db->where("sts_akun",0);
        return    $this->db->get("data_pegawai")->row();
    }

}