<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Up extends MX_Controller 
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
		$this->load->view('temp_ppnpn/main',$data);	
	}
	 
	 
	
	public function index()
	{ 	 
			$data['konten']="index";
			$this->_template($data); 
	}
	// public function ks()
	// { 	 
	// 		$data['konten']="ks";
	// 		$this->_template($data); 
	// }
	
	// public function profile()
	// { 	 
	// 		$data['konten']="profile";
	// 		$this->_template($data); 
	// }

	// function reload_info(){
	// 	$this->load->view("reload_info");
	// }
	// function reload_ks(){
	// 	$this->load->view("reload_ks");
	// }
	// function reload_profile(){
	// 	$this->load->view("reload_profile");
	// }
	// function upload(){
	// 	$this->mdl->upload();
	// 	redirect("up");
	// }
	// function kirim_ks(){
	// 	$f=$this->input->post("msg"); 
	// 	if(!$f){ return $this->m_reff->page403();}
	// 	echo $this->mdl->kirim_ks();
	// } function hapus_ks(){
	// 	$f=$this->input->post("id");  
	// 	if(!$f){ return $this->m_reff->page403();}
	// 	echo $this->mdl->hapus_ks();
	// } 
	
	// function save_password(){
	// 	$f=$this->input->post("username");  
	// 	if(!$f){ return $this->m_reff->page403();}
	// 	echo $this->mdl->save_password(); 
	// }
 
	// function update(){
	// 	echo $this->mdl->update(); 
	
	// }
	// function update_last(){
	// 	$this->mdl->update_last();
	// }
 
}
