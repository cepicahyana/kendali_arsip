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

    public function pemindahan()
    {

        $ajax = $this->input->post("ajax");
        $var["title"]        =    "Pemindahan";
        $var["subtitle"]    =    "Penyusutan / Pemindahan";
        if ($ajax == "yes") {
            $var["data"] = $this->load->view("pemindahan", null, true);
            $var["token"] = $this->m_reff->getToken();
            echo json_encode($var);
        } else {
            $var['konten'] = "pemindahan";
            $this->_template($var);
        }
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



    function getData_pemindahan()
    {
        if (!$this->m_reff->san($this->input->post("draw"))) {
            echo $this->m_reff->page403();
            return false;
        }
        $list = $this->mdl->getData_pemindahan();
        // echo json_encode($list);
        $list = [
            0 => (object) [
                "id" => 1,
                "nomor" => "SETPRES/PMDH/2023/0001",
                "tanggal" => "01 Sep 2023",
                "sumber" => "UP",
                "tujuan" => "UK2",
                "status" => 1,
                "jmlArsip" => 100
            ],
            1 => (object) [
                "id" => 2,
                "nomor" => "SETPRES/PMDH/2023/0002",
                "tanggal" => "01 Agu 2023",
                "sumber" => "UK3",
                "tujuan" => "UK2",
                "status" => 2,
                "jmlArsip" => 300
            ],
            2 => (object) [
                "id" => 3,
                "nomor" => "SETPRES/PMDH/2023/0003",
                "tanggal" => "22 Jun 2023",
                "sumber" => "UP",
                "tujuan" => "UK2",
                "status" => 3,
                "jmlArsip" => 45
            ],
            3 => (object) [
                "id" => 4,
                "nomor" => "SETPRES/PMDH/2023/0003",
                "tanggal" => "22 Jun 2023",
                "sumber" => "UP",
                "tujuan" => "UK2",
                "status" => 4,
                "jmlArsip" => 99
            ],
            4 => (object) [
                "id" => 5,
                "nomor" => "SETPRES/PMDH/2023/0004",
                "tanggal" => "25 Mei 2023",
                "sumber" => "UK3",
                "tujuan" => "UK2",
                "status" => 5,
                "jmlArsip" => 231
            ],
            5 => (object) [
                "id" => 6,
                "nomor" => "SETPRES/PMDH/2023/0004",
                "tanggal" => "25 Mei 2023",
                "sumber" => "UK3",
                "tujuan" => "UK2",
                "status" => 6,
                "jmlArsip" => 124
            ]
        ];
        // echo json_encode($list[0]->id);die;
        $data = array();
        $no = $this->m_reff->san($this->input->post("start"));
        $no = $no + 1;
        foreach ($list as $val) {
            ////
            $tombol = '<div aria-label="Basic example" class="btn-groups text-center" role="group">';
            $statusText = null;
            if ($val->status == 1) { // draft: Edit
                $tombol .= '<button onclick="action_form(`' . $val->id . '`, `' . 0 . '`)" class="font14 btn btn-icon btn-sm ti-view-list btn-secondary" data-toggle="tooltip" data-placement="top" title="Edit" type="button"></button> ';
                $tombol .= '<button onclick="action_form(`' . $val->id . '`, `' . $val->status . '`)" class="font14 btn btn-icon btn-sm ti-pencil btn-info" data-toggle="tooltip" data-placement="top" title="Edit" type="button"></button> ';
                $tombol .= '<button style="color:white" onclick="action_form(`' . $val->id . '`, `' . 99 . '`)" class="font14 btn btn-icon btn-sm ti-trash bg-danger" data-toggle="tooltip" data-placement="top" title="Batalkan" type="button"></button> ';
                
                $statusText = "<center><span class='text-muted'>Draft</span></center>";

            } elseif ($val->status == 2) { // approval pengiriman: edit = approve, download ba
                $tombol .= '<button onclick="action_form(`' . $val->id . '`, `' . 0 . '`)" class="font14 btn btn-icon btn-sm ti-view-list btn-secondary" data-toggle="tooltip" data-placement="top" title="Edit" type="button"></button> ';
                $tombol .= '<a href="'.base_url("assets_arsip/doc_template/ba-pemindahan-arsip.pdf").'" target="_blank" class="font14 btn btn-icon btn-sm ti-download btn-info" data-toggle="tooltip" data-placement="top" title="Download BA" type="button"></a> ';
                $tombol .= '<button onclick="action_form(`' . $val->id . '`, `' . $val->status . '`)" class="font14 btn btn-icon btn-sm ti-check btn-success" data-toggle="tooltip" data-placement="top" title="Approve Pengiriman" type="button"></button> ';

                $statusText = "<center><span class='text-primary'>Approval Pengiriman</span></center>";

            } elseif ($val->status == 3) { // penerimaan: penerimaan, download ba
                $tombol .= '<button onclick="action_form(`' . $val->id . '`, `' . 88 . '`)" class="font14 btn btn-icon btn-sm ti-view-list btn-secondary" data-toggle="tooltip" data-placement="top" title="Edit" type="button"></button> ';
                $tombol .= '<a href="'.base_url("assets_arsip/doc_template/ba-pemindahan-arsip.pdf").'" target="_blank" class="font14 btn btn-icon btn-sm ti-download btn-info" data-toggle="tooltip" data-placement="top" title="Download BA" type="button"></a> ';
                $tombol .= '<button onclick="action_form(`' . $val->id . '`, `' . $val->status . '`)" class="font14 btn btn-icon btn-sm ti-import btn-success" data-toggle="tooltip" data-placement="top" title="Penerimaan" type="button"></button> ';

                $statusText = "<center><span class='text-success'>Penerimaan</span></center>";

            } elseif ($val->status == 4) { // approval penerimaan: penerimaan = approval penerimaan
                $tombol .= '<button onclick="action_form(`' . $val->id . '`, `' . 88 . '`)" class="font14 btn btn-icon btn-sm ti-view-list btn-secondary" data-toggle="tooltip" data-placement="top" title="Edit" type="button"></button> ';
                $tombol .= '<button onclick="action_form(`' . $val->id . '`, `' . $val->status . '`)" class="font14 btn btn-icon btn-sm ti-check btn-success" data-toggle="tooltip" data-placement="top" title="Approve Penerimaan" type="button"></button> ';
                
                $statusText = "<center><span class='text-success'>Approval Penerimaan</span></center>";

            } elseif ($val->status == 5) { // upload ba: upload ba
                $tombol .= '<button onclick="action_form(`' . $val->id . '`, `' . 88 . '`)" class="font14 btn btn-icon btn-sm ti-view-list btn-secondary" data-toggle="tooltip" data-placement="top" title="Edit" type="button"></button> ';
                $tombol .= '<button onclick="action_form(`' . $val->id . '`, `' . $val->status . '`)" class="font14 btn btn-icon btn-sm ti-upload btn-info" data-toggle="tooltip" data-placement="top" title="Upload BA" type="button"></button> ';

                $statusText = "<center><span class='text-success'>Upload BA</span></center>";

            } elseif ($val->status == 6) { // selesai: read
                $tombol .= '<button onclick="action_form(`' . $val->id . '`, `' . 88 . '`)" class="font14 btn btn-icon btn-sm ti-view-list btn-secondary" data-toggle="tooltip" data-placement="top" title="Edit" type="button"></button> ';
                $statusText = "<center><span class='text-muted'>Selesai</span></center>";

            }
            $tombol .= '</div>';

            $row = array();
            $row[] = $no++;
            $row[] = $val->nomor;
            $row[] = $val->tanggal;
            $row[] = $val->sumber;
            $row[] = $val->tujuan;
            $row[] = $val->jmlArsip;
            $row[] = $statusText;
            $row[] = $tombol;
            $data[] = $row;
        }

        $output = array(
            "draw" => $this->m_reff->san($this->input->post("draw")),
            "recordsTotal" => $c = count($list),
            "recordsFiltered" => $c,
            "data" => $data,
            "token" => $this->m_reff->getToken()
        );
        //output to json format
        echo json_encode($output);
    }

    function form_pemindahan($status = null)
    {   
        $ajax = $this->input->post("ajax");
        $var["title"]       = "Request Pemindahan";
        $var["subtitle"]    = "Penyusutan / Pemindahan / Request Pemindahan";
        $var["status"]      = $status;
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
    function form_penerimaan_pemindahan($status = null)
    {   
        $ajax = $this->input->post("ajax");
        $var["title"]       = "Penerimaan Pemindahan";
        $var["subtitle"]    = "Penyusutan / Pemindahan / Penerimaan Pemindahan";
        $var["status"]      = $status;
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
