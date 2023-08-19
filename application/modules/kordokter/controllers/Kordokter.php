<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kordokter extends MY_Controller {

    function __construct()
	{
		parent::__construct();	
		$this->m_konfig->validasi_session(array("kordokter"));
		$this->load->model("model","mdl");
		date_default_timezone_set('Asia/Jakarta');
	}

    function _template($data)
	{
        $this->load->view('temp_main/main', $data);	
	}
 
	public function index()
	{
		$ajax = $this->input->get_post("ajax");
		if ($ajax == "yes") {
			$var["data"] = $this->load->view("index", NULL, TRUE);
			$var["token"] = $this->m_reff->getToken();
			echo json_encode($var);
		} else {
			$data['konten'] = "index";
			$this->_template($data);
		}
	}

	function reload_status()
	{
		$var["data"] = $this->load->view("reload_status", NULL, TRUE);
		$var["token"] = $this->m_reff->getToken();
		echo json_encode($var);
	}

	function akhiri_obrolan()
	{
		$id = $this->input->post('id');
		if(!$id){ return $this->m_reff->page403();}
		$var["data"] = $this->mdl->akhiri_obrolan();
		$var["token"] = $this->m_reff->getToken();
		echo json_encode($var);
	}

	function tanggapi()
	{
		$id = $this->input->post('id');
		if(!$id){ return $this->m_reff->page403();}
		$var["data"] = $this->load->view("tanggapi", NULL, TRUE);
		$var["token"] = $this->m_reff->getToken();
		echo json_encode($var);
	}

	function chat_list()
	{
		$id = $this->input->post('id');
		if(!$id){ return $this->m_reff->page403();}
		$var["data"]  = $this->load->view("chat_list", NULL, TRUE);
		$var["token"] = $this->m_reff->getToken();
		echo json_encode($var);
	}

	public function arsip()
	{
		$ajax = $this->input->get_post("ajax");
		if ($ajax == "yes") {
			$var["data"] = $this->load->view("arsip", NULL, TRUE);
			$var["token"] = $this->m_reff->getToken();
			echo json_encode($var);
		} else {
			$data['konten'] = "arsip";
			$this->_template($data);
		}
	}

	function reload_arsip()
	{
		$var["data"] = $this->load->view("reload_arsip", NULL, TRUE);
		$var["token"] = $this->m_reff->getToken();
		echo json_encode($var);
	}

	function tanggapi_arsip()
	{
		$id = $this->input->post('id');
		if(!$id){ return $this->m_reff->page403();}
		$var["data"] = $this->load->view("tanggapi_arsip", NULL, TRUE);
		$var["token"] = $this->m_reff->getToken();
		echo json_encode($var);
	}

	function chat_list_arsip()
	{
		$id = $this->input->post('id');
		if(!$id){ return $this->m_reff->page403();}
		$var["data"]  = $this->load->view("chat_list_arsip", NULL, TRUE);
		$var["token"] = $this->m_reff->getToken();
		echo json_encode($var);
	}

	function data_dokter()
	{
		$ajax = $this->input->get_post("ajax");
		if ($ajax == "yes") {
			$var["data"] = $this->load->view("data_dokter", NULL, TRUE);
			$var["token"] = $this->m_reff->getToken();
			echo json_encode($var);
		} else {
			$data['konten'] = "data_dokter";
			$this->_template($data);
		}
	}

	function getDataDokter(){
		if(!$this->input->post("draw")){ echo $this->m_reff->page403(); return false;}
		$list = $this->mdl->get_data();
		$data = array();
		$no = $this->input->post("start");
		$no =$no+1;
		foreach ($list as $dataDB) {
		    
		$row = array();
		// $row[] =  $no++;	
		$row[] = $no++;
		$row[] = $dataDB->nama;
		$row[] = strtoupper($dataDB->jk);
		$row[] = $dataDB->telp;
		$row[] = $dataDB->email;
			
		
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
































	function saveChat()
	{
		$this->mdl->saveChat();
		$group_tgl = $date = date("Y-m-d H:i");
		$content = $this->input->post("msg");
		if (!$content) {
			return false;
		}
		$this->db->order_by("id","desc");
		$this->db->where("id_sender",$this->m_reff->idu());
		$this->db->where("id_msg",$this->input->post("id_msg"));
		$val = $this->db->get("data_komentar")->row();

		$isi = '	<div class="media flex-row-reverse" id="msg'.$val->id.'">
<div class="main-img-user online"><img alt="" src="assets/dokter_'.$this->m_reff->dokter_jk().'.png">                </div>
<div class="media-body">
	<div class="main-msg-wrapper">
	' . $content . '
			</div>
	<div>
		<span>
		' . date('H:i:s'). ' 
		</span> <a href="javascript:hapus_chat(`'.$val->id.'`)" class="text-danger"><i class="icon ion-android-more-horizontal"></i>.Hapus</a>
			</div>
		</div>
</div>
';
		$var["data"] = $isi;
		$var["token"] = $this->m_reff->getToken();
		echo json_encode($var);
	}

	function lihat_obrolan()
	{
		$var["data"] = $this->load->view("lihat_obrolan", null, TRUE);
		$var["token"] = $this->m_reff->getToken();
		echo json_encode($var);
	}

}