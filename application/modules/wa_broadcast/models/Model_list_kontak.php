<?php
class Model_list_kontak extends CI_Model  {
    
	 
	function __construct()
	{
		parent::__construct();
	}

	function nip(){
		return $this->session->userdata("nip");
	}
	function idu(){
		return $this->session->userdata("id");
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
	 	  //$nip = $this->session->userdata("nip");
			// $this->db->where("sts",0);
			/*$pic = $this->session->pic;
			if($pic){
				$this->db->where("nip_pegawai in (select nip from data_pegawai where kode_biro='".$this->m_reff->sanitize($pic)."' )");
			}else{
			    $this->db->where("_cid",$this->idu());
			}*/

		// conditional istana
		$istana	= $this->m_reff->sanitize($this->input->post("kode_istana"));
		if ($istana) {
			$this->db->where("kode_istana", $istana);
		}

		// instansi
		$instansi	= $this->m_reff->sanitize($this->input->post("instansi"));
		if ($instansi) {
			$this->db->where("instansi", $instansi);
		}

		// biro
		$biro	= $this->m_reff->sanitize($this->input->post("kode_biro"));
		if ($biro) {
			$this->db->where("kode_biro", $biro);
		}

		// bagian
		$bagian	= $this->m_reff->sanitize($this->input->post("bagian"));
		if ($bagian) {
			$this->db->where("bagian", $bagian);
		}

			if (strlen(isset($_POST['search']['value'])?($_POST['search']['value']):null)>1) {
					$searchkey = $_POST['search']['value'];
					$searchkey = $this->m_reff->sanitize($searchkey);
					$query=array(
					"nama"=>$searchkey,
					);
					$this->db->group_start()
							->or_like($query)
					->group_end();
					
				}	

				//$this->db->where("jenis_pegawai", "1");
				$this->db->order_by("nama", "asc");
			$query=$this->db->from("data_pegawai");
		return $query;
	}
	public function count()
	{				
			$this->_get_data();
		return $this->db->get()->num_rows();
	}


}




