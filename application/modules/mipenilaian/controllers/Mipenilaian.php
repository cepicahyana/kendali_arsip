<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mipenilaian extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->m_konfig->validasi_session(array("admin_ppnpn", "pic_ppnpn","super_admin"));
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
			$data['header'] = "Data Master Indikator Penilaian";

			$var["data"]=$this->load->view("index",null,TRUE);
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
		} else {
		 
			$data['jp'] = $this->mdl->getJp();
			 
			$data['header'] = "Data Master Indikator Penilaian";
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

			$id	= $dataDB->id;
			$action		 =	'<div class="btn-group" role="group"  >
								 <button onclick="detail(`' . $dataDB->id . '`,`'.$dataDB->indikator.'`)" type="button" class="btn bg-grey d-none btn-sm waves-effect waves-light ti-trash">   Detail  </button>
								<button onclick="edit(`' . $dataDB->id . '`)" type="button" class="btn bg-teal  btn-sm waves-effect waves-light ti-pencil-alt"> <i class="ri-edit-2-fill"></i>  </button>
								<button onclick="hapus(`' . $dataDB->id . '`, `' . $dataDB->indikator . '`)" type="button" class="btn bg-danger  btn-sm waves-effect waves-light ti-trash">Remove  </button>
				   </div>';
			$row = array();
			$row[] = $no++;

			$row[] = $dataDB->tahun;
			$row[] = 'Semester '.$dataDB->semester;
			$row[] = $dataDB->indikator;
			$row[] = $dataDB->bobot.' %';
			$row[] = ($dataDB->sts === '1') ? 'Aktif' : 'Non Aktif' ;
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
			"token"=>$this->m_reff->getToken()
		);
		//output to json format
		//$output[$csrf_name] = $csrf_hash;
		echo json_encode($output);
	}
	
	function detail(){
		$f=$this->input->post("nip");
		if(!$f){ return $this->m_reff->page403();}
		
		$var["data"]=$this->load->view("detail",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}
 
	function form_tambah(){
		$f=$this->input->post();
		if(!$f){ return $this->m_reff->page403();}

		$var["data"]=$this->load->view("form_tambah",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var); 
	}

	function form_edit()
	{		
		$f=$this->input->post("id");
		if(!$f){ return $this->m_reff->page403();}

		$var["data"]=$this->load->view("form_edit","",TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var); 
	}

	function insert()
	{
		$f=$this->input->post("f");
		if(!$f){ return $this->m_reff->page403();}

		$var = $this->mdl->insert();
		echo json_encode($var);
	}
	function hapus()
	{
		$f=$this->input->post("id");
		if(!$f){ return $this->m_reff->page403();}

		$var = $this->mdl->hapus();
		echo json_encode($var);
	}
	function update()
	{
		$f=$this->input->post("f");
		if(!$f){ return $this->m_reff->page403();}

		$var = $this->mdl->update();
		echo json_encode($var);
	}

	function copydata()
	{
		$f=$this->input->post("tahun");
		if(!$f){ return $this->m_reff->page403();}
		
		$var = $this->mdl->copydata();
		echo json_encode($var);
	}
}
