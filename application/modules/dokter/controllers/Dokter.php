<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dokter extends MY_Controller
{



	function __construct()
	{
		parent::__construct();
		$this->m_konfig->validasi_session(array("dokter"));
		$this->load->model("model", "mdl");
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
			$var["data"] = $this->load->view("beranda", NULL, TRUE);
			$var["token"] = $this->m_reff->getToken();
			echo json_encode($var);
		} else {
			$data['konten'] = "beranda";
			$this->_template($data);
		}
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
	function hapus_status()
	{
		$id=$this->input->post('id');
		if(!$id){ return $this->m_reff->page403();}

		$this->mdl->hapus_status();
		$var["token"] = $this->m_reff->getToken();
		echo json_encode($var);
	}
	 
	function reload_status()
	{
	
		$var["data"] = $this->load->view("reload_status", NULL, TRUE);
		$var["token"] = $this->m_reff->getToken();
		echo json_encode($var);
	}
	function reload_arsip()
	{

		$var["data"] = $this->load->view("reload_arsip", NULL, TRUE);
		$var["token"] = $this->m_reff->getToken();
		echo json_encode($var);
	}
	function tanggapi()
	{
		$id=$this->input->post('id');
		if(!$id){ return $this->m_reff->page403();}

		$var["data"] = $this->load->view("tanggapi", NULL, TRUE);
		$var["token"] = $this->m_reff->getToken();
		echo json_encode($var);
	}
	function tanggapi_arsip()
	{
		$id=$this->input->post('id');
		if(!$id){ return $this->m_reff->page403();}

		$var["data"] = $this->load->view("tanggapi_arsip", NULL, TRUE);
		$var["token"] = $this->m_reff->getToken();
		echo json_encode($var);
	}

	function chat_new()
	{
		$ajax = $this->input->get_post("ajax");
		if ($ajax == "yes") {
			$var["data"] = $this->load->view("index", NULL, TRUE);
			//$var["token"] = $this->m_reff->getToken();
			echo json_encode($var);
		} else {
			$data['konten'] = "index";
			$this->_template($data);
		}
	}

	function chat_list()
	{
		$id=$this->input->post('id');
		if(!$id){ return $this->m_reff->page403();}

		$var["data"]  = $this->load->view("chat_list", NULL, TRUE);
		$var["token"] = $this->m_reff->getToken();
		echo json_encode($var);
	}
	function chat_list_arsip()
	{
		$id=$this->input->post('id');
		if(!$id){ return $this->m_reff->page403();}

		$var["data"]  = $this->load->view("chat_list_arsip", NULL, TRUE);
		$var["token"] = $this->m_reff->getToken();
		echo json_encode($var);
	}

	function chat_replay()
	{
		$idu	=	 $this->session->userdata("id");
		if(!$idu){ return $this->m_reff->page403();}

		//$this->db->where("(sender='" . $this->input->post("sender") . "' and receiver='" . $idu . "')");
		$this->db->where("id_sender !=", $idu);
		$this->db->where("id_msg", $this->input->post("id_msg"));
		$this->db->where("sts_baca", 0);
		$this->db->order_by("tgl", "asc");
		$data =	$this->db->get("data_komentar")->result();
		$isi = "";
		$var["isi"]	= "";
		foreach ($data as $val) {


			$isi .= '
		   <div class="media">
		   <div class="main-img-user online"><img alt="" src="' . base_url() . '/assets/l.png"></div>
		   <div class="media-body">
			   <div class="main-msg-wrapper">
			   ' . $val->msg . '
			   </div>
			 
				<div>
				   <span>' . $this->tanggal->hariLengkapJam($val->tgl, "/") . '</span> <a href=""><i class="icon ion-android-more-horizontal"></i></a>
					   </div>
				   </div>
				</div>';

			$this->mdl->updateStsChat($val->id);
		}
			$var["isi"] = $isi;
			$var["token"] = $this->m_reff->getToken();
		echo json_encode($var);
	}

	function saveChat()
	{	
		$f=$this->input->post('id_msg');
		if(!$f){ return $this->m_reff->page403();}

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



	function kirim_balasan()
	{
		$msg	=	 $this->input->post("msg");
		if ($msg) {
			$this->mdl->kirim_balasan();
			$var["data"] = $this->load->view("konten_balasan", NULL, TRUE);
		}
		$var["token"] = $this->m_reff->getToken();
		echo json_encode($var);
	}



	function kirim_status()
	{
		$msg	=	 $this->input->post("msg");
		if ($msg) {
			$hasil = $this->mdl->kirim_status();
			//  $id	= $this->m_reff->goField("update_status","id","where id_sender='".$this->m_reff->idu()."' order by tgl desc limit 1");
			// $this->load->view("new_status",array("id"=>$id));
			$var["data"] = $hasil; //$this->load->view("new_status",array("id"=>$id),TRUE);
		}

		$var["token"] = $this->m_reff->getToken();
		echo json_encode($var);
		// return false;
	}


	function getNewReplay()
	{
		$var["data"] = $this->load->view("getNewReplay", null, TRUE);
		$var["token"] = $this->m_reff->getToken();
		echo json_encode($var);
	}

	function akhiri_obrolan()
	{
		$id=$this->input->post('id');
		if(!$id){ return $this->m_reff->page403();}

		$var["data"] = $this->mdl->akhiri_obrolan();
		$var["token"] = $this->m_reff->getToken();
		echo json_encode($var);
	}
	function page_status()
	{
		$var["data"] = $this->load->view("page_status", null, TRUE);
		// $var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}
	function lihat_obrolan()
	{
		$var["data"] = $this->load->view("lihat_obrolan", null, TRUE);
		$var["token"] = $this->m_reff->getToken();
		echo json_encode($var);
	}
	function hapus_com()
	{
		$id=$this->input->post('id');
		if(!$id){ return $this->m_reff->page403();}
		
		$this->mdl->hapus_com();
		$var["token"] = $this->m_reff->getToken();
		echo json_encode($var);
	}
}
