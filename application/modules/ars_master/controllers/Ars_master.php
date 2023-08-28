<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ars_master extends CI_Controller {

 
	function __construct()
	{
		parent::__construct();	
		$this->m_konfig->validasi_session(array("admin_arsip","up","uk"));
		$this->load->model("model","mdl");
		 
		date_default_timezone_set('Asia/Jakarta');
	}

	function _template($data)
	{
		$this->load->view('temp_arsip/main',$data);	
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

	


	public function tingkat_perkembangan()
	{

		$ajax=$this->input->post("ajax");
		$var["title"]		=	"Tingkat perkembangan";
		$var["subtitle"]	=	"Master / Tingkat perkembangan";
		if($ajax=="yes")
		{
			$var["data"]=$this->load->view("tingkat_perkembangan",null,true);
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
		}else{
			$var['konten']="tingkat_perkembangan";
			$this->_template($var);
		}
		
	}  

	 

	function update_tingkat_perkembangan(){
		$f=$this->input->post();
		if(!$f){ return $this->m_reff->page403();}

		$data = $this->mdl->update_tingkat_perkembangan();
		echo json_encode($data);
	}

	 

	function hapus_tingkat_perkambangan(){
		$id = $this->m_reff->san($this->input->post("id"));
		if(!$id){ return $this->m_reff->page403();}

		$data = $this->mdl->hapus_tingkat_perkambangan();
		echo json_encode($data);
	}
   

	 

	function getData_tingkaPerkembangan()
	{
		if(!$this->m_reff->san($this->input->post("draw"))){ echo $this->m_reff->page403(); return false;}
		$list = $this->mdl->getData_tingkaPerkembangan();
		$data = array();
		$no = $this->m_reff->san($this->input->post("start"));
		$no =$no+1;
		foreach ($list as $val) {
         ////

		 $tombol='<div aria-label="Basic example" class="btn-groupss" role="group">
		 <button   onclick="action_form(`'.$val->id.'`,`'.$val->nama.'`)" class="font14 btn btn-sm ti-pencil btn-secondary" type="button"> Edit</button> 
		 <button style="color:white" onclick="hapus(`'.$val->id.'`,`'.$val->nama.'`)" class="font14 btn btn-sm ti-trash bg-danger" type="button"> Hapus</button> 
		 </div>';
 

		 $row = array();
		 $row[] = $no++;	
		 $row[] = $val->nama;
		 
		 $row[] = $tombol;
		 $data[] = $row; 

		}

		$output = array(
			"draw" => $this->m_reff->san($this->input->post("draw")),
			"recordsTotal" => $c=$this->mdl->count_tingkaPerkembangan(),
			"recordsFiltered" =>$c,
			"data" => $data,
			"token"=>$this->m_reff->getToken()
		);
         //output to json format
		echo json_encode($output);

	}

	function form_tingkat_perkembangan(){ 
		$var["data"]=$this->load->view("form_tingkat_perkembangan",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}
 

}