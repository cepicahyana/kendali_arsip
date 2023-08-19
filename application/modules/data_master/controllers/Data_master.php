<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data_master extends CI_Controller {


	var $tbl="admin";
	function __construct()
	{
		parent::__construct();	
		$this->m_konfig->validasi_session(array("admin_covid","super_admin","admin_data"));
		$this->load->model("model","mdl");
		$this->load->model("model_deputi","deputi");
		$this->load->model("model_test","test");
		$this->load->model("model_dr","dr");
		$this->load->model("model_kdr","kdr");
		$this->load->model("model_rs","rs");
		$this->load->model("model_pic","pic");
		$this->load->model("model_pimpinan","pimpinan");
		$this->load->model("model_pimpinan_pusat","pusat");
		$this->load->model("model_admin","admin");
		$this->load->model("model_pegawai","pegawai");
		date_default_timezone_set('Asia/Jakarta');
	}

	function _template($data)
	{
		$this->load->view('temp_main/main',$data);	
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

	


	public function biro()
	{

		$ajax=$this->input->post("ajax");
		if($ajax=="yes")
		{
			$var["data"]=$this->load->view("biro",null,true);
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
		}else{
			$data['konten']="biro";
			$this->_template($data);
		}
		
	}  

	


	///-----------------------BIRO--------------------------///
	function getData_biro()
	{
		if(!$this->m_reff->san($this->input->post("draw"))){ echo $this->m_reff->page403(); return false;}
		$list = $this->mdl->get_data_biro();
		$data = array();
		$no = $this->m_reff->san($this->input->post("start"));
		$no =$no+1;
		foreach ($list as $dataDB) {
		////


			$tombol='<div aria-label="Basic example" class="btn-groupss" role="group">
			<button onclick="edit(`'.$dataDB->id.'`,`'.$dataDB->biro.'`)" class="btn btn-sm btn-secondary pd-x-25 active" type="button">Edit</button> 
			<button onclick="hapus(`'.$dataDB->id.'`,`'.$dataDB->biro.'`)" class=" btn btn-sm btn-danger pd-x-25" type="button">Hapus</button> 
			</div>';


			$row = array();
			$row[] =  $no++;	
			$row[] =  $dataDB->kode;
			$row[] = $dataDB->biro;
			$row[] = $this->m_reff->goField("data_deputi","deputi","where kode='".$dataDB->kode_deputi."'");
			// $row[] = "<center><span class='badge badge-success'>negatif </span></center>";
			// $row[] = " -";
			$row[] = $tombol;



			$data[] = $row; 
			
		}

		$output = array(
			"draw" => $this->m_reff->san($this->input->post("draw")),
			"recordsTotal" => $c=$this->mdl->count_biro(),
			"recordsFiltered" =>$c,
			"data" => $data,
			"token"=>$this->m_reff->getToken()
		);
		//output to json format
		echo json_encode($output);

	}
	

	//----------------------------------------------- -----------------------//

	///-----------------------Deputi--------------------------///
	function getData_deputi()
	{
		if(!$this->m_reff->san($this->input->post("draw"))){ echo $this->m_reff->page403(); return false;}
		$list = $this->deputi->get_data();
		$data = array();
		$no = $this->m_reff->san($this->input->post("start"));
		$no =$no+1;
		foreach ($list as $dataDB) {
		////


			$tombol='<div aria-label="Basic example" class="btn-groupss" role="group">
			<button onclick="edit(`'.$dataDB->id.'`,`'.$dataDB->deputi.'`)" class="btn btn-sm btn-secondary pd-x-25 active" type="button">Edit</button> 
			<button onclick="hapus(`'.$dataDB->id.'`,`'.$dataDB->deputi.'`)" class=" btn btn-sm btn-danger pd-x-25" type="button">Hapus</button> 
			</div>';


			$row = array();
			$row[] =  $no++;	
			$row[] =  $dataDB->kode;
			$row[] =  $dataDB->deputi;
		 
			$row[] = $tombol;



			$data[] = $row; 
			
		}

		$output = array(
			"draw" => $this->m_reff->san($this->input->post("draw")),
			"recordsTotal" => $c=$this->deputi->count(),
			"recordsFiltered" =>$c,
			"data" => $data,
			"token"=>$this->m_reff->getToken()
		);
		//output to json format
		echo json_encode($output);

	}
	
	function viewEdit_deputi(){
		$id = $this->m_reff->san($this->input->post("id"));
		if(!$id){
			return $this->m_reff->page403();
		}
		
		$var["data"]=$this->load->view("viewEdit_deputi",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}

	function viewAdd_deputi(){
		$f = $this->input->post();
		if(!$f){
			return $this->m_reff->page403();
		}

		$var["data"]=$this->load->view("viewAdd_deputi",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}

	function update_deputi(){
		$f = $this->input->post("f");
		if(!$f){
			return $this->m_reff->page403();
		}

		$data = $this->deputi->update();
		echo json_encode($data);
	}

	function insert_deputi(){
		$f = $this->input->post("f");
		if(!$f){
			return $this->m_reff->page403();
		}

		$data = $this->deputi->insert();
		echo json_encode($data);
	}

	function hapus_deputi(){
		$id = $this->m_reff->san($this->input->post("id"));
		if(!$id){
			return $this->m_reff->page403();
		}

		$data = $this->deputi->hapus();
		echo json_encode($data);
	}


	//----------------------------------------------- -----------------------//
	function idu()
	{
		return $this->session->userdata("id");
	}

	function viewEdit_biro(){
		$id = $this->m_reff->san($this->input->post("id"));
		if(!$id){
			return $this->m_reff->page403();
		}

		$var["data"]=$this->load->view("viewEdit_biro",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}

	function viewAdd_biro(){
		$f = $this->input->post();
		if(!$f){
			return $this->m_reff->page403();
		}

		$var["data"]=$this->load->view("viewAdd_biro",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}

	function update_biro(){
		$f = $this->input->post("f");
		if(!$f){
			return $this->m_reff->page403();
		}
		
		$data = $this->mdl->update_biro();
		echo json_encode($data);
	}

	function insert_biro(){
		$f = $this->input->post("f");
		if(!$f){
			return $this->m_reff->page403();
		}

		$data = $this->mdl->insert_biro();
		echo json_encode($data);
	}

	function hapus_biro(){
		$id = $this->m_reff->san($this->input->post("id"));
		if(!$id){
			return $this->m_reff->page403();
		}

		$data = $this->mdl->hapus_biro();
		echo json_encode($data);
	}

     ///======== JENIS TES
	public function jenis_test()
	{

		$ajax=$this->input->post("ajax");
		if($ajax=="yes")
		{
			$var["data"]=$this->load->view("jenis_test",null,true);
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
		}else{
			$data['konten']="jenis_test";
			$this->_template($data);
		}

	}  
	function getData_test()
	{
		$list = $this->test->get_data();
		$data = array();
		$no = $this->m_reff->san($this->input->post("start"));
		if(!$this->m_reff->san($this->input->post("draw"))){ echo $this->m_reff->page403(); return false;}
		$no =$no+1;
		foreach ($list as $dataDB) {
         ////


			$tombol='<div aria-label="Basic example" class="btn-groupss" role="group">
			<button onclick="edit(`'.$dataDB->id.'`,`'.$dataDB->nama.'`)" class="btn btn-sm btn-secondary pd-x-25 active" type="button">Edit</button> 
			<button onclick="hapus(`'.$dataDB->id.'`,`'.$dataDB->nama.'`)" class="btn btn-sm btn-danger pd-x-25" type="button">Hapus</button> 
			</div>';


			$row = array();
			$row[] =  $no++;	
			$row[] =  $dataDB->kode;
			$row[] = $dataDB->nama;
			$row[] = $tombol;



			$data[] = $row; 

		}

		$output = array(
			"draw" => $this->m_reff->san($this->input->post("draw")),
			"recordsTotal" => $c=$this->test->count(),
			"recordsFiltered" =>$c,
			"data" => $data,
			"token"=>$this->m_reff->getToken()
		);
         //output to json format
		echo json_encode($output);

	}

	function viewEdit_test(){
		$id = $this->m_reff->san($this->input->post("id"));
		if(!$id){ return $this->m_reff->page403();}

		$var["data"]=$this->load->view("viewEdit_test",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var); 
	}

	function viewAdd_test(){
		$f = $this->input->post();
		if(!$f){ return $this->m_reff->page403();}

		$var["data"]=$this->load->view("viewAdd_test",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}

	function update_test(){
		$f = $this->input->post("f");
		if(!$f){ return $this->m_reff->page403();}

		$data = $this->test->update();
		echo json_encode($data);
	}

	function insert_test(){
		$f = $this->input->post("f");
		if(!$f){ return $this->m_reff->page403();}

		$data = $this->test->insert();
		echo json_encode($data);
	}

	function hapus_test(){
		$id = $this->m_reff->san($this->input->post("id"));
		if(!$id){ return $this->m_reff->page403();}

		$data = $this->test->hapus();
		echo json_encode($data);
	}
    //======= END TEST=================//

     ///======== DATA RS
	public function rs()
	{

		$ajax=$this->input->post("ajax");
		if($ajax=="yes")
		{
			$var["data"]=$this->load->view("rs",null,true);
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
		}else{
			$data['konten']="rs";
			$this->_template($data);
		}

	}  

	function getData_rs()
	{
		if(!$this->m_reff->san($this->input->post("draw"))){ echo $this->m_reff->page403(); return false;}
		$list = $this->rs->get_data();
		$data = array();
		$no = $this->m_reff->san($this->input->post("start"));
		$no =$no+1;
		foreach ($list as $dataDB) {
         ////


			$tombol='<div aria-label="Basic example" class="btn-groupss" role="group">
			<button onclick="edit(`'.$dataDB->id.'`,`'.$dataDB->nama.'`)" class="btn btn-sm btn-secondary pd-x-25 active" type="button">Edit</button> 
			<button onclick="hapus(`'.$dataDB->id.'`,`'.$dataDB->nama.'`)" class="btn btn-sm btn-danger pd-x-25" type="button">Hapus</button> 
			</div>';

		 
			$row = array();
			$row[] =  $no++;	
			$row[] =  $dataDB->kode;
			$row[] = $dataDB->nama;
			$row[] = $dataDB->alamat;
			$row[] = $dataDB->email;
			$row[] = $dataDB->telp;
			$row[] = $this->m_reff->istana($dataDB->kode_istana);
		 
			$row[] = $tombol;



			$data[] = $row; 

		}

		$output = array(
			"draw" => $this->m_reff->san($this->input->post("draw")),
			"recordsTotal" => $c=$this->rs->count(),
			"recordsFiltered" =>$c,
			"data" => $data,
			"token"=>$this->m_reff->getToken()
		);
         //output to json format
		echo json_encode($output);

	}

	function viewEdit_rs(){
		$id = $this->m_reff->san($this->input->post("id"));
		if(!$id){ return $this->m_reff->page403();}

		$var["data"]=$this->load->view("viewEdit_rs",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var); 
	}

	function viewAdd_rs(){
		$f = $this->input->post();
		if(!$f){ return $this->m_reff->page403();}

		$var["data"]=$this->load->view("viewAdd_rs","",true);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}

	function update_rs(){
		$f = $this->input->post("f");
		if(!$f){ return $this->m_reff->page403();}

		$data = $this->rs->update();
		echo json_encode($data);
	}

	function insert_rs(){
		$f = $this->input->post("f");
		if(!$f){ return $this->m_reff->page403();}

		$data = $this->rs->insert();
		echo json_encode($data);
	}

	function hapus_rs(){
		$id = $this->m_reff->san($this->input->post("id"));
		if(!$id){ return $this->m_reff->page403();}

		$data = $this->rs->hapus();
		echo json_encode($data);
	}
    //======= END TEST=================//


     ///======== DATA DOKTER
	public function dr()
	{
		$ajax=$this->input->post("ajax");
		if($ajax=="yes")
		{
			$var["data"]=$this->load->view("dr",null,true);
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
		}else{
			$data['konten']="dr";
			$this->_template($data);
		}

	}  

	function getData_dr()
	{
		if(!$this->m_reff->san($this->input->post("draw"))){ echo $this->m_reff->page403(); return false;}
		$list = $this->dr->get_data();
		$data = array();
		$no = $this->m_reff->san($this->input->post("start"));
		$no =$no+1;
		foreach ($list as $dataDB) {
         ////


			$tombol='<div aria-label="Basic example" class="btn-groupss" role="group">
			<button onclick="edit(`'.$dataDB->id.'`,`'.$dataDB->nama.'`)" class="btn btn-sm btn-secondary pd-x-25 active" type="button">Edit</button> 
			<button onclick="hapus(`'.$dataDB->id.'`,`'.$dataDB->nama.'`)" class="btn btn-sm btn-danger pd-x-25" type="button">Hapus</button> 
			</div>';

		 
			$row = array();
			$row[] =  $no++;	
			$row[] =  $dataDB->nip;
			$row[] = $dataDB->nama;
			$row[] = $dataDB->jk;
  			$row[] = $dataDB->telp;
  			$row[] = $dataDB->email;
		  	$row[] = $tombol;

 			$data[] = $row; 

		}

		$output = array(
			"draw" => $this->m_reff->san($this->input->post("draw")),
			"recordsTotal" => $c=$this->dr->count(),
			"recordsFiltered" =>$c,
			"data" => $data,
			"token"=>$this->m_reff->getToken()
		);
         //output to json format
		echo json_encode($output);

	}

	function viewEdit_dr(){
		$id = $this->m_reff->san($this->input->post("id"));
		if(!$id){ return $this->m_reff->page403();}

		$var["data"]=$this->load->view("viewEdit_dr",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var); 
	}

	function viewAdd_dr(){
		$f = $this->input->post();
		if(!$f){ return $this->m_reff->page403();}

		$var["data"]=$this->load->view("viewAdd_dr","",true);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}

	function update_dr(){
		$f = $this->input->post("f");
		if(!$f){ return $this->m_reff->page403();}

		$data = $this->dr->update();
		echo json_encode($data);
	}

	function insert_dr(){
		$f = $this->input->post("f");
		if(!$f){ return $this->m_reff->page403();}

		$data = $this->dr->insert();
		echo json_encode($data);
	}

	function hapus_dr(){
		$id = $this->m_reff->san($this->input->post("id"));
		if(!$id){ return $this->m_reff->page403();}

		$data = $this->dr->hapus();
		echo json_encode($data);
	}
    //======= END TEST=================//


     ///======== DATA KOORDINATOR DOKTER
	 public function kdr()
	 {
 
		 $ajax=$this->input->post("ajax");
		 if($ajax=="yes")
		 {
			 $var["data"]=$this->load->view("kdr",null,true);
			 $var["token"]=$this->m_reff->getToken();
			 echo json_encode($var);
		 }else{
			 $data['konten']="kdr";
			 $this->_template($data);
		 }
 
	 }  
	 function getData_kdr()
	 {
		 if(!$this->m_reff->san($this->input->post("draw"))){ echo $this->m_reff->page403(); return false;}
		 $list = $this->kdr->get_data();
		 $data = array();
		 $no = $this->m_reff->san($this->input->post("start"));
		 $no =$no+1;
		 foreach ($list as $dataDB) {
		  ////
 
 
			 $tombol='<div aria-label="Basic example" class="btn-groupss" role="group">
			 <button onclick="edit(`'.$dataDB->id.'`,`'.$dataDB->nama.'`)" class="btn btn-sm btn-secondary pd-x-25 active" type="button">Edit</button> 
			 <button onclick="hapus(`'.$dataDB->id.'`,`'.$dataDB->nama.'`)" class="btn btn-sm btn-danger pd-x-25" type="button">Hapus</button> 
			 </div>';
 
		  
			 $row = array();
			 $row[] =  $no++;	
			 $row[] =  $dataDB->nip;
			 $row[] = $dataDB->nama;
			 $row[] = $dataDB->jk;
			   $row[] = $dataDB->telp;
			   $row[] = $dataDB->email;
			   $row[] = $tombol;
 
			  $data[] = $row; 
 
		 }
 
		 $output = array(
			 "draw" => $this->m_reff->san($this->input->post("draw")),
			 "recordsTotal" => $c=$this->kdr->count(),
			 "recordsFiltered" =>$c,
			 "data" => $data,
			 "token"=>$this->m_reff->getToken()
		 );
		  //output to json format
		 echo json_encode($output);
 
	 }
 
	function viewEdit_kdr(){
		$id = $this->m_reff->san($this->input->post("id"));
		if(!$id){ return $this->m_reff->page403();}

		$var["data"]=$this->load->view("viewEdit_kdr",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var); 
	}

	function viewAdd_kdr(){
		$f = $this->input->post();
		if(!$f){ return $this->m_reff->page403();}

		$var["data"]=$this->load->view("viewAdd_kdr","",true);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}

	function update_kdr(){
		$f = $this->input->post("f");
		if(!$f){ return $this->m_reff->page403();}

		$data = $this->kdr->update();
		echo json_encode($data);
	}

	function insert_kdr(){
		$f = $this->input->post("f");
		if(!$f){ return $this->m_reff->page403();}

		$data = $this->kdr->insert();
		echo json_encode($data);
	}

	function hapus_kdr(){
		$id = $this->m_reff->san($this->input->post("id"));
		if(!$id){ return $this->m_reff->page403();}

		$data = $this->kdr->hapus();
		echo json_encode($data);
	}
	 //======= END TEST=================//
 
     ///======== DATA PIC
	public function pic()
	{
		$ajax=$this->input->post("ajax");
		if($ajax=="yes")
		{
			$var["data"]=$this->load->view("pic",null,true);
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
		}else{
			$data['konten']="pic";
			$this->_template($data);
		}
	}  

	function getData_pic()
	{
		if(!$this->m_reff->san($this->input->post("draw"))){ echo $this->m_reff->page403(); return false;}
		$list = $this->pic->get_data();
		$data = array();
		$no = $this->m_reff->san($this->input->post("start"));
		$no =$no+1;
		foreach ($list as $dataDB) {
         ////

		 $dataBiro = $this->m_reff->biro($dataDB->kode_biro);

		 $tombol='<div aria-label="Basic example" class="btn-groupss" role="group">
		 <button style="display:none;" onclick="edit(`'.$dataDB->id_admin.'`,`'.$dataDB->owner.'`)" class="font14 btn btn-sm ti-pencil btn-secondary" type="button"> Edit</button> 
		 <button style="color:white" onclick="hapus(`'.$dataDB->id_admin.'`,`'.$dataDB->owner.'`)" class="font14 btn btn-sm ti-trash bg-danger" type="button"> Hapus</button> 
		 </div>';

		 $relasi = $this->db->get_where("data_pegawai",array("nip"=>$dataDB->nip))->row();
		 

		 $row = array();
		 $row[] = $no++;	
		 $row[] = isset($relasi->nama)?($relasi->nama):null;
		 $row[] = isset($relasi->nip)?($relasi->nip):null;
		 $row[] = $this->m_reff->istana($dataDB->kode_istana);
		//  $row[] = $this->m_reff->jk(isset($relasi->jk)?($relasi->jk):null);
		 $row[] = $dataBiro;
		 $row[] = isset($relasi->no_hp)?($relasi->no_hp):null;
		 $row[] = isset($relasi->email)?($relasi->email):null;
			 
			 
			 
			$row[] = $tombol;



			$data[] = $row; 

		}

		$output = array(
			"draw" => $this->m_reff->san($this->input->post("draw")),
			"recordsTotal" => $c=$this->pic->count(),
			"recordsFiltered" =>$c,
			"data" => $data,
			"token"=>$this->m_reff->getToken()
		);
         //output to json format
		echo json_encode($output);

	}

	function viewEdit_pic(){
		$id = $this->m_reff->san($this->input->post("id"));
		if(!$id){ return $this->m_reff->page403();}

		$var["data"]=$this->load->view("viewEdit_pic",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}

	function viewAdd_pic(){
		$f = $this->input->post();
		if(!$f){ return $this->m_reff->page403();}

		$var["data"]=$this->load->view("viewAdd_pic","",true);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}

	function update_pic(){
		$f = $this->input->post('f');
		if(!$f){ return $this->m_reff->page403();}

		$data = $this->pic->update();
		echo json_encode($data);
	}

	function insert_pic(){
		$f = $this->input->post('f');
		if(!$f){ return $this->m_reff->page403();}

		$data = $this->pic->insert();
		echo json_encode($data);
	}

	function hapus_pic(){
		$id = $this->m_reff->san($this->input->post('id'));
		if(!$id){ return $this->m_reff->page403();}

		$data = $this->pic->hapus();
		echo json_encode($data);
	}
    //========== END PIC===============








     ///======== DATA PIMPINAN
	 public function pimpinan()
	 {
 
		 $ajax=$this->input->post("ajax");
		 if($ajax=="yes")
		 {
			 $var["data"]=$this->load->view("pimpinan",null,true);
			 $var["token"]=$this->m_reff->getToken();
			 echo json_encode($var);
		 }else{
			 $data['konten']="pimpinan";
			 $this->_template($data);
		 }
 
	 }  
 
	 function getData_pimpinan()
	 {
		 if(!$this->m_reff->san($this->input->post("draw"))){ echo $this->m_reff->page403(); return false;}
		 $list = $this->pimpinan->get_data();
		 $data = array();
		 $no = $this->m_reff->san($this->input->post("start"));
		 $no =$no+1;
		 foreach ($list as $dataDB) {
		  ////
 
		  $dataBiro = $this->m_reff->biro($dataDB->kode_biro);
 
			
		  $tombol='<div aria-label="Basic example" class="btn-groupss" role="group">
		  <button style="display:none;" onclick="edit(`'.$dataDB->id_admin.'`,`'.$dataDB->owner.'`)" class="font14 btn btn-sm ti-pencil btn-secondary" type="button"> Edit</button> 
		  <button style="color:white" onclick="hapus(`'.$dataDB->id_admin.'`,`'.$dataDB->owner.'`)" class="font14 btn btn-sm ti-trash bg-danger" type="button"> Hapus</button> 
		  </div>';
 
		  $relasi = $this->db->get_where("data_pegawai",array("nip"=>$dataDB->nip))->row();
		  
 
		  $row = array();
		  $row[] = $no++;	
		  $row[] = isset($relasi->nama)?($relasi->nama):null;
		  $row[] = isset($relasi->nip)?($relasi->nip):null;
		  $row[] = $this->m_reff->istana($dataDB->kode_istana);
		 //  $row[] = $this->m_reff->jk(isset($relasi->jk)?($relasi->jk):null);
		  $row[] = $dataBiro;
		  $row[] = isset($relasi->no_hp)?($relasi->no_hp):null;
		  $row[] = isset($relasi->email)?($relasi->email):null;
			  
			  
			 $row[] = $tombol;
 
 
 
			 $data[] = $row; 
 
		 }
 
		 $output = array(
			 "draw" => $this->m_reff->san($this->input->post("draw")),
			 "recordsTotal" => $c=$this->pimpinan->count(),
			 "recordsFiltered" =>$c,
			 "data" => $data,
			 "token"=>$this->m_reff->getToken()
		 );
		  //output to json format
		 echo json_encode($output);
 
	 }

	function viewEdit_pimpinan(){
		$id = $this->m_reff->san($this->input->post('id'));
		if(!$id){ return $this->m_reff->page403();}

		$var["data"]=$this->load->view("viewEdit_pimpinan",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}
 
	function viewAdd_pimpinan(){
		$f = $this->input->post();
		if(!$f){ return $this->m_reff->page403();}

		$var["data"]=$this->load->view("viewAdd_pimpinan","",true);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}
 
	function update_pimpinan(){
		$f = $this->input->post('f');
		if(!$f){ return $this->m_reff->page403();}

		$data = $this->pimpinan->update();
		echo json_encode($data);
	}

	function insert_pimpinan(){
		$f = $this->input->post('f');
		if(!$f){ return $this->m_reff->page403();}

		$data = $this->pimpinan->insert();
		echo json_encode($data);
	}
	 
	function hapus_pimpinan(){
		$id = $this->m_reff->san($this->input->post('id'));
		if(!$id){ return $this->m_reff->page403();}

		$data = $this->pimpinan->hapus();
	 	echo json_encode($data);
	}
	 //========== END Pimpinan===============
 
 
 
 





     ///======== DATA PEGAWAI
	public function pegawai()
	{

		$ajax=$this->input->post("ajax");
		if($ajax=="yes")
		{
			$var["data"]=$this->load->view("pegawai","null",true);
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
		}else{
			$data['konten']="pegawai";
			$this->_template($data);
		}

	}  

	function getData_pegawai()
	{
		if(!$this->m_reff->san($this->input->post("draw"))){ echo $this->m_reff->page403(); return false;}
		$list = $this->pegawai->get_data();
		$data = array();
		$no = $this->m_reff->san($this->input->post("start"));
		$no =$no+1;
		foreach ($list as $dataDB) {
         ////


			$tombol='<div aria-label="Basic example" class="btn-groupss" role="group">
			<button onclick="hapus(`'.$dataDB->id.'`,`'.$dataDB->nama.'`)" class="btn btn-sm btn-danger pd-x-25" type="button">Hapus</button> 
			</div>';


			$row = array();
			$row[] =  $no++;	
			$row[] =  $dataDB->nip;
			$row[] = $dataDB->nama;
			$row[] = $dataDB->biro;
			$row[] = $dataDB->no_hp;
			$row[] = $tombol;



			$data[] = $row; 

		}

		$output = array(
			"draw" => $this->m_reff->san($this->input->post("draw")),
			"recordsTotal" => $c=$this->pegawai->count(),
			"recordsFiltered" =>$c,
			"data" => $data,
			"token"=>$this->m_reff->getToken(),
		);
         //output to json format
		echo json_encode($output);

	}

	// function viewEdit_pegawai(){
	// 	$this->load->view("viewEdit_pegawai");
	// }

	// function viewAdd_pegawai(){
	// 	$this->load->view("viewAdd_pegawai");
	// }

	function update_pegawai(){
		$f=$this->input->post("f");
		if(!$f){ return $this->m_reff->page403();}

		$data = $this->pegawai->update();
		echo json_encode($data);
	}

	function insert_pegawai(){
		$cekNotif = $this->m_reff->san($this->input->post("notif"));
		if(!$cekNotif){ return $this->m_reff->page403();}

		$data = $this->pegawai->insert();
		echo json_encode($data);
	}

	function hapus_pegawai(){
		$id = $this->m_reff->san($this->input->post("id"));
		if(!$id){ return $this->m_reff->page403();}

		$data = $this->pegawai->hapus();
		echo json_encode($data);
	}
    //========== END pegawai===============





	function getDataPegawai(){
		$val = $this->m_reff->san($this->input->post("val"));
		if(!$val){ return $this->m_reff->page403();}
		
		$data = $this->mdl->getDataPegawai();
		if(!$data){
			echo "<br><div style='width:100%' class='alert alert-danger mg-b-0' role='alert'> <button aria-label='Close' class='close' data-dismiss='alert' type='button'> <span aria-hidden='true'>×</span> </button> 
			Data tidak ditemukan!</div>";
		}else{
			echo '
			<input type="hidden" name="id" value="'.$data->id.'">
			<input type="hidden" name="email" value="'.$data->email.'">
			<input type="hidden" name="hp" value="'.$data->no_hp.'">
			';
			echo '<br><table class="entry" width="100%">
			<tr>
			<td>Nama </td> <td>'.$data->nama.'</td>
			</tr>

			<tr>
			<td>Biro </td> <td>'.$data->biro.'</td>
			</tr>
			<tr>
			<td>Bagian </td> <td>'.$data->bagian.'</td>
			</tr>
			<tr>
			<td>Jabatan </td> <td>'.$data->jabatan.'</td>
			</tr>
			<tr>
			<td>No Hp </td> <td>'.$data->no_hp.'</td>
			</tr>
			<tr>
			<td>Email </td> <td>'.$data->email.'</td>
			</tr>
			</table>';


		}
	}


	///======== DATA PIMPINAN PUSAT
	public function pimpinan_pusat()
	{

		$ajax=$this->input->post("ajax");
		if($ajax=="yes")
		{
			$var["data"]=$this->load->view("pimpinan_pusat",null,true);
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
		}else{
			$data['konten']="pimpinan_pusat";
			$this->_template($data);
		}

	}  

	function getData()
	{
		if(!$this->m_reff->san($this->input->post("draw"))){ echo $this->m_reff->page403(); return false;}
		$list = $this->pusat->get_data();
		$data = array();
		$no = $this->m_reff->san($this->input->post("start"));
		$no =$no+1;
		foreach ($list as $dataDB) {
         ////

		 $tombol='<div aria-label="Basic example" class="btn-groupss" role="group">
		 <button style="display:none;" onclick="edit(`'.$dataDB->id_admin.'`,`'.$dataDB->owner.'`)" class="font14 btn btn-sm ti-pencil btn-secondary" type="button"> Edit</button> 
		 <button style="color:white" onclick="hapus(`'.$dataDB->id_admin.'`,`'.$dataDB->owner.'`)" class="font14 btn btn-sm ti-trash bg-danger" type="button"> Hapus</button> 
		 </div>';

		 $relasi = $this->db->get_where("data_pegawai",array("nip"=>$dataDB->nip))->row();
		 

		 $row = array();
		 $row[] = $no++;	
		 $row[] = isset($relasi->nama)?($relasi->nama):null;
		 $row[] = isset($relasi->nip)?($relasi->nip):null;
		 $row[] = $this->m_reff->jk(isset($relasi->jk)?($relasi->jk):null);
		 // $row[] = $dataDB->alamat;
		 $row[] = isset($relasi->no_hp)?($relasi->no_hp):null;
		 $row[] = isset($relasi->email)?($relasi->email):null;
			 
			$row[] = $tombol;



			$data[] = $row; 

		}

		$output = array(
			"draw" => $this->m_reff->san($this->input->post("draw")),
			"recordsTotal" => $c=$this->pusat->count(),
			"recordsFiltered" =>$c,
			"data" => $data,
			"token"=>$this->m_reff->getToken()
		);
         //output to json format
		echo json_encode($output);

	}

	function viewEdit_pimpinan_pusat(){
		$id = $this->m_reff->san($this->input->post("id"));
		if(!$id){ return $this->m_reff->page403();}

		$var["data"]=$this->load->view("viewEdit_pimpinan_pusat",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}

	function viewAdd_pimpinan_pusat(){
		$f = $this->input->post();
		if(!$f){ return $this->m_reff->page403();}

		$var["data"]=$this->load->view("viewAdd_pimpinan_pusat","",true);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}

	function update_pimpinan_pusat(){
		$f = $this->input->post("f");
		if(!$f){ return $this->m_reff->page403();}

		$data = $this->pusat->update();
		echo json_encode($data);
	}

	function insert_pimpinan_pusat(){
		$id = $this->input->post("f");
		if(!$id){ return $this->m_reff->page403();}

		$data = $this->pusat->insert();
		echo json_encode($data);
	}

	function hapus_pimpinan_pusat(){
		$id = $this->m_reff->san($this->input->post("id"));
		if(!$id){ return $this->m_reff->page403();}

		$data = $this->pusat->hapus();
		echo json_encode($data);
	}
    //========== END PIMPINAN PUSAT===============



    ///======== DATA ADMIN 
	public function admin()
	{

		$ajax=$this->input->post("ajax");
		if($ajax=="yes")
		{
			$var["data"]=$this->load->view("admin",null,true);
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
		}else{
			$data['konten']="admin";
			$this->_template($data);
		}

	}  

	function getData_admin()
	{
		if(!$this->m_reff->san($this->input->post("draw"))){ echo $this->m_reff->page403(); return false;}
		$list = $this->admin->get_data_admin();
		$data = array();
		$no = $this->m_reff->san($this->input->post("start"));
		$no =$no+1;
		foreach ($list as $dataDB) {
         ////


		 $tombol='<div aria-label="Basic example" class="btn-groupss" role="group">
		 <button style="display:none;" onclick="edit(`'.$dataDB->id_admin.'`,`'.$dataDB->owner.'`)" class="font14 btn btn-sm ti-pencil btn-secondary" type="button"> Edit</button> 
		 <button style="color:white" onclick="hapus(`'.$dataDB->id_admin.'`,`'.$dataDB->owner.'`)" class="font14 btn btn-sm ti-trash bg-danger" type="button"> Hapus</button> 
		 </div>';

		 $relasi = $this->db->get_where("data_pegawai",array("nip"=>$dataDB->nip))->row();
		 

		 $row = array();
		 $row[] = $no++;	
		 $row[] = isset($relasi->nama)?($relasi->nama):null;
		 $row[] = isset($relasi->nip)?($relasi->nip):null;
		 $row[] = $this->m_reff->jk(isset($relasi->jk)?($relasi->jk):null);
		 // $row[] = $dataDB->alamat;
		 $row[] = isset($relasi->no_hp)?($relasi->no_hp):null;
		 $row[] = isset($relasi->email)?($relasi->email):null;
			 
			 
			$row[] = $tombol;



			$data[] = $row; 

		}

		$output = array(
			"draw" => $this->m_reff->san($this->input->post("draw")),
			"recordsTotal" => $c=$this->admin->count_admin(),
			"recordsFiltered" =>$c,
			"data" => $data,
			"token"=>$this->m_reff->getToken()
		);
         //output to json format
		echo json_encode($output);

	}
	function viewEdit_admin(){
		$id	= $this->m_reff->san($this->input->post("id"));
		if(!$id){
			return $this->m_reff->page403();
		}

		$var["data"]=$this->load->view("viewEdit_admin",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}

	function viewAdd_admin(){
		$f	= $this->input->post();
		if(!$f){
			return $this->m_reff->page403();
		}

		$var["data"]=$this->load->view("viewAdd_admin","",true);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}

	function update_admin(){
		$f	= $this->input->post('f');
		if(!$f){
			return $this->m_reff->page403();
		}

		$data = $this->admin->update();
		echo json_encode($data);
	}

	function insert_admin(){
		$f	= $this->input->post('f');
		if(!$f){
			return $this->m_reff->page403();
		}

		$data = $this->admin->insert();
		echo json_encode($data);
	}

	function hapus_admin(){
		$id	= $this->m_reff->san($this->input->post('id'));
		if(!$id){
			return $this->m_reff->page403();
		}

		$data = $this->admin->hapus();
		echo json_encode($data);
	}
    //========== END ADMIN ===============

}