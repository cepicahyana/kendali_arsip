<?php

class Quota extends CI_Model  {
    
	 
	function __construct()
    {
        parent::__construct();
    }
    function pejabat($jabatan=null,$foto=null){
					$this->db->where("LOWER(jabatan)",strtolower($jabatan));
		$db = 		$this->db->get("v_pegawai")->row();
		$nip	= isset($db->nip)?($db->nip):"";
		$nama	= isset($db->nama_lengkap)?($db->nama_lengkap):"";
		$id		= isset($db->id)?($db->id):null;
		$nama 	= "<span class='anchor' onclick='detail(`".base_url()."cek_data?nip=".$nip."`)'>".$nama."</span>";
		return isset($db->nama_lengkap)?$nama:"<i style='color:red'>Belum tersedia</i>";
	}
	function loop_jenjang_jabatan($jabatan,$jenjang){
		$this->db->where("LOWER(jabatan)",strtolower($jabatan));
		$this->db->where("LOWER(jenjang_jabatan)",strtolower($jenjang));
		$db = $this->db->get("v_pegawai")->result();
		$isi="";
		// foreach($db as $val){
		// 	$isi.=  '<span class="anchor" onclick="detail(`'.base_url().'cek_data?nip='.$val->nip.'`)">'.$val->nama_lengkap.'</span><br>';
		// }
		

		if(!$isi){
			return "";//"<input value='null' onchange='setQuota()' type='text' style='width:50px;text-align:center'><br>";
		}
		return $isi;
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
			return "";
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

	function jenjang_jabatan($org,$title,$subtitle){
					$this->db->where("LOWER(jenjang_jabatan)",strtolower($subtitle));
					$this->db->where("LOWER(jabatan)",strtolower($title));
		$tersedia	=	$this->db->get("data_pegawai")->num_rows();
		 
				// $this->db->where("LOWER(org)",strtolower($org));
				// $this->db->where("LOWER(title)",strtolower($title));
				// $this->db->where("LOWER(subtitle)",strtolower($subtitle));
		$db	=	$this->db->get("tm_formasi_org")->row();
		$jenjang = ucwords($db->subtitle);
		$q	=	$db->kuota;
		if($q){

		 
			if($tersedia<$q){
				return "<b style='color:red'>".$jenjang."   </b><br/>
				<input onchange='setQuota(`".$db->id."`,this.value)' type='number' value='".$q."' style='width:70px;padding:3px;text-align:center'>
				";
			}else{
				return "<b>".$jenjang."</b>";
			}
			
		}else{
			return	$jenjang;
		}
		
	}

	function jabatan($org,$title,$subtitle){
					$this->db->where("LOWER(subbagian)",strtolower($title));
					$this->db->where("LOWER(jabatan)",strtolower($subtitle));
		$tersedia	=	$this->db->get("data_pegawai")->num_rows();
		 
				// $this->db->where("LOWER(org)",strtolower($org));
				// $this->db->where("LOWER(title)",strtolower($title));
				// $this->db->where("LOWER(subtitle)",strtolower($subtitle));
		$db	=	$this->db->get("tm_formasi_org")->row();
		$jenjang = strtoupper($db->subtitle);
		$q	=	$db->kuota;
		if($q){
			if($tersedia<$q){
				return "<b style='color:red'>".$jenjang." (".$tersedia."/".$q.") </b>
				<input onchange='setQuota(`".$db->id."`,this.value)' type='number' value='".$q."' style='width:70px;padding:3px;text-align:center'>
				";
			}else{
				return "<b>".$jenjang."</b>";
			}
			
		}else{
			return	$jenjang;
		}
		
	}
	 
}




