<?php
class Model extends CI_Model
{

    
	public function __construct() {
        parent::__construct();
    }
	
	
 function jmlHadir($jenis){
	 $jenis =  $jenis;
	 if(!$jenis){ return false;}
	 $this->db->where("nip",$this->m_reff->nip());
	 $this->db->where("year(tgl)",date("Y"));
	 $this->db->where_in("jenis_absen",$jenis);
	return $this->db->get("data_absen")->num_rows();
 }

}
//End of file data_param.php