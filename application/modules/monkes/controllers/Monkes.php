<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Monkes extends MY_Controller {

	

	function __construct()
	{
		parent::__construct();	
		$this->m_konfig->validasi_session(array("pic_covid","admin_covid","super_admin","pimpinan_covid"));
		$this->load->model("model","mdl");
		date_default_timezone_set('Asia/Jakarta');
	 
	}
	
	function _template($data){
		$this->load->view('temp_main/main',$data);	
	}

	function ajukan_tes(){
		$f=$this->input->post("f");
		if(!$f){ return $this->m_reff->page403();}

		$var = $this->mdl->ajukan_tes();
		echo json_encode($var);
	}

	function ajukanUlang(){
		$kode = $this->input->post("kode");
		if(!$kode){ return $this->m_reff->page403();}

		$var["data"]=$this->load->view("ajukanUlang",null,true);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}

	function ajukanUlangKeluarga(){
		$kode = $this->input->post("kode");
		if(!$kode){ return $this->m_reff->page403();}

		$var["data"]=$this->load->view("ajukanUlangKeluarga",null,true);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}
	 
	function setSembuhByKode(){
		$kode = $this->input->post("kode");
		 $this->mdl->setSembuhByKode($kode);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}
	 
	function setMeninggalByKode(){
		$kode = $this->input->post("kode");
		 $this->mdl->setMeninggalByKode($kode);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}
	function setSembuhByKodeKel(){
		$kode = $this->input->post("kode");
		 $this->mdl->setSembuhByKodeKel($kode);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}
	 
	function setMeninggalByKodeKel(){
		$kode = $this->input->post("kode");
		 $this->mdl->setMeninggalByKodeKel($kode);
		$var["token"]=$this->m_reff->getToken();
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
	    
	  public function keluarga()
	{
		$ajax=$this->input->get_post("ajax");
		if($ajax=="yes")
		{
			$var["data"]=$this->load->view("keluarga",null,true);
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
		}else{
			$data['konten']="keluarga";
			$this->_template($data);
		}
		
	}   
	
	function detailKondisi(){
		$kode=$this->m_reff->san($this->input->post("kode"));
		if(!$kode){ return $this->m_reff->page403();}

		$data["kode"]=$kode;
		$var["data"]=$this->load->view("detailKondisi",$data,true);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}

	function detailKondisiKeluarga(){
		$kode=$this->m_reff->san($this->input->post("kode"));
		if(!$kode){ return $this->m_reff->page403();}

		$data["kode"]=$kode;
		$var["data"]=$this->load->view("detailKondisiKeluarga",$data,true);
		$var["token"]=$this->m_reff->getToken();
		echo  json_encode($var);
	}
	  
	function getData()
	{
		if(!$this->input->post("draw")){ echo $this->m_reff->page403(); return false;}
		$level = $this->session->level;
		$list = $this->mdl->getData();
		$data = array();
		$no = $this->input->post("start");
		$no =$no+1;
		foreach ($list as $dataDB) {
         ////

			$kondisi 	   = $this->mdl->alurKondisi($dataDB->kode_test);
			$level_kondisi = $this->mdl->level_kondisi($dataDB->kode_test);
			$isoman  	   = $this->mdl->isoman($dataDB->kode_test);
			$tgl_akhir     = $this->mdl->getTanggalTest($dataDB->kode_test);
			$tombol='<div aria-label="Basic example" class="btn-groupss" role="group">
			<button onclick="detail(`'.$dataDB->kode_test.'`)" class="btn btn-sm btn-secondary pd-x-25 active" type="button">Detail</button> 
			 </div>';

			$selisih = $this->tanggal->selisih($dataDB->tgl_test,date('Y-m-d'));


			if($level=="pic_covid"){
				$klk = "onclick='ajukanTes(`".$dataDB->id."`,`".$dataDB->kode_test."`)' ";
			}else{
				$klk="";
			}

			$lamates = $this->tanggal->selisihHari($tgl_akhir,date('Y-m-d'));
			if($lamates==1){
				$lamates = $this->tanggal->ind($tgl_akhir,"/")." <br>Hari ini";
			}elseif($lamates>=14 and $dataDB->sts_test==1){
				$lamates = "<button   class='btn btn-sm btn-info'> Sudah ".$selisih." hari, Sudah diajukan tes</button>";
			}elseif($lamates>=14 and $dataDB->sts_test==0){
				$lamates = "<button ".$klk." class='btn btn-sm btn-danger'> Sudah ".$selisih." hari, Ajukan tes lanjutan </button>";
			}else{
				$lamates = $this->tanggal->ind($tgl_akhir,"/")." <br>".$lamates. " Hari yang lalu";
			}

			$row = array();
			$row[] ='<div   class="d-inline-block" >
												<label for="md_checkbox_'.$dataDB->id.'" class=" custom-control custom-checkbox  justify-content-center">
												<input type="checkbox" id="md_checkbox_'.$dataDB->id.'"   class="pilih  custom-control-input" onclick="pilcek()"  name="pilih[]"  value="'.$dataDB->id.'" />
													<span class="custom-control-label"> </span>
												</label>
											</div> ';
			$row[] =  $no++;	
			
			$row[] = "<b>".$dataDB->nama."</b>".br(). $dataDB->jabatan;//.br().$dataDB->kode_istana;
			$row[] = $lamates;
			$row[] = "<center>".($selisih+1)." Hari</center>";
			$row[] = $isoman;
			$row[] = $level_kondisi;
			$row[] = $kondisi;
			
			$row[] = $tombol;

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

	
	function getDataKeluarga()
	{
		if(!$this->input->post("draw")){ echo $this->m_reff->page403(); return false;}

		$list = $this->mdl->getDataKeluarga();
		$data = array();
		$no = $this->input->post("start");
		$no =$no+1;
		foreach ($list as $dataDB) {
         ////

			$kondisi 	   = $this->mdl->alurKondisiKeluarga($dataDB->kode_test);
			$level_kondisi = $this->mdl->level_kondisi_keluarga($dataDB->kode_test);
			$isoman  	   = $this->mdl->isoman_keluarga($dataDB->kode_test);
			$tgl_akhir     = $this->mdl->getTanggalTestKeluarga($dataDB->kode_test);
			$selisih = $this->tanggal->selisih($dataDB->tgl_test,date('Y-m-d'));
			$hub = $this->mdl->hubungan($dataDB->id_hubungan,$dataDB->jk);

			$peg = $this->m_reff->data_pegawai($dataDB->nip_pegawai);
			if($this->session->level=="pic_covid"){
				if($peg->kode_biro){
					$biro = $this->m_reff->biro($peg->kode_biro);
				}else{
					$biro = $this->m_reff->istana($peg->kode_istana);
				}
			}else{
				$biro = isset($peg->kode_istana)?($peg->kode_istana):"";
				$biro = $this->m_reff->istana($biro);
			}
			if(isset($peg)){
				if($peg->jabatan){
					$p=$peg->jabatan;
				}else{
					$p=null;
				}
				$data_pegawai = $peg->nama.$p."<br>".$biro;
			}else{
				$data_pegawai = "<i class='text-warning'>tidak ditemukan</i>";//$peg->nama. "<br>".$peg->jabatan."<br>".$biro;
			}

			$tombol='<div aria-label="Basic example" class="btn-groupss" role="group">
			<button onclick="detail(`'.$dataDB->kode_test.'`)" class="btn btn-sm btn-secondary pd-x-25 active" type="button">Detail</button> 
			 </div>';

			 $lamates = $this->tanggal->selisihHari($tgl_akhir,date('Y-m-d'));
			 if($lamates==1){
				 $lamates = $this->tanggal->ind($tgl_akhir,"/")." <br>Hari ini";
			 }elseif($lamates>=2 and $dataDB->sts_test==1){
				 $lamates = "<button   class='btn btn-sm btn-info'> Sudah ".$selisih." hari, Sudah diajukan tes</button>";
			 }elseif($lamates>=14 and $dataDB->sts_test==0){
				 $lamates = "<button onclick='ajukanTes(`".$dataDB->id."`,`".$dataDB->kode_test."`,`".$dataDB->nama."`)' class='btn btn-sm btn-danger'> Sudah ".$selisih." hari, Ajukan tes lanjutan </button>";
			 }else{
				 $lamates = $this->tanggal->ind($tgl_akhir,"/")." <br>".$lamates. " Hari yang lalu";
			 }


			$selisih = $this->tanggal->selisih($dataDB->tgl_test,date('Y-m-d'));
			$row = array();
			$row[] =  $no++;	
			
			$row[] = "<b>".$dataDB->nama."</b>".br()."(".$hub.")";
			$row[] = $lamates;
			$row[] = $data_pegawai;
			$row[] = "<center>".($selisih+1)." Hari</center>";
			$row[] = $isoman;
			$row[] = $level_kondisi;
			$row[] = $kondisi;
			
			$row[] = $tombol;

			$data[] = $row; 

		}

		$output = array(
			"draw" => $this->input->post("draw"),
			"recordsTotal" => $c=$this->mdl->countKeluarga(),
			"recordsFiltered" =>$c,
			"data" => $data,
			"token"=>$this->m_reff->getToken()
		);
         //output to json format
		echo json_encode($output);

	}

	
	function ajukan_tes_keluarga(){
		$f=$this->input->post('f');
		if(!$f){ return $this->m_reff->page403();}

		$var = $this->mdl->ajukan_tes_keluarga();
		echo json_encode($var);
	}
}