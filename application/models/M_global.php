<?php

class M_global extends CI_Model  {
    
 
	function __construct()
    {
        parent::__construct();
    }
	function getFileRakor($kode){
			 
		return $this->db->get_where("data_file",array("kode_acara"=>$kode,"kode_qr"=>"admin"))->result();
	}
	function hapus_file(){
			$kode	=	$this->input->post("kode"); 
			$id		=	$this->input->post("id"); 
					$this->db->where("id",$id);
					$this->db->where("kode_acara",$kode);
		return		$this->db->delete("data_file");
	}
      function save_hasil_rakor(){ 
		  	$kode	=	$this->input->post("kode"); 
			$tahun	=	$this->m_reff->goField2("data_acara","YEAR(tgl) as val","where kode='".$kode."' ");
		  
			$lok="file";  
			$var["validasi"]=true; 
			 
			if(isset($_FILES["userfile"]['tmp_name']))
			{  
				$dok=$this->m_reff->pengaturan(25)."files/".$tahun."/".$kode."/".$lok;
				$namfil="files/".$tahun."/".$kode."/".$lok;
				 
				$before_file="";//$this->m_reff->goField("admin","poto","where id_admin='".$id."' ");
				$file=$this->m_reff->upload_file("userfile",$dok,$kode,"JPG,JPEG,PNG,png,jpg,jpeg,ppt,pptx,pdf,docx,xlsx,xls,zip,MP4",$sizeFile="250000000",$before_file);
				if($file["validasi"]!=false)
				{  
					$this->db->set("kode_acara",$kode);
					$this->db->set("kode_qr","admin");
				 
					$this->db->set("_ctime",date('Y-m-d H:i:s'));
					$this->db->set("type",2);
					$this->db->set("nama",$this->input->post("nama"));
					$this->db->set("file",$namfil."/".$file["name"]);
					$this->db->insert("data_file");
				}else{
				
				}
			$var=$file;
			} 
			 
			return $var;
	  } function update_hasil_rakor(){ 
		  	$id		=	$this->input->post("id");
		  	$kode	=	$this->input->post("kode");
			 
			$tahun	=	$this->m_reff->goField2("data_acara","YEAR(tgl) as val","where kode='".$kode."' ");
			 
			
			$lok="file";  
			$var["validasi"]=true; 
			 
			if(isset($_FILES["userfile"]['tmp_name']))
			{  
				$dok=$this->m_reff->pengaturan(25)."files/".$tahun."/".$kode."/".$lok;
				$namfil="files/".$tahun."/".$kode."/".$lok;
				 
				$before_file="";//$this->m_reff->goField("admin","poto","where id_admin='".$id."' ");
				$file=$this->m_reff->upload_file("userfile",$dok,$kode,"JPG,JPEG,PNG,png,jpg,jpeg,ppt,pptx,pdf,docx,xlsx,xls,zip,MP4",$sizeFile="250000000",$before_file);
				if($file["validasi"]!=false)
				{  
					$this->db->set("file",$namfil."/".$file["name"]);
				 
				} 
			 
			} 
			
					$this->db->set("_ctime",date('Y-m-d H:i:s')); 
					$this->db->set("nama",$this->input->post("nama")); 
					$this->db->where("id",$id);
					$this->db->update("data_file");  
			return $var;
	  }
	  function _dataTamu()
	{
			$this->_dataTamu_();
		if($this->input->post("length")!=-1) 
		$this->db->limit($this->input->post("length"),$this->input->post("start"));
	 	return $this->db->get()->result();
	}
	function _dataTamu_()
	{  
		    $broadcast=$this->input->get_post("broadcast");  
		    $status=$this->input->get_post("status");  
		    $kode=$this->input->get_post("kode");  
		    $sts_vicon=$this->input->get_post("sts_vicon");  
		    $j_kehadiran=$this->input->get_post("j_kehadiran");  
		    $kode=$this->m_reff->decrypt($kode);  
			$this->db->where("kode_acara",$kode); 
		 
			$this->db->where("nama IS NOT NULL"); 
			//$this->db->where("sts_ikutserta",2); 
		 
		 $this->db->where("j_kehadiran",$j_kehadiran);  
		 if($j_kehadiran==2){ // peserta vicon
			 if($status==1 and $sts_vicon==1) //hadir gladi
			 {
				 $this->db->where("ttd_gladi",1);
			 }elseif($status==1 and $sts_vicon==2) //hadir real on
			 {
				 $this->db->where("ttd",1);
			 }elseif($status==2  and $sts_vicon==1)
			 {
				 $this->db->where("ttd_gladi",0);
			 }elseif($status==2  and $sts_vicon==2){
				  $this->db->where("ttd",0);
			 }
		 }else{
			  if($status==1)
			 {
				 $this->db->where("sts_kehadiran",1);
			 }elseif($status==2)
			 {
				 $this->db->where("sts_kehadiran",2);
			 } 
		 }
		  // $this->db->where("sts_ikutserta!=",3);
		   $this->db->where("hapus",0);
		if(isset($_POST['search']['value'])){
			$searchkey=$_POST['search']['value']; 
				$query=array(
				"nama"=>$searchkey,
				"jabatan"=>$searchkey, 
				"instansi"=>$searchkey, 
				"kelompok"=>$searchkey 
				);
				$this->db->group_start()
                        ->or_like($query)
                ->group_end();
				
			}
				  
				   $this->db->order_by("cekin","desc");
			return $this->db->from("data_peserta");
	}
	
	public function count_tamu()
	{				
			$this->_dataTamu_();
		return $this->db->get()->num_rows();
	}
	
	function jmlPeserta($idmeet,$kode_acara)
	{
		$this->db->where("j_kehadiran",2);
		$this->db->where("id_meeting",$idmeet);
		$this->db->where("kode_acara",$kode_acara);
		$this->db->where("nama is not null");
		return $this->db->get("data_peserta")->num_rows();
	}function jmlLink($idmeet,$kode_acara)
	{
		$this->db->where("j_kehadiran",2);
		$this->db->where("link_join IS NOT NULL");
		$this->db->where("id_meeting",$idmeet);
		$this->db->where("kode_acara",$kode_acara);
		$this->db->where("nama is not null");
		return $this->db->get("data_peserta")->num_rows();
	}
	function jmlJoin($idmeet,$kode_acara,$type)
	{
		$this->db->where("ttd".$type."!=",0);
		$this->db->where("j_kehadiran",2);
		$this->db->where("id_meeting",$idmeet);
		$this->db->where("kode_acara",$kode_acara);
		$this->db->where("nama is not null");
		return $this->db->get("data_peserta")->num_rows();
	}
	function totalTamuHadir($kode,$hadir=null)
	{
	    if($hadir){
	         $this->db->where("sts_kehadiran",$hadir);
	    }
	   
	     $this->db->where("kode_acara",$kode);
	     $this->db->where("hapus",0);
		  $this->db->where("j_kehadiran",1);
	    return $this->db->get("data_peserta")->num_rows();
	}
	function totalTamu($kode)
	{ 	$this->db->where("nama is not null");
	     $this->db->where("kode_acara",$kode);
	     $this->db->where("hapus",0);
		  $this->db->where("j_kehadiran",1);
	    return $this->db->get("data_peserta")->num_rows();
	}
}




?>