<?php
$dp = $this->db->get_where("tm_rs",array("id"=>$this->session->userdata("id")))->row();
// if(!isset($dp)){
// 	return false;
// }
$level = $this->session->userdata("level");
 
?>


					<!-- breadcrumb -->
					<div class="breadcrumb-header justify-content-between">
						<div>
							<h4 class="content-title mb-2"><i class="fa fa-envelope"></i> Pesan masuk</h4>
							<nav aria-label="breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="#">Silahkan balas pesan sesegera mungkin </a></li>
									<!-- <li class="breadcrumb-item active" aria-current="page">Project</li> -->
								</ol>
							</nav>
						</div>
					 
					</div>
					<!-- /breadcrumb -->


					<!-- main-content-body -->
					<div class="main-content-body">

	 

						
<div class="row row-sm "  id="progress"></div>


						<!-- row -->
						<div class="row row-sm " id="area_lod">
							<div class="col-md-12 col-xl-12">
								<div class="card overflow-hidden review-project">
									<div class="card-body">
										 
										<div class="table-responsive mb-0">
											<table id="table" class="table table-hover table-bordered mb-0 text-md-nowrap text-lg-nowrap text-xl-nowrap table-striped ">
												<thead>
													<tr>
													 
														<th>No</th>
														<th>Percakapan</th>
														<th>Tanggal kirim</th>
														<th>Nama pengirim</th>
														<th>Jabatan</th>
														 
													
														<th>Status</th>
														
													</tr>
												</thead>
												 
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- /row -->
<hr>
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
		 "searching": true,
		 "lengthMenu":
		 [[10 ,20,30], 
		 [10 ,20,30], ], 
	  dom: 'Blfrtip',
		buttons: [
           // 'copy', 'csv', 'excel', 'pdf', 'print'
	 
		{
			  text: 'Refresh ',
                action: function ( e, dt, node, config ) {
                   reload_table();
                },className: 'btn   btn-outline-success  '
                }, 
	 
					 
					 
        ],
        
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('pesan_masuk/getData');?>",
            "type": "POST",
			"data": function ( data ) {
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
        "columnDefs": [
        { 
          "targets": [ 0,-1,-2,-3,-4,-5,-6], //last column
          "orderable": false, //set not orderable
        },
        ],
	
      });
	function reload_table()
	{
		 dataTable.ajax.reload(null,false);	
	};
	
 </script>
 


 
<script>
		function replay(id, msg) {
		 
	 
			$('#mdl_modal').modal({backdrop: 'static', keyboard: false})  
			// $('#replayID').val(id);
			//replayID = id;
			var url = "<?php echo site_url("pesan_masuk/tanggapi"); ?>";
					var param = {
						id: id,
						msg:msg,
						<?php echo $this->m_reff->tokenName() ?>: token
					};
				//	loading("shareInfo");
					$.ajax({
						type: "POST",
						dataType: "json",
						data: param,
						url: url,
						success: function(val) {
							$('#isi').html(val["data"]);
							token = val['token'];
						//	reload_status();
						//	unblock("shareInfo");

						}
					});

		}


		function akhiri(id){
			swal({
						title: 'Akhiri obrolan ini ?',
						text: "Setelah diakhiri anda maupun pegawai tidak dapat berintraksi pada obrolan ini",
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
							 
							
							var url = "<?php echo site_url("pesan_masuk/akhiri_obrolan"); ?>";
										var param = {
											id: id,
											<?php echo $this->m_reff->tokenName() ?>: token
										};
										$.ajax({
											type: "POST",
											dataType: "json",
											data: param,
											url: url,
											success: function(val) {
												$('#msg'+id).fadeOut(600);
												token = val['token'];
												window.location.href="";
											}
										});
									
							
						}  
					});
		}
	</script>
  

	<div class="modal effect-flip-vertical" id="mdl_modal" style="z-index:1500" role="dialog">
		<div class="modal-dialog modal-md" id="area_modal" role="document">

			<div class="modal-content">
			 
			<div id="isi"></div>
			</div>
		</div>
	</div><!-- /.modal-dialog -->