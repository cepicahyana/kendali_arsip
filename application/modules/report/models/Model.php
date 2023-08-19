<?php

class Model extends CI_Model  {
    
	 
	function __construct()
    {
        parent::__construct();
    } 
	function insert_pustaka(){
		$this->m_reff->direktori_pustaka();
		$form 	 = $this->input->post("f");
		//$id		 = $this->input->post("id");
		if(isset($_FILES["file"]['tmp_name']))
		{  
			$dok	 =	$this->m_reff->pengaturan(1)."dok/pustaka";
			$doksave = 	"dok/pustaka";
			$before_file=null;//$this->m_reff->goField("tm_pustaka","file","where id='".$id."' ");
			$file=$this->m_reff->upload_file("file",$dok,"file","jpg,jpeg,png,pdf,docx",$sizeFile="5000000",$before_file);
			if($file["validasi"]!=false)
			{ 	  	 
				$this->db->set("file",$doksave."/".$file['name']);
			}else{
			 $var["gagal"]=true;
			 $var["info"]="terjadi masalah saat upload file  <br>".json_encode($file);
			 return $var;
			}
		}
	 
		 
  
		$this->db->set($form);
		$this->db->set("_cid", $this->m_reff->idu());
		$this->db->set("_ctime", date('Y-m-d H:i:s'));
		$this->db->insert("tm_pustaka");
		$this->m_reff->log("upload file pustaka");
		$var["token"] = $this->m_reff->getToken();
		return $var;
	}
	function update_pustaka(){
		// $this->m_reff->direktori_pustaka();
		$form 	 = $this->input->post("f");
		$id		 = $this->input->post("id");
		if(isset($_FILES["file"]['tmp_name']))
		{  
			$dok	 =	$this->m_reff->pengaturan(1)."dok/pustaka";
			$doksave = 	"dok/pustaka";
			$before_file=$this->m_reff->goField("tm_pustaka","file","where id='".$id."' ");
			$file=$this->m_reff->upload_file("file",$dok,"file","jpg,jpeg,png,pdf,docx",$sizeFile="5000000",$before_file);
			if($file["validasi"]!=false)
			{ 	  	 
				$this->db->set("file",$doksave."/".$file['name']);
			}else{
			 $var["gagal"]=true;
			 $var["info"]="terjadi masalah saat upload file  <br>".json_encode($file);
			 return $var;
			}
		}
	 
		 
  
		$this->db->set($form);
		$this->db->set("_uid", $this->m_reff->idu());
		$this->db->set("_utime", date('Y-m-d H:i:s'));
		$this->db->where("id", $this->input->post("id"));
		$this->db->update("tm_pustaka");
		$this->m_reff->log("Update file pustaka");
		$var["token"] = $this->m_reff->getToken();
		return $var;
	}

	function hapus_pustaka(){
		$id 			= 	$this->input->post("id");
		$dok	 		=	$this->m_reff->pengaturan(1);
		$before_file	=	$this->m_reff->goField("tm_pustaka","file","where id='".$id."' ");
		
		$filename=$dok."/".$before_file;
		if (file_exists($filename)) {
			unlink($filename);
		} 

		$this->db->where("id", $id);
		$this->db->delete("tm_pustaka");
		$this->m_reff->log("Hapus file pustaka");
		$var["token"] = $this->m_reff->getToken();
		return $var;
	}


	function getDataPustaka()
	{
		 $this->_getDataPustaka();
		if($this->input->post("length")!=-1) 
		$this->db->limit($this->input->post("length"),$this->input->post("start"));
	 	return $this->db->get()->result();
		 
	}

	function _getDataPustaka()
	{
		  
		if (strlen(isset($_POST['search']['value'])?($_POST['search']['value']):null)>1) {
				$searchkey = $_POST['search']['value'];
				$searchkey = $this->m_reff->sanitize($searchkey);

				$query=array(
				"nama"=>$searchkey,			 
				"ket"=>$searchkey 	 
				);
				$this->db->group_start()
                        ->or_like($query)
                ->group_end();
				
			}	
			
			
			$this->db->order_by("id","desc");
			$query=$this->db->from("tm_pustaka");
		return $query;
			  
	}
	
	public function count_pustaka()
	{				
			$this->_getDataPustaka();
		return $this->db->get()->num_rows();
	}
}




