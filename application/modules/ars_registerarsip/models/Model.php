<?php

class Model extends CI_Model  {
    
	 
	function __construct()
    {
        parent::__construct();
    }
	
	// Mulai Datatable
	function getData_arsiplist()
	{
		 $this->_getData_arsiplist();
		if($this->m_reff->san($this->input->post("length")!=-1)) 
		$this->db->limit($this->m_reff->san($this->input->post("length")),$this->m_reff->san($this->input->post("start")));
	 	return $this->db->get()->result();
		 
	}

	public function count_tingkaPerkembangan()
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
		$type = $this->input->post('type') == 3 ? [3,4,5] : [$this->input->post('type')];
		$this->db->select("a.*, CONCAT(kka.kode, ' - ', kka.nama) as kka, tp.nama as tingkat_perkembangan");
		$this->db->where_in("jenis",$type);
		$this->db->join("ars_tr_kka kka","a.kka_kode = kka.kode");
		$this->db->join("ars_tr_tingkat_perkembangan tp","a.tingkat_perkembangan_id = tp.id");
		$query=$this->db->from("ars_trx_arsip a");
		return $query;
	}
	// Akhir Datatable


	function getData_klasifikasiArsip()
	{
		$this->_getData_klasifikasiArsip();
		if($this->m_reff->san($this->input->post("length")!=-1)) 
		$this->db->limit($this->m_reff->san($this->input->post("length")),$this->m_reff->san($this->input->post("start")));
	 	return $this->db->get()->result();
		 
	}
	function _getData_klasifikasiArsip()
	{
		if (strlen(isset($_POST['search']['value'])?($_POST['search']['value']):null)>=1) {
			$searchkey = $_POST['search']['value'];
			$searchkey = $this->m_reff->sanitize($searchkey);
			$query=array(

			"description"=>$searchkey,
				
			);
			$this->db->group_start()
					->or_like($query)
			->group_end();
		}		 
		$query=$this->db->from("ars_tr_kka");
		return $query;
	}
	
	public function count_klasifikasiArsip()
	{				
			$this->_getData_klasifikasiArsip();
		return $this->db->get()->num_rows();
	}

	public function getData_JRA($id=0)
	{
		if($id){
			$this->db->where("a.uuid",$id);
		}
		$this->db->select("a.*, b.nama as nama_tindak_lanjut");
		$this->db->join("ars_tr_tindak_lanjut b","a.tindak_lanjut_uuid = b.uuid");
		$this->db->from("ars_tr_jra a");
		return $this->db->get()->row();
	}

	function update_arsip(){
        $id = $this->input->post("id");
        $form = $this->input->post("f");
        $type=$this->input->post("f[type]");
		$files = $_FILES;
        $this->db->set($form);
        if($id){
            $this->db->set("_uid",$this->session->userdata("nip"));
            $this->db->set("_utime",date('Y-m-d H:i:s'));
            $this->db->where("id",$id);
            $this->db->update("ars_trx_arsip");
            $this->m_reff->log("update data arsip");
        }else{
			if (!isset($form['nomor'])) $this->db->set('nomor', $this->checkNumber());
            $this->db->set('uuid',$this->getUUID());
            $this->db->set('status',1);
            $this->db->set("_cid",$this->session->userdata("nip"));
            $this->db->set("_ctime",date('Y-m-d H:i:s'));
            $this->db->insert("ars_trx_arsip");
			$insert_id = $this->db->insert_id();
            $this->m_reff->log("menambahkan data arsip");
        }

		if ($this->db->affected_rows() == 0) {
			$var["gagal"]=true;
            $var["info"]="Gagal Diinput.";
            $var["token"]=$this->m_reff->getToken();
            return $var;
		} 

		$this->upload_file($insert_id);

		$var["gagal"]=false;
		$var["token"]=$this->m_reff->getToken();
		return $var;
    }

	function upload_file($id) {
		$this->load->helper('file');
		$data = $this->db->get_where("ars_trx_arsip", array("id" => $id))->row();

		$config['upload_path']="./file_upload/" . date('Y') . '/arsip/' . $data->uuid . '/';
		if(!is_dir($config['upload_path'])) {
			mkdir($config['upload_path'], 0777, true);
		}		
		$config['allowed_types']="*";
		$this->load->library('upload',$config);
		$this->upload->initialize($config);
		
		for ($i = 0; $i < $this->input->post('JmlUpload'); $i++) {
			$this->upload->do_upload('file_' . $i);
			$uploaded_data = $this->upload->data();
			$path = preg_split("(/)", $uploaded_data['full_path']);

			$data_file['uuid'] = $this->getUUID();
			$data_file['arsip_uuid'] = $data->uuid;			
			$data_file['file_path'] = implode("/", array_slice($path, count($path) - 5));
			$data_file['file_ext'] = $uploaded_data['file_ext'];
			$data_file['file_size'] = $uploaded_data['file_size'];
			$data_file['status'] = 1;
			$data_file['_cid'] = $this->session->userdata("nip");
			$data_file['_ctime'] = date('Y-m-d H:i:s');

			$this->db->insert('ars_trx_arsip_attachment', $data_file);
            $insert_id = $this->db->insert_id();
		}
	}

	function getUUID(){
		$query = "SELECT UUID() as datauuid";
        $v =  $this->db->query($query)->row_array();
        return $v['datauuid'];
	}

	function checkNumber(){
		$this->db->from("ars_trx_arsip");
        $count = $this->db->get()->num_rows();
		$number = "ARS/" . str_pad($count + 1, 5, '0', STR_PAD_LEFT);
        return $number;
	}
}




