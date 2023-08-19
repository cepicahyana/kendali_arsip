 	<div class="card-body  iq-card " id="area_lod">
			<div class="row">
			<?php 
		 	$level = $this->session->userdata("level");
		 	// status admin
		 	if ($level === 'admin_ppnpn' or $level=='super_admin'): ?>
			<div class="col-md-3 mb-3">
 				<?php
					$dtIstana[null] = "-- Filter Instana Negara --";
					$db=$this->m_reff->list_istana()->result();
					foreach($db as $db){
						$dtIstana[$db->kode] = $db->istana;
					}
					echo form_dropdown("istana", $dtIstana, "", "class='text-black form-control' onchange='reload_table()'") ?>
 			</div>

			 <div class="col-md-3 mb-4">
 				<?php
					$dtBiro[null] = "-- Filter Biro   --";
					$db=$this->m_reff->list_biro()->result();
					foreach($db as $db){
						$dtBiro[$db->kode] = $db->biro;
					}
					echo form_dropdown("biro", $dtBiro, "", "class='text-black form-control' onchange='reload_table()'") ?>
 			</div>


			<?php endif ?>
			 <div class="col-md-3 mb-3">
 				<?php
					$dtBidang[null] = "-- Filter Bidang PPNPN --";
					$db=$this->m_reff->list_bagian(2)->result();
					foreach($db as $db){
						$dtBidang[$db->bagian] = $db->bagian;
					}
				  	echo form_dropdown("bidang", $dtBidang, "", "class='text-black form-control' onchange='reload_table()'") ?>
 			</div>
 
 
 		 

 			<div class="col-md-3 mb-3">
 				<?php
					$dtJk[null] = "-- Filter Gender--";
					$dtJk["L"] = "Laki-Laki";
					$dtJk["P"] = "Perempuan";

					echo form_dropdown("jk", $dtJk, "", "class='text-black form-control' onchange='reload_table()' ") ?>
 			</div>
 			 
 		</div>
		 </div>

		 <div class="  card">
		<div class="card-body">
 		<div class="col-md-12 table-responsive">
 			<table id="table" class="tablecool   table-sm" style="width:100%">
 				<thead>
 					<th width="30px">NO</th>
 					<!-- <th>USERNAME</th> -->
 					<th>NAMA </th>
					 <th>JK </th>
					 <th>SATKER/BIRO </th>
					 <th>BIDANG </th>
 					<th>NPP </th>
 					
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
 				text: ' Refresh ',
 				action: function(e, dt, node, config) {
 					reload_table();
 				},
 				className: '  font14 btn btn-sm btn-light ti-reload  '
 			},
			//   {
 			// 	text: ' Tambah ',
 			// 	action: function(e, dt, node, config) {
 			// 		tambah();
 			// 	},
 			// 	className: '  font14 btn btn-sm ti-plus bg-teal  '
 			// },

 		],

 		// Load data for the table's content from an Ajax source
 		"ajax": {
 			"url": "<?php echo site_url('koreksi_absen/getData'); ?>",
 			"type": "POST",
 			"data": function(data) {
 				data.istana = $('[name="istana"]').val();
 				data.jk = $('[name="jk"]').val();
 				data.bidang = $('[name="bidang"]').val();
 				data.biro = $('[name="biro"]').val();
 			
 			},
 			beforeSend: function() {
 				loading("area_lod");
 			},
 			complete: function() {
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
 	function detail(nip) {
		$("#mdl_formSubmit").modal();
		$("#mdlValue").html("mohon tunggu...");
		var url   = "<?php echo site_url("koreksi_absen/detail");?>";
		var param = {nip:nip,<?php echo $this->m_reff->tokenName()?>:token};
				$.ajax({
						type: "POST",dataType: "json",data: param, url: url,
						success: function(val){
							token=val['token'];
							$("#mdlValue").html(val['data']);
							
						}
				});	
 	}
 	function revAbsen(nip,tgl,i) {
		var masuk   = $("#masuk"+i).val();
		var pulang  = $("#pulang"+i).val();
		var url   = "<?php echo site_url("koreksi_absen/revAbsen");?>";
		var param = {tgl:tgl,masuk:masuk,pulang:pulang,nip:nip,<?php echo $this->m_reff->tokenName()?>:token};
		$.ajax({
			type: "POST",dataType: "json",data: param, url: url,
			success: function(val){
				token=val['token'];
			 	notif("Berhasil disimpan!");
				// detail(nip,null);
				$("#lembur"+i).val(val["hitungLembur"]);
			}
		});	
 	}
 	function setJenisAbsen(tgl,nip,value,i) {
		 var masuk  = $("#masuk"+i).val();
		 var pulang = $("#pulang"+i).val();
		var url   = "<?php echo site_url("koreksi_absen/setJenisAbsen");?>";
		var param = {masuk:masuk,pulang:pulang,tgl:tgl,value:value,nip:nip,<?php echo $this->m_reff->tokenName()?>:token};
		$.ajax({
			type: "POST",dataType: "json",data: param, url: url,
			success: function(val){
				token=val['token'];
				notif("Berhasil disimpan!");
				$("#lembur"+i).val(val["hitungLembur"]);
				//  detail(nip,null);
			}
		});	
 	}

	 function setLembur(nip,tgl,jml){
		var url   = "<?php echo site_url("lembur/setLembur");?>";
		var param = {nip:nip,tgl:tgl,lembur:jml,<?php echo $this->m_reff->tokenName()?>:token};
		$.ajax({
			type: "POST",dataType: "json",data: param, url: url,
			success: function(val){
				token=val['token'];
				notif("berhasil disimpan !!")
				detail(nip,null);
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