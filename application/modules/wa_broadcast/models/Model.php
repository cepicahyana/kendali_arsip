<?php
class Model extends CI_Model  {
    
	 
	function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
	}
	function idu(){
		return $this->session->userdata("id");
	}
	function getById($id)
	{
		return $this->db->get_where('broadcast_group', ['id'=>$id]);
	}
	function getAllData()
	{
		return $this->db->get('data_pegawai');
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
	 	  //$nip = $this->session->userdata("nip");
			// $this->db->where("sts",0);
			/*$pic = $this->session->pic;
			if($pic){
				$this->db->where("nip_pegawai in (select nip from data_pegawai where kode_biro='".$this->m_reff->sanitize($pic)."' )");
			}else{
			    $this->db->where("_cid",$this->idu());
			}*/

			if (strlen(isset($_POST['search']['value'])?($_POST['search']['value']):null)>1) {
					$searchkey = $_POST['search']['value'];
					$searchkey = $this->m_reff->sanitize($searchkey);
					$query=array(
					"nama"=>$searchkey,		 				 
							  
					);
					$this->db->group_start()
							->or_like($query)
					->group_end();
					
				}	

				$this->db->order_by("nama", "asc");
			$query=$this->db->from("broadcast_group");
		return $query;
	}
	public function count()
	{
		$this->_get_data();
		return $this->db->get()->num_rows();
	}

	function insert(){
		$form 	 = $this->input->post("f");
		 
		$this->db->set($form);
		$this->db->insert("broadcast_group");

		// log
		$this->m_reff->log("create new group broadcast");

		$var["token"] = $this->m_reff->getToken();
		return $var;
	}

	function update(){
		$form 	 = $this->input->post("f");
		$id		 = $this->input->post("id");
 
		$this->db->set($form);
		$this->db->where("id",$id);
		$this->db->update("broadcast_group");

		// log
		$this->m_reff->log("Update group broadcast");

		$var["token"] = $this->m_reff->getToken();
		return $var;
	}

	function hapus(){
		$id    = $this->input->post("id");

		// log
		$this->m_reff->log("Delete broadcast group id : ".$id);

		$countKontak = $this->db->get_where('broadcast_kontak', ['id_group'=>$id])->num_rows();
		if ($countKontak > 0) {
			$this->db->where("id_group",$id);
			$this->db->delete("broadcast_kontak");

			$this->m_reff->log("Delete group broadcast");
		}

		$this->db->where("id",$id);
		return $this->db->delete("broadcast_group");;
	}


	function sendBroadcast(){
		$allowed = 	array('gif', 'png', 'jpg','jpeg');
		$form	 =	$this->input->post("f");
		$file	 =	$this->input->post("lampiran"); 
			
	
			 

		$this->db->set("file",$file);
		$this->db->set($form);
		$this->db->where("id",2);
		$this->db->update("notifikasi");

		$data	   = $this->input->post("data");
		$try_wa    = $this->input->post("try_wa");
		$try_email = $this->input->post("try_email");
		$res_data  = $this->m_reff->clearkomaray($data);

		$notif	   = $this->db->get_where("notifikasi",array("id"=>2))->row();

		$tempt_email	 = isset($notif->email)?($notif->email):null;
		$tempt_wa	 	 = isset($notif->wa)?($notif->wa):null;
		$tempt_subject	 = isset($notif->subject)?($notif->subject):null;
		$tempt_file		 = isset($notif->file)?($notif->file):null;

		// $path			 = $this->m_reff->pengaturan(1)."broadcast/".$tempt_file;
		if($try_wa){
			$this->m_reff->kirimWaData($try_wa,$tempt_wa,$tempt_file);
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

				// $data		=	array(
				// 	"email" 	=> $email,
				// 	"msg" 		=> $msg,
				// 	"subject"	=> $subject,
				// 	"namaFile"  => "lampiran.pdf",
				// 	"path"		=> $path
				// );
				//$this->m_reff->kirimEmail($data);

				//kirim WA
			 
					$this->m_reff->kirimWaData($wa,$msg_wa,$tempt_file);
				 

			}
			return true;
		}  return true;
	}

	function sendBroadcast_group(){
		$form	=	$this->input->post("f");
		$file	=	$this->input->post("lampiran"); 
		$this->db->set("file",$file);
		$this->db->set($form);
		$this->db->where("id",2);
		$this->db->update("notifikasi");

		$data	   = $this->input->post("data");
		$try_wa    = $this->input->post("try_wa");
		$try_email = $this->input->post("try_email");
		$res_data  = $this->m_reff->clearkomaray($data);

		$notif	   = $this->db->get_where("notifikasi",array("id"=>2))->row();

		$tempt_email	 = isset($notif->email)?($notif->email):null;
		$tempt_wa	 	 = isset($notif->wa)?($notif->wa):null;
		$tempt_subject	 = isset($notif->subject)?($notif->subject):null;
		$tempt_file		 = isset($notif->file)?($notif->file):null;

		// $path			 = $this->m_reff->pengaturan(1)."broadcast/".$tempt_file;
		if($try_wa){
			$this->m_reff->kirimWaData($try_wa,$tempt_wa,$tempt_file);
		}
		if($data){
			foreach($res_data as $id){
				$kontak = $this->m_reff->getDataBCGroup($id);
				foreach ($kontak as $db) {
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

					// $data		=	array(
					// 	"email" 	=> $email,
					// 	"msg" 		=> $msg,
					// 	"subject"	=> $subject,
					// 	"namaFile"  => "lampiran.pdf",
					// 	"path"		=> $path
					// );
					// $this->m_reff->kirimEmail($data);
					$this->m_reff->kirimWaData($wa,$msg_wa,$tempt_file);
				}
			}
			return true;
		} 
	}

	function sendBroadcast_group_kontak(){
		$form	=	$this->input->post("f");
		$file	 =	$this->input->post("lampiran"); 
		$this->db->set("file",$file);

		$this->db->set($form);
		$this->db->where("id",2);
		$this->db->update("notifikasi");

		$data	   = $this->input->post("data");
		$try_wa    = $this->input->post("try_wa");
		$try_email = $this->input->post("try_email");
		$res_data  = $this->m_reff->clearkomaray($data);

		$notif	   = $this->db->get_where("notifikasi",array("id"=>2))->row();

		$tempt_email	 = isset($notif->email)?($notif->email):null;
		$tempt_wa	 	 = isset($notif->wa)?($notif->wa):null;
		$tempt_subject	 = isset($notif->subject)?($notif->subject):null;
		$tempt_file		 = isset($notif->file)?($notif->file):null;


		$path			 = $this->m_reff->pengaturan(1)."broadcast/".$tempt_file;
		if($try_wa){
			$this->m_reff->kirimWaData($try_wa,$tempt_wa,$tempt_file);
		}
		if($data){
			foreach($res_data as $id){

			
			  		$db = $this->m_reff->getDataBCGroupKontak($id);
					$email		=	isset($db->email)?($db->email):"";
					$wa			=	isset($db->no_hp)?($db->no_hp):"";
					$nama		=	isset($db->nama)?($db->nama):"";

					$msg_wa		=	str_replace("{nama}",$nama,$tempt_wa);
					$msg_wa		=	str_replace("{email}",$email,$msg_wa);
					$msg_wa		=	str_replace("{wa}",$wa,$msg_wa);
					

				$email		=	isset($db->email)?($db->email):"";
				$wa			=	isset($db->no_hp)?($db->no_hp):"";
				$nama		=	isset($db->nama)?($db->nama):"";

				$msg		=	str_replace("{nama}",$nama,$tempt_email);
				$msg		=	str_replace("{wa}",$wa,$msg);
				$msg		=	str_replace("{email}",$email,$msg);

				$subject	=	str_replace("{nama}",$nama,$tempt_subject);
				$subject	=	str_replace("{email}",$email,$subject);
				$subject	=	str_replace("{wa}",$wa,$subject);

				// $data		=	array(
				// 	"email" 	=> $email,
				// 	"msg" 		=> $msg,
				// 	"subject"	=> $subject,
				// 	"namaFile"  => "lampiran.pdf",
				// 	"path"		=> $path
				// );
				// $this->m_reff->kirimEmail($data);
				$this->m_reff->kirimWaData($wa,$msg_wa,$tempt_file);
			}
			return true;
		} 
	}



	function import_file()
	{
		$file_form="userfile";
		$group =	$this->m_reff->san($this->input->post("group"));
		$this->load->library("PHPExcel");
		$insert=0;$gagal=0;$dgagal="";$edit=0;$validasi_hp=true;$validasi=true;
		$file   = explode('.',$_FILES[$file_form]['name']);
		$length = count($file);
		if($file[$length -1] == 'xlsx' || $file[$length -1] == 'xls'){
         $tmp    = $_FILES[$file_form]['tmp_name']; 
	 
			    $load = PHPExcel_IOFactory::load($tmp);
                $sheets = $load->getActiveSheet()->toArray(null,true,true,true,true);
				$i=1;
			 
					 
				foreach ($sheets as $sheet) {
					if ($i > 1) {
						 	  
							 
							$nama=isset($sheet[1])?($sheet[1]):"";
							$jabatan=isset($sheet[2])?($sheet[2]):"";
							$instansi=isset($sheet[3])?($sheet[3]):"";
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
							$email=isset($sheet[5])?($sheet[5]):"";
						$cek=$this->db->query("select * from broadcast_kontak where id_group='".$group."' and no_hp='".$hp."' and email='".$email."' ")->num_rows();
						if(!$cek)
						{
							$ray=array(
							"id_group"=>$group, 
							"nama"=>$nama,
							"jabatan"=>$jabatan,
							"instansi"=>$instansi,
							"no_hp"=>$hp,
							"email"=>$email 
							);
						
							$insert++;
							$this->_insert_kontak($ray);
						}else{
							$gagal++;
							$dgagal.="No.".$i."/".$nama."-".$hp.br();
							
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

			   /*update*/
			if ($gagal > 0) {
				$var["gagal"] = true;
				$var["info"] = $dgagal;
			}
			/*update*/

		return $var;
	}
	
	private function _insert_kontak($ray)
	{
		$this->db->set($ray);
		return $this->db->insert("broadcast_kontak");
	}
 

}




