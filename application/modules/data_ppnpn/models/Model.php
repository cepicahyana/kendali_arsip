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
			$kodebiro = $this->session->kode_biro;
			if($kodebiro){
				$this->db->where("kode_biro",$this->m_reff->sanitize($kodebiro));
			}else{
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

		// conditional attandance 
		$absen	= $this->m_reff->san($this->input->post("absen"));
		if ($absen) {
			$this->db->where("nip in (select nip from data_absen where jenis_absen='".$absen."' and tgl='".date('Y-m-d')."' )");
		}

		// conditional gender 
		$dtjk	= $this->m_reff->san($this->input->post("jk"));
		if ($dtjk) {
			$this->db->where("jk", $dtjk);
		}

		// conditional istana
		$istana	= $this->m_reff->sanitize($this->input->post("istana"));
		if ($istana) {
			$this->db->where("kode_istana", $istana);
		}
		$biro	= $this->m_reff->sanitize($this->input->post("biro"));
		if ($biro) {
			$this->db->where("kode_biro", $biro);
		}

		// bidang
		$bidang	= $this->m_reff->san($this->input->post("bidang"));
		if ($bidang) {
			$this->db->where("bagian", $bidang);
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

	function insert()
	{
		$form	=	$this->input->post("f");
		if(!$form){
			return false;
		}
		$pass   =   $this->m_reff->san($this->input->post("password"));
		$username = $this->m_reff->san($this->input->post("f[email]"));
		$md5    =   md5($pass);
		$this->db->set($form);
		$this->db->set("username", $username);
		$this->db->set("password", $md5);
		return $this->db->insert("data_alumni");
	}
	function update()
	{
		$id		=	$this->m_reff->san($this->input->post("id"));
		$form	=	$this->input->post("f");
		if(!$form){
			return false;
		}
		$username = $this->m_reff->san($this->input->post("f[email]"));
		$pass   =   $this->m_reff->san($this->input->post("password"));
		$md5    =   md5($pass);
		$this->db->set($form);
		$this->db->set("username", $username);
		$this->db->set("password", $md5);
		$this->db->where("id", $id);
		return $this->db->update("data_alumni");
	}

	function hapus()
	{
		$id	=	$this->m_reff->san($this->input->post("id"));
		$this->db->where("id", $id);
		return $this->db->delete("data_alumni");
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

         $jamMasuk=$this->m_reff->pengaturan(4);  

         $jamPulang=$this->m_reff->pengaturan(5);

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
	public function dataGrafik()
	{
		$this->_dataGrafik();
		if ($this->input->post("length") != -1)
			$this->db->limit($this->input->post("length"), $this->input->post("start"));
		return $this->db->get()->result();
	}

	private function _dataGrafik()
	{
		$tahun = $this->m_reff->sanitize($this->input->post("tahun"));
		$sms = $this->m_reff->sanitize($this->input->post("sms"));
		$nip = $this->input->post("nip");
		$this->db->where_in("nip",$this->m_umum->dataPPNPNIn());

		// conditional   
		if($tahun){
				$this->db->where("tahun",$tahun);
		}  
		if (strlen(isset($_POST['search']['value'])?($_POST['search']['value']):null)>1) {
			$searchkey = $_POST['search']['value'];
			$searchkey = $this->m_reff->sanitize($searchkey);

			$query = array(
				"nama" => $searchkey,
				"nip" => $searchkey 
			);
			$this->db->group_start()
				->or_like($query)
				->group_end();
		}
		$this->db->limit(10);
		$this->db->order_by("semester","asc");
		$this->db->where("nip",$nip);
		$query = $this->db->from("penilaian_kinerja_ppnpn");
		return $query;
	}

	public function countGrafik()
	{
		$this->_dataGrafik();

		return $this->db->get()->num_rows();
	}

	function getNilai($nip){
		$this->db->order_by("tahun","asc");
		$this->db->order_by("semester","asc");
		$this->db->where("nip",$nip);
		return $this->db->get("penilaian_kinerja_ppnpn")->result();
	}



	 
}
