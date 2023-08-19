<?php
class Model extends CI_Model
{


	public function __construct()
	{
		parent::__construct();
	}

	function idu()
	{
		return $this->session->userdata("id");
	}

	/*===================================*/

	public function getData()
	{
		$this->_getData();
		if ($this->input->post("length") != -1)
			$this->db->limit($this->input->post("length"), $this->input->post("start"));
		return $this->db->get()->result();
	}

	private function _getData()
	{
		$tahun = $this->m_reff->sanitize($this->input->post("tahun"));
		$sms = $this->m_reff->sanitize($this->input->post("sms"));
		$this->db->where_in("nip",$this->m_umum->dataPPNPNIn());

		// conditional   
		if($sms){
				$this->db->where("semester",$sms);
		}  
		if($tahun){
				$this->db->where("tahun",$tahun);
		}  

		if (strlen(isset($_POST['search']['value'])?($_POST['search']['value']):null)>2) {
			$searchkey = $_POST['search']['value'];
			$searchkey = $this->m_reff->sanitize($searchkey);

			$query = array(
				"nama" => $searchkey,
				"nip" => $searchkey 
			);
			$this->db->group_start()
				->or_like($query)
				->group_end();
		}
		
		
		// $this->db->limit(10);
		$this->db->order_by("hasil_evaluasi","desc");
		$query = $this->db->from("penilaian_kinerja_ppnpn");
		return $query;
	}

	function bagian($nip){
		$this->db->where("nip",$nip);
		$dta=$this->db->get("data_pegawai")->row();
		return isset($dta->bagian)?($dta->bagian):null;
	}
	public function count()
	{
		$this->_getData();

		return $this->db->get()->num_rows();
	}

	function dataPPNPN(){

		
		$kodebiro = $this->session->kode_biro;
			if($kodebiro){
				$this->db->where("kode_biro",$this->m_reff->sanitize($kodebiro));
			}
			$kode_istana = $this->session->kode_istana;
			if($kode_istana){
				$this->db->where("kode_istana",$kode_istana);
			}


		$key = $this->m_reff->san($this->input->get("search"));
		$this->db->like("nama",$key);
		$db  =   $this->db->get("data_pegawai")->result();
		$var = array();
		$key=0;
		foreach($db as $v){
			$var[$key]["id"] = $v->nip;
			$var[$key]["text"] = $v->nama;
			$key++;
		}
		return $var;
	}

	function getNilai($nip){
		$this->db->order_by("tahun","asc");
		$this->db->order_by("semester","asc");
		$this->db->where("nip",$nip);
		return $this->db->get("penilaian_kinerja_ppnpn")->result();
	}

	function getNilaiAkumulasi(){
		$this->db->where_in("nip",$this->m_umum->dataPPNPNIn());
		$this->db->order_by("tahun","asc");
		$this->db->order_by("semester","asc");
		$this->db->group_by("tahun");
		$this->db->group_by("semester");
		$this->db->select("AVG(hasil_evaluasi) as hasil_evaluasi,tahun,semester,'Nilai keseluruhan' as nama");
		return $this->db->get("penilaian_kinerja_ppnpn")->result();
	}
	function presenstase_predikat($predikat=null,$tahun=null,$sms=null){
			$this->db->where_in("nip",$this->m_umum->dataPPNPNIn());
			$this->db->where("tahun",$tahun);
			$this->db->where("semester",$sms);
			$this->db->where("predikat",$predikat);
			// $this->db->select("predikat,count(*) as jml");
			return $this->db->get("penilaian_kinerja_ppnpn")->num_rows();
	}
	 
}
