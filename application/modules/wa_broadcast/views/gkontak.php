<?php 
$get_controller = $this->router->fetch_class();
$str_controller = str_replace("_", " ", $get_controller);
$group_id = $this->uri->segment(3, 0);
$dgroup = $this->mdl->getById($group_id)->row();
?>
	<!-- breadcrumb -->
	<div class="breadcrumb-header justify-content-between">
		<div>
			<h4 class="content-title mb-2"> KONTAK GROUP <?= $dgroup->nama;?></h4>
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
				<button onclick='import_kontak(<?= $group_id;?>)' class='btn btn-light' style="min-width:180px">
					<i class="fas fa-upload"></i> Import Data </button>
				<button onclick='addGroupKontak(<?= $group_id;?>)' class='btn btn-warning' style="min-width:180px">
					<i class="fa fa-edit"></i> Tambah Kontak </button>
				</div>
			</div>
		</div>
	</div>
	<!-- /breadcrumb -->


	<!-- main-content-body -->
	<div class="main-content-body">
		<!-- row -->
		<div class="row row-sm " id="area_lod">
			<div class="col-md-12 col-xl-12">
				<div class="card overflow-hidden review-project">
					<div class="card-body">
						<!-- <div class="d-flex justify-content-between">
							<h4 class="card-title mg-b-10">RIWAYAT TEST ANGGOTA KELUARGA PEGAWAI</h4>
							<i class="mdi mdi-dots-horizontal text-gray"></i>
						</div> --> 

						<div class="table-responsive mb-0">
							<table id="table" class="table table-hover table-bordered mb-0 text-md-nowrap text-lg-nowrap text-xl-nowrap table-striped ">
								<thead>
									<tr>
										<th><input type="checkbox" value="ya" id="selectall"/></th>
										<th>NAMA</th>
										<th>JABATAN</th>
										<th>INSTANSI</th>
										<th>EMAIL</th>
										<th>HP</th>
										<th>OPSI</th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /row -->

						
				
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
		"searching": true,
		"ordering": false,
		"lengthMenu":
		[
			[10, 30, 50, 100],
	 		[10, 30, 50, 100],
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
 			{
 				text: ' Kirim Broadcast ',
 				action: function(e, dt, node, config) {
 					broadcast_group_kontak();
 				},
 				className: 'btn btn-success '
 			},
		],
        
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url($get_controller.'/getData_kontak');?>",
            "type": "POST",
			"data": function ( data ) {
				data.group='<?= $group_id?>';
				data.<?php echo $this->m_reff->tokenName()?>=token;
			  
		 },
		   beforeSend: function() {
               loading("area_lod");
            },
			complete: function(data) {
			  token=data.responseJSON.token;
              unblock('area_lod');
	            $("#md_checkbox").attr("checked", false);
				$(".pilihsemua").val("ya");
            },
			
        },

        //Set column definition initialisation properties.
        "columnDefs": [
	        { 
	          "targets": [ 0, -1], //last column
	          "orderable": false, //set not orderable
	        },
        ],
	
      });

	function reload_table()
	{
		 dataTable.ajax.reload(null,false);	
	};

	
	function sendBroadcastGroup(group){
		var url   = "<?php echo site_url($get_controller."/form_broadcast_group");?>";
		var param = {group:group, <?php echo $this->m_reff->tokenName()?>:token};
		$.ajax({
				type: "POST",dataType: "json",data: param, url: url,
				success: function(val){
					token=val['token'];
					$("#mdl_modal").modal();
					$("#isi").html(val['data']);
				}
		});
	}
	 
	function addGroupKontak(group){
	  var url   = "<?php echo site_url($get_controller."/form_group_kontak");?>";
		var param = {group:group, <?php echo $this->m_reff->tokenName()?>:token};
		$.ajax({
				type: "POST",dataType: "json",data: param, url: url,
				success: function(val){
					token=val['token'];
					$("#mdl_modal").modal();
					$("#isi").html(val['data']);
				}
		});
	}
	function editGroupKontak(group, id){
	  var url   = "<?php echo site_url($get_controller."/form_group_kontak");?>";
		var param = {group:group, id:id, <?php echo $this->m_reff->tokenName()?>:token};
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

				var url   = "<?php echo site_url($get_controller."/hapus_group_kontak");?>";
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
	};

	function import_kontak(group){
	  var url   = "<?php echo site_url($get_controller."/form_gkontak_import");?>";
		var param = {group:group, <?php echo $this->m_reff->tokenName()?>:token};
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

	<script type="text/javascript">
	function broadcast_group_kontak(){
		var checkbox_value = ""; var i=0;
		$("[name='pilih[]']").each(function () {
			var ischecked = $(this).is(":checked");
			if (ischecked) {
				checkbox_value += $(this).val() + ",";
				i++;
			}
		});

		var url   = "<?php echo site_url($get_controller."/form_broadcast_group_kontak");?>";
		var param = {data:checkbox_value, <?php echo $this->m_reff->tokenName()?>:token};
		$.ajax({
				type: "POST",dataType: "json",data: param, url: url,
				success: function(val){
					token=val['token'];
					$("#mdl_modal").modal();
					$("#isi").html(val['data']);
				}
		});
	}
	
	$(document).ready(function () {
	    $('#selectall').click(function () {
	        $('.selectedId').prop('checked', this.checked);
	    });

	    $('.selectedId').change(function () {
	        var check = ($('.selectedId').filter(":checked").length == $('.selectedId').length);
	        $('#selectall').prop("checked", check);
	    });
	});
	</script>
	
	<div class="modal effect-newspaper" id="mdl_modal" style="z-index:1500" role="dialog">
    <div class="modal-dialog modal-lg" id="area_modal" role="document">
		<div id="isi"></div>
	</div>
	</form>
</div><!-- /.modal-dialog --> 