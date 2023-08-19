<?php

class Model extends CI_Model  {
    
	 
	function __construct()
    {
        parent::__construct();
    }

	function transfer($n){
		
		$n=json_encode($n);
		$n=json_decode($n,true);
		
		$media = $this->m_reff->pengaturan(1)."/".$n["foto"];
		if($n["foto"]){
			$media = $this->konversi->img($media);
		}else{
			$media = null;
		}
		

		$foto =  array("foto"=>$media);
		unset($n["foto"]);
		unset($n["id"]);
		 
		$data=array_merge($n,$foto);

		$curl = curl_init();
		$link  =  $this->m_reff->pengaturan(34); 

		curl_setopt($curl, CURLOPT_URL, $link);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data)); 
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		$result = curl_exec($curl);
		curl_close($curl); 
		return $result;


	}
     
	function total(){
		return $this->db->get("data_pegawai")->num_rows();
	}
	function trftotal(){
		$this->db->where("jenis_pegawai",2);
		return $this->db->get("data_pegawai")->num_rows();
	}
	function trfstart($offsite){
	 
		$this->db->limit(1,$offsite);
		$this->db->where("jenis_pegawai",2);
		$n = $this->db->get("data_pegawai")->row();
		$nip = isset($n->nip)?($n->nip):null;
		if($nip){
			return $this->transfer($n);  
		}else{
			return false;
		}
	}
	function start($offsite){
	 
		$this->db->limit(1,$offsite);
		$n = $this->db->get("data_pegawai")->row();
		$nip = isset($n->nip)?($n->nip):null;
		if($nip){
			$this->sync->syncronByNip($nip);
			$this->calculate($nip);
			$this->db->where("id",32);
			$this->db->set("val",date('d-m-Y H:i:s'));
			return $this->db->update("pengaturan");
		}else{
			return false;
		}
	}
	function calculate($nip){
		$jml_tanggungan	= $this->db->get_where("data_keluarga",array("nip_pegawai"=>$nip))->num_rows();
		$jml_hukuman	= $this->db->get_where("tm_hukuman",array("nip_pegawai"=>$nip))->num_rows();
		$jml_penghargaan	= $this->db->get_where("tm_penghargaan",array("nip_pegawai"=>$nip))->num_rows();
		$this->db->set("jml_penghargaan",$jml_penghargaan);
		$this->db->set("jml_tanggungan",$jml_tanggungan);
		$this->db->set("jml_hukuman",$jml_hukuman);
		$this->db->where("nip",$nip);
		return $this->db->update("data_pegawai");
	}
}




