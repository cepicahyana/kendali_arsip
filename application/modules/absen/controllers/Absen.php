<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class absen extends MX_Controller 
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


 
}
