<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Syncron extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->m_konfig->validasi_session(array("admin_data","super_admin","pimpinan_pusat"));
		$this->load->model("model","mdl");
		$this->load->model("sinkron","sync");
		date_default_timezone_set('Asia/Jakarta');
	}
	
	function _template($data)
	{
		$level = $this->session->userdata('level');
		$tempMain = 'temp_main_data';
		if($level=="pimpinan_pusat"){
			$tempMain = 'temp_main_pusat';
		}
		$this->load->view($tempMain.'/main',$data);	
	}
	public function index()
	{
		$ajax=$this->input->get_post("ajax");
		if($ajax=="yes")
		{
			$var["data"]	=	$this->load->view("index",null,true);
			$var["token"]	=	$this->m_reff->getToken();
			echo json_encode($var);
		}else{
			$data['konten']	=	"index";
			$this->_template($data);
		}
		
	}
	function start(){
		$offsite = $this->input->post("offsite");
		if(!$offsite){ return $this->m_reff->page403();}

		$this->mdl->start($offsite);
		$total	 = $this->input->post("total");
		
		$persen  = ($offsite/$total)*100;
		$var["persen"]	=	$persen;
		echo json_encode($var);
	}
	function trfstart(){
		$offsite = $this->input->post("offsite");
		if(!$offsite){ return $this->m_reff->page403();}

		 $this->mdl->trfstart($offsite);
		$total	 = $this->input->post("total");
		
		$persen  = ($offsite/$total)*100;
		$var["persen"]	=	$persen;
		echo json_encode($var);
	}
	  
	
	 
}