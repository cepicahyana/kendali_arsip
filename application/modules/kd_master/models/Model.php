<?php
class Model extends CI_Model  {

	function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
	}
	function nip(){
		return $this->session->userdata("nip");
	}
	function idu(){
		return $this->session->userdata("id");
	}
	function getById($id)
	{
		return $this->db->get_where('data_pegawai', ['id'=>$id]);
	}
	function getData()
	{
		$this->_getData();
		if($this->input->post("length")!=-1) 
		$this->db->limit($this->input->post("length"),$this->input->post("start"));
		return $this->db->get()->result();
	}
	function _getData()
	{
		$filter		=	$this->m_reff->san($this->input->post("filter"));
		if($filter){
			$f_istana 			=	$this->session->userdata("f_istana");
			if($f_istana){	$this->db->where("kode_istana",$f_istana);	}

			$f_biro			=	$this->session->userdata("f_biro");
			if($f_biro){	$this->db->where("kode_biro",$f_biro);	}
			
			$f_bagian		=	$this->session->userdata("f_bagian");
			if($f_bagian){	
				$this->db->where_in("bagian",$f_bagian);	
			}
			$f_covid		=	$this->session->userdata("f_covid");
			if($f_covid=="ya"){	
				$this->db->where("hasil_test","+");	
				$this->db->where("kode_test!=",NULL);	
			}elseif($f_covid=="no"){
				$this->db->where("hasil_test","-");	
				$this->db->where("kode_test",NULL);	
			}

			$f_subbagian		=	$this->session->userdata("f_subbagian");
			if($f_subbagian){	
				$this->db->where_in("subbagian",$f_subbagian);	
			}

			$f_golongan		=	$this->session->userdata("f_golongan");
			if($f_golongan){	
				$this->db->where_in("golongan",$f_golongan);	
			}

			$f_usia_min		=	$this->session->userdata("f_usia_min");
			if($f_usia_min){
				$ymin = date("Y")-$f_usia_min;	
				$this->db->where("SUBSTR(tgl_lahir,1,7)<=",$ymin."-".date('m'));	
			}
			$f_usia_max		=	$this->session->userdata("f_usia_max");
			if($f_usia_max){
				$ymax = date("Y")-$f_usia_max;	
				$this->db->where("SUBSTR(tgl_lahir,1,7)>=",$ymax."-".date('m'));	
			}

			$f_pensiun_min		=	$this->session->userdata("f_pensiun_min");
			if($f_pensiun_min){
				$ymin = date("Y")+$f_pensiun_min;	
				$this->db->where("SUBSTR(bup,1,7)>=",$ymin."-".date('m'));	
			}
			$f_pensiun_max		=	$this->session->userdata("f_pensiun_max");
			if($f_usia_max){
				$ymax = date("Y")+$f_pensiun_max;	
				$this->db->where("SUBSTR(bup,1,7)<=",$ymax."-".date('m'));	
			}

			$f_jabatan		=	$this->session->userdata("f_jabatan");
			if($f_jabatan){	
				$this->db->where_in("jabatan",$f_jabatan);	
			}

			$f_jml_tanggungan		=	$this->session->userdata("f_jml_tanggungan");
			if($f_jml_tanggungan){	
				$this->db->where("jml_tanggungan",$f_jml_tanggungan);	
			}

			$f_provinsi_ktp		=	$this->session->userdata("f_provinsi_ktp");
			if($f_provinsi_ktp){	
				$this->db->where("ktp_prov",$f_provinsi_ktp);	
			}

			$f_provinsi_domisili		=	$this->session->userdata("f_provinsi_domisili");
			if($f_provinsi_domisili){	
				$this->db->where("id_prov",$f_provinsi_domisili);	
			}

			$f_jp		=	$this->session->userdata("f_jp");
			if($f_jp){	
				$this->db->where_in("id_jp",$f_jp);	
			}

			$f_penghargaan		=	$this->session->userdata("f_penghargaan");
			if($f_penghargaan=="ya"){	
				$this->db->where("jml_penghargaan>",0);	
			}
			$f_hukuman		=	$this->session->userdata("f_hukuman");
			if($f_hukuman=="ya"){	
				$this->db->where("jml_hukuman>",0);	
			}
			$f_rm		=	$this->session->userdata("f_rm");
			if($f_rm=="ya"){	
				$this->db->where("jml_rm>",0);	
			}

			$f_masker_min		=	$this->session->userdata("f_masker_min");
			if($f_masker_min){
				$ymin = date("Y")-$f_masker_min;	
				$this->db->where("SUBSTR(tmt,1,7)<=",$ymin."-".date('m'));	
			}
			$f_masker_max		=	$this->session->userdata("f_masker_max");
			if($f_masker_max){
				$ymax = date("Y")-$f_masker_max;	
				$this->db->where("SUBSTR(tmt,1,7)>=",$ymax."-".date('m'));	
			}


		}
		// conditional istana
		$istana	= $this->m_reff->sanitize($this->input->post("istana"));
		if ($istana) {
			$this->db->where("kode_istana", $istana);
		}

		// instansi
		$instansi	= $this->m_reff->sanitize($this->input->post("instansi"));
		if ($instansi) {
			$this->db->where("instansi", $instansi);
		}

		// biro
		$biro	= $this->m_reff->sanitize($this->input->post("biro"));
		if ($biro) {
			$this->db->where("kode_biro", $biro);
		}

		// bagian
		$bagian	= $this->m_reff->sanitize($this->input->post("bagian"));
		if ($bagian) {
			$this->db->where("bagian", $bagian);
		}
		// jenis_pegawai
		$jenis_pegawai	= $this->m_reff->sanitize($this->input->post("jenis_pegawai"));
		if ($jenis_pegawai) {
			$this->db->where("jenis_pegawai", $jenis_pegawai);
		}

				if (strlen(isset($_POST['search']['value'])?($_POST['search']['value']):null)>1) {
					$searchkey = $_POST['search']['value'];
					$searchkey = $this->m_reff->sanitize($searchkey);	
					$query=array(
						"nama"=>$searchkey,
						"nip"=>$searchkey,
						"nip_baru"=>$searchkey,
						"nik"=>$searchkey,
						"bagian"=>$searchkey,
						"subbagian"=>$searchkey,
						"jabatan"=>$searchkey,
					);

					$this->db->group_start()->or_like($query)->group_end();
				}

				$this->db->order_by("nama", "asc");
			$query=$this->db->from("data_pegawai");
		return $query;
	}
	function countData()
	{
			$this->_getData();
		return $this->db->get()->num_rows();
	}


	/* BEGIN::PNS */
	function pns_insert(){
		$this->m_reff->log("Input data form pegawai PNS");
		$form 	 = $this->input->post("f");

		// $kode_biro = $this->input->post("kode_biro");
		// $biro = $this->m_reff->biro($kode_biro)->row()->biro;
		

		$tgl_lahir = $this->input->post("tgl_lahir");
		$tgl = $this->tanggal->eng_($tgl_lahir,"-");
		
		$tmtp = $this->input->post("tmt");
		$tmt = $this->tanggal->eng_($tmtp,"-");

		$nip = $form['nip'];
		 
		$this->db->set($form);
		$this->db->set("nip", $nip);
		$this->db->set("tgl_lahir", $tgl);
		// $this->db->set("kode_biro", $kode_biro);
		// $this->db->set("biro", $biro);

		$this->db->set("tmt", $tmt);

		$this->db->set("jenis_pegawai", 1);
		$this->db->set("created_at", date('Y-m-d H:i:s'));
		
		$cek=$this->cekDuplikat($nip);
		if(!$cek)
		{
			$this->db->insert("data_pegawai");
			$this->m_reff->log("insert pns");
		} else {
			$var["gagal"] = true;
			$var["info"] = "NIP sudah terdaftar";
		}


		$var["token"] = $this->m_reff->getToken();
		return $var;
	}
	function pns_update(){
		$form 	 = $this->input->post("f");
		$id		 = $this->input->post("id");

		$kode_biro = $this->input->post("kode_biro");
		$biro = $this->m_reff->biro($kode_biro);
		

		$tgl_lahir = $this->input->post("tgl_lahir");
		$tgl = $this->tanggal->eng_($tgl_lahir,"-");

		$tmtp = $this->input->post("tmt");
		$tmt = $this->tanggal->eng_($tmtp,"-");
		$nip = $form['nip_baru'];
 
		$this->db->set($form);
		$this->db->set("nip", $nip);
		$this->db->set("tgl_lahir", $tgl);
		$this->db->set("kode_biro", $kode_biro);
		$this->db->set("biro", $biro);
		$this->db->set("updated_at", date('Y-m-d H:i:s'));
		$this->db->set("tmt", $tmt);

		$this->db->where("id",$id);
		$this->db->update("data_pegawai");

		$this->m_reff->log("update pns");

		$var["token"] = $this->m_reff->getToken();
		return $var;
	}

	function pns_hapus(){
		$id    = $this->input->post("id");

		$this->m_reff->log("delete pns");

		$this->db->where("id",$id);
		return    $this->db->delete("data_pegawai");
	}
	function import_file_pns()
	{
		$jenis_pegawai = 1;
		return $this->import_file_pegawai($jenis_pegawai);
	}
	/* END::PNS */

	function set_filter(){
		$key   = $this->input->post("key");
		$value = $this->input->post("value");
		$filter = array(
			$key =>$value
		);
		return $this->session->set_userdata($filter);
	}
	function set_filter_ppnpn(){
		$key   = $this->input->post("key");
		$value = $this->input->post("value");
		$filter = array(
			$key =>$value
		);
		return $this->session->set_userdata($filter);
	}

	/* BEGIN::PPNPN */
	function ppnpn_insert(){
		$form 	 = $this->input->post("f");

		// $kode_biro = $this->input->post("kode_biro");
		// $biro = $this->m_reff->biro($kode_biro)->row()->nama;
		

		$tgl_lahir = $this->input->post("tgl_lahir");
		$tgl = $this->tanggal->eng_($tgl_lahir,"-");

		$tmtp = $this->input->post("tmt");
		$tmt = $this->tanggal->eng_($tmtp,"-");
		

		$nip = $form['nip'];
		 
		$this->db->set($form);

		if(isset($_FILES["foto"]['tmp_name']))
		{  
			$this->m_reff->direktori_nip($nip);
			$dok=$this->m_reff->pengaturan(1)."dok/".$nip;
			// $before_file=$this->m_reff->goField("data_pegawai","foto","where id='".$id."' ");
			$file=$this->m_reff->upload_file("foto",$dok,"foto","jpg,jpeg,png",$sizeFile="5000000",null);
			if($file["validasi"]!=false)
			{ 	$dok = "dok/".$nip;
				$this->db->set("foto",$dok."/".$file['name']);
			}else{
			 $var["gagal"]=true;
			 $var["info"]="terjadi masalah saat upload foto<br>".json_encode($file);
			 return $var;
			}
		} 


		$this->db->set("nip", $nip);
		$this->db->set("nip_baru", $nip);
		$this->db->set("tgl_lahir", $tgl);
		// $this->db->set("kode_biro", $kode_biro);
		// $this->db->set("biro", $biro);
		$this->db->set("tmt", $tmt);

		$this->db->set("jenis_pegawai", 2);
		$this->db->set("created_at", date('Y-m-d H:i:s'));
		
		$cek=$this->cekDuplikat($nip);
		if(!$cek)
		{
			$this->db->insert("data_pegawai");
			$this->m_reff->log("insert ppnpn");
		} else {
			$var["gagal"] = true;
			$var["info"] = "NIP sudah terdaftar";
		}


		$var["token"] = $this->m_reff->getToken();
		return $var;
	}

	function ppnpn_update(){
		$form 	 = $this->input->post("f");
		$id		 = $this->input->post("id");

		$kode_biro = $this->input->post("kode_biro");
		$biro = $this->m_reff->biro($kode_biro);
		

		$tgl_lahir = $this->input->post("tgl_lahir");
		$tgl = $this->tanggal->eng_($tgl_lahir,"-");

		$tmtp = $this->input->post("tmt");
		$tmt = $this->tanggal->eng_($tmtp,"-");
		$nip = $form['nip'];
		if($this->cekDuplikat($nip,$id)){
			$var["token"] = $this->m_reff->getToken();
			$var["gagal"] = true;
			$var["info"] = "NPP sudah ada!";
			return $var;
		}
 
		$this->db->set($form);
		// $this->db->set("nip", $nip);
		$this->db->set("tgl_lahir", $tgl);
		// $this->db->set("kode_biro", $kode_biro);
		// $this->db->set("biro", $biro);
		$this->db->set("updated_at", date('Y-m-d H:i:s'));
		$this->db->set("tmt", $tmt);
		if(isset($_FILES["foto"]['tmp_name']))
		{  
			$this->m_reff->direktori_nip($nip);
			$dok=$this->m_reff->pengaturan(1)."dok/".$nip;
			$before_file=$this->m_reff->goField("data_pegawai","foto","where id='".$id."' ");
			$file=$this->m_reff->upload_file("foto",$dok,"foto","jpg,jpeg,png",$sizeFile="5000000",$before_file);
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
		$this->db->where("id",$id);
		$this->db->update("data_pegawai");

		$this->m_reff->log("update ppnpn");

		$var["token"] = $this->m_reff->getToken();
		return $var;
	}

	function ppnpn_hapus(){
		$id    = $this->input->post("id");

		$this->m_reff->log("delete ppnpn");

		$this->db->where("id",$id);
		return    $this->db->delete("data_pegawai");
	}
	function import_file_ppnpn()
	{
		$jenis_pegawai = 2;
		return $this->import_file_pegawai($jenis_pegawai);
	}
	/* END::PPNPN */


	/* BEGIN::PetugasTaman */
	function pt_insert(){
		$form 	 = $this->input->post("f");

		// $kode_biro = $this->input->post("kode_biro");
		// $biro = $this->m_reff->biro($kode_biro);	

		$tgl_lahir = $this->input->post("tgl_lahir");
		$tgl = $this->tanggal->eng_($tgl_lahir,"-");

		$tmtp = $this->input->post("tmt");
		$tmt = $this->tanggal->eng_($tmtp,"-");

		$nip = $this->input->post("f[nip]");
		$hp = $form['no_hp'];
		$email = $form['email'];
		 
		$this->db->set($form);
		// $this->db->set("nip", $nip);
		$this->db->set("tgl_lahir", $tgl);
		// $this->db->set("kode_biro", $kode_biro);
		// $this->db->set("biro", $biro);

		$this->db->set("jenis_pegawai", 3);
		$this->db->set("created_at", date('Y-m-d H:i:s'));
		$this->db->set("tmt", $tmt);

		$cek=$this->cekDuplikat($nip);
		if(!$cek)
		{
			$this->db->insert("data_pegawai");
			$this->m_reff->log("insert ppnpn");
		} else {
			$var["gagal"] = true;
			$var["info"] = "NIP sudah terdaftar";
		}

		$var["token"] = $this->m_reff->getToken();
		return $var;
	}
	function pt_update(){
		$form 	 = $this->input->post("f");
		$id		 = $this->input->post("id");

		// $kode_biro = $this->input->post("kode_biro");
		// $biro = $this->m_reff->biro($kode_biro)->row()->nama;
		

		$tgl_lahir = $this->input->post("tgl_lahir");
		$tgl = $this->tanggal->eng_($tgl_lahir,"-");

		$tmtp = $this->input->post("tmt");
		$tmt = $this->tanggal->eng_($tmtp,"-");
		$nip = $form['nip'];
		if($this->cekDuplikat($nip,$id)){
			$var["token"] = $this->m_reff->getToken();
			$var["gagal"] = true;
			$var["info"] = "NPP sudah ada!";
			return $var;
		}
		$this->db->set($form);
		// $this->db->set("nip", $nip);
		$this->db->set("tgl_lahir", $tgl);
		// $this->db->set("kode_biro", $kode_biro);
		// $this->db->set("biro", $biro);
		$this->db->set("updated_at", date('Y-m-d H:i:s'));
		$this->db->set("tmt", $tmt);

		$this->db->where("id",$id);
		$this->db->update("data_pegawai");

		$this->m_reff->log("update petugas taman");

		$var["token"] = $this->m_reff->getToken();
		return $var;
	}

	function pt_hapus(){
		$id    = $this->input->post("id");

		$this->m_reff->log("delete petugas taman","data");

		$this->db->where("id",$id);
		return    $this->db->delete("data_pegawai");
	}
	function import_file_pt()
	{
		$jenis_pegawai = 3;
		return $this->import_file_pegawai($jenis_pegawai);
	}
	/* END::PetugasTaman */

	/* BEGIN::CleaningService */
	function cs_insert(){
		$form 	 = $this->input->post("f");

		// $kode_biro = $this->input->post("kode_biro");
		// $biro = $this->m_reff->biro($kode_biro);
		
		$tmtp = $this->input->post("tmt");
		$tmt = $this->tanggal->eng_($tmtp,"-");
		
		$tgl_lahir = $this->input->post("tgl_lahir");
		$tgl = $this->tanggal->eng_($tgl_lahir,"-");

		$tgl_lahir = $this->input->post("tgl_lahir");
		$tgl = $this->tanggal->eng_($tgl_lahir,"-");

		$nip = $this->input->post("f[nip]");
		 
		$this->db->set($form);
		// $this->db->set("nip", $nip);
		$this->db->set("tgl_lahir", $tgl);
		// $this->db->set("kode_biro", $kode_biro);
		// $this->db->set("biro", $biro);

		$this->db->set("jenis_pegawai", 4);
		$this->db->set("created_at", date('Y-m-d H:i:s'));
		$this->db->set("tmt", $tmt);

		$cek=$this->cekDuplikat($nip);
		if(!$cek)
		{
			$this->db->insert("data_pegawai");
			$this->m_reff->log("insert ppnpn");
		} else {
			$var["gagal"] = true;
			$var["info"] = "NIP sudah terdaftar";
		}


		$var["token"] = $this->m_reff->getToken();
		return $var;
	}
	function cs_update(){
		$form 	 = $this->input->post("f");
		$id		 = $this->input->post("id");

		// $kode_biro = $this->input->post("kode_biro");
		// $biro = $this->m_reff->biro($kode_biro)->row()->nama;
		$nip = $form['nip'];
		if($this->cekDuplikat($nip,$id)){
			$var["token"] = $this->m_reff->getToken();
			$var["gagal"] = true;
			$var["info"] = "NPP sudah ada!";
			return $var;
		}

		$tgl_lahir = $this->input->post("tgl_lahir");
		$tgl = $this->tanggal->eng_($tgl_lahir,"-");

		$tmtp = $this->input->post("tmt");
		$tmt = $this->tanggal->eng_($tmtp,"-");
		
 
		$this->db->set($form);
		// $this->db->set("nip", $nip);
		$this->db->set("tgl_lahir", $tgl);
		// $this->db->set("kode_biro", $kode_biro);
		// $this->db->set("biro", $biro);
		$this->db->set("updated_at", date('Y-m-d H:i:s'));
		$this->db->set("tmt", $tmt);

		$this->db->where("id",$id);
		$this->db->update("data_pegawai");

		$this->m_reff->log("update cleaning service");

		$var["token"] = $this->m_reff->getToken();
		return $var;
	}

	function cs_hapus(){
		$id    = $this->input->post("id");

		$this->m_reff->log("delete cleaning service");

		$this->db->where("id",$id);
		return    $this->db->delete("data_pegawai");
	}
	function import_file_cs()
	{
		$jenis_pegawai = 4;
		return $this->import_file_pegawai($jenis_pegawai);
	}
	/* END::CleaningService */

	function amankan2($val){
		$val=str_replace("`","",$val);
		$val=str_replace("'","",$val);
		$val=str_replace(" ","",$val);
		// $val=str_replace("-","",$val);
		$val=str_replace("+62","0",$val);
		return $val;
	}
	function amankan($val){
		$val=str_replace("`","",$val);
		$val=str_replace("'","",$val);
		$val=str_replace(" ","",$val);
		$val=str_replace("-","",$val);
		$val=str_replace("+62","0",$val);
		return $val;
	}
	/* BEGIN:ImportFile*/
	function import_file_pegawai($jenis_pegawai)
	{
		error_reporting(0);
		$this->m_reff->log("import data pegawai");
		$kode_istana = $this->input->post('istana');
		$kode_biro = $this->input->post('kode_biro');
		// $biro = $this->m_reff->biro($kode_biro);
		// $kode_istana = $this->m_reff->goField("tr_istana","kode","where LOWER(nama)='".strtolower($istana)."'");

		$file_form="userfile";
		$this->load->library("PHPExcel");
		$insert=0;$gagal=0;$dgagal="";$edit=0;$validasi_hp=true;$validasi=true;
		$file   = explode('.',$_FILES[$file_form]['name']);
		$length = count($file);
		if($file[$length -1] == 'xlsx' || $file[$length -1] == 'xls'){
        	$tmp = $_FILES[$file_form]['tmp_name'];
	 
			    $load = PHPExcel_IOFactory::load($tmp);
                $sheets = $load->getActiveSheet()->toArray(null,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true);
				$i=1;
			 
					 
				foreach ($sheets as $sheet) {
					if ($i > 1) {
							$nip=isset($sheet[1])?($sheet[1]):"";
							$nama=isset($sheet[2])?($sheet[2]):"";
							$hp=isset($sheet[3])?($sheet[3]):"";
							$hp=str_replace("`","",$hp);
							$hp=str_replace("'","",$hp);
							$hp=str_replace(" ","",$hp);
							$hp=str_replace("-","",$hp);
							$hp=str_replace("+62","0",$hp);
							if(substr($hp,0,1)!="0")
							{
								$hp="0".$hp;
							}
							$email=isset($sheet[4])?strtolower(trim($sheet[4])):"";
							$eselon=isset($sheet[5])?strtoupper(trim($sheet[5])):"";
							$golongan=isset($sheet[6])?strtoupper(trim($sheet[6])):"";
							$jabatan=isset($sheet[7])?ucwords(trim($sheet[7])):"";
							$bagian=isset($sheet[8])?ucwords(trim($sheet[8])):"";
							$instansi=isset($sheet[9])?ucwords(trim($sheet[9])):"";
							$tmt=isset($sheet[10])?($sheet[10]):null;
							$nik=isset($sheet[11])?($sheet[11]):"";
							$tempat_lahir=isset($sheet[12])?ucwords(trim($sheet[12])):"";
							$tgl_lahir=isset($sheet[13])?($sheet[13]):null;
							$jk=isset($sheet[14])?strtolower(substr(trim($sheet[14]),0,1)):"";
							$agama=isset($sheet[15])?ucwords(trim($sheet[15])):"";
							$id_jp=isset($sheet[16])?strtoupper(trim($sheet[16])):"";
							$sts_menikah=isset($sheet[17])?ucwords(trim($sheet[17])):"";
							$id_goldar=isset($sheet[18])?strtoupper(trim($sheet[18])):"";
							$subbagian=isset($sheet[19])?ucwords(trim($sheet[19])):"";
							$cek=$this->cekDuplikat($nip);



						$ray=array(
							"kode_istana"=>$kode_istana,
							"kode_biro"=>$kode_biro,
							"kode_istana"=>$kode_istana,
							// "biro"=>$biro,
							"nip"=>$nip=$this->amankan($nip),
							"nama"=>$nama,
							"no_hp"=>$hp,
							"email"=>$email, 
							"eselon"=>$eselon,
							"golongan"=>$golongan,
							"jabatan"=>$jabatan,
							"bagian"=>$bagian,
							"instansi"=>$instansi,
							"tmt"=>$this->tanggal->eng_($this->amankan2($tmt),"-"),
							// "tmt_setpres"=>$this->tanggal->eng_($this->amankan2($tmt),"-"),
							"nik"=>$this->amankan($nik),
							"tempat_lahir"=>$tempat_lahir,
							"tgl_lahir"=>$this->tanggal->eng_($this->amankan2($tgl_lahir),"-"),
							"jk"=>$jk,
							"agama"=>$agama,
							"id_jp"=>$id_jp,
							"sts_menikah"=>$sts_menikah,
							"id_goldar"=>$id_goldar,
							"subbagian"=>$subbagian,
						);

						$ray["jenis_pegawai"] = $jenis_pegawai;
					
						if(!$cek)
						{	
							$this->m_reff->direktori_nip($nip);
							$insert++;
							$this->_insert_pegawai($ray);
						} else {

							// $this->_insert_pegawai($ray,$nip);
							$gagal++;
							$dgagal.="No.".$i."/".$nama."- NIP: ".$nip.br();
						}
								 
						  
					}
					$i++;
                }
               
		}else{
			 $var["file"]=false;
			 $var["type_file"]="xlsx";
		}
			  $var["import_data"]=true;
			  $var["data_insert"]=$insert;
			  $var["data_gagal"]=$gagal;
			  $var["data_edit"]=$edit; 
			  $var["dgagal"]=$dgagal; 
			  $var["validasi"]=$validasi;


			  if ($gagal > 0) {
			  	$var["gagal"] = true;
			  	$var["info"] = $dgagal;
			  }
			  

			return $var;
	}
	function update_file_ppnpn()
	{
		$this->m_reff->log("import data pegawai");
		// $kode_istana = $this->input->post('kode_istana');
		// $kode_biro = $this->input->post('kode_biro');
		// $biro = $this->m_reff->biro($kode_biro);
		// $kode_istana = $this->m_reff->goField("tr_istana","kode","where LOWER(nama)='".strtolower($istana)."'");

		$file_form="userfile";
		$this->load->library("PHPExcel");
		$insert=0;$gagal=0;$dgagal="";$edit=0;$validasi_hp=true;$validasi=true;
		$file   = explode('.',$_FILES[$file_form]['name']);
		$length = count($file);
		if($file[$length -1] == 'xlsx' || $file[$length -1] == 'xls'){
        	$tmp = $_FILES[$file_form]['tmp_name'];
	 
			    $load = PHPExcel_IOFactory::load($tmp);
                $sheets = $load->getActiveSheet()->toArray(null,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true);
				$i=1;
			 
					 
				foreach ($sheets as $sheet) {
					if ($i > 1) {
							$nip=isset($sheet[0])?($sheet[0]):"";
							$nip=trim($nip);
							$nip=str_replace("`","",$nip);
							$nip=str_replace("'","",$nip);
							$nama=isset($sheet[1])?($sheet[1]):"";
							$jk=isset($sheet[2])?($sheet[2]):"";
							$tgl_lahir=isset($sheet[3])?($sheet[3]):"";
							$hp=isset($sheet[4])?($sheet[4]):"";
							$hp=str_replace("`","",$hp);
							$hp=str_replace("'","",$hp);
							$hp=str_replace(" ","",$hp);
							$hp=str_replace("-","",$hp);
							$hp=str_replace("+62","0",$hp);
							if(substr($hp,0,1)!="0")
							{
								$hp="0".$hp;
							}
							$email=isset($sheet[5])?strtolower(trim($sheet[5])):"";
							$bagian=isset($sheet[6])?strtoupper(trim($sheet[6])):"";
							$subbagian=isset($sheet[7])?strtoupper(trim($sheet[7])):"";
							$tmt=isset($sheet[8])?strtoupper(trim($sheet[8])):"";
							$kode_istana=isset($sheet[9])?strtoupper(trim($sheet[9])):"";
							$kode_biro=isset($sheet[10])?strtoupper(trim($sheet[10])):"";
							 
 
						$ray=array(
							"kode_istana"=>$kode_istana,
							"kode_biro"=>$kode_biro,
							// "biro"=>$biro,
						 
							"nama"=>$nama,
							"no_hp"=>$hp,
							"email"=>$email, 
							// "eselon"=>$eselon,
							// "golongan"=>$golongan,
							// "jabatan"=>$jabatan,
							"bagian"=>$bagian,
							// "instansi"=>$instansi,
							"tmt"=>$this->tanggal->eng_($this->amankan2($tmt),"-"),
							// "tmt_setpres"=>$this->tanggal->eng_($this->amankan($tmt),"-"),
							// "nik"=>$this->amankan($nik),
							// "tempat_lahir"=>$tempat_lahir,
							"tgl_lahir"=>$this->tanggal->eng_($this->amankan2($tgl_lahir),"-"),
							"jk"=>$jk,
							// "agama"=>$agama,
							// "id_jp"=>$id_jp,
							// "sts_menikah"=>$sts_menikah,
							// "id_goldar"=>$id_goldar,
							"subbagian"=>$subbagian,
							"jenis_pegawai"=>2
						);

						// $ray["jenis_pegawai"] = 2;
					 
						// if(!$cek)
						// {	
							// $this->m_reff->direktori_nip($nip);
							$insert++;
							$this->db->where("nip",$nip);
							$this->db->update("data_pegawai",$ray);
						// } else {

						// 	// $this->_insert_pegawai($ray,$nip);
						// 	$gagal++;
						// 	$dgagal.="No.".$i."/".$nama."- NIP: ".$nip.br();
						// }
								 
						  
					}
					$i++;
                }
               
		}else{
			 $var["file"]=false;
			 $var["type_file"]="xlsx";
		}
			  $var["import_data"]=true;
			  $var["data_insert"]=$insert;
			  $var["data_gagal"]=$gagal;
			  $var["data_edit"]=$edit; 
			  $var["dgagal"]=$dgagal; 
			  $var["validasi"]=$validasi;


			  if ($gagal > 0) {
			  	$var["gagal"] = true;
			  	$var["info"] = $dgagal;
			  }
			  

			return $var;
	}
	
	private function _insert_pegawai($ray,$nip=null)
	{
		$this->db->set($ray);
		if(!$nip){
			return $this->db->insert("data_pegawai");
		}else{
			$this->db->where("nip",$nip);
			return $this->db->update("data_pegawai");
		}
		
	}
	/* END:ImportFile*/


	function cekDuplikat($nip='', $id=null)
	{
		if ($nip !== '') {
			$this->db->where('nip', $nip);
		}
		// if ($hp !== '') {
		// 	$this->db->where('no_hp', $hp);
		// }
		// if ($email !== '') {
		// 	$this->db->where('email', $email);
		// }
		if($id){
			$this->db->where('id!=', $id);
		}
		return $this->db->get('data_pegawai')->num_rows();
	}

}




