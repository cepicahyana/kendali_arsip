<?php

class Model extends CI_Model  {
    
	 
	function __construct()
    {
        parent::__construct();
    }


	function persentaseCovid($biro,$jml){
		$this->db->where("biro",$biro);
		$total = $this->db->get("data_pegawai")->num_rows();
		$hasil = ($jml/$total)*100;
		return number_format($hasil,0,",",".");
	}
	function totalTest($jenis_pegawai=null){ 


	// 	if($this->session->level=="pic_covid"){

	//     if($this->session->userdata("kode_biro")){
	// 		$this->db->where("kode_biro",$this->session->userdata("kode_biro"));
	//     }else{
	// 		$this->db->where("kode_istana",$this->session->userdata("kode_istana"));
	//     }
	// }
	$kode_biro = $this->session->userdata("kode_biro");
	$kode_istana = $this->session->userdata("kode_istana");

	if($kode_biro){
		$this->db->where("kode_biro",$kode_biro);
	}
	
	if($kode_istana){
		$this->db->where("kode_istana",$kode_istana);
	}


	    if($jenis_pegawai){
			$this->db->where("jenis_pegawai",$jenis_pegawai);
		}
	  return $this->db->get("v_test")->num_rows();
	}
	function jmlPegawai($jenis){ 
	// 	if($this->session->level=="pic_covid"){

	//     if($this->session->userdata("kode_biro")){
	// 		$this->db->where("kode_biro",$this->session->userdata("kode_biro"));
	//     }else{
	// 		$this->db->where("kode_istana",$this->session->userdata("kode_istana"));
	//     }
	// }
	$kode_biro = $this->session->userdata("kode_biro");
	$kode_istana = $this->session->userdata("kode_istana");
	if($kode_biro){
		$this->db->where("kode_biro",$kode_biro);
	}
	
	if($kode_istana){
		$this->db->where("kode_istana",$kode_istana);
	}


		$this->db->where("jenis_pegawai",$jenis);
		$this->db->where("hasil_test","+");
		$this->db->where("kode_test IS NOT NULL");
	  return $this->db->get("data_pegawai")->num_rows();
	}
	function jmlExternal(){ 
	// 	if($this->session->level=="pic_covid"){

	//     if($this->session->userdata("kode_biro")){
	// 		$this->db->where("kode_biro",$this->session->userdata("kode_biro"));
	//     }else{
	// 		$this->db->where("kode_istana",$this->session->userdata("kode_istana"));
	//     } 
	// }
	$kode_biro = $this->session->userdata("kode_biro");
	$kode_istana = $this->session->userdata("kode_istana");
	if($kode_biro){
		$this->db->where("kode_biro",$kode_biro);
	}
	
	if($kode_istana){
		$this->db->where("kode_istana",$kode_istana);
	}

	$this->db->where("scan","1");
		$this->db->where("hasil IS NOT NULL");
	  return $this->db->get("data_test_external")->num_rows();
	}
	 
	function count_periode($tgl){ 
		$tgl1 = $this->tanggal->range_1($tgl, 0);
		$tgl2 = $this->tanggal->range_2($tgl, 1);
		$this->db->where("scan","1");
		$this->db->where("konfirm_rs>=",$tgl1);
		$this->db->where("konfirm_rs<=",$tgl2);
		if($this->session->level=="pic_covid"){
			if($this->session->level=="pic_covid"){

	    if($this->session->userdata("kode_biro")){
			$this->db->where("kode_biro",$this->session->userdata("kode_biro"));
	    }else{
			$this->db->where("kode_istana",$this->session->userdata("kode_istana"));
	    }
	}
	}
	  return $this->db->get("v_test")->num_rows();
	}
	function jmlPerhari($tgl){ 

	// if($this->session->level=="pic_covid"){


	//     if($this->session->userdata("kode_biro")){
	// 		$this->db->where("kode_biro",$this->session->userdata("kode_biro"));
	//     }else{
	// 		$this->db->where("kode_istana",$this->session->userdata("kode_istana"));
	//     }
	// }  
	$kode_biro = $this->session->userdata("kode_biro");
		$kode_istana = $this->session->userdata("kode_istana");
	if($kode_biro){
		$this->db->where("kode_biro",$kode_biro);
	}
	
	if($kode_istana){
		$this->db->where("kode_istana",$kode_istana);
	}
	   
		$this->db->where("konfirm_rs",$tgl);
		$this->db->where("scan","1");
	  return $this->db->get("v_test")->num_rows();
	}
	function jmlPerbulan($tgl){ 
	// 	if($this->session->level=="pic_covid"){

	//     if($this->session->userdata("kode_biro")){
	// 		$this->db->where("kode_biro",$this->session->userdata("kode_biro"));
	//     }else{
	// 		$this->db->where("kode_istana",$this->session->userdata("kode_istana"));
	//     }
	// }
	$kode_biro = $this->session->userdata("kode_biro");
	$kode_istana = $this->session->userdata("kode_istana");

	if($kode_biro){
		$this->db->where("kode_biro",$kode_biro);
	}
	
	if($kode_istana){
		$this->db->where("kode_istana",$kode_istana);
	}
	   
	   
		$this->db->where("substr(konfirm_rs,1,7)",substr($tgl,0,7));
	  return $this->db->get("v_test")->num_rows();
	}
	function jml_positif($tgl,$field){
		$kode_biro = $this->session->userdata("kode_biro");
		$kode_istana = $this->session->userdata("kode_istana");
	// if($this->session->level=="pic_covid"){

		if($kode_biro){
			$this->db->where("kode_biro",$kode_biro);
		}
		
		if($kode_istana){
			$this->db->where("kode_istana",$kode_istana);
		}
	// }

		$this->db->where("jenis_pegawai",$field);
		$this->db->where("konfirm_rs",$tgl);
		$this->db->where("hasil","+");
		return $this->db->get("v_test")->num_rows();
	 
	}
	function getJmlPositifBiro($kodebiro){
		$this->db->where("tgl_test!=",null);
		$this->db->where("hasil_test","+");
		$this->db->where("kode_biro",$kodebiro);
		return $this->db->get("data_pegawai")->num_rows();
	}
	function getJmlPositifIstana($kode_istana){
		$this->db->where("tgl_test!=",null);
		$this->db->where("hasil_test","+");
		$this->db->where("kode_istana",$kode_istana);
		return $this->db->get("data_pegawai")->num_rows();
	}
	function getIstana(){
		// $this->db->where("nama not like '%jakarta%'");
		return $this->db->get("tr_istana")->result();
	}

	function positif(){
		$kode_biro = $this->session->userdata("kode_biro");
		$kode_istana = $this->session->userdata("kode_istana");
	// 	if($this->session->level=="pic_covid"){

	// 	if($kode_biro){
	// 		$this->db->where("kode_biro",$kode_biro);
	// 	}else{
	// 		$this->db->where("kode_istana",$kode_istana);
	// 	}

	// }

	if($kode_biro){
		$this->db->where("kode_biro",$kode_biro);
	}
	
	if($kode_istana){
		$this->db->where("kode_istana",$kode_istana);
	}

		$this->db->where("hasil_test","+");
		$this->db->where("kode_test IS NOT NULL");
		return $this->db->get("data_pegawai")->num_rows();
	}

	function getBiro(){
		return $this->db->get("tr_biro")->result();
	}
	 
	function negatif(){
		$kode_biro = $this->session->userdata("kode_biro");
		$kode_istana = $this->session->userdata("kode_istana");
		// if($this->session->level=="pic_covid"){
		// 	if($kode_biro){
		// 		$this->db->where("kode_biro",$kode_biro);
		// 	}else{
		// 		$this->db->where("kode_istana",$kode_istana);
		// 	}
		// }

		if($kode_biro){
			$this->db->where("kode_biro",$kode_biro);
		}
		
		if($kode_istana){
			$this->db->where("kode_istana",$kode_istana);
		}
		$this->db->where("hasil_test","-");
		$this->db->where("kode_test IS NULL");
		return $this->db->get("data_pegawai")->num_rows();
	}
	function jml_pegawai(){
		$kode_biro = $this->session->userdata("kode_biro");
		$kode_istana = $this->session->userdata("kode_istana");

		if($kode_biro){
			$this->db->where("kode_biro",$kode_biro);
		}
		
		if($kode_istana){
			$this->db->where("kode_istana",$kode_istana);
		}


		// if($this->session->level=="pic_covid"){

		// if($kode_biro){
		// 	$this->db->where("kode_biro",$kode_biro);
		// }else{
		// 	$this->db->where("kode_istana",$kode_istana);
		// }
		// 	}
		return $this->db->get("data_pegawai")->num_rows();
	}
	function isolasi_mandiri(){
		$kode_biro = $this->session->userdata("kode_biro");
		$kode_istana = $this->session->userdata("kode_istana");
	// 	if($this->session->level=="pic_covid"){

	// 	if($kode_biro){
	// 		$this->db->where("kode_biro",$kode_biro);
	// 	}else{
	// 		$this->db->where("kode_istana",$kode_istana);
	// 	}
	// }

	if($kode_biro){
		$this->db->where("kode_biro",$kode_biro);
	}
	
	if($kode_istana){
		$this->db->where("kode_istana",$kode_istana);
	}


		$this->db->where("sts",0);
		$this->db->where("hasil","+");
		$this->db->where("kode_test_utama IS NULL");
		$this->db->where("isolasi","02");
		return $this->db->get("data_test")->num_rows();
	}
	 
	function isolasi_rs(){
		$kode_biro = $this->session->userdata("kode_biro");
		$kode_istana = $this->session->userdata("kode_istana");
	// 	if($this->session->level=="pic_covid"){

	// 	if($kode_biro){
	// 		$this->db->where("kode_biro",$kode_biro);
	// 	}else{
	// 		$this->db->where("kode_istana",$kode_istana);
	// 	}
	// }

	if($kode_biro){
		$this->db->where("kode_biro",$kode_biro);
	}
	
	if($kode_istana){
		$this->db->where("kode_istana",$kode_istana);
	}


		$this->db->where("sts",0);
		$this->db->where("hasil","+");
		$this->db->where("kode_test_utama IS NULL");
		$this->db->where("isolasi","01");
		return $this->db->get("data_test")->num_rows();
	}
	 
	function sts_positif(){
		$tgl = $this->tanggal->minTgl(1,date("Y-m-d"));
		$tgl_kemarin = $this->tanggal->eng($tgl,"-");

			   $this->db->select("(SUM(p1)+SUM(p2)+SUM(p3)) as jml");
			   $this->db->where("tgl",$tgl_kemarin);
		$db  = $this->db->get("rekap_positif")->row();
		$total_kemarin	=	isset($db->jml)?($db->jml):0;

		$ini	=	$this->positif();
		if($total_kemarin>$ini){
			return "-".($total_kemarin-$ini);
		}elseif($total_kemarin<$ini){
			return "+".($ini-$total_kemarin);
		}else{
			return 0;
		}
	}

	function sts_negatif(){
		$tgl = $this->tanggal->minTgl(1,date("Y-m-d"));
		$tgl_kemarin = $this->tanggal->eng($tgl,"-");

			   $this->db->select("(SUM(p1)+SUM(p2)+SUM(p3)) as jml");
			   $this->db->where("tgl",$tgl_kemarin);
		$db  = $this->db->get("rekap_positif")->row();
		$total_kemarin	=	isset($db->jml)?($db->jml):0;
		$jml_pegawai    = 	$this->jml_pegawai();

		$negatif		=	($jml_pegawai-$total_kemarin);


		$ini	=	$this->negatif();
		if($negatif>$ini){
			return "-".($negatif-$ini);
		}elseif($negatif<$ini){
			return "+".($ini-$negatif);
		}else{
			return 0;
		}
	}

	function usiaMin(){ // <20
		$tgl = $this->tanggal->minTahun(20);
		$kode_biro = $this->session->userdata("kode_biro");
		$kode_istana = $this->session->userdata("kode_istana");
		// if($this->session->level=="pic_covid"){

		// if($kode_biro){
		// 	$this->db->where("kode_biro",$kode_biro);
		// }else{
		// 	$this->db->where("kode_istana",$kode_istana);
		// }
		// 	}


		if($kode_biro){
			$this->db->where("kode_biro",$kode_biro);
		}
		
		if($kode_istana){
			$this->db->where("kode_istana",$kode_istana);
		}


		$this->db->where("hasil_test","+");
		$this->db->where("tgl_lahir>=",$tgl);
		return $this->db->get("data_pegawai")->num_rows();
	}
	
	function usiaMax(){ // <20
		$tgl = $this->tanggal->minTahun(50);
		$kode_biro = $this->session->userdata("kode_biro");
		$kode_istana = $this->session->userdata("kode_istana");
	// 	if($this->session->level=="pic_covid"){

	// 	if($kode_biro){
	// 		$this->db->where("kode_biro",$kode_biro);
	// 	}else{
	// 		$this->db->where("kode_istana",$kode_istana);
	// 	}
	// }

	if($kode_biro){
		$this->db->where("kode_biro",$kode_biro);
	}
	
	if($kode_istana){
		$this->db->where("kode_istana",$kode_istana);
	}
		$this->db->where("hasil_test","+");
		$this->db->where("tgl_lahir<=",$tgl);
		return $this->db->get("data_pegawai")->num_rows();
	}
	
	function usia($min,$max){ 
		$tgl1 = $this->tanggal->minTahun($min);
		$tgl2 = $this->tanggal->minTahun($max);
		$kode_biro = $this->session->userdata("kode_biro");
		$kode_istana = $this->session->userdata("kode_istana");
	// 	if($this->session->level=="pic_covid"){

	// 	if($kode_biro){
	// 		$this->db->where("kode_biro",$kode_biro);
	// 	}else{
	// 		$this->db->where("kode_istana",$kode_istana);
	// 	}
	// }

	if($kode_biro){
		$this->db->where("kode_biro",$kode_biro);
	}
	
	if($kode_istana){
		$this->db->where("kode_istana",$kode_istana);
	}

		$this->db->where("hasil_test","+");
		$this->db->where("tgl_lahir>",$tgl2);
		$this->db->where("tgl_lahir<=",$tgl1);
		return $this->db->get("data_pegawai")->num_rows();
	}
	function klasifikasiKab(){
		return $this->db->query("SELECT count(*) as jml,id_kab FROM data_pegawai where hasil_test='+' group by id_kab")->result();
	}
	function data_activity($limit=10){
		$this->db->limit($limit);
		$this->db->order_by("_ctime","desc");
		$this->db->where("hasil IS NOT NULL");
		return $this->db->get("data_test")->result();
	}
	function getPrediksiPenularan(){
		return $this->db->get("tr_penularan")->result();
	}
	function getJmlPrediksi($prediksi){

		$kode_biro = $this->session->userdata("kode_biro");
		$kode_istana = $this->session->userdata("kode_istana");
	// 	if($this->session->level=="pic_covid"){

	// 	if($kode_biro){
	// 		$this->db->where("kode_biro",$kode_biro);
	// 	}else{
	// 		$this->db->where("kode_istana",$kode_istana);
	// 	}
	// }

	if($kode_biro){
		$this->db->where("kode_biro",$kode_biro);
	}
	
	if($kode_istana){
		$this->db->where("kode_istana",$kode_istana);
	}


		$this->db->select("count(*) as jml");
		$this->db->like("penularan",$prediksi);
		$db = $this->db->get("data_test")->row();
		return isset($db->jml)?($db->jml):0;
	}
	function get_wilayah(){
		$kode_biro = $this->session->userdata("kode_biro");
		$kode_istana = $this->session->userdata("kode_istana");
	// 	if($this->session->level=="pic_covid"){

	// 	if($kode_biro){
	// 		$this->db->where("kode_biro",$kode_biro);
	// 	}else{
	// 		$this->db->where("kode_istana",$kode_istana);
	// 	}
	// }

	if($kode_biro){
		$this->db->where("kode_biro",$kode_biro);
	}
	
	if($kode_istana){
		$this->db->where("kode_istana",$kode_istana);
	}

		$this->db->where("hasil_test","+");
		$this->db->where("kode_test IS NOT NULL");
		$this->db->group_by("id_kab");
		$this->db->order_by("jml","desc");
		$this->db->select("count(*) as jml,id_kab");
		return $this->db->get("data_pegawai")->result();
	}
	function dataKondisi($limit=10){
		$this->db->limit($limit);
		$this->db->order_by("tgl","desc");
		return $this->db->get("data_kondisi")->result();
	}



	function getDataRekap()
	{
		 $this->_getDataRekap();
		if($this->input->post("length")!=-1) 
		$this->db->limit($this->input->post("length"),$this->input->post("start"));
	 	return $this->db->get()->result();
		 
	}
	function _getDataRekap()
	{
		 	$j			   = strlen(isset($_POST['search']['value'])?($_POST['search']['value']):0);
			if($j>1){
				$searchkey = $_POST['search']['value']; 
				$searchkey = $this->m_reff->sanitize($searchkey);

				$query=array(
				"nama"=>$this->m_reff->sanitize($searchkey)
				);
				$this->db->group_start()
                        ->or_like($query)
                ->group_end();
			}	

 			$kode_tempat = $this->m_reff->san($this->input->post("kode_tempat"));
			if($kode_tempat){
				$this->db->where("kode_tempat",$kode_tempat);
			}

 			$kode_jenis = $this->m_reff->san($this->input->post("kode_jenis"));
			if($kode_jenis){
				$this->db->where("kode_jenis",$kode_jenis);
			}
 			$kode_istana = $this->m_reff->san($this->input->post("kode_istana"));
			if($kode_istana){
				$this->db->where("kode_istana",$kode_istana);
			}
 			$kode_biro = $this->m_reff->san($this->input->post("kode_biro"));
			if($kode_biro){
				$this->db->where("kode_biro",$kode_biro);
			}

			$tgl  = $this->input->post("range");
			 
				$tgl1 = $this->tanggal->range_1($tgl, 0);
				$tgl2 = $this->tanggal->range_2($tgl, 1);
				
				$this->db->where("konfirm_rs>=",$tgl1);
				$this->db->where("konfirm_rs<=",$tgl2);
		 
				
			 
			$this->db->where("scan","1");
			$this->db->order_by("konfirm_rs","desc");
			$query=$this->db->from("v_test");
		 return $query;
 	}
	
	public function count()
	{				
			$this->_getDataRekap();
		return $this->db->get()->num_rows();
	}

	function listJenisTes(){
		return $this->db->get("tr_jenis_test")->result();
	}

	function jmlTest($tgl,$kode_jenis,$kode_tempat=null){
		   
		
		$tgl1 = $this->tanggal->range_1($tgl, 0);
		$tgl2 = $this->tanggal->range_2($tgl, 1);
		
		if($kode_istana=$this->session->userdata("kode_istana")){
			$this->db->where("kode_istana",$kode_istana);
		}
		if($kode_biro=$this->session->userdata("kode_biro")){
			$this->db->where("kode_biro",$kode_biro);
		}
		if($kode_tempat){
			$this->db->where("kode_tempat",$kode_tempat);
		}
		$this->db->where("kode_jenis",$kode_jenis);
		$this->db->where("konfirm_rs>=",$tgl1);
		$this->db->where("konfirm_rs<=",$tgl2);
		$this->db->where("scan","1");
		return $this->db->get("v_test")->num_rows();
		 
	}

	function listQueryRs(){
		$this->db->select("*,count(*) as jml");
			$this->db->group_by("kode_tempat");
			
	$tgl		 = $this->m_reff->san($this->input->get("range"));
	$kode_tempat = $this->m_reff->san($this->input->get("kode_tempat"));
	$kode_jenis  = $this->m_reff->san($this->input->get("kode_jenis"));
	$kode_biro   = $this->m_reff->san($this->input->get("kode_biro"));
	$kode_istana   = $this->m_reff->san($this->input->get("kode_istana"));
	if(!$tgl){
		return $this->m_reff->page404;
	}
	$tgl1 = $this->tanggal->range_1($tgl, 0);
	$tgl2 = $this->tanggal->range_2($tgl, 1);
	
	  
	   
	  
		
		if($kode_tempat!='undefined' and $kode_tempat!=''){
			$this->db->where("kode_tempat",$kode_tempat);
		}
		if($kode_jenis!='undefined' and $kode_jenis!=''){
			$this->db->where("kode_jenis",$kode_jenis);
		}


		if($kode_istana!='undefined' and $kode_istana!=''){
			$this->db->where("kode_istana",$kode_istana);
		}
		if($kode_biro!='undefined' and $kode_biro!=''){
			$this->db->where("kode_biro",$kode_biro);
		}
		$this->db->where("(konfirm_rs is not null)");
		$this->db->where("konfirm_rs>=",$tgl1);
		$this->db->where("konfirm_rs<=",$tgl2);
		$this->db->where("scan",1);
		// $this->db->where("hasil",null);
		$this->db->where("sts_acc",1);
		$this->db->order_by("scan_time","desc");
		return $this->db->get("v_test")->result();
	}
	 

}




