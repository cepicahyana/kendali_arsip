<?php
if (empty($refresh)) {
	$id 	= $this->m_reff->san($this->input->post("id"));
	$detail	= $this->mdl->getDetail($id);
	$pegawai	= $this->mdl->getPegawai(['sts_keaktifan' => 'aktif'])->result();
}
?>


<div class="card">
	<div class="row card-body" style='padding-top:10px;padding-bottom:20px'>
		<form action="<?php echo base_url() ?>ars_penyusutan/pemusnahan/update_form_proses_pemusnahan" id="form-pemusnahan" url="<?php echo base_url() ?>ars_penyusutan/pemusnahan/update_form_proses_pemusnahan" method="post" enctype="multipart/form-data">
			<input type="hidden" value="<?php echo $id ?>" name="id">
			<input type="hidden" value="<?php echo $detail->uuid ?>" name="uuid">
			<input type="hidden" id="formToken" name="<?php echo $this->m_reff->tokenName() ?>" value="<?php echo $this->m_reff->getToken() ?>">
			<div class="row">
				<div class="col-xl-7 col-lg-12" id="area_lod">
					<h5>Arsip yang akan Dimusnahkan</h5>
					<hr class="mt-1">
					<table id='table_usulmusnah_anri' width="100%" class="tabel black table-striped table-bordered table-hover dataTable">
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
				<div class="col-xl-5 col-lg-12">
					<h5>Informasi Pemusnahan</h5>
					<hr class="mt-1">

					<!-- template ba -->
					<div class="row row-xs mg-b-20 align-items-center">
						<div class="col-md-4">
							<label class="form-label mg-b-0 text-black">Saksi</label>
						</div>
						<div class="col-md-8 mg-t-5 mg-md-t-0">
							<select class="form-control select2" name="saksi[]" data-placeholder="Saksi Pemusnahan..." multiple>
								<?php if (!empty($pegawai)) : ?>
									<?php foreach ($pegawai as $v) : ?>
										<option value="<?= $v->id ?>"><?= $v->nama ?></option>
									<?php endforeach; ?>
								<?php endif; ?>
							</select>
						</div>
					</div>
					<div class="row row-xs mg-b-20 align-items-center">
						<div class="col-md-4">
							<label class="form-label mg-b-0 text-black">Template</label>
						</div>
						<div class="col-md-8 mg-t-5 mg-md-t-0">
							<a type="button" class="btn btn-info pd-x-30 mg-r-5 mg-t-5" id="btn-template"><i class='fa fa-magic'></i>Generate Template</a>
						</div>
					</div>
					<!-- end template ba -->

					<!-- upload ba -->
					<div class="row row-xs mg-b-20 align-items-center">
						<div class="col-md-4">
							<label class="form-label mg-b-0 text-black">BA Yang Sudah Ditandatangani</label>
						</div>
						<div class="col-md-8 mg-t-5 mg-md-t-0">
							<input class="form-control text-black" name="attach_ba" placeholder="Upload BA yang sudah ditandatangani..." type="file" value="">
						</div>
					</div>
					<!-- end upload ba -->

					<?php $this->load->view('ars_penyusutan/mini_informasi_pemusnahan', $detail) ?>
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
<script type="text/javascript">
	$(function() {
		$('.select2').select2()
	})

	function save_form() {
		$('#form-pemusnahan').submit()
	}

	$('#form-pemusnahan').submit(function(e) {
		e.preventDefault();
		$("#mdl_modal").modal("show");
		$("#response").html(cantik());
		var url = "<?php echo site_url('ars_penyusutan/pemusnahan/update_form_ba'); ?>";

		var formData = new FormData(this);

		$.ajax({
			type: "POST",
			dataType: "json",
			data: formData,
			url: url,
			processData: false,
			contentType: false,
			success: function(data) {
				// $("#response").html(data['data']);
				// $(".modal-title").html(data['title']);
				// token = data['token'];
				$('.modal.aside').remove();
				// history.replaceState(data["title"], data["title"], url);
				// $('title').html(data["title"]);
				// $(".content").html(data["data"]);
				$('.modal').modal('hide')

				$("#btn-kembali").click()
			}
		});

	})

	var dataTable_usulmusnah_anri = $('#table_usulmusnah_anri').DataTable({
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
				data.tipe = 'final_usulmusnah';
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