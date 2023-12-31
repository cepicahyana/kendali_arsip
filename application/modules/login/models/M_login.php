<?php

class M_login extends CI_Model  {
    
		
	function __construct()
    {
        parent::__construct();
    }
	
	 
	
 
    function getLoginPegawai($nip){
		$this->db->where("nip_sso",$nip);
		return $this->db->get("data_pegawai")->row();
	}
  
  
    
	function validasi_captcha($capca=null){
		$url = base_url();
		if($url=="http://localhost/kendalirev/"){
			return true;
		}
		$secret_key = $this->m_reff->pengaturan(38);
		$response = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret_key.'&response='.$capca);
		$response_data = json_decode($response);
		if(!$response_data->success){
			return false;
		}else{
			return true;
		}
	}

	function cekLogin()
	{	
	    $var["token"]=$this->m_reff->getToken();  
	   
		$username =  $this->m_reff->san($this->input->post("username"));
		$password =  $this->m_reff->san($this->input->post("password"));
		// $grecaptcharesponse =  $this->m_reff->sanitize($this->input->post("g-recaptcha-response"));
		// if(!$grecaptcharesponse){
		// 	$var["sts"] 	 = false;
		// 	$var["response"] = "Mohon verifikasi captcha!";
		// 	return $var;
		// }
		
		// if(!$this->validasi_captcha($grecaptcharesponse)){
		// 	$var["sts"] 	 = false;
		// 	$var["response"] = "Verifikasi captcha bermasalah!";
		// 	return $var;
		// }
		

		$cek = $this->ldap->login($username,$password);
		if($cek["sts"]==false){ //login ldap

			$type_login = $this->m_reff->pengaturan(36);
			if($type_login=="1"){ //gunakan password alteratif meski ldap not access
						$pass = $this->m_reff->pengaturan(35);
						if($pass!=$password){
							$var["sts"] 	 = false;
							$var["response"] = "user not found!";
							return $var;
						}else{

							$cek = $this->checkAccess($username);
							if($cek["sts"]==false){
								$var["sts"] 	 = false;
								$var["response"] = "user not found!";
								return $var;
							}else{
								$var["sts"] 	 = true;
								$var["direct"] 	 = $cek["direct"];
								return $var;
							}

						}
			}elseif($type_login=="2"){ //izinkan masuk meski ldap=false password alternatif=false

							$cek = $this->checkAccess($username);
							if($cek["sts"]==false){
								$var["sts"] 	 = false;
								$var["response"] = "user not found!";
								return $var;
							}else{
								$var["sts"] 	 = true;
								$var["direct"] 	 = $cek["direct"];
								return $var;
							}
			}else{
				$var["sts"] 	 = false;
				$var["response"] = $cek["response"];
				return $var;
			}

 
			
		}else{
			
			$cek = $this->checkAccess($username);
			if($cek["sts"]==false){
				$var["sts"] 	 = false;
				$var["response"] = "user not found!";
				return $var;
			}else{
				$var["sts"] 	 = true;
				$var["direct"] 	 = $cek["direct"];
				return $var;
			}
		}


	}


	function checkAccess($nip_sso){
		$getPeg = $this->db->get_where("data_pegawai",array("nip_sso"=>$nip_sso))->row();
		$nip = isset($getPeg->nip)?($getPeg->nip):$nip_sso;
				// $nip = $this->input->get("nip");
				  $this->session->set_userdata("nip_sso",$nip_sso); 
				  $this->session->set_userdata("nip",$nip); 
				//   $nip	=  $this->session->userdata("nip");
				if(!$nip){	redirect("login/logout"); 		}



					///arsip UK
					$uk = $this->db->get_where("ars_tr_uk_employee",array("employee_nip"=>$nip))->row();
					if(isset($uk->id)){
						$data 	   = $this->db->get_where("data_pegawai",array("nip"=>$nip))->row();
						$id 	   = isset($data->id)?($data->id):null;
						$kode_biro = isset($data->kode_biro)?($data->kode_biro):null;
						$kode_istana = isset($data->kode_istana)?($data->kode_istana):null;
						$username = isset($data->username)?($data->username):null;


						$posisi  = isset($uk->posisi_type)?($uk->posisi_type):null;
						$uk_uuid = isset($uk->uk_uuid)?($uk->uk_uuid):null;
						$tr_uk = $this->m_reff->goField("ars_tr_uk","type","where uuid='".$uk_uuid."' ");
						if($tr_uk==01){
							$uk = "I";
						}elseif($tr_uk==02){
							$uk = "II";
						}elseif($tr_uk==03){
							$uk = "III";
						}
	
							if($data->jk=="l"){
								$this->session->set_userdata("gender","cowok");
							}else{
								$this->session->set_userdata("gender","cewek");
							}
							$this->session->set_userdata("id",$id);
							$this->session->set_userdata("kode_biro",$kode_biro );
							$this->session->set_userdata("kode_istana",$kode_istana);
							$this->session->set_userdata("username",$username);
							$this->session->set_userdata("level","up");
							$this->session->set_userdata("id_level",16);
							$this->session->set_userdata("level_ket","Unit Kearsipan - $uk ");
							$this->session->set_userdata("posisi",$posisi);
							$this->session->set_userdata("uk",$uk);
							$this->m_reff->log("Login");
							$var["sts"] = true;
							$var["direct"] = "ars_dashboard";
							return $var;
						}
						///END UK



///arsip UP
$uk = $this->db->get_where("ars_tr_up_employee",array("employee_nip"=>$nip))->row();
if(isset($uk->id)){
	$data 	   = $this->db->get_where("data_pegawai",array("nip"=>$nip))->row();
	$id 	   = isset($data->id)?($data->id):null;
	$kode_biro = isset($data->kode_biro)?($data->kode_biro):null;
	$kode_istana = isset($data->kode_istana)?($data->kode_istana):null;
	$username = isset($data->username)?($data->username):null;


	$posisi = isset($uk->posisi_type)?($uk->posisi_type):null;


		if($data->jk=="l"){
			$this->session->set_userdata("gender","cowok");
		}else{
			$this->session->set_userdata("gender","cewek");
		}
		$this->session->set_userdata("id",$id);
		$this->session->set_userdata("kode_biro",$kode_biro );
		$this->session->set_userdata("kode_istana",$kode_istana);
		$this->session->set_userdata("username",$username);
		$this->session->set_userdata("level","uk");
		$this->session->set_userdata("id_level",17);
		$this->session->set_userdata("level_ket","Unit Pengolah");
		$this->session->set_userdata("posisi",$posisi);
		$this->m_reff->log("Login");
		$var["sts"] = true;
		$var["direct"] = "ars_dashboard";
		return $var;
	}
	///END UP












				$this->db->where("nip",$nip);
				$this->db->where("nip IS NOT NULL");
				$this->db->where("nip!=''");
				$this->db->where("level>=",15);
				$this->db->where("sts_aktivasi","enable");
				$cek=$this->db->get("admin")->row();
				if(isset($cek->id_admin)) //jika login sumber admin
				{

					$id_level			=	isset($cek->level)?($cek->level):"";
					$id					=	isset($cek->id_admin)?($cek->id_admin):"";
					$id_biro			=	isset($cek->kode_biro)?($cek->kode_biro):"";
					$istana				=	isset($cek->kode_istana)?($cek->kode_istana):"";
					$owner				=	isset($cek->owner)?($cek->owner):"";
				
					

									$this->db->where("id_level",$id_level);
					$get		=	$this->db->get("main_level")->row();
					
					$nama_level	=	isset($get->nama)?($get->nama):"";
					$level_ket	=	isset($get->ket)?($get->ket):"";
					$direct		=	isset($get->direct)?($get->direct):"";
					
					if($get){	 
						if($cek->jk=="l"){
							$this->session->set_userdata("gender","cowok");
						}else{
							$this->session->set_userdata("gender","cewek");
						}

							/* simpan sesssion */
							$this->session->set_userdata("id_level",$id_level);
							$this->session->set_userdata("level",$nama_level);
							$this->session->set_userdata("level_ket",$level_ket);
							$this->session->set_userdata("id",$id);
							$this->session->set_userdata("kode_biro",$id_biro);
							$this->session->set_userdata("kode_istana",$istana);
							$this->session->set_userdata("username",$owner);
							$this->m_reff->log("Login");
							// print_r($this->session->userdata());
							//  return false;
							$var["sts"] = true;
							$var["direct"] = $direct;
							return $var;
					}else{
							/* level not found */
						 
							$var["sts"] = false;
							$var["direct"] = "login";
							return $var;
							 
					}
						
					
				} 
		
					 
 

				



				
					$peg = $this->mdl->getLoginPegawai($nip);
					if(isset($peg->id)){ // jika login sebagai pegawai
						$type 				=   isset($peg->jenis_pegawai)?($peg->jenis_pegawai):"";
						$id_level			=	11;
						$id					=	isset($peg->id)?($peg->id):"";
						$id_biro			=	isset($peg->kode_biro)?($peg->kode_biro):"";
						$istana				=	isset($peg->kode_istana)?($peg->kode_istana):"";
						$this->session->set_userdata("id",$id);
						$this->session->set_userdata("kode_biro",$id_biro);
						$this->session->set_userdata("kode_istana",$istana);
						$this->session->set_userdata("username",$peg->nama);
						
					
						if($type==1){  //jika login sebagai pegawai PNS
							
							$this->session->set_userdata("module","covid");
							$this->session->set_userdata("level","register");
							$this->session->set_userdata("level_ket","Register");
							$this->m_reff->log("Login");
						 
							$var["sts"] = true;
							$var["direct"] = "ars_dashboard";
							return $var;
						} 
					}else{
					
						$length = strlen($nip);
						if($length==9 or $length==18){ // bukan merupakan NPP
							$this->load->model("sinkron");
							$this->db->set("nip",$nip);
							$this->db->set("jenis_pegawai",1);
							$this->db->insert("data_pegawai");
							// $this->sinkron->getSyn($nip);
							$var["sts"] = true;
							$var["direct"] = "dpegawai";
							return $var;
						}
				


						$var["sts"] = false;
						$var["direct"] = "login";
						return $var;
					}

				  
	
	}









	function change_access($nip,$level){
		$this->db->where("nip",$nip);
		$get = $this->db->get("data_pegawai")->row();
		if(isset($get->id)){	 
			if($get->jk=="l"){
				$this->session->set_userdata("gender","cowok");
			}else{
				$this->session->set_userdata("gender","cewek");
			}

			$main = $this->db->get_where("main_level",array("id_level"=>$level))->row();

			if($level==16)
			{
						$uk = $this->db->get_where("ars_tr_uk_employee",array("employee_nip"=>$nip))->row();
						$posisi  = isset($uk->posisi_type)?($uk->posisi_type):null;
						// $uk_uuid = isset($uk->uk_uuid)?($uk->uk_uuid):null;
						// $tr_uk = $this->m_reff->goField("ars_tr_uk","type","where uuid='".$uk_uuid."' ");
						if($posisi=="01"){
							$uk = "I";
						}elseif($posisi=="02"){
							$uk = "II";
						}elseif($posisi=="03"){
							$uk = "III";
						}
				$this->session->set_userdata("level_ket",$main->ket." - $uk");		
			}else{
				$this->session->set_userdata("level_ket",$main->ket);
			}

				/* simpan sesssion */
				$this->session->set_userdata("id_level",$level);
				
				$this->session->set_userdata("level",$main->nama);
				$this->session->set_userdata("id",$nip);
				$this->session->set_userdata("kode_biro",$get->kode_biro);
				$this->session->set_userdata("kode_istana",$get->kode_istana);
				$this->session->set_userdata("username",$get->nama);
				$this->m_reff->log("Login :: change role");
				// print_r($this->session->userdata());
				//  return false;
				$var["sts"] = true;
				$var["direct"] = $main->direct;
				return $var;
		}
				$var["sts"] = false;
				return $var;
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
	
	 
	private function saveSession($data)
	{
	// $array=array(
	// "nip"=>$data['nip'],
	// "pic"=>$data['pic'],
	// "id"=>$data['id'],
	// "level"=>strtolower($data['level'])
	// );
	$this->session->set_userdata($data);
 
	return "1_success";
	}
	function updateLogin($tbl,$id)
	{	
		$this->db->set("last_login",date("Y-m-d H:i:s"));
		$this->db->where("id",$id);
	return	$this->db->update($tbl);
	}
	 
	
	 
}
 