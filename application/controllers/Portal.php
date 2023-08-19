<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Portal extends CI_Controller {

	function __construct()
	{
		parent::__construct();	
		date_default_timezone_set('Asia/Jakarta');
		$this->m_konfig->validasi_global();
	} 
	 
	function getDataPns(){
	$nip = $this->input->post("nip");
	if(!$nip){
		return $this->m_reff->page404();
	}
			$this->db->where("nip_sso",$nip);
			$this->db->or_where("nip_baru",$nip);
			$this->db->or_where("nip",$nip);
			$data = $this->db->get("data_pegawai")->row();
		$tombol = $res = false;
		
		if(isset($data)){
			$res = "
			<input type='hidden' name='f[owner]' value='".$data->nama."'>
			<input type='hidden' name='f[nip]' value='".$data->nip_sso."'>
			<table class='entry2' width='100%'>
			<tr>
			<td>Nama</td> <td>".$data->nama."</td>
			</tr>
			<tr>
			<td>Gender</td> <td>".$this->m_reff->jk($data->jk)."</td>
			</tr>
			<tr>
			<td>Satker</td> <td>".$this->m_reff->istana($data->kode_istana)."</td>
			</tr>
			<tr>
			<td>Biro</td> <td>".$this->m_reff->biro($data->kode_biro)."</td>
			</tr>
			<tr>
			<td>Bagian</td> <td>".$data->bagian."</td>
			</tr>
			<tr>
			<td>Jabatan</td> <td>".$data->jabatan."</td>
			</tr>
			</table>";
			$tombol = true;
		}else{
			$res = "<i class='float-right'>Data tidak ditemukan!</i>";
		}

		$var["tombol"] = $tombol;
		$var["data"] = $res;
		$var["token"] = $this->m_reff->getToken();
		echo json_encode($var);
	}

	function getDataPns2(){
	$nip = $this->input->post("nip");
	if(!$nip){
		return $this->m_reff->page404();
	}
			$this->db->where("nip_sso",$nip);
			$this->db->or_where("nip_baru",$nip);
			$this->db->or_where("nip",$nip);
			$data = $this->db->get("data_pegawai")->row();
		$tombol = $res = false;
		
		if(isset($data)){
			$res = "
			<input type='hidden' name='f[owner]' value='".$data->nama."'>
			<input type='hidden' name='f[nip]' value='".$data->nip_sso."'>
			<input type='hidden' name='f[kode_istana]' value='".$data->kode_istana."'>
			<input type='hidden' name='f[kode_biro]' value='".$data->kode_biro."'>
			<table class='entry' width='100%'>
			<tr>
			<td>Nama</td> <td>".$data->nama."</td>
			</tr>
			<tr>
			<td>Gender</td> <td>".$this->m_reff->jk($data->jk)."</td>
			</tr>
			<tr>
			<td>Satker</td> <td>".$this->m_reff->istana($data->kode_istana)."</td>
			</tr>
			<tr>
			<td>Biro</td> <td>".$this->m_reff->biro($data->kode_biro)."</td>
			</tr>
			<tr>
			<td>Bagian</td> <td>".$data->bagian."</td>
			</tr>
			<tr>
			<td>Jabatan</td> <td>".$data->jabatan."</td>
			</tr>
			</table>";
			$tombol = true;
		}else{
			$res = "<i class='float-right'>Data tidak ditemukan!</i>";
		}

		$var["tombol"] = $tombol;
		$var["data"] = $res;
		$var["token"] = $this->m_reff->getToken();
		echo json_encode($var);
	}
	public function index()
	{
		$level = $this->session->userdata("level");
		if($level=="pegawai"){
			$cek = $this->db->get("data_pegawai",array("id",$this->m_reff->idu()))->row();
			if($cek->jenis_pegawai==1){
				  redirect("dpegawai");
			}
			if($cek->jenis_pegawai==2){
				$this->session->set_userdata("level","ppnpn");
				$level = "ppnpn";
			}
		}
		if($level=="ppnpn"){
			if($this->m_reff->mobile()){
				$this->load->view('portal/ppnpn-mobile');
			}else{
				$this->load->view('portal/ppnpn');
			}
			
		}else{
			$this->load->view('portal/index');
		}

	}
	function login(){
		$nip = $this->input->get("nip");
	 	$nip = $this->m_reff->decrypt($nip);
	
	
		$level = $this->input->get("level");
		$level = $this->m_reff->decrypt($level);

		$cekLevel = $this->db->get_where("main_level",array("nama"=>$level))->row();
		if(!isset($cekLevel->id_level)){ return $this->m_reff->page404();}

		if($level=="pegawai"){

			$data = $this->db->get_where("data_pegawai",array("nip"=>$nip))->row();
			if(isset($data->id)){
				$this->session->set_userdata("level",$level);
				$this->session->set_userdata("istana",$data->istana);
				$this->session->set_userdata("kode_biro",$data->kode_biro);
				$this->session->set_userdata("kode_istana",$data->kode_istana);
				$this->session->set_userdata("username",$data->nama);
				$this->session->set_userdata("id",$data->id);
				$this->m_reff->log("Direct login sebagai ".$level);
				redirect($cekLevel->direct);
			}else{
				return $this->m_reff->page404();
			}
			
		}else{ //jika ke admin
			$data = $this->db->get_where("admin",array("nip"=>$nip,"level"=>$cekLevel->id_level))->row();
			if(isset($data->id_admin)){
				$this->session->set_userdata("level",$level);
				$this->session->set_userdata("istana",$data->istana);
				$this->session->set_userdata("kode_biro",$data->kode_biro);
				$this->session->set_userdata("kode_istana",$data->kode_istana);
				$this->session->set_userdata("username",$data->owner);
				$this->session->set_userdata("id",$data->id_admin);
				$this->m_reff->log("Direct login sebagai ".$level);
				redirect($cekLevel->direct);
			}else{
				return $this->m_reff->page404();
			}
		}



	}
 
}
