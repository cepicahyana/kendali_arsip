<?php
class Model extends CI_Model
{
 
	public function __construct() {
        parent::__construct();
    }
	
	
	 
	function kirim_status(){
		$msg	=	 $this->input->post("msg");
		$id		=	 $this->m_reff->idu();
		$this->db->set("msg",$this->m_reff->san($msg));
		$this->db->set("tgl",date("Y-m-d H:i:s"));
		$this->db->set("id_sender",$id);
		$this->db->set("reader",",".$id.",");
		return $this->db->insert("update_status");
	}
    function kirim_balasan(){
		$msg	=	 $this->input->post("msg");
		$idm	=	 $this->input->post("idm");
		$id	=	 $this->m_reff->idu();
		$this->db->set("msg",$this->m_reff->san($msg));
		$this->db->set("id_sender",$id);
		$this->db->set("id_msg",$this->m_reff->san($idm));
		return $this->db->insert("data_komentar");
	}
 
    function dataKomen($id){
		$this->db->where("id_msg",$id);
		$this->db->order_by("tgl","asc");
		return $this->db->get("data_komentar")->result();
	}
	function dataKomenUltah($id,$tgl){
	    $this->db->where("id_alumni",$id);
	    $this->db->where("date(tgl)",$tgl);
		$this->db->order_by("tgl","asc");
		return $this->db->get("data_ultah")->result();
	}
	function getInfo(){
		$this->db->where("sts",1);
		$this->db->where("kode_biro",$this->session->userdata("kode_biro"));
		$this->db->where("kode_istana",$this->session->userdata("kode_istana"));
		$this->db->order_by("tgl","desc");
		return $this->db->get("data_informasi")->result();
	}
	function hapus_status(){
		$this->db->where("id",$this->input->post("id"));
		$this->db->where("id_sender",$this->m_reff->idu());
		$return=$this->db->delete("update_status");
		if($return==true){
			$this->db->where("id_msg",$this->input->post("id"));
		return	$this->db->delete("data_komentar");
		}
	}
	function hapus_com(){
	    	$this->db->where("id",$this->input->post("id"));
		return	$this->db->delete("data_komentar");
	}
	
	function hapus_ucapan(){
	    	$this->db->where("id",$this->input->post("id"));
		return	$this->db->delete("data_ultah");
	}

}
//End of file data_param.php