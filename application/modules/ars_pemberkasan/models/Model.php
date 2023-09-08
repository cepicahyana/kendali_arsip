<?php

class Model extends CI_Model  {
    
	 
	function __construct()
    {
        parent::__construct();
    }
    function updateText()
	{
		$form = $this->m_reff->san($this->input->post("val"));
		$this->db->set("val",$form);
		$this->db->where("id",$this->m_reff->san($this->input->post("id")));
		return $this->db->update("pengaturan");
	}


	function usiaMin(){ // <20
		$tgl = $this->tanggal->minTahun(20);
		$this->db->where("tgl_lahir>=",$tgl);
		return $this->db->get("data_pegawai")->num_rows();
	}
	
	function usiaMax(){ // <20
		$tgl = $this->tanggal->minTahun(50);
		$this->db->where("tgl_lahir<=",$tgl);
		return $this->db->get("data_pegawai")->num_rows();
	}
	
	function usia($min,$max){ 
		$tgl1 = $this->tanggal->minTahun($min);
		$tgl2 = $this->tanggal->minTahun($max);
		$this->db->where("tgl_lahir>",$tgl2);
		$this->db->where("tgl_lahir<=",$tgl1);
		return $this->db->get("data_pegawai")->num_rows();
	}

	function goldar($goldar)
	{
		$this->db->where("id_goldar",$goldar);
		return $this->db->get("data_pegawai")->num_rows();
	}
	function jenjangPendidikan()
	{
		$this->db->select('COUNT(id) as jml, id_jp');
		$this->db->group_by('id_jp');
		return $this->db->get('data_pegawai')->result();
	}

	// Mulai Datatable
	function getData_berkaslist()
	{
		 $this->_getData_berkaslist();
		if($this->m_reff->san($this->input->post("length")!=-1)) 
		$this->db->limit($this->m_reff->san($this->input->post("length")),$this->m_reff->san($this->input->post("start")));
	 	return $this->db->get()->result();
		 
	}

	public function count_tingkaPerkembangan()
	{				
			$this->_getData_berkaslist();
		return $this->db->get()->num_rows();
	}

	function _getData_berkaslist()
	{
		  
		    if (strlen(isset($_POST['search']['value'])?($_POST['search']['value']):null)>1) {
                $searchkey = $_POST['search']['value'];
                $searchkey = $this->m_reff->sanitize($searchkey);
				$query=array(
				"nama"=>$searchkey 
				);
				$this->db->group_start()
                        ->or_like($query)
                ->group_end();
				
			}		 
		$this->db->select("a.*, CONCAT(kka.kode, ' - ', kka.nama) as kka");
		$this->db->where('a.status', $this->input->post('type'));
		$this->db->join("ars_tr_kka kka","a.kka_kode = kka.kode");
		$query=$this->db->from("ars_trx_berkas a");
		return $query;
	}

	function getData_arsiplist()
	{
		 $this->_getData_arsiplist();
		if($this->m_reff->san($this->input->post("length")!=-1)) 
		$this->db->limit($this->m_reff->san($this->input->post("length")),$this->m_reff->san($this->input->post("start")));
	 	return $this->db->get()->result();
		 
	}

	public function count_arsipList()
	{				
			$this->_getData_arsiplist();
		return $this->db->get()->num_rows();
	}

	function _getData_arsiplist()
	{
		  
		    if (strlen(isset($_POST['search']['value'])?($_POST['search']['value']):null)>1) {
                $searchkey = $_POST['search']['value'];
                $searchkey = $this->m_reff->sanitize($searchkey);
				$query=array(
				"nama"=>$searchkey 
				);
				$this->db->group_start()
                        ->or_like($query)
                ->group_end();
				
			}		 
		$this->db->select("a.*, CONCAT(kka.kode, ' - ', kka.nama) as kka");
		$this->db->join("ars_tr_kka kka","a.kka_kode = kka.kode");
		$this->db->where('kka_kode', $this->input->post('kka'));
		$query=$this->db->from("ars_trx_arsip a");
		return $query;
	}
	// Akhir Datatable

	function update_berkas(){
        $id = $this->input->post("id");
        $form = $this->input->post("f");
        $type=$this->input->post("f[type]");
        $this->db->set($form);
        if($id){
            $this->db->set("_uid",$this->session->userdata("nip"));
            $this->db->set("_utime",date('Y-m-d H:i:s'));
            $this->db->where("id",$id);
            $this->db->update("ars_trx_berkas");
            $this->m_reff->log("update data berkas");
        }else{
            $this->db->set('uuid',$this->getUUID());
            $this->db->set('status',1);
            $this->db->set("_cid",$this->session->userdata("nip"));
            $this->db->set("_ctime",date('Y-m-d H:i:s'));
            $this->db->insert("ars_trx_berkas");
			$insert_id = $this->db->insert_id();
            $this->m_reff->log("menambahkan data berkas");
        }

		if ($this->db->affected_rows() == 0) {
			$var["gagal"]=true;
            $var["info"]="Gagal Diinput.";
            $var["token"]=$this->m_reff->getToken();
            return $var;
		}

		$this->insert_arsip_to_berkas($insert_id);

		$var["gagal"]=false;
		$var["token"]=$this->m_reff->getToken();
		return $var;
    }

	function insert_arsip_to_berkas($id) {
		$data = $this->db->get_where("ars_trx_berkas", array("id" => $id))->row();
		
		for ($i = 0; $i < $this->input->post('JmlUpload'); $i++) {
			$this->db->set("berkas_uuid",$data->uuid);
			$this->db->set("_uid",$this->session->userdata("nip"));
            $this->db->set("_utime",date('Y-m-d H:i:s'));
            $this->db->where("id",$this->input->post('file_' . $i));
            $this->db->update("ars_trx_arsip");
            $this->m_reff->log("update data arsip");
		}
	}

	public function getData_JRA($id=0)
	{
		if($id){
			$this->db->where("a.id",$id);
		}
		$this->db->select("a.*, b.nama as nama_tindak_lanjut");
		$this->db->join("ars_tr_tindak_lanjut b","a.tindak_lanjut_uuid = b.uuid");
		$this->db->from("ars_tr_jra a");
		return $this->db->get()->row();
	}
	
	function getUUID(){
		$query = "SELECT UUID() as datauuid";
        $v =  $this->db->query($query)->row_array();
        return $v['datauuid'];
	}
}




