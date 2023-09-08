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
		$list = [
			0 => (object) [
				"id" => 1,
				"nomor" => "SETPRES/PMSN/2023/0001",
				"inisiator" => "Pegawai 1",
				"tanggal" => "01 Sep 2023",
				"status" => 1,
				"jmlArsipTim" => 50,
				"jmlArsipAnri" => 40
			],
			1 => (object) [
				"id" => 2,
				"nomor" => "SETPRES/PMSN/2023/0002",
				"inisiator" => "Pegawai 2",
				"tanggal" => "01 Agu 2023",
				"status" => 2,
				"jmlArsipTim" => 100,
				"jmlArsipAnri" => 90
			],
			3 => (object) [
				"id" => 3,
				"nomor" => "SETPRES/PMSN/2023/0003",
				"inisiator" => "Pegawai 3",
				"tanggal" => "22 Jun 2023",
				"status" => 3,
				"jmlArsipTim" => 150,
				"jmlArsipAnri" => 100
			],
			4 => (object) [
				"id" => 4,
				"nomor" => "SETPRES/PMSN/2023/0004",
				"inisiator" => "Pegawai 4",
				"tanggal" => "25 Mei 2023",
				"status" => 4,
				"jmlArsipTim" => 200,
				"jmlArsipAnri" => 120
			],
			5 => (object) [
				"id" => 4,
				"nomor" => "SETPRES/PMSN/2023/0004",
				"inisiator" => "Pegawai 5",
				"tanggal" => "25 Mei 2023",
				"status" => 5,
				"jmlArsipTim" => 250,
				"jmlArsipAnri" => 200
			],
			6 => (object) [
				"id" => 4,
				"nomor" => "SETPRES/PMSN/2023/0004",
				"inisiator" => "Pegawai 6",
				"tanggal" => "25 Mei 2023",
				"status" => 6,
				"jmlArsipTim" => 220,
				"jmlArsipAnri" => 200
			]

		];

		$data = array();
		$no = $this->m_reff->san($this->input->post("start"));
		$no =$no+1;
		
		foreach ($list as $val) {
         ////

		 	$tombol = '<div aria-label="Basic example" class="btn-groupss" role="group">';
		 	$tombol .= '<button onclick="detail(`'.$val->id.'`,`'.$val->nomor.'`)" class="font14 btn btn-sm ti-file btn-secondary" data-toggle="tooltip" data-placement="top" title="Detail" type="button"></button> ';
			$statusText = null;
			if ($val->status == 1) {
				$tombol .= '<button onclick="form_penilaian_tim(`' . $val->id . '`,`' . $val->nomor . '`)" class="font14 btn btn-icon btn-sm ti-pencil btn-info" data-toggle="tooltip" data-placement="top" title="Proses" type="button"></button> ';
				$tombol .= '<button style="color:white" onclick="pembatalan()" class="font14 btn btn-icon btn-sm ti-trash bg-danger" data-toggle="tooltip" data-placement="top" title="Batalkan" type="button"></button> ';
				$statusText = "<center><span class='badge bg-dark'>Penilaian Tim</span></center>";
			} elseif ($val->status == 2) {
				$tombol .= '<button onclick="form_penilaian_anri(`' . $val->id . '`,`' . $val->nomor . '`)" class="font14 btn btn-icon btn-sm ti-pencil btn-info" data-toggle="tooltip" data-placement="top" title="Proses" type="button"></button> ';
				$statusText = "<center><span class='badge bg-primary'>Penilaian ANRI</span></center>";
			} elseif ($val->status == 3) {
				$tombol .= '<button onclick="approve()" class="font14 btn btn-icon btn-sm ti-check btn-success" data-toggle="tooltip" data-placement="top" title="Approval Kasetpres" type="button"></button> ';
				$statusText = "<center><span class='badge bg-info'>Approval Kasetpres</span></center>";
			} elseif ($val->status == 4) {
				$tombol .= '<button onclick="form_proses_pemusnahan(`' . $val->id . '`,`' . $val->nomor . '`)" class="font14 btn btn-icon btn-sm ti-pencil btn-info" data-toggle="tooltip" data-placement="top" title="Proses" type="button"></button> ';
				$statusText = "<center><span class='badge bg-warning'>Proses Pemusnahan</span></center>";
			} elseif ($val->status == 5) {
				$tombol .= '<button onclick="uploadBA()" class="font14 btn btn-icon btn-sm ti-upload btn-info" data-toggle="tooltip" data-placement="top" title="Upload BA" type="button"></button> ';
				$statusText = "<center><span class='badge bg-success'>Upload BA</span></center>";
			} elseif ($val->status == 6) {
				$tombol .= '<a target="_blank" class="font14 btn btn-icon btn-sm ti-download btn-info" data-toggle="tooltip" data-placement="top" title="Download BA" type="button"></a> ';
				$statusText = "<center><span class='badge bg-light'>Selesai</span></center>";
			}
		 	$tombol .= '</div>';


			$row = array();
			$row[] = $no++;
			$row[] = $val->nomor;
			$row[] = $val->inisiator;
			$row[] = $val->tanggal;
			$row[] = $val->jmlArsipTim;
			$row[] = $val->jmlArsipAnri;
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
    
    function getDataArsip()
	{
		if(!$this->m_reff->san($this->input->post("draw"))){ echo $this->m_reff->page403(); return false;}
		$list = $this->mdl->getDataArsip();
		$data = array();
		$no = $this->m_reff->san($this->input->post("start"));
		$no =$no+1;
        echo '<pre>'; var_dump($list); die;
		foreach ($list as $val) {
         ////

		 $tombol='<div aria-label="Basic example" class="btn-groupss" role="group">
		 <button   onclick="action_form(`'.$val->id.'`,`'.$val->uraian.'`)" class="font14 btn btn-sm ti-pencil btn-secondary" type="button"> Edit</button> 
		 <button style="color:white" onclick="hapus(`'.$val->id.'`,`'.$val->uraian.'`)" class="font14 btn btn-sm ti-trash bg-danger" type="button"> Hapus</button> 
		 </div>';
 

		 $row = array();
		 $row[] = $no++;	
		 $row[] = $val->uraian;
		 
		 $row[] = $tombol;
		 $data[] = $row; 

		}

		$output = array(
			"draw" => $this->m_reff->san($this->input->post("draw")),
			"recordsTotal" => $c=$this->mdl->countArsip(),
			"recordsFiltered" =>$c,
			"data" => $data,
			"token"=>$this->m_reff->getToken()
		);
         //output to json format
		echo json_encode($output);

	}

    function form_pemusnahan()
    {
		// echo '<pre>'; var_dump($this->session->userdata('username')); die;
		$ajax = $this->input->post("ajax");
		$var["title"]       = "Request Pemusnahan";
		$var["subtitle"]    = "Penyusutan / Pemusnahan / Request Pemusnahan";
		if ($ajax == "yes") {
			$var["data"]        = $this->load->view("form_pemusnahan", NULL, TRUE);
			$var["token"] = $this->m_reff->getToken();
			echo json_encode($var);
		} else {
			$var['konten'] = "form_pemusnahan";
			$this->_template($var);
		}
    }

	function form_penilaian_tim()
	{
		// echo '<pre>'; var_dump($this->session->userdata('username')); die;
		$ajax = $this->input->post("ajax");
		$var["title"]       = "Penilaian Tim Pemusnahan";
		$var["subtitle"]    = "Penyusutan / Pemusnahan / Penilaian Tim";
		if ($ajax == "yes") {
			$var["data"]        = $this->load->view("form_penilaian_tim", NULL, TRUE);
			$var["token"] = $this->m_reff->getToken();
			echo json_encode($var);
		} else {
			$var['konten'] = "form_penilaian_tim";
			$this->_template($var);
		}
	}

	function form_penilaian_anri()
	{
		// echo '<pre>'; var_dump($this->session->userdata('username')); die;
		$ajax = $this->input->post("ajax");
		$var["title"]       = "Penilaian Anri";
		$var["subtitle"]    = "Penyusutan / Pemusnahan / Penilaian Anri";
		if ($ajax == "yes") {
			$var["data"]        = $this->load->view("form_penilaian_anri", NULL, TRUE);
			$var["token"] = $this->m_reff->getToken();
			echo json_encode($var);
		} else {
			$var['konten'] = "form_penilaian_anri";
			$this->_template($var);
		}
	}
	
	function form_proses_pemusnahan()
	{
		// echo '<pre>'; var_dump($this->session->userdata('username')); die;
		$ajax = $this->input->post("ajax");
		$var["title"]       = "Proses Pemusnahan";
		$var["subtitle"]    = "Penyusutan / Pemusnahan / Proses Pemusnahan";
		if ($ajax == "yes") {
			$var["data"]        = $this->load->view("form_proses_pemusnahan", NULL, TRUE);
			$var["token"] = $this->m_reff->getToken();
			echo json_encode($var);
		} else {
			$var['konten'] = "form_proses_pemusnahan";
			$this->_template($var);
		}
	}

	function detail()
	{
		// echo '<pre>'; var_dump($this->session->userdata('username')); die;
		$ajax = $this->input->post("ajax");
		$var["title"]       = "Detail";
		$var["subtitle"]    = "Penyusutan / Pemusnahan / Detail";
		if ($ajax == "yes") {
			$var["data"]        = $this->load->view("detail_pemusnahan", NULL, TRUE);
			$var["token"] = $this->m_reff->getToken();
			echo json_encode($var);
		} else {
			$var['konten'] = "detail_pemusnahan";
			$this->_template($var);
		}
	}

}