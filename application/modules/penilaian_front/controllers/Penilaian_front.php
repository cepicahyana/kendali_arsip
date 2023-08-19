<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class penilaian_front extends MX_Controller 
{
	public function __construct()
	{
		parent::__construct();	
		$this->m_konfig->validasi_session(array("super","alumni"));
		$this->load->model("model","mdl");
		date_default_timezone_set('Asia/Jakarta');
	}
	 
	function _template($data)
	{
		// $this->m_reff->cekKelengkapan();
		$this->load->view('temp_ppnpn/main',$data);	
	}
	public function index()
	{ 	 
		$data['konten']="index";
		$this->_template($data);
	}
	function detailPenilaian(){
		$var["data"] = $this->load->view("detailPenilaian",null,true);
		$var["token"] = $this->m_reff->getToken();
		echo json_encode($var);
 	}
 	function info_detail(){
		$id=$this->input->post('id');
		if(!$id){ return $this->m_reff->page403();}
		$var["data"] = $this->load->view("infodet",null,true);
		$var["token"] = $this->m_reff->getToken();
		echo json_encode($var);
	}


 
}
