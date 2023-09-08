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
                    exportOptions: {
                        columns: [0, 1]
                    },
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
                    exportOptions: {
                        columns: [0, 1]
                    },
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
                    exportOptions: {
                        columns: [0, 1]
                    },
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