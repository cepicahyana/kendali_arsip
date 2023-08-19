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
			}
			$kode_istana = $this->session->kode_istana;
			if($kode_istana){
				$this->db->where("kode_istana",$kode_istana);
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

	function getEvaluasi($nip,$tahun,$sms){
		$this->db->where("nip",$this->m_reff->san($nip));
		$this->db->where("tahun",$this->m_reff->san($tahun));
		$this->db->where("semester",$this->m_reff->san($sms));
		return $this->db->get("penilaian_kinerja_ppnpn")->row();
	}


	function update_ttd(){

		if(isset($_FILES["file"]['tmp_name']))
		{
			$nip = $this->session->userdata("nip");
			$dok=$this->m_reff->pengaturan(1)."dok/".$nip;
			// $doksave = "dok/".$nip;
			$before_file="ttd.jpg";
			$file=$this->m_reff->upload_file_ttd("file",$dok,"ttd","jpg,jpeg,png",$sizeFile="5000000",$before_file);
			if($file["validasi"]==false)
			{ 
			 $var["gagal"]=true;
			 $var["info"]="terjadi masalah saat upload file   <br>".json_encode($file);
			 return $var;
			}
		}

	}


	private function _getData()
	{
		$sts = $this->m_reff->sanitize($this->input->post("sts"));
		$tahun = $this->m_reff->sanitize($this->input->post("tahun"));
		$sms = $this->m_reff->sanitize($this->input->post("sms"));
		$bidang = $this->m_reff->sanitize($this->input->post("bidang"));

		// conditional   
		$filter = "";
		if($tahun){
			if($sms){
				$filter.=" and semester='".$sms."' ";
			}
			if($sts==1){
				$this->db->where("nip in (select nip from penilaian_kinerja_ppnpn
				 where tahun='".$tahun."' ".$filter." ) ");
			}
			if($sts==2){
				$this->db->where("nip not in (select nip from penilaian_kinerja_ppnpn
				 where tahun='".$tahun."' ".$filter." ) ");
			}
			
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

		$bidang	= $this->input->post("bidang");
		if ($bidang) {
			$this->db->where("bagian",$bidang);
		}
		$jk	= $this->input->post("jk");
		if ($jk) {
			$this->db->where("jk",$jk);
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
 
		
			$kodebiro = $this->session->kode_biro;
			if($kodebiro){
				$this->db->where("kode_biro",$this->m_reff->sanitize($kodebiro));
			}
			$kode_istana = $this->session->kode_istana;
			if($kode_istana){
				$this->db->where("kode_istana",$kode_istana);
			}
	$this->db->where("nip_evaluator",$this->session->userdata("nip"));		
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

	function getPegawaiPPNPN()
	{
		$this->db->order_by('nama', 'asc');
		$getPegawai = $this->db->get_where('data_pegawai', ['jenis_pegawai'=>2]);
		return $getPegawai;
	}

	function insert()
	{
		$form	=	$this->input->post("f");
		if(!$form){ 
			$var["gagal"] = true;
			$var["info"] = "parameter tidak ditemukan.";
			return $var;
		}
		$fi	=	$this->input->post("i");
		$data_penilaian = json_encode($fi);

		$cek     = $this->cek_data();
    if ($cek > 0) {
        $var["gagal"] = true;
        $var["info"] = "Data sudah pernah di input";
        return $var;
    }

		$this->db->set($form);
		$this->db->set('data_penilaian', $data_penilaian);
		$this->db->set('evaluator', $this->session->userdata("nip"));
		return $this->db->insert("penilaian_kinerja_ppnpn");
	}
	function update()
	{
		$id		=	$this->input->post("id");
		$form	=	$this->input->post("f");
		if(!$form){ 
			$var["gagal"] = true;
			$var["info"] = "parameter tidak ditemukan.";
			return $var;
		}
		$fi	=	$this->input->post("i");
		$data_penilaian = json_encode($fi);

		$this->db->where("id!=", $this->input->post("id"));
		$cek     = $this->cek_data();
    if ($cek > 0) {
        $var["gagal"] = true;
        $var["info"] = "Data sudah pernah di input";
        return $var;
    }

		
		$this->db->set($form);
		$this->db->set('data_penilaian', $data_penilaian);
		$this->db->where("id", $id);
		return $this->db->update("penilaian_kinerja_ppnpn");
	}

	function hapus()
	{
		$id	=	$this->input->post("id");
		$this->db->where("id", $id);
		return $this->db->delete("penilaian_kinerja_ppnpn");
	}

	function cek_data()
  {
      $tahun = $this->input->post('f[tahun]');
      $semester = $this->input->post('f[semester]');
      $id_pegawai = $this->input->post('f[id_pegawai]');
      $tahun = date('Y', strtotime($tahun));
      $this->db->where('tahun', $tahun);
      $this->db->where('semester', $semester);
      $this->db->where('nip', $id_pegawai);
      return $this->db->get('penilaian_kinerja_ppnpn')->num_rows();
  }

	 
  	function update_periode(){
		$periode = $this->input->post("periode");
		$this->db->where("id",39);
		$this->db->set("val",$periode);
		return $this->db->update("pengaturan");
	}
  	function getPeriodeNilai(){
		$id=39;
		$data = $this->db->get_where("pengaturan",array("id"=>$id))->row();
		return isset($data->val)?($data->val):null;
	}
	// getJenjangPendidikan
	function getJp()
	{
		//return  $this->db->get('tr_jp')->result();
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

	function cekPriode($range=null){
		if(!$range){
				$range=$this->m_reff->pengaturan(39);
		}
		$a = $range;
		$b =  date('d/m/Y');

		// Memisahkan tanggal awal dan tanggal akhir pada variabel $a
		$dateRange = explode(" - ", $a);
		$startDate = DateTime::createFromFormat("d/m/Y", $dateRange[0]);
		$endDate = DateTime::createFromFormat("d/m/Y", $dateRange[1]);

		// Mengecek apakah tanggal pada variabel $b berada di dalam rentang tanggal $a
		$checkDate = DateTime::createFromFormat("d/m/Y", $b);
		if ($checkDate >= $startDate && $checkDate <= $endDate) {
			return true;
		} else {
			return false;
		}


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




	 
}
