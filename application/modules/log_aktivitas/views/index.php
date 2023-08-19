<?php 
$get_controller = $this->router->fetch_class();
$str_controller = str_replace("_", " ", $get_controller);
?>


    <!-- main-content-body -->
    <div class="main-content-body">
    	<div id="area_lod">
            <div class="breadcrumb-header justify-content-between">
            	<div>
            		<h4 class="content-title mb-2">Log Aktivitas </h4>
            	</div>
                <div class="d-flex right-page">
                    <?php
                        $options = [
                        	''=>'-- Filter Module --',
                        	'DATA'=>'DATA',
                        	'COVID'=>'COVID',
                        	'PPNPN'=>'PPNPN',
                        ];
                        echo form_dropdown("module", $options, "", "class='text-black form-control' onchange='reload_table()'") ?>
                </div>
            </div>
	        <!-- row -->
	        <div class="card overflow-hidden review-project">
	            <div class="card-body">
	                <!-- <div class="d-flex justify-content-between">
	                    <h4 class="card-title mg-b-10">RIWAYAT TEST ANGGOTA KELUARGA PEGAWAI</h4>
	                    <i class="mdi mdi-dots-horizontal text-gray"></i>
	                </div> --> 

	                <div class="table-responsive mb-0">
	                    <table id="table" class="table table-hover table-bordered mb-0 text-md-nowrap text-lg-nowrap text-xl-nowrap table-striped">
	                        <thead>
	                            <tr>
	                                <th width="30px">NO</th>
	                                <th>ID USER</th>
	                                <th>USERNAME</th>
	                                <th>AKSI</th>
	                                <th>TGL</th>
	                                <th>LEVEL</th>
	                                <th>MODULE</th>
	                            </tr>
	                        </thead>
	                    </table>
	                </div>
	            </div>
	        </div>
	        <!-- /row -->
        </div>
						
				
<script type="text/javascript">
  	 
	  
    var save_method; //for save method string
    var table;
    var  dataTable = $('#table').DataTable({
		"paging": true,
        "processing": false, //Feature control the processing indicator.
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
            "lengthMenu": "Tampil _MENU_ Baris",
		},			 
        "serverSide": true, //Feature control DataTables' server-side processing mode.
		"responsive": false,
		"searching": false,
		"ordering": false,
		"lengthMenu":
		[
			[30, 50, 100],
	 		[30, 50, 100],
	 	],
        dom: 'Blfrtip',
		// Buttons with Dropdown
		buttons: [
			{
 				text: '',
 				action: function(e, dt, node, config) {
 					reload_table();
 				},
 				className: 'btn btn-light ti-reload '
 			},
		],
        
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url($get_controller.'/get_data');?>",
            "type": "POST",
            "data": function ( data ) {
                data.module = $('[name="module"]').val();
                data.<?php echo $this->m_reff->tokenName()?>=token;
            },
            beforeSend: function() {
                loading("area_lod");
            },
            complete: function(data) {
                token=data.responseJSON.token;
                unblock('area_lod');
            },
        },

        //Set column definition initialisation properties.
        /*"columnDefs": [
            {
                "targets": [ 0,-1], //last column
                "orderable": false, //set not orderable
            },
        ],*/
        
    });

    function reload_table()
	{
		dataTable.ajax.reload(null,false);	
	};
</script>