<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Koreksi_absen extends CI_Controller
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
		 
			$data['header'] = "Data PPNPN";
			$data['token'] = $this->m_reff->getToken();
			$data['data'] = $this->load->view("index", null,true);
			echo json_encode($data);
		} else {
		 
			$data['jp'] = $this->mdl->getJp();
			 
			$data['header'] = "Data PPNPN";
			$data['konten'] = "index";
			$this->_template($data);
		}
	}
	function getData()
	{
		if(!$this->input->post("draw")){ echo $this->m_reff->page403(); return false;}
		$list = $this->mdl->getData();
		$data = array();
		$no = isset($_POST['start'])?($_POST['start']):null;
		$no = $no + 1;
		foreach ($list as $dataDB) {
 			// jenjang pendidikan
			$jp = $this->mdl->getJpByid($dataDB->id_jp);
 

			$id	= $dataDB->id;
			$action		 =	'<div class="btn-group" role="group"  >
								 <button onclick="detail(`' . $dataDB->nip . '`,`'.$dataDB->nama.'`)" type="button" class="btn bg-grey  btn-sm waves-effect waves-light ti-trash"><i class="fa fa-search"></i>   Lihat absen  </button>
				   </div>';
			if($dataDB->jk=="l"){
				$jk = "Laki-laki";
			}elseif($dataDB->jk=="p"){
				$jk = "Perempuan";
			}else{
				$jk = "-";
			}	   
			$row = array();
			$row[] = $no++;
			// $bidang = br().$this->m_umum->bidang($dataDB->id_bidang);
			$row[] = $dataDB->nama;
			$row[] = $jk;
			$row[] = $this->m_reff->istana($dataDB->kode_istana).br().$this->m_reff->biro($dataDB->kode_biro);
			$row[] = $dataDB->bagian;
			$row[] = $dataDB->nip;
		 	$row[] = $action;

			//add html for action
			$data[] = $row;
		}

		//$csrf_name = $this->security->get_csrf_token_name();
		//$csrf_hash = $this->security->get_csrf_hash(); 
		$output = array(
			"draw" => isset($_POST['draw'])?($_POST['draw']):null,
			"recordsTotal" => $c = $this->mdl->count(),
			"recordsFiltered" => $c,
			"data" => $data,
		);
		//output to json format
		//$output[$csrf_name] = $csrf_hash;
		echo json_encode($output);
	}
	
	function detail(){
		$nip=$this->input->post("nip");
		if(!$nip){ return $this->m_reff->page403();}

		$var["data"]=$this->load->view("detail",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}
 
  
	function getDataPresensi(){
		$nip=$this->input->post("nip");
		if(!$nip){ return $this->m_reff->page403();}

		$var["data"]=$this->load->view("presensi",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}
  
	function revAbsen(){
		$nip=$this->input->post("nip");
		if(!$nip){ return $this->m_reff->page403();}

		$var["data"]=$this->mdl->revAbsen();
		$var["hitungLembur"]=$this->mdl->hitungLembur();
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}

	function setJenisAbsen(){
		$nip=$this->input->post("nip");
		if(!$nip){ return $this->m_reff->page403();}
		
		$var["data"]=$this->mdl->setJenisAbsen();
		$var["hitungLembur"]=$this->mdl->hitungLembur();
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}
}
