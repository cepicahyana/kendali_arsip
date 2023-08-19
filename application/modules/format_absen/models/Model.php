<?php
class Model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	// getJenjangPendidikan
	function getJp()
	{
		return  $this->db->get('tr_jp')->result();
	}

	function getJpByid($id)
	{
		$this->db->select('nama');
		$this->db->from('tr_jp');
		$this->db->where('id', $id);
		return $this->db->get()->row();
	}

	public function getData()
	{
		$this->_getData();
		if ($this->input->post("length") != -1)
			$this->db->limit($this->input->post("length"), $this->input->post("start"));
		return $this->db->get()->result();
	}

	private function _getData()
	{
		if (isset($_POST['search']['value'])) {
			$searchkey = $_POST['search']['value'];
			$searchkey = $this->m_reff->sanitize($searchkey);
			$query = array(
				"jam_masuk" => $searchkey,
				"uang_makan" => $searchkey,
				 
			);
			$this->db->group_start()
				->or_like($query)
				->group_end();
		}

		// Filter Tahun
		// $tahun	=	$this->input->post("tahun");
		// if ($tahun) {
		// 	$this->db->where("tahun",$tahun);
		// }

		$this->db->select("tm_format_absen.*");
		$this->db->order_by("jam_masuk", "asc");
		$query = $this->db->from("tm_format_absen");
		return $query;
	}

	public function count()
	{
		$this->_getData();

		return $this->db->get()->num_rows();
	}

	function insert()
	{
		$istana = $this->session->userdata("kode_istana");
		$this->m_reff->log("insert format absen","ppnpn");
		$form	=	$this->input->post("f");
		$this->db->set($form);
		$this->db->set("kode_istana", $istana);
		return $this->db->insert("tm_format_absen");
	}

	function getDataEdit(){
		$this->m_reff->log("Edit format absen","ppnpn");
		$id = $this->input->post("id");
		return $this->db->get_where("tm_format_absen", ["id" => $id])->row();
	}

	function update(){
		$this->m_reff->log("update format absen","ppnpn");
		$id   = $this->input->post("id");
		$form = $this->input->post("f");
		$this->db->set($form);
		$this->db->where("id", $id);
		return $this->db->update("tm_format_absen");
	}

	function hapus(){
		$this->m_reff->log("hapus format absen","ppnpn");
		$id	=	$this->input->post("id");
		$this->db->where("id", $id);
		return $this->db->delete("tm_format_absen");
	}
}