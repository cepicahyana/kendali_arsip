<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Aktivitas extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->m_konfig->validasi_session(array("admin_ppnpn", "pic_ppnpn","pimpinan_ppnpn","super_admin"));
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
	 
			$data['jp'] = $this->mdl->getJp();
			$data['header'] = "Aktivitas pekerjaan";

			$var["data"]=$this->load->view("index",$data,TRUE);
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);

		} else {
		 
			$data['jp'] = $this->mdl->getJp();
			 
			$data['header'] = "Aktivitas pekerjaan";
			$data['konten'] = "index";
			$this->_template($data);
		}
	}
	public function lembur()
	{
		$ajax = $this->input->get_post("ajax");
		if ($ajax == "yes") {
	 
			$data['jp'] = $this->mdl->getJp();
			$data['header'] = "Aktivitas lembur";

			$var["data"]=$this->load->view("lembur",$data,TRUE);
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
		} else {
		 
			$data['jp'] = $this->mdl->getJp();
			$data['header'] = "Aktivitas lembur";
			$data['konten'] = "lembur";
			$this->_template($data);
		}
	}
	function getData()
	{
		if(!$this->input->post("draw")){ echo $this->m_reff->page403(); return false;}
		$list = $this->mdl->getData();
		$data = array();
		$no = $this->input->post('start');
		$no = $no + 1;
		foreach ($list as $dataDB) {
 			// jenjang pendidikan
			//  $level = $this->session->userdata("level");
 			// status admin
 	  
			 
			$row = array();
			$row[] = $no++;
			// $bidang = $this->m_umum->bidang($dataDB->id_bidang);

			$row[] = $dataDB->tgl;
			$row[] = substr($dataDB->mulai,0,5)." - ".substr($dataDB->akhir,0,5) ;
			$row[] = $dataDB->nama;
			$row[] = $dataDB->deskripsi;
			 
		 
			//add html for action
			$data[] = $row;
		}

		//$csrf_name = $this->security->get_csrf_token_name();
		//$csrf_hash = $this->security->get_csrf_hash(); 
		$output = array(
			"draw" => $this->input->post('draw'),
			"recordsTotal" => $c = $this->mdl->count(),
			"recordsFiltered" => $c,
			"data" => $data,
			"token"=>$this->m_reff->getToken()
		);
		//output to json format
		//$output[$csrf_name] = $csrf_hash;
		echo json_encode($output);
	}
	
	function getDataLembur()
	{
		if(!$this->input->post("draw")){ echo $this->m_reff->page403(); return false;}
		$list = $this->mdl->getDataLembur();
		$data = array();
		$no = $this->input->post('start');
		$no = $no + 1;
		foreach ($list as $dataDB) {
 			// jenjang pendidikan
			 $level = $this->session->userdata("level");
 			// status admin
 	 

			$id	= $dataDB->id;
			 
			$row = array();
			$row[] = $no++;
			// $bidang = $this->m_umum->bidang($dataDB->id_bidang);

			$row[] = $dataDB->tgl;
			$row[] = $dataDB->nama;
			$row[] = $dataDB->lembur_terhitung;
			$row[] = $dataDB->ket_lembur;
			 
		 
			//add html for action
			$data[] = $row;
		}

		//$csrf_name = $this->security->get_csrf_token_name();
		//$csrf_hash = $this->security->get_csrf_hash(); 
		$output = array(
			"draw" => $this->input->post('draw'),
			"recordsTotal" => $c = $this->mdl->countLembur(),
			"recordsFiltered" => $c,
			"data" => $data,
			"token"=>$this->m_reff->getToken()
		);
		//output to json format
		//$output[$csrf_name] = $csrf_hash;
		echo json_encode($output);
	}
	
	function detail(){
		$var["data"]=$this->load->view("detail",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	 }
 

	function form_edit()
	{
		$data['jp'] = $this->mdl->getJp();
		$data['agama'] = $this->mdl->getAgama();
		$data['kelas'] = $this->mdl->getKelas();
		$data['pekerjaan'] = $this->mdl->getPekerjaan();
		$data['goldar'] = $this->mdl->getGoldar();
		$data['penghasilan'] = $this->mdl->getPenghasilan();
		$data['tahunLulus'] = $this->mdl->getTahunLulus();
		$this->load->view("form_edit", $data);
	}

	// function insert()
	// {
	// 	echo $this->mdl->insert();
	// }
	// function hapus()
	// {
	// 	echo $this->mdl->hapus();
	// }
	// function update()
	// {
	// 	echo $this->mdl->update();
	// }
	function getDataPresensi(){
		$var["data"]=$this->load->view("presensi",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}
}
