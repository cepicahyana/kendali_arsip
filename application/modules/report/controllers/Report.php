<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report extends CI_Controller {

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
	public function pustaka()
	{
		$ajax=$this->input->get_post("ajax");
		if($ajax=="yes")
		{
			$var["data"]	=	$this->load->view("pustaka",null,true);
			$var["token"]	=	$this->m_reff->getToken();
			echo json_encode($var);
		}else{
			$data['konten']	=	"pustaka";
			$this->_template($data);
		}
		
	}

	///-----------------------mitra PENILIAAN--------------------------///
	function getDataPustaka()
	{
		if(!$this->input->post("draw")){ echo $this->m_reff->page403(); return false;}
		$list = $this->mdl->getDataPustaka();
		$data = array();
		$no = $this->input->post("start");
		$no =$no+1;
		foreach ($list as $dataDB) {
		////
	 
		$file = $this->m_reff->encrypt($dataDB->file);
		$path = base_url()."download"; 
		$file = "<a href='".$path."?f=".$file."'> Download </a>";
		 
		 $tombol='<div class="demo-button-groups">
                                <div class="btn-group" role="group">
                                    <button type="button" onclick="edit(`'.$dataDB->id.'`)" class="btn btn-primary btn-sm waves-effect waves-light">EDIT</button>
                                    <button type="button" onclick="hapus(`'.$dataDB->id.'`,`'.$dataDB->nama.'`)" class="btn btn-danger btn-sm waves-effect waves-light">HAPUS</button>
                                    
                                </div>
                                
                            </div>';
			 		
		 
		 
			$row = array();
	 
			$row[] = "<span class=''>  ".$no++." </span>";
			
			$row[] = "<span class=''>  ".$dataDB->nama." </span>"; 
			$row[] = "<span class=''>  ".$dataDB->ket." </span>"; 
			$row[] = "<span class='fa fa-link'>  ".$file." </span>"; 
			$row[] = "<span class=''> ".$tombol."  </span>"; 
		 
			 
			$row[] = $tombol;
		  
			$data[] = $row; 
			
			}
			 
		$output = array(
						"draw" => $this->input->post("draw"),
						"recordsTotal" => $c=$this->mdl->count_pustaka(),
						"recordsFiltered" =>$c,
						"data" => $data,
						);
		//output to json format
		echo json_encode($output);

	}
		 
	function viewEdit_pustaka(){
		$id = $this->input->post('id');
		if(!$id){ return $this->m_reff->page403();}

		$data["data"]=$this->load->view("viewEdit_pustaka",null,TRUE);
		$data["token"]=$this->m_reff->getToken();
		echo json_encode($data);
	}
	function viewAdd_pustaka(){
		$data["data"]=$this->load->view("viewAdd_pustaka",null,TRUE);
		$data["token"]=$this->m_reff->getToken();
		echo json_encode($data);
	}

	function insert_pustaka(){
		$f = $this->input->post('f');
		if(!$f){ return $this->m_reff->page403();}

		$data = $this->mdl->insert_pustaka();
		echo json_encode($data);
	}

	function update_pustaka(){
		$f = $this->input->post('f');
		if(!$f){ return $this->m_reff->page403();}

		$data = $this->mdl->update_pustaka();
		echo json_encode($data);
	}

	function hapus_pustaka(){
		$id = $this->input->post('id');
		if(!$id){ return $this->m_reff->page403();}

		$data = $this->mdl->hapus_pustaka();
		echo json_encode($data);
	}
	 
}