<?php
class Model_kontak_group extends CI_Model  {
    
	 
	function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
	}
	function idu(){
		return $this->session->userdata("id");
	}
	function getById($id)
	{
		return $this->db->get_where('broadcast_kontak', ['id'=>$id]);
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

		$group_id = $this->input->post('group');
		if ($group_id) {
			$this->db->where('id_group', $group_id);
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

			$this->db->order_by("nama", "asc");
			$query=$this->db->from("broadcast_kontak");
		return $query;
	}
	public function count()
	{
		$this->_get_data();
		return $this->db->get()->num_rows();
	}
	function countKontakInGroup($id)
	{
		return $this->db->get_where('broadcast_kontak', ['id_group'=>$id])->num_rows();
	}

	function insert(){
		$form 	 = $this->input->post("f");
		 
		$this->db->set($form);
		//$this->db->set('last', date('Y-m-d H:i:s'));
		$this->db->insert("broadcast_kontak");
		
		$this->m_reff->log("insert kontak group");

		$var["token"] = $this->m_reff->getToken();
		return $var;
	}

	function update(){
		$form 	 = $this->input->post("f");
		$id		 = $this->input->post("id");
 
		$this->db->set($form);
		//$this->db->set('last', date('Y-m-d H:i:s'));
		$this->db->where("id",$id);
		$this->db->update("broadcast_kontak");

		$this->m_reff->log("update kontak group");

		$var["token"] = $this->m_reff->getToken();
		return $var;
	}

	function hapus(){
		$id    = $this->input->post("id");

		$this->m_reff->log("delete kontak group");

		$this->db->where("id",$id);
		return    $this->db->delete("broadcast_kontak");
	}
 

}




