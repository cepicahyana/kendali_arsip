<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class pengumuman extends MX_Controller 
{
	public function __construct()
	{
		parent::__construct();	
		$this->m_konfig->validasi_session(array("super_admin","admin_ppnpn"));
		$this->load->model("model","mdl");
		date_default_timezone_set('Asia/Jakarta');
		
		 
			 
	}
	 
	function _template($data)
	{
		// $this->m_reff->cekKelengkapan();
		$this->load->view('temp_ppnpn/main',$data);	
	}
	 
	public function index()
	{ 	 return $this->informasi();
			// $data['konten']="index";
			// $this->_template($data);
	}
	 
	// public function hub()
	// { 	 
	// 		$data['konten']="hub";
	// 		$this->_template($data);
		  
	// }
	
	public function informasi()
	{ 	 
			$data['konten']="informasi";
			$this->_template($data); 
	}

	// function reload_status(){
	// 	$this->load->view("reload_status");
	// }
	// function reload_cs(){
	// 	$this->load->view("reload_cs");
	// }

	// function kirim_status(){
	// 	$msg	=	 $this->input->post("msg");
	// 	if($msg){
	// 		 $this->mdl->kirim_status();
	// 		 $id	= $this->m_reff->goField("update_status","id","where id_sender='".$this->m_reff->idu()."' order by tgl desc limit 1");
	// 		$this->load->view("new_status",array("id"=>$id));
	// 	}
	// 	return false;
	// }
	// function kirim_balasan(){
	// 	$msg	=	 $this->input->post("msg");
	// 	if($msg){
	// 		 $this->mdl->kirim_balasan();
	// 		echo $this->load->view("konten_balasan");
	// 	}
	// 	return false;
	// }
	// function kirim_ucapan(){
	// 	$msg	=	 $this->input->post("msg");
	// 	if($msg){
	// 		 $this->mdl->kirim_ucapan();
	// 		echo $this->load->view("konten_ucapan");
	// 	}
	// 	return false;
	// }

	// function page_status(){
	// 	$this->load->view("page_status");
	// }
	
	// function getNewStatus(){
	// 	$this->load->view("getNewStatus");
	// }
	function reload_info(){
		$this->load->view("reload_info");
	}
	// function hapus_status(){
	// 	$id=$this->input->post('id');
	// 	if(!$id){ return $this->m_reff->page403();}
	// 	echo $this->mdl->hapus_status();
	// }
	// function hapus_com(){
	// 	$id=$this->input->post('id');
	// 	if(!$id){ return $this->m_reff->page403();}
	// 	echo $this->mdl->hapus_com();
	// }
	// function hapus_ucapan(){
	// 	$id=$this->input->post('id');
	// 	if(!$id){ return $this->m_reff->page403();}
	// 	echo $this->mdl->hapus_ucapan();
	// }
 
}
