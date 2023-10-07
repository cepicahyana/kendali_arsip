<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Model extends CI_Model  {
    
	 
	function __construct()
    {
        parent::__construct();
    }
	
	// Mulai Datatable
	function getData_arsiplist()
	{
		 $this->_getData_arsiplist();
		if($this->m_reff->san($this->input->post("length")!=-1)) 
		$this->db->limit($this->m_reff->san($this->input->post("length")),$this->m_reff->san($this->input->post("start")));
	 	return $this->db->get()->result();
		 
	}

	public function count_tingkaPerkembangan()
	{				
			$this->_getData_arsiplist();
		return $this->db->get()->num_rows();
	}

	function _getData_arsiplist()
	{
		  
		    if (strlen(isset($_POST['search']['value'])?($_POST['search']['value']):null)>1) {
                $searchkey = $_POST['search']['value'];
                $searchkey = $this->m_reff->sanitize($searchkey);
				$query=array(
				"nama"=>$searchkey 
				);
				$this->db->group_start()
                        ->or_like($query)
                ->group_end();
				
			}	
		$type = $this->input->post('type') == 3 ? [3,4,5] : [$this->input->post('type')];
		$this->db->select("a.*, CONCAT(kka.kode, ' - ', kka.nama) as kka, tp.nama as tingkat_perkembangan");
		$this->db->where_in("jenis",$type);
		$this->db->join("ars_tr_kka kka","a.kka_kode = kka.kode", "left");
		$this->db->join("ars_tr_tingkat_perkembangan tp","a.tingkat_perkembangan_id = tp.id", "left");
		$query=$this->db->from("ars_trx_arsip a");
		return $query;
	}
	// Akhir Datatable


	function getData_klasifikasiArsip()
	{
		$this->_getData_klasifikasiArsip();
		if($this->m_reff->san($this->input->post("length")!=-1)) 
		$this->db->limit($this->m_reff->san($this->input->post("length")),$this->m_reff->san($this->input->post("start")));
	 	return $this->db->get()->result();
		 
	}
	function _getData_klasifikasiArsip()
	{
		if (strlen(isset($_POST['search']['value'])?($_POST['search']['value']):null)>=1) {
			$searchkey = $_POST['search']['value'];
			$searchkey = $this->m_reff->sanitize($searchkey);
			$query=array(

			"description"=>$searchkey,
				
			);
			$this->db->group_start()
					->or_like($query)
			->group_end();
		}		 
		$query=$this->db->from("ars_tr_kka");
		return $query;
	}
	
	public function count_klasifikasiArsip()
	{				
			$this->_getData_klasifikasiArsip();
		return $this->db->get()->num_rows();
	}

	public function getData_JRA($id=0)
	{
		if($id){
			$this->db->where("a.uuid",$id);
		}
		$this->db->select("a.*, b.nama as nama_tindak_lanjut");
		$this->db->join("ars_tr_tindak_lanjut b","a.tindak_lanjut_uuid = b.uuid");
		$this->db->from("ars_tr_jra a");
		return $this->db->get()->row();
	}

	function update_arsip(){
        $id = $this->input->post("id");
        $form = $this->input->post("f");
        $type=$this->input->post("f[type]");
		$files = $_FILES;
        $this->db->set($form);
        if($id){
            $this->db->set("_uid",$this->session->userdata("nip"));
            $this->db->set("_utime",date('Y-m-d H:i:s'));
            $this->db->where("id",$id);
            $this->db->update("ars_trx_arsip");
            $this->m_reff->log("update data arsip");
        }else{
			if (!isset($form['nomor'])) $this->db->set('nomor', $this->checkNumber());
            $this->db->set('uuid',$this->getUUID());
            $this->db->set('status',1);
            $this->db->set("_cid",$this->session->userdata("nip"));
            $this->db->set("_ctime",date('Y-m-d H:i:s'));
            $this->db->insert("ars_trx_arsip");
			$id = $this->db->insert_id();
            $this->m_reff->log("menambahkan data arsip");
        }

		if ($this->db->affected_rows() == 0) {
			$var["gagal"]=true;
            $var["info"]="Gagal Diinput.";
            $var["token"]=$this->m_reff->getToken();
            return $var;
		} 

		$this->upload_file($id);

		$var["gagal"]=false;
		$var["token"]=$this->m_reff->getToken();
		return $var;
    }

	function upload_file($id) {
		$this->load->helper('file');
		$files = $_FILES;
		$data = $this->db->get_where("ars_trx_arsip", array("id" => $id))->row();
		
		for ($i = 0; $i < $this->input->post('JmlUpload'); $i++) {
			$uploaded_data = $files["file_" . $i];
			$filenameori = $uploaded_data['name'];
			$ext = pathinfo($filenameori, PATHINFO_EXTENSION);
			$filename = sha1_file($uploaded_data['tmp_name']);
			$dirminio = "arsip/";
			$dirminiofull =  $dirminio . $filename . '.' . $ext;

			$this->load->library('minio');
			$pathfile = $this->minio->uploadFilesObject($uploaded_data['tmp_name'], $dirminiofull, $dirminio, '10');
			// $data_file['attachment_sha1_file'] = sha1_file($uploaded_data['tmp_name']);

			$data_file['uuid'] = $this->getUUID();
			$data_file['arsip_uuid'] = $data->uuid;			
			$data_file['file_path'] = $dirminiofull;
			$data_file['file_ext'] = $ext;
			$data_file['file_size'] = $uploaded_data['size'];
			$data_file['status'] = 1;
			$data_file['_cid'] = $this->session->userdata("nip");
			$data_file['_ctime'] = date('Y-m-d H:i:s');

			$this->db->insert('ars_trx_arsip_attachment', $data_file);
            $insert_id = $this->db->insert_id();
		}
	}

	function insert_import_arsip(){
        $form = $this->input->post("f");
		for ($i=0; $i < count($form) ; $i++) { 
			$forminput = $form[$i];

			$this->db->set($forminput);
			if (!isset($forminput['nomor'])) $this->db->set('nomor', $this->checkNumber());
			$this->db->set('uuid',$this->getUUID());
			$this->db->set('status',1);
			$this->db->set("_cid",$this->session->userdata("nip"));
			$this->db->set("_ctime",date('Y-m-d H:i:s'));
			$this->db->insert("ars_trx_arsip");
			$insert_id = $this->db->insert_id();
			$this->m_reff->log("menambahkan data arsip");
		}

		if ($this->db->affected_rows() == 0) {
			$var["gagal"]=true;
            $var["info"]="Gagal Diinput.";
            $var["token"]=$this->m_reff->getToken();
            return $var;
		} 

		$var["gagal"]=false;
		$var["token"]=$this->m_reff->getToken();
		return $var;
    }

	function getUUID(){
		$query = "SELECT UUID() as datauuid";
        $v =  $this->db->query($query)->row_array();
        return $v['datauuid'];
	}

	function checkNumber(){
		$this->db->from("ars_trx_arsip");
        $count = $this->db->get()->num_rows();
		$number = "ARS/" . str_pad($count + 1, 5, '0', STR_PAD_LEFT);
        return $number;
	}

	function importShow(){
		try {
			$inputFile = $_FILES['files']['tmp_name'];
			$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
			$spreadsheet = $reader->load($inputFile); // Load file yang tadi diupload ke folder tmp
			$sheet = $spreadsheet->getActiveSheet(0);
			$highestRow =  $sheet->getHighestRow();
			$highestColumn = $sheet->getHighestColumn();

			for ($row = 4; $row <= $highestRow; $row++) {
				$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
				$dataRows = $rowData[0];
				$rowResult = array();
				$dateapprove = "";

				for ($i = 0; $i < count($dataRows); ++$i) {
					$dataField = $dataRows[$i];
					if ($dataRows[4] != "") {
						if (is_numeric($dataRows[4])) {
							$dateapprove = date('Y-m-d', \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($dataRows[4]));
						} else {
							$arrdate = explode("/", $dataRows[4]);
							$dateapprove = $arrdate[0] . "-" . $arrdate[1] . "-" . $arrdate[2];
						}
					}

					$rowResult[] = trim(preg_replace('/\s+/', ' ', $dataField));

					if (in_array($i, [1,2,5])) {
						if ($dataRows[1] != "" && $i == 1) {
							switch ($dataRows[1]) {
								case 'Konvensional':
									$dataField = 1;
								break;

								case 'Elektronik':
									$dataField = 2;
								break;
								
								default:
									$dataField = 3;
								break;
							}
						}

						if ($dataRows[2] != "" && $i == 2) {
							$kka = $this->db->where('kode', $dataRows[2])->get('ars_tr_kka')->row('peraturan_id');
							$dataField = $this->db->where('id', $kka)->get('ars_tr_peraturan')->row('nama');
						}

						if ($dataRows[5] != "" && $i == 5) {
							$dataField = $this->db->where('nama', $dataRows[5])->get('ars_tr_tingkat_perkembangan')->row('id');
						}

						$rowResult[] = trim(preg_replace('/\s+/', ' ', $dataField));
					}
				}

				array_push($rowResult, $dateapprove);

				$data['item'][] = $rowResult;
				$data['gagal'] = false;

				$data['status'] = 1;
				$data["info"]="Berhasil";
			}
		} catch (Exception $e) {
			die('Error loading file "' . pathinfo($inputFile, PATHINFO_BASENAME) . '": ' . $e->getMessage());
		}
		return $data;
	}

	function exportToPdf(){
		if ($this->input->get("type") != null) {
			$type = $this->input->get("type") == 3 ? [3,4,5] : [$this->input->get("type")];
			$this->db->where_in("jenis",$type);
		}
		$this->db->select("a.*, CONCAT(kka.kode, ' - ', kka.nama) as kka, tp.nama as tingkat_perkembangan", "left");
		$this->db->join("ars_tr_kka kka","a.kka_kode = kka.kode", "left");
		$this->db->join("ars_tr_tingkat_perkembangan tp","a.tingkat_perkembangan_id = tp.id");
		$this->db->from("ars_trx_arsip a");
		$data = $this->db->get()->result();
		
		$this->excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

        $style_col_table = array(
            'font' => array('bold' => true, 'color' => array('rgb' => 'FFFFFF')), // Set font nya jadi bold
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );

        $style_row_table = array(
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (LEFT)
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );
		$this->excel->setActiveSheetIndex(0)->setCellValue('A1', "Daftar Item Arsip");
		$this->excel->setActiveSheetIndex(0)->setCellValue('A3', "No");
		$this->excel->setActiveSheetIndex(0)->setCellValue('B3', "Jenis");
		$this->excel->setActiveSheetIndex(0)->setCellValue('C3', "Klasifikasi Arsip");
		$this->excel->setActiveSheetIndex(0)->setCellValue('D3', "Uraian Informasi Arsip");
		$this->excel->setActiveSheetIndex(0)->setCellValue('E3', "Kurun Waktu");
		$this->excel->setActiveSheetIndex(0)->setCellValue('F3', "Tingkat Perkembangan");
		$this->excel->setActiveSheetIndex(0)->setCellValue('G3', "Jumlah");
		$this->excel->setActiveSheetIndex(0)->setCellValue('H3', "Deksripsi");

		$column = range('A','H');
        $title = 'A1:H1';
        $th = 'A3:H3';

		foreach($column as $columnID) {
			$this->excel->getActiveSheet()->getColumnDimension($columnID)
				->setWidth(20);
			$this->excel->getActiveSheet()->getStyle($columnID . '3:' . $columnID . '3')
				->applyFromArray($style_col_table)->applyFromArray($style_row_table);
		}
        $this->excel->getActiveSheet()->mergeCells($title);
        $this->excel->getActiveSheet()->getStyle($th)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('8DB4E2');

        $this->excel->getActiveSheet()->getStyle('A1:A1')->applyFromArray(array(
            'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
        ));

		$numrow = 4;
		if (count($data) > 0) {
			foreach ($data as $key => $val) {
				$this->excel->setActiveSheetIndex(0)
					->setCellValue('A' . $numrow, $key + 1)
					->setCellValue('B' . $numrow, ($val->jenis == 1) ? "Arsip Konvensial" : (($val->jenis == 2) ? "Arsip Elektronik" : "Arsip Audio Visual"))
					->setCellValue('C' . $numrow, $val->kka ? $val->kka : '-')
					->setCellValue('D' . $numrow, $val->uraian ? $val->uraian : '-')
					->setCellValue('E' . $numrow, $val->kurun_waktu ? $val->kurun_waktu : '-')
					->setCellValue('F' . $numrow, $val->tingkat_perkembangan ? $val->tingkat_perkembangan : '-')
					->setCellValue('G' . $numrow, $val->jumlah ? $val->jumlah : '-')
					->setCellValue('H' . $numrow, $val->deskripsi ? $val->deskripsi : '-');


				foreach (range('A', $column[array_key_last($column)]) as $columnID) {
					$this->excel->getActiveSheet()->getStyle($columnID . $numrow)->applyFromArray($style_row_table);
					$this->excel->getActiveSheet()->getStyle($column[array_key_last($column)] . $numrow)->getAlignment()->setWrapText(true);
				}
				$numrow++;
			}
		} else {
			$this->excel->setActiveSheetIndex(0)->setCellValue('A'. $numrow, "Data Tidak Ditemukan");
			$this->excel->getActiveSheet()->mergeCells('A' . $numrow . ':' . $column[array_key_last($column)] . $numrow);
			$this->excel->getActiveSheet()->getStyle('A' . $numrow . ':' . $column[array_key_last($column)] . $numrow)->applyFromArray($style_row_table);
		}

		foreach (range('A', $column[array_key_last($column)]) as $columnID) {
			$this->excel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
		}

		$writer = new Xlsx($this->excel);
        $filename = 'Daftar Item Arsip.xlsx';
        $writer->save($filename);
		return $filename;
	}

	function templateImport()
    {
        $this->excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

        $style_col_table = array(
            'font' => array('bold' => true, 'color' => array('rgb' => 'FFFFFF')), // Set font nya jadi bold
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );

        $style_row_table = array(
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (LEFT)
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );

		$this->excel->setActiveSheetIndex(0)->setCellValue('A1', "Template Pendataan Item Arsip");
		$this->excel->setActiveSheetIndex(0)->setCellValue('A3', "No Arsip");
		$this->excel->setActiveSheetIndex(0)->setCellValue('B3', "Jenis");
		$this->excel->setActiveSheetIndex(0)->setCellValue('C3', "Klasifikasi Arsip");
		$this->excel->setActiveSheetIndex(0)->setCellValue('D3', "Uraian Informasi Arsip");
		$this->excel->setActiveSheetIndex(0)->setCellValue('E3', "Kurun Waktu");
		$this->excel->setActiveSheetIndex(0)->setCellValue('F3', "Tingkat Perkembangan");
		$this->excel->setActiveSheetIndex(0)->setCellValue('G3', "Jumlah");
		$this->excel->setActiveSheetIndex(0)->setCellValue('H3', "Deksripsi");

		$column = range('A','H');
        $title = 'A1:H1';
        $th = 'A3:H3';

		foreach($column as $columnID) {
			$this->excel->getActiveSheet()->getColumnDimension($columnID)
				->setWidth(20);
			$this->excel->getActiveSheet()->getStyle($columnID . '3:' . $columnID . '3')
				->applyFromArray($style_col_table)->applyFromArray($style_row_table);
		}

        $this->excel->getActiveSheet()->mergeCells($title);
        $this->excel->getActiveSheet()->getStyle($th)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('f15a23');

        $this->excel->getActiveSheet()->getStyle('A1:A1')->applyFromArray(array(
            'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
        ));

        $configs = "Tidak, Ya";

        $ListKKA = $this->db->where('level',1)->get("ars_tr_kka")->result_array();
        $ListTP = $this->db->get("ars_tr_tingkat_perkembangan")->result_array();

        $dropKKA = '';
        $dropTP = '';        

        if (count($ListKKA) > 0) {
            foreach ($ListKKA as $key => $value) {
                $dropKKA .= $dropKKA == '' ? str_replace('"', '', $value['kode']) : ',' . str_replace('"', '', $value['kode']);
            }
        }

        if (count($ListTP) > 0) {
            foreach ($ListTP as $key => $value) {
                $dropTP .= $dropTP == '' ? str_replace('"', '', $value['nama']) : ',' . str_replace('"', '', $value['nama']);
            }
        }

        $this->excel->getActiveSheet()->setCellValue('E4', date('Y/m/d'));

        foreach (['B', 'C', 'F'] as $col) {
            $this->excel->getActiveSheet()->setCellValue($col . '4', "-- Pilih salah satu --");
            $objValidation = $this->excel->getActiveSheet()->getCell($col . '4')->getDataValidation();
            $objValidation->setType(\PhpOffice\PhpSpreadsheet\cell\DataValidation::TYPE_LIST);
            $objValidation->setErrorStyle(\PhpOffice\PhpSpreadsheet\cell\DataValidation::STYLE_INFORMATION);
            $objValidation->setAllowBlank(false);
            $objValidation->setShowInputMessage(true);
            $objValidation->setShowErrorMessage(true);
            $objValidation->setShowDropDown(true);
            $objValidation->setErrorTitle('Tidak ada dalam list');
            $objValidation->setPromptTitle('Pilih');
			if($col == 'B'){
                $objValidation->setFormula1('"Konvensional,Elektronik,Audio Visual - Film / Video,Audio Visual - Foto,Audio Visual - Rekaman Suara / Audio Transkripsi"');
            }
            if($col == 'C'){
                $objValidation->setFormula1('"' . $dropKKA . '"');
            }
            else if ($col == 'F') {
                $objValidation->setFormula1('"' . $dropTP . '"');
            }
        }

        $writer = new Xlsx($this->excel);
        $filename = 'Template Pendataan Item Arsip.xlsx';
        $writer->save($filename);
		return $filename;
    }
}




