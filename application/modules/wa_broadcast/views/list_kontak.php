<?php 
$get_controller = $this->router->fetch_class(); ?>

					<!-- breadcrumb -->
					<div class="breadcrumb-header justify-content-between">
						<div>
							<h4 class="content-title mb-2"> Data Kontak </h4>
							<!-- <nav aria-label="breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="#">Input data keluarga yang akan ditest</a></li>
									<li class="breadcrumb-item active" aria-current="page">Project</li>
								</ol>
							</nav> -->
						</div>
					</div>
					<!-- /breadcrumb -->


					<!-- main-content-body -->
					<div class="main-content-body">
						<div id="area_lod">
							<div class="row">
								<div class="col-md-3 mb-3">
					 				<?php
										$dtIstana[null] = "-- Filter Instana Negara --";
										$db=$this->m_reff->list_istana()->result();
										foreach($db as $db){
											$dtIstana[$db->kode] = $db->istana;
										}
									  	echo form_dropdown("istana", $dtIstana, "", "class='text-black form-control' onchange='reload_table()'") ?>
					 			</div>
					 			<!-- <div class="col-md-3 mb-3">
									 
										$dtInstansi[null] = "-- Filter Instansi --";
										$db=$this->m_reff->list_instansi()->result();
										foreach($db as $db){
											$dtInstansi[$db->instansi] = $db->instansi;
										}
									  	echo form_dropdown("instansi", $dtInstansi, "", "class='text-black form-control' onchange='reload_table()'") ?>
								</div> -->
								<div class="col-md-3 mb-3">
									<?php
										$dtBiro[null] = "-- Filter Biro --";
										$db=$this->m_reff->list_biro()->result();
										foreach($db as $db){
											$dtBiro[$db->kode] = $db->biro;
										}
									  	echo form_dropdown("biro", $dtBiro, "", "class='text-black form-control' onchange='reload_table()'") ?>
								</div>
								<div class="col-md-3 mb-3">
									<?php
										$dtBagian[null] = "-- Filter Bagian --";
										$db=$this->m_reff->list_bagian()->result();
										foreach($db as $db){
											$dtBagian[$db->bagian] = $db->bagian;
										}
									  	echo form_dropdown("bagian", $dtBagian, "", "class='text-black form-control' onchange='reload_table()'") ?>
								</div>
							</div>
							<!-- row -->
							<div class="card overflow-hidden review-project">
								<div class="card-body">
									<!-- <div class="d-flex justify-content-between">
										<h4 class="card-title mg-b-10">RIWAYAT TEST ANGGOTA KELUARGA PEGAWAI</h4>
										<i class="mdi mdi-dots-horizontal text-gray"></i>
									</div> --> 
									<div class="table-responsive mb-0">
										<table id="table" class="table table-hover table-bordered mb-0 text-md-nowrap text-lg-nowrap text-xl-nowrap table-striped ">
											<thead>
												<tr>
													<th width="30px">
														<input type="checkbox" value="ya" id="selectall"/>
													</th>
													<th>NAMA </th>
								 					<th>STATUS</th>
								 					<th>BAGIAN</th>
					                                <th>JABATAN</th>
					                                <th>BIRO</th>
					                         
					                                <th>ISTANA</th>
								 					<th>HP</th>
								 					<th>EMAIL</th>
												</tr>
											</thead>
										</table>
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
		"searching": true,
		"lengthMenu":
		[
			[10, 30, 50, 100],
	 		[10, 30, 50, 100],
	 	],
        dom: 'Blfrtip',
		// Buttons with Dropdown
		buttons: [
			{
				text: '',
				action: function(e, dt, node, config) {
					reload_table();
				},
				className: 'btn btn-light ti-reload '
			},
			{
				text: ' Kirim Broadcast ',
				action: function(e, dt, node, config) {
					broadcast();
				},
				className: 'btn btn-success '
			},
		],
        
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('wa_broadcast/getData_list_kontak');?>",
            "type": "POST",
			"data": function ( data ) {
				data.istana = $('[name="istana"]').val();
            	data.instansi = $('[name="instansi"]').val();
            	data.biro = $('[name="biro"]').val();
            	data.bagian = $('[name="bagian"]').val();
				data.<?php echo $this->m_reff->tokenName()?>=token;
			  
		},
		beforeSend: function() {
            loading("area_lod");
        },
			complete: function(data) {
				token=data.responseJSON.token;
				unblock('area_lod');
				$("#md_checkbox").attr("checked", false);
				$(".pilihsemua").val("ya");
            },
			
        },

        //Set column definition initialisation properties.
        "columnDefs": [
	        {
				"targets": [ 0,-1], //last column
				"orderable": false, //set not orderable
	        },
        ],
	
      });

	function reload_table()
	{
		 dataTable.ajax.reload(null,false);	
	};
	</script>

	<script type="text/javascript">
	function broadcast(){
		var checkbox_value = ""; var i=0;
		$("[name='pilih[]']").each(function () {
			var ischecked = $(this).is(":checked");
			if (ischecked) {
				checkbox_value += $(this).val() + ",";
				i++;
			}
		});

		var url   = "<?php echo site_url($get_controller."/form_broadcast");?>";
		var param = {data:checkbox_value, <?php echo $this->m_reff->tokenName()?>:token};
		$.ajax({
				type: "POST",dataType: "json",data: param, url: url,
				success: function(val){
					token=val['token'];
					$("#mdl_modal").modal();
					$("#isi").html(val['data']);
				}
		});
	}

	$(document).ready(function () {
	    $('#selectall').click(function () {
	        $('.selectedId').prop('checked', this.checked);
	    });

	    $('.selectedId').change(function () {
	        var check = ($('.selectedId').filter(":checked").length == $('.selectedId').length);
	        $('#selectall').prop("checked", check);
	    });
	});
	</script>
	
	<div class="modal effect-newspaper" id="mdl_modal" style="z-index:1500" role="dialog">
    <div class="modal-dialog modal-lg" id="area_modal" role="document">
		<div id="isi"></div>
	</div>
	</form>
</div><!-- /.modal-dialog --> 