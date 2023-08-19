<?php
class Model extends CI_Model
{

    var $tbl="data_kri";
	public function __construct() {
        parent::__construct();
    }
	
	
	/*===================================*/
	public function get_data_statuskri()
	{
		$this->_get_datatables_statuskri();
		if($this->input->post("length") != -1) 
		$this->db->limit($this->input->post("length"),$this->input->post("start"));
	 	return $this->db->get()->result();
	}

	private function _get_datatables_statuskri() 
	{	
		 //$this->db->where("level","3"); 
		 if(isset($_POST['search']['value'])){
			$searchkey=$_POST['search']['value'];
			$searchkey = $this->m_reff->sanitize($searchkey);
				  
				$query=array(
				"namadata"=>$searchkey
				);
				$this->db->group_start()
                        ->or_like($query)
                ->group_end();
				  
			}
		$this->db->order_by("id","asc"); 
		$query=$this->db->from($this->tbl);
		return $query;
	
	}	

	public function count_data_statuskri()
	{		
		$this->_get_datatables_statuskri();
		return $this->db->get()->num_rows();
	}

	public function get_data($table)
	{
		return $this->db->get($table);
	}

	function getKegiatanHarian(){
		$kode_biro =	$this->session->userdata("kode_biro");
		if($kode_biro){
			$this->db->where("kode_biro",$kode_biro);
		}
		$this->db->where("tgl",date("Y-m-d"));
		return $this->db->get("data_tugas_harian")->result();
	}

	function getPPNPN($nip){
		$this->db->where("nip",$nip);
		return $this->db->get("data_pegawai")->row();
	}

	function absenToDay(){
		$kodebiro = $this->session->kode_biro;
			if($kodebiro){
				$this->db->where("kode_biro",$this->m_reff->sanitize($kodebiro));
			}
			$kode_istana = $this->session->kode_istana;
			if($kode_istana){
				$this->db->where("kode_istana",$kode_istana);
			}
			
		$this->db->where_in("nip",$this->m_umum->dataPPNPNin());
		$this->db->where("tgl",date("Y-m-d"));
		return $this->db->get("data_absen")->result();
	}
	
	function jmlAbsen($id){
		$data_in = $this->m_umum->dataPPNPNin();
		
		$this->db->where("tgl",date('Y-m-d'));
		$this->db->where_in("jenis_absen",$id);
		$this->db->where_in("nip",$data_in);
		return $this->db->get("data_absen")->num_rows();
	}

	public function jmlPPNPN($pp = "")
	{
		if ($pp !== "pimpinan") {
			$kodebiro = $this->session->kode_biro;
			if($kodebiro){
				$this->db->where("kode_biro",$this->m_reff->sanitize($kodebiro));
			}
			$kode_istana = $this->session->kode_istana;
			if($kode_istana){
				$this->db->where("kode_istana",$kode_istana);
			}
		}
		$this->db->where("jenis_pegawai",2);
		return $this->db->get("data_pegawai")->num_rows();
	}

	public function saran()
	{ 
		$query = $this->db->get('data_kritik');
		return  $query->num_rows();

	}

	public function pengumuman()
	{ 
		$query = $this->db->get('data_informasi');
		return $query->num_rows();

	}
	
	public function status()
	{ 
		$query = $this->db->get('update_status');
		return  $query->num_rows();

	}


	function countPPNPN_ByBagian()
	{
		$kode_biro =	$this->session->userdata("kode_biro");
		if($kode_biro){
			$this->db->where("kode_biro",$kode_biro);
		}
		$this->db->select("COUNT(id) as jml, bagian");
		$this->db->where("bagian IS NOT NULL");
		$this->db->where("jenis_pegawai", 2);
		$this->db->group_by("bagian");
		return $this->db->get("data_pegawai")->result();
	}

	function getBidang(){

		return $this->db->get_where("data_pegawai")->result();
	}
	
	function jmlBidang($id){
		$kodebiro = $this->session->kode_biro;
		if($kodebiro){
			$this->db->where("kode_biro",$this->m_reff->sanitize($kodebiro));
		}else{
			$this->db->where("istana",$this->session->userdata("istana"));
		}
		$this->db->where("jenis_pegawai",2);
		$this->db->where("bagian",$id);
		return $this->db->get("data_pegawai")->num_rows();
	}



	function negatif(){
		$kode_biro = $this->session->userdata("kode_biro");
		$istana = $this->session->userdata("istana");
		if($this->session->level=="pic_covid"){
			if($kode_biro){
				$this->db->where("kode_biro",$kode_biro);
			}else{
				$this->db->where("istana",$istana);
			}
		}
		$this->db->where("hasil_test","-");
		$this->db->where("kode_test IS NULL");
		return $this->db->get("data_pegawai")->num_rows();
	}

	function positif(){
		$kode_biro = $this->session->userdata("kode_biro");
		$istana = $this->session->userdata("istana");
		if($this->session->level=="pic_covid"){

		if($kode_biro){
			$this->db->where("kode_biro",$kode_biro);
		}else{
			$this->db->where("istana",$istana);
		}

	}

		$this->db->where("hasil_test","+");
		$this->db->where("kode_test IS NOT NULL");
		return $this->db->get("data_pegawai")->num_rows();
	}

    


}
//End of file data_param.php