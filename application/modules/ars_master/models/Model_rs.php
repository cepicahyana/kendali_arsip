<?php

class Model_rs extends CI_Model  {
    
 
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
				"alamat"=>$searchkey, 				 
				"email"=>$searchkey, 				 
				"telp"=>$searchkey, 				 
				 		 
				);
				$this->db->group_start()
                        ->or_like($query)
                ->group_end();
				
			}	
			
			
			$this->db->order_by("kode","asc");
			$query=$this->db->from("tm_rs");
		return $query;
			 
		
		 
	}

    function getIstana($id){
        $this->db->where('id', $id);
        $this->db->from('tr_istana');
    return $this->db->get()->row();
    }
	
	public function count()
	{				
			$this->_get_data();
		return $this->db->get()->num_rows();
	}
    function insert(){
        $form   = $this->input->post("f");
        if(!$form){return false;}

        if($this->m_reff->san($this->input->post("password"))){


            if($this->m_reff->san($this->input->post("password"))!=$this->m_reff->san($this->input->post("c_password"))) 
            {
                $var["gagal"]=true;
                $var["info"]="Ketik ulang password tidak sama";
                $var["token"]=$this->m_reff->getToken();
                return $var;
            }

            $cek    = $this->cek_pass();
            if($cek){
                $var["gagal"]=true;
                $var["info"]="username/password sudah digunakan.";
                $var["token"]=$this->m_reff->getToken();
                return $var;
            }else{
                $this->db->set("password",md5($this->m_reff->san($this->input->post("password"))));
            }
        }
        $cek    = $this->cek();
        if($cek){
            $var["gagal"]=true;
            $var["info"]="Kode sudah pernah diinput.";
            $var["token"]=$this->m_reff->getToken();
            return $var;
        }
        

        $this->db->set($form);
        // $this->db->set("nip",$this->input->post("f[kode]"));
        $this->db->insert("tm_rs");
        $var["token"]=$this->m_reff->getToken();
        return $var;
    }

    function update(){
        $form   = $this->input->post("f");
        if(!$form){return false;}
        
        $cek    = $this->cek();
        if($cek){
            $var["gagal"]=true;
            $var["info"]="username sudah pernah diinput.";
            $var["token"]=$this->m_reff->getToken();
            return $var;
        }


        if($this->m_reff->san($this->input->post("password"))){


            if($this->m_reff->san($this->input->post("password"))!=$this->m_reff->san($this->input->post("c_password"))) 
            {
                $var["gagal"]=true;
                $var["info"]="Ketik ulang password tidak sama";
                return $var;
            }

            $cek    = $this->cek_pass();
            if($cek){
                $var["gagal"]=true;
                $var["info"]="username/password sudah digunakan.";
                $var["token"]=$this->m_reff->getToken();
                return $var;
            }else{
                $this->db->set("password",md5($this->m_reff->san($this->input->post("password"))));
            }
        }





        $id = $this->m_reff->san($this->input->post("id")); 
        $this->db->where("id",$id);
        $this->db->set($form);
        // $this->db->set("nip",$this->input->post("f[kode]"));
        $this->db->update("tm_rs");
        $var["token"]=$this->m_reff->getToken();
        return $var;
    }
    function cek(){
        $this->db->where("kode",$this->m_reff->san($this->input->post("f[kode]")));
        $this->db->where("id!=",$this->m_reff->san($this->input->post("id")));
        return $this->db->get("tm_rs")->num_rows();
    }
    function cek_pass(){
         
        $this->db->where("username",$this->m_reff->san($this->input->post("f[username]")));
        $this->db->where("password",md5($this->m_reff->san($this->input->post("password"))));
        $res = $this->db->get("data_pegawai")->num_rows();
        if($res){
            return 1;
        }

        $this->db->where("username",$this->m_reff->san($this->input->post("f[username]")));
        $this->db->where("password",md5($this->m_reff->san($this->input->post("password"))));
        $res = $this->db->get("admin")->num_rows();
        if($res){
            return 1;
        }

        $this->db->where("username",$this->m_reff->san($this->input->post("f[username]")));
        $this->db->where("password",md5($this->m_reff->san($this->input->post("password"))));
        $this->db->where("id!=",$this->m_reff->san($this->input->post("id")));
        $res = $this->db->get("tm_rs")->num_rows();
        if($res){
            return 1;
        }

        return 0;

        
    }
    function hapus(){
        $this->db->where("id",$this->m_reff->san($this->input->post("id")));
         $this->db->delete("tm_rs");
         $var["token"]=$this->m_reff->getToken();
         return $var;
    }
	
}