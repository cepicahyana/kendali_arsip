    <div class="card">
        <div class="row card-body" style='padding-top:10px;padding-bottom:20px'>
            <div class="col-md-12" id="area_lod">
                <table id='table' width="100%" class="tabel black table-striped table-bordered table-hover dataTable">
                    <thead>
                        <tr>
                            <th class='thead' width='15px'>No</th>
                            <th class='thead'>Nomor Pemusnahan</th>
                            <th class='thead'>Inisiator</th>
                            <th class='thead'>Tanggal Request</th>
                            <th class='thead'>Usul Musnah Tim</th>
                            <th class='thead'>Usul Musnah ANRI</th>
                            <th class='thead'>Status</th>
                            <th class='thead text-center' width='200px'># </th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div class="modal effect-scale" id="mdl_approval" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo" id="area_modal">
                <div class="modal-header">
                    <h6 class="modal-title"> Approve Pemusnahan</h6><button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <label for="">Upload SK Kasetpres yang sudah ditandatangani:</label>
                    <input type="file" class="form-control">
                </div>
                <div class="modal-body">
                    Status Approval
                    <div><input type="radio" name="StatusApproval" class="StatusApproval" value="1" onchange="StatusApproval(this)"> Setuju</div>
                    <div><input type="radio" name="StatusApproval" class="StatusApproval" value="2" onchange="StatusApproval(this)"> Tidak Setuju</div>
                    <textarea class="form-control" name="Alasan" id="Alasan" cols="30" rows="10" placeholder="Alasan" style="display: none;"></textarea>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-xs btn-primary" onclick="$('.modal').modal('hide')">Simpan</button>
                    <button class="btn btn-xs btn-danger" onclick="$('.modal').modal('hide')">Batal</button>
                </div>
                <div id="response"></div>
            </div>
        </div>
    </div>
    <div class="modal effect-scale" id="mdl_pembatalan" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo" id="area_modal">
                <div class="modal-header">
                    <h6 class="modal-title"> Batalkan Pemusnahan</h6><button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    Apakah anda yakin akan membatalkan Pemusnahan arsip ini?
                </div>
                <div class="modal-footer">
                    <button class="btn btn-xs btn-danger" onclick="$('.modal').modal('hide')">Yakin</button>
                    <button class="btn btn-xs btn-default" onclick="$('.modal').modal('hide')">Batal</button>
                </div>
                <div id="response"></div>
            </div>
        </div>
    </div>
    <div class="modal effect-scale" id="mdl_uploadBA" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo" id="area_modal">
                <div class="modal-header">
                    <h6 class="modal-title"> Upload BA</h6><button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <label for="">Upload BA yang sudah ditandatangani:</label>
                    <input type="file" class="form-control">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-xs btn-primary" onclick="$('.modal').modal('hide')">Proses</button>
                    <button class="btn btn-xs btn-danger" onclick="$('.modal').modal('hide')">Batal</button>
                </div>
                <div id="response"></div>
            </div>
        </div>
    </div>


    <script type="text/javascript">
        function StatusApproval(ini) {
            ($(ini).val() == '1') ? $('#Alasan').hide() : $('#Alasan').show()
        }

        function hapus(id, akun) {
            swal({
                title: 'Hapus ?',
                text: akun,
                type: 'warning',
                buttons: {
                    cancel: {
                        visible: true,
                        text: 'batal',
                        className: 'btn btn-danger'
                    },
                    confirm: {
                        text: 'Ya',
                        className: 'btn btn-success'
                    }
                }
            }).then((willDelete) => {
                if (willDelete) {
                    swal("data " + akun + " telah dihapus", {
                        icon: "success",
                        buttons: {
                            confirm: {
                                className: 'btn btn-success'
                            }
                        }
                    });

                    var url = "<?php echo site_url("ars_master/hapus_tingkat_perkambangan"); ?>";
                    var param = {
                        <?php echo $this->m_reff->tokenName() ?>: token,
                        id: id
                    };
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        data: param,
                        url: url,
                        success: function(val) {
                            token = val['token'];
                            reload_table();
                        }
                    });
                }
            });
        };



        var save_method; //for save method string
        var table;
        var dataTable = $('#table').DataTable({
            "paging": true,
            "processing": false,
            "ordering": false,
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
            "responsive": false,
            "searching": true,
            "lengthMenu": [
                [10, 20, 30, 50],
                [10, 20, 30, 50],
            ],
            dom: 'Blfrtip',
            buttons: [{
                    text: '<i class="fe fe-refresh-cw"></i>    ',
                    action: function(e, dt, node, config) {
                        reload_table();
                    },
                    className: 'btn  btn-secondary-light'
                },

                {
                    extend: 'excel',
                    text: '<i class="fe fe-download"></i>',
                    exportOptions: {
                        columns: [0, 1]
                    },
                    className: 'btn  btn-secondary-light'
                },
                {
                    text: '<i class="fe fe-plus"></i> Request Pemusnahan ',
                    action: function(e, dt, node, config) {
                        action_form();
                    },
                    className: 'btn  btn-secondary-light'
                },
            ],

            "ajax": {
                "url": "<?php echo site_url('ars_penyusutan/pemusnahan/getData'); ?>",
                "type": "POST",
                "data": function(data) {
                    data.<?php echo $this->m_reff->tokenName() ?> = token;
                },
                beforeSend: function() {
                    loading("area_lod");
                },
                complete: function(data) {
                    token = data.responseJSON.token;
                    unblock('area_lod');
                },

            },
            "columnDefs": [{
                "targets": [], //last column
                "orderable": false, //set not orderable
            }, ],
        });

        function reload_table() {
            dataTable.ajax.reload(null, false);
        };





        function action_form(id = null) {
            // $("#mdl_modal").modal("show");
            // $("#response").html(cantik());
            // if (id) {
            //     $(".modal-title").html("Update data");
            // } else {
            //     $(".modal-title").html("Tambah data");
            // }
            var url = "<?php echo site_url("ars_penyusutan/pemusnahan/form_pemusnahan"); ?>";
            var param = {
                ajax: "yes",
                <?php echo $this->m_reff->tokenName() ?>: token,
                id: id
            };
            $.ajax({
                type: "POST",
                dataType: "json",
                data: param,
                url: url,
                success: function(data) {
                    token = data["token"];
                    $('.modal.aside').remove();
                    history.replaceState(data["title"], data["title"], url);
                    $('#bread_title').html(data["title"]);
                    $('#bread_subtitle').html(data["subtitle"]);
                    $(".content").html(data["data"]);
                }
            });
        }

        function form_penilaian_tim(id = null) {
            var url = "<?php echo site_url("ars_penyusutan/pemusnahan/form_penilaian_tim"); ?>";
            var param = {
                ajax: "yes",
                <?php echo $this->m_reff->tokenName() ?>: token,
                id: id
            };
            $.ajax({
                type: "POST",
                dataType: "json",
                data: param,
                url: url,
                success: function(data) {
                    token = data["token"];
                    $('.modal.aside').remove();
                    history.replaceState(data["title"], data["title"], url);
                    $('#bread_title').html(data["title"]);
                    $('#bread_subtitle').html(data["subtitle"]);
                    $(".content").html(data["data"]);
                }
            });
        }

        function form_penilaian_anri(id = null) {
            var url = "<?php echo site_url("ars_penyusutan/pemusnahan/form_penilaian_anri"); ?>";
            var param = {
                ajax: "yes",
                <?php echo $this->m_reff->tokenName() ?>: token,
                id: id
            };
            $.ajax({
                type: "POST",
                dataType: "json",
                data: param,
                url: url,
                success: function(data) {
                    token = data["token"];
                    $('.modal.aside').remove();
                    history.replaceState(data["title"], data["title"], url);
                    $('#bread_title').html(data["title"]);
                    $('#bread_subtitle').html(data["subtitle"]);
                    $(".content").html(data["data"]);
                }
            });
        }

        function form_penilaian_kasetpres(id = null) {
            var url = "<?php echo site_url("ars_penyusutan/pemusnahan/form_penilaian_kasetpres"); ?>";
            var param = {
                ajax: "yes",
                <?php echo $this->m_reff->tokenName() ?>: token,
                id: id
            };
            $.ajax({
                type: "POST",
                dataType: "json",
                data: param,
                url: url,
                success: function(data) {
                    token = data["token"];
                    $('.modal.aside').remove();
                    history.replaceState(data["title"], data["title"], url);
                    $('#bread_title').html(data["title"]);
                    $('#bread_subtitle').html(data["subtitle"]);
                    $(".content").html(data["data"]);
                }
            });
        }

        function form_proses_pemusnahan(id = null) {
            var url = "<?php echo site_url("ars_penyusutan/pemusnahan/form_proses_pemusnahan"); ?>";
            var param = {
                ajax: "yes",
                <?php echo $this->m_reff->tokenName() ?>: token,
                id: id
            };
            $.ajax({
                type: "POST",
                dataType: "json",
                data: param,
                url: url,
                success: function(data) {
                    token = data["token"];
                    $('.modal.aside').remove();
                    history.replaceState(data["title"], data["title"], url);
                    $('#bread_title').html(data["title"]);
                    $('#bread_subtitle').html(data["subtitle"]);
                    $(".content").html(data["data"]);
                }
            });
        }

        function approve() {
            $('#mdl_approval').modal('show');
        }

        function uploadBA() {
            $('#mdl_uploadBA').modal('show');
        }

        function pembatalan() {
            $('#mdl_pembatalan').modal('show');
        }

        function detail(id = null) {
            var url = "<?php echo site_url("ars_penyusutan/pemusnahan/detail"); ?>";
            var param = {
                ajax: "yes",
                <?php echo $this->m_reff->tokenName() ?>: token,
                id: id
            };
            $.ajax({
                type: "POST",
                dataType: "json",
                data: param,
                url: url,
                success: function(data) {
                    token = data["token"];
                    $('.modal.aside').remove();
                    history.replaceState(data["title"], data["title"], url);
                    $('#bread_title').html(data["title"]);
                    $('#bread_subtitle').html(data["subtitle"]);
                    $(".content").html(data["data"]);
                }
            });
        }
    </script>





    <div class="modal effect-scale" id="mdl_modal" role="dialog" style="width: 90%;">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo" id="area_modal">
                <div class="modal-header">
                    <h6 class="modal-title"> </h6><button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                </div>
                <div id="response"></div>
            </div>
        </div>
    </div>