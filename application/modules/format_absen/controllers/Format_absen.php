<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Format_absen extends CI_Controller
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
		 
			$data['header'] = "Data Format Absen";
			$var["data"]=$this->load->view("index",$data,TRUE);
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
		} else {
		 
			$data['jp'] = $this->mdl->getJp();
			 
			$data['header'] = "Data Format Absen";
			$data['konten'] = "index";
			$this->_template($data);
		}
	}
	
	function getData()
	{
		// if(!$this->input->post("draw")){ echo $this->m_reff->page403(); return false;}
		if(!$this->m_reff->san($this->input->post("draw"))){ echo $this->m_reff->page403(); return false;}
		$list = $this->mdl->getData();
		$data = array();
		$no = $this->m_reff->san($this->input->post('start'));
		$no = $no + 1;
		foreach ($list as $dataDB) {
			$status = $dataDB->sts == 1 ? 'Aktif' : 'Tidak Aktif';


			$id	= $dataDB->id;
			$action		 =	'<div class="btn-group" role="group"  >
								<button onclick="edit(`' . $dataDB->id . '`)" type="button" class="btn bg-teal  btn-sm waves-effect waves-light ti-pencil-alt"> <i class="ri-edit-2-fill"></i>  </button>
								<button onclick="hapus(`' . $dataDB->id . '`)" type="button" class="btn bg-danger  btn-sm waves-effect waves-light ti-trash">Remove  </button>
				   </div>';
			$row = array();
			$row[] = $no++;

			$row[] = $dataDB->nama_format;
			$row[] = $dataDB->jam_masuk;
			$row[] = $dataDB->jam_pulang;
			$row[] = $this->m_umum->selisih($dataDB->jam_pulang,$dataDB->jam_masuk);
			$row[] = $dataDB->nominal_lembur;
			$row[] = $dataDB->uang_makan;
			$row[] = $dataDB->jam_mulai_lembur;
			$row[] = $dataDB->max_lembur_weekday." Jam";
			$row[] = $dataDB->max_lembur_weekend." Jam";
			// $row[] = $status;
			$row[] = $dataDB->jamin_umak;
			$row[] = $action;

			//add html for action
			$data[] = $row;
		}

		//$csrf_name = $this->security->get_csrf_token_name();
		//$csrf_hash = $this->security->get_csrf_hash(); 
		$output = array(
			"draw" => $this->m_reff->san($this->input->post('draw')),
			"recordsTotal" => $c = $this->mdl->count(),
			"recordsFiltered" => $c,
			"data" => $data,
			"token"=>$this->m_reff->getToken()
		);
		//output to json format
		//$output[$csrf_name] = $csrf_hash;
		echo json_encode($output);
	}
	
	// function detail(){
	// 	$var["data"]=$this->load->view("detail",NULL,TRUE);
	// 	$var["token"]=$this->m_reff->getToken();
	// 	echo json_encode($var);
	// }
 
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

		$var["data"]=$this->load->view("form_edit",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}

	function insert()
	{
		$f=$this->input->post("f");
		if(!$f){ return $this->m_reff->page403();}

		$this->mdl->insert();
		$this->m_reff->log("insert formasi absen");
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

		echo $this->mdl->update();
	}

}