    <div class="card">         
        <div class="row card-body" style='padding-top:10px;padding-bottom:20px'>
			<div class="row">	
				<div class="col-md-3">
					<label class="form-label mg-b-0 text-black">Peraturan </label>
					<?php 
					$valray=array();
					$valray[""]="=== Pilih ===";
					$this->db->where('status',1);
					$db = $this->db->get('ars_tr_peraturan')->result();
					foreach($db as $v)
					{
						$valray[$v->id]=$v->nama;
					}
					echo form_dropdown("",$valray,'','id="f1" class="form-control pb-2 text-black" style="width:100%" onchange="reload_filter()"');
					?>
				</div>
				<div class="col-md-3">
					<label class="form-label mg-b-0 text-black">Level </label>
					<?php 
					$valray=array();
					$valray[""]="=== Pilih ===";
					$valray["1"]="1";
					$valray["2"]="2";
					$valray["3"]="3";
					echo form_dropdown("",$valray,'','id="f2" class="form-control pb-2 text-black" style="width:100%" onchange="reload_filter()"');
					?>
				</div>
			
			
			</div>
			
			<div class="row mt-3">
				<div class="col-md-12" id="area_lod">
					<table id='table' width="100%" class="tabel black table-striped table-bordered table-hover dataTable">
						<thead>
							<tr>
								<th class='thead'  width='15px'>NO</th>
								<th class='thead' >PERATURAN </th>
								<th class='thead' >KODE </th> 
								<th class='thead' >PARENT</th>   
								<th class='thead' >NAMA </th>   
								<th class='thead' >DESKRIPSI </th>  
								<th class='thead' >STATUS </th>  
								<th class='thead' width='140px' ># </th>	  
							</tr>	 
						</thead>
					</table>
				</div>
        	</div>
        </div>
</div>	
						

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

				var url   = "<?php echo site_url("ars_master/hapus_klasifikasi_arsip");?>";
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
        "processing": false, 
        "ordering":false,
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
        "lengthMenu":
        [[10 ,20,30,50], 
        [10 ,20,30,50], ], 
        dom: 'Blfrtip',
        buttons: [
           {
           	text: '<i class="fe fe-refresh-cw"></i>    ',
           	action: function ( e, dt, node, config ) {
           		reload_table();
           	},className: 'btn  btn-secondary-light'
           },
           {
				text: '<i class="fe fe-download"></i>',
				action: function ( e, dt, node, config ) {
					downloadXL();
				},className: 'btn  btn-secondary-light'
			},
			{
				text: '<i class="fe fe-plus"></i> Tambah ',
				action: function ( e, dt, node, config ) {
					action_form();
				},className: 'btn  btn-secondary-light'
			}, 
        ],
        
        "ajax": {
        	"url": "<?php echo site_url('ars_master/getData_KlasifikasiArsip');?>",
        	"type": "POST",
        	"data": function ( data ) {
        		data.<?php echo $this->m_reff->tokenName()?>=token;
				data.f1=$('#f1').val();
				data.f2=$('#f2').val();
				//data.f3=$('#f3').val();
				// data.f4=$('#f4').val();
        	},
        	beforeSend: function() {
        		loading("area_lod");
        	},
        	complete: function(data) {
        		token=data.responseJSON.token;
        		unblock('area_lod');
        	},

        },
        "columnDefs": [
        { 
          "targets": [  ], //last column
          "orderable": false, //set not orderable
        },
        ],
      });
      function reload_table()
      {
      	dataTable.ajax.reload(null,false);	
      };
	  function reload_filter()
      {
      	dataTable.ajax.reload(null,true);	
      };

    

       

      function action_form(id=null)
      {	 
        $("#mdl_modal").modal("show");
        $("#response").html(cantik());
        if(id){
          $(".modal-title").html("Update data");
        }else{
          $(".modal-title").html("Tambah data");
        }
        var url   = "<?php echo site_url("ars_master/form_klasifikasi_arsip");?>";
        var param = {<?php echo $this->m_reff->tokenName()?>:token,id:id};
        $.ajax({
         type: "POST",dataType: "json",data: param, url: url,
         success: function(val){
          $("#response").html(val['data']);
          token=val['token'];
        }
      }); 
      }

	//   $(function() {
	// 	$('#f3').select2();
	// });

	//   function filter_kode(level){
	// 	var peraturan_id = $("#f1").val();
	// 	var url   = "<.?php echo site_url("ars_master/filter_kode_klasifikasi");?>";
    //     var param = {<.?php echo $this->m_reff->tokenName()?>:token,level:level,peraturan_id:peraturan_id};
    //     $.ajax({
	// 		type: "POST",dataType: "json",data: param, url: url,
	// 		success: function(val){
	// 			$("#f3").html(val['data']);
	// 			reload_filter();
	// 			token=val['token'];
	// 		}
	// 	}); 
	//   }

	function downloadXL()
		{	
			var f1 = $('#f1').val();
			var f2 = $('#f2').val();
			var s = $('.whatever').val();		
			window.open(
			"<?php echo base_url()?>ars_master/downloadXL_klasifikasi_arsip/?s="+s+"&f1="+f1+"&f2="+f2,
			'_blank' // <- This is what makes it open in a new window.
			);
		}
    </script>



 

  <div class="modal effect-scale" id="mdl_modal"   role="dialog" style="z-index:5000">
			<div class="modal-dialog modal-xl modal-dialog-centered" role="document">
				<div class="modal-content modal-content-demo" id="area_modal">
					<div class="modal-header">
						<h6 class="modal-title"> </h6><button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
					</div>
				<div id="response"></div>
				</div>
			</div>
		</div>