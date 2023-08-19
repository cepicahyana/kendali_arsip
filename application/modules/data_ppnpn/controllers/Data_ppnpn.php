<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Data_ppnpn extends CI_Controller
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
	function dataAbsen(){
		$var["data"]=$this->load->view("absen",null,true);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}
	function profile()
	{
		$this->load->view("profile");
	}
	function grafik()
	{
		$this->load->view("grafik_penilaian");
		
	}

	
	public function index()
	{
		$ajax = $this->input->get_post("ajax");
		if ($ajax == "yes") {
	 
			$data['jp'] = $this->mdl->getJp();
			$data['header'] = "Data PPNPN";
			// echo $this->load->view("index", $data);
			
			$var["data"]=$this->load->view("index",$data,TRUE);
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
		} else {
		 
			$data['jp'] = $this->mdl->getJp();
			 
			$data['header'] = "Data PPNPN";
			$data['konten'] = "index";
			$this->_template($data);
		}
	}
	function getData()
	{	
		if(!$this->input->post("draw")){ echo $this->m_reff->page403(); return false;}
		$level = $this->session->userdata("level");
		$list = $this->mdl->getData();
		$data = array();
		$no = $this->m_reff->san($this->input->post('start'));
		$no = $no + 1;
		foreach ($list as $dataDB) {
 			// jenjang pendidikan
			$jp = $this->mdl->getJpByid($dataDB->id_jp);
 			
 			$level = $this->session->userdata("level");
 			// status admin
 				$show_btn = '';
			 	if ($level === 'admin_ppnpn') {$show_btn = 'd-none';}

			$id	= $dataDB->id;
			if($level!="pic_ppnpn"){
				$action		 =	'<div class="btn-group" role="group"  >
				<button onclick="detail(`' . $dataDB->nip . '`,`'.$dataDB->nama.'`)" type="button" class="btn bg-grey  btn-sm waves-effect waves-light ti-trash">   Detail  </button>
 </div>';
			}else{
				$action		 =	'<div class="btn-group" role="group"  >
				<button onclick="detail(`' . $dataDB->nip . '`,`'.$dataDB->nama.'`)" type="button" class="btn bg-grey  btn-sm waves-effect waves-light ti-trash">   Detail  </button>
		 
  </div>';
			}
			
			if($dataDB->jk=="l"){
				$jk = "Laki-laki";
			}elseif($dataDB->jk=="p"){
				$jk = "Perempuan";
			}else{
				$jk = "-";
			}	   
			$row = array();
			$row[] = $no++;
			// $bidang = $this->m_umum->bidang($dataDB->id_bidang);
			if($level=="super_admin"){
				$row[] = "<a target='_blank' href='".base_url()."cek_data?nip=".$dataDB->nip."'>".$dataDB->nama."</a>";
			}else{
			$row[] = $dataDB->nama;
			}
			$row[] = $dataDB->bagian;
			$row[] = $dataDB->tmt;
			$row[] = $jk;
			$row[] = $dataDB->no_hp;
			$row[] = $dataDB->email;
			$row[]	= isset($jp->nama) ? ($jp->nama) : "";
			$row[] = $action;

			//add html for action
			$data[] = $row;
		}

		//$csrf_name = $this->security->get_csrf_token_name();
		//$csrf_hash = $this->security->get_csrf_hash(); 
		$output = array(
			"draw" => $this->m_reff->san($this->input->post('draw')),
			"recordsTotal" => $c = $this->mdl->count(),
			"recordsFiltered" => $c,
			"data" => $data,
			"token"=>$this->m_reff->getToken()
		);
		//output to json format
		//$output[$csrf_name] = $csrf_hash;
		echo json_encode($output);
	}
	
	function detail(){
		$var["data"]=$this->load->view("detail",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	 }
 

	function form_edit()
	{
		$data['jp'] = $this->mdl->getJp();
		$data['agama'] = $this->mdl->getAgama();
		$data['kelas'] = $this->mdl->getKelas();
		$data['pekerjaan'] = $this->mdl->getPekerjaan();
		$data['goldar'] = $this->mdl->getGoldar();
		$data['penghasilan'] = $this->mdl->getPenghasilan();
		$data['tahunLulus'] = $this->mdl->getTahunLulus();
		$this->load->view("form_edit", $data);
	}
	function absen()
	{
		$this->load->view("rekap_absen");
	}
	function insert()
	{

		echo $this->mdl->insert();
	}
	function hapus()
	{
		echo $this->mdl->hapus();
	}
	function update()
	{
		echo $this->mdl->update();
	}
	function getDataPresensi(){
		$var["data"]=$this->load->view("presensi",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}


	function dataGrafik(){
		// $tahun	=	$this->m_reff->san($this->input->post("tahun"));
		// $sms	=	$this->m_reff->san($this->input->post("sms"));
		if(!$this->input->post("draw")){ echo $this->m_reff->page403(); return false;}
		$list = $this->mdl->dataGrafik();
		$data = array();
		$no = $this->m_reff->san($this->input->post('start'));
		$no = $no + 1;
		foreach ($list as $dataDB) {
			$db = $dataDB->data_penilaian;
			$db = json_decode($db,TRUE);
			$nom=1;$detail_for=""; $val=null;
			foreach($db as $key=>$val){
				$detail_for.="<tr>
				<td>".$nom++."</td>
				<td>".$val['indikator']."</td>
				<td>".$val['skor']."</td>
				<td>".$val['nilai']."</td>
				</tr>";
			}

			$detail = "
			<b style='color:black'>Tahun : ".$dataDB->tahun."</b> - 
			<b  style='color:black'>Semester : ".$dataDB->semester."</b>
			<table class='entry2' width='100%'>
			<thead class='bg-info'>
			<th>No</th>
			<th>Indikator</th>
			<th>Skor</th>
			<th>Nilai bobot</th>
			</thead>
			".$detail_for."
			<tr>
			<td colspan='3' style='text-align:right'><b>Nilai Akhir</b></td>
			<td><b>".$dataDB->hasil_evaluasi."</b></td>
			</tr>
			<tr>
			<td colspan='3' style='text-align:right'><b>Predikat</b></td>
			<td><b>".$this->m_reff->predikat($dataDB->predikat)."</b></td>
			</tr>
			<tr>
			<td colspan='4'>
			<b>Hasil evaluasi/catatan:</b><br>
			".$dataDB->komentar."
			</td>
			</tr>
			</table>";

			$row = array();
			// $row[] = $dataDB->tahun;
			// $row[] = "Semester ".$dataDB->semester;
			$row[] = $detail;
			// $row[] = isset($dataDB->predikat)?($this->m_reff->predikat($dataDB->predikat)):"<i class='text-danger'>Belum dinilai</i>";
			// $row[] = isset($dataDB->komentar)?($dataDB->komentar):"<i class='text-danger'>Tidak ada Komentar</i>";
			//$row[] = $action;

			//add html for action
			$data[] = $row;
		}

		//$csrf_name = $this->security->get_csrf_token_name();
		//$csrf_hash = $this->security->get_csrf_hash(); 
		$output = array(
			"draw" => $this->m_reff->san($this->input->post('draw')),
			"recordsTotal" => $c = $this->mdl->countGrafik(),
			"recordsFiltered" => $c,
			"data" => $data,
		);
		//output to json format
		//$output[$csrf_name] = $csrf_hash;
		echo json_encode($output);
	}
}
