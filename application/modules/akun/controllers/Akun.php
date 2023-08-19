<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Akun extends MY_Controller {

	 
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
	function verifikator()
	{
		$this->index();
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
	 public function distributor()
	{
		 	
		$ajax=$this->input->post("ajax");
		if($ajax=="yes")
		{
			echo	$this->load->view("distributor");
		}else{
			$data['konten']="distributor";
			$this->_template($data);
		}
		
	}
	 
	 
	
	 
	///-----------------------SISWA--------------------------///
 
	 
	
	///-----------------------mitra PENILIAAN--------------------------///
	function getData()
	{	if(!$this->input->post("draw")){ echo $this->m_reff->page403(); return false;}
		$list = $this->mdl->get_data();
		$data = array();
		$no = $this->input->post("start");
		
		$no =$no+1;
		foreach ($list as $dataDB) {
		////
	 
		if($dataDB->sts_aktivasi=="enable")
		{
			$sts="<span class='text-primary'>Aktif</span>";
		}else{
			$sts="<span class='text-danger'>Non-aktif</span>";
		}
		 $tombol='<div class="demo-button-groups">
                                <div class="btn-group" role="group">
                                    <button type="button" onclick="edit(`'.$dataDB->id_admin.'`)" class="btn btn-primary btn-sm waves-effect waves-light">EDIT</button>
                                    <button type="button" onclick="hapus(`'.$dataDB->id_admin.'`,`'.$dataDB->owner.'`)" class="btn btn-danger btn-sm waves-effect waves-light">HAPUS</button>
                                    
                                </div>
                                
                            </div>';
			 		
			$level	= $this->m_reff->goField("main_level","nama","where id_level='".$dataDB->level."'");
			$level	=	str_replace("user","admin",$level);
		 
			$row = array();
			$row[] = "<span class='size'>".$no++."</span>";	
			$row[] = "<span class='size'>  ".$dataDB->owner." </span>";
			$row[] = "<span class='size'>  ".$dataDB->nip." </span>";
			$row[] = "<span class='size'>  ".$level." </span>"; 
			$row[] = "<span class='size'>  ".$sts."   </span>";
		 
			 
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
	  
	 
	function viewAdd()
	{
		echo $this->load->view("viewAdd");
	}
	function viewEdit()
	{
		echo $this->load->view("viewEdit");
	}
	function insert($level=null)
	{
		echo json_encode($this->mdl->insert($level));
	}
	function update()
	{
		echo json_encode($this->mdl->update());
	}
	function set()
	{
		echo $this->mdl->set();
	}
	
	
	function hapus()
	{
		$this->m_reff->log("hapus akun","data");
		$id=$this->input->post("id");
		if(!$id){return false;}
		echo $this->mdl->hapus($id);
	}
	 
	function save_bursa()
	{
	$data=$this->mdl->save_bursa();
	echo json_encode($data);
	}
	function hapus_bursa()
	{
	$data=$this->mdl->hapus_bursa();
	echo json_encode($data);
	}
}