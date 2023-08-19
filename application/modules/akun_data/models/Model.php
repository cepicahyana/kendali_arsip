<?php

class Model extends CI_Model  {
    
	var $tbl="admin";
 
 	function __construct()
    {
        parent::__construct();
    }

    function get_data_admin()
	{
        $this->_get_data_admin();
		if($this->m_reff->san($this->input->post("length")!=-1)) 
		$this->db->limit($this->m_reff->san($this->input->post("length")),$this->m_reff->san($this->input->post("start")));
	 	return $this->db->get()->result();
		 
	}
	function _get_data_admin()
	{
		if(isset($_POST['search']['value'])?($_POST['search']['value']):""){
			$searchkey=$_POST['search']['value']; 
            $searchkey=$this->m_reff->san($searchkey);
				$query=array(
				"owner"=>$searchkey				 
				 		 
				);
				$this->db->group_start()
                        ->or_like($query)
                ->group_end();
				
			}	
			
			$this->db->where("level", 3);
			$this->db->order_by("owner","asc");
			$query=$this->db->from("admin");
		return $query;
	}
	
	public function count_data_admin()
	{				
        $this->_get_data_admin();
		return $this->db->get()->num_rows();
	}
    function get_data_superadmin()
	{
        $this->_get_data_superadmin();
		if($this->m_reff->san($this->input->post("length")!=-1)) 
		$this->db->limit($this->m_reff->san($this->input->post("length")),$this->m_reff->san($this->input->post("start")));
	 	return $this->db->get()->result();
		 
	}
	function _get_data_superadmin()
	{
		if(isset($_POST['search']['value'])?($_POST['search']['value']):""){
			$searchkey=$_POST['search']['value']; 
            $searchkey=$this->m_reff->san($searchkey);
				$query=array(
				"owner"=>$searchkey				 
				 		 
				);
				$this->db->group_start()
                        ->or_like($query)
                ->group_end();
				
			}	
			
			$this->db->where("level", 2);
			$this->db->order_by("owner","asc");
			$query=$this->db->from("admin");
		return $query;
	}
	
	public function count_data_superadmin()
	{				
        $this->_get_data_superadmin();
		return $this->db->get()->num_rows();
	}

    function insert_akun_admin(){
        $form = $this->input->post("f");
        $cek    = $this->cek(3);
        if($cek){
            $var["gagal"]=true;
            $var["info"]="NIP sudah diinput.";
            $var["token"]=$this->m_reff->getToken();
            return $var;
        }

        $this->db->set($form);
        $this->db->set("level",3);
        $this->db->insert("admin");
        $var["token"]=$this->m_reff->getToken();
        return $var;
    }

    function insert_akun_superadmin(){
        $form = $this->input->post("f");
        $cek    = $this->cek(2);
        if($cek){
            $var["gagal"]=true;
            $var["info"]="NIP sudah diinput.";
            $var["token"]=$this->m_reff->getToken();
            return $var;
        }

        $this->db->set($form);
        $this->db->set("level",2);
        $this->db->insert("admin");
        $var["token"]=$this->m_reff->getToken();
        return $var;
    }

    function cek($lvl){
        $this->db->where("nip",$this->m_reff->san($this->input->post("f[nip]")));
        $this->db->where("level",$lvl);
        $this->db->where("id_admin!=",$this->m_reff->san($this->input->post("id")));
        return $this->db->get("admin")->num_rows();
    }

    function update_akun_admin(){
        $form   = $this->input->post("f");
        $cek    = $this->cek(3);
        if($cek){
            $var["gagal"]=true;
            $var["info"]="NIP sudah digunakan.";
            return $var;
        }

        $id = $this->m_reff->san($this->input->post("id")); 
        $this->db->where("id_admin",$id);
        $this->db->set($form);
        $this->db->update('admin');
        $var["token"]=$this->m_reff->getToken();
      return $var;
    }

    function update_akun_superadmin(){
        $form   = $this->input->post("f");
        $cek    = $this->cek(2);
        if($cek){
            $var["gagal"]=true;
            $var["info"]="NIP sudah digunakan.";
            return $var;
        }

        $id = $this->m_reff->san($this->input->post("id")); 
        $this->db->where("id_admin",$id);
        $this->db->set($form);
        $this->db->update('admin');
        $var["token"]=$this->m_reff->getToken();
      return $var;
    }

    function hapus_akun_admin(){
        $this->db->where("id_admin",$this->m_reff->san($this->input->post("id")));
        $this->db->delete("admin");
        $var["token"]=$this->m_reff->getToken();
        return $var;
    }
    function hapus_akun_superadmin(){
        $this->db->where("id_admin",$this->m_reff->san($this->input->post("id")));
        $this->db->delete("admin");
        $var["token"]=$this->m_reff->getToken();
        return $var;
    }
}