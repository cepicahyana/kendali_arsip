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
	 

/*======= DATATABLE TINGKAT PERKEMBANGAN=========*/
	function getData_tingkaPerkembangan()
	{
		 $this->_getData_tingkaPerkembangan();
		if($this->m_reff->san($this->input->post("length")!=-1)) 
		$this->db->limit($this->m_reff->san($this->input->post("length")),$this->m_reff->san($this->input->post("start")));
	 	return $this->db->get()->result();
		 
	}
	function _getData_tingkaPerkembangan()
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
		$query=$this->db->from("ars_tr_tingkat_perkembangan");
		return $query;
	}
	
	public function count_tingkaPerkembangan()
	{				
			$this->_getData_tingkaPerkembangan();
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
    /*======= DATATABLE TINGKAT PERKEMBANGAN=========*/
     
    function update_tingkat_perkembangan(){
        $id = $this->input->post("id");
        $form = $this->input->post("f");
        $this->db->set($form);
        if($id){
            $this->db->set("_uid",$this->session->userdata("nip"));
            $this->db->set("_utime",date('Y-m-d H:i:s'));
            $this->db->where("id",$id);
            $this->db->update("ars_tr_tingkat_perkembangan");
            $this->m_reff->log("update data tingkat perkembangan");
        }else{
            $this->db->set("_cid",$this->session->userdata("nip"));
            $this->db->set("_ctime",date('Y-m-d H:i:s'));
            $this->db->insert("ars_tr_tingkat_perkembangan");
            $this->m_reff->log("menambahkan data tingkat perkembangan");
        }
        return true;
    }

    function hapus_tingkat_perkambangan(){
        $id = $this->input->post("id");
        $this->db->where("id",$id);
        return $this->db->delete("ars_tr_tingkat_perkembangan");
    }
}