<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Broadcast extends MY_Controller {
 
	function __construct()
	{
		parent::__construct();	
		$this->m_konfig->validasi_session(array("admin_covid","pic_covid","super_admin","pimpinan_covid"));
		$this->load->model("model","mdl");
		date_default_timezone_set('Asia/Jakarta');
	}
	
	function _template($data)
	{
	$this->load->view('temp_main/main',$data);	
	}

	function kirimBroadcast(){

		 
			$var["data"]=$this->load->view("kirimBroadcast",null,true);
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
		 
	}


	  public function index()
	{
		$ajax=$this->input->get_post("ajax");
		if($ajax=="yes")
		{
			echo	$this->load->view("index");
		}else{
			$data['konten']="index";
			$this->_template($data);
		}
	}   
	
	
	function sendBroadcast(){
		$f=$this->input->post('f');
		if(!$f){ return $this->m_reff->page403();}

		$this->mdl->sendBroadcast();
		$data["token"] = $this->m_reff->getToken();
		echo json_encode($data);
	}
	
}