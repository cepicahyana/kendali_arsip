<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Data_test extends MY_Controller {

	

	function __construct()
	{
		parent::__construct();	
		$this->m_konfig->validasi_session(array("rs"));
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
	  public function riwayat()
	{
		$ajax=$this->input->get_post("ajax");
		if($ajax=="yes")
		{
			$var["data"]=$this->load->view("riwayat",NULL,TRUE);
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
		}else{
			$data['konten']="riwayat";
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
	  if($dataDB->hasil=="+"){
		  $hasil = "<span class='badge badge-danger'>positif +</span>";
		  $aksi = "
		  <a class='text-info' href='".site_url("download")."?f=".$this->m_reff->encrypt($dataDB->file)."'> <i class='fa fa-download' ></i> Download</a>
		   | 
		  <a href='javascript:reupload(`".$dataDB->kode."`,`".$dataDB->hasil."`,`".$dataDB->nama."`,`".$dataDB->kode_jenis."`,`".$dataDB->nik."`,`".$dataDB->id_hub."`,`".$dataDB->id."`,`".$dataDB->nip."`)'><i class='fa fa-edit' ></i> Upload ulang</a>";
	  }elseif($dataDB->hasil=="-"){
		  $hasil = "<span class='badge badge-success'>negatif - </span>";  
		  $aksi = "<a class='text-info' href='".site_url("download")."?f=".$this->m_reff->encrypt($dataDB->file)."'> <i class='fa fa-download' ></i>  Download</a>
		  | 
		  <a href='javascript:reupload(`".$dataDB->kode."`,`".$dataDB->hasil."`,`".$dataDB->nama."`,`".$dataDB->kode_jenis."`,`".$dataDB->nik."`,`".$dataDB->id_hub."`,`".$dataDB->id."`,`".$dataDB->nip."`)'> <i class='fa fa-edit' ></i>  Upload ulang</a>";
	  }else{
		  $hasil ="-";
		$aksi = "<button onclick='upload(`".$dataDB->kode."`,`".$dataDB->nama."`,`".$dataDB->kode_jenis."`,`".$dataDB->nik."`,`".$dataDB->id_hub."`,`".$dataDB->id."`,`".$dataDB->nip."`)' class='btn btn-secondary btn-sm'>
		<i style='font-size:15px' class='typcn typcn-upload'></i>  UPLOAD HASIL TES</button>";
	  }
	  if($dataDB->konfirm_rs){
		  $konfirm_rs=$this->tanggal->hariLengkap3($dataDB->konfirm_rs,"/");
	  }else{
		  $konfirm_rs="-";
	  }
	  $tgl_pengajuan = $this->tanggal->hariLengkap3($dataDB->tgl_permohonan,"/");

	    if($dataDB->id_hub=="id_hub"){
			$nama		=	"<span style='font-size:14px'><b>".$dataDB->nama."</b></span>";
		}elseif($dataDB->id_hub=="ppnpm"){
			$nama		=	"<span style='font-size:14px'><b>".$dataDB->nama."</b><br>(PPNPN)</span>";
		}else{
			$nama		=	"<span style='font-size:14px'><b>".$dataDB->nama."</b><br>(non-pegawai)</span>";
		}
		 
			$row = array();
			$row[] =  $no++;	
			$row[] =  $nama;	
			$row[] =  $dataDB->nik;	
		
			$row[] = $this->m_reff->goField("tr_jenis_test","nama","where kode='".$dataDB->kode_jenis."'");
			$row[] = $this->m_reff->keperluan($dataDB->id_keperluan);
			$row[] = $hasil;
			$row[] = $aksi;
			$row[] = $konfirm_rs;
			$row[] = $tgl_pengajuan;
		  
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
 
	// function import(){
	// 	$dt		=	$this->mdl->import();
	// 	echo json_encode($dt);
	// }

	 function upload(){
		$id=$this->input->post('id');
		if(!$id){ return $this->m_reff->page403();}

		$var["data"]=$this->load->view("upload",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		$this->m_reff->log("upload hasil test covid - RS","covid");
		echo json_encode($var);
	 }
	 function upload_data(){
		 
		$var["data"]=$this->load->view("upload_data",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	 }
 
	  
	 function pdf(){
		$kode 	=	$this->m_reff->san(isset($sheet[1])?($sheet[1]):"8374977232");
		$nama 	=	$this->m_reff->san(isset($sheet[2])?($sheet[2]):"");
		$nolab	=	$this->m_reff->san(isset($sheet[3])?($sheet[3]):"");
		$hasil	=	$this->m_reff->san(isset($sheet[4])?($sheet[4]):"positif");
		$hasil  =	$this->m_reff->san(trim(strtolower($hasil)));
		if($hasil=="negatif"){
			$hasil = "-";
		}elseif($hasil=="positif"){
			$hasil = "+";
		}
		$cto  	=	$this->m_reff->san(isset($sheet[5])?($sheet[5]):"");
		$ct6  	=	$this->m_reff->san(isset($sheet[6])?($sheet[6]):"");

		$hasil	=	$this->mdl->cekKode($kode);

	   if(isset($hasil->kode)){
			$req = array(
				"id"			=>	isset($hasil->id)?($hasil->id):"",
				"hasil"			=>	isset($hasil->hasil)?($hasil->hasil):"",
				"kode"			=>	isset($hasil->kode)?($hasil->kode):"",
				"id_hub"		=>	isset($hasil->id_hub)?($hasil->id_hub):"",
				"nip"			=>	isset($hasil->nip)?($hasil->nip):"",
				"nik"			=>	isset($hasil->nik)?($hasil->nik):"",
				"kode_jenis"	=>	isset($hasil->kode_jenis)?($hasil->kode_jenis):"",
			); 
		return	$this->mdl->upload_file($req);
	   } 
	 }

	//  function reupload(){
	// 	 $this->load->view("reupload");
	//  }

	function upload_file(){
		// $id=$this->input->post('id');
		// if(!$id){ return $this->m_reff->page403();}

		$echo=$this->mdl->upload_file();
		$this->m_reff->log("upload hasil test covid - RS","covid");
		echo json_encode($echo);
	 }

	 function download_data(){
	 
		$id =  $this->m_reff->idu();
		$kode = $this->m_reff->goField("tm_rs","kode","where id='".$id."' ");
		$this->db->where("(konfirm_rs is null)");
		$this->db->where("kode_tempat",$kode);
		$this->db->where("scan",1);
		// $this->db->where("hasil",null);
		$this->db->where("sts_acc",1);
		$this->db->order_by("_ctime","desc");
		$data=$this->db->get("v_test")->result();

		
		
	 
	 


		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

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


$sheet->setCellValue('A1',"Summary Pemeriksaan Setpres ".$this->tanggal->ind_bulan(date('Y-m-d')));
$sheet->setCellValue('A2',"NO");
$sheet->setCellValue('B2',"ID");
$sheet->setCellValue('C2',"Nama");
$sheet->setCellValue('D2',"Jenis Tes");
$sheet->setCellValue('E2',"Keperluan");
$sheet->setCellValue('F2',"NO LAB");
$sheet->setCellValue('G2',"Hasil");
$sheet->setCellValue('G3',"Result");
$sheet->setCellValue('H3',"Reference Value");
$sheet->setCellValue('I2',"CT Orf 1ab Gene");
$sheet->setCellValue('I3',"Result");
$sheet->setCellValue('J3',"Reference Value");
$sheet->setCellValue('K2',"CT N gene");
$sheet->setCellValue('K3',"Result");
$sheet->setCellValue('L3',"Reference Valu");
$sheet->setCellValue('M2',"Sampling Time");
$sheet->setCellValue('N2',"Received Time");
// $sheet->setCellValue('O2',"Laboratory number");
$sheet->setCellValue('O2',"Customer ID");
$sheet->setCellValue('P2',"Clinical Pathologist");
$sheet->setCellValue('Q2',"Validator");
$sheet->setCellValue('R2',"Validation Time");
$sheet->setCellValue('S2',"QRCODE");


 
$sheet->mergeCells('A1:M1'); // Set Merge Cell pada kolom A1 sampai F1
$sheet->mergeCells('A2:A3'); // Set Merge Cell pada kolom A1 sampai F1
$sheet->mergeCells('B2:B3'); // Set Merge Cell pada kolom A1 sampai F1?
$sheet->mergeCells('C2:C3'); // Set Merge Cell pada kolom A1 sampai F1?
$sheet->mergeCells('D2:D3'); // Set Merge Cell pada kolom A1 sampai F1?
$sheet->mergeCells('E2:E3'); // Set Merge Cell pada kolom A1 sampai F1?
$sheet->mergeCells('F2:F3'); // Set Merge Cell pada kolom A1 sampai F1?
$sheet->mergeCells('G2:H2'); // Set Merge Cell pada kolom A1 sampai F1?
$sheet->mergeCells('I2:J2'); // Set Merge Cell pada kolom A1 sampai F1?
$sheet->mergeCells('K2:L2'); // Set Merge Cell pada kolom A1 sampai F1?
$sheet->mergeCells('M2:M3'); // Set Merge Cell pada kolom A1 sampai F1?
$sheet->mergeCells('N2:N3'); // Set Merge Cell pada kolom A1 sampai F1?
$sheet->mergeCells('O2:O3'); // Set Merge Cell pada kolom A1 sampai F1?
$sheet->mergeCells('P2:P3'); // Set Merge Cell pada kolom A1 sampai F1?
$sheet->mergeCells('Q2:Q3'); // Set Merge Cell pada kolom A1 sampai F1?
$sheet->mergeCells('R2:R3'); // Set Merge Cell pada kolom A1 sampai F1?
$sheet->mergeCells('S2:S3'); // Set Merge Cell pada kolom A1 sampai F1?
// $sheet->mergeCells('T2:T3'); // Set Merge Cell pada kolom A1 sampai F1?
// $sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1
// $sheet->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
 
// Apply style header yang telah kita buat tadi ke masing-masing kolom header
$sheet->getStyle('A2')->applyFromArray($style_col);
$sheet->getStyle('B2')->applyFromArray($style_col);
$sheet->getStyle('C2')->applyFromArray($style_col);
$sheet->getStyle('D2')->applyFromArray($style_col);
$sheet->getStyle('E2')->applyFromArray($style_col);
$sheet->getStyle('F2')->applyFromArray($style_col);
$sheet->getStyle('G2')->applyFromArray($style_col);
$sheet->getStyle('H2')->applyFromArray($style_col);
$sheet->getStyle('I2')->applyFromArray($style_col);
$sheet->getStyle('J2')->applyFromArray($style_col);
$sheet->getStyle('K2')->applyFromArray($style_col);
$sheet->getStyle('L2')->applyFromArray($style_col);
$sheet->getStyle('M2')->applyFromArray($style_col);
$sheet->getStyle('N2')->applyFromArray($style_col);
$sheet->getStyle('O2')->applyFromArray($style_col);
$sheet->getStyle('P2')->applyFromArray($style_col);
$sheet->getStyle('Q2')->applyFromArray($style_col);
$sheet->getStyle('R2')->applyFromArray($style_col);
$sheet->getStyle('S2')->applyFromArray($style_col);
// $sheet->getStyle('T2')->applyFromArray($style_col);
$sheet->getStyle('A3')->applyFromArray($style_col);
$sheet->getStyle('B3')->applyFromArray($style_col);
$sheet->getStyle('C3')->applyFromArray($style_col);
$sheet->getStyle('D3')->applyFromArray($style_col);
$sheet->getStyle('E3')->applyFromArray($style_col);
$sheet->getStyle('F3')->applyFromArray($style_col);
$sheet->getStyle('G3')->applyFromArray($style_col);
$sheet->getStyle('H3')->applyFromArray($style_col);
$sheet->getStyle('I3')->applyFromArray($style_col);
$sheet->getStyle('J3')->applyFromArray($style_col);
$sheet->getStyle('K3')->applyFromArray($style_col);
$sheet->getStyle('L3')->applyFromArray($style_col);
$sheet->getStyle('M3')->applyFromArray($style_col);
$sheet->getStyle('N3')->applyFromArray($style_col);
$sheet->getStyle('O3')->applyFromArray($style_col);
$sheet->getStyle('P3')->applyFromArray($style_col);
$sheet->getStyle('Q3')->applyFromArray($style_col);
$sheet->getStyle('R3')->applyFromArray($style_col);
$sheet->getStyle('S3')->applyFromArray($style_col);
// $sheet->getStyle('T3')->applyFromArray($style_col);

// Set height baris ke 1, 2 dan 3
$sheet->getRowDimension('1')->setRowHeight(20); 

$no = 1; // Untuk penomoran tabel, di awal set dengan 1
$row = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
foreach ($data  as $val) { // Ambil semua data dari hasil eksekusi $sql


			$sheet->setCellValue("A".$row, $no++);
			$sheet->setCellValue("B".$row, $val->kode,\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
			$sheet->setCellValue("C".$row, $val->nama);
			$sheet->setCellValue("D".$row, $this->m_reff->goField("tr_jenis_test","nama","where kode='".$val->kode_jenis."'"));
			$sheet->setCellValue("E".$row, $val->keperluan);
			// $sheet->setCellValue("F".$row, "");
			// $sheet->setCellValue("G".$row, "");
			// $sheet->setCellValue("H".$row, "");
			// $sheet->setCellValue("I".$row, "");
			// $sheet->setCellValue("J".$row, "");
			// $sheet->setCellValue("K".$row, "");
			// $sheet->setCellValue("L".$row, "");
			// $sheet->setCellValue("M".$row, "");
			// $sheet->setCellValue("M".$row, "");
			// $sheet->setCellValue("M".$row, "");
			// $sheet->setCellValue("M".$row, "");


 
 
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
    $sheet->getStyle('J' . $row)->applyFromArray($style_row);
    $sheet->getStyle('K' . $row)->applyFromArray($style_row);
    $sheet->getStyle('L' . $row)->applyFromArray($style_row);
    $sheet->getStyle('M' . $row)->applyFromArray($style_row);
    $sheet->getStyle('N' . $row)->applyFromArray($style_row);
    $sheet->getStyle('O' . $row)->applyFromArray($style_row);
    $sheet->getStyle('P' . $row)->applyFromArray($style_row);
    $sheet->getStyle('Q' . $row)->applyFromArray($style_row);
    $sheet->getStyle('R' . $row)->applyFromArray($style_row);
    $sheet->getStyle('S' . $row)->applyFromArray($style_row);
    // $sheet->getStyle('T' . $row)->applyFromArray($style_row);

    // $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom No
    
    $sheet->getRowDimension($row)->setRowHeight(20); // Set height tiap row

    $no++; // Tambah 1 setiap kali looping
    $row++; // Tambah 1 setiap kali looping
}

// Set width kolom
$sheet->getColumnDimension('A')->setWidth(5); // Set width kolom A
$sheet->getColumnDimension('B')->setWidth(15); // Set width kolom B
$sheet->getColumnDimension('C')->setWidth(25); // Set width kolom C
$sheet->getColumnDimension('D')->setWidth(20); // Set width kolom D
$sheet->getColumnDimension('E')->setWidth(15); // Set width kolom E
$sheet->getColumnDimension('F')->setWidth(20); // Set width kolom F
$sheet->getColumnDimension('G')->setWidth(20); // Set width kolom G
$sheet->getColumnDimension('H')->setWidth(20); // Set width kolom G
$sheet->getColumnDimension('I')->setWidth(20); // Set width kolom G
$sheet->getColumnDimension('J')->setWidth(20); // Set width kolom G
$sheet->getColumnDimension('K')->setWidth(20); // Set width kolom G
$sheet->getColumnDimension('L')->setWidth(20); // Set width kolom G
$sheet->getColumnDimension('M')->setWidth(20); // Set width kolom G
$sheet->getColumnDimension('N')->setWidth(20); // Set width kolom G
$sheet->getColumnDimension('O')->setWidth(20); // Set width kolom G
$sheet->getColumnDimension('P')->setWidth(20); // Set width kolom G
$sheet->getColumnDimension('Q')->setWidth(20); // Set width kolom G
$sheet->getColumnDimension('R')->setWidth(20); // Set width kolom G
$sheet->getColumnDimension('S')->setWidth(20); // Set width kolom G
// $sheet->getColumnDimension('T')->setWidth(20); // Set width kolom G

// Set orientasi kertas jadi LANDSCAPE
$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

// Set judul file excel nya
$sheet->setTitle("Data");

// Proses file excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="Format Data Tes-'.date('Y-m-d H:i:s').'.xlsx"'); // Set nama file excel nya
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

	 }
	 
	 function scan(){
	 	 
		$echo=$this->mdl->scan();
		$var["data"]=$echo;
		$var["token"]=$this->m_reff->getToken();
		$this->m_reff->log("scan surat rekomendasi test covid","covid");
		echo json_encode($var);
	 }

	 function hapus_progress(){
		$id=$this->input->post('id');
		if(!$id){ return $this->m_reff->page403();}
		echo $this->mdl->hapus_progress();
	 }
	//  function set_update(){
	// 	echo $this->mdl->set_update();
	//  }

 
	function import(){
	 
   
        $tgl_sekarang = date('YmdHis'); // Ini akan mengambil waktu sekarang dengan format yyyymmddHHiiss
        $nama_file_baru =   'data'.$tgl_sekarang . '.xlsx';

        // Cek apakah terdapat file data.xlsx pada folder tmp
        if (is_file('plug/' . $nama_file_baru)) // Jika file tersebut ada
            unlink('plug/' . $nama_file_baru); // Hapus file tersebut

		$tmp_file = isset($_FILES['userfileImport']['tmp_name'])?($_FILES['userfileImport']['tmp_name']):null;
		if(!$tmp_file){
			return false;
		}
		$ext = pathinfo($_FILES['userfileImport']['name'], PATHINFO_EXTENSION); // Ambil ekstensi filenya apa
        // Cek apakah file yang diupload adalah file Excel 2007 (.xlsx)
        if ($ext == "xlsx") {
            // Upload file yang dipilih ke folder tmp 
			move_uploaded_file($tmp_file, 'plug/' . $nama_file_baru);

            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $spreadsheet = $reader->load('plug/' . $nama_file_baru); // Load file yang tadi diupload ke folder tmp
            $sheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
 
            $numrow = 1;
            $kosong = 0;
            foreach ($sheet as $row) { // Lakukan perulangan dari data yang ada di excel

				$kode 	=	$this->m_reff->sanex($row["B"]);
				$nama 	=	$this->m_reff->sanex($row["C"]);
				 
				$hasiltes	=	$this->m_reff->sanex($row["G"]);
				$hasiltes  =	$this->m_reff->sanex(trim(strtolower($hasiltes)));
		
				if($hasiltes=="negatif"){
					$hasiltes = "-";
				}elseif($hasiltes=="positif"){
					$hasiltes = "+";
				}
				$lab  			=	$this->m_reff->sanex($row["F"]);
				$ref_value  	=	$this->m_reff->sanex($row["H"]);
				$cto_result  	=	$this->m_reff->sanex($row["I"]);
				$cto_value  	=	$this->m_reff->sanex($row["J"]);
				$ctn_result  	=	$this->m_reff->sanex($row["K"]);
				$ctn_value  	=	$this->m_reff->sanex($row["L"]);
				$sampling	  	=	$this->m_reff->sanex($row["M"]);
				$received  		=	$this->m_reff->sanex($row["N"]);
				
				$cosid	  		=	$this->m_reff->sanex($row["O"]);
				$clinical	  		=	$this->m_reff->sanex($row["P"]);
				$validator	  		=	$this->m_reff->sanex($row["Q"]);
				$validator_time		=	$this->m_reff->sanex($row["R"]);
				$qrcode		  		=	$this->m_reff->sanex($row["S"]);
 
                     // Jadi dilewat saja, tidak usah diimport
                if ($numrow > 3) {
                     
							$hasil	=	$this->mdl->cekKode($kode);

						   if(isset($hasil->kode)){
								$req = array(
									"id"			=>	isset($hasil->id)?($hasil->id):"",
									"hasil"			=>	isset($hasiltes)?($hasiltes):"",
									"hasil_ref"		=>	isset($ref_value)?($ref_value):"",
									"kode"			=>	isset($hasil->kode)?($hasil->kode):"",
									"id_hub"		=>	isset($hasil->id_hub)?($hasil->id_hub):"",
									"nip"			=>	isset($hasil->nip)?($hasil->nip):"",
									"nik"			=>	isset($hasil->nik)?($hasil->nik):"",
									"kode_jenis"	=>	isset($hasil->kode_jenis)?($hasil->kode_jenis):"",
									"no_lab"		=>	isset($lab)?($lab):"",
									"cto_result"				=>	isset($cto_result)?($cto_result):"",
									"cto_value"					=>	isset($cto_value)?($cto_value):"",
									"ctn_result"				=>	isset($ctn_result)?($ctn_result):"",
									"ctn_value"					=>	isset($ctn_value)?($ctn_value):"",
									"sampling"		=>	isset($sampling)?($sampling):"",
									"received"		=>	isset($received)?($received):"",
									"clinical"		=>	isset($clinical)?($clinical):"",
									"validator"		=>	isset($validator)?($validator):"",
									"validator_time"	=>	isset($validator_time)?($validator_time):"",
									"qrcode"	=>	isset($qrcode)?($qrcode):"",
									"cosid"	=>	isset($cosid)?($cosid):"",
						
								); 
								$this->mdl->upload_file($req);
						   } 

                }

                $numrow++; // Tambah 1 setiap kali looping
            }
		}else{
			 
				$var["gagal"]=true;
				$var["info"]="Format file tidak dikenal, silahkan upload file .xlsx";
				echo json_encode($var);
		
		}
		// $var["import_data"]=true;
		// $var["data_insert"]=$insert;
		// $var["data_gagal"]=$gagal;
		// $var["data_edit"]=$edit; 
		// $var["dgagal"]=$dgagal; 
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
       
	}


}