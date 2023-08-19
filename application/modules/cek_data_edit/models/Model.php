<?php

class Model extends CI_Model
{


	function __construct()
	{
		parent::__construct();
	}
	function nip()
	{
		return $this->session->userdata("nip");
	}
	function idu()
	{
		return $this->session->userdata("id");
	}
	function getById($id)
	{
		return $this->db->get_where('data_pegawai', ['id' => $id]);
	}
	function getByNip($id)
	{
		return $this->db->get_where('data_pegawai', ['nip' => $id]);
	}

	/* WILAYAH */
	function getDataKab($idprov)
	{
		$this->db->where("id_prov", $idprov);
		return $this->db->get("kabupaten")->result();
	}
	function getDataKec($idkab)
	{
		$this->db->where("id_kab", $idkab);
		return $this->db->get("kecamatan")->result();
	}
	function getDataKel($idkec)
	{
		$this->db->where("id_kec", $idkec);
		return $this->db->get("kelurahan")->result();
	}

	/* BEGIN::DATAPERSONIL */
	function personil_update()
	{
		$form 	 = $this->input->post("f");
		$id		 = $this->m_reff->san($this->input->post("id"));

		$tgl_lahir = $this->m_reff->san($this->input->post("tgl_lahir"));
		$tgl = $this->tanggal->eng_($tgl_lahir, "-");

		$nip = $this->m_reff->san($this->input->post("nip"));

		$this->db->set($form);


 
		$this->m_reff->direktori_nip($nip);
		if(isset($_FILES["foto"]['tmp_name']))
		{  
			
			$dok=$this->m_reff->pengaturan(1)."dok/".$nip;
			$before_file=$this->m_reff->goField("data_pegawai","foto","where id='".$id."' ");
			$file=$this->m_reff->upload_file("foto",$dok,"foto","jpg,jpeg,png,pdf",$sizeFile="5000000",$before_file);
			if($file["validasi"]!=false)
			{ 	  	 
				$dok = "dok/".$nip;
				$this->db->set("foto",$dok."/".$file['name']);
			}else{
			 $var["gagal"]=true;
			 $var["info"]="terjadi masalah saat upload foto<br>".json_encode($file);
			 return $var;
			}
	 
		} 
		if(isset($_FILES["file_ktp"]['tmp_name']))
		{  
			$dok=$this->m_reff->pengaturan(1)."dok/".$nip;
			$before_file=$this->m_reff->goField("data_pegawai","file_ktp","where id='".$id."' ");
			$file=$this->m_reff->upload_file("file_ktp",$dok,"foto","jpg,jpeg,png,pdf",$sizeFile="5000000",$before_file);
			if($file["validasi"]!=false)
			{ 	  	 $dok = "dok/".$nip;
				$this->db->set("file_ktp",$dok."/".$file['name']);
			}else{
			 $var["gagal"]=true;
			 $var["info"]="terjadi masalah saat upload file ktp<br>".json_encode($file);
			 return $var;
			}
	 
		} 
		if(isset($_FILES["file_buku_rek"]['tmp_name']))
		{  
			$dok=$this->m_reff->pengaturan(1)."dok/".$nip;
			$before_file=$this->m_reff->goField("data_pegawai","file_buku_rek","where id='".$id."' ");
			$file=$this->m_reff->upload_file("file_buku_rek",$dok,"foto","jpg,jpeg,png,pdf",$sizeFile="5000000",$before_file);
			if($file["validasi"]!=false)
			{ 	  	 
				$dok = "dok/".$nip;
				$this->db->set("file_buku_rek",$dok."/".$file['name']);
			}else{
			 $var["gagal"]=true;
			 $var["info"]="terjadi masalah saat upload file buku rekening<br>".json_encode($file);
			 return $var;
			}
	 
		} 
		if(isset($_FILES["file_goldar"]['tmp_name']))
		{  
			$dok=$this->m_reff->pengaturan(1)."dok/".$nip;
			$before_file=$this->m_reff->goField("data_pegawai","file_goldar","where id='".$id."' ");
			$file=$this->m_reff->upload_file("file_goldar",$dok,"foto","jpg,jpeg,png,pdf",$sizeFile="5000000",$before_file);
			if($file["validasi"]!=false)
			{ 	  	 
				$dok = "dok/".$nip;
				$this->db->set("file_goldar",$dok."/".$file['name']);
			}else{
			 $var["gagal"]=true;
			 $var["info"]="terjadi masalah saat upload file ket. Golonga darah<br>".json_encode($file);
			 return $var;
			}
	 
		} 
		if(isset($_FILES["file_surat_nikah"]['tmp_name']))
		{  
			$dok=$this->m_reff->pengaturan(1)."dok/".$nip;
			$before_file=$this->m_reff->goField("data_pegawai","file_surat_nikah","where id='".$id."' ");
			$file=$this->m_reff->upload_file("file_surat_nikah",$dok,"foto","jpg,jpeg,png,pdf",$sizeFile="5000000",$before_file);
			if($file["validasi"]!=false)
			{ 	  	 
				$dok = "dok/".$nip;
				$this->db->set("file_surat_nikah",$dok."/".$file['name']);
			}else{
			 $var["gagal"]=true;
			 $var["info"]="terjadi masalah saat upload file surat nikah<br>".json_encode($file);
			 return $var;
			}
	 
		} 
		if(isset($_FILES["file_npwp"]['tmp_name']))
		{  
			$dok=$this->m_reff->pengaturan(1)."dok/".$nip;
			$before_file=$this->m_reff->goField("data_pegawai","file_npwp","where id='".$id."' ");
			$file=$this->m_reff->upload_file("file_npwp",$dok,"foto","jpg,jpeg,png,pdf",$sizeFile="5000000",$before_file);
			if($file["validasi"]!=false)
			{ 	  	 
				$dok = "dok/".$nip;
				$this->db->set("file_npwp",$dok."/".$file['name']);
			}else{
			 $var["gagal"]=true;
			 $var["info"]="terjadi masalah saat upload file NPWP<br>".json_encode($file);
			 return $var;
			}
		} 
		if(isset($_FILES["file_akta"]['tmp_name']))
		{  
			$dok=$this->m_reff->pengaturan(1)."dok/".$nip;
			$before_file=$this->m_reff->goField("data_pegawai","file_akta","where id='".$id."' ");
			$file=$this->m_reff->upload_file("file_akta",$dok,"foto","jpg,jpeg,png,pdf",$sizeFile="5000000",$before_file);
			if($file["validasi"]!=false)
			{ 	  	 
				$dok = "dok/".$nip;
				$this->db->set("file_akta",$dok."/".$file['name']);
			}else{
			 $var["gagal"]=true;
			 $var["info"]="terjadi masalah saat upload file akta lahir<br>".json_encode($file);
			 return $var;
			}
		} 
		$this->db->set("tgl_lahir", $tgl);
		$this->db->set("updated_at", date('Y-m-d H:i:s'));
		$this->db->where("id", $id);
		$this->db->update("data_pegawai");
		$this->m_reff->log("update data personil");
		$var["token"] = $this->m_reff->getToken();
		return $var;
	}

	function upload_keluarga(){
		// $form 	 = $this->input->post("f");
		$id		 = $this->m_reff->san($this->input->post("id"));

		$nip = $this->m_reff->san($this->input->post("nip"));
		if(isset($_FILES["file_bpjs"]['tmp_name']))
		{  
			$dok=$this->m_reff->pengaturan(1)."dok/".$nip;
			$doksave = "dok/".$nip;
			$before_file=$this->m_reff->goField("data_pegawai","file_bpjs","where id='".$id."' ");
			$file=$this->m_reff->upload_file("file_bpjs",$dok,"file_bpjs","jpg,jpeg,png,pdf",$sizeFile="5000000",$before_file);
			if($file["validasi"]!=false)
			{ 	  	 
				$this->db->set("file_bpjs",$doksave."/".$file['name']);
			}else{
			 $var["gagal"]=true;
			 $var["info"]="terjadi masalah saat upload file BPJS<br>".json_encode($file);
			 return $var;
			}
		}
	 
		if(isset($_FILES["file_kk"]['tmp_name']))
		{  
			$dok=$this->m_reff->pengaturan(1)."dok/".$nip;
			$doksave = "dok/".$nip;
			$before_file=$this->m_reff->goField("data_pegawai","file_kk","where id='".$id."' ");
			$file=$this->m_reff->upload_file("file_kk",$dok,"file_kk","jpg,jpeg,png,pdf",$sizeFile="5000000",$before_file);
			if($file["validasi"]!=false)
			{ 	  	 
				$this->db->set("file_kk",$doksave."/".$file['name']);
			}else{
			 $var["gagal"]=true;
			 $var["info"]="terjadi masalah saat upload file KK <br>".json_encode($file);
			 return $var;
			}
	 
		} 



  
		$this->db->set("updated_at", date('Y-m-d H:i:s'));
		$this->db->where("nip", $nip);
		$this->db->update("data_pegawai");
		$this->m_reff->log("update file keluarga");
		$var["token"] = $this->m_reff->getToken();
		return $var;
	}
	/* BEGIN::DATAPEGAWAI */
	function pegawai_update()
	{
		$form 	 = $this->input->post("f");
		if(!$form){	return false;	}

		$id	 = $this->m_reff->san($this->input->post("id"));
		$tmt = $this->m_reff->san($this->input->post("tmt"));
		$tgl = $this->tanggal->eng_($tmt, "-");

		$nip = $this->m_reff->san($this->input->post("nip"));
		if(isset($_FILES["file_penetapan_nip"]['tmp_name']))
		{  
			$dok=$this->m_reff->pengaturan(1)."dok/".$nip;
			$doksave = "dok/".$nip;
			$before_file=$this->m_reff->goField("data_pegawai","file_nip","where id='".$id."' ");
			$file=$this->m_reff->upload_file("file_penetapan_nip",$dok,"file_nip","jpg,jpeg,png,pdf",$sizeFile="5000000",$before_file);
			if($file["validasi"]!=false)
			{ 	  	 
				$this->db->set("file_nip",$doksave."/".$file['name']);
			}else{
			 $var["gagal"]=true;
			 $var["info"]="terjadi masalah saat upload file penetapan NIP<br>".json_encode($file);
			 return $var;
			}
		}
	 
		if(isset($_FILES["file_karpeg"]['tmp_name']))
		{  
			$dok=$this->m_reff->pengaturan(1)."dok/".$nip;
			$doksave = "dok/".$nip;
			$before_file=$this->m_reff->goField("data_pegawai","file_karpeg","where id='".$id."' ");
			$file=$this->m_reff->upload_file("file_karpeg",$dok,"file_karpeg","jpg,jpeg,png,pdf",$sizeFile="5000000",$before_file);
			if($file["validasi"]!=false)
			{ 	  	 
				$this->db->set("file_karpeg",$doksave."/".$file['name']);
			}else{
			 $var["gagal"]=true;
			 $var["info"]="terjadi masalah saat upload file Karpeg <br>".json_encode($file);
			 return $var;
			}
	 
		} 



		$this->db->set($form);
		$this->db->set("tmt", $tgl);
		// $this->db->set("tmt_setpres", $tgl);
		$this->db->set("updated_at", date('Y-m-d H:i:s'));
		$this->db->where("id", $id);
		$this->db->update("data_pegawai");
		$this->m_reff->log("update data personil");
		$var["token"] = $this->m_reff->getToken();
		return $var;
	}

	/* BEGIN::DATAKELUARGA */
	function getKeluargaByNip($id)
	{
		return $this->db->get_where('data_keluarga', ['nip_pegawai' => $id]);
	}
	function getKeluargaById($id)
	{
		return $this->db->get_where('data_keluarga', ['id' => $id]);
	}
	function keluarga_insert()
	{
		$form 	 = $this->input->post("f");
		if(!$form){	return false;	}
		//$id		 = $this->input->post("id");

		$tgl_lahir = $this->m_reff->san($this->input->post("tgl_lahir"));
		$tgl = $this->tanggal->eng_($tgl_lahir, "-");

		$this->db->set($form);
		$this->db->set("tgl_lahir", $tgl);
		$this->db->insert("data_keluarga");
		$this->m_reff->log("insert data keluarga");
		$var["token"] = $this->m_reff->getToken();
		return $var;
	}
	function keluarga_update()
	{
		$form 	 = $this->input->post("f");
		if(!$form){	return false;	}
		//$id		 = $this->input->post("id");
		$id_a	= $this->m_reff->san($this->input->post("id_a"));

		$tgl_lahir = $this->m_reff->san($this->input->post("tgl_lahir"));
		$tgl = $this->tanggal->eng_($tgl_lahir, "-");

		$this->db->set($form);
		$this->db->set("tgl_lahir", $tgl);
		$this->db->where("id", $id_a);
		$this->db->update("data_keluarga");
		$this->m_reff->log("update data keluarga");
		$var["token"] = $this->m_reff->getToken();
		return $var;
	}
	function keluarga_destroy()
	{
		//$form 	 = $this->input->post("f");
		//$id		 = $this->input->post("id");
		$id_a	= $this->m_reff->san($this->input->post("id_a"));

		$this->db->where("id", $id_a);
		return    $this->db->delete("data_keluarga");

		$this->m_reff->log("delete data keluarga");
		// $var["token"] = $this->m_reff->getToken();
		// return $var;
	}


	/* BEGIN::DATADOMISILI */
	function getDomisiliByNip($id)
	{
		return $this->db->get_where('tm_domisili', ['nip_pegawai' => $id]);
	}
	function getDomisiliById($id)
	{
		return $this->db->get_where('tm_domisili', ['id' => $id]);
	}
	function domisili_insert()
	{
		$form 	 = $this->input->post("f");
		if(!$form){	return false;	}
		//$id		 = $this->input->post("id");

		$this->db->set($form);
		$this->db->insert("tm_domisili");
		$this->m_reff->log("insert data domisili");
		$var["token"] = $this->m_reff->getToken();
		return $var;
	}
	function domisili_update()
	{
		$form 	 = $this->input->post("f");
		if(!$form){	return false;	}
		//$id		 = $this->input->post("id");
		$id_a	= $this->m_reff->san($this->input->post("id_a"));

		$this->db->set($form);
		$this->db->where("id", $id_a);
		$this->db->update("tm_domisili");
		$this->m_reff->log("update data domisili");
		$var["token"] = $this->m_reff->getToken();
		return $var;
	}
	function domisili_destroy()
	{	$this->m_reff->log("delete data domisili","data");
		//$form 	 = $this->input->post("f");
		//$id		 = $this->input->post("id");
		$id_a	= $this->m_reff->san($this->input->post("id_a"));

		$this->db->where("id", $id_a);
		return    $this->db->delete("tm_domisili");

		
		// $var["token"] = $this->m_reff->getToken();
		// return $var;
	}
	function defaultdomisili()
	{
		$id_a	= $this->m_reff->san($this->input->post("id_a"));
		$update1=$this->db->set("sts", "0");
		$update1=$this->db->update("tm_domisili");


		$id_a	= $this->m_reff->san($this->input->post("id_a"));
		$update1=$this->db->set("sts", "1");
		$update1=$this->db->where("id", $id_a);
		$update1=$this->db->update("tm_domisili");

		if($update1){
			$h = $this->getDomisiliById($id_a)->row();
			$nip_pegawai = $h->nip_pegawai ?? '';
			$id_prov = $h->id_prov ?? '';
			$id_kab = $h->id_kab ?? '';
			$id_kec = $h->id_kec ?? '';
			$id_kel = $h->id_kel ?? '';
			$alamat = $h->alamat ?? '';
			$sts_hunian = $h->sts_hunian ?? '';

			$this->db->set("id_prov", $id_prov);
			$this->db->set("id_kab", $id_kab);
			$this->db->set("id_kab", $id_kab);
			$this->db->set("id_kec", $id_kec);
			$this->db->set("id_kel", $id_kel);
			$this->db->set("alamat", $alamat);
			$this->db->set("sts_hunian", $sts_hunian);
			$this->db->where("nip", $nip_pegawai);
			$this->db->update("data_pegawai");
		}
		


		$this->m_reff->log("set default domisili");
		$var["token"] = $this->m_reff->getToken();
		return $var;
	}


	/* BEGIN::DATAGOLONGAN */
	function getGolonganByNip($id)
	{
		return $this->db->get_where('tm_golongan', ['nip_pegawai' => $id]);
	}
	function getGolonganById($id)
	{
		return $this->db->get_where('tm_golongan', ['id' => $id]);
	}
	function golongan_insert()
	{
		$form 	 = $this->input->post("f");
		if(!$form){	return false;	}
		//$id		 = $this->input->post("id");

		$tgltmt = $this->m_reff->san($this->input->post("tmt"));
		$tmt = $this->tanggal->eng_($tgltmt, "-");

		$tglsk = $this->m_reff->san($this->input->post("tgl_sk"));
		$tgl_sk = $this->tanggal->eng_($tglsk, "-");

		$mkerja = $this->m_reff->san($this->input->post("masa_kerja"));
		$masa_kerja = $this->tanggal->eng_($mkerja, "-");

		$nip = $this->m_reff->san($this->input->post("f[nip_pegawai]"));
		if(isset($_FILES["file"]['tmp_name']))
		{  
			$dok=$this->m_reff->pengaturan(1)."dok/".$nip;
			$doksave = "dok/".$nip;
			$before_file=$this->m_reff->goField("tm_golongan","file","where nip_pegawai='".$nip."' ");
			$file=$this->m_reff->upload_file("file",$dok,"file_nip","jpg,jpeg,png,pdf",$sizeFile="5000000",$before_file);
			if($file["validasi"]!=false)
			{ 	  	 
				$this->db->set("file",$doksave."/".$file['name']);
			}else{
			 $var["gagal"]=true;
			 $var["info"]="terjadi masalah saat upload file <br>".json_encode($file);
			 return $var;
			}
		}
	 


		$this->db->set($form);
		$this->db->set("tmt", $tmt);
		$this->db->set("tgl_sk", $tgl_sk);
		$this->db->set("masa_kerja", $masa_kerja);
		$this->db->insert("tm_golongan");
		$this->m_reff->log("insert data golongan Nip:".$nip);
		$var["token"] = $this->m_reff->getToken();
		return $var;
	}
	function golongan_update()
	{
		$form 	 = $this->input->post("f");
		if(!$form){	return false;	}
		//$id		 = $this->input->post("id");
		$id_a	= $this->m_reff->san($this->input->post("id_a"));

		$tgltmt = $this->m_reff->san($this->input->post("tmt"));
		$tmt = $this->tanggal->eng_($tgltmt, "-");

		$tglsk = $this->m_reff->san($this->input->post("tgl_sk"));
		$tgl_sk = $this->tanggal->eng_($tglsk, "-");

		$mkerja = $this->m_reff->san($this->input->post("masa_kerja"));
		$masa_kerja = $this->tanggal->eng_($mkerja, "-");
		$nip = $this->m_reff->san($this->input->post("f[nip_pegawai]"));
		if(isset($_FILES["file"]['tmp_name']))
		{  
			$dok=$this->m_reff->pengaturan(1)."dok/".$nip;
			$doksave = "dok/".$nip;
			$before_file=$this->m_reff->goField("tm_golongan","file","where nip_pegawai='".$nip."' ");
			$file=$this->m_reff->upload_file("file",$dok,"file_nip","jpg,jpeg,png,pdf",$sizeFile="5000000",$before_file);
			if($file["validasi"]!=false)
			{ 	  	 
				$this->db->set("file",$doksave."/".$file['name']);
			}else{
			 $var["gagal"]=true;
			 $var["info"]="terjadi masalah saat upload file <br>".json_encode($file);
			 return $var;
			}
		}
	 
		$this->db->set($form);
		$this->db->set("tmt", $tmt);
		$this->db->set("tgl_sk", $tgl_sk);
		$this->db->set("masa_kerja", $masa_kerja);
		$this->db->where("id", $id_a);
		$this->db->update("tm_golongan");
		$this->m_reff->log("update data golongan");
		$var["token"] = $this->m_reff->getToken();
		return $var;
	}
	function golongan_destroy()
	{
		//$form 	 = $this->input->post("f");
		//$id		 = $this->input->post("id");
		$id_a	= $this->m_reff->san($this->input->post("id_a"));

		$this->db->where("id", $id_a);
		return    $this->db->delete("tm_golongan");

		$this->m_reff->log("delete data golongan");
		// $var["token"] = $this->m_reff->getToken();
		// return $var;
	}


	/* BEGIN::DATAJABATAN */
	function getJabatanByNip($id)
	{
		return $this->db->get_where('tm_jabatan', ['nip_pegawai' => $id]);
	}
	function getJabatanById($id)
	{
		return $this->db->get_where('tm_jabatan', ['id' => $id]);
	}
	function jabatan_insert()
	{
		$form 	 = $this->input->post("f");
		if(!$form){	return false;	}
		//$id		 = $this->input->post("id");

		$tgltmt = $this->m_reff->san($this->input->post("tmt"));
		$tmt = $this->tanggal->eng_($tgltmt, "-");

		$tglskjab = $this->m_reff->san($this->input->post("tgl_sk_jabatan"));
		$tgl_sk_jabatan = $this->tanggal->eng_($tglskjab, "-");

		$tglskes = $this->m_reff->san($this->input->post("tgl_sk_eselon"));
		$tgl_sk_eselon = $this->tanggal->eng_($tglskes, "-");

		$this->db->set($form);
		$this->db->set("tmt", $tmt);
		$this->db->set("tgl_sk_jabatan", $tgl_sk_jabatan);
		$this->db->set("tgl_sk_eselon", $tgl_sk_eselon);
		$this->db->insert("tm_jabatan");
		$this->m_reff->log("insert data jabatan");
		$var["token"] = $this->m_reff->getToken();
		return $var;
	}
	function jabatan_update()
	{
		$form 	 = $this->input->post("f");
		if(!$form){	return false;	}
		//$id		 = $this->input->post("id");
		$id_a	= $this->m_reff->san($this->input->post("id_a"));

		$tgltmt = $this->m_reff->san($this->input->post("tmt"));
		$tmt = $this->tanggal->eng_($tgltmt, "-");

		$tglskjab = $this->m_reff->san($this->input->post("tgl_sk_jabatan"));
		$tgl_sk_jabatan = $this->tanggal->eng_($tglskjab, "-");

		$tglskes = $this->m_reff->san($this->input->post("tgl_sk_eselon"));
		$tgl_sk_eselon = $this->tanggal->eng_($tglskes, "-");

		$this->db->set($form);
		$this->db->set("tmt", $tmt);
		$this->db->set("tgl_sk_jabatan", $tgl_sk_jabatan);
		$this->db->set("tgl_sk_eselon", $tgl_sk_eselon);
		$this->db->where("id", $id_a);
		$this->db->update("tm_jabatan");
		$this->m_reff->log("update data jabatan");
		$var["token"] = $this->m_reff->getToken();
		return $var;
	}
	function jabatan_destroy()
	{
		//$form 	 = $this->input->post("f");
		//$id		 = $this->input->post("id");
		$id_a	= $this->m_reff->san($this->input->post("id_a"));

		$this->db->where("id", $id_a);
		return    $this->db->delete("tm_jabatan");

		$this->m_reff->log("delete data jabatan");
		// $var["token"] = $this->m_reff->getToken();
		// return $var;
	}

	/* BEGIN::DATAPENUGASAN */
	function getPenugasanByNip($id)
	{
		return $this->db->get_where('tm_penugasan', ['nip_pegawai' => $id]);
	}
	function getPenugasanById($id)
	{
		return $this->db->get_where('tm_penugasan', ['id' => $id]);
	}
	function penugasan_insert()
	{
		$form 	 = $this->input->post("f");
		if(!$form){	return false;	}
		//$id		 = $this->input->post("id");

		$tgltmt = $this->m_reff->san($this->input->post("tmt"));
		$tmt = $this->tanggal->eng_($tgltmt, "-");

		$tglsk = $this->m_reff->san($this->input->post("tgl_sk"));
		$tgl_sk = $this->tanggal->eng_($tglsk, "-");

		$masku = $this->m_reff->san($this->input->post("masa_berlaku"));
		$masa_berlaku = $this->tanggal->eng_($masku, "-");

		$this->db->set($form);
		$this->db->set("tmt", $tmt);
		$this->db->set("tgl_sk", $tgl_sk);
		$this->db->set("masa_berlaku", $masa_berlaku);
		$this->db->insert("tm_penugasan");
		$this->m_reff->log("insert data penugasan");
		$var["token"] = $this->m_reff->getToken();
		return $var;
	}
	function penugasan_update()
	{
		$form 	 = $this->input->post("f");
		if(!$form){	return false;	}
		//$id		 = $this->input->post("id");
		$id_a	= $this->m_reff->san($this->input->post("id_a"));

		$tgltmt = $this->m_reff->san($this->input->post("tmt"));
		$tmt = $this->tanggal->eng_($tgltmt, "-");

		$tglsk = $this->m_reff->san($this->input->post("tgl_sk"));
		$tgl_sk = $this->tanggal->eng_($tglsk, "-");

		$masku = $this->m_reff->san($this->input->post("masa_berlaku"));
		$masa_berlaku = $this->tanggal->eng_($masku, "-");

		$this->db->set($form);
		$this->db->set("tmt", $tmt);
		$this->db->set("tgl_sk", $tgl_sk);
		$this->db->set("masa_berlaku", $masa_berlaku);
		$this->db->where("id", $id_a);
		$this->db->update("tm_penugasan");
		$this->m_reff->log("update data penugasan");
		$var["token"] = $this->m_reff->getToken();
		return $var;
	}
	function penugasan_destroy()
	{	$this->m_reff->log("delete data penugasan");
		//$form 	 = $this->input->post("f");
		//$id		 = $this->input->post("id");
		$id_a	= $this->m_reff->san($this->input->post("id_a"));

		$this->db->where("id", $id_a);
		return    $this->db->delete("tm_penugasan");

		
		// $var["token"] = $this->m_reff->getToken();
		// return $var;
	}


	/* BEGIN::DATAPENDIDIKAN */
	function getPendidikanByNip($id)
	{
		return $this->db->get_where('tm_pendidikan', ['nip_pegawai' => $id]);
	}
	function getPendidikanById($id)
	{
		return $this->db->get_where('tm_pendidikan', ['id' => $id]);
	}
	function pendidikan_insert()
	{
		$form 	 = $this->input->post("f");
		if(!$form){	return false;	}
		//$id		 = $this->input->post("id");
		$nip = $this->m_reff->san($this->input->post("f[nip_pegawai]"));
		if(isset($_FILES["file_ijazah"]['tmp_name']))
		{  
			$dok=$this->m_reff->pengaturan(1)."dok/".$nip;
			$doksave = "dok/".$nip;
			$before_file=$this->m_reff->goField("tm_pendidikan","file_ijazah","where nip_pegawai='".$nip."' ");
			$file=$this->m_reff->upload_file("file_ijazah",$dok,"file_ijazah","jpg,jpeg,png,pdf",$sizeFile="5000000",$before_file);
			if($file["validasi"]!=false)
			{ 	  	 
				$this->db->set("file_ijazah",$doksave."/".$file['name']);
			}else{
			 $var["gagal"]=true;
			 $var["info"]="terjadi masalah saat upload file <br>".json_encode($file);
			 return $var;
			}
		}

		$this->db->set($form);
		$this->db->insert("tm_pendidikan");
		$this->m_reff->log("insert data pendidikan");
		$var["token"] = $this->m_reff->getToken();
		return $var;
	}
	function pendidikan_update()
	{
		$form 	 = $this->input->post("f");
		if(!$form){	return false;	}
		//$id		 = $this->m_reff->san($this->input->post("id"));
		$id_a	= $this->m_reff->san($this->input->post("id_a"));
		$nip = $this->m_reff->san($this->input->post("f[nip_pegawai]"));
		if(isset($_FILES["file_ijazah"]['tmp_name']))
		{  
			$dok=$this->m_reff->pengaturan(1)."dok/".$nip;
			$doksave = "dok/".$nip;
			$before_file=$this->m_reff->goField("tm_pendidikan","file_ijazah","where nip_pegawai='".$nip."' ");
			$file=$this->m_reff->upload_file("file_ijazah",$dok,"file_ijazah","jpg,jpeg,png,pdf",$sizeFile="5000000",$before_file);
			if($file["validasi"]!=false)
			{ 	  	 
				$this->db->set("file_ijazah",$doksave."/".$file['name']);
			}else{
			 $var["gagal"]=true;
			 $var["info"]="terjadi masalah saat upload file <br>".json_encode($file);
			 return $var;
			}
		}

		$this->db->set($form);
		$this->db->where("id", $id_a);
		$this->db->update("tm_pendidikan");
		$this->m_reff->log("update data pendidikan");
		$var["token"] = $this->m_reff->getToken();
		return $var;
	}
	function pendidikan_destroy()
	{
		//$form 	 = $this->input->post("f");
		//$id		 = $this->input->post("id");
		$id_a	= $this->m_reff->san($this->input->post("id_a"));

		$this->db->where("id", $id_a);
		return    $this->db->delete("tm_pendidikan");

		$this->m_reff->log("delete data pendidikan");
		// $var["token"] = $this->m_reff->getToken();
		// return $var;
	}


	/* BEGIN::DATAPENGHARGAAN */
	function getPenghargaanByNip($id)
	{
		return $this->db->get_where('tm_penghargaan', ['nip_pegawai' => $id]);
	}
	function getPenghargaanById($id)
	{
		return $this->db->get_where('tm_penghargaan', ['id' => $id]);
	}
	function penghargaan_insert()
	{
		$form 	 = $this->input->post("f");
		if(!$form){	return false;	}
		//$id		 = $this->input->post("id");

		$tgl_ = $this->m_reff->san($this->input->post("tgl"));
		$tgl = $this->tanggal->eng_($tgl_, "-");
		$nip = $this->m_reff->san($this->input->post("f[nip_pegawai]"));
		if(isset($_FILES["file"]['tmp_name']))
		{  
			$dok=$this->m_reff->pengaturan(1)."dok/".$nip;
			$doksave = "dok/".$nip;
			$before_file=$this->m_reff->goField("tm_penghargaan","file","where nip_pegawai='".$nip."' ");
			$file=$this->m_reff->upload_file("file",$dok,"file_penghargan","jpg,jpeg,png,pdf",$sizeFile="5000000",$before_file);
			if($file["validasi"]!=false)
			{ 	  	 
				$this->db->set("file",$doksave."/".$file['name']);
			}else{
			 $var["gagal"]=true;
			 $var["info"]="terjadi masalah saat upload file <br>".json_encode($file);
			 return $var;
			}
		}
		$this->db->set($form);
		$this->db->set("tgl", $tgl);
		$this->db->insert("tm_penghargaan");
		$this->m_reff->log("insert data penghargaan");
		$var["token"] = $this->m_reff->getToken();
		return $var;
	}
	function penghargaan_update()
	{
		$form 	 = $this->input->post("f");
		if(!$form){	return false;	}
		//$id		 = $this->input->post("id");
		$id_a	= $this->m_reff->san($this->input->post("id_a"));

		$tgl_ = $this->m_reff->san($this->input->post("tgl"));
		$tgl = $this->tanggal->eng_($tgl_, "-");
		$nip = $this->m_reff->san($this->input->post("f[nip_pegawai]"));
		if(isset($_FILES["file"]['tmp_name']))
		{  
			$dok=$this->m_reff->pengaturan(1)."dok/".$nip;
			$doksave = "dok/".$nip;
			$before_file=$this->m_reff->goField("tm_penghargaan","file","where nip_pegawai='".$nip."' ");
			$file=$this->m_reff->upload_file("file",$dok,"file_penghargan","jpg,jpeg,png,pdf",$sizeFile="5000000",$before_file);
			if($file["validasi"]!=false)
			{ 	  	 
				$this->db->set("file",$doksave."/".$file['name']);
			}else{
			 $var["gagal"]=true;
			 $var["info"]="terjadi masalah saat upload file <br>".json_encode($file);
			 return $var;
			}
		}
		$this->db->set($form);
		$this->db->set("tgl", $tgl);
		$this->db->where("id", $id_a);
		$this->db->update("tm_penghargaan");
		$this->m_reff->log("update data penghargaan");
		$var["token"] = $this->m_reff->getToken();
		return $var;
	}
	function penghargaan_destroy()
	{
		//$form 	 = $this->input->post("f");
		//$id		 = $this->input->post("id");
		$id_a	= $this->m_reff->san($this->input->post("id_a"));

		$this->db->where("id", $id_a);
		return    $this->db->delete("tm_penghargaan");

		$this->m_reff->log("delete data penghargaan");
		// $var["token"] = $this->m_reff->getToken();
		// return $var;
	}


	/* BEGIN::DATAPENILAIANKINERJA */
	function getPenilaianKinerjaByNip($id)
	{
		return $this->db->get_where('tm_penilaian_kinerja', ['nip_pegawai' => $id]);
	}
	function getPenilaiankinerjaById($id)
	{
		return $this->db->get_where('tm_penilaian_kinerja', ['id' => $id]);
	}
	function penilaiankinerja_insert()
	{
		$form 	 = $this->input->post("f");
		if(!$form){	return false;	}
		//$id		 = $this->input->post("id");
		$nip = $this->m_reff->san($this->input->post("f[nip_pegawai]"));
		if(isset($_FILES["file"]['tmp_name']))
		{  
			$dok=$this->m_reff->pengaturan(1)."dok/".$nip;
			$doksave = "dok/".$nip;
			$before_file=$this->m_reff->goField("tm_penilaian_kinerja","file","where nip_pegawai='".$nip."' ");
			$file=$this->m_reff->upload_file("file",$dok,"file","jpg,jpeg,png,pdf",$sizeFile="5000000",$before_file);
			if($file["validasi"]!=false)
			{ 	  	 
				$this->db->set("file",$doksave."/".$file['name']);
			}else{
			 $var["gagal"]=true;
			 $var["info"]="terjadi masalah saat upload file <br>".json_encode($file);
			 return $var;
			}
		}

		$this->db->set($form);
		$this->db->insert("tm_penilaian_kinerja");
		$this->m_reff->log("insert data penilaian kinerja");
		$var["token"] = $this->m_reff->getToken();
		return $var;
	}
	function penilaiankinerja_update()
	{
		$form 	 = $this->input->post("f");
		if(!$form){	return false;	}
		//$id		 = $this->input->post("id");
		$id_a	= $this->m_reff->san($this->input->post("id_a"));

		$this->db->set($form);
		$this->db->where("id", $id_a);
		$this->db->update("tm_penilaian_kinerja");
		$this->m_reff->log("update data penilaian kinerja");
		$var["token"] = $this->m_reff->getToken();
		return $var;
	}
	function penilaiankinerja_destroy()
	{	$this->m_reff->log("delete data penilaian kinerja","data");
		//$form 	 = $this->input->post("f");
		//$id		 = $this->input->post("id");
		$id_a	= $this->m_reff->san($this->input->post("id_a"));

		$this->db->where("id", $id_a);
		return    $this->db->delete("tm_penilaian_kinerja");

		
		// $var["token"] = $this->m_reff->getToken();
		// return $var;
	}


	/* BEGIN::DATAMEDIS */
	function getMedisByNip($id)
	{
		return $this->db->get_where('tm_medis', ['nip_pegawai' => $id]);
	}
	function getMedisById($id)
	{
		return $this->db->get_where('tm_medis', ['id' => $id]);
	}
	function medis_insert()
	{
		$form 	 = $this->input->post("f");
		if(!$form){	return false;	}
		//$id		 = $this->input->post("id");


		$nip = $this->m_reff->san($this->input->post("f[nip_pegawai]"));
		if(isset($_FILES["file_hasil_mcu"]['tmp_name']))
		{  
			$dok=$this->m_reff->pengaturan(1)."dok/".$nip;
			$doksave = "dok/".$nip;
			$before_file=$this->m_reff->goField("tm_medis","file_mcu","where nip_pegawai='".$nip."' ");
			$file=$this->m_reff->upload_file("file_hasil_mcu",$dok,"file_mcu","jpg,jpeg,png,pdf",$sizeFile="5000000",$before_file);
			if($file["validasi"]!=false)
			{ 	  	 
				$this->db->set("file_mcu",$doksave."/".$file['name']);
			}else{
			 $var["gagal"]=true;
			 $var["info"]="terjadi masalah saat upload file <br>".json_encode($file);
			 return $var;
			}
		}



		$tgl = $this->tanggal->eng_($this->input->post("tgl_mcu"),"-");
		$this->db->set("tgl_mcu",$tgl);
		$this->db->set($form);
		$this->db->insert("tm_medis");
		$this->m_reff->log("insert data penilaian kinerja");
		$var["token"] = $this->m_reff->getToken();
		return $var;
	}
	function medis_update()
	{
		$form 	 = $this->input->post("f");
		if(!$form){	return false;	}
		//$id		 = $this->input->post("id");
		$id_a	= $this->m_reff->san($this->input->post("id_a"));

		
		$nip = $this->m_reff->san($this->input->post("f[nip_pegawai]"));
		if(isset($_FILES["file_hasil_mcu"]['tmp_name']))
		{  
			$dok=$this->m_reff->pengaturan(1)."dok/".$nip;
			$doksave = "dok/".$nip;
			$before_file=$this->m_reff->goField("tm_medis","file_mcu","where nip_pegawai='".$nip."' ");
			$file=$this->m_reff->upload_file("file_hasil_mcu",$dok,"file_mcu","jpg,jpeg,png,pdf",$sizeFile="5000000",$before_file);
			if($file["validasi"]!=false)
			{ 	  	 
				$this->db->set("file_mcu",$doksave."/".$file['name']);
			}else{
			 $var["gagal"]=true;
			 $var["info"]="terjadi masalah saat upload file <br>".json_encode($file);
			 return $var;
			}
		}



		$tgl = $this->tanggal->eng_($this->input->post("tgl_mcu"),"-");
		$this->db->set("tgl_mcu",$tgl);

		$this->db->set($form);
		$this->db->where("id", $id_a);
		$this->db->update("tm_medis");
		$this->m_reff->log("update data medis");
		$var["token"] = $this->m_reff->getToken();
		return $var;
	}
	function medis_destroy()
	{
		//$form 	 = $this->input->post("f");
		//$id		 = $this->input->post("id");
		$id_a	= $this->m_reff->san($this->input->post("id_a"));

		$this->db->where("id", $id_a);
		return    $this->db->delete("tm_medis");

		$this->m_reff->log("delete data penilaian kinerja");
		// $var["token"] = $this->m_reff->getToken();
		// return $var;
	}


	/* BEGIN::DATAGAJI */
	function getGajiByNip($id)
	{
		return $this->db->get_where('tm_gaji', ['nip_pegawai' => $id]);
	}
	function getGajiById($id)
	{
		return $this->db->get_where('tm_gaji', ['id' => $id]);
	}
	function gaji_insert()
	{
		$form 	 = $this->input->post("f");
		if(!$form){	return false;	}
		//$id		 = $this->input->post("id");

		$tmt_ = $this->m_reff->san($this->input->post("tmt"));
		$tmt = $this->tanggal->eng_($tmt_, "-");

		$this->db->set($form);
		$this->db->set("tmt", $tmt);
		$this->db->insert("tm_gaji");
		$this->m_reff->log("insert data gaji");
		$var["token"] = $this->m_reff->getToken();
		return $var;
	}
	function gaji_update()
	{
		$form 	 = $this->input->post("f");
		if(!$form){	return false;	}
		//$id		 = $this->input->post("id");
		$id_a	= $this->m_reff->san($this->input->post("id_a"));

		$tmt_ = $this->m_reff->san($this->input->post("tmt"));
		$tmt = $this->tanggal->eng_($tmt_, "-");

		$this->db->set($form);
		$this->db->set("tmt", $tmt);
		$this->db->where("id", $id_a);
		$this->db->update("tm_gaji");
		$this->m_reff->log("update data gaji");
		$var["token"] = $this->m_reff->getToken();
		return $var;
	}
	function gaji_destroy()
	{
		//$form 	 = $this->input->post("f");
		//$id		 = $this->input->post("id");
		$id_a	= $this->m_reff->san($this->input->post("id_a"));

		$this->db->where("id", $id_a);
		return    $this->db->delete("tm_gaji");

		$this->m_reff->log("delete data gaji");
		// $var["token"] = $this->m_reff->getToken();
		// return $var;
	}


	/* BEGIN::DATAHUKUMAN */
	function getHukumanByNip($id)
	{
		return $this->db->get_where('tm_hukuman', ['nip_pegawai' => $id]);
	}
	function getHukumanById($id)
	{
		return $this->db->get_where('tm_hukuman', ['id' => $id]);
	}
	function hukuman_insert()
	{
		$form 	 = $this->input->post("f");
		if(!$form){	return false;	}
		//$id		 = $this->input->post("id");

		$tmt_ = $this->m_reff->san($this->input->post("tmt_akhir"));
		$tmt_akhir = $this->tanggal->eng_($tmt_, "-");

		$masa_berlaku_ = $this->m_reff->san($this->input->post("masa_berlaku"));
		$masa_berlaku = $this->tanggal->eng_($masa_berlaku_, "-");
		$nip = $this->m_reff->san($this->input->post("f[nip_pegawai]"));
		if(isset($_FILES["file"]['tmp_name']))
		{  
			$dok=$this->m_reff->pengaturan(1)."dok/".$nip;
			$doksave = "dok/".$nip;
			$before_file=$this->m_reff->goField("tm_hukuman","file","where nip_pegawai='".$nip."' ");
			$file=$this->m_reff->upload_file("file",$dok,"hukuman","jpg,jpeg,png,pdf",$sizeFile="5000000",$before_file);
			if($file["validasi"]!=false)
			{ 	  	 
				$this->db->set("file",$doksave."/".$file['name']);
			}else{
			 $var["gagal"]=true;
			 $var["info"]="terjadi masalah saat upload file <br>".json_encode($file);
			 return $var;
			}
		}
		$this->db->set($form);
		$this->db->set("tmt_akhir", $tmt_akhir);
		$this->db->set("masa_berlaku", $masa_berlaku);
		$this->db->insert("tm_hukuman");
		$this->m_reff->log("insert data hukuman");
		$var["token"] = $this->m_reff->getToken();
		return $var;
	}
	function hukuman_update()
	{
		$form 	 = $this->input->post("f");
		if(!$form){	return false;	}
		//$id		 = $this->input->post("id");
		$id_a	= $this->m_reff->san($this->input->post("id_a"));

		$tmt_ = $this->m_reff->san($this->input->post("tmt_akhir"));
		$tmt_akhir = $this->tanggal->eng_($tmt_, "-");

		$masa_berlaku_ = $this->m_reff->san($this->input->post("masa_berlaku"));
		$masa_berlaku = $this->tanggal->eng_($masa_berlaku_, "-");
		$nip = $this->m_reff->san($this->input->post("f[nip_pegawai]"));
		if(isset($_FILES["file"]['tmp_name']))
		{  
			$dok=$this->m_reff->pengaturan(1)."dok/".$nip;
			$doksave = "dok/".$nip;
			$before_file=$this->m_reff->goField("tm_hukuman","file","where nip_pegawai='".$nip."' ");
			$file=$this->m_reff->upload_file("file",$dok,"hukuman","jpg,jpeg,png,pdf",$sizeFile="5000000",$before_file);
			if($file["validasi"]!=false)
			{ 	  	 
				$this->db->set("file",$doksave."/".$file['name']);
			}else{
			 $var["gagal"]=true;
			 $var["info"]="terjadi masalah saat upload file <br>".json_encode($file);
			 return $var;
			}
		}
		$this->db->set($form);
		$this->db->set("tmt_akhir", $tmt_akhir);
		$this->db->set("masa_berlaku", $masa_berlaku);
		$this->db->where("id", $id_a);
		$this->db->update("tm_hukuman");
		$this->m_reff->log("update data hukuman");
		$var["token"] = $this->m_reff->getToken();
		return $var;
	}
	function hukuman_destroy()
	{
		//$form 	 = $this->input->post("f");
		//$id		 = $this->input->post("id");
		$id_a	= $this->m_reff->san($this->input->post("id_a"));

		$this->db->where("id", $id_a);
		return    $this->db->delete("tm_hukuman");

		$this->m_reff->log("delete data hukuman");
		// $var["token"] = $this->m_reff->getToken();
		// return $var;
	}

	/* BEGIN::DATAVAKSINASI */
	function getVaksinasiByNip($id)
	{
		return $this->db->get_where('tm_vaksin', ['nip_pegawai' => $id]);
	}
	function getVaksinasiById($id)
	{
		return $this->db->get_where('tm_vaksin', ['id' => $id]);
	}
	function vaksinasi_insert()
	{
		$form 	 = $this->input->post("f");
		if(!$form){	return false;	}
		$this->m_reff->log("insert data vaksin","data");

		$tgl_ = $this->m_reff->san($this->input->post("tgl_vaksin"));
		$tgl_vaksin = $this->tanggal->eng_($tgl_, "-");

		$this->db->set($form);
		$this->db->set("tgl_vaksin", $tgl_vaksin);
		$this->db->insert("tm_vaksin");
		$this->m_reff->log("insert data vaksinasi");
		$var["token"] = $this->m_reff->getToken();
		return $var;
	}
	function vaksinasi_update()
	{
		$form 	 = $this->input->post("f");
		if(!$form){	return false;	}
		$this->m_reff->log("update data vaksin","data");

		$id_a	= $this->m_reff->san($this->input->post("id_a"));

		$tgl_ = $this->m_reff->san($this->input->post("tgl_vaksin"));
		$tgl_vaksin = $this->tanggal->eng_($tgl_, "-");

		$this->db->set($form);
		$this->db->set("tgl_vaksin", $tgl_vaksin);
		$this->db->where("id", $id_a);
		$this->db->update("tm_vaksin");
		$this->m_reff->log("update data vaksinasi");
		$var["token"] = $this->m_reff->getToken();
		return $var;
	}
	function vaksinasi_destroy()
	{
		//$form 	 = $this->input->post("f");
		//$id		 = $this->input->post("id");
		$id_a	= $this->m_reff->san($this->input->post("id_a"));

		$this->db->where("id", $id_a);
		return    $this->db->delete("tm_vaksin");

		$this->m_reff->log("delete data vaksinasi");
		// $var["token"] = $this->m_reff->getToken();
		// return $var;
	}

	/* BEGIN::DATAKEMINATAN */
	function getKeminatanByNip($id)
	{
		return $this->db->get_where('tm_keminatan', ['nip_pegawai' => $id]);
	}
	function getKeminatanById($id)
	{
		return $this->db->get_where('tm_keminatan', ['id' => $id]);
	}
	function keminatan_insert()
	{
		$form 	 = $this->input->post("f");
		//$id		 = $this->input->post("id");
		if(!$form){	return false;	}
		$this->m_reff->log("insert data keminatan","data");

		$this->db->set($form);
		$this->db->insert("tm_keminatan");
		$this->m_reff->log("insert data keminatan");
		$var["token"] = $this->m_reff->getToken();
		return $var;
	}
	function keminatan_update()
	{
		$form 	 = $this->input->post("f");
		if(!$form){	return false;	}
		$this->m_reff->log("update data keminatan","data");

		$id_a	= $this->m_reff->san($this->input->post("id_a"));

		$this->db->set($form);
		$this->db->where("id", $id_a);
		$this->db->update("tm_keminatan");
		$this->m_reff->log("update data keminatan");
		$var["token"] = $this->m_reff->getToken();
		return $var;
	}
	function keminatan_destroy()
	{
		//$form 	 = $this->input->post("f");
		//$id		 = $this->input->post("id");
		$id_a	= $this->m_reff->san($this->input->post("id_a"));

		$this->db->where("id", $id_a);
		return    $this->db->delete("tm_keminatan");

		$this->m_reff->log("delete data keminatan");
		// $var["token"] = $this->m_reff->getToken();
		// return $var;
	}


	/* BEGIN::DATAPELATIHAN */
	function getPelatihanByNip($id)
	{
		return $this->db->get_where('tm_pelatihan', ['nip_pegawai' => $id]);
	}
	function getPelatihanById($id)
	{
		return $this->db->get_where('tm_pelatihan', ['id' => $id]);
	}
	function pelatihan_insert()
	{
		$form 	 = $this->input->post("f");
		if(!$form){	return false;	}
		$this->m_reff->log("insert data pelatihan","data");

		$tgl_ = $this->m_reff->san($this->input->post("tgl_pelaksanaan"));
		$tgl_pelaksanaan = $this->tanggal->eng_($tgl_, "-");

		$nip = $this->m_reff->san($this->input->post("f[nip_pegawai]"));
		if(isset($_FILES["file_sertifikat"]['tmp_name']))
		{  
			$dok=$this->m_reff->pengaturan(1)."dok/".$nip;
			$doksave = "dok/".$nip;
			$before_file=$this->m_reff->goField("tm_pelatihan","file_sertifikat","where nip_pegawai='".$nip."' ");
			$file=$this->m_reff->upload_file("file_sertifikat",$dok,"file_sertifikat","jpg,jpeg,png,pdf",$sizeFile="5000000",$before_file);
			if($file["validasi"]!=false)
			{ 	  	 
				$this->db->set("file_sertifikat",$doksave."/".$file['name']);
			}else{
			 $var["gagal"]=true;
			 $var["info"]="terjadi masalah saat upload file <br>".json_encode($file);
			 return $var;
			}
		}
		$this->db->set($form);
		$this->db->set("tgl_pelaksanaan", $tgl_pelaksanaan);
		$this->db->insert("tm_pelatihan");
		$this->m_reff->log("insert data pelatihan");
		$var["token"] = $this->m_reff->getToken();
		return $var;
	}
	function pelatihan_update()
	{
		$form 	 = $this->input->post("f");
		if(!$form){	return false;	}
		$this->m_reff->log("update data pelatihan","data");

		$id_a	= $this->m_reff->san($this->input->post("id_a"));

		$tgl_ = $this->m_reff->san($this->input->post("tgl_pelaksanaan"));
		$tgl_pelaksanaan = $this->tanggal->eng_($tgl_, "-");

		$nip = $this->m_reff->san($this->input->post("f[nip_pegawai]"));
		if(isset($_FILES["file_sertifikat"]['tmp_name']))
		{  
			$dok=$this->m_reff->pengaturan(1)."dok/".$nip;
			$doksave = "dok/".$nip;
			$before_file=$this->m_reff->goField("tm_pelatihan","file_sertifikat","where nip_pegawai='".$nip."' ");
			$file=$this->m_reff->upload_file("file_sertifikat",$dok,"file_sertifikat","jpg,jpeg,png,pdf",$sizeFile="5000000",$before_file);
			if($file["validasi"]!=false)
			{ 	  	 
				$this->db->set("file_sertifikat",$doksave."/".$file['name']);
			}else{
			 $var["gagal"]=true;
			 $var["info"]="terjadi masalah saat upload file <br>".json_encode($file);
			 return $var;
			}
		}
		$this->db->set($form);
		$this->db->set("tgl_pelaksanaan", $tgl_pelaksanaan);
		$this->db->where("id", $id_a);
		$this->db->update("tm_pelatihan");
		$this->m_reff->log("update data pelatihan");
		$var["token"] = $this->m_reff->getToken();
		return $var;
	}
	function pelatihan_destroy()
	{
		$this->m_reff->log("delete data pelatihan","data");
		//$form 	 = $this->input->post("f");
		//$id		 = $this->input->post("id");
		$id_a	= $this->m_reff->san($this->input->post("id_a"));

		$this->db->where("id", $id_a);
		return    $this->db->delete("tm_pelatihan");

		// $var["token"] = $this->m_reff->getToken();
		// return $var;
	}
}
