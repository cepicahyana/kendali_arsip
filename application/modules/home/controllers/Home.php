<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class home extends MX_Controller 
{
	public function __construct()
	{
		parent::__construct();	
		$this->m_konfig->validasi_session(array("super","pegawai"));
		$this->load->model("model","mdl");
		date_default_timezone_set('Asia/Jakarta');
	

	}
	 
	function _template($data)
	{
		// if(!$this->m_reff->mobile()){
		// 	echo "<i>Silahkan akses menggunakan handphone!</i><br>
		// 	<a href='".base_url()."'>kembali kehalaman utama</a>";
		// 	return false;
		// }
		// $this->m_reff->cekKelengkapan();
		$this->load->view('temp_ppnpn/main',$data);	
	}
	 
	public function index()
	{ 	 
		
			$data['konten']="index";
			$this->_template($data);
		  
	}

	function setAbsenScan(){
		$kode=$this->input->post('kode');
		if(!$kode){ return $this->m_reff->page403();}

		$var["data"] = $this->mdl->setAbsenScan();
		$var["token"] = $this->m_reff->getToken();
		echo json_encode($var);
	}

 function scan(){
	 $this->load->view("scan");
 }
 
 function setAbsen(){
	$id = $this->input->post('id');
	if(!$id){ return $this->m_reff->page403();}
	$var["data"] = $this->mdl->setAbsen();
	$var["token"] = $this->m_reff->getToken();
	echo json_encode($var);
 }

 function showScan(){
	$var["data"] = $this->load->view("showGeo",null,true);
	$var["token"] = $this->m_reff->getToken();
	echo json_encode($var);
 }
 function showScanPulang(){
	$data=array(
		"ket"=>$this->input->post("ket"),
		"id"=>$this->input->post("id"),
	);
	$var["data"] = $this->load->view("showGeoPulang",$data,true);
	$var["token"] = $this->m_reff->getToken();
	echo json_encode($var);
 }

 function reloadAbsen(){
	$var["data"] = $this->load->view("reloadAbsen",null,true);
	$var["token"] = $this->m_reff->getToken();
	echo json_encode($var);
 }
 function inputJob(){
	$var["data"] = $this->load->view("inputJob",null,true);
	$var["token"] = $this->m_reff->getToken();
	echo json_encode($var);
 }
 function infoact(){
	$var["data"] = $this->load->view("infoact",null,true);
	$var["token"] = $this->m_reff->getToken();
	echo json_encode($var);
 }
 function insert_job(){
	$f=$this->input->post('f');
	if(!$f){ return $this->m_reff->page403();}
	$this->mdl->insert_job();
	$var["token"] = $this->m_reff->getToken();
	echo json_encode($var);
 }
 function hapusJob(){
	$id = $this->input->post('id');
	if(!$id){ return $this->m_reff->page403();}
	$this->mdl->hapusJob();
	$var["token"] = $this->m_reff->getToken();
	echo json_encode($var);
 }
 function calendaragenda(){
	$var = $this->mdl->calendaragenda();
	//$var["token"] = $this->m_reff->getToken();
    echo json_encode($var);
 }
 function info_detail(){
	$var["data"] = $this->load->view("infodet",null,true);
	$var["token"] = $this->m_reff->getToken();
	echo json_encode($var);
 }
 function absen_pulang(){
	$var["data"] = $this->load->view("absen_pulang",null,true);
	$var["token"] = $this->m_reff->getToken();
	echo json_encode($var);
 }
 function cekLokasi(){
	$f=$this->input->post('lat');
	if(!$f){ return $this->m_reff->page403();}
	
	$var["jarak"] = number_format($this->mdl->cekJarak(),0,",",".");
	$var["data"] = $this->mdl->cekLokasi();
	$var["token"] = $this->m_reff->getToken();
	echo json_encode($var);
 }

 function cekLokasiPulang(){
	$f=$this->input->post('lat');
	if(!$f){ return $this->m_reff->page403();}
	
	$var["jarak"] = number_format($this->mdl->cekJarak(),0,",",".");
	$var["data"] = $this->mdl->cekLokasiPulang();
	$var["token"] = $this->m_reff->getToken();
	echo json_encode($var);
 }
 
}
