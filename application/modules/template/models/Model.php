<?php

class Model extends CI_Model  {
    
	 
	function __construct()
    {
        parent::__construct();
    }
	 
	function update()
	{
		$kode	=	$this->input->post("id");
		$form	=	isset($_POST["template_1"])?($_POST["template_1"]):"";
		
		$this->db->set("template_1",$form);
		$this->db->where("kode",$kode);
		return $this->db->update("data_acara");
	}	 
	function update_presiden()
	{
		$kode	=	$this->input->post("id");
		$form	=	isset($_POST["template_1"])?($_POST["template_1"]):"";
		$form2	=	isset($_POST["template_2"])?($_POST["template_2"]):"";
		
		$this->db->set("template_1",$form);
		$this->db->set("template_2",$form2);
		$this->db->where("kode",$kode);
		return $this->db->update("data_acara");
	}	
	
	function setTemplate()
	{
		$kode		=	$this->input->post("kode");
		$id_temp	=	$this->input->post("id_template");
		$temp		=	$this->m_reff->goField("template_undangan","isi","where id='".$id_temp."' ");
		if(!$temp){ return false;}
		
		
		$this->db->set("template_1",$temp);
		$this->db->where("kode",$kode);
		return $this->db->update("data_acara");
	}	
	function setTemplatePresiden()
	{
		$kode		=	$this->input->post("kode");
		$id_temp	=	$this->input->post("id_template");
		$temp		=	$this->m_reff->goField("template_undangan","isi","where id='".$id_temp."' ");
		$temp2		=	$this->m_reff->goField("template_undangan","isi_inggris","where id='".$id_temp."' ");
		if(!$temp){ return false;}
		
		
		$this->db->set("template_1",$temp);
		$this->db->set("template_2",$temp2);
		$this->db->where("kode",$kode);
		return $this->db->update("data_acara");
	}	
	
	
	function update_template()
	{
		$id			=	$this->input->post("id");
		$nama		=	$this->input->post("nama");
		$form		=	isset($_POST["isi"])?($_POST["isi"]):"";
		
				$dok				=	"plug/img/temp";
				$before_file		=	$this->m_reff->goField("template_undangan","poto","where id='".$id."'");
				$file=$this->m_reff->upload_file("poto",$dok,$nama_file_awal="temp",$type_file_yg_diizinkan="JPG,JPEG,PNG",$sizeFile="3000000",$before_file);
				if($file["validasi"]!=false)
				{  
					 
					$this->db->set("poto",$file["name"]); 
				}
		 
		$this->db->set("nama",$nama);
		$this->db->set("isi",$form);
		$this->db->where("id",$id);
		return $this->db->update("template_undangan");
	}	
	
	function update_template_presiden()
	{
		$id			=	$this->input->post("id");
		$nama		=	$this->input->post("nama");
		$form		=	isset($_POST["template_1"])?($_POST["template_1"]):"";
		$form2		=	isset($_POST["template_2"])?($_POST["template_2"]):"";
		
				$dok				=	"plug/img/temp";
				$before_file		=	$this->m_reff->goField("template_undangan","poto","where id='".$id."'");
				$file=$this->m_reff->upload_file("poto",$dok,$nama_file_awal="temp",$type_file_yg_diizinkan="JPG,JPEG,PNG",$sizeFile="3000000",$before_file);
				if($file["validasi"]!=false)
				{  
					 
					$this->db->set("poto",$file["name"]); 
				}
		 
		$this->db->set("nama",$nama);
		$this->db->set("isi",$form);
		$this->db->set("isi_inggris",$form2);
		$this->db->where("id",$id);
		return $this->db->update("template_undangan");
	}	
	
	function create_template()
	{
		$id_acara			=	$this->input->post("id_acara");
		$nama		=	$this->input->post("nama");
		$form		=	isset($_POST["isi"])?($_POST["isi"]):"";
		
				$dok				=	"plug/img/temp"; 
				$file=$this->m_reff->upload_file("poto",$dok,$nama_file_awal="temp",$type_file_yg_diizinkan="JPG,JPEG,PNG",$sizeFile="3000000",$before_file=null);
				if($file["validasi"]!=false)
				{   
					$this->db->set("poto",$file["name"]); 
				}
		 
		$this->db->set("nama",$nama);
		$this->db->set("isi",$form);
		$this->db->set("id_acara",$id_acara);
		return $this->db->insert("template_undangan");
	}	
	function create_template_presiden()
	{
		$id_acara	=	$this->input->post("id_acara");
		$nama		=	$this->input->post("nama");
		$form		=	isset($_POST["isi"])?($_POST["isi"]):"";
		$form2		=	isset($_POST["isi_inggris"])?($_POST["isi_inggris"]):"";
		
				$dok				=	"plug/img/temp"; 
				$file=$this->m_reff->upload_file("poto",$dok,$nama_file_awal="temp",$type_file_yg_diizinkan="JPG,JPEG,PNG",$sizeFile="3000000",$before_file=null);
				if($file["validasi"]!=false)
				{   
					$this->db->set("poto",$file["name"]); 
				}
		 
		$this->db->set("nama",$nama);
		$this->db->set("isi_inggris",$form2);
		$this->db->set("isi",$form);
		$this->db->set("id_acara",$id_acara);
		return $this->db->insert("template_undangan");
	}		
	function deleteTemplate()
	{
		$id	=	$this->input->post("id");
		$id	=	$this->m_reff->decrypt($id);
		$this->db->where("id",$id);
		return $this->db->delete("template_undangan");
	}
}




