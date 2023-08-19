<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Referensi extends CI_Controller {

	 
	 
	function __construct()
	{
		parent::__construct();	
		$this->m_konfig->validasi_session(array("admin_data","super_admin","pimpinan_pusat"));
		$this->load->model("model","mdl");
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
	function pekerjaan(){
		$ajax=$this->input->post("ajax");
		$data["tbl"] = "tr_pekerjaan";
		$data["reff"] = "Data pekerjaan";
		if($ajax=="yes")
		{
			echo	$this->load->view("datatable",$data);
		}else{
			$data['konten']="datatable";
			$this->_template($data);
		}
	}
	public function index()
	{
		 	
		$ajax=$this->input->post("ajax");
		if($ajax=="yes")
		{
			echo	$this->load->view("master");
		}else{
			$data['konten']="master";
			$this->_template($data);
		}
		
	} 
	 
	 
	 
	 ///-----------------------mitra PENILIAAN--------------------------///
	function getDataMaster()
	{
		if(!$this->input->post("draw")){ echo $this->m_reff->page403(); return false;}
		$list = $this->mdl->get_data_master();
		$data = array();
		$no = $this->input->post("start");
		$no =$no+1;
		foreach ($list as $dataDB) {
		////
	 
		 
		 $tombol='<div class="demo-button-groups">
                                <div class="btn-group" role="group">
                                    <button type="button" onclick="edit(`'.$dataDB->id.'`)" class="btn btn-primary btn-sm waves-effect waves-light">EDIT</button>
                                    <button type="button" onclick="hapus(`'.$dataDB->id.'`)" class="btn btn-danger btn-sm waves-effect waves-light">HAPUS</button>
                                    
                                </div>
                                
                            </div>';
			 		
		 
		 
			$row = array();
	 
			$row[] = "<span class='size'>  ".$dataDB->id." </span>";
			
			$row[] = "<span class='size'>  ".$dataDB->title." </span>"; 
			$row[] = "<span class='size'>  ".$dataDB->val." </span>"; 
		 
			 
			$row[] = $tombol;
		  
			$data[] = $row; 
			
			}
			 
		$output = array(
						"draw" => $this->input->post("draw"),
						"recordsTotal" => $c=$this->mdl->count_master(),
						"recordsFiltered" =>$c,
						"data" => $data,
						);
		//output to json format
		echo json_encode($output);

	}
	
	 
	 
 
	function getData()
	{
		if(!$this->input->post("draw")){ echo $this->m_reff->page403(); return false;}
		$list = $this->mdl->get_data();
		$data = array();
		$no = $this->input->post("start");
		$no =$no+1;
		foreach ($list as $dataDB) {
		////
	 
		 
		 $tombol='<div class="demo-button-groups">
                                <div class="btn-group" role="group">
                                    <button type="button" onclick="edit(`'.$dataDB->id.'`)" class="btn btn-primary btn-sm waves-effect waves-light">EDIT</button>
                                    <button type="button" onclick="hapus(`'.$dataDB->id.'`)" class="btn btn-danger btn-sm waves-effect waves-light">HAPUS</button>
                                    
                                </div>
                                
                            </div>';
			 		
		 
		 
			$row = array();
	 
			$row[] = "<span class='size'>  ".$dataDB->id." </span>";
			$row[] = "<span class='size'>  ".$dataDB->nama." </span>"; 
			 
			$row[] = $tombol;
		  
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
	
	 
	//-------------------------------------------------END SISWA------------------------------------//
	function idu()
	{
		return $this->session->userdata("id");
	}
	  
	  
	function viewAddMaster()
	{
		echo $this->load->view("viewAddMaster");
	}
	function viewEditMaster()
	{
		$id=$this->input->post('id');
		if(!$id){ return $this->m_reff->page403();}

		echo $this->load->view("viewEditMaster");
	} 
	function insert_master()
	{
		$f=$this->input->post('f');
		if(!$f){ return $this->m_reff->page403();}
		
		echo json_encode($this->mdl->insert_master());
	}
	 function update_master()
	{
		$f=$this->input->post('f');
		if(!$f){ return $this->m_reff->page403();}

		echo json_encode($this->mdl->update_master());
	}
	
	 
	  
	function hapus_master()
	{
		$id=$this->input->post("id");
		if(!$id){ return $this->m_reff->page403();}

		$data=$this->mdl->hapus_master($id);
		echo json_encode($data);
	}
	function hapus()
	{
		$id=$this->input->post("id");
		if(!$id){ return $this->m_reff->page403();}

		$tbl=$this->input->post("tbl");
		$data=$this->mdl->hapus($id,$tbl);
		echo json_encode($data);
	}
	function viewEdit()
	{
		$id=$this->input->post("id");
		if(!$id){ return $this->m_reff->page403();}

		$data["data"]=$this->load->view("viewEdit",null,TRUE);
		$data["token"]=$this->m_reff->getToken();
		echo json_encode($data);
	}
	function viewAdd()
	{
		$f=$this->input->post();
		if(!$f){ return $this->m_reff->page403();}

		$data["data"]=$this->load->view("viewAdd",null,TRUE);
		$data["token"]=$this->m_reff->getToken();
		echo json_encode($data);
	}
	function update()
	{	
		$f=$this->input->post('f');
		if(!$f){ return $this->m_reff->page403();}

		$data["data"]=$this->mdl->update();
		$data["token"]=$this->m_reff->getToken();
		echo json_encode($data);
	}
	function insert()
	{	
		$f=$this->input->post('f');
		if(!$f){ return $this->m_reff->page403();}
		
		$data["data"]=$this->mdl->insert();
		$data["token"]=$this->m_reff->getToken();
		echo json_encode($data);
	}
}