<?php
if (empty($refresh)) {
	$id 	= $this->m_reff->san($this->input->post("id"));
	$detail	= $this->mdl->getDetail($id);
}
?>


<div class="card">
	<div class="row card-body" style='padding-top:10px;padding-bottom:20px'>
		<form action="javascript:submitForm('modal')" id="modal" url="<?php echo base_url() ?>ars_master/update_pemusnahan" method="post" enctype="multipart/form-data">
			<input type="hidden" value="<?php echo $id ?>" name="id">
			<input type="hidden" id="formToken" name="<?php echo $this->m_reff->tokenName() ?>" value="<?php echo $this->m_reff->getToken() ?>">
			<div class="row">
				<div class="col-xl-7 col-lg-12" id="area_lod">
					<h5>Arsip yang akan Dimusnahkan</h5>
					<hr class="mt-1">
					<table id='tableItemArsip' width="100%" class="tabel black table-striped table-bordered table-hover dataTable">
						<thead>
							<tr>
								<th class='thead' width='15px'>No</th>
								<th class='thread'>Klasifikasi</th>
								<th class='thread'>Uraian Informasi Arsip</th>
								<th class='thread text-center' width='100px'>Kurun Waktu</th>
							</tr>
						</thead>
					</table>
				</div>
				<div class="col-xl-5 col-lg-12">
					<h5>Informasi Pemusnahan</h5>
					<hr class="mt-1">

					<?php $this->load->view('ars_penyusutan/mini_informasi_pemusnahan', $detail) ?>
				</div>
			</div>
			<div align="right">
				<hr>
				<a href="<?= base_url(); ?>ars_penyusutan/pemusnahan"" type=" button" class="btn btn-default menuclick pd-x-30 mg-r-5 mg-t-5"><i class='fa fa-arrow-left'></i> Kembali</a>
			</div>
		</form>
	</div>
</div>
<script type="text/javascript">
	// function action_form(id = null) {
	//     $("#mdl_modal").modal("show");
	//     $("#response").html(cantik());
	//     if (id) {
	//         $(".modal-title").html("Update data");
	//     } else {
	//         $(".modal-title").html("Tambah data");
	//     }
	//     var url = "< ?php echo site_url("ars_master/form_tingkat_perkembangan"); ?>";
	//     var param = {
	//         < ?php echo $this->m_reff->tokenName() ?>: token,
	//         id: id
	//     };
	//     $.ajax({
	//         type: "POST",
	//         dataType: "json",
	//         data: param,
	//         url: url,
	//         success: function(val) {
	//             $("#response").html(val['data']);
	//             token = val['token'];
	//         }
	//     });
	// }
	$("#btnAddArchive").on("click", function() {
		$("#mdl_modal").modal("show");
		$("#response").html(cantik());


		var url = "<?php echo site_url('ars_penyusutan/pemusnahan/form_add_archivepemusnahan'); ?>";
		var param = {
			<?php echo $this->m_reff->tokenName() ?>: token,
			// id: id
		};

		$.ajax({
			type: "POST",
			dataType: "json",
			data: param,
			url: url,
			success: function(data) {
				$("#response").html(data['data']);
				$(".modal-title").html(data['title']);
				token = data['token'];
				// token = data["token"];
				// $('.modal.aside').remove();
				// history.replaceState(data["title"], data["title"], url);
				// $('title').html(data["title"]);
				// $(".content").html(data["data"]);
			}
		});

	});
	var dataTable = $('#tableItemArsip').DataTable({
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
			},

			{
				extend: 'excel',
				text: '<i class="fe fe-download"></i>',
				exportOptions: {
					columns: [0, 1]
				},
				className: 'btn  btn-secondary-light'
			},
		],
		"ajax": {
			"url": "<?php echo site_url('ars_penyusutan/pemusnahan/getDataBerkas'); ?>",
			"type": "POST",
			"data": function(data) {
				data.<?php echo $this->m_reff->tokenName() ?> = token;
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