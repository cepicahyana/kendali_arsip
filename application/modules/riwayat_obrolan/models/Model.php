<?php

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
	function _get_data()
	{ 
		$kode = $this->kode_rs();
		if(isset($_POST['search']['value'])?($_POST['search']['value']):""){
			$searchkey = $_POST['search']['value']; 
			$searchkey = $this->m_reff->sanitize($searchkey);

				$query=array(
				"nama"=>$searchkey, 				 		 	 
				);
				$this->db->group_start()
                        ->or_like($query)
                ->group_end();
				
			}
	
			$this->db->order_by("tgl","desc");
			if($this->session->level=="pic_covid"){
				if($this->session->kode_biro){
					$this->db->where("id_sender in (select id from data_pegawai where  kode_biro='".$this->session->kode_biro."') ");	
				}else{
					$this->db->where("id_sender in (select id from data_pegawai where kode_istana='".$this->session->kode_istana."' ) ");	
				}
		}
		
			$query=$this->db->from("data_tanya_dokter");
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
	 
 
	function upload_file(){
		$hasil	=	$this->m_reff->sanitize($this->input->post("hasil"));
		$kode	=	$this->m_reff->sanitize($this->input->post("kode"));
		$id_hub	=	$this->m_reff->sanitize($this->input->post("id_hub"));
		if($id_hub=="id_hub"){
			$tbl 	= "data_test";
			$tblpeg = "data_pegawai";
			$tbl_kondisi = "data_kondisi";
		}else{
			$tbl = "data_test_keluarga";
			$tblpeg = "data_keluarga";
			$tbl_kondisi = "data_kondisi_keluarga";
		}

		
		 
		$kode_jenis	=	$this->input->post("kode_jenis");
		$nik		=	$this->input->post("nik");
		 
			$this->db->where("kode",$kode);
			$db = $this->db->get($tbl)->row();
			$kode_utama = isset($db->kode_test_utama)?($db->kode_test_utama):null;
		  
				if($hasil=="-" and $kode_utama){
						 
				$this->db->set("sts",1);
				$this->db->where("(kode='".$kode_utama."' or kode_test_utama='".$kode_utama."' )");
				$this->db->update($tbl);

				$this->db->set("sts",1);
				$this->db->where("(kode='".$kode_utama."' or kode_test_utama='".$kode_utama."' )");
				$this->db->update($tbl_kondisi);
			 
				}elseif($hasil=="-" and !$kode_utama){

							$this->db->set("sts",1);
							$this->db->where("kode",$kode);
							$this->db->update($tbl);

							$this->db->set("sts",1);
							$this->db->where("kode",$kode);
							$this->db->update($tbl_kondisi);
				} 
				

 
		 
		$var["validasi"]=true; 
		 
		 if(isset($_FILES["userfile"]['tmp_name']))
		{  
		$dok=$this->m_reff->pengaturan(25)."/hasil";
		 
		 	// $before_file=$this->m_reff->goField("admin","poto","where id_admin='".$id."' ");
			$file=$this->m_reff->upload_file("userfile",$dok,$kode,"pdf",$sizeFile="5000000",null);
			if($file["validasi"]!=false)
			{ 
				
				$this->db->set("konfirm_rs",date("Y-m-d"));
				$this->db->set("hasil",$hasil);
				$this->db->set("kode_jenis",$kode_jenis);
				$this->db->set("file",$file["name"]);
				// $this->db->set("sts",1);
				$this->db->where("kode",$kode);
				$this->db->update($tbl);

						$this->db->where("nik",$nik);
						$this->db->set("sts_test",0);
						$this->db->set("hasil_test",$hasil);
						if($hasil=="-"){
						$this->db->set("kode_test",null);
						$this->db->set("tgl_test",null);
						}

						if(!$kode_utama){
							$this->db->set("tgl_test",date('Y-m-d'));
						}

						$this->db->update($tblpeg);

			}else{
				$var["gagal"] = true;
				$var["info"]  = $file["info"];
				$var["token"] = $this->m_reff->getToken();
				return $var; 
			}
		$var=$file;
		} 
		$var["token"]=$this->m_reff->getToken();
		return $var;
	}
	function idu(){
		return $this->session->id;
	}
	 
	function jml_obrolan($id)
	{
		$this->db->where("id_msg", $id);
		return	$this->db->get("data_komentar_admin")->num_rows();
	}
	function respon_akhir($id){
		$this->db->where("id_msg", $id);
		$this->db->order_by("tgl","desc");
		$db = $this->db->get("data_komentar_admin")->row();
		$res = isset($db->id_sender)?($db->id_sender):"";
		if(!$res){
			return "<span class='text-secondary'>1 Pesan baru</span>";
		}elseif($res==$this->idu()){
			return "<span class='text-secondary'>Membalas</span>";
		}else{
			return "<span class='text-secondary'>1 Pesan baru</span>";
		}
	}
	function saveChat(){
		$id_msg   = $this->input->post("id_msg");
		$msg	  = $this->m_reff->san($this->input->post("msg"));
		if(!$msg){ return false;}
		$this->db->set("id_msg",$id_msg);
		$this->db->set("id_sender",$this->idu());
		$this->db->set("msg",$msg);
		$this->db->set("tgl",date('Y-m-d H:i:s'));
		return $this->db->insert("data_komentar_admin");
	}
	function getLastChat(){
		$id_msg   = $this->input->post("id_msg");
		$msg	  = $this->m_reff->san($this->input->post("msg"));
		if(!$msg){ return false;}
		$this->db->where("id_msg",$id_msg);
		$this->db->where("id_sender",$this->idu());
		$this->db->where("msg",$msg);
		return $this->db->get("data_komentar_admin")->row();
	}
	function hapus_chat_list(){
		$id		  = $this->input->post("id");
		$this->db->where("id",$id);
		$this->db->where("id_sender",$this->idu());
		return $this->db->delete("data_komentar_admin");
	}
	function akhiri_obrolan(){
		$id		  = $this->input->post("id");
		$this->db->where("id",$id);
		// $this->db->where("id_sender",$this->idu());
		$this->db->set("sts",1);
		return $this->db->update("data_tanya_admin");
	}
}




