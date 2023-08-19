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
		if (strlen(isset($_POST['search']['value'])?($_POST['search']['value']):null)>1) {
			$searchkey = $_POST['search']['value'];
			$searchkey = $this->m_reff->sanitize($searchkey);

			$query = array(
				"bulan_mulai" => $searchkey,
				"tgl_mulai" => $searchkey,
				"bulan_akhir" => $searchkey,
				"tgl_akhir" => $searchkey,
				 
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

		$this->db->select("pengaturan_absen.*");
		$this->db->order_by("id", "asc");
		$query = $this->db->from("pengaturan_absen");
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
		$form	=	$this->input->post("f");

		$this->m_reff->log("Input data pengaturan absen");

		$this->db->set($form);
		$this->db->set("kode_istana", $istana);
		$this->db->insert("pengaturan_absen");
		$var["token"] = $this->m_reff->getToken();
		return $var;
	}

	function update(){
		$id = $this->input->post("id");

		$this->m_reff->log("Update data pengaturan absen");
		
		$form = $this->input->post("f");
		$this->db->where("id", $id);
		$this->db->set($form);
		$this->db->update("pengaturan_absen");
		$var["token"] = $this->m_reff->getToken();
		return $var;
	}

	function hapus(){
		$id = $this->input->post("id");

		$this->m_reff->log("Hapus data pengaturan absen","ppnpn");

		$this->db->where("id",$id);
		$this->db->delete("pengaturan_absen");

		$var["token"] = $this->m_reff->getToken();
		return $var;
	}

}