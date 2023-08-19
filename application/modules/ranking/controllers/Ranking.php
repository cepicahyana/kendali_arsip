<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ranking extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->m_konfig->validasi_session(array("admin_ppnpn", "pic_ppnpn","pimpinan_ppnpn","super_admin"));
		$this->load->model("model", "mdl");
		date_default_timezone_set('Asia/Jakarta');
	}

	function _template($data)
	{
		$this->load->view('temp_admin_ppnpn/main', $data);
	}

	function dataPPNPN(){
		echo json_encode($this->mdl->dataPPNPN());
	}
	function download(){
		$data["id"] = $this->input->get("id");
		$html = $this->load->view("download",$data,true);
		// return false;
		$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4','margin_top' => 10, 'margin_bottom' => 15, 'margin_left' => 15, 'margin_right' => 15]);
		// $mpdf->SetDisplayMode('fullpage');
		// $mpdf->setFooter('Page {PAGENO} of {nbpg}');
		$mpdf->WriteHTML($html);
		ob_end_clean();
		$mpdf->Output("nilai.pdf", "I");
	}

	public function index()
	{
		$ajax = $this->input->get_post("ajax");
		if ($ajax == "yes") {
			$data['header'] = "Ranking Kinerja Pegawai PPNPN";

			$var["data"]=$this->load->view("index",$data,TRUE);
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
		} else {
			$data['header'] = "Ranking Kinerja Pegawai PPNPN";
			$data['konten'] = "index";
			$this->_template($data);
		}
	}
	function getData()
	{
		if(!$this->input->post("draw")){ echo $this->m_reff->page403(); return false;}

	 

		$list = $this->mdl->getData();
		$data = array();
		$no = $this->input->post('start');
		$no = $no + 1;
		foreach ($list as $dataDB) {

			$row = array();
			$row[] = $no++;

			$row[] = "<span class='text-primary cursor' onclick='goGrafik(`".$dataDB->nip."`)'>".$dataDB->nama.'</span>';
			$row[] = $this->mdl->bagian($dataDB->nip);
			$row[] = $dataDB->nip;
			$row[] = isset($dataDB->hasil_evaluasi)?($dataDB->hasil_evaluasi):"<i class='text-danger'>Belum dinilai</i>";
			$row[] = isset($dataDB->predikat)?($this->m_reff->predikat($dataDB->predikat)):"<i class='text-danger'>Belum dinilai</i>";
			//$row[] = $action;
			$row[] = "<a target='_blank' href='".base_url()."ranking/download?id=".$dataDB->id."'>Download</a>";
			//add html for action
			$data[] = $row;
		}

		//$csrf_name = $this->security->get_csrf_token_name();
		//$csrf_hash = $this->security->get_csrf_hash(); 
		$output = array(
			"draw" => $this->input->post('draw'),
			"recordsTotal" => $c = $this->mdl->count(),
			"recordsFiltered" => $c,
			"data" => $data,
			"token"=>$this->m_reff->getToken()
		);
		//output to json format
		//$output[$csrf_name] = $csrf_hash;
		echo json_encode($output);
	}

	function goGrafik(){
		$nip=$this->input->post("nip");
		// if(!$nip){ return $this->m_reff->page403();}

		$var["data"]=$this->load->view("grafik",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}
}
