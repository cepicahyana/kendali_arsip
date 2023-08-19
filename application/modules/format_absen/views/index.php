	<div class="card">
		<div class="card-body">
			<div class="col-md-12 table-responsive" id="area_lod">
				<table id="table" class="tablecool table-sm" style="width:100%">
					<thead>
						<th width="30px">NO</th>
						<th>Nama Format</th>
						<th>Jam Masuk</th>
						<th>Jam Pulang</th>
						<th>Lama bekerja</th>
						<th>Nominal Lembur</th>
						<th>Uang Makan</th>
						<th>Jam Mulai Lembur</th>
						<th>Max Lembur Weekday</th>
						<th>Max Lembur Weekend</th>
						<!-- <th>Status</th> -->
						<th>Jam lembur min.Uang Makan</th>
						<th>Opsi</th>
					</thead>
				</table>
			</div>
		</div>
 	</div>
 

 <script type="text/javascript">
	 $('#demo').daterangepicker({
		"singleDatePicker": true,
		"timePicker": true,
		"timePicker24Hour": true,
		"parentEl": "mdlValue",
	}, function(start, end, label) {
	console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
	});




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
 				text: ' Refresh ',
 				action: function(e, dt, node, config) {
 					reload_table();
 				},
 				className: '  font14 btn btn-sm btn-light ti-reload  '
 			},
			{
 				text: ' Tambah ',
 				action: function(e, dt, node, config) {
 					tambah();
 				},
 				className: '  font14 btn btn-sm ti-plus bg-teal  '
 			},

 		],

 		// Load data for the table's content from an Ajax source
 		"ajax": {
 			"url": "<?php echo site_url('format_absen/getData'); ?>",
 			"type": "POST",
 			"data": function(data) {
 				data.<?php echo $this->m_reff->tokenName()?>=token;
 				// data.tahun = $('[name="tahun"]').val();
 				// data.sms = $('[name="sms"]').val();
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
 		"columnDefs": [{
 				"targets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10], //last column
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
	var url   = "<?php echo site_url("format_absen/form_tambah");?>";
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
	var url   = "<?php echo site_url("mipenilaian/detail");?>";
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

</script>

 <script>
 	function edit(id) {
 		$("#mdl_formSubmit").modal();
 		$("#mdlValue").html("mohon tunggu...");

		 var url   = "<?php echo site_url("format_absen/form_edit");?>";
	var param = {id: id,<?php echo $this->m_reff->tokenName()?>:token};
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
 	function hapus(id) {
 		alertify.confirm("<center>  Hapus ? </center>", function() {
			var url   = "<?php echo site_url("format_absen/hapus");?>";
			var param = {id: id,<?php echo $this->m_reff->tokenName()?>:token};
			$.ajax({
		type: "POST",dataType: "json",data: param, url: url,
		success: function(val) {
			token=val['token'];
 				// notif("Berhasil dihapus!", "Info", "success");
 				reload_table();
		}
	});
 

 		 
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
 					<div id="mdlValue">
					 </div>
 				</div>
 			</div>
 		</div>
 	</div>
 </div>