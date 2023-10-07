	<div class="card custom-card" id="tab">
	    <div class="card-body">
	        <div>
	            <h6 class="card-title mb-1">Daftar Arsip</h6>
	            <p class="text-muted card-sub-title"></p>
	        </div>
	        <div class="text-wrap">
	            <div class="example">
	                <div class="border">
	                    <div class="bg-gray-300 nav-bg">
	                        <nav class="nav nav-tabs">
	                            <a class="nav-link active" data-bs-toggle="tab" href="#konvensional">Arsip Konvensional</a>
	                            <a class="nav-link" data-bs-toggle="tab" href="#elektronik">Arsip Elektronik</a>
	                            <a class="nav-link" data-bs-toggle="tab" href="#audiovisual">Arsip Audio Visual</a>
	                        </nav>
	                    </div>
	                    <div class="card-body tab-content">
	                        <div class="tab-pane active show" id="konvensional">
	                            <div class="col-md-12" id="area_lod">
	                                <table id='table1' width="100%"
	                                    class="tabel black table-striped table-bordered table-hover dataTable">
	                                    <thead>
	                                        <tr>
	                                            <th class='thead' width='15px'>No</th>
	                                            <th class='thead'>Klasifikasi Arsip </th>
	                                            <th class='thead'>Jenis / series Arsip</th>
                                                <th class='thead'>Kurun Waktu</th>
                                                <th class='thead'>Tingkat Perkembangan</th>
                                                <th class='thead'>Jumlah</th>
                                                <th class='thead'>Keterangan</th>
	                                        </tr>
	                                    </thead>
	                                </table>
	                            </div>
	                        </div>
                            <div class="tab-pane show" id="elektronik">
	                            <div class="col-md-12" id="area_lod">
	                                <table id='table2' width="100%"
	                                    class="tabel black table-striped table-bordered table-hover dataTable">
	                                    <thead>
	                                        <tr>
                                                <th class='thead' width='15px'>No</th>
	                                            <th class='thead'>Klasifikasi Arsip </th>
	                                            <th class='thead'>Jenis / series Arsip</th>
                                                <th class='thead'>Kurun Waktu</th>
                                                <th class='thead'>Tingkat Perkembangan</th>
                                                <th class='thead'>Jumlah</th>
                                                <th class='thead'>Keterangan</th>
	                                        </tr>
	                                    </thead>
	                                </table>
	                            </div>
	                        </div>
                            <div class="tab-pane show" id="audiovisual">
	                            <div class="col-md-12" id="area_lod">
	                                <table id='table3' width="100%"
	                                    class="tabel black table-striped table-bordered table-hover dataTable">
	                                    <thead>
	                                        <tr>
                                                <th class='thead' width='15px'>No</th>
	                                            <th class='thead'>Isi ( Uraian Masalah )</th>
                                                <th class='thead'>Kurun Waktu</th>
                                                <th class='thead'>Tingkat Perkembangan</th>
                                                <th class='thead'>Jumlah</th>
                                                <th class='thead'>Keterangan</th>
	                                        </tr>
	                                    </thead>
	                                </table>
	                            </div>
	                        </div>

	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
	<script type="text/javascript">
    // Awal Datattable
    var table;
    $(function() { datatableKonvensional() })
    $('[href="#konvensional"]').on('click', function() { datatableKonvensional() })
    function datatableKonvensional() {
        var dataTable = $('#table1').DataTable({
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
            "responsive": true,
            "searching": true,
            "lengthMenu": [
                [10, 20, 30, 50],
                [10, 20, 30, 50],
            ],
            destroy: true,
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
                    action: function(e, dt, node, config) {
                        window.location = "<?php echo site_url('ars_registerarsip/export');?>?type=1";
                    },
                    className: 'btn  btn-secondary-light'
                },
                {
                    text: '<i class="fe fe-plus"></i> Register Arsip',
                    action: function(e, dt, node, config) {
                        window.location = "<?php echo site_url('ars_registerarsip/form_arsip');?>";
                    },
                    className: 'btn  btn-secondary-light'
                },
                {
                    text: '<i class="fe fe-upload"></i> Import Arsip',
                    action: function(e, dt, node, config) {
                        toggleModal('#modal-import');
                    },
                    className: 'btn  btn-secondary-light'
                },
            ],

            "ajax": {
                "url": "<?php echo site_url('ars_registerarsip/getData_arsiplist');?>",
                "type": "POST",
                "data": function(data) {
                    data.<?php echo $this->m_reff->tokenName()?> = token;
                    data.type = 1;
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
    };


    $('[href="#elektronik"]').on('click', function() {
        var dataTable = $('#table2').DataTable({
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
            "responsive": true,
            "searching": true,
            "lengthMenu": [
                [10, 20, 30, 50],
                [10, 20, 30, 50],
            ],
            destroy: true,
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
                    action: function(e, dt, node, config) {
                        window.location = "<?php echo site_url('ars_registerarsip/export');?>?type=2";
                    },
                    // exportOptions: {
                    //     columns: [0, 1]
                    // },
                    className: 'btn  btn-secondary-light'
                },
                {
                    text: '<i class="fe fe-plus"></i> Register Arsip',
                    action: function(e, dt, node, config) {
                        window.location = "<?php echo site_url('ars_registerarsip/form_arsip');?>";
                        // action_form();
                    },
                    className: 'btn  btn-secondary-light'
                },
            ],

            "ajax": {
                "url": "<?php echo site_url('ars_registerarsip/getData_arsiplist');?>",
                "type": "POST",
                "data": function(data) {
                    data.<?php echo $this->m_reff->tokenName()?> = token;
                    data.type = 2;
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
    });

    $('[href="#audiovisual"]').on('click', function() {
        var dataTable = $('#table3').DataTable({
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
            "responsive": true,
            "searching": true,
            "lengthMenu": [
                [10, 20, 30, 50],
                [10, 20, 30, 50],
            ],
            destroy: true,
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
                    action: function(e, dt, node, config) {
                        window.location = "<?php echo site_url('ars_registerarsip/export');?>?type=3";
                    },
                    // exportOptions: {
                    //     columns: [0, 1]
                    // },
                    className: 'btn  btn-secondary-light'
                },
                {
                    text: '<i class="fe fe-plus"></i> Register Arsip',
                    action: function(e, dt, node, config) {
                        window.location = "<?php echo site_url('ars_registerarsip/form_arsip');?>";
                        // action_form();
                    },
                    className: 'btn  btn-secondary-light'
                },
            ],

            "ajax": {
                "url": "<?php echo site_url('ars_registerarsip/getData_arsiplist');?>",
                "type": "POST",
                "data": function(data) {
                    data.<?php echo $this->m_reff->tokenName()?> = token;
                    data.type = 3;
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
    });
    // TUTUP Datattable

    function action_form(id=null)
    {	 
        $("#mdl_modal").modal("show");
        $("#response").html(cantik());
        if(id){
        $(".modal-title").html("Update data");
        }else{
        $(".modal-title").html("Tambah data");
        }
        var url   = "<?php echo site_url("ars_registerarsip/form_arsip");?>";
        var param = {<?php echo $this->m_reff->tokenName()?>:token,id:id};
        $.ajax({
            type: "POST",dataType: "json",data: param, url: url,
            success: function(val){
                $("#response").html(val['data']);
                token=val['token'];
            }
        }); 
    }

    $('body').on('click', '#preview-import', function() {
        var dataFile = $('#file_import').prop('files')[0];
        if (!dataFile) {
            alert('Silakan upload dan preview terlebih dahulu')
            return
        }
        var formData = new FormData();
        formData.append('files', dataFile);

        $('#table-preview > tbody').html('');

        $.ajax({
            type: "POST",
            url: '<?php echo site_url('ars_registerarsip/importPreview');?>',
            data: formData,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                if (response.status == 1) {
                    for (var i = 0; i < response.item.length; ++i) {
                        var row = response.item[i];
                        no = i + 1;

                        $('#table-preview > tbody').append('' +
                            '<tr style="display:none;">' +
                            '<td>' +
                            '<input type="text" name="nomor[]" value="' + row[0] + '">' +
                            '<input type="text" name="jenis[]" value="' + row[2] + '">' +
                            '<input type="text" name="klasifikasi[]" value="' + row[3] + '">' +
                            '<input type="text" name="uraian[]" value="' + row[5] + '">' +
                            '<input type="text" name="waktu[]" value="' + row[11] + '">' +
                            '<input type="text" name="tp[]" value="' + row[8] + '">' +
                            '<input type="text" name="jumlah[]" value="' + row[9] + '">' +
                            '<input type="text" name="deskripsi[]" value="' + row[10] + '">' +
                            '</td>' +
                            '</tr>' +
                            '');
                        $('#table-preview > tbody').append('' +
                            '<tr>' +
                            '<td class="text-center">' + no + '</td>' +
                            '<td class="text-center">' + row[0] + '</td>' +
                            '<td class="text-center">' + row[1] + '</td>' +
                            '<td>' + row[3] + '</td>' +
                            '<td>' + row[4] + '</td>' +
                            '<td>' + row[5] + '</td>' +
                            '<td class="text-center">' + row[6] + '</td>' +
                            '<td class="text-center">' + row[7] + '</td>' +
                            '<td>' + row[9] + '</td>' +
                            '<td>' + row[10] + '</td>' +
                            '</tr>' +
                            '');
                    }
                } else {
                    alert('Gagal Preview File')
                }
            }
        })
    })

    $('body').on('click', '#submit-import', function() {
        if (!$('input[name="nomor[]"]').val()) {
            alert('Tidak ada data yang akan diimport')
            return
        }
        var formData = new FormData();
        if ($('input[name="nomor[]"]'))
            $('input[name="nomor[]"]').map(function(index, val) {
                formData.append(`f[${index}][nomor]`, $(this).val());
            }).get()
        if ($('input[name="jenis[]"]'))
            $('input[name="jenis[]"]').map(function(index, val) {
                formData.append(`f[${index}][jenis]`, $(this).val());
            }).get()
        if ($('input[name="klasifikasi[]"]'))
            $('input[name="klasifikasi[]"]').map(function(index, val) {
                formData.append(`f[${index}][kka_kode]`, $(this).val());
            }).get()
        if ($('input[name="uraian[]"]'))
            $('input[name="uraian[]"]').map(function(index, val) {
                formData.append(`f[${index}][uraian]`, $(this).val());
            }).get()
        if ($('input[name="waktu[]"]'))
            $('input[name="waktu[]"]').map(function(index, val) {
                formData.append(`f[${index}][kurun_waktu]`, $(this).val());
            }).get()
        if ($('input[name="tp[]"]'))
            $('input[name="tp[]"]').map(function(index, val) {
                formData.append(`f[${index}][tingkat_perkembangan_id]`, $(this).val());
            }).get()
        if ($('input[name="jumlah[]"]'))
            $('input[name="jumlah[]"]').map(function(index, val) {
                formData.append(`f[${index}][jumlah]`, $(this).val());
            }).get()
        if ($('input[name="deskripsi[]"]'))
            $('input[name="deskripsi[]"]').map(function(index, val) {
                formData.append(`f[${index}][deskripsi]`, $(this).val());
            }).get()

        toggleModal("#modal-import");

        swal({
            title: "Konfirmasi",
            text: "Yakin ingin mengimport data ini?",
            type: "warning",
            buttons: ["Batal", "Ya"],
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, Import!",
            cancelButtonText: "Tidak, Batalkan!",
            closeOnConfirm: false,
            closeOnCancel: false,
            showLoaderOnConfirm: true,
        }).then((confirm) => {
            if (confirm) {
                $.ajax({
                    type: "POST",
                    url: '<?php echo site_url('ars_registerarsip/import');?>',
                    data: formData,
                    dataType: "json",
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(response) {
                        if (response) {
                            swal({
                                title: "Berhasil",
                                text: "Data berhasil disimpan",
                                icon: "success",
                                button: "Ok",
                            }).then((success) => {
                                if (success) {
                                    window.location = "<?php echo site_url('ars_registerarsip');?>";
                                }
                            })
                        } else {
                            swal({
                                title: "Gagal",
                                text: "Data gagal disimpan",
                                icon: 'error',
                                button: "Ok",
                            })
                        }
                    }
                })

            }
        })
    })

    function toggleModal(type) {
        $(type).modal('toggle')
    }
	</script>
    <div class="modal effect-scale" id="mdl_modal"   role="dialog" >
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content modal-content-demo" id="area_modal">
                <div class="modal-header">
                    <h6 class="modal-title"> </h6><button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                </div>
            <div id="response"></div>
            </div>
        </div>
    </div>
    <div id="modal-import" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form id="form-import" class="form-horizontal need_validation" role="form" method="post" enctype="multipart/form-data" novalidate="novalidate">
                    <div class="modal-header btn-info">
                        <h4 class="modal-title"><i class="icon-warning"></i> Import Pendataan Item Arsip</h4><button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                    </div>

                    <div class="modal-body with-padding">
                        <div class="form-group row">
                            <label for="" class="col-sm-2 control-label">Download Template <span class="text-danger">*</span> :</label>
                            <div class="col-sm-4">
                                <a href="<?php echo site_url('ars_registerarsip/template_import');?>" class="btn btn-xs btn-success" id="" title="Template Excel" download><i class="fe fe-download"></i></a>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-2 control-label">File Import <span class="text-danger">*</span> :</label>
                            <div class="col-sm-4">
                                <input class="styled" type="file" name="file_import" id="file_import" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                            </div>
                            <div class="col-sm-6">
                                <a id="preview-import" class="btn btn-xs btn-primary">Preview</a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="table-preview" class="table table-bsg">
                                <thead>
                                    <tr>
                                        <th colspan="11" class="text-center info">HASIL PREVIEW</th>
                                    </tr>
                                    <tr>
                                        <th>No. </th>
                                        <th>Nomor Arsip</th>
                                        <th>Jenis Arsip</th>
                                        <th>Klasifikasi Arsip</th>
                                        <th>Peraturan</th>
                                        <th>Uraian Informasi Arsip</th>
                                        <th>Kurun Waktu</th>
                                        <th>Tingkat Perkembangan</th>
                                        <th>Jumlah</th>
                                        <th>Deskripsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="9" class="text-center">Silakan upload dan preview terlebih dahulu</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <a class="btn btn-xs btn-primary" id="submit-import"> Simpan</a>
                        <a class="btn btn-xs btn-danger" data-bs-dismiss="modal">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>