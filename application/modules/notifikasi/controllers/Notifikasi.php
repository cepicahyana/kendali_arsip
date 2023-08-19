<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notifikasi extends MY_Controller {

	

	function __construct()
	{
		parent::__construct();	
		$this->m_konfig->validasi_session(array("pic_covid","admin_covid","super_admin"));
		$this->load->model("Model","mdl");
		date_default_timezone_set('Asia/Jakarta');
	}
	 
	function _template($data)
	{
		$this->load->view('temp_main/main',$data);	
	}
	 
	 
	public function index()
	{	
		$index="index"; 
		$ajax=$this->input->get_post("ajax");
		if($ajax=="yes")
		{
			$var["data"]=$this->load->view($index);
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
		}else{
			$data['konten']=$index;
			$this->_template($data);
		}
	}

	public function aproval_tes()
	{	
		$index="aproval_tes"; 
		$ajax=$this->input->get_post("ajax");
		if($ajax=="yes")
		{
			$var["data"]=$this->load->view($index);
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
		}else{
			$data['konten']=$index;
			$this->_template($data);
		}
		
	}
	public function aproval_external()
	{	
		$index="aproval_external"; 
		$ajax=$this->input->get_post("ajax");
		if($ajax=="yes")
		{
			$var["data"]=$this->load->view($index);
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
		}else{
			$data['konten']=$index;
			$this->_template($data);
		}
		
	}
	public function hasil_external()
	{	
		$index="hasil_external"; 
		$ajax=$this->input->get_post("ajax");
		if($ajax=="yes")
		{
			$var["data"]=$this->load->view($index);
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
		}else{
			$data['konten']=$index;
			$this->_template($data);
		}
		
	}

	public function akun_wa()
	{	
		$index="akun_wa"; 
		$ajax=$this->input->get_post("ajax");
		if($ajax=="yes")
		{
			$var["data"]=$this->load->view($index);
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
		}else{
			$data['konten']=$index;
			$this->_template($data);
		}
		
	}

	public function akun_email()
	{	
		$index="akun_email"; 
		$ajax=$this->input->get_post("ajax");
		if($ajax=="yes")
		{
			$var["data"]=$this->load->view($index);
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
		}else{
			$data['konten']=$index;
			$this->_template($data);
		}
		
	}

	function update()
	{
		$f=$this->input->post("f");
		if(!$f){ return $this->m_reff->page403();}

		$this->mdl->update(); 
		// $data["data"] = $data;
		$data["token"] = $this->m_reff->getToken();
		echo json_encode($data);
	}

	function updateText()
	{
		$val = $this->input->post("val");
		if(!$val){ return $this->m_reff->page403();}
	  
		$this->mdl->updateText(); 
		// $data["data"] = $data;
		$data["token"] = $this->m_reff->getToken();
		echo json_encode($data);
	}

 
	 
	 
}