<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengaturan extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->m_konfig->validasi_session(array("admin_ppnpn"));
		$this->load->model("model", "mdl");
		date_default_timezone_set('Asia/Jakarta');
 
	}

	function _template($data)
	{
		$this->load->view('temp_admin_ppnpn/main', $data);
	}


	public function index()
	{
		$ajax = $this->input->get_post("ajax");
		if ($ajax == "yes") {
	 
			$data['header'] = "Pengaturan Presensi";
			echo $this->load->view("index", $data);
		} else {
			 
			$data['header'] = "Pengaturan Presensi";
			$data['konten'] = "index";
			$this->_template($data);
		}
	}

	function insert()
	{
		$f=$this->input->post('f');
		if(!$f){ return $this->m_reff->page403();}
		echo $this->mdl->insert();
	}
	function hapus()
	{
		$id=$this->input->post('id');
		if(!$id){ return $this->m_reff->page403();}
		echo $this->mdl->hapus();
	}
	function update()
	{
		$f=$this->input->post('f');
		if(!$f){ return $this->m_reff->page403();}
		echo $this->mdl->updateVal();
	}
}
