<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller {

	

	function __construct()
	{
		parent::__construct();	
		$this->m_konfig->validasi_global();
		$this->load->model("Model","mdl");
		date_default_timezone_set('Asia/Jakarta');
	}
	 
	function _template($data)
	{
	$this->load->view('temp_main/main',$data);	
	}
	function user_ppnpn(){
		$index= "ppnpn";
		$ajax = $this->input->post("ajax");
		if($ajax=="yes")
		{
			$var["data"]=$this->load->view($index,TRUE);
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
		}else{
			$data['konten']=$index;
			$this->load->view('temp_main/main',$data);
		}
	}
	function pimpinan_pusat(){
		$index= "global";
		$ajax = $this->input->post("ajax");
		if($ajax=="yes")
		{
			$var["data"]=$this->load->view($index,TRUE);
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
		}else{
			$data['konten']=$index;
			$this->load->view('temp_main_pusat/main',$data);
		}
	}


	function index(){
		if($this->session->level=="rs"){
			return $this->rs();
		}
		if($this->session->level=="pimpinan_pusat"){
			return $this->pimpinan_pusat();
		}
		
		if($this->session->level=="ppnpn"){
			return $this->user_ppnpn();
		}

		if($this->session->level=="dokter"){
			return $this->dokter();
		}
				$index= "global";
				$ajax = $this->input->post("ajax");
				if($ajax=="yes")
				{
					$var["data"]=$this->load->view($index,TRUE);
					$var["token"]=$this->m_reff->getToken();
					echo json_encode($var);
				}else{
					$data['konten']=$index;
					$this->load->view('temp_main/main',$data);
				}
	}
	function data_profile(){
				$index= "global";
				$ajax = $this->input->post("ajax");
				if($ajax=="yes")
				{
					$var["data"]=$this->load->view($index,TRUE);
					$var["token"]=$this->m_reff->getToken();
					echo json_encode($var);
				}else{
					$data['konten']=$index;
					$this->load->view('temp_main_data/main',$data);
				}
	}
	 
	function info(){
				$index= "global";
				$ajax = $this->input->post("ajax");
				if($ajax=="yes")
				{
					$var["data"]=$this->load->view($index,TRUE);
					$var["token"]=$this->m_reff->getToken();
					echo json_encode($var);
				}else{
					$data['konten']=$index;
					$this->load->view('temp_admin_ppnpn/main',$data);
				}
	}
	function show(){
				$index= "global";
				$ajax = $this->input->post("ajax");
				if($ajax=="yes")
				{
					$var["data"]=$this->load->view($index,TRUE);
					$var["token"]=$this->m_reff->getToken();
					echo json_encode($var);
				}else{
					$data['konten']=$index;
					$this->load->view('temp_main_data/main',$data);
				}
	}
	function ppnpn(){
		
		if($this->session->level=="ppnpn"){
			return $this->user_ppnpn();
		}
				$index= "global";
				$ajax = $this->input->post("ajax");
				if($ajax=="yes")
				{
					$var["data"]=$this->load->view($index,TRUE);
					$var["token"]=$this->m_reff->getToken();
					echo json_encode($var);
				}else{
					$data['konten']=$index;
					$this->load->view('temp_admin_ppnpn/main',$data);
				}
	}
	 
	public function index_old()
	{	
		// $this->m_konfig->validasi_session(array("admin","pic"));
		$level=strtolower($this->session->userdata("level"));
		if($level=="pic_covid"){
			$index="pic_covid"; 
			$data['data']=$this->mdl->dataProfilePicCovid();
		}elseif($level=="pimpinan_covid"){
			$index="pimpinan_covid";
			$data['data']=$this->mdl->dataProfilePimpinanCovid();
		}elseif($level=="dokter"){
			$index="dokter"; 
			$data['data']=$this->mdl->dataProfileDok();
		}elseif($level=="kordokter"){
			$index="kordokter"; 
			$data['data']=$this->mdl->dataProfileKordokter();
		}elseif($level=="pegawai"){
			$index="pegawai";
			$data['data']=$this->mdl->dataProfilePegawai();
			$ajax=$this->input->get_post("ajax");
				if($ajax=="yes")
				{
					$var["data"]=$this->load->view($index,$data,TRUE);
					$var["token"]=$this->m_reff->getToken();
					echo json_encode($var);
				}else{
					$data['konten']=$index;
					$this->load->view('temp_main/main',$data);
				}
		}elseif($level=="admin_covid"){
			$data['data']=$this->mdl->dataProfileAdminCovid();
			$index="admin_covid";
			$ajax=$this->input->get_post("ajax");
				if($ajax=="yes")
				{
					$var["data"]=$this->load->view($index,$data,TRUE);
					$var["token"]=$this->m_reff->getToken();
					echo json_encode($var);
				}else{
					$data['konten']=$index;
					$this->load->view('temp_main/main',$data);
				}
		}elseif($level=="rs"){
			$index="rs";
			$data['data']=$this->mdl->dataProfileRs();
		}elseif($level=="super_admin"){
			$index="super_admin";
			$data['data']=$this->mdl->dataProfileSuperAdmin();
		} 
		
	}
	function rs(){
			$index="rs";
			$data['data']=$this->mdl->dataProfileRs();
			$ajax=$this->input->get_post("ajax");
				if($ajax=="yes")
				{
					$var["data"]=$this->load->view($index,$data,TRUE);
					$var["token"]=$this->m_reff->getToken();
					echo json_encode($var);
				}else{
					$data['konten']=$index;
					$this->load->view('temp_main/main',$data);
				}
	}
	 
	function dokter(){
			$index="dokter";
			$data['data']=$this->mdl->dataProfileDok();
			$ajax=$this->input->get_post("ajax");
				if($ajax=="yes")
				{
					$var["data"]=$this->load->view($index,$data,TRUE);
					$var["token"]=$this->m_reff->getToken();
					echo json_encode($var);
				}else{
					$data['konten']=$index;
					$this->load->view('temp_main/main',$data);
				}
	}
	 
	 

}