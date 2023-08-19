<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mbidang extends CI_Controller
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
	 
			$data['jp'] = $this->mdl->getJp();
		 
			$data['header'] = "Data Master Bidang Pekerjaan";
			echo $this->load->view("index", $data);
		} else {
		 
			$data['jp'] = $this->mdl->getJp();
			 
			$data['header'] = "Data Master Bidang Pekerjaan";
			$data['konten'] = "index";
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

			$id	= $dataDB->id;
			$action		 =	'<div class="btn-group" role="group"  >
								 <button onclick="detail(`' . $dataDB->id . '`,`'.$dataDB->bidang.'`)" type="button" class="btn bg-grey d-none btn-sm waves-effect waves-light ti-trash">   Detail  </button>
								<button onclick="edit(`' . $dataDB->id . '`)" type="button" class="btn bg-teal  btn-sm waves-effect waves-light ti-pencil-alt"> <i class="ri-edit-2-fill"></i>  </button>
								<button onclick="hapus(`' . $dataDB->id . '`, `' . $dataDB->bidang . '`)" type="button" class="btn bg-danger  btn-sm waves-effect waves-light ti-trash">Remove  </button>
				   </div>';
			$row = array();
			$row[] = $no++;

			$row[] = $dataDB->bidang;
			$row[] = ($dataDB->sts === '1') ? 'Aktif' : 'Non Aktif' ;
			$row[] = $action;

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
 
	function form_tambah(){
		$this->load->view("form_tambah");
	}

	function form_edit()
	{
		$id = $this->input->post('id');
		if(!$id){ return $this->m_reff->page403();}
		$this->load->view("form_edit");
	}

	function insert()
	{
		$f = $this->input->post('f');
		if(!$f){ return $this->m_reff->page403();}
		echo $this->mdl->insert();
	}
	function hapus()
	{
		$id = $this->input->post('id');
		if(!$id){ return $this->m_reff->page403();}
		echo $this->mdl->hapus();
	}
	function update()
	{
		$f = $this->input->post('f');
		if(!$f){ return $this->m_reff->page403();}
		echo $this->mdl->update();
	}
	function getDataPresensi(){
		$var["data"]=$this->load->view("presensi",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}
}
