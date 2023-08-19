<?php
class Model extends CI_Model
{


	public function __construct()
	{
		parent::__construct();
	}

	function idu()
	{
		return $this->session->userdata("id");
	}
	function jenis_absen($jenis){
		$this->db->where("id",$jenis);
		$db = $this->db->get("tr_jenis_absen")->row();
		return isset($db->nama)?($db->nama):"";
	}
	function cekAbsenFinger($nip,$tgl){
		$this->db->where("nip",$nip);
		$this->db->where("tgl",$tgl);
		return $db = $this->db->get("data_absen")->row();
		//return isset($db->jenis_absen)?($db->jenis_absen):null;
	}
	function absenDatang($tgl,$nip){
		$this->db->where("nip",$nip);
		$this->db->where("tgl",$tgl);
		$db = $this->db->get("data_absen")->row();
		return isset($db->jam_masuk)?($db->jam_masuk):null;
	}
	function absenPulang($tgl,$nip){
		$this->db->where("nip",$nip);
		$this->db->where("tgl",$tgl);
		$db = $this->db->get("data_absen")->row();
		return isset($db->jam_pulang)?($db->jam_pulang):null;
	}
	function _getDataPPNPN($nip){
		$kodebiro = $this->session->userdata("kode_biro");
		if($kodebiro){
			$this->db->where("kode_biro",$this->m_reff->sanitize($kodebiro));
		}
		$kode_istana = $this->session->userdata("kode_istana");
		if($kode_istana){
			$this->db->where("kode_istana",$this->session->userdata("kode_istana"));
		}
		$this->db->where("nip", $nip);
		$this->db->where("jenis_pegawai", "2");
		$this->db->order_by("nama", "asc");
		$query = $this->db->get("data_pegawai")->row();
		return $query;
	}
	/*===================================*/
	public function getData()
	{
		$this->_getData();
		if ($this->input->post("length") != -1)
			$this->db->limit($this->input->post("length"), $this->input->post("start"));
		return $this->db->get()->result();
	}

	private function _getData()
	{

		// conditional istana
		$istana	= $this->m_reff->sanitize($this->input->post("istana"));
		if ($istana) {
			$this->db->where("kode_istana", $istana);
		}

		$biro	= $this->m_reff->sanitize($this->input->post("biro"));
		if ($biro) {
			$this->db->where("kode_biro", $biro);
		}

		// conditional attandance 
		$bidang	= $this->m_reff->san($this->input->post("bidang"));
		if ($bidang) {
			$this->db->where("bagian", $bidang);
		}

		// conditional gender 
		$dtjk	= $this->m_reff->san($this->input->post("jk"));
		if ($dtjk) {
			$this->db->where("jk", $dtjk);
		}

	  
		// conditional jp
		$dtjp	= $this->m_reff->san($this->input->post("jp"));
		if ($dtjp) {
			$this->db->where("id_jp", $dtjp);
		}

		if (strlen(isset($_POST['search']['value'])?($_POST['search']['value']):null)>1) {
			$searchkey = $_POST['search']['value'];
			$searchkey = $this->m_reff->sanitize($searchkey);

			$query = array(
				"nama" => $searchkey,
				 
			);
			$this->db->group_start()
				->or_like($query)
				->group_end();
		}

		$kodebiro = $this->session->userdata("kode_biro");
		if($kodebiro){
			$this->db->where("kode_biro",$this->m_reff->sanitize($kodebiro));
		}
		$kode_istana = $this->session->userdata("kode_istana");
		if($kode_istana){
			$this->db->where("kode_istana",$this->session->userdata("kode_istana"));
		}
		$this->db->where("jenis_pegawai", "2");
		$this->db->order_by("nama", "asc");
		$query = $this->db->from("data_pegawai");
		return $query;
	}

	function getAbsen($nip){
			   $this->db->where("nip",$nip);
			   $this->db->where("tgl",date("Y-m-d"));
		$cek = $this->db->get("data_absen")->row();
	 	$jp = isset($cek->jenis_absen)?($cek->jenis_absen):null;
		if($jp==1){
			return "<br><span class='text-primary'>WFO </span>";
		}elseif($jp==2){
			return "<br><span class='text-success'>WFH</span>";
		}elseif($jp==3){
			return "<br><span class='text-warning'>IZIN</span>";
		}elseif($jp==4){
			return "<br><span class='text-warning'>SAKIT</span>";
		}elseif($jp==6){
			return "<br><span class='text-warning'>CUTI</span>";
		}else{
			return "<br><span class='text-danger'>Belum absen</span>";
		}

	}

	public function count()
	{
		$this->_getData();

		return $this->db->get()->num_rows();
	}

	  

	// getJenjangPendidikan
	function getJp()
	{
		return  $this->db->get('tr_jp')->result();
	}

	function getJpByid($id)
	{
		$this->db->select('nama');
		$this->db->from('tr_jp');
		$this->db->where('id', $id);
		return $this->db->get()->row();
	}

	// getAgama
	function getAgama()
	{
		return  $this->db->get('tr_agama')->result();
	}
	function getAgamaByid($id)
	{
		$this->db->select('nama');
		$this->db->from('tr_agama');
		$this->db->where('id', $id);
		return $this->db->get()->row();
	}

	function status_absen($tgl,$nip)

    {   $jamMulai="050000"; $jamAkhir="230000"; $jamToleransi="080000"; //masuk

         $jamMasuk=$this->m_umum->jam_masuk();  

         $jamPulang=$this->m_umum->jam_pulang();

        $datang=$this->absenDatang($tgl,$nip);

        $pulang=$this->absenPulang($tgl,$nip);

        if($datang=="-" or !$datang){ return "0";  } //tidak masuk

        if($pulang=="-" or !$pulang){ return "0";  } //tidak masuk

        if($pulang=="-" or !$pulang){ return "0";  } //tidak masuk

       

        

          $jamMasuk=str_replace(":","",$jamMasuk);

          $jamPulang=str_replace(":","",$jamPulang);

          $pulang=str_replace(":","",$pulang); 

          $datang=str_replace(":","",$datang);

          

          if($datang>$jamMasuk){ return "t";  } //tidak masuk    --//telat masuk

          if($pulang>$jamAkhir){ return "0";  } //tidak masuk    

          

        if($datang>=$jamMulai and $datang<=$jamMasuk and $pulang>=$jamPulang and $pulang<=$jamAkhir ){ return "m"; }

        if($datang>=$jamMulai and $datang<=$jamMasuk and $pulang>=$jamPulang and $pulang>$jamAkhir ){ return "0"; }

         if($datang>=$jamMulai and $datang<=$jamMasuk and $pulang<=$jamPulang){ return "p"; }//pulang lebih awal

         if($datang>=$jamMulai and $datang>=$jamMasuk and  $datang<=$jamToleransi  and  $pulang>=$jamPulang and $pulang<=$jamAkhir   ){ return "t"; } 

         if($datang>=$jamMulai and $datang>=$jamMasuk and  $datang<=$jamToleransi  and  $pulang<$jamPulang ){ return "tp"; } 

    }
 
	 
	function selisih($akhir,$awal) //menit

	{
  
		return $hourdiff  = round((strtotime($akhir) - strtotime($awal))/60, 2)*60;
  
	}
	function jmlMakanJam($nip,$periode){
		$tgl1 = $this->tanggal->range_1($periode);
		$tgl2 = $this->tanggal->range_2($periode);
		$this->db->where("tgl>=",$tgl1);
		$this->db->where("tgl<=",$tgl2);
		$this->db->where("nip",$nip);
		$this->db->select("SUM(uang_makan) as jml");
		$db = $this->db->get("data_absen")->row();
		return isset($db->jml)?($db->jml):0;
		 
	}
	function jmlLemburJam($nip,$periode){
		$tgl1 = $this->tanggal->range_1($periode);
		$tgl2 = $this->tanggal->range_2($periode);
		$this->db->where("tgl>=",$tgl1);
		$this->db->where("tgl<=",$tgl2);
		$this->db->where("nip",$nip);
		$this->db->select("SUM(substr(lembur,1,2)) as jml");
		$db = $this->db->get("data_absen")->row();
		return isset($db->jml)?($db->jml):0;
	}
	function jmlLemburJamTerhitung($nip,$periode){
		$tgl1 = $this->tanggal->range_1($periode);
		$tgl2 = $this->tanggal->range_2($periode);
		$this->db->where("tgl>=",$tgl1);
		$this->db->where("tgl<=",$tgl2);
		$this->db->where("nip",$nip);
		$this->db->select("SUM(lembur_terhitung) as jml");
		$db = $this->db->get("data_absen")->row();
		return isset($db->jml)?($db->jml):0;
	}
	function tTelat($nip,$tgl1o,$tgl2o){
		$this->db->where("nip",$nip);
		$this->db->where("tgl>=",$tgl1o);
		$this->db->where("tgl<=",$tgl2o);
		$this->db->where("telat!=",0);
		return $this->db->get("data_absen")->num_rows();
	}

	function uLembur($nip,$tgl1o,$tgl2o){
		$this->db->where("nip",$nip);
		$this->db->where("tgl>=",$tgl1o);
		$this->db->where("tgl<=",$tgl2o);
		$this->db->select("SUM(n_lembur) as jml");
		$db =  $this->db->get("data_absen")->row();
		return isset($db->jml)?($db->jml):0;
	}
	function uMakan($nip,$tgl1o,$tgl2o){
		$this->db->where("nip",$nip);
		$this->db->where("tgl>=",$tgl1o);
		$this->db->where("tgl<=",$tgl2o);
		$this->db->select("SUM(n_uang_makan) as jml");
		$db =  $this->db->get("data_absen")->row();
		return isset($db->jml)?($db->jml):0;
	}

	function hitungLembur(){
		$nip	=	$this->m_reff->san($this->input->post("nip"));
		$tgl	=	$this->m_reff->san($this->input->post("tgl"));
		$this->db->where("nip",$nip);
		$this->db->where("tgl",$tgl);
  		 $db  = $this->db->get("data_absen")->row();
   		$lembur_terhitung = isset($db->lembur_terhitung)?($db->lembur_terhitung):null;
  		return substr($lembur_terhitung,0,5);
	}


	function revAbsen(){
		$nip	=	$this->m_reff->san($this->input->post("nip"));
		$tgl	=	$this->m_reff->san($this->input->post("tgl"));
	
		$jam_masuk	=	$this->input->post("masuk");
		$toDay		=	$this->tanggal->toDay($tgl);
		$jam_pulang	=	$this->input->post("pulang");
		
		
					 $this->db->where("nip",$nip);
					 $this->db->where("tgl",$tgl);
		  	  $db  = $this->db->get("data_absen")->row();
			 
		 
			if(isset($db->id_format)?($db->id_format):null){
				$id_format    = isset($db->id_format)?($db->id_format):1;
			}else{
				$id_format    = $this->m_umum->id_format(substr($tgl,5,6));
			}

			 
			 
			$ket 		  = isset($db->ket_lembur)?($db->ket_lembur):null;
			$iddb 	 	  = isset($db->id)?($db->id):null;

			  $jamSetingMasuk =   $this->m_umum->jam_masuk($id_format);
			  if($jam_masuk<=$jamSetingMasuk){
				  $jam_masuk_min = $jamSetingMasuk;
			  }else{
				  $jam_masuk_min = $jam_masuk;
			  }




			$this->db->set("telat",$this->m_umum->hitungTelat($jam_masuk_min,$toDay));
			
			$ja = isset($db->jenis_absen)?($db->jenis_absen):null;
			if($ja==1){

			$this->db->set("lembur",$jLembur=$this->m_umum->hitungLembur($jam_masuk_min,$jam_pulang,$toDay,$id_format));
			$this->db->set("uang_makan",$jUM=$this->m_umum->hitungUangMakan($jLembur,$id_format));
			$this->db->set("n_uang_makan",$this->m_umum->hitungNUangMakan($jUM,$id_format));
			$this->db->set("lama_bekerja", $this->m_umum->selisih($jam_pulang,$jam_masuk_min,$toDay));
		
			$this->db->set("lembur_terhitung",$this->m_umum->hitungLemburTerhitung($jLembur,$toDay,$id_format));
			$this->db->set("n_lembur",$l=$this->m_umum->hitungNLembur($jLembur,$toDay,$id_format));
			if($l){
				if(!$ket){
					$this->db->set("ket_lembur","divalidasi oleh admin");
				}
			} 


		}else{


			$this->db->set("lembur",null);
			$this->db->set("uang_makan",null);
			$this->db->set("n_uang_makan",null);
			$this->db->set("lama_bekerja", null);
		
			$this->db->set("lembur_terhitung",0);
			$this->db->set("n_lembur",null);
			$this->db->set("ket_lembur",null);
			 
			

		}

		$this->db->set("tgl",$tgl); 
		$this->db->set("nip",$nip); 
		$this->db->set("jam_masuk",$jam_masuk); 
		$this->db->set("jam_pulang",$jam_pulang); 
		$this->db->set("_uid",$this->m_reff->idu()); 
		$this->db->set("_utime",date('Y-m-d')); 

		if($id_format){
			$for = $this->m_umum->format_absen($id_format);
			$this->db->set("id_format",$id_format);
			$this->db->set("uang_lembur_berlaku",$for->nominal_lembur);
			$this->db->set("uang_makan_berlaku",$for->uang_makan);
			$this->db->set("jamin_umak_berlaku",$for->jamin_umak);
		}


		if(!$iddb){
			return $this->db->insert("data_absen");
		}else{
			$this->db->where("nip",$nip);
			$this->db->where("tgl",$tgl);
			return $this->db->update("data_absen");
		}
	
		 
	}

	

	function setJenisAbsen(){
		$nip	=	$this->m_reff->san($this->input->post("nip"));
		$tgl	=	$this->m_reff->san($this->input->post("tgl"));

		$this->db->where("nip",$nip);
		$this->db->where("tgl",$tgl);
   		$db  = $this->db->get("data_absen")->row();
 		$iddb = isset($db->id)?($db->id):null;
 

		$this->db->set("jenis_absen",$this->m_reff->san($this->input->post("value"))); 
		$this->db->set("_uid",$this->m_reff->idu()); 
		$this->db->set("_utime",date('Y-m-d')); 
		
		if(!$iddb){
			$this->db->set("nip",$nip);
			$this->db->set("tgl",$tgl);
			  $this->db->insert("data_absen");
		}else{
			$this->db->where("nip",$nip);
			$this->db->where("tgl",$tgl);
			  $this->db->update("data_absen");
		}
		return $this->revAbsen();
	}


	 
}
