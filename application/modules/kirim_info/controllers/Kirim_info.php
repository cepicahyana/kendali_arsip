<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kirim_info extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->m_konfig->validasi_session(array("admin_ppnpn","pic_ppnpn","pimpinan_ppnpn"));
		$this->load->model("model","mdl");
		date_default_timezone_set('Asia/Jakarta');
	}

	function _template($data)
	{
		$this->load->view('temp_admin_ppnpn/main',$data);
	}


	public function index()
	{
		$ajax=$this->input->get_post("ajax");
		if($ajax=="yes")
		{
			$var["data"]=$this->load->view("index",NULL,TRUE);
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
		}else{
			$data['header']="Informasi ";
			$data['konten']="index";
			$this->_template($data);
		}

	}
	function getData(){
		if(!$this->input->post("draw")){ echo $this->m_reff->page403(); return false;}
		$list = $this->mdl->getData();
		$data = array();
		$no = $this->input->post('start');
		$no = $no+1;
		foreach ($list as $dataDB) {

			if($dataDB->sts==1){
				$status ="Publish";
			}else{
				$status ="Draft";
			}


			 $id	= $dataDB->id;
			 $action		 =	'<div class="btn-group" role="group"  >
								 <button onclick="hapus(`'.$id.'`,`'.$dataDB->judul.'`)" type="button" class="btn bg-grey  btn-sm waves-effect waves-light ti-trash"> <i title="hapus" class="ri-delete-bin-7-fill"></i>   </button>
								<button onclick="edit(`'.$id.'`)" type="button" class="btn bg-teal  btn-sm waves-effect waves-light ti-pencil-alt"> <i class="ri-edit-2-fill"></i> Edit </button>

                  </div>';
				
				  if($dataDB->type_file==1){
					  $file = $this->m_reff->pengaturan(1)."info/".$dataDB->file_name;
					  $file="<img width='140px' src='".$this->konversi->img($file)."'/>";
				  }elseif($dataDB->type_file==2){
						$file = base_url()."info/".$dataDB->file_name;
					  $file='
					  <video  width="100%"  height="240" controls>
					<source src="'.$file.'" type="video/mp4">
					
				  Your browser does not support the video tag.
				  </video>
					  ';
				  }elseif($dataDB->type_file==3){
						$file = base_url()."download?f=".$this->m_reff->encrypt("info/".$dataDB->file_name);
					  $file='<a style="max-width:130px" target="_blank" class="  font14 btn btn-sm btn-light ti-reload " href="'.$file.'"> Download  </a> ';
				  }else{
					$file=null;
				  }
				  


			$row = array();
			$row[] = $no++;
			$row[] = $dataDB->tgl;
			$row[] = $file;
			$row[] = $dataDB->judul;
			$row[] = $dataDB->isi;
			$row[] = $status;
			$row[] = $action;

			//add html for action
			$data[] = $row;
			}

		//$csrf_name = $this->security->get_csrf_token_name();
		//$csrf_hash = $this->security->get_csrf_hash();
		$output = array(
		"draw" => $this->input->post('draw'),
		"recordsTotal" => $c=$this->mdl->count(),
		"recordsFiltered" =>$c,
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
	function form_edit(){
		$id=$this->input->post('id');
		if(!$id){ return $this->m_reff->page403();}
		$var["data"]=$this->load->view("form_edit","",TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var); 
	}

	function insert(){
		$f=$this->input->post('f');
		if(!$f){ return $this->m_reff->page403();}
		$var = $this->mdl->insert();
		echo json_encode($var);

	}
	function hapus(){
		$id=$this->input->post('id');
		if(!$id){ return $this->m_reff->page403();}
		$var = $this->mdl->hapus();
		echo json_encode($var);
	}
	function update(){
		$f=$this->input->post('f');
		if(!$f){ return $this->m_reff->page403();}
		$var = $this->mdl->update();
		echo json_encode($var);
	}
}
