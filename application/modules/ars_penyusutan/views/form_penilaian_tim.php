<?php
if (empty($refresh)) {
	$id 	= $this->m_reff->san($this->input->post("id"));
	$detail	= $this->mdl->getDetail($id);
}
?>


<div class="card">
	<div class="row card-body" style='padding-top:10px;padding-bottom:20px'>
		<form action="<?php echo base_url() ?>ars_penyusutan/pemusnahan/update_form_penilaian_tim" id="form-pemusnahan" url="<?php echo base_url() ?>ars_penyusutan/pemusnahan/update_form_penilaian_tim" method="post" enctype="multipart/form-data">
			<input type="hidden" value="<?php echo $id ?>" name="id">
			<input type="hidden" value="<?php echo $detail->uuid ?>" name="uuid">
			<input type="hidden" id="formToken" name="<?php echo $this->m_reff->tokenName() ?>" value="<?php echo $this->m_reff->getToken() ?>">
			<div class="row">
				<div class="col-xl-7 col-lg-12" id="area_lod">
					<div class="border">
						<div class="bg-gray-300 nav-bg">
							<nav class="nav nav-tabs">
								<a class="nav-link active" data-bs-toggle="tab" href="#tab_usulmusnah">Usul Musnah</a>
								<a class="nav-link" data-bs-toggle="tab" href="#tab_ditangguhkan">Tangguhkan</a>
							</nav>
						</div>

						<div class="card-body tab-content">
							<div class="tab-pane active show" id="tab_usulmusnah">
								<div class="col-md-12" id="area_lod">
									<h5>Arsip yang akan Dimusnahkan</h5>
									<hr class="mt-1">
									<table id='table_usulmusnah' width="100%" class="tabel black table-striped table-bordered table-hover dataTable">
										<thead>
											<tr>
												<th class='thread' width='15px'>Pilih</th>
												<th class='thread'>Klasifikasi</th>
												<th class='thread'>Uraian Informasi Arsip</th>
												<th class='thread text-center' width='100px'>Kurun Waktu</th>
											</tr>
										</thead>
									</table>
								</div>
							</div>
							<div class="tab-pane" id="tab_ditangguhkan">
								<div class="col-md-12" id="area_lod">
									<h5>Arsip yang akan Dimusnahkan</h5>
									<hr class="mt-1">
									<table id='table_ditangguhkan' width="100%" class="tabel black table-striped table-bordered table-hover dataTable">
										<thead>
											<tr>
												<th class='thread' width='15px'>Pilih</th>
												<th class='thread'>Klasifikasi</th>
												<th class='thread'>Uraian Informasi Arsip</th>
												<th class='thread text-center' width='100px'>Kurun Waktu</th>
											</tr>
										</thead>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-5 col-lg-12">
					<h5>Informasi Pemusnahan</h5>
					<hr class="mt-1">

					<div class="row row-xs mg-b-20 align-items-center">
						<div class="col-md-4">
							<label class="form-label mg-b-0 text-black">SK Penilaian Tim Pemusnahan</label>
						</div>
						<div class="col-md-8 mg-t-5 mg-md-t-0">
							<input class="form-control text-black" name="attach_sk_penilaian_tim" placeholder="SK Penilaian Tim Pemusnahan..." type="file" value="">
						</div>
					</div>

					<?php $this->load->view('ars_penyusutan/mini_informasi_pemusnahan') ?>
				</div>
			</div>
			<div align="right">
				<hr>
				<a href="<?= base_url(); ?>ars_penyusutan/pemusnahan"" type=" button" class="btn btn-default menuclick pd-x-30 mg-r-5 mg-t-5" id="btn-kembali"><i class='fa fa-arrow-left'></i> Kembali</a>
				<button type="button" role="button" onclick="save_form()" class="btn btn-primary pd-x-30 mg-r-5 mg-t-5"><i class='fa fa-save'></i> Simpan</button>
			</div>
		</form>
	</div>
</div>
<!-- datatable -->
<script type="text/javascript">
	var dataTable_usulmusnah = $('#table_usulmusnah').DataTable({
		"paging": true,
		"processing": false,
		"ordering": false,
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
			"lengthMenu": "&nbsp;&nbsp;Tampil _MENU_ Baris",
		},
		"serverSide": true,
		"responsive": true,
		"searching": true,
		// "lengthMenu": [
		//     [10, 20, 30, 50],
		//     [10, 20, 30, 50],
		// ],
		dom: 'Blfrtip',
		buttons: [{
			text: '<i class="fe fe-refresh-cw"></i>    ',
			action: function(e, dt, node, config) {
				reload_table();
			},
			className: 'btn btn-secondary-light'
		}, ],
		"ajax": {
			"url": "<?php echo site_url('ars_penyusutan/pemusnahan/getDataBerkasPenilaian'); ?>",
			"type": "POST",
			"data": function(data) {
				data.<?php echo $this->m_reff->tokenName() ?> = token;
				data.proses = true;
				data.tipe = 'tim_usulmusnah';
				data.uuid = '<?= $detail->uuid ?>';
			},
			beforeSend: function() {
				loading("area_lod");
			},
			complete: function(data) {
				token = data.responseJSON.token;
				unblock('area_lod');
			},
		},
		"columnDefs": [{
			"targets": [], //last column
			"orderable": false, //set not orderable
		}, ],
	});

	var dataTable_ditangguhkan = $('#table_ditangguhkan').DataTable({
		"paging": true,
		"processing": false,
		"ordering": false,
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
			"lengthMenu": "&nbsp;&nbsp;Tampil _MENU_ Baris",
		},
		"serverSide": true,
		"responsive": true,
		"searching": true,
		// "lengthMenu": [
		//     [10, 20, 30, 50],
		//     [10, 20, 30, 50],
		// ],
		dom: 'Blfrtip',
		buttons: [{
			text: '<i class="fe fe-refresh-cw"></i>    ',
			action: function(e, dt, node, config) {
				reload_table();
			},
			className: 'btn btn-secondary-light'
		}, ],
		"ajax": {
			"url": "<?php echo site_url('ars_penyusutan/pemusnahan/getDataBerkasPenilaian'); ?>",
			"type": "POST",
			"data": function(data) {
				data.<?php echo $this->m_reff->tokenName() ?> = token;
				data.proses = true;
				data.tipe = 'tim_ditangguhkan';
				data.uuid = '<?= $detail->uuid ?>';
			},
			beforeSend: function() {
				loading("area_lod");
			},
			complete: function(data) {
				token = data.responseJSON.token;
				unblock('area_lod');
			},
		},
		"columnDefs": [{
			"targets": [], //last column
			"orderable": false, //set not orderable
		}, ],
	});
</script>

<!-- proses -->
<script>
	function pilihBerkas(ini) {
		$("#mdl_modal").modal("show");
		$("#response").html(cantik());


		var url = "<?php echo site_url('ars_penyusutan/pemusnahan/penilaian'); ?>";
		var param = {
			<?php echo $this->m_reff->tokenName() ?>: token,
			uuid: $(ini).val(),
			tipe: $(ini).attr('data-tipe')
		};

		$.ajax({
			type: "POST",
			dataType: "json",
			data: param,
			url: url,
			success: function(data) {
				dataTable_usulmusnah.ajax.reload();
				dataTable_ditangguhkan.ajax.reload();

				$('.modal').modal('hide')
			}
		});

	}

	function save_form() {
		$('#form-pemusnahan').submit()
	}

	$('#form-pemusnahan').submit(function(e) {
		e.preventDefault();
		$("#mdl_modal").modal("show");
		$("#response").html(cantik());
		var url = "<?php echo site_url('ars_penyusutan/pemusnahan/update_form_penilaian_tim'); ?>";

		var formData = new FormData(this);

		$.ajax({
			type: "POST",
			dataType: "json",
			data: formData,
			url: url,
			processData: false,
			contentType: false,
			success: function(data) {
				$("#response").html(data['data']);
				$(".modal-title").html(data['title']);
				token = data['token'];
				$('.modal.aside').remove();
				history.replaceState(data["title"], data["title"], url);
				// $('title').html(data["title"]);
				// $(".content").html(data["data"]);
				$('.modal').modal('hide')

				$("#btn-kembali").click()
			}
		});

	})
</script>

<div class="modal effect-scale" id="mdl_modal" role="dialog">
	<div class="modal-dialog modal-dialog-centered modal-xl" role="document">
		<div class="modal-content" id="area_modal">
			<div class="modal-header">
				<h6 class="modal-title"> </h6><button type="button" role="button" aria-label="Close" class="btn-close" data-bs-dismiss="modal"><span aria-hidden="true">×</span></button>
			</div>
			<div id="response"></div>
		</div>
	</div>
</div>