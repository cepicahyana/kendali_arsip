<?php

class Model extends CI_Model  {
    
	 
	function __construct()
    {
        parent::__construct();
		error_reporting(0);
    }
    function pejabat($data){
		$i=0;
	foreach($data as $val=>$field){ $i=1;
		$key = trim($val);
		$this->db->where('LOWER('.$key.')',strtolower(trim($field)));
	}
	if(!$i){
		$this->db->where('LOWER(jabatan)',strtolower(trim($data)));
	}
		$db 	= $this->db->get("v_pegawai")->row();
		$nip	= isset($db->nip)?($db->nip):"";
		$nama	= isset($db->nama_lengkap)?($db->nama_lengkap):"";
		// $id		= isset($db->id)?($db->id):null;
		$nama 	= "<span class='anchor' onclick='detail(`".base_url()."cek_data?nip=".$nip."`)'>".$nama."</span>";
		return isset($db->nama_lengkap)?$nama:"<i style='color:red'>Belum tersedia</i>";
	}
	
	function loop_jabatan($subbag,$jabatan){
		$this->db->where("LOWER(subbagian)",strtolower($subbag));
		$this->db->where("LOWER(jabatan)",strtolower($jabatan));
		$db = $this->db->get("v_pegawai")->result();
		$isi="";
		foreach($db as $val){
			$isi.=  '<span class="anchor" onclick="detail(`'.$val->id.'`)">'.$val->nama_lengkap.'</span><br>';
		}

		if(!$isi){
			return "<i style='color:red'>(Belum tersedia)</i><br>";
		}
		return $isi;
	}
	// function loop_jabatan($jabatan,$jenjang){
	// 	$this->db->where("LOWER(jabatan)",strtolower($jabatan));
	// 	$this->db->where("LOWER(jenjang_jabatan)",strtolower($jenjang));
	// 	$db = $this->db->get("v_pegawai")->result();
	// 	$isi="";
	// 	foreach($db as $val){
	// 		$isi.=  '<span class="anchor">'.$val->nama_lengkap.'</span><br>';
	// 	}
	// 	if(!$isi){
	// 		return "<i style='color:red'>(Belum tersedia)</i><br>";
	// 	}
	// 	return $isi;
	// }
	function unit_kerja($unit_kerja){
		$unit_kerja =   strtolower($unit_kerja);
						$this->db->where("LOWER(biro)",$unit_kerja);
		$db         =   $this->db->get_where("tr_biro")->row();
		return          isset($db->kode)?($db->kode):null;
}

	function jenjang_jabatan($data){
		
		$jabatan		 = trim($data["jabatan"]);//)?($data["jabatan"]):null;
		$jenjang_jabatan = trim(isset($data["jenjang_jabatan"])?($data["jenjang_jabatan"]):null);
		$biro 			 = trim(isset($data["biro"])?($data["biro"]):null);
		$title 			 = trim(isset($data["title"])?($data["title"]):null);
	 
		$bagian 		 = trim(isset($data["bagian"])?($data["bagian"]):null);
		$subbagian 		 = trim(isset($data["subbagian"])?($data["subbagian"]):null);

		if($subbagian){
			$this->db->where("LOWER(subbagian)",strtolower($subbagian));
		}else{
			$this->db->where("(subbagian is null or subbagian='')");
		}

		if($bagian){
			$this->db->where("LOWER(bagian)",strtolower($bagian));
		}else{
			$this->db->where("(bagian is null or bagian='')");
		}
 
			$this->db->where("LOWER(jabatan)",strtolower($jabatan));

		if($biro){
			$this->db->where("LOWER(kode_biro)",strtolower($biro));
		}else{
			$this->db->where("(kode_biro is null or kode_biro='')");
		}

			 
		if($jenjang_jabatan){
			$this->db->where("LOWER(jenjang_jabatan)",strtolower($jenjang_jabatan));
		}
		
		// else{
			// $this->db->where("(jenjang_jabatan IS NULL or jenjang_jabatan='')");
		//}

		$database	=	$this->db->get("v_pegawai");
		$dbcoll		=	$database->result();
		$tersedia   =   $database->num_rows();
		// return $this->db->last_query();

		if($subbagian){
			$this->db->where("LOWER(subbagian)",$subbagian);
		}else{
			$this->db->where("(subbagian is null or subbagian='')");
		}

		 if($biro){
			$this->db->where("LOWER(biro)",$biro);
		 }else{
			$this->db->where("(biro is null or biro='')");
		 }
		
	 
			$this->db->where("LOWER(jabatan)",strtolower($jabatan));
	 
		if($jenjang_jabatan){
			$this->db->where("LOWER(jenjang_jabatan)",strtolower($jenjang_jabatan));
		} 	 
		$db		 =	$this->db->get("tm_formasi_org")->row();
		$dbjenjang = ucwords($db->jenjang_jabatan);
		$q		 =	isset($db->kuota)?($db->kuota):1;

		if($db->id){

			if($dbjenjang){
				$echo=$dbjenjang;
			}else{
				$echo='<span style="line-height:10px">'.ucwords($jabatan).'</span>';
			}

			if($tersedia!=$q){
				$echo="<b style='color:red'>".$echo." (".$tersedia."/".$q.") </b>";
			}else{
				$echo= "<b>".$echo."</b>";
			}
		}else{
			$ray=array(
				"jabatan" => $jabatan,
				"bagian" => $bagian,
				"subbagian" => $subbagian,
				"biro" => $biro,
				"jenjang_jabatan" => $jenjang_jabatan,
				"kuota" => 1,
			);
			$this->db->where($ray);
			$t = $this->db->get("tm_formasi_org")->num_rows();
			if(!$t){
				$this->db->set("_ctime",date("Y-m-d H:i:s"));
				$t = $this->db->insert("tm_formasi_org",$ray);
			}

		}
		// }else{
		// 	if($jenjang){
		// 		$echo=$jenjang;
		// 	}else{
		// 		$echo="<b>".ucwords($jabatan)."</b>";
		// 	}
			
		// }
	 if($title){
		 $echo=$echo.br().'<i style="line-height:10px;color:tint">'.$title.'</i>';
	 }
		return $echo."<div style='margin-top:2px;line-height:14px'>".$this->loop_jenjang_jabatan($dbcoll)."</div>";
		
	}
	function loop_jenjang_jabatan($db){
		// $jabatan		 = $data["jabatan"];//)?($data["jabatan"]):null;
		// $jenjang		 = isset($data["jenjang_jabatan"])?($data["jenjang_jabatan"]):null;
		// $biro 			 = isset($data["biro"])?($data["biro"]):null;
		// $subbagian 		 = isset($data["subbagian"])?($data["subbagian"]):null;
		// $bagian 		 = isset($data["bagian"])?($data["bagian"]):null;
		
		// $this->db->where("LOWER(jabatan)",strtolower($jabatan));
		// if($jenjang){
		// 	$this->db->where("LOWER(jenjang_jabatan)",strtolower($jenjang));
		// }
		// // if($biro){
		// 	$this->db->where("LOWER(kode_biro)",strtolower($biro));
		// // }
		// // if($subbagian){
		// 	$this->db->where("LOWER(subbagian)",strtolower($subbagian));
		// // }
		// // if($bagian){
		// 	$this->db->where("LOWER(bagian)",strtolower($bagian));
		// // }
		// $db = $dbcoll->result();
		// return $this->db->last_query();
		$isi=null;
		foreach($db as $val){
			$isi.=  '<span class="anchor" onclick="detail(`'.base_url().'cek_data?nip='.$val->nip.'`)">'.$val->nama_lengkap.'</span><br>';
		}
		if(!$isi){
			return "<span style='color:red;'>(Belum tersedia)</span><br><br>";
		}
		return $isi;
	}



	function jabatan($org,$title,$subtitle){
					$this->db->where("LOWER(subbagian)",strtolower($title));
					$this->db->where("LOWER(jabatan)",strtolower($subtitle));
		$tersedia	=	$this->db->get("data_pegawai")->num_rows();
		 
				$this->db->where("LOWER(org)",strtolower($org));
				$this->db->where("LOWER(title)",strtolower($title));
				$this->db->where("LOWER(subtitle)",strtolower($subtitle));
		$db	=	$this->db->get("tm_formasi_org")->row();
		$jenjang = strtoupper($db->subtitle);
		$q	=	$db->kuota;
		if($q){
			if($tersedia<$q){
				return "<b style='color:red'>".$jenjang." (".$tersedia."/".$q.") </b>";
			}else{
				return "<b>".$jenjang."</b>";
			}
			
		}else{
			return	$jenjang;
		}
		
	}
	 
}




