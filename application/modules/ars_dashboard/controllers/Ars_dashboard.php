<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ars_dashboard extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->m_konfig->validasi_session(array("admin_arsip","up","uk"));
		$this->load->model("model","mdl");
		date_default_timezone_set('Asia/Jakarta');
	}
	
	function _template($data)
	{ 
		$tempMain = 'temp_arsip'; 
		$this->load->view($tempMain.'/main',$data);	
	}
	public function index()
	{
		$ajax=$this->input->get_post("ajax");
		$var["title"] = "Home";
		$var["subtitle"] = "Dashboard";
		if($ajax=="yes")
		{
			$var["data"]=$this->load->view("index",null,true);
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
		}else{
			$var['konten']="index";
			$this->_template($var);
		}
		
	}

	 
	 
}