<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pemusnahan extends CI_Controller {

 
	function __construct()
	{
		parent::__construct();	
		$this->m_konfig->validasi_session(array("admin_arsip","up","uk"));
		$this->load->model("pemusnahan_model","mdl");
		 
		date_default_timezone_set('Asia/Jakarta');
	}

	function _template($data)
	{
		$this->load->view('temp_arsip/main',$data);	
	}





    public function index()
    {

        $ajax = $this->input->post("ajax");
        $var["title"]        =    "Pemusnahan";
        $var["subtitle"]    =    "Penyusutan / Pemusnahan";
        if ($ajax == "yes") {
            $var["data"] = $this->load->view("pemusnahan", null, true);
            $var["token"] = $this->m_reff->getToken();
            echo json_encode($var);
        } else {
            $var['konten'] = "pemusnahan";
            $this->_template($var);
        }
    }

    function update()
    {
        $id = $this->input->post("id");
        $form = $this->input->post("f");
        $this->db->set($form);
        if ($id) {
            $this->db->set("_uid", $this->session->userdata("nip"));
            $this->db->set("_utime", date('Y-m-d H:i:s'));
            $this->db->where("id", $id);
            $this->db->update("ars_tr_pemusnahan");
            $this->m_reff->log("update data pemusnahan");
        } else {
            $this->db->set("_cid", $this->session->userdata("nip"));
            $this->db->set("_ctime", date('Y-m-d H:i:s'));
            $this->db->insert("ars_tr_tingkat_perkembangan");
            $this->m_reff->log("menambahkan data pemusnahan");
        }
        return true;
    }

    function getData()
	{
		if(!$this->m_reff->san($this->input->post("draw"))){ echo $this->m_reff->page403(); return false;}
		$list = $this->mdl->getData();

		$data = array();
		$no = $this->m_reff->san($this->input->post("start"));
		$no =$no+1;
		
		foreach ($list as $val) {

			// tombol dan status
		 	$tombol = '<div aria-label="Basic example" class="btn-groupss" role="group">';
		 	$tombol .= '<button onclick="detail(`'.$val->id.'`,`'.$val->nomor.'`)" class="font14 btn btn-sm ti-file btn-secondary" data-toggle="tooltip" data-placement="top" title="Detail" type="button"></button> ';
			$statusText = null;
			if ($val->status == 1) {
				$tombol .= '<button onclick="form_penilaian_tim(`' . $val->id . '`,`' . $val->nomor . '`)" class="font14 btn btn-icon btn-sm ti-pencil btn-info" data-toggle="tooltip" data-placement="top" title="Proses" type="button"></button> ';
				$tombol .= '<button style="color:white" onclick="hapus(`' . $val->id . '`,`' . $val->nomor . '`)" class="font14 btn btn-icon btn-sm ti-trash bg-danger" data-toggle="tooltip" data-placement="top" title="Batalkan" type="button"></button> ';
				$statusText = "<center><span class='badge bg-dark'>Penilaian Tim</span></center>";
			} elseif ($val->status == 2) {
				$tombol .= '<button onclick="form_penilaian_anri(`' . $val->id . '`,`' . $val->nomor . '`)" class="font14 btn btn-icon btn-sm ti-pencil btn-info" data-toggle="tooltip" data-placement="top" title="Proses" type="button"></button> ';
				$statusText = "<center><span class='badge bg-primary'>Penilaian ANRI</span></center>";
			} elseif ($val->status == 3) {
				$tombol .= '<button onclick="form_approval_kasetpres(`' . $val->id . '`,`' . $val->nomor . '`)" class="font14 btn btn-icon btn-sm ti-check btn-success" data-toggle="tooltip" data-placement="top" title="Approval Kasetpres" type="button"></button> ';
				$statusText = "<center><span class='badge bg-info'>Approval Kasetpres</span></center>";
			} elseif ($val->status == 4) {
				$tombol .= '<button onclick="form_proses_pemusnahan(`' . $val->id . '`,`' . $val->nomor . '`)" class="font14 btn btn-icon btn-sm ti-pencil btn-info" data-toggle="tooltip" data-placement="top" title="Proses" type="button"></button> ';
				$statusText = "<center><span class='badge bg-warning'>Proses Pemusnahan</span></center>";
			} elseif ($val->status == 5) {
				$tombol .= '<button onclick="form_ba(`' . $val->id . '`,`' . $val->nomor . '`)" class="font14 btn btn-icon btn-sm ti-upload btn-info" data-toggle="tooltip" data-placement="top" title="Upload BA" type="button"></button> ';
				$statusText = "<center><span class='badge bg-success'>Upload BA</span></center>";
			} elseif ($val->status == 6) {
				$tombol .= '<a target="_blank" class="font14 btn btn-icon btn-sm ti-download btn-info" data-toggle="tooltip" data-placement="top" title="Download BA" type="button"></a> ';
				$statusText = "<center><span class='badge bg-secondary'>Selesai</span></center>";
			} else {
				$statusText = "<center><span class='badge bg-danger'>Gagal</span></center>";
			}
		 	$tombol .= '</div>';

			// insert row
			$row = array();
			$row[] = $no++;
			$row[] = $val->nomor;
			$row[] = $val->inisiator;
			$row[] = $val->tanggal_id;
			$row[] = $val->jumlah_arsip_tim;
			$row[] = $val->jumlah_arsip_anri;
			$row[] = $statusText;
			$row[] = $tombol;
			$data[] = $row;

		}

		$output = array(
			"draw" => $this->m_reff->san($this->input->post("draw")),
			"recordsTotal" => $c=$this->mdl->count(),
			"recordsFiltered" =>$c,
			"data" => $data,
			"token"=>$this->m_reff->getToken()
		);
         //output to json format
		echo json_encode($output);

	}
    
    function getDataBerkas()
	{
		if(!$this->m_reff->san($this->input->post("draw"))){ echo $this->m_reff->page403(); return false;}
		$list = $this->mdl->getDataBerkas();
		$data = array();
		$no = $this->m_reff->san($this->input->post("start"));
		$no =$no+1;
		foreach ($list as $val) {
         ////

		 $tombol='<div aria-label="Basic example" class="btn-groupss" role="group">
		 <button   onclick="action_form(`'.$val->id.'`,`'.$val->uraian_informasi.'`)" class="font14 btn btn-sm ti-pencil btn-secondary" type="button"> Edit</button> 
		 <button style="color:white" onclick="hapus(`'.$val->id.'`,`'.$val->uraian_informasi.'`)" class="font14 btn btn-sm ti-trash bg-danger" type="button"> Hapus</button> 
		 </div>';
 

		 $row = array();
		 $row[] = $no++;	
		 $row[] = $val->kka_nama;
		 $row[] = $val->uraian_informasi;
		 $row[] = $val->kurun_waktu;
		 
		//  $row[] = $tombol;
		 $data[] = $row; 

		}

		$output = array(
			"draw" => $this->m_reff->san($this->input->post("draw")),
			"recordsTotal" => $c=$this->mdl->countBerkas(),
			"recordsFiltered" =>$c,
			"data" => $data,
			"token"=>$this->m_reff->getToken()
		);
         //output to json format
		echo json_encode($output);

	}

	function getDataBerkasPenilaian()
	{
		// echo '<pre>'; var_dump($this->input->post()); die;
		if(!$this->m_reff->san($this->input->post("draw"))){ echo $this->m_reff->page403(); return false;}
		$list = $this->mdl->getDataBerkas();
		$data = array();
		$no = $this->m_reff->san($this->input->post("start"));
		$no =$no+1;

		foreach ($list as $val) { 

		 $row = array();

		 if ($this->m_reff->san($this->input->post("tipe")) == 'final_usulmusnah')
		 	$row[] = "<center>$no</center>";
		 else
		 	$row[] = "<center><input type='checkbox' onclick='pilihBerkas(this)' value='$val->pemusnahan_berkas_uuid' data-tipe='{$this->m_reff->san($this->input->post('tipe'))}'></center>";

		 $row[] = $val->kka_nama;
		 $row[] = $val->uraian_informasi;
		 $row[] = $val->kurun_waktu;

		 $data[] = $row; 

		}

		$output = array(
			"draw" => $this->m_reff->san($this->input->post("draw")),
			"recordsTotal" => $c=$this->mdl->countBerkas(),
			"recordsFiltered" =>$c,
			"data" => $data,
			"token"=>$this->m_reff->getToken()
		);
         //output to json format
		echo json_encode($output);

	}

    function form_pemusnahan()
    {
		$ajax = $this->input->post("ajax");
		$var["title"]       = "Request Pemusnahan";
		$var["subtitle"]    = "Penyusutan / Pemusnahan / Request Pemusnahan";
		if ($ajax == "yes") {
			$var["data"]    = $this->load->view("form_pemusnahan", NULL, TRUE);
			$var["token"] 	= $this->m_reff->getToken();
			echo json_encode($var);
		} else {
			$var['konten'] 	= "form_pemusnahan";
			$var['refresh'] = true;
			$var['id'] 		= 0;
			$var['pegawai']	= $this->mdl->getPegawai(['sts_keaktifan' => 'aktif'])->result();
			$this->_template($var);
		}
    }

	function update_form_pemusnahan(){
		$f=$this->input->post();
		if(!$f){ return $this->m_reff->page403();}

		$data = $this->mdl->update_form_pemusnahan();
		echo json_encode($data);
	}

	function penilaian()
	{
		$output = $this->mdl->penilaian();
		echo json_encode($output);
	}

	function form_penilaian_tim($param)
	{
		$id = $param;
		$ajax = $this->input->post("ajax");

		$var["title"]       = "Penilaian Tim Pemusnahan";
		$var["subtitle"]    = "Penyusutan / Pemusnahan / Penilaian Tim";
		if ($ajax == "yes") {
			$var["data"]    = $this->load->view("form_penilaian_tim", NULL, TRUE);
			$var["token"] 	= $this->m_reff->getToken();
			echo json_encode($var);
		} else {
			$var['konten'] 	= "form_penilaian_tim";
			$var['refresh'] = true;
			$var['detail']	= $this->mdl->getDetail($id);
			$var['id']		= $id;
			$this->_template($var);
		}
	}

	function update_form_penilaian_tim()
	{
		$f = $this->input->post();
		if (!$f) {
			return $this->m_reff->page403();
		}

		$data = $this->mdl->update_form_penilaian_tim();
		echo json_encode($data);
	}

	function form_penilaian_anri($param)
	{
		$id = $param;
		$ajax = $this->input->post("ajax");
		$var["title"]       = "Penilaian Anri";
		$var["subtitle"]    = "Penyusutan / Pemusnahan / Penilaian Anri";
		if ($ajax == "yes") {
			$var["data"]    = $this->load->view("form_penilaian_anri", NULL, TRUE);
			$var["token"] 	= $this->m_reff->getToken();
			echo json_encode($var);
		} else {
			$var['konten'] 	= "form_penilaian_anri";
			$var['refresh'] = true;
			$var['detail']	= $this->mdl->getDetail($id);
			$var['id']		= $id;
			$this->_template($var);
		}
	}

	function update_form_penilaian_anri()
	{
		$f = $this->input->post();
		if (!$f) {
			return $this->m_reff->page403();
		}

		$data = $this->mdl->update_form_penilaian_anri();
		echo json_encode($data);
	}

	function update_form_approval_kasetpres()
	{
		$f = $this->input->post();
		if (!$f) {
			return $this->m_reff->page403();
		}

		$data = $this->mdl->update_form_approval_kasetpres();
		echo json_encode($data);
	}
	
	function form_proses_pemusnahan($param)
	{
		$id = $param;
		$ajax = $this->input->post("ajax");
		$var["title"]       = "Proses Pemusnahan";
		$var["subtitle"]    = "Penyusutan / Pemusnahan / Proses Pemusnahan";
		if ($ajax == "yes") {
			$var["data"]  = $this->load->view("form_proses_pemusnahan", NULL, TRUE);
			$var["token"] = $this->m_reff->getToken();
			echo json_encode($var);
		} else {
			$var['konten'] = "form_proses_pemusnahan";
			$var['refresh'] = true;
			$var['detail']	= $this->mdl->getDetail($id);
			$var['softcopy']= $this->mdl->countBerkasByType(['uuid' => $var['detail']->uuid, 'type' => 'softcopy']);
			$var['hardcopy']= $this->mdl->countBerkasByType(['uuid' => $var['detail']->uuid, 'type' => 'hardcopy']);
			$var['id']		= $id;
			$this->_template($var);
		}
	}

	function update_form_proses_pemusnahan_softcopy()
	{
		$f = $this->input->post();
		if (!$f) {
			return $this->m_reff->page403();
		}

		$data = $this->mdl->update_form_proses_pemusnahan_softcopy();
		echo json_encode($data);
	}

	function update_form_proses_pemusnahan()
	{
		$f = $this->input->post();
		if (!$f) {
			return $this->m_reff->page403();
		}

		$data = $this->mdl->update_form_proses_pemusnahan();
		echo json_encode($data);
	}

	function form_ba($param)
	{
		$id = $param;
		$ajax = $this->input->post("ajax");
		$var["title"]       = "BA Pemusnahan";
		$var["subtitle"]    = "Penyusutan / Pemusnahan / BA Pemusnahan";
		if ($ajax == "yes") {
			$var["data"]    = $this->load->view("form_ba", NULL, TRUE);
			$var["token"] 	= $this->m_reff->getToken();
			echo json_encode($var);
		} else {
			$var['konten'] 	= "form_ba";
			$var['refresh'] = true;
			$var['detail']	= $this->mdl->getDetail($id);
			$var['pegawai']	= $this->mdl->getPegawai(['sts_keaktifan' => 'aktif'])->result();
			$var['id']		= $id;
			$this->_template($var);
		}
	}

	function update_form_ba()
	{
		$f = $this->input->post();
		if (!$f) {
			return $this->m_reff->page403();
		}

		$data = $this->mdl->update_form_ba();
		echo json_encode($data);
	}

	function hapus_pemusnahan(){
		$id = $this->m_reff->san($this->input->post("id"));
		if(!$id){ return $this->m_reff->page403();}

		$data = $this->mdl->hapus_pemusnahan();
		echo json_encode($data);
	}

	function detail($param)
	{
		$id = $param;
		$ajax = $this->input->post("ajax");
		
		$var["title"]       = "Detail";
		$var["subtitle"]    = "Penyusutan / Pemusnahan / Detail";
		if ($ajax == "yes") {
			$var["data"]  = $this->load->view("detail_pemusnahan", NULL, TRUE);
			$var["token"] = $this->m_reff->getToken();
			echo json_encode($var);
		} else {
			$var['konten'] 	= "detail_pemusnahan";
			$var['refresh'] = true;
			$var['detail']	= $this->mdl->getDetail($id);
			$var['id']		= $id;
			$this->_template($var);
		}
	}

}