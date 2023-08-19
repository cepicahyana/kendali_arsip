<?php

class Model extends CI_Model  {
    
	var $tbl="admin";
 
 	function __construct()
    {
        parent::__construct();
    }
	function idu()
	{
		return $this->session->userdata("id");
	}
	
	 
	function set()
	{
		$sts=$this->m_reff->sanitize($this->input->post("sts"));
		$id=$this->m_reff->sanitize($this->input->post("id"));
		if($sts==0){ $sts=1;}else{ $sts=0;}
		$this->db->set("sts",$sts);
		$this->db->where("id",$id);
		return $this->db->update($this->tbl);
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
		// $level		=	$this->input->get_post("level");
		  $this->db->where("id_admin!=",$this->session->userdata("id"));
		  $this->db->where_in("level",array(18,28,29,30));
		  
		 
		  if(strlen(isset($_POST['search']['value'])?($_POST['search']['value']):null)>1) {
			$searchkey = $_POST['search']['value'];
			$searchkey = $this->m_reff->sanitize($searchkey);
			
				$query=array(
				"owner"=>$searchkey 				 
				);
				$this->db->group_start()
                        ->or_like($query)
                ->group_end();
				
			}	
			
			
			$this->db->order_by("level","asc");
			$query=$this->db->from("admin");
		return $query;
			 
		
		 
	}
	
	public function count()
	{				
			$this->_get_data();
		return $this->db->get()->num_rows();
	}
	function insert($level)
	{	
	if(!$this->input->post("f")){ 
		$var["gagal"]=true;
		$var["info"]="params not found!";
		return $var;
	}
	$this->m_reff->log("insert akun","data");
	$nip=$this->m_reff->sanitize($this->input->post("f[nip]"));
	// $user=$this->input->post("f[username]");
	$pass=$this->m_reff->sanitize($this->input->post("password"));
	 $cek=$this->db->get_where("admin",array("nip"=>$nip))->num_rows();
	 if(!$cek){
		$post=$this->input->post("f");
		if(!$post){ 
					$var["gagal"]=true;
					$var["info"]="variable not found";
					return $var;
				
				}
		$post=$this->security->xss_clean($post);
		$pass=$this->input->post("password");
		$this->db->set("level",$level);
		$this->db->set("password",md5($pass));
	 
	 	return $this->db->insert($this->tbl,$post);
	 }else{
					$var["gagal"]=true;
					$var["info"]="NIP telah terdaftar.";
					return $var;
	 }
	}
	function update()
	{
		if(!$this->input->post("f")){ 
			$var["gagal"]=true;
			$var["info"]="params not found!";
			return $var;
		}
	$this->m_reff->log("update akun");
	$nip=$this->m_reff->sanitize($this->input->post("f[nip]"));
	// $user=$this->m_reff->sanitize($this->input->post("f[username]"));
	$pass=$this->m_reff->sanitize($this->input->post("password"));
	 $cek=$this->db->get_where("admin",array("nip"=>$nip,"id_admin!="=>$this->m_reff->sanitize($this->input->post("id"))))->num_rows();
	 if(!$cek){
		$post=$this->input->post("f");
		if(!$post){ 
					$var["gagal"]=true;
					$var["info"]="variable not found";
					return $var;
				
				}
		$post=$this->security->xss_clean($post);
		$pass=$this->input->post("password");
		if($pass){
		$this->db->set("password",md5($pass));
		}
		$this->db->where("id_admin",$this->input->post("id"));
	 	return $this->db->update($this->tbl,$post);
	 }else{
						$var["gagal"]=true;
					$var["info"]="Silahkan cari NIP  lain";
					return $var;
	 return $var;
	 }
	}
	function hapus($id)
	{
		if(!$id){ 
			$var["gagal"] = true;
			$var["info"]  = "params not found!";
			return $var;
		}
		$this->m_reff->log("hapus akun");
		$this->db->where("id_admin",$id);
		return $this->db->delete("admin");
	}
	
	 
	 
	 
	 
}