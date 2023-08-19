<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cek_data_edit extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->m_konfig->validasi_session(array("admin_data","super_admin","pimpinan_pusat"));
		$this->load->model("model","mdl");
		date_default_timezone_set('Asia/Jakarta');
	}
	
	function _template($data)
	{
		$level = $this->session->userdata('level');
		$tempMain = 'temp_main_data';
		if($level=="pimpinan_pusat"){
			$tempMain = 'temp_main_pusat';
		}
		$this->load->view($tempMain.'/main',$data);	
	}
	public function index()
	{
		$ajax=$this->input->get_post("ajax");
		if($ajax=="yes")
		{
			$var["data"]	=	$this->load->view("index",null,true);
			$var["token"]	=	$this->m_reff->getToken();
			echo json_encode($var);
		}else{
			$data['konten']	=	"index";
			$this->_template($data);
		}
		
	}

	//start form edit
	function modal_form_edit(){
		$cek = $this->m_reff->san($this->input->post("id"));
		if(!$cek){ return $this->m_reff->page403();}
		

		$val["id"]=$this->m_reff->san($this->input->post("id"));
		$val["val"]=$this->m_reff->san($this->input->post("val"));
		$val["id_a"]=$this->m_reff->san($this->input->post("id_a"));

		if($cek=="a"){
			$var["data"]=$this->load->view("dataPersonalEdit",$val,TRUE);
		}elseif($cek=="b"){
			$var["data"]=$this->load->view("dataPegawaiEdit",$val,TRUE);
		}elseif($cek=="c"){
			$var["data"]=$this->load->view("dataKeluargaEdit",$val,TRUE);
		}elseif($cek=="d"){
			$var["data"]=$this->load->view("dataDomisiliEdit",$val,TRUE);
		}elseif($cek=="e"){
			$var["data"]=$this->load->view("dataGolonganEdit",$val,TRUE);
		}elseif($cek=="f"){
			$var["data"]=$this->load->view("dataJabatanEdit",$val,TRUE);
		}elseif($cek=="g"){
			$var["data"]=$this->load->view("dataPenugasanEdit",$val,TRUE);
		}elseif($cek=="h"){
			$var["data"]=$this->load->view("dataPendidikanEdit",$val,TRUE);
		}elseif($cek=="i"){
			$var["data"]=$this->load->view("dataPenghargaanEdit",$val,TRUE);
		}elseif($cek=="j"){
			$var["data"]=$this->load->view("dataPenilaianKinerjaEdit",$val,TRUE);
		}elseif($cek=="k"){
			$var["data"]=$this->load->view("dataMedisEdit",$val,TRUE);
		}elseif($cek=="l"){
			$var["data"]=$this->load->view("dataGajiEdit",$val,TRUE);
		}elseif($cek=="m"){
			$var["data"]=$this->load->view("dataHukumanEdit",$val,TRUE);
		}elseif($cek=="n"){
			$var["data"]=$this->load->view("dataVaksinasiEdit",$val,TRUE);
		}elseif($cek=="o"){
			$var["data"]=$this->load->view("dataKeminatanEdit",$val,TRUE);
		}elseif($cek=="p"){
			$var["data"]=$this->load->view("dataPelatihanEdit",$val,TRUE);
		}

		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}

	function modal_table(){
		$cek=$this->m_reff->san($this->input->post("id"));
		if(!$cek){ return $this->m_reff->page403();}


		$val["id"]=$this->m_reff->san($this->input->post("id"));
		$val["val"]=$this->m_reff->san($this->input->post("val"));

		if($cek=="c"){
			$var["data"]=$this->load->view("tableKeluarga",$val,TRUE);
		}
		if($cek=="d"){
			$var["data"]=$this->load->view("tableDomisili",$val,TRUE);
		}
		if($cek=="e"){
			$var["data"]=$this->load->view("tableGolongan",$val,TRUE);
		}
		if($cek=="f"){
			$var["data"]=$this->load->view("tableJabatan",$val,TRUE);
		}
		if($cek=="g"){
			$var["data"]=$this->load->view("tablePenugasan",$val,TRUE);
		}
		if($cek=="h"){
			$var["data"]=$this->load->view("tablePendidikan",$val,TRUE);
		}
		if($cek=="i"){
			$var["data"]=$this->load->view("tablePenghargaan",$val,TRUE);
		}
		if($cek=="j"){
			$var["data"]=$this->load->view("tablePenilaianKinerja",$val,TRUE);
		}
		if($cek=="k"){
			$var["data"]=$this->load->view("tableMedis",$val,TRUE);
		}
		if($cek=="l"){
			$var["data"]=$this->load->view("tableGaji",$val,TRUE);
		}
		if($cek=="m"){
			$var["data"]=$this->load->view("tableHukuman",$val,TRUE);
		}
		if($cek=="n"){
			$var["data"]=$this->load->view("tableVaksinasi",$val,TRUE);
		}
		if($cek=="o"){
			$var["data"]=$this->load->view("tableKeminatan",$val,TRUE);
		}
		if($cek=="p"){
			$var["data"]=$this->load->view("tablePelatihan",$val,TRUE);
		}

		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}
	
	function insert(){
		$cek = $this->m_reff->san($this->input->post("fr"));
		if(!$cek){ return $this->m_reff->page403();}

		if($cek=="c"){
			$dt = $this->mdl->keluarga_insert();
		}
		if($cek=="d"){
			$dt = $this->mdl->domisili_insert();
		}
		if($cek=="e"){
			$dt = $this->mdl->golongan_insert();
		}
		if($cek=="f"){
			$dt = $this->mdl->jabatan_insert();
		}
		if($cek=="g"){
			$dt = $this->mdl->penugasan_insert();
		}
		if($cek=="h"){
			$dt = $this->mdl->pendidikan_insert();
		}
		if($cek=="i"){
			$dt = $this->mdl->penghargaan_insert();
		}
		if($cek=="j"){
			$dt = $this->mdl->penilaiankinerja_insert();
		}
		if($cek=="k"){
			$dt = $this->mdl->medis_insert();
		}
		if($cek=="l"){
			$dt = $this->mdl->gaji_insert();
		}
		if($cek=="m"){
			$dt = $this->mdl->hukuman_insert();
		}
		if($cek=="n"){
			$dt = $this->mdl->vaksinasi_insert();
		}
		if($cek=="o"){
			$dt = $this->mdl->keminatan_insert();
		}
		if($cek=="p"){
			$dt = $this->mdl->pelatihan_insert();
		}

		echo json_encode($dt);
	}
	function update(){
		$cek = $this->m_reff->san($this->input->post("fr"));
		if(!$cek){ return $this->m_reff->page403();}

		if($cek=="a"){
			$dt = $this->mdl->personil_update();
		}
		if($cek=="b"){
			$dt = $this->mdl->pegawai_update();
		}
		if($cek=="c"){
			$dt = $this->mdl->keluarga_update();
		}
		if($cek=="d"){
			$dt = $this->mdl->domisili_update();
		}
		if($cek=="e"){
			$dt = $this->mdl->golongan_update();
		}
		if($cek=="f"){
			$dt = $this->mdl->jabatan_update();
		}
		if($cek=="g"){
			$dt = $this->mdl->penugasan_update();
		}
		if($cek=="h"){
			$dt = $this->mdl->pendidikan_update();
		}
		if($cek=="i"){
			$dt = $this->mdl->penghargaan_update();
		}
		if($cek=="j"){
			$dt = $this->mdl->penilaiankinerja_update();
		}
		if($cek=="k"){
			$dt = $this->mdl->medis_update();
		}
		if($cek=="l"){
			$dt = $this->mdl->gaji_update();
		}
		if($cek=="m"){
			$dt = $this->mdl->hukuman_update();
		}
		if($cek=="n"){
			$dt = $this->mdl->vaksinasi_update();
		}
		if($cek=="o"){
			$dt = $this->mdl->keminatan_update();
		}
		if($cek=="p"){
			$dt = $this->mdl->pelatihan_update();
		}

		echo json_encode($dt);
	}
	function destroy(){
		$cek=$this->m_reff->san($this->input->post("fr"));
		if(!$cek){ return $this->m_reff->page403();}

		if($cek=="c"){
			$dt = $this->mdl->keluarga_destroy();
		}
		if($cek=="d"){
			$dt = $this->mdl->domisili_destroy();
		}
		if($cek=="e"){
			$dt = $this->mdl->golongan_destroy();
		}
		if($cek=="f"){
			$dt = $this->mdl->jabatan_destroy();
		}
		if($cek=="g"){
			$dt = $this->mdl->penugasan_destroy();
		}
		if($cek=="h"){
			$dt = $this->mdl->pendidikan_destroy();
		}
		if($cek=="i"){
			$dt = $this->mdl->penghargaan_destroy();
		}
		if($cek=="j"){
			$dt = $this->mdl->penilaiankinerja_destroy();
		}
		if($cek=="k"){
			$dt = $this->mdl->medis_destroy();
		}
		if($cek=="l"){
			$dt = $this->mdl->gaji_destroy();
		}
		if($cek=="m"){
			$dt = $this->mdl->hukuman_destroy();
		}
		if($cek=="n"){
			$dt = $this->mdl->vaksinasi_destroy();
		}
		if($cek=="o"){
			$dt = $this->mdl->keminatan_destroy();
		}
		if($cek=="p"){
			$dt = $this->mdl->pelatihan_destroy();
		}

		echo json_encode($dt);
	}

	function defaultdomisili(){
		$id = $this->m_reff->san($this->input->post('id_a'));
		if(!$id){ return $this->m_reff->page403();}

		$dt = $this->mdl->defaultdomisili();
		echo json_encode($dt);
	}


	//fungsi get wilayah
	function get_kab(){
		$idprov		=	$this->m_reff->san($this->input->post("idprov"));
		// if(!$idprov){ return $this->m_reff->page403();}

		$name		=	$this->m_reff->san($this->input->post("name"));
		$value		=	$this->m_reff->san($this->input->post("value"));
		$dbkab		=	$this->mdl->getDataKab($idprov);
		$op[null]	=	"-- pilih Kab/Kota --";
		foreach($dbkab as $val){
			$op[$val->id_kab]	=	$val->nama;
		}
		echo form_dropdown($name,$op,$value," onchange='get_kec()' class='text-black form-control select2'");
	}
	function get_kec(){
		$idkab		=	$this->m_reff->san($this->input->post("idkab"));
		// if(!$idkab){ return $this->m_reff->page403();}

		$name		=	$this->m_reff->san($this->input->post("name"));
		$value		=	$this->m_reff->san($this->input->post("value"));
		$dbkec		=	$this->mdl->getDataKec($idkab);
		$op[null]	=	"-- pilih Kecamatan --";
		foreach($dbkec as $val){
			$op[$val->id_kec]	=	$val->nama;
		}
		echo form_dropdown($name,$op,$value," onchange='get_kel()' class='text-black form-control select2'");
	}
	function get_kel(){
		$idkec		=	$this->m_reff->san($this->input->post("idkec"));
		// if(!$idkec){ return $this->m_reff->page403();}

		$name		=	$this->m_reff->san($this->input->post("name"));
		$value		=	$this->m_reff->san($this->input->post("value"));
		$dbkel		=	$this->mdl->getDataKel($idkec);
		$op[null]	=	"-- pilih Kelurahan --";
		foreach($dbkel as $val){
			$op[$val->id_kel]	=	$val->nama;
		}
		echo form_dropdown($name,$op,$value," class='text-black form-control select2'");
	}


	function upload_keluarga(){
		// $f=$this->m_reff->san($this->input->post('f'));
		// if(!$f){ return $this->m_reff->page403();}

		$data = $this->mdl->upload_keluarga();
		echo json_encode($data);
	}
 
	
	 
}