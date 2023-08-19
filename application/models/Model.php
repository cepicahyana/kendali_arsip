<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	 
	class Model extends CI_Model {

     function cek_kode($kode){
		return $this->db->get_where("v_test",array("kode"=>$kode))->row_array();
	 }

	 function update_hasil($request){
		  	$scan_time	=	$this->m_reff->input("reg");
		  	$hasil		=	$this->m_reff->input("hasil");
			  if(strtolower($hasil)=="positif"){
				  $hasil = "+";
			  }elseif(strtolower($hasil)=="negatif"){
				$hasil = "-";
				}
			// $id		= 	isset($request["id"])?($request["id"]):null;
			// $hasil		=	isset($request["hasil"])?($request["hasil"]):null;
			$kode		=	isset($request["kode"])?($request["kode"]):null;
			$id_hub		=	isset($request["id_hub"])?($request["id_hub"]):null;
			$nip		=	isset($request["nip"])?($request["nip"]):null;
			$nik		=	isset($request["nik"])?($request["nik"]):null;
			$kode_jenis	=	isset($request["kode_jenis"])?($request["kode_jenis"]):null;
			  
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
		 
		 if(isset($_FILES["file"]['tmp_name']))
		{
		$dok=$this->m_reff->pengaturan(1).date('Y')."/hasil";
		 
		 	// $before_file=$this->m_reff->goField("admin","poto","where id_admin='".$id."' ");
			$file=$this->m_reff->upload_file("file",$dok,$kode,"pdf",$sizeFile="5000000",null);
			if($file["validasi"]!=false)
			{ 
				
				$this->db->set("scan_time",$scan_time);
				$this->db->set("scan",1);
				$this->db->set("konfirm_rs",date("Y-m-d"));
				$this->db->set("hasil",$hasil);
				$this->db->set("kode_jenis",$kode_jenis);
				$this->db->set("file",date('Y')."/hasil/".$file["name"]);
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
			$var["gagal"] = true;
			$var["info"]  = "File not found!";
			return $var; 
		 }

	
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

	 
}
