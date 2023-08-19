<?php 
$get_controller = $this->router->fetch_class();
$str_controller = str_replace("_", " ", $get_controller);
?>
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div>
            <h4 class="content-title mb-2"> DATA PPNPN </h4>
            <!-- <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Input data keluarga yang akan ditest</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Project</li>
                </ol>
            </nav> -->
        </div>
        <div class="d-flex my-auto">
            <div class=" d-flex right-page">
                <div>
                    <button onclick='import_data()' class='btn btn-light' style="min-width:180px">
					<i class="fas fa-upload"></i> Import Data </button>
                </div>
            </div>
        </div>
    </div>
    <!-- /breadcrumb -->


    <!-- main-content-body -->
    <div class="main-content-body">
    	<div id="area_lod">
	    	<div class="row mb-3">
				<!-- <div class="col-md-3 mb-3">
	 				<?php
						$dtIstana[null] = "-- Filter Instana Negara --";
						$db=$this->m_reff->list_istana()->result();
						foreach($db as $db){
							$dtIstana[$db->kode] = $db->istana;
						}
					  	echo form_dropdown("istana", $dtIstana, "", "class='text-black form-control' onchange='reload_table()'") ?>
	 			</div> -->
	 			<!-- <div class="col-md-3 mb-3">
					 
						$dtInstansi[null] = "-- Filter Instansi --";
						$db=$this->m_reff->list_instansi()->result();
						foreach($db as $db){
							$dtInstansi[$db->instansi] = $db->instansi;
						}
					  	echo form_dropdown("instansi", $dtInstansi, "", "class='text-black form-control' onchange='reload_table()'") ?>
				</div> -->
				<!-- <div class="col-md-3 mb-3">
					<?php
						$dtBiro[null] = "-- Filter Biro --";
						$db=$this->m_reff->list_biro()->result();
						foreach($db as $db){
							$dtBiro[$db->kode] = $db->biro;
						}
					  	echo form_dropdown("biro", $dtBiro, "", "class='text-black form-control' onchange='reload_table()'") ?>
				</div>
				<div class="col-md-3 mb-3">
					<?php
						$dtBagian[null] = "-- Filter Bagian --";
						$db=$this->m_reff->list_bagian(2)->result();
						foreach($db as $db){
							$dtBagian[$db->bagian] = $db->bagian;
						}
					  	echo form_dropdown("bagian", $dtBagian, "", "class='text-black form-control' onchange='reload_table()'") ?>
				</div> -->
			 
				<div class="col-md-3">
					<div  >
						<button onclick='filter()' class='btn btn-block btn-warning'>
						<i class="fas fa-search"></i> Filter data</button>
					</div>
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
	                                <!-- <th>FOTO</th> -->
	                                <th>NPP</th>
	                                <th>NAMA</th>
									<th>ISTANA</th>
									<th>BIRO</th>
	                                <!-- <th>ESELON</th>
	                                <th>GOLONGAN</th> -->
	                                <th>BAGIAN</th>
	                                <!-- <th>JABATAN</th> -->
	                               
	                                <th>SUBBAGIAN</th>
	                               
	                                <th>HP</th>
	                                <th>EMAIL</th>
	                                <th>TMT</th>
	                                <th>NIK</th>
	                                <th>GENDER</th>
	                                <th>GOLONGAN DARAH</th>
	                                <th>PENDIDIKAN TERAKHIR</th>
	                                <th>AGAMA</th>
	                                <th>STATUS PERNIKAHAN</th>
	                                <th>#</th>
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
		"responsive": true,
		"searching": true,
		"ordering": false,
		"lengthMenu":
		[
			[10, 20, 30,40, 50,100,99999999],
	 		[10, 20, 30,40, 50,100,"All"],
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
			 {   extend: 'colvis',
 				text: 'Kolom',
 				className: 'btn btn-light  '
 			},
			 {   extend: 'excel',
 				text: 'Export excell', exportOptions: {
                    columns: ':visible'
                },
 				className: 'btn btn-light  '
 			},{
 				text: ' Update Data ',
 				action: function(e, dt, node, config) {
					update_data();
 				},
 				className: 'btn btn-light '
 			},
 			{
 				text: ' Tambah Data ',
 				action: function(e, dt, node, config) {
 					formAdd();
 				},
 				className: 'btn btn-success '
 			},
		],
        
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url($get_controller.'/getPPNPN');?>",
            "type": "POST",
            "data": function ( data ) {
            	data.istana = $('[name="istana"]').val();
            	data.instansi = $('[name="instansi"]').val();
            	data.biro = $('[name="biro"]').val();
            	data.bagian = $('[name="bagian"]').val();
            	data.jenis_pegawai = 2;
				data.filter = true;
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


	function filter(){
		var url = "<?php echo site_url($get_controller."/ppnpn_filter");?>";
		var param = {<?php echo $this->m_reff->tokenName()?>:token};
		$.ajax({
			type: "POST",dataType: "json",data: param, url: url,
			success: function(val){
				token=val['token'];
				$("#mdl_modal_filter").modal();
				$("#isi_filter").html(val['data']);
			}
		});
	}
	function formAdd(){
	  var url   = "<?php echo site_url($get_controller."/ppnpn_form_add");?>";
		var param = {<?php echo $this->m_reff->tokenName()?>:token};
		$.ajax({
			type: "POST",dataType: "json",data: param, url: url,
			success: function(val){
				token=val['token'];
				$("#mdl_modal").modal();
				$("#isi").html(val['data']);
			}
		});
	}

	function formEdit(id){
	  var url   = "<?php echo site_url($get_controller."/ppnpn_form_add");?>";
		var param = {id:id, <?php echo $this->m_reff->tokenName()?>:token};
		$.ajax({
			type: "POST",dataType: "json",data: param, url: url,
			success: function(val){
				token=val['token'];
				$("#mdl_modal").modal();
				$("#isi").html(val['data']);
			}
		});
	}

	function hapus(id,akun){
		swal({
			title: 'Hapus ?',
			text: akun,
			type: 'warning',
			buttons:{
				cancel: {
					visible: true,
					text : 'batal',
					className: 'btn btn-danger'
				},
				confirm: {
					text : 'Ya',
					className : 'btn btn-success'
				}
			}
		}).then((willDelete) => {
			if (willDelete) {
				swal("data "+akun+" telah dihapus", {
					icon: "success",
					buttons : {
						confirm : {
							className: 'btn btn-success'
						}
					}
				});

				var url   = "<?php echo site_url($get_controller."/ppnpn_hapus");?>";
				var param = {id:id,<?php echo $this->m_reff->tokenName()?>:token};
				$.ajax({
					type: "POST",dataType: "json",data: param, url: url,
					success: function(val){
						token=val['token'];
						reload_table();
					}
				});
			}
		});
	}

	function import_data(){
		var url = "<?php echo site_url($get_controller."/ppnpn_import");?>";
		var param = {<?php echo $this->m_reff->tokenName()?>:token};
		$.ajax({
			type: "POST",dataType: "json",data: param, url: url,
			success: function(val){
				token=val['token'];
				$("#mdl_modal").modal();
				$("#isi").html(val['data']);
			}
		});
	}

	function update_data(){
		var url = "<?php echo site_url($get_controller."/update_data");?>";
		var param = {<?php echo $this->m_reff->tokenName()?>:token};
		$.ajax({
			type: "POST",dataType: "json",data: param, url: url,
			success: function(val){
				token=val['token'];
				$("#mdl_modal").modal();
				$("#isi").html(val['data']);
			}
		});
	}

</script>

<div class="modal fade" id="mdl_modal" style="z-index:1500" role="dialog">
    <div class="modal-dialog modal-lg" id="area_modal" role="document">
		<div id="isi"></div>
	</div>
</div><!-- /.modal-dialog --> 

<div class="modal  fade " id="mdl_modal_filter" style="z-index:1500" role="dialog">
    <div class="modal-dialog modal-xl" id="area_modal" role="document">
		<div id="isi_filter"></div>
	</div>
</div><!-- /.modal-dialog --> 