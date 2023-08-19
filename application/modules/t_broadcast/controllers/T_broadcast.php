<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class T_broadcast extends MY_Controller {

	 
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
	$this->load->view('temp_user/main',$data);	
	}
	 
	function viewEdit()
	{
		$id=$this->input->post('id');
		if(!$id){ return $this->m_reff->page403();}
		echo $this->load->view("viewEdit");
	}	 
	function viewAddEmail()
	{
		$f=$this->input->post();
		if(!$f){ return $this->m_reff->page403();}
		echo $this->load->view("viewAdd_email");
	}  
	 	function viewAddWa()
	{
		$f=$this->input->post();
		if(!$f){ return $this->m_reff->page403();}
		echo $this->load->view("viewAdd_wa");
	}  
	function simpanBroadcast_wa(){
		$cekKonten =$this->input->post('konten');
		if(!$cekKonten){ return $this->m_reff->page403();}
		echo $this->mdl->simpanBroadcast_wa();
	}	
	 function simpanBroadcast_email(){
		$cekKonten =$this->input->post('konten');
		if(!$cekKonten){ return $this->m_reff->page403();}
		echo $this->mdl->simpanBroadcast_email();
	} function update(){
		$id =$this->input->post('id');
		if(!$id){ return $this->m_reff->page403();}
		echo $this->mdl->update();
	}	
	  function hapus(){
		$id =$this->input->post('id');
		if(!$id){ return $this->m_reff->page403();}
		echo $this->mdl->hapus();
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
	 
		if($dataDB->type==1)
		{	
			$sts="<span class='text-danger'>Email</span>";
		}else{
			$sts="<span class='text-info'>Whatsapp</span>";
		}
		 $tombol='<div class="demo-button-groups">
                                <div class="btn-group" role="group">
                                    <button type="button" onclick="edit(`'.$dataDB->id.'`,`'.$dataDB->type.'`)" class="btn btn-primary btn-sm waves-effect waves-light">EDIT</button>
                                    <button type="button" onclick="hapus(`'.$dataDB->id.'`,`'.$dataDB->subject.'`)" class="btn btn-danger btn-sm waves-effect waves-light">HAPUS</button>
                                    
                                </div>
                                
                            </div>';
			 		
			 
			$row = array();
			$row[] = "<span class='size'>".$no++."</span>";	
			$row[] = "<span class='size'>  ".$sts." </span>";
			$row[] = "<span class='size'>  ".$dataDB->subject." </span>";
			$row[] = "<span class='size'>  ".$dataDB->real." </span>";
			 
			 
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
	
	 
	//------------------------------------------- -----------------------------------//
	 
	 
	  
	 
}