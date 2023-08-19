<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Template extends MY_Controller {

	

	function __construct()
	{
		parent::__construct();	
		$this->m_konfig->validasi_session(array("admin"));
		$this->load->model("model","mdl");
		date_default_timezone_set('Asia/Jakarta');
	}
	function edit()
	{
		$kode	=	$this->input->get("id");
		if(!$kode){ return $this->m_reff->page403();}

		$this->db->where("kode",$kode);
		$cek	=	$this->db->get("data_acara");
		if(!$cek->num_rows())
		{
			echo $this->m_reff->page404(); return false;
		}
		$cek=$cek->row();
		
		if($cek->id_acara)
		{
			$page="pelantikan";
		} else{
			echo $this->m_reff->page404(); return false;
		}
		
		$ajax=$this->input->post("ajax");
		if($ajax=="yes")
		{			$data['db']=$cek;
			echo	$this->load->view($page,$data);
		}else{
			
			$data['konten']=$page;
			$data['db']=$cek;
			$this->_template($data);
		}
	}
	function index()
	{
		$kode	=	$this->input->get("id");
		redirect("template/edit?id=".$kode);
					
	}
	function presiden()
	{
		$kode	=	$this->input->get("id");
					$this->db->where("kode",$kode);
		$cek	=	$this->db->get("data_acara");
		if(!$cek->num_rows())
		{
			echo $this->m_reff->page404(); return false;
		}
		$cek=$cek->row();
		
		if($cek->id_acara)
		{
			$page="presiden";
		} else{
			echo $this->m_reff->page404(); return false;
		}
		
		$ajax=$this->input->post("ajax");
		if($ajax=="yes")
		{			$data['db']=$cek;
			echo	$this->load->view($page,$data);
		}else{
			
			$data['konten']=$page;
			$data['db']=$cek;
			$this->_template($data);
		}
	}
	 function create()
	{ 				$id	=	$this->input->get("id");
					$this->db->where("id",$id);
		$cek	=	$this->db->get("tr_jenis_kegiatan");
		if(!$cek->num_rows())
		{
			echo $this->m_reff->page404(); return false;
		}
		$cek=$cek->row();
		
		$page	=	"create";
		$ajax	=	$this->input->post("ajax");
		if($ajax=="yes")
		{			$data['id']=$$id;
			echo	$this->load->view($page,$data);
		}else{
			
			$data['konten']=$page;
			$data['id']=$id;
			$this->_template($data);
		}
	}
	 function pres_create()
	{ 
					$id	=	$this->input->get("id");
					$this->db->where("id",$id);
		$cek	=	$this->db->get("tr_jenis_kegiatan");
		if(!$cek->num_rows())
		{
			echo $this->m_reff->page404(); return false;
		}
		$cek=$cek->row();
		
		$page	=	"pres_create";
		$ajax	=	$this->input->post("ajax");
		if($ajax=="yes")
		{			$data['id']=$$id;
			echo	$this->load->view($page,$data);
		}else{
			
			$data['konten']=$page;
			$data['id']=$id;
			$this->_template($data);
		}
	}
	
	function edit_template()
	{
		$id		=	$this->input->get("id");
					$this->db->where("id",$id);
		$cek	=	$this->db->get("template_undangan");
		if(!$cek->num_rows())
		{
			echo $this->m_reff->page404(); return false;
		}
		$cek=$cek->row();
		
		$page	=	"edit";
		$ajax	=	$this->input->post("ajax");
		if($ajax=="yes")
		{			$data['db']=$cek;
			echo	$this->load->view($page,$data);
		}else{
			
			$data['konten']=$page;
			$data['db']=$cek;
			$this->_template($data);
		}
	}
	 
	 function edit_template_presiden()
	{
		$id		=	$this->input->get("id");
					$this->db->where("id",$id);
		$cek	=	$this->db->get("template_undangan");
		if(!$cek->num_rows())
		{
			echo $this->m_reff->page404(); return false;
		}
		$cek=$cek->row();
		
		$page	=	"edit_template_presiden";
		$ajax	=	$this->input->post("ajax");
		if($ajax=="yes")
		{			$data['db']=$cek;
			echo	$this->load->view($page,$data);
		}else{
			
			$data['konten']=$page;
			$data['db']=$cek;
			$this->_template($data);
		}
	}
	 
	 
	function _template($data)
	{
	$this->load->view('temp_user/main',$data);	
	}
	   
	function setTemplate()
	{
		$kode=$this->input->post('kode');
		if(!$kode){ return $this->m_reff->page403();}
		echo json_decode($this->mdl->setTemplate());
	}     
	function setTemplatePresiden()
	{
		$kode=$this->input->post('kode');
		if(!$kode){ return $this->m_reff->page403();}
		echo json_decode($this->mdl->setTemplatePresiden());
	}   
	function update()
	{
		$id=$this->input->post('id');
		if(!$id){ return $this->m_reff->page403();}
		echo json_decode($this->mdl->update());
	}function update_presiden()
	{
		$id=$this->input->post('id');
		if(!$id){ return $this->m_reff->page403();}
		echo json_decode($this->mdl->update_presiden());
	}function create_template()
	{
		$id_acara=$this->input->post('id_acara');
		if(!$id_acara){ return $this->m_reff->page403();}
		echo json_decode($this->mdl->create_template());
	}function create_template_presiden()
	{
		$id_acara=$this->input->post('id_acara');
		if(!$id_acara){ return $this->m_reff->page403();}
		echo json_decode($this->mdl->create_template_presiden());
	}function update_template()
	{
		$id=$this->input->post('id');
		if(!$id){ return $this->m_reff->page403();}
		echo json_decode($this->mdl->update_template());
	}function update_template_presiden()
	{
		$id=$this->input->post('id');
		if(!$id){ return $this->m_reff->page403();}
		echo json_decode($this->mdl->update_template_presiden());
	}function deleteTemplate()
	{
		$id=$this->input->post('id');
		if(!$id){ return $this->m_reff->page403();}
		echo json_decode($this->mdl->deleteTemplate());
	}
	
	
	
	
	function konsep_undangan()
	{   $kode= $this->input->get("kode"); 
		if(!$kode){ return $this->m_reff->page403();}
    	$tahun= $this->input->get("tahun"); 
	    
		ob_start();
		//include('file.html');
		$isi=$this->load->view('konsep_undangan');
		$isi = ob_get_clean();

		require_once('assets/html2pdf/html2pdf.class.php');
		try{
	      $html2pdf = new HTML2PDF('P','A4', 'en', true, '', array(5,5, 5, 5));
		   $html2pdf->AddFont('monotypecorsiva', 'bold', 'monotypecorsiva.php');
		  //$html2pdf->AddFont('robotomedium', 'normal', 'robotomedium.php');
		 // $html2pdf->setDefaultFont('monotypecorsiva');
		 $html2pdf->writeHTML($isi, isset($_GET['vuehtml']));
		 //$html2pdf->Output('data-peserta.pdf');
		///  $html2pdf->Output('files/'.$tahun.'/'.$kode.'/konsep-acara-besar.pdf', 'F');
		    $html2pdf->Output('konsep-acara-besar.pdf');
		}
		catch(HTML2PDF_exception $e){
		 echo $e;
		 exit;
		}
		//redirect(base_url()."files/".$tahun."/".$kode."/konsep-acara-besar.pdf");
	}
	
	
	
	
	
	function konsep_undangan_eng()
	{   $kode= $this->input->get("kode"); 
		if(!$kode){ return $this->m_reff->page403();}
    	$tahun= $this->input->get("tahun"); 
	    
		ob_start();
		//include('file.html');
		$isi=$this->load->view('konsep_undangan_eng');
		$isi = ob_get_clean();

		require_once('assets/html2pdf/html2pdf.class.php');
		try{
	      $html2pdf = new HTML2PDF('P','A4', 'en', true, '', array(5,5, 5, 5));
		   $html2pdf->AddFont('monotypecorsiva', 'bold', 'monotypecorsiva.php');
		  //$html2pdf->AddFont('robotomedium', 'normal', 'robotomedium.php');
		 // $html2pdf->setDefaultFont('monotypecorsiva');
		 $html2pdf->writeHTML($isi, isset($_GET['vuehtml']));
		 //$html2pdf->Output('data-peserta.pdf');
		///  $html2pdf->Output('files/'.$tahun.'/'.$kode.'/konsep-acara-besar.pdf', 'F');
		    $html2pdf->Output('konsep-acara-besar.pdf');
		}
		catch(HTML2PDF_exception $e){
		 echo $e;
		 exit;
		}
		//redirect(base_url()."files/".$tahun."/".$kode."/konsep-acara-besar.pdf");
	}
	
	
	
	
	function pdf_preview($kode=null)
	{
		
		 
	     $this->db->where("kode",$kode);
		 $data=$this->db->get("data_acara")->row();
		 if(!$data){ echo $this->m_reff->page404();	return false;	}
		 
		
		 if($data->id_acara)
		{
			$page="previe_pelantikan";
		}else{
			echo $this->m_reff->page404(); return false;
		}
		
		
		$datam["data"]=$data;
		 
		ob_start();
		//include('file.html');
		$isi=$this->load->view($page,$datam);  
		$isi = ob_get_clean();

		require_once('assets/html2pdf/html2pdf.class.php');
		try{
		 $html2pdf = new HTML2PDF('L',array("120","180"), 'en', true, '', array(0,0,0,0));
		 $html2pdf->writeHTML($isi, isset($_GET['vuehtml']));
		   $html2pdf->AddFont('monotypecorsiva', 'bold', 'monotypecorsiva.php'); 
		   $html2pdf->Output('plug/temporary/kartu_undangan_mensesneg.pdf');
		}
		catch(HTML2PDF_exception $e){
		 echo $e;
		 exit;
		}
	}
	
	function pdf_preview_presiden($kode=null)
	{
		
		 
	     $this->db->where("kode",$kode);
		 $data=$this->db->get("data_acara")->row();
		 if(!$data){ echo $this->m_reff->page404();	return false;	}
		 
		
		 if($data->id_acara)
		{
			$page="previe_presiden";
		}else{
			echo $this->m_reff->page404(); return false;
		}
		
		
		$datam["data"]=$data;
		 
		ob_start();
		//include('file.html');
		$isi=$this->load->view($page,$datam);  
		$isi = ob_get_clean();

		require_once('assets/html2pdf/html2pdf.class.php');
		try{
		 $html2pdf = new HTML2PDF('L',array("120","180"), 'en', true, '', array(0,0,0,0));
		 $html2pdf->writeHTML($isi, isset($_GET['vuehtml']));
		   $html2pdf->AddFont('monotypecorsiva', 'bold', 'monotypecorsiva.php'); 
		   $html2pdf->Output('plug/temporary/kartu_undangan_mensesneg.pdf');
		}
		catch(HTML2PDF_exception $e){
		 echo $e;
		 exit;
		}
	}function preview_edit_pdf($kode=null)
	{
		
		 
	     $this->db->where("id",$kode);
		 $data=$this->db->get("template_undangan")->row();
		 if(!$data){ return false;	}
		 
		  $page="preview_edit";
		 
		
		
		$datam["data"]=$data;
		 
		ob_start();
		//include('file.html');
		$isi=$this->load->view($page,$datam);  
		$isi = ob_get_clean();

		require_once('assets/html2pdf/html2pdf.class.php');
		try{
		 $html2pdf = new HTML2PDF('L',array("120","180"), 'en', true, '', array(0,0,0,0));
		 $html2pdf->writeHTML($isi, isset($_GET['vuehtml']));
		  $html2pdf->AddFont('monotypecorsiva', 'bold', 'monotypecorsiva.php'); 
		   $html2pdf->Output('plug/temporary/kartu_undangan_mensesneg.pdf');
		}
		catch(HTML2PDF_exception $e){
		 echo $e;
		 exit;
		}
	}
	function preview_edit_presiden_pdf($kode=null)
	{
		
		 
	     $this->db->where("id",$kode);
		 $data=$this->db->get("template_undangan")->row();
		 if(!$data){ return false;	}
		 
		  $page="preview_edit_presiden";
		 
		
		
		$datam["data"]=$data;
		 
		ob_start();
		//include('file.html');
		$isi=$this->load->view($page,$datam);  
		$isi = ob_get_clean();

		require_once('assets/html2pdf/html2pdf.class.php');
		try{
		 $html2pdf = new HTML2PDF('L',array("120","180"), 'en', true, '', array(0,0,0,0));
		 $html2pdf->writeHTML($isi, isset($_GET['vuehtml']));
		  $html2pdf->AddFont('monotypecorsiva', 'bold', 'monotypecorsiva.php'); 
		   $html2pdf->Output('plug/temporary/kartu_undangan_mensesneg.pdf');
		}
		catch(HTML2PDF_exception $e){
		 echo $e;
		 exit;
		}
	}
	
	function save_direct($id=null)
	{
		 
						$this->db->where("id_acara",$id);
						$this->db->order_by("id","DESC");
		$db			=	$this->db->get("template_undangan")->row();
		$id_acara	=	isset($db->id)?($db->id):"";
				if(!$id_acara)
				{
					echo $this->m_reff->page404(); return false;
				}
				$this->session->set_flashdata("msg","ok");
		redirect("template/edit_template/?id=".$id_acara);
		
	}
	
	function save_direct_presiden($id=null)
	{
		 
						$this->db->where("id_acara",$id);
						$this->db->order_by("id","DESC");
		$db			=	$this->db->get("template_undangan")->row();
		$id_acara	=	isset($db->id)?($db->id):"";
				if(!$id_acara)
				{
					echo $this->m_reff->page404(); return false;
				}
				$this->session->set_flashdata("msg","ok");
		redirect("template/edit_template_presiden/?id=".$id_acara);
		
	}
	
	
	function preview_create_pdf($kode=null)
	{
		
		 
	     $this->db->where("id_acara",$kode);
		 $this->db->order_by("id","DESC");
		 $data=$this->db->get("template_undangan")->row();
		 if(!$data){ return false;	}
		 
		  $page="preview_create";
		 
		
		
		$datam["data"]=$data;
		 
		ob_start();
		//include('file.html');
		$isi=$this->load->view($page,$datam);  
		$isi = ob_get_clean();

		require_once('assets/html2pdf/html2pdf.class.php');
		try{
		 $html2pdf = new HTML2PDF('L',array("120","180"), 'en', true, '', array(0,0,0,0));
		 $html2pdf->writeHTML($isi, isset($_GET['vuehtml']));
		  $html2pdf->AddFont('monotypecorsiva', 'bold', 'monotypecorsiva.php'); 
		   $html2pdf->Output('plug/temporary/kartu_undangan_mensesneg.pdf');
		}
		catch(HTML2PDF_exception $e){
		 echo $e;
		 exit;
		}
	}
	function preview()
	{	
		$kode	= $this->input->post("kode");
		if(!$kode){ return $this->m_reff->page403();}
		echo '<iframe src="'.base_url().'template/pdf_preview/'.$kode.'" height="500" width="100%"></iframe>';
	}	
	function preview_presiden()
	{	 
		$kode	= $this->input->post("kode");
		if(!$kode){ return $this->m_reff->page403();}
		echo '<iframe src="'.base_url().'template/pdf_preview_presiden/'.$kode.'" height="500" width="100%"></iframe>';
	}
	function preview_edit()
	{	 
		$kode	= $this->input->post("kode");
		if(!$kode){ return $this->m_reff->page403();}
		echo '<iframe src="'.base_url().'template/preview_edit_pdf/'.$kode.'" height="500" width="100%"></iframe>';
	}	
	function preview_edit_presiden()
	{	
		$kode	= $this->input->post("kode");
		if(!$kode){ return $this->m_reff->page403();}
		echo '<iframe src="'.base_url().'template/preview_edit_presiden_pdf/'.$kode.'" height="500" width="100%"></iframe>';
	}
	function preview_create()
	{	 
		$id_acara	= $this->input->post("id_acara");
		if(!$id_acara){ return $this->m_reff->page403();}
		echo '<iframe src="'.base_url().'template/preview_create_pdf/'.$id_acara.'" height="500" width="100%"></iframe>';
	}
	function ghaelery_template()
	{
		$this->load->view("ghaelery_template");
	}	function ghaelery_template_presiden()
	{
		$this->load->view("ghaelery_template_presiden");
	}
	function ghaelery_template_set()
	{
		$this->load->view("ghaelery_template_set");
	}
		function ghaelery_template_set_pres()
	{
		$this->load->view("ghaelery_template_set_pres");
	}
	
	function preview_template($id=null)
	{	
		  $this->db->where("id",$id);
		 $data=$this->db->get("template_undangan")->row();
		 if(!$data){ $this->m_reff->page404();return false;	}
		 
		 
			$page="preview_template";
		 
		
		
		$datam["data"]=$data;
		 
		ob_start();
		//include('file.html');
		$isi=$this->load->view($page,$datam);  
		$isi = ob_get_clean();

		require_once('assets/html2pdf/html2pdf.class.php');
		try{
		 $html2pdf = new HTML2PDF('L',array("120","180"), 'en', true, '', array(0,0,0,0));
		 $html2pdf->writeHTML($isi, isset($_GET['vuehtml']));
		  $html2pdf->AddFont('monotypecorsiva', 'bold', 'monotypecorsiva.php'); 
		   $html2pdf->Output('plug/temporary/kartu_undangan_mensesneg.pdf');
		}
		catch(HTML2PDF_exception $e){
		 echo $e;
		 exit;
		}
	}
	function cetak_undangan()
	{
		 $kode= $this->input->get("kode");
		 if(!$kode){ return $this->m_reff->page403();}
		 $tahun= $this->input->get("tahun");
       $id= $this->input->get("id"); 
		$data['id']=$id; 
		ob_start();
		//include('file.html');
		$isi=$this->load->view('cetak_undangan',$data);  
		$isi = ob_get_clean();

		require_once('assets/html2pdf/html2pdf.class.php');
		try{
		 $html2pdf = new HTML2PDF('L',array("120","180"), 'en', true, '', array(0,0,0,0));
		 $html2pdf->writeHTML($isi, isset($_GET['vuehtml']));
		  //$html2pdf->AddFont('monotypecorsivas', 'bold', 'monotypecorsiva.php'); 
		   $html2pdf->Output('cetak-undangan.pdf');
		}
		catch(HTML2PDF_exception $e){
		 echo $e;
		 exit;
		}
	//	redirect("plug/temporary/cetak-undangan-ibn.pdf");
	}
	
	function cetak_label()
	{
		 
       $id= $this->input->get("id"); 
	   if(!$id){ return $this->m_reff->page403();}
		$data['id']=$id; 
		ob_start();
		//include('file.html');
		$isi=$this->load->view('cetak_label_121',$data); 
		$isi = ob_get_clean();

		require_once('assets/html2pdf/html2pdf.class.php');
		try{
		  $html2pdf = new HTML2PDF('P',array("210","165"), 'en', true, '', array(0.5,0.5,0,0));
		 $html2pdf->writeHTML($isi, isset($_GET['vuehtml']));
		 $html2pdf->Output('undangan.pdf');
		}
		catch(HTML2PDF_exception $e){
		 echo $e;
		 exit;
		}
	}
	
	 
}