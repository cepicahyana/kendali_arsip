 


<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
	<div>
		<h4 class="content-title mb-2"><?php echo $reff;?></h4>
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Data referensi</a></li>
				<li class="breadcrumb-item active" aria-current="page"><?php echo $reff;?></li>
			</ol>
		</nav>
	</div>
</div>

<div class="card">
	
	<div class="row card-body" style='padding-top:10px;padding-bottom:20px'>

		<div class="col-md-12" id="area_lod">
			
			<table id='table' width="100%" class="tabel black table-striped table-bordered table-hover dataTable">
				<thead>
					<tr>
					 
						<th class='thead' >ID </th> 
						<th class='thead' >NAMA</th>   
						<th class='thead' >EDIT | HAPUS </th>	  
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
				
				var url   = "<?php echo site_url("referensi/hapus");?>";
				var tbl = "<?=$tbl;?>";
				var param = {<?php echo $this->m_reff->tokenName()?>:token,id:id,tbl:tbl};
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
        
        
        "serverSide": true, //Feature control DataTables' server-side processing mode.
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
        //    {
        //    	text: ' Download Xl ',
        //    	action: function ( e, dt, node, config ) {
        //    		download();
        //    	},className: 'btn   btn-outline-success  '
        //    }, 
		// {
		// 	  text: 'Input ',
        //         action: function ( e, dt, node, config ) {
        //            download();
        //         },className: 'btn   btn-outline-success  '
        //         }, 
        {
        	text: 'Tambah ',
        	action: function ( e, dt, node, config ) {
        		add();
        	},className: 'btn   btn-outline-success  '
        }, 
        
        
        
        ],
        
        // Load data for the table's content from an Ajax source
        "ajax": {
        	"url": "<?php echo site_url('referensi/getData');?>",
        	"type": "POST",
        	"data": function ( data ) {
        		data.<?php echo $this->m_reff->tokenName()?>=token;
        		data.tbl="<?=$tbl;?>";
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
          "targets": [ 0,-1,-2,-3], //last column
          "orderable": false, //set not orderable
        },
        ],
        
      });
      function reload_table()
      {
      	dataTable.ajax.reload(null,false);	
      };
      
    </script>
    
    
    
    
    
    <script>
     function add()
     {
		 var tbl = "<?=$tbl?>";
      var url   = "<?php echo site_url("referensi/viewAdd");?>";
      var param = {<?php echo $this->m_reff->tokenName()?>:token,tbl:tbl};
      $.ajax({
       type: "POST",dataType: "json",data: param, url: url,
       success: function(val){
        $("#mdl_modal").modal();
        $("#editan").html(val['data']);
        token=val['token'];
      }
    });		
    }

    function edit(id)
    {	 
		var tbl = "<?=$tbl?>";
      var url   = "<?php echo site_url("referensi/viewEdit");?>";
      var param = {<?php echo $this->m_reff->tokenName()?>:token,id:id,tbl:tbl};
      $.ajax({
       type: "POST",dataType: "json",data: param, url: url,
       success: function(val){
        $("#mdl_modal").modal();
        $("#editan").html(val['data']);
        token=val['token'];
      }
    });	
    }
    
  </script>




  <div class="modal effect-super-scaled" id="mdl_modal" tabindex="-1" role="dialog">
  	<div class="modal-dialog" id="area_modal_edit" role="document">
  		<div id="editan"></div>
  	</div>
  </form>
</div><!-- /.modal-dialog --> 














