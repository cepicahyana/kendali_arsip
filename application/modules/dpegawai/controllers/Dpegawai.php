<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dpegawai extends MY_Controller {

	

	function __construct()
	{
		parent::__construct();	
		$this->m_konfig->validasi_session(array("pegawai"));
		$this->load->model("model","mdl");
		date_default_timezone_set('Asia/Jakarta');
	 
	}
	function setSembuhByKode(){
		$kode = $this->input->post("kode");
		 $this->mdl->setSembuhByKode($kode);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}
	function setSembuhByKodeKel(){
		$kode = $this->input->post("kode");
		 $this->mdl->setSembuhByKodeKel($kode);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
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
	 
	  public function riwayat_tes()
	{
		$ajax=$this->input->get_post("ajax");
		if($ajax=="yes")
		{
			$var["data"]=$this->load->view("riwayat_tes",NULL,TRUE);
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
		}else{
			$data['konten']="riwayat_tes";
			$this->_template($data);
		}
		
	}  
	  public function riwayat_keluarga()
	{
		$ajax=$this->input->get_post("ajax");
		if($ajax=="yes")
		{
			$var["data"]=$this->load->view("riwayat_keluarga",NULL,TRUE);
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
		}else{
			$data['konten']="riwayat_keluarga";
			$this->_template($data);
		}
		
	}  
	function get_kab(){
		$idprov		=	$this->m_reff->san($this->input->post("id_prov"));
		// if(!$idprov){ return $this->m_reff->page403();}

		$value		=	$this->m_reff->san($this->input->post("value"));
		$dbkab		=	$this->mdl->getDataKab($idprov);
		$op[null]	=	"---- pilih ----";
		foreach($dbkab as $val){
			$op[$val->id_kab]	=	$val->nama;
		}
		echo form_dropdown("d[id_kab]",$op,$value,"required onchange='get_kec()' style='color:black' class='black form-control search-box'");
	}
	function get_kec(){
		$idkab		=	$this->m_reff->san($this->input->post("id_kab"));
		// if(!$idkab){ return $this->m_reff->page403();}

		$value		=	$this->m_reff->san($this->input->post("value"));
		$dbkec		=	$this->mdl->getDataKec($idkab);
		$op[null]	=	"---- pilih ----";
		foreach($dbkec as $val){
			$op[$val->id_kec]	=	$val->nama;
		}
		echo form_dropdown("d[id_kec]",$op,$value,"required onchange='get_kel()' style='color:black' class='form-control search-box'");
	}
	function get_kel(){
		$idkec		=	$this->m_reff->san($this->input->post("id_kec"));
		// if(!$idkec){ return $this->m_reff->page403();}

		$value		=	$this->m_reff->san($this->input->post("value"));
		$dbkel		=	$this->mdl->getDataKel($idkec);
		$op[null]	=	"---- pilih ----";
		foreach($dbkel as $val){
			$op[$val->id_kel]	=	$val->nama;
		}
		echo form_dropdown("d[id_kel]",$op,$value,"required class='form-control' style='color:black'");
	}
	function getData()
	{
		if(!$this->m_reff->san($this->input->post("draw"))){ echo $this->m_reff->page403(); return false;}
		$list = $this->mdl->get_data();
		$data = array();
		$no = $this->m_reff->san($this->input->post("start"));
		$no =$no+1;
		foreach ($list as $dataDB) {
		////
	  if($dataDB->hasil=="+"){
		  $hasil = "<span class='badge badge-danger'>positif +</span> 
		  | <a class='text-primary' href='".site_url("download")."?f=".$this->m_reff->encrypt($dataDB->file)."'> 
		  <i class='fa fa-download' ></i> Download hasil tes</a>
		  ";
	  }elseif($dataDB->hasil=="-"){
		  $hasil = "<span class='badge badge-success'>negatif -</span>
		  | <a class='text-primary' href='".site_url("download")."?f=".$this->m_reff->encrypt($dataDB->file)."'> 
		  <i class='fa fa-download' ></i> Download hasil tes</a> 
		  ";
	  }else{
		$hasil = "<span class='badge badge-info'> belum keluar </span>";
	  }
		 
			$row = array();
			// $row[] =  $no++;	

			if($dataDB->konfirm_rs){
				$tgl =  $this->tanggal->hariLengkap3($dataDB->konfirm_rs,"/");
			}else{
				$tgl =  $this->tanggal->hariLengkap3($dataDB->tgl,"/");
			}

			$row[] = $tgl;
			$row[] = $hasil;
			$row[] = $this->m_reff->goField("tr_jenis_test","nama","where kode='".$dataDB->kode_jenis."'");
			$row[] = $this->m_reff->goField("tm_rs","nama","where kode='".$dataDB->kode_tempat."'");
		
			 
		  
			$data[] = $row; 
			
			}
			 
		$output = array(
						"draw" => $this->m_reff->san($this->input->post("draw")),
						"recordsTotal" => $c=$this->mdl->count(),
						"recordsFiltered" =>$c,
						"data" => $data,
						// "token"=>$this->m_reff->getToken()
						);
		//output to json format
		echo json_encode($output);

	}
 

	function getDataKeluarga()
	{
		if(!$this->m_reff->san($this->input->post("draw"))){ echo $this->m_reff->page403(); return false;}
		$list = $this->mdl->get_data_keluarga();
		$data = array();
		$no = $this->m_reff->san($this->input->post("start"));
		$no =$no+1;
		foreach ($list as $dataDB) {
		////
	  if($dataDB->hasil=="+"){
		  $hasil = "<span class='badge badge-danger'>positif +</span> 
		  | <a class='text-primary' href='".site_url("download")."?f=".$this->m_reff->encrypt($dataDB->file)."'> 
		  <i class='fa fa-download' ></i> Download hasil tes</a>
		  ";
	  }elseif($dataDB->hasil=="-"){
		  $hasil = "<span class='badge badge-success'>negatif -</span>
		  | <a class='text-primary' href='".site_url("download")."?f=".$this->m_reff->encrypt($dataDB->file)."'> 
		  <i class='fa fa-download' ></i> Download hasil tes</a> 
		  ";
	  }else{
		$hasil = "<span class='badge badge-info'> belum keluar </span>";
	  }
		 
			$row = array();
			// $row[] =  $no++;	

			if($dataDB->konfirm_rs){
				$tgl =  $this->tanggal->hariLengkap3($dataDB->konfirm_rs,"/");
			}else{
				$tgl =  $this->tanggal->hariLengkap3($dataDB->tgl,"/");
			}

			$row[] = $tgl;
			$row[] = $dataDB->nama;
			$row[] = $hasil;
			$row[] = $this->m_reff->goField("tr_jenis_test","nama","where kode='".$dataDB->kode_jenis."'");
			$row[] = $this->m_reff->goField("tm_rs","nama","where kode='".$dataDB->kode_tempat."'");
		
			 
		  
			$data[] = $row; 
			
			}
			 
		$output = array(
						"draw" => $this->m_reff->san($this->input->post("draw")),
						"recordsTotal" => $c=$this->mdl->count_keluarga(),
						"recordsFiltered" =>$c,
						"data" => $data,
						// "token"=>$this->m_reff->getToken()
						);
		//output to json format
		echo json_encode($output);

	}
 

	 function viewPilihKondisi(){
		 $var["data"]=$this->load->view("viewPilihKondisi",NULL,TRUE);
		//  $var["token"]=$this->m_reff->getToken();
		 echo json_encode($var);
	 }

	 function viewPilihKondisiKeluarga(){
		 $var["data"]=$this->load->view("viewPilihKondisiKeluarga",NULL,TRUE);
		//  $var["token"]=$this->m_reff->getToken();
		 echo json_encode($var);
	 }

	 function progress(){
			$var["data"]=$this->load->view("progress",NULL,TRUE);
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
	 }

	 function viewAdd(){
		$f=$this->input->post();
		if(!$f){ return $this->m_reff->page403();}

		$var["data"]=$this->load->view("viewAdd",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	 }

	 function viewAddKeluarga(){
		$f=$this->input->post();
		if(!$f){ return $this->m_reff->page403();}

		$var["data"]=$this->load->view("viewAddKeluarga",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	 }
	 function ajukan_tes_keluarga(){
		$f=$this->input->post('f');
		if(!$f){ return $this->m_reff->page403();}
		
		 $var = $this->mdl->ajukan_tes_keluarga();
		 echo json_encode($var);
	 }
	 function ajukan_tes(){
		$f=$this->input->post('f');
		if(!$f){ return $this->m_reff->page403();}
		 $var = $this->mdl->ajukan_tes();
		 echo json_encode($var);
	 }

	 function viewKeterangan(){
		$var["data"]=$this->load->view("viewKeterangan",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	 }
	 function ajukan_ulang(){
		$var["data"]=$this->load->view("viewAjukanUlang",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	 }
	 function ajukan_ulang_keluarga(){
		$var["data"]=$this->load->view("viewAjukanUlangKeluarga",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	 }
	 function viewKeteranganNegatif(){
		 $this->load->view("viewKeteranganNegatif");
	 }
	 function update_kondisi(){
		$f=$this->input->post('f');
		if(!$f){ return $this->m_reff->page403();}
		echo json_encode($this->mdl->update_kondisi());
	 }
	 function update_kondisi_keluarga(){
		$f=$this->input->post('f');
		if(!$f){ return $this->m_reff->page403();}
		echo json_encode($this->mdl->update_kondisi_keluarga());
	 }
	 function hapus_progress(){
		$id = $this->m_reff->san($this->input->post('id'));
		if(!$id){ return $this->m_reff->page403();}

		$this->mdl->hapus_progress();
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	 }
	 function hapus_permohonan_keluarga(){
		$kode = $this->m_reff->san($this->input->post('kode'));
		if(!$kode){ return $this->m_reff->page403();}

		$this->mdl->hapus_permohonan_keluarga();
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	 }
	 function hapus_permohonan(){
		$kode = $this->m_reff->san($this->input->post('kode'));
		if(!$kode){ return $this->m_reff->page403();}

		$this->mdl->hapus_permohonan();
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	 }
	 function update_ket(){
		$kode = $this->m_reff->san($this->input->post('kode'));
		if(!$kode){ return $this->m_reff->page403();}
		
		echo json_encode($this->mdl->update_ket());
	 }
	//  function set_update(){
	// 	echo $this->mdl->set_update();
	//  }
	function download_surat(){
		return $this->dowload_surat();
	}
	function dowload_surat()
	{ 
    //    $id= $this->input->get("id"); 
	// 	$data['id']=$id; 
	// 	ob_start();
	// 	//include('file.html');
	// 	$isi=$this->load->view('dowload_surat',$data);
	// 	return false;
	// 	$isi = ob_get_clean();

	// 	require_once('assets/html2pdf/html2pdf.class.php');
	// 	try{
	// 	 $html2pdf = new HTML2PDF('P',array("210","297"), 'en', true, '', array(15,10,10, 10));
	// 	 $html2pdf->writeHTML($isi, isset($_GET['vuehtml']));
	// 	 $html2pdf->Output('surat_test.pdf');
	 
	// 	}
	// 	catch(HTML2PDF_exception $e){
	// 	 echo $e;
	// 	 exit;
	// 	}
	}
}