<?php
class Model extends CI_Model
{


	public function __construct() {
        parent::__construct();
    }

    function bagian($nip){
      $this->db->where("nip",$nip);
      $dta=$this->db->get("data_pegawai")->row();
      return isset($dta->bagian)?($dta->bagian):null;
    }
 	function jmlHadir($jenis){
	 	$this->db->where("nip",$this->m_reff->nip());
	 	$this->db->where("year(tgl)",date("Y"));
	 	$this->db->where_in("jenis_absen",$jenis);
		return $this->db->get("data_absen")->num_rows();
 	}
  function getPenilaian($t, $tB){
    $this->db->where("nip", $this->m_reff->nip());
    $this->db->where("tahun <=", $t);
    $this->db->where("tahun >=", $tB);
    $this->db->order_by("tahun", 'desc');
    return $this->db->get("penilaian_kinerja_ppnpn")->result();
  }
  function getPenilaianDetail($id){
    $this->db->where("id", $id);
    return $this->db->get("penilaian_kinerja_ppnpn")->result();
  }
  function getPegawai(){
    return $this->db->get("penilaian_kinerja_ppnpn");
  }
  function datatSekarang($tSekarag){
    $this->db->where("nip", $this->m_reff->nip());
    $this->db->where("tahun", $tSekarag);
    return $this->db->get("penilaian_kinerja_ppnpn")->result();
  }

}
//End of file data_param.php
