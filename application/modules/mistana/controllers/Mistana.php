<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mistana extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->m_konfig->validasi_session(array("admin_ppnpn","super_admin","admin_data"));
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
	 
			$data['header'] = "Data Master Istana Negara";
	 
			$var["data"]=$this->load->view("index",null,TRUE);
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
		} else {
			 
			$data['header'] = "Data Master Istana Negara";
			$data['konten'] = "index";
			$this->_template($data);
		}
	}
	function getData()
	{
		$list = $this->mdl->getData();
		$data = array();
		$no = isset($_POST['start'])?($_POST['start']):null;
		if(!$this->input->post("draw")){ echo $this->m_reff->page403(); return false;}
		$no = $no + 1;
		foreach ($list as $dataDB) {

			$id	= $dataDB->id;
			$action		 =	'<div class="btn-groups" role="group"  >
								 <button onclick="edit(`' . $dataDB->id . '`)" type="button" class="btn btn-sm btn-secondary pd-x-25 ">   Edit </button>
								 <button onclick="hapus(`' . $dataDB->id . '`,`'.$dataDB->istana.'`)" type="button" class="btn btn-sm btn-danger pd-x-25 ">  </i> Hapus </button>
				    </div>';
			$row = array();
			// $row[] = $no++;

			$row[] = $dataDB->kode;
			$row[] = $dataDB->istana;
			$row[] = $dataDB->lat;
			$row[] = $dataDB->lng;
			$row[] = $dataDB->max_jarak. " M";
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
			"token" => $this->m_reff->getToken()
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

		$var["data"]=	$this->load->view("form_tambah",null,true);
		$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
	}

	function form_edit()
	{
		$f=$this->input->post("id");
		if(!$f){ return $this->m_reff->page403();}
	
		$var["data"]=	$this->load->view("form_edit",null,true);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}

	function insert()
	{
		$f=$this->input->post("f");
		if(!$f){ return $this->m_reff->page403();}

		$this->mdl->insert();
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}
	function hapus()
	{
		$f=$this->input->post("id");
		if(!$f){ return $this->m_reff->page403();}

		$this->mdl->hapus();
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}
	function update()
	{
		$f=$this->input->post("f");
		if(!$f){ return $this->m_reff->page403();}

		$this->mdl->update();
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}
	function getDataPresensi(){
		$f=$this->input->post("nip");
		if(!$f){ return $this->m_reff->page403();}

		$var["data"]=$this->load->view("presensi",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}
}
