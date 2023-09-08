<?php
$id = $this->m_reff->san($this->input->post("id"));
// $data = $this->db->get_where("ars_trx_pemusnahan",array("id"=>$id))->row();
$id = ""; //isset($data->id)?($data->id):null;
$nomor = ""; //isset($data->nama)?($data->nama):null;
$asal = "";
$tujuan = array("Organisasi 1", "Organisasi 2", "Organisasi 3", "Organisasi 4");
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
						<tbody>
							<?php
							for ($i = 0; $i < 9; $i++) {
								$thn = rand(2, 5);
								$no = $i + 1;
								echo "<tr>";
								echo "<td>$no</td>";
								echo "<td>Klasifikasi $no</td>";
								echo "<td>Uraian Arsip $no</td>";
								echo "<td class='text-center'>$thn Tahun</td>";
								echo "</tr>";
							}
							?>
						</tbody>
					</table>
				</div>
				<div class="col-xl-5 col-lg-12">
					<h5>Informasi Pemusnahan</h5>
					<hr class="mt-1">

					<div class="panel panel-default block-content">
						<div class="panel-heading">
							<h6 class="panel-title"><i class="icon-file-plus"></i>Arsip Pemusnahan</h6>
						</div>
						<div class="panel-body">
							<div class="info-buttons">
								<div class="row">
									<div class="col-sm-6">
										<div class="row">
											<div class="col-sm-12">
												<a href="javascript:void(0)" class="ListArchiveJml" data-type="1"><i class="icon-file-zip"></i> <span class="attachment-text">Belum Dimusnahkan</span>
													<strong class="label label-info attachment-number">40</strong></a>
											</div>
											<div class="col-sm-12" style="margin-top: 15px;">
												<div class="progress">
													<div class="progress-bar bg-info" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
												</div>
											</div>
											<div class="col-sm-12" style="margin-top: 15px;">
												<div class="btn btn-xs btn-primary run-softcopy" style="width: 100%">Musnahkan File Softcopy</div>
											</div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="row">
											<div class="col-sm-12">
												<a href="javascript:void(0)" class="ListArchiveJml" data-type="1"><i class="icon-file-zip"></i> <span class="attachment-text">Belum Dimusnahkan</span>
													<strong class="label label-info attachment-number">50</strong></a>
											</div>
											<div class="col-sm-12" style="margin-top: 15px;">
												<div class="progress">
													<div class="progress-bar bg-info" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
												</div>
											</div>
											<div class="col-sm-12" style="margin-top: 15px;">
												<div class="btn btn-xs btn-secondary run-softcopy disabled" style="width: 100%" disabled>File Hardcopy</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="row row-xs mg-b-20 align-items-center">
						<div class="col-md-4">
							<label class="form-label mg-b-0 text-black">Nomor Pemusnahan</label>
						</div>
						<div class="col-md-8 mg-t-5 mg-md-t-0">
							SETPRES/PMSN/2023/0001
						</div>
					</div>
					<div class="row row-xs mg-b-20 align-items-center">
						<div class="col-md-4">
							<label class="form-label mg-b-0 text-black">Tanggal Register Pemusnahan </label>
						</div>
						<div class="col-md-8 mg-t-5 mg-md-t-0">
							<?= date('d-m-Y') ?>
						</div>
					</div>
					<div class="row row-xs align-items-center mg-b-20">
						<div class="col-md-4">
							<label class="form-label mg-b-0 text-black">Tujuan Pemusnahan </label>
						</div>
						<div class="col-md-8">
							<label class="form-label mg-b-0 text-black">UK2</label>
						</div>
					</div>
					<div class="row row-xs align-items-center mg-b-20">
						<div class="col-md-4">
							<label class="form-label mg-b-0 text-black">Inisiator </label>
						</div>
						<div class="col-md-8">
							<label class="form-label mg-b-0 text-black"><?= $this->session->userdata('username') ?></label>
						</div>
					</div>
					<div class="row row-xs align-items-center mg-b-20">
						<div class="col-md-4">
							<label class="form-label mg-b-0 text-black">Organisasi </label>
						</div>
						<div class="col-md-8">
							<label class="form-label mg-b-0 text-black">Biro Umum</label>
						</div>
					</div>
					<div class="row row-xs mg-b-20 align-items-center">
						<div class="col-md-4">
							<label class="form-label mg-b-0 text-black">Tim Pemusnahan</label>
						</div>
						<div class="col-md-8 mg-t-5 mg-md-t-0">
							Pegawai 1, Pegawai 2, Pegawai 3
						</div>
					</div>
					<div class="row row-xs mg-b-20 align-items-center">
						<div class="col-md-4">
							<label class="form-label mg-b-0 text-black">SK Tim Pemusnahan</label>
						</div>
						<div class="col-md-8 mg-t-5 mg-md-t-0">
							<a><i class="fa fa-download"></i></a>
						</div>
					</div>
					<div class="row row-xs mg-b-20 align-items-center">
						<div class="col-md-4">
							<label class="form-label mg-b-0 text-black">SK Penilaian Tim Pemusnahan</label>
						</div>
						<div class="col-md-8 mg-t-5 mg-md-t-0">
							<a><i class="fa fa-download"></i></a>
						</div>
					</div>
					<div class="row row-xs mg-b-20 align-items-center">
						<div class="col-md-4">
							<label class="form-label mg-b-0 text-black">Arsip Usul Musnah Tim Pemusnahan</label>
						</div>
						<div class="col-md-8 mg-t-5 mg-md-t-0">
							<a><i class="fa fa-download"></i></a>
						</div>
					</div>
					<div class="row row-xs mg-b-20 align-items-center">
						<div class="col-md-4">
							<label class="form-label mg-b-0 text-black">SK Penilaian ANRI</label>
						</div>
						<div class="col-md-8 mg-t-5 mg-md-t-0">
							<a><i class="fa fa-download"></i></a>
						</div>
					</div>
					<div class="row row-xs mg-b-20 align-items-center">
						<div class="col-md-4">
							<label class="form-label mg-b-0 text-black">Arsip Yang Dimusnahkan</label>
						</div>
						<div class="col-md-8 mg-t-5 mg-md-t-0">
							<a><i class="fa fa-download"></i></a>
						</div>
					</div>
					<div class="row row-xs mg-b-20 align-items-center">
						<div class="col-md-4">
							<label class="form-label mg-b-0 text-black">SK Penilaian Kasetpres</label>
						</div>
						<div class="col-md-8 mg-t-5 mg-md-t-0">
							<a><i class="fa fa-download"></i></a>
						</div>
					</div>
				</div>
			</div>
			<div align="right">
				<hr>
				<a href="<?= base_url(); ?>ars_penyusutan/pemusnahan"" type=" button" class="btn btn-default menuclick pd-x-30 mg-r-5 mg-t-5"><i class='fa fa-arrow-left'></i> Kembali</a>
				<button type="button" role="button" onclick="" class="btn btn-primary pd-x-30 mg-r-5 mg-t-5"><i class='fa fa-save'></i> Simpan</button>
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
		// "serverSide": true,
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
		// "ajax": {
		//     "url": "< ?php echo site_url('ars_penyusutan/pemusnahan/getData_pemusnahan'); ?>",
		//     "type": "POST",
		//     "data": function(data) {
		//         data.<?php echo $this->m_reff->tokenName() ?> = token;
		//     },
		//     beforeSend: function() {
		//         loading("area_lod");
		//     },
		//     complete: function(data) {
		//         token = data.responseJSON.token;
		//         unblock('area_lod');
		//     },
		// },
		// "columnDefs": [{
		//     "targets": [], //last column
		//     "orderable": false, //set not orderable
		// }, ],
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