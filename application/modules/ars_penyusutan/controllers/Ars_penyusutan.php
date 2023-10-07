<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ars_penyusutan extends CI_Controller
{


    function __construct()
    {
        parent::__construct();
        $this->m_konfig->validasi_session(array("admin_arsip", "up", "uk"));
        $this->load->model("model", "mdl");

        date_default_timezone_set('Asia/Jakarta');
    }

    function _template($data)
    {
        $this->load->view('temp_arsip/main', $data);
    }

    public function index()
    {

        $ajax = $this->input->post("ajax");
        if ($ajax == "yes") {
            echo    $this->load->view("index");
        } else {
            $data['konten'] = "index";
            $this->_template($data);
        }
    }

    public function pemindahan($id = 0)
    {
        $ajax = $this->input->post("ajax");
        $var["title"]           = "Pemindahan";
        $var["subtitle"]        = "Penyusutan / Pemindahan";

        if ($ajax == "yes") {
            $var["data"] = $this->load->view("pemindahan", null, true);
            $var["token"] = $this->m_reff->getToken();
            echo json_encode($var);
        } else {
            $var['konten'] = "pemindahan";
            $this->_template($var);
        }
    }

    function pemindahan_proses()
    {
        $form=$this->input->post();
		if(!$form)
        { 
            echo json_encode(["status" => 1, "message" => "Tidak ada data yang dapat di simpan"]);
            return;
        }
        $var["title"]       = "Request Pemindahan";
        $var["subtitle"]    = "Penyusutan / Pemindahan / Request Pemindahan";
        $status = $this->mdl->update_pemindahan();
        if($status["status"] != 0){
            $statusList = $this->mdl->add_list_pemindahan($status['uuid']);
            $statusList["uuid"] = $status["uuid"];
            $statusList["id"] = isset($status["id"]) ? $status["id"] : null;
            echo json_encode($statusList);
            return;
        }
        echo json_encode($status);
        return;
    }

    function pemindahan_cancel()
    {
        $form=$this->input->post();
		if(!$form)
        { 
            echo json_encode(["status" => 1, "message" => "Tidak ada data yang dapat di batalkan"]);
            return;
        }

        $statusList = $this->mdl->rem_list_pemindahan($form['uuid']);
        echo json_encode($statusList);
        return;
    }

    function penerimaan_pemindahan_proses()
    {
        $form=$this->input->post();
		if(!$form)
        { 
            echo json_encode(["status" => 1, "message" => "Tidak ada data yang dapat di simpan"]);
            return;
        }
        $var["title"]       = "Penerimaan Pemindahan";
        $var["subtitle"]    = "Penyusutan / Pemindahan / Request Pemindahan";
        $status = $this->mdl->update_pemindahan();
        if($status["status"] != 0){
            $statusList = $this->mdl->edit_list_penerimaan_pemindahan($form['uuid']);
            $statusList["uuid"] = $status["uuid"];
            $statusList["id"] = isset($status["id"]) ? $status["id"] : null;
            echo json_encode($statusList);
            return;
        }
        echo json_encode($status);
        return;
    }

    function penerimaan_pemindahan_cancel()
    {
        $form=$this->input->post();
		if(!$form)
        { 
            echo json_encode(["status" => 1, "message" => "Tidak ada data yang dapat di batalkan"]);
            return;
        }

        $statusList = $this->mdl->edit_list_penerimaan_pemindahan($form['uuid']);
        echo json_encode($statusList);
        return;
    }

    


    function pemindahan_simpan()
    {
        $form=$this->input->post();
		if(!$form)
        { 
            echo json_encode(["status" => 1, "message" => "Tidak ada data yang dapat di simpan"]);
            return;
        }

        $status = $this->mdl->update_pemindahan();
        echo json_encode($status);
        return;
    }



    function update_pemindahan()
    {
        $f = $this->input->post();
        if (!$f) {
            return $this->m_reff->page403();
        }

        $data = $this->mdl->update_pemindahan();
        echo json_encode($data);
    }



    function hapus_pemindahan()
    {
        $id = $this->m_reff->san($this->input->post("id"));
        if (!$id) {
            return $this->m_reff->page403();
        }

        $data = $this->mdl->hapus_pemindahan();
        echo json_encode($data);
    }

    /*
    	function update_unit_kearsipan(){
		$f=$this->input->post();
		if(!$f){ return $this->m_reff->page403();}

		$data = $this->mdl->update_unit_kearsipan();
		echo json_encode($data);
	}

    */

    function getList_pemindahan()
    {
        if (!$this->m_reff->san($this->input->post("draw"))) {
            echo $this->m_reff->page403();
            return false;
        }
        $list = $this->mdl->getList_pemindahan();
        $data = array();
        $no = $this->m_reff->san($this->input->post("start"));
        $no = $no + 1;
        foreach ($list as $val) {
            $tombol = "<div aria-label='Basic example' class='btn-groups text-center' role='group'>";
            if ($val->status_form == 1) { // draft: Edit
                $tombol .= "<button onclick='action_form(`0`, `$val->id`)' class='font14 btn btn-icon btn-sm ti-view-list btn-secondary' data-toggle='tooltip' data-placement='top' title='Detail' type='button'></button> ";
                $tombol .= "<button onclick='action_form(`$val->status_form`,`$val->id`)' class='font14 btn btn-icon btn-sm ti-pencil btn-info' data-toggle='tooltip' data-placement='top' title='Edit' type='button'></button> ";
                $tombol .= "<button style='color:white' onclick='action_form(`-1`, `$val->id`)' class='font14 btn btn-icon btn-sm ti-trash bg-danger' data-toggle='tooltip' data-placement='top' title='Batalkan' type='button'></button> ";
            } elseif ($val->status_form == 2) { // approval pengiriman: edit = approve, download ba
                $tombol .= "<button onclick='action_form(`0`, `$val->id`)' class='font14 btn btn-icon btn-sm ti-view-list btn-secondary' data-toggle='tooltip' data-placement='top' title='Detail' type='button'></button> ";
                $tombol .= "<a href='" . base_url('assets_arsip/doc_template/ba-pemindahan-arsip.pdf') . "' target='_blank' class='font14 btn btn-icon btn-sm ti-download btn-info' data-toggle='tooltip' data-placement='top' title='Download BA' type='button'></a> ";
                $tombol .= "<button onclick='action_form(`$val->status_form`,`$val->id`)' class='font14 btn btn-icon btn-sm ti-check btn-success' data-toggle='tooltip' data-placement='top' title='Approve Pengiriman' type='button'></button> ";
            } elseif ($val->status_form == 3) { // penerimaan: penerimaan, download ba
                $tombol .= "<button onclick='action_form(`99`, `$val->id`)' class='font14 btn btn-icon btn-sm ti-view-list btn-secondary' data-toggle='tooltip' data-placement='top' title='Detail' type='button'></button> ";
                $tombol .= "<a href='" . base_url('assets_arsip/doc_template/ba-pemindahan-arsip.pdf') . "' target='_blank' class='font14 btn btn-icon btn-sm ti-download btn-info' data-toggle='tooltip' data-placement='top' title='Download BA' type='button'></a> ";
                $tombol .= "<button onclick='action_form(`$val->status_form`,`$val->id`)' class='font14 btn btn-icon btn-sm ti-import btn-success' data-toggle='tooltip' data-placement='top' title='Penerimaan' type='button'></button> ";
            } elseif ($val->status_form == 4) { // approval penerimaan: penerimaan = approval penerimaan
                $tombol .= "<button onclick='action_form(`99`, `$val->id`)' class='font14 btn btn-icon btn-sm ti-view-list btn-secondary' data-toggle='tooltip' data-placement='top' title='Detail' type='button'></button> ";
                $tombol .= "<button onclick='action_form(`$val->status_form`,`$val->id`)' class='font14 btn btn-icon btn-sm ti-check btn-success' data-toggle='tooltip' data-placement='top' title='Approve Penerimaan' type='button'></button> ";
            } elseif ($val->status_form == 5) { // upload ba: upload ba
                $tombol .= "<button onclick='action_form(`99`, `$val->id`)' class='font14 btn btn-icon btn-sm ti-view-list btn-secondary' data-toggle='tooltip' data-placement='top' title='Detail' type='button'></button> ";
                $tombol .= "<button onclick='action_form(`$val->status_form`,`$val->id`)' class='font14 btn btn-icon btn-sm ti-upload btn-info' data-toggle='tooltip' data-placement='top' title='Upload BA' type='button'></button> ";
            } elseif ($val->status_form == 6) { // selesai: read
                $tombol .= "<button onclick='action_form(`99`,`$val->id`)' class='font14 btn btn-icon btn-sm ti-view-list btn-secondary' data-toggle='tooltip' data-placement='top' title='Detail' type='button'></button> ";
            }
            $tombol .= "</div>";

            $row = array();
            // "nomor" => $searchkey,
            // "tanggal_teks" => $searchkey,
            // "dari_organisasi_nama" => $searchkey,
            // "tujuan_organisasi_nama" => $searchkey,
            // "jumlah_arsip" => $searchkey,
            $statusTeks = "<center><span class=`text-muted`>$val->status_teks</span></center>";
            $row[] = $no++;
            $row[] = $val->nomor;
            $row[] = $val->tanggal_teks;
            $row[] = $val->dari_organisasi_nama;
            $row[] = $val->tujuan_organisasi_nama;
            $row[] = $val->jumlah_arsip_nomor;
            $row[] = $statusTeks;
            $row[] = $tombol;

            $data[] = $row;
        }

        $output = array(
            "draw" => $this->m_reff->san($this->input->post("draw")),
            "recordsTotal" => $c = $this->mdl->count_pemindahan(),
            "recordsFiltered" => $c,
            "data" => $data,
            "token" => $this->m_reff->getToken()
        );
        //output to json format
        echo json_encode($output);
    }

    function getList_berkas_usul_pindah()
    {
        if (!$this->m_reff->san($this->input->post("draw"))) {
            echo $this->m_reff->page403();
            return false;
        }
        $list = $this->mdl->getList_berkas_usul_pindah();
        $data = array();
        $no = $this->m_reff->san($this->input->post("start"));
        $no = $no + 1;
        foreach ($list as $val) {
            $row = array();
            //        $field = ["id", "kka_kode", "berkas_tipe_nama", "kurun_waktu", "tingkat_perkembangan_nama", "jumlah_arsip", "keterangan"];
            $row[] = "<td class='text-center'><input type='checkbox' class='checkItem1' id='checkItem1_$val->id' onclick='checkItem1($val->id)' value='$val->id'></td>";
            $row[] = $no++;
            $row[] = $val->kka_kode;
            $row[] = $val->berkas_tipe_nama;
            $row[] = $val->kurun_waktu;
            $row[] = $val->tingkat_perkembangan_nama;
            $row[] = $val->jumlah_arsip;
            $row[] = $val->keterangan;

            $data[] = $row;
        }

        $output = array(
            "draw" => $this->m_reff->san($this->input->post("draw")),
            "recordsTotal" => $c = $this->mdl->count_berkas_usul_pindah(),
            "recordsFiltered" => $c,
            "data" => $data,
            "token" => $this->m_reff->getToken()
        );
        //output to json format
        echo json_encode($output);
    }
    function getList_berkas_akan_pindah()
    {
        if (!$this->m_reff->san($this->input->post("draw"))) {
            echo $this->m_reff->page403();
            return false;
        }
        $list = $this->mdl->getList_berkas_akan_pindah($this->input->post("uuid"));
        $data = array();
        $no = $this->m_reff->san($this->input->post("start"));
        $no = $no + 1;
        foreach ($list as $val) {
            $row = array();
            //        $field = ["id", "kka_kode", "berkas_tipe_nama", "kurun_waktu", "tingkat_perkembangan_nama", "jumlah_arsip", "keterangan"];
            $row[] = "<td class='text-center'><input type='checkbox' class='checkItem2' id='checkItem2_$val->id' onclick='checkItem2($val->id)' value='$val->id'></td>";
            $row[] = $no++;
            $row[] = $val->kka_kode;
            $row[] = $val->berkas_tipe_nama;
            $row[] = $val->kurun_waktu;
            $row[] = $val->tingkat_perkembangan_nama;
            $row[] = $val->jumlah_arsip;
            $row[] = $val->keterangan;

            $data[] = $row;
        }

        $output = array(
            "draw" => $this->m_reff->san($this->input->post("draw")),
            "recordsTotal" => $c = $this->mdl->count_berkas_akan_pindah($this->input->post("uuid")),
            "recordsFiltered" => $c,
            "data" => $data,
            "token" => $this->m_reff->getToken()
        );
        //output to json format
        echo json_encode($output);
    }

    function getList_penerimaan_arsip()
    {
        if (!$this->m_reff->san($this->input->post("draw"))) {
            echo $this->m_reff->page403();
            return false;
        }
        $list = $this->mdl->getList_penerimaan_arsip($this->input->post("uuid"));
        $data = array();
        $no = $this->m_reff->san($this->input->post("start"));
        $no = $no + 1;
        foreach ($list as $val) {
            $row = array();
            //        $field = ["id", "kka_kode", "berkas_tipe_nama", "kurun_waktu", "tingkat_perkembangan_nama", "jumlah_arsip", "keterangan"];
            $row[] = "<td class='text-center'><input type='checkbox' class='checkItem1' id='checkItem1_$val->id' onclick='checkItem1($val->id)' value='$val->id'></td>";
            $row[] = $no++;
            $row[] = $val->kka_kode;
            $row[] = $val->berkas_tipe_nama;
            $row[] = $val->kurun_waktu;
            $row[] = $val->tingkat_perkembangan_nama;
            $row[] = $val->jumlah_arsip;
            $row[] = $val->keterangan;

            $data[] = $row;
        }

        $output = array(
            "draw" => $this->m_reff->san($this->input->post("draw")),
            "recordsTotal" => $c = $this->mdl->count_penerimaan_arsip($this->input->post("uuid")),
            "recordsFiltered" => $c,
            "data" => $data,
            "token" => $this->m_reff->getToken()
        );
        //output to json format
        echo json_encode($output);
    }
    function getList_penerimaan_arsip_diterima()
    {
        if (!$this->m_reff->san($this->input->post("draw"))) {
            echo $this->m_reff->page403();
            return false;
        }
        $list = $this->mdl->getList_penerimaan_arsip_diterima($this->input->post("uuid"));
        $data = array();
        $no = $this->m_reff->san($this->input->post("start"));
        $no = $no + 1;
        foreach ($list as $val) {
            $row = array();
            //        $field = ["id", "kka_kode", "berkas_tipe_nama", "kurun_waktu", "tingkat_perkembangan_nama", "jumlah_arsip", "keterangan"];
            $row[] = "<td class='text-center'><input type='checkbox' class='checkItem2' id='checkItem2_$val->id' onclick='checkItem2($val->id)' value='$val->id'></td>";
            $row[] = $no++;
            $row[] = $val->kka_kode;
            $row[] = $val->berkas_tipe_nama;
            $row[] = $val->kurun_waktu;
            $row[] = $val->tingkat_perkembangan_nama;
            $row[] = $val->jumlah_arsip;
            $row[] = $val->keterangan;

            $data[] = $row;
        }

        $output = array(
            "draw" => $this->m_reff->san($this->input->post("draw")),
            "recordsTotal" => $c = $this->mdl->count_penerimaan_arsip_diterima($this->input->post("uuid")),
            "recordsFiltered" => $c,
            "data" => $data,
            "token" => $this->m_reff->getToken()
        );
        //output to json format
        echo json_encode($output);
    }
    function getList_penerimaan_arsip_revisi()
    {
        if (!$this->m_reff->san($this->input->post("draw"))) {
            echo $this->m_reff->page403();
            return false;
        }
        $list = $this->mdl->getList_penerimaan_arsip_revisi($this->input->post("uuid"));
        $data = array();
        $no = $this->m_reff->san($this->input->post("start"));
        $no = $no + 1;
        foreach ($list as $val) {
            $row = array();
            //        $field = ["id", "kka_kode", "berkas_tipe_nama", "kurun_waktu", "tingkat_perkembangan_nama", "jumlah_arsip", "keterangan"];
            $row[] = "<td class='text-center'><input type='checkbox' class='checkItem3' id='checkItem3_$val->id' onclick='checkItem3($val->id)' value='$val->id'></td>";
            $row[] = $no++;
            $row[] = $val->kka_kode;
            $row[] = $val->berkas_tipe_nama;
            $row[] = $val->kurun_waktu;
            $row[] = $val->tingkat_perkembangan_nama;
            $row[] = $val->jumlah_arsip;
            $row[] = $val->keterangan;

            $data[] = $row;
        }

        $output = array(
            "draw" => $this->m_reff->san($this->input->post("draw")),
            "recordsTotal" => $c = $this->mdl->count_penerimaan_arsip_revisi($this->input->post("uuid")),
            "recordsFiltered" => $c,
            "data" => $data,
            "token" => $this->m_reff->getToken()
        );
        //output to json format
        echo json_encode($output);
    }


    function form_pemindahan($status_form = null, $id = null)
    {
        $ajax = $this->input->post("ajax");
        $var["title"]       = "Request Pemindahan";
        $var["subtitle"]    = "Penyusutan / Pemindahan / Request Pemindahan";
        $var["status_form"]      = $status_form;

        $pemberkasanTipe = 1;
        $var["pemberkasanTipe"] = $pemberkasanTipe;
        if($pemberkasanTipe == 1){
            $employeeNIP    = "180004900";
            $up_uuid        = "2caecb5a-5447-11ee-89db-ed50c5eb4bb3";
            $var["dataPemindahan"] = $this->mdl->get_pemindahan($id);
            $var["ttdDari"]     = $this->mdl->get_up_lead($up_uuid);
            $var["ttdTujuan"]     = $this->mdl->get_uk_lead($var["ttdDari"]->uk_tujuan_uuid, 2);
        }

        if ($ajax == "yes") {
            $var["data"]        = $this->load->view("form_pemindahan", NULL, TRUE);
            $var["token"] = $this->m_reff->getToken();
            $var["status"]      = $this->input->post("status");
            echo json_encode($var);
        } else {
            $var['konten'] = "form_pemindahan";
            $this->_template($var);
        }
    }
    function form_penerimaan_pemindahan($status_form = null, $id = null)
    {
        $ajax = $this->input->post("ajax");
        $var["title"]       = "Penerimaan Pemindahan";
        $var["subtitle"]    = "Penyusutan / Pemindahan / Penerimaan Pemindahan";
        $var["status_form"]      = $status_form;

        $pemberkasanTipe = 1;
        $var["pemberkasanTipe"] = $pemberkasanTipe;
        if($pemberkasanTipe == 1){
            $employeeNIP    = "180004900";
            $up_uuid        = "2caecb5a-5447-11ee-89db-ed50c5eb4bb3";
            $var["dataPemindahan"] = $this->mdl->get_pemindahan($id);
            $var["ttdDari"]     = $this->mdl->get_up_lead($up_uuid);
            $var["ttdTujuan"]     = $this->mdl->get_uk_lead($var["ttdDari"]->uk_tujuan_uuid, 2);
        }

        if ($ajax == "yes") {
            $var["data"]        = $this->load->view("form_penerimaan_pemindahan", NULL, TRUE);
            $var["token"] = $this->m_reff->getToken();
            $var["status"]      = $this->input->post("status");
            echo json_encode($var);
        } else {
            $var['konten'] = "form_penerimaan_pemindahan";
            $this->_template($var);
        }
    }
}
