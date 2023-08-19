<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Monitor extends MX_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->m_konfig->validasi_session(array("super_admin","pimpinan_ppnpn", "admin_ppnpn", "pic_ppnpn", "pimpinan_pusat"));
		$this->load->model("model", "mdl");
		date_default_timezone_set('Asia/Jakarta');
	}

	function _template($data)
	{
		$level = $this->session->userdata('level');
		$tempMain = 'temp_admin_ppnpn';
		if($level=="pimpinan_pusat"){
			$tempMain = 'temp_main_pusat';
		}
		$this->load->view($tempMain.'/main',$data);	
	}

	public function index()
	{
	
		$vindex = "index";
		$ajax = $this->input->get_post("ajax");
		$level = $this->session->userdata('level');
		if($level=="pimpinan_pusat"){
			$vindex = "index_pp";
		}
		if ($ajax == "yes") {
			$var["data"]=$this->load->view($vindex,null,TRUE);
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
		} else {
			$data['header'] = "Dashboard";   
			$data['konten'] = $vindex;  
			$this->_template($data);
		}
	}

}
