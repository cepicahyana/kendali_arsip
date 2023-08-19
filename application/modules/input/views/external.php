 


					<!-- breadcrumb -->
					<div class="breadcrumb-header justify-content-between">
						<div>
							<h4 class="content-title mb-2">EXTERNAL / NON - PEGAWAI </h4>
							<nav aria-label="breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="#">Input data yang akan ditest</a></li>
									<!-- <li class="breadcrumb-item active" aria-current="page">Project</li> -->
								</ol>
							</nav>
						</div>
						<div class="d-flex my-auto">
							<div class=" d-flex right-page">
								<div  >
								<?php
									if($this->session->level=="pic_covid")
									{?>
		 <button onclick='add()' class='btn btn-block btn-warning'  >
		 <i class='fa fa-plus-circle'></i> Tambah</button>
 <?php } ?>
								 
									 
								</div>
								 
							</div>
						</div>
					</div>
					<!-- /breadcrumb -->


					<!-- main-content-body -->
					<div class="main-content-body">
 
					<div class="row" style="padding-bottom:5px">
							<div class="col-md-12">
								<select id='filter' onchange='reload_table()' style='max-width:250px;color:black' class='form-control float-right'>
									<option value=''>--- Tampilkan semua data ---</option>
									<option value='1'>Sudah melakukan tes</option>
									<option value='2'>Belum melakukan tes</option>
								</select>
							</div>
						</div>
						<!-- row -->
						<div class="row row-sm " id="area_lod">
							<div class="col-md-12 col-xl-12">
								<div class="card overflow-hidden review-project">
									<div class="card-body">
										<div class="d-flex justify-content-between">
											<h4 class="card-title mg-b-10">RIWAYAT TEST </h4>
											<i class="mdi mdi-dots-horizontal text-gray"></i>
										</div> 
										<div class="table-responsive mb-0">
											<table id="table" class="table table-hover table-bordered mb-0 text-md-nowrap text-lg-nowrap text-xl-nowrap table-striped ">
												<thead>
													<tr>
														<th>Tanggal input</th>
														<!-- <th>Status Approval</th> -->
														<th>Nama</th>
														<th>NIK </th>
														<th>Ket</th>
														<th>Jenis tes</th>
														<th>Tempat tes</th>
														<th>Hasil</th>
														<th>Opsi</th>
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
        "processing": true, //Feature control the processing indicator.
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
	 
		// {
		// 	  text: 'Input ',
        //         action: function ( e, dt, node, config ) {
        //            download();
        //         },className: 'btn   btn-outline-success  '
        //         }, 
	 
		{
           	text: ' Refresh  ',
           	action: function ( e, dt, node, config ) {
           		reload_table();
           	},className: 'btn  btn-secondary  '
           },
           				 
					 
        ],
        
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('input/getDataExternal');?>",
            "type": "POST",
			"data": function ( data ) {
				data.<?php echo $this->m_reff->tokenName()?>=token;
				data.filter=$("#filter").val();
			  
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
          "targets": [ 0,-1,-2,-3,-4,-5,-6,-7], //last column
          "orderable": false, //set not orderable
        },
        ],
	
      });
	function reload_table()
	{
		 dataTable.ajax.reload(null,false);	
	};
	 
	function add(){	  
			  var url   = "<?php echo site_url("input/viewAddExternal");?>";
							var param = {<?php echo $this->m_reff->tokenName()?>:token};
							$.ajax({
									type: "POST",dataType: "json",data: param, url: url,
									success: function(val){
										token=val['token'];
										 $("#mdl_modal").modal();
										 $("#isi").html(val['data']);
									}
							});	
	}
	function edit(id){
					 	    var url   = "<?php echo site_url("input/viewEditExternal");?>";
							var param = {id:id,<?php echo $this->m_reff->tokenName()?>:token};
							$.ajax({
									type: "POST",dataType: "json",data: param, url: url,
									success: function(val){
										 token=val['token'];
										 $("#mdl_modal").modal();
										 $("#isi").html(val['data']);
									}
							});	
	}

	function hapus(id,nip,akun,kode){
		  
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
									  
									 
											  
							var url   = "<?php echo site_url("input/hapus_external");?>";
							var param = {kode:kode,id:id,nip:nip,<?php echo $this->m_reff->tokenName()?>:token};
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



				
	function acc(id,sts,akun){
	 
	 if(sts==1){
		 msg ="Setuji ";
	 }else{
		 msg = "Batalkan ";
	 }
	 
	 swal({
							 title: msg+' ?',
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
								 swal("success", {
									 icon: "success",
									 buttons : {
										 confirm : {
											 className: 'btn btn-success'
										 }
									 }
								 });
								 
								
									   
					   var url   = "<?php echo site_url("input/setStsAccFam");?>";
					   var param = {id:id,sts:sts,<?php echo $this->m_reff->tokenName()?>:token};
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
		   
				
	</script>
	
	<div class="modal effect-newspaper" id="mdl_modal" style="z-index:1500" role="dialog">
                <div class="modal-dialog modal-lg" id="area_modal" role="document">
				 <div id="isi"></div>
				</div>
				</form>
   </div><!-- /.modal-dialog --> 