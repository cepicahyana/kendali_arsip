<?php

class Model extends CI_Model  {
    
	 
	function __construct()
    {
        parent::__construct();
    }
	function setNIK(){
		$var["token"]=$this->m_reff->getToken();
		$nik	=	$this->m_reff->san($this->input->post("nik"));
		$id		=	$this->m_reff->san($this->input->post("id"));

					$this->db->where("id!=",$id);
		$cek	=	$this->db->get_where("data_pegawai",array("nik"=>$nik))->num_rows();
		if($cek){
			$var["sts"] = false;
			$var["info"] = "NIK sudah pernah digunakan oleh oleh lain.";
			return $var;
		}

		$this->db->set("nik",$nik);
		$this->db->where("id",$id);
		$this->db->update("data_pegawai");
		 $var["sts"] = true;
	
		 return $var;
	}

	
	function get_data()
	{
		 $this->_get_data();
		if($this->m_reff->san($this->input->post("length")!=-1)) 
		$this->db->limit($this->m_reff->san($this->input->post("length")),$this->m_reff->san($this->input->post("start")));
	 	return $this->db->get()->result();
		 
	}
	function _get_data()
	{
	 	     $kode_biro = $this->session->kode_biro;
		if($this->session->level=="pic_covid"){
			
			if($kode_biro){
			   $this->db->where("(nip in (select nip from data_pegawai where kode_biro='".$this->m_reff->sanitize($kode_biro)."' ) or _cid='".$this->session->userdata('id')."')");
			}else{
			   $this->db->where("(nip in (select nip from data_pegawai where kode_istana='".$this->m_reff->sanitize($this->session->kode_istana)."' ) or _cid='".$this->session->userdata('id')."')");
			   // $this->db->where("_cid",$this->idu());
			}
		}	  

		$filter = $this->m_reff->san($this->input->post("filter"));
		if($filter==1){
			$this->db->where("konfirm_rs!=",null);
		}elseif($filter==2){
			$this->db->where("konfirm_rs",null);
		} 


		if (strlen(isset($_POST['search']['value'])?($_POST['search']['value']):null)>1) {
			$searchkey = $_POST['search']['value'];
			$searchkey = $this->m_reff->sanitize($searchkey);
					 $query=array(
					 "nama"=>$searchkey, 				 		 
					 "nip"=>$searchkey, 				 
					 "nik"=>$searchkey, 				 				 
							   
					 );
					 $this->db->group_start()
							 ->or_like($query)
					 ->group_end();
					 
				 }	

			$this->db->order_by("id","desc");
			// $this->db->where("sts",0);
			$query=$this->db->from("data_test");
		return $query;
			 
		
		 
	}
	function setStsAcc(){
		$id  = $this->m_reff->san($this->input->post("id"));
		$sts = $this->m_reff->san($this->input->post("sts"));
		$this->db->set("sts_acc",$sts);
		$this->db->where("id",$id);
		$this->db->update("data_test");
		return $this->m_reff->log("update sts=acc tes covid","covid");
	}
	function setStsAccFam(){
		$id  = $this->m_reff->san($this->input->post("id"));
		$sts = $this->m_reff->san($this->input->post("sts"));
		$this->db->set("sts_acc",$sts);
		$this->db->where("id",$id);
		$this->db->update("data_test_keluarga");
		return $this->m_reff->log("update sts=acc tes covid keluarga","covid");
	}
	function get_data_family()
	{
		 $this->_get_data_family();
		if($this->m_reff->san($this->input->post("length")!=-1)) 
		$this->db->limit($this->m_reff->san($this->input->post("length")),$this->m_reff->san($this->input->post("start")));
	 	return $this->db->get()->result();
		 
	}
	function _get_data_family()
	{
	 	    $nip = $this->session->userdata("nip");    
			$this->db->order_by("id","desc");
			// $this->db->where("sts",0);
			$kode_biro = $this->session->kode_biro;
			$istana = $this->session->kode_istana;
			if($this->session->level=="pic_covid"){
				if($kode_biro){
					$this->db->where("nip_pegawai in (select nip from data_pegawai where kode_biro='".$kode_biro."' )");
				}else{
					$this->db->where("nip_pegawai in (select nip from data_pegawai where kode_istana='".$istana."' )");
				} 
			}
			
			$filter = $this->m_reff->san($this->input->post("filter"));
		if($filter==1){
			$this->db->where("konfirm_rs!=",null);
		}elseif($filter==2){
			$this->db->where("konfirm_rs",null);
		} 


			if (strlen(isset($_POST['search']['value'])?($_POST['search']['value']):null)>1) {
					$searchkey = $_POST['search']['value'];
					$searchkey = $this->m_reff->sanitize($searchkey);
					
					$query=array(
					"nama"=>$searchkey, 				 		 
					"nip_pegawai"=>$searchkey, 				 
					"nik"=>$searchkey, 				 				 
							  
					);
					$this->db->group_start()
							->or_like($query)
					->group_end();
					
				}	

			$query=$this->db->from("data_test_keluarga");
		return $query;
	}
	function nip(){
		return $this->m_reff->nip();
	}
	function idu(){
		return $this->session->userdata("id");
	}
	public function count_family()
	{				
			$this->_get_data_family();
		return $this->db->get()->num_rows();
	}
	public function count()
	{				
			$this->_get_data();
		return $this->db->get()->num_rows();
	}
	function hapus_family(){
		$id     = $this->m_reff->san($this->input->post("id"));
		$nip    = $this->m_reff->san($this->input->post("nip"));
		$kode   = $this->m_reff->san($this->input->post("kode"));

		// $this->db->where("kode_test",$kode);
		$this->db->set("sts_test",0);
		$this->db->update("data_keluarga");


		$this->db->where("nip_pegawai",$nip);
		$this->db->where("id",$id);
		$this->db->delete("data_test_keluarga");
		$var["token"] = $this->m_reff->getToken();
		return $var;
	}
	function hapus(){
		$id    = $this->m_reff->san($this->input->post("id"));
		$nip   = $this->m_reff->san($this->input->post("nip"));
		$kode   = $this->m_reff->san($this->input->post("kode"));

		// $this->db->where("kode_test",$kode);
		$this->db->where("nip",$nip);
		$this->db->set("sts_test",0);
		$this->db->update("data_pegawai");


		$this->db->where("id",$id);
		$this->db->delete("data_test");
		$var["token"] = $this->m_reff->getToken();
		return $var;
	}
	function insert(){
		$form 	 = $this->input->post("f");
		$this->m_reff->log("Input data test ::".json_encode($form),"covid");
		$tgl_test = $this->m_reff->san($this->input->post("tgl_test"));
		$nip	 = $this->m_reff->san($this->input->post("f[nip]"));
		// $nik	 = $this->input->post("f[nik]");
		$cek		 = $this->m_reff->san($this->input->post("hasil_test"));
		$kode_utama	 = $this->m_reff->san($this->input->post("kode_test"));
		$jenis_pegawai	 = $this->m_reff->san($this->input->post("jenis_pegawai"));

		 
		$kode	 = $this->generateKode();
				   $this->m_reff->qr($kode);
		
		if($this->input->post("f[kode_jenis]")=="04"){
					$tgl = $this->tanggal->eng($tgl_test,"-");
					$tgl = $this->tanggal->hariLengkap($tgl,"/");
					$msg = $this->m_reff->notifikasi(7,"wa");
					$msg = str_replace("{tgl}",$tgl,$msg);

					$this->db->where("kode_istana",$this->session->userdata("kode_istana"));
					$this->db->where("kode_biro",$this->session->userdata("kode_biro"));
					$this->db->where("level",4);
			$dbadmin	=	$this->db->get("admin")->result();
		
			foreach($dbadmin as $admin){
					$hp = $admin->telp;
					$this->m_reff->kirimWa($hp,$msg);
			}
			$s=0;
		}else{
			$s=1;
		}


		if($cek!="+"){
			$this->db->set("sts_test",1);
			$this->db->where("nip",$nip);
			$this->db->set("kode_test",$kode);
			$this->db->update("data_pegawai");
		}else{
			$this->db->set("sts_test",1);
			$this->db->where("nip",$nip);
			$this->db->update("data_pegawai");
		}
		

		$this->db->set(
			array(
			"tgl"		=>	$tgl_test=$this->tanggal->eng($tgl_test,"-"),
			"_cid"		=>	$this->idu(),
			"_ctime"	=>	date("Y-m-d H:i:s"),
			"kode"		=>	$kode
			)
		);
		$this->db->set("sts_acc",$s);
		$this->db->set($form);
		if($cek=="+"){
			// $this->db->set("test_lanjutan",1);
			$this->db->set("kode_test_utama",$kode_utama);
		}
		$this->db->set("kode_istana",$this->session->kode_istana);
	 
		$this->db->set("kode_biro",$this->session->kode_biro);
		$this->db->set("jenis_pegawai",$jenis_pegawai);
		$this->db->insert("data_test");
		$var["token"] = $this->m_reff->getToken();

		$jenis = $this->db->get_where("tr_jenis_test",array("kode"=>$this->m_reff->san($this->input->post("f[kode_jenis]"))))->row();
		$jenis_test = isset($jenis->nama)?($jenis->nama):"";

		$this->kirimNotifSR($nip,$this->m_reff->san($this->input->post("f[kode_tempat]")),$kode,$tgl_test,$jenis_test);
		return $var;
	}
	function kirimNotifSR($nip,$kode_tempat,$kode,$tgl_test,$jenis_test){
		$db = $this->db->get_where("data_pegawai",array("nip"=>$nip))->row();
		$email =  isset($db->email)?($db->email):"";
		$sts = $this->m_reff->jenis_pegawai($db->jenis_pegawai);
		$msg = $this->m_reff->notifikasi(3,"wa");
		if(strtolower($db->jk)=="laki-laki"){
			$awalan = "Bpk";
		}elseif(strtolower($db->jk)=="perempuan"){
			$awalan = "Ibu";
		}else{
			$awalan = "";
		}

		$getRS = $this->db->get_where("tm_rs",array("kode"=>$kode_tempat))->row();
		$rs = isset($getRS->nama)?($getRS->nama):"";
		$rs_alamat = isset($getRS->alamat)?($getRS->alamat):"";
		$rs = $rs." - ".$rs_alamat;

		$msg = str_replace("{kode}",$kode,$msg);
		$msg = str_replace("{email}",$email,$msg);
		$msg = str_replace("{kode_tes}",$kode,$msg);
		$msg = str_replace("{nik}",$db->nik,$msg);
		$msg = str_replace("{nama}",$db->nama,$msg);
		$msg = str_replace("{awalan}",$awalan,$msg);
		$msg = str_replace("{tempat_tes}",$rs,$msg);
		$msg = str_replace("{status}",$sts,$msg);
		$msg = str_replace("{tgl_tes}",$this->tanggal->hariLengkap($tgl_test,"/"),$msg);

		$tahun = date("Y");
		$file = $this->m_reff->pengaturan(1).$tahun."/surat_rekomendasi/".$kode.".pdf";
		$this->genSR($kode,$getRS,$db,$file,$tgl_test,$jenis_test);
		$this->m_reff->kirimWa($db->no_hp,$msg,null);


		$subject = $this->m_reff->notifikasi(3,"subject"); //email
		$msg = $this->m_reff->notifikasi(3,"email"); //email
		$msg = str_replace("{kode}",$kode,$msg);
		$msg = str_replace("{kode_tes}",$kode,$msg);
		$msg = str_replace("{email}",$email,$msg);
		$msg = str_replace("{nik}",$db->nik,$msg);
		$msg = str_replace("{nama}",$db->nama,$msg);
		$msg = str_replace("{awalan}",$awalan,$msg);
		$msg = str_replace("{tempat_tes}",$rs,$msg);
		$msg = str_replace("{status}",$sts,$msg);
		$msg = str_replace("{tgl_tes}",$this->tanggal->hariLengkap($tgl_test,"/"),$msg);

		  $file = realpath($file);
		   $mail[] = array(
			   'path' => $file,
			   'femail' => $this->m_reff->sanitize($db->email),
			   'fsubject' => $subject. " - ".date('d-m-Y'),
			   'namaFile' => "Surat Rekomendasi Tes.pdf",
			   'fmessage' => $msg
		   );

		   return	 $this->m_reff->kirimEmail($mail);
	}

	function genSR($kode,$getRS,$db,$file,$tgl_test,$jenis_test){
		ob_start();
		//include('file.html');
		$data["tgl_test"] = $tgl_test; 
		$data["kode_test"] = $kode; // kode test
		$data["getRS"] = $getRS; 
		$data["data"] = $db; // data pegawai
		$data["jenis_test"] = $jenis_test; // data pegawai
		 $this->m_reff->qr($kode);
	 	$html=$this->load->view('genSR',$data,TRUE); 
		// $css=$kode;
       
 
			$mpdf = new \Mpdf\Mpdf([
				'mode' => 'utf-8', 
				'format' => 'A4-P',
				// 'margin_left' => 32,
				// 'margin_right' => 25,
				// 'margin_top' => 27,
				// 'margin_bottom' => 25,
				// 'margin_header' => 16,
				// 'margin_footer' => 13 
			]);
	
			// $stylesheet = file_get_contents($css);
			$mpdf->SetDisplayMode('fullpage');
			// $mpdf->WriteHTML($stylesheet, 1); // The parameter 1 tells that this is css/style only and no body/html/text
			$mpdf->WriteHTML($html, 2);
			// $mpdf->Output(); // opens in browser
			$mpdf->Output($file, 'F'); // it downloads the file into the user system, with give name
	}
	function insert_family(){
		
		$form 	 = $this->input->post("f");
		$nik	 = $this->m_reff->san($this->input->post("f[nik]"));
		$id_hub  = $this->m_reff->san($this->input->post("id_hubungan"));
		$jk	     = $this->m_reff->san($this->input->post("jk"));
		$this->m_reff->log("input data tes keluarga pegawai ::".json_encode($form));
		$kode	 = $this->generateKodeFamily();
		$this->m_reff->qr($kode);
		
				   $this->db->where("nip_pegawai",$this->m_reff->nip());
				   $this->db->where("nik",$nik);
		$cek 	 = $this->db->get("data_keluarga")->row();
		$cek_test     = isset($cek->sts_test)?($cek->sts_test):0;
		$ava     = isset($cek->id)?($cek->id):0;
		$hasil_tes = isset($cek->hasil_test)?($cek->hasil_test):null;
		$kode_utama = isset($cek->kode_test)?($cek->kode_test):null;

		if($cek_test){
			$var["gagal"] = true;
			$var["info"]  = "Gagal! ".$form['nama']. " sedang diajukan untuk tes.";
			$var["token"] = $this->m_reff->getToken();
			return $var;
		}

		$tgl = $this->tanggal->eng_($this->m_reff->san($this->input->post("tgl_lahir")));
		
		// $this->db->set("istana",$this->session->userdata("istana"));
		// $this->db->set("kode_biro",$this->session->userdata("kode_biro"));
		if(!$ava){ // jika data keluarga tidak ada maka ditambahkan
			$this->db->set("tgl_lahir",$tgl);
			$this->db->set("nip_pegawai",$this->m_reff->nip());
			$this->db->set($form);
			$this->db->set("id_hubungan",$id_hub);
			$this->db->set("jk",$jk);
			$this->db->set("kode_test",$kode);
			$this->db->set("sts_test",1);
			$this->db->insert("data_keluarga");
			$this->m_reff->log("insert tes covid keluarga","covid");
		}else{
			$this->db->set("jk",$jk);
			$this->db->set("id_hubungan",$id_hub);
			$this->db->set("tgl_lahir",$tgl);
			$this->db->set("sts_test",1);
			$this->db->set($form);
			$this->db->where("id",$ava);
			$this->db->update("data_keluarga");
			// $this->m_reff->log("hapus tes covid external","covid");
		}

		 if($this->session->sts_akun){
			$sts_acc=1;
		 }else{
			 $sts_acc=0;
		 }

		$this->db->set(
			array(
			"tgl"		=>	$tgl_test = $this->m_reff->san($this->input->post("tgl_test")),
			"_cid"		=>	$this->idu(),
			"_ctime"	=>	date("Y-m-d H:i:s"),
			"kode"		=>	$kode,
			"nip_pegawai"	=> $nip=$this->m_reff->san($this->input->post("f[nip_pegawai]")),
			"kode_tempat"	=> $this->m_reff->san($this->input->post("kode_tempat")),
			"kode_jenis"	=> $this->m_reff->san($this->input->post("kode_jenis")),
			"nama"	=> $this->m_reff->san($this->input->post("f[nama]")),
			"jk"	=> $this->m_reff->san($this->input->post("jk")),
			"nik"	=> $this->m_reff->san($this->input->post("f[nik]")),
			"id_hubungan"	=> $id_hub,
			"sts_acc"		=> $sts_acc,
			"tgl"			=> $tgl_test=$this->tanggal->eng_($this->m_reff->san($this->input->post("tgl_test")),"-")
			)
		);

		if($hasil_tes=="+"){
			$this->db->set("kode_test_utama",$kode_utama);
		}
		$this->db->insert("data_test_keluarga");
		$var["token"] = $this->m_reff->getToken();

		$jenis = $this->db->get_where("tr_jenis_test",array("kode"=>$this->m_reff->san($this->input->post("kode_jenis"))))->row();
		$jenis_test = isset($jenis->nama)?($jenis->nama):"";

		$param=array(
			"nip"=>$nip,
			"nik"=>$nik,
			"kode_tempat" => $this->m_reff->san($this->input->post("kode_tempat")),
			"kode" => $kode,
			"tgl_test" => $tgl_test,
			"jenis_test" => $jenis_test
		);
		$this->kirimNotifSRKeluarga($param);

		return $var;
	}

	
	function kirimNotifSRKeluarga($param){
		$nik			=	$param["nik"];
		$nip			=	$param["nip"];
		$kode_tempat	=	$param["kode_tempat"];
		$kode			=	$param["kode"];
		$tgl_test		=	$param["tgl_test"];
		$jenis_test		=	$param["jenis_test"];

		$db  = $this->db->get_where("data_pegawai",array("nip"=>$nip))->row();
		$fam = $this->db->get_where("data_keluarga",array("nik"=>$nik))->row();
		
	  
		$msg = $this->m_reff->notifikasi(3,"wa");
		if(strtolower($db->jk)=="laki-laki"){
			$awalan = "Bpk";
		}elseif(strtolower($db->jk)=="perempuan"){
			$awalan = "Ibu";
		}else{
			$awalan = "";
		}
		if(strtolower($fam->jk)=="laki-laki"){
			$awalan_keluarga = "Bpk";
		}elseif(strtolower($fam->jk)=="perempuan"){
			$awalan_keluarga = "Ibu";
		}else{
			$awalan_keluarga = "";
		}

		
		if(strtolower($db->jk)=="laki-laki"){
			$awalan = "Bpk";
		}elseif(strtolower($db->jk)=="perempuan"){
			$awalan = "Ibu";
		}else{
			$awalan = "";
		}
		 
		$getRS = $this->db->get_where("tm_rs",array("kode"=>$kode_tempat))->row();
		$rs = isset($getRS->nama)?($getRS->nama):"";
		$rs_alamat = isset($getRS->alamat)?($getRS->alamat):"";
		$rs = $rs." - ".$rs_alamat;
		$msg = str_replace("{status}","Keluarga pegawai",$msg);
		$msg = str_replace("{nik}",$fam->nik,$msg);
		$msg = str_replace("{nama}",$fam->nama,$msg);
		$msg = str_replace("{email}",$db->email,$msg);
		// $msg = str_replace("{nama_keluarga}",$fam->nama,$msg);
		// $msg = str_replace("{awalan}",$awalan,$msg);
		$msg = str_replace("{awalan}",$awalan_keluarga,$msg);
		$msg = str_replace("{tempat_tes}",$rs,$msg);
		$msg = str_replace("{tgl_tes}",$this->tanggal->hariLengkap($tgl_test,"/"),$msg);

		$tahun = date("Y");
		$file = $this->m_reff->pengaturan(1).$tahun."/surat_rekomendasi/".$kode.".pdf";

		$param=array(
			"kode" =>$kode,
			"getRS" =>$getRS,
			"db" =>$db, //data pegawai
			"file" =>$file,
			"fam" =>$fam, //data keluarga
			"tgl_test" =>$tgl_test,
			"jenis_test" =>$jenis_test,
		);
		$this->genSRKeluarga($param);
	   $this->m_reff->kirimWa($db->no_hp,$msg,null);


		$subject = $this->m_reff->notifikasi(3,"subject"); //email
		$msg = $this->m_reff->notifikasi(3,"email"); //email
		$msg = str_replace("{status}","Keluarga pegawai",$msg);
		$msg = str_replace("{nik}",$fam->nik,$msg);
		$msg = str_replace("{nama}",$fam->nama,$msg);
		$msg = str_replace("{email}",$db->email,$msg);
		// $msg = str_replace("{nama_keluarga}",$fam->nama,$msg);
		// $msg = str_replace("{awalan}",$awalan,$msg);
		$msg = str_replace("{awalan}",$awalan_keluarga,$msg);
		$msg = str_replace("{tempat_tes}",$rs,$msg);
		$msg = str_replace("{tgl_tes}",$this->tanggal->hariLengkap($tgl_test,"/"),$msg);

		  $file = realpath($file);
		   $mail[] = array(
			   'path' => $file,
			   'femail' => $this->m_reff->sanitize($db->email),
			   'fsubject' => $subject. " - ".date('d-m-Y'),
			   'namaFile' => "Hasil Tes.pdf",
			   'fmessage' => $msg
		   );

	return $this->m_reff->kirimEmail($mail);
	}

	function genSRKeluarga($param){
		ob_start();
		//include('file.html');
		$data["kode_test"] = $kode=$param["kode"]; // kode test
		$data["getRS"] = $param["getRS"]; 
		$data["data"] = $param["db"]; // data pegawai
		$data["fam"] = $param["fam"]; // data family
		$data["tgl_test"] = $param["tgl_test"]; 
		$data["jenis_test"] = $param["jenis_test"]; 
		$file = $param["file"]; 
		 $this->m_reff->qr($kode);
	 	$html=$this->load->view('genSRKeluarga',$data,TRUE); 
		// $css=$kode;

 
			$mpdf = new \Mpdf\Mpdf([
				'mode' => 'utf-8', 
				'format' => 'A4-P',
				// 'margin_left' => 32,
				// 'margin_right' => 25,
				// 'margin_top' => 27,
				// 'margin_bottom' => 25,
				// 'margin_header' => 16,
				// 'margin_footer' => 13 
			]);
	 
			$mpdf->SetDisplayMode('fullpage');
		 	$mpdf->WriteHTML($html, 2);
			// $mpdf->Output(); // opens in browser
			$mpdf->Output($file, 'F'); // it downloads the file into the user system, with give name
	}

	function update(){
		$form 	 = $this->input->post("f");
		if(!isset($form)){ return false;}
		$id		 = $this->m_reff->san($this->input->post("id"));
		$acc 	 = $this->m_reff->san($this->input->post("acc"));
		if($acc=="acc"){
			$this->db->set("sts_acc",1);
		} 
		$this->db->set($form);
		$this->db->where("id",$id);
		$this->db->update("data_test");
		$var["token"] = $this->m_reff->getToken();

		if($acc=="acc"){
			$db = $this->db->get_where("data_test",array("id"=>$id))->row();
			$jenis = $this->db->get_where("tr_jenis_test",array("kode"=>$this->m_reff->san($this->input->post("f[kode_jenis]"))))->row();
			$jenis_test = isset($jenis->nama)?($jenis->nama):"";
			$this->kirimNotifSR($db->nip,$this->m_reff->san($this->input->post("f[kode_tempat]")),$db->kode,$db->tgl,$jenis_test);
		}

		if($this->input->post("f[kode_jenis]")=="04"){
					$tgl = $this->input->post("f[tgl]");
					$tgl = $this->tanggal->hariLengkap($tgl,"/");
					$msg = $this->m_reff->notifikasi(7,"wa");
					$msg = str_replace("{tgl}",$tgl,$msg);
					$this->db->where("kode_istana",$this->session->userdata("kode_istana"));
					$this->db->where("kode_biro",$this->session->userdata("kode_biro"));
					$this->db->where("level",4);
					$dbadmin	=	$this->db->get("admin")->result();
		
					foreach($dbadmin as $admin){
							$hp = $admin->telp;
							$this->m_reff->kirimWa($hp,$msg);
					}
		}

		return $var;
	}

	function update_family(){
		$this->m_reff->log("Persetujuan permohonan test covid keluarga","covid");
		$form 	 = $this->input->post("f");
		if(!isset($form)){return false;}
		$id		 = $this->m_reff->san($this->input->post("id"));

			if($this->session->userdata("level")=="pic_covid"){
				$this->db->set("sts_acc",1);
		   }else{
			$this->db->set("sts_acc",0);
		   }

	
		$this->db->set($form);
		$this->db->where("id",$id);
		$this->db->update("data_test_keluarga");
		$var["token"] = $this->m_reff->getToken();
		$db = $this->db->get_where("data_test_keluarga",array("id"=>$id))->row();

		$jenis = $this->db->get_where("tr_jenis_test",array("kode"=>$this->input->post("f[kode_jenis]")))->row();
		$jenis_test = isset($jenis->nama)?($jenis->nama):"";

		$param=array(
			"nip"=>$db->nip_pegawai,
			"nik"=>$db->nik,
			"kode_tempat" => $this->m_reff->san($this->input->post("f[kode_tempat]")),
			"kode" => $db->kode,
			"tgl_test" => $db->tgl,
			"jenis_test" => $jenis_test
		);
		$this->m_reff->qr($db->kode);
		$this->kirimNotifSRKeluarga($param);

		return $var;
	}
 

	function getDataKeluargaEdit(){
        $nik    = $this->m_reff->san($this->input->post("val"));
                  $this->db->or_where("nik",$nik);
        return    $this->db->get("data_keluarga")->row();
    }
	function getDataPegawaiEdit(){
        $val    = $this->m_reff->san($this->input->post("val"));
                  $this->db->or_where("nip",$val);
        return    $this->db->get("data_pegawai")->row();
    }

	function getDataPegawai(){
        $val    = $this->m_reff->san($this->input->post("val"));
                  $this->db->where("(nik ='".$val."' or nip ='".$val."'  or nip_baru ='".$val."')");
                  
                  $this->db->where("kode_istana",$this->session->userdata("kode_istana"));
                  $this->db->where("sts_test",0);
        return    $this->db->get("data_pegawai")->row();
    }

	function getDataPegawaiUntukKeluarga(){
        $val    = $this->m_reff->san($this->input->post("val"));
                  $this->db->where("(nik ='".$val."' or nip ='".$val."'  or nip_baru ='".$val."')");
				  $this->db->where("kode_istana",$this->session->userdata("kode_istana"));
                //   $this->db->where("sts_test",0);
        return    $this->db->get("data_pegawai")->row();
    }

	function generateKodeFamily(){
		$kode = $this->m_reff->acak(11);
		$cek = $this->db->get_where("data_test_keluarga",array("kode"=>$kode))->num_rows();
		if($cek){
			return $this->generateKodeFamily();
		}else{
			return $kode;
		}
	}
	
	function generateKode(){
		$kode = $this->m_reff->acak(10);
		$cek = $this->db->get_where("data_test",array("kode"=>$kode))->num_rows();
		if($cek){
			return $this->generateKode();
		}else{
			return $kode;
		}
	}

}




