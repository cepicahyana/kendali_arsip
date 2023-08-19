<?php
class Model extends CI_Model
{

	public function __construct() {
        parent::__construct();
    }
	
	function idu(){
		return $this->session->userdata("id");
	}
	function calendaragenda(){
		$this->db->where("nip",$this->m_reff->nip());
		$this->db->where("year(tgl)",date("Y"));
		
	    $a = $this->db->get("data_absen")->result();

		$dt = array();
		foreach($a as $v){
		 
			if($v->jenis_absen=="1"){
				$bg = "#17a2b8";
				$title = "WFO";
				$txt = "white";
			}elseif($v->jenis_absen=="2"){
				$bg = "#007bff";
				$title = "WFH";
				$txt = "white";
			}elseif($v->jenis_absen=="3"){
				$bg = "#dc3545";
				$title = "DINAS";
				$txt = "white";
			}elseif($v->jenis_absen=="4"){
				$bg = "#dc3545";
				$title = "IZIN";
				$txt = "white";
			}elseif($v->jenis_absen=="5"){
				$bg = "#dc3545";
				$title = "SAKIT";
				$txt = "white";
			}elseif($v->jenis_absen=="6"){
				$bg = "#dc3545";
				$title = "ALFA";
				$txt = "white";
			}else{
				$txt = "white";
				$bg = "#6c757d";
				$title = "tanpa keterangan";
			}
			
			$dt[]=array(
				"id"					=>		$v->id,
				"start"					=>		$v->tgl,
				"end"					=>		$v->tgl,
				"backgroundColor"		=>		$bg,
				"textColor"				=>		$txt,
				"title"					=>		$title,
			);
		}
		return $dt;
	}

	function insert_job(){
		$this->m_reff->log("Input pekerjaan","ppnpn");
		$tgl  = $this->input->post("tgl");
		//$date = $this->tanggal->eng($tgl,"-");
		$form = $this->input->post("f");
		$this->db->set("tgl",$tgl);
		$this->db->set("_ctime",date('Y-m-d H:i:s'));
		$this->db->set($form);
		$this->db->set("nip",$this->m_reff->nip());
		$this->db->set("kode_istana",$this->session->userdata("kode_istana"));
		$this->db->set("kode_biro",$this->session->userdata("kode_biro"));
		$this->db->set("nama",$this->m_reff->goField("data_pegawai","nama","where nip='".$this->m_reff->nip()."'"));
		return $this->db->insert("data_tugas_harian");
	}
	// function selisih($akhir,$awal) //menit

	// {
	// 	 	   $hourdiff  = round((strtotime($akhir) - strtotime($awal))/60, 2)*60;
	// 	return $this->tanggal->hitungJamAbsen($hourdiff);
	// }


	function hapusJob(){
		$this->m_reff->log("Hapus data pekerjaan","ppnpn");
		$this->db->where("id",$this->input->post("id"));
		return $this->db->delete("data_tugas_harian");
	}
	// function hitungTelat($datang){
	// 	$hari = date("N");
	// 	if($hari>5){
	// 		return	0;
	// 	}
	// 	$jamSetingMasuk =   $this->m_reff->pengaturan(4);
	// 	return 	$this->selisih($datang,$jamSetingMasuk);
		 
	// }
	// function hitungLemburWeekend($datang,$pulang){
	// 	$maxLemburWeekend = $this->m_reff->pengaturan(13);
	//  	$lamaKerja		  =	$this->selisih($pulang,$datang); // lama bekerja tanpa lembur maks. jam pulang
	// 	$max			  = "0".$maxLemburWeekend;
	// 	if(substr($lamaKerja,0,2)<=$max){
	// 		 	return	   $lamaKerja;///  total bekerja - kewajiban ,ada lebih berapa dr kewajiban!
			 
	// 	}else{
	// 			return 	"0".$maxLemburWeekend.":00:00";
	// 	}
	// }
	// function hitungLembur($datang,$pulang){
	// 	$hari = date("N");
	// 	if($hari>5){
	// 		return	$this->m_umum->selisih($pulang,$datang);
	// 	}
	// 	$jamLembur		=	$this->m_reff->pengaturan(6); //jam mulai lembur
	// 	$kewajiban		=	$this->m_reff->pengaturan(7); //kewajiban bekerja 8 jam

	// 	$jamPulang		=	$this->m_reff->pengaturan(5); //jam pulang
	// 	if($pulang>$jamPulang){
	// 		$maxPulang	=	$jamPulang;
	// 	}else{
	// 		$maxPulang = 	$pulang;
	// 	}
	 
	//  	$lamaKerja		=	$this->m_umum->selisih($maxPulang,$datang); // lama bekerja tanpa lembur maks. jam pulang

	// 	$lembur			=	$this->m_umum->selisih($pulang,$jamLembur);   //lembur mentahan

	// 	$lamaKerja		=	$this->tanggal->tambahJam($lamaKerja,$lembur); //kewajiban+lembur bersih

	// 	if($lamaKerja>$kewajiban){
	// 		 	return		 $this->m_umum->selisih($lamaKerja,$kewajiban); //  total bekerja - kewajiban ,ada lebih berapa dr kewajiban!
			 
	// 	}else{
	// 			return 		$lembur;
	// 	}
	 
	// }
	// function hitungUangMakan($jLembur){
	// 	$minLembur =   $this->m_reff->pengaturan(8);
	// 	if($jLembur>=$minLembur){
	// 		return 1;
	// 	}	return 0;
	// }
	// function hitungNUangMakan($jml){
	// 	$minLembur =   $this->m_reff->pengaturan(9);
	// 	return $minLembur*$jml;
	// }
	// function hitungNLembur($jml){
	// 	$hari = date("N");
	// 	if($hari>5){
	// 		$max		= (int)$this->m_reff->pengaturan(14);	
	// 	}else{
	// 		$max		= (int)$this->m_reff->pengaturan(11);	
	// 	}
	// 	  $jml		= (int)substr($jml,0,2);
	// 	  $lembur	= $this->m_reff->pengaturan(10);	
		  
	// 	  if($jml<10){
	// 		  $jml	=	(int)str_replace("0","",$jml);
	// 	  } 
		 
	// 	  $nilai = $jml*$lembur;
	// 	  if($nilai>=$max){
	// 		  return $max;
	// 	  }else{
	// 		  return $nilai;
	// 	  }
	// }

	function setAbsen(){
		$this->m_reff->log("Melakukan absen","ppnpn");
		$date = date("Y-m-d");
		$ket	  = $this->m_reff->san($this->input->post("ket"));
		$id		  = $this->m_reff->san($this->input->post("id"));
		if($id!=1 && $id!=2 && $id!=3 && $id!=4 && $id!=5 && $id!=6){
			return false;
		}


		$this->db->where("nip",$this->m_reff->nip());
		$this->db->where("tgl",$date);
		$cek = $this->db->get("data_absen")->row();
		$jam_pulang = isset($cek->jam_pulang)?($cek->jam_pulang):date('H:i:s');
		$jam_masuk  = isset($cek->jam_masuk)?($cek->jam_masuk):date('H:i:s');

		$jamSetingMasuk =   $this->m_umum->jam_masuk();
		if($jam_masuk<=$jamSetingMasuk){
			$jam_masuk_min = $jamSetingMasuk;
		}else{
			$jam_masuk_min = $jam_masuk;
		}
		$this->db->set("telat",$this->m_umum->hitungTelat($jam_masuk_min));
		if($id>5){ //6=pulang
			$this->db->set("jam_pulang",$jam_pulang);
	
			if($cek->jenis_absen==1){
				$this->db->set("lembur",$jLembur=$this->m_umum->hitungLembur($jam_masuk_min,$jam_pulang));
			}else{
				$this->db->set("lembur",null);
			}
		
			$this->db->set("lama_bekerja", $this->m_umum->selisih($jam_pulang,$jam_masuk_min));
		
	if($cek->jenis_absen==1){

						if(!$ket){
							$ket=null;
							$this->db->set("lembur_terhitung",0);
							$this->db->set("n_lembur",null);
							$this->db->set("uang_makan",null);
							$this->db->set("n_uang_makan",null);
						}else{
							$this->db->set("lembur_terhitung",$this->m_umum->hitungLemburTerhitung($jLembur));
							$this->db->set("n_lembur",$this->m_umum->hitungNLembur($jLembur));
							$this->db->set("uang_makan",$jUM=$this->m_umum->hitungUangMakan($jLembur));
							$this->db->set("n_uang_makan",$this->m_umum->hitungNUangMakan($jUM));
						}
						if(strlen($ket)<3){
						$this->db->set("ket_lembur", null);
						}else{
							$this->db->set("ket_lembur", $ket);
						}

	}else{
					$this->db->set("lembur_terhitung",0);
					$this->db->set("n_lembur",null);
					$this->db->set("uang_makan",null);
					$this->db->set("n_uang_makan",null);
	}
			 

		}else{
			$this->db->set("jenis_absen",$id);
		}


		$id_format = $this->m_umum->id_format();
		if($id_format){
			$for = $this->m_umum->format_absen();
			$this->db->set("id_format",$id_format);
			$this->db->set("uang_lembur_berlaku",$for->nominal_lembur);
			$this->db->set("uang_makan_berlaku",$for->uang_makan);
			$this->db->set("jamin_umak_berlaku",$for->jamin_umak);
		}
	

		if(isset($cek->id)){
			$this->db->set("nip",$this->m_reff->nip());
			
			$this->db->set("kode_istana",$this->session->userdata("kode_istana"));
			$this->db->set("kode_biro",$this->session->userdata("kode_biro"));
			$this->db->set("nama",$this->m_reff->goField("data_pegawai","nama","where nip='".$this->m_reff->nip()."'"));
			$this->db->where("id",$cek->id);
			return $this->db->update("data_absen");
		}else{
			$this->db->set("tgl",$date);
			$this->db->set("nip",$this->m_reff->nip());
			$this->db->set("jam_masuk",$jam_masuk);
			$this->db->set("kode_istana",$this->session->userdata("kode_istana"));
			$this->db->set("kode_biro",$this->session->userdata("kode_biro"));
			$this->db->set("nama",$this->m_reff->goField("data_pegawai","nama","where nip='".$this->m_reff->nip()."'"));
		
			return $this->db->insert("data_absen");
		}

	}

	// function hitungLemburTerhitung($jml){
	// 	$h = date("N");
	// 	if($h>5){
	// 				$jml=(int)substr($jml,0,2);
	// 				if($jml<10){
	// 					$jml = str_replace("0","",$jml);
	// 				} 
	// 				$max = $this->m_reff->pengaturan(13);
	// 				if($jml>=$max){
	// 					$jml = $max;
	// 				}
	// 				return $jml;
	// 	}

	// 	$jml=(int)substr($jml,0,2);
	// 	if($jml<10){
	// 		$jml = str_replace("0","",$jml);
	// 	} 
	// 	$max = $this->m_reff->pengaturan(12);
	// 	if($jml>=$max){
	// 		$jml = $max;
	// 	}
	// 	return $jml;
	// }

	function cekAbsen($tgl=null,$jenis="jam_masuk"){
		$this->db->where("nip",$this->m_reff->nip());
		if(!$tgl){
			$tgl = date("Y-m-d");
		}
		$this->db->where("tgl",$tgl);
	
		$db =  $this->db->get("data_absen")->row();
		return isset($db->$jenis)?($db->$jenis):null;
	}

	function dataAbsen($tgl=null){
		$this->db->where("nip",$this->m_reff->nip());
		if(!$tgl){
			$tgl = date("Y-m-d");
		}
		$this->db->where("tgl",$tgl);
		
		return $this->db->get("data_absen")->row();
		 
	}

	function setAbsenScan(){
		$code = $this->m_reff->san($this->input->post("code"));
		$cek = $this->m_reff->pengaturan(2);
		if($cek==$code){
			$this->session->set_flashdata("absen",true);
			$this->setAbsen();
			$var["gagal"]=false;
			return $var;
		}else{
			$var["gagal"]=true;
			$var["info"]="Qrcode  salah!";
			return $var;
		}
	

	}

	// function distance($lat1, $lon1, $lat2, $lon2) {
	// 	$theta = $lon1 - $lon2;
	// 	$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
	// 	$dist = acos($dist);
	// 	$dist = rad2deg($dist);
	// 	$miles = $dist * 60 * 1.1515;
	//     return ($miles * 1.609344);
	//   }

	  function distance($lat1, $lon1, $lat2, $lon2) {
		$theta = $lon1 - $lon2;
		$miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
		$miles = acos($miles);
		$miles = rad2deg($miles);
		$miles = $miles * 60 * 1.1515;
		$feet  = $miles * 5280;
		$yards = $feet / 3;
		$kilometers = $miles * 1.609344;
		$meters = $kilometers * 1000;
		$d= compact('miles','feet','yards','kilometers','meters'); 
		return  isset($d["meters"])?($d["meters"]):null;
	}

	function cekJarak(){
		$lat = $this->m_reff->san($this->input->post("lat"));
		$lng = $this->m_reff->san($this->input->post("lng"));

		$this->db->where("kode",$this->session->userdata("kode_istana"));
		$dt    = $this->db->get("tr_istana")->row();
		$jarak = isset($dt->max_jarak)?($dt->max_jarak):0;
		$s_lat = $dt->lat;
		$s_lng = $dt->lng;

		return $this->distance($lat,$lng,$s_lat,$s_lng);
	}
	function cekLokasi(){
		 

		// $lat = $this->m_reff->san($this->input->post("lat"));
		// $lng = $this->m_reff->san($this->input->post("lng"));

		$this->db->where("kode",$this->session->userdata("kode_istana"));
		$dt    = $this->db->get("tr_istana")->row();
		$jarak = isset($dt->max_jarak)?($dt->max_jarak):0;
		// $s_lat = $dt->lat;
		// $s_lng = $dt->lng;

		// $cek = $this->distance($lat,$lng,$s_lat,$s_lng);

		$cek = $this->cekJarak();
		if($cek>=$jarak){
			$var["sts"]=false;
			$var["jarak"]=$cek." M";
			return $var;
		}else{
			$this->setAbsen();
			$var["sts"]=true;
			$var["jarak"]=$cek." M";
			return $var;
		}

	}
	function cekLokasiPulang(){
		 

		// $lat = $this->m_reff->san($this->input->post("lat"));
		// $lng = $this->m_reff->san($this->input->post("lng"));

		$this->db->where("kode",$this->session->userdata("kode_istana"));
		$dt    = $this->db->get("tr_istana")->row();
		$jarak = isset($dt->max_jarak)?($dt->max_jarak):0;
		// $s_lat = $dt->lat;
		// $s_lng = $dt->lng;

		// $cek = $this->distance($lat,$lng,$s_lat,$s_lng);

		$cek = $this->cekJarak();
		if($cek>=$jarak){
			$var["sts"]=false;
			$var["jarak"]=$cek." M";
			return $var;
		}else{
			$this->setAbsen();
			$var["sts"]=true;
			$var["jarak"]=$cek." M";
			return $var;
		}

	}
	function max_jarak(){
		$kode_istana = $this->session->userdata("kode_istana");
						$this->db->where("kode",$kode_istana);
		$jarak 		 = $this->db->get("tr_istana")->row();
		return	isset($jarak->max_jarak)?($jarak->max_jarak):0;
	}

}
