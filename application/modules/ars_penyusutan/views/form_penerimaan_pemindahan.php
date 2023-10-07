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
                                <a class="nav-link accept-process" style="display:none" data-bs-toggle="tab" href="#tabCont1" id="navCont1">List Pemindahan Arsip</a>
                                <a class="nav-link accepted" data-bs-toggle="tab" href="#tabCont2">Arsip Diterima</a>
                                <a class="nav-link accept-process" style="display:none" data-bs-toggle="tab" href="#tabCont3">Arsip Direvisi</a>
                            </nav>
                        </div>
                        <div class="card-body tab-content">
                            <div class="tab-pane" id="tabCont1">
                                <table id='tablePemindahan' width="100%" class="tabel black table-striped table-bordered table-hover dataTable">
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
                                                <button class="btn btn-success pd-x-30 mg-r-5 mg-t-5" id="btnProsesTerima" data-toggle="tooltip" data-placement="top" title="Approve" type="button" onclick="processchecked(1)"><i class="fa fa-check text-white"></i> Terima</button>
                                                <button class="btn btn-danger pd-x-30 mg-r-5 mg-t-5" id="btnProsesTolak" data-toggle="tooltip" data-placement="top" title="Approve" type="button" onclick="processchecked(0)"><i class="fas fa-times text-white"></i> Permintaan Revisi</button>
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="tab-pane" id="tabCont2">
                                <table id='tableDiterima' width="100%" class="tabel black table-striped table-bordered table-hover dataTable">
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
                                    <tfoot style="display: none;" id="btnHBatalTerima">
                                        <tr>
                                            <th colspan="8" class="pt-0" style="text-align: left !important;">
                                                <button class="btn btn-danger pd-x-30 mg-r-5 mg-t-5" data-toggle="tooltip" data-placement="top" title="Approve" type="button" onclick="cancelacceptchecked()"><i class="fas fa-times text-white"></i> Batal Penerimaan</button>
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="tab-pane" id="tabCont3">
                                <table id='tableDitolak' width="100%" class="tabel black table-striped table-bordered table-hover dataTable">
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
                                    <tfoot style="display: none;" id="btnHBatalTolak">
                                        <tr>
                                            <th colspan="8" class="pt-0" style="text-align: left !important;">
                                                <button class="btn btn-danger pd-x-30 mg-r-5 mg-t-5" data-toggle="tooltip" data-placement="top" title="Approve" type="button" onclick="cancelrejectchecked()"><i class="fas fa-times text-white"></i> Batal Permintaan Revisi</button>
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
                            <input class="form-control text-black" name="status" id="status" type="hidden" value="<?= isset($dataPemindahan) && $dataPemindahan != null ? $dataPemindahan->status : null ?>">
                            <input class="form-control text-black" name="status_form" id="status_form" type="hidden" value="<?= isset($status_form) && $status_form != null ? $status_form : null ?>">
                            <input class="form-control text-black" name="isrev" id="isrev" type="hidden" value="<?= isset($dataPemindahan) && $dataPemindahan != null ? $dataPemindahan->isrev : null ?>">
                            <input class="form-control text-black" name="uuid" id="uuid" type="hidden" value="<?= isset($dataPemindahan) && $dataPemindahan != null ? $dataPemindahan->uuid : null ?>">
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
                    <hr class="mb-4">
                    <h5>Informasi Tambahan</h5>
                    <textarea class="form-control" name="info_tambahan" id="info_tambahan" cols="30" rows="10" placeholder="Informasi Tambahan..."><?= isset($dataPemindahan) && $dataPemindahan != null ? $dataPemindahan->info_tambahan : null ?></textarea>
                    <div id="uploadBA" style="display: none;">
                        <hr class="mb-4">
                        <h5>Upload BA</h5>
                        <input type="file" class="form-control" name="upload_ba" id="upload_ba" accept=".pdf" placeholder="Upload BA...">
                    </div>
                    <div id="uploadBATeks" style="display: block;">
                        <hr class="mb-4">
                        <h5>Upload BA</h5>
                        <a class="btn btn-info" role="button" href="<?= isset($dataPemindahan) && $dataPemindahan != null ? (base_url() . '/' . $dataPemindahan->ba_file_path) : 'javascript:void(0);' ?>"><i class="fa fa-download"></i> Download File BA<a>
                    </div>
                </div>
            </div>
            <hr>
            <div align="right">
                <a href="<?= base_url(); ?>ars_penyusutan/pemindahan" role="button" id="btnKembali" class="btn btn-default menuclick pd-x-30 mg-r-5 mg-t-5"><i class='fa fa-arrow-left'></i> Kembali</a>
                <button type="button" role="button" style="display:none;" id="btnBatal" class="btn btn-info pd-x-30 mg-r-5 mg-t-5" onclick="savechanges(3)"><i class='fa fa-save'></i> Simpan Perubahan</button>
                <button type="button" role="button" style="display:none;" id="btnReqApprove" class="btn btn-success pd-x-30 mg-r-5 mg-t-5" onclick="savechanges(4)"><i class='fa fa-arrow-right'></i> Permintaan Approval</button>
                <button type="button" role="button" style="display:none;" id="btnRevision" class="btn btn-info pd-x-30 mg-r-5 mg-t-5" onclick="savechanges(4, 1)"><i class='fa fa-undo'></i> Permintaan Revisi</button>
                <button type="button" role="button" style="display:none;" id="btnApprove" class="btn btn-success pd-x-30 mg-r-5 mg-t-5" onclick="savechanges(5)"><i class='fa fa-check'></i> Approve Penerimaan</button>
                <button type="button" role="button" style="display:none;" id="btnUploadBA" class="btn btn-success pd-x-30 mg-r-5 mg-t-5" onclick="savechanges(6)"><i class='fa fa-upload'></i> Upload BA</button>
            </div>
            <div id="checked-process">
            </div>
            <div id="checked-cancel-accept">
            </div>
            <div id="checked-cancel-reject">
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    $(function() {
        var status = parseInt($("#status").val() != null && $("#status").val() != "" ? $("#status").val() : 0);
        var isrev = parseInt($("#isrev").val() != null && $("#isrev").val() != "" ? $("#isrev").val() : 0);
        var status_form = parseInt($("#status_form").val() != null && $("#status_form").val() != "" ? $("#status_form").val() : 0);
        if (status_form == 3) {
            $(".accept-process").show();
            $("#navCont1").addClass("active");
            $("#tabCont1").addClass("active");
        } else {
            $("#navCont2").addClass("active");
            $("#tabCont2").addClass("active");
            $("#info_tambahan").attr("readonly", true);
        }

        if (status_form == 3) {
            $('#btnHProses').show();
            $('#btnHBatal').show();
            $('#btnHBatalTerima').show();
            $('#btnHBatalTolak').show();

            $('#btnBatal').show();
            $('#btnReqApprove').show();
        } else if (status_form == 4) {
            $('#btnRevision').show();
            $('#btnApprove').show();
        } else if (status_form == 5) {
            $('#btnUploadBA').show();
            $('#uploadBA').show();
        }
        reload_datatable();
    });

    function reload_datatable() {
        dataTable.ajax.reload(null, false);
        dataTable2.ajax.reload(null, false);
        dataTable3.ajax.reload(null, false);
    }
</script>
<script type="text/javascript">
    function savechanges(status = 0, isrev = 0) {
        var error = "";
        if (!(status == 3 && isrev == 0)) {
            if ($('.checkItem1').length > 0) {
                error = "Masih ada data yang belum terima!";
            } else if ($('.checkItem2').length == 0) {
                error = "Tidak ada data yang terima!";
            } else if ($('.checkItem3').length > 0) {
                error = "Masih ada data yang direvisi!";
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
        var msg = "";
        if (isrev == 1) {
            msg = "Apakah anda yakin akan melakukan permintaan revisi?";
        } else {
            if (status == 4) {
                msg = "Apakah anda yakin akan melakukan permintaan Approval Penerimaan Pemindahan Arsip?";
            } else if (status == 5) {
                msg = "Apakah anda yakin akan melakukan Approval Penerimaan Pemindahan Arsip?";
            } else {
                msg = "Apakah anda yakin akan menyimpan data ini?";
            }
        }
        swal({
            title: "Apakah anda yakin?",
            text: msg,
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
                form.append("info_tambahan", $("#info_tambahan").val())
                form.append("upload_ba", $("#upload_ba")[0].files[0])
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
    function processchecked(isAccept = 1) {
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
            text: (isAccept == 1 ? "Menerima" : "Request revisi") + " untuk arsip yang telah dipilih?",
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
                form.append("status", isAccept == 1 ? 2 : 3)
                form.append("checkedAll", $('#checkAll1').is(":checked") ? 1 : 0);
                form.append("<?php echo $this->m_reff->tokenName() ?>", "<?php echo $this->m_reff->getToken() ?>");
                $("#checked-process").find("input").each(function() {
                    form.append("checkedItem[]", $(this).val());
                });
                $.ajax({
                    url: "<?php echo base_url() ?>ars_penyusutan/penerimaan_pemindahan_proses",
                    type: "POST",
                    data: form,
                    dataType: 'JSON',
                    contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
                    processData: false, // NEEDED, DON'T OMIT THIS
                    success: function(res) {
                        $("#modal-loading-proses").modal("hide");
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
                        $("#checkAll3").prop("checked", false);
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
        if ($("#status_form").val() != 3) {
            $('#checkAll1').parents("th").hide();
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
    function cancelacceptchecked() {
        if (!$('#checkAll2').is(":checked") && $("#checked-cancel-accept").find("input").length == 0) {
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
            text: "Membatalkan penerimaan arsip yang telah dipilih?",
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
                form.append("status", 1)
                form.append("statusBefore", 2)
                form.append("checkedAll", $('#checkAll2').is(":checked") ? 1 : 0);
                form.append("<?php echo $this->m_reff->tokenName() ?>", "<?php echo $this->m_reff->getToken() ?>");
                $("#checked-cancel-accept").find("input").each(function() {
                    form.append("checkedItem[]", $(this).val());
                });
                $.ajax({
                    url: "<?php echo base_url() ?>ars_penyusutan/penerimaan_pemindahan_cancel",
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
                        $("#checkAll3").prop("checked", false);
                        $("#checked-cancel-accept").html("");
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
            if ($("#checked-cancel-accept").find("#checked-cancel-accept-" + val).length == 0) {
                $("#checked-cancel-accept").append(`<input type="hidden" id="checked-cancel-accept-${val}" value="${checkItem2.val()}">`);
            }
        } else {
            $(`#checked-cancel-accept-${val}`).remove();
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
        if ($("#status_form").val() != 3) {
            $('#checkAll2').parents("th").hide();
            $('.checkItem2').each(function() {
                $(this).parents('td').hide();
            })
        } else {
            if ($('#checkAll2').is(":checked") == true) {
                checkAll2();
            } else {
                $("#checked-cancel-accept").find("input").each(function() {
                    $("#checkItem2_" + $(this).val()).prop("checked", true);
                });
            }
        }
    }
    $('#checkAll2').click(function() {
        checkAll2();
        $("#checked-cancel-accept").html("");
    });
</script>

<script type="text/javascript">
    function cancelrejectchecked() {
        if (!$('#checkAll3').is(":checked") && $("#checked-cancel-reject").find("input").length == 0) {
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
            text: "Membatalkan permintaan revisi arsip yang telah dipilih?",
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
                form.append("status", 1)
                form.append("statusBefore", 3)
                form.append("checkedAll", $('#checkAll3').is(":checked") ? 1 : 0);
                form.append("<?php echo $this->m_reff->tokenName() ?>", "<?php echo $this->m_reff->getToken() ?>");
                $("#checked-cancel-reject").find("input").each(function() {
                    form.append("checkedItem[]", $(this).val());
                });
                $.ajax({
                    url: "<?php echo base_url() ?>ars_penyusutan/penerimaan_pemindahan_cancel",
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
                        $("#checkAll3").prop("checked", false);
                        $("#checked-cancel-reject").html("");
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

    function checkItem3(val) {
        var checkItem3 = $('#checkItem3_' + val);
        if (checkItem3.is(":checked") == true && $('#checkAll3').is(":checked") == false) {
            if ($("#checked-cancel-reject").find("#checked-cancel-reject-" + val).length == 0) {
                $("#checked-cancel-reject").append(`<input type="hidden" id="checked-cancel-reject-${val}" value="${checkItem3.val()}">`);
            }
        } else {
            $(`#checked-cancel-reject-${val}`).remove();
        }
    }

    function checkAll3() {
        if ($('#checkAll3').is(":checked") == true) {
            $('.checkItem3').each(function() {
                if (!$(this).is(':checked')) {
                    $(this).click();
                }
                $(this).attr("disabled", true);
            });
        } else {
            $('.checkItem3').each(function() {
                $(this).removeAttr("disabled");
                if ($(this).is(':checked')) {
                    $(this).click();
                }
            });
        }
    }

    function initialize_table3() {
        if ($("#status_form").val() != 3) {
            $('#checkAll3').parents("th").hide();
            $('.checkItem3').each(function() {
                $(this).parents('td').hide();
            })
        } else {
            if ($('#checkAll3').is(":checked") == true) {
                checkAll3();
            } else {
                $("#checked-cancel-reject").find("input").each(function() {
                    $("#checkItem3_" + $(this).val()).prop("checked", true);
                });
            }
        }
    }
    $('#checkAll3').click(function() {
        checkAll3();
        $("#checked-cancel-reject").html("");
    });
</script>


<script type="text/javascript">
    var dataTable = $('#tablePemindahan').DataTable({
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
            "url": "<?php echo site_url('ars_penyusutan/getList_penerimaan_arsip'); ?>",
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
                initialize_table1();
                unblock('area_lod');
            },
        },
        "columnDefs": [{
            "targets": [0],
            "visible": true,
        }, ],
    });


    var dataTable2 = $('#tableDiterima').DataTable({
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
            "url": "<?php echo site_url('ars_penyusutan/getList_penerimaan_arsip_diterima'); ?>",
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

    var dataTable3 = $('#tableDitolak').DataTable({
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
                    dataTable3.ajax.reload(null, false);
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
            "url": "<?php echo site_url('ars_penyusutan/getList_penerimaan_arsip_revisi'); ?>",
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
                initialize_table3();
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