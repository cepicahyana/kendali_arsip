<?php
$periode=$this->input->get_post("periode");
$tgl1o=$this->tanggal->range_1($periode);
$tgl1=$this->tanggal->ind($tgl1o,"/");
$tgl2o=$this->tanggal->range_2($periode);
$tgl2=$this->tanggal->ind($tgl2o,"/");
$jml=$this->tanggal->selisih($tgl1o,$tgl2o)+1;
		
		$kode_istana	= $this->input->post("kode_istana");
		$kode_biro	= $this->input->post("kode_biro");
		$sts=$this->input->post("sts");
		$jk=$this->input->post("jk");
		$jabatan=$this->input->post("jabatan");
		$bidang=$this->input->post("bidang");
		$absen=$this->input->post("absen");
?>
<!-- <a target="_blank" class="btn bg-teal pull-right waves-effect"  href="<?php echo base_url()?>presensi/down_guru?periode=<?php echo $periode?>&sts=<?php echo $sts?>&gender=<?php echo $gender?>&jabatan=<?php echo $jabatan?>">DOWNLOAD EXCEL</a> -->
<!-- <a target="_blank" class="btn bg-pink pull-right waves-effect"  href="<?php echo base_url()?>presensi/down_guru2?periode=<?php echo $periode?>&sts=<?php echo $sts?>&gender=<?php echo $gender?>&jabatan=<?php echo $jabatan?>&idguru=">DOWNLOAD PDF</a> -->
<div class="clearfix row"></div>
<div class="table-responsive">
	<table id='tabel' class="tablecool black no-footer DTFC_Cloned">
	<thead class="bg-teal col-black">
	<tr> 
		<th class='bg-teal sadow' rowspan="2" style='max-widtd:3px'>NO</th> 
		<th class='bg-teal sadowbg-teal sadowbg-teal sadow' style='min-width:173px' rowspan="2" valign="midle"  >NAMA</th>
		<th class='bg-teal sadowbg-teal sadowbg-teal sadow' style='min-width:173px' rowspan="2" valign="midle"  >BIRO/SATKER</th>
		
		<th class='bg-teal sadow'   colspan="<?php echo $jml;?>"  align="center" >PERIODE <?php echo $tgl1. " - ". $tgl2?></th>			
		<th class='bg-teal sadowbg-teal sadow' colspan="2"  >UANG LEMBUR</th>  
		<th class='bg-teal sadowbg-teal sadow' colspan="2"  >UANG MAKAN</th>
		<th class='bg-teal sadowbg-teal sadow' colspan="2" style="min-width:220px" >LEMBUR SESUAI KETENTUAN</th>
	</tr>
	
	<tr> 
		<?php
			for($i=0;$i<$jml;$i++){
				echo '<th align="center" class="bg-teal sadow">'.substr($this->tanggal->tambah_tgl($tgl1o,$i),8,2).'</th> ';
			}
		?>  
		<th>Jam</th>
		<th>Uang</th>
		<th>Hari</th>
		<th>Uang</th>
		<th>Jam</th>
		<th>Uang</th>
	</tr>
	</thead>
	</table>
</div>	
							
							
							
	 
	<script type="text/javascript">
	 
   var  dataTable = $('#tabel').DataTable({ 
        scrollY:        "400px",
        scrollX:        true,
        scrollCollapse: true,
		 fixedColumns:   true,
		  fixedColumns:   {
            leftColumns: 2
        },
		"paging": true,
        "processing": false, //Feature control tde processing indicator.
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
						  "lengtdMenu": "Tampil _MENU_ Baris",  
				    },
					 
					 
        "serverSide": true, //Feature control DataTables' server-side processing mode.
		 "responsive": false,
		 "searching": true,
		 "lengtdMenu":
		 [[10 , 30,50,100,200,300,400,500], 
		 [10 , 30,50,100,200,300,400,500]], 
		 dom: 'Blfrtip',
 		buttons: [
	
			{
 				text: ' Excel ',
 				action: function(e, dt, node, config) {
 					excel();
 				},
 				className: '  font14 btn btn-sm btn-light ti-reload  '
 			},
		 
 			{
 				text: ' Refresh ',
 				action: function(e, dt, node, config) {
 					reload_table();
 				},
 				className: '  font14 btn btn-sm btn-light ti-reload  '
 			},
			//   {
 			// 	text: ' Tambah ',
 			// 	action: function(e, dt, node, config) {
 			// 		tambah();
 			// 	},
 			// 	className: '  font14 btn btn-sm ti-plus bg-teal  '
 			// },

 		],
	 
        // Load data for tde table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('absensi/getData');?>",
            "type": "POST",
			"data": function ( data ) {
						   data.jabatan = $('#jabatan').val();
						  data.tgl1 = "<?php echo $tgl1o;?>";
						   data.tgl2 = "<?php echo $tgl2o;?>";
						    data.jml = "<?php echo $jml;?>";
					 		
					 	  data.kode_istana = "<?php echo $kode_istana; ?>";
					 	  data.kode_biro = "<?php echo $kode_biro; ?>";
						  data.periode = "<?php echo $periode ?>";
						  data.jk = "<?php echo $jk ?>";
						  data.absen = "<?php echo $absen ?>";
						  data.bidang = "<?php echo $bidang ?>";
						 
		 },
		 
		   beforeSend: function() {
               loading("area_lod");
            },
			complete: function() {
              unblock('area_lod');
            },
			
        },

        //Set column definition initialisation properties.
        "columnDefs": [
        { 
          "targets": [ 0], //last column
          "orderable": false, //set not orderable
        },
        ],
	
      });
    
  
		
function tinjau(id)
{			var url="<?php echo base_url();?>kesiswaan/tinjau";
			$.post(url,{id:id},function(data){
				   $("#judul_tinjau").html("TINJAU DATA CBT");
				   $("#isi").html(data);
				   $("#modal_tinjau").modal();
			  });
}

 

  						
											
  function hapus(id,judul=null){
		   alertify.confirm("<center>Menghapus akan membersihkan data terkait guru:<br> <span class='font-bold'>`"+judul+"`</span> <br>Yakin Hapus ? </center>",function(){
		   $.post("<?php echo site_url("presensi/hapus_pendidik"); ?>",{id:id},function(){
				notif("Data berhasil dihapus !!");			  
			  reload_table();
		      })
		   })
	  };

  
function reload_table()
{
	 dataTable.ajax.reload(null,false);	
} 

function excel() {
	jabatan = $('#jabatan').val();
	tgl1 = "<?php echo $tgl1o;?>";
	tgl2 = "<?php echo $tgl2o;?>";
	jml = "<?php echo $jml;?>";
	
	kode_istana = "<?php echo $kode_istana; ?>";
	periode = "<?php echo $periode ?>";
	jk = "<?php echo $jk ?>";
	absen = "<?php echo $absen ?>";
	bidang = "<?php echo $bidang ?>";

	window.location.href = "<?php echo site_url();?>absensi/export_excel?jabatan"+jabatan
	+"&tgl1="+tgl1
	+"&tgl2="+tgl2
	+"&jml="+jml
	+"&kode_istana="+kode_istana
	+"&periode="+periode
	+"&jk="+jk
	+"&absen="+absen
	+"&bidang="+bidang;

}
</script>