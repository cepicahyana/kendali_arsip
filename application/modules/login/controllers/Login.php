<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends MY_Controller {

	

	function __construct()
	{
		parent::__construct();	
			$this->load->model('M_login','mdl');
			$this->load->library('Ldap','ldap');
		date_default_timezone_set('Asia/Jakarta');
	}
	function sescaptcha($captcha)
	{
	$this->session->set_userdata(array("captcha"=>$captcha));
	}
	 function captcha()
	{
	$captcha=substr(str_shuffle("123456789"),0,5); // string yg akan diacak membentuk captcha 0-z dan sebanyak 6 karakter
	$this->sescaptcha($captcha);
	$gambar=ImageCreate(50,25); // ukuran kotak width=60 dan height=20
	$wk=ImageColorAllocate($gambar, 255, 255, 255); // membuat warna kotak -> Navajo White
	$wt=ImageColorAllocate($gambar, 71, 153, 153); // membuat warna tulisan -> Putih
	ImageFilledRectangle($gambar, 190, 776, 50, 120, $wk);
	ImageString($gambar, 10, 1, 3, $captcha, $wt);
	return ImageJPEG($gambar);
	}
	function _template($data)
	{
		//	$this->load->view('temp_login/main',$data);
	}
	function cek()
	{
	   echo sprintf("%05s", 4341);
	}
	public function logout()
	{
		 $this->session->sess_destroy();
		$this->load->view("logout");
		 redirect("login");
		
	}

	function index(){
		// if($this->m_reff->mobile()){
		// 	$this->load->view("mobile");
		// }else{
			$this->load->view("login");
		// }
		
	}

 




	private function index_()
	{	 
		$nip = $this->input->get("nip");
		if(!$nip){ return $this->m_reff->page403();}
	// return $this->load->view("index");
	// return false;
			     // $nip	= "pic protokol covid"; 
				//   $nip  = "11";  //pegawai
				 // $nip  = "rs1";  //rumah sakit
				//$nip = "dokter1";
			//	$nip = 44; //ppnpn
				// $nip = "admin ppnpn";
				//  $nip = "pic ppnpn";
				  $this->session->set_userdata("nip",$nip); 
				  $nip	=  $this->session->userdata("nip");
				if(!$nip){	redirect("login/logout"); 		}
				$this->db->where("nip",$nip);
				$this->db->where("nip IS NOT NULL");
				$this->db->where("nip!=''");
				$this->db->where("level>=",16);
				$this->db->where("sts_aktivasi","enable");
				$cek=$this->db->get("admin")->row();
				if(isset($cek->id_admin)) //jika login sumber admin
				{

					$id_level			=	isset($cek->level)?($cek->level):"";
					$id					=	isset($cek->id_admin)?($cek->id_admin):"";
					$id_biro			=	isset($cek->kode_biro)?($cek->kode_biro):"";
					$istana				=	isset($cek->istana)?($cek->istana):"";
					$owner				=	isset($cek->owner)?($cek->owner):"";
					

									$this->db->where("id_level",$id_level);
					$get		=	$this->db->get("main_level")->row();
					
					$nama_level	=	isset($get->nama)?($get->nama):"";
					$direct		=	isset($get->direct)?($get->direct):"";
					
					if($get){	 
							/* simpan sesssion */
							$this->session->set_userdata("level",$nama_level);
							$this->session->set_userdata("id",$id);
							$this->session->set_userdata("kode_biro",$id_biro);
							$this->session->set_userdata("istana",$istana);
							$this->session->set_userdata("username",$owner);
							$this->m_reff->log("Login");
							// print_r($this->session->userdata());
							//  return false;
							redirect($direct);
					}else{
							/* level not found */
							echo $this->m_reff->page405();	return false;
					}
						
					
				} 
		
					$rs = $this->mdl->getLoginRs($nip);
					if(isset($rs->id)){ //jika loin sebagai RS
						$type 				=   isset($rs->jenis_pegawai)?($rs->jenis_pegawai):"";
						$id_level			=	8;
						$id					=	isset($rs->id)?($rs->id):"";
						$istana				=	isset($rs->istana)?($rs->istana):"";
						$this->session->set_userdata("id",$id);
						$this->session->set_userdata("kode_biro",$id_biro);
						$this->session->set_userdata("istana",$istana);
						$this->session->set_userdata("username",$rs->nama);
						$this->session->set_userdata("module","covid");
						$this->m_reff->log("Login");
						$this->session->set_userdata("level","rs");
						redirect("data_test");	 
					}


					$dr = $this->mdl->getLoginDokter($nip);
					if(isset($dr->id)){ //jika loin sebagai Dokter
						$id_level			=	9;
						$id					=	isset($dr->id)?($dr->id):"";
						$istana				=	isset($dr->istana)?($dr->istana):"";
						$this->session->set_userdata("id",$id);
						$this->session->set_userdata("istana",$istana);
						$this->session->set_userdata("username",$dr->nama);
						$this->session->set_userdata("module","covid");
						$this->m_reff->log("Login");
						$this->session->set_userdata("level","dokter");
						redirect("dokter");	 
					}

					$dr = $this->mdl->getLoginKorDokter($nip);
					if(isset($dr->id)){ //jika loin sebagai Dokter
						$id_level			=	10;
						$id					=	isset($dr->id)?($dr->id):"";
						$istana				=	isset($dr->istana)?($dr->istana):"";
						$this->session->set_userdata("id",$id);
						$this->session->set_userdata("istana",$istana);
						$this->session->set_userdata("username",$dr->nama);
						$this->session->set_userdata("module","covid");
						$this->m_reff->log("Login");
						$this->session->set_userdata("level","kordokter");
						redirect("kordokter");	 
					}


				
					$peg = $this->mdl->getLoginPegawai($nip);
					if(isset($peg->id)){ // jika login sebagai pegawai
						$type 				=   isset($peg->jenis_pegawai)?($peg->jenis_pegawai):"";
						$id_level			=	11;
						$id					=	isset($peg->id)?($peg->id):"";
						$id_biro			=	isset($peg->kode_biro)?($peg->kode_biro):"";
						$istana				=	isset($peg->istana)?($peg->istana):"";
						$this->session->set_userdata("id",$id);
						$this->session->set_userdata("kode_biro",$id_biro);
						$this->session->set_userdata("istana",$istana);
						$this->session->set_userdata("username",$peg->owner);
						
					
						if($type==1){  //jika login sebagai pegawai PNS
							$this->session->set_userdata("module","covid");
							$this->session->set_userdata("level","pegawai");
							$this->m_reff->log("Login");
							redirect("dpegawai");
						}elseif($type==2){  //jika login sebagai PPNPN
							$this->session->set_userdata("module","covid");
							$this->session->set_userdata("level","ppnpn");
							$this->m_reff->log("ppnpn"); 
							redirect("portal");
						}
					}


					// }else{
						echo $this->m_reff->page405();	return false;
					// }
		
			
	
	
	}
	 
	 
	function cekLogin()
	{
		$cek = $this->input->post('username');
		if(!$cek){ return $this->m_reff->page403();}
		$hasil=$this->mdl->cekLogin();
		echo json_encode($hasil);
	}
	function cekAcara()
	{
		$hasil=$this->mdl->cekAcara();
		echo json_encode($hasil);
	}
	 
	function pilih(){
		echo $this->load->view("login_pilih");
	}
	 
  
}

