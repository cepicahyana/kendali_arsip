<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Riwayat_obrolan extends MY_Controller {

	

	function __construct()
	{
		parent::__construct();	
		$this->m_konfig->validasi_session(array("pic_covid","admin_covid","super_admin","pimpinan_covid"));
		$this->load->model("model","mdl");
		date_default_timezone_set('Asia/Jakarta');
	 
	}
	
	function _template($data)
	{
	$this->load->view('temp_main/main',$data);	
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
			$data['konten']="index";
			$this->_template($data);
		}
		
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
	  
					$this->db->where("id",$dataDB->id_sender);
		  $dbpeg  = $this->db->get("data_pegawai")->row();
		  $tgl	  = $this->tanggal->hariLengkapJam($dataDB->tgl,"/");
		  $jabatan = isset($dbpeg->jabatan)?($dbpeg->jabatan):"";
	 
		//	$jml_obrolan	=	 $this->mdl->jml_obrolan($dataDB->id);
			// if($jml_obrolan){
			// 	$jawab = "<span class='cursor btn btn-sm btn-info'>".$jml_obrolan." obrolan"."</span>";
			// }else{
				
			// }
			$jawab = "<span class='cursor btn btn-sm btn-secondary'  onclick='replay(`".$dataDB->id."`,`".$dataDB->msg."`)'> Lihat obrolan</span>";
				
			if($dataDB->sts==1){
				$respon_akhir ="Selesai";
			}else{
			  	$respon_akhir ="Berlangsung";
			}
		 
			


			$row = array();
			$row[] =  $no++;	
			$row[] =  $jawab;
			$row[] =  $tgl;	
			$row[] =  isset($dbpeg->nama)?($dbpeg->nama):"";	 
			$row[] =  $jabatan;	 
			
			$row[]  = $respon_akhir;  
			$data[] = $row; 
			
			}
			 
		$output = array(
						"draw" => $this->input->post("draw"),
						"recordsTotal" => $c=$this->mdl->count(),
						"recordsFiltered" =>$c,
						"data" => $data,
						"token"=>$this->m_reff->getToken()
						);
		//output to json format
		echo json_encode($output);

	}
 
	// function upload(){
	// 	$var["data"]=$this->load->view("upload",NULL,TRUE);
	// 	$var["token"]=$this->m_reff->getToken();
	// 	echo json_encode($var);
	// }
 
	// function reupload(){
	// 	$this->load->view("reupload");
	// }

	function upload_file(){
		$kode = $this->input->post("kode");
		if(!$kode){ return $this->m_reff->page403();}

		$echo=$this->mdl->upload_file();
		echo json_encode($echo);
	}

	function hapus_progress(){
		$id = $this->input->post("id");
		if(!$id){
			return $this->m_reff->page403();
		}

		echo $this->mdl->hapus_progress();
	}
	//  function set_update(){
	// 	echo $this->mdl->set_update();
	//  }

	function tanggapi()
	{
		$id = $this->input->post("id");
		if(!$id){
			return $this->m_reff->page403();
		}

		$var["data"] = $this->load->view("tanggapi", NULL, TRUE);
		$var["token"] = $this->m_reff->getToken();
		echo json_encode($var);
	}

	function chat_list()
	{
		$id = $this->input->post("id");
		if(!$id){
			return $this->m_reff->page403();
		}

		$var["data"]  = $this->load->view("chat_list", NULL, TRUE);
		$var["token"] = $this->m_reff->getToken();
		echo json_encode($var);
	}

	function hapus_chat_list()
	{
		$id = $this->input->post("id");
		if(!$id){
			return $this->m_reff->page403();
		}

		$var["data"]  = $this->mdl->hapus_chat_list();
		$var["token"] = $this->m_reff->getToken();
		echo json_encode($var);
	}

	function akhiri_obrolan()
	{
		$id = $this->input->post("id");
		if(!$id){
			return $this->m_reff->page403();
		}

		$var["data"]  = $this->mdl->akhiri_obrolan();
		$var["token"] = $this->m_reff->getToken();
		echo json_encode($var);
	}

	function saveChat()
	{
		$id = $this->input->post("id_msg");
		if(!$id){
			return $this->m_reff->page403();
		}

		$this->mdl->saveChat();
		$data = $this->mdl->getLastChat();
		
		$content = $this->m_reff->san($this->input->post("msg"));
		if (!$content) {
			return false;
		}


		$isi = '	<div class="media flex-row-reverse" id="msg'.$data->id.'">
<div class="main-img-user online"><img alt="" src="assets/dokter_'.$this->m_reff->pic_jk().'.png">                </div>
<div class="media-body">
	<div class="main-msg-wrapper">
	' . $content . '
			</div>
	<div>
		<span>
		' . date('H:i:s'). ' 
		</span> <a class="text-danger" href="javascript:hapus_chat(`'.$data->id.'`)"><i class="icon ion-android-more-horizontal"></i>. Hapus</a>
			</div>
		</div>
</div>
';
		$var["data"] = $isi;
		$var["token"] = $this->m_reff->getToken();
		echo json_encode($var);
	}

}