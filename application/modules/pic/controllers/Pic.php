<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Pic extends MY_Controller {

	

	function __construct()
	{
		parent::__construct();	
		$this->m_konfig->validasi_session(array("pic_covid","admin_covid","pimpinan_pusat","super_admin","pimpinan_covid"));
		$this->load->model("model","mdl");
		date_default_timezone_set('Asia/Jakarta');

 
	 
	}
	
	function _template($data)
	{
		$level = $this->session->userdata('level');
		$tempMain = 'temp_main';
		if($level=="pimpinan_pusat"){
			$tempMain = 'temp_main_pusat';
		}
		$this->load->view($tempMain.'/main',$data);
	}

	function notif(){
		if(!$this->input->post()){
			return $this->m_reff->page404();
		}

		


		if($this->session->userdata("kode_istana")){
			$this->db->where("kode_istana",$this->session->userdata("kode_istana"));
		}
		if($this->session->userdata("kode_biro")){
			$this->db->where("kode_biro",$this->session->userdata("kode_biro"));
		}
							   $this->db->order_by("notif_pengajuan","DESC");
							   $this->db->order_by("notif_hasil","DESC");
							   $this->db->where("level",6);
		$notif				 = $this->db->get("admin")->row();
		$notif_pengajuan	 = isset($notif->notif_pengajuan)?($notif->notif_pengajuan):0;
		$notif_hasil		 = isset($notif->notif_hasil)?($notif->notif_hasil):0;
		if($notif_pengajuan or $notif_hasil){
			$not = true;
		}else{
			$not = false;
		}
		$n["notif"]		=	$notif;
		$var["notif"]	=	$not;
		if($not==true){
			$var["data"]	=	$this->load->view("notif",$n,true);
		}
		$var["token"]	=	$this->m_reff->getToken();


		if($this->session->userdata("kode_istana")){
			$this->db->where("kode_istana",$this->session->userdata("kode_istana"));
		} 
		if($this->session->userdata("kode_biro")){
			$this->db->where("kode_biro",$this->session->userdata("kode_biro"));
		} 
		  $this->db->set("notif_pengajuan",0);
		  $this->db->set("notif_hasil",0);
		  $this->db->where("level",6);
		  $this->db->update("admin");


		echo json_encode($var);
	}
	 
	 public function index()
	{
		$ajax=$this->input->get_post("ajax");
		if($ajax=="yes")
		{
			$var["data"]=$this->load->view("index",null,true);
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
		}else{
			$data['konten']="index";
			$this->_template($data);
		}
	} 

	public function rekap()
	{
		$ajax=$this->input->get_post("ajax");
		if($ajax=="yes")
		{
			$var["data"]=$this->load->view("rekap",null,true);
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
		}else{
			$data['konten']="rekap";
			$this->_template($data);
		}
	} 
	 
	
	  
	 
	function getDataRekap()
	{
		if(!$this->input->post("draw")){ echo $this->m_reff->page403(); return false;}
		$level = $this->session->level;
		$list = $this->mdl->getDataRekap();
		$data = array();
		$no = $this->input->post("start");
		$no =$no+1;
		foreach ($list as $val) {
         ////
 
			$row = array();
			 
			if($val->scan_time){
				$reg = $val->scan_time;
			}else{
				$reg = $val->konfirm_rs;
			}


			if($val->hasil=="+"){
				$hasil = "<span>positif +</span>";
			}elseif($val->hasil=="-"){
				$hasil = "<span>negatif -</span>";
			}else{
			  $hasil = "<span>belum keluar</span>";
			}


			$row[] =	$no++;	
		 	$row[] =	$val->nama;
		 	$row[] =	"Istana ".$this->m_reff->istana($val->kode_istana,"singkat").br().$this->m_reff->biro($val->kode_biro);
		 	$row[] =	$this->m_reff->jenis_tes($val->kode_jenis);
		 	$row[] =	$this->tanggal->jamLengkap($reg);
		 	$row[] =	$hasil;
		 	$row[] =	$this->m_reff->tempat_tes($val->kode_tempat);
		 	$row[] =	$this->m_reff->keperluan_tes($val->id_keperluan);
			 

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
	  
 function downloadExcell(){

	$tgl		 = $this->m_reff->san($this->input->get("range"));
	$kode_tempat = $this->m_reff->san($this->input->get("kode_tempat"));
	$kode_jenis  = $this->m_reff->san($this->input->get("kode_jenis"));
	$kode_biro   = $this->m_reff->san($this->input->get("kode_biro"));
	$kode_istana   = $this->m_reff->san($this->input->get("kode_istana"));
	if(!$tgl){
		return $this->m_reff->page404;
	}
	$tgl1 = $this->tanggal->range_1($tgl, 0);
	$tgl2 = $this->tanggal->range_2($tgl, 1);
	
	 
	 

 
	  
	$jenis_tes=$tempat_tes=$biro=$istana = "-";
	if($kode_istana!='undefined' and $kode_istana!=''){
		$istana = "Istana ".$this->m_reff->istana($kode_istana,"singkat");
	}
	if($kode_biro!='undefined' and $kode_biro!=''){
		$biro = $this->m_reff->biro($kode_biro);
	}

	if($kode_jenis!='undefined' and $kode_jenis!=''){
		$jenis_tes = $this->m_reff->goField("tr_jenis_test","nama","where kode='".$kode_jenis."'");
	}
	if($kode_tempat!='undefined' and $kode_tempat!=''){
			$tempat_tes = $this->m_reff->goField("tm_rs","nama","where kode='".$kode_tempat."'");
	}
	  
		
		if($kode_tempat!='undefined' and $kode_tempat!=''){
			$this->db->where("kode_tempat",$kode_tempat);
		}
		if($kode_jenis!='undefined' and $kode_jenis!=''){
			$this->db->where("kode_jenis",$kode_jenis);
		}


		if($kode_istana!='undefined' and $kode_istana!=''){
			$this->db->where("kode_istana",$kode_istana);
		}
		if($kode_biro!='undefined' and $kode_biro!=''){
			$this->db->where("kode_biro",$kode_biro);
		}
		$this->db->where("(konfirm_rs is not null)");
		$this->db->where("konfirm_rs>=",$tgl1);
		$this->db->where("konfirm_rs<=",$tgl2);
		$this->db->where("scan",1);
		// $this->db->where("hasil",null);
		$this->db->where("sts_acc",1);
		$this->db->order_by("scan_time","desc");
		$this->db->order_by("kode_tempat","asc");
		$data=$this->db->get("v_test")->result();

		
	
	 
	 


		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		// $sheet2 = $spreadsheet->getActiveSheet(1);

// Buat sebuah variabel untuk menampung pengaturan style dari header tabel
$style_col = [
    'font' => ['bold' => true], // Set font nya jadi bold
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
    ],
    'borders' => [
        'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
        'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
        'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
        'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
    ]
];

// Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
$style_row = [
    'alignment' => [
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
    ],
    'borders' => [
        'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
        'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
        'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
        'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
    ]
];
$alignleft=[
	'font' => ['bold' => true], 
	'alignment' => [
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT // Set text jadi di tengah secara vertical (middle)
    ],
];

// REKAP JUMLAH TES
$sheet->setCellValue('K6',"Tempat Tes");
$sheet->setCellValue('L6',"Total");
            $dbtest = $this->mdl->listJenisTes();
			$abjad = 'M';
            foreach($dbtest as $l){
				$sheet->setCellValue($abjad++.'6',$l->nama);
				$sheet->getStyle($abjad.'6')->applyFromArray($style_row);
            }
			
			$baris=7;
			
		 
			$listRS = $this->mdl->listQueryRs();
			$total_semua=0;
			foreach($listRS as $rs)
			{
				$total_semua+=$rs->jml;
				$sheet->setCellValue('K'.$baris,$this->m_reff->goField3("tm_rs","nama","where kode='".$rs->kode_tempat."'"));
				$sheet->setCellValue('L'.$baris,$rs->jml);
				$sheet->getStyle('K'. $baris)->applyFromArray($style_row);
				$sheet->getStyle('L'. $baris)->applyFromArray($style_row);
				$abjad = 'M';  
			foreach($dbtest as $l){
                $jml = $this->mdl->jmlTest($tgl,$l->kode,$rs->kode_tempat);
				
				$sheet->getStyle($abjad . $baris)->applyFromArray($style_row);
				$sheet->setCellValue($abjad++.$baris,$jml);
            }  
			$baris++; 
		}

		$sheet->setCellValue('K'.$baris,'TOTAL');
		$sheet->setCellValue('L'.$baris,$total_semua);
		$sheet->getStyle('K' . $baris)->applyFromArray($style_row);
		$sheet->getStyle('L' . $baris)->applyFromArray($style_row);
		$ab="M";
		foreach($dbtest as $l){
			$jml = $this->mdl->jmlTest($tgl,$l->kode);
			$sheet->getStyle($ab . $baris)->applyFromArray($style_row);
			$sheet->setCellValue($ab++.$baris,$jml);
		}  


$sheet->setCellValue('A1',"periode : ".$this->tanggal->ind($tgl1,"/")." s/d ".$this->tanggal->ind($tgl2,"/"));
$sheet->setCellValue('A2',"Satker : ".$istana);
$sheet->setCellValue('A3',"Biro : ".$biro);
$sheet->setCellValue('A4',"Jenis Tes : ".$jenis_tes);
$sheet->setCellValue('A5',"Tempat Tes : ".$tempat_tes);
$sheet->setCellValue('A6',"NO");
$sheet->setCellValue('B6',"Nama");
$sheet->setCellValue('C6',"Satuan Kerja");
$sheet->setCellValue('D6',"Biro");
$sheet->setCellValue('E6',"Jenis Tes");
$sheet->setCellValue('F6',"Tanggal Tes");
$sheet->setCellValue('G6',"Hasil");
$sheet->setCellValue('H6',"Tempat Tes");
$sheet->setCellValue('I6',"Keperluan Tes");
 
$sheet->mergeCells('A1:D1'); // Set Merge Cell pada kolom A1 sampai F1?
$sheet->mergeCells('A2:D2'); // Set Merge Cell pada kolom A1 sampai F1?
$sheet->mergeCells('A3:D3'); // Set Merge Cell pada kolom A1 sampai F1?
$sheet->mergeCells('A4:D4'); // Set Merge Cell pada kolom A1 sampai F1?
$sheet->mergeCells('A5:D5'); // Set Merge Cell pada kolom A1 sampai F1?
// $sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1
// $sheet->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
 
// Apply style header yang telah kita buat tadi ke masing-masing kolom header
// $sheet->getStyle('A1')->applyFromArray($style_col);
$sheet->getStyle('A1')->applyFromArray($alignleft);
$sheet->getStyle('A2')->applyFromArray($alignleft);
$sheet->getStyle('A3')->applyFromArray($alignleft);
$sheet->getStyle('A4')->applyFromArray($alignleft);
$sheet->getStyle('A5')->applyFromArray($alignleft);



$sheet->getStyle('A6')->applyFromArray($style_col);
$sheet->getStyle('B6')->applyFromArray($style_col);
$sheet->getStyle('C6')->applyFromArray($style_col);
$sheet->getStyle('D6')->applyFromArray($style_col);
$sheet->getStyle('E6')->applyFromArray($style_col);
$sheet->getStyle('F6')->applyFromArray($style_col);
$sheet->getStyle('G6')->applyFromArray($style_col);
$sheet->getStyle('H6')->applyFromArray($style_col); 
$sheet->getStyle('I6')->applyFromArray($style_col); 
// $sheet->getStyle('J6')->applyFromArray($style_col); 
$sheet->getStyle('K6')->applyFromArray($style_col); 
$sheet->getStyle('L6')->applyFromArray($style_col); 
$sheet->getStyle('M6')->applyFromArray($style_col); 
$sheet->getStyle('N6')->applyFromArray($style_col); 
$sheet->getStyle('O6')->applyFromArray($style_col); 
$sheet->getStyle('P6')->applyFromArray($style_col); 
// $sheet->getStyle('T2')->applyFromArray($style_col);


// Set height baris ke 1, 2 dan 3
$sheet->getRowDimension('1')->setRowHeight(20); 


$no = 1; // Untuk penomoran tabel, di awal set dengan 1
$row = 7; // Set baris pertama untuk isi tabel adalah baris ke 4
foreach ($data  as $val) { // Ambil semua data dari hasil eksekusi $sql


	if($val->scan_time){
		$reg = $val->scan_time;
	}else{
		$reg = $val->konfirm_rs;
	}


	if($val->hasil=="+"){
		$hasil = "positif";
	}elseif($val->hasil=="-"){
		$hasil = "negatif";
	}else{
	  $hasil = "belum keluar";
	}


			$sheet->setCellValue("A".$row, $no);
			$sheet->setCellValue("B".$row, $val->nama);
			$sheet->setCellValue("C".$row, "Istana ".$this->m_reff->istana($val->kode_istana,"singkat"));
			$sheet->setCellValue("D".$row, $this->m_reff->biro($val->kode_biro));
			$sheet->setCellValue("E".$row, $this->m_reff->jenis_tes($val->kode_jenis));
			$sheet->setCellValue("F".$row, $this->tanggal->jamLengkap($reg));
			$sheet->setCellValue("G".$row, $hasil);
			$sheet->setCellValue("H".$row, $this->m_reff->tempat_tes($val->kode_tempat));
			$sheet->setCellValue("I".$row, $this->m_reff->keperluan_tes($val->id_keperluan));
		 

 
    // Khusus untuk no telepon. kita set type kolom nya jadi STRING
    // $sheet->setCellValueExplicit('E' . $row, $data['telp'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
 

    // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
    $sheet->getStyle('A' . $row)->applyFromArray($style_row);
    $sheet->getStyle('B' . $row)->applyFromArray($style_row);
    $sheet->getStyle('C' . $row)->applyFromArray($style_row);
    $sheet->getStyle('D' . $row)->applyFromArray($style_row);
    $sheet->getStyle('E' . $row)->applyFromArray($style_row);
    $sheet->getStyle('F' . $row)->applyFromArray($style_row);
    $sheet->getStyle('G' . $row)->applyFromArray($style_row);
    $sheet->getStyle('H' . $row)->applyFromArray($style_row);
    $sheet->getStyle('I' . $row)->applyFromArray($style_row);  
    
    // $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom No
    
    $sheet->getRowDimension($row)->setRowHeight(20); // Set height tiap row

    $no++; // Tambah 1 setiap kali looping
    $row++; // Tambah 1 setiap kali looping
}

// Set width kolom
$sheet->getColumnDimension('A')->setWidth(5); // Set width kolom A
$sheet->getColumnDimension('B')->setWidth(25); // Set width kolom B
$sheet->getColumnDimension('C')->setWidth(25); // Set width kolom C
$sheet->getColumnDimension('D')->setWidth(20); // Set width kolom D
$sheet->getColumnDimension('E')->setWidth(15); // Set width kolom E
$sheet->getColumnDimension('F')->setWidth(30); // Set width kolom F
$sheet->getColumnDimension('G')->setWidth(20); // Set width kolom G
$sheet->getColumnDimension('H')->setWidth(20); // Set width kolom G
$sheet->getColumnDimension('I')->setWidth(20); // Set width kolom G 
// $sheet->getColumnDimension('J')->setWidth(20); // Set width kolom G 
$sheet->getColumnDimension('K')->setWidth(20); // Set width kolom G 
$sheet->getColumnDimension('L')->setWidth(10); // Set width kolom G 
$sheet->getColumnDimension('M')->setWidth(10); // Set width kolom G 
$sheet->getColumnDimension('N')->setWidth(10); // Set width kolom G 
$sheet->getColumnDimension('O')->setWidth(10); // Set width kolom G 
$sheet->getColumnDimension('P')->setWidth(10); // Set width kolom G 
// $sheet->getColumnDimension('T')->setWidth(20); // Set width kolom G





// Set orientasi kertas jadi LANDSCAPE
$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

// Set judul file excel nya
$sheet->setTitle("Data");

// Proses file excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="Data Tes.xlsx'); // Set nama file excel nya
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

	 
 }


 function goRs(){
	$range = $this->input->post("range");

	if(!$range){
		return $this->m_reff->page403();
	}

	$var["data"]=$this->load->view("goRs",null,true);
	$var["token"]=$this->m_reff->getToken();
	echo json_encode($var);
	
}
		 
}