<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
	<div>
		<h4 class="content-title mb-2">Data master</h4>
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Data master</a></li>
				<li class="breadcrumb-item active" aria-current="page">Biro</li>
			</ol>
		</nav>
	</div>
</div>


	<div class="  card">
		<div class="card-body" id="area_lod">
 		<div class="col-md-12 table-responsive">
 			<table id="table" class="table table-bordered table-striped  table-sm" style="width:100%">
 				<thead>
 					<!-- <th width="30px">NO</th> -->
 					<th>KODE</th>
 					<th>NAMA ISTANA</th>
 					<th>LAT</th>
 					<th>LNG</th>
 					<th>ACTION</th>
 				</thead>
 			</table>
 		</div>
		</div>
 	</div>
 

 <script type="text/javascript">
 	var save_method; //for save method string
 	var table;
 	var dataTable = $('#table').DataTable({
 		///scrollX: 103,
 		"fixedHeader": true,
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
 			"lengthMenu": " &nbsp;&nbsp;Tampil _MENU_ Baris",
 		},


 		"serverSide": true, //Feature control DataTables' server-side processing mode.
 		"responsive": true,
 		"searching": true,
 		"lengthMenu": [
 			[10, 20, 30,40, 50],
 			[10, 20, 30,40, 50],
 		],
 		dom: 'Blfrtip',
 		buttons: [
		 
			//   'excel',
		 
			{
           	text: ' Refresh  ',
           	action: function ( e, dt, node, config ) {
           		reload_table();
           	},className: 'btn  btn-secondary  '
           },
		   {
        	text: 'Tambah ',
        	action: function ( e, dt, node, config ) {
        		tambah();
        	},className: 'btn   btn-outline-success  '
        }, 

 		],

 		// Load data for the table's content from an Ajax source
 		"ajax": {
 			"url": "<?php echo site_url('mistana/getData'); ?>",
 			"type": "POST",
 			"data": function(data) {
 				data.jk = $('[name="jk"]').val();
 				data.absen = $('[name="absen"]').val();
 				data.jp = $('[name="jp"]').val();
 			},
 			beforeSend: function() {
 				loading("area_lod");
 			},
 			complete: function(data) {
 				unblock('area_lod');
				 token=data.responseJSON.token;
 			},

 		},

 		//Set column definition initialisation properties.
 		"columnDefs": [{
 				"targets": [0, 1, 2], //last column
 				"orderable": false, //set not orderable
 			},
 			//  { "width": "10px", "targets": 0 },
 			//  { "width": "25%", "targets": 1 },
 			//  { "width": "100", "targets": 5 },
 			//  { "width": "70", "targets": 5 },

 		],

 	});

 	function reload_table() {
 		dataTable.ajax.reload(null, false);
 	};
 </script>

<script>
function tambah(){
    $("#mdl_formSubmit").modal();
    $("#mdlValue").html("mohon tunggu...");
     
   var url   = "<?php echo site_url("mistana/form_tambah");?>";
	var param = {<?php echo $this->m_reff->tokenName()?>:token};
   $.ajax({
		type: "POST",dataType: "json",data: param, url: url,
		success: function(val) {
			token=val['token'];
			$("#mdlValue").html(val['data']);
		}
	});

}
</script>

<script>
function simpan() {
	$("#mdl_formSubmit").modal();
	$("#mdlValue").html("mohon tunggu...");
	var url   = "<?php echo site_url("mistana/detail");?>";
	var param = {<?php echo $this->m_reff->tokenName()?>:token};
	$.ajax({
		type: "POST",dataType: "json",data: param, url: url,
		success: function(val) {
			token=val['token'];
			$("#mdlValue").html(val['data']);
		}
	});
}
</script>

<script>
function detail(nip) {
	$("#mdl_formSubmit").modal();
	$("#mdlValue").html("mohon tunggu...");
	var url   = "<?php echo site_url("mistana/detail");?>";
	var param = {nip:nip,<?php echo $this->m_reff->tokenName()?>:token};
	$.ajax({
		type: "POST",dataType: "json",data: param, url: url,
		success: function(val) {
			token=val['token'];
			$("#mdlValue").html(val['data']);
		}
	});

	
}
</script>

 <script>
 	function edit(id) {
 		$("#mdl_formSubmit").modal();
 		$("#mdlValue").html("mohon tunggu...");
 	 

    var url   = "<?php echo site_url("mistana/form_edit");?>";
	var param = {id:id,<?php echo $this->m_reff->tokenName()?>:token};
	$.ajax({
		type: "POST",dataType: "json",data: param, url: url,
		success: function(val) {
			token=val['token'];
			$("#mdlValue").html(val['data']);
		}
	});

 	}
 </script>

<script>
 	function hapus(id, nama) {
 	 

		 swal({
			title: 'Hapus ?',
			text: nama,
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
				swal("data "+nama+" telah dihapus", {
					icon: "success",
					buttons : {
						confirm : {
							className: 'btn btn-success'
						}
					}
				});

				var url   = "<?php echo site_url("mistana/hapus");?>";
        var param = {<?php echo $this->m_reff->tokenName()?>:token,id:id};
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
 </script>


 <!-- Modal -->
 <div class="modal  fade" id="mdl_formSubmit" tabindex="-9991" style="z-index:1199" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
 	<div id="mdl_size" class="modal-dialog modal-lg" role="document">
 		<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
 			<div class="modal-content">
 				<div class="modal-body">
 					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
 						<span aria-hidden="true">&times;</span>
 					</button>
 					<div id="mdlValue"></div>
 				</div>
 			</div>
 		</div>
 	</div>
 </div>