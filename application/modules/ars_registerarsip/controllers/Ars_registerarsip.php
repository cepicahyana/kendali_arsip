<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ars_registerarsip extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->m_konfig->validasi_session(array("super_admin","admin_arsip","up","uk"));
		$this->load->model("model","mdl");
		date_default_timezone_set('Asia/Jakarta');
	}
	
	function _template($data)
	{ 
		$tempMain = 'temp_arsip'; 
		$this->load->view($tempMain.'/main',$data);	
	}

	public function index()
	{
		$ajax=$this->input->get_post("ajax");
		$var["title"] = "Home";
		$var["subtitle"] = "Arsip";
		if($ajax=="yes")
		{
			$var["data"]=$this->load->view("index",null,true);
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
		}else{
			$var['konten']="index";
			$this->_template($var);
		}		
	}

	function getData_arsiplist()
	{
		if(!$this->m_reff->san($this->input->post("draw"))){ echo $this->m_reff->page403(); return false;}
		$list = $this->mdl->getData_arsiplist();
		$data = array();
		$no = $this->m_reff->san($this->input->post("start"));
		$no =$no+1;
		foreach ($list as $val) {
         ////

		//  $tombol='<div aria-label="Basic example" class="btn-groupss" role="group">
		//  <button   onclick="action_form(`'.$val->id.'`,`'.$val->nama.'`)" class="font14 btn btn-sm ti-pencil btn-secondary" type="button"> Edit</button> 
		//  <button style="color:white" onclick="hapus(`'.$val->id.'`,`'.$val->nama.'`)" class="font14 btn btn-sm ti-trash bg-danger" type="button"> Hapus</button> 
		//  </div>';
 

		 $row = array();
		 $row[] = $no++;	
		 $row[] = ($this->input->post('type') != 3) ? $val->kka : "-";
		 if ($this->input->post('type') != 3) $row[] = ($val->jenis == 1) ? "Arsip Konvensial" : (($val->jenis == 2) ? "Arsip Elektronik" : "Arsip Audio Visual");
		 $row[] = $val->kurun_waktu;
		 $row[] = $val->tingkat_perkembangan;
		 $row[] = $val->jumlah;
		 $row[] = $val->deskripsi;

		 
		//  $row[] = $tombol;
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

	public function form_arsip()
	{
		$ajax=$this->input->get_post("ajax");
		$var["title"] = "Home";
		$var["subtitle"] = "Arsip";
		$var['konten'] = "form_arsip";
		$var["token"] = $this->m_reff->getToken();
		$this->_template($var);
	}
	
	function update_arsip(){
		$f=$this->input->post();
		if(!$f){ return $this->m_reff->page403();}
		$var["data"] = $this->mdl->update_arsip();
		echo json_encode($var);
	}

	// function form_arsip(){ 
	// 	$var["data"]=$this->load->view("form_arsip",NULL,TRUE);
	// 	$var["token"]=$this->m_reff->getToken();
	// 	echo json_encode($var);
	// }

	function get_page(){ 
		$type = $this->input->post("type");
		if($type==1) {
			$page = "mini_form_konvensional";
		}elseif($type==2) {
			$page = "mini_form_elektronik";
		}elseif($type==3) {
			$page = "mini_form_film";
		}elseif($type==4) {
			$page = "mini_form_foto";
		}else {
			$page = "mini_form_audio";
		}
		$var["data"]=$this->load->view($page,NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}

	function get_parent_klasifikasi_arsip(){
	    $action = $this->input->post('action');
		$kode = $this->input->post('kd');
		$jmlkode=strlen($kode);
		if($action=='form'){
			$list = '<option value="">=== Pilih ===</option>';
		}else{
			$list = '<option value="">=== Pilih ===</option>';
		}

        $db = $this->db->order_by('description','ASC');
		$db = $this->db->get_where('ars_tr_uk',array('type'=>$kode))->result();
		foreach($db as $val)
		{
			$list .= "<option value='" . $val->uuid . "'>" . $val->description . "</option>";
		}
		$var["data"]=$list;
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}

	function get_jra(){ 
		$id = $this->input->post("id");
		$data = $this->mdl->getData_JRA($id);
		$var["data"] = $data;
		echo json_encode($var);
	}
}