<?php

class Model_pegawai extends CI_Model  {
    
 
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
				"nama"=>$searchkey, 				 		 
				"nip"=>$searchkey, 				 
				"email"=>$searchkey, 				 				 
				 		 
				);
				$this->db->group_start()
                        ->or_like($query)
                ->group_end();
				
			}	
			
			
			$this->db->order_by("nama","asc");
			 
			$query=$this->db->from("data_pegawai");
		return $query;
			 
		
		 
	}
	
	public function count()
	{				
			$this->_get_data();
		return $this->db->get()->num_rows();
	}
    function insert(){

                $notif = $this->m_reff->san($this->input->post("notif"));
                if($notif=="ya"){
                    $email = $this->m_reff->san($this->input->post("email"));
                    $hp    = $this->m_reff->san($this->input->post("hp"));

                    $this->kirim_notif_wa($hp);
                    $this->kirim_notif_email($email);
                }

                $id  =   $this->m_reff->san($this->input->post("id"));
                
                $this->db->where("id",$id);
      return    $this->db->update("data_pegawai");
    }
    function kirim_notif_wa($hp){
        $msg = "Informasi pendaftaran akun PIC, mohon cek email untuk akses login aplikasi monitoring covid sebagai PIC.";
        $this->m_reff->kirimWa($hp,$msg);
    }
    function kirim_notif_email($email){
        $msg = "Akun anda telah terdaftar sebagai akun PIC <br>
        untuk akses masuk aplikasi silahkan login di www.monvid.com/login  ";
        $this->m_reff->kirimEmail($email,"Pendaftaran akun PIC",$msg);
    }
    
    function update(){
        $form   = $this->input->post("f");
        if(!$form){   return false;  }

        $cek    = $this->cek();
        if($cek){
            $var["gagal"]=true;
            $var["info"]="Kode sudah pernah diinput.";
            return $var;
        }


        if($this->input->post("password")){

            if($this->input->post("password")!=$this->input->post("c_password")) 
            {
                $var["gagal"]=true;
                $var["info"]="Ketik ulang password tidak sama";
                return $var;
            }

            $cek    = $this->cek_pass();
            if($cek){
                $var["gagal"]=true;
                $var["info"]="username/password sudah digunakan.";
                return $var;
            }else{
                $this->db->set("password",md5($this->input->post("password")));
            }
        }





        $id     = $this->m_reff->san($this->input->post("id")); 
        $this->db->where("id",$id);
        $this->db->set($form);
      return  $this->db->update("data_pegawai");
    }
    function cek(){
        $this->db->where("kode",$this->m_reff->san($this->input->post("f[kode]")));
        $this->db->where("id!=",$this->m_reff->san($this->input->post("id")));
        return $this->db->get("data_pegawai")->num_rows();
    }
    function cek_pass(){
        $this->db->where("username",$this->m_reff->san($this->input->post("f[username]")));
        $this->db->where("password",md5($this->m_reff->san($this->input->post("password"))));
        $this->db->where("id!=",$this->m_reff->san($this->input->post("id")));
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
        $res = $this->db->get("tm_rs")->num_rows();
        if($res){
            return 1;
        }

        return 0;
 
    }
    function hapus(){
        $this->db->where("id",$this->m_reff->san($this->input->post("id")));
        $this->db->set("sts_akun",0);
        return $this->db->update("data_pegawai");
    }
	
}