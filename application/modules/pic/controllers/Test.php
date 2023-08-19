<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends MY_Controller {

	

	function __construct()
	{
		parent::__construct();	
		$this->m_konfig->validasi_session(array("pic_covid","admin_covid","super_admin","pimpinan_covid"));
		$this->load->model("model","mdl");
		date_default_timezone_set('Asia/Jakarta');
	 
	}
	
	function _template($data)
	{
	$this->load->view('temp_main/main',$data);	
	}
	 
  public function index()
	{
		$ajax=$this->input->get_post("ajax");
		if($ajax=="yes")
		{
			$var["data"]=$this->load->view("grafik_test",null,true);
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
		}else{
			$data['konten']="grafik_test";
			$this->_template($data);
		}
		
	}  

	function goGrafik(){
		$type = $this->input->post("type");

		if(!$type){
			return $this->m_reff->page403();
		}

		if($type==1){
			$var["data"]=$this->load->view("goGrafik_harian",null,true);
		}elseif($type==2){
			$var["data"]=$this->load->view("goGrafik_mingguan",null,true);
		}else{
			$var["data"]=$this->load->view("goGrafik_bulanan",null,true);
		}
		
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
		
	}
	 
	function count_periode(){
		$range = $this->input->post("range");

		if(!$range){
			return $this->m_reff->page403();
		}

		$var["data"]=$this->mdl->count_periode($range);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}

	function goTable(){
		$range = $this->input->post("range");

		if(!$range){
			return $this->m_reff->page403();
		}

		$var["data"]=$this->load->view("goTable",null,true);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
		
	}
	 
}