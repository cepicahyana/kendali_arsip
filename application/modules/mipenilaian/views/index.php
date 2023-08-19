<?php 
$get_controller = $this->router->fetch_class(); ?>

<div class="card-body  iq-card " >
	<div class="row">
		<div class="col-md-3 mb-3">
			<?php
			$YNow = date('Y');
			for ($thn=$YNow; $thn > ($YNow-10); $thn--) { 
			    $options[$thn] = $thn;
			}

			$attr = array('id' => 'tahun', 'onchange'=>'reload_table()', 'class' => 'form-controls', 'required' => 'required', 'style' => 'width:100%;');
			echo form_dropdown('tahun', $options, set_value('tahun'), $attr);
			unset($options);
			unset($attr);?>	
		</div>
		<div class="col-md-3 mb-3">
			<?php
			$options = [
				// ''=>'-- Pilih Semester--',
				'1'=>'Semester 1',
				'2'=>'Semester 2',
			];

			if(date('m')>6){
				$value_sms = 2;
			}else{
				$value_sms = 1;
			}

			$attr = array('id' => 'semester', 'onchange'=>'reload_table()', 'class' => 'form-controls', 'required' => 'required', 'style' => 'width:100%;');
			echo form_dropdown('sms', $options, $value_sms, $attr);
			unset($options);
			unset($attr);
			?>
		</div>
	</div>
</div>

		 <div class="  card">
		<div class="card-body" id="area_load">
 		<div class="col-md-12 table-responsive">
 			<table id="table" class="tablecool   table-sm" style="width:100%">
 				<thead>
 					<th width="30px">NO</th>
 					<th>Tahun </th>
 					<th>Semester</th>
 					<th>Indikator</th>
 					<th>Bobot (%)</th>
 					<th>Status</th>
 					<th>Option</th>
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
 			"url": "<?php echo site_url($get_controller.'/getData'); ?>",
 			"type": "POST",
 			"dataType": "JSON",
 			"data": function(data) {
 				data.tahun = $('[name="tahun"]').val();
 				data.sms = $('[name="sms"]').val();
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
    $("#mdlValue").html("mohon tunggu...");

    var url   = "<?php echo site_url($get_controller."/form_tambah");?>";
    var param = {<?php echo $this->m_reff->tokenName()?>:token};
	$.ajax({
		type: "POST",dataType: "JSON",data: param, url: url,
		success: function(val){
			token=val['token'];
    		$("#mdl_formSubmit").modal();
			$("#mdlValue").html(val['data']);
		}
	});
}
</script>

<script>
function simpan() {
	$("#mdlValue").html("mohon tunggu...");
	var url   = "<?php echo site_url($get_controller."/detail");?>";
	var param = {<?php echo $this->m_reff->tokenName()?>:token};
	$.ajax({
		type: "POST",dataType: "JSON",data: param, url: url,
		success: function(val) {
			token=val['token'];
			$("#mdl_formSubmit").modal();
			$("#mdlValue").html(val['data']);
		}
	});
}
</script>

<script>
function detail(nip) {
	$("#mdlValue").html("mohon tunggu...");
	var url   = "<?php echo site_url($get_controller."/detail");?>";
	var param = {nip:nip,<?php echo $this->m_reff->tokenName()?>:token};
	$.ajax({
		type: "POST",dataType: "JSON",data: param, url: url,
		success: function(val) {
			token=val['token'];
			$("#mdl_formSubmit").modal();
			$("#mdlValue").html(val['data']);
		}
	});
}
</script>

 <script>
 	function edit(id) {
 		
 		$("#mdlValue").html("mohon tunggu...");

 		var url   = "<?php echo site_url($get_controller."/form_edit");?>";
		var param = {id:id, <?php echo $this->m_reff->tokenName()?>:token};
		$.ajax({
			type: "POST",dataType: "JSON",data: param, url: url,
			success: function(val) {
				token=val['token'];
				$("#mdl_formSubmit").modal();
				$("#mdlValue").html(val['data']);
			}
		});
 	}
 </script>

 <script>
 	function hapus(id, nama) {
 		alertify.confirm("<center> " + nama + "<br>Hapus ? </center>", function() {

 			var url   = "<?php echo site_url($get_controller."/hapus");?>";
			var param = {id:id, <?php echo $this->m_reff->tokenName()?>:token};
			$.ajax({
				type: "POST",dataType: "JSON",data: param, url: url,
				success: function(val) {
					token=val['token'];
					
					notif("Berhasil dihapus!", "Info", "success");
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
 					<div id="mdlValue"></div>
 				</div>
 			</div>
 		</div>
 	</div>
 </div>