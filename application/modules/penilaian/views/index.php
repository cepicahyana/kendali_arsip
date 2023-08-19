<script>
$("body").removeClass("sidebar-main");
</script>
<p class="alert alert-danger" style="text-align:center;color:black">  Periode peniliaian : <?=$range=$this->m_reff->pengaturan(39)?> </p>
<div class="card-body iq-card">
		<div class="row">
		<div class="col-md-3 mb-3">
		<?php

		$range = $this->mdl->cekPriode($range);

		$YNow = date('Y');
		for ($thn=$YNow; $thn > ($YNow-10); $thn--) { 
		    $options[$thn] = $thn;
		}

		$attr = array('id' => 'tahun', 'onchange'=>'reload_table()', 'class' => 'form-controls', 'required' => 'required', 'style' => 'width:100%;');
		echo form_dropdown('tahun', $options, set_value('tahun'), $attr);
		unset($options);
		unset($attr);?>	
		</div>

		<div class="col-md-3 mb-3">
		<?php
		$options = [
			// ''=>'-- Pilih Semester--',
			'1'=>'Semester 1',
			'2'=>'Semester 2',
		];

		if(date('m')>6){
			$value_sms = 2;
		}else{
			$value_sms = 1;
		}

		$attr = array('id' => 'semester', 'onchange'=>'reload_table()', 'class' => 'form-controls', 'required' => 'required', 'style' => 'width:100%;');
		echo form_dropdown('sms', $options, $value_sms, $attr);
		unset($options);
		unset($attr);
		?></div>

		<div class="col-md-3 mb-3">
				<?php
		$options = [
			''=>'-- Status penilaian --',
			'1'=>'Sudah dinilai',
			'2'=>'Belum dinilai',
		];

		$attr = array('id' => 'semester', 'onchange'=>'reload_table()', 'class' => 'form-controls', 'required' => 'required', 'style' => 'width:100%;');
		echo form_dropdown('sts', $options, set_value('sts'), $attr);
		unset($options);
		unset($attr);
		?></div>

		<div class="col-md-3 mb-3">
			<?php
				$dtBidang[null] = "-- Filter Bidang   --";
				$db=$this->m_reff->list_bagian(2)->result();
				foreach($db as $db){
					$dtBidang[$db->bagian] = $db->bagian;
				}
			  	echo form_dropdown("bidang", $dtBidang, set_value('bidang'), "class='text-black form-controls' onchange='reload_table()'") ?>
		</div>
		
		<!-- <div class="col-md-4 mb-3">
			<?php
			   $dtJk[null] = "-- Filter  gender--";
			   $dtJk["l"] = "Laki-Laki";
			   $dtJk["p"] = "Perempuan";

			   echo form_dropdown("jk", $dtJk, "", "class='text-black form-control' onchange='reload_table()' ") ?>
		</div> -->
		 

		<?php 
	 	$level = $this->session->userdata("level");
	 	// status admin
	 	if ($level === 'admin_ppnpn' or $level=='super_admin' or !$this->session->userdata('kode_istana')): ?>
		<div class="col-md-3 mb-3">
			<?php
			$db=$this->m_reff->list_istana()->result();
			$dtIstana[null] = "-- Filter Instana   --";
			foreach($db as $db){
				$dtIstana[$db->kode] = $db->istana;
			}
		  	echo form_dropdown("istana", $dtIstana, "", "class='text-black form-controls' onchange='reload_table()' style='width:100%;'") ?>
		</div>
		<?php endif ?>
		<?php 
	 	$level = $this->session->userdata("level");
	 	// status admin
	 	if ($level === 'admin_ppnpn' or $level=='super_admin' or !$this->session->userdata('kode_biro')): ?>
		<div class="col-md-3 mb-3">
			<?php
			$db=$this->m_reff->list_biro()->result();
			$dtBiro[null] = "-- Filter Biro   --";
			foreach($db as $db){
				$dtBiro[$db->kode] = $db->biro;
			}
		  	echo form_dropdown("biro", $dtBiro, "", "class='text-black form-controls' onchange='reload_table()' style='width:100%;'") ?>
		</div>
		<?php endif ?>


	</div>
</div>

		 <div class="  card" id="area_lod">
		<div class="card-body">
 		<div class="col-md-12 table-responsive">
 			<table id="table" class="tablecool   table-sm" style="width:100%">
 				<thead>
 					<th width="30px">NO</th>
					 <th>Istana </th>
 					<th>Bagian</th>
 					<th>Tahun - Semester </th>
 					<th>Nama</th>
 					
 					<th>Hasil Penilaian</th>
 				 
 					<th>Predikat</th>
 					<th>Catatan</th>
 					<th>ACTION</th>
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
 				className: '  btn-sm    btn   btn-light   '
 			},
			 {   extend: 'excel',title: 'Penilaian',
 				text: 'Export excell', exportOptions: {
                    columns: [0, 1, 2,3,4,5,6,7],
					// targets: [0, 1, 2,3,4,5,6,7], //last column
                },
 				className: 'btn btn-light  btn-sm  '
 			},
			 {   extend: 'pdf',title: 'Penilaian',
 				text: 'Export Pdf', exportOptions: {
                    columns: [0, 1, 2,3,4,5,6,7],
					// targets: [0, 1, 2,3,4,5,6,7], //last column
                },
 				className: 'btn btn-light   btn-sm '
 			},
			/*{
 				text: ' Tambah ',
 				action: function(e, dt, node, config) {
 					tambah();
 				},
 				className: '  font14 btn btn-sm ti-plus bg-teal  '
 			},*/

 		],

 		// Load data for the table's content from an Ajax source
 		"ajax": {
 			"url": "<?php echo site_url('penilaian/getData'); ?>",
 			"type": "POST",
 			"data": function(data) {
 				data.<?php echo $this->m_reff->tokenName()?>=token;
 				data.istana = $('[name="istana"]').val();
 				data.biro = $('[name="biro"]').val();
 				data.jk = $('[name="jk"]').val();
 				data.tahun = $('[name="tahun"]').val();
 				data.sms = $('[name="sms"]').val();
 				data.sts = $('[name="sts"]').val();
 				data.bidang = $('[name="bidang"]').val();
 			 
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
 				"targets": [0, 1, 2,3,4,5,6], //last column
 				"orderable": false, //set not orderable
 			},
 			//  { "width": "10px", "targets": 0 },
 			//  { "width": "25%", "targets": 1 },
 			//  { "width": "100", "targets": 5 },
 			//  { "width": "70", "targets": 5 },
			 <?php
			 if($range==false){?>
			 { "visible": false, "targets": 8 }
			 <?php } ?>
 		],

 	});

 	function reload_table() {
 		dataTable.ajax.reload(null, false);
 	};
 </script>

<script>
function tambah(){
    $("#mdl_formSubmit").modal();
    $("#mdlValue").html("mohon tunggu...");
    $.post("<?php echo base_url() ?>penilaian/form_tambah", function(data, status){
	    $("#mdlValue").html(data);
	});
}
</script>

<script>
function simpan() {
	$("#mdl_formSubmit").modal();
	$("#mdlValue").html("mohon tunggu...");
	var url   = "<?php echo site_url("penilaian/detail");?>";
	var param = {<?php echo $this->m_reff->tokenName()?>:token};
	$.ajax({
		type: "POST",dataType: "json",data: param, url: url,
		success: function(val) {
			token=val['token'];
			$("#mdlValue").html(val['data']);
		}
	});
}
</script>

<script>
function detail(nip, tahun, sms, id) {
	$("#mdl_formSubmit").modal();
	$("#mdlValue").html("mohon tunggu...");
	$.post("<?php echo base_url() ?>penilaian/detail", {
		nip: nip,
		tahun: tahun,
		sms: sms,
		id: id,
		<?php echo $this->m_reff->tokenName()?>:token
	}, function(data, status) {
		token=data['token'];
		$("#mdlValue").html(data);
	});
}
</script>

 <script>
 	function edit(nip, tahun, sms, id) {
 		$("#mdl_formSubmit").modal();
 		$("#mdlValue").html("mohon tunggu...");

 		var url   = "<?php echo site_url("penilaian/form_edit");?>";
		var param = {
			nip: nip,
 			tahun: tahun,
 			sms: sms,
 			id: id,
 			<?php echo $this->m_reff->tokenName()?>:token
 		};
 		$.ajax({
			type: "POST",dataType: "json",data: param, url: url,
			success: function(val) {
				token=val['token'];
				$("#mdlValue").html(val['data']);
			}
		});


 	}
 </script>

 <script>
 	function hapus(id, nama) {
 		alertify.confirm("<center> Hapus Hasil Penilaian untuk <br>" + nama + " ?</center>", function() {
 			$.post("<?php echo base_url() ?>penilaian/hapus", {
 				id: id,
 				<?php echo $this->m_reff->tokenName()?>:token
 			}, function(data, status) {
 				token=data['token'];
 				notif("Berhasil dihapus!", "Info", "success");
 				reload_table();
 			});
 		});

 	}
 </script>

<script>
 	function importIndikator(tahun, semester) {
 		$("#mdl_formSubmit").modal();
 		$("#mdlValue").html("mohon tunggu...");

 		var url   = "<?php echo site_url("mipenilaian/copydata");?>";
		var param = {
			tahun: tahun,
 			semester: semester,
 			<?php echo $this->m_reff->tokenName()?>:token };
 		$.ajax({
			type: "POST",dataType: "json",data: param, url: url,
			success: function(val) {
				token=val['token'];
				// $("#mdlValue").html(val['data']);
				notif("Indikator sudah ditambahkan");
				$("#mdl_formSubmit").modal("hide");
			}
		});

 	}
 </script>

 <script>
	function loadIndikatorPenilaian() {
		var id = $('#penilaian_id').val();
	    var tahun = $('#tahun').val();
	    var semester = $('#semester').val();
	    //alert(tglhis);
	    $.post("<?php echo site_url("penilaian/get_indikator/"); ?>", {
	    	id: id,
	        tahun: tahun,
	        semester: semester,
	        <?php echo $this->m_reff->tokenName()?>:token
	    }, function(data) {
	    	token=data['token'];
	        $("#indikator").html(data['indikator']);
	        inputPenilaian();
	        inputPenilaian2()
	    	//jmlTabel();
	    	//fbobot();
	    	
	    },"json");	
	}

	function loadIndikatorPenilaianEdit() {
	    var id = $('#penilaian_id').val();
	    var tahun = $('#tahun').val();
	    var semester = $('#semester').val();
	    //alert(tglhis);
	    $.post("<?php echo site_url("penilaian/get_indikator_edit/"); ?>", {
	    	id: id,
	        tahun: tahun,
	        semester: semester,
	        <?php echo $this->m_reff->tokenName()?>:token
	    }, function(data) {
	    	token=data['token'];
	        $("#indikator").html(data['indikator']);
	        inputPenilaian();
	        inputPenilaian2()
	    	//jmlTabel();
	    	//fbobot();
	    	
	    },"json");	
	}
</script>

<script>
function inputPenilaian() {
    $("tbody#indikator").on("keyup", "input", function() {
		var row = $(this).closest("tr");
		var bobot = parseFloat(row.find(".fbobot").val());
		var skor = parseFloat(row.find(".fskor").val());
		var nilai = (bobot/100) * skor;
		row.find(".fnilai").val(isNaN(nilai) ? 0 : Number(nilai).toFixed(2));

		hitungHasilPenilaian();

    });
}

function inputPenilaian2() {
	$("tbody#indikator").on("change", "input", function() {
		var row = $(this).closest("tr");
		var bobot = parseFloat(row.find(".fbobot").val());
		var skor = parseFloat(row.find(".fskor").val());
		var nilai = (bobot/100) * skor;
		row.find(".fnilai").val(isNaN(nilai) ? 0 : Number(nilai).toFixed(2));

		hitungHasilPenilaian();

    });
}

function hitungHasilPenilaian(){
	var sum = 0;
	var predikat = '';
	var predikat_value = '';
	var sum_tampil = 0;
	var tb = $('tbody#indikator');
	tb.find(".fnilai").each(function() {
		sum += parseFloat($(this).val());
	});


	sum_tampil = Number(sum).toFixed(2);
	$('#hasil_penilaian_txt').text(sum_tampil);
	$('#hasil_penilaian').val(sum_tampil);
	// console.log(sum_tampil);

	// if (sum_tampil >= 90) {
	// 	predikat = 'Amat baik';
	// 	predikat_value = 'A';
	// } else if(sum_tampil >=80 && sum_tampil < 90) {
	// 	predikat = 'Baik';
	// 	predikat_value = 'B';
	// } else if (sum_tampil >= 60 && sum_tampil < 80) {
	// 	predikat = 'Cukup';
	// 	predikat_value = 'C';
	// } else if (sum_tampil >= 50 && sum_tampil < 60) {
	// 	predikat = 'Kurang';
	// 	predikat_value = 'D';
	// } else {
	// 	predikat = 'Buruk';
	// 	predikat_value = 'E';
	// }

	if (sum_tampil >= 71) {
		predikat = 'Baik';
		predikat_value = 'A';
	} else if(sum_tampil >=51) {
		predikat = 'Cukup';
		predikat_value = 'B';
	}  else {
		predikat = 'Kurang';
		predikat_value = 'C';
	}

	$('#predikat_txt').text(predikat);
	$('#predikat').val(predikat_value);
}
</script>


<script>

	function jmlTabel() {
		var tb = $('tbody#indikator');
		var size = tb.find("tr").length;
		  // console.log("Number of rows : " + size);
		  


		tb.find("tr").each(function(index, element) {
		  	var colBobot = $('.fbobot', element).val();
		  	var colSkor = $('.fskor', element).val();
		  	var nilai = ((colBobot/100)*colSkor);
		  	$('.fnilai', element).val(Number(nilai).toFixed(2));

			// console.log("bobot : "+colBobot);
			// console.log("skor : "+colSkor);

		    /*var colSize = $(element).find('td').length;
		    console.log("  Number of cols in row " + (index + 1) + " : " + colSize);
		    $(element).find('td').each(function(index, element) {
		      var colVal = $(element).text();
		      console.log("    Value in col " + (index + 1) + " : " + colVal.trim());
		    });*/

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