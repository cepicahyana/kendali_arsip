<?php
$dp = $this->db->get_where("admin",array("id_admin"=>$this->session->userdata("id")))->row();
if(!isset($dp)){ echo  "data tidak ditemukan"; return false; }
$level = $this->session->userdata("level");
if($level=="admin"){
    $foto = isset($dp->poto)?($dp->poto):"";
    $nama_pengguna = isset($dp->owner)?($dp->owner):"";
}
?>


					<!-- breadcrumb -->
					<div class="breadcrumb-header justify-content-between">
						<div>
							<h4 class="content-title mb-2 "><i class="fe fe-bar-chart-2"></i> Monitoring Kesehatan Keluarga Pegawai</h4>
							<nav aria-label="breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="#">Progress perkembangan kesehatan keluarga pegawai yang terpapar covid</a></li>
									<!-- <li class="breadcrumb-item active" aria-current="page">Project</li> -->
								</ol>
							</nav>
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
						<th class='thead'  width='15px'>&nbsp;NO</th>
						<th class='thead' width="100px">Nama anggota keluarga</th> 
						<th class='thead' width='100px'>Tgl test trakhir </th> 
						<th class='thead' width="200px">Keluarga pegawai dari</th> 
					
						<th class='thead' width='30px'>Terpapar </th> 
						<th class='thead' width='90px'>Isolasi </th> 
						<th class='thead' width='50px'>Status kondisi </th> 
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
<button class="btn btn-sm bg-danger" ><i class='fa fa-smile' style="font-size:20px;color:yellow"></i></button> Memburuk 
</div>

<div  style="padding-top:5px">
<button class="btn btn-sm bg-dark" ><i class='fa fa-meh' style="font-size:20px;color:white"></i></button> Stagnan 
</div>

<div  style="padding-top:5px">
<button class="btn btn-sm bg-success"  ><i class='fa fa-frown' style="font-size:20px;color:white"></i></button> Membaik
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
           
          
		// {
		// 	  text: 'Input ',
        //         action: function ( e, dt, node, config ) {
        //            download();
        //         },className: 'btn   btn-outline-success  '
        //         }, 
     


        ],
        
        // Load data for the table's content from an Ajax source
        "ajax": {
        	"url": "<?php echo site_url('monkes/getDataKeluarga');?>",
        	"type": "POST",
        	"data": function ( data ) {
        		data.<?php echo $this->m_reff->tokenName()?>=token;
        		
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
        "columnDefs": [
        { 
          "targets": [ 0,-1,-2,-3,-4,-5], //last column
          "orderable": false, //set not orderable
        },
        ],

      });
      function reload_table()
      {
      	dataTable.ajax.reload(null,false);	
      };

	function detail(kode){
					   var url   = "<?php echo site_url("monkes/detailKondisiKeluarga");?>";
					   var param = {kode:kode,<?php echo $this->m_reff->tokenName()?>:token};
					   $("#mdl_modal").modal();
					   $.ajax({
							   type: "POST",dataType: "JSON",data: param, url: url,
							   success: function(val){
								   token=val['token'];
								   $("#isi").html(val["data"]);
								
						
							   }
					   });	
	}

	function ajukanTes(id,kode,nama){
					   var url   = "<?php echo site_url("monkes/ajukanUlangKeluarga");?>";
					   var param = {nama:nama,id:id,kode:kode,<?php echo $this->m_reff->tokenName()?>:token};
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
                                            
                                            var url   = "<?php echo site_url("monkes/setSembuhByKodeKel");?>";
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
                                            
                                            var url   = "<?php echo site_url("monkes/setMeninggalByKodeKel");?>";
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