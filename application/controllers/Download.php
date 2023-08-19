<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Download extends CI_Controller {

	function __construct()
	{
		parent::__construct();	
		date_default_timezone_set('Asia/Jakarta');
	 
	}
	
	 
	function index()
	{    
	  	  $file=$this->input->get("f");  
 	      $file = $this->m_reff->decrypt($file); 
		
		if(!$file){ 
			echo "access forbiden "; return false;
		}
		 	$file=$this->m_reff->pengaturan(1)."/".$file;
		if (file_exists($file)) 
				{
						header('Content-Description: File Transfer');
		    			header('Content-Type: application/octet-stream');
		    			header('Content-Disposition: attachment; filename="'.basename($file).'"');
		    			header('Expires: 0');
		    			header('Cache-Control: must-revalidate');
		    			header('Pragma: public');
		    			header('Content-Length: ' . filesize($file));
		    			readfile($file);
		    			exit;
				}else{
				echo "file not found. "; return false;
				}
	}
	 
	 
	
     
}
