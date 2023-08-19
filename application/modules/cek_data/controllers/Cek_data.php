<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cek_data extends CI_Controller {

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
		$ajax =  $this->m_reff->sanitize($ajax);
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
	public function filter()
	{
		$ajax=$this->input->get_post("ajax");
		$ajax =  $this->m_reff->sanitize($ajax);
		if($ajax=="yes")
		{
			$var["data"]	=	$this->load->view("filter",null,true);
			$var["token"]	=	$this->m_reff->getToken();
			echo json_encode($var);
		}else{
			$data['konten']	=	"filter";
			$this->_template($data);
		}
		
	}
	 
	function syncron(){
		$this->m_reff->log("mensinkronkan data","data");
		$nip	=	$this->input->post("nip");
		$nip	=  $this->m_reff->sanitize($nip);
		if(!$nip){ return $this->m_reff->page403();}

		$this->sync->syncronByNip($nip);
		$var["token"]	=	$this->m_reff->getToken();
		echo json_encode($var);
	}
	 
	function search(){
		$key = $this->input->post('key');
		$key = $this->m_reff->san($key);
		if(!$key){ return $this->m_reff->page403();}

		$cek				=	$this->mdl->cekSearch();
		// $cek				=	$this->m_reff->sanitize($cek);
		
		if(isset($cek)){
		 
			$var["data"]	=	$this->load->view("search",['data'=>$cek],true);
		}else{
			$var["data"]	=	"<br><div class='col-md-12'> <div class='alert alert-danger'> <i class='fa fa-exclamation-triangle'></i> Data tidak ditemukan! </div> </div>";
		}
		$var["token"]	=	$this->m_reff->getToken();
		echo json_encode($var);
	}

	function tab_kepegawaian(){
		$nip			=	$this->input->post("nip");
		$nip			=	$this->m_reff->san($nip);
		if(!$nip){ return $this->m_reff->page403();}

		$var["data"]	=	$this->load->view("tab_kepegawaian",$nip,true);
		$var["token"]	=	$this->m_reff->getToken();
		echo json_encode($var);
	}
 
	function tab_keluarga(){
		$nip			=	$this->input->post("nip");
		$nip			=	$this->m_reff->san($nip);
		if(!$nip){ return $this->m_reff->page403();}

		$var["data"]	=	$this->load->view("tab_keluarga",$nip,true);
		$var["token"]	=	$this->m_reff->getToken();
		echo json_encode($var);
	}
	function tab_domisili(){
		$nip			=	$this->input->post("nip");
		$nip			=	$this->m_reff->san($nip);
		if(!$nip){ return $this->m_reff->page403();}

		$var["data"]	=	$this->load->view("tab_domisili",$nip,true);
		$var["token"]	=	$this->m_reff->getToken();
		echo json_encode($var);
	}
	function tab_golongan(){
		$nip			=	$this->input->post("nip");
		$nip			=	$this->m_reff->san($nip);
		if(!$nip){ return $this->m_reff->page403();}

		$var["data"]	=	$this->load->view("tab_golongan",$nip,true);
		$var["token"]	=	$this->m_reff->getToken();
		echo json_encode($var);
	}
	function tab_jabatan(){
		$nip			=	$this->input->post("nip");
		$nip			=	$this->m_reff->san($nip);
		if(!$nip){ return $this->m_reff->page403();}

		$var["data"]	=	$this->load->view("tab_jabatan",$nip,true);
		$var["token"]	=	$this->m_reff->getToken();
		echo json_encode($var);
	}
	function tab_penugasan(){
		$nip			=	$this->input->post("nip");
		$nip			=	$this->m_reff->san($nip);
		if(!$nip){ return $this->m_reff->page403();}

		$var["data"]	=	$this->load->view("tab_penugasan",$nip,true);
		$var["token"]	=	$this->m_reff->getToken();
		echo json_encode($var);
	}
	function tab_pendidikan(){
		$nip			=	$this->input->post("nip");
		$nip			=	$this->m_reff->san($nip);
		if(!$nip){ return $this->m_reff->page403();}

		$var["data"]	=	$this->load->view("tab_pendidikan",$nip,true);
		$var["token"]	=	$this->m_reff->getToken();
		echo json_encode($var);
	}
	function tab_penghargaan(){
		$nip			=	$this->input->post("nip");
		$nip			=	$this->m_reff->san($nip);
		if(!$nip){ return $this->m_reff->page403();}

		$var["data"]	=	$this->load->view("tab_penghargaan",$nip,true);
		$var["token"]	=	$this->m_reff->getToken();
		echo json_encode($var);
	}
	function data_nilai_ppnpn_detail(){
		 
		$var["data"]	=	$this->load->view("data_nilai_ppnpn_detail",null,true);
		$var["token"]	=	$this->m_reff->getToken();
		echo json_encode($var);
	}
	function tab_penilaian(){
		$nip			=	$this->input->post("nip");
		$nip			=	$this->m_reff->san($nip);
		if(!$nip){ return $this->m_reff->page403();}
		$db = $this->db->get_where("data_pegawai",array("nip"=>$nip))->row();
		$jenis_pegawai =isset($db->jenis_pegawai)?($db->jenis_pegawai):1;
		if($jenis_pegawai==1){
			$var["data"]	=	$this->load->view("tab_penilaian",$nip,true);
		}else{
			$var["data"]	=	$this->load->view("tab_penilaian_ppnpn",$nip,true);
		}
		$var["token"]	=	$this->m_reff->getToken();
		echo json_encode($var);
	}
	function tab_medis(){
		$nip			=	$this->input->post("nip");
		$nip			=	$this->m_reff->san($nip);
		if(!$nip){ return $this->m_reff->page403();}

		$var["data"]	=	$this->load->view("tab_medis",$nip,true);
		$var["token"]	=	$this->m_reff->getToken();
		echo json_encode($var);
	}
	function tab_hukuman(){
		$nip			=	$this->input->post("nip");
		$nip			=	$this->m_reff->san($nip);
		if(!$nip){ return $this->m_reff->page403();}

		$var["data"]	=	$this->load->view("tab_hukuman",$nip,true);
		$var["token"]	=	$this->m_reff->getToken();
		echo json_encode($var);
	}
	function tab_gaji(){
		$nip			=	$this->input->post("nip");
		$nip			=	$this->m_reff->san($nip);
		if(!$nip){ return $this->m_reff->page403();}

		$var["data"]	=	$this->load->view("tab_gaji",$nip,true);
		$var["token"]	=	$this->m_reff->getToken();
		echo json_encode($var);
	}

	function cetak_pdf(){
		$nip = $this->input->get('nip');
		$nip = $this->m_reff->san($nip);
		$data['pegawai'] = $this->mdl->dataForPDF($nip);
		$this->load->view('pdf', $data);
	}
 
	
	 
}