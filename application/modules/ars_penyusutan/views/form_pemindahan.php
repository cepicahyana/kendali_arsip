<?php
$id = $this->m_reff->san($this->input->post("id"));
?>
<style>
    table.dataTable>thead .sorting:before,
    table.dataTable>thead .sorting:after {
        display: none !important;
    }

    .swal-modal .swal-text {
        text-align: center;
    }
</style>
<div class="card">
    <div class="modal" id="modal-loading-proses" tabindex="-1" role="dialog" style="background-color: rgba(0,0,0,0.1);" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog mt-5" role="document">
            <center>
                <div style="height:100%">
                    <div class="btn btn-dark" disabled="disabled"> <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sedang dalam proses. Mohon tunggu beberapa saat... </div>
                </div>
            </center>
        </div>
    </div>
    <div class="row card-body" style='padding-top:10px;padding-bottom:20px'>
        <form method="post" enctype="multipart/form-data">
            <input type="hidden" value="<?php echo $id ?>" name="id">
            <input type="hidden" id="formToken" name="<?php echo $this->m_reff->tokenName() ?>" value="<?php echo $this->m_reff->getToken() ?>">
            <div class="row">
                <div class="col-xl-8 col-lg-12" id="area_lod">
                    <h5>Arsip yang Dipindahkan</h5>
                    <hr class="mt-1">
                    <div class="border">
                        <div class="bg-gray-200 nav-bg">
                            <nav class="nav nav-tabs">
                                <a class="nav-link active" data-bs-toggle="tab" href="#tabCont1">Arsip Usul Pindah</a>
                                <a class="nav-link" data-bs-toggle="tab" href="#tabCont2">Arsip yang akan Dipindahkan</a>
                            </nav>
                        </div>
                        <div class="card-body tab-content">
                            <div class="tab-pane active" id="tabCont1">
                                <table id='tableSelectItemArsip' width="100%" class="tabel black table-striped table-bordered table-hover dataTable">
                                    <thead>
                                        <tr>
                                            <th class='thead text-center' width='15px'><input type='checkbox' id='checkAll1'></th>
                                            <th class='thead' width='15px'>No</th>
                                            <th class='thread'>Klasifikasi Arsip</th>
                                            <th class='thread'>Jenis/Series Arsip</th>
                                            <th class='thread text-center'>Kurun Waktu</th>
                                            <th class='thread text-center'>Tingkat Perkembangan</th>
                                            <th class='thread text-center'>Jumlah</th>
                                            <th class='thread'>Ket</th>
                                        </tr>
                                    </thead>
                                    <tfoot style="display: none;" id="btnHProses">
                                        <tr>
                                            <th colspan="8" class="pt-0" style="text-align: left !important;">
                                                <button class="btn btn-success pd-x-30 mg-r-5 mg-t-5" data-toggle="tooltip" data-placement="top" title="Approve" type="button" onclick="proseschecked()"><i class="fa fa-arrow-right text-white"></i> Proses</button>
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="tab-pane" id="tabCont2">
                                <table id='tableItemArsip' width="100%" class="tabel black table-striped table-bordered table-hover dataTable">
                                    <thead>
                                        <tr>
                                            <th class='thead text-center' width='15px'><input type='checkbox' id='checkAll2'></th>
                                            <th class='thead' width='15px'>No</th>
                                            <th class='thread'>Klasifikasi Arsip</th>
                                            <th class='thread'>Jenis/Series Arsip</th>
                                            <th class='thread text-center'>Kurun Waktu</th>
                                            <th class='thread text-center'>Tingkat Perkembangan</th>
                                            <th class='thread text-center'>Jumlah</th>
                                            <th class='thread'>Ket</th>
                                        </tr>
                                    </thead>
                                    <tfoot style="display: none;" id="btnHBatal">
                                        <tr>
                                            <th colspan="8" class="pt-0" style="text-align: left !important;">
                                                <button class="btn btn-danger pd-x-30 mg-r-5 mg-t-5" data-toggle="tooltip" data-placement="top" title="Approve" type="button" onclick="cancelchecked()"><i class="fas fa-times text-white"></i> Batal</button>
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-12">
                    <h5>Informasi Pemindahan</h5>
                    <hr class="mt-1">
                    <div class="row row-xs mg-b-20 align-items-center">
                        <div class="col-md-5">
                            <label class="form-label mg-b-0 text-black">Tanggal Pemindahan </label>
                        </div>
                        <div class="col-md-7 mg-t-5 mg-md-t-0">
                            <label class="form-label mg-b-0 text-black" id="tanggal_teks"><?= isset($dataPemindahan) && $dataPemindahan != null ? $dataPemindahan->tanggal_teks : null ?></label>
                            <input class="form-control text-black" name="tanggal" id="tanggal" placeholder="Tanggal Pemindahan..." type="date" value="<?= isset($dataPemindahan) && $dataPemindahan != null ? $dataPemindahan->tanggal : null ?>">

                            <input class="form-control text-black" name="status" id="status" type="hidden" value="<?= isset($dataPemindahan) && $dataPemindahan != null ? $dataPemindahan->status : null ?>">
                            <input class="form-control text-black" name="status_form" id="status_form" type="hidden" value="<?= isset($status_form) && $status_form != null ? $status_form : null ?>">
                            <input class="form-control text-black" name="isrev" id="isrev" type="hidden" value="<?= isset($dataPemindahan) && $dataPemindahan != null ? $dataPemindahan->isrev : null ?>">
                            <input class="form-control text-black" name="uuid" id="uuid" type="hidden" value="<?= isset($dataPemindahan) && $dataPemindahan != null ? $dataPemindahan->uuid : null ?>">
                            <input class="form-control text-black" name="pemberkasan_tipe" id="pemberkasan_tipe" type="hidden" value="<?= isset($pemberkasanTipe) && $pemberkasanTipe != null ? $pemberkasanTipe : null ?>">
                            <input class="form-control text-black" name="dari_organisasi_kode" id="dari_organisasi_kode" type="hidden" value="<?= isset($ttdDari) && $ttdDari != null ? $ttdDari->organisasi_kode : null ?>">
                            <input class="form-control text-black" name="dari_penandatangan_nama" id="dari_penandatangan_nama" type="hidden" value="<?= isset($ttdDari) && $ttdDari != null ? $ttdDari->pegawai_nama : null ?>">
                            <input class="form-control text-black" name="dari_penandatangan_jabatan" id="dari_penandatangan_jabatan" type="hidden" value="<?= isset($ttdDari) && $ttdDari != null ? $ttdDari->pegawai_jabatan : null ?>">
                            <input class="form-control text-black" name="tujuan_organisasi_kode" id="tujuan_organisasi_kode" type="hidden" value="<?= isset($ttdTujuan) && $ttdTujuan != null ? $ttdTujuan->organisasi_kode : null ?>">
                            <input class="form-control text-black" name="tujuan_penandatangan_nama" id="tujuan_penandatangan_nama" type="hidden" value="<?= isset($ttdTujuan) && $ttdTujuan != null ? $ttdTujuan->pegawai_nama : null ?>">
                            <input class="form-control text-black" name="tujuan_penandatangan_jabatan" id="tujuan_penandatangan_jabatan" type="hidden" value="<?= isset($ttdTujuan) && $ttdTujuan != null ? $ttdTujuan->pegawai_jabatan : null ?>">
                        </div>
                    </div>
                    <div class="row row-xs align-items-center mg-b-20">
                        <div class="col-md-5">
                            <label class="form-label mg-b-0 text-black">Tujuan Pemindahan </label>
                        </div>
                        <div class="col-md-7">
                            <label class="form-label mg-b-0 text-black" id="text_uk_tipe"><?= isset($ttdTujuan) && $ttdTujuan != null ? "UK" . $ttdTujuan->uk_tipe : null ?></label>
                        </div>
                    </div>
                    <div class="row row-xs align-items-center mg-b-20">
                        <div class="col-md-5">
                            <label class="form-label mg-b-0 text-black">Penandatangan Sumber </label>
                        </div>
                        <div class="col-md-7">
                            <label class="form-label mg-b-0 text-black" id="text_dari"><?= isset($ttdDari) && $ttdDari != null ? $ttdDari->pegawai_nama : null ?></label>
                        </div>
                    </div>
                    <div class="row row-xs align-items-center mg-b-20">
                        <div class="col-md-5">
                            <label class="form-label mg-b-0 text-black">Penandatangan Penerima </label>
                        </div>
                        <div class="col-md-7">
                            <label class="form-label mg-b-0 text-black" id="text_tujuan"><?= isset($ttdTujuan) && $ttdTujuan != null ? $ttdTujuan->pegawai_nama : null ?></label>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div align="right">
                <a href="<?= base_url(); ?>ars_penyusutan/pemindahan" role="button" id="btnKembali" class="btn btn-default menuclick pd-x-30 mg-r-5 mg-t-5"><i class='fa fa-arrow-left'></i> Kembali</a>
                <button type="button" role="button" style="display:none;" id="btnBatal" class="btn btn-danger pd-x-30 mg-r-5 mg-t-5" onclick=""><i class='fa fa-trash-alt'></i> Batalkan Pemindahan</button>
                <button type="button" role="button" style="display:none;" id="btnSave" class="btn btn-primary pd-x-30 mg-r-5 mg-t-5" onclick="savechanges(1)"><i class='fa fa-save'></i> Simpan Draft</button>
                <button type="button" role="button" style="display:none;" id="btnReqApprove" class="btn btn-success pd-x-30 mg-r-5 mg-t-5" onclick="savechanges(2)"><i class='fa fa-arrow-right'></i> Permintaan Approval</button>
                <button type="button" role="button" style="display:none;" id="btnRevision" class="btn btn-info pd-x-30 mg-r-5 mg-t-5" onclick="savechanges(2, 1)"><i class='fa fa-undo'></i> Permintaan Revisi</button>
                <button type="button" role="button" style="display:none;" id="btnApprove" class="btn btn-success pd-x-30 mg-r-5 mg-t-5" onclick="savechanges(3)"><i class='fa fa-check'></i> Approve Pengiriman</button>
            </div>
            <div id="checked-process">
            </div>
            <div id="checked-cancel">
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    $(function() {
        var status_form = parseInt($("#status_form").val() != null && $("#status_form").val() != "" ? $("#status_form").val() : 0);
        if(status_form != 1){
            $("#tanggal").remove();
            if($("#tanggal_teks").text() == "") $("#tanggal_teks").text("-");
        }else{
            $("#tanggal_teks").remove();
        }

        if (status_form == 1) {
            $('#btnHProses').show();
            $('#btnHBatal').show();
            $('#btnSave').show();
            $('#btnReqApprove').show();
        } else if (status_form == 2) {
            $('#btnRevision').show();
            $('#btnReturnDraft').show();
            $('#btnApprove').show();
        } else if (!status_form && status_form != 0) {
            $('#btnBatal').show();
        }
        reload_datatable();
    });

    function reload_datatable() {
        dataTable.ajax.reload(null, false);
        dataTable2.ajax.reload(null, false);
    }
</script>
<script type="text/javascript">
    function savechanges(status = 1, isrev = 0) {
        var error = "";
        if ($('.checkItem2').length == 0) {
            error = "Tidak ada data yang dipilih!";
        } else if ($("#tanggal").val() == null || $("#tanggal").val() == '') {
            if($("#status_form").val() == 1){
                error = "Tanggal Pemindahan harus diisi!";
            }
        }
        if (error != null && error != "") {
            swal({
                text: error,
                icon: "warning",
                className: "text-center",
                buttons: {
                    confirm: {
                        text: 'Kembali',
                        className: "btn btn-warning"
                    }
                }
            });
            return;
        }
        swal({
            title: "Apakah anda yakin?",
            text: (isrev == 1 ? "Apakah anda yakin akan melakukan permintaan revisi?" : (status == 1 ? "Apakah anda yakin akan menyimpan data ini?" : "Apakah anda yakin akan melakukan permintaan Approval Pengiriman Pemindahan Arsip?")),
            className: "text-center",
            type: 'info',
            icon: "info",
            buttons: {
                cancel: {
                    visible: true,
                    text: 'Batal',
                    className: 'btn btn-danger'
                },
                confirm: {
                    text: 'Yakin',
                    className: 'btn btn-success'
                }
            }
        }).then((a) => {
            if (a) {
                var form = new FormData();
                if (status != 1) {
                    form.append("status", status)
                }
                form.append("isrev", isrev)
                form.append("uuid", $("#uuid").val())
                if($("status_form") == 1) form.append("tanggal", $("#tanggal").val())
                form.append("pemberkasan_tipe", $("#pemberkasan_tipe").val());
                form.append("dari_organisasi_kode", $("#dari_organisasi_kode").val());
                form.append("dari_penandatangan_nama", $("#dari_penandatangan_nama").val());
                form.append("dari_penandatangan_jabatan", $("#dari_penandatangan_jabatan").val());
                form.append("tujuan_organisasi_kode", $("#tujuan_organisasi_kode").val());
                form.append("tujuan_penandatangan_nama", $("#tujuan_penandatangan_nama").val());
                form.append("tujuan_penandatangan_jabatan", $("#tujuan_penandatangan_jabatan").val());
                form.append("<?php echo $this->m_reff->tokenName() ?>", "<?php echo $this->m_reff->getToken() ?>");
                $.ajax({
                    url: "<?php echo base_url() ?>ars_penyusutan/pemindahan_simpan",
                    type: "POST",
                    data: form,
                    dataType: 'JSON',
                    contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
                    processData: false, // NEEDED, DON'T OMIT THIS
                    success: function(res) {
                        swal({
                            title: parseInt(res.status) == 0 ? "Gagal!" : "Berhasil!",
                            text: res.message,
                            icon: parseInt(res.status) == 0 ? "error" : "success",
                            buttons: {
                                confirm: {
                                    text: 'Kembali',
                                    className: "btn " + (parseInt(res.status) == 0 ? "btn-danger" : "btn-success")
                                }
                            }
                        }).then((a) => {
                            if (a) {
                                if (parseInt(res.status) != 0) {
                                    $("#btnKembali").click();
                                }
                            }
                        });
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        swal({
                            title: "Gagal!",
                            text: "Error!",
                            icon: "danger",
                            buttons: {
                                confirm: {
                                    text: 'Tutup',
                                    className: 'btn btn-default'
                                }
                            }
                        });
                    }
                });
            }
        });
    }
</script>
<script type="text/javascript">
    function proseschecked() {
        if (!$('#checkAll1').is(":checked") && $("#checked-process").find("input").length == 0) {
            swal({
                text: "Tidak ada data yang dipilih!",
                icon: "warning",
                className: "text-center",
                buttons: {
                    confirm: {
                        text: 'Kembali',
                        className: "btn btn-warning"
                    }
                }
            });
            return;
        }

        swal({
            // title: "Apakah anda yakin akan memproses data yang telah di pilih?",
            title: "Apakah anda yakin?",
            text: "Menambahkan arsip yang telah dipilih ke daftar arsip yang akan dipindahkan?",
            className: "text-center",
            type: 'info',
            icon: "info",
            buttons: {
                cancel: {
                    visible: true,
                    text: 'Batal',
                    className: 'btn btn-danger'
                },
                confirm: {
                    text: 'Yakin',
                    className: 'btn btn-success'
                }
            }
        }).then((a) => {
            if (a) {
                $("#modal-loading-proses").modal("show");
                var form = new FormData();
                form.append("uuid", $("#uuid").val())
                form.append("tanggal", $("#tanggal").val())
                form.append("checkedAll", $('#checkAll1').is(":checked") ? 1 : 0);
                form.append("pemberkasan_tipe", $("#pemberkasan_tipe").val());
                form.append("dari_organisasi_kode", $("#dari_organisasi_kode").val());
                form.append("dari_penandatangan_nama", $("#dari_penandatangan_nama").val());
                form.append("dari_penandatangan_jabatan", $("#dari_penandatangan_jabatan").val());
                form.append("tujuan_organisasi_kode", $("#tujuan_organisasi_kode").val());
                form.append("tujuan_penandatangan_nama", $("#tujuan_penandatangan_nama").val());
                form.append("tujuan_penandatangan_jabatan", $("#tujuan_penandatangan_jabatan").val());
                form.append("<?php echo $this->m_reff->tokenName() ?>", "<?php echo $this->m_reff->getToken() ?>");
                $("#checked-process").find("input").each(function() {
                    form.append("checkedItem[]", $(this).val());
                });
                $.ajax({
                    url: "<?php echo base_url() ?>ars_penyusutan/pemindahan_proses",
                    type: "POST",
                    data: form,
                    dataType: 'JSON',
                    contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
                    processData: false, // NEEDED, DON'T OMIT THIS
                    success: function(res) {
                        $("#modal-loading-proses").modal("hide");
                        if (res != null) {
                            if (res.uuid != null && res.uuid != '') {
                                if (res.id != null && res.id != '') {
                                    var url = "<?php echo site_url("ars_penyusutan/form_pemindahan/"); ?>" + res.status + "/" + res.id;
                                    history.replaceState(res.title, res.title, url);
                                }
                                $("#uuid").val(res.uuid);
                            }
                        }
                        swal({
                            title: parseInt(res.status) == 0 ? "Gagal!" : "Berhasil!",
                            text: res.message,
                            icon: parseInt(res.status) == 0 ? "error" : "success",
                            buttons: {
                                confirm: {
                                    text: 'Kembali',
                                    className: "btn " + (parseInt(res.status) == 0 ? "btn-danger" : "btn-success")
                                }
                            }
                        });
                        $("#checkAll1").prop("checked", false);
                        $("#checkAll2").prop("checked", false);
                        $("#checked-process").html("");
                        reload_datatable();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        $("#modal-loading-proses").modal("hide");
                        swal({
                            title: "Gagal!",
                            text: "Error!",
                            icon: "danger",
                            buttons: {
                                confirm: {
                                    text: 'Tutup',
                                    className: 'btn btn-default'
                                }
                            }
                        });
                        console.log(textStatus, errorThrown);
                        reload_datatable();
                    }
                });
            }
        });
    }

    function checkItem1(val) {
        var checkItem1 = $('#checkItem1_' + val);
        if (checkItem1.is(":checked") == true && $('#checkAll1').is(":checked") == false) {
            if ($("#checked-process").find("#checked-process-" + val).length == 0) {
                $("#checked-process").append(`<input type="hidden" id="checked-process-${val}" value="${checkItem1.val()}">`);
            }
        } else {
            $(`#checked-process-${val}`).remove();
        }
    }

    function checkAll1() {
        if ($('#checkAll1').is(":checked") == true) {
            $('.checkItem1').each(function() {
                if (!$(this).is(':checked')) {
                    $(this).click();
                }
                $(this).attr("disabled", true);
            });
        } else {
            $('.checkItem1').each(function() {
                $(this).removeAttr("disabled");
                if ($(this).is(':checked')) {
                    $(this).click();
                }
            });
        }
    }

    function initialize_table1() {
        if ($("#status_form").val() != 1) {
            $('#checkAll1').parents('th').hide();
            $('.checkItem1').each(function() {
                $(this).parents('td').hide();
            })
        } else {
            if ($('#checkAll1').is(":checked") == true) {
                checkAll1();
            } else {
                $("#checked-process").find("input").each(function() {
                    $("#checkItem1_" + $(this).val()).prop("checked", true);
                });
            }
        }

    }
    $('#checkAll1').click(function() {
        checkAll1();
        $("#checked-process").html("");
    });
</script>

<script type="text/javascript">
    function cancelchecked() {
        if (!$('#checkAll2').is(":checked") && $("#checked-cancel").find("input").length == 0) {
            swal({
                text: "Tidak ada data yang dipilih!",
                icon: "warning",
                className: "text-center",
                buttons: {
                    confirm: {
                        text: 'Kembali',
                        className: "btn btn-warning"
                    }
                }
            });
            return;
        }
        swal({
            // title: "Apakah anda yakin akan memproses data yang telah di pilih?",
            title: "Apakah anda yakin?",
            text: "Membatalkan arsip yang telah dipilih dari daftar arsip yang akan dipindahkan?",
            className: "text-center",
            type: 'info',
            icon: "info",
            buttons: {
                cancel: {
                    visible: true,
                    text: 'Batal',
                    className: 'btn btn-danger'
                },
                confirm: {
                    text: 'Yakin',
                    className: 'btn btn-success'
                }
            }
        }).then((a) => {
            if (a) {
                $("#modal-loading-proses").modal("show");
                var form = new FormData();
                form.append("uuid", $("#uuid").val())
                form.append("checkedAll", $('#checkAll2').is(":checked") ? 1 : 0);
                form.append("<?php echo $this->m_reff->tokenName() ?>", "<?php echo $this->m_reff->getToken() ?>");
                $("#checked-cancel").find("input").each(function() {
                    form.append("checkedItem[]", $(this).val());
                });
                $.ajax({
                    url: "<?php echo base_url() ?>ars_penyusutan/pemindahan_cancel",
                    type: "POST",
                    data: form,
                    dataType: 'JSON',
                    contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
                    processData: false, // NEEDED, DON'T OMIT THIS
                    success: function(res) {
                        $("#modal-loading-proses").modal("hide");

                        if (res != null) {
                            if (res.uuid != null && res.uuid != '') {
                                $("#uuid").val(res.uuid);
                            }
                        }

                        swal({
                            title: parseInt(res.status) == 0 ? "Gagal!" : "Berhasil!",
                            text: res.message,
                            icon: parseInt(res.status) == 0 ? "error" : "success",
                            buttons: {
                                confirm: {
                                    text: 'Kembali',
                                    className: "btn " + (parseInt(res.status) == 0 ? "btn-danger" : "btn-success")
                                }
                            }
                        });
                        $("#checkAll1").prop("checked", false);
                        $("#checkAll2").prop("checked", false);
                        $("#checked-cancel").html("");
                        reload_datatable();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        $("#modal-loading-proses").modal("hide");

                        swal({
                            title: "Gagal!",
                            text: "Error! : " + textStatus,
                            icon: "danger",
                            buttons: {
                                confirm: {
                                    text: 'Tutup',
                                    className: 'btn btn-default'
                                }
                            }
                        });
                        console.log(textStatus, errorThrown);
                        reload_datatable();
                    }
                });
            }
        });
    }

    function checkItem2(val) {
        var checkItem2 = $('#checkItem2_' + val);
        if (checkItem2.is(":checked") == true && $('#checkAll2').is(":checked") == false) {
            if ($("#checked-cancel").find("#checked-cancel-" + val).length == 0) {
                $("#checked-cancel").append(`<input type="hidden" id="checked-cancel-${val}" value="${checkItem2.val()}">`);
            }
        } else {
            $(`#checked-cancel-${val}`).remove();
        }
    }

    function checkAll2() {
        if ($('#checkAll2').is(":checked") == true) {
            $('.checkItem2').each(function() {
                if (!$(this).is(':checked')) {
                    $(this).click();
                }
                $(this).attr("disabled", true);
            });
        } else {
            $('.checkItem2').each(function() {
                $(this).removeAttr("disabled");
                if ($(this).is(':checked')) {
                    $(this).click();
                }
            });
        }
    }

    function initialize_table2() {

        if ($("#status_form").val() != 1) {
            $('#checkAll2').parents('th').hide();
            $('.checkItem2').each(function() {
                $(this).parents('td').hide();
            })
        } else {
            if ($('#checkAll2').is(":checked") == true) {
                checkAll2();
            } else {
                $("#checked-cancel").find("input").each(function() {
                    $("#checkItem2_" + $(this).val()).prop("checked", true);
                });
            }
        }
    }
    $('#checkAll2').click(function() {
        checkAll2();
        $("#checked-cancel").html("");
    });
</script>

<script type="text/javascript">
    var dataTable = $('#tableSelectItemArsip').DataTable({
        "paging": true,
        "processing": false,
        "ordering": true,
        "language": {
            "sSearch": "Pencarian",
            "processing": ' <span class="sr-only dataTables_processing">Loading...</span> <br><b style="color:black;background:white">Proses menampilkan data<br> Mohon Menunggu..</b>',
            "oPaginate": {
                "sFirst": "Hal Pertama",
                "sLast": "Hal Terakhir",
                "sNext": "Selanjutnya",
                "sPrevious": "Sebelumnya"
            },
            "sInfo": "Total :  _TOTAL_ , Halaman (_START_ - _END_)",
            "sInfoEmpty": "Tidak ada data yang di tampilkan",
            "sZeroRecords": "Data tidak tersedia",
            "lengthMenu": "&nbsp;&nbsp;Tampil _MENU_ Baris",
        },
        "serverSide": true,
        "responsive": true,
        "searching": true,
        "order": [
            [0, 'desc']
        ],
        "columns": [{
                className: "text-center",
                sortable: false
            },
            {
                className: "text-center",
                sortable: false
            },
            {
                className: "text-center"
            },
            {
                className: "text-center"
            },
            {
                className: "text-center"
            },
            {
                className: "text-center"
            },
            {
                className: "text-center"
            },
            {
                className: "text-center"
            }
        ],
        // "lengthMenu": [
        //     [10, 20, 30, 50],
        //     [10, 20, 30, 50],
        // ],
        dom: 'Blfrtip',
        buttons: [{
                text: '<i class="fe fe-refresh-cw"></i>    ',
                action: function(e, dt, node, config) {
                    dataTable.ajax.reload(null, false);
                },
                className: 'btn  btn-secondary-light'
            },
            {
                extend: 'excel',
                text: '<i class="fe fe-download"></i>',
                exportOptions: {
                    columns: [1, 2, 3, 4, 5, 6, 7]
                },
                className: 'btn  btn-secondary-light'
            },
        ],
        "ajax": {
            "url": "<?php echo site_url('ars_penyusutan/getList_berkas_usul_pindah'); ?>",
            "type": "POST",
            "data": function(data) {
                data.<?php echo $this->m_reff->tokenName() ?> = token;
            },
            beforeSend: function() {
                loading("area_lod");
            },
            complete: function(data) {
                token = data.responseJSON.token;
                initialize_table1();
                unblock('area_lod');
            },
        },
        "columnDefs": [{
            "targets": [0],
            "visible": true,
        }, ],
    });


    var dataTable2 = $('#tableItemArsip').DataTable({
        "paging": true,
        "processing": false,
        "ordering": true,
        "language": {
            "sSearch": "Pencarian",
            "processing": ' <span class="sr-only dataTables_processing">Loading...</span> <br><b style="color:black;background:white">Proses menampilkan data<br> Mohon Menunggu..</b>',
            "oPaginate": {
                "sFirst": "Hal Pertama",
                "sLast": "Hal Terakhir",
                "sNext": "Selanjutnya",
                "sPrevious": "Sebelumnya"
            },
            "sInfo": "Total :  _TOTAL_ , Halaman (_START_ - _END_)",
            "sInfoEmpty": "Tidak ada data yang di tampilkan",
            "sZeroRecords": "Data tidak tersedia",
            "lengthMenu": "&nbsp;&nbsp;Tampil _MENU_ Baris",
        },
        "serverSide": true,
        "responsive": true,
        "searching": true,
        "order": [
            [0, 'desc']
        ],
        "columns": [{
                className: "text-center",
                sortable: false
            },
            {
                className: "text-center",
                sortable: false
            },
            {
                className: "text-center"
            },
            {
                className: "text-center"
            },
            {
                className: "text-center"
            },
            {
                className: "text-center"
            },
            {
                className: "text-center"
            },
            {
                className: "text-center"
            }
        ],

        dom: 'Blfrtip',
        buttons: [{
                text: '<i class="fe fe-refresh-cw"></i>    ',
                action: function(e, dt, node, config) {
                    dataTable2.ajax.reload(null, false);
                },
                className: 'btn  btn-secondary-light'
            },
            {
                extend: 'excel',
                text: '<i class="fe fe-download"></i>',
                exportOptions: {
                    columns: [1, 2, 3, 4, 5, 6, 7]
                },
                className: 'btn  btn-secondary-light'
            },
        ],
        "ajax": {
            "url": "<?php echo site_url('ars_penyusutan/getList_berkas_akan_pindah'); ?>",
            "type": "POST",
            "data": function(data) {
                data.<?php echo $this->m_reff->tokenName() ?> = token;
                data.uuid = $("#uuid").val();
            },
            beforeSend: function() {
                loading("area_lod");
            },
            complete: function(data) {
                token = data.responseJSON.token;
                initialize_table2();
                unblock('area_lod');
            },
        },
        "columnDefs": [{
            "targets": [0],
            "visible": true,
        }, ],
    });
</script>
<div class="modal effect-scale" id="mdl_modal" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content" id="area_modal">
            <div class="modal-header">
                <h6 class="modal-title"> </h6><button type="button" role="button" aria-label="Close" class="btn-close" data-bs-dismiss="modal"><span aria-hidden="true">×</span></button>
            </div>
            <div id="response"></div>
        </div>
    </div>
</div>