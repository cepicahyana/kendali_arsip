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
			$type="Unit Kearsipan I";
		}
		if($type==2){
			$type="Unit Kearsipan II";
		}
		if($type==3){
			$type="Unit Kearsipan III";
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

		$tombol='<div aria-label="Basic example" class="btn-groupss" role="group">
		<button   onclick="action_form(`'.$uuid.'`,`'.$type.'`)" class="font14 btn btn-sm ti-pencil btn-secondary" type="button"> Edit</button> 
		<button style="color:white" onclick="hapus(`'.$uuid.'`,`'.$type.'`)" class="font14 btn btn-sm ti-trash bg-danger" type="button"> Hapus</button> 
		</div>';


		$row = array();
		$row[] = $no++;	
		$row[] = $type;
		$row[] = $parent;
		$row[] = $description;
		$row[] = $nama_organisasi;
		$row[] = $jml_peg;
		$row[] = $status;
		
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
		$var["data"]=$this->load->view("form_unit_kearsipan",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
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
	function get_parent_unit_kearsipan(){
	    $action = $this->input->post('action');
		$kode = $this->input->post('kd');
		$jmlkode=strlen($kode);
		if($action=='form'){
			$list = '<option value="">=== Pilih ===</option>';
		}else{
			$list = '<option value="">=== Pilih ===</option>';
		}

        $db = $this->db->order_by('description','ASC');
		$db = $this->db->get_where('ars_tr_uk',array('type'=>$kode))->result();
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
			$list .= "<option value='" . $val->uuid . "' dt='" . $val->description . "'>" . $type ." (".$nama_organisasi.")</option>";
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
		$uk_uuid=$val->uk_uuid??'';
		$organisasi_kode=$val->organisasi_kode??'';
		$description=$val->description??'';
		$status=$val->status??'';

		if($uk_uuid){
			$getUk=$this->db->get_where("ars_tr_uk",array("uuid"=>$uk_uuid))->row();
			$unit_kearsipan=$getUk->description??"";
		}else{
			$unit_kearsipan="";
		}

		if($organisasi_kode){
			$getOrg=$this->db->get_where("ars_tr_organisasi",array("kode"=>$organisasi_kode))->row();
			$nama_organisasi=$getOrg->nama??"";
		}else{
			$nama_organisasi="";
		}

		

		$tombol='<div aria-label="Basic example" class="btn-groupss" role="group">
		<button   onclick="action_form(`'.$id.'`,`'.$description.'`)" class="font14 btn btn-sm ti-pencil btn-secondary" type="button"> Edit</button> 
		<button style="color:white" onclick="hapus(`'.$id.'`,`'.$description.'`)" class="font14 btn btn-sm ti-trash bg-danger" type="button"> Hapus</button> 
		</div>';


		$row = array();
		$row[] = $no++;	
		$row[] = $unit_kearsipan;
		$row[] = $nama_organisasi;
		$row[] = $description;
		$row[] = $status;
		
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
		$var["data"]=$this->load->view("form_unit_pengelola",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
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
		$id=$val->id??null;
		$uuid=$val->uuid??null;
		$kode=$val->kode??'';
		$parent_kode=$val->parent_kode??'';
		$nama=$val->nama??'';
		$deskripsi=$val->deskripsi??'';
		$status=$val->status??'';
		$level=$val->level??'';


		$tombol='<div aria-label="Basic example" class="btn-groupss" role="group">
		<button   onclick="action_form(`'.$uuid.'`,`'.$nama.'`)" class="font14 btn btn-sm ti-pencil btn-secondary" type="button"> Edit</button> 
		<button style="color:white" onclick="hapus(`'.$uuid.'`,`'.$nama.'`)" class="font14 btn btn-sm ti-trash bg-danger" type="button"> Hapus</button> 
		</div>';


		$row = array();
		$row[] = $no++;	
		$row[] = $kode;
		$row[] = $parent_kode;
		$row[] = $nama;
		$row[] = $deskripsi;
		$row[] = $status;
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
	function get_kode_klasifikasi_arsip(){
	    $action = $this->input->post('action');
		$kode = $this->input->post('kd');
		$level = $this->input->post('level');
		$jmlkode=strlen($kode);
		
		$list=$this->generate_kode_klasifikasi_arsip($kode,$level);
		
		$var["data"]=$list;
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}
	function generate_kode_klasifikasi_arsip($kode,$level){
		if($level==2){
			$this->db->select("(MAX(SUBSTR(kode,4,2))+1) as kodenumber");
			$this->db->where("level",$level);
			$t = $this->db->get("ars_tr_kka")->row();
			$idv=isset($t->kodenumber)?($t->kodenumber):''; 
			if(!$idv){  return "00"; }
			$gen=sprintf("%02s", $idv);
			return  $kode.'.'.$gen;
		}
		if($level==3){
			$this->db->select("(MAX(SUBSTR(kode,7,2))+1) as kodenumber");
			$this->db->where("level",$level);
			$t = $this->db->get("ars_tr_kka")->row();
			$idv=isset($t->kodenumber)?($t->kodenumber):''; 
			if(!$idv){  return "00"; }
			$gen=sprintf("%02s", $idv);
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
		$row[] = $status;
		
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
		$row[] = $status;
		
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
		$id=$val->id??null;
		$uuid=$val->uuid??null;
		$nama=$val->nama??'';
		$deskripsi=$val->deskripsi??'';
		$retensi_aktif=$val->retensi_aktif??null;
		$retensi_aktif_deskripsi=$val->retensi_aktif_deskripsi??null;
		$retensi_inaktif=$val->retensi_inaktif??null;
		$retensi_inaktif_deskripsi=$val->retensi_inaktif_deskripsi??null;
		$tindak_lanjut_uuid=$val->tindak_lanjut_uuid??null;
		$status=$val->status??'';

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

	
		$tombol='<div aria-label="Basic example" class="btn-groupss" role="group">
		<button   onclick="action_form(`'.$uuid.'`,`'.$nama.'`)" class="font14 btn btn-sm ti-pencil btn-secondary" type="button"> Edit</button> 
		<button style="color:white" onclick="hapus(`'.$uuid.'`,`'.$nama.'`)" class="font14 btn btn-sm ti-trash bg-danger" type="button"> Hapus</button> 
		</div>';


		$row = array();
		$row[] = $no++;	
		$row[] = $nama;
		$row[] = $deskripsi;
		$row[] = $raktif;
		$row[] = $rinaktif;
		$row[] = $tindak_lanjut;
		$row[] = $status;
		
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
 

}