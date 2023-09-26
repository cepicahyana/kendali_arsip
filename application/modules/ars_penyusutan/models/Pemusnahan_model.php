<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Pemusnahan_model extends CI_Model
{



    function __construct()
    {
        parent::__construct();
		$this->minio = new S3_library();
    }
    function idu()
    {
        return $this->session->userdata("id");
    }

	function getDetail($id)
	{
		$this->db->select("	atp.*,
							(	SELECT nama FROM ars_tr_organisasi org
								WHERE org.kode = atp.organisasi_kode ) AS organisasi_name,
							(	SELECT owner FROM admin dp
								WHERE dp.nip = atp._cid LIMIT 1) AS inisiator,
							(	CASE WHEN atp.tanggal IS NOT NULL THEN DATE_FORMAT(atp.tanggal, '%d %M %Y') 
								ELSE '' END	) AS tanggal_id,
							(	SELECT COUNT(atpb.id) 
								FROM ars_trx_pemusnahan_berkas atpb
								WHERE 
									atpb.pemusnahan_uuid = atp.uuid AND
									atpb.penilaian_tim = 1 ) AS jumlah_arsip_tim,
							(	SELECT COUNT(atpb.id) 
								FROM ars_trx_pemusnahan_berkas atpb
								WHERE 
									atpb.pemusnahan_uuid = atp.uuid AND
									atpb.penilaian_anri = 1	) AS jumlah_arsip_anri,
							(	SELECT GROUP_CONCAT(CONCAT('<li>', dp.nama, '</li>') SEPARATOR '')
								FROM data_pegawai dp
								JOIN ars_trx_pemusnahan_tim atpt ON atpt.pegawai_id = dp.id
								WHERE
									atpt.pemusnahan_uuid = atp.uuid) AS nama_tim");
		$this->db->where('id', $id);
		$query = $this->db->get("ars_trx_pemusnahan atp");
		return $query->row();	
	}
	 
    /*======= DATATABLE PEMUSNAHAN =========*/
	function getData()
	{
		$this->_getData();
		if($this->m_reff->san($this->input->post("length")!=-1)) 
		$this->db->limit($this->m_reff->san($this->input->post("length")),$this->m_reff->san($this->input->post("start")));
	 	return $this->db->get()->result();
		 
	}

	function _getData()
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

		$this->db->select("	atp.*,
							(	SELECT nama FROM ars_tr_organisasi org
								WHERE org.kode = atp.organisasi_kode ) AS organisasi_name,
							(	SELECT owner FROM admin dp
								WHERE dp.nip = atp._cid LIMIT 1) AS inisiator,
							(	CASE WHEN atp.tanggal IS NOT NULL THEN DATE_FORMAT(atp.tanggal, '%d %M %Y') 
								ELSE '' END	) AS tanggal_id,
							(	SELECT COUNT(atpb.id) 
								FROM ars_trx_pemusnahan_berkas atpb
								WHERE 
									atpb.pemusnahan_uuid = atp.uuid AND
									atpb.penilaian_tim = 1 ) AS jumlah_arsip_tim,
							(	SELECT COUNT(atpb.id) 
								FROM ars_trx_pemusnahan_berkas atpb
								WHERE 
									atpb.pemusnahan_uuid = atp.uuid AND
									atpb.penilaian_anri = 1	) AS jumlah_arsip_anri");
		$this->db->order_by("atp.id DESC");
		$query=$this->db->from("ars_trx_pemusnahan atp");
		return $query;
	}
	
	public function count()
	{				
		$this->_getData();
		return $this->db->get()->num_rows();
	}


	/*======= DATATABLE ARSIP =========*/
	function getDataBerkas()
	{
		$this->_getDataBerkas();
		if($this->m_reff->san($this->input->post("length")!=-1)) 
			$this->db->limit($this->m_reff->san($this->input->post("length")),$this->m_reff->san($this->input->post("start")));
			
			// echo '<pre>'; var_dump($this->input->post())); die;
		if (!empty($this->m_reff->san($this->input->post("proses")))) {
			$this->db->select("atb.*, atpb.uuid as pemusnahan_berkas_uuid, CONCAT(kka.kode, ' - ', kka.nama) as kka_nama");
			$this->db->join('ars_trx_pemusnahan_berkas atpb', 'atpb.berkas_uuid = atb.uuid');
			if ($this->m_reff->san($this->input->post("tipe")) == 'tim_usulmusnah')
				$this->db->where('(penilaian_tim IS NULL OR penilaian_tim = 1)');
			else if ($this->m_reff->san($this->input->post("tipe")) == 'tim_ditangguhkan')
				$this->db->where('(penilaian_tim = 2)');
			else if ($this->m_reff->san($this->input->post("tipe")) == 'anri_usulmusnah')
				$this->db->where('penilaian_tim = 1 AND (penilaian_anri IS NULL OR penilaian_anri = 1)');
			else if ($this->m_reff->san($this->input->post("tipe")) == 'anri_ditangguhkan')
				$this->db->where('penilaian_tim = 1 AND (penilaian_anri = 2)');
			else if ($this->m_reff->san($this->input->post("tipe")) == 'final_usulmusnah')
				$this->db->where('penilaian_anri = 1');
		}
		
	 	return $this->db->get()->result();
		 
	}

	function _getDataBerkas()
	{

		if (strlen(isset($_POST['search']['value']) ? ($_POST['search']['value']) : null) > 1) {
			$searchkey = $_POST['search']['value'];
			$searchkey = $this->m_reff->sanitize($searchkey);
			$query = array(
				"nama" => $searchkey
			);
			$this->db->group_start()
				->or_like($query)
				->group_end();
		}
		// $this->db->select('	atb.*,
		// 					atk.*,
		// 					atj.*,
		// 					atk.nama AS kka_nama,
		// 					atpb.*');
		// $this->db->join('ars_tr_kka atk', 'atk.kode = atb.kka_kode', 'left');
		$this->db->select("atb.*, CONCAT(kka.kode, ' - ', kka.nama) as kka_nama");
		// $this->db->where('a.status', $this->input->post('type'));
		$this->db->join("ars_tr_kka kka", "atb.kka_kode = kka.kode");
		$this->db->join('ars_tr_jra atj', 'atj.id = atb.jra_kode', 'left');
		$query = $this->db->from("ars_trx_berkas atb");
		return $query;
	}

	public function countBerkas()
	{				
		$this->_getDataBerkas();
		return $this->db->get()->num_rows();
	}

	/*======= GET REQUIREMENT =========*/
	public function getPegawai($param = [])
	{
		if (!empty($param)) {
			foreach ($param as $k => $v) {
				$this->db->where($k, $v);
			}
		}

		$query = $this->db->from('data_pegawai');
		return $query->get();
	}

	function getuuid()
	{
		return $this->db->query('SELECT UUID() AS getuuid')->row_array()['getuuid'];
	}

	function getnumber()
	{
		$lastnumber = $this->db->query('SELECT COUNT(id) AS jml FROM ars_trx_pemusnahan WHERE YEAR(_ctime) = YEAR(CURDATE())')->row_array()['jml'];
		return "SETPRES/PMSN/2023/" . str_pad($lastnumber+1, 4, "0", STR_PAD_LEFT);
	}

	function upload_file($param)
	{
		$uuidFile 		= $this->getuuid();
		$ext 			= pathinfo($param['file']['name'], PATHINFO_EXTENSION);
		$imgname 		=  $param['filename'] . '_' . $uuidFile . '.' . $ext;
		$filepathdest 	= date('Y') . '/' . date('m') . '/Pemusnahan/' . $param["uuid"] . '/';
		$targetFile 	= $filepathdest . $imgname;
		$result = $this->minio->uploadFilesObject($param['file']['tmp_name'], $targetFile, $filepathdest, 10);

		return ['targetFile' => $targetFile, 'result' => $result];
	}

	/*======= update pemusnahan =========*/
	function update_form_pemusnahan()
	{
		// insert pemusnahan
		$uuid 	= $this->getuuid();
		$this->db->set("uuid", $uuid);
		$this->db->set("nomor", $this->getnumber());
		$this->db->set("status", 1);
		$this->db->set("organisasi_kode", '010102'); // Organisasi
		$this->db->set("tipe", 1); // UK
		$this->db->set("tanggal", $this->input->post("tanggal"));

		if (!empty($_FILES["attach_sk_tim"]["name"])) {
			$upload = $this->upload_file(["file" => $_FILES["attach_sk_tim"], "filename" => "attach_sk_tim", "uuid" => $uuid]);
			
			$this->db->set("attach_sk_tim", $upload['targetFile']);
		}

		$this->db->set("_cid",$this->session->userdata("nip"));
		$this->db->set("_ctime",date('Y-m-d H:i:s'));
		$res = $this->db->insert("ars_trx_pemusnahan");
		$this->m_reff->log("menambahkan data pemusnahan");

		// insert pemusnahan tim
		if (!empty($this->input->post("tim"))) {
			foreach ($this->input->post("tim") as $i => $pegawai_id) {
				$this->db->set("uuid", $this->getuuid());
				$this->db->set("pemusnahan_uuid", $uuid);
				$this->db->set("pegawai_id", $pegawai_id);
				$this->db->set("status", 1);
				$this->db->set("keterangan", "");
				
				$this->db->set("_cid",$this->session->userdata("nip"));
				$this->db->set("_ctime",date('Y-m-d H:i:s'));
				$res = $this->db->insert("ars_trx_pemusnahan_tim");
			}
		}

		// insert pemusnahan berkas
		$berkasJra = $this->_getDataBerkas()->get()->result();
		if (!empty($berkasJra)) {
			foreach ($berkasJra as $i => $bj) {
				$this->db->set("uuid", $this->getuuid());
				$this->db->set("pemusnahan_uuid", $uuid);
				$this->db->set("berkas_uuid", $bj->uuid);
				$this->db->set("status", 1);
				
				$this->db->set("_cid",$this->session->userdata("nip"));
				$this->db->set("_ctime",date('Y-m-d H:i:s'));
				$res = $this->db->insert("ars_trx_pemusnahan_berkas");
			}
		}

		// export excel usul musnah
		$exportExcel = $this->exportToExcel(['uuid' => $uuid, 'tipe' => 'usul_musnah_awal']);
		$this->db->set("attach_usulmusnah_awal", $exportExcel['targetFile']);
		$this->db->where("uuid", $uuid);
		$res = $this->db->update("ars_trx_pemusnahan");

        return true;
    }

	/*======= update penilaian tim =========*/
	function update_form_penilaian_tim()
	{
		$id 	= $this->input->post("id");
		$detail = $this->getDetail($id);

		// update pemusnahan penilaian tim
		$berkasJra = $this->getDataBerkasPenilaian(['uuid' => $detail->uuid, 'tipe' => 'tim_usulmusnah']);
		if (!empty($berkasJra)) {
			foreach ($berkasJra as $i => $bj) {
				$this->penilaian(['tipe' => 'tim_ditangguhkan', 'uuid' => $bj->pemusnahan_berkas_uuid]);
			}
		}

		// export excel usul musnah
		$exportExcel = $this->exportToExcel(['uuid' => $detail->uuid, 'tipe' => 'tim_usulmusnah']);
		$this->db->set("attach_usulmusnah_tim", $exportExcel['targetFile']);

		// update pemusnahan
		if (!empty($_FILES["attach_sk_penilaian_tim"]["name"])) {
			$upload = $this->upload_file(["file" => $_FILES["attach_sk_penilaian_tim"], "filename" => "attach_sk_penilaian_tim", "uuid" => $detail->uuid]);
			
			$this->db->set("attach_sk_penilaian_tim", $upload['targetFile']);
		}
		$this->db->set("status", 2); // lanjut ke penilaian anri
		$this->db->set("_uid", $this->session->userdata("nip"));
		$this->db->set("_utime", date('Y-m-d H:i:s'));
		$this->db->where("id", $detail->id);
		$res = $this->db->update("ars_trx_pemusnahan");
		$this->m_reff->log("mengubah data pemusnahan");

		return true;
	}
	
	/*======= update penilaian anri =========*/
	function update_form_penilaian_anri()
	{
		$id 	= $this->input->post("id");
		$detail = $this->getDetail($id);

		// update pemusnahan penilaian anri
		$berkasJra = $this->getDataBerkasPenilaian(['uuid' => $detail->uuid, 'tipe' => 'anri_usulmusnah']);
		if (!empty($berkasJra)) {
			foreach ($berkasJra as $i => $bj) {
				$this->penilaian(['tipe' => 'anri_ditangguhkan', 'uuid' => $bj->pemusnahan_berkas_uuid]);
			}
		}

		// export excel usul musnah
		$exportExcel = $this->exportToExcel(['uuid' => $detail->uuid, 'tipe' => 'anri_usulmusnah']);
		$this->db->set("attach_usulmusnah_final", $exportExcel['targetFile']);

		// update pemusnahan
		if (!empty($_FILES["attach_sk_penilaian_anri"]["name"])) {
			$upload = $this->upload_file(["file" => $_FILES["attach_sk_penilaian_anri"], "filename" => "attach_sk_penilaian_anri", "uuid" => $detail->uuid]);
			
			$this->db->set("attach_sk_penilaian_anri", $upload['targetFile']);
		}
		$this->db->set("status", 3); // lanjut ke penilaian kasetpres
		$this->db->set("_uid", $this->session->userdata("nip"));
		$this->db->set("_utime", date('Y-m-d H:i:s'));
        $this->db->where("id", $detail->id);
		$res = $this->db->update("ars_trx_pemusnahan");
		$this->m_reff->log("mengubah data pemusnahan");

		return true;
	}

	/*======= update approval kasetpres =========*/
	function update_form_approval_kasetpres()
	{
		// echo '<pre>'; var_dump($this->input->post());
		$id 	= $this->input->post("id");
		$detail = $this->getDetail($id);

		// update pemusnahan
		if (!empty($_FILES["attach_sk_penilaian_kasetpres"]["name"])) {
			$upload = $this->upload_file(["file" => $_FILES["attach_sk_penilaian_kasetpres"], "filename" => "attach_sk_penilaian_kasetpres", "uuid" => $detail->uuid]);
			
			$this->db->set("attach_sk_penilaian_kasetpres", $upload['targetFile']);
		}

		if ($this->input->post('StatusApproval') == 1) {
			$this->db->set("status", 4); // lanjut ke proses pemusnahan
		} else {
			$this->db->set("status", 0); // pemusnahan ditolak
			$this->db->set("alasan", $this->input->post('Alasan')); // alasan ditolak
		}

		$this->db->set("approval_status", $this->input->post('StatusApproval'));
		$this->db->set("_uid", $this->session->userdata("nip"));
		$this->db->set("_utime", date('Y-m-d H:i:s'));
		$this->db->where("id", $detail->id);
		$res = $this->db->update("ars_trx_pemusnahan");
		$this->m_reff->log("mengubah data pemusnahan");

		return true;
	}

	/*======= update proses pemusnahan softcopy =========*/
	function update_form_proses_pemusnahan_softcopy()
	{
		$id 	= $this->input->post("id");
		$detail = $this->getDetail($id);

		// update pemusnahan penilaian anri
		$arsipAttachment = $this->countBerkasByType(['uuid' => $detail->uuid, 'type' => 'softcopy', 'all_data' => true]);

		if (!empty($arsipAttachment)) {
			foreach ($arsipAttachment as $i => $bj) {
				$this->db->set("status", 0);
				$this->db->set("_uid", $this->session->userdata("nip"));
				$this->db->set("_utime", date('Y-m-d H:i:s'));
				$this->db->where("id", $bj->id);
				$res = $this->db->update("ars_trx_arsip_attachment");
			}
		}

		return $this->countBerkasByType(['uuid' => $detail->uuid, 'type' => 'softcopy']);
	}

	/*======= update proses pemusnahan softcopy =========*/
	function update_form_proses_pemusnahan()
	{
		$id 	= $this->input->post("id");
		$detail = $this->getDetail($id);

		$this->db->set("status", 5); // lanjut ke upload BA
		$this->db->set("_uid", $this->session->userdata("nip"));
		$this->db->set("_utime", date('Y-m-d H:i:s'));
		$this->db->where("id", $detail->id);
		$res = $this->db->update("ars_trx_pemusnahan");
		$this->m_reff->log("mengubah data pemusnahan");

		// update pemusnahan penilaian anri
		$item = $this->countBerkasByType(['uuid' => $detail->uuid, 'type' => 'hardcopy', 'all_data' => true]);

		if (!empty($item)) {
			foreach ($item as $i => $bj) {
				$this->db->set("status", 0);
				$this->db->set("_uid", $this->session->userdata("nip"));
				$this->db->set("_utime", date('Y-m-d H:i:s'));
				$this->db->where("id", $bj->arsip_id);
				$res = $this->db->update("ars_trx_arsip");

				$this->db->set("status", 0);
				$this->db->set("_uid", $this->session->userdata("nip"));
				$this->db->set("_utime", date('Y-m-d H:i:s'));
				$this->db->where("id", $bj->berkas_id);
				$res = $this->db->update("ars_trx_berkas");

				$this->db->set("status", 1);
				$this->db->set("_uid", $this->session->userdata("nip"));
				$this->db->set("_utime", date('Y-m-d H:i:s'));
				$this->db->where("id", $bj->pemusnahan_berkas_id);
				$res = $this->db->update("ars_trx_pemindahan_berkas");
			}
		}

		return true;
	}

	/*======= update approval kasetpres =========*/
	function update_form_ba()
	{
		$id 	= $this->input->post("id");
		$detail = $this->getDetail($id);

		// update pemusnahan
		if (!empty($_FILES["attach_ba"]["name"])) {
			$upload = $this->upload_file(["file" => $_FILES["attach_ba"], "filename" => "attach_ba", "uuid" => $detail->uuid]);
			
			$this->db->set("attach_ba", $upload['targetFile']);
		}

		$this->db->set("status", 6); // selesai
		$this->db->set("_uid", $this->session->userdata("nip"));
		$this->db->set("_utime", date('Y-m-d H:i:s'));
		$this->db->where("id", $detail->id);
		$res = $this->db->update("ars_trx_pemusnahan");
		$this->m_reff->log("mengubah data pemusnahan");

		return true;
	}

	public function countBerkasByType($param)
	{
		// var_dump($param['type']);die;
		$this->_getDataBerkas();
		$this->db->join('ars_trx_pemusnahan_berkas atpb', 'atpb.berkas_uuid = atb.uuid');
		$this->db->where('pemusnahan_uuid', $param['uuid']);
		if ($param['type'] == 'softcopy') {
			$this->db->join('ars_trx_arsip ata', 'ata.berkas_uuid = atb.uuid');
			$this->db->join('ars_trx_arsip_attachment ataa', 'ataa.arsip_uuid = ata.uuid');
			$this->db->where('ataa.status', 1);
			if (isset($param['all_data'])) {
				$this->db->select('ataa.id');
				return $this->db->get()->result();
			} else {
				return $this->db->get()->num_rows();
			}
		} else if ($param['type'] == 'hardcopy') {
			$this->db->join('ars_trx_arsip ata', 'ata.berkas_uuid = atb.uuid');
			if (isset($param['all_data'])) {
				$this->db->select('ata.id as arsip_id, atb.id as berkas_id, atpb.id as pemusnahan_berkas_id');
				return $this->db->get()->result();
			} else {
				return $this->db->get()->num_rows();
			}
		}
	}

	function getDataBerkasPenilaian($param)
	{
		$this->_getDataBerkas();
		$this->db->select("	atb.*,
							atpb.uuid as pemusnahan_berkas_uuid,
							CONCAT(kka.kode, ' - ', kka.nama) as kka_nama,
							atj.nama as jra_nama");
		$this->db->join('ars_trx_pemusnahan_berkas atpb', 'atpb.berkas_uuid = atb.uuid');
		$this->db->where('pemusnahan_uuid', $param['uuid']);
		if ($param['tipe'] == 'tim_usulmusnah')
			$this->db->where('(penilaian_tim = 1 OR penilaian_tim IS NULL)');
		else if ($param['tipe'] == 'tim_ditangguhkan')
			$this->db->where('(penilaian_tim = 2)');
		else if ($param['tipe'] == 'anri_usulmusnah')
			$this->db->where('penilaian_tim = 1 AND (penilaian_anri = 1 OR penilaian_anri IS NULL)');
		else if ($param['tipe'] == 'anri_ditangguhkan')
			$this->db->where('penilaian_tim = 1 AND (penilaian_anri = 2)');
		
	 	return $this->db->get()->result();
	}

	function penilaian($param=[])
	{
		// echo '<pre>'; var_dump($this->input->post()); die;
		$tipe = !empty($this->input->post("tipe")) ? $this->input->post("tipe") : $param['tipe'];
		if ($tipe == "tim_usulmusnah")
			$this->db->set("penilaian_tim", 2);
		else if ($tipe == "tim_ditangguhkan")
			$this->db->set("penilaian_tim", 1);
		else if ($tipe == "anri_usulmusnah")
			$this->db->set("penilaian_anri", 2);
		else if ($tipe == "anri_ditangguhkan")
			$this->db->set("penilaian_anri", 1);

        $uuid = !empty($param['uuid']) ? $param['uuid'] : $this->input->post("uuid");
        $this->db->where("uuid",$uuid);
        return $this->db->update("ars_trx_pemusnahan_berkas");
    }
	
	function hapus_pemusnahan(){
        $id = $this->input->post("id");
        $this->db->where("id",$id);
        return $this->db->delete("ars_trx_pemusnahan");
    }


	// export
	function exportToExcel($param){
		$berkas = $this->getDataBerkasPenilaian(['uuid' => $param['uuid'], 'tipe' => $param['tipe']]);
		// echo '<br>'; var_dump($berkas); die;
		$this->excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

        $style_col_table = array(
            'font' => array('bold' => true, 'color' => array('rgb' => 'FFFFFF')), // Set font nya jadi bold
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );

        $style_row_table = array(
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (LEFT)
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );
		$this->excel->setActiveSheetIndex(0)->setCellValue('A1', "Berkas " . $param['tipe']);
		$this->excel->setActiveSheetIndex(0)->setCellValue('A3', "No");
		$this->excel->setActiveSheetIndex(0)->setCellValue('B3', "Klasifikasi");
		$this->excel->setActiveSheetIndex(0)->setCellValue('C3', "Uraian Informasi");
		$this->excel->setActiveSheetIndex(0)->setCellValue('D3', "Kurun Waktu");
		$this->excel->setActiveSheetIndex(0)->setCellValue('E3', "JRA");

		$column = range('A','E') ;

		foreach($column as $columnID) {
			$this->excel->getActiveSheet()->getColumnDimension($columnID)
				->setWidth(20);
			$this->excel->getActiveSheet()->getStyle($columnID . '3:' . $columnID . '3')
				->applyFromArray($style_col_table)->applyFromArray($style_row_table);
		}

        $title = 'A1:E1';
        $th = 'A3:E3';
        $this->excel->getActiveSheet()->mergeCells($title);
        $this->excel->getActiveSheet()->getStyle($th)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('8DB4E2');

        $this->excel->getActiveSheet()->getStyle('A1:A1')->applyFromArray(array(
            'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
        ));

		$numrow = 4;
		if (count($berkas) > 0) {
			foreach ($berkas as $key => $val) {
				$this->excel->setActiveSheetIndex(0)
					->setCellValue('A' . $numrow, $key + 1)
					->setCellValue('B' . $numrow, $val->kka_nama ? $val->kka_nama : '-')
					->setCellValue('C' . $numrow, $val->uraian_informasi ? $val->uraian_informasi : '-')
					->setCellValue('D' . $numrow, $val->kurun_waktu ? $val->kurun_waktu : '-')
					->setCellValue('E' . $numrow, $val->jra_nama ? $val->jra_nama : '-');


				foreach (range('A', $column[array_key_last($column)]) as $columnID) {
					$this->excel->getActiveSheet()->getStyle($columnID . $numrow)->applyFromArray($style_row_table);
					$this->excel->getActiveSheet()->getStyle($column[array_key_last($column)] . $numrow)->getAlignment()->setWrapText(true);
				}
				$numrow++;
			}
		} else {
			$this->excel->setActiveSheetIndex(0)->setCellValue('A'. $numrow, "Data Tidak Ditemukan");
			$this->excel->getActiveSheet()->mergeCells('A' . $numrow . ':' . $column[array_key_last($column)] . $numrow);
			$this->excel->getActiveSheet()->getStyle('A' . $numrow . ':' . $column[array_key_last($column)] . $numrow)->applyFromArray($style_row_table);
		}

		foreach (range('A', $column[array_key_last($column)]) as $columnID) {
			$this->excel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
		}
		
		$writer = new Xlsx($this->excel);
		$uuidFile = $this->getuuid();
        $filename = "daftar-berkas-{$param['tipe']}_{$uuidFile}.xlsx";
		$tempFile = tempnam(sys_get_temp_dir(), $filename);
        $writer->save($tempFile);

		$imgname 		=  $filename;
		$filepathdest 	= date('Y') . '/' . date('m') . '/Pemusnahan/' . $param["uuid"] . '/';
		$targetFile 	= $filepathdest . $imgname;
		$result = $this->minio->uploadFilesObject($tempFile, $targetFile, $filepathdest, 10);

		return ['targetFile' => $targetFile, 'result' => $result];
	}
}