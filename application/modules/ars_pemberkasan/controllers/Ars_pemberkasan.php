<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ars_pemberkasan extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->m_konfig->validasi_session(array("admin_arsip"));
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
		$var["subtitle"] = "Dashboard";
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

	function getData_berkaslist()
	{
		if(!$this->m_reff->san($this->input->post("draw"))){ echo $this->m_reff->page403(); return false;}
		$list = $this->mdl->getData_berkaslist();
		$data = array();
		$no = $this->m_reff->san($this->input->post("start"));
		$no =$no+1;
		foreach ($list as $val) {
			//  $tombol='<div aria-label="Basic example" class="btn-groupss" role="group">
			//  <button   onclick="action_form(`'.$val->id.'`,`'.$val->nama.'`)" class="font14 btn btn-sm ti-pencil btn-secondary" type="button"> Edit</button> 
			//  <button style="color:white" onclick="hapus(`'.$val->id.'`,`'.$val->nama.'`)" class="font14 btn btn-sm ti-trash bg-danger" type="button"> Hapus</button> 
			//  </div>';

			$row = array();
			$row[] = $no++;	
			$row[] = $val->kka;
			$row[] = $val->uraian_informasi;
			$row[] = $val->kurun_waktu;
			$row[] = $val->tingkat_perkembangan;
			$row[] = "";
			$row[] = "";
			if ($this->input->post('type') == 0) {
				$row[] = "";
				$row[] = "";
				$row[] = "";
			}
			
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

	function getData_arsiplist()
	{
		if(!$this->m_reff->san($this->input->post("draw"))){ echo $this->m_reff->page403(); return false;}
		$list = $this->mdl->getData_arsiplist();
		$data = array();
		$no = $this->m_reff->san($this->input->post("start"));
		$no =$no+1;
		foreach ($list as $val) {
			//  $tombol='<div aria-label="Basic example" class="btn-groupss" role="group">
			//  <button   onclick="action_form(`'.$val->id.'`,`'.$val->nama.'`)" class="font14 btn btn-sm ti-pencil btn-secondary" type="button"> Edit</button> 
			//  <button style="color:white" onclick="hapus(`'.$val->id.'`,`'.$val->nama.'`)" class="font14 btn btn-sm ti-trash bg-danger" type="button"> Hapus</button> 
			//  </div>';
			$checkbox = "<div class='demo-checkbox'><input type='checkbox' class='checkItem' data-id='{$val->id}' data-nomor='{$val->nomor}' data-kka='{$val->kka}'></div>";
 
			$row = array();
			$row[] = $no++;	
			$row[] = $val->nomor;
			$row[] = $val->kka;
			$row[] = ($val->jenis == 1) ? "Arsip Konvensial" : (($val->jenis == 2) ? "Arsip Elektronik" : "Arsip Audio Visual");
			$row[] = $val->kurun_waktu;
			$row[] = $val->tingkat_perkembangan;
			
			$row[] = $checkbox;
			$data[] = $row; 
		}

		$output = array(
			"draw" => $this->m_reff->san($this->input->post("draw")),
			"recordsTotal" => $c=$this->mdl->count_arsipList(),
			"recordsFiltered" =>$c,
			"data" => $data,
			"token"=>$this->m_reff->getToken()
		);
		//output to json format
		echo json_encode($output);

	}

	public function form_berkas()
	{
		$ajax=$this->input->get_post("ajax");
		$var["title"] = "Home";
		$var["subtitle"] = "Berkas";
		$var['konten'] = "form_berkas";
		$var["token"] = $this->m_reff->getToken();
		$this->_template($var);
	}

	function update_berkas(){
		$f=$this->input->post();
		if(!$f){ return $this->m_reff->page403();}
		$var["data"] = $this->mdl->update_berkas();
		echo json_encode($var);
	}

	function get_page(){ 
		$type = $this->input->post("type");
		if($type==1) {
			$page = "mini_form_konvensional";
		}else{
			$page = "mini_form_elektronik";
		}
		$var["data"]=$this->load->view($page,NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}

	function get_jra(){ 
		$id = $this->input->post("id");
		$data = $this->mdl->getData_JRA($id);
		$var["data"] = $data;
		echo json_encode($var);
	}

	function export()
    {
		$filename = $this->mdl->exportToPdf();
		
        $content = file_get_contents($filename, false);
        // Redirect hasil generate xlsx ke web client
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename='.$filename);
        header('Cache-Control: max-age=0');

        unlink($filename);
        exit($content);
    }
	 
}