<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
						<div>
							<h4 class="content-title mb-2"> </h4>
							<nav aria-label="breadcrumb">
                            <h4 class="card-title mg-b-10 text-white">RIWAYAT TEST ANDA</h4>
								 
							</nav>
						</div>
</div>

<div class="main-content-body">
 
 
<!-- row -->
<div class="row row-sm " id="riwayat">
							<div class="col-md-12 col-xl-12">
								<div class="card overflow-hidden review-project">
									<div class="card-body">
										<div class="d-flex justify-content-between">
										
											<i class="mdi mdi-dots-horizontal text-gray"></i>
										</div> 
										<div class="table-responsive mb-0">
											<table id="table" class="table table-hover table-bordered mb-0 text-md-nowrap text-lg-nowrap text-xl-nowrap table-striped ">
												<thead>
													<tr>
													 
														<th>Tanggal </th>
														<th>Hasil</th>
														<th>Jenis Test</th>
														<th>Tempat Test</th>
														
														
													</tr>
												</thead>
												 
											</table>
										</div>
									</div>
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
		  "responsive": false,
		  "searching": false,
		  "lengthMenu":
		  [[5,10 ,20,30], 
		  [5,10 ,20,30], ], 
	   dom: 'Blfrtip',
		 buttons: [
			// 'copy', 'csv', 'excel', 'pdf', 'print'
	  
		 // {
		 // 	  text: 'Input ',
		 //         action: function ( e, dt, node, config ) {
		 //            download();
		 //         },className: 'btn   btn-outline-success  '
		 //         }, 
	  
					  
					  
		 ],
		 
		 // Load data for the table's content from an Ajax source
		 "ajax": {
			 "url": "<?php echo site_url('dpegawai/getData');?>",
			 "type": "POST",
			 "data": function ( data ) {
				//  data.<?php echo $this->m_reff->tokenName()?>=token;
		  },
			beforeSend: function() {
				loading("area_lod");
			 },
			 complete: function(data) {
			//    token=data.responseJSON.token;
			   unblock('area_lod');
			  if(hasil=="+"){
				 progress(); 
			  }
			 },
			 
		 },
 
		 //Set column definition initialisation properties.
		 "columnDefs": [
		 { 
		   "targets": [ 0,-1,-2,-3], //last column
		   "orderable": false, //set not orderable
		 },
		 ],
	 
	   });
	 function reload_table()
	 {
		  dataTable.ajax.reload(null,false);	
	 };

</script>