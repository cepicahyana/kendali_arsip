<div class="col-12">
    <div id="chart"></div>

    <?php
    $nip = $this->m_reff->san($this->input->get("nip"));
    if($nip){
        $dt = $this->mdl->getNilai($nip);
    }else{
        $dt = $this->mdl->getNilaiAkumulasi();
    }

    $nama=$title=$nilai="";
    foreach($dt as $v){
        $nama=$v->nama;
    $title.="'".$v->tahun." - semester ".$v->semester."',";
    $nilai.=$v->hasil_evaluasi.",";
    }
    ?>
    <script>
        Highcharts.chart('chart', {
        chart: {
            type: 'area'
        },
        title: {
            text: '<?=$nama;?>'
        },
        subtitle: {
        
            align: 'right',
            verticalAlign: 'bottom'
        },
        legend: {
            layout: 'vertical',
            
            x: 100,
            y: 70,
            floating: true,
            borderWidth: 1,
            backgroundColor:
                Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF'
        },
        xAxis: {
            categories: [<?=$title;?>]
        },
        yAxis: {
            title: {
                text: 'Nilai'
            }
        },
        plotOptions: {
            area: {
                fillOpacity: 0.5
            }
        },
        credits: {
            enabled: false
        },
        series: [{
            name: '<?=$nama;?>',
            data: [<?=$nilai;?>]
        } ]
    });
    </script>
</div>

<div class="col-12 mt-5">
    
    <div class="row mb-2 mt-3">
     
        
        <div class="col-md-3">
            <?php
            $YNow = date('Y');
            for ($thn=$YNow; $thn > ($YNow-10); $thn--) { 
                $options[$thn] = $thn;
            }

            $attr = array('id' => 'tahun', 'onchange'=>'reload_table_grafik()', 'class' => 'form-controls', 'required' => 'required', 'style' => 'width:100%;');
            echo form_dropdown('tahun', $options, set_value('tahun'), $attr);
            unset($options);
            unset($attr);?>	
        </div> 
        <div class="table-responsive mt-2">
            <table id="table-penilaian"   style="width:100%">
                 
            </table>
        </div>
    </div>
</div>


<script type="text/javascript">

 	var save_method; //for save method string
 	var table;
 	var dataTable = $('#table-penilaian').DataTable({
 		///scrollX: 103,
 		"fixedHeader": true,
 		"paging": false,
 		"processing": true, //Feature control the processing indicator.
 		"language": {
 			"sSearch": "&nbsp;",
 			"searchPlaceholder": "Pencarian...",
 			"processing": ' <span class="sr-only dataTables_processing">Loading...</span> <br><b style="color:black;background:white">Proses menampilkan data<br> Mohon Menunggu..</b>',
 			"oPaginate": {
 				"sFirst": "Hal Pertama",
 				"sLast": "Hal Terakhir",
 				"sNext": "Selanjutnya",
 				"sPrevious": "Sebelumnya"
 			},
 			"sInfo": " ",
 			"sInfoEmpty": "Tidak ada data yang di tampilkan",
 			"sZeroRecords": "Data tidak tersedia",
 			"lengthMenu": "Tampil _MENU_ Baris",
 		},
 		


 		"serverSide": true, //Feature control DataTables' server-side processing mode.
 		"responsive": true,
 		"searching": false,
 		"lengthMenu": [
 			[10, 20, 30,40, 50],
 			[10, 20, 30,40, 50],
 		],
 		dom: 'Blfrtip',
 		buttons: [
		 
			//   'excel',
		 
 			/*{
 				text: ' Refresh ',
 				action: function(e, dt, node, config) {
 					reload_table_grafik();
 				},
 				className: '  font14 btn btn-sm btn-light ti-reload  '
 			},
			{
 				text: ' Tambah ',
 				action: function(e, dt, node, config) {
 					tambah();
 				},
 				className: '  font14 btn btn-sm ti-plus bg-teal  '
 			},*/

 		],

 		// Load data for the table's content from an Ajax source
 		"ajax": {
 			"url": "<?php echo site_url('data_ppnpn/dataGrafik'); ?>",
 			"type": "POST",
 			"data": function(data) {
 				// data.istana = $('[name="istana"]').val();
 				data.tahun = $('[name="tahun"]').val();
                data.nip = "<?=$this->input->get('nip')?>";
 			},
 			beforeSend: function() {
 				loading("area_lod");
 			},
 			complete: function() {
 				unblock('area_lod');
 			},

 		},

 		//Set column definition initialisation properties.
 		"columnDefs": [{
 				"targets": [0], //last column
 				"orderable": false, //set not orderable
 			},
 			//  { "width": "10px", "targets": 0 },
 			//  { "width": "25%", "targets": 1 },
 			//  { "width": "100", "targets": 5 },
 			//  { "width": "70", "targets": 5 },

 		],

 	});

 	

 	function reload_table_grafik() {
 		// dataTable.order([ 1, 'desc' ]).draw();
 		dataTable.ajax.reload(null, false);
 	};
 </script>