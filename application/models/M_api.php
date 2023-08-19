<?php

class M_api extends CI_Model  {
    
		
	function __construct()
    {
        parent::__construct();
		
    }
	///////////////////Golongan validasi
    function updateStatusPeserta($id,$json=null)
	{
	
	if($json==null){ return false; }
	/*			$tgl=date("Y-m-d");
				foreach ($json as $key => $entry) {
					if ($key == $tgl ) {
						$data[$tgl] = date('Y-m-d H:i:s');
					}else{
						$data[$key] = $entry;
					}
				}
				 $cekin=json_encode($data);
	*/	  
	 
		$data=array(
		"sts_kehadiran"=>1,
		"cekin"=>date('Y-m-d H:i:s'),
		"gate"=>$this->session->userdata("gate"),
		); 
	 
		   $this->db->where("qr",$id);
	return $this->db->update("data_peserta",$data);
	}
  
}