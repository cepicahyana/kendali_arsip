<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pegawai extends MY_Controller {

	 
	var $tbl="admin";
	function __construct()
	{
		parent::__construct();	
		$this->m_konfig->validasi_session(array("admin"));
		$this->load->model("model","mdl");
		date_default_timezone_set('Asia/Jakarta');
	}
	 
	function _template($data)
	{
	$this->load->view('temp_main/main',$data);	
	}
	
 
	
	
	 
	 public function index()
	{
		 	
		$ajax=$this->input->post("ajax");
		if($ajax=="yes")
		{
			echo	$this->load->view("index");
		}else{
			$data['konten']="index";
			$this->_template($data);
		}
		
	}  
	 
	 
	   
	///-----------------------mitra PENILIAAN--------------------------///
	function getData()
	{
		if(!$this->input->post("draw")){ echo $this->m_reff->page403(); return false;}
		$list = $this->mdl->get_data();
		$data = array();
		$no = $this->input->post("start");
		$no =$no+1;
		foreach ($list as $dataDB) {
		////
	 
		 
		 
		 
			$row = array();
			$row[] =  $no++;	
			$row[] =  $dataDB->nama;
			$row[] = $dataDB->biro;
			$row[] = "<center><span class='badge badge-success'>negatif </span></center>";
			$row[] = " -";
			$row[] = " -";
			  
			  
		  
			$data[] = $row; 
			
			}
			 
		$output = array(
						"draw" => $this->input->post("draw"),
						"recordsTotal" => $c=$this->mdl->count(),
						"recordsFiltered" =>$c,
						"data" => $data,
						);
		//output to json format
		echo json_encode($output);

	}
	
	 
	//----------------------------------------------- -----------------------//
	function idu()
	{
		return $this->session->userdata("id");
	}
	  
	 
}