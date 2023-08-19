<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Absensi extends CI_Controller
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


	public function index()
	{
		$ajax = $this->input->get_post("ajax");
		if ($ajax == "yes") {
	 
			$data['jp'] = $this->mdl->getJp();
		 
			$data['header'] = "Data absensi";
			$data["data"]=$this->load->view("index", $data,TRUE);
			echo json_encode($data);
		} else {
		 
			$data['jp'] = $this->mdl->getJp();
			 
			$data['header'] = "Data absensi";
			$data['konten'] = "index";
			$this->_template($data);
		}
	}
	function getData()
	{
		if(!$this->input->post("draw")){ echo $this->m_reff->page403(); return false;}
		
		$list = $this->mdl->getData();
		$data = array();
		$no		 = $_POST['start'];
		$jml 	 = $this->input->post("jml");
		$periode = $this->input->post("periode");
		$no = $no + 1;
		foreach ($list as $dataDB) {
 			// jenjang pendidikan
			$jp = $this->mdl->getJpByid($dataDB->id_jp);
			
			// nama biro
			$biro = $this->m_reff->biro($dataDB->kode_biro);

			$id	= $dataDB->id;
		 
			if($dataDB->jk=="l"){
				$jk = "Laki-laki";
			}elseif($dataDB->jk=="p"){
				$jk = "Perempuan";
			}else{
				$jk = "-";
			}

			$jmlLembur=0; $lemburdibayar=0; $jmlJamLembur=0;
            // $nip=44;
			$tgl1o=$this->tanggal->range_1($periode);
			$tgl1=$this->tanggal->ind($tgl1o,"/");
			$tgl2o=$this->tanggal->range_2($periode);
			$tgl2=$this->tanggal->ind($tgl2o,"/");
			$jml=$this->tanggal->selisih($tgl1o,$tgl2o)+1;

            // COBA REKAP PERMINGGU
            for($i=0;$i<$jml;$i++){
                $n=$n=$this->tanggal->tambah_tgl($tgl1o,$i);
                $tgl    =   $this->tanggal->tambah_tgl($tgl1o,$i);
                // $db     =   $this->mdl->cekAbsenFingerExcel($tgl);
                // echo json_encode($db);
                $db     =   $this->mdl->cekAbsenFinger($dataDB->nip,$tgl);	
                $hasil  =   isset($db->jenis_absen)?($db->jenis_absen):"";
                // $nip    =   $dataDB->nip;
                $numberOfDay = $this->tanggal->toDay($n);

                if($numberOfDay==7){
                    $jmlLembur+=isset($db->n_lembur)?($db->n_lembur):0; 
                    $jmlJamLembur+=isset($db->lembur_terhitung)?($db->lembur_terhitung):0; 
                    $max = $this->m_umum->max_uang_lembur_perminggu();
                    if($jmlLembur>$max){
                        $jmlLembur = $max;
                        $lemburdibayar = $max+$lemburdibayar;
                    }else{
                        $lemburdibayar = $jmlLembur+$lemburdibayar;
                    }
                    $jmlLembur=0;
                 }else{
                    $jmlLembur+=isset($db->n_lembur)?($db->n_lembur):0; 
                 }
            }

			$rekapLembur = "Rp.". number_format($lemburdibayar,0,",",".");

			$row = array();
			$row[] = $no++;
			$absen = $this->mdl->getAbsen($dataDB->nip);
			$row[] = "<a href='javascript:detail(`".$dataDB->nip."`,`".$periode."`)'><i class='fa fa-user'></i> <b>".$dataDB->nama."</b>".$absen."</a>";
			$lembur = $this->mdl->jmlLemburJamTerhitung($dataDB->nip,$periode);
			$makan = $this->mdl->jmlMakanJam($dataDB->nip,$periode);
			$row[] = $biro.br().$dataDB->bagian;
			
			for($i=0;$i<$jml;$i++){
				$row[] = $this->mdl->presensiHarian($dataDB->nip,$i,$periode);
			}
			
			$row[] = $lembur;
			$row[] = "Rp.". number_format($this->mdl->jmlLembur($dataDB->nip,$periode),0,",",".");
			$row[] = $makan;
			$row[] = "Rp.".number_format($this->mdl->jmlMakan($dataDB->nip,$periode),0,",",".");
			$row[] = $lembur;
			$row[] = $rekapLembur;
			//add html for action
			$data[] = $row;
		}

		//$csrf_name = $this->security->get_csrf_token_name();
		//$csrf_hash = $this->security->get_csrf_hash(); 
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $c = $this->mdl->count(),
			"recordsFiltered" => $c,
			"data" => $data,
			"token" =>$this->m_reff->getToken()
		);
		//output to json format
		//$output[$csrf_name] = $csrf_hash;
		echo json_encode($output);
	}
	
	function detail(){
		$cekNip =$this->input->post("nip");
		if(!$cekNip){ return $this->m_reff->page403();}

		$var["data"]=$this->load->view("detail",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	 }
 
  
	function detailTgl(){
		$cekNip =$this->input->post("nip");
		if(!$cekNip){ return $this->m_reff->page403();}

		$var["data"]=$this->load->view("detailTgl",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	 }
 
  
	function range_absen(){
		$cekNip = $this->input->post("periode");
		if(!$cekNip){ return $this->m_reff->page403();}

		$var["data"]=$this->load->view("range_absen",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}

	
	function printPDF()
	{	
		$this->load->view('pdf');
		// $mpdf = new \Mpdf\Mpdf();
		// $mpdf->WriteHTML('<h1>Hello world!</h1>');
		// $mpdf->Output();
	}

	function export_excel(){

		// $var["token"]=$this->m_reff->getToken();
		// $var["getAbsen"] = $this->db->get('data_absen')->result();
		$this->load->view("excel");

	}
}
