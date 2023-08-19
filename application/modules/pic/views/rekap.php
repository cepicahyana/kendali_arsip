<?php
$dp = $this->db->get_where("admin",array("id_admin"=>$this->session->userdata("id")))->row();
if(!isset($dp)){ echo  "data ditemukan"; return false; }

$level = $this->session->userdata("level");
if($level=="admin"){
    $foto = isset($dp->poto)?($dp->poto):"";
    $nama_pengguna = isset($dp->owner)?($dp->owner):"";
}
?>


					<!-- breadcrumb -->
					<div class="breadcrumb-header justify-content-between">
						<div>
							<h4 class="content-title mb-2 "><i class="fe fe-book"></i> Rekapitulasi hasil test</h4>
							<nav aria-label="breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="#">Data telah melakukan tes</a></li>
									<!-- <li class="breadcrumb-item active" aria-current="page">Project</li> -->
								</ol>
							</nav>
						</div>
</div>


 				<div class="row" style="margin-top:-10px;padding-bottom:10px">
						
						<div class="col-md-3">
                        <input type="readonly" 
                        value="<?= $this->tanggal->minTgl2(7,date('Y-m-d'))." - ".date('d/m/Y')?>";
                        id="range" 
                        class="form-control" 
                        onchange="reload_table()">
						</div>

                    <?php
                    if($this->session->userdata("kode_istana")){
                            if($this->session->userdata("kode_istana")==$this->m_reff->pengaturan(2) and $this->session->userdata("kode_biro")){?>
                               <input type="hidden" id="kode_istana" value="<?=$this->session->userdata("kode_istana");?>">
                               <input type="hidden" id="kode_biro" value="<?=$this->session->userdata("kode_biro");?>">
                                <?php 
                            }elseif($this->session->userdata("kode_istana")==$this->m_reff->pengaturan(2)){?>
                                <div class="col-md-3">
                                <select id="kode_biro" class="form-control text-black" style="color:black" onchange="reload_table()">
                                <option  value=""> === Filter Biro ===</option>
                                <?php
                                $dt = $this->db->get("tr_biro")->result();
                                foreach($dt as $val){
                                echo '<option  value="'.$val->kode.'">'.$val->biro.'</option>';
                                }
                                ?> 
                                </select>
                                </div>
                            <?php 
                            }else{
                                echo "<input id='kode_istana' type='hidden' value='".$this->session->userdata("kode_istana")."'> ";
                            }
                 }else{?>
                  <div class="col-md-3">
							<select id="kode_istana" class="form-control text-black" style="color:black" onchange="reload_table()">
							<option  value=""> === Filter Istana ===</option>
                                    <?php
                                $dt = $this->db->get("tr_istana")->result();
                                foreach($dt as $val){
                                echo '<option  value="'.$val->kode.'">'.$val->istana.'</option>';
                                }
                                ?> 
                                </select>
                    </div> 
                 <?php }?>
                       


                        <div class="col-md-3">
							<select id="kode_jenis" class="form-control text-black" style="color:black" onchange="reload_table()">
							<option  value=""> === Filter Jenis Tes ===</option>
							<?php
							$dt = $this->db->get("tr_jenis_test")->result();
							foreach($dt as $val){
							echo '<option  value="'.$val->kode.'">'.$val->nama.'</option>';
							}
							?> 
							</select>
						</div>
 
						<div class="col-md-3">
							<select id="kode_tempat" class="form-control text-black" style="color:black" onchange="reload_table()">
							<option  value=""> === Filter Rumah Sakit ===</option>
							<?php
							$dt = $this->db->get("tm_rs")->result();
							foreach($dt as $val){
							echo '<option  value="'.$val->kode.'">'.$val->nama.'</option>';
							}
							?> 
							</select>
						</div>
 
             </div>	 
					 
					<!-- /breadcrumb -->


				
<!-- breadcrumb -->
 
<div class="card">
<div class="card-body">

    <div id="goRs"></div>
    
</div>
	<div class="row card-body" style='padding-top:10px;padding-bottom:20px'>

		<div class="col-md-12" id="area_lod">

			<table id='table' width="100%" class="tabel black table-striped table-bordered table-hover dataTable">
				<thead>
					<tr>
					 
						<th class='thead'  width='15px'>&nbsp;No</th>
						<th class='thead'  >Nama </th> 
						<th class='thead'  >Satuan Kerja </th> 
						<th class='thead'  >Jenis Test</th> 
						<th class='thead' >Tgl Test </th> 
						<th class='thead'  >Hasil Test </th> 
						<th class='thead' >Tempat Test</th>  
						<th class='thead' width="80px">Keperluan</th>  
						    
					</tr>	 
				</thead>
			</table>
		</div>
	</div>

</div>	

 
<!-- #END# Task Info -->


<script type="text/javascript">
	function hapus(id,akun){

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

				var url   = "<?php echo site_url("data_master/hapus_rs");?>";
        var param = {<?php echo $this->m_reff->tokenName()?>:token,id:id};
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

        "serverSide": true,
        "responsive": true,
        "searching": true,
        "lengthMenu":
        [[10 ,20,30,50], 
        [10 ,20,30,50], ], 
        dom: 'Blfrtip',
        buttons: [
           // 'copy', 'csv', 'excel', 'pdf', 'print'
           {
           	text: ' Refresh  ',
           	action: function ( e, dt, node, config ) {
           		reload_table();
           	},className: 'btn  btn-secondary  '
           },
           
          
		{
			  text: 'Export excell ',
                action: function ( e, dt, node, config ) {
                   downloadExcell();
                },className: 'btn   btn-primary  '
                }, 
     


        ],
        
        // Load data for the table's content from an Ajax source
        "ajax": {
        	"url": "<?php echo site_url('pic/getDataRekap');?>",
        	"type": "POST",
        	"data": function ( data ) {
        		data.<?php echo $this->m_reff->tokenName()?>=token;
        		// data.jenis_pegawai=$("#jenis_pegawai").val();
        		data.kode_tempat=$("#kode_tempat").val();
        		data.kode_jenis=$("#kode_jenis").val();
        		data.kode_test=$("#kode_test").val();
        		data.kode_istana=$("#kode_istana").val();
        		data.kode_biro=$("#kode_biro").val();
        		data.range=$("#range").val();
        	},
        	beforeSend: function() {
        		loading("area_lod");
        	},
        	complete: function(data) {
        		token=data.responseJSON.token;
        		unblock('area_lod');
				// $("#md_checkbox").prop("checked", false);
			//    document.getElementById("pilihsemua").checked = false;
			//    $(".pilihsemua").val("ya");
               goRs();
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

	function detail(kode){
					   var url   = "<?php echo site_url("monkes/detailKondisi");?>";
					   var param = {kode:kode,<?php echo $this->m_reff->tokenName()?>:token};
					   $("#mdl_modal").modal();
					   $.ajax({
							   type: "POST",dataType: "json",data: param, url: url,
							   success: function(val){
								   token=val['token'];
								   $("#isi").html(val["data"]);
								
						
							   }
					   });	
	}
    
	function ajukanTes(id,kode){
					   var url   = "<?php echo site_url("monkes/ajukanUlang");?>";
					   var param = {id:id,kode:kode,<?php echo $this->m_reff->tokenName()?>:token};
					   $("#mdl_modal").modal();
					   $.ajax({
							   type: "POST",dataType: "json",data: param, url: url,
							   success: function(val){
								   token=val['token'];
								   $("#isi").html(val["data"]);
								
						
							   }
					   });	
	}
    </script>

<!-- <div class="modal effect-newspaper" id="mdl_modal" style="z-index:1500" role="dialog">
                <div class="modal-dialog modal-lg" id="area_modal" role="document">
				 <div id="isi"></div>
				</div>
				
   </div> -->

   <div class="modal effect-flip-vertical" id="mdl_modal" style="z-index:1500" role="dialog">
		<div class="modal-dialog modal-lg" id="area_modal" role="document">

			<div class="modal-content">
			 
			<div id="isi"></div>
			</div>
		</div>
	</div><!-- /.modal-dialog -->



    <script>
	$('#range').daterangepicker({
		"showDropdowns": true,
		"autoApply": true,
		ranges: {
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

	
    <script type="text/javascript">
 
 

function downloadExcell(){
    var kode_istana = $("#kode_istana").val();
    var kode_jenis = $("#kode_jenis").val();
    var kode_tempat = $("#kode_tempat").val();
    var kode_biro = $("#kode_biro").val();
    var range = $("#range").val();
    window.location.href="<?php echo base_url()?>pic/downloadExcell?range="+range+"&kode_istana="+kode_istana+"&kode_jenis="+kode_jenis+"&kode_tempat="+kode_tempat+"&kode_biro="+kode_biro;
}




function goRs() {
		var range = $("#range").val();
		var kode_istana = $("#kode_istana").val();
		var kode_biro = $("#kode_biro").val();
		var kode_tempat = $("#kode_tempat").val();
		var kode_jenis = $("#kode_jenis").val();
		var url = "<?php echo site_url("pic/goRs"); ?>";
		var param = {
			range: range,
            kode_istana : kode_istana,
            kode_biro : kode_biro,
            kode_tempat : kode_tempat,
            kode_jenis : kode_jenis,
			<?php echo $this->m_reff->tokenName() ?>: token
		};
		$.ajax({
			type: "POST",
			dataType: "json",
			data: param,
			url: url,
			success: function(val) {
				token = val['token'];
				$("#goRs").html(val['data']);
			}
		});
	}

</script>
