<?php
$dp = $this->db->get_where("tm_rs",array("id"=>$this->session->userdata("id")))->row();
  $nama = isset($dp->nama)?($dp->nama):"";
  $op	  = strpos(strtolower($nama),"bunda");
	if($op!==false){
		$upload =  true;
	}else{
		$upload	= false;
	}


if(!isset($dp)){ return false;}
$level = $this->session->userdata("level");
 
?>


					<!-- breadcrumb -->
					<div class="breadcrumb-header justify-content-between">
						<div>
							<h4 class="content-title mb-2"><i class="fa fa-home"></i> <?php echo $dp->nama?></h4>
							<nav aria-label="breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="#">Data yang akan menjalani tes hari ini</a></li>
									<!-- <li class="breadcrumb-item active" aria-current="page">Project</li> -->
								</ol>
							</nav>
						</div>
					 
					</div>
					<!-- /breadcrumb -->


					<!-- main-content-body -->
					<div class="main-content-body">
<center>
							<div class="card card-body bg-successx">
								<span>
									<span class="text-black">  filter tanggal upload hasil tes  </span>
									<input onchange="reload_table()" type="text" id="range" style="width:400px;text-align:center;font-size:13px;font-weight:bold;color:black" class="form-control">
								</span>
							</div>
</center>

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
														<th>Nama</th>
														<th>NIK</th>
														<th>Jenis Test</th>
														<th>Keperluan Test</th>
														<th>Hasil</th>
														<th>Upload</th>
														<th  width="90px">Tanggal Upload Hasil</th>
														<th width="90px">Tanggal pengajuan</th>
														
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
						
				
  <script type="text/javascript">
    
	setTimeout(function(){ 
		document.getElementById("scand").focus();
	}, 1000);
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
                },className: 'btn   btn-secondary  '
                }, 
				<?php
				if($upload==='truexxx'){ ?>
				{
			  text: 'Download data belum tes ',
                action: function ( e, dt, node, config ) {
                   download_data();
                },className: 'btn   btn-success  '
                }, 
				{
			  text: 'Upload hasil tes',
                action: function ( e, dt, node, config ) {
                   upload_data();
                },className: 'btn   btn-warning  '
                }, 
	 <?php } ?>
					 
					 
        ],
        
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('data_test/getData');?>",
            "type": "POST",
			"data": function ( data ) {
				data.<?php echo $this->m_reff->tokenName()?>=token;
				data.filter=3;
				data.range=$("#range").val();
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

	function download_data(){
		window.location.href="<?php echo base_url()?>data_test/download_data";
	}
 

	function upload_data(){
				$("#mdl_modal").modal("hide");
			    var url   = "<?php echo site_url("data_test/upload_data");?>";
				var param = {<?php echo $this->m_reff->tokenName()?>:token};
				$.ajax({
						type: "POST",dataType: "json",data: param, url: url,
						success: function(val){
							$("#mdl_modal").modal();
							$("#isi").html(val["data"]);
							token=val['token'];
						}
				});	
					}



	function upload(kode,nama,kode_jenis,nik,id_hub,id,nip){
				$("#mdl_modal").modal("hide");
			    var url   = "<?php echo site_url("data_test/upload");?>";
				var param = {niip:nip,id:id,id_hub:id_hub,kode:kode,nama:nama,kode_jenis:kode_jenis,nik:nik,<?php echo $this->m_reff->tokenName()?>:token};
				$.ajax({
						type: "POST",dataType: "json",data: param, url: url,
						success: function(val){
							$("#mdl_modal").modal();
							$("#isi").html(val["data"]);
							token=val['token'];
						}
				});	
}

	function reupload(kode,hasil,nama,kode_jenis,nik,hub,id,nip){
			    var url   = "<?php echo site_url("data_test/upload");?>";
				var param = {nip:nip,id:id,id_hub:hub,kode:kode,hasil:hasil,nama:nama,kode_jenis:kode_jenis,nik:nik,<?php echo $this->m_reff->tokenName()?>:token};
				$.ajax({
						type: "POST",dataType: "json",data: param, url: url,
						success: function(val){
							$("#mdl_modal").modal();
							$("#isi").html(val["data"]);
							token=val['token'];
						}
				});		

}

 </script>
	
	<div class="modal effect-flip-vertical" id="mdl_modal" style="z-index:1500" role="dialog">
                <div class="modal-dialog modal-lg" id="area_modal" role="document">
				 <div id="isi"></div>
				</div>
				</form>
   </div><!-- /.modal-dialog --> 


   	 


 <script>
	$('#range').daterangepicker({
		"showDropdowns": true,
		"autoApply": true,
		ranges: {
			'hari ini': [moment(), moment()],
			'kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
			'7 hari trakhir': [moment().subtract(6, 'days'), moment()],
			'30 hari trakhir': [moment().subtract(29, 'days'), moment()],
			'Bulan ini': [moment().startOf('month'), moment().endOf('month')],
			'Bulan lalu': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
		},
		"locale": {
			"format": "DD/MM/YYYY",
			"separator": " - ",
			"applyLabel": "Apply",
			"cancelLabel": "Cancel",
			"fromLabel": "From",
			"toLabel": "To",
			"autoApply": true,
			"customRangeLabel": "Custom",
			"weekLabel": "W",
			"daysOfWeek": [
				"Su",
				"Mo",
				"Tu",
				"We",
				"Th",
				"Fr",
				"Sa"
			],
			"monthNames": [
				"January",
				"February",
				"March",
				"April",
				"May",
				"June",
				"July",
				"August",
				"September",
				"October",
				"November",
				"December"
			],
			"firstDay": 1
		},
		"alwaysShowCalendars": true,

		"startDate": moment().subtract(6, 'days'),
		"endDate": moment()
	}, function(start, end, label) {
		// console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
	});
</script>

	