<?php

class Model extends CI_Model  {
    
	 
	function __construct()
    {
        parent::__construct();
    }
	 
	function sendBroadcast(){
		$form	=	$this->input->post("f");
		if(!isset($form)){
			return false;
		}
		if(isset($_FILES["lampiran"]['tmp_name']))
			{  
				$dok 	=	$this->m_reff->pengaturan(1)."broadcast";
				$file	=	$this->m_reff->upload_file("lampiran",$dok,"broad","jpg,jpeg,png,pdf");
				if($file["validasi"]!=false)
				{ 
					$this->db->set("file",$file["name"]);
				}
			} 


		$this->db->set($form);
		$this->db->where("id",6);
		$this->db->update("notifikasi");

		$data	   = $this->input->post("data");
		$try_wa    = $this->input->post("try_wa");
		$try_email = $this->input->post("try_email");
		$res_data  = $this->m_reff->clearkomaray($data);

		$notif	   = $this->db->get_where("notifikasi",array("id"=>6))->row();

		$tempt_email	 = isset($notif->email)?($notif->email):null;
		$tempt_wa	 	 = isset($notif->wa)?($notif->wa):null;
		$tempt_subject	 = isset($notif->subject)?($notif->subject):null;
		$tempt_file		 = isset($notif->file)?($notif->file):null;

		$path			 = $this->m_reff->pengaturan(1)."broadcast/".$tempt_file;
		
		if($wat=$this->input->post("try_wa")){
			$msg_wa		=	str_replace("{nama}","NAMA_PEGAWAI",$tempt_wa);
			$msg_wa		=	str_replace("{email}","email@mail.com",$msg_wa);
			$msg_wa		=	str_replace("{wa}",$wat,$msg_wa);
			$this->m_reff->kirimWa($wat,$msg_wa);
		}


		if($data){

					foreach($res_data as $id){
						$db = $this->m_reff->getDataPegawai($id);
						$email		=	isset($db->email)?($db->email):"";
						$wa			=	isset($db->no_hp)?($db->no_hp):"";
						$nama		=	isset($db->nama)?($db->nama):"";

						$msg		=	str_replace("{nama}",$nama,$tempt_email);
						$msg		=	str_replace("{wa}",$wa,$msg);
						$msg		=	str_replace("{email}",$email,$msg);

						$subject	=	str_replace("{nama}",$nama,$tempt_subject);
						$subject	=	str_replace("{email}",$email,$subject);
						$subject	=	str_replace("{wa}",$wa,$subject);

						
						$msg_wa		=	str_replace("{nama}",$nama,$tempt_wa);
						$msg_wa		=	str_replace("{email}",$email,$msg_wa);
						$msg_wa		=	str_replace("{wa}",$wa,$msg_wa);

						$data		=	array(
							"email" 	=> $email,
							"msg" 		=> $msg,
							"subject"	=> $subject,
							"namaFile"  => "lampiran.pdf",
							"path"		=> $path
						);
						// $this->m_reff->kirimEmail($data);

						$this->m_reff->kirimWa($wa,$msg_wa);


					}
					return true;
	}
	
 
}

}




