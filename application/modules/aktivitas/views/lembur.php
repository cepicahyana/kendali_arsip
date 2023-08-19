 	<div class="card-body  iq-card "  >


			 <div class="row">
			 <div class="col-md-2 pull-right text-black mt-2">Filter tanggal :</div>
			 <div class="col-md-3 pull-right">
				  <input required style='color:black;min-width:180px;margin-left:-20px' type="text" id="periode" name="periode" class="cursor form-control" onchange="reload_table()" >
              </div>
 
 	 
 		</div>
		 </div>

		 <div class="  card">
		<div class="card-body">
 		<div class="col-md-12 table-responsive"  id="area_lod">
 			<table id="table" class="tablecool   table-sm" style="width:100%">
 				<thead>
 					<th width="30px">NO</th>
 					<!-- <th>USERNAME</th> -->
 					<th>Tanggal </th>
 					<th>Nama </th>
					 <th>Lama lembur (jam)  </th>
 					<th>Aktivitas </th>
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
			 {   extend: 'excel',title: 'Aktivitas lembur',
 				text: 'Export excell', exportOptions: {
					messageTop: "",
           
                },
 				className: 'btn  btn-sm btn-light  '
 			},
			 {   extend: 'pdf',title: 'Aktivitas lembur',
 				text: 'Export Pdf', exportOptions: {
                    messageTop: "",
           
                },
 				className: 'btn  btn-sm btn-light  '
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
 			"url": "<?php echo site_url('aktivitas/getDataLembur'); ?>",
 			"type": "POST",
 			"data": function(data) {
                data.<?php echo $this->m_reff->tokenName()?>=token;
 				data.periode = $('[name="periode"]').val();
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
 				"targets": [0, 1, 2,3,4], //last column
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
		var url   = "<?php echo site_url("aktivitas/detail");?>";
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
 		$.post("<?php echo base_url() ?>aktivitas/form_edit", {
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
 			$.post("<?php echo base_url() ?>aktivitas/hapus", {
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





 
 
 <script>
$('#periode').daterangepicker({
    "showDropdowns": true,
    ranges: {
      //  'Hari ini': [moment(), moment()],
      //  'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
       
    //    '30 Hari yang lalu': [moment().subtract(29, 'days'), moment()],
        'Bulan ini': [moment().startOf('month'), moment().endOf('month')],
        'Bulan kemarin': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    },
    "locale": {
        "format": "DD/MM/YYYY",
        "separator": " - ",
        "applyLabel": "Apply",
        "cancelLabel": "Cancel",
        "fromLabel": "From",
        "toLabel": "To",
        "customRangeLabel": "Sesuaikan",
        "weekLabel": "W",
        "daysOfWeek": [
			"Min",
            "Sen",
            "Sel",
            "Rab",
            "Kam",
            "Jum",
            "Sab",
             
        ],
        "monthNames": [
            "Januari",
            "Februari",
            "Maret",
            "April",
            "Mei",
            "Juni",
            "Juli",
            "Agustus",
            "September",
            "Oktober",
            "November",
            "Desember"
        ],
        "firstDay": 1
    },
    // "startDate": moment().subtract(1, 'month').startOf('month'),
	"startDate":moment().startOf('month'),
	"endDate":moment().endOf('month'),
    // "endDate":  moment().subtract(1, 'month').endOf('month'),
    "opens": "left"
}, function(start, end, label) {
  console.log('New date range selected: ' + start.format('DD-MM-YYYY') + ' to ' + end.format('DD-MM-YYYY') + ' (predefined range: ' + label + ')');
 
});
</script>