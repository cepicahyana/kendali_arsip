<?php

class Model extends CI_Model  {
    
	 
	function __construct()
    {
        parent::__construct();
    }

	// function persentaseCovid($biro,$jml){
	// 	$this->db->where("biro",$biro);
	// 	$total = $this->db->get("data_pegawai")->num_rows();
	// 	$hasil = ($jml/$total)*100;
	// 	return number_format($hasil,0,",",".");
	// }
	// function jml_positif($tgl,$field){

	// 	$this->db->where("tgl",$tgl);
	// 	$db = $this->db->get("rekap_positif")->row();
	// 	return isset($db->$field)?($db->$field):0;
	// }
	// function positif(){
	// 	$this->db->where("hasil_test","+");
	// 	return $this->db->get("data_pegawai")->num_rows();
	// }
	 
	// function negatif(){
	// 	$this->db->where("hasil_test","-");
	// 	return $this->db->get("data_pegawai")->num_rows();
	// }
	// function jml_pegawai(){
	// 	return $this->db->get("data_pegawai")->num_rows();
	// }
	// function isolasi_mandiri(){
	// 	$this->db->where("sts",0);
	// 	$this->db->where("hasil","+");
	// 	$this->db->where("kode_test_utama IS NULL");
	// 	$this->db->where("isolasi","02");
	// 	return $this->db->get("data_test")->num_rows();
	// }
	 
	// function isolasi_rs(){
	// 	$this->db->where("sts",0);
	// 	$this->db->where("hasil","+");
	// 	$this->db->where("kode_test_utama IS NULL");
	// 	$this->db->where("isolasi","01");
	// 	return $this->db->get("data_test")->num_rows();
	// }
	 
	// function sts_positif(){
	// 	$tgl = $this->tanggal->minTgl(1,date("Y-m-d"));
	// 	$tgl_kemarin = $this->tanggal->eng($tgl,"-");

	// 		   $this->db->select("(SUM(p1)+SUM(p2)+SUM(p3)) as jml");
	// 		   $this->db->where("tgl",$tgl_kemarin);
	// 	$db  = $this->db->get("rekap_positif")->row();
	// 	$total_kemarin	=	isset($db->jml)?($db->jml):0;

	// 	$ini	=	$this->positif();
	// 	if($total_kemarin>$ini){
	// 		return "-".($total_kemarin-$ini);
	// 	}elseif($total_kemarin<$ini){
	// 		return "+".($ini-$total_kemarin);
	// 	}else{
	// 		return 0;
	// 	}
	// }

	// function sts_negatif(){
	// 	$tgl = $this->tanggal->minTgl(1,date("Y-m-d"));
	// 	$tgl_kemarin = $this->tanggal->eng($tgl,"-");

	// 		   $this->db->select("(SUM(p1)+SUM(p2)+SUM(p3)) as jml");
	// 		   $this->db->where("tgl",$tgl_kemarin);
	// 	$db  = $this->db->get("rekap_positif")->row();
	// 	$total_kemarin	=	isset($db->jml)?($db->jml):0;
	// 	$jml_pegawai    = 	$this->jml_pegawai();

	// 	$negatif		=	($jml_pegawai-$total_kemarin);


	// 	$ini	=	$this->negatif();
	// 	if($negatif>$ini){
	// 		return "-".($negatif-$ini);
	// 	}elseif($negatif<$ini){
	// 		return "+".($ini-$negatif);
	// 	}else{
	// 		return 0;
	// 	}
	// }

	// function usiaMin(){ // <20
	// 	$tgl = $this->tanggal->minTahun(20);
	// 	$this->db->where("hasil_test","+");
	// 	$this->db->where("tgl_lahir>=",$tgl);
	// 	return $this->db->get("data_pegawai")->num_rows();
	// }
	
	// function usiaMax(){ // <20
	// 	$tgl = $this->tanggal->minTahun(50);
	// 	$this->db->where("hasil_test","+");
	// 	$this->db->where("tgl_lahir<=",$tgl);
	// 	return $this->db->get("data_pegawai")->num_rows();
	// }
	
	// function usia($min,$max){ 
	// 	$tgl1 = $this->tanggal->minTahun($min);
	// 	$tgl2 = $this->tanggal->minTahun($max);
	// 	$this->db->where("hasil_test","+");
	// 	$this->db->where("tgl_lahir>",$tgl2);
	// 	$this->db->where("tgl_lahir<=",$tgl1);
	// 	return $this->db->get("data_pegawai")->num_rows();
	// }
	// function klasifikasiKab(){
	// 	return $this->db->query("SELECT count(*) as jml,id_kab FROM data_pegawai where hasil_test='+' group by id_kab")->result();
	// }
	// function data_activity($limit=10){
	// 	$this->db->limit($limit);
	// 	$this->db->order_by("_ctime","desc");
	// 	$this->db->where("hasil IS NOT NULL");
	// 	return $this->db->get("data_test")->result();
	// }
	// function getPrediksiPenularan(){
	// 	return $this->db->get("tr_penularan")->result();
	// }
	// function getJmlPrediksi($prediksi){
	// 	$this->db->select("count(*) as jml");
	// 	$this->db->like("penularan",$prediksi);
	// 	$db = $this->db->get("data_test")->row();
	// 	return isset($db->jml)?($db->jml):0;
	// }
	// function get_wilayah(){
	// 	$this->db->where("hasil_test","+");
	// 	$this->db->group_by("id_kab");
	// 	$this->db->order_by("jml","desc");
	// 	$this->db->select("count(*) as jml,id_kab");
	// 	return $this->db->get("data_pegawai")->result();
	// }
	// function dataKondisi($limit=10){
	// 	$this->db->limit($limit);
	// 	$this->db->order_by("tgl","desc");
	// 	return $this->db->get("data_kondisi")->result();
	// }
}




