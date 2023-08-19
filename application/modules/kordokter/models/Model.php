<?php

class Model extends CI_Model  {

    function __construct()
    {
        parent::__construct();
    }

    function jml_obrolan($id){
		$this->db->where("id_msg",$id);
		return	$this->db->get("data_komentar")->num_rows();
	}

    function akhiri_obrolan(){
		$this->db->where("id",$this->input->post("id"));
		$this->db->set("sts",1);
		return	$this->db->update("data_tanya_dokter");
	}

    function idu(){
		return $this->session->userdata("id");
	}

    function saveChat(){
		$id_msg   = $this->input->post("id_msg");
		$msg	  = $this->input->post("msg");
		if(!$msg){ return false;}

		$this->db->set("sts_replay","open");
		$this->db->set("oleh",2); //2=dokter
		$this->db->set("tgl_respon",date("Y-m-d H:i:s"));
		$this->db->where("id",$id_msg);
		$this->db->update("data_tanya_dokter");

		$this->db->set("id_msg",$id_msg);
		$this->db->set("id_sender",$this->idu());
		$this->db->set("msg",$msg);
		$this->db->set("tgl",date('Y-m-d H:i:s'));
		return $this->db->insert("data_komentar");
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

		if (strlen(isset($_POST['search']['value'])?($_POST['search']['value']):null)>1) {
			$searchkey = $_POST['search']['value'];
			$searchkey = $this->m_reff->sanitize($searchkey);

			$query = array(
				"nama" => $searchkey,
				"username" => $searchkey
				 
			);
			$this->db->group_start()
				->or_like($query)
				->group_end();
		}

		$this->db->order_by("id","desc");
		$query=$this->db->from("data_kordokter");
		return $query; 
	}

	public function count()
	{				
		$this->_get_data();
		return $this->db->get()->num_rows();
	}

}