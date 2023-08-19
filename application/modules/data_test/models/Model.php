<?php


// use PhpOffice\PhpSpreadsheet\Spreadsheet;
// use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Model extends CI_Model  {
    
	 
	function __construct()
    {
        parent::__construct();
    }
	function get_data()
	{
		 $this->_get_data();
		if($this->input->post("length")!=-1) 
		$this->db->limit($this->input->post("length"),$this->input->post("start"));
	 	return $this->db->get()->result();
		 
	}
	function scan(){

		// /5797592496
		$kode_rs = $this->m_reff->goField("tm_rs","kode","where id='".$this->m_reff->idu()."'");
		$val	 = $this->m_reff->san($this->input->post("val"));

		// $this->db->where("istana",$this->session->istana);
		$this->db->where("kode",$val);
		$this->db->or_where("nik",$val);
		// $this->db->or_where("nip",$val);
		$this->db->order_by("_ctime","desc");
		$cek = $this->db->get("v_test")->row();

		if(isset($cek->id)){

			$nama_rs = $this->m_reff->goField("tm_rs","nama","where kode='".$cek->kode_tempat."'");

			if($cek->scan==1){
				$var["gagal"]  = true;
				$var["info"]   = "Pemohon sudah pernah diregistrasi.";
				return $var;
			}elseif($cek->kode_tempat!=$kode_rs){
				$var["gagal"]  = true;
				$var["info"]   = "Tempat test dilakukan di ".$nama_rs;
				return $var;
			}elseif($cek->kode_istana!=$this->session->kode_istana){
				$var["gagal"]  = true;
				$var["info"]   = "Surat rekomendasi ini ditujuan untuk rumah sakit yang telah bekerja sama dengan ".$cek->istana;
				return $var;
			}elseif($cek->sts_acc==0){
				$var["gagal"]  = true;
				$var["info"]   = "Pemohon belum disetujui, silahkan pemohon menghubungi admin kantor.";
				return $var;
			}elseif($cek->tgl_permohonan>date('Y-m-d')){
				$var["gagal"]  = true;
				$var["info"]   = "Tanggal test tidak sesuai, Jadwal Test :".$this->tanggal->hariLengkap($cek->tgl_permohonan,"/");
				return $var;
			}else{
				$this->db->where("kode",$cek->kode);
				$this->db->set("scan",1);
				$this->db->set("scan_time",date('Y-m-d H:i:s'));
				$this->db->update($cek->tbl);
				$var["gagal"] = false;
				$var["info"] = "Tersedia!";
				return $var;
			}

		}else{
			$var["gagal"]  = true;
			$var["info"]   = "Data tidak ditemukan.";
			return $var;
		}

		// $this->db->where("kode",$val);
		// $this->db->where("acc",1);
		// $this->db->or_where("nik",$val);
		// $this->db->or_where("nip",$val);
		// $this->db->set("sts_acc",1);
		// $this->db->update("data_test");
		// $a1 = $this->db->affected_rows();

		// $this->db->where("kode",$val);
		// $this->db->or_where("nik",$val);
		// $this->db->set("scan",1);
		// $this->db->update("data_test_ppnpn");
		// $a2 = $this->db->affected_rows();
		// $a2=0;
		// $this->db->where("kode",$val);
		// $this->db->or_where("nik",$val);
		// $this->db->set("scan",1);
		// $this->db->set("sts_acc",1);
		// $this->db->update("data_test_keluarga");
		// $a3 = $this->db->affected_rows();

		// $this->db->where("kode",$val);
		// $this->db->or_where("nik",$val);
		// $this->db->set("scan",1);
		// $this->db->set("sts_acc",1);
		// $this->db->update("data_test_external");
		// $a4 = $this->db->affected_rows();

		// if($a1+$a2+$a3+$a4){
		// 	return "Tersedia!";
		// }else{
		// 	return "<b>Tidak tersedia<b><br>kemungkinan pengajuan belum di ACC atau  ";
		// }


	}
	function _get_data()
	{ 
		$kode = $this->kode_rs();
		if (strlen(isset($_POST['search']['value'])?($_POST['search']['value']):null)>1) {
				$searchkey = $_POST['search']['value'];
				$searchkey = $this->m_reff->sanitize($searchkey);

				$query=array(
				"nama"=>$searchkey, 				 		 
				"nik"=>$searchkey, 				 				 
				 		 
				);
				$this->db->group_start()
                        ->or_like($query)
                ->group_end();
				
			}
			$filter = $this->m_reff->san($this->input->post("filter"));
			if($filter==1){
				$this->db->where("konfirm_rs!=",null);
				$this->db->where("konfirm_rs>='".date("Y-m-d")."'");
			}elseif($filter==3){
				$this->db->where("konfirm_rs!=",null);
			}elseif($filter==2){
				$this->db->where("konfirm_rs",null);
			}else{
				$this->db->where("(konfirm_rs is null or konfirm_rs>='".date("Y-m-d")."' )");
			}

			//range tanggal
			$tgl  = $this->m_reff->san($this->input->post("range"));
			if($tgl){
				$tgl1 = $this->tanggal->range_1($tgl, 0);
				$tgl2 = $this->tanggal->range_2($tgl, 1);
				$this->db->where("konfirm_rs>=",$tgl1);
				$this->db->where("konfirm_rs<=",$tgl2);
			}
			//range tanggal
			
			$this->db->order_by("_ctime","desc");
			$this->db->where("kode_tempat",$kode);
			$this->db->where("sts_acc",1);
			$this->db->where("scan",1);
			$query=$this->db->from("v_test");
		return $query;
			 
		
		 
	}
	function hapus_progress(){
		$this->db->where("id",$this->input->post("id"));
		return $this->db->delete("data_kondisi");
	}
	function kode_rs(){
		$this->db->where("id",$this->session->userdata("id"));
		$db =  $this->db->get("tm_rs")->row();
		return isset($db->kode)?($db->kode):"";
	}
	public function count()
	{				
			$this->_get_data();
		return $this->db->get()->num_rows();
	}
	 
 
	function upload_file($request=null){
		if(!$request){
			$id		=	$this->m_reff->sanitize($this->input->post("id"));
			$hasil	=	$this->m_reff->sanitize($this->input->post("hasil"));
			$kode	=	$this->m_reff->sanitize($this->input->post("kode"));
			$id_hub	=	$this->m_reff->sanitize($this->input->post("id_hub"));
			$nip	=	$this->m_reff->sanitize($this->input->post("nip"));
			$nik	=	$this->m_reff->sanitize($this->input->post("nik"));
			$kode_jenis	=	$this->m_reff->san($this->input->post("kode_jenis"));
		}else{
			$id		= 	isset($request["id"])?($request["id"]):null;
			$hasil	=	isset($request["hasil"])?($request["hasil"]):null;
			$kode	=	isset($request["kode"])?($request["kode"]):null;
			$id_hub	=	isset($request["id_hub"])?($request["id_hub"]):null;
			$nip	=	isset($request["nip"])?($request["nip"]):null;
			$nik	=	isset($request["nik"])?($request["nik"]):null;
			$kode_jenis	=	isset($request["kode_jenis"])?($request["kode_jenis"]):null;
			 
							$tambahan = array(
								"hasil_ref"			=>	isset($request["hasil_ref"])?($request["hasil_ref"]):"",
								"no_lab"			=>	isset($request["no_lab"])?($request["no_lab"]):"",
								"cto_result"				=>	isset($request["cto_result"])?($request["cto_result"]):"",
								"cto_value"					=>	isset($request["cto_value"])?($request["cto_value"]):"",
								"ctn_result"				=>	isset($request["ctn_result"])?($request["ctn_result"]):"",
								"ctn_value"					=>	isset($request["ctn_value"])?($request["ctn_value"]):"",
								"sampling"			=>	isset($request["sampling"])?($request["sampling"]):"",
								"received"			=>	isset($request["received"])?($request["received"]):"",
								"clinical"			=>	isset($request["clinical"])?($request["clinical"]):"",
								"validator"			=>	isset($request["validator"])?($request["validator"]):"",
								"validator_time"	=>	isset($request["validator_time"])?($request["validator_time"]):"",
								"qrcode"			=>	isset($request["qrcode"])?($request["qrcode"]):"",
								"cosid"				=>	isset($request["cosid"])?($request["cosid"]):"",
					
							); 
						 


		}


	 
		if($id_hub=="id_hub"){
			$tbl 			= "data_test";
			$tblpeg 		= "data_pegawai";
			$tbl_kondisi 	= "data_kondisi";
		}elseif($id_hub=="external"){
			$tbl 			= "data_test_external";
			$tblpeg 		= "data_external";
			$tbl_kondisi 	= "data_kondisi_external";
		}else{
			$tbl 			= "data_test_keluarga";
			$tblpeg 		= "data_keluarga";
			$tbl_kondisi 	= "data_kondisi_keluarga";
		}

		
		
 
		 
			$this->db->where("kode",$kode);
			$db = $this->db->get($tbl)->row();
			$kode_istana = isset($db->kode_istana)?($db->kode_istana):null;
			$kode_biro   = isset($db->kode_biro)?($db->kode_biro):null;

			if($tblpeg=="data_external"){
				$dbm   = $this->db->get_where($tblpeg,array("nik"=>$nik))->row();
				$email = isset($dbm->email)?($dbm->email):null;
				$no_hp = isset($dbm->no_hp)?($dbm->no_hp):null;;
			}else{
				$dbm   = $this->db->get_where("data_pegawai",array("nip"=>$nip))->row();
				$email = isset($dbm->email)?($dbm->email):null;
				$no_hp = isset($dbm->no_hp)?($dbm->no_hp):null;;
			}
			


			$kode_utama = isset($db->kode_test_utama)?($db->kode_test_utama):null;
		  
				if($hasil=="-" and $kode_utama){
						 
				$this->db->set("sts",1);
				$this->db->where("(kode='".$kode_utama."' or kode_test_utama='".$kode_utama."' )");
				$this->db->update($tbl);

				$this->db->set("sts",1);
				$this->db->where("(kode_test='".$kode_utama."' or kode_test_utama='".$kode_utama."' )");
				$this->db->update($tbl_kondisi);
			 
				}elseif($hasil=="-" and !$kode_utama){

							$this->db->set("sts",1);
							$this->db->where("kode",$kode);
							$this->db->update($tbl);

							$this->db->set("sts",1);
							$this->db->where("kode_test",$kode);
							$this->db->update($tbl_kondisi);
				} 
				

 
		 
		$var["validasi"]=true; 
		 
		 if(isset($_FILES["userfile"]['tmp_name']))
		{  
		$dok=$this->m_reff->pengaturan(1).date('Y')."/hasil";
		 
		 	// $before_file=$this->m_reff->goField("admin","poto","where id_admin='".$id."' ");
			$file=$this->m_reff->upload_file("userfile",$dok,$kode,"pdf",$sizeFile="5000000",null);
			if($file["validasi"]!=false)
			{ 
				
				$this->db->set("konfirm_rs",date("Y-m-d"));
				$this->db->set("hasil",$hasil);
				$this->db->set("kode_jenis",$kode_jenis);
				$this->db->set("file",date('Y')."/hasil/".$file["name"]);
				// $this->db->set("sts",1);
				$this->db->where("kode",$kode);
				$this->db->update($tbl);

						$this->db->where("nik",$nik);
						$this->db->set("sts_test",0);
						$this->db->set("hasil_test",$hasil);
						if($hasil=="-"){
						// $this->db->set("level_indikasi",null);
						$this->db->set("kode_test",null);
						$this->db->set("tgl_test",null);
						}

						if(!$kode_utama){
							$this->db->set("tgl_test",date('Y-m-d'));
							$this->db->set("kode_test",$kode);
						}

						$this->db->update($tblpeg);

						///broadcast
						// $db  = $this->db->get_where($tblpeg,array("id"=>$id))->row();
						// $msg = $this->m_reff->pengaturan(23);
						// if(strtolower($db->jk)=="laki-laki"){
						// 	$awalan = "Bpk";
						// }elseif(strtolower($db->jk)=="perempuan"){
						// 	$awalan = "Ibu";
						// }else{
						// 	$awalan = "";
						// }cepi
						// $email = isset($db->email)?($db->email):null;
						$kode_tempat = $this->m_reff->goField("tm_rs","nama","where kode='".$db->kode_tempat."' ");
						$msg = $this->m_reff->notifikasi(1,"wa");
						$msg = str_replace("{nama}",$db->nama,$msg);
						$msg = str_replace("{nik}",$db->nik,$msg);
						$msg = str_replace("{email}",$email,$msg);
						// $msg = str_replace("{awalan}",$awalan,$msg);

						$msg = str_replace("{rs}",$kode_tempat,$msg);
						$msg = str_replace("{tempat_tes}",$kode_tempat,$msg);
						$msg = str_replace("{tgl}",$this->tanggal->hariLengkap(date('Y-m-d'),"/")." ".date('H:i:s')." WIB.",$msg);
					 
						$tgl_test = isset($db->tgl_permohonan)?($db->tgl_permohonan):date('Y');
						$tahun= substr($tgl_test,0,4);
						$file = $this->m_reff->pengaturan(1).$tahun."/hasil/".$file["name"];
						
						$this->m_reff->counterNotif($kode_istana,$kode_biro);
						
						if($tblpeg!="data_external"){


							$subject = $this->m_reff->notifikasi(4,"subject"); //email
							$msg = $this->m_reff->notifikasi(4,"email"); //email
							$msg = str_replace("{nama}",$db->nama,$msg);
							$msg = str_replace("{nik}",$db->nik,$msg);
							$msg = str_replace("{email}",$email,$msg);
							// $msg = str_replace("{awalan}",$awalan,$msg);

							$msg = str_replace("{rs}",$kode_tempat,$msg);
							$msg = str_replace("{tempat_tes}",$kode_tempat,$msg);
							$msg = str_replace("{tgl}",$this->tanggal->hariLengkap(date('Y-m-d'),"/")." ".date('H:i:s')." WIB.",$msg);
					 
							  $file = realpath($file);
							   $mail[] = array(
								   'path' => $file,
								   'femail' => $this->m_reff->sanitize($email),
								   'fsubject' => $subject. " - ".date('d-m-Y'),
								   'namaFile' => "Hasil Tes.pdf",
								   'fmessage' => $msg
							   );
					
						 $this->m_reff->kirimEmail($mail);




							return $this->m_reff->kirimWa($no_hp,$msg,null);
						}else{


							$msg =  $this->m_reff->notifikasi(4,"wa");
							$msg = str_replace("{email}",$email,$msg);
							$msg = str_replace("{nama}",$db->nama,$msg);
							$msg = str_replace("{nik}",$db->nik,$msg);
							// $msg = str_replace("{awalan}",$awalan,$msg);

							$msg = str_replace("{rs}",$kode_tempat,$msg);
							$msg = str_replace("{tempat_tes}",$kode_tempat,$msg);
							$msg = str_replace("{tgl}",$this->tanggal->hariLengkap(date('Y-m-d'),"/")." ".date('H:i:s')." WIB.",$msg);
							$this->m_reff->kirimWa($no_hp,$msg,null);
						
						
						
							$subject = $this->m_reff->notifikasi(4,"subject"); //email
							$msg = $this->m_reff->notifikasi(4,"email"); //email
							$msg = str_replace("{email}",$email,$msg);
							$msg = str_replace("{nama}",$db->nama,$msg);
							$msg = str_replace("{nik}",$db->nik,$msg);
							// $msg = str_replace("{awalan}",$awalan,$msg);

							$msg = str_replace("{rs}",$kode_tempat,$msg);
							$msg = str_replace("{tempat_tes}",$kode_tempat,$msg);
							$msg = str_replace("{tgl}",$this->tanggal->hariLengkap(date('Y-m-d'),"/")." ".date('H:i:s')." WIB.",$msg);
					 
							  $file = realpath($file);
							   $mail[] = array(
								   'path' => $file,
								   'femail' => $this->m_reff->sanitize($email),
								   'fsubject' => $subject. " - ".date('d-m-Y'),
								   'namaFile' => "Hasil Tes.pdf",
								   'fmessage' => $msg
							   );
					
						return $this->m_reff->kirimEmail($mail);


							 
						}

			}else{
				$var["gagal"] = true;
				$var["info"]  = $file["info"];
				$var["token"] = $this->m_reff->getToken();
				return $var; 
			}
		$var=$file;
		}else{


			$tgl_test = isset($db->tgl_permohonan)?($db->tgl_permohonan):date('Y');
			$tahun    = substr($tgl_test,0,4);
			$file = $tahun."/hasil/Doc-".$kode;

			



			$this->db->set("konfirm_rs",date("Y-m-d"));
			$this->db->set("hasil",$hasil);
			$this->db->set("kode_jenis",$kode_jenis);
			$this->db->set("file",$file.".pdf");
			$this->db->set($tambahan);
			// $this->db->set("sts",1);
			$this->db->where("kode",$kode);
			$this->db->update($tbl);
			

					$this->db->where("nik",$nik);
					$this->db->set("sts_test",0);
					$this->db->set("hasil_test",$hasil);
					if($hasil=="-"){
					// $this->db->set("level_indikasi",null);
					$this->db->set("kode_test",null);
					$this->db->set("tgl_test",null);
					}

					if(!$kode_utama){
						$this->db->set("tgl_test",date('Y-m-d'));
						$this->db->set("kode_test",$kode);
					}

					$this->db->update($tblpeg);


					$this->db->where("kode",$kode);
					$db = $this->db->get($tbl)->row();
					$this->genHasilMPdf($kode,$db,$file,$tgl_test,$kode_jenis,$tblpeg);
					///broadcast
					// $db  = $this->db->get_where($tblpeg,array("id"=>$id))->row();
					// $msg = $this->m_reff->pengaturan(23);
					// if(strtolower($db->jk)=="laki-laki"){
					// 	$awalan = "Bpk";
					// }elseif(strtolower($db->jk)=="perempuan"){
					// 	$awalan = "Ibu";
					// }else{
					// 	$awalan = "";
					// }
					$kode_tempat = $this->m_reff->goField("tm_rs","nama","where kode='".$db->kode_tempat."' ");
					$msg = $this->m_reff->notifikasi(1,"wa");
					$msg = str_replace("{email}",$email,$msg);
					$msg = str_replace("{nama}",$db->nama,$msg);
					$msg = str_replace("{nik}",$db->nik,$msg);
					// $msg = str_replace("{awalan}",$awalan,$msg);

					$msg = str_replace("{rs}",$kode_tempat,$msg);
					$msg = str_replace("{tempat_tes}",$kode_tempat,$msg);
					$msg = str_replace("{tgl}",$this->tanggal->hariLengkap(date('Y-m-d'),"/")." ".date('H:i:s')." WIB.",$msg);
				 
					$this->m_reff->counterNotif($kode_istana,$kode_biro);
					if($tblpeg!="data_external"){
						  $this->m_reff->kirimWa($no_hp,$msg,null);


						$subject = $this->m_reff->notifikasi(4,"subject"); //email
						$msg = $this->m_reff->notifikasi(4,"email"); //email
						$msg = str_replace("{email}",$email,$msg);
						$msg = str_replace("{nama}",$db->nama,$msg);
						$msg = str_replace("{nik}",$db->nik,$msg);
						// $msg = str_replace("{awalan}",$awalan,$msg);

						$msg = str_replace("{rs}",$kode_tempat,$msg);
						$msg = str_replace("{tempat_tes}",$kode_tempat,$msg);
						$msg = str_replace("{tgl}",$this->tanggal->hariLengkap(date('Y-m-d'),"/")." ".date('H:i:s')." WIB.",$msg);
						  $file = $this->m_reff->pengaturan(1).$file;
						  $file = realpath($file);
						   $mail[] = array(
							   'path' => $file,
							   'femail' => $this->m_reff->sanitize($email),
							   'fsubject' => $subject. " - ".date('d-m-Y'),
							   'namaFile' => "Hasil Tes.pdf",
							   'fmessage' => $msg
						   );
				
					return $this->m_reff->kirimEmail($mail);



					}else{
						$msg =  $this->m_reff->notifikasi(4,"wa");
						$msg = str_replace("{nama}",$db->nama,$msg);
						$msg = str_replace("{nik}",$db->nik,$msg);
						$msg = str_replace("{email}",$email,$msg);
						// $msg = str_replace("{awalan}",$awalan,$msg);

						$msg = str_replace("{rs}",$kode_tempat,$msg);
						$msg = str_replace("{tempat_tes}",$kode_tempat,$msg);
						$msg = str_replace("{tgl}",$this->tanggal->hariLengkap(date('Y-m-d'),"/")." ".date('H:i:s')." WIB.",$msg);
				 

						  $this->m_reff->kirimWa($no_hp,$msg,null);


						  $subject = $this->m_reff->notifikasi(4,"subject"); //email
						$msg = $this->m_reff->notifikasi(4,"email"); //email
						$msg = str_replace("{nama}",$db->nama,$msg);
						$msg = str_replace("{nik}",$db->nik,$msg);
						$msg = str_replace("{email}",$email,$msg);
						// $msg = str_replace("{awalan}",$awalan,$msg);

						$msg = str_replace("{rs}",$kode_tempat,$msg);
						$msg = str_replace("{tempat_tes}",$kode_tempat,$msg);
						$msg = str_replace("{tgl}",$this->tanggal->hariLengkap(date('Y-m-d'),"/")." ".date('H:i:s')." WIB.",$msg);
						  $file = $this->m_reff->pengaturan(1).$file;
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


		  

		}




		$var["token"]=$this->m_reff->getToken();
		return $var;
	}
	function genHasilMPdf($kode,$db,$file,$tgl_test,$jenis_test,$tblpeg){
		$data["tblpeg"] = $tblpeg; 
		$data["tgl_test"] = $tgl_test; 
		$data["kode_test"] = $kode; // kode test
		$data["getRS"] = $this->db->get("tm_rs",array("id"=>$this->session->userdata("id")))->row();
		$data["data"] = $db; // data pegawai
		$data["jenis_test"] = $jenis_test; // data pegawai
		// $data["tambahan"] = $tambahan; // data pegawai
		$this->m_reff->qr($kode);
		$this->m_reff->qr($db->qrcode);


		$mpdf = new \Mpdf\Mpdf();
		$mpdf->SetDisplayMode('fullpage');
		$mpdf->AddPageByArray([
			'margin-left' => 0,
			'margin-right' => 0,
			'margin-top' => 10,
			'margin-bottom' => 0,
		]);
		$mpdf->SetHTMLFooter('<img style="margin-left:550px"  src="'.base_url().'plug/rs/bunda/logo.png"/>');
		if($jenis_test=="01"){//rapid
			$html = $this->load->view("genHasilRapid",$data,true);
		}elseif($jenis_test=="02"){ //antigen
			$html = $this->load->view("genHasilAG",$data,true);
		}else{ //swab
			$html = $this->load->view("genHasilPcr",$data,true);
		}
		$mpdf->WriteHTML($html);
		ob_clean();
		$path=$this->m_reff->pengaturan("1");
		$mpdf->Output($path."/".$file.".pdf","F");
	 }

	// function genHasilPdf($kode,$db,$file,$tgl_test,$jenis_test,$tambahan){
	// 	$this->load->library('pdf');
	// 	$file = $this->m_reff->pengaturan(1).$file;
	// 	ob_start();
	// 	//include('file.html');
	// 	$data["tgl_test"] = $tgl_test; 
	// 	$data["kode_test"] = $kode; // kode test
	// 	$data["getRS"] = $this->db->get("tm_rs",array("id"=>$this->session->userdata("id")))->row();
	// 	$data["data"] = $db; // data pegawai
	// 	$data["jenis_test"] = $jenis_test; // data pegawai
	// 	$data["tambahan"] = $tambahan; // data pegawai
	// 	$this->m_reff->qr($kode);
	//     $html = $this->load->view('genHasilPdf',$data,TRUE); 
	// 	// $css=$kode;
       
 
        
	// 	$paper_size = 'A4';
    //     $orientation = 'potrait';
    //     // $html = $this->output->get_output();
    //     $this->pdf->set_paper($paper_size, $orientation);

    //     $this->pdf->load_html($html);
    //     $this->pdf->render();
	// 	$output = $this->pdf->output();
    //     $this->pdf->stream($file.".pdf",array("Attachment" => false));
	// 	// file_put_contents('Brochure.pdf', $output);

	// 		// $mpdf = new \Mpdf\Mpdf([
	// 		// 	'mode' => 'utf-8', 
	// 		// 	'format' => 'A4-P',
	// 		// 	// 'margin_left' => 32,
	// 		// 	// 'margin_right' => 25,
	// 		// 	// 'margin_top' => 27,
	// 		// 	// 'margin_bottom' => 25,
	// 		// 	// 'margin_header' => 16,
	// 		// 	// 'margin_footer' => 13 
	// 		// ]);
	
	// 		// $stylesheet = file_get_contents($css);
	// 		// $mpdf->SetDisplayMode('fullpage');
	// 		// $mpdf->WriteHTML($stylesheet, 1); // The parameter 1 tells that this is css/style only and no body/html/text
	// 		// $mpdf->WriteHTML($html, 2);
	// 		// $mpdf->Output(); // opens in browser
	// 		// $mpdf->Output($file.".pdf", 'F'); // it downloads the file into the user system, with give name
	// }





	function import(){
		$this->m_reff->log("import data tes ole RS","COVID");
		 
		$file_form="userfileImport";
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
					if ($i > 2) {
							$kode 	=	$this->m_reff->sanex(isset($sheet[1])?($sheet[1]):"");
							$nama 	=	$this->m_reff->sanex(isset($sheet[2])?($sheet[2]):"");
							// $nolab	=	$this->m_reff->san(isset($sheet[3])?($sheet[3]):"");
							$hasil1	=	$this->m_reff->sanex(isset($sheet[6])?($sheet[6]):"");
							$hasil1  =	$this->m_reff->sanex(trim(strtolower($hasil1)));
					
							if($hasil1=="negatif"){
								$hasil1 = "-";
							}elseif($hasil1=="positif"){
								$hasil1 = "+";
							}
							$lab  			=	$this->m_reff->sanex(isset($sheet[5])?($sheet[5]):"");
							$ref_value  	=	$this->m_reff->sanex(isset($sheet[7])?($sheet[7]):"");
							$cto_result  	=	$this->m_reff->sanex(isset($sheet[8])?($sheet[8]):"");
							$cto_value  	=	$this->m_reff->sanex(isset($sheet[9])?($sheet[9]):"");
							$ctn_result  	=	$this->m_reff->sanex(isset($sheet[10])?($sheet[10]):"");
							$ctn_value  	=	$this->m_reff->sanex(isset($sheet[11])?($sheet[11]):"");
							$sampling	  	=	$this->m_reff->sanex(isset($sheet[12])?($sheet[12]):"");
							$received  		=	$this->m_reff->sanex(isset($sheet[13])?($sheet[13]):"");
							// $lab	  		=	$this->m_reff->sanex(isset($sheet[14])?($sheet[14]):"");
							$cosid	  		=	$this->m_reff->sanex(isset($sheet[14])?($sheet[14]):"");
							$clinical	  		=	$this->m_reff->sanex(isset($sheet[15])?($sheet[15]):"");
							$validator	  		=	$this->m_reff->sanex(isset($sheet[16])?($sheet[16]):"");
							$validator_time		=	$this->m_reff->sanex(isset($sheet[17])?($sheet[17]):"");
							$qrcode		  		=	$this->m_reff->sanex(isset($sheet[18])?($sheet[18]):"");

							$hasil	=	$this->cekKode($kode);

						   if(isset($hasil->kode)){
								$req = array(
									"id"			=>	isset($hasil->id)?($hasil->id):"",
									"hasil"			=>	$hasil1,//isset($hasil->hasil)?($hasil->hasil):"",
									"hasil_ref"		=>	$ref_value,//isset($hasil->ref_value)?($hasil->ref_value):"",
									"kode"			=>	isset($hasil->kode)?($hasil->kode):"",
									"id_hub"		=>	isset($hasil->id_hub)?($hasil->id_hub):"",
									"nip"			=>	isset($hasil->nip)?($hasil->nip):"",
									"nik"			=>	isset($hasil->nik)?($hasil->nik):"",
									"kode_jenis"	=>	isset($hasil->kode_jenis)?($hasil->kode_jenis):"",
									"no_lab"		=>	isset($lab)?($lab):"",
									"cto_result"				=>	isset($cto_result)?($cto_result):"",
									"cto_value"					=>	isset($cto_value)?($cto_value):"",
									"ctn_result"				=>	isset($ctn_result)?($ctn_result):"",
									"ctn_value"					=>	isset($ctn_value)?($ctn_value):"",
									"sampling"		=>	isset($sampling)?($sampling):"",
									"received"		=>	isset($received)?($received):"",
									"clinical"		=>	isset($clinical)?($clinical):"",
									"validator"		=>	isset($validator)?($validator):"",
									"validator_time"	=>	isset($validator_time)?($validator_time):"",
									"qrcode"	=>	isset($qrcode)?($qrcode):"",
									"cosid"	=>	isset($cosid)?($cosid):"",
						
								); 
								if($hasil1){
									$this->upload_file($req);
								}
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

	function cekKode($kode){
		$this->db->where("kode",$kode);
		return $this->db->get("v_test")->row();
	}
	 
}




