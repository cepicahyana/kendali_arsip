<?php

class Model extends CI_Model  {
    
	 
	function __construct()
    {
        parent::__construct();
    }
	function updateStsChat($id){
		$this->db->where("id",$id);
		$this->db->set("sts",1);
		return $this->db->update("data_chat");
	}
	// function saveChat(){
	// 	$receiver = $this->input->post("receiver");
	// 	$msg	  = $this->input->post("msg");
	// 	if(!$msg){ return false;}

		
	// 	$this->db->set("sender",$this->idu());
	// 	$this->db->set("receiver",$receiver);
	// 	$this->db->set("msg",$msg);
	// 	$this->db->set("tgl",date('Y-m-d H:i:s'));
	// 	return $this->db->insert("data_chat");
	// }
	function idu(){
		return $this->session->userdata("id");
	}
	function dataKomen($id){
		$this->db->where("id_msg",$id);
		$this->db->order_by("tgl","asc");
		return $this->db->get("data_komentar")->result();
	}
	function hapus_status(){
		$this->db->where("id",$this->input->post("id"));
		$this->db->where("id_sender",$this->m_reff->idu());
		$return=$this->db->delete("data_tanya_dokter");
		if($return==true){
			$this->db->where("id_msg",$this->input->post("id"));
		return	$this->db->delete("data_komentar");
		}
	}
	function kirim_status(){

		$cek	=	$this->db->get_where("data_tanya_dokter",array("sts"=>0,"id_sender"=>$this->m_reff->idu()))->num_rows();
		if($cek){
			$var["error"]=true;
			$var["info"]="Maaf! Untuk dapat memulai obrolan baru mohon akhiri terlebih dahulu obrolan yang masih berlangsung.";
			return $var;
		}

		$msg	=	 $this->input->post("msg");
		$id		=	 $this->m_reff->sanitize($this->m_reff->idu());
		$this->db->set("msg",$this->m_reff->sanitize($msg));
		$this->db->set("tgl",date("Y-m-d H:i:s"));
		$this->db->set("tgl_respon",date("Y-m-d H:i:s"));
		$this->db->set("id_sender",$id);
		// $this->db->set("reader",",".$id.",");
		 $this->db->insert("data_tanya_dokter");
		 $var["error"]=false;
		 return $var;
	}
	 
	function kirim_balasan(){
		$msg	=	 $this->input->post("msg");
		$idm	=	 $this->input->post("idm");
		$id		=	 $this->m_reff->idu();

			 $this->db->set("tgl_respon",date("Y-m-d H:i:s"));
			 $this->db->set("sts_replay","open");
			 $this->db->set("oleh",1); //1=peg
			 $this->db->where("id",$idm);
			 $this->db->update("data_tanya_dokter");

		$this->db->set("msg",$this->m_reff->sanitize($msg));
		$this->db->set("id_sender",$id);
		// $this->db->set("level",$this->session->level);
		$this->db->set("id_msg",$this->m_reff->sanitize($idm));
		return $this->db->insert("data_komentar"); 
	} 
	 
	function getReplay(){
			 $id		=	 $this->m_reff->idu();
			 $this->db->where("sts_replay","open");
			 $this->db->where("sts",0);
			 $this->db->where("id_sender",$this->m_reff->idu());
			 $dt	 = $this->db->get("data_tanya_dokter")->row();
		 	 $id_msg = isset($dt->id)?($dt->id):null;
			  if($id_msg){
					$this->db->where("sts_baca",0);
					$this->db->where("id_msg",$id_msg);
					$this->db->where("id_sender!=",$id);
			$db =	$this->db->get("data_komentar")->result();


				  $this->db->set("sts_baca",1);
				  $this->db->where("id_msg",$id_msg);
				  $this->db->where("id_sender!=",$id);
				  $this->db->update("data_komentar");

				return $db;
				 
			  }

			 return false;
			  
	}

	function hapus_com(){
		$this->db->where("id",$this->input->post("id"));
		return	$this->db->delete("data_komentar");
	}
	function akhiri_obrolan(){
		$this->db->where("id",$this->input->post("id"));
		$this->db->set("sts",1);
		return	$this->db->update("data_tanya_dokter");
	}
	 
	function jml_obrolan($id){
		$this->db->where("id_msg",$id);
		return	$this->db->get("data_komentar")->num_rows();
	}
	 
}




