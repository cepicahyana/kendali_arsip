<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Kd_master extends CI_Controller {

	function __construct()
	{
		parent::__construct();	
		$this->m_konfig->validasi_session(array("admin_data","super_admin","pimpinan_covid"));
		$this->load->model("model","mdl");
		date_default_timezone_set('Asia/Jakarta');
	}
	
	function _template($data)
	{
		$this->load->view('temp_main_data/main',$data);	
	}

	function pns()
	{
		$data=array(
			"f_istana","f_biro","f_bagian","f_subbagian","f_golongan","f_usia_min",
			"f_usia_max","f_masker_min","f_masker_max","f_pensiun_min","f_pensiun_max",
			"f_jabatan","f_jml_tanggungan","f_provinsi_ktp","f_provinsi_domisili","f_jp",
			"f_penghargaan","f_hukuman","f_rm","f_covid"	 
		);
		$this->session->unset_userdata($data);


		$ajax=$this->input->get_post("ajax");
		if($ajax=="yes")
		{
			$var["data"]=$this->load->view("pns",NULL,TRUE);
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
		}else{
			$data['konten']="pns";
			$this->_template($data);
		}
	}
	function getPNS()
	{
		if(!$this->input->post("draw")){ echo $this->m_reff->page403(); return false;}
		$list = $this->mdl->getData();
		$data = array();
		$no = $this->input->post("start");
		$no =$no+1;

		foreach ($list as $dataDB) {

			if($dataDB->jk=="l"){
				$jk = "Laki-laki";
			}elseif($dataDB->jk=="p"){
				$jk = "Perempuan";
			}else{
				$jk = "-";
			}

			$row = array();
			$row[] = $no++;
			$tombol = '
			<div class="btn-group">
			<button class="btn btn-light" onclick="formEdit(`'.$dataDB->id.'`)" title="Edit"><i class="fe fe-edit menu-icon"></i></button>
			<button class="btn btn-danger" onclick="hapus(`'.$dataDB->id.'`,`'.$dataDB->nama.'`)" title="Hapus"><i class="fe fe-trash-2 menu-icon"></i></button>
			</div>';

			// $row[] = $dataDB->foto;
			$row[] = $dataDB->nip;
			$row[] = "<a href='".base_url()."cek_data?nip=".$dataDB->nip."'>".$dataDB->nama."</a>";
			$row[] = $dataDB->eselon;
			$row[] = $dataDB->golongan;
			$row[] = $dataDB->jabatan;
			$row[] = $this->m_reff->biro($dataDB->kode_biro);
			$row[] = $this->m_reff->istana($dataDB->kode_istana);
			$row[] = $dataDB->bagian;
			$row[] = $dataDB->subbagian;
			$row[] = $dataDB->no_hp;
			$row[] = $dataDB->email;
			$row[] = $dataDB->tmt;
			$row[] = $dataDB->nik;
			$row[] = $jk;
			$row[] = $dataDB->id_goldar;
			$row[] = $dataDB->id_jp;
			$row[] = $dataDB->agama;
			$row[] = $dataDB->sts_menikah;
			$row[] = $dataDB->jml_tanggungan;
			$row[] = $dataDB->jml_penghargaan;
			$row[] = $dataDB->jml_hukuman;
			$row[] = $dataDB->jml_rm;
			$row[] = $tombol;

			//add html for action
			$data[] = $row;
		}

		$output = array(
			"draw" => $this->input->post("draw"),
			"recordsTotal" => $c=$this->mdl->countData(),
			"recordsFiltered" =>$c,
			"data" => $data,
			"token"=>$this->m_reff->getToken()
		);
		//output to json format
		echo json_encode($output);
	}
	function pns_form_add(){
		$f=$this->input->post();
		if(!$f){ return $this->m_reff->page403();}

		$var["data"]=$this->load->view("pns_form_add",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}
	function pns_insert(){
		$f=$this->input->post('f');
		if(!$f){ return $this->m_reff->page403();}

		$dt = $this->mdl->pns_insert();
		echo json_encode($dt);
	}
	function pns_update(){
		$f=$this->input->post('f');
		if(!$f){ return $this->m_reff->page403();}

		$dt = $this->mdl->pns_update();
		echo json_encode($dt);
	}
	function pns_hapus(){
		$id=$this->input->post('id');
		if(!$id){ return $this->m_reff->page403();}
		
		$dt = $this->mdl->pns_hapus();
		echo json_encode($dt);
	}
	function pns_import(){
		$f = $this->input->post();
		if(!$f){ return $this->m_reff->page403();}

		$var["data"]=$this->load->view("pns_import",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}
	function pns_filter(){
		$f = $this->input->post();
		if(!$f){ return $this->m_reff->page403();}

		$var["data"]=$this->load->view("pns_filter",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}
	function ppnpn_filter(){
		$f = $this->input->post();
		if(!$f){ return $this->m_reff->page403();}

		$var["data"]=$this->load->view("ppnpn_filter",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}
	function import_file_pns()
	{
		$dt		=	$this->mdl->import_file_pns();
		echo json_encode($dt);
	}

	function download_format_update(){
		$kode_istana = $this->input->get("istana");
		$kode_biro = $this->input->get("biro");
		$id =  $this->m_reff->idu();


	 		$this->db->where("kode_istana",$kode_istana);
		if($kode_biro){
			$this->db->where("kode_biro",$kode_biro);
		}
		$this->db->where("jenis_pegawai",2);
		$data=$this->db->get("data_pegawai")->result();

		 
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


$sheet->setCellValue('A1',"NPP");
$sheet->setCellValue('B1',"Nama");
$sheet->setCellValue('C1',"JK");
$sheet->setCellValue('D1',"Tgl lahir");
$sheet->setCellValue('E1',"Hp");
$sheet->setCellValue('F1',"Email");
$sheet->setCellValue('G1',"Bagian");
$sheet->setCellValue('H1',"Subbagian");
$sheet->setCellValue('I1',"TMT");
$sheet->setCellValue('J1',"noedit");
$sheet->setCellValue('K1',"noedit");
 
  // $sheet->mergeCells('T2:T3'); // Set Merge Cell pada kolom A1 sampai F1?
// $sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1
// $sheet->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
 
// Apply style header yang telah kita buat tadi ke masing-masing kolom header
$sheet->getStyle('A1')->applyFromArray($style_col);
$sheet->getStyle('B1')->applyFromArray($style_col);
$sheet->getStyle('C1')->applyFromArray($style_col);
$sheet->getStyle('D1')->applyFromArray($style_col);
$sheet->getStyle('E1')->applyFromArray($style_col);
$sheet->getStyle('F1')->applyFromArray($style_col);
$sheet->getStyle('G1')->applyFromArray($style_col); 
$sheet->getStyle('H1')->applyFromArray($style_col); 
$sheet->getStyle('I1')->applyFromArray($style_col); 
$sheet->getStyle('J1')->applyFromArray($style_col); 
$sheet->getStyle('K1')->applyFromArray($style_col); 
 

// Set height baris ke 1, 2 dan 3
$sheet->getRowDimension('1')->setRowHeight(20); 

$no = 1; // Untuk penomoran tabel, di awal set dengan 1
$row = 2; // Set baris pertama untuk isi tabel adalah baris ke 4
foreach ($data  as $val) { // Ambil semua data dari hasil eksekusi $sql


			$sheet->setCellValue("A".$row, "`".$val->nip,\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);	
			$sheet->setCellValue("B".$row, $val->nama);
			$sheet->setCellValue("C".$row, $val->jk);
			$sheet->setCellValue("D".$row, $val->tgl_lahir);
			$sheet->setCellValue("E".$row, $val->no_hp);
			$sheet->setCellValue("F".$row, $val->email);
			$sheet->setCellValue("G".$row, $val->bagian);
			$sheet->setCellValue("H".$row, $val->subbagian);
			$sheet->setCellValue("I".$row, $val->tmt);
			$sheet->setCellValue("J".$row, $val->kode_istana);
			$sheet->setCellValue("K".$row, $val->kode_biro);
 
			 
 
 
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
     
    // $sheet->getStyle('T' . $row)->applyFromArray($style_row);

    // $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom No
    
    $sheet->getRowDimension($row)->setRowHeight(20); // Set height tiap row

    $no++; // Tambah 1 setiap kali looping
    $row++; // Tambah 1 setiap kali looping
}

// Set width kolom
$sheet->getColumnDimension('A')->setWidth(25); // Set width kolom A
$sheet->getColumnDimension('B')->setWidth(30); // Set width kolom B
$sheet->getColumnDimension('C')->setWidth(5); // Set width kolom C
$sheet->getColumnDimension('D')->setWidth(16); // Set width kolom D
$sheet->getColumnDimension('E')->setWidth(15); // Set width kolom E
$sheet->getColumnDimension('F')->setWidth(20); // Set width kolom F
$sheet->getColumnDimension('G')->setWidth(32); // Set width kolom G
$sheet->getColumnDimension('H')->setWidth(20); // Set width kolom G 
$sheet->getColumnDimension('I')->setWidth(16); // Set width kolom G 
$sheet->getColumnDimension('J')->setWidth(5); // Set width kolom G 
$sheet->getColumnDimension('K')->setWidth(5); // Set width kolom G 
// $sheet->getColumnDimension('T')->setWidth(20); // Set width kolom G

// Set orientasi kertas jadi LANDSCAPE
$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

// Set judul file excel nya
$sheet->setTitle("Data");

// Proses file excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="Format Data '.date('Y-m-d H:i:s').'.xlsx"'); // Set nama file excel nya
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
	}
	 
	function set_filter(){
		$key = $this->input->post('key');
		if(!$key){ return $this->m_reff->page403();}

		$this->mdl->set_filter();
		$dt["token"] = $this->m_reff->getToken();
		echo json_encode($dt);
	}

	function resset(){
		$data=array(
			"f_istana","f_biro","f_bagian","f_subbagian","f_golongan","f_usia_min",
			"f_usia_max","f_masker_min","f_masker_max","f_pensiun_min","f_pensiun_max",
			"f_jabatan","f_jml_tanggungan","f_provinsi_ktp","f_provinsi_domisili","f_jp",
			"f_penghargaan","f_hukuman","f_rm","f_covid"	 
		);
		$this->session->unset_userdata($data);
		$dt["token"] = $this->m_reff->getToken();
		echo json_encode($dt);
	}
 


	// ppnpn
	function ppnpn()
	{
		
		$data=array(
			"f_istana","f_biro","f_bagian","f_subbagian","f_golongan","f_usia_min",
			"f_usia_max","f_masker_min","f_masker_max","f_pensiun_min","f_pensiun_max",
			"f_jabatan","f_jml_tanggungan","f_provinsi_ktp","f_provinsi_domisili","f_jp",
			"f_penghargaan","f_hukuman","f_rm","f_covid"	 
		);
		$this->session->unset_userdata($data);

		
		$ajax=$this->input->get_post("ajax");
		if($ajax=="yes")
		{
			$var["data"]=$this->load->view("ppnpn",NULL,TRUE);
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
		}else{
			$data['konten']="ppnpn";
			$this->_template($data);
		}
	}

	function getPPNPN()
	{
		if(!$this->input->post("draw")){ echo $this->m_reff->page403(); return false;}
		$list = $this->mdl->getData();
		$data = array();
		$no = $this->input->post("start");
		$no =$no+1;

		foreach ($list as $dataDB) {

			if($dataDB->jk=="l"){
				$jk = "Laki-laki";
			}elseif($dataDB->jk=="p"){
				$jk = "Perempuan";
			}else{
				$jk = "-";
			}

			$tombol = '
			<div class="btn-group">
			<button class="btn btn-light" onclick="formEdit(`'.$dataDB->id.'`)" title="Edit"><i class="fe fe-edit menu-icon"></i></button> 
			<button class="btn btn-danger" onclick="hapus(`'.$dataDB->id.'`,`'.$dataDB->nama.'`)" title="Hapus"><i class="fe fe-trash-2 menu-icon"></i></button>
			</div>';

			$row = array();
			$row[] = $no++;

			// $row[] = $dataDB->foto;
			$row[] = $dataDB->nip;
			$row[] = "<a href='".base_url()."cek_data?nip=".$dataDB->nip."'>".$dataDB->nama."</a>";
			$row[] = $this->m_reff->istana($dataDB->kode_istana);
			$row[] = $this->m_reff->biro($dataDB->kode_biro);
			// $row[] = $dataDB->eselon;
			// $row[] = $dataDB->golongan;
			$row[] = $dataDB->bagian;
			// $row[] = $dataDB->jabatan;
			$row[] = $dataDB->subbagian;
			
			
			$row[] = $dataDB->no_hp;
			$row[] = $dataDB->email;
			$row[] = $dataDB->tmt;
			$row[] = $dataDB->nik;
			$row[] = $jk;
			$row[] = $dataDB->id_goldar;
			$row[] = $dataDB->id_jp;
			$row[] = $dataDB->agama;
			$row[] = $dataDB->sts_menikah;
			
			$row[] = $tombol;

			//add html for action
			$data[] = $row;
		}

		$output = array(
			"draw" => $this->input->post("draw"),
			"recordsTotal" => $c=$this->mdl->countData(),
			"recordsFiltered" =>$c,
			"data" => $data,
			"token"=>$this->m_reff->getToken()
		);
		//output to json format
		echo json_encode($output);
	}

	function ppnpn_form_add(){
		$f=$this->input->post();
		if(!$f){ return $this->m_reff->page403();}

		$var["data"]=$this->load->view("ppnpn_form_add",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}
	function ppnpn_insert(){
		$f=$this->input->post('f');
		if(!$f){ return $this->m_reff->page403();}

		$dt = $this->mdl->ppnpn_insert();
		echo json_encode($dt);
	}
	function ppnpn_update(){
		$f=$this->input->post('f');
		if(!$f){ return $this->m_reff->page403();}

		$dt = $this->mdl->ppnpn_update();
		echo json_encode($dt);
	}
	function ppnpn_hapus(){
		$id = $this->input->post('id');
		if(!$id){ return $this->m_reff->page403();}

		$dt = $this->mdl->ppnpn_hapus();
		echo json_encode($dt);
	}
	/* import file*/
	function ppnpn_import(){
		$f = $this->input->post();
		if(!$f){ return $this->m_reff->page403();}

		$var["data"]=$this->load->view("ppnpn_import",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}
	function update_data(){
		$f = $this->input->post();
		if(!$f){ return $this->m_reff->page403();}

		$var["data"]=$this->load->view("update_data",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}
	// function import_file_ppnpn()
	// {

	// 	$dt		=	$this->mdl->import_file_ppnpn();
		
		/*$insert =	$dt["data_insert"];
		$gagal =	$dt["data_gagal"];
		$dgagal =	$dt["dgagal"];
		$g="";
		if($gagal)
		{
			$g="<br> ".$gagal." Data gagal ditambahkan dikarenakan sudah ada";
			
		}
		
		$i="";
		if($insert)
		{
			$i=$insert." Data berhasil ditambahkan";
		}
		
		
		
		if(!$i and !$g)
		{
			$i="Tidak ada data didalam file! silahkan cek kembali file yang anda upload....";
		}
		echo ' <i class="feather icon-check-circle display-3 text-success"></i><br>
				<span class="mt-3"> '.$i.'  '.$g.'</span>';
		if($dgagal)
		{
			echo "<br>data gagal:<br>".$dgagal;
		}*/

	// 	echo json_encode($dt);
	// }



	// petugas_taman
	function petugas_taman()
	{
		$ajax=$this->input->get_post("ajax");
		if($ajax=="yes")
		{
			$var["data"]=$this->load->view("petugas_taman",NULL,TRUE);
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
		}else{
			$data['konten']="petugas_taman";
			$this->_template($data);
		}
	}
	function getPetugasTaman()
	{
		if(!$this->input->post("draw")){ echo $this->m_reff->page403(); return false;}
		$list = $this->mdl->getData();
		$data = array();
		$no = $this->input->post("start");
		$no =$no+1;

		foreach ($list as $dataDB) {

			if($dataDB->jk=="l"){
				$jk = "Laki-laki";
			}elseif($dataDB->jk=="p"){
				$jk = "Perempuan";
			}else{
				$jk = "-";
			}

			$tombol = '<button class="btn btn-light" onclick="formEdit(`'.$dataDB->id.'`)" title="Edit"><i class="fe fe-edit menu-icon"></i></button>&nbsp;&nbsp;<button class="btn btn-danger" onclick="hapus(`'.$dataDB->id.'`,`'.$dataDB->nama.'`)" title="Hapus"><i class="fe fe-trash-2 menu-icon"></i></button>';

			$row = array();
			$row[] = $no++;

			// $row[] = $dataDB->foto;
			$row[] = $dataDB->nip;
			$row[] = $dataDB->nama;
			$row[] = $this->m_reff->istana($dataDB->kode_istana);
			$row[] = $this->m_reff->biro($dataDB->kode_biro);
			// $row[] = $dataDB->eselon;
			// $row[] = $dataDB->golongan;
			$row[] = $dataDB->bagian;
			$row[] = $dataDB->no_hp;
			$row[] = $dataDB->email;
			$row[] = $dataDB->tmt;
			// $row[] = $dataDB->jabatan;
			// $row[] = $dataDB->biro;
			// $row[] = $dataDB->instansi;
			// $row[] = $dataDB->istana;
			
			
		
			$row[] = $dataDB->nik;
			$row[] = $jk;
			$row[] = $dataDB->id_goldar;
			$row[] = $dataDB->id_jp;
			$row[] = $dataDB->agama;
			$row[] = $dataDB->sts_menikah;
			$row[] = $tombol;

			//add html for action
			$data[] = $row;
		}

		$output = array(
			"draw" => $this->input->post("draw"),
			"recordsTotal" => $c=$this->mdl->countData(),
			"recordsFiltered" =>$c,
			"data" => $data,
			"token"=>$this->m_reff->getToken()
		);
		//output to json format
		echo json_encode($output);
	}
	function pt_form_add(){
		$f = $this->input->post();
		if(!$f){
			return $this->m_reff->page403();
		}

		$var["data"]=$this->load->view("pt_form_add",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}
	function pt_insert(){
		$f = $this->input->post('f');
		if(!$f){
			return $this->m_reff->page403();
		}

		$dt = $this->mdl->pt_insert();
		echo json_encode($dt);
	}
	function pt_update(){
		$f = $this->input->post('f');
		if(!$f){
			return $this->m_reff->page403();
		}

		$dt = $this->mdl->pt_update();
		echo json_encode($dt);
	}
	function pt_hapus(){
		$id = $this->input->post('id');
		if(!$id){
			return $this->m_reff->page403();
		}

		$dt = $this->mdl->pt_hapus();
		echo json_encode($dt);
	}
	function pt_import(){
		$f = $this->input->post();
		if(!$f){
			return $this->m_reff->page403();
		}

		$var["data"]=$this->load->view("pt_import",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}

	function update_file_ppnpn(){
		$dt		=	$this->mdl->update_file_ppnpn();
		echo json_encode($dt);
	}
	function import_file_pt()
	{
		$dt		=	$this->mdl->import_file_pt();
		echo json_encode($dt);
	}
	function import_file_ppnpn()
	{
		$dt		=	$this->mdl->import_file_ppnpn();
		echo json_encode($dt);
	}

	// cleaning service
	function cleaning_service()
	{
		$ajax=$this->input->get_post("ajax");
		if($ajax=="yes")
		{
			$var["data"]=$this->load->view("cleaning_service",NULL,TRUE);
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
		}else{
			$data['konten']="cleaning_service";
			$this->_template($data);
		}
	}

	function getCleaningService()
	{
		if(!$this->input->post("draw")){ echo $this->m_reff->page403(); return false;}
		$list = $this->mdl->getData();
		$data = array();
		$no = $this->input->post("start");
		$no =$no+1;

		foreach ($list as $dataDB) {

			if($dataDB->jk=="l"){
				$jk = "Laki-laki";
			}elseif($dataDB->jk=="p"){
				$jk = "Perempuan";
			}else{
				$jk = "-";
			}

			$tombol = '<button class="btn btn-light" onclick="formEdit(`'.$dataDB->id.'`)" title="Edit"><i class="fe fe-edit menu-icon"></i></button>&nbsp;&nbsp;<button class="btn btn-danger" onclick="hapus(`'.$dataDB->id.'`,`'.$dataDB->nama.'`)" title="Hapus"><i class="fe fe-trash-2 menu-icon"></i></button>';


			$row = array();
			$row[] = $no++;

			// $row[] = $dataDB->foto;
			$row[] = $dataDB->nip;
			$row[] = $dataDB->nama;
			$row[] = $this->m_reff->istana($dataDB->kode_istana);
			$row[] = $this->m_reff->biro($dataDB->kode_biro);
			// $row[] = $dataDB->eselon;
			// $row[] = $dataDB->golongan;
			$row[] = $dataDB->bagian;
			$row[] = $dataDB->jabatan;
			// $row[] = $dataDB->instansi;
			$row[] = $dataDB->no_hp;
			$row[] = $dataDB->email;
			$row[] = $dataDB->tmt;
			$row[] = $dataDB->nik;
			$row[] = $jk;
			$row[] = $dataDB->id_goldar;
			$row[] = $dataDB->id_jp;
			$row[] = $dataDB->agama;
			$row[] = $dataDB->sts_menikah;
			$row[] = $tombol;

			//add html for action
			$data[] = $row;
		}

		$output = array(
			"draw" => $this->input->post("draw"),
			"recordsTotal" => $c=$this->mdl->countData(),
			"recordsFiltered" =>$c,
			"data" => $data,
			"token"=>$this->m_reff->getToken()
		);
		//output to json format
		echo json_encode($output);
	}
	function cs_form_add(){
		$f=$this->input->post();
		if(!$f){ return $this->m_reff->page403();}

		$var["data"]=$this->load->view("cs_form_add",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}
	function cs_insert(){
		$f=$this->input->post('f');
		if(!$f){ return $this->m_reff->page403();}

		$dt = $this->mdl->cs_insert();
		echo json_encode($dt);
	}
	function cs_update(){
		$f=$this->input->post('f');
		if(!$f){ return $this->m_reff->page403();}

		$dt = $this->mdl->cs_update();
		echo json_encode($dt);
	}
	function cs_hapus(){
		$id = $this->input->post('id');
		if(!$id){ return $this->m_reff->page403();}

		$dt = $this->mdl->cs_hapus();
		echo json_encode($dt);
	}
	function cs_import(){
		$f = $this->input->post();
		if(!$f){ return $this->m_reff->page403();}

		$var["data"]=$this->load->view("cs_import",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}
	function import_file_cs()
	{
		$dt		=	$this->mdl->import_file_cs();
		echo json_encode($dt);
	}

}
