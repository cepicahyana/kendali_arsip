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
							<h4 class="content-title mb-2 "><i class="fe fe-bar-chart-2"></i> Monitoring Kesehatan Pegawai</h4>
							<nav aria-label="breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="#">Progress perkembangan kesehatan pegawai yang terpapar covid</a></li>
									<!-- <li class="breadcrumb-item active" aria-current="page">Project</li> -->
								</ol>
							</nav>
						</div>
	<?php
	if($this->session->level!="pic_covid"){?>					
						<div class="col-md-3">
							<select id="kode_istana" class="form-control text-black" style="color:black" onchange="reload_table()">
							<option  value=""> === semua istana ===</option>
							<?php
							$dt = $this->m_reff->list_istana()->result();
							foreach($dt as $val){
							echo '<option  value="'.$val->kode.'">'.$val->istana.'</option>';
							}
							?> 
							</select>
						</div>
	<?php } ?>
						<div class="col-md-3">
	<select id="jenis_pegawai" class="form-control text-black" style="color:black" onchange="reload_table()">
	<option  value=""> --- Filter  --- </option>
	<option  value="1">Pegawai / PNS </option>
	<option  value="2">PPNPN </option>
	<option  value="3">Petugas taman </option>
	<option  value="4">Cleaning service </option>
	</select>
 
	<!-- <select id="isolasi" class="form-control text-black mt-2" style="color:black" onchange="reload_table()">
	<option  value="">=== Filter isolasi ===</option>
	<?php
	$iso = $this->db->get("tr_isolasi")->result();
	foreach($iso as $val){
		echo '<option  value="'.$val->kode.'">'.$val->nama.'</option>';
	}
	?>
	 
	</select> -->
</div>
					</div>
					<!-- /breadcrumb -->


				
<!-- breadcrumb -->
 
<div class="card">

	<div class="row card-body" style='padding-top:10px;padding-bottom:20px'>

		<div class="col-md-12" id="area_lod">

			<table id='table' width="100%" class="tabel black table-striped table-bordered table-hover dataTable">
				<thead>
					<tr>
					<th class='thead ' style='max-width:15px' >
					<div class="d-inline-block" style="margin-left:-23px">
												<label for="pilihsemua" class="custom-control custom-checkbox  justify-content-center">
												<input type="checkbox" id="pilihsemua"  class="pilihsemua  custom-control-input"   value="ya">
													<span class="custom-control-label"> </span>
												</label>
											</div>
 					 </th>	
						<th class='thead'  width='15px'>&nbsp;NO</th>
						<th class='thead' width="250px">Nama </th> 
					
						<th class='thead' width='100px'>Tgl Test trakhir </th> 
						<th class='thead' width='30px'>Lama <br>Terpapar </th> 
						<th class='thead' width='90px'>Isolasi </th> 
						<th class='thead' width='50px'>Status Kondisi </th> 
						<th class='thead' >Progress</th>  
						<th class='thead' width="80px">Detail</th>  
						    
					</tr>	 
				</thead>
			</table>
		</div>
	</div>

</div>	

<div class="alert alert-light">
<div style="padding-top:5px">
<button class="btn btn-sm bg-success" ><i class='fa fa-smile' style="font-size:20px;color:yellow"></i></button> Membaik 
</div>

<div  style="padding-top:5px">
<button class="btn btn-sm bg-dark" ><i class='fa fa-meh' style="font-size:20px;color:white"></i></button> Stagnan 
</div>

<div  style="padding-top:5px">
<button class="btn btn-sm bg-danger"  ><i class='fa fa-frown' style="font-size:20px;color:white"></i></button> Memburuk
<div>
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
			  text: 'Broadcast ',
                action: function ( e, dt, node, config ) {
                   broadcast();
                },className: 'btn   btn-primary  '
                }, 
     


        ],
        
        // Load data for the table's content from an Ajax source
        "ajax": {
        	"url": "<?php echo site_url('monkes/getData');?>",
        	"type": "POST",
        	"data": function ( data ) {
        		data.<?php echo $this->m_reff->tokenName()?>=token;
        		data.jenis_pegawai=$("#jenis_pegawai").val();
        		data.kode_istana=$("#kode_istana").val();
        		// data.isolasi=$("#isolasi").val();
        	},
        	beforeSend: function() {
        		loading("area_lod");
        	},
        	complete: function(data) {
        		token=data.responseJSON.token;
        		unblock('area_lod');
				$("#md_checkbox").prop("checked", false);
			   document.getElementById("pilihsemua").checked = false;
			   $(".pilihsemua").val("ya");
        	},

        },

        //Set column definition initialisation properties.
        "columnDefs": [
        { 
          "targets": [ 0,-1,-2,-3,-4,-5,-6,-7,-8,-9], //last column
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




	
    <script type="text/javascript">
	$(".btnhapus").hide();
  	$(".pilihsemua").click(function(){
	
		if($(".pilihsemua").val()=="ya") {
		$(".pilih").prop("checked", "checked");
		$(".pilihsemua").val("no");
		  $(".btnhapus").show();
		} else {
		$(".pilih").prop("checked", false);
		$(".pilihsemua").val("ya");
		  $(".btnhapus").hide();
		}
	
	});
	
	function pilcek(){
		$(".btnhapus").show();
		$(".pilihsemua").val("ya");
		$(".pilihsemua").prop("checked", false);
	};

	function ceklis()
			{	
				 var i=0;
				 $("[name='pilih[]']").each(function () {
					var ischecked = $(this).is(":checked");
					if (ischecked) { 
						i++;
					};  
				}); 
				if(i==0)
					{
						return "false";
					}else{
						return "true";
					}
			}
		 
	function broadcast(){
				// var h = ceklis();  
				// if(h!="true")
				// {
				// 	notif("<b class='text-white sadow'>Silahkan pilih data terlebih dahulu</b>");
				// 	return false;
				// } 
				
			 var checkbox_value = ""; var i=0;
				$("[name='pilih[]']").each(function () {
					var ischecked = $(this).is(":checked");
					if (ischecked) {
						checkbox_value += $(this).val() + ",";
						i++;
					}
				});

		var url   = "<?php echo site_url("broadcast/kirimBroadcast");?>";
					   var param = {data:checkbox_value,<?php echo $this->m_reff->tokenName()?>:token};
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



<script>
        function setSembuh(kode){
                                    swal({
                                        title: 'jadikan status menjadi sembuh ?',
                                        text: '',
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
                                            swal("data telah dihapus", {
                                                icon: "success",
                                                buttons : {
                                                    confirm : {
                                                        className: 'btn btn-success'
                                                    }
                                                }
                                            });
                                            
                                            var url   = "<?php echo site_url("monkes/setSembuhByKode");?>";
                                            var param = {<?php echo $this->m_reff->tokenName()?>:token,kode:kode};
                                            $.ajax({
                                            type: "POST",dataType: "json",data: param, url: url,
                                            success: function(val){
                                                token=val['token'];
												$("#mdl_modal").modal("hide");
                                                reload_table();
                                            }
                                            });

                                        }
                                        });
}





function setMeninggal(kode){
                                    swal({
                                        title: 'Telah meninggal ?',
                                        text: '',
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
                                            swal("data telah dihapus", {
                                                icon: "success",
                                                buttons : {
                                                    confirm : {
                                                        className: 'btn btn-success'
                                                    }
                                                }
                                            });
                                            
                                            var url   = "<?php echo site_url("monkes/setMeninggalByKode");?>";
                                            var param = {<?php echo $this->m_reff->tokenName()?>:token,kode:kode};
                                            $.ajax({
                                            type: "POST",dataType: "json",data: param, url: url,
                                            success: function(val){
                                                token=val['token'];
												$("#mdl_modal").modal("hide");
                                                reload_table();
                                            }
                                            });

                                        }
                                        });
}
                            </script>