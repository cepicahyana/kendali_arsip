<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Akun_wa extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->m_konfig->validasi_session(array("admin_ppnpn", "pic_ppnpn","super_admin"));
		$this->load->model("model", "mdl");
		date_default_timezone_set('Asia/Jakarta');
	}

	function _template($data)
	{
		$this->load->view('temp_admin_ppnpn/main', $data);
	}

    public function index()
	{
		$ajax = $this->input->get_post("ajax");
		if ($ajax == "yes") {
	 
			$data['jp'] = $this->mdl->getJp();
		 
			$data['header'] = "Akun WhatsApp";
			$var["data"]=$this->load->view("index",$data,TRUE);
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
		} else {
		 
			$data['jp'] = $this->mdl->getJp();
			 
			$data['header'] = "Akun WhatsApp";
			$data['konten'] = "index";
			$this->_template($data);
		}
	}

	function updateText(){
		$this->m_reff->log("update link api teks","ppnpn");
		$f=$this->m_reff->san($this->input->post("text"));
		if(!$f){ return $this->m_reff->page403();}

		$this->mdl->updateText();
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}

	function updateImage(){
		$this->m_reff->log("update link api image","ppnpn");
		$f=$this->m_reff->san($this->input->post("image"));
		if(!$f){ return $this->m_reff->page403();}
		
		$this->mdl->updateImage();
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}
 
	function updateKey(){
		$this->m_reff->log("update key api wa","ppnpn");
		$f=$this->m_reff->san($this->input->post("key"));
		if(!$f){ return $this->m_reff->page403();}
		
		$this->mdl->updateKey();
		$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
	}
}