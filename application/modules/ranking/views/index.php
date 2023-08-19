<script>
$("body").addClass("sidebar-main");
</script>
 
<div class="row">
	<div class="col-md-5" >
		<div id="goGrafik" ></div>
	</div>
	<div class="col-md-7">
		<div class="card">
			<div class="card-body">
				<span class='text-black'>Data penilaian berdasarkan nilai tertinggi</span>
				<div class="row mb-2">
				
					
					<div class="col-md-6">
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


					<div class="col-md-6">
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
					<div class="col-md-12">&nbsp;</div>
					<?php 
				 	$level = $this->session->userdata("level");
				 	// status admin
				 	if ($level === 'admin_ppnpn' or $level==='super_admin' or !$this->session->userdata("kode_istana")): ?>
					<div class="col-md-6">
		 				<?php
							$dtIstana[null] = "-- Filter Instana   --";
							$db=$this->m_reff->list_istana()->result();
							foreach($db as $db){
								$dtIstana[$db->kode] = $db->istana;
							}
						  	echo form_dropdown("istana", $dtIstana, "", "class='text-black form-controls' onchange='reload_table()'") ?>
		 			</div>
	 				<?php endif ?>



					 <?php 
				 	$level = $this->session->userdata("level");
				 	// status admin
				 	if ($level === 'admin_ppnpn' or $level==='super_admin' or (!$this->session->userdata("kode_biro")  )): ?>
					<div class="col-md-6">
		 				<?php
							$dBiro[null] = "-- Filter Biro --";
							$db=$this->m_reff->list_biro()->result();
							foreach($db as $db){
								$dBiro[$db->kode] = $db->biro;
							}
						  	echo form_dropdown("biro", $dBiro, "", "class='text-black form-controls' onchange='reload_table()'") ?>
		 			</div>
	 				<?php endif ?>



				</div>
				<div class="table-responsive" id="area_lod">
					<table id="table" class="tablecool   table-sm" style="width:100%">
		 				<thead>
		 					<th width="30px">NO</th>
		 					<th>Nama</th>
		 					<th>Bagian</th>
		 					<th>NIP</th>
		 					<th>Hasil Penilaian</th>
		 					<th>Predikat</th>
		 					<th>Download</th>
		 				</thead>
		 			</table>
		 		</div>
			</div>
		</div>
	</div>
	
</div>

<script type="text/javascript">
 
    //    $('.select2').select2({
    //        minimumInputLength: 3,
    //        allowClear: false,
    //        placeholder: 'Cari nama PPNPN :',
    //        ajax: {
    //           dataType: 'json',
    //           url: 'ranking/dataPPNPN',
    //           delay: 400,
    //           data: function(params) {
    //             return {
    //               search: params.term
    //             }
    //           },
    //           processResults: function (data, page) {
    //           return {
    //             results: data
    //           };
    //         },
    //       }
    //   }).on('select2:select', function (evt) {
    //      var nip = evt.params.data.id;
	// 		goGrafik(nip);
    //   });
	setTimeout(() => {
		goGrafik(null);
	}, 300);
 
</script>


 <script type="text/javascript">

 	var save_method; //for save method string
 	var table;
 	var dataTable = $('#table').DataTable({
 		///scrollX: 103,
 		"fixedHeader": true,
 		"paging": true,
 		"processing": false, //Feature control the processing indicator.
 		"language": {
 			"sSearch": "&nbsp;",
 			"searchPlaceholder": "Pencarian...",
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
 			[10, 20, 30,40, 50,100,10000000],
 			[10, 20, 30,40, 50,100,"All"],
 		],
 		dom: 'Blfrtip',
 		buttons: [
		 
		 
			{ text: ' Export Excell ',extend: 'excel',
				 className: 'btn btn-primary',
				//  exportOptions: {
                //     columns: [ 0]
                // }
			
			},
                
		 
 			/*{
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
 			},*/

 		],

 		// Load data for the table's content from an Ajax source
 		"ajax": {
 			"url": "<?php echo site_url('ranking/getData'); ?>",
 			"type": "POST",
 			"data": function(data) {
 				data.<?php echo $this->m_reff->tokenName()?>=token;
 				data.istana = $('[name="istana"]').val();
 				data.tahun = $('[name="tahun"]').val();
 				data.sms = $('[name="sms"]').val();
 				data.biro = $('[name="biro"]').val();
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
			 { 'visible': false, 'targets': [3] }
 			//  { "width": "10px", "targets": 0 },
 			//  { "width": "25%", "targets": 1 },
 			//  { "width": "100", "targets": 5 },
 			//  { "width": "70", "targets": 5 },

 		],

 	});

 	

 	function reload_table() {
 		// dataTable.order([ 1, 'desc' ]).draw();
 		dataTable.ajax.reload(null, false);
		 goGrafik();
 	};
 </script>


 

<script>
function goGrafik(nip=null) {
	$("#goGrafik").html("mohon tunggu...");
	var url   = "<?php echo site_url("ranking/goGrafik");?>";
	var tahun = $("#tahun").val();
	var semester = $("#semester").val();
	var param = {nip:nip,<?php echo $this->m_reff->tokenName()?>:token,tahun:tahun,semester:semester};
	$.ajax({
		type: "POST",dataType: "json",data: param, url: url,
		success: function(val) {
			token=val['token'];
			$("#goGrafik").html(val['data']);
		}
	});
}
</script>
