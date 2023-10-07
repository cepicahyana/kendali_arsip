<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ars_master extends CI_Controller {

 
	function __construct()
	{
		parent::__construct();	
		$this->m_konfig->validasi_session(array("admin_arsip","up","uk"));
		$this->load->model("model","mdl");
		 
		date_default_timezone_set('Asia/Jakarta');
	}

	function _template($data)
	{
		$this->load->view('temp_arsip/main',$data);	
	}
	

	
	

	public function index()
	{

		$ajax=$this->input->post("ajax");
		if($ajax=="yes")
		{
			echo	$this->load->view("index");
		}else{
			$data['konten']="index";
			$this->_template($data);
		}
		
	}  

	


	public function tingkat_perkembangan()
	{

		$ajax=$this->input->post("ajax");
		$var["title"]		=	"Tingkat perkembangan";
		$var["subtitle"]	=	"Master / Tingkat perkembangan";
		if($ajax=="yes")
		{
			$var["data"]=$this->load->view("tingkat_perkembangan",null,true);
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
		}else{
			$var['konten']="tingkat_perkembangan";
			$this->_template($var);
		}
		
	}  

	 

	function update_tingkat_perkembangan(){
		$f=$this->input->post();
		if(!$f){ return $this->m_reff->page403();}

		$data = $this->mdl->update_tingkat_perkembangan();
		echo json_encode($data);
	}

	 

	function hapus_tingkat_perkambangan(){
		$id = $this->m_reff->san($this->input->post("id"));
		if(!$id){ return $this->m_reff->page403();}

		$data = $this->mdl->hapus_tingkat_perkambangan();
		echo json_encode($data);
	}
   

	 

	function getData_tingkaPerkembangan()
	{
		if(!$this->m_reff->san($this->input->post("draw"))){ echo $this->m_reff->page403(); return false;}
		$list = $this->mdl->getData_tingkaPerkembangan();
		$data = array();
		$no = $this->m_reff->san($this->input->post("start"));
		$no =$no+1;
		foreach ($list as $val) {
         ////

		 $tombol='<div aria-label="Basic example" class="btn-groupss" role="group">
		 <button   onclick="action_form(`'.$val->id.'`,`'.$val->nama.'`)" class="font14 btn btn-sm ti-pencil btn-secondary" type="button"> Edit</button> 
		 <button style="color:white" onclick="hapus(`'.$val->id.'`,`'.$val->nama.'`)" class="font14 btn btn-sm ti-trash bg-danger" type="button"> Hapus</button> 
		 </div>';
 

		 $row = array();
		 $row[] = $no++;	
		 $row[] = $val->nama;
		 
		 $row[] = $tombol;
		 $data[] = $row; 

		}

		$output = array(
			"draw" => $this->m_reff->san($this->input->post("draw")),
			"recordsTotal" => $c=$this->mdl->count_tingkaPerkembangan(),
			"recordsFiltered" =>$c,
			"data" => $data,
			"token"=>$this->m_reff->getToken()
		);
         //output to json format
		echo json_encode($output);

	}

	function form_tingkat_perkembangan(){ 
		$var["data"]=$this->load->view("form_tingkat_perkembangan",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}


	//master unit_kearsipan-------------------------------------------------------------------------------------
	public function unit_kearsipan()
	{
		$ajax=$this->input->post("ajax");
		$var["title"]		=	"Unit Kearsipan";
		$var["subtitle"]	=	"Master / Unit Kearsipan";
		if($ajax=="yes")
		{
			$var["data"]=$this->load->view("unit_kearsipan",null,true);
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
		}else{
			$var['konten']="unit_kearsipan";
			$this->_template($var);
		}

	} 

	function getData_unitKearsipan()
	{
		if(!$this->m_reff->san($this->input->post("draw"))){ echo $this->m_reff->page403(); return false;}
		$list = $this->mdl->getData_unitKearsipan();
		$data = array();
		$no = $this->m_reff->san($this->input->post("start"));
		$no =$no+1;
		foreach ($list as $val) {
		////
		$id=$val->id??null;
		$uuid=$val->uuid??null;
		$type=$val->type??'';
		$parent_uuid=$val->parent_uuid??'';
		$organization_kode=$val->organization_kode??'';
		$description=$val->description??'';
		$status=$val->status??'';

		if($type==1){
			$type_name="Unit Kearsipan I";
		}
		if($type==2){
			$type_name="Unit Kearsipan II";
		}
		if($type==3){
			$type_name="Unit Kearsipan III";
		}

		if($parent_uuid){
			$getUuid=$this->db->get_where("ars_tr_uk",array("parent_uuid"=>$parent_uuid))->row();
			$type_parent=$getUuid->type??"";
			if($type_parent==1){
				$parent="";
			}
			if($type_parent==2){
				$parent="Unit Kearsipan I";
			}
			if($type_parent==3){
				$parent="Unit Kearsipan II";
			}
		}else{
			$parent="";
		}

		if($organization_kode){
			$getOrg=$this->db->get_where("ars_tr_organisasi",array("kode"=>$organization_kode))->row();
			$nama_organisasi=$getOrg->nama??"";
		}else{
			$nama_organisasi="";
		}

		$jumlah_pegawai=$this->db->get_where("ars_tr_uk_employee",array("uk_uuid"=>$uuid))->num_rows();
		if($jumlah_pegawai==0){
			$jml_peg="";
		}else{
			$jml_peg=$jumlah_pegawai.' orang';
		}

		if($status==1){
			$sts='aktif';
		}else{
			$sts='nonaktif';
		}

		$tombol='<div aria-label="Basic example" class="btn-groupss" role="group">
		<a href="'.site_url("ars_master/form_unit_kearsipan").'?id='.$uuid.'"  class="font14 btn btn-sm ti-pencil btn-secondary menuclick"> Edit</a> 
		<button style="color:white" onclick="hapus(`'.$uuid.'`,`'.$type_name.'`)" class="font14 btn btn-sm ti-trash bg-danger" type="button"> Hapus</button> 
		</div>';


		$row = array();
		$row[] = $no++;	
		$row[] = $type_name;
		$row[] = $parent;
		$row[] = $description;
		$row[] = $nama_organisasi;
		$row[] = $jml_peg;
		$row[] = $sts;
		
		$row[] = $tombol;
		$data[] = $row; 

		}

		$output = array(
			"draw" => $this->m_reff->san($this->input->post("draw")),
			"recordsTotal" => $c=$this->mdl->count_unitKearsipan(),
			"recordsFiltered" =>$c,
			"data" => $data,
			"token"=>$this->m_reff->getToken()
		);
		//output to json format
		echo json_encode($output);

	} 
	function form_unit_kearsipan(){ 
		$ajax=$this->input->post("ajax");
		$id=$this->input->get_post("id");
		$var["title"]		=	"Unit Kearsipan";
		
		if($id!=null){
			$var["subtitle"]	=	"Master / Form Edit Unit Kearsipan";
			$var["formhead"]	=	"Form Edit Unit Kearsipan";
		}else{
			$var["subtitle"]	=	"Master / Form Tambah Unit Kearsipan";
			$var["formhead"]	=	"Form Tambah Unit Kearsipan";
		}
		
		if($ajax=="yes")
		{
			$var["data"]=$this->load->view("form_unit_kearsipan",$var,true);
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
		}else{
			$var['konten']="form_unit_kearsipan";
			$this->_template($var);
		}
	}
	function update_unit_kearsipan(){
		$f=$this->input->post();
		if(!$f){ return $this->m_reff->page403();}

		$data = $this->mdl->update_unit_kearsipan();
		echo json_encode($data);
	}
	function hapus_unit_kearsipan(){
		$id = $this->m_reff->san($this->input->post("id"));
		if(!$id){ return $this->m_reff->page403();}

		$data = $this->mdl->hapus_unit_kearsipan();
		echo json_encode($data);
	}
	function downloadXL_unit_kearsipan(){
		// $f1=$this->input->get("f1");
		// if($f1){
		// 	$this->db->where('kode',$f1); 
		// }
		$this->db->order_by('id','asc');
		$db=$this->db->get('ars_tr_uk')->result();
		$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		//TOPHEAD
		$sheet->mergeCells('A1:G1')->setCellValue('A1', 'MASTER UNIT KEARSIPAN');
		$sheet->mergeCells('A2:G2')->setCellValue('A2', 'Dicetak '.date("d-M-Y  H:i:s").'');
		$sheet->mergeCells('A3:G3')->setCellValue('A3', '');
		//HEADERTABLE
		$sheet->setCellValue('A4', 'NO');
		$sheet->setCellValue('B4', 'UNIT KEARSIPAN');
		$sheet->setCellValue('C4', 'PARENT UK');
		$sheet->setCellValue('D4', 'DESKRIPSI');
		$sheet->setCellValue('E4', 'ORGANISASI');
		$sheet->setCellValue('F4', 'JUMLAH PEGAWAI');
		$sheet->setCellValue('G4', 'STATUS');
		//ISITABLE
		$no=5;
		foreach($db as $key => $val){
		    $id=$val->id??'';
			$uuid=$val->uuid??'';
			$type=$val->type??'';
			$parent_uuid=$val->parent_uuid??'';
			$organization_kode=$val->organization_kode??'';
			$description=$val->description??'';
			$status=$val->status??'';

			if($type==1){
				$type_name="Unit Kearsipan I";
			}
			if($type==2){
				$type_name="Unit Kearsipan II";
			}
			if($type==3){
				$type_name="Unit Kearsipan III";
			}

			if($parent_uuid){
				$getUuid=$this->db->get_where("ars_tr_uk",array("parent_uuid"=>$parent_uuid))->row();
				$type_parent=$getUuid->type??"";
				if($type_parent==1){
					$parent="";
				}
				if($type_parent==2){
					$parent="Unit Kearsipan I";
				}
				if($type_parent==3){
					$parent="Unit Kearsipan II";
				}
			}else{
				$parent="";
			}

			if($organization_kode){
				$getOrg=$this->db->get_where("ars_tr_organisasi",array("kode"=>$organization_kode))->row();
				$nama_organisasi=$getOrg->nama??"";
			}else{
				$nama_organisasi="";
			}

			$jumlah_pegawai=$this->db->get_where("ars_tr_uk_employee",array("uk_uuid"=>$uuid))->num_rows();
			if($jumlah_pegawai==0){
				$jml_peg="";
			}else{
				$jml_peg=$jumlah_pegawai.' orang';
			}

			if($status==1){
				$sts='aktif';
			}else{
				$sts='nonaktif';
			}

			$sheet->setCellValue('A'.$no, ($no-4));
			$sheet->setCellValue('B'.$no, $type_name);
			$sheet->setCellValue('C'.$no, $parent);
			$sheet->setCellValue('D'.$no, $description);
			$sheet->setCellValue('E'.$no, $nama_organisasi);
			$sheet->setCellValue('F'.$no, $jml_peg);
			$sheet->setCellValue('G'.$no, $sts);
			$no++;
		}
		$sheet->getStyle('A1:G4')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('A1:G4')->getFont()->setBold(true);
		$sheet->getStyle('A4:G4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFFF00');
		$styleArray = [
			'borders'=> [
				'allBorders' => [
					'borderStyle' => \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN,
					'color' => ['argb'=>'FF000000'],
				],
			],
		];
		$sheet->getStyle('A1:G'.($no-1))->applyFromArray($styleArray);

		$sheet->getColumnDimension('A')->setAutoSize(true);
		$sheet->getColumnDimension('B')->setAutoSize(true);
		$sheet->getColumnDimension('C')->setAutoSize(true);
		$sheet->getColumnDimension('D')->setAutoSize(true);
		$sheet->getColumnDimension('E')->setAutoSize(true);
		$sheet->getColumnDimension('F')->setAutoSize(true);
		$sheet->getColumnDimension('G')->setWidth(10);

		$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename=master_unit_kearsipan.xlsx');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
		exit();
	}
	function get_parent_unit_kearsipan(){
	    $action = $this->input->post('action');
		$kode = $this->input->post('kd');
		$jmlkode=strlen($kode);
		if($action=='form'){
			$list = '<option value="">=== Pilih ===</option>';
		}else{
			$list = '<option value="">=== Pilih ===</option>';
		}

		if($kode==2){
			$db = $this->db->order_by('description','ASC');
			$db = $this->db->get_where('ars_tr_uk',array('type'=>1))->result();
		}
		if($kode==3){
			$db = $this->db->order_by('description','ASC');
			$db = $this->db->get_where('ars_tr_uk',array('type'=>2))->result();
		}
        
		foreach($db as $val)
		{
			$type="";
			if($val->type==1){
				$type="Unit Kearsipan I";
			}
			if($val->type==2){
				$type="Unit Kearsipan II";
			}
			if($val->type==3){
				$type="Unit Kearsipan III";
			}

			if($val->organization_kode){
				$getOrg=$this->db->get_where("ars_tr_organisasi",array("kode"=>$val->organization_kode))->row();
				$nama_organisasi=$getOrg->nama??"";
			}else{
				$nama_organisasi="";
			}
			if($nama_organisasi){		
				$list .= "<option value='" . $val->uuid . "' dt='" . $val->description . "'>" . $type ." (".$nama_organisasi.")</option>";
			}else{
				$list .= "<option value='" . $val->uuid . "' dt='" . $val->description . "'>" . $type ."</option>";
			}
		}
		$var["data"]=$list;
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}
	function get_uk_employe(){
		$data['kode_organisasi'] = $this->input->post('kd');
		$data['uuid'] = $this->input->post('uuid');
		$var["data"]=$this->load->view("pilihan_employe_uk",$data,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}
	function remove_employe_uk(){
		$id = $this->m_reff->san($this->input->post("id"));
		if(!$id){ return $this->m_reff->page403();}

		$id = $this->input->post("id");
        $this->db->where("uuid",$id);
        $hapus=$this->db->delete("ars_tr_uk_employee");

		$data = $hapus;
		echo json_encode($data);
	}
	
	// function get_organisasi(){
	//     $action = $this->input->post('action');
	// 	$kode = $this->input->post('kd');
	// 	$jmlkode=strlen($kode);
	// 	if($action=='form'){
	// 		$list = '<option value="">=== Pilih ===</option>';
	// 	}else{
	// 		$list = '<option value="">=== Pilih ===</option>';
	// 	}

	// 	$get = $this->db->get_where('ars_tr_uk',array('parent_uuid'=>$kode))->row();
	// 	$type=$get->type??'';
	// 	$this->db->select("LENGTH(kode) as jml, kode,nama");
	// 	if($type==1){
	// 		$this->db->where("jml","2");
	// 		$this->db->where("kode","01");
	// 		$this->db->order_by('kode','ASC');
	// 		$db = $this->db->get('ars_tr_organisasi')->result();
	// 		foreach($db as $val)
	// 		{
	// 			$list .= "<option value='" . $val->kode . "'>" . $val->nama . "</option>";
	// 		}
	// 	}
	// 	if($type==2){
	// 		$this->db->where("jml","6");
	// 		$this->db->order_by('kode','ASC');
	// 		$db = $this->db->get('ars_tr_organisasi')->result();
	// 		foreach($db as $val)
	// 		{
	// 			$list .= "<option value='" . $val->kode . "'>" . $val->nama . "</option>";
	// 		}
	// 	}
	// 	if($type==3){
	// 		$this->db->where("jml","8");
	// 		$this->db->order_by('kode','ASC');
	// 		$db = $this->db->get('ars_tr_organisasi')->result();
	// 		foreach($db as $val)
	// 		{
	// 			$list .= "<option value='" . $val->kode . "'>" . $val->nama . "</option>";
	// 		}
	// 	}

        
	// 	$var["data"]=$list;
	// 	$var["token"]=$this->m_reff->getToken();
	// 	echo json_encode($var);
	// }

	//master unit_pengelola-------------------------------------------------------------------------------------
	public function unit_pengelola()
	{
		$ajax=$this->input->post("ajax");
		$var["title"]		=	"Unit Pengelola";
		$var["subtitle"]	=	"Master / Unit Pengelola";
		if($ajax=="yes")
		{
			$var["data"]=$this->load->view("unit_pengelola",null,true);
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
		}else{
			$var['konten']="unit_pengelola";
			$this->_template($var);
		}

	} 
	function getData_unitPengelola()
	{
		if(!$this->m_reff->san($this->input->post("draw"))){ echo $this->m_reff->page403(); return false;}
		$list = $this->mdl->getData_unitPengelola();
		$data = array();
		$no = $this->m_reff->san($this->input->post("start"));
		$no =$no+1;
		foreach ($list as $val) {
		////
		$id=$val->id??'';
		$uuid=$val->uuid??'';
		$uk_uuid=$val->uk_uuid??'';
		$organisasi_kode=$val->organisasi_kode??'';
		$description=$val->description??'';
		$status=$val->status??'';

		if($uk_uuid){
			$getUk=$this->db->get_where("ars_tr_uk",array("uuid"=>$uk_uuid))->row();
			if($getUk->type==1){
				$unit_kearsipan="Unit Kearsipan I";
			}
			if($getUk->type==2){
				$unit_kearsipan="Unit Kearsipan II";
			}
			if($getUk->type==3){
				$unit_kearsipan="Unit Kearsipan III";
			}
		}else{
			$unit_kearsipan="";
		}

		if($organisasi_kode){
			$getOrg=$this->db->get_where("ars_tr_organisasi",array("kode"=>$organisasi_kode))->row();
			$nama_organisasi=$getOrg->nama??"";
		}else{
			$nama_organisasi="";
		}

		$jumlah_pegawai=$this->db->get_where("ars_tr_up_employee",array("up_uuid"=>$uuid))->num_rows();
		if($jumlah_pegawai==0){
			$jml_peg="";
		}else{
			$jml_peg=$jumlah_pegawai.' orang';
		}

		if($status==1){
			$sts='aktif';
		}else{
			$sts='nonaktif';
		}

		$tombol='<div aria-label="Basic example" class="btn-groupss" role="group">
		<a href="'.site_url("ars_master/form_unit_pengelola").'?id='.$uuid.'"  class="font14 btn btn-sm ti-pencil btn-secondary menuclick"> Edit</a> 
		<button style="color:white" onclick="hapus(`'.$uuid.'`,`'.$description.'`)" class="font14 btn btn-sm ti-trash bg-danger" type="button"> Hapus</button> 
		</div>';


		$row = array();
		$row[] = $no++;	
		$row[] = $unit_kearsipan;
		$row[] = $nama_organisasi;
		$row[] = $description;
		$row[] = $jml_peg;
		$row[] = $sts;
		
		$row[] = $tombol;
		$data[] = $row; 

		}

		$output = array(
			"draw" => $this->m_reff->san($this->input->post("draw")),
			"recordsTotal" => $c=$this->mdl->count_unitPengelola(),
			"recordsFiltered" =>$c,
			"data" => $data,
			"token"=>$this->m_reff->getToken()
		);
		//output to json format
		echo json_encode($output);

	} 
	function form_unit_pengelola(){ 
		$ajax=$this->input->post("ajax");
		$id=$this->input->get_post("id");
		$var["title"]		=	"Unit Pengelola";
		
		if($id!=null){
			$var["subtitle"]	=	"Master / Form Edit Unit Pengelola";
			$var["formhead"]	=	"Form Edit Unit Pengelola";
		}else{
			$var["subtitle"]	=	"Master / Form Tambah Unit Pengelola";
			$var["formhead"]	=	"Form Tambah Unit Pengelola";
		}
		
		if($ajax=="yes")
		{
			$var["data"]=$this->load->view("form_unit_pengelola",$var,true);
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
		}else{
			$var['konten']="form_unit_pengelola";
			$this->_template($var);
		}
	}
	function update_unit_pengelola(){
		$f=$this->input->post();
		if(!$f){ return $this->m_reff->page403();}

		$data = $this->mdl->update_unit_pengelola();
		echo json_encode($data);
	}
	function hapus_unit_pengelola(){
		$id = $this->m_reff->san($this->input->post("id"));
		if(!$id){ return $this->m_reff->page403();}

		$data = $this->mdl->hapus_unit_pengelola();
		echo json_encode($data);
	}
	function downloadXL_unit_pengelola(){
		// $f1=$this->input->get("f1");
		// if($f1){
		// 	$this->db->where('kode',$f1); 
		// }
		$this->db->order_by('id','asc');
		$db=$this->db->get('ars_tr_up')->result();
		$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		//TOPHEAD
		$sheet->mergeCells('A1:F1')->setCellValue('A1', 'MASTER UNIT PENGELOLA');
		$sheet->mergeCells('A2:F2')->setCellValue('A2', 'Dicetak '.date("d-M-Y  H:i:s").'');
		$sheet->mergeCells('A3:F3')->setCellValue('A3', '');
		//HEADERTABLE
		$sheet->setCellValue('A4', 'NO');
		$sheet->setCellValue('B4', 'UNIT KEARSIPAN');
		$sheet->setCellValue('C4', 'ORGANISASI');
		$sheet->setCellValue('D4', 'DESKRIPSI');
		$sheet->setCellValue('E4', 'JUMLAH PEGAWAI');
		$sheet->setCellValue('F4', 'STATUS');
		//ISITABLE
		$no=5;
		foreach($db as $key => $val){
		    $id=$val->id??'';
			$uuid=$val->uuid??'';
			$uk_uuid=$val->uk_uuid??'';
			$organisasi_kode=$val->organisasi_kode??'';
			$description=$val->description??'';
			$status=$val->status??'';

			if($uk_uuid){
				$getUk=$this->db->get_where("ars_tr_uk",array("uuid"=>$uk_uuid))->row();
				if($getUk->type==1){
					$unit_kearsipan="Unit Kearsipan I";
				}
				if($getUk->type==2){
					$unit_kearsipan="Unit Kearsipan II";
				}
				if($getUk->type==3){
					$unit_kearsipan="Unit Kearsipan III";
				}
			}else{
				$unit_kearsipan="";
			}

			if($organisasi_kode){
				$getOrg=$this->db->get_where("ars_tr_organisasi",array("kode"=>$organisasi_kode))->row();
				$nama_organisasi=$getOrg->nama??"";
			}else{
				$nama_organisasi="";
			}

			$jumlah_pegawai=$this->db->get_where("ars_tr_up_employee",array("up_uuid"=>$uuid))->num_rows();
			if($jumlah_pegawai==0){
				$jml_peg="";
			}else{
				$jml_peg=$jumlah_pegawai.' orang';
			}

			if($status==1){
				$sts='aktif';
			}else{
				$sts='nonaktif';
			}


			$sheet->setCellValue('A'.$no, ($no-4));
			$sheet->setCellValue('B'.$no, $unit_kearsipan);
			$sheet->setCellValue('C'.$no, $nama_organisasi);
			$sheet->setCellValue('D'.$no, $description);
			$sheet->setCellValue('E'.$no, $jml_peg);
			$sheet->setCellValue('F'.$no, $sts);
			$no++;
		}
		$sheet->getStyle('A1:F4')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('A1:F4')->getFont()->setBold(true);
		$sheet->getStyle('A4:F4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFFF00');
		$styleArray = [
			'borders'=> [
				'allBorders' => [
					'borderStyle' => \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN,
					'color' => ['argb'=>'FF000000'],
				],
			],
		];
		$sheet->getStyle('A1:F'.($no-1))->applyFromArray($styleArray);

		$sheet->getColumnDimension('A')->setAutoSize(true);
		$sheet->getColumnDimension('B')->setAutoSize(true);
		$sheet->getColumnDimension('C')->setAutoSize(true);
		$sheet->getColumnDimension('D')->setAutoSize(true);
		$sheet->getColumnDimension('E')->setAutoSize(true);
		$sheet->getColumnDimension('F')->setWidth(10);

		$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename=master_unit_pengelola.xlsx');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
		exit();
	}
	function get_up_employe(){
		$data['kode_organisasi'] = $this->input->post('kd');
		$data['uuid'] = $this->input->post('uuid');
		$var["data"]=$this->load->view("pilihan_employe_up",$data,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}
	function remove_employe_up(){
		$id = $this->m_reff->san($this->input->post("id"));
		if(!$id){ return $this->m_reff->page403();}

		$id = $this->input->post("id");
        $this->db->where("uuid",$id);
        $hapus=$this->db->delete("ars_tr_up_employee");

		$data = $hapus;
		echo json_encode($data);
	}


	//master klasifikasi_arsip-------------------------------------------------------------------------------------
	public function klasifikasi_arsip()
	{
		$ajax=$this->input->post("ajax");
		$var["title"]		=	"Klasifikasi Arsip";
		$var["subtitle"]	=	"Master / Klasifikasi Arsip";
		if($ajax=="yes")
		{
			$var["data"]=$this->load->view("klasifikasi_arsip",null,true);
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
		}else{
			$var['konten']="klasifikasi_arsip";
			$this->_template($var);
		}

	} 
	function getData_KlasifikasiArsip()
	{
		if(!$this->m_reff->san($this->input->post("draw"))){ echo $this->m_reff->page403(); return false;}
		$list = $this->mdl->getData_KlasifikasiArsip();
		$data = array();
		$no = $this->m_reff->san($this->input->post("start"));
		$no =$no+1;
		foreach ($list as $val) {
		////
		$id=$val->id??'';
		$uuid=$val->uuid??'';
		$kode=$val->kode??'';
		$parent_kode=$val->parent_kode??'';
		$nama=$val->nama??'';
		$deskripsi=$val->deskripsi??'';
		$status=$val->status??'';
		$level=$val->level??'';
		$peraturan_id=$val->peraturan_id??'';

		if($peraturan_id){
			$getPer=$this->db->get_where("ars_tr_peraturan",array("id"=>$peraturan_id))->row();
			$peraturan=$getPer->nama??"";
		}else{
			$peraturan="";
		}

		if($parent_kode){
			$this->db->where('kode',$parent_kode);
			$this->db->where('peraturan_id',$peraturan_id);
			$getPar=$this->db->get("ars_tr_kka")->row();
			$parent_nama=$getPar->nama??"";
		}else{
			$parent_nama="";
		}

		if($status==1){
			$sts='aktif';
		}else{
			$sts='nonaktif';
		}
		$tombol='<div aria-label="Basic example" class="btn-groupss" role="group">
		<button   onclick="action_form(`'.$uuid.'`,`'.$nama.'`)" class="font14 btn btn-sm ti-pencil btn-secondary" type="button"> Edit</button> 
		<button style="color:white" onclick="hapus(`'.$uuid.'`,`'.$nama.'`)" class="font14 btn btn-sm ti-trash bg-danger" type="button"> Hapus</button> 
		</div>';


		$row = array();
		$row[] = $no++;	
		$row[] = $peraturan;
		$row[] = $kode;
		$row[] = $parent_nama;
		$row[] = $nama;
		$row[] = $deskripsi;
		$row[] = $sts;
		$row[] = $tombol;
		$data[] = $row; 

		}

		$output = array(
			"draw" => $this->m_reff->san($this->input->post("draw")),
			"recordsTotal" => $c=$this->mdl->count_KlasifikasiArsip(),
			"recordsFiltered" =>$c,
			"data" => $data,
			"token"=>$this->m_reff->getToken()
		);
		//output to json format
		echo json_encode($output);

	} 
	function form_klasifikasi_arsip(){ 
		$var["data"]=$this->load->view("form_klasifikasi_arsip",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}
	function update_klasifikasi_arsip(){
		$f=$this->input->post();
		if(!$f){ return $this->m_reff->page403();}

		$data = $this->mdl->update_klasifikasi_arsip();
		echo json_encode($data);
	}
	function hapus_klasifikasi_arsip(){
		$id = $this->m_reff->san($this->input->post("id"));
		if(!$id){ return $this->m_reff->page403();}

		$data = $this->mdl->hapus_klasifikasi_arsip();
		echo json_encode($data);
	}
	function downloadXL_klasifikasi_arsip(){
		$f1=$this->input->get("f1");
		$f2=$this->input->get("f2");
		if($f1){
            $this->db->where('peraturan_id',$f1);
        }
        if($f2){
            $this->db->where('level',$f2);
        }
		$this->db->order_by('id','asc');
		$db=$this->db->get('ars_tr_kka')->result();
		$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		//TOPHEAD
		$sheet->mergeCells('A1:G1')->setCellValue('A1', 'MASTER KLASIFIKASI');
		$sheet->mergeCells('A2:G2')->setCellValue('A2', 'Dicetak '.date("d-M-Y  H:i:s").'');
		$sheet->mergeCells('A3:G3')->setCellValue('A3', '');
		//HEADERTABLE
		$sheet->setCellValue('A4', 'NO');
		$sheet->setCellValue('B4', 'PERATURAN');
		$sheet->setCellValue('C4', 'KODE');
		$sheet->setCellValue('D4', 'PARENT');
		$sheet->setCellValue('E4', 'NAMA');
		$sheet->setCellValue('F4', 'DESKRIPSI');
		$sheet->setCellValue('G4', 'STATUS');
		//ISITABLE
		$no=5;
		foreach($db as $key => $val){
		    $id=$val->id??'';
			$uuid=$val->uuid??'';
			$kode=$val->kode??'';
			$parent_kode=$val->parent_kode??'';
			$nama=$val->nama??'';
			$deskripsi=$val->deskripsi??'';
			$status=$val->status??'';
			$level=$val->level??'';
			$peraturan_id=$val->peraturan_id??'';

			if($peraturan_id){
				$getPer=$this->db->get_where("ars_tr_peraturan",array("id"=>$peraturan_id))->row();
				$peraturan=$getPer->nama??"";
			}else{
				$peraturan="";
			}

			if($parent_kode){
				$this->db->where('kode',$parent_kode);
				$this->db->where('peraturan_id',$peraturan_id);
				$getPar=$this->db->get("ars_tr_kka")->row();
				$parent_nama=$getPar->nama??"";
			}else{
				$parent_nama="";
			}

			if($status==1){
				$sts='aktif';
			}else{
				$sts='nonaktif';
			}

			$sheet->setCellValue('A'.$no, ($no-4));
			$sheet->setCellValue('B'.$no, $peraturan);
			$sheet->setCellValue('C'.$no, $kode);
			$sheet->setCellValue('D'.$no, $parent_nama);
			$sheet->setCellValue('E'.$no, $nama);
			$sheet->setCellValue('F'.$no, $deskripsi);
			$sheet->setCellValue('G'.$no, $sts);
			$no++;
		}
		$sheet->getStyle('A1:G4')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('A1:G4')->getFont()->setBold(true);
		$sheet->getStyle('A4:G4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFFF00');
		$styleArray = [
			'borders'=> [
				'allBorders' => [
					'borderStyle' => \PhpOffice\PhpSpreadsheet\style\Border::BORDER_THIN,
					'color' => ['argb'=>'FF000000'],
				],
			],
		];
		$sheet->getStyle('A1:G'.($no-1))->applyFromArray($styleArray);

		$sheet->getColumnDimension('A')->setAutoSize(true);
		$sheet->getColumnDimension('B')->setAutoSize(true);
		$sheet->getColumnDimension('C')->setAutoSize(true);
		$sheet->getColumnDimension('D')->setWidth(80);
		$sheet->getColumnDimension('E')->setWidth(80);
		$sheet->getColumnDimension('F')->setAutoSize(true);
		$sheet->getColumnDimension('G')->setWidth(10);

		$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename=master_klasifikasi_arsip.xlsx');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
		exit();
	}
	function filter_kode_klasifikasi(){

		$level = $this->input->post('level');
		$peraturan_id = $this->input->post('peraturan_id');
		
		$list = '<option value="">=== Pilih ===</option>';
		if($level){
			$this->db->where("level",$level);
		}
		if($peraturan_id){
			$this->db->where("peraturan_id",$peraturan_id);
		}
		
		// $this->db->group_by("kode");
		$this->db->order_by('kode','ASC');
		$db = $this->db->get('ars_tr_kka')->result();
		foreach($db as $val)
		{
			$list .= "<option value='" . $val->kode . "'>" . $val->kode . " - " . $val->nama . "</option>";
		}

		$var["data"]=$list;
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}
	function get_parent_kode_klasifikasi(){
	    $action = $this->input->post('action');
		$level = $this->input->post('level');
		$peraturan_id = $this->input->post('peraturan_id');
		
		if($action=='form'){
			$list = '<option value="">=== Pilih ===</option>';
		}else{
			$list = '<option value="">=== Pilih ===</option>';
		}

		if($level==2){
			$this->db->where("level",1);
		}
		if($level==3){
			$this->db->where("level",2);
		}
		$this->db->where("peraturan_id",$peraturan_id);
		$this->db->group_by("kode");
		$this->db->order_by('kode','ASC');
		$db = $this->db->get('ars_tr_kka')->result();
		foreach($db as $val)
		{
			$list .= "<option value='" . $val->kode . "'>" . $val->kode . " - " . $val->nama . "</option>";
		}

		$var["data"]=$list;
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}
	function get_kode_klasifikasi_arsip(){
	    $action = $this->input->post('action');
		$kode = $this->input->post('kd');
		$level = $this->input->post('level');
		$peraturan_id = $this->input->post('peraturan_id');
		
		$list=$this->generate_kode_klasifikasi_arsip($kode,$level,$peraturan_id);
		
		$var["data"]=$list;
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}
	function generate_kode_klasifikasi_arsip($kode,$level,$peraturan_id){
		if($level==2){
			$this->db->select("(MAX(SUBSTR(kode,4,2))+1) as kodenumber");
			$this->db->where("level",$level);
			$this->db->where("peraturan_id",$peraturan_id);
			$this->db->where("parent_kode",$kode);
			$t = $this->db->get("ars_tr_kka")->row();
			$idv=isset($t->kodenumber)?($t->kodenumber):''; 
			if(!$idv){  $idv = "00"; }
			$gen=sprintf("%02s", $idv);
			return  $kode.'.'.$gen;
		}
		if($level==3){
			$this->db->select("(MAX(SUBSTR(kode,7,2))+1) as kodenumber");
			$this->db->where("level",$level);
			$this->db->where("peraturan_id",$peraturan_id);
			$this->db->where("parent_kode",$kode);
			$t = $this->db->get("ars_tr_kka")->row();
			$idv=isset($t->kodenumber)?($t->kodenumber):''; 
			if(!$idv){  $idv = "00"; }
			$gen=sprintf("%02s", $idv);
			return  $kode.'.'.$gen;
		}
	}


	//master jra-------------------------------------------------------------------------------------
	public function jra()
	{
		$ajax=$this->input->post("ajax");
		$var["title"]		=	"Jarak Retensi Arsip";
		$var["subtitle"]	=	"Master / Jarak Retensi Arsip";
		if($ajax=="yes")
		{
			$var["data"]=$this->load->view("jra",null,true);
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
		}else{
			$var['konten']="jra";
			$this->_template($var);
		}

	} 
	function getData_jra()
	{
		if(!$this->m_reff->san($this->input->post("draw"))){ echo $this->m_reff->page403(); return false;}
		$list = $this->mdl->getData_jra();
		$data = array();
		$no = $this->m_reff->san($this->input->post("start"));
		$no =$no+1;
		foreach ($list as $val) {
		////
		$id=$val->id??'';
		$uuid=$val->uuid??'';
		$nama=$val->nama??'';
		$deskripsi=$val->deskripsi??'';
		$retensi_aktif=$val->retensi_aktif??'';
		$retensi_aktif_deskripsi=$val->retensi_aktif_deskripsi??'';
		$retensi_inaktif=$val->retensi_inaktif??'';
		$retensi_inaktif_deskripsi=$val->retensi_inaktif_deskripsi??'';
		$tindak_lanjut_uuid=$val->tindak_lanjut_uuid??'';
		$status=$val->status??'';
		$kode=$val->kode??'';
		$parent_kode=$val->parent_kode??'';
		$level=$val->level??'';

		if($parent_kode){
			$this->db->where('kode',$parent_kode);
			$getPar=$this->db->get("ars_tr_jra")->row();
			$parent_nama=$getPar->nama??"";
		}else{
			$parent_nama="";
		}

		if($tindak_lanjut_uuid){
			$getTL=$this->db->get_where("ars_tr_tindak_lanjut",array("uuid"=>$tindak_lanjut_uuid))->row();
			$tindak_lanjut=$getTL->nama??"";
		}else{
			$tindak_lanjut="";
		}

		if($retensi_aktif){
			$raktif="".$retensi_aktif." Tahun ".$retensi_aktif_deskripsi."";
		}else{
			$raktif="";
		}
		if($retensi_inaktif){
			$rinaktif="".$retensi_inaktif." Tahun ".$retensi_inaktif_deskripsi."";
		}else{
			$rinaktif="";
		}

		if($status==1){
			$sts='aktif';
		}else{
			$sts='nonaktif';
		}
		$tombol='<div aria-label="Basic example" class="btn-groupss" role="group">
		<button   onclick="action_form(`'.$uuid.'`,`'.$nama.'`)" class="font14 btn btn-sm ti-pencil btn-secondary mb-2" type="button"> Edit</button> 
		<button style="color:white" onclick="hapus(`'.$uuid.'`,`'.$nama.'`)" class="font14 btn btn-sm ti-trash bg-danger" type="button"> Hapus</button> 
		</div>';


		$row = array();
		$row[] = $no++;	
		$row[] = $kode;
		$row[] = $parent_nama;
		$row[] = $nama;
		$row[] = $deskripsi;
		$row[] = $raktif;
		$row[] = $rinaktif;
		$row[] = $tindak_lanjut;
		$row[] = $sts;
		
		$row[] = $tombol;
		$data[] = $row; 

		}

		$output = array(
			"draw" => $this->m_reff->san($this->input->post("draw")),
			"recordsTotal" => $c=$this->mdl->count_jra(),
			"recordsFiltered" =>$c,
			"data" => $data,
			"token"=>$this->m_reff->getToken()
		);
		//output to json format
		echo json_encode($output);

	} 
	function form_jra(){ 
		$var["data"]=$this->load->view("form_jra",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}
	function update_jra(){
		$f=$this->input->post();
		if(!$f){ return $this->m_reff->page403();}

		$data = $this->mdl->update_jra();
		echo json_encode($data);
	}
	function hapus_jra(){
		$id = $this->m_reff->san($this->input->post("id"));
		if(!$id){ return $this->m_reff->page403();}

		$data = $this->mdl->hapus_jra();
		echo json_encode($data);
	}
	function get_parent_kode_jra(){
	    $action = $this->input->post('action');
		$level = $this->input->post('level');
		
		if($action=='form'){
			$list = '<option value="">=== Pilih ===</option>';
		}else{
			$list = '<option value="">=== Pilih ===</option>';
		}

		if($level==2){
			$this->db->where("level",1);
		}
		if($level==3){
			$this->db->where("level",2);
		}
		$this->db->group_by("kode");
		$this->db->order_by('kode','ASC');
		$db = $this->db->get('ars_tr_jra')->result();
		foreach($db as $val)
		{
			$list .= "<option value='" . $val->kode . "'>" . $val->kode . " - " . $val->nama . "</option>";
		}

		$var["data"]=$list;
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}
	function get_kode_jra(){
	    $action = $this->input->post('action');
		$kode = $this->input->post('kd');
		$level = $this->input->post('level');
		
		$list=$this->generate_kode_jra($kode,$level);
		
		$var["data"]=$list;
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}
	function generate_kode_jra($kode,$level){
		if($level==2){
			$this->db->select("(MAX(SUBSTR(kode,2,1))+1) as kodenumber");
			$this->db->where("level",$level);
			$this->db->where("parent_kode",$kode);
			$t = $this->db->get("ars_tr_jra")->row();
			$idv=isset($t->kodenumber)?($t->kodenumber):''; 
			if(!$idv){  $idv = "0"; }
			$gen=sprintf("%01s", $idv);
			return  $kode.'.'.$gen;
		}
		if($level==3){
			$this->db->select("(MAX(SUBSTR(kode,5,1))+1) as kodenumber");
			$this->db->where("level",$level);
			$this->db->where("parent_kode",$kode);
			$t = $this->db->get("ars_tr_jra")->row();
			$idv=isset($t->kodenumber)?($t->kodenumber):''; 
			if(!$idv){  $idv = "0"; }
			$gen=sprintf("%01s", $idv);
			return  $kode.'.'.$gen;
		}
	}
 


	//master folder-------------------------------------------------------------------------------------
	public function folder()
	{
		$ajax=$this->input->post("ajax");
		$var["title"]		=	"Folder";
		$var["subtitle"]	=	"Master / Folder";
		if($ajax=="yes")
		{
			$var["data"]=$this->load->view("folder",null,true);
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
		}else{
			$var['konten']="folder";
			$this->_template($var);
		}

	} 
	function getData_folder()
	{
		if(!$this->m_reff->san($this->input->post("draw"))){ echo $this->m_reff->page403(); return false;}
		$list = $this->mdl->getData_folder();
		$data = array();
		$no = $this->m_reff->san($this->input->post("start"));
		$no =$no+1;
		foreach ($list as $val) {
		////
		$id=$val->id??null;
		$uuid=$val->uuid??null;
		$box_uuid=$val->box_uuid??'';
		$code=$val->code??'';
		$number=$val->number??'';
		$deskripsi=$val->deskripsi??'';
		$status=$val->status??'';

		$tahun=substr($code,1,4);

		if($box_uuid){
			$getBox=$this->db->get_where("ars_trx_box",array("uuid"=>$box_uuid))->row();
			$box=$getBox->nomor??"";
		}else{
			$box="";
		}
		if($status==1){
			$sts='aktif';
		}else{
			$sts='nonaktif';
		}
		$tombol='<div aria-label="Basic example" class="btn-groupss" role="group">
		<button   onclick="action_form(`'.$uuid.'`,`'.$code.'`)" class="font14 btn btn-sm ti-pencil btn-secondary" type="button"> Edit</button> 
		<button style="color:white" onclick="hapus(`'.$uuid.'`,`'.$code.'`)" class="font14 btn btn-sm ti-trash bg-danger" type="button"> Hapus</button> 
		</div>';


		$row = array();
		$row[] = $no++;	
		$row[] = $box;
		$row[] = $tahun;
		$row[] = $code;
		$row[] = $number;
		$row[] = $deskripsi;
		$row[] = $sts;
		
		$row[] = $tombol;
		$data[] = $row; 

		}

		$output = array(
			"draw" => $this->m_reff->san($this->input->post("draw")),
			"recordsTotal" => $c=$this->mdl->count_folder(),
			"recordsFiltered" =>$c,
			"data" => $data,
			"token"=>$this->m_reff->getToken()
		);
		//output to json format
		echo json_encode($output);

	} 
	function form_folder(){ 
		$var["data"]=$this->load->view("form_folder",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}
	function update_folder(){
		$f=$this->input->post();
		if(!$f){ return $this->m_reff->page403();}

		$data = $this->mdl->update_folder();
		echo json_encode($data);
	}
	function hapus_folder(){
		$id = $this->m_reff->san($this->input->post("id"));
		if(!$id){ return $this->m_reff->page403();}

		$data = $this->mdl->hapus_folder();
		echo json_encode($data);
	}

	//master box-------------------------------------------------------------------------------------
	public function box()
	{
		$ajax=$this->input->post("ajax");
		$var["title"]		=	"Box";
		$var["subtitle"]	=	"Master / Box";
		if($ajax=="yes")
		{
			$var["data"]=$this->load->view("box",null,true);
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
		}else{
			$var['konten']="box";
			$this->_template($var);
		}

	} 
	function getData_box()
	{
		if(!$this->m_reff->san($this->input->post("draw"))){ echo $this->m_reff->page403(); return false;}
		$list = $this->mdl->getData_box();
		$data = array();
		$no = $this->m_reff->san($this->input->post("start"));
		$no =$no+1;
		foreach ($list as $val) {
		////
		$id=$val->id??null;
		$uuid=$val->uuid??null;
		$code=$val->code??'';
		$nomor=$val->nomor??'';
		$deskripsi=$val->deskripsi??'';
		$status=$val->status??'';

		$tahun=substr($code,1,4);

		// if($uk_uuid){
		// 	$getUk=$this->db->get_where("ars_tr_uk",array("uuid"=>$uk_uuid))->row();
		// 	$unit_kearsipan=$getUk->description??"";
		// }else{
		// 	$unit_kearsipan="";
		// }
		if($status==1){
			$sts='aktif';
		}else{
			$sts='nonaktif';
		}

		$tombol='<div aria-label="Basic example" class="btn-groupss" role="group">
		<button   onclick="action_form(`'.$uuid.'`,`'.$code.'`)" class="font14 btn btn-sm ti-pencil btn-secondary" type="button"> Edit</button> 
		<button style="color:white" onclick="hapus(`'.$uuid.'`,`'.$code.'`)" class="font14 btn btn-sm ti-trash bg-danger" type="button"> Hapus</button> 
		</div>';


		$row = array();
		$row[] = $no++;	
		$row[] = $tahun;
		$row[] = $code;
		$row[] = $nomor;
		$row[] = $deskripsi;
		$row[] = $sts;
		
		$row[] = $tombol;
		$data[] = $row; 

		}

		$output = array(
			"draw" => $this->m_reff->san($this->input->post("draw")),
			"recordsTotal" => $c=$this->mdl->count_box(),
			"recordsFiltered" =>$c,
			"data" => $data,
			"token"=>$this->m_reff->getToken()
		);
		//output to json format
		echo json_encode($output);

	} 
	function form_box(){ 
		$var["data"]=$this->load->view("form_box",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}
	function update_box(){
		$f=$this->input->post();
		if(!$f){ return $this->m_reff->page403();}

		$data = $this->mdl->update_box();
		echo json_encode($data);
	}
	function hapus_box(){
		$id = $this->m_reff->san($this->input->post("id"));
		if(!$id){ return $this->m_reff->page403();}

		$data = $this->mdl->hapus_box();
		echo json_encode($data);
	}


	

}