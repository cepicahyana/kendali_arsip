<?php

class Model_pimpinan extends CI_Model  {

    function get_data_pimpinan()
	{
        $this->_get_data_pimpinan();
		if($this->input->post("length")!=-1) 
		$this->db->limit($this->input->post("length"),$this->input->post("start"));
	 	return $this->db->get()->result();
		 
	}
	function _get_data_pimpinan()
	{
        if (strlen(isset($_POST['search']['value'])?($_POST['search']['value']):null)>1) {
            $searchkey=$_POST['search']['value']; 
            $searchkey = $this->m_reff->sanitize($searchkey);
				$query=array(
				"owner"=>$searchkey				 
				 		 
				);
				$this->db->group_start()
                        ->or_like($query)
                ->group_end();
				
			}	
			
			$this->db->where("level", 12);
			$this->db->order_by("owner","asc");
			$query=$this->db->from("admin");
		return $query;
	}
	
	public function count_data_pimpinan()
	{				
        $this->_get_data_pimpinan();
		return $this->db->get()->num_rows();
	}

    function insert_akun_pimpinan(){
        $form = $this->input->post("f");
        $cek    = $this->cek();
        if($cek){
            $var["gagal"]=true;
            $var["info"]="NIP sudah diinput.";
            $var["token"]=$this->m_reff->getToken();
            return $var;
        }

        $this->db->set($form);
        $this->db->set("level",12);
        $this->db->insert("admin");
        $var["token"]=$this->m_reff->getToken();
        return $var;
    }

    function cek(){
        $this->db->where("nip",$this->input->post("f[nip]"));
        $this->db->where("level",12);
        $this->db->where("id_admin!=",$this->input->post("id"));
        return $this->db->get("admin")->num_rows();
    }

    function update_akun_pimpinan(){
        $form   = $this->input->post("f");
        $id     = $this->input->post("id");
        $cek    = false;//$this->cek();
        if($cek){
            $var["gagal"]=true;
            $var["info"]="NIP sudah digunakan.";
            return $var;
        }

        $id = $this->input->post("id"); 
        $this->db->where("id_admin",$id);
        $this->db->set($form);
        $this->db->update('admin');
        $var["token"]=$this->m_reff->getToken();
      return $var;
    }

    function hapus_akun_pimpinan(){
        $this->db->where("id_admin",$this->input->post("id"));
        $this->db->delete("admin");
        $var["token"]=$this->m_reff->getToken();
        return $var;
    }
}