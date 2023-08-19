<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Organisasi extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->m_konfig->validasi_session(array("admin_data","super_admin","pimpinan_pusat"));
		$this->load->model("model","mdl");
		$this->load->model("quota","quota");
		$this->load->model("draft","draft");
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

	function hierarki(){
		$ajax=$this->input->get_post("ajax");
		if($ajax=="yes")
		{
			$bagan["bagan"]		=   isset($_GET["f"])?($_GET["f"]):"404";
			$bagan["nama_file"] =   $this->input->get("name");
			$var["data"]	=	$this->load->view("main",$bagan,true);
			$var["token"]	=	$this->m_reff->getToken();
			echo json_encode($var);
		}else{
			$data['bagan']		=	isset($_GET["f"])?($_GET["f"]):"404";
			$data["nama_file"] =   $this->input->get("name");
			$data['konten']		=	"main";
			$this->_template($data);
		}	
	}
 
 
	function bagan($file=null){
		error_reporting(0);
		$this->load->view($file);
	}
	function setbagan($file=null){
		error_reporting(0);
		$this->load->view("quota/".$file);
	}
	function draft($file=null){
		error_reporting(0);
		$this->load->view("draft/".$file);
	}
	function detail(){
		$id = $this->input->post("id");
		if(!$id){ return $this->m_reff->page403();}
		$param["id"]	=	$id;
		$var["token"]	=	$this->m_reff->getToken();
		$var["data"]	= 	$this->load->view("detail",$param,true);
		echo json_encode($var);
	}
	function setQuota(){
		$id				=	$this->m_reff->san($this->input->post("id"));
		if(!$id){ 			return $this->m_reff->page403();	}
		$val			=	$this->m_reff->san($this->input->post("val"));

		$this->db->where("id",$id);
		$this->db->set("kuota",$val);
		$this->db->update("tm_formasi_org");

		$var["token"]	=	$this->m_reff->getToken();
		echo json_encode($var);
	}
	 
}