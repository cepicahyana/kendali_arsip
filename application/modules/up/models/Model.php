<?php
class Model extends CI_Model
{
 
	public function __construct() {
        parent::__construct();
    }
	
	 
	function getInfo(){
		$this->db->where("sts",1);
		$this->db->order_by("tgl","desc");
		return $this->db->get("data_informasi")->result();
	}
	
	function getKelas($id){
		$this->db->order_by("nama_kelas","asc");
		$this->db->where("id_tingkat",$id);
		return $this->db->get("tr_kelas")->result();
	}
	function getPendidikan(){
		 
		return $this->db->get("tr_jp")->result();
	}function getGoldar(){
		 
		return $this->db->get("tr_goldar")->result();
	}function getTahun(){
		 
		return $this->db->get("tr_tahun")->result();
	}function getProfesi(){
		 
		return $this->db->get("tr_pekerjaan")->result();
	}function getAgama(){
		 
		return $this->db->get("tr_agama")->result();
	}
	function upload(){
				$dok="upload/dp";
				$before_file = $this->m_reff->goField("data_pegawai","foto","where id='".$this->m_reff->idu()."'");
				$file=$this->m_reff->upload_file("userfile",$dok,$this->m_reff->idu()."_image_".date("His"),"JPG,JPEG,PNG,png,jpg,jpeg",$sizeFile="250000000",$before_file);
				print_r($file);
				if($file["validasi"]!=false)
				{ 
					$this->db->where("id",$this->m_reff->idu()); 
					$this->db->set("foto",$file["name"]);
					$this->db->update("data_pegawai");
				}
	}
	function cek($username,$pass){
		$this->db->where("id!=",$this->m_reff->idu());
		$this->db->where("username",$username);
		$this->db->where("password",$pass);
		return $this->db->get("data_pegawai")->num_rows();
	}function cekEmail($email,$hp){
		 
		$this->db->where("(email = '".$email."' or no_hp='".$hp."') and id!='".$this->m_reff->idu()."'" );
		 
		return $this->db->get("data_pegawai")->num_rows();
	}
	function save_password(){
		$username = $this->input->post("username");
		$pass     = $this->input->post("pass");
		$md5	  = md5($pass);
		$cek = $this->mdl->cek($username,$md5);
		if($cek){
			return false;
		}
		$this->db->where("id",$this->m_reff->idu());
		$this->db->set("username",$username);
		$this->db->set("password",$md5);
		return $this->db->update("data_pegawai");
	}
	function update_last(){
		$this->db->where("id",$this->m_reff->idu()); 
		$this->db->set("last_login",date('Y-m-d H:i:s'));
		return $this->db->update("data_pegawai");
	}
	
	function update(){
		$tgl	=	$this->input->post("tgl");
		if($tgl){
			$tgl	=	$this->tanggal->eng_($tgl,"-");
			$this->db->set("tgl_lahir",$tgl);
		}
		
		$email = $this->input->post("email");
		$hp     = $this->input->post("no_hp");
		if($email){
			$cek=$this->cekEmail($email,$hp);
			if(!$cek){
				$this->db->set("email",$email);
				$this->db->set("no_hp",$hp);
			}
		}
		$post = $this->input->post("f"); 
		$this->db->where("id",$this->m_reff->idu());
		$this->db->set($post); 
		return $this->db->update("data_pegawai");
	}

	function kirim_ks(){
		$msg	=	$this->input->post("msg"); 
		$this->db->set("id_alumni",$this->m_reff->idu());
		$this->db->set("msg",$msg); 
		return $this->db->insert("data_kritik");
	}
	function hapus_ks(){
		$id	=	$this->input->post("id");  
		$this->db->where("id",$id); 
		return $this->db->delete("data_kritik");
	}

}
 