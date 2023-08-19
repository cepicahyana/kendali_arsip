<?php

class Model_external extends CI_Model  {
    
	 
	function __construct()
    {
        parent::__construct();
    }
	function get_data()
	{
		 $this->_get_data();
		if($this->m_reff->san($this->input->post("length"))!=-1) 
		$this->db->limit($this->m_reff->san($this->input->post("length")),$this->m_reff->san($this->input->post("start")));
	 	return $this->db->get()->result();
		 
	}
	function _get_data()
	{
	 	     $kode_biro = $this->session->kode_biro;
		if($this->session->level=="pic_covid"){
			if($kode_biro){
				$this->db->where("nik in (select nik from data_external where kode_biro='".$this->m_reff->sanitize($kode_biro)."' )");
			 }else{
				$this->db->where("nik in (select nik from data_external where kode_istana='".$this->m_reff->sanitize($this->session->kode_istana)."' )");
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
					 "bagian"=>$searchkey, 				 
					 "nik"=>$searchkey, 				 				 
							   
					 );
					 $this->db->group_start()
							 ->or_like($query)
					 ->group_end();
					 
				 }	

			$this->db->order_by("id","desc");
			// $this->db->where("sts",0);
			$query=$this->db->from("data_test_external");
		return $query;
			 
		
		 
	}
	function setStsAcc(){
		$id  = $this->m_reff->san($this->input->post("id"));
		$sts = $this->m_reff->san($this->input->post("sts"));
		$this->db->set("sts_acc",$sts);
		$this->db->where("id",$id);
		return $this->db->update("data_test_external");
	}
 
	 
	function nip(){
		return $this->m_reff->nip();
	}
	function idu(){
		return $this->session->userdata("id");
	}
	public function count()
	{				
			$this->_get_data();
		return $this->db->get()->num_rows();
	}
	 
	function hapus(){
		$id    = $this->m_reff->san($this->input->post("id"));
		$nik   = $this->m_reff->san($this->input->post("nik"));
		// $kode   = $this->m_reff->san($this->input->post("kode"));

		// $this->db->where("kode_test",$kode);
		$this->db->where("nik",$nik);
		$this->db->set("sts_test",0);
		$this->db->update("data_external");


		$this->db->where("id",$id);
		$this->db->delete("data_test_external");
		$var["token"] = $this->m_reff->getToken();
		$this->m_reff->log("hapus tes covid external","covid");
		return $var;
	}
	function insert(){
		$form 	 = $this->input->post("f");
		$tgl_test = $this->m_reff->san($this->input->post("tgl_test"));
		$jk		  = $this->m_reff->san($this->input->post("jk"));
		$nik	 = $this->m_reff->san($this->input->post("f[nik]"));
		$email	 = $this->m_reff->san($this->input->post("f[email]"));
		$this->m_reff->log("Input data test external::".json_encode($form),"covid");
		$kode_utama	 = $this->m_reff->san($this->input->post("kode_test"));

		 
		$kode	 = $this->generateKode();
		$this->m_reff->qr($kode);

		$cek_data	=	$this->db->get_where("data_external",array("nik"=>$nik))->row();
		$sts 		= 	isset($cek_data->hasil)?($cek_data->hasil):"";
		if(isset($cek_data)){
			if($sts!="+"){
				$tgl = $this->tanggal->eng_($this->m_reff->san($this->input->post("tgl_lahir")),"-");
				
				$this->db->where("nik",$nik);
			 
				$this->db->set("kode_test",$kode);
				$this->db->set("jk",$jk);
				$this->db->set("tgl_lahir",$tgl);
				$this->db->set("kode_biro",$this->session->kode_biro);
				$this->db->set($form);
				$this->db->update("data_external");
				$this->m_reff->log("update data tes covid external","covid");
			}
		}else{
				$tgl = $this->tanggal->eng_($this->m_reff->san($this->input->post("tgl_lahir")),"-");
				
				$this->db->set("sts_test",1);
				$this->db->set("jk",$jk);
				$this->db->set("tgl_lahir",$tgl);
				$this->db->set("kode_biro",$this->session->kode_biro);
				$this->db->set($form);
				$this->db->set("kode_istana",$this->session->kode_istana);
				$this->db->set("kode_biro",$this->session->kode_biro);
				$this->db->insert("data_external");
				$this->m_reff->log("insert data tes covid external","covid");
		}
		
	
		

		$this->db->set(
			array(
 
			"_cid"		=>	$this->idu(),
			"_ctime"	=>	date("Y-m-d H:i:s"),
			"kode"		=>	$kode
			)
		);
		$this->db->set("sts_acc",1);
		unset($form["jk"]);
		unset($form["tempat_lahir"]);
		unset($form["tgl_lahir"]);
		unset($form["no_hp"]);
		unset($form["email"]);
		$this->db->set($form);
		if($sts=="+"){
			// $this->db->set("test_lanjutan",1);
			$this->db->set("kode_test_utama",$kode_utama);
		}
		$this->db->set("tgl",$tgl_test=$this->tanggal->eng_($tgl_test,"-"));
		$this->db->set("kode_istana",$this->session->kode_istana);
		$this->db->set("kode_biro",$this->session->kode_biro);
		$this->db->set("kode_jenis",$jenis_tes=$this->m_reff->san($this->input->post("kode_jenis")));
		$this->db->set("kode_tempat",$this->m_reff->san($this->input->post("kode_tempat")));
		$this->db->insert("data_test_external");
		 $var["token"] = $this->m_reff->getToken();
		$jenis = $this->db->get_where("tr_jenis_test",array("kode"=>$jenis_tes))->row();
		$jenis_tes = isset($jenis->nama)?($jenis->nama):"";

		$param=array(
			"email" => $email,
			"nik" => $nik,
			"kode_tempat" => $this->m_reff->san($this->input->post("kode_tempat")),
			"kode" => $kode,
			"tgl_test" => $tgl_test,
			"jenis_tes" => $jenis_tes,
		);
		$this->kirimNotifEx($param);
		return $var;
	}
	function kirimNotifEx($param){
		$this->db->order_by("id","desc");
		$db = $this->db->get_where("data_external",array("nik"=>$param["nik"]))->row();
		if(!isset($db)){ return false;}
	 
		$msg = $this->m_reff->notifikasi(5,"wa");
		if(strtolower($db->jk)=="laki-laki"){
			$awalan = "Bpk";
		}elseif(strtolower($db->jk)=="perempuan"){
			$awalan = "Ibu";
		}else{
			$awalan = "";
		}
		// $msg = str_replace("{nama}",$db->nama,$msg);
		// $msg = str_replace("{awalan}",$awalan,$msg);
		// $msg = str_replace("{rs}",$kode_tempat,$msg);
		$getRS = $this->db->get_where("tm_rs",array("kode"=>$param["kode_tempat"]))->row();
		$rs = isset($getRS->nama)?($getRS->nama):"";
		$rs_alamat = isset($getRS->alamat)?($getRS->alamat):"";
		$rs = $rs." - ".$rs_alamat;

		$msg = str_replace("{kode}",$param['kode'],$msg);
		$msg = str_replace("{kode_tes}",$param['kode'],$msg);
		$msg = str_replace("{email}",$param['email'],$msg);
		$msg = str_replace("{nik}",$db->nik,$msg);
		$msg = str_replace("{nama}",$db->nama,$msg);
		$msg = str_replace("{email}",$db->email,$msg);
		$msg = str_replace("{awalan}",$awalan,$msg);
		$msg = str_replace("{tempat_tes}",$rs,$msg);
		$msg = str_replace("{status}","non-pegawai",$msg);
		$msg = str_replace("{tgl_tes}",$this->tanggal->hariLengkap($param["tgl_test"],"/"),$msg);


		$tahun = date("Y");
		$file = $this->m_reff->pengaturan(1).$tahun."/surat_rekomendasi/".$param["kode"].".pdf";
		$param=array(
			"kode"=>$param["kode"],
			"getRS"=>$getRS,
			"db"=>$db,
			"file"=>$file,
			"tgl_test"=>$param["tgl_test"],
			"jenis_tes"=>$param["jenis_tes"]
		);
		 	   $this->genSRExternal($param);
		 $this->m_reff->kirimWa($db->no_hp,$msg,$file);


		 $subject = $this->m_reff->notifikasi(5,"subject"); //email
		 $msg = $this->m_reff->notifikasi(5,"email"); //email
		 $msg = str_replace("{kode}",$param['kode'],$msg);
		 $msg = str_replace("{kode_tes}",$param['kode'],$msg);
		 $msg = str_replace("{nik}",$db->nik,$msg);
		 $msg = str_replace("{nama}",$db->nama,$msg);
		 $msg = str_replace("{email}",$db->email,$msg);
		 $msg = str_replace("{awalan}",$awalan,$msg);
		 $msg = str_replace("{tempat_tes}",$rs,$msg);
		 $msg = str_replace("{status}","non-pegawai",$msg);
		 $msg = str_replace("{tgl_tes}",$this->tanggal->hariLengkap($param["tgl_test"],"/"),$msg);
 
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

	function genSRExternal($param){
		$kode = $param["kode"];
		$getRS = $param["getRS"];
		$db= $param["db"];
		$file = $param["file"];
		$tgl_test = $param["tgl_test"];
		$jenis_tes = $param["jenis_tes"];
		ob_start();
		//include('file.html');
		$data["kode_test"] = $kode; // kode test
		$data["getRS"] = $getRS; 
		$data["data"] = $db; // data pegawai
		$data["tgl_test"] = $tgl_test; 
		$data["jenis_tes"] = $jenis_tes; 
	 	$html=$this->load->view('genSRExternal',$data,TRUE); 
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
		if(!$form){ return false;	}
		$id		 = $this->m_reff->san($this->input->post("id"));

		$this->db->set("sts_acc",1);
		$this->db->set($form);
		$this->db->where("id",$id);
		$this->db->update("data_test_external");
		$var["token"] = $this->m_reff->getToken();
		$this->m_reff->log("update data test external","covid");
		return $var;
	}

	// function update_family(){
	// 	$form 	 = $this->input->post("f");
	// 	$id		 = $this->input->post("id");

	// 		if($this->session->userdata("level")=="pic"){
	// 			$this->db->set("sts_acc",1);
	// 	   }else{
	// 		$this->db->set("sts_acc",0);
	// 	   }

	
	// 	$this->db->set($form);
	// 	$this->db->where("id",$id);
	// 	$this->db->update("data_test_external_keluarga");
	// 	$var["token"] = $this->m_reff->getToken();
	// 	return $var;
	// }
 

	function getDataexternal(){
        $val    = $this->m_reff->san($this->input->post("val"));
                  $this->db->where("(nik ='".$val."')");
                  
                  $this->db->where("sts_test",0);
        return    $this->db->get("data_external")->row();
    }

	function getDataexternalEdit(){
        $val    = $this->m_reff->san($this->input->post("val"));
                  $this->db->where("nik",$val);
        return    $this->db->get("data_external")->row();
    }

	function generateKode(){
		$kode = $this->m_reff->acak(13);
		$cek = $this->db->get_where("data_test_external",array("kode"=>$kode))->num_rows();
		if($cek){
			return $this->generateKode();
		}else{
			return $kode;
		}
	}

}




