<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Setting_absen extends CI_Controller
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
		 
			$data['header'] = "Setting Absen";
			$var["data"]=$this->load->view("index",$data,TRUE);
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
		} else {
		 
			$data['jp'] = $this->mdl->getJp();
			 
			$data['header'] = "Setting Absen";
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
			
			$id_f = $dataDB->id_format;
			$fmt = $this->db->get_where("tm_format_absen", ["id" => $id_f])->row(); // get nama_format
			$nama_format = isset($fmt->nama_format)?($fmt->nama_format):"";

			$id	= $dataDB->id;
			$action		 =	'<div class="btn-group" role="group"  >
								<button onclick="edit(`' . $dataDB->id . '`)" type="button" class="btn bg-teal  btn-sm waves-effect waves-light ti-pencil-alt"> <i class="ri-edit-2-fill"></i>  </button>
								<button onclick="hapus(`' . $dataDB->id . '`,`'.$dataDB->bulan_mulai.'`)" type="button" class="btn bg-danger  btn-sm waves-effect waves-light ti-trash">Remove  </button>
				   </div>';
			$row = array();
			$row[] = $no++;

			$row[] = $this->tanggal->bulan($dataDB->bulan_mulai);
			$row[] = $dataDB->tgl_mulai;
			$row[] = $this->tanggal->bulan($dataDB->bulan_akhir);
			$row[] = $dataDB->tgl_akhir;
			$row[] = $nama_format;
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

	function form_tambah(){
		$f=$this->input->post();
		if(!$f){ return $this->m_reff->page403();}

		$var["data"]=$this->load->view("form_tambah",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}

	function insert(){
		$f=$this->input->post("f");
		if(!$f){ return $this->m_reff->page403();}

		$dt = $this->mdl->insert();
		echo json_encode($dt);
	}

	function form_edit(){
		$f=$this->input->post("id");
		if(!$f){ return $this->m_reff->page403();}

		$var["data"]=$this->load->view("form_edit",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}

	function update(){
		$f=$this->input->post("f");
		if(!$f){ return $this->m_reff->page403();}

		$dt = $this->mdl->update();
		echo json_encode($dt);
	}

	function hapus(){
		$f=$this->input->post("id");
		if(!$f){ return $this->m_reff->page403();}

		$dt = $this->mdl->hapus();
		echo json_encode($dt);
	}
}