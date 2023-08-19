<div class="card-body  iq-card " id="area_lod">
			 <div class="row">
			  

			 <div class="col-md-4 mb-3">
 				<?php
					$dtBidang[null] = "-- Filter Bidang PPNPN --";
					$db=$this->m_reff->list_bagian(2)->result();
					foreach($db as $db){
						$dtBidang[$db->bagian] = $db->bagian;
					}
				  	echo form_dropdown("bidang", $dtBidang, "", "class='text-black form-control' onchange='reload_table()'") ?>
 			</div>
 


 			<div class="col-md-4 mb-3">
 				<?php
					$dtJk[null] = "-- Filter  gender--";
					$dtJk["l"] = "Laki-Laki";
					$dtJk["p"] = "Perempuan";

					echo form_dropdown("jk", $dtJk, "", "class='text-black form-control' onchange='reload_table()' ") ?>
 			</div>
 
 
 			<div class="col-md-4 mb-3">
 				<?php
					$dtjp[null] = "-- Filter Jenjang Pendidikan--";
					foreach ($jp as $jpn) :
						$dtjp[$jpn->id] = $jpn->nama;
					endforeach;
					echo form_dropdown("jp", $dtjp, "", "class='text-black form-control' onchange='reload_table()' ") ?>
 			</div>

			 <?php 
	 	$level = $this->session->userdata("level");
	 	// status admin
	 	if ($level === 'admin_ppnpn' or $level=='super_admin' or !$this->session->userdata('kode_istana')): ?>
		<div class="col-md-4 mb-3">
			<?php
			$db=$this->m_reff->list_istana()->result();
			$dtIstana[null] = "-- Filter Instana   --";
			foreach($db as $db){
				$dtIstana[$db->kode] = $db->istana;
			}
		  	echo form_dropdown("istana", $dtIstana, "", "class='text-black form-controls' onchange='reload_table()' style='width:100%;'") ?>
		</div>
		<?php endif ?>
		<?php 
	 	$level = $this->session->userdata("level");
	 	// status admin
	 	if ($level === 'admin_ppnpn' or $level=='super_admin' or !$this->session->userdata('kode_biro')): ?>
		<div class="col-md-4 mb-3">
			<?php
			$db=$this->m_reff->list_biro()->result();
			$dtBiro[null] = "-- Filter Biro   --";
			foreach($db as $db){
				$dtBiro[$db->kode] = $db->biro;
			}
		  	echo form_dropdown("biro", $dtBiro, "", "class='text-black form-controls' onchange='reload_table()' style='width:100%;'") ?>
		</div>
		<?php endif ?>
 			 
 		</div>
		 </div>

		 <div class="  card">
		<div class="card-body">
 		<div class="col-md-12 table-responsive">
 			<table id="table" class="tablecool   table-sm" style="width:100%">
 				<thead>
 					<th width="30px">NO</th>
 					<!-- <th>USERNAME</th> -->
 					<th>NAMA</th>
 					<th>BIDANG </th>
 					<th>TMT</th>
 					<th>JK</th>
 					<th>HP</th>
 					<th>EMAIL</th>
 					<th>J.PENDIDIKAN</th>
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
 			},,
			 {   extend: 'excel',title: 'Data PPNPN',
 				text: 'Export excell', exportOptions: {
					messageTop: "",
					columns:[0,1,2,3,4,5,6,7]
           
                },
 				className: 'btn btn-light btn-sm '
 			},
			 {   extend: 'pdf',title: 'Data PPNPN',
 				text: 'Export Pdf', exportOptions: {
                    messageTop: "",
					columns:[0,1,2,3,4,5,6,7]
           
                },
 				className: 'btn btn-light  btn-sm'
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
 			"url": "<?php echo site_url('data_ppnpn/getData'); ?>",
 			"type": "POST",
 			"data": function(data) {
 				data.<?php echo $this->m_reff->tokenName()?>=token;
 				data.jk = $('[name="jk"]').val();
 				data.jp = $('[name="jp"]').val();
 				data.istana = $('[name="istana"]').val();
 				data.biro = $('[name="biro"]').val();
 				data.absen = $('[name="absen"]').val();
 				data.bidang = $('[name="bidang"]').val();
 				
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
 	function detail(nip) {
		$("#mdl_formSubmit").modal();
		$("#mdlValue").html("mohon tunggu...");
		var url   = "<?php echo site_url("data_ppnpn/detail");?>";
				var param = {nip:nip,<?php echo $this->m_reff->tokenName()?>:token};
				$.ajax({
						type: "POST",dataType: "json",data: param, url: url,
						success: function(val){
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
 		$.post("<?php echo base_url() ?>data_ppnpn/form_edit", {
 			id: id,
 			<?php echo $this->m_reff->tokenName()?>:token
 		}, function(data, status) {
 			$("#mdlValue").html(data);
 		});
 	}
 </script>

 <script>
 	function hapus(id, nama) {
 		alertify.confirm("<center> " + nama + "<br>Hapus ? </center>", function() {
 			$.post("<?php echo base_url() ?>data_ppnpn/hapus", {
 				id: id,
 				<?php echo $this->m_reff->tokenName()?>:token
 			}, function(data, status) {
 				notif("Berhasil dihapus!", "Info", "success");
 				reload_table();
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