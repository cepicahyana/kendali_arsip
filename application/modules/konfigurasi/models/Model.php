<?php

class Model extends CI_Model  {
    
	var $tbl="admin";
 
 	function __construct()
    {
        parent::__construct();
    }
	function idu()
	{
		return $this->session->userdata("id");
	}
	
	 
	function save_($idp,$val)
	{
		$this->db->set("val",$this->m_reff->san($val));
		$this->db->where("id",$idp);
	return $this->db->update("pengaturan");
	}
	
	function hapusTahun()
	{	
		$token	=	$this->m_reff->san($this->input->post("token"));
		$token	=	$this->m_reff->decrypt($token);
		
		$tahun	=	$this->m_reff->san($this->input->post("tahun"));
		$tahun	=	$this->m_reff->decrypt($tahun);
		
		if($token!=date('Hi'))
		{
			$this->session->set_flashdata("msg","Token  error!");
			return false;
		}
		$this->session->set_flashdata("msg","Data tahun ".$tahun." berhasil dihapus!");
		 
		$this->db->where("YEAR(_ctime)",$tahun);
		$this->db->delete("data_peserta");
		
		$this->db->where("YEAR(tgl)",$tahun);
		$this->db->delete("data_acara");
		
		
		$this->db->where("YEAR(_ctime)",$tahun);
		return $this->db->delete("data_file");
		 
	}
	
	function resset(){
		$this->db->query("TRUNCATE TABLE data_absen");
		$this->db->query("TRUNCATE TABLE data_chat");
		$this->db->query("TRUNCATE TABLE data_informasi");
		$this->db->query("TRUNCATE TABLE data_keluarga");
		$this->db->query("TRUNCATE TABLE data_komentar");
		$this->db->query("TRUNCATE TABLE data_komentar_admin");
		$this->db->query("TRUNCATE TABLE data_kondisi");
		$this->db->query("TRUNCATE TABLE data_kondisi_external");
		$this->db->query("TRUNCATE TABLE data_kondisi_keluarga");
		$this->db->query("TRUNCATE TABLE data_kondisi_ppnpn_del");
		$this->db->query("TRUNCATE TABLE data_kordokter");
		// $this->db->query("TRUNCATE TABLE data_pegawai");
		$this->db->query("TRUNCATE TABLE data_pengumuman");
		$this->db->query("TRUNCATE TABLE data_tanya_admin");
		$this->db->query("TRUNCATE TABLE data_tanya_dokter");
		$this->db->query("TRUNCATE TABLE data_test");
		$this->db->query("TRUNCATE TABLE data_test_external");
		$this->db->query("TRUNCATE TABLE data_test_keluarga");
		$this->db->query("TRUNCATE TABLE data_tugas_harian");
		$this->db->query("TRUNCATE TABLE penilaian_kinerja_ppnpn");
		$this->db->query("TRUNCATE TABLE rekap_positif");
		$this->db->query("TRUNCATE TABLE tm_domisili");
		$this->db->query("TRUNCATE TABLE tm_gaji");
		$this->db->query("TRUNCATE TABLE tm_golongan");
		$this->db->query("TRUNCATE TABLE tm_hukuman");
		$this->db->query("TRUNCATE TABLE tm_indikator_penilaian");
		$this->db->query("TRUNCATE TABLE tm_jabatan");
		$this->db->query("TRUNCATE TABLE tm_jadwal_libur");
		$this->db->query("TRUNCATE TABLE tm_keminatan");
		$this->db->query("TRUNCATE TABLE tm_medis");
		$this->db->query("TRUNCATE TABLE tm_pelatihan");
		$this->db->query("TRUNCATE TABLE tm_pendidikan");
		$this->db->query("TRUNCATE TABLE tm_penghargaan");
		$this->db->query("TRUNCATE TABLE tm_penilaian_kinerja");
		$this->db->query("TRUNCATE TABLE tm_penugasan");
		$this->db->query("TRUNCATE TABLE tm_persetujuan");
		$this->db->query("TRUNCATE TABLE tm_predikat");
		$this->db->query("TRUNCATE TABLE tm_pustaka");
		$this->db->query("TRUNCATE TABLE tm_vaksin");
		$data = array(
			"level_indikasi"	=>	null,
			"kode_test"			=>	null,
			"hasil_test"		=>	null,
			"sts_test"			=>	0,
			"tgl_test"			=>	null);
		$this->db->update("data_pegawai",$data);
		return true;
	}
	 
	 
}