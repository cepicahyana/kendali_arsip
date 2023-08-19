<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Log_aktivitas extends MY_Controller {

	function __construct()
	{
		parent::__construct();	
		$this->m_konfig->validasi_session(array("admin_data","super_admin"));
		$this->load->model("model","mdl");
		date_default_timezone_set('Asia/Jakarta');
	}
	
	function _template($data)
	{
		$this->load->view('temp_main_data/main',$data);	
	}

	function index()
	{
		$ajax=$this->input->get_post("ajax");
		if($ajax=="yes")
		{
			$var["data"]=$this->load->view("index",NULL,TRUE);
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
		}else{
			$data['konten']="index";
			$this->_template($data);
		}
	}
	function get_data()
	{
		if(!$this->input->post("draw")){ echo $this->m_reff->page403(); return false;}
		$list = $this->mdl->getData();
		$data = array();
		$no = $this->input->post("start");
		$no =$no+1;

		foreach ($list as $dataDB) {
			$row = array();
			$row[] = $no++;
			$row[] = $dataDB->id_user;
			$row[] = $dataDB->username;
			$row[] = $dataDB->aksi;
			$row[] = $dataDB->tgl;
			$row[] = $dataDB->level;
			$row[] = $dataDB->module;

			//add html for action
			$data[] = $row;
		}

		$output = array(
			"draw" => $this->input->post("draw"),
			"recordsTotal" => $c=$this->mdl->countData(),
			"recordsFiltered" =>$c,
			"data" => $data,
			"token"=>$this->m_reff->getToken()
		);
		//output to json format
		echo json_encode($output);
	}

}
