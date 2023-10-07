<?php

class Model extends CI_Model
{



    function __construct()
    {
        parent::__construct();
    }
    function idu()
    {
        return $this->session->userdata("id");
    }


    /*======= DATATABLE PEMINDAHAN =========*/
    function getList_pemindahan()
    {
        if ($this->m_reff->san($this->input->post("length") != -1))
            return $this->_getList_pemindahan($this->m_reff->san($this->input->post("length")), $this->m_reff->san($this->input->post("start")), 0, "");
        else
            return $this->_getList_pemindahan(0, 0, 0, "");
    }
    public function count_pemindahan()
    {
        return $this->_getList_pemindahan(0, 0, 1, "")[0]->total;
    }
    function _getList_pemindahan($limit = 0, $offset = 0, $isCount = 0, $filter = "")
    {
        $field = ["`id`", "`nomor`", "`tanggal`", "`dari_organisasi_nama`", "`tujuan_organisasi_nama`", "`jumlah_arsip`", "`status_teks`"];

        $filter .= "";
        if (strlen(isset($_POST['search']['value']) ? ($_POST['search']['value']) : null) > 1) {
            $searchkey = $_POST['search']['value'];
            $searchkey = $this->m_reff->sanitize($searchkey);

            $filter .= " AND (";
            for ($a = 0; $a < count($field); $a++) {
                $filter .= ($a == 0 ? "" : " OR ") . $field[$a] . " LIKE \"%$searchkey%\"";
            }
            $filter .= ")";
        }

        $orderColumn = intval($_POST['order'][0]['column'] ?? 0);
        $orderColumn = $this->m_reff->sanitize($orderColumn);
        $orderDir = $_POST['order'][0]['column'] == null ? "desc" : $_POST['order'][0]['dir'] ?? "desc";
        $orderDir = $this->m_reff->sanitize($orderDir);
        $order = $field[$orderColumn] . " " . $orderDir;

        $query = $this->db->query("CALL proc_pemindahan('$limit','$offset','$filter','$order','$isCount');");
        $result = $query->result();
        $this->db->close();
        return $result;
    }
    /*======= DATATABLE PEMINDAHAN =========*/

    /*======= DATATABLE BERKAS USUL PINDAH =========*/
    function getList_berkas_usul_pindah()
    {
        if ($this->m_reff->san($this->input->post("length") != -1))
            return $this->_getList_berkas_usul_pindah($this->m_reff->san($this->input->post("length")), $this->m_reff->san($this->input->post("start")), 0, " AND `a`.`process` IS NULL ");
        else
            return $this->_getList_berkas_usul_pindah(0, 0, 0, " AND `a`.`process` IS NULL ");
    }
    public function count_berkas_usul_pindah()
    {
        return $this->_getList_berkas_usul_pindah(0, 0, 1, " AND `a`.`process` IS NULL ")[0]->total;
    }
    function getList_berkas_akan_pindah($uuid)
    {
        if ($this->m_reff->san($this->input->post("length") != -1))
            return $this->_getList_berkas_usul_pindah($this->m_reff->san($this->input->post("length")), $this->m_reff->san($this->input->post("start")), 0, ' AND `a`.`process` = 2 AND `pemindahan_uuid` = "' . $uuid . '" ');
        else
            return $this->_getList_berkas_usul_pindah(0, 0, 0, ' AND `a`.`process` = 2 AND `pemindahan_uuid` = "' . $uuid . '" ');
    }
    public function count_berkas_akan_pindah($uuid)
    {
        return $this->_getList_berkas_usul_pindah(0, 0, 1, ' AND `a`.`process` = 2 AND `pemindahan_uuid` = "' . $uuid . '" ')[0]->total;
    }

    function getList_penerimaan_arsip($uuid)
    {
        if ($this->m_reff->san($this->input->post("length") != -1))
            return $this->_getList_berkas_usul_pindah($this->m_reff->san($this->input->post("length")), $this->m_reff->san($this->input->post("start")), 0, ' AND `d`.`status` = 1 AND `a`.`process` = 2 AND `pemindahan_uuid` = "' . $uuid . '" ');
        else
            return $this->_getList_berkas_usul_pindah(0, 0, 0, ' AND `d`.`status` = 1 AND `a`.`process` = 2 AND `pemindahan_uuid` = "' . $uuid . '" ');
    }
    public function count_penerimaan_arsip($uuid)
    {
        return $this->_getList_berkas_usul_pindah(0, 0, 1, ' AND `d`.`status` = 1 AND `a`.`process` = 2 AND `pemindahan_uuid` = "' . $uuid . '" ')[0]->total;
    }
    function getList_penerimaan_arsip_diterima($uuid)
    {
        if ($this->m_reff->san($this->input->post("length") != -1))
            return $this->_getList_berkas_usul_pindah($this->m_reff->san($this->input->post("length")), $this->m_reff->san($this->input->post("start")), 0, ' AND `d`.`status` = 2 AND `a`.`process` = 2 AND `pemindahan_uuid` = "' . $uuid . '" ');
        else
            return $this->_getList_berkas_usul_pindah(0, 0, 0, ' AND `d`.`status` = 2 AND `a`.`process` = 2 AND `pemindahan_uuid` = "' . $uuid . '" ');
    }
    public function count_penerimaan_arsip_diterima($uuid)
    {
        return $this->_getList_berkas_usul_pindah(0, 0, 1, ' AND `d`.`status` = 2 AND `a`.`process` = 2 AND `pemindahan_uuid` = "' . $uuid . '" ')[0]->total;
    }
    function getList_penerimaan_arsip_revisi($uuid)
    {
        if ($this->m_reff->san($this->input->post("length") != -1))
            return $this->_getList_berkas_usul_pindah($this->m_reff->san($this->input->post("length")), $this->m_reff->san($this->input->post("start")), 0, ' AND `d`.`status` = 3 AND `a`.`process` = 2 AND `pemindahan_uuid` = "' . $uuid . '" ');
        else
            return $this->_getList_berkas_usul_pindah(0, 0, 0, ' AND `d`.`status` = 3 AND `a`.`process` = 2 AND `pemindahan_uuid` = "' . $uuid . '" ');
    }
    public function count_penerimaan_arsip_revisi($uuid)
    {
        return $this->_getList_berkas_usul_pindah(0, 0, 1, ' AND `d`.`status` = 3 AND `a`.`process` = 2 AND `pemindahan_uuid` = "' . $uuid . '" ')[0]->total;
    }

    function _getList_berkas_usul_pindah($limit = 0, $offset = 0, $isCount = 0, $filter = "")
    {
        $field = ["id", "id", "kka_kode", "berkas_tipe_nama", "kurun_waktu", "tingkat_perkembangan_nama", "jumlah_arsip", "keterangan_pemindahan"];

        $filter .= "";
        if (strlen(isset($_POST['search']['value']) ? ($_POST['search']['value']) : null) > 1) {
            $searchkey = $_POST['search']['value'];
            $searchkey = $this->m_reff->sanitize($searchkey);

            $filter .= " AND (";
            for ($a = 0; $a < count($field); $a++) {
                $filter .= ($a == 0 ? "" : " OR ") . $field[$a] . " LIKE \"%$searchkey%\"";
            }
            $filter .= ")";
        }

        $orderColumn = intval($_POST['order'][0]['column'] ?? 0);
        $orderColumn = $this->m_reff->sanitize($orderColumn);
        $orderDir = $_POST['order'][0]['column'] == null ? "desc" : $_POST['order'][0]['dir'] ?? "desc";
        $orderDir = $this->m_reff->sanitize($orderDir);
        $order = $field[$orderColumn] . " " . $orderDir;

        $query = $this->db->query("CALL proc_pemindahan_list_berkas('$limit','$offset','$filter','$order','$isCount');");
        $result = $query->result();
        $this->db->close();
        return $result;
    }
    /*======= DATATABLE BERKAS USUL PINDAH =========*/

    function get_pemindahan($id)
    {
        $this->db->where("id", $id);
        return $this->db->get("view_ars_trx_pemindahan")->row();
    }

    function update_pemindahan()
    {
        $form = $this->input->post();
        if (!$form) {
            $result["status"] = 0;
            $result["message"] = "Gagal memproses data pemindahan";
            return $result;
        }
        $uuid = isset($form["uuid"]) && $form["uuid"] != null && $form["uuid"] != "" ? $form["uuid"] : null;

        if (isset($form["isrev"])) $this->db->set("isrev", $form["isrev"] != null && $form["isrev"] != "" ? $form["isrev"] : null);
        if (isset($form["status"])) $this->db->set("status", $form["status"] != null && $form["status"] != "" ? $form["status"] : null);
        if (isset($form["tanggal"])) $this->db->set("tanggal", $form["tanggal"] != null && $form["tanggal"] != "" ? $form["tanggal"] : null);
        if (isset($form["pemberkasan_tipe"])) $this->db->set("tipe", $form["pemberkasan_tipe"] != null && $form["pemberkasan_tipe"] != "" ? $form["pemberkasan_tipe"] : null);
        if (isset($form["dari_organisasi_kode"])) $this->db->set("dari_organisasi_kode", $form["dari_organisasi_kode"] != null && $form["dari_organisasi_kode"] != "" ? $form["dari_organisasi_kode"] : null);
        if (isset($form["dari_penandatangan_nama"])) $this->db->set("ttd_dari_employee", $form["dari_penandatangan_nama"] != null && $form["dari_penandatangan_nama"] != "" ? $form["dari_penandatangan_nama"] : null);
        if (isset($form["dari_penandatangan_jabatan"])) $this->db->set("ttd_dari_jabatan", $form["dari_penandatangan_jabatan"] != null && $form["dari_penandatangan_jabatan"] != "" ? $form["dari_penandatangan_jabatan"] : null);
        if (isset($form["tujuan_organisasi_kode"])) $this->db->set("tujuan_organisasi_kode", $form["tujuan_organisasi_kode"] != null && $form["tujuan_organisasi_kode"] != "" ? $form["tujuan_organisasi_kode"] : null);
        if (isset($form["tujuan_penandatangan_nama"])) $this->db->set("ttd_tujuan_employee", $form["tujuan_penandatangan_nama"] != null && $form["tujuan_penandatangan_nama"] != "" ? $form["tujuan_penandatangan_nama"] : null);
        if (isset($form["tujuan_penandatangan_jabatan"])) $this->db->set("ttd_tujuan_jabatan", $form["tujuan_penandatangan_jabatan"] != null && $form["tujuan_penandatangan_jabatan"] != "" ? $form["tujuan_penandatangan_jabatan"] : null);
        if (isset($form["info_tambahan"])) $this->db->set("info_tambahan", $form["info_tambahan"] != null && $form["info_tambahan"] != "" ? $form["info_tambahan"] : null);

        if ($_FILES['upload_ba']['name'] != '') {
            $this->load->helper('file');
            $uploaded_data = $_FILES['upload_ba'];
            $filenameori = $uploaded_data['name'];
            $ext = pathinfo($filenameori, PATHINFO_EXTENSION);
            $filename = sha1_file($uploaded_data['tmp_name']);
            $dirminio = "pemindahan/upload_ba/";
            $dirminiofull =  $dirminio . $filename . '.' . $ext;

            $this->load->library('minio');
            $pathfile = $this->minio->uploadFilesObject($uploaded_data['tmp_name'], $dirminiofull, $dirminio, '10');

            $this->db->set('ba_file_path', $dirminiofull);
            // $data_file['uuid'] = $this->getUUID();
            // $data_file['arsip_uuid'] = $data->uuid;
            // $data_file['file_path'] = $dirminiofull;
            // $data_file['file_ext'] = $ext;
            // $data_file['file_size'] = $uploaded_data['size'];
        }


        if ($uuid != null && $uuid != '') {
            $this->db->set("_uid", $this->session->userdata("nip"));
            $this->db->set("_utime", date('Y-m-d H:i:s'));
            $this->db->where("uuid", $uuid);
            $this->db->update("ars_trx_pemindahan");
            $this->m_reff->log("mengubah data pemindahan");
            $result["status"] = 2;
            $result["message"] = "Berhasil mengubah data pemindahan";
            $result["uuid"] = $uuid;
        } else {
            $this->db->set("uuid", 'uuid()', false);
            $this->db->set("nomor", $this->generate_nomor());
            $this->db->set("kode", $this->generate_kode());
            if (!isset($form["status"])) $this->db->set("status", 1);
            $this->db->set("_cid", $this->session->userdata("nip"));
            $this->db->set("_ctime", date('Y-m-d H:i:s'));

            $this->db->insert("ars_trx_pemindahan");
            $id = $this->db->insert_id();
            $this->m_reff->log("menambahkan data pemindahan");
            $result["status"] = 1;
            $result["message"] = "Berhasil menambahkan data pemindahan";
            $result["uuid"] = $this->db->where('id', $id)->from('ars_trx_pemindahan')->get()->row()->uuid;
            $result["id"] = $id;
        }
        if (isset($form['checkedItem'])) {
            $checkedItem[] = count($form['checkedItem']) > 0 ? $form['checkedItem'] : null;
            if (count($checkedItem) > 0) {
                foreach ($checkedItem as $v) {
                }
            }
        }
        return $result;
    }
    function add_list_pemindahan($uuid)
    {
        $checkedAll = $this->input->post('checkedAll');
        $checkedItem = $this->input->post('checkedItem');
        if (($checkedItem == null || count($checkedItem) == 0) && ($checkedAll == null || $checkedAll == 0)) {
            $result["status"] = 0;
            $result["message"] = "proses penambahan list pemindahan gagal dilakukan";
            return $result;
        }
        $successTotal = 0;
        if ($checkedAll == 1) {
            $this->db->where('(process IS NULL OR process = 0)');
            $listBerkas = $this->db->get('ars_trx_berkas')->result();
            foreach ($listBerkas as $thisBerkas) {
                if ($thisBerkas != null) {
                    $this->db->set("uuid", 'uuid()', false);
                    $this->db->set("pemindahan_uuid", $uuid);
                    $this->db->set("berkas_uuid", $thisBerkas->uuid);
                    $this->db->set("status", 1);
                    $this->db->set("_cid", $this->session->userdata("nip"));
                    $this->db->set("_ctime", date('Y-m-d H:i:s'));
                    $this->db->insert("ars_trx_pemindahan_berkas");

                    $this->db->set("process", 2);
                    $this->db->set("_uid", $this->session->userdata("nip"));
                    $this->db->set("_utime", date('Y-m-d H:i:s'));
                    $this->db->where("id", $thisBerkas->id);
                    $this->db->where("(process IS NULL OR process = 0)");
                    $this->db->update("ars_trx_berkas");
                    $successTotal++;
                }
            }
        } else {
            foreach ($checkedItem as $v) {
                $this->db->where('id', $v);
                $this->db->where('(process IS NULL OR process = 0)');
                $thisBerkas = $this->db->get('ars_trx_berkas')->row();
                if ($thisBerkas != null) {
                    $this->db->set("uuid", 'uuid()', false);
                    $this->db->set("pemindahan_uuid", $uuid);
                    $this->db->set("berkas_uuid", $thisBerkas->uuid);
                    $this->db->set("status", 1);
                    $this->db->set("_cid", $this->session->userdata("nip"));
                    $this->db->set("_ctime", date('Y-m-d H:i:s'));
                    $this->db->insert("ars_trx_pemindahan_berkas");

                    $this->db->set("process", 2);
                    $this->db->set("_uid", $this->session->userdata("nip"));
                    $this->db->set("_utime", date('Y-m-d H:i:s'));
                    $this->db->where("id", $thisBerkas->id);
                    $this->db->where("(process IS NULL OR process = 0)");
                    $this->db->update("ars_trx_berkas");
                    $successTotal++;
                }
            }
        }

        $this->db->where('pemindahan_uuid', $uuid);
        $totalData = $this->db->get('ars_trx_pemindahan_berkas')->num_rows();

        $this->db->set('jumlah_arsip', $totalData);
        $this->db->where('uuid', $uuid);
        $this->db->update('ars_trx_pemindahan');

        $result["status"] = 1;
        $result["message"] = "Berhasil menambahkan $successTotal Berkas Arsip";
        return $result;
    }
    function rem_list_pemindahan($uuid)
    {
        $checkedAll = $this->input->post('checkedAll');
        $checkedItem = $this->input->post('checkedItem');
        if (($checkedItem == null || count($checkedItem) == 0) && ($checkedAll == null || $checkedAll == 0)) {
            $result["status"] = 0;
            $result["message"] = "proses pembatalan list pemindahan gagal dilakukan";
            $result["uuiid"] = $uuid;
            return $result;
        }
        $successTotal = 0;
        if ($checkedAll == 1) {
            $this->db->from("ars_trx_berkas a");
            $this->db->join("ars_trx_pemindahan_berkas b", "a.uuid = b.berkas_uuid", 'INNER JOIN');
            $this->db->where("b.pemindahan_uuid", $uuid);
            $this->db->where('a.process = 2');
            $this->db->select('a.*');
            $listBerkas = $this->db->get()->result();
            foreach ($listBerkas as $thisBerkas) {
                if ($thisBerkas != null) {
                    $this->db->where("pemindahan_uuid", $uuid);
                    $this->db->where("berkas_uuid", $thisBerkas->uuid);
                    $this->db->delete("ars_trx_pemindahan_berkas");

                    $this->db->set("process", null);
                    $this->db->set("_uid", $this->session->userdata("nip"));
                    $this->db->set("_utime", date('Y-m-d H:i:s'));
                    $this->db->where("id", $thisBerkas->id);
                    $this->db->where("process = 2");
                    $this->db->update("ars_trx_berkas");
                    $successTotal++;
                }
            }
        } else {
            foreach ($checkedItem as $v) {
                $this->db->where('id', $v);
                $this->db->where('process = 2');
                $thisBerkas = $this->db->get('ars_trx_berkas')->row();
                if ($thisBerkas != null) {
                    $this->db->where("pemindahan_uuid", $uuid);
                    $this->db->where("berkas_uuid", $thisBerkas->uuid);
                    $this->db->delete("ars_trx_pemindahan_berkas");

                    $this->db->set("process", null);
                    $this->db->set("_uid", $this->session->userdata("nip"));
                    $this->db->set("_utime", date('Y-m-d H:i:s'));
                    $this->db->where("id", $thisBerkas->id);
                    $this->db->where("process = 2");
                    $this->db->update("ars_trx_berkas");
                    $successTotal++;
                }
            }
        }

        $this->db->where('pemindahan_uuid', $uuid);
        $totalData = $this->db->get('ars_trx_pemindahan_berkas')->num_rows();

        $this->db->set('jumlah_arsip', $totalData);
        $this->db->where('uuid', $uuid);
        $this->db->update('ars_trx_pemindahan');

        $result["status"] = 1;
        $result["message"] = "Berhasil membatalkan $successTotal Berkas Arsip";
        $result["uuiid"] = $uuid;
        return $result;
    }

    function edit_list_penerimaan_pemindahan($uuid)
    {
        $status = $this->input->post('status');
        $statusBefore = $this->input->post('statusBefore');
        $checkedAll = $this->input->post('checkedAll');
        $checkedItem = $this->input->post('checkedItem');
        if (($checkedItem == null || count($checkedItem) == 0) && ($checkedAll == null || $checkedAll == 0)) {
            $result["status"] = 0;
            $result["message"] = "proses " . ($status == 1 ? "pembatalan" : ($status == 2 ? "penerimaan" : "penolakan")) . " list pemindahan gagal dilakukan";
            $result["uuiid"] = $uuid;
            return $result;
        }
        $successTotal = 0;
        if ($checkedAll == 1) {
            $this->db->from("ars_trx_pemindahan_berkas");
            $this->db->where("pemindahan_uuid", $uuid);
            $this->db->where("status", $statusBefore == null ? 1 : $statusBefore);
            $listBerkas = $this->db->get()->result();
            foreach ($listBerkas as $thisBerkas) {
                if ($thisBerkas != null) {
                    $this->db->set("_uid", $this->session->userdata("nip"));
                    $this->db->set("_utime", date('Y-m-d H:i:s'));
                    $this->db->set("status", $status);
                    $this->db->where("uuid", $thisBerkas->uuid);
                    $this->db->update("ars_trx_pemindahan_berkas");
                    $successTotal++;
                }
            }
        } else {
            foreach ($checkedItem as $v) {
                $this->db->where('id', $v);
                $this->db->where('process = 2');
                $thisBerkas = $this->db->get('ars_trx_berkas')->row();
                if ($thisBerkas != null) {
                    $this->db->set("status", $status);
                    $this->db->set("_uid", $this->session->userdata("nip"));
                    $this->db->set("_utime", date('Y-m-d H:i:s'));
                    $this->db->where("pemindahan_uuid", $uuid);
                    $this->db->where("berkas_uuid", $thisBerkas->uuid);
                    $this->db->update("ars_trx_pemindahan_berkas");
                    $successTotal++;
                }
            }
        }

        $this->db->where('pemindahan_uuid', $uuid);
        $totalData = $this->db->get('ars_trx_pemindahan_berkas')->num_rows();

        $this->db->set('jumlah_arsip', $totalData);
        $this->db->where('uuid', $uuid);
        $this->db->update('ars_trx_pemindahan');

        $result["status"] = 1;
        $result["message"] = "Berhasil " . ($status == 1 ? "pembatalan" : ($status == 2 ? "penerimaan" : "penolakan")) . " $successTotal Berkas Arsip";
        $result["uuiid"] = $uuid;
        return $result;
    }

    function generate_nomor()
    {
        $nomor = "SETPRES/PMDH/" . date("Y") . "/";
        $this->db->from("ars_trx_pemindahan");
        $this->db->where("nomor LIKE '$nomor%'");
        $this->db->where("nomor IS NOT NULL");
        $this->db->order_by("id", "desc");
        $lastdata = $this->db->get()->row();

        $index = 0;
        if ($lastdata) {
            $_nomor = $lastdata->nomor;
            $index = intval(explode("/", $_nomor)[3]);
            $index = $index == null || $index == '' ? 0 : $index;
        }
        $nomor = $nomor . sprintf("%04d", ($index + 1));
        return $nomor;
    }
    function generate_kode()
    {
        $kode = "P-" . date("Y") . "-";
        $this->db->from("ars_trx_pemindahan");
        $this->db->where("kode LIKE '$kode%'");
        $this->db->where("kode IS NOT NULL");
        $this->db->order_by("id", "desc");
        $lastdata = $this->db->get()->row();

        $index = 0;
        if ($lastdata) {
            $_kode = $lastdata->kode;
            $index = intval(explode("-", $_kode)[2]);
            $index = $index == null || $index == '' ? 0 : $index;
        }
        $kode = $kode . sprintf("%03d", ($index + 1));
        return $kode;
    }

    function get_up_lead($uuid)
    {
        $this->db->from("ars_tr_up a");
        $this->db->join("ars_tr_up_employee b", "a.uuid = b.up_uuid", "INNER JOIN");
        $this->db->join("data_pegawai c", "b.employee_nip = c.nip", "INNER JOIN");
        $this->db->join("ars_tr_organisasi d", "a.organisasi_kode = d.kode", "INNER JOIN");
        $this->db->join("ars_tr_posisi_tipe e", "b.posisi_type = e.kode", "INNER JOIN");

        $this->db->where("a.uuid", $uuid);
        $this->db->where("b.posisi_type", "01");
        $this->db->select("a.uuid up_uuid, a.uk_uuid uk_tujuan_uuid, b.uuid up_employee_uuid, c.nip pegawai_nip, d.kode organisasi_kode, d.nama organisasi_nama, c.nama pegawai_nama, c.jabatan pegawai_jabatan, e.nama up_posisi_tipe");
        return $this->db->get()->row();
    }
    function get_uk_lead($uuid, $ukTipe = 2)
    {
        $this->db->from("ars_tr_uk a");
        $this->db->join("ars_tr_uk_employee b", "a.uuid = b.uk_uuid", "INNER JOIN");
        $this->db->join("data_pegawai c", "b.employee_nip = c.nip", "INNER JOIN");
        $this->db->join("ars_tr_organisasi d", "a.organization_kode = d.kode", "INNER JOIN");
        $this->db->join("ars_tr_posisi_tipe e", "b.posisi_type = e.kode", "INNER JOIN");

        $this->db->where("a.uuid", $uuid);
        $this->db->where("b.posisi_type", "01");
        $this->db->where("a.type", $ukTipe);
        $this->db->select("a.uuid uk_uuid, a.parent_uuid uk_tujuan_uuid, a.type uk_tipe, b.uuid uk_employee_uuid, c.nip pegawai_nip, d.kode organisasi_kode, d.nama organisasi_nama, c.nama pegawai_nama, c.jabatan pegawai_jabatan, e.nama up_posisi_tipe");
        return $this->db->get()->row();
    }

    function hapus_pemindahan()
    {
        $id = $this->input->post("id");
        $this->db->where("id", $id);
        return $this->db->delete("ars_trx_pemindahan");
    }


    /*======= UNIT KEARSIPAN =========----------------------------------------------------------------------------*/
    function getData_unitKearsipan()
    {
        $this->_getData_unitKearsipan();
        if ($this->m_reff->san($this->input->post("length") != -1))
            $this->db->limit($this->m_reff->san($this->input->post("length")), $this->m_reff->san($this->input->post("start")));
        return $this->db->get()->result();
    }
    function _getData_unitKearsipan()
    {

        if (strlen(isset($_POST['search']['value']) ? ($_POST['search']['value']) : null) >= 1) {
            $searchkey = $_POST['search']['value'];
            $searchkey = $this->m_reff->sanitize($searchkey);
            $query = array(

                "description" => $searchkey,

            );
            $this->db->group_start()
                ->or_like($query)
                ->group_end();
        }
        $query = $this->db->from("ars_tr_uk");
        return $query;
    }

    public function count_unitKearsipan()
    {
        $this->_getData_unitKearsipan();
        return $this->db->get()->num_rows();
    }

    function update_unit_kearsipan()
    {
        $id = $this->input->post("id");
        $form = $this->input->post("f");
        $type = $this->input->post("f[type]");
        $this->db->set($form);
        if ($id) {
            $get = $this->db->get_where("ars_tr_uk", array("id" => $id))->row();
            $type_b = $get->type ?? '';
            $cek = $this->db->get_where("ars_tr_uk", array("type!=" => $type_b, "type" => $type))->num_rows();
            if ($cek) {
                $var["gagal"] = true;
                $var["info"] = "Unit Kearsipan I sudah ada";
                $var["token"] = $this->m_reff->getToken();
                return $var;
            }
            $this->db->set("_uid", $this->session->userdata("nip"));
            $this->db->set("_utime", date('Y-m-d H:i:s'));
            $this->db->where("id", $id);
            $this->db->update("ars_tr_uk");
            $this->m_reff->log("update data unit kearsipan");
        } else {
            if ($type == 1) {
                $cek = $this->db->get_where("ars_tr_uk", array("type" => 1))->num_rows();
                if ($type) {
                    $var["gagal"] = true;
                    $var["info"] = "Unit Kearsipan I sudah ada";
                    $var["token"] = $this->m_reff->getToken();
                    return $var;
                }
            }
            $this->db->set('status', 1);
            $this->db->set("_cid", $this->session->userdata("nip"));
            $this->db->set("_ctime", date('Y-m-d H:i:s'));
            $this->db->insert("ars_tr_uk");
            $this->m_reff->log("menambahkan data unit kearsipan");
        }
        return true;
    }

    function hapus_unit_kearsipan()
    {
        $id = $this->input->post("id");
        $this->db->where("id", $id);
        return $this->db->delete("ars_tr_uk");
    }


    /*======= UNIT PENGELOLA =========----------------------------------------------------------------------------*/
    function getData_unitPengelola()
    {
        $this->_getData_unitPengelola();
        if ($this->m_reff->san($this->input->post("length") != -1))
            $this->db->limit($this->m_reff->san($this->input->post("length")), $this->m_reff->san($this->input->post("start")));
        return $this->db->get()->result();
    }
    function _getData_unitPengelola()
    {

        if (strlen(isset($_POST['search']['value']) ? ($_POST['search']['value']) : null) >= 1) {
            $searchkey = $_POST['search']['value'];
            $searchkey = $this->m_reff->sanitize($searchkey);
            $query = array(

                "description" => $searchkey,

            );
            $this->db->group_start()
                ->or_like($query)
                ->group_end();
        }
        $query = $this->db->from("ars_tr_up");
        return $query;
    }

    public function count_unitPengelola()
    {
        $this->_getData_unitPengelola();
        return $this->db->get()->num_rows();
    }

    function update_unit_pengelola()
    {
        $id = $this->input->post("id");
        $form = $this->input->post("f");
        $type = $this->input->post("f[type]");
        $this->db->set($form);
        if ($id) {
            // $get=$this->db->get_where("ars_tr_up",array("id"=>$id))->row();
            // $type_b=$get->type??'';
            // $cek=$this->db->get_where("ars_tr_up",array("type!="=>$type_b,"type"=>$type))->num_rows();
            // if($cek){
            //     $var["gagal"]=true;
            //     $var["info"]="Unit Kearsipan I sudah ada";
            //     $var["token"]=$this->m_reff->getToken();
            //     return $var;
            // }
            $this->db->set("_uid", $this->session->userdata("nip"));
            $this->db->set("_utime", date('Y-m-d H:i:s'));
            $this->db->where("id", $id);
            $this->db->update("ars_tr_up");
            $this->m_reff->log("update data unit kearsipan");
        } else {
            // if($type==1){
            //     $cek=$this->db->get_where("ars_tr_up",array("type"=>1))->num_rows();
            //     if($type){
            //         $var["gagal"]=true;
            //         $var["info"]="Unit Kearsipan I sudah ada";
            //         $var["token"]=$this->m_reff->getToken();
            //         return $var;
            //     }
            // }
            $this->db->set('status', 1);
            $this->db->set("_cid", $this->session->userdata("nip"));
            $this->db->set("_ctime", date('Y-m-d H:i:s'));
            $this->db->insert("ars_tr_up");
            $this->m_reff->log("menambahkan data unit kearsipan");
        }
        return true;
    }

    function hapus_unit_pengelola()
    {
        $id = $this->input->post("id");
        $this->db->where("id", $id);
        return $this->db->delete("ars_tr_up");
    }
}
