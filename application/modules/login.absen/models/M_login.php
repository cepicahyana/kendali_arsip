<?php

class M_login extends CI_Model  {
    
		
	function __construct()
    {
        parent::__construct();
    }
	
	 
	
 
    function getLoginPegawai($nip){
		$this->db->where("nip",$nip);
		return $this->db->get("data_pegawai")->row();
	}
  
	function cek_loggin_google($data){
		$username = isset($data->username)?($data->username):null;
		$password = isset($data->password)?($data->password):null;
		return $this->cekLogin($username,$password);
	}
	function cekLogin($username=null,$password=null)
	{	
		if(!$username){
			$username = $this->input->post("username");
		}
		if(!$password){
			$password = md5($this->input->post("password"));
		}

	    $var["token"]=$this->m_reff->getToken();  
		$username =  $this->m_reff->san($username);
		$password =  $this->m_reff->san($password);
		if(!$username or !$password){
			$var["sts"] 	 = false;
			$var["response"] = "Kolom Username dan password wajib diisi!";
			return $var;
		}
			$cek = $this->checkAccess($username,$password);
			if($cek["sts"]==false){
				$var["sts"] 	 = false;
				$var["response"] = $cek["response"];
			}else{
				$var["sts"] 	 = true;
				$var["direct"] 	 = $cek["direct"];
			}
			return $var;
	}


	function checkAccess($username,$password){ 
				$this->db->where("username",$username);
				$this->db->where("password",$password);
				$cek=$this->db->get("data_pegawai")->row();
				if(isset($cek->id)) //jika login sumber admin
				{
					$stspeg = isset($cek->sts_keaktifan)?($cek->sts_keaktifan):null;
					if(strtolower($stspeg)!="aktif"){
						$var["sts"] = false;
						$var["response"] = "Akun non-aktif!";
						return $var;
					}

					$id_level			=	isset($cek->id_level)?($cek->id_level):"";
					$id					=	isset($cek->id)?($cek->id):"";
					$nama				=	isset($cek->nama)?($cek->nama):"";
					$nik				=	isset($cek->nik)?($cek->nik):"";
					$tempat_tugas		=	isset($cek->tempat_tugas)?($cek->tempat_tugas):"";
					$count = strlen($tempat_tugas); 
					if($count==4){
						$this->session->set_userdata("wilayah",1);
						$db  = $this->db->get("kabupaten")->row();
						$wil = isset($db->nama)?($db->nama):null;
						$this->session->set_userdata("nama_wilayah",$wil);
					}elseif($count==6){
						$this->session->set_userdata("wilayah",2);
						$db  = $this->db->get("kecamatan")->row();
						$wil = isset($db->nama)?($db->nama):null;
						$this->session->set_userdata("nama_wilayah",$wil);
					}elseif($count==10){
						$this->session->set_userdata("wilayah",3);
						$db  = $this->db->get("kelurahan")->row();
						$wil = isset($db->nama)?($db->nama):null;
						$this->session->set_userdata("nama_wilayah",$wil);
					}else{
						$this->session->set_userdata("wilayah",0);
						$db  = $this->db->get("kabupaten")->row();
						$wil = isset($db->nama)?($db->nama):null;
						$this->session->set_userdata("nama_wilayah",$wil);
					}
					 
					

									$this->db->where("id_level",$id_level);
					$get		=	$this->db->get("main_level")->row();
					
					$nama_level	=	isset($get->nama)?($get->nama):"";
					$direct		=	isset($get->direct)?($get->direct):"";
					
					if(isset($get)){	 
							/* simpan sesssion */
							$this->session->set_userdata("level",$nama_level);
							$this->session->set_userdata("id",$id);
							$this->session->set_userdata("nik",$nik);
							$this->session->set_userdata("nama",$nama);
							$this->session->set_userdata("tempat_tugas",$tempat_tugas);
							 
							$this->m_reff->log("Login");
							$var["sts"] = true;
							$var["direct"] = $direct;
							return $var;
					}else{
							/* level not found */
							$var["sts"] = false;
							$var["response"] = "hak akses tidak ditemukan!";
							return $var;
							 
					}
						
					
				}else{
					$var["sts"] = false;
					$var["response"] = "Username/password salah!";
					return $var;
				}
				  
	
	}













	
	 
	 
	function getDataLevel($id)//id_level
	{
	$this->db->where("id_level",$id);
	$data=$this->db->get("main_level")->row();
	return strtolower($data->nama);
	}
	function getDataLevelJabatan($id)//id_level
	{
	$this->db->where("id",$id);
	$data=$this->db->get("tr_jabatan")->row();
	return $data->nama;
	}
	
	
	function direct($nama)
	{
		 $this->db->where("nama",$nama);
	   $return=$this->db->get("main_level")->row();
	return isset($return->direct)?($return->direct):"dashboard";
	}
	
	 
	 function saveSession($data)
	{
	return $this->session->set_userdata($data);
	}


	function updateLogin($tbl,$id)
	{	
		$this->db->set("last_login",date("Y-m-d H:i:s"));
		$this->db->where("id",$id);
	return	$this->db->update($tbl);
	}
	 
	
	 
}
 