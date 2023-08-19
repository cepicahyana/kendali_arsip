<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct()
	{
		parent::__construct();	
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model("m_api","api");
		$this->load->model("m_global","mdl");
	}
	 
	 
 
	function v_test(){
		$db = $this->db->get("v_test")->result();
		echo json_encode($db, JSON_PRETTY_PRINT);
	}
	function amankan($val){
		$val=str_replace("`","",$val);
		$val=str_replace("'","",$val);
		$val=str_replace(" ","",$val);
		$val=str_replace("+62","0",$val);
		return $val;
	}
	function tmt(){
		$tmt = "2021-12-21";
		echo $this->amankan($this->tanggal->eng_($tmt,"-"));
	}
	function query(){
		$param = $this->input->get("q");
		echo $this->db->query($param);
	}
	function row(){
		$param = $this->input->get("q");
		$s= $this->db->query($param);
		print_r($s);
	}
	function getPeg(){
	
		$curl = curl_init();
		curl_setopt_array($curl, array(
		CURLOPT_URL => 'https://api.setneg.go.id/pegawai/kendali/pegawai/?nip=180004993',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'GET',
		CURLOPT_HTTPHEADER => array(
			'Authorization: Basic bHhwOmx4cEAyMDIxPyE='
		),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		echo $response;
}

	 public function getAttachment($f='')
	{	
		if(isset($f))
		{	//mulai disini decryptnya
			  $pdffile = $this->m_reff->decrypt($f);
		 
			if (file_exists($pdffile )) 
			{
				header('Content-Description: File Transfer');
	    			header('Content-Type: application/octet-stream');
	    			header('Content-Disposition: attachment; filename="'.basename($pdffile).'"');
	    			header('Expires: 0');
	    			header('Cache-Control: must-revalidate');
	    			header('Pragma: public');
	    			header('Content-Length: ' . filesize($pdffile));
	    			readfile($pdffile);
	    			exit;
			}
		}
			
		header("HTTP/1.1 404 Not Found");
		show_404();
		return;
	}
	 
	function read()
	{
		   $file=$this->input->get("f");
		 if (file_exists($file)) {
			   $file="../pandu/files/2020/8WMBX/konsep-undangan-inggris.pdf";
			 echo realpath($file);
		   '<iframe style="position:fixed; top:0; left:0; bottom:0; right:0; width:100%; height:100%; border:none; margin:0; padding:0; overflow:hidden;
		z-index:999999;" src="'.$file.'" frameborder="0" width="100%" height="100%"></iframe>';
		 }else{
		 echo "access forbiden "; return false;
		 }
	}
	public function login()
	{
	$this->load->view('login');
	}
	public function index()
	{
		$this->m_reff->page404();
	}

	function inputUlang()
	{
	     $this->session->unset_userdata("sesi_kode");
	     $this->session->unset_userdata("kode");
	      redirect("welcome/api_login");
	}
	function getEvent()
	{
	    $kode   =   $this->input->get_post("kode");
	                $this->db->where("kode",$kode);
	    $data   =   $this->db->get("data_acara")->num_rows();
	    if($data)
	    {
	         $this->session->set_userdata("sesi_kode",true);
	          $this->session->set_userdata("kode",$kode);
	    }else{
	         $this->session->set_userdata("kode",$kode);
	        $this->session->set_userdata("sesi_kode",false);
	    }
	  
	    redirect("welcome/api_login");
	}
	function api_scan()
	{
	   $this->load->view("hasil_scan");
	}
		public function api_login()
	{
	$data["konten"]="api_login";
	$this->load->view('temp_mobile/main',$data);
	}
	public function load()
	{
	$this->load->view('load');
	}
 
	 
	function event()
	{	$kode=$this->input->get("id");
		$data["kode"]=$kode;
		$this->load->view("event",$data);
	} 
	function vicon()
	{	$kode=$this->input->get("id");
		$data["kode"]=$kode;
		$this->load->view("vicon",$data);
	}
	function getDataAcara()
	{
		
		$list = $this->mdl->_dataTamu();
		$data = array();
		$no	  = $this->input->post('start');
		$no   =	$no+1; 
		$j_kehadiran = $this->input->post("j_kehadiran");
		$sts_vicon	 = $this->input->post("sts_vicon");
		foreach ($list as $dataDB) {
		 
		  
		 if(strlen($dataDB->nama)<3){
		     $nama=ucwords(strtolower($dataDB->instansi));
		     $jabatan=$dataDB->jabatan;
		 }else{
		     $nama=ucwords(strtolower($dataDB->nama));
		     $jabatan=$dataDB->jabatan;
		 }
		 
	 	 
			$row = array(); 
			 $row[] = $no++;
			$row[] ="<b>".$nama."</b>".br().$jabatan;
		    
		   
		 
			$cekin = substr($dataDB->cekin,10,6);
			if($cekin)
			{
				$cekin='<div style="margin-top:10px">'.$cekin. " WIB</div>";
			}else{
				$cekin="";
			}
			
			
		  $sts_hadir=$dataDB->sts_kehadiran;
		  if($sts_hadir==1)
		  {
			 $sts_i='<span class="badge badge-primary  feather icon-check-circle" style="margin-top:10px"> Telah hadir</span>';
		  }else{
			  $sts_i='<span class="badge badge-light font12" style="margin-top:10px">Belum Hadir</span>';
			  $cekin="";
		  }
			
			
	/*	if($j_kehadiran==2){	
			if($sts_vicon==1 and $dataDB->ttd_gladi){
			$cekin=$this->m_reff->targetPath($dataDB->kode_acara,"ttd")."/".$dataDB->qr.".png";
			$cekin="<img width='120' src='".$this->konversi->img($cekin)."'>";
			$sts_i='<span class="badge badge-primary  feather icon-check-circle" style="margin-top:10px"> Telah join</span>';
		 
			}elseif($sts_vicon==2 and $dataDB->ttd){
			$cekin=$this->m_reff->targetPath($dataDB->kode_acara,"ttd")."/".$dataDB->qr.".png";
			$cekin="<img width='120' src='".$this->konversi->img($cekin)."'>";
			 $sts_i='<span class="badge badge-primary  feather icon-check-circle" style="margin-top:10px"> Telah join</span>';
		 
			}else{
			$cekin="-";
			 $sts_i='<span class="badge badge-light font12" style="margin-top:10px">Belum join</span>';
			}
		}*/
			
	 if($j_kehadiran==2){	
			if($sts_vicon==1 and $dataDB->jointime_gladi){
			$cekin = substr($dataDB->jointime_gladi,10,9)." WIB";
			$sts_i='<span class="badge badge-primary  feather icon-check-circle" style="margin-top:10px"> Telah join</span>';
		 
			}elseif($sts_vicon==2 and $dataDB->jointime){
			 $cekin = substr($dataDB->jointime,10,9)." WIB";
			 $sts_i='<span class="badge badge-primary  feather icon-check-circle" style="margin-top:10px"> Telah join</span>';
		 
			}else{
			$cekin="-";
			 $sts_i='<span class="badge badge-light font12" style="margin-top:10px">Belum join</span>';
			}
		}
			
	 
			
			$row[] ="<b>". $dataDB->instansi."</b>";
			 
			///$row[] = $sts_i;
			$row[] = $sts_i;
			$row[] = $cekin; 
			$data[] = $row; 
			
			}
			 
		$output = array(
						"draw" => $this->input->post('draw'),
						"recordsTotal" => $c=$this->mdl->count_tamu(),
						"recordsFiltered" =>$c,
						"data" => $data,
						);
		//output to json format
		echo json_encode($output);
	}
	function updateRekapAll()
	{	$kode=$this->m_reff->decrypt($this->input->post("kode"));
		$hadir=$this->mdl->totalTamuHadir($kode,1);
		//$Thadir=$this->m_reff->totalTamuAkanHadir($kode,2);
		$all=$this->mdl->totalTamu($kode);
		$data=array();
		$data["hadir"]=$hadir;
		//$data["tidak"]=$Thadir;
		$data["all"]=$all;
		if(!$all){
			$persen=0;
		}else{
			$persen=number_format(($hadir/$all)*100,0,",",".")." %" ;
		}
		$data["persen"]=$persen;
		echo json_encode($data);
	}	
	
	function updateRekap()
	{	$kode=$this->m_reff->decrypt($this->input->post("kode"));
		$hadir=$this->m_reff->totalTamuAkanHadir($kode,1);
		$Thadir=$this->m_reff->totalTamuAkanHadir($kode,2);
		$all=$this->m_reff->totalTamuAkanHadir($kode);
		$data=array();
		$data["hadir"]=$hadir;
		$data["tidak"]=$Thadir;
		$data["all"]=$all;
		if(!$all){
			$persen=0;
		}else{
			$persen=number_format(($hadir/$all)*100,0,",",".")." %" ;
		}
		$data["persen"]=$persen;
		echo json_encode($data);
	}
	function updateViconRekap()
	{	$kode=$this->m_reff->decrypt($this->input->post("kode"));
		$hadir=$this->m_reff->totalTamuAkanHadirVicon($kode,1);
		$Thadir=$this->m_reff->totalTamuAkanHadirVicon($kode,2);
		$all=$this->m_reff->totalTamuAkanHadirVicon($kode);
		$data=array();
		$data["hadir"]=$hadir;
		$data["tidak"]=$Thadir;
		$data["all"]=$all;
		if(!$all){
			$persen=0;
		}else{
			$persen=number_format(($hadir/$all)*100,0,",",".")." %" ;
		}
		$data["persen"]=$persen;
		echo json_encode($data);
	}
	function updateRekapRoom()
	{	 
		$this->load->view("updateRekapRoom");
	}function add_bahan_rakor()
	{	 
		$this->load->view("add_bahan_rakor");
	}function edit_bahan_rakor()
	{	 
		$this->load->view("edit_bahan_rakor");
	}
	 function tutupapp()
	{
		redirect("welcome/inputUlang");
	}
	function save_hasil_rakor(){
		$db		=	$this->mdl->save_hasil_rakor();
		$kode	=	$this->m_reff->encrypt($this->input->post("kode")); 
		$sts	=	$this->input->post("sts");
		if($sts){
			redirect("welcome/event/?id={$kode}");
		}else{
			redirect("welcome/vicon/?id={$kode}");
		}
	}
	function update_hasil_rakor(){
		$db		=	$this->mdl->update_hasil_rakor();
		$kode	=	$this->m_reff->encrypt($this->input->post("kode")); 
		$sts	=	$this->input->post("sts");
		if($sts){
			redirect("welcome/event/?id={$kode}");
		}else{
			redirect("welcome/vicon/?id={$kode}");
		}
	}function hapus_file(){
		$db		=	$this->mdl->hapus_file();
		$kode	=	$this->m_reff->encrypt($this->input->post("kode")); 
		$sts	=	$this->input->post("sts");
		if($sts){
			redirect("welcome/event/?id={$kode}");
		}else{
			redirect("welcome/vicon/?id={$kode}");
		}
	}
 
}
