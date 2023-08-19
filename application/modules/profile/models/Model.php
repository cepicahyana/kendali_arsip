<?php

class Model extends CI_Model  {
    
		
	function __construct()
    {
        parent::__construct();
    }
	 
	 
	 
	  function dataProfile()
	 {
		$idu=$this->session->userdata("id");
		$this->db->where("id_admin",$idu);
		return $this->db->get("admin")->row();
		 
	 }
	     function dataProfilePegawai()
	 {
		$nip=$this->session->userdata("nip");
		$this->db->where("nip",$nip);
		return $this->db->get("data_pegawai")->row();
		 
	 }
	    
	     function dataProfilePicCovid()
	 {
		$id=$this->session->userdata("id");
		$this->db->where("id_admin",$id);
		return $this->db->get("admin")->row();
		 
	 }
	    
	     function dataProfileDok()
	 {
		$id=$this->session->userdata("id");
		$this->db->where("id",$id);
		return $this->db->get("data_dokter")->row();
		 
	 }

	 function dataProfilePicProtokolCovid(){
		$id=$this->session->userdata("id");
		$this->db->where("id_admin",$id);
		return $this->db->get("admin")->row();
	 }

	 function dataProfileKordokter()
	 {
		$id=$this->session->userdata("id");
		$this->db->where("id_admin",$id);
		return $this->db->get("admin")->row();
		 
	 }

	 function dataProfileRs()
	 {
		$id=$this->session->userdata("id");
		$this->db->where("id",$id);
		return $this->db->get("tm_rs")->row();
		 
	 }

	 function dataProfileAdminCovid(){
		$id=$this->session->userdata("id");
		$this->db->where("id_admin",$id);
		return $this->db->get("admin")->row();
	 }

	 function dataProfilePimpinanCovid(){
		$id=$this->session->userdata("id");
		$this->db->where("id_admin",$id);
		return $this->db->get("admin")->row();
	 }

	 function dataProfileSuperAdmin(){
		$id=$this->session->userdata("id");
		$this->db->where("id_admin",$id);
		return $this->db->get("admin")->row();
	 }
	 
	    
	 
	  
	function updatePegawai()
	{
	 $var=array();
	 
	$var["validasi"]=true; 
	$id = $this->session->userdata("id");
	 $user=$this->input->post("f[username]");
	 $user=$this->security->xss_clean($user);
	 
	 $cpass=$this->input->post("cpassword");
	 $pass=$this->input->post("password");
	 $pass=$this->security->xss_clean($pass);
	  



	 
		$data=$this->input->post("f");
		if(!$data){ return false;}

		$data=$this->security->xss_clean($data);
	
		if($cpass)
		{
			if($cpass!=$pass){
				$var["gagal"]=true;
				$var["info"]="ketik ulang password tidak sama";
				return $var;
			}
			
			if($this->cekPassword($id,$user,$pass)>0)
			{
				 $var["gagal"]=true; $var["info"]="Silahkan cari username/password lain"; 
				 return $var;
			} 

		  $this->db->set("password",md5($pass));
		} 

	
 
			 if(isset($_FILES["poto"]['tmp_name']))
			{  
				$file=$this->m_reff->upload_file("poto","plug/img/dp","dp","JPG,JPEG,PNG","3000000",null);
			
				if($file["validasi"]!=false)
				{
					
					$this->db->set("poto",$file["name"]);
					
				}
			$var=$file;
			} 

				$this->db->where("id",$id);
				$this->db->update("data_pegawai",$data);		
			
			return $var;
	
	}
	function updateRs()
	{
	 $var=array();
	 
	$var["validasi"]=true; 
	$id = $this->session->userdata("id");
	 $user=$this->input->post("f[username]");
	 $user=$this->security->xss_clean($user);
	 
	 $cpass=$this->input->post("cpassword");
	 $pass=$this->input->post("password");
	 $pass=$this->security->xss_clean($pass);
	  



	 
		$data=$this->input->post("f");
		if(!$data){ return false;}

		$data=$this->security->xss_clean($data);
	
		if($cpass)
		{
			if($cpass!=$pass){
				$var["gagal"]=true;
				$var["info"]="ketik ulang password tidak sama";
				$var["token"]=$this->m_reff->getToken();
				return $var;
			}
			
			if($this->cekPassword($id,$user,$pass)>0)
			{
				 $var["gagal"]=true; $var["info"]="Silahkan cari username/password lain"; 
				 $var["token"]=$this->m_reff->getToken();
				 return $var;
			} 

		  $this->db->set("password",md5($pass));
		} 

	
 
			 if(isset($_FILES["poto"]['tmp_name']))
			{  
				$file=$this->m_reff->upload_file("poto","plug/img/dp","dp","JPG,JPEG,PNG","3000000",null);
			
				if($file["validasi"]!=false)
				{
					
					$this->db->set("poto",$file["name"]);
					
				}
			$var=$file;
			} 

				$this->db->where("id",$id);
				$this->db->update("tm_rs",$data);	
					
			$var["token"]=$this->m_reff->getToken();
			return $var;
	
	}
	function update()
	{
	 $var=array();
	 
	$var["validasi"]=true; 
	$id = $this->session->userdata("id");
	 $user=$this->input->post("f[username]");
	 $user=$this->security->xss_clean($user);
	 
	 $cpass=$this->input->post("cpassword");
	 $pass=$this->input->post("password");
	 $pass=$this->security->xss_clean($pass);
	  



	 
		$data=$this->input->post("f");
		if(!$data){ return false;}

		$data=$this->security->xss_clean($data);
	
		if($cpass)
		{
			if($cpass!=$pass){
				$var["gagal"]=true;
				$var["info"]="ketik ulang password tidak sama";
				return $var;
			}
			
			if($this->cekPassword($id,$user,$pass)>0)
			{
				 $var["gagal"]=true; $var["info"]="Silahkan cari username/password lain"; 
				 return $var;
			} 

		  $this->db->set("password",md5($pass));
		} 

	
 
			 if(isset($_FILES["poto"]['tmp_name']))
			{  
				$file=$this->m_reff->upload_file("poto","plug/img/dp","dp","JPG,JPEG,PNG","3000000",null);
			
				if($file["validasi"]!=false)
				{
					
					$this->db->set("foto",$file["name"]);
					
				}
			$var=$file;
			} 

			if($this->session->level=="admin"){

				$this->db->where("id_admin",$id);
				$this->db->update("admin",$data);	
			}elseif($this->session->level=="pic"){

				$this->db->where("id",$id);
				$this->db->update("tm_pic",$data);	
			}	
			
			 
		
			return $var;
	
	}
	function update_dokter()
	{
	 $var=array();
	 
	$var["validasi"]=true; 
	$id = $this->session->userdata("id");
	 $user=$this->input->post("f[username]");
	 $user=$this->security->xss_clean($user);
	 
	 $cpass=$this->input->post("cpassword");
	 $pass=$this->input->post("password");
	 $pass=$this->security->xss_clean($pass);
	  



	 
		$data=$this->input->post("f");
		if(!$data){ return false;}

		$data=$this->security->xss_clean($data);
	
		if($cpass)
		{
			if($cpass!=$pass){
				$var["gagal"]=true;
				$var["info"]="ketik ulang password tidak sama";
				return $var;
			}
			
			if($this->cekPassword($id,$user,$pass)>0)
			{
				 $var["gagal"]=true; $var["info"]="Silahkan cari username/password lain"; 
				 return $var;
			} 

		  $this->db->set("password",md5($pass));
		} 

	
 
			 if(isset($_FILES["poto"]['tmp_name']))
			{  
				$file=$this->m_reff->upload_file("poto","plug/img/dp","dp","JPG,JPEG,PNG","3000000",null);
			
				if($file["validasi"]!=false)
				{
					
					$this->db->set("foto",$file["name"]);
					
				}
			$var=$file;
			} 

				$this->db->where("id",$id);
				$this->db->update("data_dokter",$data);		
			
			 
		
			return $var;
	
	}
	function upload_file($form,$dok,$idu,$id=null,$tabel="admin")
	{		
		$var=array();
		$var["size"]=""; 
		$var["file"]="";
		$var["validasi"]=false; 
	
		$nama=date("YmdHis")."_".$idu."_";
		  $lokasi_file = $_FILES[$form]['tmp_name'];
		  $tipe_file   = $_FILES[$form]['type'];
		  $nama_file   = $_FILES[$form]['name'];
		   $size  	   = $_FILES[$form]['size'];
			$nama_file=str_replace(" ","_",$nama_file);
			// $jenis="jpg";
			$nama=str_replace("/","",$nama."_".$nama_file);
			 $target_path = "plug/img/".$dok."/".$nama;
			 
			  $ex=substr($nama_file,-3);
			$extention=str_replace(" ","_",strtoupper($ex));
			
		 $maxsize = 30000000;
		 if($size>=$maxsize)
		 {
			$var["size"]=$size; 
		 }elseif($extention!="JPG" AND $extention!="PNG" AND $extention!="JPEG"){
			$var["file"]=$extention;
		 }else{
		 	$var["validasi"]=true;
			if (!empty($lokasi_file)) {
			move_uploaded_file($lokasi_file,$target_path);
				if($id)
				{
					$namapotoid=$this->m_reff->goField($tabel,"poto","where id_admin='".$id."'");
					$file_namapotoid="plug/img/".$dok."/".$namapotoid."";
					if(file_exists($file_namapotoid))
					{
						unlink($file_namapotoid);
					}
				}
			
			 }
			$var["name"]=$nama;
		 }
		 return $var;
	}
	function insert()
	{
		$var=array();
	$var["size"]=""; 
	$var["file"]="";
	$var["password"]="";
	$var["validasi"]=false; 
	
	 $user=$this->input->post("f[username]");
	 $user=$this->security->xss_clean($user);
	 
	 $pass=$this->input->post("password");
	 $pass=$this->security->xss_clean($pass);
	 
	 $id=$this->session->userdata("id");
	 $pro=$this->mdl->dataProfile();
		$data=$this->input->post("f");
		$data=$this->security->xss_clean($data);
		if($pass)
		{
		  $this->db->set("password",md5($pass));
		    
		} 
		 
		if($this->cekPassword("",$user,$pass)>0)
		{
			 $var["password"]=false; $var["validasi"]=false; 
		}else
		{
			 $var["validasi"]=true; 
			 if(isset($_FILES["poto"]['tmp_name']))
			{  
				$file=$this->mdl_extra->upload_file_image("poto","dp",$id);
				if($file["validasi"]!=false)
				{
					
					$this->db->set("poto",$file["name"]);
					
				}
			$var=$file;
			} 
			//	$this->db->where("id_admin",$id);
				$this->db->insert("admin",$data);		
			
			 
		}
			return $var;
	
	}
	
	 
	
	
	 function cekPassword($id,$user,$pass)
	{
		 
		$this->db->where("username",$user);
        $this->db->where("password",md5($pass));
        $this->db->where("id!=",$id);
        $res = $this->db->get("data_pegawai")->num_rows();
        if($res){
            return 1;
        }

		$this->db->where("username",$user);
        $this->db->where("password",md5($pass));
        $this->db->where("id_admin!=",$id);
        $res = $this->db->get("admin")->num_rows();
        if($res){
            return 1;
        }

        $this->db->where("username",$user);
        $this->db->where("password",md5($pass));
        $this->db->where("id!=",$id);
        $res = $this->db->get("tm_rs")->num_rows();
        if($res){
            return 1;
        }

        $this->db->where("username",$user);
        $this->db->where("password",md5($pass));
        $this->db->where("id!=",$id);
        $res = $this->db->get("data_dokter")->num_rows();
        if($res){
            return 1;
        }

        return 0;
 
	}
	
	 
}