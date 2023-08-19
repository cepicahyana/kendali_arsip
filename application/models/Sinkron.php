<?php
class Sinkron extends ci_Model
{
    function jk($jk){
        if(strtolower($jk)=="laki-laki"){
            return "l";
        }else{
            return "p";
        }
    }

    function unit_kerja($unit_kerja){
            $unit_kerja =   strtolower($unit_kerja);
                            $this->db->where("LOWER(biro)",$unit_kerja);
            $db         =   $this->db->get_where("tr_biro")->row();
            return          isset($db->kode)?($db->kode):null;
    }

	function getSyn($nip){
			$curl = curl_init();
			curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://api.setneg.go.id/pegawai/kendali/pegawai/?nip='.$nip,
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
			return $response;
	}

    function syncronByNip($nip){
		$res 	= $this->getSyn($nip);
		$val	= json_decode($res,true);
			if(!isset($val['data'])){ return false;}
			$val						= 	$val["data"];
			$nipbaru 					=	$val['nipbaru'];
			$jenispeg 					=	$val['jenispeg'];
			$nmpeg	 					=	$val['nmpeg'];
			$jeniskelamin 				=	$val['jeniskelamin'];
			$email	 					=	$val['email'];
			$jenisjabatanakhir	 		=	$val['jenisjabatanakhir'];
			$golongan			 		=	$val['golongan'];
			

			$grade				 		=	$val['grade'];
			$statuspeg			 		=	$val['statuspeg'];
			$gelardepan			 		=	$val['gelardepan'];
			$gelarbelakang		 		=	$val['gelarbelakang'];
			$foto				 		=	$val['foto'];
			$bup				 		=	$val['bup'];
			$statkwn					=	$val['statkwn'];
			$nohp						=	$val['nohp'];
			$alamat						=	$val['alamat'];
			$tgllahir					=	$val['tgllahir'];
			$tempatlahir				=	$val['tempatlahir'];
			$agama						=	$val['agama'];
			$tmtjabatanterakhir			=	$val['tmtjabatanterakhir'];
			$instansi					=	$val['instansi'];
			// $satuan_kerja				=	$val['satuan_kerja']; // include biro
			$unit_kerja					=	$val['unit_kerja'];
			$bagian						=	$val['bagian'];
			$subbagian					=	$val['subbagian'];
			$jenis_jab					=	$val['jenis_jab'];
			$jabatan					=	$this->jjab($val['jabatan']);
			$jenjangjabatan				=	$val['jenjangjabatan'];

			 
			$tmtpangkatterakhir 		=	$this->tanggal->eng_($val['tmtpangkatterakhir'],"-");
			$karpeg				 		=	$val['karpeg'];
			$mkgoltahun			 		=	$val['mkgoltahun'];
			$mkgolbulan			 		=	$val['mkgolbulan'];
			$mkseluruhtahun				=	$val['mkseluruhtahun'];
			$mkseluruhbulan				=	$val['mkseluruhbulan'];
			$npwp						=	$val['npwp'];
			$no_rekening				=	$val['no_rekening'];
			$nama_bank					=	$val['nama_bank'];
			$nik						=	$val['nik'];
			$bpjs						=	$val['bpjs'];

			$nip_sso					=	isset($val['nip_sso'])?($val['nip_sso']):null;

			 $this->cekGol($nip,$golongan,$tmtpangkatterakhir);
		 

		 $param = array(	 
						// "mkgoltahun"				=>	$mkgoltahun,

						"nip_sso"					=>	$nip_sso,

						"bank"						=>	$nama_bank,
						"norek"						=>	$no_rekening,

						"bpjs"						=>	$bpjs,
						"nik"						=>	$nik,
						"npwp"						=>	$npwp,

						"karpeg"					=>	$karpeg,
						"nik"						=>	$nik,

						"nip_baru"					=>	$nipbaru,
						"jenispeg"					=>	$jenispeg,
						"nama"						=>	$nmpeg,
						"jk"						=>	$this->jk($jeniskelamin),
						"email"						=>	$email,
						"jabatan"					=>	$jabatan,
				 
						"jenis_jabakhir"			=>	$jenisjabatanakhir,
						"golongan"					=>	$golongan,
						"tmt_golongan"				=>	$tmtpangkatterakhir, //golongan=pangkat


						"grade"						=>	$grade,
						"statuspeg"					=>	$statuspeg,
						"gelar_depan"				=>	$gelardepan,
						"gelar_belakang"			=>	$gelarbelakang,
						"foto"						=>	$foto,
						"bup"						=>	$bup,
						"sts_menikah"				=>	$statkwn,
						"no_hp"						=>	$nohp,
						"ktp_alamat"				=>	$alamat,
						"tgl_lahir"					=>	$this->tanggal->eng_($tgllahir,"-"),
						"tempat_lahir"				=>	$tempatlahir,
						"agama"						=>	$agama,
						"tmt_jabatan_akhir"			=>	$tmtjabatanterakhir,
						"instansi"					=>	$instansi,
						// "deputi"					=>	$satuan_kerja,
						"kode_biro"					=>	$this->unit_kerja($unit_kerja),
						"bagian"					=>	$bagian,
						"subbagian"					=>	$subbagian,
						"jenis_jab"					=>	$jenis_jab,
						"jenjang_jabatan"			=>	$jenjangjabatan,
						"sync"						=>	date('Y-m-d H:i:s'),
					 );
		 $this->db->set($param);	
		 $this->db->where("nip",$nip);
		 return $this->db->update("data_pegawai");
	}

	function cekGol($nip,$golongan,$tmtpangkatterakhir){
		// $cekdefault = $this->db->get_where("data_pegawai",array("nip"=>$nip))->row();
		// $gol 		=isset($cekdefault->golongan)?($cekdefault->golongan):"";
		// if(strtoupper($golongan)==strtoupper($gol)){ return false; }

		$cekdefault = $this->db->get_where("tm_golongan",array("nip_pegawai"=>$nip,"golongan"=>$golongan))->num_rows();
		if(!$cekdefault){
			$this->db->set("tmt",$tmtpangkatterakhir);
			$this->db->set("golongan",$golongan);
			$this->db->set("nip_pegawai",$nip);
			return $this->db->insert("tm_golongan");
		}
	}

	function jjab($jab){
		$jab = strtolower($jab);
		$jab = str_replace("ahli madya","",$jab);
		$jab = str_replace("madya","",$jab);
		$jab = str_replace("ahli muda","",$jab);
		$jab = str_replace("muda","",$jab);
		$jab = str_replace("ahli pertama","",$jab);
		$jab = str_replace("pertama","",$jab);
		$jab = str_replace("ahli penyelia","",$jab);
		$jab = str_replace("penyelia","",$jab);
		$jab = str_replace("ahli mahir","",$jab);
		$jab = str_replace("mahir","",$jab);
		$jab = str_replace("ahli","",$jab);
		return $jab = str_replace("terampil","",$jab);
	}
}